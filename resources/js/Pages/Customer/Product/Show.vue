<template>
    <Head :title="product.name" />

    <component :is="layoutComponent">
        <!-- Admin Preview Banner -->
        <div v-if="isAdminPreview" class="bg-yellow-600 text-yellow-50 px-4 py-3 mb-6">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Admin Preview Mode</span>
                    <span class="ml-2 text-yellow-100">You are viewing this product as a customer would see it</span>
                </div>
                <Link 
                    :href="`/admin/products/${product.id}`"
                    class="bg-yellow-700 hover:bg-yellow-800 px-3 py-1 rounded text-sm font-medium transition"
                >
                    Back to Admin
                </Link>
            </div>
        </div>

        <template #header v-if="!isAdminPreview">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ product.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Product Header -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                            <!-- Product Image -->
                            <div class="lg:col-span-1">
                                <div class="aspect-square w-full max-w-md mx-auto">
                                    <ProductImage 
                                        :product="product" 
                                        :alt="product.name"
                                        image-class="w-full h-full object-cover rounded-lg"
                                    />
                                </div>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="lg:col-span-2 text-white">
                                <h1 class="text-3xl font-bold mb-4">{{ product.name }}</h1>
                                <div class="text-gray-300 mb-6 text-lg leading-relaxed">
                                    {{ product.description }}
                                </div>
                                
                                <!-- Product Stats -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                    <div class="bg-gray-700 rounded-lg p-4 text-center">
                                        <div class="text-2xl font-bold text-green-400">${{ product.price }}</div>
                                        <div class="text-sm text-gray-400">Value</div>
                                    </div>
                                    <div class="bg-gray-700 rounded-lg p-4 text-center">
                                        <div class="text-2xl font-bold text-blue-400">{{ product.contents.length }}</div>
                                        <div class="text-sm text-gray-400">Sections</div>
                                    </div>
                                    <div class="bg-gray-700 rounded-lg p-4 text-center">
                                        <div class="text-2xl font-bold text-purple-400">{{ product.type }}</div>
                                        <div class="text-sm text-gray-400">Type</div>
                                    </div>
                                    <div class="bg-gray-700 rounded-lg p-4 text-center">
                                        <div class="text-2xl font-bold text-orange-400">∞</div>
                                        <div class="text-sm text-gray-400">Access</div>
                                    </div>
                                </div>
                                
                                <!-- Access Status -->
                                <div class="bg-green-900/50 border border-green-700 rounded-lg p-4 mb-6">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-green-100 font-medium">
                                            {{ isAdminPreview ? 'Admin Access' : 'Full Access Granted' }}
                                        </span>
                                    </div>
                                    <p class="text-green-200 text-sm mt-1">
                                        {{ isAdminPreview ? 'Previewing as admin - you have access to all content' : 'You have purchased this product and have lifetime access to all content' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Content Sections -->
                        <div class="border-t border-gray-700 pt-8">
                            <h2 class="text-2xl font-bold text-white mb-6">Content Sections</h2>
                            
                            <div v-if="product.contents.length === 0" class="text-center py-12 text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-lg font-medium mb-2">No Content Available</h3>
                                <p>This product doesn't have any content sections yet.</p>
                                <p v-if="isAdminPreview" class="mt-2 text-yellow-400">As an admin, you can add content sections in the admin panel.</p>
                            </div>

                            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <Link
                                    v-for="content in product.contents"
                                    :key="content.id"
                                    :href="`/my-products/${product.id}/content/${content.id}`"
                                    class="bg-gray-700 hover:bg-gray-600 rounded-lg p-6 transition-colors duration-200 group"
                                >
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="bg-indigo-600 rounded-lg p-3 group-hover:bg-indigo-500 transition-colors">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm text-gray-400 bg-gray-600 px-2 py-1 rounded">
                                            Section {{ content.section_order }}
                                        </span>
                                    </div>
                                    
                                    <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-indigo-200 transition-colors">
                                        {{ content.title }}
                                    </h3>
                                    
                                    <p class="text-gray-300 text-sm line-clamp-3 mb-4">
                                        {{ content.description || 'Click to view this content section' }}
                                    </p>
                                    
                                    <div class="flex items-center text-indigo-400 text-sm font-medium group-hover:text-indigo-300">
                                        View Content
                                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </component>
</template>

<script setup>
import { computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ProductImage from '@/Components/ProductImage.vue';

const props = defineProps({
    product: Object,
    isAdminPreview: Boolean,
    userHasPurchased: Boolean
});

// Use AdminLayout for admin preview, AuthenticatedLayout for regular users
const layoutComponent = computed(() => {
    return props.isAdminPreview ? AdminLayout : AuthenticatedLayout;
});
</script>

<style scoped>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>