<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const form = useForm({
    name: '',
    description: '',
    short_description: '',
    type: 'info',
    price: '',
    image_path: '',
    active: true,
    content_sections: []
});

const types = [
    { value: 'info', label: 'Info Product' },
    { value: 'service', label: 'Service' },
    { value: 'physical', label: 'Physical Product' }
];

const submit = () => {
    form.post('/admin/products');
};
</script>

<template>
    <Head title="Add New Product" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-white leading-tight">Add New Product</h2>
                <Link
                    href="/admin/products"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition"
                >
                    Back to Products
                </Link>
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
                                <InputLabel for="image_path" value="Image URL (optional)" />
                                <TextInput
                                    id="image_path"
                                    type="url"
                                    class="mt-1 block w-full"
                                    v-model="form.image_path"
                                    placeholder="https://example.com/image.jpg"
                                />
                                <InputError class="mt-2" :message="form.errors.image_path" />
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
                                    Create Product
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>