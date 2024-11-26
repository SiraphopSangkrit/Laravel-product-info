<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { ref } from 'vue';
import { Link, Head } from '@inertiajs/vue3';
import Category from '@/Components/Category.vue';

const props = defineProps(['product_types', 'banners', 'news', 'products']);


const showingNavigationDropdown = ref(false);



</script>
<template>
    <AppLayout>

        <Head title="TPPS" />
        <template #header>
            <div class="flex w-full justify-center">
                <SearchInput></SearchInput>
            </div>
        </template>

        <div class="flex justify-start">
            <div class="mt-5 ml-24 ">
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
        </div>
        <div class="flex justify-center">


            <div class="flex flex-col">
                <div class="ml-10 mt-5">
                    <div v-for="(banner, index) in banners" :key="index">
                        <img class="h-auto max-w-full" :src="/storage/ + banner.public_url"
                            :alt="'Banner' + (index + 1)" width="1290" height="500" />
                    </div>
                    <div>

                        <div class="flex justify-between">
                            <h1 class="flex items-center text-4xl font-extrabold dark:text-white mt-10">สินค้าใหม่
                            </h1>

                        </div>


                        <hr class="h-px my-5 bg-gray-200 border-1 dark:bg-gray-700">

                        <div class="grid grid-cols-3 gap-4 ml-5">
                            <div v-for="(product, index) in products" :key="index">
                                <Link
                                    :href="route('product.detail', { product_id: product.product_id, producttype_id: product.producttype_id })">
                                <div
                                    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 my-9">
                                    <div class="flex justify-center">
                                        <img :src="product.product_pics && product.product_pics[0]
                                            ? '/storage/' + product.product_pics[0].public_url
                                            : 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png'"
                                            :alt="product.product_pics && product.product_pics[0]
                                                ? 'Image ' + product.product_id
                                                : 'No Image Available'" class="h-72 w-72 rounded-lg my-3" />
                                    </div>
                                    <div class="p-5">

                                        <h5
                                            class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                            {{ product.product_name }}</h5>

                                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 line-clamp-3">
                                            {{ product.product_desc }}</p>
                                        <div
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            ดูเพิ่มเติม
                                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                </Link>
                            </div>


                        </div>

                    </div>
                    <div v-if="news && news[0]">
                        <Link :href="route('news.index')">
                        <div class="flex justify-between">
                            <h1 class="flex items-center text-4xl font-extrabold dark:text-white mt-10">ข่าวสาร
                            </h1>
                            <diV class="mt-10">
                                ดูข่าวทั้งหมด >>>
                            </diV>
                        </div>
                        </Link>

                        <hr class="h-px my-5 bg-gray-200 border-1 dark:bg-gray-700">

                        <div class="grid grid-cols-3 gap-4 ml-5">
                            <div v-for="(news, index) in news" :key="index">
                                <Link :href="route('news.detail', { id: news.news_id })">
                                <div
                                    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 my-9">
                                    <div class="flex justify-center">
                                        <img :src="news.news_pics && news.news_pics[0]
                                            ? '/storage/' + news.news_pics[0].public_url
                                            : 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png'"
                                            :alt="news.news_pics && news.news_pics[0]
                                                ? 'Image ' + news.news_id
                                                : 'No Image Available'" class="h-72 w-72 rounded-lg my-3" />
                                    </div>
                                    <div class="p-5">

                                        <h5
                                            class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                            {{ news.news_name }}</h5>

                                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 line-clamp-3">
                                            {{ news.news_desc }}</p>
                                        <div
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            อ่านเพิ่มเติม
                                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                </Link>
                            </div>


                        </div>

                    </div>

                </div>
            </div>
        </div>


    </AppLayout>
</template>
