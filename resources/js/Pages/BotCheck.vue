<template>
    <div class="bot-check-container">
        <!-- 8-bit Background -->
        <div class="pixel-bg"></div>
        
        <!-- Main Content -->
        <div class="verification-card">
            <!-- Robot Icon -->
            <div class="robot-icon">
                <svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" class="robot-svg">
                    <!-- Antenna -->
                    <rect x="38" y="8" width="4" height="8" fill="#94a3b8"/>
                    <circle cx="40" cy="6" r="4" fill="#f97316"/>
                    
                    <!-- Robot Head -->
                    <rect x="24" y="16" width="32" height="28" fill="#64748b" stroke="#334155" stroke-width="2"/>
                    <rect x="26" y="18" width="28" height="24" fill="#475569"/>
                    
                    <!-- Eyes -->
                    <rect x="30" y="24" width="8" height="8" :fill="eyeColor" class="eye"/>
                    <rect x="42" y="24" width="8" height="8" :fill="eyeColor" class="eye"/>
                    
                    <!-- Mouth -->
                    <rect x="32" y="36" width="16" height="3" fill="#1e293b"/>
                    
                    <!-- Body -->
                    <rect x="28" y="44" width="24" height="20" fill="#64748b" stroke="#334155" stroke-width="2"/>
                    
                    <!-- Chest Panel -->
                    <rect x="34" y="50" width="12" height="8" fill="#1e293b"/>
                    <circle cx="40" cy="54" r="2" fill="#22c55e" class="status-light"/>
                    
                    <!-- Arms -->
                    <rect x="18" y="48" width="10" height="6" fill="#64748b"/>
                    <rect x="52" y="48" width="10" height="6" fill="#64748b"/>
                    
                    <!-- Legs -->
                    <rect x="30" y="64" width="8" height="12" fill="#64748b"/>
                    <rect x="42" y="64" width="8" height="12" fill="#64748b"/>
                </svg>
            </div>
            
            <!-- Title -->
            <h1 class="title">
                <span class="pixel-text">HUMAN VERIFICATION</span>
            </h1>
            
            <p class="subtitle">
                Prove you're not a robot by solving this math problem
            </p>
            
            <!-- Math Problem -->
            <div class="math-problem">
                <div class="equation">
                    <span class="number">{{ num1 }}</span>
                    <span class="operator">+</span>
                    <span class="number">{{ num2 }}</span>
                    <span class="operator">=</span>
                    <span class="question">?</span>
                </div>
            </div>
            
            <!-- Answer Input -->
            <div class="answer-section">
                <input
                    ref="answerInput"
                    v-model="userAnswer"
                    type="number"
                    class="answer-input"
                    :class="{ 'shake': showError, 'correct': showSuccess }"
                    placeholder="Your answer"
                    @keyup.enter="checkAnswer"
                    @input="showError = false"
                    :disabled="showSuccess"
                />
                
                <button
                    @click="checkAnswer"
                    class="verify-button"
                    :class="{ 'success': showSuccess }"
                    :disabled="!userAnswer || showSuccess"
                >
                    <span v-if="!showSuccess">VERIFY</span>
                    <span v-else>✓ VERIFIED</span>
                </button>
            </div>
            
            <!-- Error Message -->
            <transition name="fade">
                <div v-if="showError" class="error-message">
                    <span class="pixel-text-small">❌ Incorrect! Try again.</span>
                </div>
            </transition>
            
            <!-- Attempts Counter -->
            <div class="attempts">
                Attempts: {{ attempts }}/3
            </div>
            
            <!-- Security Notice -->
            <div class="security-notice">
                <svg class="shield-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.682-.057-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z" clip-rule="evenodd" />
                </svg>
                <span>This verification protects against automated bots</span>
            </div>
        </div>
        
        <!-- Decorative Pixels -->
        <div class="floating-pixels">
            <div v-for="n in 20" :key="n" class="pixel" :style="getPixelStyle(n)"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BotCheck',
    data() {
        return {
            num1: 0,
            num2: 0,
            userAnswer: '',
            attempts: 0,
            showError: false,
            showSuccess: false,
            eyeColor: '#3b82f6'
        };
    },
    mounted() {
        this.generateMathProblem();
        this.$refs.answerInput.focus();
        
        // Animate robot eyes
        setInterval(() => {
            this.eyeColor = this.eyeColor === '#3b82f6' ? '#60a5fa' : '#3b82f6';
        }, 1000);
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
                this.eyeColor = '#22c55e';
                
                // Wait a moment, then set session and redirect
                setTimeout(() => {
                    // Set session via POST
                    fetch('/verify', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    }).then(() => {
                        // Redirect to home page (loading screen will show from app.js)
                        window.location.href = '/home';
                    });
                }, 1000);
            } else {
                this.showError = true;
                this.eyeColor = '#ef4444';
                
                // Reset after animation
                setTimeout(() => {
                    this.showError = false;
                    this.userAnswer = '';
                    this.eyeColor = '#3b82f6';
                    
                    // Generate new problem if too many attempts
                    if (this.attempts >= 3) {
                        this.generateMathProblem();
                        this.attempts = 0;
                    }
                }, 1500);
            }
        },
        getPixelStyle(n) {
            return {
                left: Math.random() * 100 + '%',
                top: Math.random() * 100 + '%',
                animationDelay: Math.random() * 3 + 's',
                animationDuration: (Math.random() * 3 + 2) + 's'
            };
        }
    }
};
</script>

<style scoped>
.bot-check-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    padding: 20px;
    position: relative;
    overflow: hidden;
}

.pixel-bg {
    position: absolute;
    inset: 0;
    background-image: 
        repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(249, 115, 22, 0.03) 2px, rgba(249, 115, 22, 0.03) 4px),
        repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(249, 115, 22, 0.03) 2px, rgba(249, 115, 22, 0.03) 4px);
}

.verification-card {
    background: rgba(30, 41, 59, 0.9);
    backdrop-filter: blur(10px);
    border: 3px solid #f97316;
    border-radius: 20px;
    padding: 40px;
    max-width: 500px;
    width: 100%;
    text-align: center;
    position: relative;
    z-index: 10;
    box-shadow: 0 20px 60px rgba(249, 115, 22, 0.3);
}

.robot-icon {
    margin: 0 auto 30px;
    width: 80px;
    height: 80px;
}

.robot-svg {
    width: 100%;
    height: 100%;
    image-rendering: pixelated;
    filter: drop-shadow(0 4px 8px rgba(249, 115, 22, 0.3));
}

.eye {
    transition: fill 0.3s ease;
}

.status-light {
    animation: blink 2s ease-in-out infinite;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

.title {
    margin: 0 0 10px 0;
}

.pixel-text {
    font-family: 'Courier New', monospace;
    font-size: 2rem;
    font-weight: bold;
    color: #f97316;
    text-shadow: 3px 3px 0 rgba(0, 0, 0, 0.5);
    letter-spacing: 3px;
}

.subtitle {
    color: #cbd5e1;
    font-size: 1rem;
    margin: 0 0 30px 0;
}

.math-problem {
    background: #0f172a;
    border: 2px solid #475569;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 30px;
}

.equation {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    font-family: 'Courier New', monospace;
    font-size: 3rem;
    font-weight: bold;
}

.number {
    color: #60a5fa;
    text-shadow: 2px 2px 0 rgba(0, 0, 0, 0.5);
}

.operator {
    color: #f97316;
}

.question {
    color: #fbbf24;
    animation: pulse 1.5s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.2); opacity: 0.7; }
}

.answer-section {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.answer-input {
    flex: 1;
    padding: 16px 20px;
    font-size: 1.5rem;
    font-family: 'Courier New', monospace;
    font-weight: bold;
    text-align: center;
    background: #0f172a;
    border: 3px solid #475569;
    border-radius: 12px;
    color: #ffffff;
    transition: all 0.3s ease;
}

.answer-input:focus {
    outline: none;
    border-color: #f97316;
    box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
}

.answer-input.shake {
    animation: shake 0.5s ease-in-out;
    border-color: #ef4444;
}

.answer-input.correct {
    border-color: #22c55e;
    background: rgba(34, 197, 94, 0.1);
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-10px); }
    75% { transform: translateX(10px); }
}

.verify-button {
    padding: 16px 32px;
    font-family: 'Courier New', monospace;
    font-size: 1.25rem;
    font-weight: bold;
    letter-spacing: 2px;
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);
}

.verify-button:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(249, 115, 22, 0.6);
}

.verify-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.verify-button.success {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4);
}

.error-message {
    margin-bottom: 10px;
}

.pixel-text-small {
    font-family: 'Courier New', monospace;
    font-size: 1rem;
    font-weight: bold;
    color: #ef4444;
    text-shadow: 2px 2px 0 rgba(0, 0, 0, 0.5);
}

.attempts {
    color: #94a3b8;
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
    margin-bottom: 20px;
}

.security-notice {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px;
    background: rgba(100, 116, 139, 0.2);
    border-radius: 8px;
    color: #94a3b8;
    font-size: 0.75rem;
}

.shield-icon {
    width: 16px;
    height: 16px;
    color: #f97316;
}

.floating-pixels {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.pixel {
    position: absolute;
    width: 8px;
    height: 8px;
    background: #f97316;
    opacity: 0.2;
    animation: float-pixel linear infinite;
}

@keyframes float-pixel {
    0% {
        transform: translateY(0) rotate(0deg);
        opacity: 0;
    }
    50% {
        opacity: 0.4;
    }
    100% {
        transform: translateY(-100vh) rotate(360deg);
        opacity: 0;
    }
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

/* Responsive */
@media (max-width: 640px) {
    .verification-card {
        padding: 30px 20px;
    }
    
    .pixel-text {
        font-size: 1.5rem;
    }
    
    .equation {
        font-size: 2rem;
        gap: 15px;
    }
    
    .answer-section {
        flex-direction: column;
    }
}
</style>
