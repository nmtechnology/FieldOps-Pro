<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link
        :href="href"
        class="block w-full px-4 py-2 text-start text-sm leading-5 text-white transition duration-150 ease-in-out hover:bg-gray-800 hover:text-orange-400 focus:bg-gray-800 focus:text-orange-400 focus:outline-none"
    >
        <slot />
    </Link>
</template>
