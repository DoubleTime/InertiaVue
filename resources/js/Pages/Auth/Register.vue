<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import GuestPrimaryButton from '@/Components/Guest/GuestPrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <form @submit.prevent="submit">

            <div class="form-floating my-2" :class="{ 'is-invalid': form.errors.name }">
                <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.name }" id="floatingName" required autofocus v-model="form.name">
                <label for="floatingName">Name</label>
            </div>
            <InputError class="my-1" :message="form.errors.name" />

            <div class="form-floating my-2" :class="{ 'is-invalid': form.errors.email }">
                <input type="email" class="form-control" :class="{ 'is-invalid': form.errors.email }" id="floatingEmail" placeholder="name@example.com" required v-model="form.email">
                <label for="floatingEmail">Email address</label>
            </div>
            <InputError class="my-1" :message="form.errors.email" />

            <div class="form-floating my-2" :class="{ 'is-invalid': form.errors.password }">
                <input type="password" class="form-control" :class="{ 'is-invalid': form.errors.password }" id="floatingPassword" required v-model="form.password">
                <label for="floatingPassword">Password</label>
            </div>
            <InputError class="my-1" :message="form.errors.password" />


            <div class="form-floating my-2" :class="{ 'is-invalid': form.errors.password_confirmation }">
                <input type="password" class="form-control" :class="{ 'is-invalid': form.errors.password_confirmation }" id="floatingConfirm" required v-model="form.password_confirmation">
                <label for="floatingConfirm">Confirm Password</label>
            </div>
            <InputError class="my-1" :message="form.errors.password_confirmation" />

            <div class="mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Already registered?
                </Link>
            </div>

            <GuestPrimaryButton class="mt-2" :disabled="form.processing">
                Register
            </GuestPrimaryButton>

        </form>
    </GuestLayout>
</template>
