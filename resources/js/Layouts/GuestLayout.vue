<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="relative min-h-screen">
        <!-- Topographic Map SVG Pattern Background inspired by the example image -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="absolute inset-0">
                <defs>
                    <pattern id="topo-pattern" x="0" y="0" width="800" height="800" patternUnits="userSpaceOnUse">
                        <g fill="none" stroke="#f97316" stroke-width="0.5" opacity="0.2">
                            <!-- Central elevation with many contour lines -->
                            <path d="M400,400 C420,380 450,390 480,400 S520,420 540,410 S580,390 600,400 S630,420 650,410" />
                            <path d="M390,390 C410,370 445,380 475,390 S515,410 535,400 S575,380 595,390 S625,410 645,400" />
                            <path d="M380,380 C400,360 440,370 470,380 S510,400 530,390 S570,370 590,380 S620,400 640,390" />
                            <path d="M370,370 C390,350 435,360 465,370 S505,390 525,380 S565,360 585,370 S615,390 635,380" />
                            <path d="M360,360 C380,340 430,350 460,360 S500,380 520,370 S560,350 580,360 S610,380 630,370" />
                            <path d="M350,350 C370,330 425,340 455,350 S495,370 515,360 S555,340 575,350 S605,370 625,360" />
                            <path d="M340,340 C360,320 420,330 450,340 S490,360 510,350 S550,330 570,340 S600,360 620,350" />
                            <path d="M330,330 C350,310 415,320 445,330 S485,350 505,340 S545,320 565,330 S595,350 615,340" />
                            <path d="M320,320 C340,300 410,310 440,320 S480,340 500,330 S540,310 560,320 S590,340 610,330" />
                            <path d="M310,310 C330,290 405,300 435,310 S475,330 495,320 S535,300 555,310 S585,330 605,320" />
                            
                            <!-- Second elevation area -->
                            <path d="M150,200 C170,190 190,195 210,205 S240,220 260,210 S280,190 300,200 S330,210 350,200" />
                            <path d="M160,210 C180,200 200,205 220,215 S250,230 270,220 S290,200 310,210 S340,220 360,210" />
                            <path d="M170,220 C190,210 210,215 230,225 S260,240 280,230 S300,210 320,220 S350,230 370,220" />
                            <path d="M180,230 C200,220 220,225 240,235 S270,250 290,240 S310,220 330,230 S360,240 380,230" />
                            <path d="M190,240 C210,230 230,235 250,245 S280,260 300,250 S320,230 340,240 S370,250 390,240" />
                            
                            <!-- Third elevation area -->
                            <path d="M500,150 C520,140 540,145 560,155 S590,170 610,160 S630,140 650,150 S680,160 700,150" />
                            <path d="M510,160 C530,150 550,155 570,165 S600,180 620,170 S640,150 660,160 S690,170 710,160" />
                            <path d="M520,170 C540,160 560,165 580,175 S610,190 630,180 S650,160 670,170 S700,180 720,170" />
                            <path d="M530,180 C550,170 570,175 590,185 S620,200 640,190 S660,170 680,180 S710,190 730,180" />
                            
                            <!-- Valley lines -->
                            <path d="M100,300 C150,320 200,310 250,300 S350,280 400,290 S500,310 550,300 S650,280 700,290" />
                            <path d="M100,320 C150,340 200,330 250,320 S350,300 400,310 S500,330 550,320 S650,300 700,310" />
                            <path d="M100,340 C150,360 200,350 250,340 S350,320 400,330 S500,350 550,340 S650,320 700,330" />
                            
                            <!-- Ridge lines -->
                            <path d="M200,100 C250,80 300,90 350,100 S450,120 500,110 S600,90 650,100 S750,120 800,110" />
                            <path d="M200,120 C250,100 300,110 350,120 S450,140 500,130 S600,110 650,120 S750,140 800,130" />
                            <path d="M200,140 C250,120 300,130 350,140 S450,160 500,150 S600,130 650,140 S750,160 800,150" />
                            
                            <!-- Additional contour shapes -->
                            <ellipse cx="300" cy="500" rx="50" ry="40" />
                            <ellipse cx="300" cy="500" rx="40" ry="30" />
                            <ellipse cx="300" cy="500" rx="30" ry="20" />
                            <ellipse cx="300" cy="500" rx="20" ry="10" />
                            
                            <ellipse cx="600" cy="600" rx="60" ry="50" />
                            <ellipse cx="600" cy="600" rx="50" ry="40" />
                            <ellipse cx="600" cy="600" rx="40" ry="30" />
                            <ellipse cx="600" cy="600" rx="30" ry="20" />
                            
                            <!-- More organic contour lines -->
                            <path d="M50,500 C100,520 150,510 200,490 S300,460 350,480 S450,510 500,490 S600,460 650,480 S750,510 800,490" />
                            <path d="M50,520 C100,540 150,530 200,510 S300,480 350,500 S450,530 500,510 S600,480 650,500 S750,530 800,510" />
                            <path d="M50,540 C100,560 150,550 200,530 S300,500 350,520 S450,550 500,530 S600,500 650,520 S750,550 800,530" />
                            <path d="M50,560 C100,580 150,570 200,550 S300,520 350,540 S450,570 500,550 S600,520 650,540 S750,570 800,550" />
                            
                            <!-- Detailed areas with tight contour lines -->
                            <path d="M100,700 C120,705 140,700 160,695 S200,685 220,690 S260,700 280,695" />
                            <path d="M100,710 C120,715 140,710 160,705 S200,695 220,700 S260,710 280,705" />
                            <path d="M100,720 C120,725 140,720 160,715 S200,705 220,710 S260,720 280,715" />
                            <path d="M100,730 C120,735 140,730 160,725 S200,715 220,720 S260,730 280,725" />
                            <path d="M100,740 C120,745 140,740 160,735 S200,725 220,730 S260,740 280,735" />
                        </g>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#topo-pattern)" />
            </svg>
        </div>

        <!-- Content Container with Dark Background -->
        <div
            class="relative flex min-h-screen flex-col items-center bg-gray-900 pt-6 sm:justify-center sm:pt-0"
        >
            <div class="z-10">
                <Link href="/">
                    <div class="flex flex-col items-center">
                        <ApplicationLogo class="h-20 w-20 fill-current text-orange-500" />
                        <h1 class="mt-2 text-2xl font-bold text-white">FieldEngineer Pro</h1>
                    </div>
                </Link>
            </div>

            <div
                class="mt-6 w-full overflow-hidden bg-gray-800 bg-opacity-50 border border-gray-700 px-6 py-4 shadow-md backdrop-blur-sm sm:max-w-md sm:rounded-lg z-10"
            >
                <slot />
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Subtle animation for the topographic map */
@keyframes topo-shift {
    0% {
        transform: translate(0, 0);
    }
    50% {
        transform: translate(-10px, 5px);
    }
    100% {
        transform: translate(0, 0);
    }
}

.absolute.inset-0.overflow-hidden {
    animation: topo-shift 60s ease-in-out infinite;
}

/* Set proper background color */
.bg-gray-900 {
    background-color: #111827;
}
</style>
