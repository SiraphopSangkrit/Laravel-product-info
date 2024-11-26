<template>
    <div class="relative">
        <div class="bg-blue-600 rounded-md px-2 py-2  text-white text-xl">
            <div class="flex items-center">
                <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                    class="inline-flex items-center  rounded-md p-2 text-white transition duration-150 ease-in-out hover:bg-blue-500 focus:bg-blue-500 focus:text-white focus:outline-none">
                    หมวดหมู่สินค้า
                    <svg class="h-6 w-6 ml-11" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{
                            hidden: showingNavigationDropdown,
                            'inline-flex': !showingNavigationDropdown,
                        }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{
                            hidden: !showingNavigationDropdown,
                            'inline-flex': showingNavigationDropdown,
                        }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div v-show="showingNavigationDropdown" class="fixed inset-0 z-10"
                @click="showingNavigationDropdown = false">
            </div>

            <div v-show="showingNavigationDropdown"
                class="absolute z-20 left-0  w-80 bg-blue-600 rounded-md shadow-lg" style="display: none"
                @click="showingNavigationDropdown = false">

                <slot />
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';

const showingNavigationDropdown = ref(false);
</script>
