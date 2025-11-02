<template>
    <div class="fixed bottom-4 left-4 z-50 pointer-events-none">
        <TransitionGroup name="notification">
            <div
                v-for="notification in activeNotifications"
                :key="notification.id"
                class="mb-3 bg-white rounded-lg shadow-2xl border-2 border-green-500 p-4 max-w-sm pointer-events-auto transform hover:scale-105 transition-transform"
            >
                <div class="flex items-start space-x-3">
                    <!-- Success Icon -->
                    <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center space-x-2">
                            <p class="text-sm font-bold text-gray-900">
                                {{ notification.name }}
                            </p>
                            <span class="text-xs text-gray-500">
                                {{ notification.location }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">
                            Just purchased <span class="font-bold text-orange-600">{{ notification.product }}</span>
                        </p>
                        <div class="flex items-center mt-2 space-x-2">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-800">
                                {{ notification.price }}
                            </span>
                            <span class="text-xs text-gray-400">{{ notification.timeAgo }}</span>
                        </div>
                    </div>

                    <!-- Close Button -->
                    <button
                        @click="removeNotification(notification.id)"
                        class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors"
                    >
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </TransitionGroup>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const activeNotifications = ref([]);
let notificationId = 0;
let interval = null;

// Fake data pools
const firstNames = ['James', 'Mary', 'John', 'Patricia', 'Robert', 'Jennifer', 'Michael', 'Linda', 'William', 'Barbara', 'David', 'Elizabeth', 'Richard', 'Susan', 'Joseph', 'Jessica', 'Thomas', 'Sarah', 'Charles', 'Karen', 'Christopher', 'Nancy', 'Daniel', 'Lisa', 'Matthew', 'Betty', 'Anthony', 'Margaret', 'Mark', 'Sandra'];

const lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin', 'Lee', 'Thompson', 'White', 'Harris', 'Clark'];

const cities = [
    'New York, NY', 'Los Angeles, CA', 'Chicago, IL', 'Houston, TX', 'Phoenix, AZ',
    'Philadelphia, PA', 'San Antonio, TX', 'San Diego, CA', 'Dallas, TX', 'San Jose, CA',
    'Austin, TX', 'Jacksonville, FL', 'Fort Worth, TX', 'Columbus, OH', 'Charlotte, NC',
    'San Francisco, CA', 'Indianapolis, IN', 'Seattle, WA', 'Denver, CO', 'Washington, DC',
    'Boston, MA', 'Nashville, TN', 'Detroit, MI', 'Portland, OR', 'Las Vegas, NV',
    'Memphis, TN', 'Louisville, KY', 'Baltimore, MD', 'Milwaukee, WI', 'Atlanta, GA'
];

const products = [
    { name: 'Field Engineer\'s Operations Guide', price: '$297' },
    { name: 'Starter Package', price: '$197' },
    { name: 'Complete Bundle', price: '$497' },
    { name: 'Premium Training Package', price: '$397' }
];

const timeAgoOptions = ['Just now', '2 min ago', '5 min ago', '8 min ago', '12 min ago'];

const getRandomItem = (array) => {
    return array[Math.floor(Math.random() * array.length)];
};

const generateNotification = () => {
    const firstName = getRandomItem(firstNames);
    const lastInitial = getRandomItem(lastNames).charAt(0);
    const product = getRandomItem(products);

    return {
        id: ++notificationId,
        name: `${firstName} ${lastInitial}.`,
        location: getRandomItem(cities),
        product: product.name,
        price: product.price,
        timeAgo: getRandomItem(timeAgoOptions)
    };
};

const showNotification = () => {
    const notification = generateNotification();
    activeNotifications.value.push(notification);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        removeNotification(notification.id);
    }, 5000);

    // Limit to max 3 notifications at a time
    if (activeNotifications.value.length > 3) {
        activeNotifications.value.shift();
    }
};

const removeNotification = (id) => {
    const index = activeNotifications.value.findIndex(n => n.id === id);
    if (index !== -1) {
        activeNotifications.value.splice(index, 1);
    }
};

onMounted(() => {
    // Show first notification after 3 seconds
    setTimeout(() => {
        showNotification();
    }, 3000);

    // Then show notifications at random intervals (15-45 seconds)
    const scheduleNext = () => {
        const delay = Math.random() * 30000 + 15000; // 15-45 seconds
        interval = setTimeout(() => {
            showNotification();
            scheduleNext();
        }, delay);
    };

    scheduleNext();
});

onUnmounted(() => {
    if (interval) {
        clearTimeout(interval);
    }
});
</script>

<style scoped>
.notification-enter-active {
    animation: slideInLeft 0.5s ease-out;
}

.notification-leave-active {
    animation: slideOutLeft 0.3s ease-in;
}

@keyframes slideInLeft {
    from {
        transform: translateX(-100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutLeft {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(-100%);
        opacity: 0;
    }
}
</style>
