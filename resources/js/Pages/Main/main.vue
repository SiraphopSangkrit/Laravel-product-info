<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import Dropdown from '@/Components/Dropdown.vue';
import { onMounted, onUnmounted } from 'vue';
import { computed } from 'vue';

const showingNavigationDropdown = ref(false);


const closeOnEscape = (e) => {
    if (open.value && e.key === 'Escape') {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape));

const props = defineProps(['products', 'product_types'])

console.log(props.products)

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
                <div class="min-h-screen w-full">

                    <div class="ml-5 mt-5">

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <div class="relative">
                                <div class="bg-blue-600 rounded-md px-2 py-2 w-fit text-white ">
                                    <div class="me-2 flex items-center justify-between">
                                        <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                                            class="inline-flex items-center justify-center rounded-md p-2 text-white transition duration-150 ease-in-out hover:bg-blue-500 focus:bg-blue-500 focus:text-white focus:outline-none">
                                            หมวดหมู่สินค้า
                                            <svg class="h-6 w-6 ml-2" stroke="currentColor" fill="none"
                                                viewBox="0 0 24 24">
                                                <path :class="{
                                                    hidden: showingNavigationDropdown,
                                                    'inline-flex': !showingNavigationDropdown,
                                                }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 12h16M4 18h16" />
                                                <path :class="{
                                                    hidden: !showingNavigationDropdown,
                                                    'inline-flex': showingNavigationDropdown,
                                                }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>


                                    <div v-show="showingNavigationDropdown"
                                        class="absolute z-20 left-0 mt-3 w-48 bg-blue-600 rounded-md shadow-lg"
                                        style="display: none" @click="showingNavigationDropdown = false">

                                        <div class="border-t border-gray-200 pb-4 pt-4 dark:border-gray-600"
                                            v-for="product_type in product_types" :key="product_type.producttype_id">

                                            <button @click="fetchProducts(product_type.producttype_id)"
                                                class="pl-1 pr-2 ml-2 text-left text-base font-medium text-white dark:text-gray-200 hover:text-blue-300">
                                                {{ product_type.producttype_name }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!------------------------------------->
                        <section id="Projects" @click="showingNavigationDropdown = false"
                            class="w-fit mx-auto grid lg:grid-cols-4 md:grid-cols-3 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5">
                            <div v-for="product in products.data" :key="product.product_id">
                                <div
                                    class=" bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
                                    <a href="#">

                                        <img :src="product.product_pics && product.product_pics[0]
                                            ? '/storage/' + product.product_pics[0].public_url
                                            : 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png'"
                                            :alt="product.product_pics && product.product_pics[0]
                                                ? 'Image ' + product.product_id
                                                : 'No Image Available'" class="h-72 w-72 rounded-lg" />

                                        <div class="px-4 py-3 w-72">
                                            <span class="text-gray-400 mr-3 uppercase text-xs">{{
                                                product.brands.brand_name
                                                }}</span>
                                            <p class="text-lg font-bold text-black truncate block capitalize">
                                                {{ product.product_name }}
                                            </p>
                                            <div class="flex items-center">
                                                <p class="text-lg font-semibold text-black cursor-auto my-3">฿
                                                    {{product.product_price }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="flex justify-items-center justify-center">
                        <p>
                           แสดงสินค้า
                            {{ products.from }} - {{ products.to }} ชิ้น จาก {{ products.total }} ชิ้น
                        </p>
                    </div>
                    <div class="flex justify-end mb-5">

                        <pagination :elements="props.products"></pagination>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
