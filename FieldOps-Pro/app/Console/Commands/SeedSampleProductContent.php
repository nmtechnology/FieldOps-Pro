<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SeedSampleProductContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-sample-product-content {product_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed sample content for an info product, including downloadable resources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the product ID
        $productId = $this->argument('product_id');
        
        if (!$productId) {
            // Get the first info product if no ID is provided
            $product = \App\Models\Product::where('type', 'info')->first();
            
            if (!$product) {
                $this->error('No info product found. Create one first.');
                return 1;
            }
            
            $productId = $product->id;
        } else {
            $product = \App\Models\Product::find($productId);
            
            if (!$product) {
                $this->error("Product with ID {$productId} not found.");
                return 1;
            }
            
            if ($product->type !== 'info') {
                $this->warn("Product is not of type 'info'. This may lead to unexpected results.");
            }
        }
        
        $this->info("Seeding content for product: {$product->name} (ID: {$product->id})");
        
        // Create a directory for this product's files if it doesn't exist
        $productFilesDir = "product-files/{$product->id}";
        $fullPath = storage_path("app/public/{$productFilesDir}");
        
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
            $this->info("Created product files directory: {$fullPath}");
        }
        
        // Create sample files
        $this->createSampleFiles($fullPath);
        
        // Create the sample content
        $this->createSampleContent($product, $productFilesDir);
        
        $this->info('Sample content created successfully!');
        return 0;
    }
    
    /**
     * Create sample downloadable files
     */
    private function createSampleFiles($directory)
    {
        // Create a sample PDF file
        $pdfContent = "Sample PDF Content\n\nThis is a sample PDF file for the FieldOps-Pro platform.";
        file_put_contents("{$directory}/sample-guide.pdf", $pdfContent);
        
        // Create a sample Excel file
        $excelContent = "Sample,Excel,File\nRow1,Data1,Value1\nRow2,Data2,Value2";
        file_put_contents("{$directory}/sample-spreadsheet.csv", $excelContent);
        
        // Create a sample template
        $templateContent = "Sample Template\n\nThis is a sample template document that users can download and customize.";
        file_put_contents("{$directory}/sample-template.txt", $templateContent);
        
        $this->info('Created sample files in ' . $directory);
    }
    
    /**
     * Create sample product content with downloads
     */
    private function createSampleContent($product, $filesDir)
    {
        // First, clear existing content for this product
        \App\Models\ProductContent::where('product_id', $product->id)->delete();
        $this->info('Cleared existing content for this product');
        
        // Create an introduction section (free)
        \App\Models\ProductContent::create([
            'product_id' => $product->id,
            'title' => 'Introduction',
            'slug' => 'introduction',
            'section_type' => 'introduction',
            'section_order' => 1,
            'content' => '<h2>Welcome to ' . $product->name . '</h2><p>This is an introduction to the product. This content is free and available to everyone.</p><p>The rest of the content is premium and only available to customers who have purchased this product.</p>',
            'is_premium' => false,
            'is_published' => true,
        ]);
        
        // Create a first chapter (premium)
        \App\Models\ProductContent::create([
            'product_id' => $product->id,
            'title' => 'Getting Started',
            'slug' => 'getting-started',
            'section_type' => 'chapter',
            'section_order' => 2,
            'content' => '<h2>Getting Started</h2><p>This is the first chapter of the premium content. Here you will learn the basics of the subject.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl vel ultricies lacinia, nisl nisl aliquet nisl, eget aliquet nisl nisl eget nisl.</p>',
            'is_premium' => true,
            'is_published' => true,
        ]);
        
        // Create a second chapter with some media (premium)
        \App\Models\ProductContent::create([
            'product_id' => $product->id,
            'title' => 'Advanced Techniques',
            'slug' => 'advanced-techniques',
            'section_type' => 'chapter',
            'section_order' => 3,
            'content' => '<h2>Advanced Techniques</h2><p>This chapter covers more advanced techniques and strategies.</p><p>Below you\'ll find a helpful video and some media resources to support your learning.</p>',
            'media' => [
                [
                    'type' => 'video',
                    'title' => 'Tutorial Video',
                    'url' => 'https://example.com/video.mp4',
                    'caption' => 'A detailed tutorial video explaining the advanced techniques'
                ],
                [
                    'type' => 'image',
                    'title' => 'Process Diagram',
                    'url' => 'https://via.placeholder.com/800x500',
                    'caption' => 'Visual diagram of the process'
                ]
            ],
            'is_premium' => true,
            'is_published' => true,
        ]);
        
        // Create a resources section with downloads
        \App\Models\ProductContent::create([
            'product_id' => $product->id,
            'title' => 'Downloadable Resources',
            'slug' => 'resources',
            'section_type' => 'bonus',
            'section_order' => 4,
            'content' => '<h2>Downloadable Resources</h2><p>Here are some helpful resources you can download and use.</p>',
            'downloads' => [
                [
                    'name' => 'Complete Guide (PDF)',
                    'description' => 'A comprehensive guide with all the information you need',
                    'path' => "{$filesDir}/sample-guide.pdf",
                    'size' => filesize(storage_path("app/public/{$filesDir}/sample-guide.pdf"))
                ],
                [
                    'name' => 'Data Spreadsheet',
                    'description' => 'Useful data and calculations in spreadsheet format',
                    'path' => "{$filesDir}/sample-spreadsheet.csv",
                    'size' => filesize(storage_path("app/public/{$filesDir}/sample-spreadsheet.csv"))
                ],
                [
                    'name' => 'Template Document',
                    'description' => 'A template you can customize for your own use',
                    'path' => "{$filesDir}/sample-template.txt",
                    'size' => filesize(storage_path("app/public/{$filesDir}/sample-template.txt"))
                ]
            ],
            'is_premium' => true,
            'is_published' => true,
        ]);
        
        // Create a conclusion section
        \App\Models\ProductContent::create([
            'product_id' => $product->id,
            'title' => 'Conclusion',
            'slug' => 'conclusion',
            'section_type' => 'conclusion',
            'section_order' => 5,
            'content' => '<h2>Conclusion</h2><p>Congratulations on completing the content! Here\'s a summary of what you\'ve learned and some next steps.</p>',
            'is_premium' => true,
            'is_published' => true,
        ]);
        
        $this->info('Created 5 content sections');
    }
}
