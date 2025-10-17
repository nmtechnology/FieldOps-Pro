<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    users: Object
});

// Form for toggling admin status
const toggleAdminForm = useForm({});

// Toggle admin status for a user
const toggleAdmin = (userId) => {
    toggleAdminForm.post(route('admin.users.toggle-admin', userId), {
        preserveScroll: true,
        onSuccess: () => {
            // Success notification handled by global flash message
        }
    });
};
</script>

<template>
    <Head title="Users Management" />

    <AdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-white">
                    Users Management
                </h2>
                <Link :href="route('admin.users.create')" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Add New User
                </Link>
            </div>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Users Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            User
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Joined
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Role
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-if="users.data.length === 0">
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No users found
                                        </td>
                                    </tr>
                                    <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0 bg-gray-200 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-medium">{{ user.name.charAt(0).toUpperCase() }}</span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ user.name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ user.email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="user.is_online ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                                {{ user.is_online ? 'Online' : 'Offline' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ new Date(user.created_at).toLocaleDateString() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full" :class="user.is_admin ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'">
                                                {{ user.is_admin ? 'Admin' : 'Customer' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <Link :href="route('admin.users.show', user.id)" class="text-indigo-600 hover:text-indigo-900 mr-2">
                                                View
                                            </Link>
                                            <Link :href="route('admin.users.edit', user.id)" class="text-blue-600 hover:text-blue-900 mr-2">
                                                Edit
                                            </Link>
                                            <Link :href="route('admin.users.orders', user.id)" class="text-green-600 hover:text-green-900 mr-2">
                                                Orders
                                            </Link>
                                            <button @click="toggleAdmin(user.id)" 
                                                  :class="[
                                                    'text-purple-600 hover:text-purple-900',
                                                    { 'opacity-50 cursor-not-allowed': user.id === $page.props.auth.user.id }
                                                  ]"
                                                  :disabled="user.id === $page.props.auth.user.id">
                                                {{ user.is_admin ? 'Remove Admin' : 'Make Admin' }}
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 flex justify-between sm:hidden">
                                    <Link :href="users.prev_page_url" 
                                          class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                          :class="{ 'opacity-50 cursor-not-allowed': !users.prev_page_url }">
                                        Previous
                                    </Link>
                                    <Link :href="users.next_page_url" 
                                          class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                          :class="{ 'opacity-50 cursor-not-allowed': !users.next_page_url }">
                                        Next
                                    </Link>
                                </div>
                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            Showing
                                            <span class="font-medium">{{ users.from }}</span>
                                            to
                                            <span class="font-medium">{{ users.to }}</span>
                                            of
                                            <span class="font-medium">{{ users.total }}</span>
                                            results
                                        </p>
                                    </div>
                                    <div>
                                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                            <Link v-for="link in users.links" :key="link.url" 
                                                  :href="link.url"
                                                  class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                                                  :class="[
                                                      link.active ? 'bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                                                      link.url === null ? 'opacity-50 cursor-not-allowed' : ''
                                                  ]"
                                                  v-html="link.label">
                                            </Link>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
