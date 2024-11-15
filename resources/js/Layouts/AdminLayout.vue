<script setup>


import Sidebar from '@/Components/Sidebar.vue';
</script>
<template>
    <div>
        <div class="min-h-screen bg-white">

            <Sidebar></Sidebar>
            <div class="p-4 sm:ml-64">

                <div class="flex justify-center">
                    <div class="min-h-screen w-full">
                        <div class="mt-20 ml-5 mr-5">


                            <main>
                                <slot />
                            </main>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
</template>
