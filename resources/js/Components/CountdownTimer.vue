<template>
    <!-- Full-width banner below navbar for screens < 1790px | Floating card top-right for larger screens -->
    <!-- On md-2xl (768px-1789px): below navbar + announcement banner at top-[120px] -->
    <!-- On sm (< 768px): below navbar at top-20 -->
    <div v-if="showTimer" 
         :class="[
             'fixed z-[60] bg-gradient-to-r from-red-600 to-orange-600 text-white shadow-2xl animate-pulse-slow',
             isLargeScreen ? 'top-4 right-4 max-w-sm rounded-lg px-6 py-4 border-2 border-yellow-400' : 'top-20 md:top-[120px] 2xl:top-20 left-0 right-0 px-3 py-2 border-b-2 border-yellow-400'
         ]">
        <div :class="[
            'flex items-center space-x-2',
            isLargeScreen ? 'justify-start space-x-3' : 'justify-center'
        ]">
            <svg :class="[
                'text-yellow-300 flex-shrink-0',
                isLargeScreen ? 'w-6 h-6' : 'w-4 h-4'
            ]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
            </svg>
            <div :class="[
                'min-w-0',
                isLargeScreen ? 'block' : 'flex flex-col'
            ]">
                <div :class="[
                    'font-semibold uppercase tracking-wide',
                    isLargeScreen ? 'text-xs' : 'text-[10px]'
                ]">🎉 End of Year Sale!</div>
                <div :class="[
                    'font-black tabular-nums',
                    isLargeScreen ? 'text-2xl' : 'text-base'
                ]">
                    {{ formattedTime }}
                </div>
                <div :class="[
                    'opacity-90 font-bold',
                    isLargeScreen ? 'text-xs mt-1' : 'text-[10px]'
                ]">💥 50% OFF - Ends Dec 31st!</div>
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
const isLargeScreen = ref(false);
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

const checkScreenSize = () => {
    isLargeScreen.value = window.innerWidth >= 1790;
};

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
    checkScreenSize();
    window.addEventListener('resize', checkScreenSize);
    startCountdown();
});

onUnmounted(() => {
    window.removeEventListener('resize', checkScreenSize);
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
