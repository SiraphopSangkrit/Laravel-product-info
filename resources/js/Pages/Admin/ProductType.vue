<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { router, useForm } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import { computed, ref, watch } from 'vue';
import Modal from '@/Components/Modal.vue';
import { Head } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import InputError from '@/Components/InputError.vue';
InputError

const CreateModal = ref(false);

const EditModal = ref(false);


const openCreateModal = () => {
    CreateModal.value = true;
};

const openEditModal = (type) => {
    EditProductTypeForm.producttype_id = type.producttype_id;
    EditProductTypeForm.producttype_name = type.producttype_name;
    EditModal.value = true;
};


const handleClose = () => {
    CreateModal.value = false;
    EditModal.value = false;
};

const CreateProductTypeForm = useForm({
    producttype_id: '',
    producttype_name: '',
})

const EditProductTypeForm = useForm({
    producttype_id: '',
    producttype_name: '',
})

const productTypeCreate = () => {
    CreateProductTypeForm.post(route('admin.productTypes.create'), {
        onSuccess: () => {
            handleClose();
            Toast.fire({
                icon: "success",
                title: "เพิ่มประเภทสินค้าสำเร็จ"
            });
        },
        onError: () => {

            Toast.fire({
                icon: "error",
                title: "เพิ่มประเภทสินค้าไม่สำเร็จ"
            });
        }
    });
}

const productTypeEdit = () => {
    EditProductTypeForm.put(route('admin.productTypes.update',{ id: EditProductTypeForm.producttype_id }), {
        onSuccess: () => {
            handleClose();
            Toast.fire({
                icon: "success",
                title: "แก้ไขประเภทสินค้าสำเร็จ"
            });
        },
        onError: () => {

            Toast.fire({
                icon: "error",
                title: "แก้ไขประเภทสินค้าไม่สำเร็จ"
            });
        }
    });
}

const handleDelete = (type) => {
    Swal.fire({
        title: 'ต้องการลบสิ่งนี้หรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'ไม่ต้องการ',
        confirmButtonText: 'ใช่,ฉันต้องการลบ!',
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route('admin.productTypes.delete', {
                id: type.producttype_id,
            }));
            Swal.fire(
                'Deleted!',
                'ProductType has been deleted.',
                'success'
            );
        }
    });
};

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

const props = defineProps(['productTypes','search'])

let searchQuery = ref(props.search ||''),
    pageNumber = ref(1);

let productTypeUrl = computed(() => {
    let url = new URL(route('admin.productTypes'));

    url.searchParams.append("page", pageNumber.value);


    if (searchQuery.value) {
        url.searchParams.append("search", searchQuery.value);
    }

    return url;
})

watch(
    () => productTypeUrl.value,
    (updateProductTypeUrl) => {

        router.visit(updateProductTypeUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true
        });

    }
)



</script>
<template>
    <AdminLayout>

        <Head title="Types" />
        <div>
            <button type="button" @click="openCreateModal"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-lg px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">เพิ่มประเภทสินค้า</button>
        </div>

        <div class="w-1/3 my-5">
            <label for="default-search"
                class="mb-2 text-lg font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="default-search" v-model="searchQuery"
                    class="block w-full p-4 ps-10 text-lg text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" />
            </div>
        </div>
        <div class="flex justify-end my-3">
            <pagination :links="props.productTypes.links"></pagination>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-base text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class=" text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            รหัสประเภทสินค้า
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ชื่อประเภทสินค้า
                        </th>

                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        v-for="type in productTypes.data" :key="type.producttype_id">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ type.producttype_id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ type.producttype_name }}
                        </td>
                        <td class="px-6 py-4 text-right">

                            <button
                                class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900"
                                @click="openEditModal(type)">แก้ไข</button>

                            <button @click="handleDelete(type)"
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">ลบประเภทสินค้า</button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="flex justify-end my-3">
            <pagination :links="props.productTypes.links"></pagination>
        </div>

        <Modal :show="CreateModal" @close="handleClose" maxWidth="6xl" closeable>

            <div class="m-3">
                <button type="button" @click="CreateModal = false"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-lg w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close</span>
                </button>
            </div>

            <div class="p-4 md:p-5">
                <form class="space-y-4" @submit.prevent="productTypeCreate">
                    <div class="flex flex-row">

                        <div>
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">รหัสสินค้า</label>
                            <input type="text" v-model="CreateProductTypeForm.producttype_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Product Name" required />
                                <InputError class="mt-2" :message="CreateProductTypeForm.errors.producttype_id" />
                        </div>
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">ชื่อสินค้า</label>
                            <input type="text" v-model="CreateProductTypeForm.producttype_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Product Name" required />
                                <InputError class="mt-2" :message="CreateProductTypeForm.errors.producttype_name" />
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">เพิ่มประเภทสินค้า</button>
                </form>
            </div>
        </Modal>
        <Modal :show="EditModal" @close="handleClose" maxWidth="6xl" closeable>

            <div class="m-3">
                <button type="button" @click="EditModal = false"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-lg w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close</span>
                </button>
            </div>

            <div class="p-4 md:p-5">
                <form class="space-y-4" @submit.prevent="productTypeEdit">
                    <div class="flex flex-row">

                        <div>
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">รหัสสินค้า</label>
                            <input type="text" v-model="EditProductTypeForm.producttype_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="รหัสสินค้า" required disabled />
                        </div>
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">ชื่อสินค้า</label>
                            <input type="text" v-model="EditProductTypeForm.producttype_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ชื่อสินค้า" required />
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">แก้ไขประเภทสินค้า</button>
                </form>
            </div>
        </Modal>
    </AdminLayout>
</template>
