<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    orders: {
        type: Object,
        required: true
    }
});

// Status badge colors
const statusColors = {
    pending: 'bg-yellow-100 text-yellow-800',
    completed: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800',
    refunded: 'bg-purple-100 text-purple-800'
};
</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Order ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Customer
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Product
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Amount
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-if="orders.data.length === 0">
                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                        No orders found
                    </td>
                </tr>
                <tr v-for="order in orders.data" :key="order.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">
                            #{{ order.id }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ order.user.name }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ order.user.email }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ order.product.name }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ order.product.tier }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            ${{ order.amount.toFixed(2) }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span :class="[
                            'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                            statusColors[order.status] || 'bg-gray-100 text-gray-800'
                        ]">
                            {{ order.status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            {{ new Date(order.created_at).toLocaleDateString() }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ new Date(order.created_at).toLocaleTimeString() }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <Link :href="route('admin.orders.show', order.id)" class="text-indigo-600 hover:text-indigo-900 mr-2">
                            View
                        </Link>
                        <Link v-if="order.status === 'pending'" 
                              :href="route('admin.orders.edit', order.id)" 
                              class="text-blue-600 hover:text-blue-900 mr-2">
                            Edit
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
