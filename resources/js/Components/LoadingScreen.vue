<template>
    <div v-if="show" class="loading-screen">
        <div class="game-container">
            <!-- Score/Loading Text -->
            <div class="loading-text">
                <h2 class="pixel-text">LOADING...</h2>
                <div class="loading-bar">
                    <div class="loading-bar-fill"></div>
                </div>
            </div>

            <!-- Game Scene -->
            <div class="game-scene">
                <!-- Sky Background -->
                <div class="sky"></div>
                
                <!-- Clouds -->
                <div class="cloud cloud-1"></div>
                <div class="cloud cloud-2"></div>
                <div class="cloud cloud-3"></div>
                
                <!-- Character (Running and Jumping) -->
                <div class="character" :class="{ jumping: isJumping }">
                    <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" class="character-sprite">
                        <!-- Hard Hat (Orange) -->
                        <rect x="20" y="14" width="24" height="4" fill="#f97316"/>
                        <rect x="18" y="18" width="28" height="2" fill="#ea580c"/>
                        <rect x="24" y="12" width="16" height="2" fill="#fb923c"/>
                        
                        <!-- Face/Head -->
                        <rect x="22" y="20" width="20" height="4" fill="#ffd4a3"/>
                        <rect x="20" y="24" width="24" height="8" fill="#ffd4a3"/>
                        
                        <!-- Mustache -->
                        <rect x="24" y="28" width="4" height="2" fill="#78350f"/>
                        <rect x="36" y="28" width="4" height="2" fill="#78350f"/>
                        <rect x="22" y="30" width="20" height="2" fill="#78350f"/>
                        
                        <!-- Eyes -->
                        <rect x="24" y="24" width="4" height="4" fill="#ffffff"/>
                        <rect x="36" y="24" width="4" height="4" fill="#ffffff"/>
                        <rect x="26" y="26" width="2" height="2" fill="#000000"/>
                        <rect x="38" y="26" width="2" height="2" fill="#000000"/>
                        
                        <!-- Body - Orange Work Shirt -->
                        <rect x="20" y="32" width="24" height="4" fill="#f97316"/>
                        <rect x="18" y="36" width="28" height="8" fill="#f97316"/>
                        
                        <!-- Overall Straps -->
                        <rect x="24" y="32" width="4" height="12" fill="#3b82f6"/>
                        <rect x="36" y="32" width="4" height="12" fill="#3b82f6"/>
                        
                        <!-- Buttons -->
                        <rect x="26" y="34" width="2" height="2" fill="#fbbf24"/>
                        <rect x="38" y="34" width="2" height="2" fill="#fbbf24"/>
                        
                        <!-- Blue Overalls -->
                        <rect x="22" y="44" width="20" height="8" fill="#3b82f6"/>
                        <rect x="20" y="46" width="24" height="4" fill="#2563eb"/>
                        
                        <!-- Arms (animated) -->
                        <rect x="14" y="36" width="4" height="8" fill="#ffd4a3" class="arm-left"/>
                        <rect x="46" y="36" width="4" height="8" fill="#ffd4a3" class="arm-right"/>
                        
                        <!-- Legs (animated) -->
                        <g class="legs">
                            <rect x="22" y="52" width="8" height="4" fill="#2563eb"/>
                            <rect x="34" y="52" width="8" height="4" fill="#2563eb"/>
                            <rect x="22" y="56" width="8" height="4" fill="#78350f"/>
                            <rect x="34" y="56" width="8" height="4" fill="#78350f"/>
                        </g>
                    </svg>
                </div>
                
                <!-- Obstacles (Mean Laptops) -->
                <div v-for="(laptop, index) in laptops" :key="'laptop-' + index" class="obstacle" :style="{ left: laptop.position + 'px' }">
                    <svg viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" class="laptop-sprite">
                        <!-- Laptop Screen -->
                        <rect x="8" y="4" width="32" height="24" fill="#1e293b" stroke="#f97316" stroke-width="2"/>
                        <rect x="10" y="6" width="28" height="20" fill="#0f172a"/>
                        
                        <!-- Mean Face -->
                        <rect x="16" y="12" width="4" height="4" fill="#ef4444"/>
                        <rect x="28" y="12" width="4" height="4" fill="#ef4444"/>
                        <path d="M16 20 L20 18 L24 20 L28 18 L32 20" stroke="#ef4444" stroke-width="2" fill="none"/>
                        
                        <!-- Angry Eyebrows -->
                        <rect x="14" y="10" width="6" height="2" fill="#ef4444" transform="rotate(-20 17 11)"/>
                        <rect x="28" y="10" width="6" height="2" fill="#ef4444" transform="rotate(20 31 11)"/>
                        
                        <!-- Laptop Base -->
                        <rect x="4" y="28" width="40" height="4" fill="#475569"/>
                        <rect x="6" y="32" width="36" height="2" fill="#334155"/>
                    </svg>
                </div>
                
                <!-- Ground (Moving Bricks) -->
                <div class="ground">
                    <div class="bricks" :style="{ transform: 'translateX(' + brickOffset + 'px)' }">
                        <div v-for="n in 30" :key="n" class="brick"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'LoadingScreen',
    props: {
        show: {
            type: Boolean,
            default: true
        }
    },
    data() {
        return {
            isJumping: false,
            brickOffset: 0,
            laptops: [
                { position: 600 },
                { position: 1100 },
                { position: 1600 }
            ],
            animationFrame: null
        };
    },
    mounted() {
        this.startAnimation();
    },
    beforeUnmount() {
        if (this.animationFrame) {
            cancelAnimationFrame(this.animationFrame);
        }
    },
    methods: {
        startAnimation() {
            const animate = () => {
                // Move bricks
                this.brickOffset -= 3;
                if (this.brickOffset <= -64) {
                    this.brickOffset = 0;
                }
                
                // Move laptops
                this.laptops = this.laptops.map(laptop => {
                    let newPos = laptop.position - 5;
                    if (newPos < -100) {
                        newPos = 800 + Math.random() * 400;
                    }
                    return { position: newPos };
                });
                
                // Auto jump when laptop approaches
                const characterPosition = 200; // Character is at 200px from left
                const nearbyLaptop = this.laptops.find(laptop => 
                    laptop.position > characterPosition - 50 && 
                    laptop.position < characterPosition + 100
                );
                
                if (nearbyLaptop && !this.isJumping) {
                    this.jump();
                }
                
                this.animationFrame = requestAnimationFrame(animate);
            };
            
            animate();
        },
        jump() {
            this.isJumping = true;
            setTimeout(() => {
                this.isJumping = false;
            }, 600);
        }
    }
};
</script>

<style scoped>
.loading-screen {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, #5eade2 0%, #5eade2 70%, #f4a460 70%, #d2691e 100%);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.game-container {
    width: 100%;
    height: 100%;
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    overflow: hidden;
}

.loading-text {
    position: absolute;
    top: 40px;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    z-index: 100;
}

.pixel-text {
    font-family: 'Courier New', monospace;
    font-size: 2.5rem;
    font-weight: bold;
    color: #ffffff;
    text-shadow: 4px 4px 0 #000000;
    letter-spacing: 4px;
    animation: pulse 1s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.loading-bar {
    width: 300px;
    height: 20px;
    background: #1e293b;
    border: 3px solid #f97316;
    margin: 20px auto;
    position: relative;
    overflow: hidden;
}

.loading-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #f97316 0%, #fbbf24 100%);
    animation: loading 2s ease-in-out infinite;
}

@keyframes loading {
    0% { width: 0%; }
    50% { width: 100%; }
    100% { width: 0%; }
}

.game-scene {
    width: 100%;
    height: 100%;
    position: relative;
}

.sky {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 70%;
    background: linear-gradient(to bottom, #5eade2 0%, #87ceeb 100%);
}

.cloud {
    position: absolute;
    width: 80px;
    height: 40px;
    background: white;
    border-radius: 40px;
    opacity: 0.8;
}

.cloud::before,
.cloud::after {
    content: '';
    position: absolute;
    background: white;
    border-radius: 50%;
}

.cloud::before {
    width: 40px;
    height: 40px;
    top: -20px;
    left: 10px;
}

.cloud::after {
    width: 50px;
    height: 50px;
    top: -25px;
    right: 10px;
}

.cloud-1 {
    top: 80px;
    animation: float 20s linear infinite;
}

.cloud-2 {
    top: 140px;
    animation: float 25s linear infinite;
    animation-delay: -10s;
}

.cloud-3 {
    top: 100px;
    animation: float 18s linear infinite;
    animation-delay: -5s;
}

@keyframes float {
    from { left: -100px; }
    to { left: 100%; }
}

.character {
    position: absolute;
    bottom: 150px;
    left: 200px;
    width: 64px;
    height: 64px;
    transition: bottom 0.3s ease-out;
    z-index: 10;
}

.character.jumping {
    bottom: 280px;
    animation: jumpRotate 0.6s ease-in-out;
}

@keyframes jumpRotate {
    0% { transform: rotate(0deg); }
    50% { transform: rotate(360deg); }
    100% { transform: rotate(360deg); }
}

.character-sprite {
    width: 100%;
    height: 100%;
    image-rendering: pixelated;
    image-rendering: -moz-crisp-edges;
    image-rendering: crisp-edges;
}

.character-sprite .legs {
    animation: run 0.3s steps(2) infinite;
}

@keyframes run {
    0% { transform: translateX(0); }
    50% { transform: translateX(2px); }
    100% { transform: translateX(0); }
}

.obstacle {
    position: absolute;
    bottom: 150px;
    width: 48px;
    height: 48px;
    z-index: 5;
}

.laptop-sprite {
    width: 100%;
    height: 100%;
    image-rendering: pixelated;
    animation: shake 0.5s ease-in-out infinite;
}

@keyframes shake {
    0%, 100% { transform: rotate(-2deg); }
    50% { transform: rotate(2deg); }
}

.ground {
    position: absolute;
    bottom: 80px;
    left: 0;
    right: 0;
    height: 70px;
    background: #8b4513;
    border-top: 4px solid #654321;
    overflow: hidden;
}

.bricks {
    display: flex;
    height: 100%;
    will-change: transform;
}

.brick {
    min-width: 64px;
    height: 64px;
    background: #d2691e;
    border: 2px solid #8b4513;
    box-shadow: inset 0 0 0 2px #cd853f;
    position: relative;
}

.brick::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background: #8b4513;
}

.brick::after {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 50%;
    width: 2px;
    background: #8b4513;
}

/* Pixel perfect rendering */
* {
    image-rendering: pixelated;
    image-rendering: -moz-crisp-edges;
    image-rendering: crisp-edges;
}
</style>
