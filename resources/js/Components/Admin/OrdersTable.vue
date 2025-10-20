<script setup>
import { Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    orders: {
        type: [Object, Array],
        required: true
    },
    activeTab: {
        type: String,
        default: 'all'
    }
});

// Status badge colors
const statusColors = {
    pending: 'bg-yellow-100 text-yellow-800',
    completed: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800',
    refunded: 'bg-purple-100 text-purple-800'
};

// Handle row click to navigate to order details
const viewOrder = (orderId) => {
    router.visit(route('admin.orders.show', orderId));
};
</script>

<template>
    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-700">
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">
                        Order ID
                    </th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                        Customer
                    </th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                        Product
                    </th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                        Amount
                    </th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                        Status
                    </th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">
                        Date
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700 bg-gray-800">
                <tr v-if="!orders || (Array.isArray(orders) ? orders.length === 0 : (orders.data && orders.data.length === 0))">
                    <td colspan="6" class="py-10 text-center text-gray-400">
                        No orders found
                    </td>
                </tr>
                <tr v-for="(order, index) in (Array.isArray(orders) ? orders : (orders.data || []))" 
                    :key="order.id" 
                    @click="viewOrder(order.id)"
                    class="hover:bg-gray-700 cursor-pointer transition-colors duration-150 ease-in-out">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                        <div class="font-medium text-white">
                            #{{ order.id }}
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                        <div class="text-white">
                            {{ order.user.name }}
                        </div>
                        <div class="text-gray-400">
                            {{ order.user.email }}
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                        <div class="text-white">
                            {{ order.product.name }}
                        </div>
                        <div class="text-gray-400">
                            {{ order.product.tier }}
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                        <div class="font-medium">
                            ${{ order.amount.toFixed(2) }}
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                        <span :class="[
                            'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                            statusColors[order.status] || 'bg-gray-100 text-gray-800'
                        ]">
                            {{ order.status }}
                        </span>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300 relative">
                        <div>
                            {{ new Date(order.created_at).toLocaleDateString() }}
                        </div>
                        <div class="text-gray-400">
                            {{ new Date(order.created_at).toLocaleTimeString() }}
                        </div>
                        <!-- Edit button for pending orders, positioned to avoid interfering with row click -->
                        <Link v-if="order.status === 'pending'" 
                              :href="route('admin.orders.edit', order.id)" 
                              @click.stop
                              class="absolute top-2 right-2 text-xs text-orange-400 hover:text-orange-300 bg-gray-700 hover:bg-gray-600 px-2 py-1 rounded transition-colors duration-150">
                            Edit
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
