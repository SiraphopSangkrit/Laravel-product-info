<template>
    <nav class="flex" aria-label="Breadcrumb">
      <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
        <li v-for="(breadcrumb, index) in breadcrumbs" :key="index" class="inline-flex items-center">
          <template v-if="breadcrumb.url">
            <a :href="breadcrumb.url" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
              <svg v-if="breadcrumb.icon" class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path :d="breadcrumb.icon" />
              </svg>
              {{ breadcrumb.label }}
            </a>
          </template>
          <template v-else>
            <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{ breadcrumb.label }}</span>
          </template>
          <!-- Arrow icon for separation -->
          <svg v-if="index < breadcrumbs.length - 1" class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
          </svg>
        </li>
      </ol>
    </nav>
  </template>

  <script setup>
  import { ref } from 'vue';

  // Example of dynamic breadcrumb data that you might receive from your router or a parent component
  const breadcrumbs = ref([
    { label: 'Home', url: '/', icon: 'M19.707 9.293l-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414z' },
    { label: 'Projects', url: '/projects' },
   
  ]);

  </script>
