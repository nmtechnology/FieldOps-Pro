<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    products: Array,
    userProducts: Array,
});

// Filter out products the user already owns
const availableProducts = ref(
    props.products.filter(product => 
        !props.userProducts.some(userProduct => 
            userProduct.product_id === product.id
        )
    )
);

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
};
</script>

<template>
    <Head title="Products - Your Field Tech Side Hustle Training" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        Side Hustle Training Programs
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Build your field engineering side business with proven strategies
                    </p>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Hero Banner -->
                <div class="mb-8 relative overflow-hidden bg-gradient-to-r from-orange-600 to-orange-700 rounded-2xl shadow-2xl">
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="relative px-6 py-12 sm:px-12">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-3xl font-bold text-white mb-2">Transform Your Spare Time Into Income</h1>
                                <p class="text-xl text-orange-100">Professional field tech training to launch your side hustle</p>
                            </div>
                            <div class="hidden lg:block">
                                <svg class="w-32 h-32 text-white/20" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                    
                <div v-if="availableProducts.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="product in availableProducts" :key="product.id" 
                        class="group relative bg-gray-800 rounded-2xl overflow-hidden shadow-xl border border-gray-700 hover:border-orange-500/50 transition-all duration-300 hover:transform hover:scale-105">
                        
                        <!-- Hover Glow Effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-500/0 via-orange-500/10 to-orange-500/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Product Image -->
                        <div class="relative h-56 bg-gradient-to-br from-gray-700 to-gray-800 overflow-hidden">
                            <img v-if="product.image" :src="product.image" alt="Product image" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-300" />
                            <div v-else class="flex items-center justify-center h-full">
                                <div class="text-center">
                                    <svg class="mx-auto h-16 w-16 text-orange-500/50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">Side Hustle Training</p>
                                </div>
                            </div>
                            
                            <!-- Badge -->
                            <div class="absolute top-4 right-4 bg-orange-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                Popular
                            </div>
                        </div>
                        
                        <!-- Product Details -->
                        <div class="relative p-6">
                            <h3 class="text-xl font-bold text-white mb-2 group-hover:text-orange-400 transition-colors">{{ product.name }}</h3>
                            
                            <!-- Price -->
                            <div class="flex items-baseline gap-2 mb-4">
                                <span class="text-3xl font-bold text-orange-400">{{ formatCurrency(product.price) }}</span>
                                <span v-if="product.old_price" class="text-lg line-through text-gray-500">
                                    {{ formatCurrency(product.old_price) }}
                                </span>
                                <span v-if="product.old_price" class="ml-auto bg-green-500/20 text-green-400 px-2 py-1 rounded text-xs font-bold">
                                    SAVE {{ Math.round(((product.old_price - product.price) / product.old_price) * 100) }}%
                                </span>
                            </div>
                            
                            <p class="text-gray-300 mb-6 line-clamp-2">{{ product.description }}</p>
                            
                            <!-- Features -->
                            <div v-if="product.features && product.features.length" class="mb-6">
                                <div class="space-y-2">
                                    <div v-for="(feature, index) in product.features.slice(0, 3)" :key="index" class="flex items-start text-sm text-gray-300">
                                        <svg class="w-5 h-5 text-green-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ feature }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                <a :href="route('products.show', product.id)" 
                                   class="flex-1 inline-flex items-center justify-center px-4 py-3 border-2 border-gray-600 rounded-lg font-medium text-gray-300 hover:border-orange-500 hover:text-orange-400 transition-all duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Details
                                </a>
                                
                                <a :href="route('checkout', product.id)"
                                   class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-orange-600 to-orange-500 rounded-lg font-bold text-white hover:from-orange-500 hover:to-orange-600 shadow-lg hover:shadow-orange-500/50 transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Buy Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div v-else class="text-center py-16">
                    <div class="bg-gray-800 rounded-2xl p-12 border border-gray-700">
                        <div class="flex justify-center mb-4">
                            <div class="rounded-full bg-green-500/20 p-4">
                                <svg class="h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">You're All Set!</h3>
                        <p class="text-gray-400">
                            You already own all available training programs. Check your dashboard to access your content.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>