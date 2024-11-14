<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

defineProps({ product_types:Object})

</script>
<template>
    <AppLayout>
        <template #header>
            <div class="flex ml-20 w-full mt-5 justify-center">
                <SearchInput class="w-2/3"></SearchInput>
            </div>
        </template>
        <div>
            <div class="flex justify-center">
                <div class="min-h-screen w-4/5">
                    <div class="ml-5 mt-5">

                        <div class="bg-blue-600 rounded-md px-2 py-2 w-fit text-white relative ">


                         <div class="me-2 flex items-center">
                                <div class="mx-2">
                                    หมวดหมู่สินค้า
                                </div>
                                <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                    class="inline-flex items-center justify-center rounded-md p-2 text-white transition duration-150 ease-in-out hover:bg-blue-500 focus:bg-blue-500 focus:text-white focus:outline-none">
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        <path :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>


                            <div :class="{
                                'block': showingNavigationDropdown,
                                'hidden': !showingNavigationDropdown
                            }" class=" mt-3 w-48 bg-blue-600 rounded-md shadow-lg">


                                <div class="border-t border-gray-200 pb-1 pt-4 dark:border-gray-600 " v-for="product_type in product_types" :key="product_type.producttype_id">
                                    <div class="px-4">
                                        <div class="text-base font-medium text-gray-800 dark:text-gray-200">

                                        </div>
                                        <div class="text-sm font-medium text-gray-500">

                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        {{ product_type.producttype_name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
