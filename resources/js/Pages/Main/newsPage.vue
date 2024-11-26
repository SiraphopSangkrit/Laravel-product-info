<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import SearchInput from '@/Components/SearchInput.vue';
import Category from '@/Components/Category.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps(['product_types', 'news', 'newsPicture']);



</script>
<template>
    <AppLayout>

        <Head>
            <title>{{ news.news_name }}</title>

        </Head>

        <template #header>
            <div class="flex w-full  justify-center">
                <SearchInput></SearchInput>
            </div>
        </template>

        <div>
            <div class="flex justify-center">
                <div class="min-h-screen w-full">

                    <div class="ml-24 mt-5 w-fit">
                        <Category>
                            <div v-for="product_type in product_types" :key="product_type.producttype_id">
                                <Link :href="route('product.category', { id: product_type.producttype_id })">
                                <div class="pb-4 pt-4 dark:border-gray-600 hover:bg-blue-500 rounded-lg">
                                    <div class="pl-1 pr-2 text-lg font-medium ml-2 text-white dark:text-gray-200">

                                        {{ product_type.producttype_name }}
                                    </div>
                                </div>
                                </Link>
                            </div>
                        </Category>
                    </div>

                    <div class="flex justify-center w-full">
                        <div class="font-sans">
                            <div class="p-4 lg:max-w-5xl max-w-lg mx-auto">
                                <div class="grid items-start grid-cols-1 lg:grid-cols-2 gap-6 max-lg:gap-12">

                                    <div class="w-full top-0 gap-2 flex">


                                        <img :src="'/storage/' + newsPicture[0].public_url" alt="Product"
                                            class="w-4/5 rounded-md object-cover" />
                                    </div>

                                    <div>
                                        <h2 class="text-2xl font-bold text-gray-800">{{ news.news_name }}
                                        </h2>

                                        <div class="mt-8">
                                            <h3 class="text-xl font-bold text-gray-800">รายละเอียด</h3>
                                            <div class="ml-2 mt-4 font-normal">
                                                <div class="mt-4 indent-8">
                                                    {{ news.news_desc }}
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="my-5">


                        <div id="gallery" class="relative w-full" data-carousel="slide">

                            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">

                                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                    <div v-for="pic in newsPicture" :key="pic.newsPic_id">

                                        <img :src="'/storage/' + pic.public_url"
                                            class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                            alt="">
                                    </div>
                                </div>

                            </div>
                            <!-- Slider controls -->
                            <button type="button"
                                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                data-carousel-prev>
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M5 1 1 5l4 4" />
                                    </svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button type="button"
                                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                                data-carousel-next>
                                <span
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>
</template>
