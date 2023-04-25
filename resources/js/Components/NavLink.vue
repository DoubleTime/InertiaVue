<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
    isSubmenu: {
        type: Boolean,
        default: false
    }
});

const classes = computed(() => {
    let classes = props.isSubmenu ? 'dropdown-item' : 'nav-link';
    return classes += props.active ? ' active' : '';
}
);
</script>

<template>
    <Link :href="href" :class="classes">
    <slot />
    </Link>
</template>
