<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SearchInput from '@/Components/SearchInput.vue';
import { ref, watch } from 'vue';
import { Link, router, Head } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import {
    Dialog,
    DialogPanel,
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { ChevronDownIcon, FunnelIcon, MinusIcon, PlusIcon, Squares2X2Icon } from '@heroicons/vue/20/solid'
import Category from '@/Components/Category.vue';

const mobileFiltersOpen = ref(false)
const props = defineProps(['products', 'product_types', 'productType', 'brands', 'kinds', 'groups', 'filters']);

const activeFilters = ref({
    brands: props.filters.brands || [],
    kinds: props.filters.kinds || [],
    groups: props.filters.groups || [],
});



watch([() => activeFilters.value.brands,
() => activeFilters.value.kinds,
() => activeFilters.value.groups],
    () => {
        updateFilters();
    });

const updateFilters = () => {
    const query = {
        page: 1,
        brands: activeFilters.value.brands.join(','),
        groups: activeFilters.value.groups.join(','),
        kinds: activeFilters.value.kinds.join(','),
    };

    router.get(route('product.category', { id: props.productType.producttype_id }), query, {
        preserveScroll: true,
        preserveState: true
    });
};


console.log(props.products.links)
</script>
<template>
    <AppLayout>

        <Head>
            <title>{{ productType.producttype_name }}</title>
        </Head>
        <template #header>
            <div class="flex ml-20 w-full mt-5 justify-center">
                <SearchInput class="w-2/3"></SearchInput>
            </div>
        </template>
        <div>
            <div class="flex justify-center">
                <div class="min-h-screen w-full">

                    <div>

                        <TransitionRoot as="template" :show="mobileFiltersOpen">
                            <Dialog class="relative z-40 lg:hidden" @close="mobileFiltersOpen = false">
                                <TransitionChild as="template" enter="transition-opacity ease-linear duration-300"
                                    enter-from="opacity-0" enter-to="opacity-100"
                                    leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
                                    leave-to="opacity-0">
                                    <div class="fixed inset-0 bg-black/25" />
                                </TransitionChild>

                                <div class="fixed inset-0 z-40 flex">
                                    <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
                                        enter-from="translate-x-full" enter-to="translate-x-0"
                                        leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
                                        leave-to="translate-x-full">
                                        <DialogPanel
                                            class="relative ml-auto flex size-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                                            <div class="flex items-center justify-between px-4">
                                                <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                                                <button type="button"
                                                    class="mr-2 flex size-10 items-center justify-center rounded-md bg-white p-2 text-gray-400 "
                                                    @click="mobileFiltersOpen = false">
                                                    <span class="sr-only">Close menu</span>
                                                    <XMarkIcon class="size-6" aria-hidden="true" />
                                                </button>
                                            </div>

                                            <Category>
                                                <div class="border-t border-gray-200 pb-4 pt-4 dark:border-gray-600"
                                                    v-for="product_type in product_types"
                                                    :key="product_type.producttype_id">

                                                    <Link
                                                        :href="route('product.category', { id: product_type.producttype_id })"
                                                        class="pl-1 pr-2 ml-2 text-left text-base font-medium text-white dark:text-gray-200 hover:text-blue-300">
                                                    {{ product_type.producttype_name }}
                                                    </Link>
                                                </div>
                                            </Category>
                                            <form class="mt-4 border-t border-gray-200">


                                                <Disclosure as="div" class="border-b border-gray-200 px-4 py-6"
                                                    v-slot="{ open }">
                                                    <h3 class="mx-2 -my-3 flow-root">
                                                        <DisclosureButton
                                                            class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                                            <span class="font-medium text-gray-900">แบรนด์</span>
                                                            <span class="ml-6 flex items-center">
                                                                <PlusIcon v-if="!open" class="size-5"
                                                                    aria-hidden="true" />
                                                                <MinusIcon v-else class="size-5" aria-hidden="true" />
                                                            </span>
                                                        </DisclosureButton>
                                                    </h3>
                                                    <DisclosurePanel class="pt-6">
                                                        <div class="space-y-6">
                                                            <div v-for="brandFilter in brands"
                                                                :key="brandFilter.brand_id" class="flex items-center">
                                                                <input name="brands" :value="brandFilter.brand_id"
                                                                    type="checkbox" v-model="activeFilters.brands"
                                                                    class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                                <label class="ml-3 min-w-0 flex-1 text-gray-500">{{
                                                                    brandFilter.brand_name }}</label>
                                                            </div>
                                                        </div>
                                                    </DisclosurePanel>
                                                </Disclosure>
                                                <Disclosure as="div" class="border-b border-gray-200 px-4 py-6"
                                                    v-slot="{ open }">
                                                    <h3 class="mx-2 -my-3 flow-root">
                                                        <DisclosureButton
                                                            class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                                            <span class="font-medium text-gray-900">กลุ่มสินค้า</span>
                                                            <span class="ml-6 flex items-center">
                                                                <PlusIcon v-if="!open" class="size-5"
                                                                    aria-hidden="true" />
                                                                <MinusIcon v-else class="size-5" aria-hidden="true" />
                                                            </span>
                                                        </DisclosureButton>
                                                    </h3>
                                                    <DisclosurePanel class="pt-6">
                                                        <div class="space-y-6">
                                                            <div v-for="groupFilter in groups"
                                                                :key="groupFilter.group_id" class="flex items-center">
                                                                <input name="groups" :value="groupFilter.group_id"
                                                                    type="checkbox" v-model="activeFilters.groups"
                                                                    class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                                <label class="ml-3 min-w-0 flex-1 text-gray-500">{{
                                                                    groupFilter.group_name }}</label>
                                                            </div>
                                                        </div>
                                                    </DisclosurePanel>
                                                </Disclosure>
                                                <Disclosure as="div" class="border-b border-gray-200 px-4 py-6"
                                                    v-slot="{ open }">
                                                    <h3 class="mx-2 -my-3 flow-root">
                                                        <DisclosureButton
                                                            class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                                            <span class="font-medium text-gray-900">ชนิดสินค้า</span>
                                                            <span class="ml-6 flex items-center">
                                                                <PlusIcon v-if="!open" class="size-5"
                                                                    aria-hidden="true" />
                                                                <MinusIcon v-else class="size-5" aria-hidden="true" />
                                                            </span>
                                                        </DisclosureButton>
                                                    </h3>
                                                    <DisclosurePanel class="pt-6">
                                                        <div class="space-y-6">
                                                            <div v-for="kindFilter in kinds" :key="kindFilter.kind_id"
                                                                class="flex items-center">
                                                                <input name="brands" :value="kindFilter.kind_id"
                                                                    type="checkbox" v-model="activeFilters.kinds"
                                                                    class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                                <label class="ml-3 min-w-0 flex-1 text-gray-500">{{
                                                                    kindFilter.kind_name }}</label>
                                                            </div>
                                                        </div>
                                                    </DisclosurePanel>
                                                </Disclosure>
                                            </form>
                                        </DialogPanel>
                                    </TransitionChild>
                                </div>
                            </Dialog>
                        </TransitionRoot>
                        <main class="mr-6 ml-6 w-full px-4 sm:px-6 lg:px-8">
                            <div class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-12">
                                <h1 class="text-4xl font-bold tracking-tight text-gray-900 ml-5">{{
                                    productType.producttype_name
                                    }}</h1>

                                <div class="flex items-center">
                                    <button type="button"
                                        class="mr-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden"
                                        @click="mobileFiltersOpen = true">
                                        <span class="sr-only">Filters</span>
                                        <FunnelIcon class="size-5" aria-hidden="true" />
                                    </button>
                                </div>
                            </div>
                            <section aria-labelledby="products-heading" class="pb-3 pt-6">
                                <h2 id="products-heading" class="sr-only">Products</h2>
                                <div class="flex flex-row">
                                    <div class="hidden lg:block w-60">
                                        <Category>
                                            <div class="border-t border-gray-200 pb-4 pt-4 dark:border-gray-600"
                                                v-for="product_type in product_types"
                                                :key="product_type.producttype_id">

                                                <Link
                                                    :href="route('product.category', { id: product_type.producttype_id })"
                                                    class="pl-1 pr-2 ml-2 text-left text-base font-medium text-white dark:text-gray-200 hover:text-blue-300">
                                                {{ product_type.producttype_name }}
                                                </Link>
                                            </div>
                                        </Category>

                                        <Disclosure as="div" class="border-b border-gray-200 px-4 py-6"
                                            v-slot="{ open }">
                                            <h3 class="mx-2 -my-3 flow-root">
                                                <DisclosureButton
                                                    class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                                    <span class="font-medium text-gray-900">แบรนด์</span>
                                                    <span class="ml-6 flex items-center">
                                                        <PlusIcon v-if="!open" class="size-5" aria-hidden="true" />
                                                        <MinusIcon v-else class="size-5" aria-hidden="true" />
                                                    </span>
                                                </DisclosureButton>
                                            </h3>
                                            <DisclosurePanel class="pt-6">
                                                <div class="space-y-6">
                                                    <div v-for="brandFilter in brands" :key="brandFilter.brand_id"
                                                        class="flex items-center">
                                                        <input name="brands" :value="brandFilter.brand_id"
                                                            type="checkbox" v-model="activeFilters.brands"
                                                            class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                        <label class="ml-3 min-w-0 flex-1 text-gray-500">{{
                                                            brandFilter.brand_name }}</label>
                                                    </div>
                                                </div>
                                            </DisclosurePanel>
                                        </Disclosure>
                                        <Disclosure as="div" class="border-b border-gray-200 px-4 py-6"
                                            v-slot="{ open }">
                                            <h3 class="mx-2 -my-3 flow-root">
                                                <DisclosureButton
                                                    class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                                    <span class="font-medium text-gray-900">กลุ่มสินค้า</span>
                                                    <span class="ml-6 flex items-center">
                                                        <PlusIcon v-if="!open" class="size-5" aria-hidden="true" />
                                                        <MinusIcon v-else class="size-5" aria-hidden="true" />
                                                    </span>
                                                </DisclosureButton>
                                            </h3>
                                            <DisclosurePanel class="pt-6">
                                                <div class="space-y-6">
                                                    <div v-for="groupFilter in groups" :key="groupFilter.group_id"
                                                        class="flex items-center">
                                                        <input name="groups" :value="groupFilter.group_id"
                                                            type="checkbox" v-model="activeFilters.groups"
                                                            class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                        <label class="ml-3 min-w-0 flex-1 text-gray-500">{{
                                                            groupFilter.group_name }}</label>
                                                    </div>
                                                </div>
                                            </DisclosurePanel>
                                        </Disclosure>
                                        <Disclosure as="div" class="border-b border-gray-200 px-4 py-6"
                                            v-slot="{ open }">
                                            <h3 class="mx-2 -my-3 flow-root">
                                                <DisclosureButton
                                                    class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                                                    <span class="font-medium text-gray-900">ชนิดสินค้า</span>
                                                    <span class="ml-6 flex items-center">
                                                        <PlusIcon v-if="!open" class="size-5" aria-hidden="true" />
                                                        <MinusIcon v-else class="size-5" aria-hidden="true" />
                                                    </span>
                                                </DisclosureButton>
                                            </h3>
                                            <DisclosurePanel class="pt-6">
                                                <div class="space-y-6">
                                                    <div v-for="kindFilter in kinds" :key="kindFilter.kind_id"
                                                        class="flex items-center">
                                                        <input name="brands" :value="kindFilter.kind_id" type="checkbox"
                                                            v-model="activeFilters.kinds"
                                                            class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                                        <label class="ml-3 min-w-0 flex-1 text-gray-500">{{
                                                            kindFilter.kind_name }}</label>
                                                    </div>
                                                </div>
                                            </DisclosurePanel>
                                        </Disclosure>

                                    </div>

                                    <div class="lg:col-span-3 w-full">
                                        <div class="flex justify-end mb-5 mr-5">
                                            <Pagination :links="props.products.links">
                                            </Pagination>
                                        </div>
                                        <section id="Projects"
                                            class="w-fit grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 justify-items-center justify-center gap-y-20 gap-x-14 ml-24 p-10 rounded-lg">
                                            <div v-for="product in products.data" :key="product.product_id">
                                                <div
                                                    class=" bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
                                                    <Link
                                                        :href="route('product.detail', { product_id: product.product_id, producttype_id: product.producttype_id })">
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
                                                        <p
                                                            class="text-lg font-bold text-black truncate block capitalize">
                                                            {{ product.product_name }}
                                                        </p>
                                                        <div class="flex items-center">
                                                            <p
                                                                class="text-lg font-semibold text-black cursor-auto my-3">
                                                                ฿
                                                                {{ product.product_price }}</p>
                                                        </div>
                                                    </div>
                                                    </Link>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </section>
                        </main>
                    </div>


                    <div class="flex justify-items-center justify-center">
                        <p>
                            แสดงสินค้า
                            {{ products.from }} - {{ products.to }} ชิ้น จาก {{ products.total }} ชิ้น
                        </p>
                    </div>
                    <div class="flex justify-end mb-5 mr-4">
                        <Pagination :links="props.products.links" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
