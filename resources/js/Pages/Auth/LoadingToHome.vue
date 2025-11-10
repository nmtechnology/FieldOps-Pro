<script setup>
import { onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

onMounted(() => {
    // Show loading animation for 2.5 seconds, then redirect to home
    setTimeout(() => {
        router.visit('/');
    }, 2500);
});
</script>

<template>
    <div class="min-h-screen bg-gray-900 flex items-center justify-center">
        <div class="text-center">
            <!-- Success Checkmark Animation -->
            <div class="mb-8 flex justify-center">
                <div class="relative">
                    <div class="w-24 h-24 border-4 border-green-500 rounded-full flex items-center justify-center animate-scale-in">
                        <svg class="w-12 h-12 text-green-500 animate-check-draw" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <!-- Glow effect -->
                    <div class="absolute inset-0 bg-green-500/30 rounded-full blur-xl animate-pulse"></div>
                </div>
            </div>
            
            <!-- Success Message -->
            <h1 class="text-3xl font-bold text-white mb-3 animate-fade-in">
                ✓ Verified!
            </h1>
            <p class="text-lg text-gray-300 mb-6 animate-fade-in-delayed">
                Welcome to FieldEngineer Pro
            </p>
            
            <!-- Loading Spinner -->
            <div class="flex items-center justify-center space-x-2 animate-fade-in-delayed-2">
                <div class="w-2 h-2 bg-orange-500 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
                <div class="w-2 h-2 bg-orange-500 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                <div class="w-2 h-2 bg-orange-500 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes scale-in {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes check-draw {
    0% {
        stroke-dasharray: 100;
        stroke-dashoffset: 100;
    }
    100% {
        stroke-dasharray: 100;
        stroke-dashoffset: 0;
    }
}

@keyframes fade-in {
    0% {
        opacity: 0;
        transform: translateY(10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-scale-in {
    animation: scale-in 0.5s ease-out;
}

.animate-check-draw {
    stroke-dasharray: 100;
    animation: check-draw 0.5s ease-out 0.3s forwards;
}

.animate-fade-in {
    animation: fade-in 0.5s ease-out 0.8s both;
}

.animate-fade-in-delayed {
    animation: fade-in 0.5s ease-out 1s both;
}

.animate-fade-in-delayed-2 {
    animation: fade-in 0.5s ease-out 1.2s both;
}
</style>
