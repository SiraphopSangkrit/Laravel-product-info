<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import LinkCard from '@/Components/LinkCard.vue';
</script>
<template>
    <AdminLayout>


        <div class="grid grid-cols-3 gap-2">

            <LinkCard :href="route('admin.products')" class="w-full">
                สินค้า
            </LinkCard>
            <LinkCard :href="route('admin.productTypes')" class="w-full">
                ประเภทสินค้า
            </LinkCard>
            <LinkCard :href="route('admin.productGroups')" class="w-full">
                กลุ่มสินค้า
            </LinkCard >
            <LinkCard :href="route('admin.productKinds')" class="w-full">
                ชนิดสินค้า
            </LinkCard>
            <LinkCard class="w-full">
                แบนเนอร์
            </LinkCard>
            <LinkCard class="w-full">
                ข่าว
            </LinkCard>
        </div>

    </AdminLayout>
</template>
