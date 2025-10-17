<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DiscountController extends Controller
{
    /**
     * Display a listing of the discounts.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $discounts = Discount::withCount(['orders'])
            ->latest()
            ->paginate(10);
        
        return Inertia::render('Admin/Discounts/Index', [
            'discounts' => $discounts
        ]);
    }

    /**
     * Show the form for creating a new discount.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Discounts/Create');
    }

    /**
     * Store a newly created discount in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:discounts',
            'description' => 'required|string',
            'type' => 'required|string|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean'
        ]);

        Discount::create($validated);

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount created successfully.');
    }

    /**
     * Display the specified discount.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Inertia\Response
     */
    public function show(Discount $discount)
    {
        $discount->load(['orders']);
        
        return Inertia::render('Admin/Discounts/Show', [
            'discount' => $discount
        ]);
    }

    /**
     * Show the form for editing the specified discount.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Inertia\Response
     */
    public function edit(Discount $discount)
    {
        return Inertia::render('Admin/Discounts/Edit', [
            'discount' => $discount
        ]);
    }

    /**
     * Update the specified discount in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'code' => 'sometimes|string|max:50|unique:discounts,code,'.$discount->id,
            'description' => 'sometimes|string',
            'type' => 'sometimes|string|in:percentage,fixed',
            'value' => 'sometimes|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'sometimes|boolean'
        ]);

        $discount->update($validated);

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount updated successfully.');
    }

    /**
     * Remove the specified discount from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Discount $discount)
    {
        // Check if the discount has been used in orders
        if ($discount->orders()->exists()) {
            return redirect()->route('admin.discounts.index')
                ->with('error', 'Cannot delete discount with existing orders.');
        }
        
        $discount->delete();

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount deleted successfully.');
    }
}
