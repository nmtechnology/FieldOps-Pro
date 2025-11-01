<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

// Props passed from the controller
const props = defineProps({
    product: Object,
    discountCode: String,
});

// Calculate discounted price if discount code is provided
const hasDiscount = computed(() => props.discountCode !== undefined && props.discountCode !== null);

// Define tier prices for reference
const tierPrices = {
    scout: 22.99,
    pro: 33.99,
    elite: 44.99,
    business: 399.99
};

</script>

<template>
    <Head>
        <title>{{ product.name }} - FieldEngineer Pro</title>
        <meta name="description" :content="product.description">
    </Head>

    <div class="bg-gray-900 dark:bg-gray-900">
        <!-- Hero Section with Book Cover and Field Tech Background Image -->
        <div class="relative overflow-hidden">
            <!-- Background image of field technician -->
            <div class="absolute inset-0">
                <img src="/img/it-tech-at-the-fiber-rack.webp"
                    alt="IT tech at the fiber rack"
                    class="w-full h-full object-cover" />
                <!-- Gradient overlay that fades from orange to transparent -->
                <div class="absolute inset-0 bg-gradient-to-b from-orange-600/90 via-orange-500/70 to-gray-900/95"></div>
            </div>
            <div class="relative px-4 py-16 md:py-20 lg:py-24 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex flex-col lg:grid lg:grid-cols-2 lg:gap-8 items-center lg:min-h-[500px]">
                    <!-- Left side: Book Cover with 3D effect -->
                    <div class="mb-10 lg:mb-0 flex justify-center lg:justify-start">
                        <div class="relative w-44 sm:w-56 md:w-72 lg:w-auto max-w-xs mx-auto lg:mx-0 book-container">
                            <!-- Book Cover with 3D effect -->
                            <div class="relative transform perspective-1000 rotate-y-0 hover:rotate-y-10 transition-transform duration-500 shadow-2xl">
                                <div class="w-full aspect-[3/4] bg-gradient-to-br from-slate-800 via-slate-700 to-slate-600 rounded-lg shadow-xl overflow-hidden relative">
                                    <!-- Book Cover Lighting Effects -->
                                    <div class="absolute inset-0 bg-gradient-to-tr from-black/30 via-transparent to-white/10 opacity-70"></div>
                                    <div class="absolute top-0 left-0 right-0 h-1/3 bg-gradient-to-b from-white/10 to-transparent opacity-20"></div>
                                    
                                    <!-- Book Spine Effect -->
                                    <div class="absolute left-0 top-0 h-full w-[8px] sm:w-[10px] md:w-[15px] bg-gradient-to-r from-slate-900 to-slate-800"></div>
                                    
                                    <!-- Book Content -->
                                    <div class="flex flex-col h-full p-3 sm:p-4 md:p-6 pl-6 sm:pl-8 md:pl-10 relative">
                                        <!-- Icons at the top similar to cover.png but with orange theme and 3D effects -->
                                        <div class="flex items-center gap-2 sm:gap-3 md:gap-4 mb-3 sm:mb-5 md:mb-8 mt-6 sm:mt-8 md:mt-12">
                                            <!-- Square with circle icon with gradient and shadow -->
                                            <div class="h-8 w-8 sm:h-10 sm:w-10 md:h-14 md:w-14 bg-gradient-to-br from-orange-300 to-orange-500 rounded-md flex items-center justify-center shadow-md relative">
                                                <div class="absolute inset-0 bg-gradient-to-tr from-black/10 to-white/30 rounded-md"></div>
                                                <div class="h-4 w-4 sm:h-6 sm:w-6 md:h-8 md:w-8 bg-slate-700 rounded-full shadow-inner"></div>
                                            </div>
                                            <!-- Circle with square icon with gradient and shadow -->
                                            <div class="h-8 w-8 sm:h-10 sm:w-10 md:h-14 md:w-14 bg-gradient-to-br from-orange-300 to-orange-500 rounded-full flex items-center justify-center shadow-md relative">
                                                <div class="absolute inset-0 bg-gradient-to-tr from-black/10 to-white/30 rounded-full"></div>
                                                <div class="h-4 w-4 sm:h-6 sm:w-6 md:h-8 md:w-8 bg-slate-700 rounded-md shadow-inner"></div>
                                            </div>
                                        </div>
                                        
                                        <!-- Title with enhanced 3D effects -->
                                        <div class="mt-auto mb-2 sm:mb-3 md:mb-4 relative">
                                            <!-- Subtle glow effect behind title -->
                                            <div class="absolute -left-2 -top-2 w-full h-full blur-md bg-orange-400/10"></div>
                                            
                                            <!-- Title text with gradient and text shadow -->
                                            <h3 class="text-2xl sm:text-3xl md:text-4xl leading-tight font-bold text-transparent bg-clip-text bg-gradient-to-r from-orange-300 to-orange-500 mb-1 sm:mb-2 relative drop-shadow-sm">FieldEngineer</h3>
                                            <h4 class="text-2xl sm:text-3xl md:text-4xl leading-tight font-bold text-transparent bg-clip-text bg-gradient-to-br from-white to-gray-300 mb-2 sm:mb-3 md:mb-4 drop-shadow-sm">Pro</h4>
                                            
                                            <!-- Separator line with gradient -->
                                            <div class="w-16 sm:w-20 md:w-24 h-1 bg-gradient-to-r from-orange-300 to-orange-500 mb-2 sm:mb-3 md:mb-4 rounded-full"></div>
                                            
                                            <p class="text-sm sm:text-base md:text-lg font-light text-gray-300 mb-6 sm:mb-8 md:mb-12 leading-relaxed relative">
                                                The definitive method to mastering field operations.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Book Shadow - more realistic with multiple layers -->
                            <div class="absolute -bottom-2 sm:-bottom-3 left-0 right-6 sm:right-8 h-3 sm:h-4 bg-black/30 blur-sm rounded-full"></div>
                            <div class="absolute -bottom-1 sm:-bottom-2 left-3 sm:left-4 right-4 sm:right-6 h-4 sm:h-6 bg-black/20 blur-md rounded-full"></div>
                            
                            <!-- Book Pages Edge with more dimension -->
                            <div class="absolute top-[2%] bottom-[2%] right-0 w-[3px] sm:w-[4px] md:w-[6px] bg-gradient-to-l from-gray-100 via-gray-200 to-gray-300 rounded-r transform translate-x-[2px] sm:translate-x-[2px] md:translate-x-[3px]">
                                <!-- Subtle page separator lines with better dimension -->
                                <div class="h-full w-full opacity-30" style="background-image: repeating-linear-gradient(to bottom, transparent, transparent 2px, rgba(0,0,0,0.1) 2px, rgba(0,0,0,0.1) 3px);"></div>
                                <!-- Top and bottom shading -->
                                <div class="absolute top-0 left-0 right-0 h-[15%] bg-gradient-to-b from-gray-400/30 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 h-[15%] bg-gradient-to-t from-gray-400/30 to-transparent"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right side: Text and CTA -->
                    <div class="text-center lg:text-left">
                        <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                            {{ product.name }}
                        </h1>
                        <p class="max-w-3xl mx-auto lg:mx-0 mt-4 md:mt-6 text-lg md:text-xl text-white">
                            {{ product.description }}
                        </p>
                        <div class="max-w-sm mx-auto lg:mx-0 mt-6 md:mt-10 sm:max-w-none sm:flex sm:justify-center lg:justify-start">
                            <div class="space-y-4 sm:space-y-0 sm:mx-auto lg:mx-0">
                                <a href="#pricing" class="flex items-center justify-center w-full px-8 py-3 text-base font-medium text-gray-900 bg-orange-400 border border-transparent rounded-md shadow-md hover:bg-orange-500 md:py-4 md:text-lg md:px-10">
                                    Get Access Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section - continues the dark theme from the hero image fade -->
        <div class="py-16 overflow-hidden bg-gray-900 dark:bg-gray-900">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-white dark:text-white sm:text-4xl">
                        What You'll Learn
                    </h2>
                    <p class="max-w-3xl mx-auto mt-4 text-xl text-gray-500 dark:text-gray-400">
                        Everything you need to succeed as an independent field engineer!
                    </p>
                </div>

                <div class="mt-12">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Feature 1 -->
                        <div class="pt-6">
                            <div class="flow-root px-6 pb-8 rounded-lg bg-gray-300 dark:bg-gray-800">
                                <div class="-mt-6">
                                    <div>
                                        <span class="inline-flex items-center justify-center p-3 rounded-md shadow-lg bg-green-500">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium tracking-tight text-gray-900 dark:text-white">Comprehensive Guides</h3>
                                    <p class="mt-5 text-base text-gray-500 dark:text-gray-400">
                                        Detailed step-by-step instructions to help you master every concept
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="pt-6">
                            <div class="flow-root px-6 pb-8 rounded-lg bg-gray-300 dark:bg-gray-800">
                                <div class="-mt-6">
                                    <div>
                                        <span class="inline-flex items-center justify-center p-3 rounded-md shadow-lg bg-red-600">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium tracking-tight text-gray-900 dark:text-white">Practical Examples</h3>
                                    <p class="mt-5 text-base text-gray-500 dark:text-gray-400">
                                        Real-world examples and case studies that you can apply immediately
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="pt-6">
                            <div class="flow-root px-6 pb-8 rounded-lg bg-gray-300">
                                <div class="-mt-6">
                                    <div>
                                        <span class="inline-flex items-center justify-center p-3 rounded-md shadow-lg bg-orange-500">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium tracking-tight text-gray-900">Professional Resources</h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        Downloadable templates, checklists, and tools to enhance your success
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Preview Section for Registered Users -->
        <div class="py-20 bg-gradient-to-br from-gray-800 via-gray-900 to-gray-800">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <div class="inline-flex items-center px-4 py-2 bg-orange-500/10 border border-orange-500/30 rounded-full mb-4">
                        <svg class="w-5 h-5 text-orange-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-orange-400 font-semibold text-sm">SNEAK PEEK</span>
                    </div>
                    <h2 class="text-4xl font-bold text-white mb-4">What's Inside the Training</h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">Get a preview of the comprehensive content that will transform your field tech career</p>
                </div>

                <!-- Preview Content Grid -->
                <div class="grid md:grid-cols-2 gap-8 mb-12">
                    <!-- Module Preview 1 -->
                    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl p-8 hover:border-orange-500/50 transition-all duration-300">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-white mb-3">Module 1: Skills Assessment</h3>
                                <p class="text-gray-300 mb-4">Learn to evaluate your existing skills and identify high-demand service areas where you can excel.</p>
                                <div class="space-y-2">
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        PC Support & Troubleshooting fundamentals
                                    </div>
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Smart home installation techniques
                                    </div>
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Low voltage wiring and cable management
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Module Preview 2 -->
                    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl p-8 hover:border-cyan-500/50 transition-all duration-300">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-white mb-3">Module 2: Essential Tools</h3>
                                <p class="text-gray-300 mb-4">Discover exactly which tools you need (and which to skip) to start earning immediately.</p>
                                <div class="space-y-2">
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Complete tool kit recommendations
                                    </div>
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Budget-friendly purchasing guides
                                    </div>
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Field applications and best practices
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Module Preview 3 -->
                    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl p-8 hover:border-purple-500/50 transition-all duration-300">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-white mb-3">Module 3: Territory Setup</h3>
                                <p class="text-gray-300 mb-4">Strategic guidance on defining your service area and maximizing your earning potential.</p>
                                <div class="space-y-2">
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Define your optimal service radius
                                    </div>
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Job acceptance criteria strategies
                                    </div>
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Scheduling optimization tips
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Module Preview 4 -->
                    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl p-8 hover:border-green-500/50 transition-all duration-300">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-white mb-3">Module 4: Platform & Reputation</h3>
                                <p class="text-gray-300 mb-4">Master the art of building a 5-star reputation and attracting high-paying clients consistently.</p>
                                <div class="space-y-2">
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Profile optimization secrets
                                    </div>
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Rate setting strategies ($50-150/hr)
                                    </div>
                                    <div class="flex items-center text-sm text-gray-400">
                                        <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Review generation techniques
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA for Preview -->
                <div class="text-center bg-gradient-to-r from-orange-500/10 to-cyan-500/10 border border-orange-500/30 rounded-2xl p-8">
                    <h3 class="text-2xl font-bold text-white mb-3">Ready to Access the Full Training?</h3>
                    <p class="text-gray-300 mb-6">Join hundreds of successful field engineers who started with just $75.99</p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="#pricing" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold rounded-lg hover:from-orange-500 hover:to-orange-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            View Pricing Options
                        </a>
                        <span class="text-gray-400 text-sm">One-time payment • Lifetime access • Money-back guarantee</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Section with 3 Tiers -->
        <div id="pricing" class="py-16 bg-gray-900">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-base text-orange-400 font-semibold tracking-wide uppercase">Pricing Options</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-orange-400 sm:text-4xl">
                        Choose the tier that fits your needs
                    </p>
                    <p class="max-w-3xl mx-auto mt-4 text-xl text-white">
                        From getting started to building a full-time field engineering business
                    </p>
                </div>
                
                <div class="mt-16 space-y-12 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8">
                    <!-- Scout Tier -->
                    <div class="relative p-8 bg-gray-800 border border-gray-700 rounded-2xl shadow-sm flex flex-col">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-orange-400">FieldOps Scout</h3>
                            <p class="mt-4 flex items-baseline text-orange-400">
                                <span class="text-5xl font-extrabold tracking-tight">$69.99</span>
                                <span class="ml-1 text-xl font-semibold">/month</span>
                            </p>
                            <p class="mt-6 text-white">
                                Perfect for beginners looking to break into field engineering and low voltage contracting.
                            </p>
                            
                            <!-- Feature list -->
                            <ul role="list" class="mt-6 space-y-6">
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">Professional profile setup guide</span>
                                </li>
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">Market access fundamentals</span>
                                </li>
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">Platform navigation tutorial</span>
                                </li>
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">Getting your first job guide</span>
                                </li>
                            </ul>
                        </div>
                        
                        <Link :href="route('checkout', { product: product.id, tier: 'scout' })" class="mt-8 block w-full bg-gray-700 border border-gray-600 rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-gray-600">
                            Buy Now
                        </Link>
                    </div>
                    
                    <!-- Pro Tier (Highlighted) -->
                    <div class="relative p-8 bg-gray-800 border-2 border-orange-400 rounded-2xl shadow-sm flex flex-col">
                        <div class="absolute top-0 inset-x-0 transform translate-y-px">
                            <div class="flex justify-center transform -translate-y-1/2">
                                <span class="inline-flex rounded-full bg-orange-400 px-4 py-1 text-sm font-semibold tracking-wider uppercase text-gray-900">
                                    Most Popular
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-orange-400">FieldOps Pro</h3>
                            <p class="mt-4 flex items-baseline text-orange-400">
                                <span class="text-5xl font-extrabold tracking-tight">$33.99</span>
                                <span class="ml-1 text-xl font-semibold">/month</span>
                            </p>
                            <p class="mt-6 text-white">
                                For contractors seeking to establish a consistent income stream and build a reputation.
                            </p>
                            
                            <!-- Feature list -->
                            <ul role="list" class="mt-6 space-y-6">
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">Advanced bidding strategies</span>
                                </li>
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">Competitive rate setting</span>
                                </li>
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">Client management systems</span>
                                </li>
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">Monthly income planning</span>
                                </li>
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">Field engineering best practices</span>
                                </li>
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">All Scout tier benefits included</span>
                                </li>
                            </ul>
                        </div>
                        
                        <Link :href="route('checkout', { product: product.id, tier: 'pro' })" class="mt-8 block w-full bg-orange-400 border border-transparent rounded-md py-2 text-sm font-semibold text-gray-900 text-center hover:bg-orange-500">
                            Buy Now
                        </Link>
                    </div>
                    
                    <!-- Elite Tier -->
                    <div class="relative p-8 bg-gray-800 border border-gray-700 rounded-2xl shadow-sm flex flex-col">
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-orange-400">FieldOps Elite</h3>
                            <p class="mt-4 flex items-baseline text-orange-400">
                                <span class="text-5xl font-extrabold tracking-tight">$44.99</span>
                                <span class="ml-1 text-xl font-semibold">/month</span>
                            </p>
                            <p class="mt-6 text-white">
                                Premium tier for serious field engineers looking to maximize earnings and scale their business.
                            </p>
                            
                            <!-- Feature list -->
                            <ul role="list" class="mt-6 space-y-6">
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">Premium bid templates</span>
                                </li>
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">Rate optimization framework</span>
                                </li>
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">Enterprise client acquisition</span>
                                </li>
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">Multiple contract management</span>
                                </li>
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">VIP support and mentoring</span>
                                </li>
                                <li class="flex">
                                    <span class="text-orange-400 mr-2">✓</span>
                                    <span class="text-white">All Pro tier benefits included</span>
                                </li>
                            </ul>
                        </div>
                        
                        <Link :href="route('checkout', { product: product.id, tier: 'elite' })" class="mt-8 block w-full bg-gray-700 border border-gray-600 rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-gray-600">
                            Buy Now
                        </Link>
                    </div>
                </div>
            </div>
        </div>

        <!-- Business Establishment Package Upsell -->
        <div id="business-package" class="py-16 bg-gradient-to-b from-gray-900 to-gray-800">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                    <!-- Left side: Description -->
                    <div class="mb-10 lg:mb-0">
                        <div class="inline-flex items-center justify-center px-4 py-1 mb-3 rounded-full bg-green-500 text-white">
                            <span class="text-xs font-semibold uppercase tracking-wide">50% OFF - Limited Time Offer</span>
                        </div>
                        <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl mb-4">
                            Business Establishment Package
                        </h2>
                        <p class="text-xl text-gray-300 mb-6">
                            Ready to make it official? Our comprehensive business package gives you everything you need to establish a legitimate field engineering business.
                        </p>
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="ml-3 text-lg text-gray-300">
                                    <strong class="text-white">Business License:</strong> We'll handle the paperwork to register your business in your state
                                </p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="ml-3 text-lg text-gray-300">
                                    <strong class="text-white">Custom Logo Design:</strong> Professional brand identity with 3 concept designs and unlimited revisions
                                </p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="ml-3 text-lg text-gray-300">
                                    <strong class="text-white">Business Name Creation:</strong> Strategic naming services with domain availability check
                                </p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="ml-3 text-lg text-gray-300">
                                    <strong class="text-white">Insurance Quotes:</strong> Customized insurance package options from trusted providers
                                </p>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <p class="ml-3 text-lg text-gray-300">
                                    <strong class="text-white">1-on-1 Consultation:</strong> 60-minute setup call with a business establishment expert
                                </p>
                            </li>
                        </ul>
                        <p class="text-sm text-gray-400 mb-6">
                            *Additional state fees may apply depending on your location. Our team will provide a complete breakdown before proceeding.
                        </p>
                    </div>
                    <!-- Right side: Price Card -->
                    <div class="bg-gray-900 border-2 border-orange-400 rounded-2xl shadow-xl overflow-hidden">
                        <div class="p-8">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-2xl font-bold text-white">Business Establishment Package</h3>
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-500 text-white">
                                    50% OFF
                                </span>
                            </div>
                            <div class="flex flex-col mb-6">
                                <div class="flex items-center mb-2">
                                    <span class="text-2xl font-medium line-through decoration-2 text-gray-400 mr-2 relative">
                                        $799.99
                                        <span class="absolute top-1/2 left-0 w-full h-0.5 bg-red-500 transform -rotate-6"></span>
                                    </span>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded bg-green-500 text-white">
                                        Save $400
                                    </span>
                                </div>
                                <div class="flex items-end">
                                    <span class="text-5xl font-extrabold text-orange-400">$399.99</span>
                                    <span class="ml-2 text-xl text-gray-400">+ applicable taxes</span>
                                </div>
                            </div>
                            <p class="text-gray-300 mb-8">
                                Everything you need to launch your field engineering business properly, with all legal requirements covered.
                            </p>
                            <Link :href="route('checkout', { product: product.id, tier: 'business' })" class="block w-full py-4 px-6 border border-transparent rounded-md shadow text-center text-xl font-medium text-gray-900 bg-orange-400 hover:bg-orange-500 transition-colors">
                                Establish Your Business Now
                            </Link>
                            <p class="text-center text-sm text-gray-400 mt-4">
                                30-day satisfaction guarantee or your money back
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="py-16 bg-gray-900 dark:bg-gray-900">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-200 dark:text-white sm:text-4xl">
                        Frequently Asked Questions
                    </h2>
                    <p class="max-w-3xl mx-auto mt-4 text-xl text-gray-200 dark:text-gray-400">
                        Can't find the answer you're looking for? Contact our support team.
                    </p>
                </div>
                <div class="mt-12">
                    <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-12">
                        <div>
                            <dt class="text-lg font-medium leading-6 text-gray-300">
                                How long do I have access to the content?
                            </dt>
                            <dd class="mt-2 text-base text-gray-500">
                                You get lifetime access to all content, including future updates.
                            </dd>
                        </div>
                        <div>
                            <dt class="text-lg font-medium leading-6 text-gray-300">
                                Can I get a refund if I'm not satisfied?
                            </dt>
                            <dd class="mt-2 text-base text-gray-500">
                                Yes, we offer a 30-day money-back guarantee if you're not completely satisfied.
                            </dd>
                        </div>
                        <div>
                            <dt class="text-lg font-medium leading-6 text-gray-300">
                                How is the content delivered?
                            </dt>
                            <dd class="mt-2 text-base text-gray-500">
                                All content is available online immediately after purchase through our secure member area.
                            </dd>
                        </div>
                        <div>
                            <dt class="text-lg font-medium leading-6 text-gray-300">
                                Do you offer any discounts?
                            </dt>
                            <dd class="mt-2 text-base text-gray-500">
                                We occasionally offer promotional discounts. Sign up for our newsletter to be notified.
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-orange-600">
            <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                <h2 class="text-3xl font-extrabold tracking-tight text-white md:text-4xl">
                    <span class="block">Ready to dive in?</span>
                    <span class="block text-white">Get access today.</span>
                </h2>
                <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                    <div class="inline-flex rounded-md shadow">
                        <Link :href="route('checkout', { product: product.id })" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-gray-900 bg-orange-400 hover:bg-orange-500">
                            Get Started
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
/* Book Effect CSS */
.perspective-1000 {
    perspective: 1000px;
}
.rotate-y-0 {
    transform: rotateY(0deg);
}
.rotate-y-10 {
    transform: rotateY(10deg);
}

/* Hero section parallax and image effects */
@keyframes subtle-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.hero-parallax-image {
    background-attachment: fixed;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.book-container {
    animation: subtle-float 6s ease-in-out infinite;
}
</style>