<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            You're logged in!
        </div>


    </AuthenticatedLayout>
</template>
