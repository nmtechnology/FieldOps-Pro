<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    user: Object,
});

// Format date for display
const formatDate = (dateString) => {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
};

// Format role for display
const formatRole = (isAdmin) => {
    return isAdmin ? 'Administrator' : 'Customer';
};

</script>

<template>
    <Head title="User Details" />
    
    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-white">
                    User Details
                </h2>
                <Link :href="route('admin.users.index')" class="rounded-md bg-gray-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500">
                    Back to Users
                </Link>
            </div>
        </template>
        
        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <!-- User Profile -->
                <div class="overflow-hidden bg-gray-800 shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="mb-6 border-b border-gray-700 pb-6">
                            <div class="flex items-center">
                                <div class="h-20 w-20 flex-shrink-0">
                                    <img class="h-20 w-20 rounded-full" 
                                        :src="user.profile_photo_url || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name) + '&color=7F9CF5&background=EBF4FF'" 
                                        :alt="user.name">
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-2xl font-bold text-white">{{ user.name }}</h3>
                                    <div class="flex space-x-4">
                                        <span class="flex items-center text-sm text-gray-300">
                                            <span class="mr-2 h-2.5 w-2.5 rounded-full" :class="user.is_online ? 'bg-green-400' : 'bg-gray-400'" aria-hidden="true"></span>
                                            {{ user.is_online ? 'Online' : 'Offline' }}
                                        </span>
                                        <span class="text-sm text-gray-300">{{ formatRole(user.is_admin) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Information -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <h4 class="mb-4 text-lg font-medium text-white">Contact Information</h4>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-400">Email</p>
                                        <p class="text-white">{{ user.email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h4 class="mb-4 text-lg font-medium text-white">Account Details</h4>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-400">Registered On</p>
                                        <p class="text-white">{{ formatDate(user.created_at) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-400">Last Login</p>
                                        <p class="text-white">{{ user.last_login_at ? formatDate(user.last_login_at) : 'Never' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Orders -->
                <div class="overflow-hidden bg-gray-800 shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="mb-6 text-xl font-semibold text-white">Orders History</h3>
                        
                        <div v-if="user.orders && user.orders.length > 0" class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">Order #</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Product</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Date</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Amount</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Status</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700 bg-gray-800">
                                    <tr v-for="order in user.orders" :key="order.id" class="hover:bg-gray-700">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-white sm:pl-6">
                                            {{ order.order_number }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                            {{ order.product ? order.product.name : 'Unknown Product' }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                            {{ formatDate(order.created_at) }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                            ${{ order.amount ? order.amount.toFixed(2) : '0.00' }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                            <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5" 
                                                :class="{
                                                    'bg-green-100 text-green-800': order.status === 'completed',
                                                    'bg-yellow-100 text-yellow-800': order.status === 'pending',
                                                    'bg-red-100 text-red-800': order.status === 'failed' || order.status === 'cancelled',
                                                    'bg-indigo-100 text-indigo-800': order.status === 'refunded',
                                                }">
                                                {{ order.status.charAt(0).toUpperCase() + order.status.slice(1) }}
                                            </span>
                                        </td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <Link :href="route('admin.orders.show', order.id)" class="text-blue-400 hover:text-blue-300">
                                                View
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else class="rounded-md bg-gray-700 p-6 text-center">
                            <p class="text-gray-300">This user has no orders yet.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>