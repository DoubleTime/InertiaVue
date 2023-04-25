<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import GuestPrimaryButton from '@/Components/Guest/GuestPrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>

        <Head title="Forgot Password" />

        <div class="mb-4 text-start">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.
        </div>

        <Alert :message="status" />

        <form @submit.prevent="submit">

            <div class="form-floating" :class="{ 'is-invalid': form.errors.email }">
                <input type="email" class="form-control" :class="{ 'is-invalid': form.errors.email }" id="floatingEmail" placeholder="name@example.com" required autofocus v-model="form.email">
                <label for="floatingEmail">Email address</label>
            </div>
            <InputError class="my-1" :message="form.errors.email" />

            <GuestPrimaryButton class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Email Password Reset Link
            </GuestPrimaryButton>
        </form>
    </GuestLayout>
</template>
