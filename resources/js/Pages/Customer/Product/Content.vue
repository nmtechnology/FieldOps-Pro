<template>
    <Head :title="`${content.title} - ${product.name}`" />

    <component :is="layoutComponent">
        <!-- Admin Preview Banner -->
        <div v-if="isAdminPreview" class="bg-yellow-600 text-yellow-50 px-4 py-3 mb-6">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Admin Preview Mode</span>
                    <span class="ml-2 text-yellow-100">Viewing content as customer would see it</span>
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
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-white leading-tight">
                    {{ content.title }}
                </h2>
                <Link 
                    :href="`/my-products/${product.id}`"
                    class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded text-sm font-medium transition"
                >
                    Back to {{ product.name }}
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Content Navigation -->
                <div class="bg-gray-800 rounded-lg mb-6 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Previous Content -->
                            <Link
                                v-if="previousContent"
                                :href="getContentUrl(previousContent)"
                                class="flex items-center text-gray-300 hover:text-white transition-colors"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                </svg>
                                Previous
                            </Link>
                            
                            <!-- Content Progress -->
                            <div class="text-center">
                                <div class="text-sm text-gray-400">Section {{ content.section_order }} of {{ allContent.length }}</div>
                                <div class="w-32 bg-gray-700 rounded-full h-2 mt-1">
                                    <div 
                                        class="bg-indigo-600 h-2 rounded-full transition-all duration-300"
                                        :style="{ width: `${(content.section_order / allContent.length) * 100}%` }"
                                    ></div>
                                </div>
                            </div>
                            
                            <!-- Next Content -->
                            <Link
                                v-if="nextContent"
                                :href="getContentUrl(nextContent)"
                                class="flex items-center text-gray-300 hover:text-white transition-colors"
                            >
                                Next
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </Link>
                        </div>
                        
                        <!-- Back to Product -->
                        <Link 
                            :href="getProductUrl()"
                            class="bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded text-sm font-medium text-white transition"
                        >
                            Back to {{ product.name }}
                        </Link>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8">
                        <!-- Content Header -->
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    Section {{ content.section_order }}
                                </span>
                                <span v-if="!content.is_published && isAdminPreview" class="bg-yellow-600 text-white px-3 py-1 rounded-full text-sm font-medium ml-2">
                                    Draft
                                </span>
                            </div>
                            <h1 class="text-4xl font-bold text-white mb-4">{{ content.title }}</h1>
                            <p v-if="content.description" class="text-xl text-gray-300 leading-relaxed">
                                {{ content.description }}
                            </p>
                        </div>

                        <!-- Content Body -->
                        <div class="prose prose-lg prose-invert max-w-none">
                            <div v-if="content.content" v-html="content.content" class="text-gray-200 leading-relaxed"></div>
                            <div v-else class="text-center py-12 text-gray-400">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="text-xl font-medium mb-2">No Content Available</h3>
                                <p>This section doesn't have any content yet.</p>
                                <p v-if="isAdminPreview" class="mt-2 text-yellow-400">As an admin, you can add content to this section in the admin panel.</p>
                            </div>
                        </div>

                        <!-- Content Sections (if JSON structured content) -->
                        <div v-if="contentSections && contentSections.length > 0" class="mt-12">
                            <h2 class="text-2xl font-bold text-white mb-6">Sections</h2>
                            <div class="space-y-8">
                                <div v-for="(section, index) in contentSections" :key="index" class="bg-gray-700 rounded-lg p-6">
                                    <h3 v-if="section.title" class="text-xl font-semibold text-white mb-4">{{ section.title }}</h3>
                                    <div v-if="section.content" class="text-gray-200 leading-relaxed" v-html="section.content"></div>
                                    
                                    <!-- Files/Downloads if any -->
                                    <div v-if="section.files && section.files.length > 0" class="mt-4">
                                        <h4 class="text-lg font-medium text-white mb-2">Downloads</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <a 
                                                v-for="(file, fileIndex) in section.files" 
                                                :key="fileIndex"
                                                :href="file.url || '#'"
                                                class="flex items-center p-3 bg-gray-600 hover:bg-gray-500 rounded-lg transition-colors"
                                                :download="file.name"
                                            >
                                                <svg class="w-6 h-6 text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <div>
                                                    <div class="text-white font-medium">{{ file.name }}</div>
                                                    <div class="text-gray-400 text-sm">{{ file.type || 'Download' }}</div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Footer -->
                        <div class="mt-12 pt-8 border-t border-gray-700">
                            <div class="flex justify-between items-center">
                                <Link
                                    v-if="previousContent"
                                    :href="getContentUrl(previousContent)"
                                    class="flex items-center bg-gray-700 hover:bg-gray-600 px-6 py-3 rounded-lg text-white transition-colors"
                                >
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    <div>
                                        <div class="text-sm text-gray-300">Previous</div>
                                        <div class="font-medium">{{ previousContent.title }}</div>
                                    </div>
                                </Link>
                                
                                <div v-else class="w-1"></div>
                                
                                <Link
                                    v-if="nextContent"
                                    :href="getContentUrl(nextContent)"
                                    class="flex items-center bg-indigo-600 hover:bg-indigo-700 px-6 py-3 rounded-lg text-white transition-colors"
                                >
                                    <div class="text-right">
                                        <div class="text-sm text-indigo-200">Next</div>
                                        <div class="font-medium">{{ nextContent.title }}</div>
                                    </div>
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </Link>
                                
                                <div v-else class="w-1"></div>
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

const props = defineProps({
    product: Object,
    content: Object,
    allContent: Array,
    isAdminPreview: Boolean
});

// Use AdminLayout for admin preview, AuthenticatedLayout for regular users
const layoutComponent = computed(() => {
    return props.isAdminPreview ? AdminLayout : AuthenticatedLayout;
});

// Parse content sections if they exist
const contentSections = computed(() => {
    if (props.content.content_sections) {
        try {
            return Array.isArray(props.content.content_sections) 
                ? props.content.content_sections 
                : JSON.parse(props.content.content_sections);
        } catch (e) {
            console.warn('Failed to parse content sections:', e);
            return [];
        }
    }
    return [];
});

// Find previous and next content
const currentIndex = computed(() => {
    return props.allContent.findIndex(c => c.id === props.content.id);
});

const previousContent = computed(() => {
    return currentIndex.value > 0 ? props.allContent[currentIndex.value - 1] : null;
});

const nextContent = computed(() => {
    return currentIndex.value < props.allContent.length - 1 ? props.allContent[currentIndex.value + 1] : null;
});

// Helper functions
const getContentUrl = (content) => {
    return props.isAdminPreview 
        ? `/admin/products/${props.product.id}/preview/content/${content.id}`
        : `/my-products/${props.product.id}/content/${content.id}`;
};

const getProductUrl = () => {
    return props.isAdminPreview 
        ? `/admin/products/${props.product.id}/preview`
        : `/my-products/${props.product.id}`;
};
</script>

<style scoped>
/* Custom styles for content display */
.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
    color: white;
}

.prose p, .prose li {
    color: #d1d5db;
}

.prose a {
    color: #818cf8;
}

.prose a:hover {
    color: #a5b4fc;
}

.prose blockquote {
    border-left-color: #4f46e5;
    color: #d1d5db;
}

.prose code {
    background-color: #374151;
    color: #f3f4f6;
    padding: 0.125rem 0.25rem;
    border-radius: 0.25rem;
}

.prose pre {
    background-color: #1f2937;
    color: #f3f4f6;
}
</style>