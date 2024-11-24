<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3'
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";


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
    ShowImg.value = false;
};



const createAdminForm = useForm({
    username: '',
    firstname: '',
    lastname: '',
    email: '',
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
                Toast.fire({
                    icon: "success",
                    title: "เพิ่มรูปสินค้าสำเร็จ"
                });
            },
            onError: () => {
                handleClose();
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
            handleClose();
            Toast.fire({
                icon: "error",
                title: "ลบรูปสินค้าไม่สำเร็จ"
            });
        }
    });

}

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

const props = defineProps(['News'])
</script>
<template>
    <AdminLayout>

        <Head title="News" />
        <div>
            <button type="button" @click="openCreateModal"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-lg px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">เพิ่มข่าว</button>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-base text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class=" text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            รหัสข่าว
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ชื่อข่าว
                        </th>
                        <th scope="col" class="px-6 py-3">
                            รายละเอียดข่าว
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
                    <tr v-for="(news, index) in News" :key="news.news_id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                            {{ (index + 1) }}
                        </th>
                        <td class="px-6 py-4 ">
                            {{ news.news_name }}
                        </td>
                        <td class="px-6 py-4 ">
                            {{ news.news_desc }}
                        </td>
                        <td class="px-6 py-4 ">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" :checked="news.news_status" class="sr-only peer"
                                    @change="toggleProductStatus(news)">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                </div>

                            </label>
                        </td>
                        <td class=" px-6 py-4 ">
                            <button
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                @click="openImgModal(product)">รูปสินค้า</button>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <button
                                class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">แก้ไข</button>
                            <button
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">ลบสินค้า</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Modal :show="ShowImg" @close="handleClose" maxWidth="6xl" closeable>
            <div class="m-3">
                <button type="button" @click="ShowImg = false"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
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
                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">ลบรูป</button>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="mt-3">
                    <form @submit.prevent="AddImage">
                        <file-pond name="image" ref="pond" label-idle="Drop files here..." v-bind:allow-multiple="true"
                            accepted-file-types="image/jpeg, image/png" @change="imageForm.image = $event.target.files"
                            @init="handleFilePondInit" />

                        <button type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">เพิ่มรูปสินค้า</button>
                    </form>
                </div>
            </div>
        </Modal>
        <Modal :show="CreateModal" @close="handleClose" maxWidth="6xl" closeable>

            <div class="m-3">
                <button type="button" @click="CreateModal = false"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close</span>
                </button>
            </div>

            <div class="p-4 md:p-5">
                <form class="space-y-4">
                    <div class="flex flex-row">


                        <div class="w-full">
                            <label for="product"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ชื่อข่าว</label>
                            <input type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ชื่อข่าว" required />
                        </div>
                    </div>
                    <div>
                        <label
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">รายละเอียดข่าว</label>
                        <textarea id="message" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="รายละเอียดข่าว" required></textarea>
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">เพิ่มข่าว</button>
                </form>
            </div>
        </Modal>
    </AdminLayout>
</template>
