<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    is_admin: false,
});

const submit = () => {
    form.post(route('admin.users.store'), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Add New User" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-white leading-tight">Add New User</h2>
                <Link
                    :href="route('admin.users.index')"
                    class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition"
                >
                    Back to Users
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-200">
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Basic Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="name" value="Name" class="text-gray-300" />
                                    <TextInput
                                        id="name"
                                        type="text"
                                        class="mt-1 block w-full bg-gray-700 text-white border-gray-600"
                                        v-model="form.name"
                                        required
                                        autofocus
                                    />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <div>
                                    <InputLabel for="email" value="Email" class="text-gray-300" />
                                    <TextInput
                                        id="email"
                                        type="email"
                                        class="mt-1 block w-full bg-gray-700 text-white border-gray-600"
                                        v-model="form.email"
                                        required
                                    />
                                    <InputError class="mt-2" :message="form.errors.email" />
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="password" value="Password" class="text-gray-300" />
                                    <TextInput
                                        id="password"
                                        type="password"
                                        class="mt-1 block w-full bg-gray-700 text-white border-gray-600"
                                        v-model="form.password"
                                        required
                                        autocomplete="new-password"
                                    />
                                    <InputError class="mt-2" :message="form.errors.password" />
                                </div>

                                <div>
                                    <InputLabel for="password_confirmation" value="Confirm Password" class="text-gray-300" />
                                    <TextInput
                                        id="password_confirmation"
                                        type="password"
                                        class="mt-1 block w-full bg-gray-700 text-white border-gray-600"
                                        v-model="form.password_confirmation"
                                        required
                                        autocomplete="new-password"
                                    />
                                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                                </div>
                            </div>

                            <!-- Admin Status -->
                            <div>
                                <div class="flex items-center">
                                    <input
                                        id="is_admin"
                                        type="checkbox"
                                        class="rounded border-gray-600 bg-gray-700 text-orange-600 shadow-sm focus:ring-orange-500"
                                        v-model="form.is_admin"
                                    />
                                    <InputLabel for="is_admin" value="Administrator" class="ml-2 text-gray-300" />
                                </div>
                                <p class="mt-1 text-sm text-gray-400">
                                    Grant administrative privileges to this user
                                </p>
                                <InputError class="mt-2" :message="form.errors.is_admin" />
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center gap-4">
                                <PrimaryButton 
                                    :disabled="form.processing"
                                    class="bg-orange-600 hover:bg-orange-700"
                                >
                                    Create User
                                </PrimaryButton>

                                <p v-if="form.recentlySuccessful" class="text-sm text-green-400">
                                    User created successfully.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>