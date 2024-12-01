<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Footer from '@/Components/Footer.vue';
import { Link } from '@inertiajs/vue3';

</script>
<template>
    <div>
        <div class="min-h-screen bg-white">
            <div class="min-w-full bg-[#333552]">


                <div class="flex justify-end mr-2">
                    <Link :href="route('admin.dashboard')" class="text-white text-sm">
                    สำหรับผู้ดูแล
                    </Link>

                </div>
            </div>
            <header class="bg-[#333552] shadow dark:bg-gray-800 py-5" v-if="$slots.header">
                <div class="mx-auto">
                    <div class="flex items-center">
                        <Link :href="route('product.index')">
                        <div class="mx-10">
                            <ApplicationLogo />
                        </div>
                        </Link>
                        <slot name="header" />

                    </div>
                </div>
            </header>

            <div class="flex justify-center">
                <div class=" max-h-max w-full">
                    <main>
                        <slot />
                    </main>

                </div>

            </div>
        </div>
        <Footer>

        </Footer>
    </div>
</template>
