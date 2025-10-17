<template>
    <AppLayout title="Checkout">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Checkout
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Order Summary -->
                    <div class="col-span-1">
                        <div class="bg-gray-900 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-gray-900 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-white mb-4">Order Summary</h3>
                                
                                <div class="mb-4">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-sm text-gray-400">Product:</span>
                                        <span class="text-sm font-medium text-gray-300">{{ product.name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-400">Price:</span>
                                        <span class="text-sm font-medium text-gray-300">${{ product.price.toFixed(2) }}</span>
                                    </div>
                                </div>
                                
                                <!-- Discount Code Section -->
                                <div class="border-t border-gray-700 pt-4 mb-4">
                                    <div class="mb-2">
                                        <label for="discount-code" class="block text-sm font-medium text-gray-300">Discount Code</label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" name="discount-code" id="discount-code" v-model="discountCode" 
                                                class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300 bg-gray-700 text-white"
                                                placeholder="Enter code">
                                            <button type="button" @click="applyDiscount"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-r-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Apply
                                            </button>
                                        </div>
                                        <div v-if="discountError" class="mt-1 text-sm text-red-600">
                                            {{ discountError }}
                                        </div>
                                        <div v-if="discount" class="mt-1 text-sm text-green-600">
                                            Discount applied: {{ discountDescription }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-700 pt-4">
                                    <div class="flex justify-between">
                                        <span class="text-base font-medium text-white">Subtotal:</span>
                                        <span class="text-base font-medium text-white">${{ product.price.toFixed(2) }}</span>
                                    </div>
                                    
                                    <div v-if="discount" class="flex justify-between mt-2 text-green-600">
                                        <span class="text-sm font-medium">Discount:</span>
                                        <span class="text-sm font-medium">-${{ discountAmount.toFixed(2) }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between mt-4">
                                        <span class="text-lg font-bold text-white">Total:</span>
                                        <span class="text-lg font-bold text-white">${{ finalAmount.toFixed(2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Form -->
                    <div class="col-span-2">
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Guest Checkout</h3>
                                
                                <!-- Email Input -->
                                <div class="mb-6">
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
                                    <input type="email" id="email" v-model="email" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="your@email.com">
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        We'll send your receipt and order details to this email address.
                                    </p>
                                </div>
                                
                                <!-- Payment Method Selector -->
                                <div class="mb-6">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center">
                                            <input id="payment-card" type="radio" v-model="paymentMethod" value="card" 
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                            <label for="payment-card" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                                Credit/Debit Card
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Card Payment Form -->
                                <div v-if="paymentMethod === 'card'" class="mt-4">
                                    <div class="mb-4">
                                        <label for="card-element" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Card Details</label>
                                        <div id="card-element" class="border border-gray-300 rounded-md p-3 dark:border-gray-600 dark:bg-gray-700"></div>
                                        <div id="card-errors" class="mt-2 text-sm text-red-600" role="alert"></div>
                                    </div>
                                    
                                    <div class="mt-6">
                                        <button type="button" @click="processCardPayment" :disabled="isProcessing" 
                                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                                            <span v-if="isProcessing">Processing...</span>
                                            <span v-else>Pay ${{ finalAmount.toFixed(2) }}</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4 text-center">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Already have an account? 
                                        <a :href="route('login')" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                            Sign in
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { defineComponent } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';

export default defineComponent({
    components: {
        AppLayout
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