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
        <!-- High-Quality Tron Grid Background with Depth -->
        <div class="absolute inset-0 grid-container">
            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <defs>
                    <!-- Enhanced neon glow -->
                    <filter id="neon-glow" x="-50%" y="-50%" width="200%" height="200%">
                        <feGaussianBlur stdDeviation="0.5" result="coloredBlur"/>
                        <feMerge>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="SourceGraphic"/>
                        </feMerge>
                    </filter>
                    
                    <!-- Strong glow for major lines -->
                    <filter id="strong-glow" x="-50%" y="-50%" width="200%" height="200%">
                        <feGaussianBlur stdDeviation="0.8" result="coloredBlur"/>
                        <feMerge>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="SourceGraphic"/>
                        </feMerge>
                    </filter>
                </defs>
                
                <!-- HORIZONTAL GRID LINES - Receding into distance (creates depth) -->
                <g class="grid-lines">
                    <!-- Closest lines (bottom/foreground) - Brightest and thickest -->
                    <line x1="0" y1="95" x2="100" y2="95" stroke="#f97316" stroke-width="0.4" opacity="1" filter="url(#strong-glow)"/>
                    <line x1="0" y1="90" x2="100" y2="90" stroke="#f97316" stroke-width="0.35" opacity="0.95" filter="url(#neon-glow)"/>
                    <line x1="0" y1="85" x2="100" y2="85" stroke="#f97316" stroke-width="0.3" opacity="0.9" filter="url(#neon-glow)"/>
                    <line x1="0" y1="80" x2="100" y2="80" stroke="#f97316" stroke-width="0.28" opacity="0.85" filter="url(#neon-glow)"/>
                    <line x1="0" y1="75" x2="100" y2="75" stroke="#f97316" stroke-width="0.26" opacity="0.8" filter="url(#neon-glow)"/>
                    <line x1="0" y1="70" x2="100" y2="70" stroke="#f97316" stroke-width="0.24" opacity="0.75" filter="url(#neon-glow)"/>
                    <line x1="0" y1="65" x2="100" y2="65" stroke="#f97316" stroke-width="0.22" opacity="0.7" filter="url(#neon-glow)"/>
                    <line x1="0" y1="60" x2="100" y2="60" stroke="#f97316" stroke-width="0.2" opacity="0.65" filter="url(#neon-glow)"/>
                    <line x1="0" y1="55" x2="100" y2="55" stroke="#f97316" stroke-width="0.18" opacity="0.6" filter="url(#neon-glow)"/>
                    <line x1="0" y1="50" x2="100" y2="50" stroke="#f97316" stroke-width="0.16" opacity="0.55" filter="url(#neon-glow)"/>
                    <line x1="0" y1="45" x2="100" y2="45" stroke="#f97316" stroke-width="0.14" opacity="0.5" filter="url(#neon-glow)"/>
                    <line x1="0" y1="40" x2="100" y2="40" stroke="#f97316" stroke-width="0.12" opacity="0.45" filter="url(#neon-glow)"/>
                    <line x1="0" y1="35" x2="100" y2="35" stroke="#f97316" stroke-width="0.1" opacity="0.4" filter="url(#neon-glow)"/>
                    <line x1="0" y1="30" x2="100" y2="30" stroke="#f97316" stroke-width="0.08" opacity="0.35" filter="url(#neon-glow)"/>
                    <line x1="0" y1="25" x2="100" y2="25" stroke="#f97316" stroke-width="0.06" opacity="0.3" filter="url(#neon-glow)"/>
                    <line x1="0" y1="20" x2="100" y2="20" stroke="#f97316" stroke-width="0.05" opacity="0.25" filter="url(#neon-glow)"/>
                    <line x1="0" y1="15" x2="100" y2="15" stroke="#f97316" stroke-width="0.04" opacity="0.2" filter="url(#neon-glow)"/>
                    <line x1="0" y1="10" x2="100" y2="10" stroke="#f97316" stroke-width="0.03" opacity="0.15" filter="url(#neon-glow)"/>
                    
                    <!-- VERTICAL GRID LINES - Creating perfect squares with perspective -->
                    <!-- Left side -->
                    <line x1="5" y1="0" x2="5" y2="100" stroke="#f97316" stroke-width="0.3" opacity="0.9" filter="url(#neon-glow)"/>
                    <line x1="10" y1="0" x2="10" y2="100" stroke="#f97316" stroke-width="0.28" opacity="0.85" filter="url(#neon-glow)"/>
                    <line x1="15" y1="0" x2="15" y2="100" stroke="#f97316" stroke-width="0.26" opacity="0.8" filter="url(#neon-glow)"/>
                    <line x1="20" y1="0" x2="20" y2="100" stroke="#f97316" stroke-width="0.24" opacity="0.75" filter="url(#neon-glow)"/>
                    <line x1="25" y1="0" x2="25" y2="100" stroke="#f97316" stroke-width="0.22" opacity="0.7" filter="url(#neon-glow)"/>
                    <line x1="30" y1="0" x2="30" y2="100" stroke="#f97316" stroke-width="0.2" opacity="0.65" filter="url(#neon-glow)"/>
                    <line x1="35" y1="0" x2="35" y2="100" stroke="#f97316" stroke-width="0.18" opacity="0.6" filter="url(#neon-glow)"/>
                    <line x1="40" y1="0" x2="40" y2="100" stroke="#f97316" stroke-width="0.16" opacity="0.55" filter="url(#neon-glow)"/>
                    <line x1="45" y1="0" x2="45" y2="100" stroke="#f97316" stroke-width="0.14" opacity="0.5" filter="url(#neon-glow)"/>
                    
                    <!-- Center -->
                    <line x1="50" y1="0" x2="50" y2="100" stroke="#f97316" stroke-width="0.35" opacity="0.95" filter="url(#strong-glow)"/>
                    
                    <!-- Right side -->
                    <line x1="55" y1="0" x2="55" y2="100" stroke="#f97316" stroke-width="0.14" opacity="0.5" filter="url(#neon-glow)"/>
                    <line x1="60" y1="0" x2="60" y2="100" stroke="#f97316" stroke-width="0.16" opacity="0.55" filter="url(#neon-glow)"/>
                    <line x1="65" y1="0" x2="65" y2="100" stroke="#f97316" stroke-width="0.18" opacity="0.6" filter="url(#neon-glow)"/>
                    <line x1="70" y1="0" x2="70" y2="100" stroke="#f97316" stroke-width="0.2" opacity="0.65" filter="url(#neon-glow)"/>
                    <line x1="75" y1="0" x2="75" y2="100" stroke="#f97316" stroke-width="0.22" opacity="0.7" filter="url(#neon-glow)"/>
                    <line x1="80" y1="0" x2="80" y2="100" stroke="#f97316" stroke-width="0.24" opacity="0.75" filter="url(#neon-glow)"/>
                    <line x1="85" y1="0" x2="85" y2="100" stroke="#f97316" stroke-width="0.26" opacity="0.8" filter="url(#neon-glow)"/>
                    <line x1="90" y1="0" x2="90" y2="100" stroke="#f97316" stroke-width="0.28" opacity="0.85" filter="url(#neon-glow)"/>
                    <line x1="95" y1="0" x2="95" y2="100" stroke="#f97316" stroke-width="0.3" opacity="0.9" filter="url(#neon-glow)"/>
                    
                    <!-- Grid intersection highlights - pathway markers -->
                    <circle cx="50" cy="90" r="0.6" fill="#f97316" opacity="1" filter="url(#strong-glow)" class="pulse-node"/>
                    <circle cx="50" cy="70" r="0.5" fill="#f97316" opacity="0.9" filter="url(#strong-glow)" class="pulse-node" style="animation-delay: 0.3s"/>
                    <circle cx="50" cy="50" r="0.4" fill="#f97316" opacity="0.8" filter="url(#strong-glow)" class="pulse-node" style="animation-delay: 0.6s"/>
                    <circle cx="50" cy="30" r="0.3" fill="#f97316" opacity="0.7" filter="url(#strong-glow)" class="pulse-node" style="animation-delay: 0.9s"/>
                    
                    <!-- Side markers for depth -->
                    <circle cx="20" cy="80" r="0.4" fill="#f97316" opacity="0.6" filter="url(#neon-glow)" class="pulse-node" style="animation-delay: 0.2s"/>
                    <circle cx="80" cy="80" r="0.4" fill="#f97316" opacity="0.6" filter="url(#neon-glow)" class="pulse-node" style="animation-delay: 0.4s"/>
                    <circle cx="30" cy="60" r="0.3" fill="#f97316" opacity="0.5" filter="url(#neon-glow)" class="pulse-node" style="animation-delay: 0.5s"/>
                    <circle cx="70" cy="60" r="0.3" fill="#f97316" opacity="0.5" filter="url(#neon-glow)" class="pulse-node" style="animation-delay: 0.7s"/>
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
/* 4K-Quality Grid with Depth and Upward Pathway */
.grid-container {
    perspective: 600px;
    perspective-origin: 50% 50%;
}

.grid-container svg {
    transform-style: preserve-3d;
    transform: rotateX(70deg) translateZ(-50px);
    transform-origin: center bottom;
}

/* Smooth pulsing animation for pathway markers */
@keyframes pulse-node {
    0%, 100% {
        opacity: 0.4;
        transform: scale(1);
    }
    50% {
        opacity: 1;
        transform: scale(1.8);
    }
}

.pulse-node {
    animation: pulse-node 2.5s ease-in-out infinite;
}

/* Subtle upward movement animation for the entire grid */
@keyframes grid-flow {
    0% {
        transform: rotateX(70deg) translateZ(-50px) translateY(0);
    }
    100% {
        transform: rotateX(70deg) translateZ(-50px) translateY(-5px);
    }
}

.grid-lines {
    animation: grid-flow 4s linear infinite;
}

/* Ambient glow from the grid */
.grid-container::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 40%;
    background: radial-gradient(ellipse at center bottom, rgba(249, 115, 22, 0.15) 0%, transparent 70%);
    pointer-events: none;
}
</style>
