<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { ref } from 'vue';
import { Link , Head } from '@inertiajs/vue3';
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
                        <div class="ml-24 mt-5">
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
                                    <h1>News</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
