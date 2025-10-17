<template>
    <Head>
        <title>Thank You - FieldEngineer Pro</title>
        <meta name="description" content="Thank you for your purchase">
    </Head>

    <GuestLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="text-center mb-8">
                            <svg class="mx-auto h-24 w-24 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h1 class="mt-4 text-3xl font-bold text-green-600 dark:text-green-400">Thank You for Your Purchase!</h1>
                            <p class="mt-2 text-xl">Your order has been successfully processed.</p>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg mb-8">
                            <h2 class="text-xl font-semibold mb-4">Order Details</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Order Number:</p>
                                    <p class="font-medium">{{ purchase.order_number }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Date:</p>
                                    <p class="font-medium">{{ new Date().toLocaleDateString() }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Total Amount:</p>
                                    <p class="font-medium">${{ purchase.amount.toFixed(2) }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Email:</p>
                                    <p class="font-medium">{{ purchase.email }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg mb-8">
                            <h2 class="text-xl font-semibold mb-4">Product Purchased</h2>
                            <div class="flex items-center">
                                <img :src="product.image_url" :alt="product.name" class="w-24 h-24 object-cover rounded mr-4">
                                <div>
                                    <h3 class="text-lg font-medium">{{ product.name }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400">{{ product.short_description }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-orange-50 dark:bg-orange-900 border-l-4 border-orange-500 p-4 mb-8">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-orange-800 dark:text-orange-300">Complete Your Account</h3>
                                    <p class="mt-2 text-orange-700 dark:text-orange-200">
                                        To access your purchased products and have a personalized experience, please take a moment to complete your account setup.
                                    </p>
                                    <div class="mt-4">
                                        <Link :href="registrationUrl" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-500 focus:bg-orange-500 active:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Complete Registration
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                A confirmation email has been sent to your email address.
                            </p>
                            <Link :href="route('home')" class="text-orange-600 hover:text-orange-500">
                                Return to Homepage
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    purchase: Object,
    product: Object,
    registrationUrl: String,
});
</script>