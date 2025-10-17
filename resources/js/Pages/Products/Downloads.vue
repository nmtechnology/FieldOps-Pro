<template>
    <AppLayout :title="product.name + ' - Downloads'">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ product.name }} - Downloads
                </h2>
                <Link :href="route('products.toc', product.id)" class="text-sm text-blue-600 hover:text-blue-800">
                    Back to Table of Contents
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Header -->
                    <div class="p-6 bg-blue-50 border-b border-gray-200">
                        <h1 class="text-2xl font-bold text-gray-900">Downloadable Resources</h1>
                        <p class="mt-2 text-gray-600">Access all downloadable files for {{ product.name }}</p>
                    </div>
                    
                    <!-- Downloads List -->
                    <div class="p-6 bg-gray-900">
                        <div v-if="downloadables.length === 0" class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No downloadable resources</h3>
                            <p class="mt-1 text-sm text-gray-500">This product does not have any downloadable resources yet.</p>
                        </div>
                        
                        <div v-else>
                            <div v-for="content in downloadables" :key="content.id" class="mb-10">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ content.title }}</h3>
                                
                                <ul class="divide-y divide-gray-200 border border-gray-200 rounded-md">
                                    <li v-for="(download, index) in content.downloads" :key="index" class="px-6 py-4 flex items-center">
                                        <div class="flex-1">
                                            <div class="flex items-center">
                                                <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                <span class="ml-2 text-sm font-medium text-gray-900">{{ download.name }}</span>
                                                <span class="ml-2 text-xs text-gray-500">{{ formatFileSize(download.size) }}</span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">{{ download.description || 'Downloadable resource' }}</p>
                                        </div>
                                        
                                        <div class="ml-4">
                                            <a :href="route('products.download', { productId: product.id, contentId: content.id, fileIndex: index })" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Download
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Back Navigation -->
                <div class="mt-6 flex justify-center">
                    <Link :href="route('products.toc', product.id)" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Back to Table of Contents
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { defineComponent } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

export default defineComponent({
    components: {
        AppLayout,
        Link
    },
    props: {
        product: Object,
        downloadables: Array
    },
    methods: {
        formatFileSize(bytes) {
            if (!bytes) return '';
            
            const units = ['bytes', 'KB', 'MB', 'GB', 'TB'];
            let i = 0;
            
            while (bytes >= 1024 && i < 4) {
                bytes /= 1024;
                i++;
            }
            
            return `${bytes.toFixed(2)} ${units[i]}`;
        }
    }
});
</script>