<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { ref } from 'vue';
import { Link, Head } from '@inertiajs/vue3';
import Category from '@/Components/Category.vue';

const props = defineProps(['product_types', 'banners']);


const showingNavigationDropdown = ref(false);



</script>
<template>
    <AppLayout>

        <Head title="TPPS" />
        <template #header>
            <div class="flex ml-20 w-full mt-5 justify-center">
                <SearchInput class="w-2/3"></SearchInput>
            </div>
        </template>
        <div>
            <div class="flex justify-center">
                <div class="min-h-screen w-full">
                    <div class="flex flex-row">
                        <div class="ml-24 mt-5 w-52">
                            <Category>
                                <div class="border-b border-gray-200 pb-4 pt-4 dark:border-gray-600"
                                    v-for="product_type in product_types" :key="product_type.producttype_id">
                                    <Link :href="route('product.category', { id: product_type.producttype_id })"
                                        class="pl-1 pr-2 ml-2 text-left text-base font-medium text-white dark:text-gray-200 hover:text-blue-300">
                                    {{ product_type.producttype_name }}
                                    </Link>
                                </div>
                            </Category>
                        </div>
                        <div class="flex flex-col">
                            <div class="mt-5 ml-10">
                                <div v-for="(banner, index) in banners" :key="index">
                                    <img class="h-auto max-w-full" :src="/storage/ + banner.public_url"
                                        :alt="'Banner' + (index + 1)" width="1290" height="500" />
                                </div>
                                <div>

                                    <h1 class="flex items-center text-4xl font-extrabold dark:text-white mt-10">ข่าวสาร
                                    </h1>

                                    <hr class="h-px my-5 bg-gray-200 border-0 dark:bg-gray-700">

                                    <div class="grid grid-cols-3 gap-4 ml-5">

                                        <div
                                            class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 my-9">
                                            <a href="#" class="flex justify-center">
                                                <img class="rounded-t-lg "
                                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png"
                                                    alt="dfg" width="150" height="150" />
                                            </a>
                                            <div class="p-5">
                                                <a href="#">
                                                    <h5
                                                        class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                                        Noteworthy technology acquisitions 2021</h5>
                                                </a>
                                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here
                                                    are the
                                                    biggest
                                                    enterprise technology acquisitions of 2021 so far, in reverse
                                                    chronological
                                                    order.</p>
                                                <a href="#"
                                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    Read more
                                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 10">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>

                                        <div
                                            class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 my-9">
                                            <a href="#" class="flex justify-center">
                                                <img class="rounded-t-lg "
                                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png"
                                                    alt="dfg" width="150" height="150" />
                                            </a>
                                            <div class="p-5">
                                                <a href="#">
                                                    <h5
                                                        class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                                        Noteworthy technology acquisitions 2021</h5>
                                                </a>
                                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here
                                                    are the
                                                    biggest
                                                    enterprise technology acquisitions of 2021 so far, in reverse
                                                    chronological
                                                    order.</p>
                                                <a href="#"
                                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    Read more
                                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 10">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                        <div
                                            class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 my-9">
                                            <a href="#" class="flex justify-center">
                                                <img class="rounded-t-lg "
                                                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png"
                                                    alt="dfg" width="150" height="150" />
                                            </a>
                                            <div class="p-5">
                                                <a href="#">
                                                    <h5
                                                        class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                                        Noteworthy technology acquisitions 2021</h5>
                                                </a>
                                                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here
                                                    are the
                                                    biggest
                                                    enterprise technology acquisitions of 2021 so far, in reverse
                                                    chronological
                                                    order.</p>
                                                <a href="#"
                                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    Read more
                                                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 14 10">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
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
