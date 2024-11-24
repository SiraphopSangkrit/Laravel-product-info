<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3'


const CreateModal = ref(false);

const openCreateModal = () => {
    CreateModal.value = true;
};

const handleClose = () => {
    CreateModal.value = false;
};

const createAdminForm = useForm({
    username: '',
    firstname: '',
    lastname: '',
    email: '',
});


const AdminCreate = () => {
    createAdminForm.post(route('admin.userAdmin.create'), {
        onSuccess: () => {
            handleClose();
            Toast.fire({
                icon: "success",
                title: "เพิ่มแอดมินสำเร็จ"
            });
        },
        onError: () => {
            handleClose();
            Toast.fire({
                icon: "error",
                title: "เพิ่มแอดมินไม่สำเร็จ"
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


defineProps({adminUsers:Object})

</script>
<template>
    <AdminLayout>

        <Head title="User Admin" />
        <div>
            <button type="button" @click="openCreateModal"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-lg px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">เพิ่มแอดมิน</button>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-base text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class=" text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            รหัสแอดมิน
                        </th>
                        <th scope="col" class="px-6 py-3">
                            username
                        </th>
                        <th scope="col" class="px-6 py-3">
                            ชื่อแอดมิน
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email แอดมิน
                        </th>
                        <th scope="col" class="px-6 py-3">

                        </th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="admin in adminUsers" :key="admin.id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                            {{ admin.id }}
                        </th>
                        <td class="px-6 py-4 ">
                            {{ admin.username }}
                        </td>
                        <td class=" px-6 py-4 ">
                            {{ admin.firstname }} {{ admin.lastname }}
                        </td>

                        <td class="px-6 py-4 ">
                            {{ admin.email }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">ลบสินค้า</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
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


                        <div class="w-full ">
                            <label
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ชื่อ</label>
                            <input type="text" v-model="createAdminForm.firstname"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ชื่อ" required />
                        </div>
                        <div class="w-full ml-2">
                            <label
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">นามสกุล</label>
                            <input type="text" v-model="createAdminForm.lastname"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="นามสกุล" required />
                        </div>
                    </div>
                    <div class="flex flex-row">


                        <div class="w-full ">
                            <label
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                            <input type="text" v-model="createAdminForm.username"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="Username" required />
                        </div>
                        <div class="w-full ml-2">
                            <label
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" v-model="createAdminForm.email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="email" required />
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">เพิ่มแอดมิน</button>
                </form>
            </div>
        </Modal>
    </AdminLayout>
</template>
