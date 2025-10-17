<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TermsAndConditions from '@/Components/TermsAndConditions.vue';

const props = defineProps({
    product: Object,
    discountCode: String,
    discountAmount: Number,
    finalPrice: Number,
    stripeKey: String,
});

const stripeElements = ref(null);
const cardElement = ref(null);
const paymentProcessing = ref(false);
const paymentError = ref('');
const paymentMethod = ref('card'); // 'card' or 'ach'
const termsAccepted = ref(false);
const termsError = ref(false);

const form = useForm({
    payment_method: 'card',
    product_id: props.product.id,
    discount_code: props.discountCode,
});

onMounted(() => {
    // Initialize Stripe Elements
    if (window.Stripe) {
        stripeElements.value = window.Stripe(props.stripeKey).elements();
        
        // Create card element
        cardElement.value = stripeElements.value.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                }
            }
        });
        
        // Mount card element to the DOM
        cardElement.value.mount('#card-element');
        
        // Handle card errors
        cardElement.value.on('change', (event) => {
            if (event.error) {
                paymentError.value = event.error.message;
            } else {
                paymentError.value = '';
            }
        });
    }
});

const processPayment = async () => {
    // Check if terms are accepted
    if (!termsAccepted.value) {
        termsError.value = true;
        return;
    }
    
    paymentProcessing.value = true;
    paymentError.value = '';
    
    try {
        if (paymentMethod.value === 'card') {
            // Process card payment
            const stripe = window.Stripe(props.stripeKey);
            const { paymentMethod: stripePaymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: cardElement.value,
            });
            
            if (error) {
                paymentError.value = error.message;
                paymentProcessing.value = false;
                return;
            }
            
            // Submit the payment method ID to server
            form.payment_method_id = stripePaymentMethod.id;
            form.payment_method = 'card';
            form.post(route('process.payment'));
        } else if (paymentMethod.value === 'ach') {
            // For ACH, we'll redirect to Stripe's ACH payment flow
            form.payment_method = 'ach';
            form.post(route('process.payment.ach'));
        }
    } catch (e) {
        paymentError.value = 'An unexpected error occurred. Please try again.';
        paymentProcessing.value = false;
    }
};

const setPaymentMethod = (method) => {
    paymentMethod.value = method;
};
</script>

<template>
    <AppLayout>
        <Head>
            <title>Checkout - FieldEngineer Pro</title>
        </Head>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h1 class="text-2xl font-semibold text-gray-900">Checkout</h1>
                        
                        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Order summary -->
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
                                
                                <div class="mt-4 border-t border-gray-200 pt-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">{{ product.name }}</span>
                                        <span class="text-gray-900">${{ product.price.toFixed(2) }}</span>
                                    </div>
                                    
                                    <div v-if="discountAmount > 0" class="flex justify-between mt-2 text-green-600">
                                        <span>Discount ({{ discountCode }})</span>
                                        <span>-${{ discountAmount.toFixed(2) }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between mt-4 pt-4 border-t border-gray-200 font-medium">
                                        <span>Total</span>
                                        <span>${{ finalPrice.toFixed(2) }}</span>
                                    </div>
                                    
                                    <!-- Subscription terms -->
                                    <div v-if="product.name !== 'FieldOps Scout'" class="mt-4 pt-4 border-t border-gray-200">
                                        <p class="text-sm text-indigo-600 font-medium">
                                            You will be billed ${{ product.price.toFixed(2) }} monthly for access to {{ product.name }}.
                                        </p>
                                    </div>
                                    
                                    <div v-else class="mt-4 pt-4 border-t border-gray-200">
                                        <p class="text-sm text-indigo-600 font-medium">
                                            One-time purchase, no recurring charges.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment form -->
                            <div class="bg-white p-6 rounded-lg border border-gray-200">
                                <h2 class="text-lg font-medium text-gray-900">Payment Method</h2>
                                
                                <!-- Payment method selector -->
                                <div class="mt-4 space-x-4">
                                    <button
                                        type="button"
                                        @click="setPaymentMethod('card')"
                                        :class="[
                                            'px-4 py-2 rounded-md',
                                            paymentMethod === 'card' 
                                                ? 'bg-indigo-600 text-white' 
                                                : 'bg-gray-100 text-gray-800 hover:bg-gray-200'
                                        ]"
                                    >
                                        Credit/Debit Card
                                    </button>
                                    
                                    <button
                                        type="button"
                                        @click="setPaymentMethod('ach')"
                                        :class="[
                                            'px-4 py-2 rounded-md',
                                            paymentMethod === 'ach' 
                                                ? 'bg-indigo-600 text-white' 
                                                : 'bg-gray-100 text-gray-800 hover:bg-gray-200'
                                        ]"
                                    >
                                        Bank Transfer (ACH)
                                    </button>
                                </div>
                                
                                <!-- Card payment form -->
                                <div v-if="paymentMethod === 'card'" class="mt-6">
                                    <div class="mb-4">
                                        <label for="card-element" class="block text-sm font-medium text-gray-700">Card Information</label>
                                        <div id="card-element" class="mt-1 p-3 border border-gray-300 rounded-md"></div>
                                        <div v-if="paymentError" class="mt-2 text-sm text-red-600">{{ paymentError }}</div>
                                    </div>
                                </div>
                                
                                <!-- ACH payment info -->
                                <div v-if="paymentMethod === 'ach'" class="mt-6">
                                    <p class="text-gray-600">
                                        You'll be redirected to securely connect your bank account for ACH payment.
                                    </p>
                                </div>
                                
                                <!-- Terms and Conditions -->
                                <TermsAndConditions
                                    :is-subscription="product.name !== 'FieldOps Scout'"
                                    subscription-frequency="monthly"
                                    v-model:value="termsAccepted"
                                    v-model:error="termsError"
                                />

                                <!-- Submit button -->
                                <div class="mt-8">
                                    <button 
                                        type="button" 
                                        @click="processPayment" 
                                        :disabled="paymentProcessing"
                                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                                    >
                                        <span v-if="paymentProcessing">Processing...</span>
                                        <span v-else>Pay ${{ finalPrice.toFixed(2) }}</span>
                                    </button>
                                </div>
                                
                                <!-- Secure payment note -->
                                <div class="mt-4 flex items-center justify-center space-x-2 text-sm text-gray-500">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <span>Secure payment processing by Stripe</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>