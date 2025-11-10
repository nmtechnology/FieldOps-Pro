<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    product: Object,
    content: Object
});

const form = useForm({
    title: props.content.title,
    description: props.content.description || '',
    section_type: props.content.section_type,
    duration_minutes: props.content.duration_minutes,
    is_premium: props.content.is_premium,
    is_published: props.content.is_published,
});

const blockForm = useForm({
    block_type: 'text',
    content: '',
    caption: '',
    media_type: null,
    media_file: null,
    tutorial_name: 'Field Technician Training',
});

const editingBlock = ref(null);
const showDeleteBlockModal = ref(false);
const blockToDelete = ref(null);
const previewUrl = ref(null);

const submit = () => {
    form.put(route('admin.products.content.update', {
        product: props.product.id,
        content: props.content.id
    }));
};

const addBlock = () => {
    blockForm.post(route('admin.products.content.blocks.store', {
        product: props.product.id,
        content: props.content.id
    }), {
        onSuccess: () => {
            blockForm.reset();
            previewUrl.value = null;
        }
    });
};

const startEditBlock = (block) => {
    editingBlock.value = block.id;
    blockForm.block_type = block.block_type;
    blockForm.content = block.content || '';
    blockForm.caption = block.caption || '';
    blockForm.media_type = block.media_type;
    blockForm.tutorial_name = block.block_type === 'tutorial' ? (block.content || 'Field Technician Training') : 'Field Technician Training';
};

const cancelEditBlock = () => {
    editingBlock.value = null;
    blockForm.reset();
    previewUrl.value = null;
};

const updateBlock = (blockId) => {
    blockForm.put(route('admin.products.content.blocks.update', {
        product: props.product.id,
        content: props.content.id,
        block: blockId
    }), {
        onSuccess: () => {
            editingBlock.value = null;
            blockForm.reset();
            previewUrl.value = null;
        }
    });
};

const openDeleteBlockModal = (block) => {
    blockToDelete.value = block;
    showDeleteBlockModal.value = true;
};

const closeDeleteBlockModal = () => {
    blockToDelete.value = null;
    showDeleteBlockModal.value = false;
};

const deleteBlock = () => {
    router.delete(route('admin.products.content.blocks.destroy', {
        product: props.product.id,
        content: props.content.id,
        block: blockToDelete.value.id
    }), {
        onSuccess: () => {
            closeDeleteBlockModal();
        }
    });
};

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        blockForm.media_file = file;
        
        // Create preview URL
        if (file.type.startsWith('image/')) {
            previewUrl.value = URL.createObjectURL(file);
        } else if (file.type.startsWith('video/')) {
            previewUrl.value = URL.createObjectURL(file);
        }
    }
};

const getBlockTypeIcon = (type) => {
    const icons = {
        text: '📝',
        heading: '📌',
        image: '🖼️',
        video: '🎥',
        tutorial: '🎓'
    };
    return icons[type] || '📄';
};

const isMediaBlock = computed(() => {
    return blockForm.block_type === 'image' || blockForm.block_type === 'video';
});
</script>

<template>
    <Head :title="`Edit Content: ${content.title}`" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-white leading-tight">
                    Edit Content: {{ content.title }}
                </h2>
                <Link
                    :href="route('admin.products.content.index', product.id)"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition"
                >
                    Back to Content
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Section Settings -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <h3 class="text-lg font-semibold text-white mb-4">Section Settings</h3>
                        <form @submit.prevent="submit" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="title" value="Title" />
                                    <TextInput
                                        id="title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.title"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>

                                <div>
                                    <InputLabel for="duration_minutes" value="Duration (minutes)" />
                                    <TextInput
                                        id="duration_minutes"
                                        type="number"
                                        min="0"
                                        class="mt-1 block w-full"
                                        v-model="form.duration_minutes"
                                    />
                                    <InputError class="mt-2" :message="form.errors.duration_minutes" />
                                </div>
                            </div>

                            <div>
                                <InputLabel for="description" value="Description" />
                                <textarea
                                    id="description"
                                    class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.description"
                                    rows="2"
                                ></textarea>
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <div class="flex items-center gap-6">
                                <div class="flex items-center">
                                    <input
                                        id="is_premium"
                                        type="checkbox"
                                        class="rounded border-gray-600 bg-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        v-model="form.is_premium"
                                    />
                                    <label for="is_premium" class="ml-2 block text-sm text-gray-300">
                                        Premium Content
                                    </label>
                                </div>

                                <div class="flex items-center">
                                    <input
                                        id="is_published"
                                        type="checkbox"
                                        class="rounded border-gray-600 bg-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        v-model="form.is_published"
                                    />
                                    <label for="is_published" class="ml-2 block text-sm text-gray-300">
                                        Published
                                    </label>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Update Section Settings
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Content Blocks -->
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <h3 class="text-lg font-semibold text-white mb-4">Content Blocks</h3>
                        
                        <!-- Existing Blocks -->
                        <div v-if="content.blocks && content.blocks.length > 0" class="space-y-4 mb-6">
                            <div v-for="block in content.blocks" :key="block.id" class="border border-gray-700 rounded-lg p-4">
                                <div v-if="editingBlock === block.id">
                                    <!-- Edit Mode -->
                                    <form @submit.prevent="updateBlock(block.id)" class="space-y-4">
                                        <div>
                                            <InputLabel for="edit_block_type" value="Block Type" />
                                            <select
                                                id="edit_block_type"
                                                class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-lg font-medium"
                                                v-model="blockForm.block_type"
                                            >
                                                <option value="heading">📌 Heading</option>
                                                <option value="text">📝 Text Paragraph</option>
                                                <option value="image">🖼️ Image</option>
                                                <option value="video">🎥 Video</option>
                                                <option value="tutorial">🎓 Interactive Tutorial</option>
                                            </select>
                                        </div>

                                        <div v-if="blockForm.block_type === 'heading' || blockForm.block_type === 'text'">
                                            <InputLabel :for="`edit_content_${block.id}`" :value="blockForm.block_type === 'heading' ? 'Heading Text' : 'Paragraph Text'" />
                                            <textarea
                                                :id="`edit_content_${block.id}`"
                                                class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                v-model="blockForm.content"
                                                :rows="blockForm.block_type === 'heading' ? 2 : 6"
                                                required
                                            ></textarea>
                                        </div>

                                        <div v-if="blockForm.block_type === 'tutorial'" class="bg-purple-900 border border-purple-700 rounded-md p-4">
                                            <InputLabel for="edit_tutorial_name" value="Select Tutorial" />
                                            <select
                                                id="edit_tutorial_name"
                                                class="mt-1 block w-full border-purple-600 bg-purple-800 text-white focus:border-purple-400 focus:ring-purple-400 rounded-md shadow-sm"
                                                v-model="blockForm.tutorial_name"
                                                required
                                            >
                                                <option value="Field Technician Training">Field Technician Training (15 slides)</option>
                                                <option value="Cat 6 Cable Installation">Cat 6 Cable Installation & Termination (Coming Soon)</option>
                                                <option value="Network Equipment Setup">Network Equipment Setup (Coming Soon)</option>
                                            </select>
                                        </div>

                                        <div v-if="isMediaBlock">
                                            <InputLabel :for="`edit_media_file_${block.id}`" :value="blockForm.block_type === 'image' ? 'Upload New Image (optional)' : 'Upload New Video (optional)'" />
                                            
                                            <div v-if="blockForm.block_type === 'video'" class="mb-3 p-3 bg-blue-900 border border-blue-700 rounded-md">
                                                <p class="text-sm text-blue-200">
                                                    <strong>Video Upload:</strong> MP4 or WebM format (max 50MB)
                                                </p>
                                            </div>
                                            
                                            <input
                                                :id="`edit_media_file_${block.id}`"
                                                type="file"
                                                class="mt-1 block w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-600 file:text-white hover:file:bg-orange-500 cursor-pointer"
                                                @change="handleFileChange"
                                                :accept="blockForm.block_type === 'image' ? 'image/webp,image/jpeg,image/png' : 'video/mp4,video/webm'"
                                            />
                                            <p class="mt-1 text-sm text-gray-400">
                                                {{ blockForm.block_type === 'image' ? '🖼️ WebP, JPG, or PNG format' : '🎥 MP4 or WebM format' }}
                                            </p>
                                            
                                            <div v-if="block.media_path || previewUrl" class="mt-3">
                                                <p class="text-sm text-gray-400 mb-2">Current Media:</p>
                                                <img v-if="blockForm.block_type === 'image'" 
                                                    :src="previewUrl || `/storage/${block.media_path}`" 
                                                    class="max-w-xs rounded border border-gray-600"
                                                    alt="Preview"
                                                />
                                                <video v-if="blockForm.block_type === 'video'" 
                                                    :src="previewUrl || `/storage/${block.media_path}`"
                                                    controls
                                                    class="max-w-md rounded border border-gray-600"
                                                ></video>
                                            </div>
                                        </div>

                                        <div v-if="isMediaBlock">
                                            <InputLabel :for="`edit_caption_${block.id}`" value="Caption (optional)" />
                                            <TextInput
                                                :id="`edit_caption_${block.id}`"
                                                type="text"
                                                class="mt-1 block w-full"
                                                v-model="blockForm.caption"
                                                placeholder="Optional caption for the media"
                                            />
                                        </div>

                                        <div class="flex gap-2">
                                            <PrimaryButton :class="{ 'opacity-25': blockForm.processing }" :disabled="blockForm.processing">
                                                Update Block
                                            </PrimaryButton>
                                            <SecondaryButton type="button" @click="cancelEditBlock">
                                                Cancel
                                            </SecondaryButton>
                                        </div>
                                    </form>
                                </div>
                                <div v-else>
                                    <!-- View Mode -->
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="text-2xl">{{ getBlockTypeIcon(block.block_type) }}</span>
                                                <span class="text-sm font-semibold text-orange-400 uppercase">{{ block.block_type }}</span>
                                            </div>
                                            
                                            <div v-if="block.block_type === 'heading'" class="text-xl font-bold text-white">
                                                {{ block.content }}
                                            </div>
                                            <div v-else-if="block.block_type === 'text'" class="text-gray-300 whitespace-pre-line">
                                                {{ block.content }}
                                            </div>
                                            <div v-else-if="block.block_type === 'tutorial'" class="bg-purple-900 border border-purple-700 rounded-md p-4">
                                                <p class="text-purple-200 font-semibold">{{ block.content || 'Field Technician Training' }}</p>
                                                <p class="text-sm text-purple-300 mt-1">Interactive tutorial with slides, quizzes, and certificate</p>
                                            </div>
                                            <div v-else-if="block.block_type === 'image' && block.media_path">
                                                <img :src="`/storage/${block.media_path}`" 
                                                    class="max-w-md rounded border border-gray-600 mb-2"
                                                    :alt="block.caption || 'Content image'"
                                                />
                                                <p v-if="block.caption" class="text-sm text-gray-400 italic">{{ block.caption }}</p>
                                            </div>
                                            <div v-else-if="block.block_type === 'video' && block.media_path">
                                                <video :src="`/storage/${block.media_path}`" 
                                                    controls
                                                    class="max-w-2xl rounded border border-gray-600 mb-2"
                                                ></video>
                                                <p v-if="block.caption" class="text-sm text-gray-400 italic">{{ block.caption }}</p>
                                            </div>
                                        </div>
                                        <div class="flex gap-2 ml-4">
                                            <button
                                                @click="startEditBlock(block)"
                                                class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                @click="openDeleteBlockModal(block)"
                                                class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add New Block Form -->
                        <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 bg-gray-750">
                            <h4 class="text-md font-semibold text-white mb-4">Add New Content Block</h4>
                            <form @submit.prevent="addBlock" class="space-y-4">
                                <div>
                                    <InputLabel for="block_type" value="Block Type" />
                                    <select
                                        id="block_type"
                                        class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-lg font-medium"
                                        v-model="blockForm.block_type"
                                        required
                                    >
                                        <option value="heading">📌 Heading - Section Title</option>
                                        <option value="text">📝 Text Paragraph - Main Content</option>
                                        <option value="image">🖼️ Image - Upload Picture (WebP, JPG, PNG)</option>
                                        <option value="video">🎥 Video - Upload Video (MP4, WebM)</option>
                                        <option value="tutorial">🎓 Interactive Tutorial - Field Tech Training</option>
                                    </select>
                                    <p class="mt-2 text-sm text-gray-400">
                                        <span v-if="blockForm.block_type === 'heading'">Use for section titles and headers</span>
                                        <span v-else-if="blockForm.block_type === 'text'">Use for paragraphs and main content text</span>
                                        <span v-else-if="blockForm.block_type === 'image'">Use for screenshots, diagrams, and illustrations</span>
                                        <span v-else-if="blockForm.block_type === 'video'">Use for tutorial videos, demonstrations, and explanations</span>
                                        <span v-else-if="blockForm.block_type === 'tutorial'">Interactive tutorial with 15 slides, quizzes, and certificate</span>
                                    </p>
                                </div>

                                <div v-if="blockForm.block_type === 'tutorial'" class="bg-purple-900 border border-purple-700 rounded-md p-4">
                                    <p class="text-sm text-purple-200 mb-3">
                                        <strong>🎓 Tutorial Block:</strong> Select which interactive tutorial to embed in this content section. Students will complete the tutorial with slides, quizzes, and earn a certificate.
                                    </p>
                                    
                                    <div>
                                        <InputLabel for="tutorial_name" value="Select Tutorial" />
                                        <select
                                            id="tutorial_name"
                                            class="mt-1 block w-full border-purple-600 bg-purple-800 text-white focus:border-purple-400 focus:ring-purple-400 rounded-md shadow-sm"
                                            v-model="blockForm.tutorial_name"
                                            required
                                        >
                                            <option value="Field Technician Training">Field Technician Training (15 slides)</option>
                                            <option value="Cat 6 Cable Installation">Cat 6 Cable Installation & Termination (Coming Soon)</option>
                                            <option value="Network Equipment Setup">Network Equipment Setup (Coming Soon)</option>
                                        </select>
                                        <p class="mt-1 text-xs text-purple-300">More tutorials will be added here as you create them</p>
                                    </div>
                                </div>

                                <div v-if="blockForm.block_type === 'heading' || blockForm.block_type === 'text'">
                                    <InputLabel for="content" :value="blockForm.block_type === 'heading' ? 'Heading Text' : 'Paragraph Text'" />
                                    <textarea
                                        id="content"
                                        class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        v-model="blockForm.content"
                                        :rows="blockForm.block_type === 'heading' ? 2 : 6"
                                        required
                                        :placeholder="blockForm.block_type === 'heading' ? 'Enter heading text...' : 'Enter paragraph text...'"
                                    ></textarea>
                                    <InputError class="mt-2" :message="blockForm.errors.content" />
                                </div>

                                <div v-if="isMediaBlock">
                                    <InputLabel for="media_file" :value="blockForm.block_type === 'image' ? 'Upload Image' : 'Upload Video'" />
                                    
                                    <div v-if="blockForm.block_type === 'video'" class="mb-3 p-3 bg-blue-900 border border-blue-700 rounded-md">
                                        <p class="text-sm text-blue-200">
                                            <strong>Video Upload Tips:</strong>
                                        </p>
                                        <ul class="text-xs text-blue-300 mt-2 space-y-1 list-disc list-inside">
                                            <li>MP4 format recommended (H.264 codec)</li>
                                            <li>WebM is also supported</li>
                                            <li>Maximum file size: 50MB</li>
                                            <li>For longer videos, consider hosting on YouTube/Vimeo and embedding instead</li>
                                        </ul>
                                    </div>
                                    
                                    <input
                                        id="media_file"
                                        type="file"
                                        class="mt-1 block w-full text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-600 file:text-white hover:file:bg-orange-500 cursor-pointer"
                                        @change="handleFileChange"
                                        required
                                        :accept="blockForm.block_type === 'image' ? 'image/webp,image/jpeg,image/png' : 'video/mp4,video/webm'"
                                    />
                                    <p class="mt-1 text-sm text-gray-400">
                                        {{ blockForm.block_type === 'image' ? '🖼️ WebP, JPG, or PNG format (max 50MB)' : '🎥 MP4 or WebM format (max 50MB)' }}
                                    </p>
                                    <InputError class="mt-2" :message="blockForm.errors.media_file" />
                                    
                                    <div v-if="previewUrl" class="mt-3">
                                        <p class="text-sm text-gray-400 mb-2">Preview:</p>
                                        <img v-if="blockForm.block_type === 'image'" 
                                            :src="previewUrl" 
                                            class="max-w-xs rounded border border-gray-600"
                                            alt="Preview"
                                        />
                                        <video v-if="blockForm.block_type === 'video'" 
                                            :src="previewUrl"
                                            controls
                                            class="max-w-md rounded border border-gray-600"
                                        ></video>
                                    </div>
                                </div>

                                <div v-if="isMediaBlock">
                                    <InputLabel for="caption" value="Caption (optional)" />
                                    <TextInput
                                        id="caption"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="blockForm.caption"
                                        placeholder="Optional caption for the media"
                                    />
                                    <InputError class="mt-2" :message="blockForm.errors.caption" />
                                </div>

                                <div class="flex justify-end">
                                    <PrimaryButton :class="{ 'opacity-25': blockForm.processing }" :disabled="blockForm.processing">
                                        Add Block
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>

                        <div v-if="!content.blocks || content.blocks.length === 0" class="text-center py-8 text-gray-400">
                            <p>No content blocks yet. Add your first block above to start building this section.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Block Confirmation Modal -->
        <div v-if="showDeleteBlockModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeDeleteBlockModal"></div>
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
                                    Delete Content Block
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-300">
                                        Are you sure you want to delete this {{ blockToDelete?.block_type }} block? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <DangerButton @click="deleteBlock" class="w-full sm:w-auto sm:ml-3">
                            Delete
                        </DangerButton>
                        <SecondaryButton @click="closeDeleteBlockModal" class="mt-3 sm:mt-0 w-full sm:w-auto">
                            Cancel
                        </SecondaryButton>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
