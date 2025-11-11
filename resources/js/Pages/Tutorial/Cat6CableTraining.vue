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
        title: "Welcome to Cat 6 Cable Installation Training!",
        text: "Hey there! Ready to master one of the most valuable skills in field tech work? I'm your FieldOps Pro guide, and I'm going to teach you everything about installing and terminating Cat 6 cabling!\n\nThis training covers:\n\n🔧 Cable types and when to use them\n📏 Proper cable routing techniques\n🏢 Commercial vs. residential installations\n🔌 Professional RJ-45 termination (TIA-568B standard)\n🧪 Testing and certification methods\n💼 Industry best practices\n\nCat 6 cabling is EVERYWHERE - offices, retail stores, warehouses, homes. Master this skill and you'll always have work. Let's dive in!",
        image: "https://images.unsplash.com/photo-1606603696914-4d85a5287b8f?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Professional Cat6 cable installation - structured cabling is a high-demand skill"
    },
    {
        title: "Understanding Cat 6 Cable",
        text: "Before we start pulling cable, let's understand what makes Cat 6 special:\n\n📊 SPECIFICATIONS:\n• Maximum speed: 10 Gbps (up to 55 meters)\n• Frequency: 250 MHz\n• Standard speed: 1 Gbps (up to 100 meters)\n• 4 twisted pairs (8 wires total)\n• Backward compatible with Cat 5e\n\n🆚 CAT 6 vs CAT 5e:\n• Tighter wire twists (less crosstalk)\n• Thicker cable jacket\n• Better shielding options\n• Higher data rates\n• Slightly more expensive\n\n⚡ WHEN TO USE CAT 6:\n• New installations (future-proofing)\n• High-bandwidth applications\n• PoE+ devices (cameras, APs)\n• Professional environments\n• When client requests it\n\nAlways verify project specs before ordering cable!",
        image: "https://images.unsplash.com/photo-1606603696914-4d85a5287b8f?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Cat6 cable - understanding the specifications",
        customHtml: `
        <div class="bg-gray-800 rounded-lg p-6 my-6">
            <h3 class="text-xl font-bold text-orange-400 mb-4">📊 Cable Category Comparison</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="py-3 px-4 text-orange-400 font-semibold">Category</th>
                        <th class="py-3 px-4 text-orange-400 font-semibold text-right">Max Speed</th>
                        <th class="py-3 px-4 text-orange-400 font-semibold text-right">Frequency</th>
                        <th class="py-3 px-4 text-orange-400 font-semibold text-right">Max Distance</th>
                        <th class="py-3 px-4 text-orange-400 font-semibold text-center">Best For</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300">
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4 font-mono">Cat 5e</td>
                        <td class="py-3 px-4 text-right font-mono">1 Gbps</td>
                        <td class="py-3 px-4 text-right font-mono">100 MHz</td>
                        <td class="py-3 px-4 text-right font-mono">100m</td>
                        <td class="py-3 px-4 text-center text-sm">Legacy/Budget</td>
                    </tr>
                    <tr class="border-b border-gray-700/50 bg-green-500/10">
                        <td class="py-3 px-4 font-mono font-bold text-green-400">Cat 6</td>
                        <td class="py-3 px-4 text-right font-mono text-green-400">10 Gbps (55m)</td>
                        <td class="py-3 px-4 text-right font-mono text-green-400">250 MHz</td>
                        <td class="py-3 px-4 text-right font-mono text-green-400">100m (1Gb)</td>
                        <td class="py-3 px-4 text-center text-sm"><span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-bold">RECOMMENDED</span></td>
                    </tr>
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4 font-mono">Cat 6a</td>
                        <td class="py-3 px-4 text-right font-mono">10 Gbps</td>
                        <td class="py-3 px-4 text-right font-mono">500 MHz</td>
                        <td class="py-3 px-4 text-right font-mono">100m</td>
                        <td class="py-3 px-4 text-center text-sm">Data Centers</td>
                    </tr>
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4 font-mono">Cat 7/8</td>
                        <td class="py-3 px-4 text-right font-mono">40+ Gbps</td>
                        <td class="py-3 px-4 text-right font-mono">600+ MHz</td>
                        <td class="py-3 px-4 text-right font-mono">100m</td>
                        <td class="py-3 px-4 text-center text-sm">Enterprise Only</td>
                    </tr>
                </tbody>
            </table>
            <p class="text-sm text-gray-400 mt-4">💡 <strong>Pro Tip:</strong> Cat 6 is the sweet spot for 95% of installations - future-proof without breaking the bank!</p>
        </div>
        `,
        quiz: {
            question: "What is the maximum speed of Cat 6 cable for distances up to 55 meters?",
            options: [
                "1 Gbps",
                "5 Gbps",
                "10 Gbps",
                "100 Mbps"
            ],
            correctAnswer: 2,
            correctFeedback: "🎯 Perfect! Cat 6 can handle 10 Gbps at shorter distances (up to 55m), making it ideal for high-performance networks.",
            incorrectFeedback: "Not quite! Cat 6 supports up to 10 Gbps at distances under 55 meters. It's one of the key advantages over Cat 5e."
        }
    },
    {
        title: "Essential Tools: Cable Installation",
        text: "Here's your toolkit for professional cable installation:\n\n🎒 BASIC INSTALLATION TOOLS:\n\n📏 **Fish Tape/Glow Rods** ($30-150)\n• For routing cable through walls\n• Steel or fiberglass options\n• Get 25-50 foot length minimum\n\n✂️ **Cable Cutters** ($15-40)\n• Sharp, clean cuts only\n• Don't use regular scissors!\n• Cuts through jacket and wires\n\n🔦 **Headlamp** ($20-60)\n• Hands-free lighting is essential\n• Get 300+ lumens brightness\n• Long battery life important\n\n📐 **Measuring Tape** ($10-25)\n• 25-foot minimum\n• Mark cable route distances\n• Verify box heights\n\n🗂️ **Cable Labels** ($10-30)\n• Label both ends BEFORE termination\n• Use permanent markers\n• Include location codes\n\nInvest in quality tools - they'll last years!",
        image: "https://images.unsplash.com/photo-1581092918484-8313e8f28c7d?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Professional cable installation tools"
    },
    {
        title: "Essential Tools: Termination & Testing",
        text: "Now for the precision tools - these make or break your connections:\n\n🔌 TERMINATION TOOLS:\n\n🔨 **Crimp Tool** ($15-100)\n• Get a ratcheting model (consistent crimps)\n• Must fit RJ-45 connectors\n• Quality matters here!\n\n✂️ **Wire Stripper** ($10-30)\n• Adjustable for Cat 6 thickness\n• Removes jacket without cutting wires\n• Some have built-in cutters\n\n🧪 TESTING EQUIPMENT:\n\n✅ **Cable Tester** ($20-80)\n• Verifies pin-to-pin continuity\n• Tests for shorts and miswires\n• Essential for every tech\n\n📊 **Network Certifier** ($1,500-3,000)\n• Professional certification tool\n• Tests to TIA/EIA standards\n• Required for warranty work\n• Usually company-provided\n\n💡 PRO TIP: Start with a basic tester, upgrade as you grow!",
        image: "https://images.unsplash.com/photo-1581092160607-1e49b2f2a7b4?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Cable termination and testing equipment",
        quiz: {
            question: "Why should you get a ratcheting crimp tool instead of a basic one?",
            options: [
                "It's cheaper",
                "It provides consistent, reliable crimps every time",
                "It works faster",
                "It doesn't need connectors"
            ],
            correctAnswer: 1,
            correctFeedback: "✅ Exactly! Ratcheting crimp tools ensure consistent pressure on every crimp, resulting in reliable connections that pass testing.",
            incorrectFeedback: "The key advantage is consistency! Ratcheting tools apply the same pressure every time, preventing connection failures from over or under-crimping."
        }
    },
    {
        title: "Planning Your Cable Route",
        text: "Good planning saves time and prevents problems. Here's how to plan a professional installation:\n\n🗺️ ROUTE PLANNING CHECKLIST:\n\n1️⃣ **Walk the Route**\n   • Measure actual distance (add 10-15% slack)\n   • Identify obstacles (pipes, ducts, beams)\n   • Check for electrical lines (keep 12\" away)\n   • Note wall types (drywall, concrete, brick)\n\n2️⃣ **Choose Your Path**\n   ✅ Follow existing cable runs when possible\n   ✅ Use cable trays in commercial spaces\n   ✅ Stay above ceiling tiles (if present)\n   ✅ Avoid sharp bends (minimum 4x cable diameter)\n   ❌ Never run parallel to electrical for long distances\n   ❌ Don't cross fluorescent lights\n\n3️⃣ **Mark Access Points**\n   • Entry point (usually network closet)\n   • Exit point (jack location)\n   • Any pull points needed\n   • Mark studs and obstacles\n\n📝 Document everything with photos and notes!",
    },
    {
        title: "Commercial Installation Techniques",
        text: "Commercial buildings have different requirements than residential. Here's what you need to know:\n\n🏢 COMMERCIAL BEST PRACTICES:\n\n📊 **Cable Tray Systems**\n• J-hooks every 4-5 feet\n• Use velcro straps (not zip ties on horizontal runs)\n• Leave service loops at both ends\n• Bundle neatly (max 25 cables per bundle)\n\n🔝 **Above Drop Ceiling**\n• Most common commercial route\n• Follow building codes (plenum cable required!)\n• Support every 5 feet maximum\n• Keep away from HVAC ducts\n• Mark tiles for future access\n\n⚡ **Electrical Separation**\n• 12\" minimum from power lines\n• 2\" if in conduit\n• Cross at 90° when necessary\n• NEVER bundle with electrical\n\n🎯 **Professional Appearance**\n• Straight, neat runs\n• Consistent spacing\n• Proper labeling\n• Clean terminations\n\nClients notice quality work!",
    },
    {
        title: "Residential Installation Techniques",
        text: "Homes present unique challenges. Here's how to handle them professionally:\n\n🏠 RESIDENTIAL STRATEGIES:\n\n🧱 **Running Through Walls**\n• Drill from basement/attic when possible\n• Use fish tape or rods\n• Drop from attic to wall cavity\n• Fish up from basement to first floor\n• Mark drill locations carefully\n\n📦 **Low Voltage Brackets**\n• Use old-work boxes for existing walls\n• Cut hole with drywall saw\n• Secure bracket to drywall\n• Mount faceplate when done\n\n🎨 **Minimizing Damage**\n• Use smallest holes necessary\n• Patch any mistakes\n• Paint touchup if needed\n• Hide runs in closets when possible\n• Baseboard routing (staple behind)\n\n🔍 **Finding Studs**\n• Use stud finder\n• Knock test\n• Look for outlet locations\n• Studs typically 16\" on center\n\n💡 Always get homeowner approval for routing before drilling!",
        quiz: {
            question: "What type of cable MUST be used above drop ceilings in commercial buildings?",
            options: [
                "Any Cat 6 cable works fine",
                "Plenum-rated cable (required by building codes)",
                "Outdoor-rated cable",
                "Armored cable only"
            ],
            correctAnswer: 1,
            correctFeedback: "🔥 Correct! Plenum-rated cable is required in air-handling spaces because it produces less toxic smoke if it burns. This is a building code requirement!",
            incorrectFeedback: "Building codes require plenum-rated cable in air-handling spaces like above drop ceilings. It's designed to produce less toxic smoke in case of fire."
        }
    },
    {
        title: "Pulling Cable: Best Practices",
        text: "Proper pulling technique prevents damage and ensures long cable life:\n\n💪 PULLING TECHNIQUES:\n\n👥 **Two-Person Pulls**\n• One person feeds, one pulls\n• Feeder prevents tangles and kinks\n• Puller applies steady, even pressure\n• Communication is key!\n\n⚠️ **Maximum Pull Tension**\n• Cat 6: 25 lbs maximum force\n• Pull slowly and steadily\n• NEVER jerk or yank\n• Stop if you feel resistance\n\n🌀 **Preventing Kinks**\n• Keep cable relaxed\n• Don't over-pull\n• Watch for tight corners\n• Use pulling lubricant for long runs\n\n📏 **Service Loops**\n• Leave 3-6 feet at each end\n• Coil neatly (not too tight)\n• Allows for future adjustments\n• Provides slack for termination\n\n🚫 **What NOT To Do:**\n❌ Step on cable\n❌ Pull over sharp edges\n❌ Stretch or yank\n❌ Exceed bend radius (4x cable diameter)",
    },
    {
        title: "Understanding TIA-568B Wiring Standard",
        text: "This is THE standard you'll use 99% of the time. Memorize this!\n\n🎨 TIA-568B PINOUT (Left to Right):\n\nPin 1: 🟧 White/Orange\nPin 2: 🟠 Orange\nPin 3: ⬜ White/Green\nPin 4: 🔵 Blue\nPin 5: ⬜ White/Blue\nPin 6: 🟢 Green\nPin 7: ⬜ White/Brown\nPin 8: 🟤 Brown\n\n💡 MEMORY TRICK:\n\"Orange pair first, green pair split, blue together, brown at the end\"\n\n📊 WHY THIS ORDER?\n• Pins 1,2,3,6 carry data (100Mbps/1Gbps)\n• Pins 4,5,7,8 used for Gigabit and PoE\n• Order minimizes crosstalk\n• Twisted pairs stay together\n\n⚡ TIA-568A vs 568B:\n• 568B is the industry standard\n• 568A mainly for government/legacy\n• NEVER mix standards on same cable!\n• Both ends must match\n\nWrite this down and keep it in your toolkit!",
        image: "https://images.unsplash.com/photo-1625314868143-20e93ce3ff33?w=1200&h=600&fit=crop&q=80",
        imageCaption: "RJ-45 connector with Cat6 cable - proper termination is critical",
        customHtml: `
        <div class="bg-gray-800 rounded-lg p-6 my-6">
            <h3 class="text-xl font-bold text-orange-400 mb-4">🔌 TIA-568B Wiring Diagram</h3>
            <div class="bg-gray-900 rounded-lg p-6 border-2 border-orange-500">
                <div class="text-center mb-4">
                    <p class="text-gray-400 text-sm mb-2">Looking at RJ-45 connector (clip facing DOWN, pins facing UP)</p>
                    <div class="inline-block bg-gray-800 px-4 py-2 rounded border border-gray-600 font-mono text-sm mb-4">
                        ← Pin 1 (Left) | Pin 8 (Right) →
                    </div>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-orange-500">
                            <th class="py-3 px-4 text-orange-400 font-semibold text-center">Pin #</th>
                            <th class="py-3 px-4 text-orange-400 font-semibold">Wire Color</th>
                            <th class="py-3 px-4 text-orange-400 font-semibold">Pair</th>
                            <th class="py-3 px-4 text-orange-400 font-semibold">Function</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-300">
                        <tr class="border-b border-gray-700 bg-orange-500/10">
                            <td class="py-3 px-4 text-center font-bold text-orange-400">1</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full bg-orange-300 border-2 border-white"></span>
                                    <span class="font-mono">White/Orange</span>
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono text-orange-400">Pair 2</td>
                            <td class="py-3 px-4 text-sm">TX+ (Transmit)</td>
                        </tr>
                        <tr class="border-b border-gray-700 bg-orange-500/10">
                            <td class="py-3 px-4 text-center font-bold text-orange-400">2</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full bg-orange-500"></span>
                                    <span class="font-mono">Orange</span>
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono text-orange-400">Pair 2</td>
                            <td class="py-3 px-4 text-sm">TX- (Transmit)</td>
                        </tr>
                        <tr class="border-b border-gray-700 bg-green-500/10">
                            <td class="py-3 px-4 text-center font-bold text-green-400">3</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full bg-green-300 border-2 border-white"></span>
                                    <span class="font-mono">White/Green</span>
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono text-green-400">Pair 3</td>
                            <td class="py-3 px-4 text-sm">RX+ (Receive)</td>
                        </tr>
                        <tr class="border-b border-gray-700">
                            <td class="py-3 px-4 text-center font-bold text-blue-400">4</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full bg-blue-500"></span>
                                    <span class="font-mono">Blue</span>
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono text-blue-400">Pair 1</td>
                            <td class="py-3 px-4 text-sm">PoE / Gigabit</td>
                        </tr>
                        <tr class="border-b border-gray-700">
                            <td class="py-3 px-4 text-center font-bold text-blue-400">5</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full bg-blue-300 border-2 border-white"></span>
                                    <span class="font-mono">White/Blue</span>
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono text-blue-400">Pair 1</td>
                            <td class="py-3 px-4 text-sm">PoE / Gigabit</td>
                        </tr>
                        <tr class="border-b border-gray-700 bg-green-500/10">
                            <td class="py-3 px-4 text-center font-bold text-green-400">6</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full bg-green-500"></span>
                                    <span class="font-mono">Green</span>
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono text-green-400">Pair 3</td>
                            <td class="py-3 px-4 text-sm">RX- (Receive)</td>
                        </tr>
                        <tr class="border-b border-gray-700">
                            <td class="py-3 px-4 text-center font-bold text-yellow-600">7</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full bg-yellow-200 border-2 border-white"></span>
                                    <span class="font-mono">White/Brown</span>
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono text-yellow-600">Pair 4</td>
                            <td class="py-3 px-4 text-sm">PoE / Gigabit</td>
                        </tr>
                        <tr class="border-b border-gray-700">
                            <td class="py-3 px-4 text-center font-bold text-yellow-600">8</td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center gap-2">
                                    <span class="w-4 h-4 rounded-full bg-yellow-700"></span>
                                    <span class="font-mono">Brown</span>
                                </span>
                            </td>
                            <td class="py-3 px-4 font-mono text-yellow-600">Pair 4</td>
                            <td class="py-3 px-4 text-sm">PoE / Gigabit</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4 bg-red-500/20 border border-red-500 rounded-lg p-4">
                <h4 class="font-bold text-red-400 mb-2">⚠️ CRITICAL: Never Split Twisted Pairs!</h4>
                <p class="text-sm text-gray-300">Each colored wire MUST stay with its white/colored striped partner. Separating pairs causes "split pair" failure even if continuity tests pass!</p>
            </div>
            <p class="text-sm text-gray-400 mt-4">💡 <strong>Memory Aid:</strong> "Orange-Green-Blue-Brown" with whites before solids (except green pair splits for pins 3 & 6)</p>
        </div>
        `,
        quiz: {
            question: "In TIA-568B standard, which color goes on Pin 1?",
            options: [
                "White/Green",
                "White/Orange",
                "Orange",
                "White/Blue"
            ],
            correctAnswer: 1,
            correctFeedback: "🎯 Perfect! White/Orange goes on Pin 1, followed by solid Orange on Pin 2. Orange pair always comes first in 568B!",
            incorrectFeedback: "In TIA-568B, Pin 1 is White/Orange (the striped wire from the orange pair). Remember: Orange pair first!"
        }
    },
    {
        title: "Preparing the Cable for Termination",
        text: "Proper prep work is 80% of a good termination. Take your time here!\n\n✂️ STEP-BY-STEP PREPARATION:\n\n1️⃣ **Cut Cable Square** (30 seconds)\n   • Use sharp cable cutters\n   • Make a clean, perpendicular cut\n   • Remove any damaged end\n\n2️⃣ **Strip Outer Jacket** (1 minute)\n   • Remove 1.5-2 inches of jacket\n   • Use wire stripper or careful knife\n   • DON'T nick the inner wires!\n   • Slide jacket off cleanly\n\n3️⃣ **Untwist Wire Pairs** (1 minute)\n   • Carefully separate 4 pairs\n   • Untwist each pair completely\n   • Keep wires as straight as possible\n   • Maintain original length\n\n4️⃣ **Arrange in 568B Order** (2 minutes)\n   • Flatten and straighten wires\n   • Arrange left to right: WO-O-WG-B-WB-G-WBr-Br\n   • Keep wires parallel and flat\n   • This takes practice!\n\n🎯 PRO TIP: Work on a flat surface with good lighting!",
    },
    {
        title: "Trimming and Inserting Wires",
        text: "This step requires precision - here's how to do it perfectly:\n\n✂️ TRIMMING TECHNIQUE:\n\n📏 **Measure and Cut**\n• Hold wires flat and parallel\n• Line up RJ-45 connector to check length\n• Wires should reach end but not extend beyond\n• Cut straight across (perpendicular)\n• Use sharp cutters for clean cut\n• Length: about 0.5 inches from jacket\n\n🔌 **Inserting into RJ-45**\n\n1️⃣ Orient connector: clip facing DOWN, pins facing UP\n2️⃣ Hold wires flat and parallel\n3️⃣ Insert straight into connector\n4️⃣ Push firmly until wires bottom out\n5️⃣ Verify: wires visible through clear end\n6️⃣ Check: jacket inside connector (strain relief)\n7️⃣ Confirm: all 8 pins have wire fully inserted\n\n⚠️ COMMON MISTAKES:\n❌ Wires not bottomed out\n❌ Jacket not inside connector  \n❌ Wires crossed or out of order\n❌ One wire shorter than others\n\nIf it's not perfect, cut it off and try again!",
    },
    {
        title: "Crimping the RJ-45 Connector",
        text: "Now for the moment of truth - the crimp that holds it all together:\n\n🔨 CRIMPING PROCESS:\n\n1️⃣ **Final Inspection**\n   • Verify all 8 wires visible at end\n   • Confirm wire order is correct\n   • Check jacket is inside connector\n   • Wires fully seated (bottomed out)\n\n2️⃣ **Insert into Crimp Tool**\n   • RJ-45 connector goes in the tool opening\n   • Connector should be firmly seated\n   • Don't let wires shift\n\n3️⃣ **Apply Pressure**\n   • Squeeze firmly and evenly\n   • With ratcheting tool: complete the full cycle\n   • Without ratcheting: apply full firm pressure\n   • You'll feel resistance, then a click/release\n\n4️⃣ **Inspect the Crimp**\n   • Metal pins should be pushed down into wires\n   • Jacket strain relief engaged\n   • Connector firmly attached\n   • No loose wires\n\n🎯 If crimp looks wrong, cut it off and redo it!",
        quiz: {
            question: "What should you verify BEFORE crimping the RJ-45 connector?",
            options: [
                "Just crimp it quickly",
                "All 8 wires visible at end, correct order, jacket inside connector",
                "Only check that some wires are in",
                "Just make sure the clip works"
            ],
            correctAnswer: 1,
            correctFeedback: "✅ Perfect! Always verify wire order, that all wires are bottomed out, and the jacket is inside for strain relief. Prevention is easier than rework!",
            incorrectFeedback: "Always inspect BEFORE crimping! Check all 8 wires are fully inserted, in correct order, and the jacket is inside the connector."
        }
    },
    {
        title: "Testing Your Termination",
        text: "A cable tester is your quality control - use it on EVERY cable:\n\n🧪 BASIC CABLE TESTING:\n\n🔌 **Connect the Tester**\n• Plug cable into main unit\n• Plug other end into remote unit\n• Power on the tester\n• Select test mode (usually automatic)\n\n✅ **Reading Test Results**\n\n**PASS Indicators:**\n• All 8 pins light up in sequence (1-8)\n• Green lights or \"PASS\" display\n• Lights match 1:1 pattern\n\n**FAIL Indicators:**\n• ❌ Missing pins (wire not making contact)\n• ❌ Miswired (wrong order)\n• ❌ Short (multiple pins light at once)\n• ❌ Split pair (wrong pairing detected)\n\n🔧 **Common Failures and Fixes:**\n• No connection on pin: Recut and recrimp\n• Wrong order: Cut off, redo wire sequence\n• Short: Cut off, ensure wires don't touch\n• Split pair: Verify you didn't split twist pairs\n\n📝 Document test results for warranty work!",
    },
    {
        title: "Advanced Testing: Certification",
        text: "Professional installations require certification. Here's what you need to know:\n\n📊 CABLE CERTIFICATION:\n\n🎯 **What Certifiers Test:**\n• Wire mapping (continuity)\n• Length (must be under 100m)\n• Attenuation (signal loss)\n• Near-End Crosstalk (NEXT)\n• Return loss\n• Propagation delay\n• Delay skew\n\n💰 **Certification Tools** ($1,500-$5,000)\n• Fluke DTX/DSX series (industry standard)\n• Softing CableMaster\n• Ideal NaviTEK\n• Usually company provides these\n\n📋 **When Certification Required:**\n• New construction projects\n• Warranty installations\n• Hospital/medical facilities\n• Government contracts\n• Client-requested documentation\n\n📄 **Certification Reports Include:**\n• Pass/Fail for each parameter\n• Detailed test results\n• Cable ID and location\n• Test date and technician\n• PDF export for records\n\nCertification proves cable meets TIA/EIA standards!",
    },
    {
        title: "Troubleshooting Failed Tests",
        text: "When a cable fails testing, here's your systematic troubleshooting guide:\n\n🔍 COMMON FAILURES AND SOLUTIONS:\n\n❌ **Open/No Connection**\nCause: Wire not making contact\nFix: Verify wire fully inserted, recrimp or reterminate\n\n❌ **Miswired**  \nCause: Wrong wire order\nFix: Cut off connector, rearrange wires in 568B order\n\n❌ **Short**\nCause: Wires touching each other\nFix: Cut off connector, ensure wires separated\n\n❌ **Split Pair**\nCause: Twisted pairs separated\nFix: Verify you're using: WO-O together, WG-G together, etc.\n\n❌ **High NEXT (Crosstalk)**\nCause: Untwisted wires too long OR cable damaged\nFix: Minimize untwisted length (<0.5\"), check cable for kinks\n\n❌ **Length Failure**\nCause: Cable run exceeds 100 meters (328 feet)\nFix: Add switch or use fiber for longer runs\n\n💡 PRO TIP: 90% of failures are at the termination points. Check your connectors first!",
        quiz: {
            question: "What's the most common cause of a 'split pair' failure?",
            options: [
                "Cable is too long",
                "Twisted wire pairs were separated (like pairing White/Orange with White/Green instead of solid colors)",
                "Connector wasn't crimped hard enough",
                "Cable was bent too sharply"
            ],
            correctAnswer: 1,
            correctFeedback: "🎯 Exactly! Split pair happens when you separate twisted pairs - each colored wire must stay with its white/colored partner throughout the entire cable.",
            incorrectFeedback: "Split pair means the twisted pairs were separated during termination. Each colored wire must stay paired with its matching white/colored striped wire."
        }
    },
    {
        title: "Professional Cable Management",
        text: "Clean cable management separates amateurs from professionals:\n\n🎯 CABLE MANAGEMENT BEST PRACTICES:\n\n📊 **In Network Closets**\n• Use cable management panels\n• Dress cables neatly (waterfall effect)\n• Service loops coiled and tied\n• Labels visible and consistent\n• Separate incoming from outgoing\n\n🔧 **Support and Routing**\n• J-hooks or cable tray every 5 feet\n• Velcro straps on horizontal runs (reusable)\n• Zip ties on vertical drops (one-time)\n• Don't overtighten! (causes cable damage)\n• Maintain minimum bend radius\n\n🏷️ **Labeling Standards**\n• Both ends labeled identically\n• Include: Location-Jack#-Date\n• Example: \"2F-CONF-J12-092024\"\n• Use label maker for professionalism\n• Update documentation/drawings\n\n🎨 **Color Coding** (Optional but helpful)\n• Blue: Horizontal runs\n• Yellow: Uplinks/infrastructure\n• Red: Critical systems\n• Green: PoE devices\n\nClients LOVE clean, organized cable runs!",
    },
    {
        title: "Patch Panel Termination",
        text: "Patch panels are the professional standard for network closets:\n\n🔌 PATCH PANEL INSTALLATION:\n\n📦 **What is a Patch Panel?**\n• Central termination point for all cables\n• Typically 24 or 48 ports\n• Mounts in network rack\n• Uses 110 punch-down blocks (not RJ-45 crimps!)\n\n🔧 **Termination Process:**\n\n1️⃣ Strip cable jacket (2-3 inches)\n2️⃣ Separate twisted pairs\n3️⃣ Route to appropriate port\n4️⃣ Untwist ONLY what's needed (<0.5\")\n5️⃣ Place wires in 110 block (color coded)\n6️⃣ Use punch-down tool to seat wires\n7️⃣ Trim excess with punch tool\n8️⃣ Verify connections with tester\n\n✅ **Advantages:**\n• Easy to reorganize network\n• Protects switch ports from wear\n• Professional appearance\n• Easier troubleshooting\n• Industry standard\n\n🎯 Many commercial jobs REQUIRE patch panels!",
    },
    {
        title: "Power over Ethernet (PoE) Considerations",
        text: "Many devices now use PoE - here's what you need to know:\n\n⚡ POE BASICS:\n\n🔋 **PoE Standards:**\n• PoE (802.3af): 15.4W\n• PoE+ (802.3at): 30W  \n• PoE++ (802.3bt): 60-100W\n\n📱 **Common PoE Devices:**\n• IP cameras (most common)\n• Wireless access points\n• VoIP phones\n• Door access controls\n• LED lighting\n\n🔌 **Cat 6 and PoE:**\n• Cat 6 handles all PoE standards\n• Uses all 4 pairs (pins 1-8)\n• Cable quality matters more with PoE\n• Heat generation increases\n• Maximum 328 feet still applies\n\n⚠️ **PoE Installation Tips:**\n• Use quality connectors (cheap ones fail with PoE)\n• All 8 wires MUST be perfect\n• Test with PoE tester if possible\n• Don't bundle 50+ PoE cables (heat buildup)\n• Document which runs carry PoE\n\n💡 PoE troubleshooting: If device powers on but network fails, check data pairs (1,2,3,6)",
    },
    {
        title: "Cable Types and When to Use Them",
        text: "Not all Cat 6 is the same! Here's what you need to know:\n\n📦 CAT 6 VARIANTS:\n\n🏢 **Plenum (CMP)**\n• Fire-resistant jacket\n• Required in air-handling spaces\n• Most expensive option\n• Use: Above drop ceilings, HVAC areas\n\n🏠 **Riser (CMR)**\n• Flame-retardant\n• For vertical runs between floors\n• Mid-range price\n• Use: Elevator shafts, between-floor runs\n\n📋 **General Purpose (CM/CMG)**\n• Basic indoor cable\n• Least expensive\n• Use: Within same floor, non-plenum areas\n\n🌧️ **Outdoor (CMX/Direct Burial)**\n• UV-resistant jacket\n• Water-resistant or waterproof\n• Some can be buried\n• Use: Outside runs, underground\n\n🛡️ **Shielded (STP) vs Unshielded (UTP)**\n• UTP: Standard, 95% of installs\n• STP: EMI-heavy environments (factories, hospitals)\n• STP requires grounded connections\n\n⚠️ ALWAYS verify cable type matches application!",
        quiz: {
            question: "Which type of Cat 6 cable is required for installation above a drop ceiling?",
            options: [
                "General Purpose (CM)",
                "Plenum (CMP) - fire-resistant",
                "Riser (CMR)",
                "Any Cat 6 cable works"
            ],
            correctAnswer: 1,
            correctFeedback: "🔥 Correct! Plenum-rated cable (CMP) is required in air-handling spaces because it produces less toxic smoke in a fire. Building codes enforce this!",
            incorrectFeedback: "Plenum (CMP) rated cable is required by building code in air-handling spaces like above drop ceilings. It's fire-resistant and produces less toxic smoke."
        }
    },
    {
        title: "Common Installation Mistakes to Avoid",
        text: "Learn from others' mistakes! Here are the top failures I see:\n\n❌ CRITICAL MISTAKES:\n\n🔴 **Over-Untwisting Wires**\n• Problem: Untwist more than 0.5\" from jacket\n• Result: Failed certification (high crosstalk)\n• Fix: Minimize untwisted length\n\n🔴 **Not Bottoming Out Wires**\n• Problem: Wires don't reach end of connector\n• Result: Intermittent connection, failed test\n• Fix: Push wires firmly, verify through clear end\n\n🔴 **Jacket Outside Connector**\n• Problem: No strain relief on cable\n• Result: Wires pull out over time\n• Fix: Ensure 1/4\" jacket inside connector\n\n🔴 **Exceeding Pull Tension**  \n• Problem: Yanking cable or over-pulling\n• Result: Stretched conductors, internal damage\n• Fix: Pull slowly, never exceed 25 lbs force\n\n🔴 **Sharp Bends**\n• Problem: Bending tighter than 4x cable diameter\n• Result: Internal wire damage, failed tests\n• Fix: Use proper radius, add corner protection\n\n🔴 **Using Wrong Cable Type**\n• Problem: Non-plenum in ceiling\n• Result: Code violation, potential fine\n• Fix: Always verify specs before ordering",
    },
    {
        title: "Documentation and Labeling",
        text: "Professional documentation sets you apart. Here's the system:\n\n📋 DOCUMENTATION CHECKLIST:\n\n🏷️ **Physical Labels:**\n• Both cable ends labeled identically\n• Format: [Floor]-[Room]-[Jack#]-[Date]\n• Example: \"2F-205-J03-110924\"\n• Placed 6\" from termination\n• Permanent, waterproof labels\n\n📄 **Cable Schedule:**\nCreate spreadsheet with:\n• Cable ID\n• Source location (patch panel port)\n• Destination location (wall jack)\n• Cable length\n• Installation date\n• Test results (Pass/Fail)\n• Notes (PoE, special use, etc.)\n\n📸 **Photo Documentation:**\n• Before: Empty spaces\n• During: Cable routing\n• After: Completed terminations\n• Network closet organization\n• Wall jack installations\n\n🗺️ **As-Built Drawings:**\n• Mark actual cable routes (not planned)\n• Update floor plans\n• Note access points\n• Include in final deliverable\n\nGood documentation = happy clients + easy troubleshooting!",
    },
    {
        title: "Pricing Your Cable Installation Work",
        text: "Know your worth! Here's how to price cable installation jobs:\n\n💰 PRICING STRUCTURE:\n\n📊 **Per-Drop Pricing** (Most Common)\n• Basic run (under 150ft): $125-200 per drop\n• Long run (150-300ft): $200-300 per drop  \n• Difficult access: $250-400 per drop\n• Includes: Cable, connectors, labor, testing\n\n⏱️ **Time Estimates:**\n• Simple drop (open ceiling): 1-1.5 hours\n• Through walls: 2-3 hours\n• Fishing difficult areas: 3-4 hours\n• Patch panel termination: 30-45 min per port\n\n🔧 **Additional Charges:**\n• Patch panel: $150-300 (hardware + labor)\n• Wall plates/jacks: $15-30 each\n• Cable certification: $25-50 per drop\n• After-hours work: 1.5-2x normal rate\n• Weekend work: 1.5-2x normal rate\n\n📦 **Material Markup:**\n• Cable: Cost + 30-50%\n• Connectors: Cost + 50-100%\n• Panels/hardware: Cost + 30-50%\n\n💡 ALWAYS get site survey before quoting complex jobs!",
    },
    {
        title: "Safety and Best Practices",
        text: "Stay safe and protect yourself legally:\n\n⚠️ SAFETY REQUIREMENTS:\n\n🦺 **Personal Protection:**\n• Safety glasses when drilling\n• Gloves when handling fiberglass\n• Knee pads for attic/crawlspace work\n• Hard hat in active construction\n• Steel-toe boots on job sites\n\n⚡ **Electrical Safety:**\n• Verify power off before drilling\n• Use non-contact voltage tester\n• Assume all wires are live\n• Keep 12\" from electrical when possible\n• NEVER work on live electrical\n\n🏗️ **Ladder Safety:**\n• 3-point contact at all times\n• Level and stable ground\n• Secure ladder at top when possible\n• Don't overreach\n• Use proper height ladder\n\n📋 **Legal Protection:**\n• Liability insurance ($1-2M recommended)\n• Worker's comp if you have employees\n• Proper business license\n• Follow local building codes\n• Get permits when required\n\n💡 A safe tech is an employed tech!",
        quiz: {
            question: "What is the minimum safe distance to maintain from electrical wiring when running Cat 6 cable?",
            options: [
                "6 inches",
                "12 inches minimum (2 inches if in conduit)",
                "No separation needed",
                "24 inches always"
            ],
            correctAnswer: 1,
            correctFeedback: "⚡ Perfect! Maintain at least 12 inches separation from electrical lines, or 2 inches if your data cable is in conduit. This prevents interference and meets code.",
            incorrectFeedback: "The standard is 12 inches minimum separation from electrical wiring (or 2 inches if your cable is in conduit). This prevents electrical interference with your data signals."
        }
    },
    {
        title: "Fiber Optics: When Cat 6 Isn't Enough",
        text: "Sometimes you need to know when NOT to use copper:\n\n🌟 WHEN TO RECOMMEND FIBER:\n\n📏 **Distance Limitations:**\n• Cat 6 maximum: 328 feet (100 meters)\n• Fiber: Up to 40km (single-mode)\n• Between buildings: Always use fiber\n• Building-to-building: Fiber prevents ground loops\n\n⚡ **Speed Requirements:**\n• 10 Gbps beyond 180 feet? Fiber\n• 40 Gbps or 100 Gbps? Fiber only\n• Future-proofing? Consider fiber\n\n🛡️ **Environment Factors:**\n• High EMI areas (factories): Fiber immune to interference\n• Lightning-prone areas: Fiber provides isolation\n• Electrical noise: Fiber unaffected\n• Secure data: Fiber harder to tap\n\n💰 **Cost Considerations:**\n• Fiber cable: More expensive\n• Termination: Requires special skills/tools\n• Transceivers: $50-500 each\n• Worth it for: Long runs, high security, extreme speeds\n\n📚 Fiber is a specialty - consider training or subcontracting!",
    },
    {
        title: "Building Your Cable Installation Business",
        text: "Ready to make cable installation a profit center? Here's how:\n\n🚀 BUSINESS GROWTH STRATEGY:\n\n🎯 **Target Markets:**\n• Small business offices (10-50 drops)\n• Retail store buildouts\n• Warehouse/industrial IoT\n• Residential smart homes\n• Property management companies\n\n📈 **Scaling Your Services:**\n\nYEAR 1: Master the basics\n• Perfect your terminations\n• Build basic tool kit\n• Take small jobs (5-10 drops)\n• Build reputation\n\nYEAR 2: Add capabilities  \n• Get cable certifier\n• Learn patch panel work\n• Hire helper/apprentice\n• Take larger jobs (50+ drops)\n\nYEAR 3: Become full-service\n• Add fiber capabilities\n• Offer network equipment\n• Build install crews\n• Bid on commercial projects\n\n💼 **Marketing Tips:**\n• Partner with IT companies\n• Network with general contractors\n• Join local BICSI chapter\n• Get BICSI installer certification\n• Build portfolio with photos\n\nCabling is steady, profitable work!",
    },
    {
        title: "Certification and Continuing Education",
        text: "Professional certifications increase your value and rates:\n\n🎓 RECOMMENDED CERTIFICATIONS:\n\n🏆 **BICSI Installer Certifications:**\n\n📘 **BICSI Installer 1 (Entry Level)**\n• Cost: ~$300 exam\n• Topics: Basic cabling, standards, safety\n• Value: Shows professional commitment\n• Time: 2-3 months study\n\n📗 **BICSI Installer 2 (Intermediate)**\n• Cost: ~$350 exam  \n• Topics: Advanced installation, testing, fiber basics\n• Value: Command higher rates ($5-10/hr more)\n• Time: 6-12 months experience recommended\n\n🔵 **BICSI Technician**\n• Cost: ~$400 exam\n• Topics: Troubleshooting, certification testing, repair\n• Value: Required for some contracts\n\n📚 **Additional Training:**\n• Fiber optic certification (FOA CFOT)\n• Fluke certifier training\n• OSHA 10 or 30-hour safety\n• Manufacturer-specific (Panduit, CommScope)\n\n💰 ROI: Certifications pay for themselves in 2-3 jobs!",
    },
    {
        title: "Final Knowledge Check",
        text: "Let's verify you've mastered Cat 6 installation! This comprehensive question covers the key concepts:\n\nYou've learned:\n✅ Cat 6 specifications and capabilities\n✅ Essential tools for installation and testing  \n✅ Commercial and residential techniques\n✅ TIA-568B termination standard\n✅ Proper testing and troubleshooting\n✅ Professional cable management\n✅ Safety and best practices\n✅ Business and pricing strategies\n\nYou're ready to take on professional cable installation jobs. Remember:\n• Quality over speed (at first)\n• Test EVERY cable\n• Document everything\n• Keep learning and improving\n\nNow prove you've got this!",
        quiz: {
            question: "You're installing Cat 6 in an office above a drop ceiling. Which factors are MOST critical for a professional installation?",
            options: [
                "Just run the cable as fast as possible",
                "Use plenum-rated cable, maintain 12\" from electrical, support every 5 feet, test every termination",
                "Any Cat 6 works, zip-tie it anywhere convenient",
                "Only testing matters, installation method doesn't"
            ],
            correctAnswer: 1,
            correctFeedback: "🎉 OUTSTANDING! You've mastered professional cable installation! You understand code requirements (plenum), electrical safety (12\" separation), proper support (every 5'), and quality assurance (testing). You're ready to deliver pro-level work!",
            incorrectFeedback: "Professional installation requires: Plenum-rated cable (building code), 12\" electrical separation (safety + performance), proper support every 5 feet (prevent sag), and testing every cable (quality assurance). These aren't optional!"
        }
    },
    {
        title: "Congratulations - You're Certified!",
        text: "🎓 **OUTSTANDING WORK!**\n\nYou've completed the Cat 6 Cable Installation & Termination training!\n\nYou now know:\n\n✅ Cat 6 cable specifications and selection\n✅ Professional installation techniques (commercial & residential)\n✅ TIA-568B termination standard\n✅ Proper testing and certification procedures\n✅ Troubleshooting failed connections\n✅ Cable management best practices\n✅ Safety protocols and code compliance\n✅ Business operations and pricing strategies\n\n🚀 **Your Next Steps:**\n\n1. Practice terminations (buy practice cable!)\n2. Start with simple residential jobs\n3. Build your tool kit gradually\n4. Document every installation\n5. Consider BICSI certification\n6. Never stop learning!\n\n💼 **Cable installation is everywhere:**\n• Every office needs cabling\n• Retail stores constantly update\n• Warehouses adding IoT devices\n• Homes going smart\n• Security camera installations\n\nYou've gained a skill that will provide steady income for years. Now go out there and start pulling cable professionally!\n\n📜 Download your certificate and add this to your resume!",
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
    <Head title="Cat 6 Cable Installation Training" />

    <AuthenticatedLayout>
        <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
            <div v-if="!showCertificate">
                <TutorialSlides 
                    :slides="tutorialSlides"
                    :product-name="product.name"
                    @complete="handleTutorialComplete"
                />
            </div>

            <!-- Certificate Display -->
            <div v-else class="py-12">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="bg-white rounded-lg shadow-2xl p-8 text-center">
                        <div class="mb-6">
                            <div class="text-6xl mb-4">🎓</div>
                            <h1 class="text-4xl font-bold text-gray-900 mb-2">Congratulations!</h1>
                            <p class="text-xl text-gray-600">You've completed the Cat 6 Cable Installation Training</p>
                        </div>

                        <div class="bg-orange-50 border-2 border-orange-200 rounded-lg p-6 mb-6">
                            <p class="text-lg text-gray-700 mb-2">Your Score:</p>
                            <p class="text-5xl font-bold text-orange-600">{{ certificate?.score || 0 }}%</p>
                        </div>

                        <div class="space-y-4">
                            <p class="text-gray-600">
                                You've mastered professional Cat 6 cable installation, termination, and testing!
                            </p>
                            
                            <button
                                @click="downloadCertificate"
                                class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors duration-200"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download Certificate
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
