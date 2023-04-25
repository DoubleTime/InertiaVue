<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message" class="invalid-feedback">
        {{ message }}
    </div>
</template>
