<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import { computed, ref, watch } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import { router, useForm, usePage, Head } from '@inertiajs/vue3';
import Swal from 'sweetalert2'
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import debounce from 'lodash/debounce';
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

const CreateModal = ref(false);
const EditModal = ref(false);
const ShowImg = ref(false);
const currentImage = ref(null);


const openCreateModal = () => {
    CreateModal.value = true;
};

const handleClose = () => {
    CreateModal.value = false;
    EditModal.value = false;
    ShowImg.value = false;
    currentImage.value = '';
    imageForm.reset();
    imageForm.clearErrors();
    createForm.clearErrors();
    editForm.clearErrors();
};


const openImgModal = (product) => {

    currentImage.value = product.product_pics;
    imageForm.product_id = product.product_id;
    ShowImg.value = true;

};


const openEditModal = (product) => {
    editForm.product_id_edit = product.product_id;
    editForm.product_name_edit = product.product_name;
    editForm.product_desc_edit = product.product_desc;
    editForm.product_desc0_edit = product.product_desc0;
    editForm.product_desc1_edit = product.product_desc1;
    editForm.producttype_id_edit = product.producttype_id;
    editForm.brand_id_edit = product.brand_id;
    editForm.group_id_edit = product.group_id;
    editForm.kind_id_edit = product.kind_id;
    editForm.product_price_edit = product.product_price;
    EditModal.value = true;
};


const createForm = useForm({
    product_id: '',
    product_name: '',
    product_desc: '',
    product_desc0: '',
    product_desc1: '',
    producttype_id: '',
    brand_id: '',
    group_id: '',
    kind_id: '',
    product_price: '',

});

const editForm = useForm({
    product_id_edit: null,
    product_name_edit: '',
    product_desc_edit: '',
    product_desc0_edit: '',
    product_desc1_edit: '',
    producttype_id_edit: '',
    brand_id_edit: '',
    group_id_edit: '',
    kind_id_edit: '',
    product_price_edit: '',
});

const imageForm = useForm({
    product_id: null,
    image: []
})

const AddImage = () => {
    imageForm.post(route('admin.addProductPics', { id: imageForm.product_id }),
        {
            onSuccess: () => {
                handleClose();
                imageForm.reset();
                Toast.fire({
                    icon: "success",
                    title: "เพิ่มรูปสินค้าสำเร็จ"
                });
            },
            onError: () => {
                Toast.fire({
                    icon: "error",
                    title: "เพิ่มรูปสินค้าไม่สำเร็จ"
                });
            }
        });
}
const ProductImgDelete = ($ProductPicId) => {
    router.delete(route('admin.deleteProductPics', $ProductPicId), {
        onSuccess: () => {
            handleClose();
            Toast.fire({
                icon: "success",
                title: "ลบรูปสินค้าสำเร็จ"
            });
        },
        onError: () => {

            Toast.fire({
                icon: "error",
                title: "ลบรูปสินค้าไม่สำเร็จ"
            });
        }
    });
}
const ProductCreate = () => {
    createForm.post(route('admin.productCreate'), {
        onSuccess: () => {
            handleClose();
            createForm.reset();
            Toast.fire({
                icon: "success",
                title: "เพิ่มข้อมูลสินค้าสำเร็จ"
            });
        },
        onError: () => {
            Toast.fire({
                icon: "error",
                title: "เพิ่มข้อมูลสินค้าไม่สำเร็จ"
            });
        }
    });
}


const ProductUpdate = () => {

    editForm.put(route('admin.updateProduct', { id: editForm.product_id_edit }), {
        onSuccess: () => {
            handleClose();

            Toast.fire({
                icon: "success",
                title: "อัพเดตข้อมูลสินค้าสำเร็จ"
            });
        },
        onError: () => {
            Toast.fire({
                icon: "error",
                title: "อัพเดตข้อมูลสินค้าไม่สำเร็จ"
            });
        }
    });
}


const toggleProductStatus = (product) => {

    const newStatus = !product.product_status;

    try {
        // Send a PUT request to update the status on the server
        router.put(route('admin.toggleStatus', product.product_id), {

            status: newStatus,

        });

        product.product_status = newStatus;

        Toast.fire({
            icon: "success",
            title: "อัพเดตสเตตัสสำเร็จ"
        });
    } catch (error) {
        console.error('Failed to update status:', error);
        Toast.fire({
            icon: "error",
            title: "อัพเดตสเตตัสไม่สำเร็จ"
        });
    }
};

const handleDelete = (product) => {
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
            router.delete(route('admin.deleteProduct', {
                id: product.product_id,
            }));
            Swal.fire(
                'Deleted!',
                'Product has been deleted.',
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

const handleFilePondInit = () => {
}
const props = defineProps(['products', 'productTypes', 'productKinds', 'productGroups', 'productBrands','search']);

let searchQuery = ref(props.search ||''),
    pageNumber = ref(1);

let productUrl = computed(() => {
    let url = new URL(route('admin.products'));

    url.searchParams.append("page", pageNumber.value);


    if (searchQuery.value) {
        url.searchParams.append("search", searchQuery.value);
    }

    return url;
})

watch(
    () => productUrl.value,
    (updateProductUrl) => {

        router.visit(updateProductUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true
        });

    }
)



</script>
<template>
    <AdminLayout>

        <Head title="Products" />
        <div>

            <button type="button" @click="openCreateModal"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-lg px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">เพิ่มสินค้า</button>
        </div>

        <div class="w-1/3 my-5">
            <label for="default-search"
                class="mb-2 text-lg  font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="default-search" v-model="searchQuery"
                    class="block w-full p-4 ps-10 text-lg  text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="" />
            </div>
        </div>
        <div class="flex justify-end mb-5">

            <Pagination :links="props.products.links"></Pagination>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-base text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class=" text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            รหัสสินค้า
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ชื่อสินค้า
                        </th>
                        <th scope="col" class="px-6 py-3">
                            รายละเอียดสินค้า
                        </th>
                        <th scope="col" class="px-6 py-3">
                            แบรนด์สินค้า
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ประเภทสินค้า
                        </th>
                        <th scope="col" class="px-6 py-3">
                            กลุ่มสินค้า
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ชนิดสินค้า
                        </th>
                        <th scope="col" class="px-6 py-3">
                            รูป
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ราคาสินค้า
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">

                        </th>
                        <th scope="col" class="px-6 py-3">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="product in products.data" :key="product.product_id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                            {{ product.product_id }}
                        </th>
                        <td class="px-6 py-4 ">
                            {{ product.product_name }}
                        </td>
                        <td class="truncate max-w-xs px-6 py-4" :title="product.product_desc">
                            {{ product.product_desc }}
                        </td>

                        <td class="px-6 py-4">
                            {{ product.brands.brand_name }}
                        </td>
                        <td class="px-6 py-4 ">
                            {{ product.types.producttype_name }}
                        </td>
                        <td class="px-6 py-4 ">
                            {{ product.groups.group_name }}
                        </td>
                        <td class="px-6 py-4 ">
                            {{ product.kinds.kind_name }}
                        </td>
                        <td class="px-6 py-4 w-1/12">

                            {{ product.product_pics.length }}
                        </td>
                        <td class="px-6 py-4">
                            {{ product.product_price }}
                        </td>
                        <td class="px-6 py-4">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" :checked="product.product_status" class="sr-only peer"
                                    @change="toggleProductStatus(product)">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                </div>

                            </label>
                        </td>
                        <td class="px-6 py-4 w-1/12">
                            <button
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                @click="openImgModal(product)">รูปสินค้า</button>
                        </td>

                        <td class="px-6 py-4 text-center">

                            <button
                                class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900"
                                @click="openEditModal(product)">แก้ไข</button>

                            <button
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"
                                @click="handleDelete(product)">ลบสินค้า</button>

                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
        <div class="flex justify-end my-5">
            <Pagination :links="props.products.links"></Pagination>
        </div>

        <Modal :show="ShowImg" @close="handleClose" maxWidth="6xl" closeable>
            <div class="m-3">
                <button type="button" @click="ShowImg = false"
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
                <section id="Projects"
                    class="w-fit mx-auto grid lg:grid-cols-4 md:grid-cols-3 justify-items-center justify-center gap-y-20 gap-x-14 mt-10 mb-5">
                    <div v-for="(image, index) in currentImage" :key="index">
                        <div class=" bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl">
                            <img :src="/storage/ + image.public_url" :alt="'Image ' + (index + 1)"
                                class="h-auto w-72 rounded-lg" />
                            <div class="m-2">
                                <button type="button" @click="ProductImgDelete(image.ProductPic_id)"
                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-lg px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">ลบรูป</button>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="mt-3">
                    <form @submit.prevent="AddImage">
                        <file-pond name="image" ref="pond" label-idle="Drop files here..." v-bind:allow-multiple="true"
                            accepted-file-types="image/jpeg, image/png" @change="imageForm.image = $event.target.files"
                            @init="handleFilePondInit" />

                            <InputError class="my-2" :message="imageForm.errors.image" />

                        <button type="submit"
                            class="mt-2 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">เพิ่มรูปสินค้า</button>
                    </form>
                </div>
            </div>
        </Modal>

        <!------------------------Create Modal------------------------->
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
                <form class="space-y-4" @submit.prevent="ProductCreate">
                    <div class="flex flex-row">

                        <div>
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">รหัสสินค้า</label>
                            <input type="text" v-model="createForm.product_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="รหัสสินค้า" required />
                            <InputError class="mt-2" :message="createForm.errors.product_id" />
                        </div>
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">ชื่อสินค้า</label>
                            <input type="text" v-model="createForm.product_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ชื่อสินค้า" required />
                            <InputError class="mt-2" :message="createForm.errors.product_name" />
                        </div>
                    </div>
                    <div class="flex flex-row">

                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">เลือกประเภทสินค้า</label>
                            <select v-model="createForm.producttype_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>เลือกประเภทสินค้า</option>
                                <option v-for="type in productTypes" :key="type.producttype_id"
                                    :value="type.producttype_id">{{
                                        type.producttype_name }}</option>
                            </select>
                            <InputError class="mt-2" :message="createForm.errors.producttype_id" />
                        </div>

                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">เลือกแบรนด์สินค้า</label>
                            <select v-model="createForm.brand_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>เลือกแบรนด์สินค้า</option>
                                <option v-for="brand in productBrands" :key="brand.brand_id" :value="brand.brand_id">{{
                                    brand.brand_name }}</option>
                            </select>
                            <InputError class="mt-2" :message="createForm.errors.brand_id" />
                        </div>

                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">เลือกกลุ่มสินค้า</label>
                            <select v-model="createForm.group_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>เลือกกลุ่มสินค้า</option>
                                <option v-for="group in productGroups" :key="group.group_id" :value="group.group_id">{{
                                    group.group_name }}</option>
                            </select>
                            <InputError class="mt-2" :message="createForm.errors.group_id" />
                        </div>
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">เลือกชนิดสินค้า</label>
                            <select v-model="createForm.kind_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>เลือกชนิดสินค้า</option>
                                <option v-for="kind in productKinds" :key="kind.kind_id" :value="kind.kind_id">{{
                                    kind.kind_name }}</option>
                            </select>
                            <InputError class="mt-2" :message="createForm.errors.kind_id" />
                        </div>
                    </div>
                    <div>
                        <label
                            class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">รายละเอียดสินค้า</label>
                        <textarea id="message" rows="4" v-model="createForm.product_desc"
                            class="block p-2.5 w-full text-lg text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="รายละเอียดสินค้า" required></textarea>
                        <InputError class="mt-2" :message="createForm.errors.product_desc" />
                    </div>
                    <div>
                        <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">รายละเอียดสินค้า
                            (เพิ่มเติม)</label>
                        <textarea id="message" rows="4" v-model="createForm.product_desc0"
                            class="block p-2.5 w-full text-lg text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="รายละเอียดสินค้า (เพิ่มเติม)"></textarea>
                    </div>
                    <div>
                        <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">รายละเอียดสินค้า
                            (เพิ่มเติม)</label>
                        <textarea id="message" rows="4" v-model="createForm.product_desc1"
                            class="block p-2.5 w-full text-lg text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="รายละเอียดสินค้า (เพิ่มเติม)"></textarea>
                    </div>
                    <div>
                        <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">ราคาสินค้า</label>
                        <input type="number" v-model="createForm.product_price"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="ราคาสินค้า" required min=0 />
                        <InputError class="mt-2" :message="createForm.errors.product_price" />
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">เพิ่มสินค้า</button>
                </form>
            </div>
        </Modal>
        <!----------------------------------------------------------->



        <!------------------------Edit Modal------------------------->
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
                <form class="space-y-4" @submit.prevent="ProductUpdate">
                    <div class="flex flex-row">

                        <div>
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">รหัสสินค้า</label>
                            <input type="text" v-model="editForm.product_id_edit"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="รหัสสินค้า" required disabled />

                        </div>
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">ชื่อสินค้า</label>
                            <input type="text" v-model="editForm.product_name_edit"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ชื่อสินค้า" required />
                            <InputError class="mt-2" :message="editForm.errors.product_name_edit" />
                        </div>
                    </div>
                    <div class="flex flex-row">

                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">เลือกประเภทสินค้า</label>
                            <select id="productTypeSelect" v-model="editForm.producttype_id_edit"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>เลือกประเภทสินค้า</option>
                                <option v-for="type in productTypes" :key="type.producttype_id"
                                    :value="type.producttype_id">{{
                                        type.producttype_name }}</option>
                            </select>
                            <InputError class="mt-2" :message="editForm.errors.producttype_id_edit" />
                        </div>

                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">เลือกแบรนด์สินค้า</label>
                            <select id="brand_id" v-model="editForm.brand_id_edit"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>เลือกแบรนด์สินค้า</option>
                                <option v-for="brand in productBrands" :key="brand.brand_id" :value="brand.brand_id">{{
                                    brand.brand_name }}</option>
                            </select>
                            <InputError class="mt-2" :message="editForm.errors.brand_id_edit" />
                        </div>

                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">เลือกกลุ่มสินค้า</label>
                            <select id="group_id" v-model="editForm.group_id_edit"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>เลือกกลุ่มสินค้า</option>
                                <option v-for="group in productGroups" :key="group.group_id" :value="group.group_id">{{
                                    group.group_name }}</option>
                            </select>
                            <InputError class="mt-2" :message="editForm.errors.group_id_edit" />
                        </div>
                        <div class="w-full mx-2">
                            <label
                                class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">เลือกชนิดสินค้า</label>
                            <select id="kind_id" v-model="editForm.kind_id_edit"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>เลือกชนิดสินค้า</option>
                                <option v-for="kind in productKinds" :key="kind.kind_id" :value="kind.kind_id">{{
                                    kind.kind_name }}</option>
                            </select>
                            <InputError class="mt-2" :message="editForm.errors.kind_id_edit" />
                        </div>
                    </div>
                    <div>
                        <label
                            class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">รายละเอียดสินค้า</label>
                        <textarea id="message" rows="4" v-model="editForm.product_desc_edit"
                            class="block p-2.5 w-full text-lg text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="รายละเอียดสินค้า"></textarea>
                        <InputError class="mt-2" :message="editForm.errors.product_desc_edit" />
                    </div>
                    <div>
                        <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">รายละเอียดสินค้า
                            (เพิ่มเติม)</label>
                        <textarea id="message" rows="4" v-model="editForm.product_desc0_edit"
                            class="block p-2.5 w-full text-lg text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="รายละเอียดสินค้า (เพิ่มเติม)"></textarea>
                    </div>
                    <div>
                        <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">รายละเอียดสินค้า
                            (เพิ่มเติม)</label>
                        <textarea id="message" rows="4" v-model="editForm.product_desc1_edit"
                            class="block p-2.5 w-full text-lg text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="รายละเอียดสินค้า (เพิ่มเติม)"></textarea>
                    </div>
                    <div>
                        <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">ราคาสินค้า</label>
                        <input type="number" id="product_price" v-model="editForm.product_price_edit"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Product Price" required min=0 />
                        <InputError class="mt-2" :message="editForm.errors.product_price_edit" />
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">อัพเดตสินค้า</button>
                </form>
            </div>
        </Modal>
        <!------------------------------------------------->
    </AdminLayout>
</template>
