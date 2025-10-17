<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import OrdersTable from '@/Components/Admin/OrdersTable.vue';

const props = defineProps({
    orders: Object,
    filters: Object,
});

const activeTab = ref('all');

function setTab(tab) {
    activeTab.value = tab;
}
</script>

<template>
    <Head title="Admin Orders" />

    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-white">
                Orders Management
            </h2>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-gray-800 shadow-xl sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <!-- Order Status Filter Tabs -->
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
                                    All Orders
                                </button>
                                <button 
                                    @click="setTab('active')" 
                                    :class="{ 
                                        'border-orange-500 text-orange-500': activeTab === 'active',
                                        'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300': activeTab !== 'active' 
                                    }" 
                                    class="inline-block p-4 border-b-2 font-medium"
                                >
                                    Active
                                </button>
                                <button 
                                    @click="setTab('processing')" 
                                    :class="{ 
                                        'border-orange-500 text-orange-500': activeTab === 'processing',
                                        'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300': activeTab !== 'processing' 
                                    }" 
                                    class="inline-block p-4 border-b-2 font-medium"
                                >
                                    Processing
                                </button>
                                <button 
                                    @click="setTab('completed')" 
                                    :class="{ 
                                        'border-orange-500 text-orange-500': activeTab === 'completed',
                                        'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300': activeTab !== 'completed' 
                                    }" 
                                    class="inline-block p-4 border-b-2 font-medium"
                                >
                                    Completed
                                </button>
                                <button 
                                    @click="setTab('cancelled')" 
                                    :class="{ 
                                        'border-orange-500 text-orange-500': activeTab === 'cancelled',
                                        'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300': activeTab !== 'cancelled' 
                                    }" 
                                    class="inline-block p-4 border-b-2 font-medium"
                                >
                                    Cancelled
                                </button>
                                <button 
                                    @click="setTab('refunded')" 
                                    :class="{ 
                                        'border-orange-500 text-orange-500': activeTab === 'refunded',
                                        'border-transparent text-gray-400 hover:text-gray-300 hover:border-gray-300': activeTab !== 'refunded' 
                                    }" 
                                    class="inline-block p-4 border-b-2 font-medium"
                                >
                                    Refunded
                                </button>
                            </div>
                        </div>

                        <!-- Search and Filter Controls -->
                        <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                            <div class="w-full md:w-1/3">
                                <label for="search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" id="search" class="block w-full rounded-md border-0 bg-gray-700 py-1.5 pl-10 pr-3 text-white placeholder:text-gray-400 focus:ring-2 focus:ring-orange-500 sm:text-sm sm:leading-6" placeholder="Search orders..." />
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <button type="button" class="inline-flex items-center rounded bg-orange-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">
                                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M2 3.75A.75.75 0 012.75 3h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 3.75zm0 4.167a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75zm0 4.166a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75zm0 4.167a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
                                    </svg>
                                    Export Orders
                                </button>
                                <button type="button" class="inline-flex items-center rounded border border-gray-600 bg-gray-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
                                    </svg>
                                    Filter
                                </button>
                            </div>
                        </div>

                        <!-- Orders Table -->
                        <OrdersTable :orders="orders" :activeTab="activeTab" />

                        <!-- Pagination -->
                        <div class="mt-6 flex items-center justify-between border-t border-gray-700 pt-4">
                            <div class="flex flex-1 justify-between sm:hidden">
                                <a href="#" class="relative inline-flex items-center rounded-md border border-gray-700 bg-gray-800 px-4 py-2 text-sm font-medium text-gray-400 hover:bg-gray-700">Previous</a>
                                <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-700 bg-gray-800 px-4 py-2 text-sm font-medium text-gray-400 hover:bg-gray-700">Next</a>
                            </div>
                            <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-400">
                                        Showing <span class="font-medium">{{ (orders.current_page - 1) * orders.per_page + 1 }}</span> to <span class="font-medium">{{ Math.min(orders.current_page * orders.per_page, orders.total) }}</span> of <span class="font-medium">{{ orders.total }}</span> results
                                    </p>
                                </div>
                                <div>
                                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                                        <a href="#" :class="{ 'opacity-50 cursor-not-allowed': orders.current_page === 1 }" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-700 hover:bg-gray-700 focus:z-20 focus:outline-offset-0">
                                            <span class="sr-only">Previous</span>
                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                        <!-- Page numbers would be dynamically generated -->
                                        <span v-for="i in Math.min(5, orders.last_page)" :key="i" 
                                            :class="{ 'bg-orange-500 text-white': i === orders.current_page, 'text-gray-400 hover:bg-gray-700': i !== orders.current_page }"
                                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold ring-1 ring-inset ring-gray-700 focus:z-20 focus:outline-offset-0">
                                            {{ i }}
                                        </span>
                                        <a href="#" :class="{ 'opacity-50 cursor-not-allowed': orders.current_page === orders.last_page }" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-700 hover:bg-gray-700 focus:z-20 focus:outline-offset-0">
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