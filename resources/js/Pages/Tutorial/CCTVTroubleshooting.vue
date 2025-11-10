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
    },
    {
        title: "Understanding PoE Camera Systems",
        text: "Let's start with PoE (Power over Ethernet) digital cameras - the modern standard for CCTV installations.\n\n🔌 HOW PoE WORKS:\nPoE delivers both power AND data over a single Ethernet cable (Cat5e/Cat6). No separate power cable needed!\n\n🏗️ SYSTEM COMPONENTS:\n\n📷 IP Camera - Network-connected camera with built-in processor\n🔄 PoE Switch/Injector - Provides 15.4W to 30W per port\n💾 NVR (Network Video Recorder) - Stores and manages video\n🌐 Network Infrastructure - Cables, routers, switches\n\n⚡ POE STANDARDS:\n• PoE (802.3af) = 15.4W - Basic cameras\n• PoE+ (802.3at) = 30W - PTZ cameras\n• PoE++ (802.3bt) = 60-100W - High-power systems\n\nKnowing these basics helps you diagnose 90% of PoE camera issues!",
        quiz: {
            question: "What is the main advantage of PoE cameras over traditional cameras?",
            options: [
                "They're cheaper to install",
                "Power and data travel over one cable, simplifying installation",
                "They have better video quality",
                "They don't need any cables at all"
            ],
            correctAnswer: 1,
            correctFeedback: "🎯 Exactly! PoE combines power and data in one cable, making installation cleaner and easier.",
            incorrectFeedback: "Think about what makes PoE special - it's all about combining power and data transmission in a single Ethernet cable!"
        }
    },
    {
        title: "Understanding Analog Camera Systems",
        text: "Now let's cover analog CCTV systems - still widely used and often what you'll encounter in older installations.\n\n📺 HOW ANALOG WORKS:\nAnalog cameras send video signals over coaxial cable (like old TV antennas). Simple and reliable!\n\n🏗️ SYSTEM COMPONENTS:\n\n📹 Analog Camera - Captures in analog format (CVBS, AHD, TVI, CVI)\n📀 DVR (Digital Video Recorder) - Converts analog to digital\n🔌 Power Supply - Separate 12V DC for each camera\n🔗 Cabling - RG59/RG6 coaxial for video, separate power wires\n\n📊 VIDEO FORMATS:\n• CVBS - Traditional analog (low res)\n• AHD - HD over coax (720p-1080p)\n• TVI/CVI - Competing HD-over-coax standards\n\n💡 KEY DIFFERENCE:\nAnalog = Separate power and video cables\nPoE = Combined in one Ethernet cable\n\nUnderstanding both systems makes you valuable - many sites have mixed installations!",
    },
    {
        title: "The Technician's Toolkit",
        text: "Having the right tools makes troubleshooting 10X easier. Here's what you need:\n\n⚡ FOR PoE/DIGITAL SYSTEMS:\n✅ PoE tester/validator ($50-150)\n✅ Network cable tester ($30-200)\n✅ Multimeter for voltage testing ($20-50)\n✅ Laptop with network tools (ping, SADP, IP scanner)\n✅ Ethernet crimping tool ($15-30)\n✅ RJ-45 connectors and cable\n\n📺 FOR ANALOG SYSTEMS:\n✅ Multimeter (12V DC testing)\n✅ Portable test monitor ($50-150)\n✅ Coax cable tester ($30-100)\n✅ BNC compression tool ($20-40)\n✅ BNC connectors\n\n📱 UNIVERSAL TOOLS:\n✅ Phone with good camera (document everything!)\n✅ Flashlight (headlamp is better)\n✅ Label maker\n✅ Notepad for tracking IPs and settings\n\nYou don't need everything day one - start with basics and build your kit!",
        quiz: {
            question: "What's the most important tool for troubleshooting PoE camera power issues?",
            options: [
                "A really expensive laptop",
                "PoE tester and multimeter to measure voltage",
                "Just a screwdriver",
                "A portable monitor"
            ],
            correctAnswer: 1,
            correctFeedback: "⚡ Perfect! A PoE tester and multimeter let you verify power delivery - the #1 cause of PoE camera failures.",
            incorrectFeedback: "Power issues are super common with PoE! You need tools to measure voltage - that's where a PoE tester and multimeter come in."
        }
    },
    {
        title: "PoE Troubleshooting: Camera Has No Power",
        text: "Let's tackle the most common PoE camera issue - no power!\n\n🔍 SYMPTOMS:\n• No lights on camera\n• No link light on switch port\n• Camera not detected on network\n\n🛠️ DIAGNOSTIC STEPS:\n\n1️⃣ CHECK SWITCH/INJECTOR:\n   • Is it powered on?\n   • Is the port PoE-enabled? (Check docs)\n   • Try a different port\n\n2️⃣ TEST VOLTAGE:\n   • Use multimeter at camera end\n   • Should read 48-54V DC\n   • If 0V, cable or switch issue\n\n3️⃣ CHECK CABLE:\n   • Max PoE distance: 100 meters (328 feet)\n   • Look for damage, kinks, cuts\n   • Test with known-good cable\n\n4️⃣ VERIFY POE BUDGET:\n   • Each switch has max total wattage\n   • Count cameras × wattage per camera\n   • Budget exceeded = some cameras won't power\n\nMost \"dead\" cameras are actually power delivery issues!",
    },
    {
        title: "Understanding PoE Power Budgets",
        text: "Here's something that trips up even experienced techs - PoE power budgets!\n\n💡 THE CONCEPT:\nEvery PoE switch has a TOTAL power budget. Add up all connected devices - if you exceed it, cameras won't power on!\n\n📊 EXAMPLE CALCULATION:\nYou have a 16-port PoE switch with 120W budget\n\n✅ SCENARIO 1 - Works Fine:\n• 8 cameras @ 12W each = 96W\n• 2 cameras @ 6W each = 12W\n• Total: 108W (under 120W budget) ✓\n\n❌ SCENARIO 2 - Problems:\n• 10 cameras @ 15W each = 150W\n• Total: 150W (exceeds 120W budget) ✗\n• Last cameras to connect won't power on!\n\n🔧 SOLUTIONS:\n1. Add second PoE switch\n2. Use PoE injectors for some cameras\n3. Upgrade to higher-wattage switch\n4. Use lower-power cameras\n\n💰 PRO TIP: Always leave 20% headroom in your power budget calculation!",
        quiz: {
            question: "You have a PoE switch with 200W budget. Can you power 12 cameras that each use 18W?",
            options: [
                "Yes, 12 × 18 = 216W which is close enough",
                "No, 12 × 18 = 216W exceeds the 200W budget",
                "Yes, because PoE can share power between cameras",
                "It depends on the cable length"
            ],
            correctAnswer: 1,
            correctFeedback: "🧮 Correct! 216W exceeds 200W budget. You'd need to reduce cameras, upgrade switch, or add another PoE source.",
            incorrectFeedback: "Do the math: 12 cameras × 18W = 216W. That exceeds the 200W budget, so not all cameras will power on!"
        }
    },
    {
        title: "PoE Troubleshooting: Camera Powers On But No Video",
        text: "Camera lights are on but no video? This is a network/configuration issue!\n\n🔍 SYMPTOMS:\n• Camera has power (LED lit)\n• No video in NVR/VMS\n• Can't access camera web interface\n\n🛠️ DIAGNOSTIC STEPS:\n\n1️⃣ FIND THE CAMERA:\n   • Use SADP tool (Hikvision)\n   • Or IP scanner software\n   • Or check DHCP server logs\n   • Camera should appear with IP address\n\n2️⃣ CHECK IP CONFIGURATION:\n   • Camera IP in same subnet as NVR?\n   • Example: Camera 192.168.1.64, NVR 192.168.1.100 ✓\n   • Example: Camera 192.168.0.64, NVR 192.168.1.100 ✗\n\n3️⃣ TEST CONNECTIVITY:\n   • Ping camera from NVR or laptop\n   • If no response, IP/network issue\n   • If responds, try web interface\n\n4️⃣ VERIFY CREDENTIALS:\n   • Default username/password?\n   • Check camera documentation\n   • Try: admin/admin, admin/12345\n\nNetwork issues beat techs more than hardware failures!",
    },
    {
        title: "IP Configuration Issues",
        text: "Let's master IP addressing - crucial for PoE camera troubleshooting!\n\n🌐 COMMON IP PROBLEMS:\n\n❌ IP CONFLICT:\nTwo devices with same IP address\n• Both devices will have connection problems\n• Change one camera's IP to unique address\n\n❌ WRONG SUBNET:\nCamera: 192.168.1.64\nNVR: 192.168.0.100\n• Different subnets (1 vs 0) - can't communicate!\n• Change camera to 192.168.0.x range\n\n❌ DHCP ISSUES:\nCamera set to DHCP but no DHCP server\n• Camera waits forever for IP assignment\n• Set static IP manually instead\n\n✅ SOLUTION STEPS:\n1. Find camera with manufacturer's IP config tool\n2. Set camera to static IP in NVR's subnet\n3. Use sequential IPs (easier tracking):\n   • NVR: 192.168.1.100\n   • Camera 1: 192.168.1.101\n   • Camera 2: 192.168.1.102\n4. Document all IPs with labels!\n\n📝 PRO TIP: Keep a spreadsheet of all camera IPs, locations, and MAC addresses!",
        quiz: {
            question: "Your NVR is at 192.168.1.100. Which camera IP will work?",
            options: [
                "192.168.0.150 (different subnet)",
                "192.168.1.101 (same subnet)",
                "10.0.0.50 (completely different network)",
                "Any IP will work fine"
            ],
            correctAnswer: 1,
            correctFeedback: "🎯 Perfect! Both are in 192.168.1.x subnet so they can communicate. Subnet matching is critical!",
            incorrectFeedback: "Remember: Devices must be in the same subnet to communicate! 192.168.1.x devices can talk to each other."
        }
    },
    {
        title: "Analog Troubleshooting: No Video Signal",
        text: "Now let's tackle analog camera issues - different problems, different solutions!\n\n🔍 SYMPTOMS:\n• DVR shows \"No Video\" or black screen\n• No image on test monitor\n• Channel appears disabled\n\n🛠️ DIAGNOSTIC STEPS:\n\n1️⃣ CHECK POWER:\n   • Measure at camera: should be 11.5-12.5V DC\n   • Below 11V = voltage drop problem\n   • 0V = power supply or wiring issue\n\n2️⃣ INSPECT CONNECTIONS:\n   • BNC connectors tight?\n   • Look for corrosion, damage\n   • Reseat all connections\n\n3️⃣ TEST VIDEO SIGNAL:\n   • Use portable monitor at camera\n   • Plug directly into camera output\n   • If image shows, cable to DVR is bad\n   • If no image, camera is faulty\n\n4️⃣ CHECK DVR:\n   • Try camera on different DVR channel\n   • If works, original channel is bad\n   • Verify channel is enabled in settings\n\n🎯 80% of analog issues = power or cable problems!",
    },
    {
        title: "Voltage Drop: The Silent Killer",
        text: "Voltage drop causes MORE analog camera problems than anything else. Let's fix it!\n\n⚡ THE PROBLEM:\nLong cable runs cause voltage drop. 12V at power supply becomes 9V at camera = camera fails!\n\n🧮 VOLTAGE DROP FORMULA:\nDrop = (2 × Length × Current × Resistance) ÷ 1000\n\n📊 REAL EXAMPLE:\n• Cable: 100 meters (328 feet)\n• Current: 0.5A (camera draw)\n• Wire: 18AWG (21 Ω/km resistance)\n• Drop = (2 × 100 × 0.5 × 21) ÷ 1000 = 2.1V\n• Camera gets: 12V - 2.1V = 9.9V ✗ Too low!\n\n✅ SOLUTIONS:\n\n1️⃣ USE LARGER WIRE:\n   • 16AWG or 14AWG = lower resistance\n   • Reduces voltage drop significantly\n\n2️⃣ MID-POINT POWER:\n   • Install power supply closer to cameras\n   • Shorter runs = less drop\n\n3️⃣ HIGHER INPUT VOLTAGE:\n   • Use 24V AC systems\n   • More headroom for drop\n\n📏 RULE OF THUMB: For 18AWG wire, max run is 200 feet with 12V DC",
        quiz: {
            question: "You run a camera cable 300 feet using thin wire. Camera works for 1 hour then goes dark. What's wrong?",
            options: [
                "The camera is defective",
                "Voltage drop - the camera isn't getting enough power over that distance",
                "The DVR channel failed",
                "Someone unplugged it"
            ],
            correctAnswer: 1,
            correctFeedback: "⚡ Exactly! Long cable + thin wire = voltage drop. Camera boots up but can't maintain operation. Use thicker wire!",
            incorrectFeedback: "Think about the distance! 300 feet is a long run. Voltage drop over thin wire means the camera doesn't get enough power."
        }
    },
    {
        title: "Poor Video Quality: Diagnosis Guide",
        text: "Video quality issues tell you exactly what's wrong - if you know how to read the signs!\n\n📺 SYMPTOM GUIDE:\n\n❄️ SNOWY/GRAINY IMAGE:\n• Weak signal strength\n• Bad cable or connectors\n• Cable too long without amplifier\n→ Fix: Replace cable, check connections, add video amplifier\n\n🌊 ROLLING LINES:\n• Ground loop (interference)\n• Power and video share same pathway\n• Bad grounding\n→ Fix: Use ground loop isolator, separate power/video runs\n\n🔅 DIM IMAGE:\n• Low voltage at camera\n• Camera not getting full 12V\n• Voltage drop on power cable\n→ Fix: Check power voltage, use larger wire, add mid-point power\n\n⚫ NO COLOR (Black & White):\n• Camera in night mode (IR LEDs active)\n• Not enough light for color mode\n• Camera set to B&W mode\n→ Fix: Add lighting, adjust camera settings, check IR cut filter\n\n👥 GHOSTING/DOUBLE IMAGE:\n• Impedance mismatch (75Ω termination)\n• Cable too long\n• Poor quality cable\n→ Fix: Check termination, use video amplifier, replace cable",
    },
    {
        title: "Cable Testing Techniques",
        text: "Proper cable testing saves hours of frustration. Here's how the pros do it!\n\n🔌 TESTING ETHERNET CABLES (PoE):\n\n1️⃣ VISUAL INSPECTION:\n   • Look for kinks, cuts, crush damage\n   • Check connectors for broken tabs\n   • Verify cable type (Cat5e minimum)\n\n2️⃣ CONTINUITY TEST:\n   • Use cable tester\n   • All 8 wires must test good\n   • Check for shorts between pairs\n\n3️⃣ POE VOLTAGE TEST:\n   • Disconnect camera first!\n   • Measure pins 1-2 and 3-6\n   • Should read 48-54V DC\n\n4️⃣ LENGTH VERIFICATION:\n   • Max PoE distance: 100m (328ft)\n   • Cable tester can measure length\n   • Too long = no power delivery\n\n📺 TESTING COAXIAL CABLES (Analog):\n\n1️⃣ VISUAL INSPECTION:\n   • Check for damaged jacket\n   • Look for exposed braid shield\n   • Verify proper connectors\n\n2️⃣ CONTINUITY TEST:\n   • Test center conductor: should be ~0Ω\n   • Test shield: should be ~0Ω\n   • Test center-to-shield: should be infinite Ω\n\n3️⃣ VIDEO SIGNAL TEST:\n   • Use portable monitor at camera\n   • Connect at DVR end too\n   • Image should be identical both ends",
        quiz: {
            question: "What's the maximum cable distance for PoE cameras?",
            options: [
                "500 feet (152 meters)",
                "328 feet (100 meters)",
                "1000 feet (305 meters)",
                "There's no limit"
            ],
            correctAnswer: 1,
            correctFeedback: "📏 Perfect! 100 meters (328 feet) is the PoE limit. Beyond that, both data and power degrade significantly.",
            incorrectFeedback: "The IEEE 802.3af/at standard limits PoE to 100 meters (328 feet). Beyond that, you need repeaters or extenders."
        }
    },
    {
        title: "Environmental Factors",
        text: "Cameras don't just fail from electrical issues - environment plays a huge role!\n\n🌡️ TEMPERATURE EXTREMES:\n\n❄️ COLD:\n• Cameras may fail below -10°C (14°F)\n• Condensation causes failures\n• PoE switches can fail in cold\n✅ Solution: Use outdoor-rated cameras, add heaters, insulate\n\n🔥 HEAT:\n• Cameras fail above 50°C (122°F)\n• Direct sunlight overheats housings\n• Dark camera housings absorb more heat\n✅ Solution: Use sunshades, white housings, proper ventilation\n\n💧 MOISTURE/HUMIDITY:\n• Water intrusion kills cameras fast\n• Condensation inside housing\n• Corroded connections\n✅ Solution: IP66 minimum rating, seal cable entries, use silicone, check drainage holes\n\n⚡ LIGHTNING/SURGES:\n• Lightning doesn't need direct hit\n• Nearby strikes induce voltage in cables\n• Kills cameras, switches, NVRs\n✅ Solution: Surge protectors on power AND data, proper grounding, shielded cables\n\n☀️ LIGHTING CONDITIONS:\n• Backlight (camera facing sun)\n• WDR needed for mixed light\n• IR reflection off objects\n✅ Solution: Adjust camera angle, enable WDR, reposition cameras",
    },
    {
        title: "Systematic Troubleshooting Checklist",
        text: "Follow this proven checklist on EVERY call - you'll solve 95% of issues!\n\n⚡ THE 5-MINUTE QUICK CHECK:\n\n☐ Power present at camera?\n  • LED indicator on?\n  • Measure voltage if no LED\n\n☐ Cables physically intact?\n  • No visible damage\n  • Connectors secure\n\n☐ Other cameras working?\n  • Single camera = camera/cable issue\n  • All cameras = switch/NVR issue\n\n☐ Recent changes?\n  • Power outage?\n  • Construction/renovation?\n  • New equipment added?\n\n☐ Test with known-good equipment?\n  • Swap camera with working one\n  • Try different cable\n  • Test on different port/channel\n\n🔍 THE 30-MINUTE DEEP DIVE:\n\n☐ Measure actual voltages (PoE or 12V DC)\n☐ Check network settings (IP, subnet, gateway)\n☐ Test camera on bench with direct power\n☐ Review system logs if available\n☐ Verify firmware compatibility\n☐ Check for IP conflicts\n☐ Test port-to-port on switch\n☐ Inspect for environmental damage",
        quiz: {
            question: "All cameras stop working at once. What's the MOST likely cause?",
            options: [
                "All cameras failed simultaneously (very unlikely)",
                "Power supply, PoE switch, or NVR failure (centralized issue)",
                "All cables failed at once",
                "Cameras need firmware updates"
            ],
            correctAnswer: 1,
            correctFeedback: "🎯 Excellent thinking! Multiple failures = look for centralized problems. Check power source, switch, or NVR first!",
            incorrectFeedback: "When ALL cameras fail together, think centralized! Check the switch, power supply, or NVR - not individual cameras."
        }
    },
    {
        title: "Ground Loop Issues",
        text: "Ground loops cause weird problems that confuse even experienced techs. Let's demystify them!\n\n⚡ WHAT IS A GROUND LOOP?\n\nImagine two devices (camera and DVR) each connected to electrical ground at different points. If there's a voltage difference between those grounds, current flows through the cable shield - creating interference!\n\n📺 SYMPTOMS:\n• Rolling horizontal lines on video\n• Wavy or distorted image\n• Hum bars (60Hz interference)\n• Image gets worse with fluorescent lights\n• Worse in long cable runs\n\n🔍 HOW TO IDENTIFY:\n• Problem appears on some cameras, not all\n• Worse at certain times of day\n• Changes when you touch camera or cable\n• Lifting ground temporarily \"fixes\" it (DON'T DO THIS - SAFETY HAZARD!)\n\n✅ PROPER SOLUTIONS:\n\n1️⃣ GROUND LOOP ISOLATOR:\n   • Install inline on video cable\n   • Breaks the ground path\n   • $10-30 per camera\n\n2️⃣ SINGLE POINT GROUNDING:\n   • All equipment grounds to ONE point\n   • Eliminates voltage differences\n\n3️⃣ SEPARATE POWER/VIDEO RUNS:\n   • Don't bundle power and video cables\n   • Reduces interference coupling\n\n4️⃣ USE FIBER OPTIC:\n   • For long runs\n   • Completely immune to ground loops\n   • More expensive but bulletproof",
    },
    {
        title: "Network Bandwidth Issues",
        text: "PoE cameras work on networks - and networks have limits! Here's what you need to know:\n\n🌐 BANDWIDTH BASICS:\n\nEach IP camera uses network bandwidth based on:\n• Resolution (1080p vs 4K)\n• Frame rate (15fps vs 30fps)\n• Compression (H.264 vs H.265)\n\n📊 TYPICAL CAMERA BANDWIDTH:\n• 1080p @ 30fps = 2-4 Mbps\n• 4K @ 30fps = 8-12 Mbps\n• With H.265 compression = 30-50% less\n\n⚠️ COMMON PROBLEMS:\n\n1️⃣ NETWORK SATURATION:\n   • Too many cameras on one switch\n   • 1Gbps switch with 20 cameras @ 4Mbps each = 80Mbps ✓\n   • But add 10 more 4K cameras @ 10Mbps = 180Mbps total\n   • Plus network overhead = choppy video\n\n2️⃣ WIFI CAMERAS:\n   • Never use WiFi for more than 2-3 cameras\n   • WiFi bandwidth is SHARED\n   • Latency and interference cause dropouts\n   • Wired is ALWAYS better\n\n3️⃣ NVR PROCESSING:\n   • NVR has max incoming bandwidth limit\n   • Exceed it = dropped frames, lost recordings\n   • Check NVR specs: \"Max 256Mbps\" etc.\n\n✅ SOLUTIONS:\n• Use H.265 compression (saves 50% bandwidth)\n• Reduce frame rate to 15fps if acceptable\n• Segment network with multiple switches\n• Upgrade to managed switches with QoS\n• Lower resolution on less critical cameras",
    },
    {
        title: "Preventive Maintenance Schedule",
        text: "Don't wait for failures! Preventive maintenance keeps systems running and clients happy!\n\n📅 MONTHLY TASKS:\n\n☐ Clean camera lenses\n  • Dust, spider webs, water spots\n  • Use microfiber cloth, lens cleaner\n  • Check IR LEDs for obstructions\n\n☐ Verify video quality\n  • Spot-check random cameras\n  • Look for focus drift\n  • Check for new obstructions\n\n☐ Test recording functionality\n  • Playback footage from all cameras\n  • Verify motion detection works\n  • Check storage availability\n\n📅 QUARTERLY TASKS:\n\n☐ Inspect all cable connections\n  • Look for corrosion\n  • Tighten loose connections\n  • Check for water intrusion\n\n☐ Test backup power systems\n  • UPS battery test\n  • Generator test (if present)\n  • Verify failover works\n\n☐ Update camera firmware\n  • Check manufacturer sites\n  • Test updates on one camera first\n  • Document versions\n\n☐ Review storage capacity\n  • How many days of recording?\n  • Plan for expansion if needed\n\n📅 ANNUAL TASKS:\n\n☐ Full system testing\n☐ Replace surge protectors (they wear out!)\n☐ Clean internal electronics (dust buildup)\n☐ Update NVR/DVR firmware\n☐ Review and update network security\n☐ Test all backup/restore procedures",
        quiz: {
            question: "How often should you clean camera lenses in a dusty environment?",
            options: [
                "Once a year is enough",
                "Monthly, or more often in harsh environments",
                "Only when clients complain",
                "Cameras are self-cleaning"
            ],
            correctAnswer: 1,
            correctFeedback: "🧹 Perfect! Monthly minimum, more often in dusty/dirty locations. Clean lenses = happy clients!",
            incorrectFeedback: "Dirty lenses degrade video quality significantly. In harsh environments, monthly cleaning (or more) is essential for clear footage."
        }
    },
    {
        title: "Installation Best Practices",
        text: "Great installations prevent future service calls! Follow these pro practices:\n\n✅ DO THESE THINGS:\n\n🔌 Use quality cables\n  • Cat6 for PoE (better than Cat5e)\n  • RG6 for analog (better than RG59)\n  • Don't cheap out - cables last 10+ years\n\n🏷️ Label everything clearly\n  • Both ends of every cable\n  • Camera number + location\n  • IP addresses on labels\n  • Use weatherproof labels outdoors\n\n🔄 Leave service loops\n  • Extra 3-6 feet at each end\n  • Allows repositioning without rewiring\n  • Coil neatly, secure with velcro\n\n📋 Document everything\n  • IP addresses in spreadsheet\n  • Camera locations on site map\n  • Login credentials (secure!)\n  • Installation date and equipment models\n\n⚡ Install surge protection\n  • Protects entire investment\n  • Both power and data lines\n  • Ground properly\n\n❌ DON'T DO THESE THINGS:\n\n⚠️ Run near high voltage lines\n  • Causes interference\n  • Keep 12+ inches away\n\n⚠️ Exceed maximum distances\n  • 100m for PoE\n  • Check specs for analog\n\n⚠️ Use indoor equipment outdoors\n  • Water ingress kills everything\n  • Always use proper IP ratings\n\n⚠️ Forget proper grounding\n  • Lightning strikes destroy systems\n  • Proper ground = protection\n\n⚠️ Skip testing before closing walls\n  • ALWAYS test before sealing\n  • Saves massive headaches",
    },
    {
        title: "Professional Documentation",
        text: "Documentation separates pros from amateurs. It protects you AND helps future troubleshooting!\n\n📸 TAKE PHOTOS OF EVERYTHING:\n\n• Before starting (document existing conditions)\n• Cable routing and pathways\n• All connections (close-ups)\n• Equipment serial numbers\n• After completion (prove quality work)\n• Problem areas you find\n\n📋 DOCUMENT THESE DETAILS:\n\n🎯 SYSTEM INFORMATION:\n  • Camera make/model/serial numbers\n  • NVR/DVR make/model/firmware version\n  • Switch make/model (if separate)\n  • Power supply specifications\n\n🌐 NETWORK CONFIGURATION:\n  • Every camera's IP address\n  • NVR IP address and gateway\n  • Subnet mask\n  • DNS servers (if used)\n  • Port forwarding rules (if remote access)\n\n🔐 CREDENTIALS:\n  • Admin usernames (never write passwords!)\n  • Camera access codes\n  • Keep in secure password manager\n  • Never email credentials\n\n📍 PHYSICAL LAYOUT:\n  • Site map with camera locations\n  • Cable run lengths and pathways\n  • Where equipment is mounted\n  • Access panel locations\n\n💡 WHY THIS MATTERS:\n• Saves hours on future service calls\n• Protects you legally (proof of proper work)\n• Helps other techs who come after you\n• Shows professionalism to clients\n• Allows accurate quoting for expansions",
    },
    {
        title: "Remote Troubleshooting Tips",
        text: "Sometimes you can solve problems remotely - saves time and travel costs!\n\n💻 REMOTE ACCESS SETUP:\n\n1️⃣ NVR/CAMERA WEB ACCESS:\n   • Port forwarding on router\n   • Use HTTPS with strong passwords\n   • Change default ports (not 80, not 8000)\n   • Consider VPN instead of port forwarding\n\n2️⃣ REMOTE DESKTOP:\n   • TeamViewer/AnyDesk to client computer\n   • Can access local network from there\n   • View same interface as on-site\n\n3️⃣ MANUFACTURER APPS:\n   • Hikvision: Hik-Connect\n   • Dahua: gDMSS Plus\n   • Check camera web interface remotely\n\n🔍 REMOTE DIAGNOSTICS:\n\n☐ Check system logs remotely\n☐ Verify recording is working\n☐ Test camera connections\n☐ Review error messages\n☐ Adjust camera settings\n☐ Reboot cameras/NVR remotely\n☐ Check network connectivity\n☐ Review bandwidth usage\n\n⚠️ SECURITY WARNINGS:\n\n❌ Never use default passwords\n❌ Don't open all ports to internet\n❌ Avoid using telnet (not secure)\n❌ Don't share admin credentials openly\n\n✅ Use strong unique passwords\n✅ Enable two-factor authentication\n✅ Use VPN when possible\n✅ Keep firmware updated\n✅ Monitor for unauthorized access\n\n💰 REMOTE TROUBLESHOOTING SAVES:\n• 2-4 hours drive time\n• Vehicle expenses\n• Same-day resolution for clients\n• Can help after hours\n• Build recurring maintenance contracts",
    },
    {
        title: "Common Myths Debunked",
        text: "Let's clear up misconceptions that waste time and money!\n\n❌ MYTH #1: \"More megapixels = better cameras\"\n✅ TRUTH: More megapixels = more storage/bandwidth needed. 4MP is plenty for most applications. Consider lighting, lens quality, and sensor size!\n\n❌ MYTH #2: \"WiFi cameras are just as good as wired\"\n✅ TRUTH: WiFi has interference, bandwidth limits, and reliability issues. Wired is ALWAYS more reliable for CCTV.\n\n❌ MYTH #3: \"All Ethernet cables are the same\"\n✅ TRUTH: Cat5e is minimum for PoE, Cat6 is better. Quality matters - cheap cable = voltage drop and data errors.\n\n❌ MYTH #4: \"Cameras work forever without maintenance\"\n✅ TRUTH: Dust, moisture, temperature, and age degrade all cameras. Regular cleaning and inspection extends life significantly.\n\n❌ MYTH #5: \"More cameras = better security\"\n✅ TRUTH: Proper camera placement matters more than quantity. 5 well-placed cameras beat 20 poorly positioned ones.\n\n❌ MYTH #6: \"Night vision works in total darkness\"\n✅ TRUTH: IR cameras need IR LEDs (invisible light). \"Starlight\" cameras need SOME ambient light. True darkness = no image.\n\n❌ MYTH #7: \"Digital zoom = optical zoom\"\n✅ TRUTH: Digital zoom just enlarges pixels (makes image blocky). Optical zoom maintains quality. Know the difference!\n\n❌ MYTH #8: \"Cloud storage is always better\"\n✅ TRUTH: Local storage is faster, more reliable, and no monthly fees. Cloud is great for off-site backup, not primary storage.",
    },
    {
        title: "Dealing with Challenging Installations",
        text: "Some sites present unique challenges. Here's how to handle them!\n\n🏢 LONG DISTANCE RUNS:\n\nProblem: Need camera 500 feet from NVR\n\n✅ Solutions:\n• Use PoE extenders (every 100m)\n• Install intermediate switch\n• Use fiber optic converters\n• Consider wireless bridge (line of sight)\n\n🌳 OUTDOOR/HARSH ENVIRONMENTS:\n\nProblem: Extreme weather, moisture, dust\n\n✅ Solutions:\n• IP66/IP67 rated cameras minimum\n• Add heater/blower for extreme temps\n• Use sunshades on south-facing cameras\n• Seal all cable entries with silicone\n• Check drainage holes aren't blocked\n• Use stainless steel mounting hardware\n\n⚡ HIGH LIGHTNING AREAS:\n\nProblem: System damaged by storms repeatedly\n\n✅ Solutions:\n• Install surge protectors on EVERY camera\n• Use shielded cables\n• Proper grounding (critical!)\n• Consider fiber for long runs (immune to surges)\n• Install whole-system surge protection\n• Document lightning protection in quote\n\n🏗️ METAL BUILDING/INTERFERENCE:\n\nProblem: Metal building causing PoE/network issues\n\n✅ Solutions:\n• Use shielded Cat6 cable\n• Proper grounding eliminates ground loops\n• Keep cables away from metal structures\n• Use fiber optic if interference persists\n• Check for nearby radio transmitters\n\n🔒 HIGH SECURITY REQUIREMENTS:\n\nProblem: Client needs redundancy, encryption\n\n✅ Solutions:\n• Dual recording (local + cloud/off-site)\n• Redundant power (UPS + generator)\n• VLAN segregation for camera network\n• Enable camera encryption\n• Regular backup testing\n• Documented security procedures",
    },
    {
        title: "Pricing Your Services",
        text: "Don't leave money on the table! Here's how to price CCTV troubleshooting properly:\n\n💰 SERVICE CALL STRUCTURE:\n\n🔍 DIAGNOSTIC FEE: $100-150\n  • Covers initial visit and diagnosis\n  • Applied to repair if client proceeds\n  • Non-refundable if they decline\n\n🔧 HOURLY RATE: $75-125/hour\n  • Varies by region and experience\n  • Minimum 1-2 hour charge\n  • Higher rate for after-hours/emergency\n\n📊 COMMON REPAIRS (Labor + Parts):\n\n• Replace single camera: $150-250\n• Run new cable: $200-400\n• Configure network settings: $100-200\n• Replace PoE switch: $300-600\n• Full system checkup: $200-400\n• Install surge protection: $150-300/camera\n• Add storage upgrade: $200-500\n\n💡 VALUE-BASED PRICING:\n\nInstead of just hourly:\n\"Camera down = lost evidence = risk\"\n\"I can fix it today = peace of mind\"\n\nPrice based on VALUE delivered:\n• Restore critical security\n• Prevent loss/theft\n• Compliance requirements\n• Emergency response\n\n📋 MAINTENANCE CONTRACTS:\n\nRecurring revenue = business stability!\n\n🥉 BRONZE ($100/month):\n   • Quarterly check-ins\n   • Priority scheduling\n   • 10% off repairs\n\n🥈 SILVER ($200/month):\n   • Monthly checks\n   • Remote monitoring\n   • 20% off repairs\n   • After-hours support\n\n🥇 GOLD ($400/month):\n   • Bi-weekly checks\n   • 24/7 monitoring\n   • Free minor repairs\n   • Guaranteed 4-hour response\n\n💰 BUNDLE PRICING:\n\"System Health Check\" package:\n• Clean all lenses\n• Test all cameras\n• Update firmware\n• Check all connections\n• Full report with recommendations\n• $500 flat rate (beats hourly for client)\n• You complete in 3-4 hours = $125-165/hour effective rate!",
    },
    {
        title: "Building Your CCTV Business",
        text: "You've got the technical skills - now let's talk about building a profitable CCTV service business!\n\n🎯 NICHE SPECIALIZATION:\n\nDon't be everything to everyone! Pick a focus:\n\n• Retail stores (know POS integration)\n• Restaurants (kitchen camera requirements)\n• Warehouses (wide area coverage)\n• Residential (user-friendly systems)\n• Construction sites (temporary power, wireless)\n• Schools (specific compliance needs)\n\n📣 MARKETING STRATEGIES:\n\n1️⃣ REFERRAL PARTNERSHIPS:\n   • IT companies (don't do CCTV themselves)\n   • Electricians (camera installs needed)\n   • Security companies (need installation help)\n   • Property managers (multiple properties)\n\n2️⃣ ONLINE PRESENCE:\n   • Google Business Profile (critical!)\n   • Before/after photos\n   • Video testimonials\n   • \"CCTV troubleshooting [your city]\"\n\n3️⃣ LOCAL NETWORKING:\n   • Join chamber of commerce\n   • Business networking groups\n   • Property manager associations\n\n💼 GROWTH PATH:\n\n📊 YEAR 1:\n   • Focus on service calls\n   • Build reputation\n   • 2-3 installs/month\n   • $50-75K revenue\n\n📈 YEAR 2:\n   • Add installation services\n   • Hire first helper\n   • 5-8 installs/month\n   • $100-150K revenue\n\n🚀 YEAR 3+:\n   • Focus on sales/project management\n   • Team handles technical work\n   • Recurring maintenance contracts\n   • $200K+ revenue\n\n💡 RECURRING REVENUE FOCUS:\n\nService calls are unpredictable income.\nMaintenance contracts = predictable monthly income!\n\n20 clients × $200/month = $4,000/month baseline\nBefore you do ANY project work!",
    },
    {
        title: "Final Assessment",
        text: "Alright, let's test your CCTV troubleshooting mastery! This brings together everything we've covered.\n\nYou arrive at a site with 8 PoE cameras. Cameras 1-6 work fine. Cameras 7 and 8 have no power. You check:\n\n• Both cameras: No LED lights\n• PoE switch: All other ports working\n• Cables: Appear undamaged\n• Switch specs: 16 ports, 200W PoE budget\n• Cameras 1-6: Each using 15W = 90W total\n• Cameras 7-8: Each rated for 30W (PTZ models)\n• Total if all worked: 90W + 60W = 150W (under 200W budget)\n\nYou test Camera 7 on an empty port - still no power. You connect your laptop with a known-good cable to Camera 7's port - you get network access and PoE power.\n\nWhat's the most likely problem?",
        quiz: {
            question: "Based on the scenario above, what's wrong with Cameras 7 and 8?",
            options: [
                "Both cameras are defective",
                "The PoE switch has failed",
                "The cables to Cameras 7 and 8 are damaged/faulty",
                "The cameras need different voltage"
            ],
            correctAnswer: 2,
            correctFeedback: "🎯 Perfect diagnosis! The switch and cameras work fine (you tested them). Laptop got power on those ports. Same camera failed on different port. Must be the cables to those camera locations. Time to replace those cables!",
            incorrectFeedback: "Think through the testing: Camera 7 failed on its original port AND a new port. But your laptop worked on Camera 7's port with a good cable. The switch provides power, the cameras would work with good cables... what's left?"
        }
    },
    {
        title: "Congratulations! You're a CCTV Pro! 🎉",
        text: "Outstanding work! You've completed the CCTV Camera Troubleshooting certification!\n\n🎓 YOU NOW KNOW HOW TO:\n\n✅ Troubleshoot PoE digital camera systems\n✅ Diagnose and fix analog camera issues\n✅ Calculate power budgets and voltage drops\n✅ Configure network settings properly\n✅ Test cables and connections professionally\n✅ Handle environmental challenges\n✅ Perform preventive maintenance\n✅ Build a profitable CCTV service business\n✅ Price services confidently\n✅ Document work professionally\n\n💼 YOUR NEXT STEPS:\n\n1️⃣ Practice these techniques on real systems\n2️⃣ Build your technician toolkit\n3️⃣ Start offering CCTV services\n4️⃣ Join industry groups and forums\n5️⃣ Consider manufacturer certifications\n6️⃣ Build a portfolio of completed projects\n7️⃣ Network with local installers\n8️⃣ Stay updated on new technologies\n\n🚀 CAREER OPPORTUNITIES:\n\n💰 CCTV technicians earn:\n   • Service calls: $75-125/hour\n   • Installations: $300-800/day\n   • Maintenance contracts: Recurring revenue\n   • Emergency calls: Premium rates\n\n🌟 With these skills, you can:\n   • Work independently\n   • Join established companies\n   • Start your own CCTV business\n   • Combine with other field tech services\n\n📚 KEEP LEARNING:\n   • New camera technologies emerge constantly\n   • AI/analytics integration is growing\n   • Cloud-based systems expanding\n   • Cybersecurity becoming critical\n\nCCTV systems protect property, assets, and people. Your troubleshooting skills ensure security systems work when needed most. That's valuable - own it!\n\n🎊 You've earned this certification. Now go make money with these skills! 🔧📹💰",
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
