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
        title: "Welcome to CCTV Camera Troubleshooting!",
        text: "Hey there! Ready to become a CCTV troubleshooting expert? I'm your FieldOps Pro guide, and I'm going to teach you everything about diagnosing and fixing both PoE digital cameras and analog CCTV systems!\n\nThis comprehensive training covers:\n\n📹 Understanding PoE (Power over Ethernet) systems\n📺 Analog camera fundamentals\n🔧 Common failure points and diagnostics\n⚡ Power and connectivity issues\n📡 Video signal problems\n🌐 Network configuration troubleshooting\n🧪 Testing equipment and techniques\n\nCCTV systems are EVERYWHERE - offices, retail stores, warehouses, parking lots. Master these troubleshooting skills and you'll always be in demand. Let's dive in!",
        image: "https://images.unsplash.com/photo-1557597774-9d273605dfa9?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Modern CCTV surveillance systems combining PoE and analog technologies"
    },
    {
        title: "Understanding PoE Camera Systems",
        text: "Let's start with PoE (Power over Ethernet) digital cameras - the modern standard for CCTV installations.\n\n🔌 HOW PoE WORKS:\nPoE delivers both power AND data over a single Ethernet cable (Cat5e/Cat6). No separate power cable needed!\n\n🏗️ SYSTEM COMPONENTS:\n\n📷 IP Camera - Network-connected camera with built-in processor\n🔄 PoE Switch/Injector - Provides 15.4W to 30W per port\n💾 NVR (Network Video Recorder) - Stores and manages video\n🌐 Network Infrastructure - Cables, routers, switches\n\n⚡ POE STANDARDS:\n• PoE (802.3af) = 15.4W - Basic cameras\n• PoE+ (802.3at) = 30W - PTZ cameras\n• PoE++ (802.3bt) = 60-100W - High-power systems\n\nKnowing these basics helps you diagnose 90% of PoE camera issues!",
        image: "https://images.unsplash.com/photo-1558346490-a72e53ae2d4f?w=1200&h=600&fit=crop&q=80",
        imageCaption: "PoE IP camera system with network switch and NVR"
    },
    {
        title: "Understanding Analog Camera Systems",
        text: "Now let's cover analog CCTV systems - still widely used and often what you'll encounter in older installations.\n\n📺 HOW ANALOG WORKS:\nAnalog cameras send video signals over coaxial cable (like old TV antennas). Simple and reliable!\n\n🏗️ SYSTEM COMPONENTS:\n\n📹 Analog Camera - Captures in analog format (CVBS, AHD, TVI, CVI)\n📀 DVR (Digital Video Recorder) - Converts analog to digital\n🔌 Power Supply - Separate 12V DC for each camera\n🔗 Cabling - RG59/RG6 coaxial for video, separate power wires\n\n📊 VIDEO FORMATS:\n• CVBS - Traditional analog (low res)\n• AHD - HD over coax (720p-1080p)\n• TVI/CVI - Competing HD-over-coax standards\n\n💡 KEY DIFFERENCE:\nAnalog = Separate power and video cables\nPoE = Combined in one Ethernet cable\n\nUnderstanding both systems makes you valuable - many sites have mixed installations!",
        image: "https://images.unsplash.com/photo-1557597774-9d47605007b1?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Traditional analog CCTV cameras with coaxial cabling and DVR system"
    },
    {
        title: "Essential Technician's Toolkit",
        text: "Having the right tools makes troubleshooting 10X easier and faster. Here's your complete shopping list!\n\n⚡ FOR PoE/DIGITAL SYSTEMS:\n✅ PoE Tester/Validator - Test voltage and data\n✅ Network Cable Tester - Verify all 8 wires\n✅ Multimeter - Measure voltage accurately\n✅ Laptop - Configure cameras and test network\n✅ Ethernet Crimping Tool - Make/repair cables\n✅ RJ-45 Connectors - Have extras on hand\n\n📺 FOR ANALOG SYSTEMS:\n✅ Multimeter - Test 12V DC power\n✅ Portable Test Monitor - See video at camera\n✅ Coax Cable Tester - Check cable integrity\n✅ BNC Compression Tool - Professional connections\n✅ BNC Connectors - Various sizes\n\n📱 UNIVERSAL TOOLS:\n✅ Smartphone with Camera - Document everything\n✅ Flashlight/Headlamp - See in dark spaces\n✅ Label Maker - Organize your work\n✅ Notepad - Track IPs and settings\n\nClick the links below to see recommended tools on Amazon!",
        image: "https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Professional CCTV technician toolkit with testers and hand tools",
        links: [
            {
                icon: "🔌",
                title: "PoE Network Cable Tester (TRENDnet)",
                price: "$79.99",
                url: "https://www.amazon.com/TRENDnet-Network-Cable-Tester-TC-NT3/dp/B01M63EMBQ"
            },
            {
                icon: "⚡",
                title: "PoE Voltage Tester & Power Checker",
                price: "$45.99",
                url: "https://www.amazon.com/Klein-Tools-VDV500-820-Cable-Tester/dp/B07MKZHRRY"
            },
            {
                icon: "📏",
                title: "KAIWEETS Digital Multimeter (Affordable)",
                price: "$39.99",
                url: "https://www.amazon.com/KAIWEETS-Multimeter-Resistance-Capacitance-Temperature/dp/B07SHLS639"
            },
            {
                icon: "📺",
                title: "Portable Test Monitor (7\" LCD)",
                price: "$89.99",
                url: "https://www.amazon.com/LILLIPUT-7-Inch-Monitor-HDMI-Input/dp/B00HZN0D9U"
            },
            {
                icon: "🔧",
                title: "Professional RJ45 Crimping Tool Kit",
                price: "$29.99",
                url: "https://www.amazon.com/iCrimp-Crimping-Connectors-Stripper-Accessories/dp/B01K4JE53Q"
            },
            {
                icon: "🔌",
                title: "BNC Compression Tool for Coax",
                price: "$34.99",
                url: "https://www.amazon.com/Klein-Tools-VDV212-015-Compression-Connectors/dp/B002D3B97U"
            }
        ],
        quiz: {
            question: "What's the main advantage of using a PoE tester over just a multimeter?",
            options: [
                "It's cheaper and easier to use",
                "It tests both power delivery AND data connectivity in one tool",
                "You don't need one - multimeters are enough",
                "PoE testers can fix cameras automatically"
            ],
            correctAnswer: 1,
            correctFeedback: "🎯 Exactly! A PoE tester verifies both power AND network connectivity, saving you time by testing everything at once.",
            incorrectFeedback: "Think about what makes PoE special - it combines power and data. A PoE tester checks both functions simultaneously!"
        }
    },
    {
        title: "Interactive Scenario 1: The Dead Camera",
        text: "🎬 REAL-WORLD SCENARIO:\n\nYou arrive at a retail store. The manager says: \"Camera 3 in the back room stopped working yesterday. It's completely dead - no lights, nothing on the monitor.\"\n\nYou walk to the camera location and observe:\n• Camera is mounted 12 feet high\n• No LED lights visible on camera\n• Cable runs through ceiling\n• Other 7 cameras in store work fine\n• System uses PoE IP cameras\n• 16-port PoE switch in server closet\n\nWhat's your FIRST troubleshooting step?",
        image: "https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=1200&h=600&fit=crop&q=80",
        imageCaption: "CCTV camera mounted in retail environment - troubleshooting scenario",
        quiz: {
            question: "What should you check FIRST?",
            options: [
                "Immediately climb ladder and take camera down to bench test it",
                "Check the PoE switch to see if the port has link lights and is providing power",
                "Replace the camera with a new one to see if that fixes it",
                "Check if the NVR software needs updating"
            ],
            correctAnswer: 1,
            correctFeedback: "✅ Perfect! Always start at the switch - it's safer, faster, and tells you if power is being delivered. No need to climb a ladder yet! You see no link lights on port 3. Next step: Test the port with your PoE tester...",
            incorrectFeedback: "Think about working safely and efficiently. Before climbing ladders or replacing parts, check the POWER SOURCE first. Head to that PoE switch!"
        }
    },
    {
        title: "Scenario 1 Continued: Testing the Switch",
        text: "Good decision! You head to the server closet and check the PoE switch.\n\n🔍 WHAT YOU OBSERVE:\n• Switch is powered on (green power LED)\n• Ports 1, 2, 4-8 show green link lights\n• Port 3 (dead camera) shows NO link light\n• Switch shows 16 ports, 120W total PoE budget\n• Label says \"Port 3 = Back Room Camera\"\n\nYou plug your PoE tester into port 3...\n\n⚡ TESTER RESULTS:\n• No voltage detected\n• No data link\n• Port appears completely dead\n\nWhat's your next move?",
        image: "https://images.unsplash.com/photo-1560732488-6b0df240254a?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Network switch with PoE ports - some showing link lights, one dead",
        quiz: {
            question: "Port 3 shows no power or link. What should you do next?",
            options: [
                "The switch is bad - replace the entire switch immediately",
                "Test the same PoE tester on port 9 (empty port) to see if the switch can deliver PoE at all",
                "The cable from port 3 to the camera must be bad - start pulling new cable",
                "Call the camera manufacturer for technical support"
            ],
            correctAnswer: 1,
            correctFeedback: "🎯 Excellent troubleshooting! You test port 9 and get 52V PoE! The switch CAN deliver power. This tells you: ✅ Switch works ✅ Your tester works ❌ Port 3 is dead OR the cable is bad. Next: Let's test if it's the port or the cable...",
            incorrectFeedback: "Don't jump to conclusions! Test if the SWITCH can deliver PoE on other ports. This verifies your switch and your tester are working."
        }
    },
    {
        title: "Scenario 1 Continued: Port vs Cable?",
        text: "Smart! You tested port 9 (empty) and got 52V PoE. The switch is good!\n\n🤔 THE QUESTION:\nIs port 3 dead, or is the cable bad?\n\n🧪 YOUR TEST:\nYou unplug the back room camera cable from port 3, then plug it into the working port 9.\n\nYou connect your PoE tester to the CAMERA END of the cable (at the ceiling).\n\n⚡ RESULT:\nYour PoE tester shows: 48V detected! Data link established!\n\n💡 WHAT THIS TELLS YOU:\n✅ The cable is GOOD (delivers power and data)\n✅ The switch port 9 works\n❌ The switch port 3 is DEAD\n\nNow you know the problem!",
        image: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Testing cable with PoE tester - isolating the problem",
        quiz: {
            question: "You've confirmed port 3 is dead but the cable is good. What's the best solution?",
            options: [
                "Replace the entire PoE switch ($300-500) since port 3 doesn't work",
                "Simply move the camera cable to port 9 and update your documentation - camera works now!",
                "Run a completely new cable because you can't trust the switch",
                "Tell the customer the camera needs replacing"
            ],
            correctAnswer: 1,
            correctFeedback: "💰 Perfect! Port 9 works, cable works, camera works. Just move the connection! Update your port labels: \"Port 9 = Back Room Camera (was port 3)\". Document that port 3 is dead. Job done in 15 minutes! The customer is happy and you look like a pro. This is real-world troubleshooting - systematic, fast, and cost-effective!",
            incorrectFeedback: "Think cost-effectively! You have 16 ports and one is dead. The switch still has 15 working ports. Why replace anything when you can just use a different port?"
        }
    },
    {
        title: "Understanding PoE Power Budgets",
        text: "Let's dive deeper into PoE power budgets - this trips up many techs!\n\n💡 THE CONCEPT:\nEvery PoE switch has a TOTAL power budget. Add up all connected devices - if you exceed it, cameras won't power on!\n\n📊 VISUAL EXAMPLE:\nSwitch: 16 ports, 120W total budget\n\n✅ SCENARIO A - Works:\n• 6 cameras @ 15W each = 90W\n• 2 cameras @ 12W each = 24W\n• Total: 114W / 120W (96% used) ✓\n\n⚠️ SCENARIO B - Danger Zone:\n• 8 cameras @ 15W each = 120W\n• Total: 120W / 120W (100% used)\n• NO HEADROOM - any spike fails!\n\n❌ SCENARIO C - Failure:\n• 10 cameras @ 15W each = 150W\n• Exceeds 120W budget\n• Last 2 cameras won't power on!\n\n🎯 PROFESSIONAL TIP:\nAlways plan for 80% max usage (96W of 120W). This gives you headroom for power spikes!",
        image: "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1200&q=80",
        imageCaption: "PoE power budget visualization showing working vs failed scenarios"
    },
    {
        title: "Interactive Scenario 2: Mysterious Power Issues",
        text: "🎬 NEW SCENARIO:\n\nYou get a call: \"Our cameras keep going offline randomly, usually in the afternoon.\"\n\nYou investigate and find:\n• 12 PoE cameras on site\n• 16-port PoE switch, 200W budget\n• 10 cameras work fine\n• Cameras 11 and 12 randomly reboot\n• Problem started 2 weeks ago\n• Client recently added 2 new cameras (#11 and #12)\n\nYou check power consumption:\n• Cameras 1-10: 12W each = 120W\n• Cameras 11-12: 30W each = 60W\n• Total: 180W / 200W budget\n\nThe math says it should work! But cameras 11-12 still reboot randomly...\n\nWhat could be wrong?",
        image: "https://images.unsplash.com/photo-1573167243872-43c6433b9d40?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Multiple security cameras - intermittent power issues",
        quiz: {
            question: "Math says 180W/200W should work, but cameras reboot. What's the likely cause?",
            options: [
                "The cameras are defective and need replacement",
                "Environmental heat causes power consumption spikes beyond rated specs",
                "The network bandwidth is too high",
                "Someone is unplugging cameras as a prank"
            ],
            correctAnswer: 1,
            correctFeedback: "🔥 Brilliant! HEAT is the culprit! In afternoon sun, camera power consumption spikes 20-30% above rated specs. 180W + 20% = 216W! This exceeds the 200W budget. Solutions: 1) Add a second PoE switch, 2) Use PoE injectors for cameras 11-12, 3) Add sunshades to reduce heat. Real-world troubleshooting considers environment, not just specs!",
            incorrectFeedback: "Think about WHEN it happens - afternoons. What changes? Temperature! Hot cameras draw more power. Your 180W rating can spike to 216W in heat!"
        }
    },
    {
        title: "Network Configuration Basics",
        text: "PoE cameras live on your network - understanding IP addressing is CRUCIAL!\n\n🌐 IP ADDRESS BASICS:\n\nEvery device needs a unique IP address in the same subnet.\n\n✅ CORRECT SETUP:\nNVR: 192.168.1.100\nCamera 1: 192.168.1.101\nCamera 2: 192.168.1.102\n(All in 192.168.1.x subnet) ✓\n\n❌ COMMON MISTAKE:\nNVR: 192.168.1.100\nCamera: 192.168.0.50\n(Different subnets - won't talk!) ✗\n\n🔧 DHCP vs STATIC:\n\n📡 DHCP (Dynamic):\n• Router assigns IPs automatically\n• Good: Easy setup\n• Bad: IPs can change, cameras disappear\n\n📌 STATIC (Fixed):\n• You manually set each IP\n• Good: IPs never change, reliable\n• Bad: Takes more setup time\n\n💡 PRO RECOMMENDATION:\nUse STATIC IPs for cameras. Document them all!",
        image: "https://images.unsplash.com/photo-1544197150-b99a580bb7a8?w=1200&q=80",
        imageCaption: "IP address subnet configuration diagram for CCTV systems"
    },
    {
        title: "Interactive Scenario 3: The Invisible Camera",
        text: "🎬 CHALLENGING SCENARIO:\n\nCustomer: \"I installed a new IP camera but can't see it in my NVR. The camera has power - I see lights on it.\"\n\nYOU OBSERVE:\n• Camera power LED is ON (green)\n• Network link light is BLINKING (data flowing)\n• NVR shows 5 cameras, this would be #6\n• NVR IP: 192.168.1.100\n• Other cameras: 192.168.1.101-105\n\nYou run an IP scanner...\n\n📡 SCAN RESULTS:\n192.168.1.100 - NVR\n192.168.1.101 - Camera 1\n192.168.1.102 - Camera 2\n192.168.1.103 - Camera 3\n192.168.1.104 - Camera 4\n192.168.1.105 - Camera 5\n192.168.0.64 - Unknown device!\n\nWhat's wrong?",
        image: "https://images.unsplash.com/photo-1550751827-4bd374c3f58b?w=1200&h=600&fit=crop&q=80",
        imageCaption: "IP camera with LED lights showing power and network activity",
        links: [
            {
                icon: "🔍",
                title: "Advanced IP Scanner (Free Software)",
                price: "Free",
                url: "https://www.advanced-ip-scanner.com/"
            },
            {
                icon: "🔍",
                title: "SADP Tool - Hikvision IP Config",
                price: "Free",
                url: "https://www.hikvision.com/en/support/tools/hitools/cl1f27f97b2e3d7b0e/"
            }
        ],
        quiz: {
            question: "The camera is at 192.168.0.64 but the NVR is at 192.168.1.100. Why can't they communicate?",
            options: [
                "The camera is too far away from the NVR",
                "Different subnets (192.168.0.x vs 192.168.1.x) - they can't see each other",
                "The camera needs a firmware update",
                "The NVR is full and can't add more cameras"
            ],
            correctAnswer: 1,
            correctFeedback: "🎯 Perfect! The camera came preset to 192.168.0.64 (different subnet). The NVR is in 192.168.1.x subnet. They're like different neighborhoods - can't talk! SOLUTION: 1) Connect laptop to camera, 2) Access camera web interface at 192.168.0.64, 3) Change camera IP to 192.168.1.106 (static), 4) Change subnet mask to match (255.255.255.0), 5) Now NVR can see it! Always check subnets first!",
            incorrectFeedback: "Look at the IP addresses! 192.168.0.64 vs 192.168.1.100 - they're in different subnets. Devices must be in the same subnet to communicate."
        }
    },
    {
        title: "Analog Camera Troubleshooting",
        text: "Now let's master analog systems - different technology, different problems!\n\n📺 ANALOG SIGNAL PATH:\nCamera → Coax Cable → DVR → Display\n\n🔍 COMMON SYMPTOMS & CAUSES:\n\n❄️ SNOWY/STATIC IMAGE:\n• Weak signal (cable too long)\n• Bad connectors (corrosion)\n• Damaged coax shield\n→ Test with portable monitor at camera\n\n🌊 ROLLING HORIZONTAL LINES:\n• Ground loop interference\n• AC power interference\n→ Use ground loop isolator\n\n⚫ COMPLETE BLACK SCREEN:\n• No power to camera\n• Completely bad cable\n• Wrong DVR input selected\n→ Check voltage at camera first\n\n🔅 DIM/DARK IMAGE:\n• Voltage drop (cable too long)\n• Undersized wire gauge\n• Weak power supply\n→ Measure voltage: should be 11.5-12.5V\n\n👥 GHOSTING/DOUBLE IMAGE:\n• Impedance mismatch\n• Cable termination wrong\n→ Check 75Ω termination",
        image: "https://images.unsplash.com/photo-1600783245777-6d0ac96c0096?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Analog CCTV camera installation with coaxial cabling"
    },
    {
        title: "The Voltage Drop Calculator",
        text: "Voltage drop is the #1 killer of analog cameras! Let's master it.\n\n⚡ THE PROBLEM:\n12V at power supply → 9V at camera = Camera fails!\n\n🧮 VOLTAGE DROP FORMULA:\nDrop (V) = (2 × Length × Current × Resistance) ÷ 1000\n\nWhere:\n• Length = meters of cable\n• Current = amps camera draws\n• Resistance = Ω/km of wire gauge\n\n📊 WIRE RESISTANCE:\n• 18 AWG = 21 Ω/km\n• 16 AWG = 13 Ω/km\n• 14 AWG = 8 Ω/km\n\n💡 REAL EXAMPLE:\n• Cable: 150m run\n• Camera: 0.5A draw\n• Wire: 18 AWG (21 Ω/km)\n\nDrop = (2 × 150 × 0.5 × 21) ÷ 1000\nDrop = 3,150 ÷ 1000 = 3.15V\n\nCamera gets: 12V - 3.15V = 8.85V ❌\n(Minimum needed: 11V)\n\n✅ SOLUTION: Use 16 AWG wire!\nDrop = (2 × 150 × 0.5 × 13) ÷ 1000 = 1.95V\nCamera gets: 12V - 1.95V = 10.05V ❌ Still too low!\n\n✅ BEST SOLUTION: Use 14 AWG OR add mid-point power!",
        image: "https://images.unsplash.com/photo-1621905251918-48416bd8575a?w=1200&q=80",
        imageCaption: "Voltage drop chart showing wire gauge vs cable length"
    },
    {
        title: "Interactive Scenario 4: The Dying Camera",
        text: "🎬 TRICKY SCENARIO:\n\nCustomer: \"Camera was working fine, then started showing a dark image. Now it's completely dead.\"\n\nYOUR INVESTIGATION:\n• Analog camera, 300 feet from DVR\n• Camera powered from central power supply\n• 18 AWG wire used for power\n• Camera rated 12V DC, 500mA\n• Power supply output: 12.2V (measured)\n• Other cameras on shorter runs work fine\n\nYou climb the ladder and measure voltage AT THE CAMERA with your multimeter...\n\n⚡ READING: 8.3V DC\n\nThe camera needs minimum 11V to operate.\n\nWhat's your diagnosis and fix?",
        image: "https://images.unsplash.com/photo-1581092918484-8313e8f28c7d?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Technician measuring voltage at camera with multimeter",
        quiz: {
            question: "Camera gets 8.3V instead of 12V due to 300ft run with 18 AWG wire. Best solution?",
            options: [
                "Replace the camera with a 24V model",
                "Run new 14 AWG wire OR install a power supply at the halfway point (150ft)",
                "Increase the power supply to 15V to compensate for drop",
                "Use a wireless camera instead"
            ],
            correctAnswer: 1,
            correctFeedback: "⚡ Excellent! 300ft with 18 AWG is way too much voltage drop. Solutions: 1) Pull 14 AWG wire (lower resistance), or 2) Install power supply at 150ft midpoint (half the distance = 1/4 the drop). Mid-point power is often fastest! You install a small 12V supply at 150ft: Drop = (2 × 46m × 0.5 × 21) ÷ 1000 = 0.96V. Camera now gets 11.24V ✓ Problem solved!",
            incorrectFeedback: "The problem is voltage DROP over distance. You need either lower-resistance wire (thicker gauge) or shorter distance (mid-point power)."
        }
    },
    {
        title: "Cable Testing Like a Pro",
        text: "Proper cable testing saves HOURS of frustration. Here's the professional method!\n\n🔌 TESTING ETHERNET (PoE CAMERAS):\n\n1️⃣ VISUAL INSPECTION:\n   • Check for kinks, cuts, staple damage\n   • Verify Cat5e minimum (Cat6 better)\n   • Check connector tabs aren't broken\n\n2️⃣ CONTINUITY TEST:\n   • Use cable tester\n   • ALL 8 wires must test good\n   • Check wire map for correct order\n   • Look for shorts between pairs\n\n3️⃣ POE VOLTAGE TEST:\n   • Disconnect camera first!\n   • Measure pins 1-2: should be 48-54V\n   • Measure pins 3-6: should be 48-54V\n   • Both pairs must have voltage\n\n4️⃣ LENGTH TEST:\n   • Max PoE: 100m (328ft)\n   • Most testers measure length\n   • Over 100m = no PoE delivery\n\n📺 TESTING COAX (ANALOG CAMERAS):\n\n1️⃣ CONTINUITY:\n   • Center conductor: ~0Ω\n   • Shield: ~0Ω  \n   • Center to shield: Infinite Ω\n\n2️⃣ VISUAL VIDEO TEST:\n   • Portable monitor at camera\n   • Compare to monitor at DVR\n   • Images should match\n\n3️⃣ CONNECTOR CHECK:\n   • BNC should click firmly\n   • No exposed center conductor\n   • Shield properly crimped",
        image: "https://images.unsplash.com/photo-1581092160607-1e49b2f2a7b4?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Professional network cable tester showing wire map and continuity",
        links: [
            {
                icon: "🔍",
                title: "Klein Tools Cable Tester with Tone",
                price: "$89.99",
                url: "https://www.amazon.com/Klein-Tools-VDV501-851-Cable-Tester/dp/B00OQWBZ92"
            },
            {
                icon: "📏",
                title: "Fluke MicroScanner PoE Cable Verifier",
                price: "$449.99",
                url: "https://www.amazon.com/Fluke-Networks-MS-POE-MicroScanner-Verifier/dp/B008BZBRQ6"
            },
            {
                icon: "🔌",
                title: "Budget-Friendly Cable Tester",
                price: "$24.99",
                url: "https://www.amazon.com/iMBAPrice-Network-Cable-Tester-Phone/dp/B01M63EMBQ"
            }
        ]
    },
    {
        title: "Interactive Scenario 5: The Cable Mystery",
        text: "🎬 DETECTIVE WORK:\n\nYou're called to investigate: \"Camera 4 worked yesterday, nothing today.\"\n\nYOUR TESTS:\n• Power at switch: 52V PoE ✓\n• Switch link light: ON ✓\n• Camera: No power, no LED\n\nYou test with cable tester at the camera end:\n\n📊 TESTER RESULTS:\n✅ Wire 1: Good\n✅ Wire 2: Good\n❌ Wire 3: OPEN (broken)\n✅ Wire 4: Good\n✅ Wire 5: Good\n❌ Wire 6: OPEN (broken)\n✅ Wire 7: Good\n✅ Wire 8: Good\n\n💡 PoE uses:\n• Wires 1-2 for data + power\n• Wires 3-6 for data + power\n\nWires 3 and 6 are broken!\n\nWhat happened?",
        image: "https://images.unsplash.com/photo-1581092795360-fd1ca04f0952?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Cable tester display showing failed wires in red",
        quiz: {
            question: "Wires 1-2 good, wires 3-6 broken, wires 7-8 good. What likely happened?",
            options: [
                "The cable was defective from the factory",
                "Someone stapled or pinched the cable, crushing wires 3-6 in the middle",
                "The camera shorted out and burned the wires",
                "Lightning strike damaged specific wires"
            ],
            correctAnswer: 1,
            correctFeedback: "🎯 Detective work! Wires 3-6 are together in the cable. Damage to ONLY those wires = physical crush injury. You inspect the cable run and find a STAPLE driven through it! Customer says 'Oh yeah, we hung a picture yesterday...' SOLUTION: Cut out damaged section, install two RJ45 connectors and a coupler. Or pull new cable. Document: 'Cable damaged by staple at 8ft height near picture frame.' Customer now understands the damage!",
            incorrectFeedback: "Think about the pattern! Wires 3, 4, 5, 6 are physically grouped together in the cable. Damage to ONLY this group = something crushed the cable at one point."
        }
    },
    {
        title: "Environmental Troubleshooting",
        text: "Cameras don't just fail electrically - environment kills them too!\n\n🌡️ TEMPERATURE ISSUES:\n\n❄️ COLD (Below -10°C/14°F):\n• Condensation inside housing\n• Camera won't boot\n• Lens fogs up\n✅ Fix: Add heater, use cold-rated cameras\n\n🔥 HEAT (Above 50°C/122°F):\n• Camera overheats and shuts down\n• Afternoon failures\n• Dark housings worse\n✅ Fix: Add sunshade, white housing, ventilation\n\n💧 MOISTURE PROBLEMS:\n\n🌧️ SYMPTOMS:\n• Foggy lens\n• Corrosion on connections  \n• Intermittent operation\n• Water inside housing\n\n✅ PREVENTION:\n• IP66 minimum rating\n• Seal ALL cable entries with silicone\n• Point camera down (water drains)\n• Check drainage holes aren't clogged\n• Use outdoor-rated connectors\n\n⚡ LIGHTNING & SURGE:\n\n🌩️ DAMAGE PATTERNS:\n• Multiple cameras fail at once\n• Switch/NVR also damaged\n• Happens after storms\n\n✅ PROTECTION:\n• Surge protectors on EVERY camera\n• Surge protection at switch/NVR\n• Proper system grounding\n• Consider fiber for long runs",
        image: "https://images.unsplash.com/photo-1592210454359-9043f067919b?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Outdoor CCTV cameras in harsh environmental conditions",
        links: [
            {
                icon: "⚡",
                title: "Ethernet Surge Protector (PoE)",
                price: "$39.99",
                url: "https://www.amazon.com/Ubiquiti-ETH-SP-G2-Ethernet-Surge-Protector/dp/B07PGBCQP8"
            },
            {
                icon: "🌡️",
                title: "Camera Housing with Heater/Blower",
                price: "$89.99",
                url: "https://www.amazon.com/Outdoor-Security-Housing-Heater-Blower/dp/B07QKXN8VH"
            }
        ]
    },
    {
        title: "Professional Maintenance Schedule",
        text: "Preventive maintenance keeps systems running and builds recurring revenue!\n\n📅 MONTHLY CHECKS ($100-150/visit):\n\n🧹 Clean camera lenses\n  • Microfiber cloth\n  • Lens cleaning solution\n  • Check for spider webs\n  • Clear IR LED obstructions\n\n📹 Spot-check video quality\n  • Random camera playback\n  • Check focus hasn't drifted\n  • Verify motion detection works\n\n💾 Check storage capacity\n  • Days of recording available?\n  • Storage nearly full?\n  • Plan expansion if needed\n\n📅 QUARTERLY CHECKS ($200-300/visit):\n\n🔌 Inspect connections\n  • Look for corrosion\n  • Tighten loose connections\n  • Check for water intrusion\n  • Test all cameras\n\n⚡ Power system check\n  • Test UPS batteries\n  • Verify PoE budget headroom\n  • Check power supply voltages\n\n🔄 Firmware updates\n  • Check manufacturer sites\n  • Test on one camera first\n  • Document versions\n\n📅 ANNUAL SERVICE ($500-800/visit):\n\n🧪 Full system test\n✅ Replace surge protectors\n🧹 Clean equipment internals  \n🔄 Update NVR/DVR firmware\n🔒 Security audit\n💾 Test backup/restore",
        image: "https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Technician performing preventive maintenance on CCTV system"
    },
    {
        title: "Building Your CCTV Business",
        text: "You've got the skills - now let's talk about making money!\n\n💰 PRICING GUIDE:\n\n🔍 DIAGNOSTIC VISIT:\n$100-150 flat rate\n• Covers first hour\n• Applied to repair if they proceed\n• Non-refundable if they decline\n\n🔧 HOURLY RATE:\n$75-125/hour\n• Varies by region\n• 2-hour minimum\n• After-hours: +50%\n• Emergency: +100%\n\n💼 COMMON JOBS:\n• Camera replacement: $150-250\n• Cable run (100ft): $200-400\n• Network config: $100-200\n• Switch replacement: $300-600  \n• Full system health check: $400-600\n\n📋 MAINTENANCE CONTRACTS (Monthly):\n\n🥉 BASIC ($150/month):\n   • Quarterly visits\n   • Priority scheduling\n   • 10% off repairs\n\n🥈 STANDARD ($300/month):\n   • Monthly visits\n   • Remote monitoring\n   • 20% off repairs\n   • After-hours support\n\n🥇 PREMIUM ($600/month):\n   • Bi-weekly visits\n   • 24/7 monitoring\n   • Free minor repairs\n   • 4-hour response guarantee\n\n💡 RECURRING REVENUE:\n10 clients × $300/month = $3,000/month\nBefore you do ANY project work!\n\nThis is how you build a stable business!",
        image: "https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1200&h=600&fit=crop&q=80",
        imageCaption: "CCTV service business - pricing and contracts planning"
    },
    {
        title: "Final Master Scenario",
        text: "🎬 THE ULTIMATE TEST:\n\nYou're called to a warehouse with 16 PoE cameras. The manager is frustrated:\n\n\"Cameras 13-16 randomly go offline. Sometimes they work, sometimes they don't. It's driving us crazy!\"\n\nYOUR INVESTIGATION:\n• System: 16-port PoE switch, 200W budget\n• Cameras 1-12: 12W each = 144W\n• Cameras 13-16: 30W each = 120W\n• Total: 264W required\n• Budget: 200W available\n\nBUT HERE'S THE TWIST:\nCameras 13-16 are PTZ (Pan-Tilt-Zoom) cameras. They only use 30W when MOVING. When stationary, they use 15W.\n\n• Stationary load: 144W + (4 × 15W) = 204W (exceeds 200W slightly)\n• Moving load: 144W + (4 × 30W) = 264W (way over!)\n\nThe warehouse has motion detection enabled on PTZ cameras. When motion detected, all 4 PTZ cameras start moving simultaneously...\n\nWhat's happening?",
        image: "https://images.unsplash.com/photo-1580894894513-541e068a3e2b?w=1200&h=600&fit=crop&q=80",
        imageCaption: "PTZ surveillance cameras in warehouse environment",
        quiz: {
            question: "Why do cameras 13-16 randomly fail? (Hint: Think about WHEN they fail)",
            options: [
                "The cameras are defective and need warranty replacement",
                "When motion triggers all PTZ cameras to move simultaneously, power demand spikes to 264W, exceeding the 200W budget - last cameras lose power",
                "The network bandwidth is saturated",
                "Someone keeps unplugging the cameras"
            ],
            correctAnswer: 1,
            correctFeedback: "🏆 MASTER LEVEL! You identified a DYNAMIC power budget problem! At rest: barely works (204W). During motion: demand hits 264W, exceeding 200W budget - cameras 13-16 drop! SOLUTIONS: 1) Add 2nd PoE switch for cameras 13-16, 2) Use PoE injectors for PTZ cameras, 3) Stagger motion detection (don't move all PTZs at once), 4) Upgrade to 400W PoE switch. You recommend: Add 4-port PoE+ injectors ($60 each) for cameras 13-16. Total cost: $240. Problem solved! This is REAL troubleshooting - understanding system behavior over time!",
            incorrectFeedback: "Think about WHEN failures occur - during motion! PTZ cameras draw more power while moving. Multiple moving at once = power spike!"
        }
    },
    {
        title: "Congratulations! You're a CCTV Pro! 🎉",
        text: "Outstanding work! You've completed the CCTV Camera Troubleshooting certification!\n\n🎓 YOU NOW KNOW HOW TO:\n\n✅ Systematically troubleshoot PoE cameras\n✅ Diagnose analog camera issues\n✅ Calculate and plan power budgets\n✅ Configure network settings properly\n✅ Test cables like a professional\n✅ Understand environmental impacts\n✅ Solve real-world complex scenarios\n✅ Price services profitably\n✅ Build maintenance contracts\n✅ Create recurring revenue\n\n💼 YOUR NEXT STEPS:\n\n1️⃣ Purchase your essential toolkit (see links earlier)\n2️⃣ Practice on real systems (offer free service to friends)\n3️⃣ Start taking CCTV jobs on FieldNation/WorkMarket\n4️⃣ Build a portfolio with before/after photos\n5️⃣ Join CCTV forums and Facebook groups\n6️⃣ Get manufacturer certifications (Hikvision, Dahua)\n7️⃣ Network with local security installers\n8️⃣ Start offering maintenance contracts\n\n🚀 INCOME POTENTIAL:\n\n💰 Service calls: $75-125/hour\n💰 Installations: $300-800/day  \n💰 Maintenance: $150-600/month per client\n💰 Emergency calls: $150-250/hour\n\n📚 KEEP LEARNING:\n• AI/analytics integration (hot trend!)\n• Cloud-based systems  \n• Thermal cameras\n• License plate recognition\n• Cybersecurity for IP cameras\n\nYou protect people, property, and assets. That's valuable work. Own it and charge accordingly!\n\n🎊 Now go build your CCTV troubleshooting business! 🔧📹💰",
        image: "https://images.unsplash.com/photo-1556745753-b2904692b3cd?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Professional CCTV technician - certified and ready for business"
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
    <Head title="CCTV Camera Troubleshooting" />

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
                    <div class="text-6xl mb-4">🎉📹🎊</div>
                    <h1 class="text-4xl font-bold text-white mb-2">Congratulations!</h1>
                    <p class="text-xl text-gray-300">You've Completed CCTV Camera Troubleshooting Certification</p>
                </div>

                <!-- Certificate Preview -->
                <div class="bg-white rounded-2xl shadow-2xl p-12 mb-8 border-8 border-blue-600">
                    <div class="text-center">
                        <div class="flex justify-center mb-6">
                            <img src="/img/8bit-character.svg" alt="FieldOps Pro" class="w-24 h-24" style="image-rendering: pixelated; image-rendering: crisp-edges;" />
                        </div>
                        
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Certificate of Completion</h2>
                        <div class="w-32 h-1 bg-blue-600 mx-auto mb-6"></div>
                        
                        <p class="text-lg text-gray-600 mb-4">This certifies that</p>
                        <p class="text-3xl font-bold text-blue-600 mb-4">{{ $page.props.auth.user.name }}</p>
                        
                        <p class="text-lg text-gray-600 mb-6">has successfully completed</p>
                        <p class="text-2xl font-bold text-gray-800 mb-6">CCTV Camera Troubleshooting Certification</p>
                        
                        <p class="text-gray-600 mb-8">
                            Demonstrating proficiency in PoE digital camera systems, analog CCTV troubleshooting,<br/>
                            network configuration, cable testing, and professional installation practices
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
                        class="px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg font-bold text-lg hover:from-blue-500 hover:to-blue-600 transition-all shadow-lg shadow-blue-500/50"
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
                    <h3 class="text-2xl font-bold text-white mb-4">📹 You're Ready! Next Steps:</h3>
                    <div class="grid md:grid-cols-2 gap-4 text-gray-300">
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">🛠️</span>
                            <div>
                                <p class="font-semibold text-white">Build your toolkit</p>
                                <p class="text-sm">PoE tester, multimeter, cable tester, portable monitor</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">📋</span>
                            <div>
                                <p class="font-semibold text-white">Practice on real systems</p>
                                <p class="text-sm">Volunteer for friends or low-stakes jobs</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">💼</span>
                            <div>
                                <p class="font-semibold text-white">Start offering CCTV services</p>
                                <p class="text-sm">Add to your FieldNation/WorkMarket profiles</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">📚</span>
                            <div>
                                <p class="font-semibold text-white">Stay updated</p>
                                <p class="text-sm">Join CCTV forums, follow manufacturers</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 text-center text-gray-400 text-sm">
                    <p>Share your achievement with #FieldOpsPro #CCTVPro</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
