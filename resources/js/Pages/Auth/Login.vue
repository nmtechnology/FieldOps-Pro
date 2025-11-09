<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="relative min-h-screen bg-black flex flex-col items-center pt-6 sm:justify-center sm:pt-0 overflow-hidden">
        <!-- Dense Tron-Style 3D Matrix Grid -->
        <div class="absolute inset-0 grid-container">
            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <filter id="grid-glow">
                        <feGaussianBlur stdDeviation="0.3" result="coloredBlur"/>
                        <feMerge>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="SourceGraphic"/>
                        </feMerge>
                    </filter>
                </defs>
                
                <g class="grid-lines" filter="url(#grid-glow)">
                    <!-- HORIZONTAL LINES - Many lines creating dense grid -->
                    <line x1="0" y1="100" x2="100" y2="100" stroke="#0ea5e9" stroke-width="0.3" opacity="1"/>
                    <line x1="0" y1="98" x2="100" y2="98" stroke="#0ea5e9" stroke-width="0.25" opacity="0.95"/>
                    <line x1="0" y1="96" x2="100" y2="96" stroke="#0ea5e9" stroke-width="0.25" opacity="0.9"/>
                    <line x1="0" y1="94" x2="100" y2="94" stroke="#0ea5e9" stroke-width="0.25" opacity="0.85"/>
                    <line x1="0" y1="92" x2="100" y2="92" stroke="#0ea5e9" stroke-width="0.25" opacity="0.8"/>
                    <line x1="0" y1="90" x2="100" y2="90" stroke="#0ea5e9" stroke-width="0.25" opacity="0.75"/>
                    <line x1="0" y1="88" x2="100" y2="88" stroke="#0ea5e9" stroke-width="0.2" opacity="0.7"/>
                    <line x1="0" y1="86" x2="100" y2="86" stroke="#0ea5e9" stroke-width="0.2" opacity="0.65"/>
                    <line x1="0" y1="84" x2="100" y2="84" stroke="#0ea5e9" stroke-width="0.2" opacity="0.6"/>
                    <line x1="0" y1="82" x2="100" y2="82" stroke="#0ea5e9" stroke-width="0.2" opacity="0.55"/>
                    <line x1="0" y1="80" x2="100" y2="80" stroke="#0ea5e9" stroke-width="0.2" opacity="0.5"/>
                    <line x1="0" y1="78" x2="100" y2="78" stroke="#0ea5e9" stroke-width="0.15" opacity="0.48"/>
                    <line x1="0" y1="76" x2="100" y2="76" stroke="#0ea5e9" stroke-width="0.15" opacity="0.46"/>
                    <line x1="0" y1="74" x2="100" y2="74" stroke="#0ea5e9" stroke-width="0.15" opacity="0.44"/>
                    <line x1="0" y1="72" x2="100" y2="72" stroke="#0ea5e9" stroke-width="0.15" opacity="0.42"/>
                    <line x1="0" y1="70" x2="100" y2="70" stroke="#0ea5e9" stroke-width="0.15" opacity="0.4"/>
                    <line x1="0" y1="68" x2="100" y2="68" stroke="#0ea5e9" stroke-width="0.15" opacity="0.38"/>
                    <line x1="0" y1="66" x2="100" y2="66" stroke="#0ea5e9" stroke-width="0.15" opacity="0.36"/>
                    <line x1="0" y1="64" x2="100" y2="64" stroke="#0ea5e9" stroke-width="0.15" opacity="0.34"/>
                    <line x1="0" y1="62" x2="100" y2="62" stroke="#0ea5e9" stroke-width="0.15" opacity="0.32"/>
                    <line x1="0" y1="60" x2="100" y2="60" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="0" y1="58" x2="100" y2="58" stroke="#0ea5e9" stroke-width="0.1" opacity="0.28"/>
                    <line x1="0" y1="56" x2="100" y2="56" stroke="#0ea5e9" stroke-width="0.1" opacity="0.26"/>
                    <line x1="0" y1="54" x2="100" y2="54" stroke="#0ea5e9" stroke-width="0.1" opacity="0.24"/>
                    <line x1="0" y1="52" x2="100" y2="52" stroke="#0ea5e9" stroke-width="0.1" opacity="0.22"/>
                    <line x1="0" y1="50" x2="100" y2="50" stroke="#0ea5e9" stroke-width="0.1" opacity="0.2"/>
                    <line x1="0" y1="48" x2="100" y2="48" stroke="#0ea5e9" stroke-width="0.1" opacity="0.18"/>
                    <line x1="0" y1="46" x2="100" y2="46" stroke="#0ea5e9" stroke-width="0.1" opacity="0.16"/>
                    <line x1="0" y1="44" x2="100" y2="44" stroke="#0ea5e9" stroke-width="0.1" opacity="0.14"/>
                    <line x1="0" y1="42" x2="100" y2="42" stroke="#0ea5e9" stroke-width="0.1" opacity="0.12"/>
                    <line x1="0" y1="40" x2="100" y2="40" stroke="#0ea5e9" stroke-width="0.1" opacity="0.1"/>
                    
                    <!-- VERTICAL LINES - Dense spacing -->
                    <line x1="0" y1="0" x2="0" y2="100" stroke="#0ea5e9" stroke-width="0.25" opacity="0.8"/>
                    <line x1="2" y1="0" x2="2" y2="100" stroke="#0ea5e9" stroke-width="0.2" opacity="0.7"/>
                    <line x1="4" y1="0" x2="4" y2="100" stroke="#0ea5e9" stroke-width="0.2" opacity="0.65"/>
                    <line x1="6" y1="0" x2="6" y2="100" stroke="#0ea5e9" stroke-width="0.2" opacity="0.6"/>
                    <line x1="8" y1="0" x2="8" y2="100" stroke="#0ea5e9" stroke-width="0.2" opacity="0.55"/>
                    <line x1="10" y1="0" x2="10" y2="100" stroke="#0ea5e9" stroke-width="0.2" opacity="0.5"/>
                    <line x1="12" y1="0" x2="12" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.45"/>
                    <line x1="14" y1="0" x2="14" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.4"/>
                    <line x1="16" y1="0" x2="16" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.4"/>
                    <line x1="18" y1="0" x2="18" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.4"/>
                    <line x1="20" y1="0" x2="20" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.4"/>
                    <line x1="22" y1="0" x2="22" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.35"/>
                    <line x1="24" y1="0" x2="24" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.35"/>
                    <line x1="26" y1="0" x2="26" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.35"/>
                    <line x1="28" y1="0" x2="28" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.35"/>
                    <line x1="30" y1="0" x2="30" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.35"/>
                    <line x1="32" y1="0" x2="32" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="34" y1="0" x2="34" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="36" y1="0" x2="36" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="38" y1="0" x2="38" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="40" y1="0" x2="40" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="42" y1="0" x2="42" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="44" y1="0" x2="44" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="46" y1="0" x2="46" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="48" y1="0" x2="48" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="50" y1="0" x2="50" y2="100" stroke="#0ea5e9" stroke-width="0.25" opacity="0.6"/>
                    <line x1="52" y1="0" x2="52" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="54" y1="0" x2="54" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="56" y1="0" x2="56" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="58" y1="0" x2="58" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="60" y1="0" x2="60" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="62" y1="0" x2="62" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="64" y1="0" x2="64" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="66" y1="0" x2="66" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="68" y1="0" x2="68" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.3"/>
                    <line x1="70" y1="0" x2="70" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.35"/>
                    <line x1="72" y1="0" x2="72" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.35"/>
                    <line x1="74" y1="0" x2="74" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.35"/>
                    <line x1="76" y1="0" x2="76" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.35"/>
                    <line x1="78" y1="0" x2="78" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.35"/>
                    <line x1="80" y1="0" x2="80" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.4"/>
                    <line x1="82" y1="0" x2="82" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.4"/>
                    <line x1="84" y1="0" x2="84" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.4"/>
                    <line x1="86" y1="0" x2="86" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.4"/>
                    <line x1="88" y1="0" x2="88" y2="100" stroke="#0ea5e9" stroke-width="0.15" opacity="0.4"/>
                    <line x1="90" y1="0" x2="90" y2="100" stroke="#0ea5e9" stroke-width="0.2" opacity="0.5"/>
                    <line x1="92" y1="0" x2="92" y2="100" stroke="#0ea5e9" stroke-width="0.2" opacity="0.55"/>
                    <line x1="94" y1="0" x2="94" y2="100" stroke="#0ea5e9" stroke-width="0.2" opacity="0.6"/>
                    <line x1="96" y1="0" x2="96" y2="100" stroke="#0ea5e9" stroke-width="0.2" opacity="0.65"/>
                    <line x1="98" y1="0" x2="98" y2="100" stroke="#0ea5e9" stroke-width="0.2" opacity="0.7"/>
                    <line x1="100" y1="0" x2="100" y2="100" stroke="#0ea5e9" stroke-width="0.25" opacity="0.8"/>
                </g>
            </svg>
        </div>
        
        <!-- Logo -->
        <div class="z-10">
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-orange-500" />
            </Link>
        </div>

        <!-- Brand Text -->
        <div class="z-10 text-center mt-4 mb-2">
            <h1 class="text-3xl font-bold text-white tracking-tight">FieldEngineer Pro</h1>
            <p class="text-orange-400 font-semibold mt-1">Field Service Training Platform</p>
            <p class="text-gray-400 text-sm mt-1">Sign in to access your courses</p>
        </div>
        
        <!-- Login Form Card -->
        <div class="mt-6 w-full max-w-md px-6 py-4 bg-gray-800 bg-opacity-50 shadow-md overflow-hidden sm:rounded-lg z-10 backdrop-blur-sm border border-gray-700">
            <Head title="Log in" />

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4 block">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ms-2 text-sm text-gray-300"
                            >Remember me</span
                        >
                    </label>
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="rounded-md text-sm text-gray-300 underline hover:text-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
                    >
                        Forgot your password?
                    </Link>

                    <PrimaryButton
                        class="ms-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Log in
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
/* Dense 3D Tron Matrix Grid */
.grid-container {
    perspective: 400px;
    perspective-origin: 50% 100%;
    overflow: hidden;
}

.grid-container svg {
    transform-style: preserve-3d;
    transform: rotateX(75deg) translateY(50%);
    transform-origin: center bottom;
}

/* Smooth upward scrolling animation */
@keyframes grid-flow {
    0% {
        transform: rotateX(75deg) translateY(50%);
    }
    100% {
        transform: rotateX(75deg) translateY(48%);
    }
}

.grid-lines {
    animation: grid-flow 8s linear infinite;
}

/* Ambient horizon glow */
.grid-container::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(to bottom, transparent 0%, rgba(14, 165, 233, 0.1) 50%, transparent 100%);
    pointer-events: none;
}
</style>

