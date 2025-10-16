<template>
    <AppLayout :title="product.name + ' - Table of Contents'">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ product.name }} - Table of Contents
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Product Information Header -->
                    <div class="p-6 bg-blue-50 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0" v-if="product.image_path">
                                <img :src="product.image_path" alt="Product image" class="h-24 w-auto rounded-md">
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-bold text-gray-900">{{ product.name }}</h2>
                                <p class="mt-1 text-gray-600">{{ product.description }}</p>
                            </div>
                        </div>
                        
                        <div v-if="!hasPurchased" class="mt-6 bg-yellow-50 border border-yellow-100 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Premium Content Notice</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Some sections of this content are only available after purchase. Purchase this product to access all premium content.</p>
                                    </div>
                                    <div class="mt-4">
                                        <Link :href="route('checkout', product.id)" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Purchase for ${{ product.price.toFixed(2) }}
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table of Contents -->
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Table of Contents</h3>
                        
                        <ul class="divide-y divide-gray-200">
                            <li v-for="content in contents" :key="content.id" class="py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="flex-shrink-0 h-6 w-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-800 text-xs font-medium">
                                            {{ getSectionIcon(content.section_type) }}
                                        </span>
                                        <span class="ml-3 text-sm font-medium text-gray-900">
                                            {{ content.title }}
                                        </span>
                                        <span v-if="content.is_premium && !hasPurchased" class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Premium
                                        </span>
                                    </div>
                                    
                                    <div>
                                        <template v-if="content.is_premium && !hasPurchased">
                                            <span class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-gray-700 bg-gray-100">
                                                Locked
                                                <svg class="ml-1 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </template>
                                        <template v-else>
                                            <Link :href="route('products.content.show', { productId: product.id, slug: content.slug })" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200">
                                                Read
                                                <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                </svg>
                                            </Link>
                                        </template>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Downloads Section -->
                    <div v-if="hasPurchased" class="p-6 bg-gray-50">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Downloads</h3>
                        
                        <div class="bg-white shadow overflow-hidden sm:rounded-md">
                            <ul role="list" class="divide-y divide-gray-200">
                                <li>
                                    <Link :href="route('products.downloads', product.id)" class="block hover:bg-gray-50">
                                        <div class="px-4 py-4 sm:px-6">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    <p class="ml-3 text-sm font-medium text-blue-600 truncate">View All Downloadable Resources</p>
                                                </div>
                                                <div class="ml-2 flex-shrink-0 flex">
                                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { defineComponent } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        AppLayout,
        Link
    },
    props: {
        product: Object,
        contents: Array,
        hasPurchased: Boolean
    },
    methods: {
        getSectionIcon(sectionType) {
            switch (sectionType) {
                case 'introduction':
                    return '👋';
                case 'chapter':
                    return '📝';
                case 'bonus':
                    return '🎁';
                case 'conclusion':
                    return '✅';
                case 'appendix':
                    return '📚';
                default:
                    return '📄';
            }
        }
    }
});
</script>