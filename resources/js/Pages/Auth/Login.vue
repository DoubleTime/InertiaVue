<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import Alert from '@/Components/Alert.vue';
import GuestPrimaryButton from '@/Components/Guest/GuestPrimaryButton.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Log in" />
        <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
        <Alert :message="status" :status="'success'" />

        <form @submit.prevent="submit">
            <div class="form-floating" :class="{ 'is-invalid': form.errors.email }">
                <input type="email" class="form-control" :class="{ 'is-invalid': form.errors.email }" id="floatingEmail" placeholder="name@example.com" required autofocus v-model="form.email">
                <label for="floatingEmail">Email address</label>
            </div>
            <InputError class="my-1" :message="form.errors.email" />

            <div class="form-floating my-2" :class="{ 'is-invalid': form.errors.email }">
                <input type="password" class="form-control" :class="{ 'is-invalid': form.errors.email }" id="floatingPassword" placeholder="Password" required v-model="form.password">
                <label for="floatingPassword">Password</label>
            </div>
            <InputError class="my-1" :message="form.errors.password" />
            <div class="checkbox my-3">
                <label>
                    <Checkbox id="remember" v-model:checked="form.remember"> Remember me</Checkbox>
                </label>
            </div>

            <GuestPrimaryButton :disabled="form.processing">
                Log in
            </GuestPrimaryButton>

            <div class="mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')"> Forgot your password?
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
