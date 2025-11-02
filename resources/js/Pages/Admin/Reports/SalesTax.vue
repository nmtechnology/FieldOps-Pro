<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    taxByState: Array,
    totals: Object,
    monthlyTax: Array,
    recentOrders: Array,
    startDate: String,
    endDate: String
});

const startDate = ref(props.startDate);
const endDate = ref(props.endDate);

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(amount);
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString();
};

const updateReport = () => {
    router.get(route('admin.reports.sales-tax'), {
        start_date: startDate.value,
        end_date: endDate.value
    }, {
        preserveState: true,
    });
};

const exportReport = () => {
    window.location.href = route('admin.reports.sales-tax.export', {
        start_date: startDate.value,
        end_date: endDate.value
    });
};
</script>

<template>
    <Head title="Sales Tax Report" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-white leading-tight">Sales Tax Report</h2>
                <div class="flex gap-2">
                    <button
                        @click="exportReport"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition"
                    >
                        Export to CSV
                    </button>
                    <Link
                        href="/admin/reports"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition"
                    >
                        All Reports
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Date Range Filter -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <div class="flex flex-wrap items-end gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-300 mb-1">
                                    Start Date
                                </label>
                                <input
                                    id="start_date"
                                    type="date"
                                    v-model="startDate"
                                    class="border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                />
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-300 mb-1">
                                    End Date
                                </label>
                                <input
                                    id="end_date"
                                    type="date"
                                    v-model="endDate"
                                    class="border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                />
                            </div>
                            <button
                                @click="updateReport"
                                class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-500 transition"
                            >
                                Update Report
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-400">Total Tax Collected</div>
                            <div class="mt-2 text-3xl font-bold text-green-400">
                                {{ formatCurrency(totals?.total_tax || 0) }}
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-400">Total Sales (Pre-Tax)</div>
                            <div class="mt-2 text-3xl font-bold text-white">
                                {{ formatCurrency(totals?.total_sales || 0) }}
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-400">Taxable Orders</div>
                            <div class="mt-2 text-3xl font-bold text-white">
                                {{ totals?.total_orders || 0 }}
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="text-sm font-medium text-gray-400">Grand Total</div>
                            <div class="mt-2 text-3xl font-bold text-orange-400">
                                {{ formatCurrency(totals?.grand_total || 0) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tax by State -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <h3 class="text-lg font-semibold text-white mb-4">Tax Collected by State</h3>
                        
                        <div v-if="taxByState && taxByState.length > 0" class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            State
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Orders
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Sales (Pre-Tax)
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Avg Tax Rate
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Tax Collected
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-800 divide-y divide-gray-700">
                                    <tr v-for="item in taxByState" :key="item.buyer_state" class="hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                                            {{ item.state_name }} ({{ item.buyer_state }})
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ item.order_count }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ formatCurrency(item.total_sales) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ item.avg_tax_rate_formatted }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-400">
                                            {{ formatCurrency(item.total_tax) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div v-else class="text-center py-8 text-gray-400">
                            No taxable sales found for the selected date range.
                        </div>
                    </div>
                </div>

                <!-- Recent Taxable Orders -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <h3 class="text-lg font-semibold text-white mb-4">Recent Taxable Orders</h3>
                        
                        <div v-if="recentOrders && recentOrders.length > 0" class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Order #
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Customer
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            State
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Subtotal
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Tax Rate
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Tax
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                                            Total
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-gray-800 divide-y divide-gray-700">
                                    <tr v-for="order in recentOrders" :key="order.id" class="hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-orange-400">
                                            <Link :href="`/admin/orders/${order.id}`" class="hover:text-orange-300">
                                                {{ order.order_number }}
                                            </Link>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ formatDate(order.created_at) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ order.user?.name || order.email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ order.buyer_state }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ formatCurrency(order.subtotal) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                            {{ order.tax_rate_formatted }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-400">
                                            {{ formatCurrency(order.tax_amount) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-white">
                                            {{ formatCurrency(order.amount) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div v-else class="text-center py-8 text-gray-400">
                            No recent taxable orders.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
