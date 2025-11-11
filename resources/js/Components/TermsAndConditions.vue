<template>
    <div class="terms-container">
        <Teleport to="body">
            <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                <div class="bg-gray-800 rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden flex flex-col border border-gray-700">
                    <!-- Header -->
                    <div class="bg-gray-900 border-b border-gray-700 px-6 py-4 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-white">Terms & Conditions</h2>
                        <button @click="closeModal" class="text-gray-400 hover:text-white transition">
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

                            <div>
                                <h3 class="text-white font-semibold mb-2">11. Severability</h3>
                                <p>If any provision of these terms is found to be invalid or unenforceable, such provision shall be struck and the remaining provisions shall remain in full force and effect.</p>
                            </div>

                            <div>
                                <h3 class="text-white font-semibold mb-2">12. Contact Information</h3>
                                <p>For questions regarding these terms and conditions, please contact us at support@fieldengineer.pro.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-900 border-t border-gray-700 px-6 py-4 flex justify-end space-x-3">
                        <button @click="closeModal" class="px-4 py-2 rounded-md bg-gray-700 hover:bg-gray-600 text-white transition">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </Teleport>

        <div class="mt-4">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input 
                        id="terms" 
                        name="terms" 
                        type="checkbox" 
                        v-model="accepted"
                        required
                        class="focus:ring-orange-400 h-4 w-4 text-orange-400 border-gray-700 rounded bg-gray-700"
                    />
                </div>
                <div class="ml-3 text-sm">
                    <label for="terms" class="font-medium text-gray-300">
                        I agree to the 
                        <button 
                            type="button" 
                            @click="openModal" 
                            class="text-orange-400 hover:text-orange-300 underline font-semibold"
                        >
                            Terms and Conditions
                        </button>
                    </label>
                </div>
            </div>
            <p v-if="showError" class="mt-2 text-sm text-red-400">
                You must accept the terms and conditions to proceed
            </p>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
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