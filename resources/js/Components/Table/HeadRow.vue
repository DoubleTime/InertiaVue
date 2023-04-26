<script setup>
import { computed } from 'vue';

const props = defineProps({
    field: { //Sort Key
        type: String,
    },
    sort: { //Sort Data
        type: Object,
        default: null,
    },
    disabled: {
        type: Boolean,
        default: false
    }
});

const classes = computed(() => props.sort != null ? 'sortable' : '')

const emit = defineEmits(['sortEvent']);
function sortEvent(field) {
    //Pass field value back to parent
    if (!props.disabled && props.sort != null) emit('sortEvent', field);
}
</script>

<template>
    <th scope="col" class="header-cell" :class="classes" @click="sortEvent(field)">
        <slot>{{ field }}</slot>
        <template v-if="sort != null">
            <i v-if="sort?.direction == 'asc' && sort?.field == field" class="bi bi-caret-up-fill header-icon me-2"></i>
            <i v-else-if="sort?.direction == 'desc' && sort?.field == field" class="bi bi-caret-down-fill header-icon me-2"></i>
            <i v-else class="bi bi-funnel header-icon me-2"></i>
        </template>

    </th>
</template>

<style scoped>
.sortable {
    cursor: pointer;
}

.header-cell {
    position: relative;
}

.header-icon {
    position: absolute;
    right: 0;
}
</style>