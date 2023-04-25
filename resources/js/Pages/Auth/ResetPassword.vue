<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, useForm } from '@inertiajs/vue3';
import GuestPrimaryButton from '@/Components/Guest/GuestPrimaryButton.vue';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Reset Password" />

        <form @submit.prevent="submit">
            <div class="form-floating" :class="{ 'is-invalid': form.errors.email }">
                <input type="email" class="form-control" :class="{ 'is-invalid': form.errors.email }" id="floatingEmail" placeholder="name@example.com" required autofocus v-model="form.email">
                <label for="floatingEmail">Email address</label>
            </div>
            <InputError class="my-1" :message="form.errors.email" />


            <div class="form-floating my-2" :class="{ 'is-invalid': form.errors.password }">
                <input type="password" class="form-control" :class="{ 'is-invalid': form.errors.password }" id="floatingPassword" required v-model="form.password">
                <label for="floatingPassword">New Password</label>
            </div>
            <InputError class="my-1" :message="form.errors.password" />

            <div class="form-floating my-2" :class="{ 'is-invalid': form.errors.password_confirmation }">
                <input type="password" class="form-control" :class="{ 'is-invalid': form.errors.password_confirmation }" id="floatingConfirmation" required v-model="form.password_confirmation">
                <label for="floatingConfirmation">Confirm Password</label>
            </div>
            <InputError class="my-1" :message="form.errors.password_confirmation" />

            <GuestPrimaryButton class="mt-4" :disabled="form.processing">
                Reset Password
            </GuestPrimaryButton>

        </form>
    </GuestLayout>
</template>
