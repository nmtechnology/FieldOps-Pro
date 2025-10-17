<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    products: Array,
    userProducts: Array,
});

// Filter out products the user already owns
const availableProducts = ref(
    props.products.filter(product => 
        !props.userProducts.some(userProduct => 
            userProduct.product_id === product.id
        )
    )
);

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
};
</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Available Products
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-gray-900 dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Browse Products</h1>
                    
                    <div v-if="availableProducts.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div v-for="product in availableProducts" :key="product.id" 
                            class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-md transition-all hover:shadow-lg">
                            
                            <!-- Product Image (replace with actual image) -->
                            <div class="h-48 bg-gray-300 dark:bg-gray-700">
                                <img v-if="product.image" :src="product.image" alt="Product image" class="h-full w-full object-cover" />
                                <div v-else class="flex items-center justify-center h-full">
                                    <svg class="h-12 w-12 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Product Details -->
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ product.name }}</h3>
                                <div class="mt-1">
                                    <span class="text-xl font-bold text-gray-900 dark:text-white">{{ formatCurrency(product.price) }}</span>
                                    <span v-if="product.old_price" class="ml-2 text-sm line-through text-gray-500 dark:text-gray-400">
                                        {{ formatCurrency(product.old_price) }}
                                    </span>
                                </div>
                                
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">{{ product.description }}</p>
                                
                                <div class="mt-4 space-y-2">
                                    <div v-if="product.features && product.features.length" class="text-sm text-gray-600 dark:text-gray-300">
                                        <ul class="list-disc pl-5 space-y-1">
                                            <li v-for="(feature, index) in product.features.slice(0, 3)" :key="index">
                                                {{ feature }}
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <div class="mt-4 flex justify-between items-center">
                                        <a :href="route('products.show', product.id)" 
                                           class="inline-flex items-center text-orange-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">
                                            View Details
                                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                        
                                        <a :href="route('checkout', product.id)"
                                           class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Buy Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div v-else class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No additional products available</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            You already own all available products.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>