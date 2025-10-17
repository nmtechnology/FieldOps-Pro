<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
    product: Object
});

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(amount);
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString();
};
</script>

<template>
    <Head :title="`Product: ${product.name}`" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Product Details: {{ product.name }}
                </h2>
                <div class="flex gap-2">
                    <Link
                        :href="`/admin/products/${product.id}/edit`"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
                    >
                        Edit Product
                    </Link>
                    <Link
                        href="/admin/products"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition"
                    >
                        Back to Products
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Details -->
                            <div>
                                <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">ID</p>
                                        <p>{{ product.id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Name</p>
                                        <p>{{ product.name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Price</p>
                                        <p>{{ formatCurrency(product.price) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Status</p>
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
                                        <p class="text-sm font-medium text-gray-500">Tier</p>
                                        <p class="capitalize">{{ product.tier || 'Standard' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Total Orders</p>
                                        <p>{{ product.orders_count }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Created</p>
                                        <p>{{ formatDate(product.created_at) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Last Updated</p>
                                        <p>{{ formatDate(product.updated_at) }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Product Image and Description -->
                            <div>
                                <div v-if="product.image_url" class="mb-4">
                                    <img :src="product.image_url" :alt="product.name" class="rounded-lg max-h-64 mx-auto">
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                                    <p class="text-gray-700 whitespace-pre-line">{{ product.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Contents -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Product Contents</h3>
                        
                        <div v-if="product.contents && product.contents.length > 0" class="space-y-6">
                            <div v-for="content in product.contents" :key="content.id" class="border-b pb-4 last:border-b-0">
                                <h4 class="font-medium mb-2">{{ content.title }}</h4>
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
                                    <span class="text-sm text-gray-500">
                                        Section {{ content.section_order }}
                                    </span>
                                </div>
                                <p class="text-gray-700 whitespace-pre-line">{{ content.content }}</p>
                            </div>
                        </div>
                        
                        <div v-else class="text-gray-500 italic">
                            No content sections have been added to this product yet.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>