<template>
    <div class="flex justify-center">
        <div class="relative">
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" v-model="isDarkMode" class="sr-only peer" @change="handleToggle">
                <div
                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                </div>
                <!-- Display the label text dynamically based on the theme -->
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">

                    <MoonIcon v-if="themeLabel === 'Dark Mode'" class="h-6 w-6 text-gray-400" aria-hidden="true" />
                    <SunIcon v-if="themeLabel === 'Light Mode'" class="h-6 w-6 text-amber-500" aria-hidden="true" />
                </span>
            </label>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { SunIcon, MoonIcon, ComputerDesktopIcon } from '@heroicons/vue/20/solid';
// Create a reactive property to keep track of dark mode state
const isDarkMode = ref(localStorage.getItem('theme') === 'dark' || (localStorage.getItem('theme') === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches));

// Function to toggle dark mode
const handleToggle = () => {
    // Set the theme in localStorage based on the toggle status
    if (isDarkMode.value) {
        localStorage.setItem('theme', 'dark');
        document.documentElement.classList.add('dark');
    } else {
        localStorage.setItem('theme', 'light');
        document.documentElement.classList.remove('dark');
    }
};

// Computed property to show the label based on the theme
const themeLabel = computed(() => isDarkMode.value ? "Dark Mode" : "Light Mode");

// Watch for system preference changes if theme is set to "system"
const systemDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
systemDarkMode.addEventListener('change', (e) => {
    if (localStorage.getItem('theme') === 'system') {
        isDarkMode.value = e.matches;
        handleToggle();
    }
});

// Initialize theme on page load
onMounted(() => {
    if (localStorage.getItem('theme') === 'system') {
        isDarkMode.value = systemDarkMode.matches;
    }
    handleToggle();
});
</script>
