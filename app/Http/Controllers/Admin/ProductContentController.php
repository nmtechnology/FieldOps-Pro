<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductContent;
use App\Models\ContentBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductContentController extends Controller
{
    /**
     * Display content management for a product
     */
    public function index(Product $product)
    {
        $contents = $product->contents()
            ->with(['children.blocks', 'blocks'])
            ->whereNull('parent_id') // Only get chapters (top-level)
            ->orderBy('section_order')
            ->get();

        return Inertia::render('Admin/Products/Content/Index', [
            'product' => $product,
            'contents' => $contents
        ]);
    }

    /**
     * Show the form for creating a new content section
     */
    public function create(Product $product, Request $request)
    {
        $parentId = $request->query('parent_id');
        $parent = $parentId ? ProductContent::find($parentId) : null;

        return Inertia::render('Admin/Products/Content/Create', [
            'product' => $product,
            'parent' => $parent
        ]);
    }

    /**
     * Store a newly created content section
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:product_contents,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'section_type' => 'required|string|in:introduction,chapter,section,bonus,conclusion',
            'duration_minutes' => 'nullable|integer|min:0',
            'is_premium' => 'boolean',
            'is_published' => 'boolean',
        ]);

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(6);
        $validated['product_id'] = $product->id;
        
        // Get the next section order
        $maxOrder = ProductContent::where('product_id', $product->id)
            ->where('parent_id', $validated['parent_id'] ?? null)
            ->max('section_order') ?? 0;
        $validated['section_order'] = $maxOrder + 1;

        $content = ProductContent::create($validated);

        return redirect()
            ->route('admin.products.content.edit', ['product' => $product->id, 'content' => $content->id])
            ->with('success', 'Content section created successfully. Now add content blocks.');
    }

    /**
     * Show the form for editing content
     */
    public function edit(Product $product, ProductContent $content)
    {
        $content->load(['blocks', 'children.blocks']);

        return Inertia::render('Admin/Products/Content/Edit', [
            'product' => $product,
            'content' => $content
        ]);
    }

    /**
     * Update the content section
     */
    public function update(Request $request, Product $product, ProductContent $content)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'section_type' => 'required|string|in:introduction,chapter,section,bonus,conclusion',
            'duration_minutes' => 'nullable|integer|min:0',
            'section_order' => 'nullable|integer|min:0',
            'is_premium' => 'boolean',
            'is_published' => 'boolean',
        ]);

        $content->update($validated);

        return back()->with('success', 'Content section updated successfully.');
    }

    /**
     * Remove the content section
     */
    public function destroy(Product $product, ProductContent $content)
    {
        $content->delete();

        return redirect()
            ->route('admin.products.content.index', $product)
            ->with('success', 'Content section deleted successfully.');
    }

    /**
     * Add a content block
     */
    public function storeBlock(Request $request, Product $product, ProductContent $content)
    {
        $validated = $request->validate([
            'block_type' => 'required|string|in:text,heading,image,video',
            'content' => 'nullable|string',
            'caption' => 'nullable|string',
            'media_type' => 'nullable|string|in:webp,jpg,png,mp4,webm',
            'media_file' => 'nullable|file|mimes:webp,jpg,jpeg,png,mp4,webm|max:51200', // 50MB max
        ]);

        // Get next block order
        $maxOrder = $content->blocks()->max('block_order') ?? 0;
        $validated['block_order'] = $maxOrder + 1;

        // Handle file upload
        if ($request->hasFile('media_file')) {
            $file = $request->file('media_file');
            $path = $file->store('product-media/' . $product->id, 'public');
            $validated['media_path'] = $path;
            $validated['media_type'] = $file->getClientOriginalExtension();
        }

        $content->blocks()->create($validated);

        return back()->with('success', 'Content block added successfully.');
    }

    /**
     * Update a content block
     */
    public function updateBlock(Request $request, Product $product, ProductContent $content, ContentBlock $block)
    {
        $validated = $request->validate([
            'block_type' => 'required|string|in:text,heading,image,video',
            'content' => 'nullable|string',
            'caption' => 'nullable|string',
            'block_order' => 'nullable|integer|min:0',
            'media_type' => 'nullable|string|in:webp,jpg,png,mp4,webm',
            'media_file' => 'nullable|file|mimes:webp,jpg,jpeg,png,mp4,webm|max:51200',
        ]);

        // Handle file upload
        if ($request->hasFile('media_file')) {
            // Delete old file if exists
            if ($block->media_path && \Storage::disk('public')->exists($block->media_path)) {
                \Storage::disk('public')->delete($block->media_path);
            }

            $file = $request->file('media_file');
            $path = $file->store('product-media/' . $product->id, 'public');
            $validated['media_path'] = $path;
            $validated['media_type'] = $file->getClientOriginalExtension();
        }

        $block->update($validated);

        return back()->with('success', 'Content block updated successfully.');
    }

    /**
     * Delete a content block
     */
    public function destroyBlock(Product $product, ProductContent $content, ContentBlock $block)
    {
        // Delete media file if exists
        if ($block->media_path && \Storage::disk('public')->exists($block->media_path)) {
            \Storage::disk('public')->delete($block->media_path);
        }

        $block->delete();

        return back()->with('success', 'Content block deleted successfully.');
    }

    /**
     * Reorder content sections
     */
    public function reorder(Request $request, Product $product)
    {
        $validated = $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:product_contents,id',
            'orders.*.section_order' => 'required|integer|min:0',
        ]);

        foreach ($validated['orders'] as $order) {
            ProductContent::where('id', $order['id'])
                ->update(['section_order' => $order['section_order']]);
        }

        return back()->with('success', 'Content order updated successfully.');
    }

    /**
     * Reorder content blocks
     */
    public function reorderBlocks(Request $request, Product $product, ProductContent $content)
    {
        $validated = $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:content_blocks,id',
            'orders.*.block_order' => 'required|integer|min:0',
        ]);

        foreach ($validated['orders'] as $order) {
            ContentBlock::where('id', $order['id'])
                ->update(['block_order' => $order['block_order']]);
        }

        return back()->with('success', 'Block order updated successfully.');
    }
}
