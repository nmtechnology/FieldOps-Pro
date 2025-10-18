<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    order: Object,
});

const showRefundModal = ref(false);
const refundForm = useForm({
    amount: props.order.amount || 0,
    reason: '',
});

const updateStatus = (status) => {
    // Use Inertia to update the order status
    useForm().put(route('admin.orders.update-status', props.order.id), {
        status: status
    });
};

const processRefund = () => {
    refundForm.post(route('admin.orders.refund', props.order.id), {
        onSuccess: () => {
            showRefundModal.value = false;
            refundForm.reset();
        },
    });
};

const toggleRefundModal = () => {
    showRefundModal.value = !showRefundModal.value;
};

// Format date helper function
const formatDate = (dateString) => {
    if (!dateString) return '';
    const options = { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

// Get status badge class
const getStatusClass = (status) => {
    switch (status) {
        case 'pending':
            return 'bg-yellow-100 text-yellow-800';
        case 'processing':
            return 'bg-blue-100 text-blue-800';
        case 'completed':
            return 'bg-green-100 text-green-800';
        case 'cancelled':
            return 'bg-gray-100 text-gray-800';
        case 'refunded':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};
</script>

<template>
    <Head :title="`Order #${order.id} Details`" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-white">
                    Order #{{ order.id }} Details
                </h2>
                <span :class="[getStatusClass(order.status), 'inline-flex items-center rounded-full px-3 py-1 text-sm font-medium']">
                    {{ order.status.charAt(0).toUpperCase() + order.status.slice(1) }}
                </span>
            </div>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6 flex gap-4">
                    <button 
                        v-if="['pending', 'processing'].includes(order.status)"
                        @click="updateStatus('completed')"
                        class="inline-flex items-center rounded bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                    >
                        Mark as Completed
                    </button>
                    <button 
                        v-if="['pending', 'processing'].includes(order.status)"
                        @click="updateStatus('cancelled')"
                        class="inline-flex items-center rounded bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                    >
                        Cancel Order
                    </button>
                    <button 
                        v-if="order.status !== 'refunded' && order.status !== 'cancelled'"
                        @click="toggleRefundModal"
                        class="inline-flex items-center rounded bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                    >
                        Process Refund
                    </button>
                </div>

                <!-- Order details grid -->
                <div class="overflow-hidden bg-gray-800 shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Customer Information -->
                            <div class="rounded-lg bg-gray-700 p-6">
                                <h3 class="text-lg font-medium text-white">Customer Information</h3>
                                <div class="mt-4 space-y-2 text-sm">
                                    <div>
                                        <p class="font-medium text-gray-300">Name</p>
                                        <p class="text-white">{{ order.customer_name }}</p>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-300">Email</p>
                                        <p class="text-white">{{ order.customer_email }}</p>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-300">Phone</p>
                                        <p class="text-white">{{ order.customer_phone || 'Not provided' }}</p>
                                    </div>
                                    <div class="pt-4">
                                        <button 
                                            class="inline-flex items-center rounded border border-orange-400 bg-transparent px-3 py-2 text-xs font-medium text-orange-400 hover:bg-orange-400 hover:text-white"
                                            @click="$inertia.visit(route('admin.users.edit', order.user_id))"
                                        >
                                            Edit Customer Profile
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Summary -->
                            <div class="rounded-lg bg-gray-700 p-6">
                                <h3 class="text-lg font-medium text-white">Order Summary</h3>
                                <div class="mt-4 space-y-2 text-sm">
                                    <div>
                                        <p class="font-medium text-gray-300">Order Date</p>
                                        <p class="text-white">{{ formatDate(order.created_at) }}</p>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-300">Payment Method</p>
                                        <p class="text-white">{{ order.payment_method }}</p>
                                    </div>
                                    <div v-if="order.payment_id">
                                        <p class="font-medium text-gray-300">Payment ID</p>
                                        <p class="text-white">{{ order.payment_id }}</p>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-300">Total Amount</p>
                                        <p class="text-xl font-bold text-white">${{ order.amount ? order.amount.toFixed(2) : '0.00' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div class="rounded-lg bg-gray-700 p-6">
                                <h3 class="text-lg font-medium text-white">Address</h3>
                                <div class="mt-4 space-y-2 text-sm">
                                    <div>
                                        <p class="font-medium text-gray-300">Service Location</p>
                                        <p class="text-white">{{ order.address_line1 }}</p>
                                        <p v-if="order.address_line2" class="text-white">{{ order.address_line2 }}</p>
                                        <p class="text-white">{{ order.city }}, {{ order.state }} {{ order.postal_code }}</p>
                                        <p class="text-white">{{ order.country }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Status History -->
                            <div class="rounded-lg bg-gray-700 p-6">
                                <h3 class="text-lg font-medium text-white">Status History</h3>
                                <div class="mt-4 space-y-4">
                                    <div v-for="(statusUpdate, index) in order.status_history" :key="index" class="flex gap-3">
                                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-500">
                                            <div class="h-2.5 w-2.5 rounded-full bg-white"></div>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-sm font-medium text-white">{{ statusUpdate.status.charAt(0).toUpperCase() + statusUpdate.status.slice(1) }}</p>
                                            <p class="text-xs text-gray-400">{{ formatDate(statusUpdate.timestamp) }}</p>
                                            <p v-if="statusUpdate.note" class="text-xs text-gray-300">{{ statusUpdate.note }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-white">Order Items</h3>
                            <div class="mt-4 overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-700">
                                    <thead class="bg-gray-700">
                                        <tr>
                                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">Item</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Quantity</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Price</th>
                                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-700 bg-gray-800">
                                        <tr v-for="item in order.items" :key="item.id">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-6">
                                                {{ item.name }}
                                                <p v-if="item.description" class="mt-1 text-xs text-gray-400">{{ item.description }}</p>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">{{ item.quantity }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">${{ item.price.toFixed(2) }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-white">${{ (item.price * item.quantity).toFixed(2) }}</td>
                                        </tr>
                                        <!-- Subtotal row -->
                                        <tr class="bg-gray-900">
                                            <td colspan="3" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-right text-white sm:pl-6">Subtotal</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-white">${{ (order.amount && order.discount_amount ? (parseFloat(order.amount) + parseFloat(order.discount_amount)).toFixed(2) : order.amount ? order.amount.toFixed(2) : '0.00') }}</td>
                                        </tr>
                                        <!-- Tax row -->
                                        <tr class="bg-gray-900">
                                            <td colspan="3" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-right text-white sm:pl-6">Tax</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-white">$0.00</td>
                                        </tr>
                                        <!-- Discount row if applicable -->
                                        <tr v-if="order.discount_amount > 0" class="bg-gray-900">
                                            <td colspan="3" class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-right text-white sm:pl-6">Discount</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-green-400">-${{ order.discount_amount.toFixed(2) }}</td>
                                        </tr>
                                        <!-- Total row -->
                                        <tr class="bg-gray-900">
                                            <td colspan="3" class="whitespace-nowrap py-4 pl-4 pr-3 text-base font-bold text-right text-white sm:pl-6">Total</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-base font-bold text-white">${{ order.amount ? order.amount.toFixed(2) : '0.00' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Admin Notes Section -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-white">Admin Notes</h3>
                            <div class="mt-2">
                                <textarea rows="3" class="block w-full rounded-md border-0 bg-gray-700 py-1.5 text-white shadow-sm placeholder:text-gray-400 focus:ring-2 focus:ring-orange-500 sm:text-sm sm:leading-6" placeholder="Add notes about this order...">{{ order.admin_notes }}</textarea>
                                <div class="mt-2 flex justify-end">
                                    <button type="button" class="inline-flex items-center rounded bg-orange-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">
                                        Save Notes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Refund Modal -->
        <div v-if="showRefundModal" class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <!-- Modal panel -->
                <div class="inline-block transform overflow-hidden rounded-lg bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                    <form @submit.prevent="processRefund">
                        <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 w-full text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg font-medium leading-6 text-white" id="modal-title">Process Refund</h3>
                                    <div class="mt-4 space-y-4">
                                        <div>
                                            <label for="amount" class="block text-sm font-medium text-gray-300">Refund Amount</label>
                                            <div class="mt-1">
                                                <input type="number" step="0.01" name="amount" id="amount" v-model="refundForm.amount" class="block w-full rounded-md border-0 bg-gray-700 py-1.5 text-white shadow-sm placeholder:text-gray-400 focus:ring-2 focus:ring-orange-500 sm:text-sm sm:leading-6" />
                                            </div>
                                            <p class="mt-1 text-xs text-gray-400">Maximum amount: ${{ order.amount ? order.amount.toFixed(2) : '0.00' }}</p>
                                        </div>
                                        <div>
                                            <label for="reason" class="block text-sm font-medium text-gray-300">Reason for Refund</label>
                                            <div class="mt-1">
                                                <textarea name="reason" id="reason" rows="3" v-model="refundForm.reason" class="block w-full rounded-md border-0 bg-gray-700 py-1.5 text-white shadow-sm placeholder:text-gray-400 focus:ring-2 focus:ring-orange-500 sm:text-sm sm:leading-6" placeholder="Provide reason for the refund"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-700 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="submit" class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Process Refund</button>
                            <button type="button" @click="toggleRefundModal" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-500 bg-gray-800 px-4 py-2 text-base font-medium text-gray-300 shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>