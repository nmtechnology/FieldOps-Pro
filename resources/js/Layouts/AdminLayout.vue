<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

const showingNavigationDropdown = ref(false);
const darkMode = ref(false);

// Check if user is admin
const isAdmin = computed(() => {
    return usePage().props.auth.user?.is_admin === true;
});

// Toggle dark mode function
const toggleDarkMode = () => {
    darkMode.value = !darkMode.value;
    localStorage.setItem('darkMode', darkMode.value ? 'enabled' : 'disabled');
    updateTheme();
};

// Update the document theme based on dark mode setting
const updateTheme = () => {
    if (darkMode.value) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

// Load Stripe.js and initialize dark mode when component mounts
onMounted(() => {
    // Initialize dark mode from localStorage or system preference
    const savedTheme = localStorage.getItem('darkMode');
    if (savedTheme === 'enabled' || 
        (savedTheme === null && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        darkMode.value = true;
    }
    
    updateTheme();
    
    // If user is not admin, redirect to customer dashboard
    if (!isAdmin.value) {
        // Non-admin users should not see this layout, redirect to home
        window.location.href = route('home.index');
    }
});
</script>

<template>
    <div class="bg-gray-900">
        <div class="min-h-screen bg-gradient-to-b from-gray-800 via-gray-900 to-black">
            <nav class="border-b border-gray-700 bg-gray-800">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('home.index')" class="flex items-center hover:opacity-80 transition-opacity">
                                    <ApplicationLogo class="h-9 w-auto mr-2" />
                                    <span class="text-2xl font-bold text-orange-400">Admin Portal</span>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink href="/admin/dashboard" :active="$page.url.startsWith('/admin/dashboard')">
                                    Dashboard
                                </NavLink>
                                
                                <NavLink href="/admin/orders" :active="$page.url.startsWith('/admin/orders')">
                                    Orders
                                </NavLink>

                                <NavLink href="/admin/users" :active="$page.url.startsWith('/admin/users')">
                                    Users
                                </NavLink>
                                
                                <NavLink href="/admin/products" :active="$page.url.startsWith('/admin/products')">
                                    Products
                                </NavLink>
                                
                                <NavLink href="/admin/discounts" :active="$page.url.startsWith('/admin/discounts')">
                                    Discounts
                                </NavLink>

                                <NavLink href="/admin/reports" :active="$page.url.startsWith('/admin/reports')">
                                    Reports
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Dark Mode Toggle -->
                            <button 
                                @click="toggleDarkMode" 
                                class="inline-flex items-center px-3 py-2 border border-orange-400 text-sm leading-4 font-medium rounded-md text-white bg-gray-800 hover:text-orange-400 focus:outline-none transition ease-in-out duration-150 mr-2"
                                :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'"
                            >
                                <!-- Sun icon for light mode -->
                                <svg v-if="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <!-- Moon icon for dark mode -->
                                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </button>
                            
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-orange-500 px-3 py-2 text-sm font-medium leading-4 text-white transition duration-150 ease-in-out hover:bg-orange-600 focus:outline-none"
                                            >
                                                {{ $page.props.auth.user.name }} (Admin)

                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')">
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink :href="route('dashboard')">
                                            Customer View
                                        </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-700 hover:text-gray-300 focus:bg-gray-700 focus:text-gray-300 focus:outline-none"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink href="/admin/dashboard" :active="$page.url.startsWith('/admin/dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                        
                        <ResponsiveNavLink href="/admin/orders" :active="$page.url.startsWith('/admin/orders')">
                            Orders
                        </ResponsiveNavLink>

                        <ResponsiveNavLink href="/admin/users" :active="$page.url.startsWith('/admin/users')">
                            Users
                        </ResponsiveNavLink>
                        
                        <ResponsiveNavLink href="/admin/products" :active="$page.url.startsWith('/admin/products')">
                            Products
                        </ResponsiveNavLink>
                        
                        <ResponsiveNavLink href="/admin/discounts" :active="$page.url.startsWith('/admin/discounts')">
                            Discounts
                        </ResponsiveNavLink>

                        <ResponsiveNavLink href="/admin/reports" :active="$page.url.startsWith('/admin/reports')">
                            Reports
                        </ResponsiveNavLink>
                    </div>

                    <!-- Dark Mode Toggle (Mobile) -->
                    <div class="border-t border-gray-700 pt-4 pb-1 px-4">
                        <button 
                            @click="toggleDarkMode" 
                            class="flex items-center w-full py-2 text-left text-base font-medium text-white hover:text-orange-400 focus:outline-none focus:text-orange-400 transition duration-150 ease-in-out"
                        >
                            <!-- Sun icon for light mode -->
                            <svg v-if="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <!-- Moon icon for dark mode -->
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            {{ darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode' }}
                        </button>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="border-t border-gray-700 pb-1 pt-4">
                        <div class="px-4">
                            <div class="font-medium text-base text-orange-400">
                                {{ $page.props.auth.user.name }} (Admin)
                            </div>
                            <div class="font-medium text-sm text-white">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('dashboard')">
                                Customer View
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-gray-800 shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>