<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const stats = ref({
    totalOrders: 0,
    pendingOrders: 0,
    totalRevenue: 0,
    activeUsers: 0
});

const recentOrders = ref([]);
const onlineUsers = ref([]);

// Fetch real stats from the backend
onMounted(async () => {
    try {
        const response = await fetch('/admin/api/stats');
        if (response.ok) {
            const data = await response.json();
            stats.value = data.stats;
            recentOrders.value = data.recentOrders || [];
            onlineUsers.value = data.onlineUsers || [];
        }
    } catch (error) {
        console.error('Failed to fetch stats:', error);
        // Default to zeros on error
        stats.value = {
            totalOrders: 0,
            pendingOrders: 0,
            totalRevenue: 0,
            activeUsers: 0
        };
        recentOrders.value = [];
        onlineUsers.value = [];
    }
});

const getStatusColor = (status) => {
    const colors = {
        'completed': 'bg-green-600 text-white',
        'pending': 'bg-amber-600 text-white',
        'processing': 'bg-blue-600 text-white',
        'refunded': 'bg-gray-600 text-white'
    };
    return colors[status] || 'bg-gray-600 text-white';
};

const formatTime = (timestamp) => {
    if (!timestamp) return 'Never';
    const date = new Date(timestamp);
    const now = new Date();
    const diff = Math.floor((now - date) / 1000); // seconds
    
    if (diff < 60) return 'Just now';
    if (diff < 3600) return `${Math.floor(diff / 60)} minutes ago`;
    if (diff < 86400) return `${Math.floor(diff / 3600)} hours ago`;
    return `${Math.floor(diff / 86400)} days ago`;
};
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-white">
                Admin Dashboard
            </h2>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Stats Cards -->
                <div class="mb-6 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Total Orders -->
                    <div class="overflow-hidden rounded-lg bg-gradient-to-br from-gray-700 to-gray-900 shadow">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 rounded-md bg-orange-600 p-3">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dt class="truncate text-sm font-medium text-gray-300">Total Orders</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-white">{{ stats?.totalOrders || 0 }}</dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Orders -->
                    <div class="overflow-hidden rounded-lg bg-gradient-to-br from-gray-700 to-gray-900 shadow">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 rounded-md bg-orange-600 p-3">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dt class="truncate text-sm font-medium text-gray-300">Pending Orders</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-white">{{ stats?.pendingOrders || 0 }}</dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Revenue -->
                    <div class="overflow-hidden rounded-lg bg-gradient-to-br from-gray-700 to-gray-900 shadow">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 rounded-md bg-orange-600 p-3">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dt class="truncate text-sm font-medium text-gray-300">Total Revenue</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-white">${{ (stats?.totalRevenue || 0).toLocaleString() }}</dd>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Active Users -->
                    <div class="overflow-hidden rounded-lg bg-gradient-to-br from-gray-700 to-gray-900 shadow">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 rounded-md bg-orange-600 p-3">
                                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dt class="truncate text-sm font-medium text-gray-300">Active Users</dt>
                                    <dd class="mt-1 text-3xl font-semibold text-white">{{ stats?.activeUsers || 0 }}</dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Recent Orders -->
                    <div class="overflow-hidden bg-gray-800 shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg font-medium leading-6 text-white">Recent Orders</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-400">Latest customer orders across the platform.</p>
                        </div>
                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                    <div class="overflow-hidden border-b border-gray-700">
                                        <table class="min-w-full divide-y divide-gray-700">
                                            <thead class="bg-gray-700">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Order ID</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Customer</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Status</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-700 bg-gray-800">
                                                <tr v-if="recentOrders.length === 0">
                                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400">
                                                        No orders yet. Your first order will appear here!
                                                    </td>
                                                </tr>
                                                <tr v-for="order in recentOrders" :key="order.id" class="hover:bg-gray-700">
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">#{{ order.order_number }}</td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">{{ order.user_name }}</td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                        <span :class="getStatusColor(order.status)" class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize">
                                                            {{ order.status }}
                                                        </span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">${{ parseFloat(order.amount).toFixed(2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-700 px-4 py-3 text-right sm:px-6">
                            <a href="/admin/orders" class="inline-flex items-center rounded-md border border-transparent bg-orange-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-700">
                                View All Orders
                            </a>
                        </div>
                    </div>

                    <!-- Online Users -->
                    <div class="overflow-hidden bg-gray-800 shadow sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg font-medium leading-6 text-white">Online Users</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-400">Users currently active on the platform.</p>
                        </div>
                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                    <div class="overflow-hidden border-b border-gray-700">
                                        <table class="min-w-full divide-y divide-gray-700">
                                            <thead class="bg-gray-700">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">User</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Role</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-300">Last Activity</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-700 bg-gray-800">
                                                <tr v-if="onlineUsers.length === 0">
                                                    <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-400">
                                                        No users online currently.
                                                    </td>
                                                </tr>
                                                <tr v-for="user in onlineUsers" :key="user.id" class="hover:bg-gray-700">
                                                    <td class="whitespace-nowrap px-6 py-4">
                                                        <div class="flex items-center">
                                                            <div class="h-8 w-8 flex-shrink-0">
                                                                <div class="relative h-8 w-8 bg-gray-600 rounded-full flex items-center justify-center">
                                                                    <span class="text-white text-xs font-medium">{{ user.name.charAt(0).toUpperCase() }}</span>
                                                                    <span v-if="user.is_online" class="absolute right-0 bottom-0 block h-2 w-2 rounded-full bg-green-400 ring-2 ring-gray-800"></span>
                                                                </div>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-white">{{ user.name }}</div>
                                                                <div class="text-sm text-gray-400">{{ user.email }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                        <span :class="user.is_admin ? 'bg-orange-600 text-white' : 'bg-blue-600 text-white'" class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
                                                            {{ user.is_admin ? 'Admin' : 'Customer' }}
                                                        </span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">{{ formatTime(user.last_login_at) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-700 px-4 py-3 text-right sm:px-6">
                            <a href="/admin/users" class="inline-flex items-center rounded-md border border-transparent bg-orange-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-orange-700">
                                View All Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>