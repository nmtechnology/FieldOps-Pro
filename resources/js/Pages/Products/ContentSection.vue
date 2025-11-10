<template>
    <AppLayout :title="content.title">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ content.title }}
                </h2>
                <Link :href="route('products.toc', product.id)" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                    Back to Table of Contents
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Navigation Links -->
                <div class="flex justify-between mb-4 px-4 sm:px-0">
                    <div>
                        <Link v-if="prevSection" :href="route('products.content.show', { productId: product.id, slug: prevSection.slug })" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 inline-flex items-center">
                            <svg class="mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ prevSection.title }}
                        </Link>
                    </div>
                    <div>
                        <Link v-if="nextSection" :href="route('products.content.show', { productId: product.id, slug: nextSection.slug })" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 inline-flex items-center">
                            {{ nextSection.title }}
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </Link>
                    </div>
                </div>
                
                <div class="bg-gray-900 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- Content Header -->
                    <div class="p-6 bg-blue-50 dark:bg-blue-900 border-b border-gray-200 dark:border-gray-700">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ content.title }}</h1>
                        <div class="mt-2 flex">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200">
                                {{ getSectionTypeName(content.section_type) }}
                            </span>
                            <span v-if="content.is_premium" class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200">
                                Premium Content
                            </span>
                        </div>
                    </div>
                    
                    <!-- Main Content -->
                    <div class="p-6 bg-gray-900 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                        <!-- Content is rendered as HTML -->
                        <div class="prose dark:prose-invert max-w-none" v-html="content.content"></div>
                        
                        <!-- Content Blocks -->
                        <div v-if="content.blocks && content.blocks.length > 0" class="mt-8 space-y-6">
                            <div v-for="block in content.blocks" :key="block.id">
                                <!-- Heading Block -->
                                <h3 v-if="block.block_type === 'heading'" 
                                    class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                    {{ block.content }}
                                </h3>
                                
                                <!-- Text Block -->
                                <div v-else-if="block.block_type === 'text'" 
                                     class="prose dark:prose-invert max-w-none"
                                     v-html="block.content">
                                </div>
                                
                                <!-- Image Block -->
                                <div v-else-if="block.block_type === 'image'" class="my-6">
                                    <img :src="block.media_url" :alt="block.content || 'Content image'" class="rounded-lg shadow-lg w-full">
                                    <p v-if="block.content" class="text-sm text-gray-600 dark:text-gray-400 mt-2 text-center">{{ block.content }}</p>
                                </div>
                                
                                <!-- Video Block -->
                                <div v-else-if="block.block_type === 'video'" class="my-6">
                                    <video controls class="rounded-lg shadow-lg w-full">
                                        <source :src="block.media_url" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <p v-if="block.content" class="text-sm text-gray-600 dark:text-gray-400 mt-2 text-center">{{ block.content }}</p>
                                </div>
                                
                                <!-- Tutorial Block -->
                                <div v-else-if="block.block_type === 'tutorial'" class="my-8 bg-gradient-to-r from-purple-900 to-indigo-900 rounded-xl shadow-2xl p-8 border-2 border-purple-500">
                                    <div class="flex items-center mb-4">
                                        <div class="text-5xl mr-4">🎓</div>
                                        <div class="flex-1">
                                            <h3 class="text-2xl font-bold text-white mb-2">Interactive Tutorial</h3>
                                            <p class="text-purple-200 text-lg">{{ block.content || 'Field Technician Training' }}</p>
                                        </div>
                                    </div>
                                    <p class="text-purple-100 mb-6">
                                        Complete this hands-on training module to master the skills. Features interactive slides, knowledge checks, and earn a certificate upon completion!
                                    </p>
                                    <Link 
                                        :href="`/tutorial/${product.id}?tutorial=${encodeURIComponent(block.content || 'Field Technician Training')}`"
                                        class="inline-flex items-center px-6 py-3 bg-white text-purple-900 font-bold rounded-lg shadow-lg hover:bg-purple-100 transform hover:scale-105 transition-all duration-200"
                                    >
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Start Tutorial
                                    </Link>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Media Section if available -->
                        <div v-if="content.media && content.media.length > 0" class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Media Resources</h3>
                            
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                <div v-for="(media, index) in content.media" :key="index" class="relative rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-500">
                                    <div class="flex-shrink-0">
                                        <img v-if="media.type === 'image'" :src="media.url" :alt="media.caption || 'Media content'" class="h-10 w-10 rounded-full">
                                        <svg v-else class="h-10 w-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <a :href="media.url" target="_blank" class="focus:outline-none">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            <p class="text-sm font-medium text-gray-900">{{ media.title || 'Media Resource' }}</p>
                                            <p class="text-sm text-gray-500 truncate">{{ media.caption || 'Click to view' }}</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Downloads Section if available -->
                        <div v-if="content.downloads && content.downloads.length > 0" class="mt-8 border-t border-gray-200 pt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Downloads</h3>
                            
                            <ul class="divide-y divide-gray-200">
                                <li v-for="(download, index) in content.downloads" :key="index" class="py-4 flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ download.name }}</p>
                                        <p class="text-sm text-gray-500">{{ download.description || 'Downloadable resource' }}</p>
                                    </div>
                                    <div class="ml-auto">
                                        <a :href="route('products.download', { productId: product.id, contentId: content.id, fileIndex: index })" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Download
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Navigation Footer -->
                    <div class="p-6 bg-gray-50 dark:bg-gray-700 flex items-center justify-between">
                        <div>
                            <Link v-if="prevSection" :href="route('products.content.show', { productId: product.id, slug: prevSection.slug })" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Previous
                            </Link>
                        </div>
                        
                        <Link :href="route('products.toc', product.id)" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Table of Contents
                        </Link>
                        
                        <div>
                            <Link v-if="nextSection" :href="route('products.content.show', { productId: product.id, slug: nextSection.slug })" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Next
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </Link>
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
import { Link } from '@inertiajs/vue3';

export default defineComponent({
    components: {
        AppLayout,
        Link
    },
    props: {
        product: Object,
        content: Object,
        nextSection: Object,
        prevSection: Object
    },
    methods: {
        getSectionTypeName(sectionType) {
            switch (sectionType) {
                case 'introduction':
                    return 'Introduction';
                case 'chapter':
                    return 'Chapter';
                case 'bonus':
                    return 'Bonus Content';
                case 'conclusion':
                    return 'Conclusion';
                case 'appendix':
                    return 'Appendix';
                default:
                    return 'Section';
            }
        }
    }
});
</script>