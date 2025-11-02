<template>
    <div v-if="showTimer" class="fixed top-4 right-4 z-50 bg-gradient-to-r from-red-600 to-orange-600 text-white px-6 py-4 rounded-lg shadow-2xl border-2 border-red-400 animate-pulse-slow">
        <div class="flex items-center space-x-3">
            <svg class="w-6 h-6 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <div class="text-xs font-semibold uppercase tracking-wide">Limited Time Offer</div>
                <div class="text-2xl font-black tabular-nums">
                    {{ formattedTime }}
                </div>
                <div class="text-xs opacity-90">Hurry! Special pricing ends soon</div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';

const showTimer = ref(false);
const timeRemaining = ref(0);
let interval = null;

const TIMER_DURATION = 15 * 60; // 15 minutes in seconds
const STORAGE_KEY = 'urgency_timer_end';

const formattedTime = computed(() => {
    const minutes = Math.floor(timeRemaining.value / 60);
    const seconds = timeRemaining.value % 60;
    return `${minutes}:${seconds.toString().padStart(2, '0')}`;
});

const initTimer = () => {
    const storedEndTime = localStorage.getItem(STORAGE_KEY);
    const now = Date.now();

    if (storedEndTime) {
        const endTime = parseInt(storedEndTime);
        const remaining = Math.floor((endTime - now) / 1000);

        if (remaining > 0) {
            // Timer is still active
            timeRemaining.value = remaining;
            showTimer.value = true;
            startCountdown();
        } else {
            // Timer expired, start new one
            startNewTimer();
        }
    } else {
        // First visit, start new timer
        startNewTimer();
    }
};

const startNewTimer = () => {
    const endTime = Date.now() + (TIMER_DURATION * 1000);
    localStorage.setItem(STORAGE_KEY, endTime.toString());
    timeRemaining.value = TIMER_DURATION;
    showTimer.value = true;
    startCountdown();
};

const startCountdown = () => {
    interval = setInterval(() => {
        timeRemaining.value--;

        if (timeRemaining.value <= 0) {
            clearInterval(interval);
            showTimer.value = false;
            localStorage.removeItem(STORAGE_KEY);
        }
    }, 1000);
};

onMounted(() => {
    initTimer();
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
