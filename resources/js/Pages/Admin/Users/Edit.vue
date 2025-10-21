<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { computed } from 'vue';

const props = defineProps({
    user: Object,
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    is_admin: props.user.is_admin,
    current_password: '', // Admin's current password for verification
});

// Track if sensitive information has changed
const hasChanges = computed(() => {
    return form.name !== props.user.name || 
           form.email !== props.user.email || 
           form.is_admin !== props.user.is_admin ||
           form.password !== '';
});

const submit = () => {
    form.put(route('admin.users.update', props.user.id), {
        onSuccess: () => {
            // Clear password fields after successful update
            form.password = '';
            form.password_confirmation = '';
            form.current_password = '';
        },
    });
};
</script>

<template>
    <Head :title="`Edit User: ${user.name}`" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-white leading-tight">
                    Edit User: {{ user.name }}
                </h2>
                <div class="flex gap-2">
                    <Link
                        :href="route('admin.users.show', user.id)"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
                    >
                        View User
                    </Link>
                    <Link
                        :href="route('admin.users.index')"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition"
                    >
                        Back to Users
                    </Link>
                </div>
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

                            <!-- Password Change (Optional) -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-white">Change Password (Optional)</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <InputLabel for="password" value="New Password" class="text-gray-300" />
                                        <TextInput
                                            id="password"
                                            type="password"
                                            class="mt-1 block w-full bg-gray-700 text-white border-gray-600"
                                            v-model="form.password"
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
                                            autocomplete="new-password"
                                        />
                                        <InputError class="mt-2" :message="form.errors.password_confirmation" />
                                    </div>
                                </div>
                            </div>

                            <!-- Admin Password Verification -->
                            <div v-if="hasChanges" class="p-4 bg-yellow-900 border border-yellow-700 rounded-md">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-200">
                                            Admin Verification Required
                                        </h3>
                                        <div class="mt-2 text-sm text-yellow-300">
                                            <p>You are modifying user account information. Please enter your admin password to verify these changes.</p>
                                        </div>
                                        <div class="mt-4">
                                            <InputLabel for="current_password" value="Your Admin Password" class="text-yellow-200" />
                                            <TextInput
                                                id="current_password"
                                                type="password"
                                                class="mt-1 block w-full bg-gray-700 text-white border-gray-600"
                                                v-model="form.current_password"
                                                autocomplete="current-password"
                                                placeholder="Enter your admin password"
                                            />
                                            <InputError class="mt-2" :message="form.errors.current_password" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center gap-4">
                                <PrimaryButton 
                                    :disabled="form.processing || (hasChanges && !form.current_password)"
                                    :class="{ 'opacity-50': hasChanges && !form.current_password }"
                                    class="bg-orange-600 hover:bg-orange-700"
                                >
                                    {{ hasChanges ? 'Verify & Update User' : 'Update User' }}
                                </PrimaryButton>

                                <p v-if="hasChanges && !form.current_password" class="text-sm text-yellow-400">
                                    Admin password verification required to save changes
                                </p>

                                <p v-if="form.recentlySuccessful" class="text-sm text-green-400">
                                    User updated successfully.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>