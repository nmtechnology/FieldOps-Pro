<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\ProductContent;
use App\Models\ContentBlock;

class CreateCCTVTutorial extends Command
{
    protected $signature = 'tutorial:cctv';
    protected $description = 'Create CCTV Camera Troubleshooting Tutorial';

    public function handle()
    {
        $this->info('Creating CCTV Camera Troubleshooting Tutorial...');

        // Find or create the product
        $product = Product::find(8);
        if (!$product) {
            $product = Product::create([
                'name' => 'CCTV Camera Troubleshooting Guide',
                'description' => 'Comprehensive guide to troubleshooting both PoE digital and analog CCTV cameras. Learn common issues, diagnostics, and resolution steps with visual diagrams and real-world scenarios.',
                'short_description' => 'Master CCTV camera troubleshooting for PoE digital and analog systems',
                'type' => 'info',
                'price' => 99.99,
                'active' => true,
                'image_path' => '/img/cctv-tutorial.jpg'
            ]);
        }

        // Delete existing tutorial if it exists
        ProductContent::where('slug', 'cctv-camera-troubleshooting')->delete();

        // Create the tutorial content
        $content = ProductContent::create([
            'product_id' => $product->id,
            'title' => 'CCTV Camera Troubleshooting',
            'slug' => 'cctv-camera-troubleshooting',
            'description' => 'Interactive tutorial covering both PoE and analog camera troubleshooting with visual diagrams',
            'content' => 'Complete CCTV troubleshooting guide with 30+ interactive slides',
            'section_type' => 'tutorial',
            'section_order' => 1,
            'is_premium' => true,
            'is_published' => true,
            'duration_minutes' => 60
        ]);

        $this->info("Tutorial content created with ID: {$content->id}");

        // Create content blocks for the tutorial
        $blocks = [
            // Introduction (Slides 1-3)
            [
                'block_type' => 'heading',
                'content' => 'Welcome to CCTV Camera Troubleshooting',
                'block_order' => 1
            ],
            [
                'block_type' => 'text',
                'content' => 'This comprehensive tutorial will teach you how to diagnose and resolve common issues with both PoE digital cameras and analog CCTV systems. You\'ll learn systematic troubleshooting approaches used by professional technicians.',
                'block_order' => 2
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>What You\'ll Learn:</h3>
<ul>
<li>Understanding PoE (Power over Ethernet) systems</li>
<li>Analog camera fundamentals</li>
<li>Common failure points and diagnostics</li>
<li>Power and connectivity issues</li>
<li>Video signal problems</li>
<li>Network configuration troubleshooting</li>
<li>Testing equipment and tools</li>
</ul>',
                'block_order' => 3
            ],

            // Section 1: Understanding CCTV Systems (Slides 4-8)
            [
                'block_type' => 'heading',
                'content' => 'Section 1: CCTV System Architecture',
                'block_order' => 4
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>PoE Digital Camera System Overview</h3>
<p>Power over Ethernet (PoE) cameras combine power and data transmission over a single Ethernet cable. This system includes:</p>
<ul>
<li><strong>IP Camera:</strong> Network-connected camera with built-in processor</li>
<li><strong>PoE Switch/Injector:</strong> Provides both data and power (typically 15.4W to 30W)</li>
<li><strong>NVR (Network Video Recorder):</strong> Stores and manages video footage</li>
<li><strong>Network Infrastructure:</strong> CAT5e/CAT6 cables, routers, switches</li>
</ul>',
                'block_order' => 5
            ],
            [
                'block_type' => 'image',
                'content' => 'PoE System Architecture Diagram',
                'media_url' => 'https://via.placeholder.com/800x600/1e3a8a/ffffff?text=PoE+Camera+System+Architecture',
                'block_order' => 6
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Analog Camera System Overview</h3>
<p>Traditional analog systems use coaxial cables for video transmission:</p>
<ul>
<li><strong>Analog Camera:</strong> Captures video in analog format (CVBS, AHD, TVI, CVI)</li>
<li><strong>DVR (Digital Video Recorder):</strong> Converts analog to digital and stores footage</li>
<li><strong>Power Supply:</strong> Separate 12V DC power for cameras</li>
<li><strong>Cabling:</strong> RG59 or RG6 coaxial cable for video, separate power cables</li>
</ul>',
                'block_order' => 7
            ],
            [
                'block_type' => 'image',
                'content' => 'Analog System Architecture Diagram',
                'media_url' => 'https://via.placeholder.com/800x600/166534/ffffff?text=Analog+Camera+System+Architecture',
                'block_order' => 8
            ],

            // Section 2: Essential Tools (Slides 9-11)
            [
                'block_type' => 'heading',
                'content' => 'Section 2: Technician\'s Toolkit',
                'block_order' => 9
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Required Testing Equipment</h3>
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
<div>
<h4>For PoE/Digital Systems:</h4>
<ul>
<li>PoE tester/validator</li>
<li>Network cable tester</li>
<li>Multimeter (voltage testing)</li>
<li>Laptop with network tools (ping, SADP, IP scanner)</li>
<li>Ethernet crimping tool</li>
<li>Cable certifier (optional)</li>
</ul>
</div>
<div>
<h4>For Analog Systems:</h4>
<ul>
<li>Multimeter (12V DC testing)</li>
<li>Portable test monitor</li>
<li>Coax cable tester</li>
<li>BNC compression tool</li>
<li>Video balun tester (if used)</li>
</ul>
</div>
</div>',
                'block_order' => 10
            ],
            [
                'block_type' => 'image',
                'content' => 'Common CCTV Testing Tools',
                'media_url' => 'https://via.placeholder.com/800x600/7c2d12/ffffff?text=CCTV+Testing+Tools',
                'block_order' => 11
            ],

            // Section 3: PoE Troubleshooting (Slides 12-20)
            [
                'block_type' => 'heading',
                'content' => 'Section 3: PoE Camera Troubleshooting',
                'block_order' => 12
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>PoE Troubleshooting Flowchart</h3>
<p>Follow this systematic approach when a PoE camera is not working:</p>
<ol>
<li><strong>Check Physical Connections</strong> - Verify all cables are properly seated</li>
<li><strong>Test Power Delivery</strong> - Confirm PoE voltage at camera end</li>
<li><strong>Verify Network Connectivity</strong> - Check link lights and ping camera</li>
<li><strong>Check IP Configuration</strong> - Ensure no IP conflicts</li>
<li><strong>Test Camera Functionality</strong> - Try direct connection to laptop</li>
</ol>',
                'block_order' => 13
            ],
            [
                'block_type' => 'image',
                'content' => 'PoE Troubleshooting Decision Tree',
                'media_url' => 'https://via.placeholder.com/800x600/1e40af/ffffff?text=PoE+Troubleshooting+Flowchart',
                'block_order' => 14
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Issue #1: Camera Has No Power</h3>
<p><strong>Symptoms:</strong> No lights on camera, no link light on switch</p>
<p><strong>Diagnostic Steps:</strong></p>
<ol>
<li>Check if PoE switch/injector is powered on</li>
<li>Verify port is PoE-enabled (check switch documentation)</li>
<li>Test PoE output with multimeter (should read 48-54V DC)</li>
<li>Try different port on PoE switch</li>
<li>Test with known-good cable</li>
<li>Check cable length (PoE limit: 100 meters/328 feet)</li>
</ol>
<p><strong>Common Causes:</strong></p>
<ul>
<li>PoE budget exceeded on switch</li>
<li>Damaged cable or connectors</li>
<li>Non-PoE port selected</li>
<li>Faulty PoE injector</li>
</ul>',
                'block_order' => 15
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>PoE Power Budget Calculation</h3>
<p>Each PoE switch has a maximum power budget. Calculate total consumption:</p>
<table style="width:100%; border-collapse: collapse; border: 1px solid #ddd;">
<tr style="background-color: #f2f2f2;">
<th style="border: 1px solid #ddd; padding: 8px;">PoE Standard</th>
<th style="border: 1px solid #ddd; padding: 8px;">Power Per Port</th>
<th style="border: 1px solid #ddd; padding: 8px;">Typical Use</th>
</tr>
<tr>
<td style="border: 1px solid #ddd; padding: 8px;">PoE (802.3af)</td>
<td style="border: 1px solid #ddd; padding: 8px;">15.4W</td>
<td style="border: 1px solid #ddd; padding: 8px;">Basic IP cameras</td>
</tr>
<tr>
<td style="border: 1px solid #ddd; padding: 8px;">PoE+ (802.3at)</td>
<td style="border: 1px solid #ddd; padding: 8px;">30W</td>
<td style="border: 1px solid #ddd; padding: 8px;">PTZ cameras, heaters</td>
</tr>
<tr>
<td style="border: 1px solid #ddd; padding: 8px;">PoE++ (802.3bt)</td>
<td style="border: 1px solid #ddd; padding: 8px;">60W/100W</td>
<td style="border: 1px solid #ddd; padding: 8px;">High-power PTZ, multi-sensor</td>
</tr>
</table>
<p><em>Example: A 16-port PoE switch with 120W budget can power 8 cameras at 15W each.</em></p>',
                'block_order' => 16
            ],
            [
                'block_type' => 'image',
                'content' => 'PoE Power Budget Graph',
                'media_url' => 'https://via.placeholder.com/800x600/0f766e/ffffff?text=PoE+Power+Budget+Chart',
                'block_order' => 17
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Issue #2: Camera Powers On But No Video</h3>
<p><strong>Symptoms:</strong> Camera lights on, but no video feed in NVR/VMS</p>
<p><strong>Diagnostic Steps:</strong></p>
<ol>
<li>Check if camera is detected on network (use SADP tool or IP scanner)</li>
<li>Verify camera IP address is in correct subnet</li>
<li>Ping camera from NVR or computer</li>
<li>Access camera web interface directly (http://camera-ip)</li>
<li>Check username/password credentials</li>
<li>Verify ONVIF or camera brand compatibility with NVR</li>
<li>Check network bandwidth (multiple 4K cameras can saturate network)</li>
</ol>',
                'block_order' => 18
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Network Configuration Issues</h3>
<p>Common IP configuration problems:</p>
<ul>
<li><strong>IP Conflict:</strong> Two devices with same IP address</li>
<li><strong>Wrong Subnet:</strong> Camera IP not matching network range (e.g., camera on 192.168.1.x, NVR on 192.168.0.x)</li>
<li><strong>DHCP Issues:</strong> Camera not getting IP from DHCP server</li>
<li><strong>Gateway Misconfiguration:</strong> Camera can\'t reach NVR across subnets</li>
</ul>
<p><strong>Solution Steps:</strong></p>
<ol>
<li>Set camera to static IP in same subnet as NVR</li>
<li>Use manufacturer\'s IP configuration tool</li>
<li>Reset camera to factory defaults if needed</li>
<li>Ensure no firewall blocking communication</li>
</ol>',
                'block_order' => 19
            ],
            [
                'block_type' => 'image',
                'content' => 'Network Configuration Diagram',
                'media_url' => 'https://via.placeholder.com/800x600/1e40af/ffffff?text=IP+Configuration+Example',
                'block_order' => 20
            ],

            // Section 4: Analog Troubleshooting (Slides 21-27)
            [
                'block_type' => 'heading',
                'content' => 'Section 4: Analog Camera Troubleshooting',
                'block_order' => 21
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Analog Troubleshooting Flowchart</h3>
<p>Systematic approach for analog camera issues:</p>
<ol>
<li><strong>Verify Power Supply</strong> - Check 12V DC at camera</li>
<li><strong>Inspect Video Cable</strong> - Look for damage, test continuity</li>
<li><strong>Test at DVR Input</strong> - Verify signal reaches DVR</li>
<li><strong>Check DVR Channel</strong> - Ensure channel is enabled</li>
<li><strong>Swap Components</strong> - Isolate faulty equipment</li>
</ol>',
                'block_order' => 22
            ],
            [
                'block_type' => 'image',
                'content' => 'Analog Troubleshooting Decision Tree',
                'media_url' => 'https://via.placeholder.com/800x600/166534/ffffff?text=Analog+Troubleshooting+Flowchart',
                'block_order' => 23
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Issue #1: No Video Signal (Black Screen)</h3>
<p><strong>Symptoms:</strong> DVR shows "No Video" or black screen for camera channel</p>
<p><strong>Diagnostic Steps:</strong></p>
<ol>
<li><strong>Check Power:</strong> Measure voltage at camera power input (should be 11.5-12.5V DC)</li>
<li><strong>Inspect Connections:</strong> Ensure BNC connectors are tight and not corroded</li>
<li><strong>Test Video Signal:</strong> Use portable monitor at camera to verify output</li>
<li><strong>Check Cable:</strong> Test coax cable continuity with multimeter</li>
<li><strong>Verify DVR Input:</strong> Test camera on different DVR channel</li>
<li><strong>Check Video Standard:</strong> Ensure camera matches DVR (NTSC/PAL)</li>
</ol>',
                'block_order' => 24
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Voltage Drop Calculation</h3>
<p>Long cable runs cause voltage drop, affecting camera performance:</p>
<div style="background-color: #fef3c7; padding: 15px; border-left: 4px solid #f59e0b; margin: 20px 0;">
<strong>Formula:</strong> Voltage Drop = (2 × L × I × R) / 1000<br>
Where:<br>
- L = Cable length in meters<br>
- I = Current in amperes<br>
- R = Resistance per km (varies by wire gauge)<br><br>
<strong>Example:</strong><br>
100m run, 0.5A camera, 18AWG wire (21 Ω/km):<br>
Drop = (2 × 100 × 0.5 × 21) / 1000 = 2.1V<br>
At camera: 12V - 2.1V = 9.9V (too low!)
</div>
<p><strong>Solutions:</strong></p>
<ul>
<li>Use larger wire gauge (16AWG or 14AWG)</li>
<li>Install mid-point power supply</li>
<li>Use higher input voltage (24V AC systems)</li>
</ul>',
                'block_order' => 25
            ],
            [
                'block_type' => 'image',
                'content' => 'Voltage Drop Chart by Cable Length',
                'media_url' => 'https://via.placeholder.com/800x600/dc2626/ffffff?text=Voltage+Drop+vs+Cable+Length',
                'block_order' => 26
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Issue #2: Poor Video Quality</h3>
<p><strong>Symptoms:</strong> Snowy/grainy image, rolling lines, color issues</p>
<p><strong>Diagnostic Steps & Solutions:</strong></p>
<table style="width:100%; border-collapse: collapse;">
<tr style="background-color: #f2f2f2;">
<th style="border: 1px solid #ddd; padding: 8px;">Symptom</th>
<th style="border: 1px solid #ddd; padding: 8px;">Likely Cause</th>
<th style="border: 1px solid #ddd; padding: 8px;">Solution</th>
</tr>
<tr>
<td style="border: 1px solid #ddd; padding: 8px;">Snow/Static</td>
<td style="border: 1px solid #ddd; padding: 8px;">Weak signal, bad cable</td>
<td style="border: 1px solid #ddd; padding: 8px;">Replace cable, check connections</td>
</tr>
<tr>
<td style="border: 1px solid #ddd; padding: 8px;">Rolling Lines</td>
<td style="border: 1px solid #ddd; padding: 8px;">Ground loop, interference</td>
<td style="border: 1px solid #ddd; padding: 8px;">Use ground loop isolator</td>
</tr>
<tr>
<td style="border: 1px solid #ddd; padding: 8px;">Dim Image</td>
<td style="border: 1px solid #ddd; padding: 8px;">Low voltage at camera</td>
<td style="border: 1px solid #ddd; padding: 8px;">Check power supply, reduce cable length</td>
</tr>
<tr>
<td style="border: 1px solid #ddd; padding: 8px;">No Color</td>
<td style="border: 1px solid #ddd; padding: 8px;">Camera in B&W mode, low light</td>
<td style="border: 1px solid #ddd; padding: 8px;">Check camera settings, add lighting</td>
</tr>
<tr>
<td style="border: 1px solid #ddd; padding: 8px;">Ghosting/Echo</td>
<td style="border: 1px solid #ddd; padding: 8px;">Impedance mismatch, cable too long</td>
<td style="border: 1px solid #ddd; padding: 8px;">Check 75Ω termination, use video amplifier</td>
</tr>
</table>',
                'block_order' => 27
            ],

            // Section 5: Advanced Diagnostics (Slides 28-32)
            [
                'block_type' => 'heading',
                'content' => 'Section 5: Advanced Diagnostics',
                'block_order' => 28
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Cable Testing Procedures</h3>
<p><strong>For Ethernet Cables (PoE Systems):</strong></p>
<ol>
<li><strong>Visual Inspection:</strong> Check for kinks, cuts, or crushed sections</li>
<li><strong>Continuity Test:</strong> Use cable tester to verify all 8 wires</li>
<li><strong>PoE Voltage Test:</strong> Measure voltage on pins 1-2 and 3-6 (should be 48-54V)</li>
<li><strong>Bandwidth Test:</strong> Use cable certifier to verify Cat5e/6 spec (optional)</li>
<li><strong>Length Verification:</strong> Ensure run is under 100m/328ft</li>
</ol>
<p><strong>For Coaxial Cables (Analog Systems):</strong></p>
<ol>
<li><strong>Visual Inspection:</strong> Check for damaged jacket or exposed braid</li>
<li><strong>Continuity Test:</strong> Verify center conductor and shield continuity</li>
<li><strong>Resistance Test:</strong> Should read near zero ohms on center conductor</li>
<li><strong>Capacitance Test:</strong> Check for shorts between center and shield</li>
</ol>',
                'block_order' => 29
            ],
            [
                'block_type' => 'image',
                'content' => 'Cable Testing Diagram',
                'media_url' => 'https://via.placeholder.com/800x600/7c2d12/ffffff?text=Cable+Testing+Methods',
                'block_order' => 30
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Environmental Factors</h3>
<p>External conditions affecting camera performance:</p>
<ul>
<li><strong>Temperature Extremes:</strong>
  <ul>
  <li>Cameras may fail below -10°C or above 50°C</li>
  <li>Use outdoor-rated cameras with proper temperature range</li>
  <li>Add heaters for extreme cold environments</li>
  </ul>
</li>
<li><strong>Moisture/Humidity:</strong>
  <ul>
  <li>Check IP rating (IP66 minimum for outdoor)</li>
  <li>Inspect cable entries for water intrusion</li>
  <li>Use silicone sealant on connections</li>
  </ul>
</li>
<li><strong>Lightning/Power Surges:</strong>
  <ul>
  <li>Install surge protectors on power and data lines</li>
  <li>Ensure proper grounding of all equipment</li>
  <li>Use shielded cables in high-EMI environments</li>
  </ul>
</li>
<li><strong>Lighting Conditions:</strong>
  <ul>
  <li>Adjust camera settings for backlight compensation</li>
  <li>Use WDR (Wide Dynamic Range) cameras for mixed lighting</li>
  <li>Position cameras to avoid direct sunlight</li>
  </ul>
</li>
</ul>',
                'block_order' => 31
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Systematic Troubleshooting Checklist</h3>
<div style="background-color: #dbeafe; padding: 20px; border-radius: 8px; margin: 20px 0;">
<h4>The 5-Minute Quick Check:</h4>
<ol>
<li>☐ Power present at camera? (LED on or voltage measured)</li>
<li>☐ Cables physically intact? (no visible damage)</li>
<li>☐ Connections secure? (BNC/RJ45 clicked in)</li>
<li>☐ Other cameras working? (system-wide vs single camera issue)</li>
<li>☐ Recent changes? (power outage, construction, new equipment)</li>
</ol>
<h4>The 30-Minute Deep Dive:</h4>
<ol start="6">
<li>☐ Test with different cable</li>
<li>☐ Test on different port/channel</li>
<li>☐ Measure actual voltages (power and PoE)</li>
<li>☐ Check network settings (IP, subnet, gateway)</li>
<li>☐ Test camera on bench with known-good equipment</li>
<li>☐ Review camera logs (if available)</li>
<li>☐ Check NVR/DVR firmware version compatibility</li>
</ol>
</div>',
                'block_order' => 32
            ],

            // Section 6: Best Practices (Slides 33-35)
            [
                'block_type' => 'heading',
                'content' => 'Section 6: Preventive Maintenance & Best Practices',
                'block_order' => 33
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Regular Maintenance Schedule</h3>
<table style="width:100%; border-collapse: collapse;">
<tr style="background-color: #f2f2f2;">
<th style="border: 1px solid #ddd; padding: 8px;">Frequency</th>
<th style="border: 1px solid #ddd; padding: 8px;">Task</th>
<th style="border: 1px solid #ddd; padding: 8px;">Benefit</th>
</tr>
<tr>
<td style="border: 1px solid #ddd; padding: 8px;"><strong>Monthly</strong></td>
<td style="border: 1px solid #ddd; padding: 8px;">
  • Clean camera lenses<br>
  • Check video quality<br>
  • Verify recording functionality
</td>
<td style="border: 1px solid #ddd; padding: 8px;">Maintain image clarity</td>
</tr>
<tr>
<td style="border: 1px solid #ddd; padding: 8px;"><strong>Quarterly</strong></td>
<td style="border: 1px solid #ddd; padding: 8px;">
  • Inspect cable connections<br>
  • Test backup power systems<br>
  • Update camera firmware<br>
  • Check storage capacity
</td>
<td style="border: 1px solid #ddd; padding: 8px;">Prevent failures</td>
</tr>
<tr>
<td style="border: 1px solid #ddd; padding: 8px;"><strong>Annually</strong></td>
<td style="border: 1px solid #ddd; padding: 8px;">
  • Full system testing<br>
  • Replace surge protectors<br>
  • Clean internal electronics<br>
  • Update NVR/DVR firmware<br>
  • Review and update network security
</td>
<td style="border: 1px solid #ddd; padding: 8px;">Extend equipment life</td>
</tr>
</table>',
                'block_order' => 34
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>Installation Best Practices</h3>
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
<div>
<h4>DO:</h4>
<ul>
<li>✓ Use quality cables (Cat6 for PoE, RG6 for analog)</li>
<li>✓ Label all cables clearly</li>
<li>✓ Leave service loops at connections</li>
<li>✓ Use proper cable management</li>
<li>✓ Install surge protection</li>
<li>✓ Document IP addresses and settings</li>
<li>✓ Test before final installation</li>
<li>✓ Use weatherproof connectors outdoors</li>
</ul>
</div>
<div>
<h4>DON\'T:</h4>
<ul>
<li>✗ Run cables near high voltage lines</li>
<li>✗ Exceed maximum cable distances</li>
<li>✗ Use indoor equipment outdoors</li>
<li>✗ Mix PoE standards without verification</li>
<li>✗ Skip proper grounding</li>
<li>✗ Use copper in lightning-prone areas without protection</li>
<li>✗ Daisy-chain too many switches</li>
<li>✗ Forget to secure admin credentials</li>
</ul>
</div>
</div>',
                'block_order' => 35
            ],

            // Conclusion (Slide 36-37)
            [
                'block_type' => 'heading',
                'content' => 'Congratulations! 🎉',
                'block_order' => 36
            ],
            [
                'block_type' => 'text',
                'content' => '<h3>You\'ve Completed the CCTV Troubleshooting Tutorial!</h3>
<p>You now have the knowledge to:</p>
<ul>
<li>✓ Understand PoE and analog CCTV system architectures</li>
<li>✓ Diagnose power and connectivity issues</li>
<li>✓ Troubleshoot video signal problems</li>
<li>✓ Test cables and connections properly</li>
<li>✓ Calculate power budgets and voltage drops</li>
<li>✓ Implement preventive maintenance schedules</li>
<li>✓ Follow industry best practices</li>
</ul>
<h4>Next Steps:</h4>
<ol>
<li>Practice these techniques on actual systems</li>
<li>Build your technician toolkit</li>
<li>Document your troubleshooting procedures</li>
<li>Stay updated on new camera technologies</li>
</ol>
<p style="text-align: center; margin-top: 30px; font-size: 1.2em;">
<strong>Keep learning and happy troubleshooting! 🔧📹</strong>
</p>',
                'block_order' => 37
            ],
        ];

        foreach ($blocks as $blockData) {
            ContentBlock::create([
                'product_content_id' => $content->id,
                'block_type' => $blockData['block_type'],
                'content' => $blockData['content'],
                'media_url' => $blockData['media_url'] ?? null,
                'block_order' => $blockData['block_order']
            ]);
        }

        $this->info("Created " . count($blocks) . " content blocks!");
        $this->info("Tutorial is ready! View it at: /my-products/{$product->id}/content/{$content->id}");
        
        return 0;
    }
}
