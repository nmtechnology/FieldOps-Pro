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
    <div class="relative min-h-screen bg-gradient-to-b from-gray-950 via-black to-gray-950 flex flex-col items-center pt-6 sm:justify-center sm:pt-0">
        <!-- 3D Matrix Grid Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none" class="absolute inset-0 w-full h-full" style="transform: perspective(1200px) rotateX(55deg); transform-origin: center bottom;">
                <defs>
                    <!-- Gradient for elevation ramp effect -->
                    <linearGradient id="ramp-gradient" x1="0%" y1="100%" x2="0%" y2="0%">
                        <stop offset="0%" style="stop-color:#f97316;stop-opacity:0.8" />
                        <stop offset="50%" style="stop-color:#f97316;stop-opacity:0.4" />
                        <stop offset="100%" style="stop-color:#f97316;stop-opacity:0.1" />
                    </linearGradient>
                    
                    <!-- Glow effect for grid lines -->
                    <filter id="glow">
                        <feGaussianBlur stdDeviation="0.3" result="coloredBlur"/>
                        <feMerge>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="SourceGraphic"/>
                        </feMerge>
                    </filter>
                </defs>
                
                <!-- 3D Elevated Ramp Grid - Square Grid Forming Elevation -->
                <g filter="url(#glow)">
                    <!-- Horizontal grid lines (perpendicular to viewer) forming the floor/ramp -->
                    <!-- Bottom rows - closest to viewer (thicker, brighter) -->
                    <line x1="5" y1="95" x2="95" y2="95" stroke="#f97316" stroke-width="0.4" opacity="0.9"/>
                    <line x1="8" y1="90" x2="92" y2="90" stroke="#f97316" stroke-width="0.38" opacity="0.85"/>
                    <line x1="11" y1="85" x2="89" y2="85" stroke="#f97316" stroke-width="0.36" opacity="0.8"/>
                    <line x1="14" y1="80" x2="86" y2="80" stroke="#f97316" stroke-width="0.34" opacity="0.75"/>
                    <line x1="17" y1="75" x2="83" y2="75" stroke="#f97316" stroke-width="0.32" opacity="0.7"/>
                    <line x1="20" y1="70" x2="80" y2="70" stroke="#f97316" stroke-width="0.3" opacity="0.65"/>
                    <line x1="23" y1="65" x2="77" y2="65" stroke="#f97316" stroke-width="0.28" opacity="0.6"/>
                    <line x1="26" y1="60" x2="74" y2="60" stroke="#f97316" stroke-width="0.26" opacity="0.55"/>
                    <line x1="29" y1="55" x2="71" y2="55" stroke="#f97316" stroke-width="0.24" opacity="0.5"/>
                    <line x1="32" y1="50" x2="68" y2="50" stroke="#f97316" stroke-width="0.22" opacity="0.45"/>
                    <line x1="35" y1="45" x2="65" y2="45" stroke="#f97316" stroke-width="0.2" opacity="0.4"/>
                    <line x1="38" y1="40" x2="62" y2="40" stroke="#f97316" stroke-width="0.18" opacity="0.35"/>
                    <line x1="41" y1="35" x2="59" y2="35" stroke="#f97316" stroke-width="0.16" opacity="0.3"/>
                    <line x1="44" y1="30" x2="56" y2="30" stroke="#f97316" stroke-width="0.14" opacity="0.25"/>
                    <line x1="47" y1="25" x2="53" y2="25" stroke="#f97316" stroke-width="0.12" opacity="0.2"/>
                    
                    <!-- Vertical grid lines (left side) - creating square grid cells -->
                    <line x1="5" y1="95" x2="47" y2="25" stroke="#f97316" stroke-width="0.4" opacity="0.9"/>
                    <line x1="15" y1="95" x2="48" y2="25" stroke="#f97316" stroke-width="0.35" opacity="0.75"/>
                    <line x1="25" y1="95" x2="49" y2="25" stroke="#f97316" stroke-width="0.3" opacity="0.6"/>
                    <line x1="35" y1="95" x2="49.5" y2="25" stroke="#f97316" stroke-width="0.25" opacity="0.5"/>
                    <line x1="45" y1="95" x2="50" y2="25" stroke="#f97316" stroke-width="0.2" opacity="0.4"/>
                    
                    <!-- Vertical grid lines (right side) - creating square grid cells -->
                    <line x1="55" y1="95" x2="50" y2="25" stroke="#f97316" stroke-width="0.2" opacity="0.4"/>
                    <line x1="65" y1="95" x2="50.5" y2="25" stroke="#f97316" stroke-width="0.25" opacity="0.5"/>
                    <line x1="75" y1="95" x2="51" y2="25" stroke="#f97316" stroke-width="0.3" opacity="0.6"/>
                    <line x1="85" y1="95" x2="52" y2="25" stroke="#f97316" stroke-width="0.35" opacity="0.75"/>
                    <line x1="95" y1="95" x2="53" y2="25" stroke="#f97316" stroke-width="0.4" opacity="0.9"/>
                    
                    <!-- Additional vertical lines for finer grid detail -->
                    <line x1="10" y1="95" x2="47.5" y2="25" stroke="#f97316" stroke-width="0.25" opacity="0.5"/>
                    <line x1="20" y1="95" x2="48.5" y2="25" stroke="#f97316" stroke-width="0.22" opacity="0.45"/>
                    <line x1="30" y1="95" x2="49.2" y2="25" stroke="#f97316" stroke-width="0.2" opacity="0.4"/>
                    <line x1="40" y1="95" x2="49.7" y2="25" stroke="#f97316" stroke-width="0.18" opacity="0.35"/>
                    
                    <line x1="60" y1="95" x2="50.3" y2="25" stroke="#f97316" stroke-width="0.18" opacity="0.35"/>
                    <line x1="70" y1="95" x2="50.8" y2="25" stroke="#f97316" stroke-width="0.2" opacity="0.4"/>
                    <line x1="80" y1="95" x2="51.5" y2="25" stroke="#f97316" stroke-width="0.22" opacity="0.45"/>
                    <line x1="90" y1="95" x2="52.5" y2="25" stroke="#f97316" stroke-width="0.25" opacity="0.5"/>
                    
                    <!-- Grid intersection nodes (bottom row - most prominent) -->
                    <circle cx="5" cy="95" r="0.6" fill="#f97316" opacity="0.9"/>
                    <circle cx="15" cy="95" r="0.5" fill="#f97316" opacity="0.8"/>
                    <circle cx="25" cy="95" r="0.45" fill="#f97316" opacity="0.7"/>
                    <circle cx="35" cy="95" r="0.4" fill="#f97316" opacity="0.6"/>
                    <circle cx="45" cy="95" r="0.35" fill="#f97316" opacity="0.5"/>
                    <circle cx="55" cy="95" r="0.35" fill="#f97316" opacity="0.5"/>
                    <circle cx="65" cy="95" r="0.4" fill="#f97316" opacity="0.6"/>
                    <circle cx="75" cy="95" r="0.45" fill="#f97316" opacity="0.7"/>
                    <circle cx="85" cy="95" r="0.5" fill="#f97316" opacity="0.8"/>
                    <circle cx="95" cy="95" r="0.6" fill="#f97316" opacity="0.9"/>
                    
                    <!-- Pulsing elevation markers showing the upward journey -->
                    <circle cx="20" cy="80" r="0.4" fill="#f97316" opacity="0.9" class="pulse-node"/>
                    <circle cx="35" cy="65" r="0.35" fill="#f97316" opacity="0.8" class="pulse-node"/>
                    <circle cx="50" cy="50" r="0.3" fill="#f97316" opacity="0.7" class="pulse-node"/>
                    <circle cx="65" cy="65" r="0.35" fill="#f97316" opacity="0.8" class="pulse-node"/>
                    <circle cx="80" cy="80" r="0.4" fill="#f97316" opacity="0.9" class="pulse-node"/>
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
/* Pulsing node animation */
@keyframes pulse-node {
    0%, 100% {
        opacity: 0.4;
    }
    50% {
        opacity: 1;
    }
}

.pulse-node {
    animation: pulse-node 3s ease-in-out infinite;
}
</style>
