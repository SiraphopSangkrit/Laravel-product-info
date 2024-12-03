<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    message: {
        type: String,
        default: ''
    }
})

const visibleMessage = ref(props.message)

watch(() => props.message, (newMessage) => {
    visibleMessage.value = newMessage

    if (newMessage) {
        setTimeout(() => {
            visibleMessage.value = ''
        }, 3000) // 3 seconds timeout
    }
})
</script>

<template>
    <div>
        <div v-show="visibleMessage">
            <p class="text-sm text-red-600 dark:text-red-400">
                {{ visibleMessage }}
            </p>
        </div>
    </div>
</template>
