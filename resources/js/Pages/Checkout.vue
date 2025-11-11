<template>
    <AppLayout title="Checkout">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Checkout
            </h2>
        </template>

        <div class="py-12 bg-gray-900 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-700">
                            <div class="p-6 border-b border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Order Summary</h3>
                                
                                <div class="mb-4">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Product:</span>
                                        <span class="text-sm font-medium dark:text-gray-300">{{ product.name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Price:</span>
                                        <span class="text-sm font-medium dark:text-gray-300">${{ productPrice.toFixed(2) }}</span>
                                    </div>
                                </div>
                                
                                <!-- Discount Code Section -->
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-4">
                                    <div class="mb-2">
                                        <label for="discount-code" class="block text-sm font-medium text-gray-300">Discount Code</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="discount-code" id="discount-code" v-model="discountCode" 
                                                class="focus:ring-orange-500 focus:border-orange-500 flex-1 block w-full rounded-l-md sm:text-sm border-gray-600 bg-gray-700 text-white"
                                                placeholder="Enter code">
                                            <button type="button" @click="applyDiscount"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-r-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                                Apply
                                            </button>
                                        </div>
                                        <div v-if="discountError" class="mt-1 text-sm text-red-400">
                                            {{ discountError }}
                                        </div>
                                        <div v-if="discount" class="mt-1 text-sm text-green-400">
                                            Discount applied: {{ discountDescription }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-700 pt-4">
                                    <div class="flex justify-between">
                                        <span class="text-base font-medium text-white">Subtotal:</span>
                                        <span class="text-base font-medium text-white">${{ subtotalAmount.toFixed(2) }}</span>
                                    </div>
                                    
                                    <div v-if="discount" class="flex justify-between mt-2 text-green-400">
                                        <span class="text-sm font-medium">Discount:</span>
                                        <span class="text-sm font-medium">-${{ discountAmount.toFixed(2) }}</span>
                                    </div>
                                    
                                    <div v-if="taxAmount > 0" class="flex justify-between mt-2">
                                        <span class="text-sm text-gray-400">Sales Tax ({{ selectedState }} {{ (taxRate * 100).toFixed(2) }}%):</span>
                                        <span class="text-sm text-gray-300">${{ taxAmount.toFixed(2) }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between mt-4">
                                        <span class="text-lg font-bold text-orange-400">Total:</span>
                                        <span class="text-lg font-bold text-orange-400">${{ finalAmount.toFixed(2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-700">
                            <div class="p-6 border-b border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Payment Method</h3>
                                
                                <!-- Payment Method Selector -->
                                <div class="mb-6">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all"
                                            :class="paymentMethod === 'card' ? 'border-orange-500 bg-orange-500/10' : 'border-gray-600 hover:border-gray-500'"
                                            @click="paymentMethod = 'card'">
                                            <input id="payment-card" type="radio" v-model="paymentMethod" value="card" 
                                                class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-600">
                                            <label for="payment-card" class="ml-3 block text-sm text-white font-medium cursor-pointer">
                                                💳 Credit/Debit Card
                                            </label>
                                        </div>
                                        <div class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all"
                                            :class="paymentMethod === 'ach' ? 'border-orange-500 bg-orange-500/10' : 'border-gray-600 hover:border-gray-500'"
                                            @click="paymentMethod = 'ach'">
                                            <input id="payment-ach" type="radio" v-model="paymentMethod" value="ach" 
                                                class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-600">
                                            <label for="payment-ach" class="ml-3 block text-sm text-white font-medium cursor-pointer">
                                                🏦 Bank Transfer (ACH)
                                            </label>
                                        </div>
                                        <div class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all"
                                            :class="paymentMethod === 'crypto' ? 'border-orange-500 bg-orange-500/10' : 'border-gray-600 hover:border-gray-500'"
                                            @click="paymentMethod = 'crypto'">
                                            <input id="payment-crypto" type="radio" v-model="paymentMethod" value="crypto" 
                                                class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-600">
                                            <label for="payment-crypto" class="ml-3 block text-sm text-white font-medium cursor-pointer">
                                                ₿ Bitcoin / Crypto
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Card Payment Form -->
                                <div v-if="paymentMethod === 'card'" class="mt-4">
                                    <form @submit.prevent="processCardPayment">
                                        <!-- Account Information Section -->
                                        <div class="mb-6 pb-6 border-b border-gray-700">
                                            <h4 class="text-md font-semibold text-white mb-4">Account Information</h4>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <div>
                                                    <label for="card-name" class="block text-sm font-medium text-gray-300">Full Name</label>
                                                    <input type="text" id="card-name" v-model="cardForm.name" required
                                                        class="mt-1 block w-full border-gray-600 bg-gray-700 text-white rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                                </div>
                                                <div>
                                                    <label for="card-email" class="block text-sm font-medium text-gray-300">Email</label>
                                                    <input type="email" id="card-email" v-model="cardForm.email" required
                                                        class="mt-1 block w-full border-gray-600 bg-gray-700 text-white rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="card-phone" class="block text-sm font-medium text-gray-300">Phone Number</label>
                                                <input type="tel" id="card-phone" v-model="cardForm.phone" required
                                                    class="mt-1 block w-full border-gray-600 bg-gray-700 text-white rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm"
                                                    placeholder="(555) 123-4567">
                                            </div>

                                            <div class="mb-4">
                                                <label for="card-address" class="block text-sm font-medium text-gray-300">Street Address</label>
                                                <input type="text" id="card-address" v-model="cardForm.address" required
                                                    class="mt-1 block w-full border-gray-600 bg-gray-700 text-white rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm"
                                                    placeholder="123 Main Street">
                                            </div>

                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                                <div>
                                                    <label for="card-city" class="block text-sm font-medium text-gray-300">City</label>
                                                    <input type="text" id="card-city" v-model="cardForm.city" required
                                                        class="mt-1 block w-full border-gray-600 bg-gray-700 text-white rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                                </div>
                                                <div>
                                                    <label for="card-state" class="block text-sm font-medium text-gray-300">State</label>
                                                    <select id="card-state" v-model="selectedState" @change="calculateTax" required
                                                        class="mt-1 block w-full border-gray-600 bg-gray-700 text-white rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                                        <option value="">Select state</option>
                                                        <option v-for="(name, code) in states" :key="code" :value="code">{{ code }}</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="card-zip" class="block text-sm font-medium text-gray-300">ZIP Code</label>
                                                    <input type="text" id="card-zip" v-model="cardForm.zipCode" required
                                                        class="mt-1 block w-full border-gray-600 bg-gray-700 text-white rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm"
                                                        placeholder="12345">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="card-element" class="block text-sm font-medium text-gray-300 mb-2">Card Details</label>
                                            <div id="card-element" class="border border-gray-600 rounded-md p-3 bg-gray-700"></div>
                                            <div id="card-errors" class="mt-2 text-sm text-red-400" role="alert"></div>
                                        </div>
                                        
                                        <!-- Terms & Conditions Acceptance -->
                                        <div class="mb-6 p-4 bg-gray-900 rounded-md border border-gray-700">
                                            <div class="flex items-start">
                                                <div class="flex items-center h-5">
                                                    <input id="card-terms" type="checkbox" v-model="cardForm.acceptedTerms" required
                                                        class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-600 rounded bg-gray-700">
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="card-terms" class="font-medium text-gray-300">
                                                        I have read and agree to the 
                                                        <button type="button" @click.prevent="showTermsModal = true" class="text-orange-400 hover:text-orange-300 underline font-semibold">
                                                            Terms & Conditions
                                                        </button>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-6">
                                            <button type="submit" :disabled="isProcessing || !selectedState || !cardForm.name || !cardForm.email || !cardForm.phone || !cardForm.address || !cardForm.acceptedTerms" 
                                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-base font-bold text-white bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 transition-all duration-200 transform hover:scale-105">
                                                <span v-if="isProcessing">Processing...</span>
                                                <span v-else>Pay ${{ finalAmount.toFixed(2) }}</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- ACH Payment Form -->
                                <div v-if="paymentMethod === 'ach'" class="mt-4">
                                    <form @submit.prevent="processAchPayment">
                                        <div class="mb-4">
                                            <label for="ach-name" class="block text-sm font-medium text-gray-300">Account Holder Name</label>
                                            <input type="text" id="ach-name" v-model="achForm.name" required
                                                class="mt-1 block w-full border-gray-600 bg-gray-700 text-white rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="ach-email" class="block text-sm font-medium text-gray-300">Email</label>
                                            <input type="email" id="ach-email" v-model="achForm.email" required
                                                class="mt-1 block w-full border-gray-600 bg-gray-700 text-white rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="ach-routing" class="block text-sm font-medium text-gray-300">Routing Number</label>
                                            <input type="text" id="ach-routing" v-model="achForm.routing" required
                                                class="mt-1 block w-full border-gray-600 bg-gray-700 text-white rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="ach-account" class="block text-sm font-medium text-gray-300">Account Number</label>
                                            <input type="text" id="ach-account" v-model="achForm.account" required
                                                class="mt-1 block w-full border-gray-600 bg-gray-700 text-white rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                        </div>
                                        
                                        <div class="mb-4">
                                            <div class="flex items-center">
                                                <input id="ach-terms" type="checkbox" v-model="achForm.acceptedTerms" required
                                                    class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-600 rounded">
                                                <label for="ach-terms" class="ml-2 block text-sm text-gray-300">
                                                    I authorize the payment and agree to the <a href="#" @click.prevent="showTerms = true" class="text-orange-400 hover:text-orange-300">Terms and Conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-6">
                                            <button type="submit" :disabled="isProcessing"
                                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-base font-bold text-white bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 transition-all duration-200 transform hover:scale-105">
                                                <span v-if="isProcessing">Processing...</span>
                                                <span v-else>Pay ${{ finalAmount.toFixed(2) }}</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Crypto Payment -->
                                <div v-if="paymentMethod === 'crypto'" class="mt-4">
                                    <div class="bg-gray-900 rounded-lg p-6 mb-4 border border-gray-700">
                                        <div class="flex items-start space-x-3 mb-4">
                                            <svg class="w-6 h-6 text-orange-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div>
                                                <h4 class="text-white font-semibold mb-2">Pay with Bitcoin or Cryptocurrency</h4>
                                                <ul class="text-sm text-gray-400 space-y-1">
                                                    <li>✓ Accepts Bitcoin, Ethereum, Litecoin, and more</li>
                                                    <li>✓ Secure payment through Coinbase Commerce</li>
                                                    <li>✓ Instant access once payment is confirmed</li>
                                                    <li>✓ No credit card required</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <button @click="processCryptoPayment" :disabled="isProcessing" 
                                        class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-lg text-base font-bold text-white bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 transition-all duration-200 transform hover:scale-105">
                                        <span v-if="isProcessing">Redirecting to Coinbase...</span>
                                        <span v-else>
                                            <span class="mr-2">₿</span> Pay ${{ finalAmount.toFixed(2) }} with Crypto
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Terms & Conditions Modal -->
        <TermsAndConditions v-if="showTermsModal" ref="termsModal" />
        <div v-if="showTermsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-gray-800 rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col border border-gray-700">
                <!-- Header -->
                <div class="bg-gray-900 border-b border-gray-700 px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-white">Terms & Conditions</h2>
                    <button @click="showTermsModal = false" class="text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Content -->
                <div class="flex-1 overflow-y-auto px-6 py-6 text-gray-300 text-sm leading-relaxed">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-white font-semibold mb-2">1. Agreement to Terms</h3>
                            <p>By accessing and using the FieldEngineer Pro website and purchasing digital products, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by the above, please do not use this service.</p>
                        </div>

                        <div>
                            <h3 class="text-white font-semibold mb-2">2. Use License</h3>
                            <p>Permission is granted to download and use digital products for personal or commercial purposes as specified in the product description. You may not:</p>
                            <ul class="list-disc list-inside ml-2 mt-2 space-y-1">
                                <li>Share or distribute products to unauthorized persons</li>
                                <li>Resell or redistribute the digital products</li>
                                <li>Modify or create derivative works</li>
                                <li>Remove copyright or proprietary notations</li>
                                <li>Violate applicable laws or regulations</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-white font-semibold mb-2">3. Digital Product License</h3>
                            <p>Upon purchase, you receive a non-exclusive, non-transferable license to use the digital products. This license is personal to you and may not be shared, assigned, or transferred to any third party. The digital product remains the intellectual property of FieldEngineer Pro.</p>
                        </div>

                        <div>
                            <h3 class="text-white font-semibold mb-2">4. Payment Terms</h3>
                            <p>All prices are displayed in United States Dollars (USD). Payments are processed securely through Stripe, PayPal, and other trusted payment processors. By completing a purchase, you authorize us to charge your payment method for the full amount indicated. Your transaction is final and non-refundable except as specified in our Refund Policy.</p>
                        </div>

                        <div>
                            <h3 class="text-white font-semibold mb-2">5. Account Responsibility</h3>
                            <p>You are responsible for maintaining the confidentiality of your account credentials and for all activity that occurs under your account. You agree to notify us immediately of any unauthorized use of your account. FieldEngineer Pro is not liable for any losses resulting from unauthorized use of your account.</p>
                        </div>

                        <div>
                            <h3 class="text-white font-semibold mb-2">6. Disclaimer of Warranties</h3>
                            <p>The materials and digital products on FieldEngineer Pro are provided on an "as is" basis without warranties of any kind, either express or implied. FieldEngineer Pro disclaims all warranties including merchantability, fitness for a particular purpose, and non-infringement of intellectual property rights.</p>
                        </div>

                        <div>
                            <h3 class="text-white font-semibold mb-2">7. Limitation of Liability</h3>
                            <p>In no event shall FieldEngineer Pro be liable for any indirect, incidental, special, or consequential damages arising out of or related to your use of our products or services, even if we have been advised of the possibility of such damages.</p>
                        </div>

                        <div>
                            <h3 class="text-white font-semibold mb-2">8. Intellectual Property Rights</h3>
                            <p>All content, materials, trademarks, and information provided through FieldEngineer Pro are protected by applicable intellectual property laws and remain the exclusive property of FieldEngineer Pro. You receive only a limited license to access and use the content as permitted under these terms.</p>
                        </div>

                        <div>
                            <h3 class="text-white font-semibold mb-2">9. Modification of Terms</h3>
                            <p>FieldEngineer Pro reserves the right to modify these terms at any time without notice. Your continued use of the website and services constitutes acceptance of the modified terms. It is your responsibility to check these terms periodically for changes.</p>
                        </div>

                        <div>
                            <h3 class="text-white font-semibold mb-2">10. Governing Law and Jurisdiction</h3>
                            <p>These terms and conditions are governed by and construed in accordance with the laws of the United States. You irrevocably submit to the exclusive jurisdiction of the courts located in the United States for any disputes arising from these terms.</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="bg-gray-900 border-t border-gray-700 px-6 py-4 flex justify-end">
                    <button @click="showTermsModal = false" class="px-4 py-2 rounded-md bg-orange-600 hover:bg-orange-500 text-white transition">
                        I Understand
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { defineComponent } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import TermsAndConditions from '@/Components/TermsAndConditions.vue';
import axios from 'axios';

export default defineComponent({
    components: {
        AppLayout,
        TermsAndConditions
    },
    props: {
        product: Object,
        stripeKey: String,
        states: Object
    },
    data() {
        return {
            paymentMethod: 'card',
            isProcessing: false,
            stripe: null,
            card: null,
            selectedState: '',
            taxRate: 0,
            taxAmount: 0,
            cardForm: {
                name: '',
                email: '',
                phone: '',
                address: '',
                city: '',
                state: '',
                zipCode: '',
                acceptedTerms: false
            },
            achForm: {
                name: '',
                email: '',
                routing: '',
                account: '',
                acceptedTerms: false
            },
            discountCode: '',
            discount: null,
            discountError: '',
            showTermsModal: false
        };
    },
    computed: {
        productPrice() {
            return parseFloat(this.product.price);
        },
        discountDescription() {
            if (!this.discount) return '';
            
            if (this.discount.type === 'percentage') {
                return `${this.discount.value}% off`;
            } else {
                return `$${parseFloat(this.discount.value).toFixed(2)} off`;
            }
        },
        discountAmount() {
            if (!this.discount) return 0;
            
            if (this.discount.type === 'percentage') {
                return (this.productPrice * this.discount.value) / 100;
            } else {
                return Math.min(parseFloat(this.discount.value), this.productPrice);
            }
        },
        subtotalAmount() {
            return Math.max(0, this.productPrice - this.discountAmount);
        },
        finalAmount() {
            return this.subtotalAmount + this.taxAmount;
        }
    },
    mounted() {
        this.loadStripe();
    },
    methods: {
        loadStripe() {
            // Load Stripe.js
            this.stripe = Stripe(this.stripeKey);
            
            // Create card element
            const elements = this.stripe.elements();
            this.card = elements.create('card');
            
            // Mount card element
            this.$nextTick(() => {
                this.card.mount('#card-element');
                
                // Handle validation errors
                this.card.addEventListener('change', event => {
                    const displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });
            });
        },
        async calculateTax() {
            if (!this.selectedState) {
                this.taxRate = 0;
                this.taxAmount = 0;
                return;
            }
            
            try {
                const response = await axios.post(route('checkout.calculate-tax'), {
                    product_id: this.product.id,
                    state: this.selectedState,
                    discount_code: this.discount ? this.discountCode : null,
                });
                
                this.taxRate = response.data.tax_rate;
                this.taxAmount = response.data.tax_amount;
            } catch (error) {
                console.error('Tax calculation error:', error);
                this.taxRate = 0;
                this.taxAmount = 0;
            }
        },
        async processCardPayment() {
            if (this.isProcessing) return;
            this.isProcessing = true;
            
            try {
                // Create payment intent
                const response = await axios.post(route('process.payment'), {
                    product_id: this.product.id,
                    state: this.selectedState,
                    discount_code: this.discount ? this.discountCode : null,
                    // Account information
                    name: this.cardForm.name,
                    email: this.cardForm.email,
                    phone: this.cardForm.phone,
                    address: this.cardForm.address,
                    city: this.cardForm.city,
                    state_code: this.selectedState,
                    zip_code: this.cardForm.zipCode
                });
                
                const { client_secret } = response.data;
                
                // Confirm card payment
                const result = await this.stripe.confirmCardPayment(client_secret, {
                    payment_method: {
                        card: this.card,
                        billing_details: {
                            name: this.cardForm.name,
                            email: this.cardForm.email,
                            phone: this.cardForm.phone,
                            address: {
                                line1: this.cardForm.address,
                                city: this.cardForm.city,
                                state: this.selectedState,
                                postal_code: this.cardForm.zipCode
                            }
                        }
                    }
                });
                
                if (result.error) {
                    // Show error to your customer
                    document.getElementById('card-errors').textContent = result.error.message;
                    this.isProcessing = false;
                } else {
                    // Payment succeeded - redirect to thank you page
                    router.visit(route('checkout.thankyou', response.data.order_id));
                }
            } catch (error) {
                console.error('Payment error:', error);
                document.getElementById('card-errors').textContent = error.response?.data?.message || 'An error occurred while processing your payment. Please try again.';
                this.isProcessing = false;
            }
        },
        async processAchPayment() {
            if (this.isProcessing) return;
            this.isProcessing = true;
            
            try {
                // Process ACH payment
                const response = await axios.post(route('process.payment.ach'), {
                    product_id: this.product.id,
                    name: this.achForm.name,
                    email: this.achForm.email,
                    routing_number: this.achForm.routing,
                    account_number: this.achForm.account,
                    discount_code: this.discount ? this.discountCode : null,
                });
                
                // Redirect to thank you page
                router.visit(route('checkout.thankyou', response.data.order_id));
            } catch (error) {
                console.error('ACH Payment error:', error);
                alert('An error occurred while processing your payment. Please try again.');
                this.isProcessing = false;
            }
        },
        async processCryptoPayment() {
            if (this.isProcessing) return;
            this.isProcessing = true;
            
            try {
                // Process crypto payment through Coinbase Commerce
                const response = await axios.post(route('payment.coinbase'), {
                    product_id: this.product.id,
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
                    // Recalculate tax with new discount
                    if (this.selectedState) {
                        await this.calculateTax();
                    }
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