<template>
    <Head>
        <title>Complete Registration - FieldEngineer Pro</title>
        <meta name="description" content="Complete your account registration">
    </Head>

    <GuestLayout>
        <div class="pt-12 pb-24">
            <div class="max-w-md mx-auto sm:px-6 lg:px-8">
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Complete Your Registration</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">Just a few more details to set up your account</p>
                </div>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <div class="mb-6">
                                <InputLabel for="email" value="Email" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                    disabled
                                />
                                <p class="mt-1 text-sm text-gray-500">This email was provided during checkout</p>
                            </div>

                            <div class="mb-6">
                                <InputLabel for="name" value="Full Name" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div class="mb-6">
                                <InputLabel for="password" value="Password" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                    required
                                    autocomplete="new-password"
                                />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <div class="mb-6">
                                <InputLabel for="password_confirmation" value="Confirm Password" />
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password_confirmation"
                                    required
                                    autocomplete="new-password"
                                />
                                <InputError class="mt-2" :message="form.errors.password_confirmation" />
                            </div>

                            <div class="mb-6">
                                <div class="flex items-center">
                                    <Checkbox name="terms" id="terms" v-model:checked="form.terms" />
                                    <div class="ml-2">
                                        <label for="terms" class="text-sm text-gray-600 dark:text-gray-400">
                                            I agree to the <Link :href="route('terms')" class="text-orange-600 hover:text-orange-500">Terms and Conditions</Link>
                                        </label>
                                    </div>
                                </div>
                                <InputError class="mt-2" :message="form.errors.terms" />
                            </div>

                            <div class="flex items-center justify-end">
                                <PrimaryButton class="w-full justify-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Complete Registration
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';

const props = defineProps({
    email: String,
});

const form = useForm({
    name: '',
    email: props.email,
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('guest.register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>