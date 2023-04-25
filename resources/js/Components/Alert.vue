<script setup>
import { computed } from 'vue';
const props = defineProps({
    message: {
        type: String,
    },
    status: {
        type: String,
        default: "danger"
    }
});

const alertClass = computed(() => 'alert-' + props.status)

</script>

<template>
    <div v-show="message" class="alert" :class="alertClass" role="alert">
        {{ message }}
    </div>
</template>
