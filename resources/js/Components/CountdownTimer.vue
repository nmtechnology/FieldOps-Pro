<template>
    <!-- Mobile: Full-width banner at top ABOVE navbar -->
    <div v-if="showTimer" class="fixed top-0 left-0 right-0 md:top-4 md:left-auto md:right-4 md:max-w-sm z-[60] bg-gradient-to-r from-red-600 to-orange-600 text-white px-3 py-2 md:px-6 md:py-4 md:rounded-lg shadow-2xl border-b-2 md:border-2 border-yellow-400 animate-pulse-slow">
        <div class="flex items-center justify-center md:justify-start space-x-2 md:space-x-3">
            <svg class="w-4 h-4 md:w-6 md:h-6 text-yellow-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
            </svg>
            <div class="min-w-0 flex items-center md:block space-x-2 md:space-x-0">
                <div class="text-[10px] md:text-xs font-semibold uppercase tracking-wide truncate">🎉 Sale!</div>
                <div class="text-base md:text-2xl font-black tabular-nums">
                    {{ formattedTime }}
                </div>
                <div class="text-[10px] md:text-xs opacity-90 font-bold truncate hidden md:block">💥 50% OFF - Ends Dec 31st!</div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const showTimer = ref(true);
const days = ref(0);
const hours = ref(0);
const minutes = ref(0);
const seconds = ref(0);
let interval = null;

// Target: December 31, 2025 at 23:59:59
const TARGET_DATE = new Date('2025-12-31T23:59:59').getTime();

const formattedTime = computed(() => {
    if (days.value > 0) {
        return `${days.value}d ${hours.value}h ${minutes.value}m`;
    } else if (hours.value > 0) {
        return `${hours.value}h ${minutes.value}m ${seconds.value}s`;
    } else {
        return `${minutes.value}m ${seconds.value}s`;
    }
});

const updateCountdown = () => {
    const now = Date.now();
    const distance = TARGET_DATE - now;

    if (distance < 0) {
        // Countdown finished
        showTimer.value = false;
        if (interval) {
            clearInterval(interval);
        }
        return;
    }

    days.value = Math.floor(distance / (1000 * 60 * 60 * 24));
    hours.value = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    minutes.value = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    seconds.value = Math.floor((distance % (1000 * 60)) / 1000);
};

const startCountdown = () => {
    updateCountdown(); // Initial update
    interval = setInterval(() => {
        updateCountdown();
    }, 1000);
};

onMounted(() => {
    startCountdown();
});

onUnmounted(() => {
    if (interval) {
        clearInterval(interval);
    }
});
</script>

<style scoped>
@keyframes pulse-slow {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    50% {
        opacity: 0.95;
        transform: scale(1.02);
    }
}

.animate-pulse-slow {
    animation: pulse-slow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
