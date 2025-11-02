<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    product: Object,
    contents: Array
});

const showDeleteModal = ref(false);
const contentToDelete = ref(null);

const openDeleteModal = (content) => {
    contentToDelete.value = content;
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    contentToDelete.value = null;
    showDeleteModal.value = false;
};

const deleteContent = () => {
    router.delete(route('admin.products.content.destroy', {
        product: props.product.id,
        content: contentToDelete.value.id
    }), {
        onSuccess: () => {
            closeDeleteModal();
        }
    });
};

const getSectionTypeColor = (type) => {
    const colors = {
        introduction: 'bg-blue-100 text-blue-800',
        chapter: 'bg-green-100 text-green-800',
        section: 'bg-yellow-100 text-yellow-800',
        bonus: 'bg-purple-100 text-purple-800',
        conclusion: 'bg-gray-100 text-gray-800'
    };
    return colors[type] || 'bg-gray-100 text-gray-800';
};
</script>

<template>
    <Head :title="`Manage Content: ${product.name}`" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-white leading-tight">
                    Manage Content: {{ product.name }}
                </h2>
                <div class="flex gap-2">
                    <Link
                        :href="route('admin.products.content.create', product.id)"
                        class="px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-500 transition"
                    >
                        Add Chapter
                    </Link>
                    <Link
                        :href="route('admin.products.show', product.id)"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition"
                    >
                        Back to Product
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-200">
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-white mb-2">Content Structure</h3>
                            <p class="text-gray-400 text-sm">
                                Organize your product content into chapters and sections. Each chapter can contain multiple sections with text, images, and videos.
                            </p>
                        </div>

                        <div v-if="contents && contents.length > 0" class="space-y-6">
                            <div v-for="(content, index) in contents" :key="content.id" class="border border-gray-700 rounded-lg overflow-hidden">
                                <!-- Chapter Header -->
                                <div class="bg-gray-700 p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <span class="text-2xl font-bold text-orange-400">{{ index + 1 }}</span>
                                            <div>
                                                <h4 class="font-semibold text-white text-lg">{{ content.title }}</h4>
                                                <p v-if="content.description" class="text-gray-400 text-sm mt-1">{{ content.description }}</p>
                                                <div class="flex items-center gap-2 mt-2">
                                                    <span :class="['px-2 py-1 text-xs font-semibold rounded-full', getSectionTypeColor(content.section_type)]">
                                                        {{ content.section_type }}
                                                    </span>
                                                    <span v-if="content.duration_minutes" class="text-xs text-gray-400">
                                                        {{ content.duration_minutes }} min
                                                    </span>
                                                    <span :class="[
                                                        'px-2 py-1 text-xs font-semibold rounded-full',
                                                        content.is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
                                                    ]">
                                                        {{ content.is_published ? 'Published' : 'Draft' }}
                                                    </span>
                                                    <span class="text-xs text-gray-400">
                                                        {{ content.blocks?.length || 0 }} blocks
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <Link
                                                :href="route('admin.products.content.edit', { product: product.id, content: content.id })"
                                                class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition"
                                            >
                                                Edit
                                            </Link>
                                            <button
                                                @click="openDeleteModal(content)"
                                                class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Child Sections -->
                                <div v-if="content.children && content.children.length > 0" class="bg-gray-750 p-4">
                                    <div class="space-y-2">
                                        <div v-for="(child, childIndex) in content.children" :key="child.id" 
                                            class="flex items-center justify-between p-3 bg-gray-800 rounded border border-gray-600">
                                            <div class="flex items-center gap-3">
                                                <span class="text-sm font-semibold text-gray-400">{{ index + 1 }}.{{ childIndex + 1 }}</span>
                                                <div>
                                                    <p class="text-white">{{ child.title }}</p>
                                                    <p v-if="child.description" class="text-gray-400 text-xs mt-1">{{ child.description }}</p>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <span v-if="child.duration_minutes" class="text-xs text-gray-400">
                                                            {{ child.duration_minutes }} min
                                                        </span>
                                                        <span class="text-xs text-gray-400">
                                                            {{ child.blocks?.length || 0 }} blocks
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex gap-2">
                                                <Link
                                                    :href="route('admin.products.content.edit', { product: product.id, content: child.id })"
                                                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition"
                                                >
                                                    Edit
                                                </Link>
                                                <button
                                                    @click="openDeleteModal(child)"
                                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition"
                                                >
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add Section Button -->
                                <div class="bg-gray-750 px-4 pb-4">
                                    <Link
                                        :href="route('admin.products.content.create', { product: product.id, parent_id: content.id })"
                                        class="inline-flex items-center px-3 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-500 transition"
                                    >
                                        <span class="mr-1">+</span> Add Section to this Chapter
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <div v-else class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <svg class="mx-auto h-12 w-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-white mb-2">No content yet</h3>
                            <p class="text-gray-400 mb-4">Get started by creating your first chapter.</p>
                            <Link
                                :href="route('admin.products.content.create', product.id)"
                                class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-500 transition"
                            >
                                Create First Chapter
                            </Link>
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
                                <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                    Delete Content Section
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-300">
                                        Are you sure you want to delete "{{ contentToDelete?.title }}"? 
                                        <span v-if="contentToDelete?.children && contentToDelete.children.length > 0" class="text-red-400">
                                            This will also delete {{ contentToDelete.children.length }} child section(s).
                                        </span>
                                        This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <DangerButton @click="deleteContent" class="w-full sm:w-auto sm:ml-3">
                            Delete
                        </DangerButton>
                        <SecondaryButton @click="closeDeleteModal" class="mt-3 sm:mt-0 w-full sm:w-auto">
                            Cancel
                        </SecondaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>
.bg-gray-750 {
    background-color: #2d3748;
}
</style>
