<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PricingTiers from '@/Components/PricingTiers.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref } from 'vue';

// For the mobile menu toggle
const mobileMenuOpen = ref(false);

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    featuredProduct: Object,
    products: Array,
    guestCheckout: Boolean,
});
</script>

<template>
    <Head>
        <title>FieldEngineer Pro - Professional Info Products</title>
        <meta name="description" content="High-quality info products for professionals">
    </Head>

    <!-- Navigation - Full width at the top level -->
    <nav class="fixed top-0 left-0 right-0 z-50 w-full bg-gray-800 bg-opacity-90 backdrop-blur-sm border-b border-gray-700 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <Link href="/" class="flex items-center">
                            <ApplicationLogo class="h-10 w-10 fill-current text-orange-500 mr-2" />
                            <span class="text-xl font-bold text-orange-500">FieldEngineer Pro</span>
                        </Link>
                    </div>
                </div>
                
                <!-- Desktop navigation menu -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                    <Link :href="route('products.show', featuredProduct)" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Products</Link>
                    <Link href="#testimonials" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">Testimonials</Link>
                    <Link href="#about" class="text-gray-300 hover:text-white px-3 py-2 text-sm font-medium">About</Link>
                    <Link href="/register" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-medium">Sign Up</Link>
                    <Link href="/login" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-medium">Sign In</Link>
                </div>
                
                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-300 hover:text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div v-if="mobileMenuOpen" class="sm:hidden pt-2 pb-3 space-y-1">
                <Link :href="route('products.show', featuredProduct)" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white">Products</Link>
                <Link href="#testimonials" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white">Testimonials</Link>
                <Link href="#about" class="block px-3 py-2 text-base font-medium text-gray-300 hover:text-white">About</Link>
                <div class="flex space-x-2 px-3 py-2">
                    <Link href="/register" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-medium">Sign Up</Link>
                    <Link href="/login" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-medium">Sign In</Link>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="min-h-screen bg-gray-900 dark:bg-gray-900">
        <div class="h-16"><!-- Spacer to account for fixed navbar --></div>
        
        <!-- Hero section -->
        <div class="relative bg-gray-900 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                    <!-- Simple polygon SVG -->
                    <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-gray-800 transform translate-x-1/2" 
                         fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                        <polygon points="50,0 100,0 50,100 0,100" />
                    </svg>

                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-orange-600 sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">Unlock Your Potential as an</span>
                                <span class="block text-orange-400 xl:inline"> Independent Field Engineer</span>
                            </h1>
                            <p class="mt-3 text-base text-white sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Learn how to set competitive rates, win bids on work platforms, and create sustainable self-employment opportunities in the low voltage contracting industry.
                            </p>
                            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <Link :href="route('guest.checkout', { product: featuredProduct.id })" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-gray-900 bg-orange-600 hover:bg-orange-500 md:py-4 md:text-lg md:px-10">
                                        Buy Now
                                    </Link>
                                </div>
                                <div class="mt-3 sm:mt-0 sm:ml-3">
                                    <a href="#featured" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-gray-900 bg-orange-400 hover:bg-orange-700 md:py-4 md:text-lg md:px-10">
                                        Learn more
                                    </a>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2850&q=80" alt="Field engineer working with low voltage equipment">
            </div>
        </div>

        <!-- Featured Product Section -->
        <div id="featured" class="py-12 bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-orange-400 font-semibold tracking-wide uppercase">Featured Product</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-orange-400 sm:text-4xl">
                        {{ featuredProduct.name }}
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-white lg:mx-auto">
                        {{ featuredProduct.description }}
                    </p>
                </div>

                <div class="mt-10">
                    <div class="lg:grid lg:grid-cols-2 lg:gap-x-8">
                        <!-- Left Side: Book Cover with 3D effect -->
                        <div class="mb-10 lg:mb-0 flex justify-center lg:justify-start">
                            <!-- Ambient glow effect container -->
                            <div class="relative w-44 sm:w-56 md:w-72 lg:w-auto max-w-xs mx-auto lg:mx-0 book-container">
                                <!-- Cosmic nebula backdrop -->
                                <div class="absolute -inset-6 sm:-inset-8 md:-inset-10 bg-gradient-to-br from-indigo-600/30 via-purple-500/20 to-violet-400/30 rounded-full blur-3xl opacity-60 animate-nebula-pulse"></div>
                                <div class="absolute -inset-12 sm:-inset-16 md:-inset-20 bg-gradient-to-tr from-purple-500/15 via-white/10 to-blue-400/15 rounded-full blur-3xl opacity-40 animate-cosmic-drift"></div>
                                <div class="absolute -inset-3 sm:-inset-4 md:-inset-5 bg-gradient-to-r from-violet-500/20 to-indigo-400/15 rounded-2xl blur-xl opacity-70 mix-blend-screen"></div>
                                
                                <!-- Cosmic dust clouds -->
                                <div class="absolute w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48 bg-gradient-to-br from-purple-600/20 via-indigo-400/20 to-violet-300/20 rounded-full blur-3xl -top-16 -left-16 animate-cosmic-drift"></div>
                                <div class="absolute w-28 h-28 sm:w-36 sm:h-36 md:w-44 md:h-44 bg-gradient-to-br from-indigo-500/15 via-purple-400/15 to-blue-300/15 rounded-full blur-3xl" style="animation-delay: -5s; top: 30%; right: -15%; animation: cosmic-drift 18s ease-in-out infinite reverse;"></div>
                                <div class="absolute w-24 h-24 sm:w-32 sm:h-32 md:w-40 md:h-40 bg-gradient-to-br from-purple-400/20 via-violet-300/10 to-indigo-200/15 rounded-full blur-3xl" style="animation-delay: -10s; bottom: -10%; left: -10%; animation: cosmic-drift 22s ease-in-out infinite alternate;"></div>
                                
                                <!-- Cosmic energy rings -->
                                <div class="absolute w-full h-full border border-purple-300/20 rounded-full blur-sm animate-cosmic-rays" style="top: -10%; left: -10%; width: 120%; height: 120%;"></div>
                                <div class="absolute w-full h-full border-2 border-indigo-400/15 rounded-full blur-md animate-cosmic-rays" style="animation-delay: -4s; top: -5%; left: -5%; width: 110%; height: 110%;"></div>
                                <div class="absolute w-full h-full border border-violet-200/20 rounded-full blur-sm animate-cosmic-rays" style="animation-delay: -8s; top: -15%; left: -15%; width: 130%; height: 130%;"></div>
                                
                                <!-- Distant stars twinkling -->
                                <div class="absolute w-2 h-2 bg-white/90 rounded-full blur-sm animate-star-twinkle" style="top: 15%; left: -8%;"></div>
                                <div class="absolute w-1 h-1 bg-white/80 rounded-full blur-sm animate-star-twinkle" style="animation-delay: -1s; top: 45%; right: -5%;"></div>
                                <div class="absolute w-1.5 h-1.5 bg-white/85 rounded-full blur-sm animate-star-twinkle" style="animation-delay: -2s; top: 75%; left: 10%;"></div>
                                <div class="absolute w-1 h-1 bg-white/80 rounded-full blur-sm animate-star-twinkle" style="animation-delay: -3s; top: 25%; left: 85%;"></div>
                                <div class="absolute w-1 h-1 bg-white/90 rounded-full blur-sm animate-star-twinkle" style="animation-delay: -2.5s; top: 65%; left: 80%;"></div>
                                <div class="absolute w-2 h-2 bg-white/80 rounded-full blur-sm animate-star-twinkle" style="animation-delay: -1.5s; top: 5%; left: 50%;"></div>
                                <div class="absolute w-1.5 h-1.5 bg-white/85 rounded-full blur-sm animate-star-twinkle" style="animation-delay: -0.5s; top: 85%; left: 40%;"></div>
                                
                                <!-- Stardust particles -->
                                <div class="absolute bottom-0 left-1/4 w-0.5 h-16 bg-gradient-to-t from-transparent via-purple-300/50 to-white/90 rounded-full blur-sm animate-stardust"></div>
                                <div class="absolute bottom-0 left-1/2 w-0.5 h-12 bg-gradient-to-t from-transparent via-indigo-300/60 to-white/90 rounded-full blur-sm animate-stardust" style="animation-delay: -3s;"></div>
                                <div class="absolute bottom-0 left-3/4 w-0.5 h-20 bg-gradient-to-t from-transparent via-violet-300/70 to-white/90 rounded-full blur-sm animate-stardust" style="animation-delay: -6s;"></div>
                                <div class="absolute bottom-10 left-1/3 w-0.5 h-14 bg-gradient-to-t from-transparent via-blue-300/50 to-white/90 rounded-full blur-sm animate-stardust" style="animation-delay: -9s;"></div>
                                <div class="absolute bottom-14 left-2/3 w-0.5 h-10 bg-gradient-to-t from-transparent via-purple-200/60 to-white/90 rounded-full blur-sm animate-stardust" style="animation-delay: -12s;"></div>
                                
                                <!-- Ethereal light beams -->
                                <div class="absolute -top-20 -left-10 w-60 h-96 bg-gradient-to-b from-purple-300/20 via-indigo-400/10 to-transparent rotate-30 blur-3xl transform-gpu animate-pulse-slow"></div>
                                <div class="absolute -bottom-16 -right-10 w-60 h-80 bg-gradient-to-t from-indigo-400/20 via-violet-300/15 to-transparent -rotate-30 blur-3xl transform-gpu animate-pulse-slow" style="animation-delay: -4s;"></div>
                                
                                <!-- Book Cover with 3D effect -->
                                <div class="relative transform perspective-1000 rotate-y-0 hover:rotate-y-10 transition-transform duration-500 shadow-2xl">
                                    <div class="w-full aspect-[3/4] bg-gradient-to-br from-slate-800 via-blue-900 to-slate-900 rounded-lg shadow-xl overflow-hidden relative">
                                        <!-- Book Cover Pattern -->
                                        <div class="absolute inset-0 opacity-20 bg-pattern"></div>
                                        <div class="absolute inset-0 bg-gradient-to-tr from-black/20 via-transparent to-white/10"></div>
                                        
                                        <!-- Book Spine Effect -->
                                        <div class="absolute left-0 top-0 h-full w-[8px] sm:w-[10px] md:w-[15px] bg-gradient-to-r from-slate-900 to-blue-900"></div>
                                        
                                        <!-- Book Content -->
                                        <div class="flex flex-col h-full p-3 sm:p-4 md:p-6 pl-6 sm:pl-8 md:pl-10 relative">
                                            <!-- Icons at the top -->
                                            <div class="flex items-center gap-2 sm:gap-3 md:gap-4 mb-3 sm:mb-5 md:mb-8 mt-6 sm:mt-8 md:mt-12">
                                                <!-- Square with circle icon -->
                                                <div class="h-8 w-8 sm:h-10 sm:w-10 md:h-14 md:w-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-md flex items-center justify-center shadow-md">
                                                    <div class="h-4 w-4 sm:h-6 sm:w-6 md:h-8 md:w-8 bg-slate-800 rounded-full shadow-inner"></div>
                                                </div>
                                                <!-- Circle with square icon -->
                                                <div class="h-8 w-8 sm:h-10 sm:w-10 md:h-14 md:w-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center shadow-md">
                                                    <div class="h-4 w-4 sm:h-6 sm:w-6 md:h-8 md:w-8 bg-slate-800 rounded-md shadow-inner"></div>
                                                </div>
                                            </div>
                                            
                                            <!-- Title -->
                                            <div class="mt-auto mb-2 sm:mb-3 md:mb-4">
                                                <h3 class="text-2xl sm:text-3xl md:text-4xl leading-tight font-bold text-white mb-1 sm:mb-2">FieldEngineer</h3>
                                                <h4 class="text-2xl sm:text-3xl md:text-4xl leading-tight font-bold text-white mb-2 sm:mb-3 md:mb-4">Pro</h4>
                                                
                                                <!-- Separator line -->
                                                <div class="w-16 sm:w-20 md:w-24 h-1 bg-gradient-to-r from-purple-400 to-purple-600 mb-2 sm:mb-3 md:mb-4 rounded-full"></div>
                                                
                                                <p class="text-sm sm:text-base md:text-lg font-light text-white mb-6 sm:mb-8 md:mb-12 leading-relaxed">
                                                    {{ featuredProduct.short_description || "The definitive method to mastering field operations." }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Cosmic shadow effects -->
                                <div class="absolute -bottom-3 left-0 right-8 h-4 bg-black/20 blur-sm rounded-full"></div>
                                <div class="absolute -bottom-2 left-4 right-6 h-6 bg-black/15 blur-md rounded-full"></div>
                                <!-- Ethereal glow beneath -->
                                <div class="absolute -bottom-6 left-2 right-2 h-8 bg-gradient-to-r from-purple-600/40 via-indigo-500/50 to-violet-600/40 blur-xl rounded-full animate-nebula-pulse"></div>
                                <!-- Cosmic energy pool -->
                                <div class="absolute -bottom-8 left-1/4 right-1/4 h-6 bg-gradient-to-r from-purple-500/50 via-white/50 to-purple-500/50 blur-xl rounded-full animate-pulse-slow" style="animation-delay: -3s;"></div>
                                
                                <!-- Book Pages Edge -->
                                <div class="absolute top-[2%] bottom-[2%] right-0 w-[6px] bg-gradient-to-l from-gray-100 via-gray-200 to-gray-300 rounded-r transform translate-x-[3px]">
                                    <!-- Subtle page separator lines -->
                                    <div class="h-full w-full opacity-30" style="background-image: repeating-linear-gradient(to bottom, transparent, transparent 3px, rgba(0,0,0,0.1) 3px, rgba(0,0,0,0.1) 4px);"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-10 lg:mt-0">
                            <h3 class="text-2xl font-extrabold text-purple-400">Key Benefits</h3>
                            <div class="mt-4 text-white">
                                <ul class="mt-6 space-y-6">
                                    <li class="flex">
                                        <svg class="flex-shrink-0 h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="ml-3">Expert knowledge from industry professionals</span>
                                    </li>
                                    <li class="flex">
                                        <svg class="flex-shrink-0 h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="ml-3">Practical templates and resources</span>
                                    </li>
                                    <li class="flex">
                                        <svg class="flex-shrink-0 h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="ml-3">Step-by-step implementation guides</span>
                                    </li>
                                    <li class="flex">
                                        <svg class="flex-shrink-0 h-6 w-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="ml-3">Lifetime access to all content and updates</span>
                                    </li>
                                </ul>
                                
                                <div class="mt-10">
                                    <h4 class="text-lg font-medium text-white">Price: ${{ featuredProduct.price.toFixed(2) }}</h4>
                                    <div class="mt-4 flex space-x-4">
                                        <Link :href="route('products.show', { product: featuredProduct.id })" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700">
                                            Learn More
                                        </Link>
                                        <Link :href="route('guest.checkout', { product: featuredProduct.id })" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-orange-500 hover:bg-orange-600">
                                            Buy Now
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Tiers section -->
        <PricingTiers />

        <!-- Testimonial section -->
        <div id="testimonials" class="bg-gray-900 py-16 lg:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-orange-400 font-semibold tracking-wide uppercase">Testimonials</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-orange-400 sm:text-4xl">
                        What our customers are saying
                    </p>
                </div>
                
                <div class="mt-12">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                        <!-- Testimonial 1 -->
                        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700">
                            <div class="px-6 py-8">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-10 w-10 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z"></path>
                                            <path d="M12 17C14.7614 17 17 14.7614 17 12C17 9.23858 14.7614 7 12 7C9.23858 7 7 9.23858 7 12C7 14.7614 9.23858 17 12 17Z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-orange-400">Mike Ramirez</h3>
                                        <p class="text-sm text-white">Independent Low Voltage Technician</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-white">
                                        "The FieldOps Pro guide completely changed how I approach bidding for contracts. Within 2 weeks of applying these strategies, I landed 3 new clients and increased my rates by 30%."
                                    </p>
                                </div>
                                <div class="mt-4 flex">
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 2 -->
                        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700">
                            <div class="px-6 py-8">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-10 w-10 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z"></path>
                                            <path d="M12 17C14.7614 17 17 14.7614 17 12C17 9.23858 14.7614 7 12 7C9.23858 7 7 9.23858 7 12C7 14.7614 9.23858 17 12 17Z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-orange-400">Michael Chen</h3>
                                        <p class="text-sm text-white">Small Business Owner</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-white">
                                        "Worth every penny! The strategies I learned helped me increase my business revenue by 30% in just three months."
                                    </p>
                                </div>
                                <div class="mt-4 flex">
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 3 -->
                        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700">
                            <div class="px-6 py-8">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-10 w-10 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z"></path>
                                            <path d="M12 17C14.7614 17 17 14.7614 17 12C17 9.23858 14.7614 7 12 7C9.23858 7 7 9.23858 7 12C7 14.7614 9.23858 17 12 17Z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-orange-400">Jessica Rodriguez</h3>
                                        <p class="text-sm text-white">Freelance Consultant</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-white">
                                        "As a freelancer, this info product gave me the structure I needed to approach client projects more professionally and efficiently."
                                    </p>
                                </div>
                                <div class="mt-4 flex">
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- About section -->
        <div id="about" class="bg-gray-900 py-16 lg:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-orange-400 font-semibold tracking-wide uppercase">About Us</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-orange-400 sm:text-4xl">
                        Expert Knowledge, Delivered Digitally
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-white lg:mx-auto">
                        We create premium info products designed to help professionals succeed in their fields.
                    </p>
                </div>

                <div class="mt-10">
                    <div class="prose prose-orange prose-lg text-white mx-auto">
                        <p>
                            At FieldEngineer Pro, I'm sharing my years of hands-on experience as a successful field engineer in the low voltage industry. I've developed proven strategies for bidding, winning contracts, and setting competitive rates that maximize earnings on various work platforms.
                        </p>
                        <p>
                            What makes my info products different is that they're based on real-world success stories and techniques I've personally used to create a sustainable self-employment business. Whether you're a seasoned contractor looking to expand, or someone seeking to break into the field for extra income, these resources provide the exact roadmap I followed.
                        </p>
                        <p>
                            From optimizing your profile to stand out on bidding platforms, to pricing strategies that win contracts while maintaining profitability, to managing client relationships that lead to repeat business—my comprehensive guides cover everything you need to succeed as an independent low voltage contractor.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter section -->
        <div class="bg-gray-800 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:flex lg:items-center lg:justify-between">
                    <div class="max-w-xl">
                        <h2 class="text-3xl font-extrabold tracking-tight text-orange-400 sm:text-4xl">
                            Subscribe to our newsletter
                        </h2>
                        <p class="mt-3 text-lg text-white">
                            Get free tips, strategies, and occasional special offers delivered directly to your inbox.
                        </p>
                    </div>
                    <div class="mt-8 lg:mt-0 lg:ml-8">
                        <form class="sm:flex">
                            <label for="email-address" class="sr-only">Email address</label>
                            <input id="email-address" name="email" type="email" autocomplete="email" required class="w-full px-5 py-3 border border-gray-700 bg-gray-800 shadow-sm text-white placeholder-gray-400 focus:ring-1 focus:ring-orange-400 focus:border-orange-400 sm:max-w-xs rounded-md" placeholder="Enter your email">
                            <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3 sm:flex-shrink-0">
                                <button type="submit" class="w-full flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-gray-900 bg-orange-400 hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400">
                                    Subscribe
                                </button>
                            </div>
                        </form>
                        <p class="mt-3 text-sm text-gray-300">
                            We care about your data. Read our <a href="#" class="font-medium text-orange-400 underline">Privacy Policy</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900">
            <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
                <nav class="flex flex-wrap justify-center -mx-5 -my-2">
                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-white hover:text-orange-400">About</a>
                    </div>
                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-white hover:text-orange-400">Products</a>
                    </div>
                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-gray-500 hover:text-gray-900">Contact</a>
                    </div>
                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-gray-500 hover:text-gray-900">Terms</a>
                    </div>
                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-gray-500 hover:text-gray-900">Privacy</a>
                    </div>
                </nav>
                <div class="mt-8 flex justify-center space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                </div>
                <p class="mt-8 text-center text-base text-gray-400">
                    &copy; 2025 FieldEngineer Pro. All rights reserved. 
                    <Link :href="route('terms')" class="text-orange-400 hover:text-orange-500 ml-1">Terms & Conditions</Link>
                </p>
            </div>
        </footer>
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
.bg-pattern {
    background-image: radial-gradient(circle, rgba(255,255,255,0.2) 1px, transparent 1px);
    background-size: 15px 15px;
}
/* Cosmic ethereal animations */
.animate-pulse-slow {
    animation: pulse 6s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
@keyframes pulse {
    0%, 100% {
        opacity: 0.5;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.1);
    }
}

.animate-rotate-slow {
    animation: rotate 20s linear infinite;
}
@keyframes rotate {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

.animate-cosmic-drift {
    animation: cosmic-drift 15s ease-in-out infinite alternate;
}
@keyframes cosmic-drift {
    0% {
        transform: translateX(-5px) translateY(-5px) scale(0.95);
        opacity: 0.5;
    }
    50% {
        opacity: 0.7;
    }
    100% {
        transform: translateX(5px) translateY(5px) scale(1.05);
        opacity: 0.6;
    }
}

.animate-star-twinkle {
    animation: star-twinkle 4s ease-in-out infinite;
}
@keyframes star-twinkle {
    0%, 100% {
        opacity: 0.2;
        filter: blur(2px) brightness(0.8);
    }
    50% {
        opacity: 1;
        filter: blur(1px) brightness(1.2);
    }
}

.animate-nebula-pulse {
    animation: nebula-pulse 8s ease-in-out infinite alternate;
}
@keyframes nebula-pulse {
    0% {
        opacity: 0.6;
        filter: blur(15px) hue-rotate(0deg);
    }
    50% {
        opacity: 0.8;
        filter: blur(18px) hue-rotate(15deg);
    }
    100% {
        opacity: 0.7;
        filter: blur(20px) hue-rotate(0deg);
    }
}

.animate-cosmic-rays {
    animation: cosmic-rays 12s linear infinite;
}
@keyframes cosmic-rays {
    0% {
        transform: rotate(0deg) scale(1);
        opacity: 0.3;
    }
    50% {
        transform: rotate(180deg) scale(1.2);
        opacity: 0.7;
    }
    100% {
        transform: rotate(360deg) scale(1);
        opacity: 0.3;
    }
}

.animate-stardust {
    animation: stardust 15s ease-in-out infinite;
}
@keyframes stardust {
    0%, 100% {
        opacity: 0;
        transform: translateY(0) translateX(0) scale(0.2) rotate(0deg);
    }
    10% {
        opacity: 0.9;
    }
    50% {
        opacity: 0.5;
        transform: translateY(-60px) translateX(20px) scale(0.6) rotate(45deg);
    }
    90% {
        opacity: 0.8;
    }
    100% {
        transform: translateY(-120px) translateX(40px) scale(0.1) rotate(90deg);
    }
}
</style>