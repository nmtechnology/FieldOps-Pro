<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateProductTiers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-product-tiers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the product tiers with the latest information';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating product tiers...');
        
        // Run the UpdateProductTiersSeeder
        Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\UpdateProductTiersSeeder'
        ], $this->output);
        
        $this->info('Product tiers updated successfully!');
        
        return Command::SUCCESS;
    }
}