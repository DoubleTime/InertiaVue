<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    invalid: {
        type: Boolean,
        default: false
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input class="form-control" :class="{ 'is-invalid': invalid }" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="input" />
</template>
