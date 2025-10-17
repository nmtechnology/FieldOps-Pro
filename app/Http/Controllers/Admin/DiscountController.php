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
    public function index(Request $request)
    {
        $discounts = Discount::when($request->search, function ($query, $search) {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Discounts/Index', [
            'discounts' => $discounts,
            'filters' => $request->only(['search']),
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
        $request->validate([
            'code' => 'required|string|max:50|unique:discounts',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'max_uses' => 'nullable|integer|min:1',
            'active' => 'boolean',
        ]);

        Discount::create([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount,
            'starts_at' => $request->starts_at,
            'expires_at' => $request->expires_at,
            'max_uses' => $request->max_uses,
            'active' => $request->active ?? true,
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Discount created successfully.');
    }

    /**
     * Display the specified discount.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Inertia\Response
     */
    public function show(Discount $discount)
    {
        $discount->load('orders');
        
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
        $request->validate([
            'code' => 'required|string|max:50|unique:discounts,code,' . $discount->id,
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'max_uses' => 'nullable|integer|min:1',
            'active' => 'boolean',
        ]);

        $discount->update([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->value,
            'min_order_amount' => $request->min_order_amount,
            'starts_at' => $request->starts_at,
            'expires_at' => $request->expires_at,
            'max_uses' => $request->max_uses,
            'active' => $request->active ?? $discount->active,
        ]);

        return redirect()->route('admin.discounts.index')->with('success', 'Discount updated successfully.');
    }

    /**
     * Remove the specified discount from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Discount $discount)
    {
        // Check if discount has been used before deletion
        if ($discount->orders()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete discount that has been used in orders.');
        }

        $discount->delete();

        return redirect()->route('admin.discounts.index')->with('success', 'Discount deleted successfully.');
    }
}