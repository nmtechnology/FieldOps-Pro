<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    order: Object
});

// Status badge colors
const statusColors = {
    pending: 'bg-yellow-100 text-yellow-800',
    completed: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800',
    refunded: 'bg-purple-100 text-purple-800'
};

// Form for updating order status
const statusForm = useForm({
    status: props.order.status
});

// Form for processing refunds
const refundForm = useForm({
    reason: ''
});

// Modal control
const showRefundModal = ref(false);

// Update order status
const updateStatus = () => {
    statusForm.put(route('admin.orders.update-status', props.order.id), {
        preserveScroll: true,
        onSuccess: () => {
            // Success notification handled by global flash message
        }
    });
};

// Process refund
const processRefund = () => {
    refundForm.post(route('admin.orders.refund', props.order.id), {
        preserveScroll: true,
        onSuccess: () => {
            showRefundModal.value = false;
            // Success notification handled by global flash message
        }
    });
};
</script>

<template>
    <Head :title="`Order #${order.id}`" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-white">
                    Order #{{ order.id }} Details
                </h2>
                <Link :href="route('admin.orders.index')" class="px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-md hover:bg-gray-700">
                    Back to Orders
                </Link>
            </div>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Order Summary Card -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Order Summary</h3>
                            <span :class="[
                                'px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full',
                                statusColors[order.status] || 'bg-gray-100 text-gray-800'
                            ]">
                                {{ order.status }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Order Details -->
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Order ID</h4>
                                    <p class="mt-1 text-sm text-gray-900">#{{ order.id }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Date</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ new Date(order.created_at).toLocaleString() }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Total Amount</h4>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">${{ order.amount.toFixed(2) }}</p>
                                </div>
                                <div v-if="order.refunded_at">
                                    <h4 class="text-sm font-medium text-gray-500">Refunded At</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ new Date(order.refunded_at).toLocaleString() }}</p>
                                </div>
                                <div v-if="order.refund_reason">
                                    <h4 class="text-sm font-medium text-gray-500">Refund Reason</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ order.refund_reason }}</p>
                                </div>
                            </div>
                            
                            <!-- Customer Details -->
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Customer</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ order.user.name }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Email</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ order.user.email }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Customer Since</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ new Date(order.user.created_at).toLocaleDateString() }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Customer Profile</h4>
                                    <Link :href="route('admin.users.show', order.user.id)" class="mt-1 inline-block text-sm text-indigo-600 hover:text-indigo-900">
                                        View Profile
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Details Card -->
                <div class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-6 text-lg font-medium text-gray-900">Product Details</h3>
                        
                        <div class="flex flex-col md:flex-row">
                            <div v-if="order.product.image_url" class="w-full md:w-1/4 mb-4 md:mb-0 md:pr-4">
                                <img :src="order.product.image_url" :alt="order.product.name" class="w-full h-auto rounded-md" />
                            </div>
                            
                            <div class="w-full md:w-3/4 space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Product Name</h4>
                                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ order.product.name }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Tier</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ order.product.tier }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Description</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ order.product.description }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Regular Price</h4>
                                    <p class="mt-1 text-sm text-gray-900">${{ order.product.price.toFixed(2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-6 text-lg font-medium text-gray-900">Order Actions</h3>
                        
                        <div class="space-y-4">
                            <!-- Update Status Form -->
                            <div v-if="order.status !== 'refunded'">
                                <h4 class="text-sm font-medium text-gray-500">Update Status</h4>
                                <div class="mt-2 flex items-center space-x-4">
                                    <select v-model="statusForm.status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="pending">Pending</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                    <button @click="updateStatus" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" :disabled="statusForm.processing">
                                        Update
                                    </button>
                                </div>
                                <p v-if="statusForm.errors.status" class="mt-2 text-sm text-red-600">{{ statusForm.errors.status }}</p>
                            </div>
                            
                            <!-- Process Refund Button -->
                            <div v-if="order.status === 'completed' && !order.refunded_at">
                                <h4 class="text-sm font-medium text-gray-500">Process Refund</h4>
                                <button @click="showRefundModal = true" class="mt-2 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Process Refund
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Refund Modal -->
        <div v-if="showRefundModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="bg-white rounded-lg w-full max-w-lg mx-4">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Process Refund</h3>
                    <p class="text-sm text-gray-600 mb-4">Are you sure you want to process a refund for this order? This action cannot be undone.</p>
                    
                    <div class="mb-4">
                        <label for="reason" class="block text-sm font-medium text-gray-700">Refund Reason</label>
                        <textarea id="reason" v-model="refundForm.reason" rows="3" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        <p v-if="refundForm.errors.reason" class="mt-2 text-sm text-red-600">{{ refundForm.errors.reason }}</p>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button @click="showRefundModal = false" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Cancel
                        </button>
                        <button @click="processRefund" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" :disabled="refundForm.processing">
                            Confirm Refund
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
