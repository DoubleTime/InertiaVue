<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    id: {
        type: String
    },
    checked: {
        type: [Array, Boolean],
        required: true,
    },
    value: {
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>

<template>
    <div class="form-check">
        <input :value="value" v-model="proxyChecked" class="form-check-input" type="checkbox" :id="id">
        <label class="form-check-label" :for="id">
            <slot></slot>
        </label>
    </div>
</template>
