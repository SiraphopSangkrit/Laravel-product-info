<script setup>
import { Link } from '@inertiajs/vue3';
</script>
<template>


    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <Link :href="route('product.index')" class="flex ms-2 md:me-24">

                    <span
                        class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">Flowbite</span>
                    </Link>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <div class="w-8 h-8 rounded-full">

                                </div>

                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-ท text-gray-900 dark:text-white" role="none">
                                    {{ $page.props.auth.user.firstname }} {{ $page.props.auth.user.lastname }}
                                </p>
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                    {{ $page.props.auth.user.email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <Link :href="route('logout')" method="post" as="button"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem">Sign out</Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 text-base">
                <li>
                    <Link :href="route('admin.dashboard')"  :class="{ 'active bg-gray-200 ' : $page.url === '/admin'}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group ">
                    <span class="ms-3">แดชบอร์ด</span>
                    </Link>
                </li>
                <li>
                    <Link :href="route('admin.banner')"  :class="{ 'active bg-gray-200 ' :$page.url === '/admin/banner'}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">

                    <span class="flex-1 ms-3 whitespace-nowrap">แบนเนอร์</span>

                    </Link>
                </li>
                <li>
                    <Link :href="route('admin.news')"  :class="{ 'active bg-gray-200 ' :$page.url === '/admin/news'}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">

                    <span class="flex-1 ms-3 whitespace-nowrap">ข่าว</span>
                    </Link>
                </li>
                <li>
                    <Link :href="route('admin.products')"  :class="{ 'active bg-gray-200 ' :$page.url === '/admin/products'}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">

                    <span class="flex-1 ms-3 whitespace-nowrap">สินค้า</span>
                </Link>
            </li>
            <li>
                <Link :href="route('admin.productBrands')" :class="{ 'active bg-gray-200 ' :$page.url === '/admin/productBrands'}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                <span class="flex-1 ms-3 whitespace-nowrap">แบรนด์สินค้า</span>
                </Link>
            </li>
            <li>
                <Link :href="route('admin.productTypes')" :class="{ 'active bg-gray-200 ' :$page.url === '/admin/productTypes'}"
                    class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">

                <span class="flex-1 ms-3 whitespace-nowrap">ประเภทสินค้า</span>
                </Link>
            </li>
                <li>
                    <Link :href="route('admin.productGroups')" :class="{ 'active bg-gray-200 ' :$page.url === '/admin/productGroups'}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">

                    <span class="flex-1 ms-3 whitespace-nowrap">กลุ่มสินค้า</span>
                    </Link>
                </li>
                <li>
                    <Link :href="route('admin.productKinds')" :class="{ 'active bg-gray-200 ' :$page.url === '/admin/productKinds'}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">

                    <span class="flex-1 ms-3 whitespace-nowrap">ชนิดสินค้า</span>
                    </Link>
                </li>
            </ul>
        </div>
    </aside>


</template>
