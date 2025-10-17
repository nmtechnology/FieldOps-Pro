<template>
    <div class="terms-container">
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-gray-900 rounded-lg max-w-3xl w-full max-h-[80vh] overflow-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-orange-400">Terms and Conditions</h2>
                        <button @click="closeModal" class="text-white hover:text-orange-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="prose prose-sm max-w-none text-white prose-headings:text-orange-400">
                        <h3>1. Subscription Terms</h3>
                        <p>By purchasing a subscription to FieldOps Pro or FieldOps Elite, you agree that your credit card or other payment method will be billed automatically on a monthly basis until you cancel your subscription. The Scout tier is a one-time purchase and does not include recurring charges.</p>
                        
                        <h3>2. Billing and Cancellation</h3>
                        <p>Your subscription will automatically renew each month on the anniversary of your purchase date. You may cancel your subscription at any time through your account settings or by contacting customer support. Upon cancellation, you will retain access to the subscription content until the end of your current billing period.</p>
                        
                        <h3>3. Refund Policy</h3>
                        <p>We offer a 14-day money-back guarantee for first-time subscribers. If you are not satisfied with your subscription within the first 14 days, contact us for a full refund. After this period, refunds are issued at our discretion.</p>
                        
                        <h3>4. Price Changes</h3>
                        <p>We reserve the right to adjust pricing for our subscriptions. If the subscription price changes, we will notify you via email before the change takes effect.</p>
                        
                        <h3>5. Content Usage</h3>
                        <p>All content provided through our platform is for your personal use only. You may not share, distribute, or resell our content to third parties. You may not reproduce or create derivative works from our materials without express permission.</p>
                        
                        <h3>6. Account Security</h3>
                        <p>You are responsible for maintaining the confidentiality of your account information and password. You agree to accept responsibility for all activities that occur under your account.</p>
                        
                        <h3>7. Intellectual Property</h3>
                        <p>All content, materials, and information provided through our platform are protected by intellectual property laws and remain the property of FieldEngineer Pro. You receive a limited license to access the content for your personal use only.</p>
                        
                        <h3>8. Limitation of Liability</h3>
                        <p>We strive to provide accurate and valuable information, but we make no guarantees about the results you may achieve by implementing our strategies. We are not liable for any financial losses or damages resulting from the use of our content.</p>
                        
                        <h3>9. Communication</h3>
                        <p>By creating an account, you agree to receive emails related to your account, subscription, and occasional updates about our products and services. You can opt out of marketing communications at any time.</p>
                        
                        <h3>10. Governing Law</h3>
                        <p>These terms and conditions are governed by the laws of the United States without regard to its conflict of law provisions.</p>
                    </div>
                    
                    <div class="mt-6 text-right">
                        <button @click="closeModal" class="px-4 py-2 bg-orange-400 text-gray-900 rounded-md hover:bg-orange-500">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input 
                        id="terms" 
                        name="terms" 
                        type="checkbox" 
                        v-model="accepted"
                        required
                        class="focus:ring-orange-400 h-4 w-4 text-orange-400 border-gray-700 rounded"
                    />
                </div>
                <div class="ml-3 text-sm">
                    <label for="terms" class="font-medium text-white">
                        I agree to the 
                        <button 
                            type="button" 
                            @click="openModal" 
                            class="text-orange-400 hover:text-orange-300 underline"
                        >
                            Terms and Conditions
                        </button>
                        <template v-if="isSubscription">
                            and understand that my payment method will be billed {{ subscriptionFrequency }} until I cancel.
                        </template>
                    </label>
                </div>
            </div>
            <p v-if="showError" class="mt-2 text-sm text-red-600 dark:text-red-400">
                You must accept the terms and conditions to proceed
            </p>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    isSubscription: {
        type: Boolean,
        default: false
    },
    subscriptionFrequency: {
        type: String,
        default: 'monthly'
    },
    value: {
        type: Boolean,
        default: false
    },
    error: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['update:value', 'update:error']);

const showModal = ref(false);
const accepted = ref(props.value);
const showError = ref(props.error);

watch(accepted, (newVal) => {
    emit('update:value', newVal);
    if (newVal) {
        emit('update:error', false);
    }
});

watch(() => props.error, (newVal) => {
    showError.value = newVal;
});

function openModal() {
    showModal.value = true;
}

function closeModal() {
    showModal.value = false;
}
</script>