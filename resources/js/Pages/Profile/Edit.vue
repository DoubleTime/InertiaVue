<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            Profile
        </template>

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
        </div>

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <UpdatePasswordForm />
        </div>

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <DeleteUserForm />
        </div>
    </AuthenticatedLayout>
</template>
