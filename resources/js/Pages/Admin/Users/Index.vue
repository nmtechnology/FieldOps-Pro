<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    users: Object,
    filters: Object,
});

const activeTab = ref('all');

function setTab(tab) {
    activeTab.value = tab;
}

// Function to calculate time ago
function timeAgo(timestamp) {
    if (!timestamp) return 'Never';
    
    const now = new Date();
    const past = new Date(timestamp);
    const diffInSeconds = Math.floor((now - past) / 1000);
    
    if (diffInSeconds < 60) return `${diffInSeconds} seconds ago`;
    if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)} minutes ago`;
    if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)} hours ago`;
    if (diffInSeconds < 604800) return `${Math.floor(diffInSeconds / 86400)} days ago`;
    if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 604800)} weeks ago`;
    if (diffInSeconds < 31536000) return `${Math.floor(diffInSeconds / 2592000)} months ago`;
    return `${Math.floor(diffInSeconds / 31536000)} years ago`;
}
</script>

<template>
    <Head title="Users Management" />

    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-white">
                Users Management
            </h2>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-gray-800 shadow-xl sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <!-- User Status Filter Tabs -->
                        <div class="mb-6 border-b border-gray-700">
                            <div class="flex flex-wrap -mb-px">
                                <button 
                                    @click="setTab('all')" 
                                    :class="{ 
                                        'border-orange-500 text-orange-500': activeTab === 'all',
                                        'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300': activeTab !== 'all' 
                                    }" 
                                    class="inline-block p-4 border-b-2 font-medium"
                                >
                                    All Users
                                </button>
                                <button 
                                    @click="setTab('online')" 
                                    :class="{ 
                                        'border-orange-500 text-orange-500': activeTab === 'online',
                                        'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300': activeTab !== 'online' 
                                    }" 
                                    class="inline-block p-4 border-b-2 font-medium"
                                >
                                    Online
                                </button>
                                <button 
                                    @click="setTab('offline')" 
                                    :class="{ 
                                        'border-orange-500 text-orange-500': activeTab === 'offline',
                                        'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300': activeTab !== 'offline' 
                                    }" 
                                    class="inline-block p-4 border-b-2 font-medium"
                                >
                                    Offline
                                </button>
                                <button 
                                    @click="setTab('admins')" 
                                    :class="{ 
                                        'border-orange-500 text-orange-500': activeTab === 'admins',
                                        'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300': activeTab !== 'admins' 
                                    }" 
                                    class="inline-block p-4 border-b-2 font-medium"
                                >
                                    Admins
                                </button>
                                <button 
                                    @click="setTab('inactive')" 
                                    :class="{ 
                                        'border-orange-500 text-orange-500': activeTab === 'inactive',
                                        'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300': activeTab !== 'inactive' 
                                    }" 
                                    class="inline-block p-4 border-b-2 font-medium"
                                >
                                    Inactive
                                </button>
                            </div>
                        </div>

                        <!-- Search and Filter Controls -->
                        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                            <div class="w-full md:w-1/3">
                                <label for="search" class="sr-only">Search Users</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" id="search" class="block w-full rounded-md border-0 bg-gray-700 py-1.5 pl-10 pr-3 text-white placeholder:text-gray-400 focus:ring-2 focus:ring-orange-500 sm:text-sm sm:leading-6" placeholder="Search users..." />
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <Link :href="route('admin.users.create')" class="inline-flex items-center rounded bg-orange-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">
                                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                    </svg>
                                    Add New User
                                </Link>
                                <button type="button" class="inline-flex items-center rounded border border-gray-600 bg-gray-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
                                    </svg>
                                    Filter
                                </button>
                                <button type="button" class="inline-flex items-center rounded border border-gray-600 bg-gray-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
                                    </svg>
                                    Export Users
                                </button>
                            </div>
                        </div>

                        <!-- Users Table -->
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-700">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">User</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Role</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Status</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Last Login</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Registered</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Orders</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700 bg-gray-800">
                                    <tr v-if="users.data.length === 0">
                                        <td colspan="6" class="py-10 text-center text-gray-400">
                                            No users found matching the selected filter.
                                        </td>
                                    </tr>
                                    <tr v-for="user in users.data" :key="user.id" 
                                        @click="$inertia.visit(route('admin.users.show', user.id))"
                                        class="hover:bg-gray-700 cursor-pointer transition-colors duration-150">
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img class="h-10 w-10 rounded-full" :src="user.profile_photo_url || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(user.name) + '&color=7F9CF5&background=EBF4FF'" :alt="user.name">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-white">{{ user.name }}</div>
                                                    <div class="text-gray-400">{{ user.email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                            <span class="inline-flex items-center rounded bg-orange-100 px-2 py-0.5 text-xs font-medium text-orange-800" v-if="user.is_admin">
                                                Admin
                                            </span>
                                            <span class="inline-flex items-center rounded bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800" v-else>
                                                Customer
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm">
                                            <span class="flex items-center">
                                                <span class="h-2.5 w-2.5 rounded-full" :class="user.is_online ? 'bg-green-400' : 'bg-gray-400'" aria-hidden="true"></span>
                                                <span class="ml-2 text-gray-300">{{ user.is_online ? 'Online' : 'Offline' }}</span>
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                            {{ user.last_login_at ? timeAgo(user.last_login_at) : 'Never' }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                            {{ new Date(user.created_at).toLocaleDateString() }}
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-300">
                                            {{ user.orders_count || 0 }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6 flex items-center justify-between border-t border-gray-700 pt-4">
                            <div class="flex flex-1 justify-between sm:hidden">
                                <a href="#" class="relative inline-flex items-center rounded-md border border-gray-700 bg-gray-800 px-4 py-2 text-sm font-medium text-gray-400 hover:bg-gray-700">Previous</a>
                                <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-700 bg-gray-800 px-4 py-2 text-sm font-medium text-gray-400 hover:bg-gray-700">Next</a>
                            </div>
                            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-400">
                                        Showing <span class="font-medium">{{ (users.current_page - 1) * users.per_page + 1 }}</span> to <span class="font-medium">{{ Math.min(users.current_page * users.per_page, users.total) }}</span> of <span class="font-medium">{{ users.total }}</span> users
                                    </p>
                                </div>
                                <div>
                                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                        <a href="#" :class="{ 'opacity-50 cursor-not-allowed': users.current_page === 1 }" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-700 hover:bg-gray-700 focus:z-20 focus:outline-offset-0">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <!-- Page numbers would be dynamically generated -->
                                        <span v-for="i in Math.min(5, users.last_page)" :key="i" 
                                            :class="{ 'bg-orange-500 text-white': i === users.current_page, 'text-gray-400 hover:bg-gray-700': i !== users.current_page }"
                                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold ring-1 ring-inset ring-gray-700 focus:z-20 focus:outline-offset-0">
                                            {{ i }}
                                        </span>
                                        <a href="#" :class="{ 'opacity-50 cursor-not-allowed': users.current_page === users.last_page }" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-700 hover:bg-gray-700 focus:z-20 focus:outline-offset-0">
                                            <span class="sr-only">Next</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>