<script setup>
import { ref, computed, onMounted } from 'vue';

const props = defineProps({
    modelValue: String,
    disabled: Boolean
});

const emit = defineEmits(['update:modelValue', 'verified']);

// Puzzle state
const num1 = ref(0);
const num2 = ref(0);
const operation = ref('+');
const userAnswer = ref('');
const correctAnswer = ref(0);
const isCorrect = ref(null);
const attempts = ref(0);

// Generate a new puzzle
const generatePuzzle = () => {
    const operations = ['+', '-', '*'];
    operation.value = operations[Math.floor(Math.random() * operations.length)];
    
    // Generate numbers based on operation
    if (operation.value === '*') {
        // Smaller numbers for multiplication
        num1.value = Math.floor(Math.random() * 9) + 1;
        num2.value = Math.floor(Math.random() * 9) + 1;
    } else {
        // Larger numbers for addition/subtraction
        num1.value = Math.floor(Math.random() * 20) + 1;
        num2.value = Math.floor(Math.random() * 20) + 1;
    }
    
    // Calculate correct answer
    if (operation.value === '+') {
        correctAnswer.value = num1.value + num2.value;
    } else if (operation.value === '-') {
        correctAnswer.value = num1.value - num2.value;
    } else if (operation.value === '*') {
        correctAnswer.value = num1.value * num2.value;
    }
    
    userAnswer.value = '';
    isCorrect.value = null;
    attempts.value = 0;
};

// Check the answer
const checkAnswer = () => {
    attempts.value++;
    const answer = parseInt(userAnswer.value);
    
    if (answer === correctAnswer.value) {
        isCorrect.value = true;
        emit('verified', true);
    } else {
        isCorrect.value = false;
        if (attempts.value < 3) {
            userAnswer.value = '';
        }
    }
};

// Puzzle question display
const puzzleQuestion = computed(() => {
    return `${num1.value} ${operation.value} ${num2.value} = ?`;
});

// Initialize puzzle on mount
onMounted(() => {
    generatePuzzle();
});

// Handle enter key
const handleKeyup = (event) => {
    if (event.key === 'Enter' && userAnswer.value && !isCorrect.value) {
        checkAnswer();
    }
};
</script>

<template>
    <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 rounded-lg">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm2 4a1 1 0 11-2 0 1 1 0 012 0zm-7 0a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-medium text-blue-900 dark:text-blue-200 mb-3">
                    Security Check: Solve this math puzzle
                </h3>
                
                <div class="space-y-3">
                    <!-- Puzzle Display -->
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-700 dark:text-blue-300 font-mono mb-3">
                            {{ puzzleQuestion }}
                        </div>
                    </div>
                    
                    <!-- Answer Input -->
                    <div class="flex gap-2 items-center">
                        <input
                            type="text"
                            v-model="userAnswer"
                            @keyup="handleKeyup"
                            :disabled="isCorrect || disabled"
                            placeholder="Your answer"
                            class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent disabled:opacity-50 disabled:cursor-not-allowed"
                        />
                        <button
                            v-if="!isCorrect"
                            type="button"
                            @click="checkAnswer"
                            :disabled="!userAnswer || disabled"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors font-medium text-sm"
                        >
                            Check
                        </button>
                        <div v-else class="flex items-center gap-1 text-green-600 dark:text-green-400 font-medium">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Correct!</span>
                        </div>
                    </div>
                    
                    <!-- Feedback -->
                    <div v-if="isCorrect === false" class="text-sm text-red-600 dark:text-red-400">
                        <span v-if="attempts < 3">Incorrect. Try again ({{ 3 - attempts }} attempts remaining)</span>
                        <span v-else>Too many incorrect attempts. Please reload and try again.</span>
                    </div>
                    
                    <!-- New Puzzle Link -->
                    <div v-if="isCorrect" class="text-center">
                        <button
                            type="button"
                            @click="generatePuzzle"
                            class="text-xs text-blue-600 dark:text-blue-400 hover:underline"
                        >
                            Generate new puzzle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
