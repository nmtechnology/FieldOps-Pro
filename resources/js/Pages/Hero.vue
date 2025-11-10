<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="FieldEngineer Pro - Professional Field Service Training" />

    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <nav class="fixed w-full z-50 bg-gray-900/80 backdrop-blur-sm border-b border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-white">
                            <span class="text-orange-500">Field</span>Engineer<span class="text-orange-500">Pro</span>
                        </span>
                    </div>
                    <div class="flex items-center gap-4">
                        <Link v-if="canLogin" :href="route('login')" class="text-gray-300 hover:text-white transition-colors">
                            Log in
                        </Link>
                        <Link :href="route('login')" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                            Get Started
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <div class="relative pt-32 pb-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center">
                    <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6">
                        Master Field Service
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-red-600">
                            Engineering Skills
                        </span>
                    </h1>
                    <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto">
                        Professional training courses for field technicians, network engineers, and service professionals.
                        Learn from industry experts and get certified.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <Link :href="route('login')" class="bg-orange-600 hover:bg-orange-700 text-white px-8 py-4 rounded-lg text-lg font-bold transition-all transform hover:scale-105 shadow-lg">
                            Start Learning Today
                        </Link>
                        <a href="#features" class="bg-gray-700 hover:bg-gray-600 text-white px-8 py-4 rounded-lg text-lg font-bold transition-all transform hover:scale-105">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="features" class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-800/50">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-4xl font-bold text-white text-center mb-16">
                    Why Choose FieldEngineer<span class="text-orange-500">Pro</span>?
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-gray-900 p-8 rounded-xl border border-gray-700 hover:border-orange-500 transition-all">
                        <div class="bg-orange-600 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">Interactive Tutorials</h3>
                        <p class="text-gray-300">
                            Step-by-step interactive courses with hands-on exercises, quizzes, and real-world scenarios to master field service skills.
                        </p>
                    </div>

                    <div class="bg-gray-900 p-8 rounded-xl border border-gray-700 hover:border-orange-500 transition-all">
                        <div class="bg-orange-600 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">Professional Certificates</h3>
                        <p class="text-gray-300">
                            Earn industry-recognized certificates upon course completion. Showcase your expertise to employers and clients.
                        </p>
                    </div>

                    <div class="bg-gray-900 p-8 rounded-xl border border-gray-700 hover:border-orange-500 transition-all">
                        <div class="bg-orange-600 w-16 h-16 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">Expert-Led Content</h3>
                        <p class="text-gray-300">
                            Learn from experienced field engineers and certified professionals with decades of real-world experience.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <footer class="bg-gray-900 border-t border-gray-800 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto text-center">
                <p class="text-gray-400">
                    &copy; 2025 <span class="text-orange-500 font-semibold">Field</span>Engineer<span class="text-orange-500 font-semibold">Pro</span>. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>
