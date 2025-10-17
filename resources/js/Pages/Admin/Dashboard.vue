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

// This would normally be passed from the controller
onMounted(() => {
    // Simulated stats
    stats.value = {
        totalOrders: 157,
        pendingOrders: 12,
        totalRevenue: 15842.50,
        activeUsers: 83
    };
});
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
                                    <dd class="mt-1 text-3xl font-semibold text-white">{{ stats.totalOrders }}</dd>
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
                                    <dd class="mt-1 text-3xl font-semibold text-white">{{ stats.pendingOrders }}</dd>
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
                                    <dd class="mt-1 text-3xl font-semibold text-white">${{ stats.totalRevenue.toLocaleString() }}</dd>
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
                                    <dd class="mt-1 text-3xl font-semibold text-white">{{ stats.activeUsers }}</dd>
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
                                                <!-- Sample order data -->
                                                <tr class="hover:bg-gray-700">
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">#10045</td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">John Smith</td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                        <span class="inline-flex items-center rounded-full bg-orange-600 px-2.5 py-0.5 text-xs font-medium text-white">Completed</span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">$238.50</td>
                                                </tr>
                                                <tr class="hover:bg-gray-700">
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">#10044</td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">Sarah Johnson</td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                        <span class="inline-flex items-center rounded-full bg-amber-600 px-2.5 py-0.5 text-xs font-medium text-white">Pending</span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">$129.99</td>
                                                </tr>
                                                <tr class="hover:bg-gray-700">
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">#10043</td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">Robert Williams</td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                        <span class="inline-flex items-center rounded-full bg-blue-600 px-2.5 py-0.5 text-xs font-medium text-white">Processing</span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">$427.00</td>
                                                </tr>
                                                <tr class="hover:bg-gray-700">
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">#10042</td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">Michael Brown</td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Completed</span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">$195.25</td>
                                                </tr>
                                                <tr class="hover:bg-gray-700">
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">#10041</td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">Jennifer Davis</td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">Cancelled</span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">$79.99</td>
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
                                                <!-- Sample user data -->
                                                <tr class="hover:bg-gray-700">
                                                    <td class="whitespace-nowrap px-6 py-4">
                                                        <div class="flex items-center">
                                                            <div class="h-8 w-8 flex-shrink-0">
                                                                <div class="relative h-8 w-8">
                                                                    <img class="rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                                                    <span class="absolute right-0 bottom-0 block h-2 w-2 rounded-full bg-green-400 ring-2 ring-gray-800"></span>
                                                                </div>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-white">John Smith</div>
                                                                <div class="text-sm text-gray-400">john@example.com</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                        <span class="inline-flex items-center rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-medium text-orange-800">Admin</span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">Just now</td>
                                                </tr>
                                                <tr class="hover:bg-gray-700">
                                                    <td class="whitespace-nowrap px-6 py-4">
                                                        <div class="flex items-center">
                                                            <div class="h-8 w-8 flex-shrink-0">
                                                                <div class="relative h-8 w-8">
                                                                    <img class="rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                                                    <span class="absolute right-0 bottom-0 block h-2 w-2 rounded-full bg-green-400 ring-2 ring-gray-800"></span>
                                                                </div>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-white">Sarah Johnson</div>
                                                                <div class="text-sm text-gray-400">sarah@example.com</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">Customer</span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">2 minutes ago</td>
                                                </tr>
                                                <tr class="hover:bg-gray-700">
                                                    <td class="whitespace-nowrap px-6 py-4">
                                                        <div class="flex items-center">
                                                            <div class="h-8 w-8 flex-shrink-0">
                                                                <div class="relative h-8 w-8">
                                                                    <img class="rounded-full" src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                                                    <span class="absolute right-0 bottom-0 block h-2 w-2 rounded-full bg-green-400 ring-2 ring-gray-800"></span>
                                                                </div>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-white">Robert Williams</div>
                                                                <div class="text-sm text-gray-400">robert@example.com</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">Customer</span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">5 minutes ago</td>
                                                </tr>
                                                <tr class="hover:bg-gray-700">
                                                    <td class="whitespace-nowrap px-6 py-4">
                                                        <div class="flex items-center">
                                                            <div class="h-8 w-8 flex-shrink-0">
                                                                <div class="relative h-8 w-8">
                                                                    <img class="rounded-full" src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                                                    <span class="absolute right-0 bottom-0 block h-2 w-2 rounded-full bg-green-400 ring-2 ring-gray-800"></span>
                                                                </div>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-white">Michael Brown</div>
                                                                <div class="text-sm text-gray-400">michael@example.com</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">Customer</span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">8 minutes ago</td>
                                                </tr>
                                                <tr class="hover:bg-gray-700">
                                                    <td class="whitespace-nowrap px-6 py-4">
                                                        <div class="flex items-center">
                                                            <div class="h-8 w-8 flex-shrink-0">
                                                                <div class="relative h-8 w-8">
                                                                    <img class="rounded-full" src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                                                                    <span class="absolute right-0 bottom-0 block h-2 w-2 rounded-full bg-green-400 ring-2 ring-gray-800"></span>
                                                                </div>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-white">Jennifer Davis</div>
                                                                <div class="text-sm text-gray-400">jennifer@example.com</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                        <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">Customer</span>
                                                    </td>
                                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-white">12 minutes ago</td>
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