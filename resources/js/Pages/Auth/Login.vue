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
    <div class="relative min-h-screen bg-black flex flex-col items-center pt-6 sm:justify-center sm:pt-0">
        <!-- 3D Matrix Grid Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="absolute inset-0" preserveAspectRatio="xMidYMid slice">
                <defs>
                    <!-- Gradient for depth effect -->
                    <linearGradient id="grid-gradient" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#f97316;stop-opacity:0.1" />
                        <stop offset="50%" style="stop-color:#f97316;stop-opacity:0.3" />
                        <stop offset="100%" style="stop-color:#f97316;stop-opacity:0.6" />
                    </linearGradient>
                    
                    <!-- Glow effect for grid lines -->
                    <filter id="glow">
                        <feGaussianBlur stdDeviation="2" result="coloredBlur"/>
                        <feMerge>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="SourceGraphic"/>
                        </feMerge>
                    </filter>
                </defs>
                
                <!-- 3D Perspective Grid -->
                <g class="grid-animation" filter="url(#glow)">
                    <!-- Horizontal lines (receding into distance) - perspective effect -->
                    <line x1="0" y1="100%" x2="100%" y2="100%" stroke="url(#grid-gradient)" stroke-width="2" opacity="0.8"/>
                    <line x1="5%" y1="95%" x2="95%" y2="95%" stroke="url(#grid-gradient)" stroke-width="1.8" opacity="0.75"/>
                    <line x1="10%" y1="90%" x2="90%" y2="90%" stroke="url(#grid-gradient)" stroke-width="1.6" opacity="0.7"/>
                    <line x1="15%" y1="85%" x2="85%" y2="85%" stroke="url(#grid-gradient)" stroke-width="1.4" opacity="0.65"/>
                    <line x1="20%" y1="80%" x2="80%" y2="80%" stroke="url(#grid-gradient)" stroke-width="1.2" opacity="0.6"/>
                    <line x1="25%" y1="75%" x2="75%" y2="75%" stroke="url(#grid-gradient)" stroke-width="1" opacity="0.55"/>
                    <line x1="30%" y1="70%" x2="70%" y2="70%" stroke="url(#grid-gradient)" stroke-width="0.8" opacity="0.5"/>
                    <line x1="35%" y1="65%" x2="65%" y2="65%" stroke="url(#grid-gradient)" stroke-width="0.6" opacity="0.45"/>
                    <line x1="40%" y1="60%" x2="60%" y2="60%" stroke="url(#grid-gradient)" stroke-width="0.5" opacity="0.4"/>
                    <line x1="42%" y1="55%" x2="58%" y2="55%" stroke="url(#grid-gradient)" stroke-width="0.4" opacity="0.35"/>
                    <line x1="44%" y1="50%" x2="56%" y2="50%" stroke="url(#grid-gradient)" stroke-width="0.3" opacity="0.3"/>
                    <line x1="46%" y1="45%" x2="54%" y2="45%" stroke="url(#grid-gradient)" stroke-width="0.2" opacity="0.25"/>
                    <line x1="48%" y1="40%" x2="52%" y2="40%" stroke="url(#grid-gradient)" stroke-width="0.1" opacity="0.2"/>
                    
                    <!-- Vertical lines (perspective converging to center) - left to center -->
                    <line x1="0" y1="100%" x2="48%" y2="40%" stroke="#f97316" stroke-width="2" opacity="0.6"/>
                    <line x1="10%" y1="100%" x2="49%" y2="40%" stroke="#f97316" stroke-width="1.8" opacity="0.55"/>
                    <line x1="20%" y1="100%" x2="49.5%" y2="40%" stroke="#f97316" stroke-width="1.6" opacity="0.5"/>
                    <line x1="30%" y1="100%" x2="49.8%" y2="40%" stroke="#f97316" stroke-width="1.4" opacity="0.45"/>
                    <line x1="40%" y1="100%" x2="50%" y2="40%" stroke="#f97316" stroke-width="1.2" opacity="0.4"/>
                    
                    <!-- Vertical lines (perspective converging to center) - right to center -->
                    <line x1="100%" y1="100%" x2="52%" y2="40%" stroke="#f97316" stroke-width="2" opacity="0.6"/>
                    <line x1="90%" y1="100%" x2="51%" y2="40%" stroke="#f97316" stroke-width="1.8" opacity="0.55"/>
                    <line x1="80%" y1="100%" x2="50.5%" y2="40%" stroke="#f97316" stroke-width="1.6" opacity="0.5"/>
                    <line x1="70%" y1="100%" x2="50.2%" y2="40%" stroke="#f97316" stroke-width="1.4" opacity="0.45"/>
                    <line x1="60%" y1="100%" x2="50%" y2="40%" stroke="#f97316" stroke-width="1.2" opacity="0.4"/>
                    
                    <!-- Additional grid detail for depth -->
                    <line x1="5%" y1="100%" x2="48.5%" y2="40%" stroke="#f97316" stroke-width="1" opacity="0.3"/>
                    <line x1="15%" y1="100%" x2="49%" y2="40%" stroke="#f97316" stroke-width="1" opacity="0.3"/>
                    <line x1="25%" y1="100%" x2="49.5%" y2="40%" stroke="#f97316" stroke-width="1" opacity="0.3"/>
                    <line x1="35%" y1="100%" x2="49.9%" y2="40%" stroke="#f97316" stroke-width="1" opacity="0.3"/>
                    
                    <line x1="95%" y1="100%" x2="51.5%" y2="40%" stroke="#f97316" stroke-width="1" opacity="0.3"/>
                    <line x1="85%" y1="100%" x2="51%" y2="40%" stroke="#f97316" stroke-width="1" opacity="0.3"/>
                    <line x1="75%" y1="100%" x2="50.5%" y2="40%" stroke="#f97316" stroke-width="1" opacity="0.3"/>
                    <line x1="65%" y1="100%" x2="50.1%" y2="40%" stroke="#f97316" stroke-width="1" opacity="0.3"/>
                    
                    <!-- Intersection nodes for 3D effect -->
                    <circle cx="0" cy="100%" r="3" fill="#f97316" opacity="0.6"/>
                    <circle cx="10%" cy="100%" r="3" fill="#f97316" opacity="0.6"/>
                    <circle cx="20%" cy="100%" r="3" fill="#f97316" opacity="0.6"/>
                    <circle cx="30%" cy="100%" r="3" fill="#f97316" opacity="0.6"/>
                    <circle cx="40%" cy="100%" r="3" fill="#f97316" opacity="0.6"/>
                    <circle cx="60%" cy="100%" r="3" fill="#f97316" opacity="0.6"/>
                    <circle cx="70%" cy="100%" r="3" fill="#f97316" opacity="0.6"/>
                    <circle cx="80%" cy="100%" r="3" fill="#f97316" opacity="0.6"/>
                    <circle cx="90%" cy="100%" r="3" fill="#f97316" opacity="0.6"/>
                    <circle cx="100%" cy="100%" r="3" fill="#f97316" opacity="0.6"/>
                    
                    <!-- Pulsing data points -->
                    <circle cx="20%" cy="85%" r="2" fill="#f97316" opacity="0.8" class="pulse-node"/>
                    <circle cx="35%" cy="75%" r="2" fill="#f97316" opacity="0.8" class="pulse-node"/>
                    <circle cx="50%" cy="65%" r="2" fill="#f97316" opacity="0.8" class="pulse-node"/>
                    <circle cx="65%" cy="75%" r="2" fill="#f97316" opacity="0.8" class="pulse-node"/>
                    <circle cx="80%" cy="85%" r="2" fill="#f97316" opacity="0.8" class="pulse-node"/>
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
/* 3D Matrix Grid Animation */
@keyframes matrix-flow {
    0% {
        transform: perspective(1000px) rotateX(0deg) translateY(0);
    }
    100% {
        transform: perspective(1000px) rotateX(0deg) translateY(50px);
    }
}

@keyframes pulse-node {
    0%, 100% {
        opacity: 0.4;
        r: 2;
    }
    50% {
        opacity: 1;
        r: 4;
    }
}

.grid-animation {
    animation: matrix-flow 20s linear infinite;
    transform-origin: center bottom;
}

.pulse-node {
    animation: pulse-node 2s ease-in-out infinite;
}

/* Parallax depth effect on scroll */
@keyframes depth-shift {
    0%, 100% {
        transform: perspective(1500px) rotateX(60deg) translateZ(0);
    }
    50% {
        transform: perspective(1500px) rotateX(60deg) translateZ(50px);
    }
}
</style>
