<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Modal from '@/Components/Modal.vue';
import { router, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { computed, ref, watch } from 'vue';
import { Head } from '@inertiajs/vue3'
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import InputError from '@/Components/InputError.vue';
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

const openEditModal = (news) => {
    editNewsForm.news_id = news.news_id
    editNewsForm.news_name = news.news_name
    editNewsForm.news_desc  = news.news_desc
    EditModal.value = true;
};

const handleClose = () => {
    CreateModal.value = false;
    ShowImg.value = false;
    EditModal.value = false;
};

const openImgModal = (news) => {


    currentImage.value = news.news_pics;
    imageForm.news_id = news.news_id;
    ShowImg.value = true;
};


const createNewsForm = useForm({
    news_name: '',
    news_desc: '',
});

const editNewsForm = useForm({
    news_id: null,
    news_name: '',
    news_desc: '',
});

const imageForm = useForm({
    news_id: null,
    image: []
})

const AddImage = () => {
    imageForm.post(route('admin.addNewsPics', { id: imageForm.news_id }),
        {
            onSuccess: () => {
                handleClose();
                Toast.fire({
                    icon: "success",
                    title: "เพิ่มรูปข่าวสำเร็จ"
                });
            },
            onError: () => {

                Toast.fire({
                    icon: "error",
                    title: "เพิ่มรูปข่าวไม่สำเร็จ"
                });
            }
        });
}
const NewsImgDelete = ($NewsPicId) => {
    router.delete(route('admin.deleteNewsPics', $NewsPicId), {
        onSuccess: () => {
            handleClose();
            Toast.fire({
                icon: "success",
                title: "ลบรูปข่าวสำเร็จ"
            });
        },
        onError: () => {

            Toast.fire({
                icon: "error",
                title: "ลบรูปข่าวไม่สำเร็จ"
            });
        }
    });

}


const CreateNews = () => {
    createNewsForm.post(route('admin.news.create'),
        {
            onSuccess: () => {
                handleClose();
                Toast.fire({
                    icon: "success",
                    title: "เพิ่มข้อมูลข่าวสำเร็จ"
                });
            },
            onError: () => {

                Toast.fire({
                    icon: "error",
                    title: "เพิ่มข้อมูลข่าวไม่สำเร็จ"
                });
            }
        });
}

const EditNews = () => {
    editNewsForm.put(route('admin.news.update',{id:editNewsForm.news_id}),
        {
            onSuccess: () => {
                handleClose();
                Toast.fire({
                    icon: "success",
                    title: "แก้ไขข้อมูลข่าวสำเร็จ"
                });
            },
            onError: () => {
                Toast.fire({
                    icon: "error",
                    title: "แก้ไขข้อมูลข่าวไม่สำเร็จ"
                });
            }
        });
}

const toggleNewsStatus = (news) => {

    const newStatus = !news.news_status;

    try {
        // Send a PUT request to update the status on the server
        router.put(route('admin.toggleNewsStatus', news.news_id), {

            status: newStatus,

        });

        news.news_status = newStatus;

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

const handleDelete = (news) => {
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

            router.delete(route('admin.news.delete', {
                id: news.news_id,
            }));
            Swal.fire(
                'Deleted!',
                'News has been deleted.',
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

const props = defineProps(['News','search'])

let searchQuery = ref(props.search ||''),
    pageNumber = ref(1);

let NewsUrl = computed(() => {
    let url = new URL(route('admin.news'));

    url.searchParams.append("page", pageNumber.value);


    if (searchQuery.value) {
        url.searchParams.append("search", searchQuery.value);
    }

    return url;
})

watch(
    () => NewsUrl.value,
    (updateNewsUrl) => {
        router.visit(updateNewsUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true
        });

    }
)


</script>
<template>
    <AdminLayout>

        <Head title="News" />
        <div>
            <button type="button" @click="openCreateModal"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-lg px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">เพิ่มข่าว</button>
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
                    <tr v-for="(news, index) in News.data" :key="news.news_id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white ">
                            {{ (index + 1) }}
                        </th>
                        <td class="px-6 py-4 truncate max-w-xs">
                            {{ news.news_name }}
                        </td>
                        <td class="px-6 py-4 truncate max-w-xs ">
                            {{ news.news_desc }}
                        </td>
                        <td class="px-6 py-4 ">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" :checked="news.news_status" class="sr-only peer"
                                    @change="toggleNewsStatus(news)">
                                <div
                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                </div>

                            </label>
                        </td>
                        <td class=" px-6 py-4 ">
                            <button
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                                @click="openImgModal(news)">รูปข่าว</button>
                        </td>

                        <td class="px-6 py-4 text-center">
                            <button
                                class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900"
                                @click="openEditModal(news)">แก้ไข</button>
                            <button @click="handleDelete(news)"
                                class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">ลบข่าว</button>
                        </td>
                    </tr>
                </tbody>
            </table>
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
                                <button type="button" @click="NewsImgDelete(image.newsPic_id)"
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
                <form class="space-y-4" @submit.prevent="CreateNews">
                    <div class="flex flex-row">


                        <div class="w-full">
                            <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">ชื่อข่าว</label>
                            <input type="text" v-model="createNewsForm.news_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ชื่อข่าว" required />
                        </div>
                    </div>
                    <div>
                        <label
                            class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">รายละเอียดข่าว</label>
                        <textarea id="message" rows="4" v-model="createNewsForm.news_desc"
                            class="block p-2.5 w-full text-lg text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="รายละเอียดข่าว" required></textarea>
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">เพิ่มข่าว</button>
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
                <form class="space-y-4" @submit.prevent="EditNews">
                    <div class="flex flex-row">


                        <div class="w-full">
                            <label class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">ชื่อข่าว</label>
                            <input type="text" v-model="editNewsForm.news_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="ชื่อข่าว" required />
                        </div>
                    </div>
                    <div>
                        <label
                            class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">รายละเอียดข่าว</label>
                        <textarea id="message" rows="4" v-model="editNewsForm.news_desc"
                            class="block p-2.5 w-full text-lg text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="รายละเอียดข่าว" required></textarea>
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">แก้ไขข่าว</button>
                </form>
            </div>
        </Modal>
    </AdminLayout>
</template>
