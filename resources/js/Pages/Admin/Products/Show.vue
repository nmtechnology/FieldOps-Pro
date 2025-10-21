<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ProductImage from '@/Components/ProductImage.vue';
import { ref } from 'vue';

const props = defineProps({
    product: Object
});

const showDeleteModal = ref(false);

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(amount);
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString();
};

const openDeleteModal = () => {
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
};

const deleteProduct = () => {
    router.delete(`/admin/products/${props.product.id}`, {
        onSuccess: () => {
            router.visit('/admin/products');
        }
    });
};
</script>

<template>
    <Head :title="`Product: ${product.name}`" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-white leading-tight">
                    Product Details: {{ product.name }}
                </h2>
                <div class="flex gap-2">
                    <Link
                        :href="`/admin/products/${product.id}/preview`"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition"
                    >
                        Preview as Customer
                    </Link>
                    <Link
                        :href="`/admin/products/${product.id}/edit`"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
                    >
                        Edit Product
                    </Link>
                    <button
                        @click="openDeleteModal"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
                        :disabled="product.orders_count > 0"
                        :class="{'opacity-50 cursor-not-allowed': product.orders_count > 0}"
                        :title="product.orders_count > 0 ? 'Cannot delete product with existing orders' : 'Delete product'"
                    >
                        Delete Product
                    </button>
                    <Link
                        href="/admin/products"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition"
                    >
                        Back to Products
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Details -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4 text-white">Basic Information</h3>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-400">ID</p>
                                        <p class="text-white">{{ product.id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-400">Name</p>
                                        <p class="text-white">{{ product.name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-400">Price</p>
                                        <p class="text-white">{{ formatCurrency(product.price) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-400">Status</p>
                                        <p>
                                            <span 
                                                :class="[
                                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                    product.active 
                                                        ? 'bg-green-100 text-green-800' 
                                                        : 'bg-gray-100 text-gray-800'
                                                ]"
                                            >
                                                {{ product.active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-400">Tier</p>
                                        <p class="capitalize text-white">{{ product.tier || 'Standard' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-400">Total Orders</p>
                                        <p class="text-white">{{ product.orders_count }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-400">Created</p>
                                        <p class="text-white">{{ formatDate(product.created_at) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-400">Last Updated</p>
                                        <p class="text-white">{{ formatDate(product.updated_at) }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Product Image and Description -->
                            <div>
                                <div class="mb-4">
                                    <h3 class="text-lg font-semibold mb-2 text-white">Product Image</h3>
                                    <div class="max-w-sm mx-auto">
                                        <ProductImage 
                                            :product="product" 
                                            :alt="product.name"
                                            image-class="w-full h-64 object-cover rounded-lg shadow-lg"
                                        />
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-2 text-white">Description</h3>
                                    <p class="text-gray-300 whitespace-pre-line">{{ product.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Contents -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <h3 class="text-lg font-semibold mb-4 text-white">Product Contents</h3>
                        
                        <div v-if="product.contents && product.contents.length > 0" class="space-y-6">
                            <div v-for="content in product.contents" :key="content.id" class="border-b border-gray-700 pb-4 last:border-b-0">
                                <h4 class="font-medium mb-2 text-white">{{ content.title }}</h4>
                                <div class="flex items-center mb-2">
                                    <span 
                                        :class="[
                                            'px-2 mr-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                            content.is_published 
                                                ? 'bg-green-100 text-green-800' 
                                                : 'bg-yellow-100 text-yellow-800'
                                        ]"
                                    >
                                        {{ content.is_published ? 'Published' : 'Draft' }}
                                    </span>
                                    <span class="text-sm text-gray-400">
                                        Section {{ content.section_order }}
                                    </span>
                                </div>
                                <p class="text-gray-300 whitespace-pre-line">{{ content.content }}</p>
                            </div>
                        </div>
                        
                        <div v-else class="text-gray-400 italic">
                            No content sections have been added to this product yet.
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
                                    Delete Product
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-300">
                                        Are you sure you want to delete "{{ product.name }}"? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="deleteProduct" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
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