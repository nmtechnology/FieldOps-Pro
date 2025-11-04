<template>
    <section id="pricing" class="py-16 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-orange-400 font-semibold tracking-wide uppercase">Pricing</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-orange-400 sm:text-4xl">
                    Choose the tier that fits your needs
                </p>
                <p class="mt-4 max-w-2xl text-xl text-white mx-auto">
                    From getting started to building a full-time field engineering business
                </p>
                <div v-if="activeDiscount" class="mt-4 inline-flex items-center px-4 py-2 rounded-full bg-green-500/20 border border-green-500/30">
                    <svg class="w-5 h-5 text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-300 font-semibold text-sm">Limited Time: {{ activeDiscount.discount_percentage }}% OFF All Tiers!</span>
                </div>
            </div>
            
            <div class="mt-16 space-y-12 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8">
                <!-- Scout Tier -->
                <div class="relative p-8 bg-gray-800 border border-gray-700 rounded-2xl shadow-sm flex flex-col">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-orange-400">FieldOps Scout</h3>
                        <p class="mt-4 flex items-baseline text-orange-400">
                            <span v-if="activeDiscount" class="text-3xl font-semibold text-gray-400 line-through mr-2">${{ basePrices.scout.toFixed(2) }}</span>
                            <span class="text-5xl font-extrabold tracking-tight">${{ activeDiscount ? calculateDiscountedPrice(basePrices.scout).toFixed(2) : basePrices.scout.toFixed(2) }}</span>
                            <span class="ml-1 text-xl font-semibold">one-time</span>
                        </p>
                        <p class="mt-6 text-white">
                            Perfect for beginners looking to break into field engineering and low voltage contracting.
                        </p>
                        
                        <!-- Feature list -->
                        <ul role="list" class="mt-6 space-y-6">
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">Professional profile setup guide</span>
                            </li>
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">Market access fundamentals</span>
                            </li>
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">Platform navigation tutorial</span>
                            </li>
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">Getting your first job guide</span>
                            </li>
                        </ul>
                    </div>
                    
                    <a href="#" class="mt-8 block w-full bg-gray-700 border border-gray-600 rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-gray-600">
                        Buy Now
                    </a>
                </div>
                
                <!-- Pro Tier (Highlighted) -->
                <div class="relative p-8 bg-gray-800 border-2 border-orange-400 rounded-2xl shadow-sm flex flex-col">
                    <div class="absolute top-0 inset-x-0 transform translate-y-px">
                        <div class="flex justify-center transform -translate-y-1/2">
                            <span class="inline-flex rounded-full bg-orange-400 px-4 py-1 text-sm font-semibold tracking-wider uppercase text-gray-900">
                                Most Popular
                            </span>
                        </div>
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-orange-400">FieldOps Pro</h3>
                        <p class="mt-4 flex items-baseline text-orange-400">
                            <span v-if="activeDiscount" class="text-3xl font-semibold text-gray-400 line-through mr-2">${{ basePrices.pro.toFixed(2) }}</span>
                            <span class="text-5xl font-extrabold tracking-tight">${{ activeDiscount ? calculateDiscountedPrice(basePrices.pro).toFixed(2) : basePrices.pro.toFixed(2) }}</span>
                            <span class="ml-1 text-xl font-semibold">/month</span>
                        </p>
                        <p class="mt-6 text-white">
                            For contractors seeking to establish a consistent income stream and build a reputation.
                        </p>
                        
                        <!-- Feature list -->
                        <ul role="list" class="mt-6 space-y-6">
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">Advanced bidding strategies</span>
                            </li>
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">Competitive rate setting</span>
                            </li>
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">Client management systems</span>
                            </li>
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">Monthly income planning</span>
                            </li>
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">Field engineering best practices</span>
                            </li>
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">All Scout tier benefits included</span>
                            </li>
                        </ul>
                    </div>
                    
                    <a href="#" class="mt-8 block w-full bg-orange-400 border border-transparent rounded-md py-2 text-sm font-semibold text-gray-900 text-center hover:bg-orange-500">
                        Subscribe Now
                    </a>
                </div>
                
                <!-- Elite Tier -->
                <div class="relative p-8 bg-gray-800 border border-gray-700 rounded-2xl shadow-sm flex flex-col">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-orange-400">FieldOps Elite</h3>
                        <p class="mt-4 flex items-baseline text-orange-400">
                            <span v-if="activeDiscount" class="text-3xl font-semibold text-gray-400 line-through mr-2">${{ basePrices.elite.toFixed(2) }}</span>
                            <span class="text-5xl font-extrabold tracking-tight">${{ activeDiscount ? calculateDiscountedPrice(basePrices.elite).toFixed(2) : basePrices.elite.toFixed(2) }}</span>
                            <span class="ml-1 text-xl font-semibold">/month</span>
                        </p>
                        <p class="mt-6 text-white">
                            Premium tier for serious field engineers looking to maximize earnings and scale their business.
                        </p>
                        
                        <!-- Feature list -->
                        <ul role="list" class="mt-6 space-y-6">
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">Premium bid templates</span>
                            </li>
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">Rate optimization framework</span>
                            </li>
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">Enterprise client acquisition</span>
                            </li>
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">Multiple contract management</span>
                            </li>
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">VIP support and mentoring</span>
                            </li>
                            <li class="flex">
                                <span class="text-orange-400 mr-2">✓</span>
                                <span class="text-white">All Pro tier benefits included</span>
                            </li>
                        </ul>
                    </div>
                    
                    <a href="#" class="mt-8 block w-full bg-gray-700 border border-gray-600 rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-gray-600">
                        Subscribe Now
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
// Component for displaying pricing tiers
const props = defineProps({
    activeDiscount: {
        type: Object,
        default: null
    }
});

// Base prices for each tier
const basePrices = {
    scout: 22.99,
    pro: 67.98,
    elite: 89.98
};

// Calculate discounted price based on discount type
const calculateDiscountedPrice = (basePrice) => {
    if (!props.activeDiscount) return basePrice;
    
    let discountedPrice = basePrice;
    
    if (props.activeDiscount.type === 'percentage') {
        const discountAmount = (basePrice * props.activeDiscount.value) / 100;
        discountedPrice = basePrice - discountAmount;
    } else { // fixed amount
        discountedPrice = Math.max(0, basePrice - props.activeDiscount.value);
    }
    
    return discountedPrice;
};
</script>
