<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    order: Object,
    product: Object,
});
</script>

<template>
    <AppLayout>
        <Head>
            <title>Thank You - FieldOps Pro</title>
        </Head>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 sm:p-10 bg-white">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            
                            <h1 class="mt-4 text-2xl font-semibold text-gray-900 sm:text-3xl">Thank you for your purchase!</h1>
                            
                            <p class="mt-2 text-gray-600">
                                Your order has been successfully processed and your access is now available.
                            </p>
                            
                            <div class="mt-8 p-5 bg-gray-50 rounded-lg">
                                <h2 class="text-lg font-medium text-gray-900">Order Details</h2>
                                <div class="mt-2 grid grid-cols-1 gap-2 text-sm sm:grid-cols-2">
                                    <div class="flex justify-between sm:block">
                                        <span class="text-gray-500">Order Number:</span>
                                        <span class="font-medium">{{ order.order_number }}</span>
                                    </div>
                                    <div class="flex justify-between sm:block">
                                        <span class="text-gray-500">Date:</span>
                                        <span class="font-medium">{{ new Date(order.created_at).toLocaleDateString() }}</span>
                                    </div>
                                    <div class="flex justify-between sm:block">
                                        <span class="text-gray-500">Total:</span>
                                        <span class="font-medium">${{ order.amount.toFixed(2) }}</span>
                                    </div>
                                    <div class="flex justify-between sm:block">
                                        <span class="text-gray-500">Product:</span>
                                        <span class="font-medium">{{ product.name }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-10">
                                <p class="text-gray-600 mb-6">
                                    You can access your purchase at any time from your dashboard.
                                </p>
                                
                                <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4 justify-center">
                                    <Link :href="route('dashboard')" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        Go to Dashboard
                                    </Link>
                                    
                                    <Link :href="route('home')" class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        Return Home
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>