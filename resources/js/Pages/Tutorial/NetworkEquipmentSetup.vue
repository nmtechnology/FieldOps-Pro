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
        title: "Welcome to Network Equipment Setup Training!",
        text: "Ready to become a network infrastructure pro? I'm your FieldOps guide, and I'm here to teach you everything about setting up, configuring, and maintaining professional network equipment!\n\n🌐 This comprehensive training covers:\n\n🔧 Network equipment fundamentals (switches, routers, access points)\n📊 Rack mounting and cable management\n⚙️ Initial configuration and best practices\n🔒 Security hardening and VLANs\n📡 Wireless access point deployment\n🧪 Testing and troubleshooting\n💼 Professional documentation\n\nWhether you're setting up a small office or a large enterprise network, these skills are in MASSIVE demand. Let's get you certified!",
        image: "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Professional network equipment rack - your future workspace"
    },
    {
        title: "Understanding Network Equipment Types",
        text: "Before we start racking equipment, let's understand what each device does:\n\n🔀 NETWORK SWITCHES:\n• Layer 2 (unmanaged/managed)\n• Layer 3 (routing capable)\n• PoE/PoE+ models\n• Purpose: Connect devices on local network\n• Ports: 8, 16, 24, 48 common\n\n🌐 ROUTERS:\n• Connect networks together\n• WAN/Internet gateway\n• Firewall capabilities\n• NAT and DHCP services\n• VPN endpoints\n\n📡 WIRELESS ACCESS POINTS:\n• Provide WiFi coverage\n• 802.11ac (WiFi 5) or 802.11ax (WiFi 6)\n• PoE powered (most models)\n• Controller-based or standalone\n• Mesh vs traditional\n\n🔥 FIREWALLS:\n• Network security\n• Deep packet inspection\n• IPS/IDS capabilities\n• Application control\n• Usually sits between router and switch\n\nKnowing which device does what is critical!",
        quiz: {
            question: "What is the PRIMARY function of a Layer 2 network switch?",
            options: [
                "Route traffic between different networks",
                "Connect devices on the same local network",
                "Provide wireless connectivity",
                "Act as a firewall"
            ],
            correctAnswer: 1,
            correctFeedback: "🎯 Exactly! Layer 2 switches connect devices on the same local network using MAC addresses. They're the backbone of your LAN infrastructure.",
            incorrectFeedback: "Layer 2 switches connect devices on the same local network using MAC addresses. Routing between networks is handled by Layer 3 switches or routers."
        }
    },
    {
        title: "Essential Tools for Network Setup",
        text: "Here's your professional network tech toolkit:\n\n🔧 BASIC TOOLS:\n\n🪛 **Screwdriver Set** ($20-50)\n• Phillips and flathead\n• Magnetic tips helpful\n• For rack mounting\n\n🔌 **Cable Tester** ($20-80)\n• Tests patch cables\n• Verifies wiring\n• Essential for troubleshooting\n\n💻 **Laptop with Console Cable** ($150-2000 + $15)\n• For CLI configuration\n• USB-to-serial or USB-to-RJ45\n• Serial terminal software (PuTTY, screen)\n\n📱 ADVANCED TOOLS:\n\n🧪 **Network Toner/Tester** ($50-150)\n• Trace cables in racks\n• Identify ports\n• Time-saver!\n\n📊 **Label Maker** ($30-80)\n• Professional labels\n• Port identification\n• Cable labeling\n\n🔦 **Headlamp** ($20-60)\n• Hands-free lighting\n• Essential in server rooms\n• Long battery life\n\nInvest in quality tools - they'll pay for themselves!",
    },
    {
        title: "Safety in the Server Room",
        text: "Server rooms can be dangerous if you're not careful. Follow these safety protocols:\n\n⚡ ELECTRICAL SAFETY:\n\n• Always assume equipment is powered\n• Check voltage before touching\n• Never work alone on live equipment\n• Use insulated tools\n• Know where emergency shutoffs are located\n• Avoid wearing jewelry (conductive!)\n\n🏗️ PHYSICAL SAFETY:\n\n• Wear closed-toe shoes (steel toe preferred)\n• Lift with your legs, not your back\n• Use lifting assistance for heavy equipment\n• Watch for raised floor tiles\n• Be aware of overhead cable trays\n• Never stand on chairs - use proper ladders\n\n🌡️ ENVIRONMENTAL SAFETY:\n\n• Server rooms are cold (65-72°F typical)\n• Bring a jacket\n• Stay hydrated\n• Take breaks in normal temperature areas\n• Be aware of loud noise (wear ear protection if needed)\n\n🔥 FIRE SAFETY:\n\n• Know where fire extinguishers are\n• Understand fire suppression systems\n• Never block exits or extinguishers\n• Report any burning smells immediately\n\n💡 Safety first, ALWAYS. No job is worth getting hurt!",
    },
    {
        title: "Understanding Rack Units (U)",
        text: "Professional equipment is measured in 'rack units' - here's what you need to know:\n\n📏 RACK UNIT BASICS:\n\n• 1U = 1.75 inches (44.45mm) height\n• Standard 19\" wide mounting\n• Racks typically 42U tall (full height)\n• Also: 24U, 18U, 12U racks common\n\n📊 COMMON EQUIPMENT SIZES:\n\n• Patch panel: 1U\n• Network switch: 1U (typically)\n• Router/firewall: 1U-2U\n• Server: 1U (pizza box) to 4U\n• UPS: 2U-4U\n• Cable management: 1U-2U\n\n🔢 PLANNING RACK SPACE:\n\n1. List all equipment + U size\n2. Add 1U cable management between layers\n3. Add 20% buffer for future growth\n4. Leave 2U at top for cable routing\n5. Leave 2U at bottom for power\n\n📐 EXAMPLE RACK LAYOUT:\n• 2U: Top cable management\n• 1U: Patch panel\n• 1U: Cable management\n• 1U: 24-port PoE switch\n• 1U: Cable management\n• 1U: Firewall\n• ...remaining space...\n• 2U: UPS\n\nProper planning prevents rack disasters!",
        image: "https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Server rack with properly mounted network equipment",
        customHtml: `
        <div class="bg-gray-800 rounded-lg p-6 my-6">
            <h3 class="text-xl font-bold text-orange-400 mb-4">📏 Common Equipment Rack Unit (U) Sizing</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="py-3 px-4 text-orange-400 font-semibold">Equipment Type</th>
                        <th class="py-3 px-4 text-orange-400 font-semibold text-center">Typical Size</th>
                        <th class="py-3 px-4 text-orange-400 font-semibold text-right">Height (inches)</th>
                        <th class="py-3 px-4 text-orange-400 font-semibold">Example</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300">
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4">24-Port Patch Panel</td>
                        <td class="py-3 px-4 text-center font-mono font-bold text-green-400">1U</td>
                        <td class="py-3 px-4 text-right font-mono">1.75"</td>
                        <td class="py-3 px-4 text-sm text-gray-400">Cable termination</td>
                    </tr>
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4">Network Switch (24-48 port)</td>
                        <td class="py-3 px-4 text-center font-mono font-bold text-green-400">1U</td>
                        <td class="py-3 px-4 text-right font-mono">1.75"</td>
                        <td class="py-3 px-4 text-sm text-gray-400">Cisco Catalyst 2960</td>
                    </tr>
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4">Cable Management</td>
                        <td class="py-3 px-4 text-center font-mono font-bold text-yellow-400">1-2U</td>
                        <td class="py-3 px-4 text-right font-mono">1.75-3.5"</td>
                        <td class="py-3 px-4 text-sm text-gray-400">Horizontal organizers</td>
                    </tr>
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4">Router / Firewall</td>
                        <td class="py-3 px-4 text-center font-mono font-bold text-yellow-400">1-2U</td>
                        <td class="py-3 px-4 text-right font-mono">1.75-3.5"</td>
                        <td class="py-3 px-4 text-sm text-gray-400">Cisco ISR, FortiGate</td>
                    </tr>
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4">Rack-Mount Server</td>
                        <td class="py-3 px-4 text-center font-mono font-bold text-orange-400">1-4U</td>
                        <td class="py-3 px-4 text-right font-mono">1.75-7"</td>
                        <td class="py-3 px-4 text-sm text-gray-400">Dell PowerEdge</td>
                    </tr>
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4">UPS (Battery Backup)</td>
                        <td class="py-3 px-4 text-center font-mono font-bold text-orange-400">2-4U</td>
                        <td class="py-3 px-4 text-right font-mono">3.5-7"</td>
                        <td class="py-3 px-4 text-sm text-gray-400">APC Smart-UPS</td>
                    </tr>
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4">PDU (Power Distribution)</td>
                        <td class="py-3 px-4 text-center font-mono font-bold text-green-400">0-1U</td>
                        <td class="py-3 px-4 text-right font-mono">0-1.75"</td>
                        <td class="py-3 px-4 text-sm text-gray-400">Vertical or horizontal</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="mt-6 bg-gray-900 rounded-lg p-4 border border-gray-700">
                <h4 class="font-bold text-orange-400 mb-3">📐 Example 42U Rack Layout (Small Office)</h4>
                <div class="space-y-1 font-mono text-sm">
                    <div class="flex justify-between p-2 bg-gray-800 rounded">
                        <span>42U (Top)</span><span class="text-gray-500">→ Empty (cable access)</span>
                    </div>
                    <div class="flex justify-between p-2 bg-gray-800 rounded">
                        <span>41-40U</span><span class="text-orange-400">→ 2U Cable Management</span>
                    </div>
                    <div class="flex justify-between p-2 bg-green-500/20 rounded">
                        <span>39U</span><span class="text-green-400">→ 1U Patch Panel (24-port)</span>
                    </div>
                    <div class="flex justify-between p-2 bg-gray-800 rounded">
                        <span>38U</span><span class="text-orange-400">→ 1U Cable Management</span>
                    </div>
                    <div class="flex justify-between p-2 bg-green-500/20 rounded">
                        <span>37U</span><span class="text-green-400">→ 1U PoE Switch (24-port)</span>
                    </div>
                    <div class="flex justify-between p-2 bg-gray-800 rounded">
                        <span>36U</span><span class="text-orange-400">→ 1U Cable Management</span>
                    </div>
                    <div class="flex justify-between p-2 bg-green-500/20 rounded">
                        <span>35U</span><span class="text-green-400">→ 1U Firewall/Router</span>
                    </div>
                    <div class="flex justify-between p-2 bg-gray-800 rounded">
                        <span>34-20U</span><span class="text-gray-500">→ Reserved for Growth</span>
                    </div>
                    <div class="flex justify-between p-2 bg-blue-500/20 rounded">
                        <span>19-16U</span><span class="text-blue-400">→ 4U Server (if needed)</span>
                    </div>
                    <div class="flex justify-between p-2 bg-gray-800 rounded">
                        <span>15-5U</span><span class="text-gray-500">→ Reserved</span>
                    </div>
                    <div class="flex justify-between p-2 bg-yellow-500/20 rounded">
                        <span>4-3U</span><span class="text-yellow-400">→ 2U UPS (Battery Backup)</span>
                    </div>
                    <div class="flex justify-between p-2 bg-gray-800 rounded">
                        <span>2-1U</span><span class="text-gray-500">→ Empty (heat exhaust)</span>
                    </div>
                </div>
            </div>
            
            <p class="text-sm text-gray-400 mt-4">💡 <strong>Pro Tip:</strong> Always leave 20% of rack space empty for future expansion and proper airflow!</p>
        </div>
        `,
        quiz: {
            question: "How tall is 1 rack unit (1U)?",
            options: [
                "1 inch",
                "1.5 inches",
                "1.75 inches",
                "2 inches"
            ],
            correctAnswer: 2,
            correctFeedback: "✅ Perfect! 1U equals 1.75 inches (44.45mm). This is the standard unit for rack-mounted equipment worldwide.",
            incorrectFeedback: "1U equals 1.75 inches (44.45mm). This is the international standard for measuring rack-mounted equipment height."
        }
    },
    {
        title: "Rack Mounting Best Practices",
        text: "Proper rack mounting is an art. Here's how the pros do it:\n\n🔩 MOUNTING TECHNIQUES:\n\n1️⃣ **Plan Bottom to Top**\n   • Heaviest equipment at bottom\n   • UPS at very bottom (most common)\n   • Network equipment in middle\n   • Patch panels near top\n   • Lighter equipment higher up\n\n2️⃣ **Use Cage Nuts Properly**\n   • Square holes use cage nuts\n   • Clip into square hole from back\n   • Flat side faces out\n   • Practice this - it's tricky at first!\n\n3️⃣ **Install Support Rails**\n   • For deep equipment (servers, UPS)\n   • Front and rear mounting\n   • Takes equipment weight off front mounting\n   • Prevents rack tip-over\n\n4️⃣ **Cable Management**\n   • 1U cable management between layers\n   • Vertical cable managers on sides\n   • Front-to-back cable routing\n   • Never block airflow!\n\n5️⃣ **Airflow Considerations**\n   • Front-to-back airflow (typically)\n   • Don't block intake vents\n   • Leave space for exhaust\n   • Hot aisle / cold aisle in data centers\n\n🎯 Take your time - a clean install is a professional install!",
    },
    {
        title: "Power Planning and Distribution",
        text: "Network equipment needs reliable power. Here's how to plan it:\n\n⚡ POWER REQUIREMENTS:\n\n🔌 **Calculate Total Wattage:**\n• Check equipment labels for power draw\n• Add 20% overhead\n• Example: 24-port PoE switch = 400-500W\n• Router/firewall = 50-150W\n• Each AP via PoE = 15-30W\n\n🔋 **UPS Selection:**\n• Calculate total watts needed\n• Add 30% for future growth\n• UPS in VA (volt-amps), not just watts\n• Watts × 1.4 = VA (rough estimate)\n• Runtime: 15-30 minutes typical\n• Long enough for clean shutdown\n\n📊 **PDU (Power Distribution Unit):**\n• Rack-mounted power strip\n• Multiple outlets (8-16 typical)\n• Switched vs non-switched\n• Metered models show power usage\n• Remote management optional\n\n🔌 **Power Cable Management:**\n• Use velcro straps (not zip ties!)\n• Keep power separate from data cables\n• Label both ends of power cables\n• Use different color cables if possible\n• Leave service loops (6\" slack)\n\n💡 REDUNDANCY:\n• Dual power supplies (if equipment supports)\n• Connect to different circuits\n• Critical equipment on UPS\n• Non-critical can be direct power\n\nNo power = no network!",
    },
    {
        title: "Initial Switch Configuration: Console Access",
        text: "Let's configure your first network switch! Starting with console access:\n\n💻 CONSOLE CONNECTION:\n\n1️⃣ **Physical Connection:**\n   • Connect console cable (RJ45 or USB)\n   • Blue Cisco console cable (classic)\n   • USB-to-serial adapters common now\n   • Connect before powering on\n\n2️⃣ **Terminal Settings:**\n   • Baud rate: 9600\n   • Data bits: 8\n   • Parity: None\n   • Stop bits: 1\n   • Flow control: None\n   • Summary: 9600-8-N-1\n\n3️⃣ **Software Options:**\n   • PuTTY (Windows)\n   • SecureCRT (Windows/Mac/Linux)\n   • screen (Mac/Linux built-in)\n   • Terminal (Mac built-in)\n\n💡 **Mac/Linux Console Command:**\n```\nscreen /dev/tty.usbserial 9600\n```\n\n💡 **Windows with PuTTY:**\n• Select 'Serial'\n• COM port (check Device Manager)\n• Speed: 9600\n• Click 'Open'\n\n4️⃣ **First Boot:**\n   • Power on equipment\n   • Watch boot messages\n   • Wait for prompt (2-5 minutes)\n   • Press Enter if needed\n\nYou're now connected to the switch CLI!",
        quiz: {
            question: "What are the correct console port settings for most network equipment?",
            options: [
                "115200-8-N-1",
                "9600-8-N-1",
                "19200-7-E-1",
                "57600-8-N-2"
            ],
            correctAnswer: 1,
            correctFeedback: "🎯 Correct! 9600-8-N-1 (9600 baud, 8 data bits, No parity, 1 stop bit) is the standard for network equipment console access.",
            incorrectFeedback: "The standard console settings are 9600-8-N-1 (9600 baud rate, 8 data bits, No parity, 1 stop bit)."
        }
    },
    {
        title: "Basic Switch Configuration: Cisco IOS",
        text: "Now let's configure a Cisco switch (most common brand). These commands work on most Cisco equipment:\n\n⚙️ INITIAL CONFIGURATION:\n\n```\n! Enter privileged mode\nenable\n\n! Enter configuration mode\nconfigure terminal\n\n! Set hostname\nhostname Office-SW01\n\n! Set enable password (encrypted)\nenable secret YourSecurePassword123!\n\n! Configure management VLAN interface\ninterface vlan 1\nip address 192.168.1.10 255.255.255.0\nno shutdown\nexit\n\n! Set default gateway\nip default-gateway 192.168.1.1\n\n! Configure console password\nline console 0\npassword YourConsolePass123!\nlogin\nexit\n\n! Configure SSH (remote access)\nip domain-name yourcompany.local\ncrypto key generate rsa modulus 2048\nline vty 0 15\ntransport input ssh\nlogin local\nexit\n\n! Create admin user\nusername admin privilege 15 secret AdminPassword123!\n\n! Save configuration\nend\nwrite memory\n```\n\n💡 IMPORTANT NOTES:\n• Change passwords to secure ones!\n• Document credentials securely\n• Save config with 'write memory' or 'copy run start'\n• Test SSH access before disconnecting console!",
    },
    {
        title: "Setting Up VLANs (Virtual LANs)",
        text: "VLANs segment your network for better security and performance:\n\n🔀 VLAN CONCEPTS:\n\n**What are VLANs?**\n• Virtual network segments\n• Separate broadcast domains\n• Improve security (isolation)\n• Organize by department/function\n• Require Layer 3 device to communicate between VLANs\n\n📊 **Common VLAN Scheme:**\n• VLAN 1: Management (default)\n• VLAN 10: Users/Workstations\n• VLAN 20: Servers\n• VLAN 30: Voice/VoIP phones\n• VLAN 40: Guest WiFi\n• VLAN 50: Security cameras\n• VLAN 99: Native (unused)\n\n⚙️ **VLAN Configuration:**\n\n```\n! Create VLANs\nvlan 10\nname USERS\nexit\nvlan 20\nname SERVERS\nexit\nvlan 30\nname VOIP\nexit\n\n! Configure access port (single VLAN)\ninterface gigabitethernet 1/0/5\nswitchport mode access\nswitchport access vlan 10\nspanning-tree portfast\nexit\n\n! Configure trunk port (multiple VLANs)\ninterface gigabitethernet 1/0/24\nswitchport mode trunk\nswitchport trunk native vlan 99\nswitchport trunk allowed vlan 10,20,30\nexit\n```\n\nVLANs = network segmentation done right!",
    },
    {
        title: "Configuring PoE (Power over Ethernet)",
        text: "Power over Ethernet lets you power devices through network cables. Here's how to manage it:\n\n⚡ POE OVERVIEW:\n\n📊 **PoE Standards:**\n• PoE (802.3af): 15.4W per port\n• PoE+ (802.3at): 30W per port\n• PoE++ (802.3bt): 60-100W per port\n\n🔌 **Common PoE Devices:**\n• IP phones: 7-15W (PoE)\n• Access points: 15-25W (PoE+)\n• IP cameras: 4-15W (PoE/PoE+)\n• LED lighting: varies\n• Access control: 5-10W (PoE)\n\n⚙️ **PoE Configuration (Cisco):**\n\n```\n! Check PoE budget\nshow power inline\n\n! Enable PoE on interface\ninterface gigabitethernet 1/0/10\npower inline auto\ndescription IP-Camera-Lobby\nexit\n\n! Set PoE priority (if needed)\ninterface gigabitethernet 1/0/5\npower inline auto\npower inline priority high\ndescription IP-Phone-Reception\nexit\n\n! Disable PoE (save power)\ninterface gigabitethernet 1/0/20\npower inline never\nexit\n```\n\n💡 **PoE Power Budget:**\n• Calculate total PoE watts needed\n• Example: 24-port PoE switch = 370W budget\n• If 20 APs @ 20W each = 400W (exceeds budget!)\n• Use priority to ensure critical devices stay powered\n• Consider PoE+ switch if needed\n\nAlways check your PoE power budget!",
        quiz: {
            question: "What is the maximum power delivery of PoE+ (802.3at) per port?",
            options: [
                "15.4 watts",
                "30 watts",
                "60 watts",
                "100 watts"
            ],
            correctAnswer: 1,
            correctFeedback: "✅ Exactly! PoE+ (802.3at) delivers up to 30 watts per port, which is sufficient for most access points and PTZ cameras.",
            incorrectFeedback: "PoE+ (802.3at) delivers 30 watts per port. Regular PoE (802.3af) is 15.4W, while PoE++ (802.3bt) goes up to 60-100W."
        }
    },
    {
        title: "Wireless Access Point Deployment",
        text: "WiFi is critical in modern networks. Here's how to deploy access points professionally:\n\n📡 PLANNING WIFI COVERAGE:\n\n1️⃣ **Site Survey:**\n   • Walk the space\n   • Identify obstacles (walls, metal, water)\n   • Note ceiling height\n   • Mark coverage dead zones\n   • Count expected users per area\n\n2️⃣ **AP Placement Guidelines:**\n   • One AP per 2,500-5,000 sq ft (rough estimate)\n   • Ceiling mount preferred (better coverage)\n   • Avoid placing near metal or machinery\n   • Stagger on different channels\n   • Higher density for high-traffic areas\n\n3️⃣ **Channel Planning:**\n   • 2.4GHz: Use channels 1, 6, 11 (non-overlapping)\n   • 5GHz: More channels available (less interference)\n   • Keep same-channel APs far apart\n   • Use WiFi analyzer app to check interference\n\n⚙️ **AP INSTALLATION:**\n\n• Mount to ceiling with bracket\n• Run Cat6 cable (must support PoE)\n• Configure on correct VLAN (typically separate)\n• Set SSID and security (WPA3 if possible, WPA2 minimum)\n• Adjust transmit power (lower in dense deployments)\n• Enable band steering (5GHz preferred)\n• Test coverage with mobile device\n\n📶 **Professional Tip:**\nMore APs at lower power > Fewer APs at high power\nReduces interference and improves handoff!",
    },
    {
        title: "Network Security Fundamentals",
        text: "Securing your network is NOT optional. Here are the essential security measures:\n\n🔒 BASIC SECURITY HARDENING:\n\n1️⃣ **Change Default Credentials**\n   • NEVER leave factory defaults!\n   • Use strong passwords (16+ chars)\n   • Mix upper, lower, numbers, symbols\n   • Different password per device\n   • Store in password manager\n\n2️⃣ **Disable Unused Services**\n   ```\n   ! Disable HTTP (use HTTPS only)\n   no ip http server\n   ip http secure-server\n   \n   ! Disable unused ports\n   interface range gi1/0/20-24\n   shutdown\n   exit\n   ```\n\n3️⃣ **Enable Port Security**\n   • Limit MAC addresses per port\n   • Prevents MAC flooding attacks\n   • Auto-shutdown on violation\n\n4️⃣ **Implement Access Control**\n   • Use SSH instead of Telnet\n   • Limit management to specific IPs\n   • Enable AAA (authentication, authorization, accounting)\n   • Use RADIUS for centralized auth\n\n5️⃣ **VLAN Segmentation**\n   • Separate user traffic from servers\n   • Isolate guest WiFi\n   • Security cameras on separate VLAN\n   • IoT devices isolated\n\n6️⃣ **Regular Updates**\n   • Check for firmware updates monthly\n   • Test updates in staging first\n   • Document current version before updating\n   • Always have console access during update\n\n🎯 Security is a process, not a one-time task!",
    },
    {
        title: "Creating and Documenting Network Diagrams",
        text: "Professional documentation is what separates great techs from average ones:\n\n📊 NETWORK DOCUMENTATION:\n\n🗺️ **Physical Diagram:**\n• Shows physical locations\n• Rack layouts\n• Cable paths\n• Jack numbers\n• Equipment serial numbers\n\n🔀 **Logical Diagram:**\n• IP addressing scheme\n• VLAN assignments\n• Routing topology\n• Subnet masks\n• Gateway addresses\n\n💡 **What to Document:**\n\n✅ Equipment Details:\n• Make and model\n• Serial number\n• Firmware version\n• Purchase date\n• Warranty expiration\n• Management IP address\n• Location in rack\n\n✅ Network Information:\n• IP addressing scheme\n• Subnet assignments\n• VLAN IDs and names\n• DNS servers\n• DHCP scopes\n• Default gateway\n\n✅ Port Assignments:\n• Which device on which port\n• VLAN assignment\n• PoE status\n• Port description\n\n✅ Credentials:\n• Admin passwords (secure storage!)\n• SNMP community strings\n• WiFi passwords\n• API keys\n\n📝 **Tools:**\n• draw.io (free, web-based)\n• Microsoft Visio (paid)\n• Lucidchart (cloud-based)\n• NetBox (free, open-source IPAM)\n\nGood documentation = easy troubleshooting!",
    },
    {
        title: "IP Addressing and Subnetting Basics",
        text: "Understanding IP addresses is fundamental to network setup:\n\n🌐 IP ADDRESSING ESSENTIALS:\n\n📍 **Private IP Ranges** (RFC 1918):\n• 10.0.0.0/8 (10.0.0.0 - 10.255.255.255)\n  - Large networks, 16 million hosts\n• 172.16.0.0/12 (172.16.0.0 - 172.31.255.255)\n  - Medium networks, 1 million hosts\n• 192.168.0.0/16 (192.168.0.0 - 192.168.255.255)\n  - Small networks, 65,536 hosts\n  - Most common for small business\n\n📊 **Common Subnet Masks:**\n• /24 = 255.255.255.0 (254 usable hosts)\n• /25 = 255.255.255.128 (126 hosts)\n• /26 = 255.255.255.192 (62 hosts)\n• /27 = 255.255.255.224 (30 hosts)\n• /28 = 255.255.255.240 (14 hosts)\n• /30 = 255.255.255.252 (2 hosts - point-to-point)\n\n🎯 **IP Planning Example:**\n\nNetwork: 192.168.10.0/24\n• .1 - Gateway/Router\n• .2-.9 - Network infrastructure (switches, APs)\n• .10-.99 - Servers\n• .100-.199 - Workstations (DHCP pool)\n• .200-.249 - Printers/devices\n• .250-.254 - Future use\n\n💡 **DHCP vs Static:**\n• Workstations: DHCP (dynamic)\n• Servers: Static IP\n• Network equipment: Static IP\n• Printers: Static IP (for mapping)\n• Phones: DHCP with reservation\n\nPlan your IP scheme BEFORE deploying!",
        image: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200&h=600&fit=crop&q=80",
        imageCaption: "Network IP addressing and documentation",
        customHtml: `
        <div class="bg-gray-800 rounded-lg p-6 my-6">
            <h3 class="text-xl font-bold text-orange-400 mb-4">🌐 Common Subnet Mask Reference</h3>
            <table class="w-full text-left border-collapse mb-6">
                <thead>
                    <tr class="border-b border-gray-700">
                        <th class="py-3 px-4 text-orange-400 font-semibold">CIDR</th>
                        <th class="py-3 px-4 text-orange-400 font-semibold">Subnet Mask</th>
                        <th class="py-3 px-4 text-orange-400 font-semibold text-right">Total IPs</th>
                        <th class="py-3 px-4 text-orange-400 font-semibold text-right">Usable Hosts</th>
                        <th class="py-3 px-4 text-orange-400 font-semibold">Common Use</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300">
                    <tr class="border-b border-gray-700/50 bg-green-500/10">
                        <td class="py-3 px-4 font-mono font-bold text-green-400">/24</td>
                        <td class="py-3 px-4 font-mono">255.255.255.0</td>
                        <td class="py-3 px-4 text-right font-mono">256</td>
                        <td class="py-3 px-4 text-right font-mono text-green-400 font-bold">254</td>
                        <td class="py-3 px-4 text-sm">Most common - small office</td>
                    </tr>
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4 font-mono">/25</td>
                        <td class="py-3 px-4 font-mono">255.255.255.128</td>
                        <td class="py-3 px-4 text-right font-mono">128</td>
                        <td class="py-3 px-4 text-right font-mono">126</td>
                        <td class="py-3 px-4 text-sm">Divided small networks</td>
                    </tr>
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4 font-mono">/26</td>
                        <td class="py-3 px-4 font-mono">255.255.255.192</td>
                        <td class="py-3 px-4 text-right font-mono">64</td>
                        <td class="py-3 px-4 text-right font-mono">62</td>
                        <td class="py-3 px-4 text-sm">Departmental subnets</td>
                    </tr>
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4 font-mono">/27</td>
                        <td class="py-3 px-4 font-mono">255.255.255.224</td>
                        <td class="py-3 px-4 text-right font-mono">32</td>
                        <td class="py-3 px-4 text-right font-mono">30</td>
                        <td class="py-3 px-4 text-sm">Small VLANs</td>
                    </tr>
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4 font-mono">/28</td>
                        <td class="py-3 px-4 font-mono">255.255.255.240</td>
                        <td class="py-3 px-4 text-right font-mono">16</td>
                        <td class="py-3 px-4 text-right font-mono">14</td>
                        <td class="py-3 px-4 text-sm">Tiny networks</td>
                    </tr>
                    <tr class="border-b border-gray-700/50">
                        <td class="py-3 px-4 font-mono">/30</td>
                        <td class="py-3 px-4 font-mono">255.255.255.252</td>
                        <td class="py-3 px-4 text-right font-mono">4</td>
                        <td class="py-3 px-4 text-right font-mono">2</td>
                        <td class="py-3 px-4 text-sm">Point-to-point links</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="bg-gray-900 rounded-lg p-4 border border-gray-700">
                <h4 class="font-bold text-orange-400 mb-3">📋 Example IP Scheme: 192.168.10.0/24</h4>
                <div class="space-y-2 font-mono text-sm">
                    <div class="flex items-center gap-4 p-2 bg-blue-500/20 rounded">
                        <span class="text-blue-400 font-bold w-32">192.168.10.1</span>
                        <span class="text-gray-300">→ Gateway/Router</span>
                    </div>
                    <div class="flex items-center gap-4 p-2 bg-green-500/20 rounded">
                        <span class="text-green-400 font-bold w-32">192.168.10.2-9</span>
                        <span class="text-gray-300">→ Infrastructure (Switches, APs, NVR)</span>
                    </div>
                    <div class="flex items-center gap-4 p-2 bg-purple-500/20 rounded">
                        <span class="text-purple-400 font-bold w-32">192.168.10.10-99</span>
                        <span class="text-gray-300">→ Servers (Static IPs)</span>
                    </div>
                    <div class="flex items-center gap-4 p-2 bg-orange-500/20 rounded">
                        <span class="text-orange-400 font-bold w-32">192.168.10.100-199</span>
                        <span class="text-gray-300">→ Workstations (DHCP Pool)</span>
                    </div>
                    <div class="flex items-center gap-4 p-2 bg-yellow-500/20 rounded">
                        <span class="text-yellow-400 font-bold w-32">192.168.10.200-249</span>
                        <span class="text-gray-300">→ Printers/IoT (Static or Reserved)</span>
                    </div>
                    <div class="flex items-center gap-4 p-2 bg-gray-700/50 rounded">
                        <span class="text-gray-400 font-bold w-32">192.168.10.250-254</span>
                        <span class="text-gray-300">→ Reserved for Future</span>
                    </div>
                </div>
            </div>
            
            <p class="text-sm text-gray-400 mt-4">💡 <strong>Pro Tip:</strong> Document your IP scheme BEFORE deployment and keep it updated. Future-you will thank you!</p>
        </div>
        `,
        quiz: {
            question: "How many usable host addresses are in a /24 subnet?",
            options: [
                "256 addresses",
                "254 addresses",
                "128 addresses",
                "126 addresses"
            ],
            correctAnswer: 1,
            correctFeedback: "🎯 Perfect! A /24 subnet has 256 total addresses, but subtract 2 (network and broadcast), leaving 254 usable host addresses.",
            incorrectFeedback: "A /24 subnet has 256 total addresses minus 2 (network address and broadcast address), which equals 254 usable host addresses."
        }
    },
    {
        title: "Testing Your Network Setup",
        text: "After configuration, you MUST test everything. Here's your checklist:\n\n🧪 NETWORK TESTING PROCEDURES:\n\n1️⃣ **Physical Layer Testing:**\n   • All link lights active?\n   • Correct link speed (1Gbps or 100Mbps)?\n   • No amber/error lights?\n   • PoE devices powering up?\n   • Cable test all connections\n\n2️⃣ **Connectivity Testing:**\n   ```\n   ! From switch CLI\n   ping 192.168.1.1 (gateway)\n   ping 8.8.8.8 (internet)\n   ping google.com (DNS resolution)\n   ```\n\n3️⃣ **VLAN Testing:**\n   • Connect device to each VLAN\n   • Verify correct IP assignment\n   • Test inter-VLAN routing\n   • Confirm isolation between VLANs\n\n4️⃣ **Wireless Testing:**\n   • Can connect to SSID?\n   • Correct VLAN assignment?\n   • Speed test (50+ Mbps on 5GHz)?\n   • Walk coverage area\n   • Test handoff between APs\n\n5️⃣ **Security Testing:**\n   • Try default credentials (should fail!)\n   • Verify SSH access works\n   • Test port security (plug in unauthorized device)\n   • Guest VLAN isolated from internal?\n\n6️⃣ **Performance Testing:**\n   • Run iperf between clients\n   • Check switch CPU/memory\n   • Monitor bandwidth utilization\n   • Test PoE power budget\n\n📝 Document all test results!",
    },
    {
        title: "Common Network Issues and Troubleshooting",
        text: "Things will go wrong. Here's how to troubleshoot like a pro:\n\n🔍 SYSTEMATIC TROUBLESHOOTING:\n\n**THE OSI MODEL APPROACH:**\n\n1️⃣ **Layer 1 - Physical:**\n   • Cable plugged in?\n   • Link light on?\n   • Correct cable type?\n   • Port enabled?\n   • PoE working?\n\n2️⃣ **Layer 2 - Data Link:**\n   • Correct VLAN?\n   • Spanning tree blocking?\n   • MAC address learned?\n   • Switch port security?\n\n3️⃣ **Layer 3 - Network:**\n   • Correct IP address?\n   • Correct subnet mask?\n   • Default gateway set?\n   • Can ping gateway?\n   • Routing table correct?\n\n4️⃣ **Layer 4-7 - Upper Layers:**\n   • Firewall rules?\n   • DNS working?\n   • Application issues?\n\n🐛 **COMMON ISSUES:**\n\n❌ **\"No Internet\"**\n• Check WAN link on router\n• Verify DNS settings\n• Test with 8.8.8.8 ping\n• Check routing\n\n❌ **\"Slow Network\"**\n• Check for broadcast storms\n• Monitor switch CPU\n• Look for duplex mismatches\n• Check for cable errors\n\n❌ **\"WiFi Drops\"**\n• Too many clients per AP\n• Interference from other networks\n• Weak signal\n• Channel overlap\n\n💡 **Pro Tip:** Always start at Layer 1 and work up!",
    },
    {
        title: "Monitoring and Maintenance",
        text: "Networks need ongoing care. Here's your maintenance routine:\n\n📊 NETWORK MONITORING:\n\n🔍 **What to Monitor:**\n\n• **Uptime**\n  - Is equipment online?\n  - Ping monitoring\n  - SNMP polling\n\n• **Performance**\n  - Bandwidth utilization\n  - CPU/memory usage\n  - Interface errors\n  - Packet loss\n\n• **Security**\n  - Failed login attempts\n  - Port security violations\n  - Unusual traffic patterns\n\n🛠️ **MAINTENANCE SCHEDULE:**\n\n📅 **Weekly:**\n• Check system logs\n• Review bandwidth graphs\n• Verify backups working\n\n📅 **Monthly:**\n• Check for firmware updates\n• Review port utilization\n• Test failover/redundancy\n• Clean equipment (blow out dust)\n\n📅 **Quarterly:**\n• Full configuration backup\n• Update documentation\n• Review security policies\n• Test disaster recovery\n\n📅 **Annually:**\n• Plan capacity upgrades\n• Review equipment lifecycle\n• Audit user access\n• Security assessment\n\n💻 **Monitoring Tools:**\n• PRTG Network Monitor (free up to 100 sensors)\n• Nagios (open source)\n• Zabbix (open source)\n• LibreNMS (open source)\n• Cisco Prime (Cisco equipment)\n\nProactive monitoring prevents outages!",
    },
    {
        title: "Backup and Recovery Procedures",
        text: "Configuration backups can save your job. Here's how to do it right:\n\n💾 BACKUP STRATEGIES:\n\n📝 **What to Backup:**\n\n• Switch/router configurations\n• Firewall rules\n• VLAN databases\n• IP address assignments\n• Network documentation\n• Firmware versions (for rollback)\n\n⚙️ **Manual Backup (Cisco):**\n\n```\n! View current config\nshow running-config\n\n! Save to startup-config\nwrite memory\n! or\ncopy running-config startup-config\n\n! Backup to TFTP server\ncopy running-config tftp:\nAddress: 192.168.1.100\nFilename: sw01-config-2025-11-09.txt\n\n! Backup to USB (if supported)\ncopy running-config usbflash0:\n```\n\n🤖 **Automated Backups:**\n• Use RANCID (Really Awesome New Cisco confIg Differ)\n• Oxidized (multi-vendor)\n• Scripts with expect/paramiko\n• Schedule nightly via cron/Task Scheduler\n• Email diffs when configs change\n\n📅 **Backup Schedule:**\n• Before ANY changes\n• After successful changes\n• Weekly automated backup\n• Monthly off-site backup\n\n🔄 **Recovery Process:**\n\n```\n! Restore from TFTP\ncopy tftp: running-config\nAddress: 192.168.1.100\nFilename: sw01-config-2025-11-09.txt\n\n! Verify and save\nshow running-config\nwrite memory\n```\n\n💡 Test your backups - restore to a test device!",
        quiz: {
            question: "When should you backup network device configurations?",
            options: [
                "Only when you remember to",
                "Once a year is enough",
                "Before and after any changes, plus weekly automated backups",
                "Backups aren't necessary"
            ],
            correctAnswer: 2,
            correctFeedback: "✅ Exactly right! Always backup before making changes, after successful changes, and run automated backups weekly. This saves you from disasters!",
            incorrectFeedback: "You should backup before and after any changes, plus run weekly automated backups. Configuration loss can cause major downtime!"
        }
    },
    {
        title: "Advanced Features: Spanning Tree Protocol (STP)",
        text: "Spanning Tree prevents network loops - here's what you need to know:\n\n🔀 SPANNING TREE BASICS:\n\n**What is STP?**\n• Prevents Layer 2 loops\n• Blocks redundant paths\n• Activates backup paths when primary fails\n• Required in networks with redundant switches\n• Without STP, broadcast storms crash network!\n\n📊 **STP Variants:**\n• STP (802.1D) - Original, slow convergence (30-50 sec)\n• RSTP (802.1w) - Rapid STP, fast convergence (1-2 sec)\n• PVST+ - Cisco per-VLAN STP\n• MST (802.1s) - Multiple Spanning Tree\n\n⚙️ **STP Configuration (Cisco):**\n\n```\n! Enable Rapid PVST+ (recommended)\nspanning-tree mode rapid-pvst\n\n! Set root bridge priority\nspanning-tree vlan 1-100 priority 0\n\n! Enable PortFast on access ports (skips STP)\ninterface range gi1/0/1-20\nspanning-tree portfast\nexit\n\n! Enable BPDU Guard (security)\ninterface range gi1/0/1-20\nspanning-tree bpduguard enable\nexit\n```\n\n🎯 **Best Practices:**\n• Use RSTP (rapid-pvst) over classic STP\n• Manually set root bridge (don't rely on defaults)\n• Enable PortFast on access ports only\n• Enable BPDU Guard on access ports\n• Never disable STP unless you know what you're doing!\n\n💡 Broadcast storms can take down entire networks in seconds!",
    },
    {
        title: "Link Aggregation (EtherChannel/LAG)",
        text: "Combine multiple links for higher bandwidth and redundancy:\n\n🔗 LINK AGGREGATION EXPLAINED:\n\n**What is it?**\n• Bonds multiple physical links into one logical link\n• Increases bandwidth (2× 1Gbps = 2Gbps)\n• Provides redundancy (one link fails, others continue)\n• Load balancing across links\n• Also called: EtherChannel (Cisco), LAG, Port Channel\n\n📊 **Common Uses:**\n• Switch-to-switch uplinks\n• Server with dual NICs\n• Storage area networks\n• High-bandwidth applications\n\n⚙️ **EtherChannel Configuration (Cisco):**\n\n```\n! Configure port-channel on first switch\ninterface range gigabitethernet 1/0/23-24\nchannel-group 1 mode active\nno shutdown\nexit\n\n! Configure the port-channel interface\ninterface port-channel 1\nswitchport mode trunk\nswitchport trunk allowed vlan all\ndescription Uplink-to-Core-Switch\nexit\n\n! Verify\nshow etherchannel summary\nshow interface port-channel 1\n```\n\n⚡ **Protocols:**\n• **LACP (802.3ad)** - Standard, use this!\n• **PAgP** - Cisco proprietary\n• **Static/On** - No negotiation (not recommended)\n\n💡 **Important Rules:**\n• All links must be same speed/duplex\n• All links must be same VLAN config\n• Up to 8 physical links per LAG\n• Both sides must use compatible protocol\n\nDouble the links = double the bandwidth!",
    },
    {
        title: "Quality of Service (QoS)",
        text: "Not all traffic is equal. QoS prioritizes important traffic:\n\n📊 QUALITY OF SERVICE BASICS:\n\n**Why QoS?**\n• Voice/video calls need priority (real-time)\n• Business apps over personal browsing\n• Prevent bandwidth hogging\n• Reduce latency for critical traffic\n• Required for VoIP deployments\n\n🎯 **Traffic Classification:**\n\n**Priority Levels (0-7, DSCP):**\n• **High Priority:** Voice (EF - 46)\n• **Medium-High:** Video conferencing (AF41 - 34)\n• **Medium:** Business apps (AF21 - 18)\n• **Low:** Web browsing (Best Effort - 0)\n• **Scavenger:** Personal streaming (CS1 - 8)\n\n⚙️ **Basic QoS Config (Cisco):**\n\n```\n! Enable QoS globally\nmls qos\n\n! Trust DSCP markings from IP phones\ninterface range gi1/0/1-20\nmls qos trust dscp\nexit\n\n! Priority queue for voice VLAN\nmls qos srr-queue output dscp-map queue 1 threshold 3 46\n\n! Apply to voice VLAN\ninterface vlan 30\nmls qos cos 5\nexit\n```\n\n💡 **Simple QoS Strategy:**\n1. Identify voice traffic (VLAN or DSCP)\n2. Give it highest priority\n3. Reserve 20-30% bandwidth for voice\n4. Everything else: best effort\n\n📞 **VoIP Requirements:**\n• Latency < 150ms\n• Jitter < 30ms\n• Packet loss < 1%\n• QoS makes this possible!\n\nGood QoS = crystal clear phone calls!",
    },
    {
        title: "Remote Management Best Practices",
        text: "Managing network equipment remotely requires security and planning:\n\n🌐 REMOTE ACCESS METHODS:\n\n🔒 **Secure Options:**\n\n1️⃣ **SSH (Secure Shell)**\n   • Encrypted terminal access\n   • Port 22 (default)\n   • Use key-based auth when possible\n   • Best for CLI management\n\n2️⃣ **HTTPS Web Interface**\n   • Encrypted web access\n   • Port 443\n   • Good for switch/AP config\n   • Less features than CLI\n\n3️⃣ **VPN Access**\n   • Connect to network remotely\n   • Then use SSH/HTTPS\n   • Most secure method\n   • Required for production networks\n\n4️⃣ **Out-of-Band Management**\n   • Separate management network\n   • IPMI/iLO for servers\n   • Console server for switches\n   • Access even if network is down\n\n❌ **NEVER USE:**\n• Telnet (unencrypted!)\n• HTTP (unencrypted!)\n• Default passwords\n• Direct internet exposure\n\n🔐 **Security Measures:**\n\n```\n! Restrict SSH to specific IPs\naccess-list 10 permit 192.168.1.0 0.0.0.255\naccess-list 10 permit 10.0.0.0 0.255.255.255\nline vty 0 15\naccess-class 10 in\nexit\n\n! Set idle timeout\nline vty 0 15\nexec-timeout 10 0\nexit\n\n! Enable logging\nlogging buffered 16384\nlogging console informational\n```\n\n💡 Always have console access as backup!",
    },
    {
        title: "Network Equipment Lifecycle Management",
        text: "Equipment doesn't last forever. Plan for refresh cycles:\n\n📅 EQUIPMENT LIFECYCLE:\n\n🔄 **Typical Lifespans:**\n• Network switches: 5-7 years\n• Routers: 5-7 years\n• Wireless APs: 3-5 years (tech changes fast)\n• Firewalls: 3-5 years (security updates critical)\n• Servers: 3-5 years\n• UPS batteries: 3-5 years\n\n⚠️ **End-of-Life (EOL) Stages:**\n\n1. **End of Sales (EOS)**\n   - Can't buy new anymore\n   - Still getting updates\n   - Start planning replacement\n\n2. **End of Support (EOS)**\n   - No more updates/patches\n   - Security risk!\n   - Replace ASAP\n\n3. **End of Life (EOL)**\n   - No support at all\n   - Parts unavailable\n   - High failure risk\n\n💰 **Budgeting for Refresh:**\n\n• Calculate total equipment cost\n• Divide by expected lifespan\n• Set aside annually\n• Example: $10,000 equipment / 5 years = $2,000/year\n\n📊 **Replacement Planning:**\n• Track purchase dates\n• Monitor vendor EOL announcements\n• Test new equipment before deploying\n• Plan refresh during low-usage times\n• Keep old equipment as cold spare (if working)\n\n💡 Don't wait for failure - plan proactively!",
    },
    {
        title: "Pricing Network Equipment Installation",
        text: "Know your worth! Here's how to price network equipment work:\n\n💰 SERVICE PRICING:\n\n📊 **Hourly Rates:**\n• Junior tech: $75-100/hour\n• Mid-level tech: $100-150/hour\n• Senior/specialist: $150-250/hour\n• Emergency/after-hours: 1.5-2× normal rate\n• Weekend: 1.5-2× normal rate\n\n🔧 **Common Job Pricing:**\n\n**Small Office (5-15 users):**\n• 1× 24-port PoE switch\n• 1× firewall/router\n• 2-3× wireless APs\n• Cable management\n• Configuration\n• Total time: 8-16 hours\n• Labor: $800-2,400\n• Equipment: $2,000-5,000\n• Total project: $2,800-7,400\n\n**Medium Office (25-50 users):**\n• 2× 48-port PoE switches\n• 1× router + firewall\n• 5-8× wireless APs\n• Rack + cable management\n• VLANs + advanced config\n• Total time: 16-32 hours\n• Labor: $1,600-4,800\n• Equipment: $8,000-15,000\n• Total project: $9,600-19,800\n\n💡 **Equipment Markup:**\n• Hardware: 20-40% over cost\n• Includes procurement time\n• Warranty management\n• RMA handling\n\n📋 **Additional Services:**\n• Network design: $500-2,000\n• Documentation: $200-500\n• Training: $100-150/hour\n• Monthly monitoring: $50-200/month\n• Annual maintenance: 10-15% of equipment cost\n\nAlways provide detailed quotes!",
    },
    {
        title: "Professional Certifications",
        text: "Certifications boost your credibility and earning potential:\n\n🎓 RECOMMENDED CERTIFICATIONS:\n\n🥉 **Entry Level:**\n\n**CompTIA Network+**\n• Cost: ~$350 exam\n• Vendor-neutral\n• Covers networking fundamentals\n• Good foundation\n• Time: 2-3 months study\n\n**Cisco CCNA (200-301)**\n• Cost: ~$300 exam\n• Industry standard\n• Cisco-focused but applies broadly\n• Covers routing, switching, wireless\n• Time: 3-6 months study\n• Value: $5-10k salary increase\n\n🥈 **Intermediate:**\n\n**Cisco CCNP Enterprise**\n• Cost: ~$400 per exam (2 exams)\n• Advanced routing/switching\n• Large network design\n• Automation basics\n\n**Ubiquiti UniFi Certified**\n• Cost: Free\n• Growing platform\n• Small-medium business focus\n\n🥇 **Advanced:**\n\n**Cisco CCIE**\n• Cost: ~$1,600 exam + lab\n• Expert-level\n• Extremely difficult\n• Top-tier salary potential\n\n📚 **Study Resources:**\n• CBT Nuggets (video training)\n• Udemy courses\n• Official cert guides\n• Home lab equipment\n• GNS3/Packet Tracer (simulators)\n• Reddit: /r/ccna, /r/networking\n\n💰 ROI: Certifications pay for themselves quickly!",
    },
    {
        title: "Final Comprehensive Knowledge Check",
        text: "Time to prove you've mastered network equipment setup! Let's test everything you've learned:\n\n✅ **You've Mastered:**\n\n• Network equipment types and purposes\n• Rack mounting and cable management\n• Power planning and PoE deployment\n• Console access and initial configuration\n• VLAN setup and segmentation\n• Wireless access point deployment\n• Network security hardening\n• IP addressing and subnetting\n• Testing and troubleshooting\n• Documentation and monitoring\n• Backup and recovery procedures\n• Advanced features (STP, LAG, QoS)\n• Remote management best practices\n• Equipment lifecycle management\n• Professional pricing strategies\n• Certification paths\n\n🎯 **You're Ready To:**\n• Configure professional network infrastructure\n• Deploy enterprise wireless systems\n• Implement network security best practices\n• Troubleshoot complex network issues\n• Document networks professionally\n• Price your services competitively\n• Pass certification exams\n\nLet's verify your knowledge with one comprehensive question!",
        quiz: {
            question: "You're setting up a new office network with 30 users, 5 servers, VoIP phones, and wireless access. Which approach demonstrates professional best practices?",
            options: [
                "One flat network with all devices in VLAN 1, default passwords, no documentation",
                "Separate VLANs for users/servers/voice/WiFi, PoE for phones/APs, QoS for VoIP, documented IP scheme, strong passwords, regular backups",
                "Just plug everything into an unmanaged switch and hope it works",
                "Use all default settings and don't change anything"
            ],
            correctAnswer: 1,
            correctFeedback: "🎉 OUTSTANDING! You understand professional network deployment! VLAN segmentation, PoE planning, QoS for voice, proper documentation, security hardening, and backup procedures - you've got it all! You're ready for real-world deployments!",
            incorrectFeedback: "Professional deployments require: VLAN segmentation (security), PoE planning (voice/WiFi), QoS (VoIP quality), strong passwords (security), IP documentation (troubleshooting), and regular backups (disaster recovery). These aren't optional!"
        }
    },
    {
        title: "Congratulations - You're Network Certified!",
        text: "🎓 **EXCEPTIONAL WORK!**\n\nYou've completed the Network Equipment Setup & Configuration training!\n\n✅ **You Now Master:**\n\n• Network equipment selection and deployment\n• Professional rack mounting techniques\n• Switch configuration (Cisco IOS & others)\n• VLAN segmentation and security\n• PoE planning and implementation\n• Wireless infrastructure deployment\n• Network security best practices\n• IP addressing and subnetting\n• Systematic troubleshooting\n• Professional documentation\n• Backup and disaster recovery\n• Advanced features (STP, LAG, QoS)\n• Remote management\n• Equipment lifecycle planning\n• Business operations and pricing\n\n🚀 **Your Next Steps:**\n\n1. **Build a Home Lab**\n   • Get used equipment on eBay\n   • Practice configurations\n   • Break things and fix them\n\n2. **Pursue Certifications**\n   • Start with CCNA or Network+\n   • Join study groups\n   • Use GNS3/Packet Tracer\n\n3. **Gain Real Experience**\n   • Start with small office jobs\n   • Document everything\n   • Build your portfolio\n\n4. **Stay Current**\n   • Follow networking blogs\n   • Join communities (/r/networking)\n   • Learn automation (Python)\n   • Cloud networking (AWS, Azure)\n\n💼 **The Network Engineering Field is BOOMING:**\n• Every business needs networking\n• Remote work = more network upgrades\n• IoT devices everywhere\n• WiFi 6/7 upgrades\n• Cloud migrations\n• Security concerns driving upgrades\n\n📜 **Download your certificate** and showcase your new expertise!\n\nYou're now qualified to deploy professional network infrastructure. Go make networks better!",
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
    <Head title="Network Equipment Setup Training" />

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
                            <p class="text-xl text-gray-600">You've completed the Network Equipment Setup Training</p>
                        </div>

                        <div class="bg-orange-50 border-2 border-orange-200 rounded-lg p-6 mb-6">
                            <p class="text-lg text-gray-700 mb-2">Your Score:</p>
                            <p class="text-5xl font-bold text-orange-600">{{ certificate?.score || 0 }}%</p>
                        </div>

                        <div class="space-y-4">
                            <p class="text-gray-600">
                                You've mastered professional network equipment setup, configuration, and management!
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
