<template>
    <AppLayout title="Thank You">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Order Confirmation
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="text-center mb-8">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-900">Thank you for your order!</h1>
                            <p class="mt-2 text-lg text-gray-600">Your order has been received and is being processed.</p>
                        </div>
                        
                        <div class="max-w-3xl mx-auto">
                            <div class="border-t border-b border-gray-200 py-4 mb-6">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                                
                                <div class="grid grid-cols-2 gap-4 mb-3">
                                    <div class="text-sm text-gray-600">Order Number:</div>
                                    <div class="text-sm font-medium text-gray-900">{{ order.order_number }}</div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 mb-3">
                                    <div class="text-sm text-gray-600">Date:</div>
                                    <div class="text-sm font-medium text-gray-900">{{ order.created_at }}</div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 mb-3">
                                    <div class="text-sm text-gray-600">Total Amount:</div>
                                    <div class="text-sm font-medium text-gray-900">${{ order.total_amount.toFixed(2) }}</div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 mb-3">
                                    <div class="text-sm text-gray-600">Payment Method:</div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ order.payment ? formatPaymentMethod(order.payment.payment_method) : 'N/A' }}
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4 mb-3">
                                    <div class="text-sm text-gray-600">Status:</div>
                                    <div class="text-sm font-medium">
                                        <span v-if="order.status === 'completed'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                        <span v-else-if="order.status === 'pending'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                        <span v-else-if="order.status === 'failed'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Failed
                                        </span>
                                        <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ order.status }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-8">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Product Details</h2>
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <h3 class="text-md font-medium text-gray-900 mb-1">{{ order.product.name }}</h3>
                                    <p class="text-sm text-gray-600">{{ order.product.description }}</p>
                                </div>
                            </div>
                            
                            <div class="mb-8">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">What's Next?</h2>
                                <div class="bg-blue-50 p-4 rounded-md">
                                    <div v-if="order.status === 'completed'">
                                        <p class="text-sm text-gray-700 mb-2">
                                            Your payment has been processed and your product is now available in your account.
                                        </p>
                                        <p class="text-sm text-gray-700 mb-4">
                                            You can access your purchase from your dashboard at any time.
                                        </p>
                                        <Link :href="route('dashboard')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Go to Dashboard
                                        </Link>
                                    </div>
                                    <div v-else-if="order.status === 'pending'">
                                        <p class="text-sm text-gray-700 mb-2">
                                            Your payment is being processed. Once completed, your product will be available in your account.
                                        </p>
                                        <p class="text-sm text-gray-700 mb-4">
                                            You can check the status of your order from your dashboard.
                                        </p>
                                        <Link :href="route('dashboard')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Go to Dashboard
                                        </Link>
                                    </div>
                                    <div v-else>
                                        <p class="text-sm text-gray-700 mb-2">
                                            There was an issue with your payment. Please contact support for assistance.
                                        </p>
                                        <Link :href="route('home')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Return to Homepage
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center mt-8">
                                <p class="text-sm text-gray-600">
                                    Thank you for your purchase! If you have any questions, please contact our support team.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { defineComponent } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

export default defineComponent({
    components: {
        AppLayout,
        Link
    },
    props: {
        order: Object
    },
    methods: {
        formatPaymentMethod(method) {
            switch (method) {
                case 'card': return 'Credit/Debit Card';
                case 'ach': return 'Bank Transfer (ACH)';
                case 'discount': return 'Discount Code (100%)';
                default: return method;
            }
        }
    }
});
</script>