<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <nav v-if="data.links.length > 3" aria-label="Paginate">
        <ul class="pagination justify-content-center">
            <li v-for="(link, k) in data.links" :key="k" class="page-item" :class="{ 'active': link.active }">
                <Link class="page-link" :class="{ 'disabled': !link.url }" :href="link.url ?? '#'" v-html="link.label" />
            </li>
        </ul>
    </nav>
</template>