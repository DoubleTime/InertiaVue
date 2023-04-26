<script setup>
import { computed } from 'vue';
const props = defineProps({
    status: {
        type: String,
        default: "success"
    }
});

const alertClass = computed(() => 'alert-' + props.status)

</script>

<template>
    <div class="alert alert-dismissible fade show" :class="alertClass" role="alert">
        <slot></slot>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</template>
