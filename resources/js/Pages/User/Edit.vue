<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DetailForm from './Partials/DetailForm.vue';

import { Head, router, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import MenuForm from './Partials/MenuForm.vue';

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    useUsername: {
        type: Boolean
    },
    menu_list: {
        type: Array,
    },
});
const routeGroupName = 'users';
const headerTitle = ref('User');
</script>

<template>
    <Head :title="headerTitle" />

    <AuthenticatedLayout>
        <template #header>
            {{ headerTitle }}
        </template>

        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#tab_1">Details</a>
                    </li>
                    <li v-if="data.id" class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab_2">Menus</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade pt-10 show active" id="tab_1" role="tabpanel" aria-labelledby="tab_1">
                        <DetailForm v-bind:="$props" />
                    </div>
                    <div v-if="data.id" class="tab-pane fade pt-10" id="tab_2" role="tabpanel" aria-labelledby="tab_2">
                        <MenuForm v-bind:="$props" />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-12">
                    <Link class="btn btn-secondary me-2" :href="route(routeGroupName + '.index')">Back</Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>