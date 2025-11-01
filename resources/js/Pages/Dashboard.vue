<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    purchases: Array,
});

const openFaq = ref(null);

const toggleFaq = (index) => {
    openFaq.value = openFaq.value === index ? null : index;
};

const faqs = [
    {
        question: "Why is 2026 the perfect time to start a field tech side hustle?",
        answer: "2026 marks a critical inflection point: the skilled trades shortage is at an all-time high with 650,000+ open positions, baby boomer retirements are accelerating, and businesses are desperate for reliable technicians. Early movers in 2026 will establish themselves before competition increases, lock in premium rates, and build client bases that will sustain them for years."
    },
    {
        question: "What makes field tech work more profitable than other side hustles?",
        answer: "Field tech work commands $50-150/hour because you're solving urgent, high-value problems that businesses can't ignore. Unlike gig economy work, you're positioning yourself as a specialized professional, not a commodity. Plus, overhead is minimal—you likely already own most tools needed, and clients come to you through word-of-mouth and simple online listings."
    },
    {
        question: "Do I need years of experience to start earning?",
        answer: "No! Many successful field tech side hustlers start with basic skills and learn as they grow. The key is starting with services you're confident in (even simple ones like equipment setup, basic repairs, or preventive maintenance), then expanding your offerings as you gain experience. Your first clients care more about reliability and professionalism than having 10 years of experience."
    },
    {
        question: "How does a side hustle benefit my main career?",
        answer: "Running your own field tech business makes you more valuable in your day job. You'll develop client management skills, business acumen, and problem-solving abilities that employers highly value. Many find their side hustle income gives them leverage to negotiate better terms at their main job, or even transition to full-time entrepreneurship when the time is right."
    },
    {
        question: "What are the market conditions for 2026?",
        answer: "Market conditions are exceptionally strong: small businesses are struggling to find reliable technicians, equipment complexity is increasing (more opportunities for specialized knowledge), and remote/hybrid work means businesses need more on-site support. Economic uncertainty actually drives demand as companies prefer hiring contractors over full-time employees. Starting in 2026 positions you ahead of the inevitable wave of new technicians."
    },
    {
        question: "Can I really maintain work-life balance with a side hustle?",
        answer: "Absolutely. Field tech side hustles are uniquely flexible—you choose which jobs to accept, when to work, and how much to charge. Most successful side hustlers work 10-20 hours per week on weekends or evenings, earning $2K-5K monthly. You control your schedule completely, and since you're servicing local businesses, travel time is minimal. Start small with one client, then scale at your own pace."
    },
    {
        question: "Won't the market get saturated if everyone starts doing this?",
        answer: "The skilled trades shortage is massive—650,000+ open positions currently, growing every year. Even if 10,000 people started field tech side hustles tomorrow, it wouldn't make a dent. Plus, this work is inherently local and relationship-based. Your competition isn't everyone nationwide; it's the handful of people in your specific area offering your specific services. Quality providers always have more work than they can handle."
    },
    {
        question: "How quickly can I start making money?",
        answer: "Many of our students land their first paid client within 2-4 weeks of starting. The initial setup is simple: create basic listings on Google My Business and local directories, reach out to your network, and start accepting jobs. Unlike complex online businesses, field tech work has immediate demand. Once you complete a few jobs successfully, word-of-mouth referrals create a steady stream of opportunities."
    },
    {
        question: "Can AI or robots replace field engineers?",
        answer: "Not anytime soon—and possibly never. Field tech work requires physical presence, hands-on problem-solving, adaptability to unique situations, and human judgment that AI simply cannot replicate. While AI might help with diagnostics or documentation, someone still needs to physically install equipment, troubleshoot complex systems in unpredictable environments, and make on-the-spot decisions. Unlike desk jobs vulnerable to automation, field tech work is one of the most future-proof careers available. The physical, hands-on nature of this work makes it irreplaceable by technology."
    }
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-gray-900 dark:bg-gray-800 shadow-xl sm:rounded-lg p-6">
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Your Purchases</h1>
                    
                    <div v-if="purchases && purchases.length > 0">
                        <div class="space-y-6">
                            <div v-for="purchase in purchases" :key="purchase.id" class="border border-gray-200 dark:border-gray-700 rounded-lg p-6 dark:bg-gray-800">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                    <div>
                                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ purchase.product.name }}</h2>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Purchased on {{ new Date(purchase.created_at).toLocaleDateString() }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Order #{{ purchase.order_number }}
                                        </p>
                                    </div>
                                    
                                    <div class="mt-2 sm:mt-0">
                                        <span 
                                            :class="[
                                                'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
                                                purchase.status === 'completed' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300' : 
                                                purchase.status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-300' : 
                                                'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-300'
                                            ]"
                                        >
                                            {{ purchase.status.charAt(0).toUpperCase() + purchase.status.slice(1) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <a 
                                        v-if="purchase.status === 'completed'" 
                                        :href="route('products.toc', purchase.product.id)"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    >
                                        Access Content
                                    </a>
                                    
                                    <p v-else-if="purchase.status === 'pending'" class="text-sm text-yellow-600 dark:text-yellow-400">
                                        Your purchase is being processed. Content access will be available soon.
                                    </p>
                                    
                                    <p v-else-if="purchase.status === 'refunded'" class="text-sm text-red-600 dark:text-red-400">
                                        This purchase has been refunded.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Enhanced Free User Experience -->
                    <div v-else class="space-y-8">
                        <!-- Welcome Banner -->
                        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-500 to-orange-600 p-8 shadow-2xl">
                            <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>
                            <div class="absolute bottom-0 left-0 -mb-4 -ml-4 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>
                            
                            <div class="relative">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-2xl font-bold text-white mb-2">Welcome to Your Dashboard! 🎉</h3>
                                        <p class="text-orange-100 text-lg mb-4">You're one step closer to launching your profitable field tech side hustle.</p>
                                        <p class="text-white/90 text-sm mb-6">Explore our training programs, preview content, and see how you can start earning $2K-$5K+ monthly in your spare time.</p>
                                        <a :href="route('products')" class="inline-flex items-center px-6 py-3 bg-white text-orange-600 font-bold rounded-lg hover:bg-orange-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            Explore Training Programs
                                        </a>
                                    </div>
                                    <div class="hidden lg:block">
                                        <svg class="w-32 h-32 text-white/20" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Benefits Grid -->
                        <div class="grid md:grid-cols-3 gap-6">
                            <!-- Preview Content -->
                            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition-all duration-200">
                                <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-lg flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-white mb-2">Preview Training</h4>
                                <p class="text-gray-400 text-sm mb-4">Explore sample lessons and see what's included in our comprehensive field tech training program.</p>
                                <a :href="route('products')" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium inline-flex items-center">
                                    View Preview
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>

                            <!-- Track Progress -->
                            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition-all duration-200">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-white mb-2">Your Journey</h4>
                                <p class="text-gray-400 text-sm mb-4">Once you purchase, track your learning progress and completed modules all in one place.</p>
                                <span class="text-gray-500 text-sm font-medium">Available after purchase</span>
                            </div>

                            <!-- Community Access -->
                            <div class="bg-gray-800 border border-gray-700 rounded-xl p-6 hover:border-orange-500/50 transition-all duration-200">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-white mb-2">Join Community</h4>
                                <p class="text-gray-400 text-sm mb-4">Connect with other field engineers, share tips, and learn from real success stories.</p>
                                <span class="text-gray-500 text-sm font-medium">Coming soon</span>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="bg-gradient-to-r from-gray-800 to-gray-900 border border-gray-700 rounded-xl p-6">
                            <h4 class="text-lg font-bold text-white mb-4">Why Start Your Side Hustle Now?</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-orange-400 mb-1">$50-150</div>
                                    <div class="text-sm text-gray-400">Per Hour Average</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-cyan-400 mb-1">10-20</div>
                                    <div class="text-sm text-gray-400">Hours Per Week</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-purple-400 mb-1">$2K-5K</div>
                                    <div class="text-sm text-gray-400">Monthly Potential</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-green-400 mb-1">100%</div>
                                    <div class="text-sm text-gray-400">Your Schedule</div>
                                </div>
                            </div>
                        </div>

                        <!-- FAQ Section -->
                        <div class="bg-gray-800 border border-gray-700 rounded-xl p-6">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-white">Why Start in 2026?</h4>
                                    <p class="text-sm text-gray-400">Your questions about timing and opportunity answered</p>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div 
                                    v-for="(faq, index) in faqs" 
                                    :key="index"
                                    class="border border-gray-700 rounded-lg overflow-hidden hover:border-orange-500/50 transition-all duration-200"
                                >
                                    <button
                                        @click="toggleFaq(index)"
                                        class="w-full px-5 py-4 flex items-center justify-between text-left bg-gray-800/50 hover:bg-gray-800 transition-colors duration-200"
                                    >
                                        <span class="font-medium text-white pr-4">{{ faq.question }}</span>
                                        <svg 
                                            class="w-5 h-5 text-orange-400 flex-shrink-0 transform transition-transform duration-200"
                                            :class="{ 'rotate-180': openFaq === index }"
                                            fill="none" 
                                            stroke="currentColor" 
                                            viewBox="0 0 24 24"
                                        >
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <transition
                                        enter-active-class="transition-all duration-200 ease-out"
                                        enter-from-class="opacity-0 max-h-0"
                                        enter-to-class="opacity-100 max-h-96"
                                        leave-active-class="transition-all duration-200 ease-in"
                                        leave-from-class="opacity-100 max-h-96"
                                        leave-to-class="opacity-0 max-h-0"
                                    >
                                        <div v-show="openFaq === index" class="px-5 py-4 bg-gray-900/50 border-t border-gray-700">
                                            <p class="text-gray-300 leading-relaxed">{{ faq.answer }}</p>
                                        </div>
                                    </transition>
                                </div>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="text-center bg-gray-800/50 border-2 border-dashed border-gray-700 rounded-xl p-8">
                            <svg class="mx-auto h-16 w-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-white mb-2">Ready to Get Started?</h3>
                            <p class="text-gray-400 mb-6">Browse our training programs and start your journey to earning extra income today.</p>
                            <a :href="route('products')" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-600 to-orange-500 text-white font-bold rounded-lg hover:from-orange-500 hover:to-orange-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Browse Training Programs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
