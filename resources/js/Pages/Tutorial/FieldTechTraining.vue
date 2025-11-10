<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TutorialSlides from '@/Components/TutorialSlides.vue';

const props = defineProps({
    product: Object,
    hasCompleted: Boolean,
    certificate: Object,
});

const showCertificate = ref(props.hasCompleted);

const tutorialSlides = ref([
    {
        title: "Welcome to Field Technician Training!",
        text: "Hey there! I'm your FieldOps Pro guide, and I'm super excited to help you start your journey as an independent field technician!\n\nIn this training, you'll learn everything you need to know to build a successful side hustle or even replace your 9-5 income. We're going to cover:\n\n✅ Setting up your profiles on FieldNation and WorkMarket\n✅ How to price your services profitably\n✅ Building an effective territory strategy\n✅ Essential tools you'll need\n✅ Professional practices that win repeat clients\n\nThis isn't just another course - this is your roadmap to financial freedom through field services. Ready? Let's get started!",
    },
    {
        title: "Getting Started: Platform Signup",
        text: "First things first - we need to get you signed up on the two major platforms where you'll find work: FieldNation.com and WorkMarket.com.\n\nThese platforms connect businesses that need on-site technical work with skilled technicians like you. Think of them as the Uber of field services!\n\n🌐 FieldNation.com - Register as a service provider\n🌐 WorkMarket.com - Create your technician profile\n\nBoth platforms are free to join. You'll need:\n📧 A professional email address\n📱 Your phone number\n💳 Banking info for payments (added after approval)\n📄 Basic business info (you can operate as a sole proprietor)\n\nDon't worry about being perfect - you can update your profile as you go. The key is to get started!",
        quiz: {
            question: "What are the two main platforms we'll be using to find work orders?",
            options: [
                "Facebook and LinkedIn",
                "FieldNation and WorkMarket",
                "Indeed and Monster",
                "Craigslist and TaskRabbit"
            ],
            correctAnswer: 1,
            correctFeedback: "🎉 Exactly right! FieldNation and WorkMarket are the premier platforms for field technician work.",
            incorrectFeedback: "Not quite! We'll be using FieldNation and WorkMarket - these are specialized platforms for field service work."
        }
    },
    {
        title: "Building Your Profile: Skills Matter!",
        text: "Your profile is your digital resume - it's what clients see when deciding whether to hire you. Let's make it shine!\n\n📝 Start with what you ALREADY know:\n• Network equipment installation\n• Cable running and termination  \n• Basic electrical work\n• Hardware installation\n• Software troubleshooting\n• Any IT or telecommunications experience\n\n🎯 Then add skills you WANT to learn:\n• WiFi network setup\n• Point-of-sale system installation\n• Audio/visual equipment\n• Server rack installation\n• Security camera systems\n\nHere's the secret: Many work orders provide step-by-step instructions. If you're willing to learn and follow directions carefully, you can take jobs in areas where you're building skills.\n\nBe honest but confident. Mark your skill level accurately - it's better to under-promise and over-deliver!",
        quiz: {
            question: "Should you only list skills you're already an expert in?",
            options: [
                "Yes, only list skills you've mastered completely",
                "No, you can list skills you're willing to learn, especially if jobs provide instructions",
                "Only list skills if you have official certifications",
                "Wait until you have 5+ years experience in each skill"
            ],
            correctAnswer: 1,
            correctFeedback: "💯 Perfect! Being willing to learn is valuable. Many jobs teach you on the go with detailed instructions.",
            incorrectFeedback: "Remember - you can list skills you're willing to learn! Many work orders include step-by-step instructions. Being honest about your level while showing willingness to learn is key."
        }
    },
    {
        title: "Calculating Your Hourly Rate",
        text: "This is CRUCIAL - pricing yourself right means the difference between profit and working for free. Let's break it down.\n\n💰 Your rate needs to cover:\n\n1️⃣ Your desired hourly wage (what you want to earn)\n2️⃣ Taxes (set aside 25-30% for self-employment taxes)\n3️⃣ Vehicle costs (gas, maintenance, insurance)\n4️⃣ Tools and equipment\n5️⃣ Insurance (liability insurance is smart)\n6️⃣ Unbillable time (driving, admin work, no-work days)\n\n📊 Example calculation:\n• You want $25/hour take-home\n• Add 30% for taxes = $32.50\n• Add $15 for vehicle/overhead = $47.50\n• Round up for unbillable time = $55-60/hour\n\nDon't race to the bottom on price! Clients value quality work. Being affordable doesn't mean being the cheapest - it means providing great value.\n\nStart at $50-65/hour for most markets. You can adjust based on your local area.",
    },
    {
        title: "Understanding Your Costs",
        text: "Let's get specific about what you need to factor into your pricing:\n\n🚗 VEHICLE COSTS ($0.65/mile IRS standard):\n• 20-mile round trip = $13\n• 50-mile round trip = $32.50\n• 100-mile round trip = $65\n\n🔧 TOOL COSTS (one-time investment, but factor in):\n• Basic tool kit: $100-300\n• Laptop for remote work: $400-800\n• Specialized tools: Budget as needed\n\n⏰ TIME COSTS:\n• 2-hour job might take 4 hours total (drive time + admin)\n• Bid on the TOTAL time, not just on-site time\n\n📋 Example bid breakdown:\n• On-site work: 2 hours @ $60 = $120\n• Drive time: 1 hour @ $60 = $60\n• Total bid: $180\n\nAlways account for the full scope of what you're investing!",
        quiz: {
            question: "If a job is 30 miles away (60 miles round trip) and takes 2 hours on-site, what should you factor into your bid?",
            options: [
                "Only the 2 hours of on-site work",
                "The 2 hours on-site plus drive time and vehicle costs",
                "Just the gas money",
                "Whatever the client wants to pay"
            ],
            correctAnswer: 1,
            correctFeedback: "🎯 Exactly! Always factor in drive time, vehicle costs, and your full time investment. You deserve to be paid for ALL of your work.",
            incorrectFeedback: "Remember - you need to account for on-site time, drive time, AND vehicle costs. Your time and expenses have value!"
        }
    },
    {
        title: "Your Territory Strategy: Work Smarter",
        text: "Here's a game-changer that most new techs don't understand: Having a defined territory makes you WAY more profitable!\n\n🎯 Why territory matters:\n\n1️⃣ EFFICIENCY: Working within 30-50 miles of home means:\n   • Less drive time = more jobs per day\n   • Lower vehicle costs\n   • Better work-life balance\n   • You can respond to emergencies faster\n\n2️⃣ REPUTATION: Focusing on one area means:\n   • You become THE known tech in that region\n   • Clients remember you and request you\n   • You learn the local sites and systems\n   • Word-of-mouth referrals explode\n\n3️⃣ SCHEDULING: Stay local and you can:\n   • Book multiple jobs in one day\n   • Fill schedule gaps efficiently  \n   • Reduce canceled job impact\n\n🚫 Don't chase every job across the state - it's a trap! Pick your zone and OWN it.",
        quiz: {
            question: "What's the recommended travel distance to maximize your effectiveness?",
            options: [
                "Travel anywhere for any job - money is money",
                "Stay within 30-50 miles to build efficiency and reputation",
                "Only work within 5 miles",
                "The further you travel, the better"
            ],
            correctAnswer: 1,
            correctFeedback: "🌟 Perfect! 30-50 miles is the sweet spot for balancing opportunity with efficiency and profitability.",
            incorrectFeedback: "Think efficiency! Working within 30-50 miles lets you do more jobs, spend less on travel, and build a strong local reputation."
        }
    },
    {
        title: "Essential Tools: Start Simple",
        text: "Good news - you don't need $10,000 in tools to get started! Here's what you ACTUALLY need:\n\n🔧 BASIC HAND TOOLS ($100-200):\n✅ Screwdriver set (Phillips & flathead)\n✅ Drill and bit set\n✅ Wire strippers and cutters\n✅ Voltage tester/multimeter\n✅ Flashlight (headlamp is even better)\n✅ Measuring tape\n✅ Utility knife\n✅ Adjustable wrench and pliers\n\n💻 LAPTOP ($400-800):\n✅ Windows 10/11 laptop\n✅ Don't need high-end gaming specs\n✅ Reliable and virus-free is key\n✅ For configuring equipment, remote support\n✅ This ONE tool can save entire jobs!\n\n📦 Other essentials:\n✅ Tool bag or backpack\n✅ Phone with good camera (document work)\n✅ Notepad and pens\n\nWith just these basics, you can complete 80% of field work orders. Add specialized tools as specific jobs require them!",
    },
    {
        title: "The Power of Being Prepared",
        text: "Here's why having the right tools matters SO much:\n\n🎯 FIRST-TRIP COMPLETION:\n\nScenario: You arrive at a retail store to install a router.\n❌ Without laptop: Can't configure it → have to return → unprofitable\n✅ With laptop: Configure on-site → job done → client happy → you're profitable!\n\n💵 Financial impact:\n• Trip 1: 2 hours + 1 hour drive = 3 hours\n• Trip 2: 1 hour + 1 hour drive = 2 hours  \n• Total: 5 hours for a job that should take 3\n• Lost: 2 hours of income + extra fuel costs\n\n😊 CLIENT SATISFACTION:\n• One trip = professional and efficient\n• Client is impressed\n• They request YOU next time\n• They leave 5-star reviews\n• You get MORE work\n\nInvesting in basic tools isn't an expense - it's the foundation of your profitable business!",
        quiz: {
            question: "Why is having a laptop essential for field tech work?",
            options: [
                "Just for checking emails",
                "To play games during downtime",
                "To configure equipment and complete jobs on the first trip",
                "It's not really necessary"
            ],
            correctAnswer: 2,
            correctFeedback: "💻 Exactly! A laptop lets you configure equipment on-site, preventing costly return trips and keeping clients happy.",
            incorrectFeedback: "A laptop is essential! It allows you to configure equipment, troubleshoot issues, and complete jobs in one trip - saving time and money."
        }
    },
    {
        title: "Professionalism: Your Secret Weapon",
        text: "This might be the MOST important lesson in this entire training:\n\n🌟 YOU ARE REPRESENTING YOUR CLIENT\n\nWhen you're on a job site, you're not just a contractor - you're an extension of the business that hired you. Whether it's FieldNation, WorkMarket, or direct clients:\n\n✅ Professional appearance:\n   • Clean clothes (doesn't have to be fancy)\n   • Company shirt if provided\n   • Look put-together and trustworthy\n\n✅ Professional communication:\n   • Arrive on time (or call ahead if delayed)\n   • Be polite to everyone\n   • Clear, written updates on job progress\n   • Take before/after photos\n\n✅ Professional work:\n   • Clean workspace when done\n   • Cable management (no sloppy wiring!)\n   • Test everything before leaving\n   • Document what you did\n\nThis matters because ONE bad experience can cost you dozens of future jobs. ONE great experience can earn you a lifetime client!",
    },
    {
        title: "Building Your 5-Star Rating",
        text: "Your rating is your CURRENCY in this business. Here's how to build and protect it:\n\n⭐ RATING FACTORS:\n\n1️⃣ Communication (30%):\n   • Confirm jobs promptly\n   • Update on arrival/completion\n   • Respond to messages quickly\n   • Be clear and professional\n\n2️⃣ Quality of Work (40%):\n   • Follow instructions exactly\n   • Double-check your work\n   • Take photos of completion\n   • Clean up after yourself\n\n3️⃣ Timeliness (20%):\n   • Show up when scheduled\n   • Complete on time\n   • Don't rush and make mistakes\n\n4️⃣ Professionalism (10%):\n   • Respectful demeanor\n   • Appropriate appearance  \n   • Handle issues calmly\n\n🎯 Goal: Maintain 4.5+ stars\n\nClients AND platforms look at your rating. High ratings = more job offers = higher pay rates = better clients.",
        quiz: {
            question: "What's the most important factor in getting repeat business?",
            options: [
                "Being the absolute cheapest option",
                "Maintaining high ratings through quality, professional work",
                "Only taking the easiest jobs",
                "Working as fast as possible regardless of quality"
            ],
            correctAnswer: 1,
            correctFeedback: "⭐ That's right! Quality work and professionalism build your reputation, leading to repeat clients and more opportunities.",
            incorrectFeedback: "While price matters, your rating and professionalism are what bring clients back. Quality work = repeat business = sustainable income!"
        }
    },
    {
        title: "Beyond the Platforms: Local Growth",
        text: "Here's where it gets REALLY exciting - once you've built your reputation through FieldNation and WorkMarket, a whole new world opens up:\n\n🏪 LOCAL BUSINESS OPPORTUNITIES:\n\nAs you work in your territory, you'll notice:\n• The same retail chains\n• Local IT companies\n• Property management firms\n• Schools and offices\n\n💡 These businesses need ongoing tech support!\n\nThey might:\n✅ Hire you directly (no platform fees!)\n✅ Give you regular maintenance contracts\n✅ Pay premium rates for trusted techs\n✅ Refer you to other businesses\n\n📈 Growth strategy:\n1. Do excellent work through platforms\n2. Build relationships with site managers\n3. Have business cards ready\n4. Ask for referrals\n5. Grow your direct client base\n\nMany successful techs start with platforms but eventually build a local client base that provides steady, premium-rate work!",
    },
    {
        title: "Professional Communication Template",
        text: "Let me give you some real examples of professional communication:\n\n📧 JOB ACCEPTANCE:\n\"Thank you for the opportunity! I've reviewed the work order and have all necessary tools. I'll arrive on [DATE] at [TIME]. Please let me know if you need anything else before the appointment.\"\n\n📱 ARRIVAL UPDATE:\n\"Hi! I'm en route to [LOCATION] and will arrive within 15 minutes. Looking forward to completing this work order for you.\"\n\n✅ COMPLETION UPDATE:\n\"Work completed successfully! I've installed and tested [EQUIPMENT]. All systems are functioning properly. Photos uploaded to work order. Please let me know if you need anything else.\"\n\n⚠️ ISSUE COMMUNICATION:\n\"I've encountered [SPECIFIC ISSUE]. I have two solutions: [OPTION 1] or [OPTION 2]. Please advise how you'd like me to proceed. I'm standing by.\"\n\nNotice the pattern? Clear, professional, solution-oriented communication builds trust!",
        quiz: {
            question: "When should you communicate with the client about a job?",
            options: [
                "Only if something goes wrong",
                "Just when you complete the job",
                "At acceptance, arrival, completion, and if any issues arise",
                "Never - just do the work silently"
            ],
            correctAnswer: 2,
            correctFeedback: "📱 Perfect! Regular communication keeps clients informed and confident in your professionalism.",
            incorrectFeedback: "Communication is key! Update clients at acceptance, arrival, completion, and whenever issues arise. This builds trust and confidence."
        }
    },
    {
        title: "Managing Your Business Finances",
        text: "You're not just a technician - you're a business owner! Let's talk money management:\n\n💰 INCOME TRACKING:\n✅ Keep spreadsheet of all jobs\n✅ Record: Date, Client, Amount, Miles driven\n✅ Track which platforms pay best\n✅ Note your hourly effective rate\n\n💵 EXPENSE TRACKING:\n✅ Keep ALL receipts (tools, gas, supplies)\n✅ Log mileage for every job\n✅ Track phone/internet costs\n✅ Save for equipment replacement\n\n🏦 BANKING:\n✅ Open separate business checking account\n✅ Set aside 25-30% for taxes IMMEDIATELY\n✅ Pay yourself a regular \"salary\"\n✅ Keep 3-6 months expenses saved\n\n📊 QUARTERLY REVIEWS:\n• What's your real hourly rate?\n• Which job types are most profitable?\n• What expenses can you reduce?\n• Are you growing?\n\nTreat this like the business it is, and it'll reward you like a business!",
    },
    {
        title: "Safety First: Protect Yourself",
        text: "Let's talk about staying safe while you work:\n\n⚡ ELECTRICAL SAFETY:\n✅ ALWAYS turn off power at breaker\n✅ Use voltage tester to confirm power is OFF\n✅ Never work on live circuits\n✅ Know your limits - call an electrician if unsure\n\n🏗️ PHYSICAL SAFETY:\n✅ Use ladder properly (3-point contact)\n✅ Wear safety glasses when drilling\n✅ Lift with your legs, not your back\n✅ Keep work area clean and organized\n\n📱 PERSONAL SAFETY:\n✅ Let someone know your job locations\n✅ Trust your instincts about sites\n✅ Keep phone charged\n✅ Have emergency contacts saved\n\n🛡️ BUSINESS PROTECTION:\n✅ Get liability insurance ($300-500/year)\n✅ Document everything with photos\n✅ Have clients sign off on completed work\n✅ Never work outside your skill level\n\nYou can't earn money if you're injured. Safety isn't optional - it's part of being professional!",
        quiz: {
            question: "What should you do BEFORE working with any electrical equipment?",
            options: [
                "Just start working - it's probably fine",
                "Turn off power at breaker and verify with voltage tester",
                "Wear rubber gloves and hope for the best",
                "Call an electrician for every small task"
            ],
            correctAnswer: 1,
            correctFeedback: "⚡ Absolutely correct! Always turn off power and verify it's off before working. Safety first, always!",
            incorrectFeedback: "Safety is critical! Always turn power off at the breaker and use a voltage tester to verify before touching any wiring."
        }
    },
    {
        title: "Your Action Plan: Next Steps",
        text: "Congratulations! You've made it through the training. Now it's time to take ACTION:\n\n📋 IMMEDIATE STEPS (This Week):\n1️⃣ Sign up on FieldNation.com ✓\n2️⃣ Sign up on WorkMarket.com ✓\n3️⃣ Complete your profile 100% ✓\n4️⃣ List your skills honestly ✓\n5️⃣ Calculate your hourly rate ✓\n\n🛠️ PREPARE (Week 2):\n1️⃣ Buy basic tool kit\n2️⃣ Set up laptop for field work\n3️⃣ Get business cards printed\n4️⃣ Set up business bank account\n5️⃣ Research liability insurance\n\n🎯 LAUNCH (Week 3+):\n1️⃣ Start bidding on jobs in your territory\n2️⃣ Begin with simpler work orders\n3️⃣ Focus on 5-star ratings\n4️⃣ Track your finances\n5️⃣ Build your reputation\n\nRemember: Every expert started as a beginner. You've got this!",
    },
    {
        title: "Final Assessment",
        text: "Alright, let's make sure you've got the key concepts down! This final question brings it all together:\n\nYou've completed your training and you're ready to start building your field technician business. You understand the platforms, pricing, territory strategy, tools, and professionalism.\n\nNow it's time to prove you were paying attention!",
        quiz: {
            question: "What are the three MOST important factors for building a successful field technician business?",
            options: [
                "Being the cheapest, working 7 days a week, taking every job offered",
                "Professional work quality, defined territory strategy, and proper pricing that covers all costs",
                "Having the most expensive tools, driving anywhere for work, undercutting competition",
                "Only working on the easiest jobs, avoiding challenging work, minimal communication"
            ],
            correctAnswer: 1,
            correctFeedback: "🎓 Outstanding! You've mastered the fundamentals. Professional quality, smart territory management, and proper pricing are the foundations of a profitable business. You're ready to succeed!",
            incorrectFeedback: "Think about everything we covered - quality work builds reputation, a defined territory maximizes efficiency, and proper pricing ensures profitability. These three pillars support your entire business!"
        }
    },
]);

const handleTutorialComplete = (answers) => {
    // Send completion to backend
    router.post('/tutorial/complete', {
        product_id: props.product.id,
        answers: answers,
    }, {
        onSuccess: () => {
            showCertificate.value = true;
        }
    });
};

const downloadCertificate = () => {
    window.open(route('tutorial.certificate', props.product.id), '_blank');
};
</script>

<template>
    <Head title="Field Technician Certification Training" />

    <AuthenticatedLayout>
        <div v-if="!showCertificate">
            <TutorialSlides 
                :slides="tutorialSlides" 
                :on-complete="handleTutorialComplete"
            />
        </div>

        <!-- Certificate View -->
        <div v-else class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-12 px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Celebration -->
                <div class="text-center mb-8">
                    <div class="text-6xl mb-4">🎉🎓🎊</div>
                    <h1 class="text-4xl font-bold text-white mb-2">Congratulations!</h1>
                    <p class="text-xl text-gray-300">You've Completed Your Field Technician Training</p>
                </div>

                <!-- Certificate Preview -->
                <div class="bg-white rounded-2xl shadow-2xl p-12 mb-8 border-8 border-orange-500">
                    <div class="text-center">
                        <div class="flex justify-center mb-6">
                            <img src="/img/8bit-character.svg" alt="FieldOps Pro" class="w-24 h-24" style="image-rendering: pixelated; image-rendering: crisp-edges;" />
                        </div>
                        
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Certificate of Completion</h2>
                        <div class="w-32 h-1 bg-orange-500 mx-auto mb-6"></div>
                        
                        <p class="text-lg text-gray-600 mb-4">This certifies that</p>
                        <p class="text-3xl font-bold text-orange-600 mb-4">{{ $page.props.auth.user.name }}</p>
                        
                        <p class="text-lg text-gray-600 mb-6">has successfully completed</p>
                        <p class="text-2xl font-bold text-gray-800 mb-6">FieldOps Pro Field Technician Certification</p>
                        
                        <p class="text-gray-600 mb-8">
                            Demonstrating proficiency in platform navigation, professional service delivery,<br/>
                            business operations, and independent contractor best practices
                        </p>
                        
                        <div class="flex justify-center gap-12 text-left">
                            <div>
                                <div class="border-t-2 border-gray-300 pt-2">
                                    <p class="font-semibold">FieldOps Pro</p>
                                    <p class="text-sm text-gray-600">Training Program</p>
                                </div>
                            </div>
                            <div>
                                <div class="border-t-2 border-gray-300 pt-2">
                                    <p class="font-semibold">{{ new Date().toLocaleDateString() }}</p>
                                    <p class="text-sm text-gray-600">Date of Completion</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 justify-center">
                    <button 
                        @click="downloadCertificate"
                        class="px-8 py-4 bg-gradient-to-r from-orange-600 to-orange-500 text-white rounded-lg font-bold text-lg hover:from-orange-500 hover:to-orange-600 transition-all shadow-lg shadow-orange-500/50"
                    >
                        📄 Download Certificate
                    </button>
                    
                    <a 
                        :href="route('dashboard')"
                        class="px-8 py-4 bg-gray-700 text-white rounded-lg font-bold text-lg hover:bg-gray-600 transition-all"
                    >
                        Return to Dashboard
                    </a>
                </div>

                <!-- Next Steps -->
                <div class="mt-12 bg-gray-800 rounded-xl p-8 border border-gray-700">
                    <h3 class="text-2xl font-bold text-white mb-4">🚀 You're Ready! Next Steps:</h3>
                    <div class="grid md:grid-cols-2 gap-4 text-gray-300">
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">✅</span>
                            <div>
                                <p class="font-semibold text-white">Sign up on platforms</p>
                                <p class="text-sm">FieldNation.com & WorkMarket.com</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">🛠️</span>
                            <div>
                                <p class="font-semibold text-white">Get your tools ready</p>
                                <p class="text-sm">Basic kit + laptop</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">📍</span>
                            <div>
                                <p class="font-semibold text-white">Define your territory</p>
                                <p class="text-sm">30-50 mile radius</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">💰</span>
                            <div>
                                <p class="font-semibold text-white">Start bidding on jobs</p>
                                <p class="text-sm">Apply your pricing strategy</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
