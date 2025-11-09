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
        <!-- Tron-Style Grid Background -->
        <div class="absolute inset-0 tron-grid-perspective">
            <svg class="absolute inset-0 w-full h-full tron-grid-svg" viewBox="0 0 1000 1000" preserveAspectRatio="none">
                <defs>
                    <!-- Neon glow filter -->
                    <filter id="neon-glow">
                        <feGaussianBlur stdDeviation="3" result="coloredBlur"/>
                        <feMerge>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="SourceGraphic"/>
                        </feMerge>
                    </filter>
                    
                    <!-- Gradient for depth -->
                    <linearGradient id="depth-gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#f97316;stop-opacity:0.2"/>
                        <stop offset="100%" style="stop-color:#f97316;stop-opacity:0.9"/>
                    </linearGradient>
                </defs>
                
                <!-- Tron Grid - Perfect Squares -->
                <g class="tron-grid-lines" filter="url(#neon-glow)">
                    <!-- Horizontal lines - perpendicular to viewer -->
                    <line x1="0" y1="100" x2="1000" y2="100" stroke="url(#depth-gradient)" stroke-width="2" opacity="0.9"/>
                    <line x1="0" y1="200" x2="1000" y2="200" stroke="url(#depth-gradient)" stroke-width="2" opacity="0.85"/>
                    <line x1="0" y1="300" x2="1000" y2="300" stroke="url(#depth-gradient)" stroke-width="2" opacity="0.8"/>
                    <line x1="0" y1="400" x2="1000" y2="400" stroke="url(#depth-gradient)" stroke-width="2" opacity="0.7"/>
                    <line x1="0" y1="500" x2="1000" y2="500" stroke="url(#depth-gradient)" stroke-width="1.8" opacity="0.6"/>
                    <line x1="0" y1="600" x2="1000" y2="600" stroke="url(#depth-gradient)" stroke-width="1.6" opacity="0.5"/>
                    <line x1="0" y1="700" x2="1000" y2="700" stroke="url(#depth-gradient)" stroke-width="1.4" opacity="0.4"/>
                    <line x1="0" y1="800" x2="1000" y2="800" stroke="url(#depth-gradient)" stroke-width="1.2" opacity="0.3"/>
                    <line x1="0" y1="900" x2="1000" y2="900" stroke="url(#depth-gradient)" stroke-width="1" opacity="0.2"/>
                    
                    <!-- Vertical lines - creating the grid squares -->
                    <line x1="100" y1="0" x2="100" y2="1000" stroke="url(#depth-gradient)" stroke-width="2" opacity="0.8"/>
                    <line x1="200" y1="0" x2="200" y2="1000" stroke="url(#depth-gradient)" stroke-width="2" opacity="0.8"/>
                    <line x1="300" y1="0" x2="300" y2="1000" stroke="url(#depth-gradient)" stroke-width="2" opacity="0.8"/>
                    <line x1="400" y1="0" x2="400" y2="1000" stroke="url(#depth-gradient)" stroke-width="2" opacity="0.8"/>
                    <line x1="500" y1="0" x2="500" y2="1000" stroke="url(#depth-gradient)" stroke-width="2" opacity="0.8"/>
                    <line x1="600" y1="0" x2="600" y2="1000" stroke="url(#depth-gradient)" stroke-width="2" opacity="0.8"/>
                    <line x1="700" y1="0" x2="700" y2="1000" stroke="url(#depth-gradient)" stroke-width="2" opacity="0.8"/>
                    <line x1="800" y1="0" x2="800" y2="1000" stroke="url(#depth-gradient)" stroke-width="2" opacity="0.8"/>
                    <line x1="900" y1="0" x2="900" y2="1000" stroke="url(#depth-gradient)" stroke-width="2" opacity="0.8"/>
                    
                    <!-- Grid intersection nodes -->
                    <circle cx="100" cy="100" r="4" fill="#f97316" opacity="0.9" class="pulse-node"/>
                    <circle cx="300" cy="200" r="4" fill="#f97316" opacity="0.8" class="pulse-node" style="animation-delay: 0.5s"/>
                    <circle cx="500" cy="300" r="4" fill="#f97316" opacity="0.8" class="pulse-node" style="animation-delay: 1s"/>
                    <circle cx="700" cy="200" r="4" fill="#f97316" opacity="0.8" class="pulse-node" style="animation-delay: 1.5s"/>
                    <circle cx="900" cy="100" r="4" fill="#f97316" opacity="0.9" class="pulse-node" style="animation-delay: 2s"/>
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
/* Tron Grid Perspective */
.tron-grid-perspective {
    perspective: 800px;
    pointer-events: none;
}

.tron-grid-svg {
    transform-style: preserve-3d;
    transform: rotateX(60deg);
    transform-origin: center center;
}

/* Pulsing node animation */
@keyframes pulse-node {
    0%, 100% {
        opacity: 0.3;
        transform: scale(1);
    }
    50% {
        opacity: 1;
        transform: scale(1.5);
    }
}

.pulse-node {
    animation: pulse-node 2s ease-in-out infinite;
}

/* Grid line glow animation */
@keyframes grid-pulse {
    0%, 100% {
        opacity: 0.6;
    }
    50% {
        opacity: 1;
    }
}

.tron-grid-lines {
    animation: grid-pulse 4s ease-in-out infinite;
}
</style>
