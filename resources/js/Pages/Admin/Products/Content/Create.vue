<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    product: Object,
    parent: {
        type: Object,
        default: null
    }
});

const page = usePage();
const urlParams = new URLSearchParams(window.location.search);
const isTutorial = urlParams.get('type') === 'tutorial';

const form = useForm({
    parent_id: props.parent?.id || null,
    title: '',
    description: '',
    section_type: isTutorial ? 'tutorial' : (props.parent ? 'section' : 'chapter'),
    duration_minutes: null,
    is_premium: true,
    is_published: false,
});

const submit = () => {
    form.post(route('admin.products.content.store', props.product.id));
};
</script>

<template>
    <Head :title="`Add ${parent ? 'Section' : 'Chapter'}: ${product.name}`" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-white leading-tight">
                    Add {{ isTutorial ? 'Tutorial' : (parent ? 'Section' : 'Chapter') }}: {{ product.name }}
                    <span v-if="parent" class="text-gray-400 text-base">→ {{ parent.title }}</span>
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
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <InputLabel for="title" :value="isTutorial ? 'Tutorial Title' : (parent ? 'Section Title' : 'Chapter Title')" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                    autofocus
                                    :placeholder="isTutorial ? 'e.g., Field Technician Certification' : 'e.g., Getting Started with Field Operations'"
                                />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div>
                                <InputLabel for="description" value="Description" />
                                <textarea
                                    id="description"
                                    class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.description"
                                    rows="3"
                                    placeholder="Brief description of what this section covers"
                                ></textarea>
                                <InputError class="mt-2" :message="form.errors.description" />
                                <p class="mt-1 text-sm text-gray-400">This will be shown in the content overview.</p>
                            </div>

                            <div v-if="!parent && !isTutorial">
                                <InputLabel for="section_type" value="Section Type" />
                                <select
                                    id="section_type"
                                    class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.section_type"
                                    required
                                >
                                    <option value="introduction">Introduction</option>
                                    <option value="chapter">Chapter</option>
                                    <option value="bonus">Bonus Content</option>
                                    <option value="conclusion">Conclusion</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.section_type" />
                            </div>

                            <div v-if="isTutorial" class="bg-purple-900 border border-purple-700 rounded-md p-4">
                                <p class="text-sm text-purple-200">
                                    <strong>📚 Tutorial Section:</strong> This will link to the interactive Field Technician Training tutorial with 15 slides, quizzes, and a certificate.
                                </p>
                            </div>

                            <div>
                                <InputLabel for="duration_minutes" value="Estimated Duration (minutes)" />
                                <TextInput
                                    id="duration_minutes"
                                    type="number"
                                    min="0"
                                    class="mt-1 block w-full"
                                    v-model="form.duration_minutes"
                                    placeholder="e.g., 15"
                                />
                                <InputError class="mt-2" :message="form.errors.duration_minutes" />
                                <p class="mt-1 text-sm text-gray-400">How long it takes to complete this section.</p>
                            </div>

                            <div class="flex items-center">
                                <input
                                    id="is_premium"
                                    type="checkbox"
                                    class="rounded border-gray-600 bg-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    v-model="form.is_premium"
                                />
                                <label for="is_premium" class="ml-2 block text-sm text-gray-300">
                                    Premium Content (requires purchase)
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
                                    Published (visible to users)
                                </label>
                            </div>

                            <div class="bg-blue-900 border border-blue-700 rounded-md p-4">
                                <p class="text-sm text-blue-200">
                                    <strong>Note:</strong> After creating this {{ isTutorial ? 'tutorial' : (parent ? 'section' : 'chapter') }}, {{ isTutorial ? "users will be able to access the interactive training directly" : "you'll be able to add content blocks (text, images, videos) to build out the material" }}.
                                </p>
                            </div>

                            <div class="flex items-center justify-end gap-4">
                                <Link
                                    :href="route('admin.products.content.index', product.id)"
                                    class="text-gray-400 hover:text-gray-300"
                                >
                                    Cancel
                                </Link>
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Create {{ parent ? 'Section' : 'Chapter' }}
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
