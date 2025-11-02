<template>
    <Head>
        <title>Start Your Side Hustle - Secure Checkout | FieldEngineer Pro</title>
        <meta name="description" content="Complete your purchase and start your field tech side hustle journey today. Secure checkout with instant access.">
    </Head>

    <div class="min-h-screen bg-gray-900 py-8 sm:py-12">
        <!-- Header with Logo -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            <div class="text-center">
                <a href="/" class="inline-flex items-center hover:opacity-80 transition-opacity">
                    <ApplicationLogo class="h-12 w-12" />
                    <span class="ml-3 text-2xl font-bold text-white">FieldEngineer Pro</span>
                </a>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Progress Header -->
            <div class="mb-8 lg:mb-12 text-center">
                <h2 class="font-bold text-2xl sm:text-3xl lg:text-4xl text-white mb-2">
                    You're Almost There!
                </h2>
                <p class="text-sm sm:text-base lg:text-lg text-gray-400">Complete your order to unlock your side hustle training</p>
                
                <!-- Trust Badges -->
                <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-6 lg:gap-8 mt-4 lg:mt-6 text-xs sm:text-sm text-gray-400">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-400 mr-1 sm:mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="whitespace-nowrap">Secure Payment</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-400 mr-1 sm:mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="whitespace-nowrap">Instant Access</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-400 mr-1 sm:mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 012 0v4a1 1 0 11-2 0V7zm1 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="whitespace-nowrap">Money-Back Guarantee</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-10">
                <!-- Order Summary -->
                <div class="w-full order-2 lg:order-1 lg:col-span-1">
                    <div class="bg-gradient-to-br from-gray-800 to-gray-900 overflow-hidden shadow-2xl rounded-xl sm:rounded-2xl backdrop-blur-sm border border-gray-700 lg:sticky lg:top-8">
                        <div class="p-6 lg:p-8">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-bold text-white">Order Summary</h3>
                                <span class="bg-orange-500/20 text-orange-400 px-3 py-1 rounded-full text-xs font-bold whitespace-nowrap">Limited Time</span>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="bg-gray-900/50 rounded-xl p-4 mb-6">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-white mb-1">{{ product.name }}</h4>
                                        <p class="text-xs text-gray-400">Digital Training Program • Lifetime Access</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Price Breakdown -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-gray-300">
                                    <span>Subtotal</span>
                                    <span class="font-medium">${{ product.price.toFixed(2) }}</span>
                                </div>
                            </div>
                            
                            <!-- Discount Code Section -->
                            <div class="border-t border-gray-700 pt-6 mb-6">
                                <label for="discount-code" class="block text-sm font-medium text-gray-300 mb-2">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-orange-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Have a Discount Code?
                                    </span>
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" name="discount-code" id="discount-code" v-model="discountCode" 
                                        class="focus:ring-orange-500 focus:border-orange-500 flex-1 block w-full rounded-lg text-sm border-gray-600 bg-gray-900 text-white placeholder-gray-500 px-3 py-2"
                                        placeholder="Enter discount code">
                                    <button type="button" @click="applyDiscount"
                                        class="inline-flex items-center justify-center px-4 sm:px-6 py-2 border border-transparent text-sm font-bold rounded-lg text-white bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200 whitespace-nowrap">
                                        Apply
                                    </button>
                                </div>
                                <div v-if="discountError" class="mt-2 flex items-center text-sm text-red-400">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ discountError }}
                                </div>
                                <div v-if="discount" class="mt-2 flex items-center text-sm text-green-400 bg-green-500/10 rounded-lg p-2">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ discountDescription }}
                                </div>
                            </div>
                            
                            <!-- Total Section -->
                            <div class="border-t border-gray-700 pt-6">
                                <div v-if="discount" class="flex justify-between mb-3 text-green-400">
                                    <span class="font-medium">Savings:</span>
                                    <span class="font-bold">-${{ discountAmount.toFixed(2) }}</span>
                                </div>
                                
                                <div class="flex justify-between items-center bg-gradient-to-r from-orange-500/20 to-orange-600/20 rounded-xl p-4">
                                    <div>
                                        <p class="text-sm text-gray-400">Total Due Today</p>
                                        <p class="text-3xl font-bold text-white">${{ finalAmount.toFixed(2) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-400">One-time payment</p>
                                        <p class="text-xs text-green-400 font-bold">Lifetime access</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Value Props -->
                            <div class="mt-6 space-y-2">
                                <div class="flex items-center text-sm text-gray-300">
                                    <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Instant digital access
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    All future updates included
                                </div>
                                <div class="flex items-center text-sm text-gray-300">
                                    <svg class="w-4 h-4 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    30-day money-back guarantee
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Form -->
                <div class="w-full order-1 lg:order-2 lg:col-span-2">
                    <div class="bg-gradient-to-br from-gray-800 to-gray-900 overflow-hidden shadow-2xl rounded-xl sm:rounded-2xl backdrop-blur-sm border border-gray-700">
                        <div class="p-6 lg:p-8">
                            <div class="flex items-center justify-between mb-6 lg:mb-8">
                                <h3 class="text-xl lg:text-2xl font-bold text-white">Payment Details</h3>
                                <div class="hidden sm:flex items-center gap-2">
                                    <svg class="w-8 h-8 text-gray-600" viewBox="0 0 48 32" fill="currentColor">
                                        <rect width="48" height="32" rx="4" fill="#1A1F36"/>
                                        <circle cx="15" cy="16" r="8" fill="#EB001B"/>
                                        <circle cx="33" cy="16" r="8" fill="#FF5F00"/>
                                        <circle cx="24" cy="16" r="8" fill="#F79E1B" opacity="0.8"/>
                                    </svg>
                                    <svg class="w-10 h-10 text-blue-600" viewBox="0 0 48 32" fill="currentColor">
                                        <rect width="48" height="32" rx="4" fill="currentColor"/>
                                        <path d="M17 11h14v10H17z" fill="white"/>
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Email Input -->
                            <div class="mb-6 lg:mb-8">
                                <label for="email" class="block text-sm lg:text-base font-bold text-gray-300 mb-2 lg:mb-3">
                                    Email Address <span class="text-red-400">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 lg:pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                    <input type="email" id="email" v-model="email" required
                                        class="pl-10 lg:pl-12 block w-full border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm lg:text-base bg-gray-900 text-white placeholder-gray-500 py-3 lg:py-4"
                                        placeholder="your@email.com">
                                </div>
                                <p class="mt-2 text-xs text-gray-400 flex items-start sm:items-center">
                                    <svg class="w-4 h-4 mr-1 text-blue-400 flex-shrink-0 mt-0.5 sm:mt-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Your receipt and training access will be sent to this email</span>
                                </p>
                            </div>
                            
                            <!-- Payment Method -->
                            <div class="mb-6 lg:mb-8">
                                <label class="block text-sm lg:text-base font-bold text-gray-300 mb-3">
                                    Payment Method <span class="text-red-400">*</span>
                                </label>
                                <div class="space-y-3">
                                    <!-- Card Payment -->
                                    <div class="bg-gray-900 rounded-lg border-2 cursor-pointer transition-all p-4 lg:p-5"
                                        :class="paymentMethod === 'card' ? 'border-orange-500' : 'border-gray-700 hover:border-gray-600'"
                                        @click="paymentMethod = 'card'">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <input id="payment-card" type="radio" v-model="paymentMethod" value="card"
                                                    class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-600 flex-shrink-0">
                                                <label for="payment-card" class="ml-2 sm:ml-3 flex items-center text-xs sm:text-sm font-medium text-white cursor-pointer">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2 text-orange-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                    </svg>
                                                    <span class="whitespace-nowrap">Credit / Debit Card</span>
                                                </label>
                                            </div>
                                            <div class="hidden sm:flex gap-1">
                                                <svg class="w-8 h-6" viewBox="0 0 32 20" fill="none">
                                                    <rect width="32" height="20" rx="2" fill="#1434CB"/>
                                                    <path d="M11.5 5h9v10h-9z" fill="#FF5F00"/>
                                                    <circle cx="11.5" cy="10" r="5" fill="#EB001B"/>
                                                    <circle cx="20.5" cy="10" r="5" fill="#F79E1B"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Crypto Payment -->
                                    <div class="bg-gray-900 rounded-lg border-2 cursor-pointer transition-all p-4 lg:p-5"
                                        :class="paymentMethod === 'crypto' ? 'border-orange-500' : 'border-gray-700 hover:border-gray-600'"
                                        @click="paymentMethod = 'crypto'">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <input id="payment-crypto" type="radio" v-model="paymentMethod" value="crypto"
                                                    class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-600 flex-shrink-0">
                                                <label for="payment-crypto" class="ml-2 sm:ml-3 flex items-center text-xs sm:text-sm font-medium text-white cursor-pointer">
                                                    <span class="text-lg mr-2">₿</span>
                                                    <span class="whitespace-nowrap">Bitcoin / Cryptocurrency</span>
                                                </label>
                                            </div>
                                            <div class="hidden sm:flex items-center text-xs text-gray-400">
                                                <span>Powered by Coinbase</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Card Payment Form -->
                            <div v-if="paymentMethod === 'card'" class="space-y-6 lg:space-y-8">
                                <div>
                                    <label for="card-element" class="block text-sm lg:text-base font-bold text-gray-300 mb-2 lg:mb-3">
                                        Card Information <span class="text-red-400">*</span>
                                    </label>
                                    <div id="card-element" class="border-2 border-gray-600 rounded-lg p-4 lg:p-5 bg-gray-900 focus-within:border-orange-500 transition-colors"></div>
                                    <div id="card-errors" class="mt-2 text-sm text-red-400 flex items-center" role="alert">
                                        <svg v-if="cardErrors" class="w-4 h-4 mr-1 flex-shrink-0 mt-0.5 sm:mt-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                <!-- Security Badge -->
                                <div class="flex items-start sm:items-center justify-center p-2 sm:p-3 bg-green-500/10 rounded-lg border border-green-500/30">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-400 mr-2 flex-shrink-0 mt-0.5 sm:mt-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-xs sm:text-sm text-green-400 font-medium">Secured by Stripe • Your information is encrypted</span>
                                </div>
                                
                                <!-- Submit Button -->
                                <div>
                                    <!-- Card Payment Button -->
                                    <button v-if="paymentMethod === 'card'" type="button" @click="processCardPayment" :disabled="isProcessing" 
                                        class="group relative w-full flex justify-center items-center py-4 lg:py-5 px-6 border border-transparent rounded-lg text-lg lg:text-xl font-bold text-white bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed shadow-xl hover:shadow-orange-500/50 transition-all duration-200 transform hover:scale-105 active:scale-100">
                                        <span v-if="isProcessing" class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-white" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Processing...
                                        </span>
                                        <span v-else class="flex items-center">
                                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                            Complete Purchase • ${{ finalAmount.toFixed(2) }}
                                        </span>
                                    </button>
                                    
                                    <!-- Crypto Payment Button -->
                                    <button v-if="paymentMethod === 'crypto'" type="button" @click="processCryptoPayment" :disabled="isProcessing" 
                                        class="group relative w-full flex justify-center items-center py-4 lg:py-5 px-6 border border-transparent rounded-lg text-lg lg:text-xl font-bold text-white bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed shadow-xl hover:shadow-orange-500/50 transition-all duration-200 transform hover:scale-105 active:scale-100">
                                        <span v-if="isProcessing" class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-3 h-6 w-6 text-white" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Redirecting to Coinbase...
                                        </span>
                                        <span v-else class="flex items-center">
                                            <span class="text-2xl mr-2">₿</span>
                                            Pay with Crypto • ${{ finalAmount.toFixed(2) }}
                                        </span>
                                    </button>
                                    
                                    <p class="mt-4 text-center text-sm text-gray-400">
                                        By completing your purchase, you agree to our terms of service
                                    </p>
                                </div>
                            </div>

                            <div class="mt-8 border-t border-gray-700 pt-6 text-center">
                                <p class="text-sm text-gray-400">
                                    Already have an account? 
                                    <a :href="route('login')" class="text-orange-400 hover:text-orange-300 font-medium">
                                        Sign in here
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent, onMounted } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import axios from 'axios';

export default defineComponent({
    components: {
        Head,
        ApplicationLogo
    },
    props: {
        product: Object,
        stripeKey: String
    },
    data() {
        return {
            paymentMethod: 'card',
            isProcessing: false,
            stripe: null,
            card: null,
            cardErrors: '',
            email: '',
            discountCode: '',
            discount: null,
            discountError: ''
        };
    },
    computed: {
        discountDescription() {
            if (!this.discount) return '';
            
            if (this.discount.type === 'percentage') {
                return `${this.discount.value}% off`;
            } else {
                return `$${this.discount.value.toFixed(2)} off`;
            }
        },
        discountAmount() {
            if (!this.discount) return 0;
            
            if (this.discount.type === 'percentage') {
                return (this.product.price * this.discount.value) / 100;
            } else {
                return Math.min(this.discount.value, this.product.price);
            }
        },
        finalAmount() {
            return Math.max(0, this.product.price - this.discountAmount);
        }
    },
    mounted() {
        // Load Stripe script if not already loaded
        if (!window.Stripe) {
            const script = document.createElement('script');
            script.src = 'https://js.stripe.com/v3/';
            script.async = true;
            script.onload = () => {
                this.loadStripe();
            };
            document.head.appendChild(script);
        } else {
            this.loadStripe();
        }
    },
    methods: {
        loadStripe() {
            // Wait for Stripe to be available
            const initStripe = () => {
                if (!window.Stripe) {
                    setTimeout(initStripe, 100);
                    return;
                }
                
                // Load Stripe.js
                this.stripe = window.Stripe(this.stripeKey);
                
                // Create card element
                const elements = this.stripe.elements();
                this.card = elements.create('card');
                
                // Mount card element
                this.$nextTick(() => {
                    this.card.mount('#card-element');
                    
                    // Handle validation errors
                    this.card.addEventListener('change', event => {
                        if (event.error) {
                            this.cardErrors = event.error.message;
                            const displayError = document.getElementById('card-errors');
                            if (displayError) {
                                displayError.textContent = event.error.message;
                            }
                        } else {
                            this.cardErrors = '';
                            const displayError = document.getElementById('card-errors');
                            if (displayError) {
                                displayError.textContent = '';
                            }
                        }
                    });
                });
            };
            
            initStripe();
        },
        async processCardPayment() {
            if (this.isProcessing) return;
            
            // Validate email
            if (!this.email || !this.validateEmail(this.email)) {
                document.getElementById('card-errors').textContent = 'Please enter a valid email address.';
                return;
            }
            
            this.isProcessing = true;
            
            try {
                // Create payment method
                const result = await this.stripe.createPaymentMethod({
                    type: 'card',
                    card: this.card,
                    billing_details: {
                        email: this.email,
                    },
                });
                
                if (result.error) {
                    document.getElementById('card-errors').textContent = result.error.message;
                    this.isProcessing = false;
                    return;
                }
                
                // Process the payment with our server
                await axios.post(route('guest.process-payment'), {
                    product_id: this.product.id,
                    payment_method_id: result.paymentMethod.id,
                    email: this.email,
                    discount_code: this.discount ? this.discountCode : null,
                });
                
                // Redirect to thank you page
                router.visit(route('guest.thank-you'));
            } catch (error) {
                console.error('Payment error:', error);
                document.getElementById('card-errors').textContent = error.response?.data?.message || 
                    'An error occurred while processing your payment. Please try again.';
                this.isProcessing = false;
            }
        },
        async processCryptoPayment() {
            if (this.isProcessing) return;
            
            // Validate email
            if (!this.email || !this.validateEmail(this.email)) {
                alert('Please enter a valid email address.');
                return;
            }
            
            this.isProcessing = true;
            
            try {
                // Process crypto payment through Coinbase Commerce
                await axios.post(route('guest.coinbase-payment'), {
                    product_id: this.product.id,
                    email: this.email,
                    discount_code: this.discount ? this.discountCode : null,
                });
                
                // Coinbase Commerce will redirect via Inertia::location()
                // The controller handles the redirect to hosted checkout page
            } catch (error) {
                console.error('Crypto Payment error:', error);
                alert('An error occurred while creating the payment. Please try again.');
                this.isProcessing = false;
            }
        },
        validateEmail(email) {
            const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        },
        async applyDiscount() {
            if (!this.discountCode.trim()) {
                this.discountError = 'Please enter a discount code';
                return;
            }
            
            this.discountError = '';
            
            try {
                const response = await axios.post(route('discount.validate'), {
                    code: this.discountCode,
                    product_id: this.product.id
                });
                
                if (response.data.valid) {
                    this.discount = response.data.discount;
                } else {
                    this.discountError = response.data.message || 'Invalid discount code';
                    this.discount = null;
                }
            } catch (error) {
                console.error('Discount validation error:', error);
                this.discountError = error.response?.data?.message || 'Error validating discount code';
                this.discount = null;
            }
        }
    }
});
</script>