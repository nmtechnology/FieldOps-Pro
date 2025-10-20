<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    user: Object,
});

const showDeleteModal = ref(false);

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

const openDeleteModal = () => {
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
};

const deleteUser = () => {
    router.delete(route('admin.users.destroy', props.user.id), {
        onSuccess: () => {
            router.visit(route('admin.users.index'));
        }
    });
};

const toggleAdminStatus = () => {
    router.post(route('admin.users.toggle-admin', props.user.id));
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
                <div class="flex gap-2">
                    <Link :href="route('admin.users.edit', user.id)" class="rounded-md bg-blue-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">
                        Edit User
                    </Link>
                    <button 
                        @click="toggleAdminStatus"
                        :class="[
                            'rounded-md px-3.5 py-2 text-sm font-semibold text-white shadow-sm',
                            user.is_admin ? 'bg-yellow-600 hover:bg-yellow-500' : 'bg-indigo-600 hover:bg-indigo-500'
                        ]"
                    >
                        {{ user.is_admin ? 'Remove Admin' : 'Make Admin' }}
                    </button>
                    <button 
                        @click="openDeleteModal"
                        class="rounded-md bg-red-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500"
                        :disabled="user.orders && user.orders.length > 0"
                        :class="{'opacity-50 cursor-not-allowed': user.orders && user.orders.length > 0}"
                        :title="user.orders && user.orders.length > 0 ? 'Cannot delete user with existing orders' : 'Delete user'"
                    >
                        Delete User
                    </button>
                    <Link :href="route('admin.users.index')" class="rounded-md bg-gray-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500">
                        Back to Users
                    </Link>
                </div>
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
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700 bg-gray-800">
                                    <tr v-for="order in user.orders" :key="order.id" 
                                        @click="$inertia.visit(route('admin.orders.show', order.id))"
                                        class="hover:bg-gray-700 cursor-pointer transition-colors duration-150">
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

        <!-- Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeDeleteModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                    Delete User
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-300">
                                        Are you sure you want to delete "{{ user.name }}"? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="deleteUser" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                        <button @click="closeDeleteModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>