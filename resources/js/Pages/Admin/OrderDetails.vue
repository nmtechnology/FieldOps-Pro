<template>
    <AppLayout title="Order Details">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Order #{{ order.id }} Details
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-4">
                    <Link :href="route('admin.orders.index')" class="text-sm text-blue-600 hover:text-blue-800">
                        &larr; Back to Orders
                    </Link>
                </div>
                
                <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-gray-900 border-b border-gray-200">
                        <!-- Flash Messages -->
                        <div v-if="$page.props.flash.success" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ $page.props.flash.success }}
                        </div>
                        <div v-if="$page.props.flash.error" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ $page.props.flash.error }}
                        </div>
                        
                        <!-- Order Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Order Information</h3>
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="text-sm text-gray-500">Order ID:</div>
                                        <div class="text-sm font-medium text-gray-900">{{ order.id }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="text-sm text-gray-500">Date:</div>
                                        <div class="text-sm font-medium text-gray-900">{{ order.created_at }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="text-sm text-gray-500">Status:</div>
                                        <div class="text-sm font-medium">
                                            <span v-if="order.status === 'completed'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Completed
                                            </span>
                                            <span v-else-if="order.status === 'refunded'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Refunded
                                            </span>
                                            <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                {{ order.status }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="text-sm text-gray-500">Total Amount:</div>
                                        <div class="text-sm font-medium text-gray-900">${{ order.total_amount.toFixed(2) }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Customer Information</h3>
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="text-sm text-gray-500">Name:</div>
                                        <div class="text-sm font-medium text-gray-900">{{ order.user.name }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="text-sm text-gray-500">Email:</div>
                                        <div class="text-sm font-medium text-gray-900">{{ order.user.email }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="text-sm text-gray-500">User ID:</div>
                                        <div class="text-sm font-medium text-gray-900">{{ order.user.id }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Product Information</h3>
                                <div class="bg-gray-50 p-4 rounded-md">
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="text-sm text-gray-500">Name:</div>
                                        <div class="text-sm font-medium text-gray-900">{{ order.product.name }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="text-sm text-gray-500">Price:</div>
                                        <div class="text-sm font-medium text-gray-900">${{ order.product.price.toFixed(2) }}</div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="text-sm text-gray-500 mb-1">Description:</div>
                                        <div class="text-sm font-medium text-gray-900">{{ order.product.description }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Payment Information</h3>
                                <div v-if="order.payment" class="bg-gray-50 p-4 rounded-md">
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="text-sm text-gray-500">Payment ID:</div>
                                        <div class="text-sm font-medium text-gray-900">{{ order.payment.id }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="text-sm text-gray-500">Method:</div>
                                        <div class="text-sm font-medium text-gray-900">{{ order.payment.payment_method }}</div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="text-sm text-gray-500">Status:</div>
                                        <div class="text-sm font-medium">
                                            <span v-if="order.payment.status === 'completed'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Completed
                                            </span>
                                            <span v-else-if="order.payment.status === 'refunded'" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Refunded
                                            </span>
                                            <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                {{ order.payment.status }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-3">
                                        <div class="text-sm text-gray-500">Stripe Payment ID:</div>
                                        <div class="text-sm font-medium text-gray-900">{{ order.payment.stripe_payment_id }}</div>
                                    </div>
                                    
                                    <!-- Refund Information -->
                                    <div v-if="order.payment.refund_id" class="mt-4 border-t pt-4">
                                        <div class="text-sm font-medium text-gray-900 mb-2">Refund Information</div>
                                        <div class="grid grid-cols-2 gap-4 mb-3">
                                            <div class="text-sm text-gray-500">Refund ID:</div>
                                            <div class="text-sm font-medium text-gray-900">{{ order.payment.refund_id }}</div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 mb-3">
                                            <div class="text-sm text-gray-500">Refunded on:</div>
                                            <div class="text-sm font-medium text-gray-900">{{ order.payment.refunded_at }}</div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="text-sm text-gray-500 mb-1">Reason:</div>
                                            <div class="text-sm font-medium text-gray-900">{{ order.payment.refund_reason }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="bg-gray-50 p-4 rounded-md">
                                    <p class="text-sm text-gray-500">No payment information available</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-6 flex justify-end">
                            <button v-if="order.status !== 'refunded'" @click="openRefundModal" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Process Refund
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Refund Modal -->
        <div v-if="showRefundModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form @submit.prevent="processRefund">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Process Refund
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            You are about to refund order #{{ order.id }} for ${{ order.total_amount.toFixed(2) }} to {{ order.user.name }}. This action cannot be undone.
                                        </p>
                                        <div class="mt-4">
                                            <label for="refund-reason" class="block text-sm font-medium text-gray-700">Reason for refund</label>
                                            <textarea id="refund-reason" v-model="refundReason" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Enter reason for refund..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Process Refund
                            </button>
                            <button @click="closeRefundModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { defineComponent } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

export default defineComponent({
    components: {
        AppLayout,
        Link
    },
    props: {
        order: Object
    },
    data() {
        return {
            showRefundModal: false,
            refundReason: ''
        };
    },
    methods: {
        openRefundModal() {
            this.refundReason = '';
            this.showRefundModal = true;
        },
        closeRefundModal() {
            this.showRefundModal = false;
        },
        processRefund() {
            if (!this.refundReason.trim()) {
                alert('Please provide a reason for the refund');
                return;
            }
            
            router.post(route('admin.orders.refund', this.order.id), {
                reason: this.refundReason
            }, {
                onSuccess: () => {
                    this.closeRefundModal();
                }
            });
        }
    }
});
</script>