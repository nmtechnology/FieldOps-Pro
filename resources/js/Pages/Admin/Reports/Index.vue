<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, onMounted } from 'vue';
import Chart from 'chart.js/auto';

const props = defineProps({
    salesData: Object,
    revenueData: Object,
    topProducts: Array,
    monthlySummary: Object,
});

const monthlySalesChart = ref(null);
const revenueChart = ref(null);
const topProductsChart = ref(null);

onMounted(() => {
    // Monthly Sales Chart
    if (props.salesData && monthlySalesChart.value) {
        const salesCtx = monthlySalesChart.value.getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: props.salesData.labels || [],
                datasets: [{
                    label: 'Sales Count',
                    data: props.salesData.values || [],
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 2,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Monthly Sales'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Revenue Chart
    if (props.revenueData && revenueChart.value) {
        const revenueCtx = revenueChart.value.getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: props.revenueData.labels || [],
                datasets: [{
                    label: 'Monthly Revenue',
                    data: props.revenueData.values || [],
                    backgroundColor: 'rgba(34, 197, 94, 0.5)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Monthly Revenue'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Include a dollar sign in the ticks
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    // Top Products Chart
    if (props.topProducts && props.topProducts.length > 0 && topProductsChart.value) {
        const productsCtx = topProductsChart.value.getContext('2d');
        new Chart(productsCtx, {
            type: 'doughnut',
            data: {
                labels: props.topProducts.map(product => product.name) || [],
                datasets: [{
                    data: props.topProducts.map(product => product.sales_count) || [],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Top Selling Products'
                    }
                }
            }
        });
    }
});

const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(value);
};
</script>

<template>
    <Head title="Admin Reports" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports & Analytics</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm font-medium text-gray-500 mb-1">Total Sales (Month)</div>
                        <div class="text-2xl font-bold">{{ monthlySummary?.sales_count || 0 }}</div>
                        <div class="text-xs text-gray-500 mt-1">
                            <span :class="monthlySummary?.sales_trend > 0 ? 'text-green-600' : 'text-red-600'">
                                {{ monthlySummary?.sales_trend > 0 ? '↑' : '↓' }} {{ Math.abs(monthlySummary?.sales_trend || 0) }}%
                            </span>
                            vs last month
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm font-medium text-gray-500 mb-1">Revenue (Month)</div>
                        <div class="text-2xl font-bold">{{ formatCurrency(monthlySummary?.revenue || 0) }}</div>
                        <div class="text-xs text-gray-500 mt-1">
                            <span :class="monthlySummary?.revenue_trend > 0 ? 'text-green-600' : 'text-red-600'">
                                {{ monthlySummary?.revenue_trend > 0 ? '↑' : '↓' }} {{ Math.abs(monthlySummary?.revenue_trend || 0) }}%
                            </span>
                            vs last month
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm font-medium text-gray-500 mb-1">Avg. Order Value</div>
                        <div class="text-2xl font-bold">{{ formatCurrency(monthlySummary?.avg_order_value || 0) }}</div>
                        <div class="text-xs text-gray-500 mt-1">
                            <span :class="monthlySummary?.aov_trend > 0 ? 'text-green-600' : 'text-red-600'">
                                {{ monthlySummary?.aov_trend > 0 ? '↑' : '↓' }} {{ Math.abs(monthlySummary?.aov_trend || 0) }}%
                            </span>
                            vs last month
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="text-sm font-medium text-gray-500 mb-1">Discount Usage</div>
                        <div class="text-2xl font-bold">{{ monthlySummary?.discount_usage || 0 }}</div>
                        <div class="text-xs text-gray-500 mt-1">
                            <span :class="monthlySummary?.discount_trend > 0 ? 'text-green-600' : 'text-red-600'">
                                {{ monthlySummary?.discount_trend > 0 ? '↑' : '↓' }} {{ Math.abs(monthlySummary?.discount_trend || 0) }}%
                            </span>
                            vs last month
                        </div>
                    </div>
                </div>

                <!-- Charts Row 1 -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Sales Trend</h3>
                        <div class="h-64">
                            <canvas ref="monthlySalesChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Revenue Trend</h3>
                        <div class="h-64">
                            <canvas ref="revenueChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Charts Row 2 -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 lg:col-span-1">
                        <h3 class="text-lg font-semibold mb-4">Top Products</h3>
                        <div class="h-64">
                            <canvas ref="topProductsChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 lg:col-span-2">
                        <h3 class="text-lg font-semibold mb-4">Top Selling Products</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sales</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg. Price</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(product, index) in topProducts" :key="index" class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ product.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ product.sales_count }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatCurrency(product.revenue) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatCurrency(product.avg_price) }}</td>
                                    </tr>
                                    <tr v-if="!topProducts || topProducts.length === 0">
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No data available</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>