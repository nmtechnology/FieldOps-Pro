<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::latest()->get()->map(function ($discount) {
            return [
                'id' => $discount->id,
                'code' => $discount->code,
                'type' => $discount->type,
                'value' => $discount->value,
                'is_active' => $discount->is_active,
                'valid_from' => $discount->valid_from ? $discount->valid_from->format('Y-m-d') : null,
                'valid_until' => $discount->valid_until ? $discount->valid_until->format('Y-m-d') : null,
                'usage_count' => $discount->usage_count,
                'max_uses' => $discount->max_uses,
                'description' => $discount->description
            ];
        });
        
        return Inertia::render('Admin/Discounts', [
            'discounts' => $discounts
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:20|unique:discounts,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric',
            'is_active' => 'boolean',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'max_uses' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:255'
        ]);
        
        // Generate random code if not provided
        if (empty($validated['code'])) {
            $validated['code'] = strtoupper(Str::random(8));
        }
        
        // Default to active if not specified
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = true;
        }
        
        // Create discount code
        $discount = Discount::create($validated);
        
        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount code created successfully.');
    }
    
    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:20|unique:discounts,code,' . $discount->id,
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric',
            'is_active' => 'boolean',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date|after_or_equal:valid_from',
            'max_uses' => 'nullable|integer|min:1',
            'description' => 'nullable|string|max:255'
        ]);
        
        $discount->update($validated);
        
        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount code updated successfully.');
    }
    
    public function destroy(Discount $discount)
    {
        $discount->delete();
        
        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount code deleted successfully.');
    }
    
    public function validateCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'product_id' => 'required|exists:products,id'
        ]);
        
        $discount = Discount::where('code', $request->code)
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            })
            ->where(function($query) {
                $query->whereNull('max_uses')
                    ->orWhere('usage_count', '<', 'max_uses');
            })
            ->first();
        
        if (!$discount) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid or expired discount code.'
            ], 422);
        }
        
        return response()->json([
            'valid' => true,
            'discount' => [
                'type' => $discount->type,
                'value' => $discount->value
            ]
        ]);
    }
}
