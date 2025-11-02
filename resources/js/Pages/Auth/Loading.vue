<script setup>
import { onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

// Redirect to dashboard after loading animation
onMounted(() => {
    setTimeout(() => {
        router.visit('/dashboard', {
            replace: true
        });
    }, 2500);
});
</script>

<template>
    <div class="min-h-screen bg-gray-900 flex items-center justify-center">
        <!-- Loading screen component will be shown via app.js -->
        <div class="text-center">
            <div class="inline-block h-12 w-12 animate-spin rounded-full border-4 border-solid border-orange-500 border-r-transparent"></div>
        </div>
    </div>
</template>
