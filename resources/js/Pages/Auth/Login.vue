<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import MathPuzzle from '@/Components/MathPuzzle.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

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

const puzzleSolved = ref(false);

const submit = () => {
    if (!puzzleSolved.value) {
        alert('Please solve the math puzzle first');
        return;
    }
    
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="relative min-h-screen bg-black flex flex-col items-center pt-6 sm:justify-center sm:pt-0 overflow-hidden">
        <!-- 3D Matrix Grid Background - Upward Ramp with Extended Depth -->
        <div class="fixed inset-0 grid-container pointer-events-none">
            <svg class="absolute w-full h-full" viewBox="0 0 100 120" preserveAspectRatio="xMidYMid slice">
                <defs>
                    <filter id="grid-glow">
                        <feGaussianBlur stdDeviation="1.5" result="coloredBlur"/>
                        <feMerge>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="coloredBlur"/>
                            <feMergeNode in="SourceGraphic"/>
                        </feMerge>
                    </filter>
                </defs>
                
                <g class="grid-lines" filter="url(#grid-glow)">
                    <!-- HORIZONTAL LINES - Extended far into distance -->
                    <!-- Foreground - Very close and large -->
                    <line x1="0" y1="120" x2="100" y2="120" stroke="#0ea5e9" stroke-width="2.5" opacity="1"/>
                    <line x1="0" y1="115" x2="100" y2="115" stroke="#0ea5e9" stroke-width="2.3" opacity="0.98"/>
                    <line x1="0" y1="110" x2="100" y2="110" stroke="#0ea5e9" stroke-width="2.1" opacity="0.96"/>
                    <line x1="0" y1="105" x2="100" y2="105" stroke="#0ea5e9" stroke-width="1.9" opacity="0.94"/>
                    <line x1="0" y1="100" x2="100" y2="100" stroke="#0ea5e9" stroke-width="1.7" opacity="0.92"/>
                    <line x1="0" y1="95" x2="100" y2="95" stroke="#0ea5e9" stroke-width="1.5" opacity="0.9"/>
                    <line x1="0" y1="90" x2="100" y2="90" stroke="#0ea5e9" stroke-width="1.4" opacity="0.85"/>
                    <line x1="0" y1="85" x2="100" y2="85" stroke="#0ea5e9" stroke-width="1.3" opacity="0.8"/>
                    <line x1="0" y1="80" x2="100" y2="80" stroke="#0ea5e9" stroke-width="1.2" opacity="0.75"/>
                    <line x1="0" y1="75" x2="100" y2="75" stroke="#0ea5e9" stroke-width="1.1" opacity="0.7"/>
                    <line x1="0" y1="70" x2="100" y2="70" stroke="#0ea5e9" stroke-width="1" opacity="0.65"/>
                    <line x1="0" y1="65" x2="100" y2="65" stroke="#0ea5e9" stroke-width="0.9" opacity="0.6"/>
                    <line x1="0" y1="60" x2="100" y2="60" stroke="#0ea5e9" stroke-width="0.8" opacity="0.55"/>
                    <line x1="0" y1="55" x2="100" y2="55" stroke="#0ea5e9" stroke-width="0.7" opacity="0.5"/>
                    <line x1="0" y1="50" x2="100" y2="50" stroke="#0ea5e9" stroke-width="0.6" opacity="0.45"/>
                    <line x1="0" y1="45" x2="100" y2="45" stroke="#0ea5e9" stroke-width="0.5" opacity="0.4"/>
                    <line x1="0" y1="40" x2="100" y2="40" stroke="#0ea5e9" stroke-width="0.4" opacity="0.35"/>
                    <line x1="0" y1="35" x2="100" y2="35" stroke="#0ea5e9" stroke-width="0.35" opacity="0.3"/>
                    <line x1="0" y1="30" x2="100" y2="30" stroke="#0ea5e9" stroke-width="0.3" opacity="0.25"/>
                    <line x1="0" y1="25" x2="100" y2="25" stroke="#0ea5e9" stroke-width="0.25" opacity="0.2"/>
                    <line x1="0" y1="20" x2="100" y2="20" stroke="#0ea5e9" stroke-width="0.2" opacity="0.15"/>
                    <line x1="0" y1="15" x2="100" y2="15" stroke="#0ea5e9" stroke-width="0.15" opacity="0.1"/>
                    <line x1="0" y1="10" x2="100" y2="10" stroke="#0ea5e9" stroke-width="0.1" opacity="0.08"/>
                    <line x1="0" y1="5" x2="100" y2="5" stroke="#0ea5e9" stroke-width="0.08" opacity="0.05"/>
                    
                    <!-- VERTICAL LINES - Wider at edges for perspective -->
                    <line x1="0" y1="0" x2="0" y2="120" stroke="#0ea5e9" stroke-width="1.8" opacity="0.95"/>
                    <line x1="5" y1="0" x2="5" y2="120" stroke="#0ea5e9" stroke-width="1.5" opacity="0.9"/>
                    <line x1="10" y1="0" x2="10" y2="120" stroke="#0ea5e9" stroke-width="1.3" opacity="0.85"/>
                    <line x1="15" y1="0" x2="15" y2="120" stroke="#0ea5e9" stroke-width="1.1" opacity="0.8"/>
                    <line x1="20" y1="0" x2="20" y2="120" stroke="#0ea5e9" stroke-width="0.9" opacity="0.75"/>
                    <line x1="25" y1="0" x2="25" y2="120" stroke="#0ea5e9" stroke-width="0.8" opacity="0.7"/>
                    <line x1="30" y1="0" x2="30" y2="120" stroke="#0ea5e9" stroke-width="0.7" opacity="0.65"/>
                    <line x1="35" y1="0" x2="35" y2="120" stroke="#0ea5e9" stroke-width="0.6" opacity="0.6"/>
                    <line x1="40" y1="0" x2="40" y2="120" stroke="#0ea5e9" stroke-width="0.5" opacity="0.55"/>
                    <line x1="45" y1="0" x2="45" y2="120" stroke="#0ea5e9" stroke-width="0.45" opacity="0.5"/>
                    <line x1="50" y1="0" x2="50" y2="120" stroke="#0ea5e9" stroke-width="0.4" opacity="0.45"/>
                    <line x1="55" y1="0" x2="55" y2="120" stroke="#0ea5e9" stroke-width="0.45" opacity="0.5"/>
                    <line x1="60" y1="0" x2="60" y2="120" stroke="#0ea5e9" stroke-width="0.5" opacity="0.55"/>
                    <line x1="65" y1="0" x2="65" y2="120" stroke="#0ea5e9" stroke-width="0.6" opacity="0.6"/>
                    <line x1="70" y1="0" x2="70" y2="120" stroke="#0ea5e9" stroke-width="0.7" opacity="0.65"/>
                    <line x1="75" y1="0" x2="75" y2="120" stroke="#0ea5e9" stroke-width="0.8" opacity="0.7"/>
                    <line x1="80" y1="0" x2="80" y2="120" stroke="#0ea5e9" stroke-width="0.9" opacity="0.75"/>
                    <line x1="85" y1="0" x2="85" y2="120" stroke="#0ea5e9" stroke-width="1.1" opacity="0.8"/>
                    <line x1="90" y1="0" x2="90" y2="120" stroke="#0ea5e9" stroke-width="1.3" opacity="0.85"/>
                    <line x1="95" y1="0" x2="95" y2="120" stroke="#0ea5e9" stroke-width="1.5" opacity="0.9"/>
                    <line x1="100" y1="0" x2="100" y2="120" stroke="#0ea5e9" stroke-width="1.8" opacity="0.95"/>
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

                <!-- Math Puzzle for Security -->
                <MathPuzzle @verified="puzzleSolved = true" />

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

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-300">
                        Don't have an account yet?
                        <Link
                            :href="route('register')"
                            class="text-orange-400 hover:text-orange-300 font-semibold underline transition-colors"
                        >
                            Register here
                        </Link>
                    </p>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
/* 3D Upward Ramp Grid - Static with Extended Depth */
.grid-container {
    perspective: 150px;
    perspective-origin: 50% 90%;
    overflow: hidden;
}

.grid-container svg {
    transform-style: preserve-3d;
    transform: rotateX(70deg) translateY(15%) scale(2.2);
    transform-origin: center bottom;
}

/* Dramatic horizon glow for extended depth */
.grid-container::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 70%;
    background: radial-gradient(ellipse at center bottom, rgba(14, 165, 233, 0.25) 0%, rgba(14, 165, 233, 0.1) 30%, transparent 70%);
    pointer-events: none;
}
</style>

