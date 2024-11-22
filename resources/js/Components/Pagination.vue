<template>
    <div id="pagination" class="border-gray-100 pt-4 items-center">
      <div class="flex flex-wrap -mb-1">
        <template v-for="(link, key) in processedLinks" :key="key">
          <!-- Disabled link -->
          <div
            v-if="!link.url"
            class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
            v-html="link.label"
          />
          <!-- Active/Clickable link -->
          <Link
            v-else
            class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-gray-200 focus:border-indigo-500 focus:text-indigo-500"
            :class="{ 'bg-gray-500 text-white': link.active }"
            :href="buildLink(link.url)"
            v-html="link.label"
          ></Link>
        </template>
      </div>
    </div>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3';
 

  const props = defineProps(['elements', 'filters']);


  const processLabel = (label) => {
    if (label.includes('&laquo;')) return 'ย้อนกลับ';
    if (label.includes('&raquo;')) return 'ต่อไป';
    return label.replace(/&[^;]+;/g, '');
  };

  const buildLink = (url) => {
    if (!props.filters) return url;
    const params = new URLSearchParams(props.filters).toString();
    return `${url}${url.includes('?') ? '&' : '?'}${params}`;
  };


  const processedLinks = props.elements.links.map((link) => ({
    ...link,
    label: processLabel(link.label),
  }));
  </script>
