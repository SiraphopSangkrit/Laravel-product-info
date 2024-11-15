<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

import Pagination from '@/Components/Pagination.vue';
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';

const CreateModal = ref(false);

const openCreateModal = () => {
    CreateModal.value = true;
};

const handleClose = () => {
    CreateModal.value = false;
};
const props = defineProps(['productGroups'])

</script>
<template>
<AdminLayout>
        <div>
            <button type="button" @click="openCreateModal"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-lg px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">เพิ่มกลุ่มสินค้า</button>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-base text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class=" text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            รหัสกลุ่มสินค้า
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ชื่อกลุ่มสินค้า
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        v-for="group in productGroups.data" :key="group.group_id">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ group.group_id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ group.group_name }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="flex justify-end">
            <pagination :elements="props.productGroups"></pagination>
        </div>

        <Modal :show="CreateModal" @close="handleClose" maxWidth="6xl" closeable>
            <button type="button" @click="CreateModal = false"
                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close</span>
            </button>
        </Modal>
    </AdminLayout>
</template>
