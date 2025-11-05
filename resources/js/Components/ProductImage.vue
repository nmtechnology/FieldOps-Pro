<template>
    <!-- Artificial Book Design for Field Operations Guide -->
    <div v-if="isArtificialBook" class="relative w-full h-full flex justify-center items-center">
        <!-- Small/Icon Version (for tables, etc.) -->
        <div v-if="isIconSize" class="relative w-full h-full max-w-12 max-h-12">
            <div class="relative z-20 bg-gradient-to-br from-slate-800 via-slate-900 to-slate-800 rounded shadow-lg w-full h-full">
                <div class="relative overflow-hidden rounded w-full h-full">
                    <!-- Book Cover Pattern -->
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 via-transparent to-orange-400/10"></div>
                    
                    <!-- Book Spine Effect -->
                    <div class="absolute left-0 top-0 w-0.5 h-full bg-gradient-to-b from-slate-600 via-slate-700 to-slate-600 rounded-l"></div>
                    
                    <!-- Mini Book Content -->
                    <div class="relative p-1 flex flex-col justify-center h-full">
                        <!-- Title -->
                        <div class="text-center">
                            <div class="text-orange-400 font-bold text-xs leading-none">FIELD</div>
                            <div class="text-white font-bold text-xs leading-none">OPS</div>
                            <div class="text-orange-300 font-bold text-xs leading-none">GUIDE</div>
                        </div>
                    </div>
                </div>
                
                <!-- Mini Book Pages Edge -->
                <div class="absolute -right-0.5 top-0.5 bottom-0.5 w-0.5 bg-gradient-to-r from-gray-100 to-gray-200 rounded-r opacity-80"></div>
            </div>
        </div>
        
        <!-- Full Version (for large displays) -->
        <div v-else class="relative w-44 sm:w-56 md:w-72 lg:w-auto max-w-xs mx-auto book-container isolate">
            <!-- Cosmic nebula backdrop -->
            <div class="absolute -inset-6 sm:-inset-8 md:-inset-10 bg-gradient-to-br from-indigo-600/30 via-purple-500/20 to-violet-400/30 rounded-full blur-3xl opacity-60 animate-nebula-pulse"></div>
            <div class="absolute -inset-12 sm:-inset-16 md:-inset-20 bg-gradient-to-tr from-purple-500/15 via-white/10 to-blue-400/15 rounded-full blur-3xl opacity-40 animate-cosmic-drift"></div>
            <div class="absolute -inset-3 sm:-inset-4 md:-inset-5 bg-gradient-to-r from-violet-500/20 to-indigo-400/15 rounded-2xl blur-xl opacity-70 mix-blend-screen"></div>
            
            <!-- Book Cover with 3D effect -->
            <div class="relative z-20 bg-gradient-to-br from-slate-800 via-slate-900 to-slate-800 rounded-lg shadow-2xl transform perspective-1000 rotate-y-12 hover:rotate-y-6 transition-all duration-700 hover:scale-105">
                <div class="relative overflow-hidden rounded-lg">
                    <!-- Book Cover Pattern -->
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-600/20 via-transparent to-orange-400/10"></div>
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(251,191,36,0.15),transparent_50%)]"></div>
                    
                    <!-- Book Spine Effect -->
                    <div class="absolute left-0 top-0 w-2 h-full bg-gradient-to-b from-slate-600 via-slate-700 to-slate-600 rounded-l-lg"></div>
                    
                    <!-- Book Content -->
                    <div class="relative p-6 sm:p-8 md:p-10">
                        <!-- Title -->
                        <div class="text-center space-y-2 sm:space-y-3 md:space-y-4">
                            <div class="text-orange-400 font-bold text-lg sm:text-xl md:text-2xl leading-tight tracking-wide">
                                FIELD
                            </div>
                            <div class="text-white font-bold text-lg sm:text-xl md:text-2xl leading-tight tracking-wide">
                                OPERATIONS
                            </div>
                            <div class="text-orange-300 font-bold text-lg sm:text-xl md:text-2xl leading-tight tracking-wide">
                                GUIDE
                            </div>
                        </div>
                        
                        <!-- Decorative Line -->
                        <div class="my-4 sm:my-6 md:my-8 flex justify-center">
                            <div class="w-16 sm:w-20 md:w-24 h-px bg-gradient-to-r from-transparent via-orange-400 to-transparent"></div>
                        </div>
                        
                        <!-- Subtitle -->
                        <div class="text-center text-xs sm:text-sm md:text-base text-gray-300 leading-relaxed">
                            Professional Excellence<br/>
                            in Field Engineering
                        </div>
                        
                        <!-- Professional Badge -->
                        <div class="mt-4 sm:mt-6 md:mt-8 text-center">
                            <div class="inline-block px-3 sm:px-4 py-1 sm:py-2 bg-gradient-to-r from-orange-600/20 to-orange-400/20 border border-orange-500/30 rounded-full">
                                <span class="text-orange-300 font-semibold text-xs sm:text-sm">PROFESSIONAL EDITION</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Book Pages Edge -->
                <div class="absolute -right-1 top-1 bottom-1 w-3 sm:w-4 bg-gradient-to-r from-gray-100 via-white to-gray-200 rounded-r-lg border-l border-gray-300"></div>
                <div class="absolute -right-2 top-2 bottom-2 w-3 sm:w-4 bg-gradient-to-r from-gray-200 via-gray-100 to-gray-300 rounded-r-lg opacity-60"></div>
            </div>
        </div>
    </div>
    
    <!-- Regular Product Image -->
    <img v-else :src="imageUrl" :alt="alt" :class="imageClass" />
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    product: {
        type: Object,
        required: true
    },
    alt: {
        type: String,
        default: ''
    },
    imageClass: {
        type: String,
        default: 'w-full h-full object-cover'
    }
});

const isArtificialBook = computed(() => {
    return props.product.image_path === 'artificial-book' || 
           props.product.image_url === 'artificial-book' ||
           (props.product.name && 
            props.product.name.toLowerCase().includes('field') && 
            props.product.name.toLowerCase().includes('guide'));
});

const isIconSize = computed(() => {
    // Check if the imageClass indicates a small/icon size
    return props.imageClass.includes('w-12') || 
           props.imageClass.includes('h-12') ||
           props.imageClass.includes('w-8') || 
           props.imageClass.includes('h-8') ||
           props.imageClass.includes('w-16') || 
           props.imageClass.includes('h-16') ||
           props.imageClass.includes('w-10') || 
           props.imageClass.includes('h-10');
});

const imageUrl = computed(() => {
    if (isArtificialBook.value) {
        return null; // Will use the artificial book design
    }
    
    // Return the product's image path/url or a simple fallback
    return props.product.image_url || props.product.image_path || '/img/default-product.jpg';
});
</script>

<style scoped>
/* Book Effect CSS */
.book-container {
    transform-style: preserve-3d;
}

.rotate-y-12 {
    transform: rotateY(12deg);
}

.rotate-y-6 {
    transform: rotateY(6deg);
}

.perspective-1000 {
    perspective: 1000px;
}

@keyframes nebula-pulse {
    0%, 100% { opacity: 0.6; transform: scale(1) rotate(0deg); }
    25% { opacity: 0.8; transform: scale(1.1) rotate(90deg); }
    50% { opacity: 0.4; transform: scale(0.9) rotate(180deg); }
    75% { opacity: 0.7; transform: scale(1.05) rotate(270deg); }
}

@keyframes cosmic-drift {
    0%, 100% { transform: translate(0, 0) rotate(0deg); opacity: 0.4; }
    25% { transform: translate(10px, -15px) rotate(90deg); opacity: 0.2; }
    50% { transform: translate(-5px, -10px) rotate(180deg); opacity: 0.6; }
    75% { transform: translate(-10px, 5px) rotate(270deg); opacity: 0.3; }
}

@keyframes cosmic-rays {
    0%, 100% { transform: scale(1) rotate(0deg); opacity: 0.2; }
    33% { transform: scale(1.1) rotate(120deg); opacity: 0.4; }
    66% { transform: scale(0.9) rotate(240deg); opacity: 0.1; }
}

.animate-nebula-pulse {
    animation: nebula-pulse 8s ease-in-out infinite;
}

.animate-cosmic-drift {
    animation: cosmic-drift 12s ease-in-out infinite;
}

.animate-cosmic-rays {
    animation: cosmic-rays 10s linear infinite;
}
</style>