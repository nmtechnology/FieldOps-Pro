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
                                        <span class="text-sm font-medium dark:text-gray-300">${{ product.price.toFixed(2) }}</span>
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
                                        <span class="text-base font-medium text-white">${{ product.price.toFixed(2) }}</span>
                                    </div>
                                    
                                    <div v-if="discount" class="flex justify-between mt-2 text-green-400">
                                        <span class="text-sm font-medium">Discount:</span>
                                        <span class="text-sm font-medium">-${{ discountAmount.toFixed(2) }}</span>
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
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center">
                                            <input id="payment-card" type="radio" v-model="paymentMethod" value="card" 
                                                class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-600">
                                            <label for="payment-card" class="ml-2 block text-sm text-white">
                                                Credit/Debit Card
                                            </label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="payment-ach" type="radio" v-model="paymentMethod" value="ach" 
                                                class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-600">
                                            <label for="payment-ach" class="ml-2 block text-sm text-white">
                                                Bank Transfer (ACH)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Card Payment Form -->
                                <div v-if="paymentMethod === 'card'" class="mt-4">
                                    <form @submit.prevent="processCardPayment">
                                        <div class="mb-4">
                                            <label for="card-element" class="block text-sm font-medium text-gray-300 mb-2">Card Details</label>
                                            <div id="card-element" class="border border-gray-600 rounded-md p-3 bg-gray-700"></div>
                                            <div id="card-errors" class="mt-2 text-sm text-red-400" role="alert"></div>
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
            achForm: {
                name: '',
                email: '',
                routing: '',
                account: '',
                acceptedTerms: false
            },
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
            this.isProcessing = true;
            
            try {
                // Create payment intent
                const response = await axios.post(route('process.payment'), {
                    product_id: this.product.id,
                    discount_code: this.discount ? this.discountCode : null,
                });
                
                const { client_secret } = response.data;
                
                // Confirm card payment
                const result = await this.stripe.confirmCardPayment(client_secret, {
                    payment_method: {
                        card: this.card,
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
                document.getElementById('card-errors').textContent = 'An error occurred while processing your payment. Please try again.';
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