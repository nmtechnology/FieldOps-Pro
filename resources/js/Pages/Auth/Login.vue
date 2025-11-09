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
                    <!-- Gradient for elevation ramp effect -->
                    <linearGradient id="ramp-gradient" x1="0%" y1="100%" x2="0%" y2="0%">
                        <stop offset="0%" style="stop-color:#f97316;stop-opacity:0.8" />
                        <stop offset="50%" style="stop-color:#f97316;stop-opacity:0.4" />
                        <stop offset="100%" style="stop-color:#f97316;stop-opacity:0.1" />
                    </linearGradient>
                    
                    <!-- Glow effect for grid lines -->
                    <filter id="glow">
                        <feGaussianBlur stdDeviation="1.5" result="coloredBlur"/>
                        <feMerge>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="SourceGraphic"/>
                        </feMerge>
                    </filter>
                </defs>
                
                <!-- 3D Elevated Ramp Grid - Square Grid Forming Elevation -->
                <g class="ramp-animation" filter="url(#glow)">
                    <!-- Horizontal grid lines (perpendicular to viewer) forming the floor/ramp -->
                    <!-- Bottom rows - closest to viewer (thicker, brighter) -->
                    <line x1="10%" y1="95%" x2="90%" y2="95%" stroke="#f97316" stroke-width="2.5" opacity="0.9"/>
                    <line x1="12%" y1="91%" x2="88%" y2="91%" stroke="#f97316" stroke-width="2.3" opacity="0.85"/>
                    <line x1="14%" y1="87%" x2="86%" y2="87%" stroke="#f97316" stroke-width="2.1" opacity="0.8"/>
                    <line x1="16%" y1="83%" x2="84%" y2="83%" stroke="#f97316" stroke-width="1.9" opacity="0.75"/>
                    <line x1="18%" y1="79%" x2="82%" y2="79%" stroke="#f97316" stroke-width="1.7" opacity="0.7"/>
                    <line x1="20%" y1="75%" x2="80%" y2="75%" stroke="#f97316" stroke-width="1.5" opacity="0.65"/>
                    <line x1="22%" y1="71%" x2="78%" y2="71%" stroke="#f97316" stroke-width="1.4" opacity="0.6"/>
                    <line x1="24%" y1="67%" x2="76%" y2="67%" stroke="#f97316" stroke-width="1.3" opacity="0.55"/>
                    <line x1="26%" y1="63%" x2="74%" y2="63%" stroke="#f97316" stroke-width="1.2" opacity="0.5"/>
                    <line x1="28%" y1="59%" x2="72%" y2="59%" stroke="#f97316" stroke-width="1.1" opacity="0.45"/>
                    <line x1="30%" y1="55%" x2="70%" y2="55%" stroke="#f97316" stroke-width="1.0" opacity="0.4"/>
                    <line x1="32%" y1="51%" x2="68%" y2="51%" stroke="#f97316" stroke-width="0.9" opacity="0.35"/>
                    <line x1="34%" y1="47%" x2="66%" y2="47%" stroke="#f97316" stroke-width="0.8" opacity="0.3"/>
                    <line x1="36%" y1="43%" x2="64%" y2="43%" stroke="#f97316" stroke-width="0.7" opacity="0.25"/>
                    <line x1="38%" y1="39%" x2="62%" y2="39%" stroke="#f97316" stroke-width="0.6" opacity="0.2"/>
                    <line x1="40%" y1="35%" x2="60%" y2="35%" stroke="#f97316" stroke-width="0.5" opacity="0.15"/>
                    
                    <!-- Vertical grid lines (left side) - creating square grid cells -->
                    <line x1="10%" y1="95%" x2="40%" y2="35%" stroke="#f97316" stroke-width="2.5" opacity="0.9"/>
                    <line x1="18%" y1="95%" x2="43%" y2="35%" stroke="#f97316" stroke-width="2.0" opacity="0.75"/>
                    <line x1="26%" y1="95%" x2="46%" y2="35%" stroke="#f97316" stroke-width="1.6" opacity="0.6"/>
                    <line x1="34%" y1="95%" x2="48%" y2="35%" stroke="#f97316" stroke-width="1.3" opacity="0.5"/>
                    <line x1="42%" y1="95%" x2="49.5%" y2="35%" stroke="#f97316" stroke-width="1.0" opacity="0.4"/>
                    <line x1="50%" y1="95%" x2="50%" y2="35%" stroke="#f97316" stroke-width="0.8" opacity="0.35"/>
                    
                    <!-- Vertical grid lines (right side) - creating square grid cells -->
                    <line x1="58%" y1="95%" x2="50.5%" y2="35%" stroke="#f97316" stroke-width="1.0" opacity="0.4"/>
                    <line x1="66%" y1="95%" x2="52%" y2="35%" stroke="#f97316" stroke-width="1.3" opacity="0.5"/>
                    <line x1="74%" y1="95%" x2="54%" y2="35%" stroke="#f97316" stroke-width="1.6" opacity="0.6"/>
                    <line x1="82%" y1="95%" x2="57%" y2="35%" stroke="#f97316" stroke-width="2.0" opacity="0.75"/>
                    <line x1="90%" y1="95%" x2="60%" y2="35%" stroke="#f97316" stroke-width="2.5" opacity="0.9"/>
                    
                    <!-- Additional vertical lines for finer grid detail -->
                    <line x1="14%" y1="95%" x2="41.5%" y2="35%" stroke="#f97316" stroke-width="1.2" opacity="0.4"/>
                    <line x1="22%" y1="95%" x2="44.5%" y2="35%" stroke="#f97316" stroke-width="1.0" opacity="0.35"/>
                    <line x1="30%" y1="95%" x2="47%" y2="35%" stroke="#f97316" stroke-width="0.9" opacity="0.3"/>
                    <line x1="38%" y1="95%" x2="48.8%" y2="35%" stroke="#f97316" stroke-width="0.8" opacity="0.25"/>
                    <line x1="46%" y1="95%" x2="49.8%" y2="35%" stroke="#f97316" stroke-width="0.7" opacity="0.2"/>
                    
                    <line x1="54%" y1="95%" x2="50.2%" y2="35%" stroke="#f97316" stroke-width="0.7" opacity="0.2"/>
                    <line x1="62%" y1="95%" x2="51.2%" y2="35%" stroke="#f97316" stroke-width="0.8" opacity="0.25"/>
                    <line x1="70%" y1="95%" x2="53%" y2="35%" stroke="#f97316" stroke-width="0.9" opacity="0.3"/>
                    <line x1="78%" y1="95%" x2="55.5%" y2="35%" stroke="#f97316" stroke-width="1.0" opacity="0.35"/>
                    <line x1="86%" y1="95%" x2="58.5%" y2="35%" stroke="#f97316" stroke-width="1.2" opacity="0.4"/>
                    
                    <!-- Grid intersection nodes (bottom row - most prominent) -->
                    <circle cx="10%" cy="95%" r="3.5" fill="#f97316" opacity="0.9"/>
                    <circle cx="18%" cy="95%" r="3" fill="#f97316" opacity="0.8"/>
                    <circle cx="26%" cy="95%" r="2.5" fill="#f97316" opacity="0.7"/>
                    <circle cx="34%" cy="95%" r="2" fill="#f97316" opacity="0.6"/>
                    <circle cx="42%" cy="95%" r="1.8" fill="#f97316" opacity="0.5"/>
                    <circle cx="50%" cy="95%" r="1.5" fill="#f97316" opacity="0.5"/>
                    <circle cx="58%" cy="95%" r="1.8" fill="#f97316" opacity="0.5"/>
                    <circle cx="66%" cy="95%" r="2" fill="#f97316" opacity="0.6"/>
                    <circle cx="74%" cy="95%" r="2.5" fill="#f97316" opacity="0.7"/>
                    <circle cx="82%" cy="95%" r="3" fill="#f97316" opacity="0.8"/>
                    <circle cx="90%" cy="95%" r="3.5" fill="#f97316" opacity="0.9"/>
                    
                    <!-- Pulsing elevation markers showing the upward journey -->
                    <circle cx="25%" cy="80%" r="2.5" fill="#f97316" opacity="0.9" class="pulse-node"/>
                    <circle cx="40%" cy="65%" r="2" fill="#f97316" opacity="0.8" class="pulse-node"/>
                    <circle cx="50%" cy="55%" r="1.8" fill="#f97316" opacity="0.7" class="pulse-node"/>
                    <circle cx="60%" cy="65%" r="2" fill="#f97316" opacity="0.8" class="pulse-node"/>
                    <circle cx="75%" cy="80%" r="2.5" fill="#f97316" opacity="0.9" class="pulse-node"/>
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
/* Elevated Ramp Animation - Ascending Grid */
@keyframes ramp-ascend {
    0% {
        transform: perspective(1200px) rotateX(55deg) translateY(0);
    }
    100% {
        transform: perspective(1200px) rotateX(55deg) translateY(30px);
    }
}

@keyframes pulse-node {
    0%, 100% {
        opacity: 0.4;
    }
    50% {
        opacity: 1;
    }
}

.ramp-animation {
    animation: ramp-ascend 25s linear infinite;
    transform-origin: center bottom;
}

.pulse-node {
    animation: pulse-node 3s ease-in-out infinite;
}

/* Additional depth for the elevation effect */
@keyframes elevation-glow {
    0%, 100% {
        filter: drop-shadow(0 0 8px rgba(249, 115, 22, 0.4));
    }
    50% {
        filter: drop-shadow(0 0 15px rgba(249, 115, 22, 0.6));
    }
}
</style>
