<script setup>
import { Link } from '@inertiajs/vue3';
</script>
<template>


    <Link :href="href" :class="classes"
        class="block max-w-sm p-6 bg-blue-600 border border-gray-200 rounded-lg shadow hover:bg-blue-400 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

        <h5 class="text-2xl font-bold tracking-tight text-white dark:text-white text-center">
           <slot />
        </h5>

    </Link>


</template>
