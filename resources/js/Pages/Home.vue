<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PricingTiers from '@/Components/PricingTiers.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import CountdownTimer from '@/Components/CountdownTimer.vue';
import PurchaseNotifications from '@/Components/PurchaseNotifications.vue';
import { ref, computed } from 'vue';

// For the mobile menu toggle
const mobileMenuOpen = ref(false);

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    featuredProduct: Object,
    products: Array,
    guestCheckout: Boolean,
    activeDiscount: Object,
});

// Find the Premium Business Consultation product
const consultationProduct = computed(() => {
    return props.products?.find(product => product.name === 'Premium Business Consultation');
});
</script>

<template>
    <Head>
        <title>Side Hustle Field Tech Work - Earn $2000-5000+ Monthly Income | FieldEngineer Pro</title>
        <meta name="description" content="Start your profitable side hustle in field engineering today. Learn low voltage contracting, fiber optics, and network installation skills to earn $2000-5000+ monthly. Perfect part-time business for extra income - no experience required. Join 1000+ students earning extra cash.">
        <meta name="keywords" content="side hustle, extra income, monthly income, field tech work, low voltage contractor, side business, part time work, electrical side hustle, contracting side gig, make extra money, field engineer side work, fiber optics training, network installation, passive income, second job, weekend work">
        
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ route('home') }}">
        <meta property="og:title" content="Side Hustle Field Tech Work - Earn $2000-5000+ Monthly Income">
        <meta property="og:description" content="Start your profitable side hustle in field engineering. Learn low voltage contracting skills to earn $2000-5000+ monthly. No experience required.">
        
        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Side Hustle Field Tech Work - Earn $2000-5000+ Monthly">
        <meta name="twitter:description" content="Start your profitable side hustle in field engineering. Learn low voltage contracting skills to earn $2000-5000+ monthly.">
        
        <!-- JSON-LD Structured Data for Course -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Course",
            "name": "Field Engineering & Low Voltage Contracting Side Hustle Training",
            "description": "Complete training program to start your side hustle in field engineering and low voltage contracting. Earn $2000-5000+ monthly in extra income.",
            "provider": {
                "@type": "Organization",
                "name": "FieldEngineer Pro",
                "sameAs": "{{ route('home') }}"
            },
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.8",
                "ratingCount": "1247",
                "bestRating": "5",
                "worstRating": "1"
            },
            "offers": {
                "@type": "Offer",
                "category": "Educational",
                "priceCurrency": "USD",
                "availability": "https://schema.org/InStock"
            },
            "educationalLevel": "Beginner to Advanced",
            "keywords": "side hustle, extra income, field engineering, low voltage contractor, monthly income, side business"
        }
        </script>
        
        <!-- JSON-LD for Organization -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "EducationalOrganization",
            "name": "FieldEngineer Pro",
            "description": "Leading platform for field engineering and low voltage contracting side hustle training",
            "url": "{{ route('home') }}",
            "logo": "{{ asset('img/fieldengineer-logo.png') }}",
            "contactPoint": {
                "@type": "ContactPoint",
                "contactType": "Customer Support",
                "email": "support@fieldengineerpro.com"
            },
            "sameAs": []
        }
        </script>
        
        <!-- JSON-LD for FAQs -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                {
                    "@type": "Question",
                    "name": "How much can I earn with a field tech side hustle?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Most students earn between $2000-5000+ per month working part-time. Some advanced students earn $100,000+ annually doing field tech work on weekends and evenings."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Do I need experience to start?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "No experience required! Our training covers everything from basic tools to advanced low voltage contracting, fiber optics, and network installation."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How much time do I need to invest?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "You can start with just 5-10 hours per week. Many students work evenings and weekends while keeping their full-time jobs."
                    }
                },
                {
                    "@type": "Question",
                    "name": "What skills will I learn?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "You'll learn low voltage contracting, fiber optic installation, network cabling, troubleshooting, client management, pricing strategies, and business development for your side hustle."
                    }
                }
            ]
        }
        </script>
    </Head>

    <!-- Modern Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 w-ful backdrop-blur-md border-b border-white/10 shadow-2xl">
        <!-- Top announcement bar (optional) -->
        <div class="bg-gradient-to-r from-orange-600 to-orange-500 text-white text-center py-2 text-sm font-medium hidden md:block">
            <span class="hidden sm:inline">🚀 Limited Time: Start Your Journey Today - </span>
            <span class="font-bold">Earn $100k+ yearly</span>
            <span class="hidden sm:inline"> in Your Spare Time</span>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 backdrop-blur-md">
            <div class="flex justify-between items-center h-20">
                <!-- Logo and Brand -->
                <div class="flex items-center">
                    <Link href="/" class="flex items-center group">
                        <div class="relative">
                            <div class="absolute inset-0 bg-orange-500 rounded-lg blur-lg opacity-50 group-hover:opacity-75 transition-opacity duration-300"></div>
                            <ApplicationLogo class="relative h-12 w-12 fill-current text-orange-500 mr-3 transform group-hover:scale-110 transition-transform duration-300" />
                        </div>
                        <div>
                            <span class="text-2xl font-bold bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">FieldEngineer Pro</span>
                            <span class="hidden md:block text-xs text-gray-400 font-medium">Your Side Hustle Success Path</span>
                        </div>
                    </Link>
                </div>
                
                <!-- Desktop Navigation Menu -->
                <div class="hidden lg:flex items-center space-x-1">
                    <Link v-if="featuredProduct" 
                          :href="route('products.show', featuredProduct)" 
                          class="group relative px-4 py-2 text-gray-300 hover:text-white font-medium transition-colors duration-200">
                        <span class="relative z-10">Training Guide</span>
                        <div class="absolute inset-0 bg-orange-500/0 group-hover:bg-orange-500/10 rounded-lg transition-colors duration-200"></div>
                    </Link>
                    
                    <Link href="#testimonials" 
                          class="group relative px-4 py-2 text-gray-300 hover:text-white font-medium transition-colors duration-200">
                        <span class="relative z-10">Success Stories</span>
                        <div class="absolute inset-0 bg-orange-500/0 group-hover:bg-orange-500/10 rounded-lg transition-colors duration-200"></div>
                    </Link>
                    
                    <Link href="#about" 
                          class="group relative px-4 py-2 text-gray-300 hover:text-white font-medium transition-colors duration-200">
                        <span class="relative z-10">About</span>
                        <div class="absolute inset-0 bg-orange-500/0 group-hover:bg-orange-500/10 rounded-lg transition-colors duration-200"></div>
                    </Link>
                    
                    <!-- Divider -->
                    <div class="h-8 w-px bg-gray-700 mx-2"></div>
                    
                    <!-- Auth Buttons -->
                    <Link href="/login" 
                          class="px-4 py-2 text-gray-300 hover:text-white font-medium transition-colors duration-200">
                        Sign In
                    </Link>
                    
                    <Link href="/register" 
                          class="group relative inline-flex items-center px-6 py-2.5 overflow-hidden rounded-lg bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold shadow-lg hover:shadow-orange-500/50 transition-all duration-300 transform hover:scale-105">
                        <span class="relative z-10 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Register Free
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-orange-600 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                    </Link>
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="flex items-center lg:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="relative p-2 rounded-lg text-gray-300 hover:text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-all duration-200"
                            :aria-expanded="mobileMenuOpen"
                            aria-label="Toggle navigation menu">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Menu Dropdown -->
            <div v-if="mobileMenuOpen" 
                 class="lg:hidden absolute left-0 right-0 top-full bg-gray-900/95 backdrop-blur-lg border-t border-white/10 shadow-2xl z-[70]"
                 style="animation: slideDown 0.3s ease-out;">
                <div class="px-4 py-6 space-y-3">
                    <Link v-if="featuredProduct" 
                          :href="route('products.show', featuredProduct)" 
                          class="block px-4 py-3 text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-all duration-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Training Guide
                        </div>
                    </Link>
                    
                    <Link href="#testimonials" 
                          class="block px-4 py-3 text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-all duration-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Success Stories
                        </div>
                    </Link>
                    
                    <Link href="#about" 
                          class="block px-4 py-3 text-base font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-all duration-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            About
                        </div>
                    </Link>
                    
                    <div class="pt-4 space-y-2 border-t border-gray-800">
                        <Link href="/login" 
                              class="block w-full px-4 py-3 text-center font-medium text-gray-300 hover:text-white border-2 border-gray-700 hover:border-gray-600 rounded-lg transition-all duration-200">
                            Sign In
                        </Link>
                        
                        <Link href="/register" 
                              class="block w-full px-4 py-3 text-center font-bold text-white bg-gradient-to-r from-orange-600 to-orange-500 rounded-lg shadow-lg hover:shadow-orange-500/50 transition-all duration-200 transform hover:scale-105">
                            <span class="flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Register Free
                            </span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="min-h-screen bg-gray-900 dark:bg-gray-900">
        <!-- Spacer to account for fixed navbar -->
        <div class="h-20 md:h-24"><!-- 80px nav on mobile, 96px (24*4) nav on desktop --></div>
        
        <!-- Hero section -->
        <div class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 overflow-hidden">
            <!-- Animated background elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-orange-500/20 rounded-full blur-3xl animate-pulse-slow"></div>
                <div class="absolute top-40 -left-40 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: -2s;"></div>
                <div class="absolute bottom-20 right-20 w-64 h-64 bg-cyan-500/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: -4s;"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="text-center lg:text-left">
                        <!-- Badge -->
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-orange-500/20 border border-orange-500/30 mb-6">
                            <svg class="w-4 h-4 text-orange-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="text-orange-300 font-semibold text-sm">The #1 Field Tech Side Hustle Training</span>
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6">
                            <span class="block text-white">Master the art of field engineering</span>
                            <span class="block bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">Earn $2K-$5K+ Monthly Income</span>
                        </h1>

                        <p class="text-lg sm:text-xl text-gray-300 mb-8 leading-relaxed">
                            Master the art of field engineering and build a <strong class="text-white">profitable side hustle</strong> with proven independent contracting strategies. No experience needed—start earning within weeks.
                        </p>

                        <!-- Stats Bar -->
                        <div class="grid grid-cols-3 gap-4 mb-8 p-6 bg-white/5 backdrop-blur-sm rounded-xl border border-white/10">
                            <div class="text-center">
                                <div class="text-2xl sm:text-3xl font-bold text-orange-400">$50-150</div>
                                <div class="text-xs sm:text-sm text-gray-400">Per Hour</div>
                            </div>
                            <div class="text-center border-l border-r border-gray-700">
                                <div class="text-2xl sm:text-3xl font-bold text-orange-400">100%</div>
                                <div class="text-xs sm:text-sm text-gray-400">Remote Ready</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl sm:text-3xl font-bold text-orange-400">0</div>
                                <div class="text-xs sm:text-sm text-gray-400">Experience Needed</div>
                            </div>
                        </div>

                        <!-- Feature List -->
                        <div class="grid sm:grid-cols-2 gap-3 mb-8 text-left">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-green-500/20 flex items-center justify-center mt-0.5">
                                    <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-gray-300">Work your own schedule</span>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-green-500/20 flex items-center justify-center mt-0.5">
                                    <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-gray-300">Set your own rates</span>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-green-500/20 flex items-center justify-center mt-0.5">
                                    <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-gray-300">Keep your day job</span>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-green-500/20 flex items-center justify-center mt-0.5">
                                    <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="ml-3 text-gray-300">Available in all 50 states</span>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <Link :href="route('guest.checkout', { product: featuredProduct.id })" class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg overflow-hidden shadow-xl hover:shadow-orange-500/50 transition-all duration-300 transform hover:scale-105">
                                <span class="relative z-10 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Start Your Side Hustle
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-orange-600 to-orange-700 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                            </Link>
                            <Link :href="route('products.show', { product: featuredProduct.id })" class="inline-flex items-center justify-center px-8 py-4 text-lg font-bold text-orange-400 bg-white/5 backdrop-blur-sm border-2 border-orange-500/30 rounded-lg hover:bg-white/10 hover:border-orange-500/50 transition-all duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                See How It Works
                            </Link>
                        </div>

                        <!-- Trust Indicators -->
                        <div class="mt-8 flex flex-wrap items-center justify-center lg:justify-start gap-6 text-sm text-gray-400">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Instant Access
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Lifetime Updates
                            </div>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Money-Back Guarantee
                            </div>
                        </div>
                    </div>

                    <!-- Right Content - Image with decorative elements -->
                    <div class="relative hidden lg:block">
                        <div class="relative">
                            <!-- Decorative gradient border -->
                            <div class="absolute -inset-4 bg-gradient-to-r from-orange-500 to-cyan-500 rounded-2xl blur-xl opacity-30 animate-pulse-slow"></div>
                            
                            <!-- Main image -->
                            <div class="relative rounded-2xl overflow-hidden shadow-2xl transform hover:scale-105 transition-transform duration-500">
                                <img class="w-full h-[600px] object-cover" src="https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2850&q=80" alt="Field engineer working with low voltage equipment">
                                
                                <!-- Overlay badge -->
                                <div class="absolute bottom-6 left-6 right-6 bg-gray-900/90 backdrop-blur-sm rounded-xl p-4 border border-orange-500/30">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-orange-400 font-bold text-lg">Start Earning Fast</div>
                                            <div class="text-gray-300 text-sm">Complete training included</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-white font-bold text-2xl">$5K+</div>
                                            <div class="text-gray-400 text-xs">Monthly Potential</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Engaging Questions Section -->
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                        What If You Could...
                    </h2>
                    <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                        <!-- Question 1 -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-white text-orange-600 mx-auto mb-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">Make Your Own Schedule?</h3>
                            <p class="text-orange-100">Choose exactly when you want to work - mornings, evenings, or weekends only</p>
                        </div>

                        <!-- Question 2 -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-white text-orange-600 mx-auto mb-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">Delegate What Work You Want?</h3>
                            <p class="text-orange-100">Pick and choose the projects that interest you and fit your skills</p>
                        </div>

                        <!-- Question 3 -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-white text-orange-600 mx-auto mb-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">Select Your Hourly Rate?</h3>
                            <p class="text-orange-100">Set competitive rates based on your skills - $50-150+ per hour</p>
                        </div>

                        <!-- Question 4 -->
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-white text-orange-600 mx-auto mb-4">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-white mb-2">Own Your Business Without the Weight?</h3>
                            <p class="text-orange-100">Harness business ownership power without heavy overhead, employees, or stress</p>
                        </div>
                    </div>

                    <div class="mt-12 bg-white/20 backdrop-blur-sm rounded-xl p-8 max-w-4xl mx-auto">
                        <h3 class="text-2xl font-bold text-white mb-4">We Can Show You How to Do Exactly That!</h3>
                        <p class="text-xl text-orange-100 mb-6">
                            Our proven field engineering strategies give you complete control over your time, income, and business decisions. 
                            Experience the freedom of entrepreneurship without the traditional business burdens.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <Link :href="route('guest.checkout', { product: featuredProduct.id })" class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-medium rounded-md text-orange-600 bg-white hover:bg-orange-50 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Start Your Freedom Journey
                            </Link>
                            <Link :href="route('products.show', { product: featuredProduct.id })" class="inline-flex items-center px-8 py-4 border-2 border-white text-lg font-medium rounded-md text-white hover:bg-white hover:text-orange-600 transition-colors duration-200">
                                Learn How It Works
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Featured Product Section -->
        <div id="featured" class="py-12 bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-orange-400 font-semibold tracking-wide uppercase">Side Hustle Training Guide</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-orange-400 sm:text-4xl">
                        {{ featuredProduct.name }}
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-white lg:mx-auto">
                        Complete side business blueprint for field engineering work. Learn how to earn extra income on weekends and evenings with proven low voltage contracting strategies. Turn your spare time into $2000-5000+ monthly income.
                    </p>
                </div>

                <div class="mt-10">
                    <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
                        <!-- Left Side: Book Cover with 3D effect -->
                        <div class="mb-10 lg:mb-0 flex justify-center lg:justify-start">
                            <!-- Ambient glow effect container -->
                            <div class="relative w-44 sm:w-56 md:w-72 lg:w-auto max-w-xs mx-auto lg:mx-0 book-container isolate">
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
                                
                                <!-- Enhanced magical stardust particles -->
                                <div class="absolute bottom-0 left-1/4 w-0.5 h-20 bg-gradient-to-t from-transparent via-cyan-400/70 to-white/90 rounded-full blur-sm animate-stardust"></div>
                                <div class="absolute bottom-0 left-1/2 w-0.5 h-24 bg-gradient-to-t from-transparent via-blue-400/80 to-white/90 rounded-full blur-sm animate-stardust" style="animation-delay: -3s;"></div>
                                <div class="absolute bottom-0 left-3/4 w-0.5 h-28 bg-gradient-to-t from-transparent via-violet-400/90 to-white/90 rounded-full blur-sm animate-stardust" style="animation-delay: -6s;"></div>
                                <div class="absolute bottom-10 left-1/3 w-0.5 h-18 bg-gradient-to-t from-transparent via-blue-300/80 to-white/90 rounded-full blur-sm animate-stardust" style="animation-delay: -9s;"></div>
                                <div class="absolute bottom-14 left-2/3 w-0.5 h-16 bg-gradient-to-t from-transparent via-cyan-300/80 to-white/90 rounded-full blur-sm animate-stardust" style="animation-delay: -12s;"></div>
                                
                                <!-- Additional magical particles -->
                                <div class="absolute bottom-2 left-[45%] w-1 h-1 bg-blue-300 rounded-full animate-float-particle blur-sm -z-10"></div>
                                <div class="absolute bottom-6 left-[55%] w-1.5 h-1.5 bg-cyan-200 rounded-full animate-float-particle-slow blur-sm -z-10" style="animation-delay: -2s;"></div>
                                <div class="absolute bottom-10 left-[35%] w-1 h-1 bg-violet-200 rounded-full animate-float-particle blur-sm -z-10" style="animation-delay: -4s;"></div>
                                <div class="absolute bottom-8 left-[65%] w-2 h-2 bg-white rounded-full animate-float-particle-slow blur-sm -z-10" style="animation-delay: -6s;"></div>
                                <div class="absolute bottom-12 left-[40%] w-1.5 h-1.5 bg-blue-100 rounded-full animate-float-particle blur-sm -z-10" style="animation-delay: -8s;"></div>
                                
                                <!-- Small magical particles -->
                                <div class="absolute bottom-4 left-[30%] w-0.5 h-0.5 bg-cyan-100 rounded-full animate-float-particle blur-[0.5px] -z-10" style="animation-delay: -1s;"></div>
                                <div class="absolute bottom-7 left-[28%] w-0.5 h-0.5 bg-blue-200 rounded-full animate-float-particle-slow blur-[0.5px] -z-10" style="animation-delay: -3.5s;"></div>
                                <div class="absolute bottom-10 left-[27%] w-1 h-1 bg-indigo-200 rounded-full animate-float-particle blur-[0.5px] -z-10" style="animation-delay: -5.2s;"></div>
                                <div class="absolute bottom-8 left-[32%] w-0.5 h-0.5 bg-violet-100 rounded-full animate-float-particle-slow blur-[0.5px] -z-10" style="animation-delay: -7.3s;"></div>
                                
                                <div class="absolute bottom-3 left-[60%] w-0.5 h-0.5 bg-blue-100 rounded-full animate-float-particle-slow blur-[0.5px] -z-10" style="animation-delay: -2.2s;"></div>
                                <div class="absolute bottom-7 left-[62%] w-1 h-1 bg-cyan-200 rounded-full animate-float-particle blur-[0.5px] -z-10" style="animation-delay: -4.7s;"></div>
                                <div class="absolute bottom-11 left-[64%] w-0.5 h-0.5 bg-white rounded-full animate-float-particle-slow blur-[0.5px] -z-10" style="animation-delay: -6.8s;"></div>
                                <div class="absolute bottom-14 left-[66%] w-0.5 h-0.5 bg-purple-100 rounded-full animate-float-particle blur-[0.5px] -z-10" style="animation-delay: -8.9s;"></div>
                                
                                <div class="absolute bottom-5 left-[48%] w-0.5 h-0.5 bg-blue-50 rounded-full animate-float-particle-slow blur-[0.5px] -z-10" style="animation-delay: -1.5s;"></div>
                                <div class="absolute bottom-9 left-[52%] w-0.5 h-0.5 bg-indigo-50 rounded-full animate-float-particle blur-[0.5px] -z-10" style="animation-delay: -3.7s;"></div>
                                
                                <!-- Micro magical particles -->
                                <div class="absolute bottom-7 left-[42%] w-[2px] h-[2px] bg-white rounded-full animate-float-particle-slow -z-10" style="animation-delay: -1.2s;"></div>
                                <div class="absolute bottom-9 left-[43%] w-[2px] h-[2px] bg-blue-100 rounded-full animate-float-particle -z-10" style="animation-delay: -2.4s;"></div>
                                <div class="absolute bottom-11 left-[44%] w-[2px] h-[2px] bg-cyan-50 rounded-full animate-float-particle-slow -z-10" style="animation-delay: -3.6s;"></div>
                                <div class="absolute bottom-13 left-[45%] w-[2px] h-[2px] bg-indigo-100 rounded-full animate-float-particle -z-10" style="animation-delay: -4.8s;"></div>
                                
                                <div class="absolute bottom-6 left-[57%] w-[2px] h-[2px] bg-purple-50 rounded-full animate-float-particle -z-10" style="animation-delay: -1.8s;"></div>
                                <div class="absolute bottom-8 left-[58%] w-[2px] h-[2px] bg-white rounded-full animate-float-particle-slow -z-10" style="animation-delay: -3.0s;"></div>
                                <div class="absolute bottom-10 left-[59%] w-[2px] h-[2px] bg-blue-50 rounded-full animate-float-particle -z-10" style="animation-delay: -4.2s;"></div>
                                
                                <div class="absolute bottom-4 left-[38%] w-[1px] h-[1px] bg-cyan-100 rounded-full animate-float-particle-slow -z-10" style="animation-delay: -2.1s;"></div>
                                <div class="absolute bottom-6 left-[39%] w-[1px] h-[1px] bg-white rounded-full animate-float-particle -z-10" style="animation-delay: -3.3s;"></div>
                                <div class="absolute bottom-8 left-[40%] w-[1px] h-[1px] bg-indigo-50 rounded-full animate-float-particle-slow -z-10" style="animation-delay: -4.5s;"></div>
                                
                                <div class="absolute bottom-5 left-[62%] w-[1px] h-[1px] bg-blue-50 rounded-full animate-float-particle -z-10" style="animation-delay: -1.6s;"></div>
                                <div class="absolute bottom-7 left-[63%] w-[1px] h-[1px] bg-cyan-100 rounded-full animate-float-particle-slow -z-10" style="animation-delay: -2.8s;"></div>
                                <div class="absolute bottom-9 left-[64%] w-[1px] h-[1px] bg-white rounded-full animate-float-particle -z-10" style="animation-delay: -4.0s;"></div>
                                
                                <!-- Additional varied animation particles -->
                                <div class="absolute bottom-3 left-[47%] w-[2px] h-[2px] bg-cyan-100 rounded-full animate-float-particle-micro -z-10" style="animation-delay: -0.7s;"></div>
                                <div class="absolute bottom-5 left-[48%] w-[2px] h-[2px] bg-indigo-50 rounded-full animate-float-particle-tiny -z-10" style="animation-delay: -1.4s;"></div>
                                <div class="absolute bottom-7 left-[49%] w-[1px] h-[1px] bg-white rounded-full animate-sparkle -z-10" style="animation-delay: -2.1s;"></div>
                                
                                <div class="absolute bottom-4 left-[51%] w-[1px] h-[1px] bg-blue-50 rounded-full animate-sparkle -z-10" style="animation-delay: -0.5s;"></div>
                                <div class="absolute bottom-6 left-[52%] w-[1px] h-[1px] bg-white rounded-full animate-float-particle-micro -z-10" style="animation-delay: -1.0s;"></div>
                                <div class="absolute bottom-8 left-[53%] w-[1px] h-[1px] bg-cyan-50 rounded-full animate-float-particle-tiny -z-10" style="animation-delay: -1.5s;"></div>
                                
                                <div class="absolute bottom-6 left-[32%] w-[1px] h-[1px] bg-indigo-50 rounded-full animate-sparkle -z-10" style="animation-delay: -0.3s;"></div>
                                <div class="absolute bottom-8 left-[33%] w-[1px] h-[1px] bg-blue-50 rounded-full animate-float-particle-micro -z-10" style="animation-delay: -0.9s;"></div>
                                <div class="absolute bottom-10 left-[34%] w-[2px] h-[2px] bg-white rounded-full animate-float-particle-tiny -z-10" style="animation-delay: -1.8s;"></div>
                                
                                <div class="absolute bottom-7 left-[67%] w-[1px] h-[1px] bg-white rounded-full animate-sparkle -z-10" style="animation-delay: -0.6s;"></div>
                                <div class="absolute bottom-9 left-[68%] w-[1px] h-[1px] bg-cyan-50 rounded-full animate-float-particle-micro -z-10" style="animation-delay: -1.2s;"></div>
                                <div class="absolute bottom-11 left-[69%] w-[2px] h-[2px] bg-blue-50 rounded-full animate-float-particle-tiny -z-10" style="animation-delay: -2.4s;"></div>
                                
                                <!-- Magical glow effects moved to be behind the book -->
                                <!-- Will be positioned but invisible until we add z-index to the book -->
                                
                                <!-- Ethereal light beams -->
                                <div class="absolute top-[20%] -left-10 w-60 h-96 bg-gradient-to-b from-blue-400/30 via-indigo-400/20 to-transparent rotate-30 blur-3xl transform-gpu animate-pulse-slow"></div>
                                <div class="absolute top-[30%] -right-10 w-60 h-80 bg-gradient-to-t from-cyan-500/30 via-blue-400/20 to-transparent -rotate-30 blur-3xl transform-gpu animate-pulse-slow" style="animation-delay: -4s;"></div>
                                
                                <!-- Book Cover with 3D effect -->
                                <div class="relative transform perspective-1000 rotate-y-0 hover:rotate-y-10 transition-transform duration-500 shadow-2xl z-10">
                                    <div class="w-full aspect-[3/4] bg-gradient-to-br from-slate-800 via-gray-900 to-slate-900 rounded-lg shadow-xl overflow-hidden relative">
                                        <!-- Book Cover Pattern -->
                                        <div class="absolute inset-0 opacity-20 bg-pattern"></div>
                                        <div class="absolute inset-0 bg-gradient-to-tr from-black/20 via-transparent to-white/10"></div>
                                        
                                        <!-- Book Spine Effect -->
                                        <div class="absolute left-0 top-0 h-full w-[8px] sm:w-[10px] md:w-[15px] bg-gradient-to-r from-slate-700 to-gray-900"></div>
                                        
                                        <!-- Book Content -->
                                        <div class="flex flex-col h-full p-3 sm:p-4 md:p-6 pl-6 sm:pl-8 md:pl-10 relative">
                                            <!-- Icons at the top -->
                                            <div class="flex items-center gap-2 sm:gap-3 md:gap-4 mb-3 sm:mb-5 md:mb-8 mt-6 sm:mt-8 md:mt-12">
                                                <!-- Square with circle icon -->
                                                <div class="h-8 w-8 sm:h-10 sm:w-10 md:h-14 md:w-14 bg-gradient-to-br from-orange-300 to-orange-500 rounded-md flex items-center justify-center shadow-md">
                                                    <div class="h-4 w-4 sm:h-6 sm:w-6 md:h-8 md:w-8 bg-gray-700 rounded-full shadow-inner"></div>
                                                </div>
                                                <!-- Circle with square icon -->
                                                <div class="h-8 w-8 sm:h-10 sm:w-10 md:h-14 md:w-14 bg-gradient-to-br from-orange-300 to-orange-500 rounded-full flex items-center justify-center shadow-md">
                                                    <div class="h-4 w-4 sm:h-6 sm:w-6 md:h-8 md:w-8 bg-gray-600 rounded-md shadow-inner"></div>
                                                </div>
                                            </div>
                                            
                                            <!-- Title -->
                                            <div class="mt-auto mb-2 sm:mb-3 md:mb-4">
                                                <h3 class="text-2xl sm:text-3xl md:text-4xl leading-tight font-bold text-white mb-1 sm:mb-2">FieldEngineer</h3>
                                                <h4 class="text-2xl sm:text-3xl md:text-4xl leading-tight font-bold text-white mb-2 sm:mb-3 md:mb-4">Pro</h4>
                                                
                                                <!-- Separator line -->
                                                <div class="w-16 sm:w-20 md:w-24 h-1 bg-gradient-to-r from-orange-400 to-orange-500 mb-2 sm:mb-3 md:mb-4 rounded-full"></div>
                                                
                                                <p class="text-sm sm:text-base md:text-lg font-light text-white mb-6 sm:mb-8 md:mb-12 leading-relaxed">
                                                    {{ featuredProduct.short_description || "The definitive method to mastering field operations." }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- All magical glow effects with explicit z-index to keep them behind the book -->
                                <!-- Cosmic shadow effects -->
                                <div class="absolute -bottom-3 left-0 right-8 h-4 bg-black/20 blur-sm rounded-full -z-10"></div>
                                <div class="absolute -bottom-2 left-4 right-6 h-6 bg-black/15 blur-md rounded-full -z-10"></div>
                                
                                <!-- Magical light rays behind book -->
                                <div class="absolute top-1/2 left-1/2 w-0.5 h-36 bg-white/90 blur-sm transform rotate-[20deg] origin-bottom translate-y-[-10%] translate-x-[-50%] animate-pulse-slow -z-10"></div>
                                <div class="absolute top-1/2 left-[45%] w-0.5 h-32 bg-cyan-100/90 blur-sm transform rotate-[10deg] origin-bottom translate-y-[-20%] animate-pulse-slow -z-10" style="animation-delay: -2s;"></div>
                                <div class="absolute top-1/2 left-[55%] w-0.5 h-28 bg-blue-100/90 blur-sm transform rotate-[-15deg] origin-bottom translate-y-[-15%] animate-pulse-slow -z-10" style="animation-delay: -4s;"></div>
                                
                                <!-- Magical focal point behind book -->
                                <div class="absolute top-[45%] left-1/2 -translate-x-1/2 w-16 h-16 bg-white rounded-full opacity-70 blur-xl animate-pulse-slow -z-10"></div>
                                <div class="absolute top-[45%] left-1/2 -translate-x-1/2 w-10 h-10 bg-cyan-200 rounded-full opacity-80 blur-lg animate-pulse-fast -z-10" style="animation-delay: -1s;"></div>
                                <div class="absolute top-[45%] left-1/2 -translate-x-1/2 w-6 h-6 bg-blue-100 rounded-full opacity-90 blur-md animate-pulse-fast -z-10" style="animation-delay: -2s;"></div>
                                
                                <!-- Magical book glow - primary glow -->
                                <div class="absolute -bottom-10 -left-10 -right-10 h-24 bg-gradient-to-r from-cyan-300/60 via-blue-400/70 to-purple-600/60 blur-2xl rounded-full animate-nebula-pulse -z-10"></div>
                                
                                <!-- Ethereal glow beneath - secondary layer -->
                                <div class="absolute -bottom-14 -left-8 -right-8 h-20 bg-gradient-to-r from-blue-600/70 via-cyan-400/80 to-indigo-600/70 blur-3xl rounded-full animate-pulse-slow -z-10" style="animation-delay: -2s;"></div>
                                
                                <!-- Cosmic energy pool - tertiary layer -->
                                <div class="absolute -bottom-8 left-[15%] right-[15%] h-14 bg-gradient-to-r from-violet-500/80 via-white/90 to-blue-500/80 blur-xl rounded-full animate-pulse-slow -z-10" style="animation-delay: -3s;"></div>
                                
                                <!-- Center bright glow -->
                                <div class="absolute -bottom-6 left-[25%] right-[25%] h-10 bg-gradient-to-r from-cyan-300/90 via-white/100 to-cyan-300/90 blur-md rounded-full animate-pulse-fast -z-10"></div>
                                
                                <!-- Intense center light source -->
                                <div class="absolute -bottom-1 left-[40%] right-[40%] h-8 bg-white shadow-lg shadow-cyan-500/50 blur-sm rounded-full animate-pulse-fast -z-10" style="animation-delay: -1s;"></div>
                                
                                <!-- Book Pages Edge -->
                                <div class="absolute top-[2%] bottom-[2%] right-0 w-[6px] bg-gradient-to-l from-gray-100 via-gray-200 to-gray-300 rounded-r transform translate-x-[3px]">
                                    <!-- Subtle page separator lines -->
                                    <div class="h-full w-full opacity-30" style="background-image: repeating-linear-gradient(to bottom, transparent, transparent 3px, rgba(0,0,0,0.1) 3px, rgba(0,0,0,0.1) 4px);"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-10 lg:mt-0">
                            <h3 class="text-2xl font-extrabold text-orange-400">Professional Field Engineering Excellence</h3>
                            <div class="mt-4 text-white">
                                <ul class="mt-6 space-y-6">
                                    <li class="flex">
                                        <svg class="flex-shrink-0 h-6 w-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 9.172V5L8 4z"></path>
                                        </svg>
                                        <span class="ml-3">Essential troubleshooting tools and methodologies for efficient field work</span>
                                    </li>
                                    <li class="flex">
                                        <svg class="flex-shrink-0 h-6 w-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        <span class="ml-3">Proven strategies for competitive pricing and sustainable income growth</span>
                                    </li>
                                    <li class="flex">
                                        <svg class="flex-shrink-0 h-6 w-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <span class="ml-3">Accessible for technicians at any experience level - from newcomers to experts</span>
                                    </li>
                                    <li class="flex">
                                        <svg class="flex-shrink-0 h-6 w-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="ml-3">Step-by-step implementation guides for immediate professional results</span>
                                    </li>
                                    <li class="flex">
                                        <svg class="flex-shrink-0 h-6 w-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="ml-3">Lifetime access to all strategies and future content updates</span>
                                    </li>
                                </ul>
                                
                                <div class="mt-8 p-4 bg-blue-900/30 border border-blue-700 rounded-lg">
                                    <h4 class="text-lg font-semibold text-blue-400 mb-2">� Professional Growth</h4>
                                    <p class="text-blue-200">Master the skills and business strategies that successful field engineers use to build thriving independent contracting businesses with potential earnings up to $5,000+ monthly.</p>
                                </div>
                                
                                <div class="mt-10">
                                    <div class="flex items-baseline gap-3 mb-2">
                                        <h4 class="text-lg font-medium text-white">Investment:</h4>
                                        <div class="flex items-baseline gap-2">
                                            <span v-if="activeDiscount" class="text-lg text-gray-400 line-through">${{ parseFloat(featuredProduct.price).toFixed(2) }}</span>
                                            <span class="text-2xl font-bold text-orange-400">${{ activeDiscount ? parseFloat(activeDiscount.discounted_price).toFixed(2) : parseFloat(featuredProduct.price).toFixed(2) }}</span>
                                            <span v-if="activeDiscount" class="text-sm font-bold text-green-400 bg-green-500/20 px-2 py-1 rounded">{{ activeDiscount.discount_percentage }}% OFF</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-300 text-sm mt-1">
                                        <span v-if="activeDiscount">Professional development that pays for itself - Limited time offer!</span>
                                        <span v-else>Professional development that pays for itself</span>
                                    </p>
                                    <div class="mt-4">
                                        <Link :href="route('guest.checkout', { product: featuredProduct.id })" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-orange-500 hover:bg-orange-600">
                                            Get Started
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
        <PricingTiers :active-discount="activeDiscount" />

        <!-- Side Hustle Benefits Section -->
        <div class="bg-gray-800 py-16 lg:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-orange-400 font-semibold tracking-wide uppercase">Perfect Side Business</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-orange-400 sm:text-4xl">
                        Why Field Tech Work is the Ultimate Side Hustle
                    </p>
                    <p class="mt-4 max-w-2xl text-xl text-white lg:mx-auto">
                        Discover why thousands are choosing field engineering as their go-to side business for reliable extra income.
                    </p>
                </div>
                
                <div class="mt-16">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                        <!-- Benefit 1 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-orange-500 text-white mx-auto">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-xl font-medium text-white">High Hourly Rates</h3>
                            <p class="mt-2 text-gray-300">Earn $50-150+ per hour for field tech work. Much higher than typical side hustle opportunities like delivery or retail work.</p>
                        </div>

                        <!-- Benefit 2 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-orange-500 text-white mx-auto">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-xl font-medium text-white">Flexible Schedule</h3>
                            <p class="mt-2 text-gray-300">Work weekends, evenings, or whenever fits your schedule. Perfect for people with day jobs looking for extra income.</p>
                        </div>

                        <!-- Benefit 3 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-orange-500 text-white mx-auto">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-xl font-medium text-white">Low Startup Costs</h3>
                            <p class="mt-2 text-gray-300">Start with basic tools you may already have. No expensive equipment or inventory required to begin earning.</p>
                        </div>

                        <!-- Benefit 4 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-orange-500 text-white mx-auto">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-xl font-medium text-white">Skill-Based Work</h3>
                            <p class="mt-2 text-gray-300">Build valuable technical skills that increase your earning potential over time. More rewarding than gig economy jobs.</p>
                        </div>

                        <!-- Benefit 5 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-orange-500 text-white mx-auto">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-xl font-medium text-white">Local Market Demand</h3>
                            <p class="mt-2 text-gray-300">High demand for field tech services in every US state. Businesses always need reliable technical support and installations.</p>
                        </div>

                        <!-- Benefit 6 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-orange-500 text-white mx-auto">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                </svg>
                            </div>
                            <h3 class="mt-4 text-xl font-medium text-white">Scalable Income</h3>
                            <p class="mt-2 text-gray-300">Start part-time earning $2000+ monthly, then scale to $5000+ or even transition to full-time contracting when ready.</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12 text-center">
                    <div class="bg-orange-600/20 border border-orange-500/30 rounded-lg p-6 max-w-4xl mx-auto">
                        <h3 class="text-2xl font-bold text-orange-400 mb-4">Ready to Start Your Side Hustle?</h3>
                        <p class="text-white text-lg mb-6">Join thousands earning extra income with field engineering work. Perfect for anyone looking to supplement their current income with high-paying, flexible side work.</p>
                        <Link :href="route('guest.checkout', { product: featuredProduct.id })" class="inline-flex items-center px-8 py-3 border border-transparent text-lg font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700">
                            Start My Side Hustle Today
                        </Link>
                    </div>
                </div>
            </div>
        </div>

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

        <!-- Business Development Service Section -->
        <div class="relative py-24 bg-gradient-to-br from-gray-900 to-amber-900 overflow-hidden">
            <!-- Background decoration -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 right-1/4 w-96 h-96 bg-orange-500 rounded-full filter blur-3xl"></div>
                <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-cyan-500 rounded-full filter blur-3xl"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500/20 to-cyan-500/20 border border-orange-500/30 rounded-full mb-4">
                        <svg class="w-5 h-5 text-orange-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-orange-400 font-semibold text-sm">PREMIUM SERVICE</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                        We'll Build Your <span class="bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">Field Tech Business</span> For You
                    </h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                        Skip the learning curve. Let us handle everything while you focus on what you do best—earning money in the field.
                    </p>
                </div>

                <!-- Main Content Grid -->
                <div class="grid lg:grid-cols-2 gap-12 items-center mb-16">
                    <!-- Left: Service Details -->
                    <div class="space-y-8">
                        <div class="bg-gradient-to-br from-gray-800/80 to-gray-900/80 backdrop-blur-sm border border-gray-700 rounded-2xl p-8">
                            <h3 class="text-2xl font-bold text-white mb-6">Complete Business Setup Package</h3>
                            
                            <div class="space-y-6">
                                <!-- Service Item 1 -->
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-white mb-2">Business Name & Branding</h4>
                                        <p class="text-gray-400">Professional business name development, logo design, and complete brand identity package that makes you stand out.</p>
                                    </div>
                                </div>

                                <!-- Service Item 2 -->
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-white mb-2">Professional Website</h4>
                                        <p class="text-gray-400">Custom-designed website with mobile optimization, contact forms, service listings, and professional portfolio showcase.</p>
                                    </div>
                                </div>

                                <!-- Service Item 3 -->
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-white mb-2">Complete Business Plan</h4>
                                        <p class="text-gray-400">Detailed business strategy, financial projections, marketing roadmap, and growth plan tailored to your local market.</p>
                                    </div>
                                </div>

                                <!-- Service Item 4 -->
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-white mb-2">Legal & Compliance Setup</h4>
                                        <p class="text-gray-400">Business registration guidance, insurance recommendations, contract templates, and compliance documentation.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Pricing & CTA -->
                    <div class="space-y-6">
                        <!-- Pricing Card -->
                        <div class="relative bg-gradient-to-br from-orange-500/10 to-cyan-500/10 backdrop-blur-sm border-2 border-orange-500/50 rounded-2xl p-8 hover:shadow-2xl hover:shadow-orange-500/20 transition-all duration-300">
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                <span class="bg-gradient-to-r from-orange-600 to-orange-500 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                                    MOST POPULAR
                                </span>
                            </div>

                            <div class="text-center mb-8 mt-4">
                                <div class="text-gray-400 text-sm font-medium mb-2">STARTING AT</div>
                                <div class="flex items-baseline justify-center">
                                    <span class="text-5xl font-bold text-white">$1999</span>
                                    <span class="text-2xl text-gray-400 ml-1">.99</span>
                                    <span class="text-xl text-gray-400 ml-2">+</span>
                                </div>
                                <p class="text-gray-400 text-sm mt-2">Customized based on your needs</p>
                            </div>

                            <div class="space-y-4 mb-8">
                                <div class="flex items-center text-white">
                                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>2-3 week turnaround time</span>
                                </div>
                                <div class="flex items-center text-white">
                                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Unlimited revisions included</span>
                                </div>
                                <div class="flex items-center text-white">
                                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>30-day satisfaction guarantee</span>
                                </div>
                                <div class="flex items-center text-white">
                                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Ongoing support & consultation</span>
                                </div>
                            </div>

                            <Link v-if="consultationProduct" :href="route('guest.checkout', { product: consultationProduct.id })" class="w-full py-4 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold rounded-xl hover:from-orange-500 hover:to-orange-600 shadow-lg hover:shadow-orange-500/50 transition-all duration-200 transform hover:scale-105 flex items-center justify-center group">
                                <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Get Started - Premium Business Package
                            </Link>
                        </div>

                        <!-- Trust Badge -->
                        <div class="bg-gray-800/50 border border-gray-700 rounded-xl p-6 text-center">
                            <div class="flex items-center justify-center space-x-2 mb-3">
                                <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <h4 class="text-lg font-bold text-white">Backed by Experience</h4>
                            </div>
                            <p class="text-gray-400 text-sm">
                                Over 50+ successful field tech businesses launched using our proven system and templates.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bottom Features -->
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-gray-800/30 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 text-center hover:border-orange-500/50 transition-all duration-200">
                        <div class="text-3xl font-bold text-orange-400 mb-2">10x</div>
                        <div class="text-gray-300">Faster Business Launch</div>
                    </div>
                    <div class="bg-gray-800/30 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 text-center hover:border-cyan-500/50 transition-all duration-200">
                        <div class="text-3xl font-bold text-cyan-400 mb-2">100%</div>
                        <div class="text-gray-300">Professional Setup</div>
                    </div>
                    <div class="bg-gray-800/30 backdrop-blur-sm border border-gray-700/50 rounded-xl p-6 text-center hover:border-purple-500/50 transition-all duration-200">
                        <div class="text-3xl font-bold text-purple-400 mb-2">$0</div>
                        <div class="text-gray-300">Hidden Fees</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Your Free Account Section -->
        <div class="relative py-24 bg-gray-900 overflow-hidden">
            <!-- Background decoration -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-orange-500 rounded-full filter blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-cyan-500 rounded-full filter blur-3xl"></div>
            </div>
            
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <div class="inline-flex items-center px-4 py-2 bg-orange-500/10 border border-orange-500/30 rounded-full mb-4">
                        <svg class="w-5 h-5 text-orange-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-orange-400 font-semibold text-sm">100% FREE • NO CREDIT CARD</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                        Create Your <span class="bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">Free Account</span>
                    </h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                        Join thousands exploring their side hustle potential. No payment required—unlock exclusive features and explore at your own pace.
                    </p>
                </div>

                <!-- Benefits Grid -->
                <div class="grid md:grid-cols-3 gap-8 mb-12">
                    <!-- Benefit 1 -->
                    <div class="group relative bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl p-8 hover:border-orange-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-orange-500/10 hover:-translate-y-1">
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-orange-500/10 rounded-full filter blur-2xl group-hover:bg-orange-500/20 transition-all duration-300"></div>
                        <div class="relative">
                            <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-3">Exclusive Content Previews</h3>
                            <p class="text-gray-400 leading-relaxed">Get a sneak peek at our training materials, sample lessons, and success stories before you buy. See exactly what you're getting.</p>
                        </div>
                    </div>

                    <!-- Benefit 2 -->
                    <div class="group relative bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl p-8 hover:border-orange-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-orange-500/10 hover:-translate-y-1">
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-cyan-500/10 rounded-full filter blur-2xl group-hover:bg-cyan-500/20 transition-all duration-300"></div>
                        <div class="relative">
                            <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-3">Save Your Favorites</h3>
                            <p class="text-gray-400 leading-relaxed">Bookmark products and resources you're interested in. Build your personalized learning roadmap and come back anytime.</p>
                        </div>
                    </div>

                    <!-- Benefit 3 -->
                    <div class="group relative bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-2xl p-8 hover:border-orange-500/50 transition-all duration-300 hover:shadow-xl hover:shadow-orange-500/10 hover:-translate-y-1">
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-purple-500/10 rounded-full filter blur-2xl group-hover:bg-purple-500/20 transition-all duration-300"></div>
                        <div class="relative">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-3">Track Your Journey</h3>
                            <p class="text-gray-400 leading-relaxed">Access your personalized dashboard to track progress, view completed sections, and see how far you've come on your path to success.</p>
                        </div>
                    </div>
                </div>

                <!-- Additional Features -->
                <div class="bg-gradient-to-r from-gray-800/60 to-gray-800/40 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-8 mb-12">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1">Early Access to New Features</h4>
                                <p class="text-gray-400 text-sm">Be the first to try new tools, resources, and training modules as we release them.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1">Community Access</h4>
                                <p class="text-gray-400 text-sm">Connect with other aspiring field engineers and share experiences (coming soon).</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1">Special Offers & Discounts</h4>
                                <p class="text-gray-400 text-sm">Receive exclusive member-only deals and promotional pricing on training programs.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1">Personalized Dashboard</h4>
                                <p class="text-gray-400 text-sm">Your own space to manage purchases, track learning, and plan your side hustle journey.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA -->
                <div class="text-center">
                    <Link href="/register" 
                          class="group relative inline-flex items-center px-10 py-5 overflow-hidden rounded-xl bg-gradient-to-r from-orange-600 to-orange-500 text-white text-lg font-bold shadow-2xl hover:shadow-orange-500/50 transition-all duration-300 transform hover:scale-105">
                        <span class="relative z-10 flex items-center">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Create Your Free Account Now
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-orange-600 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                    </Link>
                    <p class="mt-4 text-gray-400 text-sm">Takes less than 60 seconds • No credit card required • Cancel anytime</p>
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

        <!-- Urgency Components -->
        <CountdownTimer />
        <PurchaseNotifications :products="products" />
        
        <!-- Footer -->
        <footer class="bg-gray-900">
            <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
                <nav class="flex flex-wrap justify-center -mx-5 -my-2">
                    <div class="px-5 py-2">
                        <a href="#about" class="text-base text-white hover:text-orange-400">About</a>
                    </div>
                    <div class="px-5 py-2">
                        <Link :href="route('home')" class="text-base text-white hover:text-orange-400">Products</Link>
                    </div>
                    <div class="px-5 py-2">
                        <Link :href="route('contact')" class="text-base text-white hover:text-orange-400">Contact Support</Link>
                    </div>
                    <div class="px-5 py-2">
                        <Link :href="route('terms')" class="text-base text-white hover:text-orange-400">Terms</Link>
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