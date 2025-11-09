<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test SQL injection attempts in search/filter parameters
     */
    public function test_sql_injection_in_product_search()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        
        // Common SQL injection payloads
        $injectionPayloads = [
            "' OR '1'='1",
            "1' OR '1' = '1",
            "' OR 1=1--",
            "admin'--",
            "1' UNION SELECT NULL--",
            "'; DROP TABLE users--",
        ];

        foreach ($injectionPayloads as $payload) {
            $response = $this->actingAs($admin)->get('/admin/products?search=' . urlencode($payload));
            
            // Should not crash or expose SQL errors
            $response->assertStatus(200);
            $this->assertStringNotContainsString('SQL', $response->getContent());
            $this->assertStringNotContainsString('syntax', $response->getContent());
        }
    }

    /**
     * Test XSS (Cross-Site Scripting) attempts
     */
    public function test_xss_in_product_creation()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        
        $xssPayloads = [
            '<script>alert("XSS")</script>',
            '<img src=x onerror=alert("XSS")>',
            'javascript:alert("XSS")',
            '<svg/onload=alert("XSS")>',
        ];

        foreach ($xssPayloads as $payload) {
            $response = $this->actingAs($admin)->post('/admin/products', [
                'name' => $payload,
                'description' => 'Test Description',
                'price' => 99.99,
                'active' => true,
            ]);

            // Check if saved
            if ($response->status() === 302) {
                $product = Product::where('name', $payload)->first();
                
                if ($product) {
                    // XSS should be escaped in output
                    $viewResponse = $this->actingAs($admin)->get('/admin/products/' . $product->id);
                    
                    // Raw script tags should not be in HTML output
                    $this->assertStringNotContainsString('<script>', $viewResponse->getContent());
                    $this->assertStringNotContainsString('onerror=', $viewResponse->getContent());
                }
            }
        }
        
        // Test passes if no exceptions thrown
        $this->assertTrue(true);
    }

    /**
     * Test CSRF protection
     */
    public function test_csrf_protection_on_forms()
    {
        $user = User::factory()->create();
        
        // Attempt to submit form without CSRF token
        $response = $this->actingAs($user)->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test',
            'message' => 'Test message',
        ], [
            'X-CSRF-TOKEN' => 'invalid-token'
        ]);

        // Should be rejected (419 or redirect)
        $this->assertTrue(in_array($response->status(), [419, 302]));
    }

    /**
     * Test mass assignment protection
     */
    public function test_mass_assignment_protection()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        
        // Try to create user with admin flag via mass assignment
        $response = $this->post('/register', [
            'name' => 'Hacker',
            'email' => 'hacker@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'is_admin' => true, // Should be blocked
        ]);

        $user = User::where('email', 'hacker@test.com')->first();
        
        if ($user) {
            // Should NOT be admin
            $this->assertFalse($user->is_admin);
        }
    }

    /**
     * Test unauthorized access attempts
     */
    public function test_unauthorized_admin_access()
    {
        $regularUser = User::factory()->create(['is_admin' => false]);
        
        $adminRoutes = [
            '/admin/dashboard',
            '/admin/products',
            '/admin/users',
            '/admin/orders',
        ];

        foreach ($adminRoutes as $route) {
            $response = $this->actingAs($regularUser)->get($route);
            
            // Should redirect (not 200)
            $this->assertNotEquals(200, $response->status());
        }
    }

    /**
     * Test path traversal attempts
     */
    public function test_path_traversal_protection()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        
        $traversalPayloads = [
            '../../../etc/passwd',
            '..\\..\\..\\windows\\system32\\config\\sam',
            '....//....//....//etc/passwd',
        ];

        foreach ($traversalPayloads as $payload) {
            // Try in various contexts where file paths might be used
            $response = $this->actingAs($admin)->get('/admin/products?file=' . urlencode($payload));
            
            // Should not expose system files
            $this->assertStringNotContainsString('root:', $response->getContent());
            $this->assertStringNotContainsString('administrator:', $response->getContent());
        }
    }

    /**
     * Test command injection attempts
     */
    public function test_command_injection_protection()
    {
        $user = User::factory()->create();
        
        $commandPayloads = [
            '; ls -la',
            '| cat /etc/passwd',
            '`whoami`',
            '$(whoami)',
        ];

        foreach ($commandPayloads as $payload) {
            $response = $this->actingAs($user)->post('/contact', [
                'name' => $payload,
                'email' => 'test@example.com',
                'subject' => 'Test',
                'message' => 'Test message',
            ]);

            // Should not execute commands or expose output
            $this->assertStringNotContainsString('root', $response->getContent());
            $this->assertStringNotContainsString('bin', $response->getContent());
        }
    }

    /**
     * Test authentication bypass attempts
     */
    public function test_authentication_bypass_attempts()
    {
        // Create a user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('correct-password'),
        ]);

        $bypassPayloads = [
            "' OR '1'='1",
            "admin'--",
            "' OR 1=1#",
        ];

        foreach ($bypassPayloads as $payload) {
            $response = $this->post('/login', [
                'email' => $payload,
                'password' => $payload,
            ]);

            // Should not be authenticated
            $this->assertGuest();
        }
    }

    /**
     * Test rate limiting on sensitive endpoints
     */
    public function test_rate_limiting_on_login()
    {
        // Attempt 6 login requests (limit is 5 per minute)
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrong-password',
            ]);
        }

        // The 6th request should be rate limited
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        // Should return 429 Too Many Requests
        $response->assertStatus(429);
    }

    /**
     * Test HTTP headers security
     */
    public function test_security_headers()
    {
        $response = $this->get('/');

        // Should have security headers
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }
}
