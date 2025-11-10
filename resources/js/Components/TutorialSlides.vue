<script setup>
import { ref, computed, watch, onMounted } from 'vue';

const props = defineProps({
    slides: Array,
    onComplete: Function,
});

const currentSlide = ref(0);
const displayedText = ref('');
const isTyping = ref(false);
const typingSpeed = ref(30); // milliseconds per character
const showQuiz = ref(false);
const selectedAnswer = ref(null);
const quizFeedback = ref('');
const canProceed = ref(true);
const slideAnswers = ref({});

// Typewriter effect
const typeText = (text, callback) => {
    isTyping.value = true;
    displayedText.value = '';
    let index = 0;

    const interval = setInterval(() => {
        if (index < text.length) {
            displayedText.value += text[index];
            index++;
        } else {
            clearInterval(interval);
            isTyping.value = false;
            if (callback) callback();
        }
    }, typingSpeed.value);
};

// Watch for slide changes
watch(currentSlide, (newSlide) => {
    const slide = props.slides[newSlide];
    showQuiz.value = false;
    selectedAnswer.value = null;
    quizFeedback.value = '';
    canProceed.value = !slide.quiz; // If has quiz, can't proceed until answered
    
    typeText(slide.text, () => {
        if (slide.quiz) {
            showQuiz.value = true;
        }
    });
});

// Initialize first slide
onMounted(() => {
    const slide = props.slides[0];
    typeText(slide.text, () => {
        if (slide.quiz) {
            showQuiz.value = true;
        }
    });
});

const currentSlideData = computed(() => props.slides[currentSlide.value]);
const progress = computed(() => ((currentSlide.value + 1) / props.slides.length) * 100);
const isLastSlide = computed(() => currentSlide.value === props.slides.length - 1);

const nextSlide = () => {
    if (!canProceed.value) {
        quizFeedback.value = 'Please answer the question before proceeding.';
        return;
    }
    
    if (currentSlide.value < props.slides.length - 1) {
        currentSlide.value++;
    } else {
        // Completed tutorial
        if (props.onComplete) {
            props.onComplete(slideAnswers.value);
        }
    }
};

const previousSlide = () => {
    if (currentSlide.value > 0) {
        currentSlide.value--;
    }
};

const skipTypewriter = () => {
    if (isTyping.value) {
        displayedText.value = currentSlideData.value.text;
        isTyping.value = false;
        if (currentSlideData.value.quiz) {
            showQuiz.value = true;
        }
    }
};

const submitAnswer = (answerIndex) => {
    selectedAnswer.value = answerIndex;
    const quiz = currentSlideData.value.quiz;
    const isCorrect = answerIndex === quiz.correctAnswer;
    
    // Store answer
    slideAnswers.value[currentSlide.value] = {
        question: quiz.question,
        selectedAnswer: answerIndex,
        correct: isCorrect,
    };
    
    if (isCorrect) {
        quizFeedback.value = quiz.correctFeedback || '✅ Correct! Great job!';
        canProceed.value = true;
    } else {
        quizFeedback.value = quiz.incorrectFeedback || '❌ Not quite. Review the slide and try again.';
        canProceed.value = false;
    }
};

const retryQuiz = () => {
    selectedAnswer.value = null;
    quizFeedback.value = '';
    canProceed.value = false;
};
</script>

<template>
    <div class="tutorial-container min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 p-6">
        <!-- Progress Bar -->
        <div class="max-w-5xl mx-auto mb-8">
            <div class="bg-gray-700 rounded-full h-3 overflow-hidden">
                <div 
                    class="bg-gradient-to-r from-orange-500 to-orange-400 h-full transition-all duration-500 ease-out"
                    :style="{ width: `${progress}%` }"
                ></div>
            </div>
            <div class="text-center text-gray-400 text-sm mt-2">
                Slide {{ currentSlide + 1 }} of {{ slides.length }}
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-5xl mx-auto bg-gray-800 rounded-2xl shadow-2xl border border-gray-700 overflow-hidden">
            <!-- Character & Slide Title -->
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 p-6 border-b border-gray-700">
                <div class="flex items-center gap-6">
                    <!-- 8-bit Character -->
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-orange-600 to-orange-500 p-1 shadow-lg shadow-orange-500/50">
                            <div class="w-full h-full rounded-full bg-gray-800 flex items-center justify-center overflow-hidden">
                                <img 
                                    src="/img/8bit-character.svg" 
                                    alt="Tutorial Guide" 
                                    class="w-20 h-20 object-contain pixelated"
                                    style="image-rendering: pixelated; image-rendering: -moz-crisp-edges; image-rendering: crisp-edges;"
                                />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-orange-400 mb-1">
                            {{ currentSlideData.title }}
                        </h2>
                        <p class="text-gray-400 text-sm">Your FieldOps Pro Guide</p>
                    </div>
                </div>
            </div>

            <!-- Dialogue Box -->
            <div class="p-8">
                <div class="bg-gray-900 rounded-xl border-2 border-orange-500/30 p-6 min-h-[300px] relative">
                    <!-- Typewriter Text -->
                    <div 
                        class="text-gray-200 text-lg leading-relaxed whitespace-pre-wrap"
                        @click="skipTypewriter"
                    >
                        {{ displayedText }}
                        <span v-if="isTyping" class="inline-block w-3 h-6 bg-orange-500 ml-1 animate-pulse"></span>
                    </div>
                    
                    <!-- Skip hint -->
                    <div v-if="isTyping" class="absolute bottom-4 right-4 text-xs text-gray-500 italic">
                        Click anywhere to skip typing...
                    </div>
                </div>

                <!-- Quiz Section -->
                <div v-if="showQuiz && currentSlideData.quiz" class="mt-6">
                    <div class="bg-gray-900 rounded-xl border-2 border-blue-500/30 p-6">
                        <h3 class="text-xl font-bold text-blue-400 mb-4">
                            📝 Quick Check
                        </h3>
                        <p class="text-gray-300 mb-4">{{ currentSlideData.quiz.question }}</p>
                        
                        <!-- Answer Options -->
                        <div class="space-y-3">
                            <button
                                v-for="(option, index) in currentSlideData.quiz.options"
                                :key="index"
                                @click="submitAnswer(index)"
                                :disabled="selectedAnswer !== null"
                                :class="[
                                    'w-full text-left p-4 rounded-lg border-2 transition-all duration-200',
                                    selectedAnswer === null 
                                        ? 'border-gray-600 hover:border-orange-500 hover:bg-gray-800 cursor-pointer'
                                        : selectedAnswer === index
                                            ? index === currentSlideData.quiz.correctAnswer
                                                ? 'border-green-500 bg-green-500/20'
                                                : 'border-red-500 bg-red-500/20'
                                            : index === currentSlideData.quiz.correctAnswer && selectedAnswer !== null
                                                ? 'border-green-500 bg-green-500/20'
                                                : 'border-gray-700 bg-gray-800/50 cursor-not-allowed opacity-50'
                                ]"
                            >
                                <span class="text-gray-200">{{ option }}</span>
                            </button>
                        </div>

                        <!-- Feedback -->
                        <div v-if="quizFeedback" class="mt-4 p-4 rounded-lg" :class="canProceed ? 'bg-green-500/20 border border-green-500' : 'bg-red-500/20 border border-red-500'">
                            <p class="text-white">{{ quizFeedback }}</p>
                            <button 
                                v-if="!canProceed"
                                @click="retryQuiz"
                                class="mt-3 px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white rounded-lg transition-colors"
                            >
                                Try Again
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <div class="bg-gray-900 p-6 border-t border-gray-700 flex justify-between items-center">
                <button
                    @click="previousSlide"
                    :disabled="currentSlide === 0"
                    :class="[
                        'px-6 py-3 rounded-lg font-semibold transition-all duration-200',
                        currentSlide === 0
                            ? 'bg-gray-700 text-gray-500 cursor-not-allowed'
                            : 'bg-gray-700 text-white hover:bg-gray-600'
                    ]"
                >
                    ← Previous
                </button>

                <button
                    @click="nextSlide"
                    :disabled="!canProceed"
                    :class="[
                        'px-6 py-3 rounded-lg font-semibold transition-all duration-200',
                        !canProceed
                            ? 'bg-gray-700 text-gray-500 cursor-not-allowed'
                            : isLastSlide
                                ? 'bg-green-600 hover:bg-green-500 text-white shadow-lg shadow-green-500/50'
                                : 'bg-gradient-to-r from-orange-600 to-orange-500 text-white hover:from-orange-500 hover:to-orange-600 shadow-lg shadow-orange-500/50'
                    ]"
                >
                    {{ isLastSlide ? 'Complete Tutorial 🎓' : 'Next →' }}
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.pixelated {
    image-rendering: pixelated;
    image-rendering: -moz-crisp-edges;
    image-rendering: crisp-edges;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
}

.animate-pulse {
    animation: pulse 1s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
