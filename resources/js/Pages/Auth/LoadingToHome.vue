<script setup>
import { onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

onMounted(() => {
    // Show loading animation for 2.5 seconds, then redirect to home
    setTimeout(() => {
        router.visit('/home');
    }, 2500);
});
</script>

<template>
    <!-- The loading screen is handled by app.js which detects this route -->
    <div></div>
</template>
