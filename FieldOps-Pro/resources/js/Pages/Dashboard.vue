<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    purchases: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg p-6">
                    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Your Purchases</h1>
                    
                    <div v-if="purchases && purchases.length > 0">
                        <div class="space-y-6">
                            <div v-for="purchase in purchases" :key="purchase.id" class="border border-gray-200 rounded-lg p-6">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                    <div>
                                        <h2 class="text-lg font-medium text-gray-900">{{ purchase.product.name }}</h2>
                                        <p class="text-sm text-gray-500">
                                            Purchased on {{ new Date(purchase.created_at).toLocaleDateString() }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Order #{{ purchase.order_number }}
                                        </p>
                                    </div>
                                    
                                    <div class="mt-2 sm:mt-0">
                                        <span 
                                            :class="[
                                                'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                                purchase.status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                purchase.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                'bg-red-100 text-red-800'
                                            ]"
                                        >
                                            {{ purchase.status.charAt(0).toUpperCase() + purchase.status.slice(1) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <a 
                                        v-if="purchase.status === 'completed'" 
                                        :href="route('products.toc', purchase.product.id)"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    >
                                        Access Content
                                    </a>
                                    
                                    <p v-else-if="purchase.status === 'pending'" class="text-sm text-yellow-600">
                                        Your purchase is being processed. Content access will be available soon.
                                    </p>
                                    
                                    <p v-else-if="purchase.status === 'refunded'" class="text-sm text-red-600">
                                        This purchase has been refunded.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div v-else class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No purchases yet</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            You haven't made any purchases yet. Check out our products to get started.
                        </p>
                        <div class="mt-6">
                            <a href="/" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Browse Products
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
