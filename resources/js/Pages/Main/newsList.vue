<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { ref, watch } from 'vue';
import { Link, router, Head } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import Category from '@/Components/Category.vue';

const props = defineProps(['news', 'product_types']);


</script>
<template>
    <AppLayout>

        <Head>
            <title>News</title>
        </Head>
        <template #header>
            <div class="flex w-full justify-center">
                <SearchInput></SearchInput>
            </div>
        </template>
        <div>
            <div class="flex justify-center">
                <div class="min-h-screen w-full">

                    <div>
                        <div class="flex justify-start">
                            <div class="mt-5 ml-24 ">
                                <Category>
                                    <div v-for="product_type in product_types" :key="product_type.producttype_id">
                                        <Link :href="route('product.category', { id: product_type.producttype_id })">
                                        <div class="pb-4 pt-4 dark:border-gray-600 hover:bg-blue-500 rounded-lg">
                                            <div
                                                class="pl-1 pr-2 text-lg font-medium ml-2 text-white dark:text-gray-200">

                                                {{ product_type.producttype_name }}
                                            </div>
                                        </div>
                                        </Link>
                                    </div>
                                </Category>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <main class="w-full px-4 sm:px-6 lg:px-8">

                                <div class="lg:col-span-3 w-full">
                                    <div class="flex items-center text-4xl font-extrabold dark:text-white ml-24 mt-14">
                                        ข่าวสาร

                                    </div>
                                    <hr class="h-px my-5 mx-10 bg-gray-200 border-1 dark:bg-gray-700" />
                                    <div class="flex justify-end mb-5 mr-5">
                                        <Pagination :links="props.news.links">
                                        </Pagination>
                                    </div>
                                    <section id="Projects"
                                        class="w-fit grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 xl:ml-24 lg:ml-20 lg:mr-10 p-10 rounded-lg ">

                                        <div v-for="news in news.data" :key="news.news_id">
                                            <div
                                                class=" bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
                                                <Link :href="route('news.detail', { id: news.news_id })">
                                                <img :src="news.news_pics && news.news_pics[0]
                                                    ? '/storage/' + news.news_pics[0].public_url
                                                    : 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png'"
                                                    :alt="news.news_pics && news.news_pics[0]
                                                        ? 'Image ' + news.news_id
                                                        : 'No Image Available'" class="h-72 w-72 rounded-lg" />

                                                <div class="px-4 py-3 w-72">

                                                    <p class="text-lg font-bold text-black truncate block capitalize">
                                                        {{ news.news_name }}
                                                    </p>
                                                    <div class="flex items-center">
                                                        <div class="line-clamp-3">

                                                            {{ news.news_desc }}
                                                        </div>
                                                    </div>
                                                </div>
                                                </Link>
                                            </div>
                                        </div>
                                    </section>
                                </div>


                            </main>
                        </div>
                    </div>


                    <div class="flex justify-items-center justify-center">
                        <p>
                            แสดงข่าว
                            {{ news.from }} - {{ news.to }} ชิ้น จาก {{ news.total }} ชิ้น
                        </p>
                    </div>
                    <div class="flex justify-end mb-5 mr-4">
                        <Pagination :links="props.news.links" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
