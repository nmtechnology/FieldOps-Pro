<script setup>
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    product: Object,
    defaultImages: {
        type: Array,
        default: () => []
    }
});

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    short_description: props.product.short_description || '',
    type: props.product.type || 'info',
    price: props.product.price,
    image_path: props.product.image_path || '',
    active: props.product.active,
    content_sections: props.product.content_sections || []
});

const types = [
    { value: 'info', label: 'Info Product' },
    { value: 'service', label: 'Service' },
    { value: 'physical', label: 'Physical Product' }
];

const useDefaultImage = (imageFile) => {
    form.image_path = `/img/${imageFile}`;
};

const useArtificialBook = () => {
    form.image_path = 'artificial-book';
};

// Handle content sections as JSON text
const contentSectionsText = computed({
    get() {
        try {
            return JSON.stringify(form.content_sections, null, 2);
        } catch (e) {
            return '[]';
        }
    },
    set(value) {
        try {
            form.content_sections = JSON.parse(value);
        } catch (e) {
            // Keep the form value as is if JSON is invalid
            console.warn('Invalid JSON in content sections');
        }
    }
});

const submit = () => {
    form.put(`/admin/products/${props.product.id}`);
};
</script>

<template>
    <Head :title="`Edit Product: ${product.name}`" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-white leading-tight">
                    Edit Product: {{ product.name }}
                </h2>
                <div class="flex gap-2">
                    <Link
                        :href="`/admin/products/${product.id}`"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
                    >
                        View Product
                    </Link>
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
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <InputLabel for="name" value="Product Name" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div>
                                <InputLabel for="description" value="Description" />
                                <textarea
                                    id="description"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.description"
                                    rows="6"
                                    required
                                ></textarea>
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <div>
                                <InputLabel for="short_description" value="Short Description" />
                                <textarea
                                    id="short_description"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.short_description"
                                    rows="3"
                                    placeholder="Brief description used in product previews and home page"
                                ></textarea>
                                <InputError class="mt-2" :message="form.errors.short_description" />
                            </div>

                            <div>
                                <InputLabel for="type" value="Product Type" />
                                <select
                                    id="type"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.type"
                                    required
                                >
                                    <option v-for="type in types" :key="type.value" :value="type.value">
                                        {{ type.label }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.type" />
                            </div>

                            <div>
                                <InputLabel for="price" value="Price ($)" />
                                <TextInput
                                    id="price"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    class="mt-1 block w-full"
                                    v-model="form.price"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.price" />
                            </div>

                            <div>
                                <InputLabel for="tier" value="Tier" />
                                <select
                                    id="tier"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.tier"
                                    required
                                >
                                    <option v-for="tier in tiers" :key="tier.value" :value="tier.value">
                                        {{ tier.label }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.tier" />
                            </div>

                            <div>
                                <InputLabel for="image_path" value="Product Image" />
                                
                                <!-- Current Image Preview -->
                                <div v-if="form.image_path" class="mt-2 mb-4">
                                    <p class="text-sm text-gray-400 mb-2">Current image:</p>
                                    <div v-if="form.image_path === 'artificial-book'" class="p-4 border border-gray-600 rounded-lg bg-gray-700">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-16 h-16 bg-gradient-to-br from-slate-800 via-slate-900 to-slate-800 rounded flex items-center justify-center text-xs text-orange-400 font-bold">
                                                FIELD<br/>GUIDE
                                            </div>
                                            <div>
                                                <div class="font-medium text-white">Artificial Book Design</div>
                                                <div class="text-sm text-gray-400">Special design for Field Operations Guide</div>
                                            </div>
                                        </div>
                                    </div>
                                    <img 
                                        v-else
                                        :src="form.image_path" 
                                        :alt="form.name"
                                        class="w-32 h-24 object-cover rounded border border-gray-600"
                                    />
                                </div>
                                
                                <!-- Default Image Options -->
                                <div v-if="defaultImages.length > 0" class="mt-2 mb-4">
                                    <p class="text-sm text-gray-400 mb-3">Choose from available images:</p>
                                    
                                    <!-- Artificial Book Option for Field Operations Guide -->
                                    <div class="mb-4">
                                        <button
                                            type="button"
                                            @click="useArtificialBook"
                                            class="p-3 border rounded-lg hover:bg-gray-700 transition-colors flex items-center space-x-3 w-full text-left"
                                            :class="form.image_path === 'artificial-book' ? 'border-indigo-500 bg-gray-700' : 'border-gray-600'"
                                        >
                                            <div class="w-16 h-16 bg-gradient-to-br from-slate-800 via-slate-900 to-slate-800 rounded flex items-center justify-center text-xs text-orange-400 font-bold">
                                                FIELD<br/>GUIDE
                                            </div>
                                            <div>
                                                <div class="font-medium text-white">Artificial Book Design</div>
                                                <div class="text-sm text-gray-400">Perfect for the Field Operations Guide</div>
                                            </div>
                                        </button>
                                    </div>
                                    
                                    <!-- Default Images Grid -->
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                        <button
                                            v-for="image in defaultImages"
                                            :key="image"
                                            type="button"
                                            @click="useDefaultImage(image)"
                                            class="p-2 border rounded-lg hover:bg-gray-700 transition-colors"
                                            :class="form.image_path === `/img/${image}` ? 'border-indigo-500 bg-gray-700' : 'border-gray-600'"
                                        >
                                            <img
                                                :src="`/img/${image}`"
                                                :alt="image"
                                                class="w-full h-20 object-cover rounded mb-2"
                                            />
                                            <div class="text-xs text-gray-300 text-center truncate">{{ image.replace(/\.[^/.]+$/, "") }}</div>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Custom Image URL -->
                                <div>
                                    <InputLabel for="image_path" value="Or enter custom image URL:" />
                                    <TextInput
                                        id="image_path"
                                        type="url"
                                        class="mt-1 block w-full"
                                        v-model="form.image_path"
                                        placeholder="https://example.com/image.jpg"
                                    />
                                    <p class="text-sm text-gray-400 mt-1">Leave empty to automatically assign a default image</p>
                                </div>
                                <InputError class="mt-2" :message="form.errors.image_path" />
                            </div>

                            <div>
                                <InputLabel for="content_sections" value="Content Sections (JSON)" />
                                <textarea
                                    id="content_sections"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm font-mono text-sm"
                                    v-model="contentSectionsText"
                                    rows="10"
                                    placeholder='[{"heading": "Section Title", "content": "Section content here"}]'
                                ></textarea>
                                <p class="mt-1 text-sm text-gray-600">
                                    JSON array of content sections. Each section should have "heading" and "content" properties.
                                </p>
                                <InputError class="mt-2" :message="form.errors.content_sections" />
                            </div>

                            <div class="flex items-center mt-4">
                                <input
                                    id="active"
                                    type="checkbox"
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    v-model="form.active"
                                />
                                <InputLabel for="active" value="Active" class="ml-2" />
                                <InputError class="mt-2" :message="form.errors.active" />
                            </div>

                            <div class="flex items-center justify-end mt-6 space-x-4">
                                <SecondaryButton
                                    type="button"
                                    @click="$router.go(-1)"
                                >
                                    Cancel
                                </SecondaryButton>
                                <PrimaryButton 
                                    class="ml-4" 
                                    :class="{ 'opacity-25': form.processing }" 
                                    :disabled="form.processing"
                                >
                                    Update Product
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>