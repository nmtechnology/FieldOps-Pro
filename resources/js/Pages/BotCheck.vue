<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 flex items-center justify-center px-4 py-8">
        <!-- Floating particles background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-2 h-2 bg-orange-500 rounded-full opacity-50 animate-pulse"></div>
            <div class="absolute top-40 right-20 w-3 h-3 bg-orange-400 rounded-full opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-32 left-1/4 w-2 h-2 bg-orange-600 rounded-full opacity-40 animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute bottom-20 right-1/3 w-3 h-3 bg-orange-300 rounded-full opacity-20 animate-pulse" style="animation-delay: 1.5s;"></div>
        </div>

        <div class="max-w-6xl w-full relative z-10">
            <!-- Header with Logo and Brand -->
            <div class="text-center mb-12">
                <div class="flex items-center justify-center mb-6">
                    <ApplicationLogo class="h-16 w-auto mr-4" />
                    <div class="text-left">
                        <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight">
                            FieldEngineer<span class="text-orange-500">Pro</span>
                        </h1>
                        <p class="text-orange-400 text-sm font-medium tracking-wide">Professional Training Platform</p>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-start">
                
                <!-- Left: Hero Book Section -->
                <div class="order-2 lg:order-1">
                    <div class="relative">
                        <!-- Glow effect -->
                        <div class="absolute -inset-1 bg-gradient-to-r from-orange-600 to-orange-400 rounded-3xl blur-2xl opacity-20"></div>
                        
                        <!-- Main card -->
                        <div class="relative bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl p-8 border border-orange-500/30 shadow-2xl">
                            
                            <!-- Book Display -->
                            <div class="mb-8">
                                <div class="relative aspect-[4/5] max-w-sm mx-auto">
                                    <!-- Book cover -->
                                    <div class="absolute inset-0 bg-gradient-to-br from-orange-600 via-orange-500 to-orange-700 rounded-2xl shadow-2xl transform rotate-2 hover:rotate-0 transition-transform duration-500">
                                        <!-- Shine effect -->
                                        <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-transparent rounded-2xl"></div>
                                        
                                        <!-- Book content -->
                                        <div class="relative h-full flex flex-col items-center justify-center p-8 text-center">
                                            <div class="space-y-6">
                                                <div>
                                                    <div class="text-white font-black text-3xl sm:text-4xl leading-tight mb-2" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5)">
                                                        FIELD ENGINEER'S
                                                    </div>
                                                    <div class="text-white font-black text-4xl sm:text-5xl leading-tight mb-2" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5)">
                                                        OPERATIONS
                                                    </div>
                                                    <div class="text-white font-black text-3xl sm:text-4xl leading-tight" style="text-shadow: 2px 2px 8px rgba(0,0,0,0.5)">
                                                        GUIDE
                                                    </div>
                                                </div>
                                                
                                                <div class="border-t border-white/30 pt-6">
                                                    <p class="text-white/95 text-lg font-bold mb-1">Launch Your Side Hustle</p>
                                                    <p class="text-white/90 text-2xl font-black">$2K-$5K/Month</p>
                                                </div>
                                            </div>
                                            
                                            <!-- Corner accents -->
                                            <div class="absolute top-4 right-4 w-12 h-12 border-2 border-white/30 rounded-tl-3xl"></div>
                                            <div class="absolute bottom-4 left-4 w-12 h-12 border-2 border-white/30 rounded-br-3xl"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Benefits -->
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3 bg-gray-900/50 rounded-xl p-4 border border-orange-500/20">
                                    <div class="flex-shrink-0 w-6 h-6 bg-orange-500 rounded-full flex items-center justify-center mt-0.5">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-white font-bold text-lg">$50-150 Per Hour</p>
                                        <p class="text-gray-400 text-sm">Premium rates for field tech work</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3 bg-gray-900/50 rounded-xl p-4 border border-orange-500/20">
                                    <div class="flex-shrink-0 w-6 h-6 bg-cyan-500 rounded-full flex items-center justify-center mt-0.5">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-white font-bold text-lg">No Experience Required</p>
                                        <p class="text-gray-400 text-sm">Start learning from scratch today</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3 bg-gray-900/50 rounded-xl p-4 border border-orange-500/20">
                                    <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-0.5">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-white font-bold text-lg">Flexible Schedule</p>
                                        <p class="text-gray-400 text-sm">Work 10-20 hours/week on your terms</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Market demand note -->
                            <div class="mt-6 p-4 bg-orange-500/10 border border-orange-500/30 rounded-xl">
                                <p class="text-orange-300 text-sm text-center">
                                    <span class="font-bold">650,000+</span> open field tech positions nationwide
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Verification Form -->
                <div class="order-1 lg:order-2">
                    <div class="bg-gray-800 border-2 border-orange-500 rounded-3xl p-8 shadow-2xl">
                        
                        <!-- Shield icon -->
                        <div class="flex justify-center mb-6">
                            <div class="relative">
                                <div class="absolute inset-0 bg-orange-500/50 rounded-2xl blur-xl"></div>
                                <div class="relative bg-gradient-to-br from-orange-600 to-orange-500 p-5 rounded-2xl">
                                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-black text-white mb-2">Verify You're Human</h2>
                            <p class="text-gray-400">Solve the math problem below to continue</p>
                        </div>

                        <!-- Math problem -->
                        <div class="bg-gray-900 rounded-2xl p-8 mb-6 border-2 border-gray-700">
                            <div class="flex items-center justify-center gap-6 text-5xl font-black">
                                <span class="text-orange-400">{{ num1 }}</span>
                                <span class="text-gray-600">+</span>
                                <span class="text-orange-400">{{ num2 }}</span>
                                <span class="text-gray-600">=</span>
                                <span class="text-orange-400">?</span>
                            </div>
                        </div>

                        <!-- Input -->
                        <div class="space-y-4">
                            <input
                                ref="answerInput"
                                v-model="userAnswer"
                                type="number"
                                class="w-full px-6 py-4 bg-gray-900 border-2 rounded-2xl text-white text-2xl font-bold text-center focus:outline-none focus:border-orange-500 focus:ring-4 focus:ring-orange-500/20 transition-all"
                                :class="{ 
                                    'border-red-500 ring-4 ring-red-500/20 animate-shake': showError,
                                    'border-green-500 ring-4 ring-green-500/20': showSuccess,
                                    'border-gray-700': !showError && !showSuccess
                                }"
                                placeholder="Your answer"
                                @keyup.enter="checkAnswer"
                                @input="showError = false"
                                :disabled="showSuccess"
                            />

                            <!-- Button -->
                            <button
                                @click="checkAnswer"
                                class="w-full px-6 py-4 rounded-2xl font-black text-lg text-white transition-all duration-300 transform hover:scale-105"
                                :class="showSuccess 
                                    ? 'bg-green-600 hover:bg-green-500 shadow-green-500/50' 
                                    : 'bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-600 shadow-orange-500/50'"
                                :disabled="!userAnswer || showSuccess"
                            >
                                <span v-if="!showSuccess" class="flex items-center justify-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    VERIFY & ENTER
                                </span>
                                <span v-else class="flex items-center justify-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    VERIFIED! LOADING...
                                </span>
                            </button>
                        </div>

                        <!-- Error message -->
                        <transition name="fade">
                            <div v-if="showError" class="mt-4 p-4 bg-red-900/50 border-2 border-red-500 rounded-xl text-center">
                                <p class="text-red-200 font-bold">❌ Incorrect. Please try again!</p>
                            </div>
                        </transition>

                        <!-- Footer info -->
                        <div class="mt-6 pt-6 border-t border-gray-700 flex items-center justify-between text-sm">
                            <span class="text-gray-400">Attempt {{ attempts }}/3</span>
                            <div class="flex items-center text-gray-500">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Security Protection</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { router } from '@inertiajs/vue3';

export default {
    name: 'BotCheck',
    components: {
        ApplicationLogo
    },
    data() {
        return {
            num1: 0,
            num2: 0,
            userAnswer: '',
            attempts: 0,
            showError: false,
            showSuccess: false
        };
    },
    mounted() {
        this.generateMathProblem();
        // Safe focus with null check
        this.$nextTick(() => {
            if (this.$refs.answerInput) {
                this.$refs.answerInput.focus();
            }
        });
    },
    methods: {
        generateMathProblem() {
            this.num1 = Math.floor(Math.random() * 10) + 1;
            this.num2 = Math.floor(Math.random() * 10) + 1;
        },
        checkAnswer() {
            if (!this.userAnswer) return;
            
            const correctAnswer = this.num1 + this.num2;
            this.attempts++;
            
            if (parseInt(this.userAnswer) === correctAnswer) {
                this.showSuccess = true;
                
                // Wait a moment to show success state, then submit verification
                setTimeout(() => {
                    // Use Inertia router for POST - server will redirect to loading screen
                    router.post('/verify', {}, {
                        preserveState: false,
                        preserveScroll: false,
                    });
                }, 1500);
            } else {
                this.showError = true;
                
                // Reset after animation
                setTimeout(() => {
                    this.showError = false;
                    this.userAnswer = '';
                    
                    // Generate new problem if too many attempts
                    if (this.attempts >= 3) {
                        this.generateMathProblem();
                        this.attempts = 0;
                    }
                }, 1500);
            }
        }
    }
};
</script>

<style scoped>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-10px); }
    50% { transform: translateX(10px); }
    75% { transform: translateX(-10px); }
}

.animate-shake {
    animation: shake 0.5s ease-in-out;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>

