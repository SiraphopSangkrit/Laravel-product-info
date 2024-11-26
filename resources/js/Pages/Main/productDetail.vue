<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import SearchInput from '@/Components/SearchInput.vue';
import Category from '@/Components/Category.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps(['product_types', 'product', 'productPic', 'group', 'kind', 'brand', 'type']);


const mainImage = ref(
    props.productPic && props.productPic.length > 0
        ? `/storage/${props.productPic[0].public_url}`
        : 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png'
);
// Function to set the main image
const setMainImage = (url) => {
    mainImage.value = `/storage/${url}`;
};
</script>
<template>
    <AppLayout>

        <Head>
            <title>{{ product.product_name }}</title>

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
                                        <div class="flex-col">
                                            <div class=" w-16" v-for="Pic in productPic" :key="Pic.ProductPic_id"
                                                @click="setMainImage(Pic.public_url)">
                                                <img :src="Pic
                                                    ? '/storage/' + Pic.public_url
                                                    : 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png'"
                                                    :alt="Pic
                                                        ? 'Image ' + product.product_id
                                                        : 'No Image Available'"
                                                    class="w-full rounded-lg cursor-pointer hover:opacity-80 transition-opacity mt-2" />
                                            </div>
                                        </div>

                                        <img :src="mainImage" alt="Product" class="w-4/5 rounded-md object-cover" />
                                    </div>

                                    <div>
                                        <h2 class="text-2xl font-bold text-gray-800">{{ product.product_name }}
                                        </h2>
                                        <div class="flex flex-wrap gap-4 mt-4">
                                            <p class="text-gray-800 text-xl font-bold">฿ {{ product.product_price }}
                                            </p>

                                        </div>
                                        <div class="flex flex-row w-fit">

                                            <div class="mt-8">
                                                <h3 class="text-xl font-bold text-gray-800 w-36">แบรนด์</h3>
                                                <div class=" ml-2 mt-4 font-normal">
                                                    {{ brand.brand_name }}

                                                </div>
                                            </div>

                                            <div class="mt-8">
                                                <h3 class="text-xl font-bold text-gray-800 w-36">ประเภทสินค้า</h3>
                                                <div class=" ml-2 mt-4 font-normal">
                                                    {{ type.producttype_name }}

                                                </div>
                                            </div>
                                            <div class="mt-8">
                                                <h3 class="text-xl font-bold text-gray-800 w-36">กลุ่มสินค้า</h3>
                                                <div class=" ml-2 mt-4 font-normal">
                                                    {{ group.group_name }}

                                                </div>
                                            </div>
                                            <div class="mt-8 ml-10">
                                                <h3 class="text-xl font-bold text-gray-800 w-36">ชนิดสินค้า</h3>
                                                <div class=" ml-2 mt-4 font-normal">
                                                    {{ kind.kind_name }}

                                                </div>
                                            </div>
                                        </div>


                                        <div class="mt-8">
                                            <h3 class="text-xl font-bold text-gray-800">รายละเอียด</h3>
                                            <div class="ml-2 mt-4 font-normal">
                                                <div class="mt-4 indent-8">
                                                    {{ product.product_desc }}


                                                </div>
                                                <div class="mt-4 indent-8">
                                                    {{ product.product_desc0 }}


                                                </div>
                                                <div class="mt-4 indent-8">
                                                    {{ product.product_desc1 }}


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
        </div>

    </AppLayout>
</template>
