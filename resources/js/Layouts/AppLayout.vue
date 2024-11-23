<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Footer from '@/Components/Footer.vue';
import { Link } from '@inertiajs/vue3';

</script>
<template>
    <div>
        <div class="min-h-screen bg-white">
            <div class="min-w-full bg-gray-100">
                <div class="flex justify-end mx-auto px-6 sm:px-8 lg:px-10 text-black">
                    <Link :href="route('admin.dashboard')">
                    admin login
                    </Link>
                </div>

            </div>
            <header class="bg-white shadow dark:bg-gray-800" v-if="$slots.header">
                <div class="mx-auto max-w-7xl ">
                    <div class="flex items-center">
                        <Link :href="route('product.index')">
                        <ApplicationLogo class="block h-10 w-auto fill-current text-gray-800 dark:text-gray-200">
                        </ApplicationLogo>
                        </Link>
                        <slot name="header" />

                    </div>
                </div>
            </header>

            <div class="flex justify-center">
                <div class="min-h-screen w-full">
                    <main>
                        <slot />
                    </main>

                </div>

            </div>
        </div>
        <Footer></Footer>
    </div>
</template>
