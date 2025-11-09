<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="relative min-h-screen bg-gradient-to-b from-gray-800 via-gray-900 to-black flex flex-col items-center pt-6 sm:justify-center sm:pt-0">
        <!-- Classic Topographic Map Background SVG -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none topo-animated">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="absolute inset-0">
                <defs>
                    <pattern id="topo-pattern" x="0" y="0" width="1000" height="1000" patternUnits="userSpaceOnUse">
                        <g fill="none" stroke="#f97316" opacity="0.2">
                            <!-- Central hill/mountain feature -->
                            <!-- Major contour lines (thicker) -->
                            <path d="M400,400 C450,380 500,350 550,380 C600,410 650,400 700,430 C750,460 800,450 850,420 C800,350 750,320 700,290 C650,260 600,250 550,220 C500,190 450,200 400,230 C350,260 300,250 250,280 C200,310 150,300 100,330 C150,360 200,350 250,380 C300,410 350,380 400,400 Z" stroke-width="1.2" />
                            <path d="M400,360 C440,345 480,325 520,345 C560,365 600,355 640,375 C680,395 720,385 760,365 C720,325 680,305 640,285 C600,265 560,260 520,240 C480,220 440,230 400,250 C360,270 320,265 280,285 C240,305 200,295 160,315 C200,335 240,325 280,345 C320,365 360,345 400,360 Z" stroke-width="1.2" />
                            <path d="M400,440 C460,415 520,375 580,415 C640,455 700,445 760,485 C820,525 880,515 940,475 C880,385 820,345 760,305 C700,265 640,250 580,210 C520,170 460,180 400,220 C340,260 280,245 220,285 C160,325 100,315 40,355 C100,395 160,385 220,425 C280,465 340,425 400,440 Z" stroke-width="1.2" />
                            
                            <!-- Standard contour lines -->
                            <path d="M400,380 C445,365 490,340 535,365 C580,390 625,380 670,405 C715,430 760,420 805,395 C760,340 715,315 670,290 C625,265 580,255 535,230 C490,205 445,215 400,240 C355,265 310,260 265,285 C220,310 175,300 130,325 C175,350 220,340 265,365 C310,390 355,365 400,380 Z" stroke-width="0.6" />
                            <path d="M400,370 C442,356 485,333 527,356 C569,379 611,370 653,393 C695,416 737,407 779,384 C737,333 695,310 653,287 C611,264 569,255 527,232 C485,209 442,218 400,241 C358,264 316,258 274,281 C232,304 190,295 148,318 C190,341 232,332 274,355 C316,378 358,356 400,370 Z" stroke-width="0.6" />
                            <path d="M400,390 C447,373 495,345 542,373 C589,401 636,390 683,418 C730,446 777,435 824,407 C777,347 730,321 683,295 C636,269 589,258 542,232 C495,206 447,217 400,243 C353,269 306,263 259,289 C212,315 165,304 118,332 C165,360 212,349 259,377 C306,405 353,377 400,390 Z" stroke-width="0.6" />
                            <path d="M400,410 C452,390 505,355 557,390 C609,425 661,412 713,447 C765,482 817,467 869,432 C817,357 765,327 713,297 C661,267 609,257 557,227 C505,197 452,212 400,242 C348,272 296,262 244,292 C192,322 140,307 88,342 C140,377 192,362 244,397 C296,432 348,390 400,410 Z" stroke-width="0.6" />
                            <path d="M400,420 C455,398 510,360 565,398 C620,436 675,422 730,460 C785,498 840,482 895,444 C840,364 785,331 730,299 C675,267 620,256 565,224 C510,192 455,209 400,241 C345,273 290,261 235,293 C180,325 125,309 70,347 C125,385 180,369 235,407 C290,445 345,398 400,420 Z" stroke-width="0.6" />
                            
                            <!-- Finer detail contour lines -->
                            <path d="M400,375 C443,361 487,338 530,361 C573,384 617,375 660,398 C703,421 747,412 790,389 C747,336 703,312 660,288 C617,264 573,255 530,231 C487,207 443,217 400,241 C357,265 313,258 270,282 C227,306 183,296 140,320 C183,344 227,334 270,358 C313,382 357,359 400,375 Z" stroke-width="0.5" />
                            <path d="M400,385 C445,369 490,343 535,369 C580,395 625,384 670,410 C715,436 760,425 805,399 C760,341 715,315 670,289 C625,263 580,253 535,227 C490,201 445,213 400,239 C355,265 310,259 265,285 C220,311 175,300 130,326 C175,352 220,341 265,367 C310,393 355,369 400,385 Z" stroke-width="0.5" />
                            <path d="M400,395 C448,377 497,347 545,377 C593,407 642,395 690,425 C738,455 787,443 835,413 C787,347 738,319 690,291 C642,263 593,252 545,224 C497,196 448,209 400,237 C352,265 303,258 255,286 C207,314 158,302 110,332 C158,362 207,350 255,380 C303,410 352,377 400,395 Z" stroke-width="0.5" />
                            <path d="M400,405 C451,385 502,350 553,385 C604,420 655,407 706,442 C757,477 808,463 859,428 C808,353 757,323 706,293 C655,263 604,253 553,223 C502,193 451,208 400,238 C349,268 298,258 247,288 C196,318 145,303 94,338 C145,373 196,358 247,393 C298,428 349,385 400,405 Z" stroke-width="0.5" />
                            
                            <!-- Left side hill/mountain -->
                            <path d="M200,650 C230,630 260,640 290,620 C320,600 350,610 380,590 C410,570 440,580 470,560 C440,540 410,530 380,510 C350,490 320,500 290,480 C260,460 230,470 200,450 C170,470 140,460 110,480 C80,500 50,490 20,510 C50,530 80,520 110,540 C140,560 170,550 200,570 C230,590 200,630 200,650 Z" stroke-width="1" />
                            <path d="M200,630 C225,615 250,623 275,608 C300,593 325,600 350,585 C375,570 400,578 425,563 C400,548 375,540 350,525 C325,510 300,518 275,503 C250,488 225,495 200,480 C175,495 150,488 125,503 C100,518 75,510 50,525 C75,540 100,533 125,548 C150,563 175,555 200,570 C225,585 200,615 200,630 Z" stroke-width="0.6" />
                            <path d="M200,600 C220,590 240,597 260,587 C280,577 300,583 320,573 C340,563 360,570 380,560 C360,550 340,545 320,535 C300,525 280,532 260,522 C240,512 220,518 200,508 C180,518 160,512 140,522 C120,532 100,525 80,535 C100,545 120,540 140,550 C160,560 180,555 200,565 C220,575 200,590 200,600 Z" stroke-width="0.5" />
                            
                            <!-- Right side hill/mountain -->
                            <path d="M750,200 C780,180 810,190 840,170 C870,150 900,160 930,140 C960,120 990,130 1020,110 C990,90 960,80 930,60 C900,40 870,50 840,30 C810,10 780,20 750,0 C720,20 690,10 660,30 C630,50 600,40 570,60 C600,80 630,70 660,90 C690,110 720,100 750,120 C780,140 750,180 750,200 Z" stroke-width="1" />
                            <path d="M750,180 C775,165 800,173 825,158 C850,143 875,150 900,135 C925,120 950,128 975,113 C950,98 925,90 900,75 C875,60 850,68 825,53 C800,38 775,45 750,30 C725,45 700,38 675,53 C650,68 625,60 600,75 C625,90 650,83 675,98 C700,113 725,105 750,120 C775,135 750,165 750,180 Z" stroke-width="0.6" />
                            <path d="M750,150 C770,140 790,147 810,137 C830,127 850,133 870,123 C890,113 910,120 930,110 C910,100 890,95 870,85 C850,75 830,82 810,72 C790,62 770,68 750,58 C730,68 710,62 690,72 C670,82 650,75 630,85 C650,95 670,90 690,100 C710,110 730,105 750,115 C770,125 750,140 750,150 Z" stroke-width="0.5" />
                            
                            <!-- Valley/stream feature with index lines -->
                            <path d="M100,100 L900,900" stroke-width="0.3" stroke-dasharray="5,5" />
                            <path d="M150,100 L950,900" stroke-width="0.3" stroke-dasharray="5,5" />
                            <path d="M100,150 L900,950" stroke-width="0.3" stroke-dasharray="5,5" />
                            
                            <path d="M100,500 C200,480 300,520 400,500 C500,480 600,520 700,500 C800,480 900,520 1000,500" stroke-width="0.6" />
                            <path d="M100,520 C200,500 300,540 400,520 C500,500 600,540 700,520 C800,500 900,540 1000,520" stroke-width="0.6" />
                            <path d="M100,540 C200,520 300,560 400,540 C500,520 600,560 700,540 C800,520 900,560 1000,540" stroke-width="0.6" />
                            <path d="M100,560 C200,540 300,580 400,560 C500,540 600,580 700,560 C800,540 900,580 1000,560" stroke-width="0.6" />
                            <path d="M100,580 C200,560 300,600 400,580 C500,560 600,600 700,580 C800,560 900,600 1000,580" stroke-width="0.6" />
                            
                            <!-- Reference markers (like survey points) -->
                            <path d="M250,250 L270,250 M260,240 L260,260" stroke-width="0.5" />
                            <path d="M650,350 L670,350 M660,340 L660,360" stroke-width="0.5" />
                            <path d="M350,750 L370,750 M360,740 L360,760" stroke-width="0.5" />
                            <path d="M750,650 L770,650 M760,640 L760,660" stroke-width="0.5" />
                            
                            <!-- Grid lines -->
                            <path d="M200,0 L200,1000" stroke-width="0.3" stroke-dasharray="2,8" />
                            <path d="M400,0 L400,1000" stroke-width="0.3" stroke-dasharray="2,8" />
                            <path d="M600,0 L600,1000" stroke-width="0.3" stroke-dasharray="2,8" />
                            <path d="M800,0 L800,1000" stroke-width="0.3" stroke-dasharray="2,8" />
                            
                            <path d="M0,200 L1000,200" stroke-width="0.3" stroke-dasharray="2,8" />
                            <path d="M0,400 L1000,400" stroke-width="0.3" stroke-dasharray="2,8" />
                            <path d="M0,600 L1000,600" stroke-width="0.3" stroke-dasharray="2,8" />
                            <path d="M0,800 L1000,800" stroke-width="0.3" stroke-dasharray="2,8" />
                   
                            <path d="M0,60 C40,55 80,70 120,60 C160,50 200,65 240,55 C280,45 320,60 360,50 C400,40 440,55 480,45" stroke-width="0.5" />
                            <path d="M0,65 C40,60 80,75 120,65 C160,55 200,70 240,60 C280,50 320,65 360,55 C400,45 440,60 480,50" stroke-width="0.5" />
                            <path d="M0,70 C40,65 80,80 120,70 C160,60 200,75 240,65 C280,55 320,70 360,60 C400,50 440,65 480,55" stroke-width="0.5" />
                            
                            <!-- Dense contour pattern cluster 2 - top right -->
                            <path d="M400,400 C420,380 450,390 480,400 S520,420 540,410 S580,390 600,400 S630,420 650,410" stroke-width="0.5" />
                            <path d="M390,390 C410,370 445,380 475,390 S515,410 535,400 S575,380 595,390 S625,410 645,400" stroke-width="0.5" />
                            <path d="M380,380 C400,360 440,370 470,380 S510,400 530,390 S570,370 590,380 S620,400 640,390" stroke-width="0.5" />
                            <path d="M370,370 C390,350 435,360 465,370 S505,390 525,380 S565,360 585,370 S615,390 635,380" stroke-width="0.5" />
                            <path d="M360,360 C380,340 430,350 460,360 S500,380 520,370 S560,350 580,360 S610,380 630,370" stroke-width="0.5" />
                            <path d="M350,350 C370,330 425,340 455,350 S495,370 515,360 S555,340 575,350 S605,370 625,360" stroke-width="0.5" />
                            <path d="M340,340 C360,320 420,330 450,340 S490,360 510,350 S550,330 570,340 S600,360 620,350" stroke-width="0.5" />
                            <path d="M330,330 C350,310 415,320 445,330 S485,350 505,340 S545,320 565,330 S595,350 615,340" stroke-width="0.5" />
                            <path d="M320,320 C340,300 410,310 440,320 S480,340 500,330 S540,310 560,320 S590,340 610,330" stroke-width="0.5" />
                            <path d="M310,310 C330,290 405,300 435,310 S475,330 495,320 S535,300 555,310 S585,330 605,320" stroke-width="0.5" />
                            
                            <!-- Second elevation area -->
                            <path d="M150,200 C170,190 190,195 210,205 S240,220 260,210 S280,190 300,200 S330,210 350,200" stroke-width="0.5" />
                            <path d="M160,210 C180,200 200,205 220,215 S250,230 270,220 S290,200 310,210 S340,220 360,210" stroke-width="0.5" />
                            <path d="M170,220 C190,210 210,215 230,225 S260,240 280,230 S300,210 320,220 S350,230 370,220" stroke-width="0.5" />
                            <path d="M180,230 C200,220 220,225 240,235 S270,250 290,240 S310,220 330,230 S360,240 380,230" stroke-width="0.5" />
                            <path d="M190,240 C210,230 230,235 250,245 S280,260 300,250 S320,230 340,240 S370,250 390,240" stroke-width="0.5" />
                            
                            <!-- Complex contour pattern in the center - main feature -->
                            <path d="M300,350 C320,320 340,330 360,300 C380,270 400,280 420,250 C440,220 460,230 480,200 C460,240 440,250 420,290 C400,330 380,340 360,380 C340,420 320,430 300,470 C280,430 260,420 240,380 C220,340 200,330 180,290 C160,250 140,240 120,200 C140,230 160,220 180,250 C200,280 220,270 240,300 C260,330 280,320 300,350 Z" stroke-width="0.5" />
                            <path d="M310,350 C330,320 350,330 370,300 C390,270 410,280 430,250 C450,220 470,230 490,200 C470,240 450,250 430,290 C410,330 390,340 370,380 C350,420 330,430 310,470 C290,430 270,420 250,380 C230,340 210,330 190,290 C170,250 150,240 130,200 C150,230 170,220 190,250 C210,280 230,270 250,300 C270,330 290,320 310,350 Z" stroke-width="0.5" />
                            <path d="M320,350 C340,320 360,330 380,300 C400,270 420,280 440,250 C460,220 480,230 500,200 C480,240 460,250 440,290 C420,330 400,340 380,380 C360,420 340,430 320,470 C300,430 280,420 260,380 C240,340 220,330 200,290 C180,250 160,240 140,200 C160,230 180,220 200,250 C220,280 240,270 260,300 C280,330 300,320 320,350 Z" stroke-width="0.5" />
                            <path d="M330,350 C350,320 370,330 390,300 C410,270 430,280 450,250 C470,220 490,230 510,200 C490,240 470,250 450,290 C430,330 410,340 390,380 C370,420 350,430 330,470 C310,430 290,420 270,380 C250,340 230,330 210,290 C190,250 170,240 150,200 C170,230 190,220 210,250 C230,280 250,270 270,300 C290,330 310,320 330,350 Z" stroke-width="0.5" />
                            <path d="M340,350 C360,320 380,330 400,300 C420,270 440,280 460,250 C480,220 500,230 520,200 C500,240 480,250 460,290 C440,330 420,340 400,380 C380,420 360,430 340,470 C320,430 300,420 280,380 C260,340 240,330 220,290 C200,250 180,240 160,200 C180,230 200,220 220,250 C240,280 260,270 280,300 C300,330 320,320 340,350 Z" stroke-width="0.5" />
                        </g>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#topo-pattern)" />
            </svg>
        </div>
        
        <!-- Logo -->
        <div class="z-10">
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-orange-500" />
            </Link>
        </div>

        <!-- Brand Text -->
        <div class="z-10 text-center mt-4 mb-2">
            <h1 class="text-3xl font-bold text-white tracking-tight">FieldEngineer Pro</h1>
            <p class="text-orange-400 font-semibold mt-1">Field Service Training Platform</p>
            <p class="text-gray-400 text-sm mt-1">Sign in to access your courses</p>
        </div>
        
        <!-- Login Form Card -->
        <div class="mt-6 w-full max-w-md px-6 py-4 bg-gray-800 bg-opacity-50 shadow-md overflow-hidden sm:rounded-lg z-10 backdrop-blur-sm border border-gray-700">
            <Head title="Log in" />

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Password" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4 block">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ms-2 text-sm text-gray-300"
                            >Remember me</span
                        >
                    </label>
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="rounded-md text-sm text-gray-300 underline hover:text-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
                    >
                        Forgot your password?
                    </Link>

                    <PrimaryButton
                        class="ms-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Log in
                    </PrimaryButton>
                </div>
            </form>
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

.topo-animated {
    animation: topo-shift 60s ease-in-out infinite;
}
</style>
