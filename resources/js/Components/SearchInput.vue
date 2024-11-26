<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const searchQuery = ref('');
const results = ref([]);



watch(searchQuery, async (newQuery) => {
    if (newQuery) {
        await productSearch(newQuery);
    } else {
        results.value = [];
    }
});

const productSearch = async (query) => {
    try {
        console.log('Searching products with query:', query);
        const response = await axios.get('/product/search', { params: { searchQuery: query } }); // Correct axios usage
        results.value = response.data;
    } catch (error) {
        console.error('Error fetching products:', error);
        results.value = [];
    }
};

const goToProduct = (result) => {
    router.get(route('product.detail', { product_id: result.product_id, producttype_id: result.producttype_id }));
};


</script>
<template>

    <div class="relative w-2/3 z-40">
        <input type="text" id="default-input" v-model="searchQuery"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

        <ul v-if="results.length > 0" class=" w-full bg-white rounded-lg shadow absolute ">
            <li v-for="result in results" :key="result.id" class="p-2 hover:bg-gray-100 cursor-pointer"
                @click="goToProduct(result)">
                <div class="flex flex-row">
                    <img :src="result.product_pics && result.product_pics[0]
                        ? '/storage/' + result.product_pics[0].public_url
                        : 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ac/No_image_available.svg/1024px-No_image_available.svg.png'"
                        :alt="result.product_pics && result.product_pics[0]
                            ? 'Image ' + result.product_id
                            : 'No Image Available'" class="rounded-lg my-3"  width="50" height="50"/>
                    <div class="content-center ml-3"  v-text="result.product_name"></div>
                </div>
            </li>
        </ul>

    </div>
</template>
