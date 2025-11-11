<template>
    <footer class="bg-gray-800 border-t border-gray-700 mt-16 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Trust Badges Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-12">
                <!-- SSL Secure Badge -->
                <div class="flex flex-col items-center text-center group">
                    <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-4 rounded-lg mb-3 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414L10 3.586l4.707 4.707a1 1 0 01-1.414 1.414L10 6.414l-3.293 3.293a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-1">SSL Secure</h3>
                    <p class="text-xs text-gray-400">256-bit Encryption</p>
                </div>

                <!-- Money Back Guarantee -->
                <div class="flex flex-col items-center text-center group">
                    <div class="bg-gradient-to-br from-blue-500 to-cyan-600 p-4 rounded-lg mb-3 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-1">Money-Back Guarantee</h3>
                    <p class="text-xs text-gray-400">30-Day Satisfaction</p>
                </div>

                <!-- Verified Seller -->
                <div class="flex flex-col items-center text-center group">
                    <div class="bg-gradient-to-br from-purple-500 to-pink-600 p-4 rounded-lg mb-3 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 3.062v6.218c0 1.257-.925 2.348-2.169 2.47a8.054 8.054 0 01-1.147.081H7.3a8.054 8.054 0 01-1.146-.081c-1.244-.122-2.169-1.213-2.169-2.47V6.517a3.066 3.066 0 012.812-3.062zM9 13a1 1 0 11-2 0 1 1 0 012 0zm5-4a1 1 0 100-2 1 1 0 000 2zM5 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-1">Verified Seller</h3>
                    <p class="text-xs text-gray-400">Industry Trusted</p>
                </div>

                <!-- Secure Checkout -->
                <div class="flex flex-col items-center text-center group">
                    <div class="bg-gradient-to-br from-orange-500 to-red-600 p-4 rounded-lg mb-3 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-1">Secure Checkout</h3>
                    <p class="text-xs text-gray-400">PCI Compliant</p>
                </div>

                <!-- Customer Support -->
                <div class="flex flex-col items-center text-center group">
                    <div class="bg-gradient-to-br from-indigo-500 to-blue-600 p-4 rounded-lg mb-3 group-hover:scale-110 transition-transform duration-200">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-semibold text-white mb-1">24/7 Support</h3>
                    <p class="text-xs text-gray-400">Dedicated Team</p>
                </div>
            </div>

            <!-- Footer Links & Legal -->
            <div class="border-t border-gray-700 pt-8 mt-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <!-- About -->
                    <div>
                        <h4 class="text-sm font-semibold text-white mb-4">About FieldEngineer Pro</h4>
                        <p class="text-xs text-gray-400 leading-relaxed">
                            Trusted digital product marketplace providing premium engineering solutions and professional development content since 2024.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-sm font-semibold text-white mb-4">Quick Links</h4>
                        <ul class="space-y-2">
                            <li><a href="#" @click.prevent="$emit('show-terms')" class="text-xs text-gray-400 hover:text-orange-400 transition">Terms & Conditions</a></li>
                            <li><a href="#" @click.prevent="$emit('show-privacy')" class="text-xs text-gray-400 hover:text-orange-400 transition">Privacy Policy</a></li>
                            <li><a href="#" @click.prevent="$emit('show-refund')" class="text-xs text-gray-400 hover:text-orange-400 transition">Refund Policy</a></li>
                            <li><a href="mailto:support@fieldengineer.pro" class="text-xs text-gray-400 hover:text-orange-400 transition">Contact Support</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h4 class="text-sm font-semibold text-white mb-4">Get in Touch</h4>
                        <ul class="space-y-2">
                            <li class="text-xs text-gray-400"><span class="font-semibold">Email:</span> support@fieldengineer.pro</li>
                            <li class="text-xs text-gray-400"><span class="font-semibold">Hours:</span> Mon-Fri 9AM-6PM EST</li>
                            <li class="text-xs text-gray-400"><span class="font-semibold">Response:</span> Within 2 hours</li>
                        </ul>
                    </div>
                </div>

                <!-- Copyright & Legal -->
                <div class="border-t border-gray-700 pt-6">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-xs text-gray-500 mb-4 md:mb-0">
                            &copy; {{ currentYear }} FieldEngineer Pro. All rights reserved.
                        </p>
                        <div class="flex space-x-4 text-xs text-gray-500">
                            <span>PCI DSS Compliant</span>
                            <span class="text-gray-700">•</span>
                            <span>GDPR Compliant</span>
                            <span class="text-gray-700">•</span>
                            <span>SOC 2 Certified</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'TrustedBadge',
    data() {
        return {
            currentYear: new Date().getFullYear()
        };
    }
});
</script>
