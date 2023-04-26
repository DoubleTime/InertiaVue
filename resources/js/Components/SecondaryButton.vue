<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button type="button" class="btn btn-secondary">
        <slot />
    </button>
</template>
