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

</script>

<template>
    <Head>
        <title>{{ product.name }} - FieldOps Pro</title>
        <meta name="description" :content="product.description">
    </Head>

    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-700 mix-blend-multiply"></div>
            </div>
            <div class="relative px-4 py-24 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                        {{ product.name }}
                    </h1>
                    <p class="max-w-3xl mx-auto mt-6 text-xl text-indigo-100">
                        {{ product.description }}
                    </p>
                    <div class="max-w-sm mx-auto mt-10 sm:max-w-none sm:flex sm:justify-center">
                        <div class="space-y-4 sm:space-y-0 sm:mx-auto">
                            <a href="#pricing" class="flex items-center justify-center w-full px-8 py-3 text-base font-medium text-indigo-700 bg-white border border-transparent rounded-md shadow-md hover:bg-indigo-50 md:py-4 md:text-lg md:px-10">
                                Get Access Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-16 overflow-hidden bg-white">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        What You'll Learn
                    </h2>
                    <p class="max-w-3xl mx-auto mt-4 text-xl text-gray-500">
                        Everything you need to succeed with our comprehensive info product
                    </p>
                </div>

                <div class="mt-12">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Feature 1 -->
                        <div class="pt-6">
                            <div class="flow-root px-6 pb-8 rounded-lg bg-gray-50">
                                <div class="-mt-6">
                                    <div>
                                        <span class="inline-flex items-center justify-center p-3 rounded-md shadow-lg bg-indigo-600">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium tracking-tight text-gray-900">Comprehensive Guides</h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        Detailed step-by-step instructions to help you master every concept
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="pt-6">
                            <div class="flow-root px-6 pb-8 rounded-lg bg-gray-50">
                                <div class="-mt-6">
                                    <div>
                                        <span class="inline-flex items-center justify-center p-3 rounded-md shadow-lg bg-indigo-600">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <h3 class="mt-8 text-lg font-medium tracking-tight text-gray-900">Practical Examples</h3>
                                    <p class="mt-5 text-base text-gray-500">
                                        Real-world examples and case studies that you can apply immediately
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="pt-6">
                            <div class="flow-root px-6 pb-8 rounded-lg bg-gray-50">
                                <div class="-mt-6">
                                    <div>
                                        <span class="inline-flex items-center justify-center p-3 rounded-md shadow-lg bg-indigo-600">
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

        <!-- Pricing Section -->
        <div id="pricing" class="py-16 bg-gray-50">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Simple, Straightforward Pricing
                    </h2>
                    <p class="max-w-3xl mx-auto mt-4 text-xl text-gray-500">
                        One-time payment, lifetime access to all content
                    </p>
                </div>

                <div class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-1 sm:gap-6 lg:max-w-4xl lg:mx-auto">
                    <!-- Pricing Card -->
                    <div class="divide-y divide-gray-200 rounded-lg shadow-lg overflow-hidden bg-white">
                        <div class="p-6">
                            <h3 class="text-xl font-medium text-gray-900">Complete Access</h3>
                            <p class="mt-4 text-gray-500">Everything you need to succeed with our info product</p>
                            <p class="mt-8">
                                <span class="text-4xl font-extrabold text-gray-900">$45</span>
                                <span class="text-base font-medium text-gray-500">one-time</span>
                            </p>
                            <Link :href="route('checkout', { product: product.id })" class="block w-full py-3 px-6 border border-transparent rounded-md shadow text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 mt-8">
                                Get Access Now
                            </Link>
                        </div>
                        <div class="px-6 pt-6 pb-8">
                            <h4 class="text-sm font-medium text-gray-900 tracking-wide">What's included:</h4>
                            <ul class="mt-6 space-y-4">
                                <li class="flex space-x-3">
                                    <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-gray-500">Comprehensive guides and tutorials</span>
                                </li>
                                <li class="flex space-x-3">
                                    <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-gray-500">Downloadable resources and templates</span>
                                </li>
                                <li class="flex space-x-3">
                                    <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-gray-500">Lifetime access to all content</span>
                                </li>
                                <li class="flex space-x-3">
                                    <svg class="flex-shrink-0 h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-gray-500">Future updates included</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="py-16 bg-white">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Frequently Asked Questions
                    </h2>
                    <p class="max-w-3xl mx-auto mt-4 text-xl text-gray-500">
                        Can't find the answer you're looking for? Contact our support team.
                    </p>
                </div>
                <div class="mt-12">
                    <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-12">
                        <div>
                            <dt class="text-lg font-medium leading-6 text-gray-900">
                                How long do I have access to the content?
                            </dt>
                            <dd class="mt-2 text-base text-gray-500">
                                You get lifetime access to all content, including future updates.
                            </dd>
                        </div>
                        <div>
                            <dt class="text-lg font-medium leading-6 text-gray-900">
                                Can I get a refund if I'm not satisfied?
                            </dt>
                            <dd class="mt-2 text-base text-gray-500">
                                Yes, we offer a 30-day money-back guarantee if you're not completely satisfied.
                            </dd>
                        </div>
                        <div>
                            <dt class="text-lg font-medium leading-6 text-gray-900">
                                How is the content delivered?
                            </dt>
                            <dd class="mt-2 text-base text-gray-500">
                                All content is available online immediately after purchase through our secure member area.
                            </dd>
                        </div>
                        <div>
                            <dt class="text-lg font-medium leading-6 text-gray-900">
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
        <div class="bg-indigo-700">
            <div class="px-4 py-12 mx-auto max-w-7xl sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                <h2 class="text-3xl font-extrabold tracking-tight text-white md:text-4xl">
                    <span class="block">Ready to dive in?</span>
                    <span class="block text-indigo-200">Get access today.</span>
                </h2>
                <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                    <div class="inline-flex rounded-md shadow">
                        <Link :href="route('checkout', { product: product.id })" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                            Get Started
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>