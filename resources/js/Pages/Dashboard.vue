<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    purchases: Array,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-gray-900 dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Your Purchases</h1>
                    
                    <div v-if="purchases && purchases.length > 0">
                        <div class="space-y-6">
                            <div v-for="purchase in purchases" :key="purchase.id" class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 dark:bg-gray-800">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                    <div>
                                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ purchase.product.name }}</h2>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Purchased on {{ new Date(purchase.created_at).toLocaleDateString() }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Order #{{ purchase.order_number }}
                                        </p>
                                    </div>
                                    
                                    <div class="mt-2 sm:mt-0">
                                        <span 
                                            :class="[
                                                'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                                purchase.status === 'completed' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 
                                                purchase.status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300' : 
                                                'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300'
                                            ]"
                                        >
                                            {{ purchase.status.charAt(0).toUpperCase() + purchase.status.slice(1) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <a 
                                        v-if="purchase.status === 'completed'" 
                                        :href="route('products.toc', purchase.product.id)"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    >
                                        Access Content
                                    </a>
                                    
                                    <p v-else-if="purchase.status === 'pending'" class="text-sm text-yellow-600 dark:text-yellow-400">
                                        Your purchase is being processed. Content access will be available soon.
                                    </p>
                                    
                                    <p v-else-if="purchase.status === 'refunded'" class="text-sm text-red-600 dark:text-red-400">
                                        This purchase has been refunded.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Enhanced Free User Experience -->
                    <div v-else class="space-y-8">
                        <!-- Welcome Banner -->
                        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 p-8 shadow-2xl">
                            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>
                            <div class="absolute bottom-0 left-0 -mb-4 -ml-4 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>
                            
                            <div class="relative">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-2xl font-bold text-white mb-2">Welcome to Your Dashboard! 🎉</h3>
                                        <p class="text-orange-100 text-lg mb-4">You're one step closer to launching your profitable field tech side hustle.</p>
                                        <p class="text-white/90 text-sm mb-6">Explore our training programs, preview content, and see how you can start earning $2K-$5K+ monthly in your spare time.</p>
                                        <a :href="route('products')" class="inline-flex items-center px-6 py-3 bg-white text-orange-600 font-bold rounded-lg hover:bg-orange-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            Explore Training Programs
                                        </a>
                                    </div>
                                    <div class="hidden lg:block">
                                        <svg class="w-32 h-32 text-white/20" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Benefits Grid -->
                        <div class="grid md:grid-cols-3 gap-6">
                            <!-- Preview Content -->
                            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition-all duration-200">
                                <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-white mb-2">Preview Training</h4>
                                <p class="text-gray-400 text-sm mb-4">Explore sample lessons and see what's included in our comprehensive field tech training program.</p>
                                <a :href="route('products')" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium inline-flex items-center">
                                    View Preview
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>

                            <!-- Track Progress -->
                            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition-all duration-200">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-white mb-2">Your Journey</h4>
                                <p class="text-gray-400 text-sm mb-4">Once you purchase, track your learning progress and completed modules all in one place.</p>
                                <span class="text-gray-500 text-sm font-medium">Available after purchase</span>
                            </div>

                            <!-- Community Access -->
                            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition-all duration-200">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-white mb-2">Join Community</h4>
                                <p class="text-gray-400 text-sm mb-4">Connect with other field engineers, share tips, and learn from real success stories.</p>
                                <span class="text-gray-500 text-sm font-medium">Coming soon</span>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="bg-gradient-to-r from-gray-800 to-gray-900 border border-gray-700 rounded-xl p-6">
                            <h4 class="text-lg font-bold text-white mb-4">Why Start Your Side Hustle Now?</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-orange-400 mb-1">$50-150</div>
                                    <div class="text-sm text-gray-400">Per Hour Average</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-cyan-400 mb-1">10-20</div>
                                    <div class="text-sm text-gray-400">Hours Per Week</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-purple-400 mb-1">$2K-5K</div>
                                    <div class="text-sm text-gray-400">Monthly Potential</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-green-400 mb-1">100%</div>
                                    <div class="text-sm text-gray-400">Your Schedule</div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="text-center bg-gray-800/50 border-2 border-dashed border-gray-700 rounded-xl p-8">
                            <svg class="mx-auto h-16 w-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-white mb-2">Ready to Get Started?</h3>
                            <p class="text-gray-400 mb-6">Browse our training programs and start your journey to earning extra income today.</p>
                            <a :href="route('products')" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold rounded-lg hover:from-orange-500 hover:to-orange-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Browse Training Programs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
