<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import GuestPrimaryButton from '@/Components/Guest/GuestPrimaryButton.vue';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>

        <Head title="Email Verification" />

        <div class="mb-4">
            <small>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
                we just emailed to you? If you didn't receive the email, we will gladly send you another.</small>
        </div>

        <div class="mb-4 text-success" v-if="verificationLinkSent">
            A new verification link has been sent to the email address you provided during registration.
        </div>

        <form @submit.prevent="submit">

            <GuestPrimaryButton :disabled="form.processing">
                Resend Verification Email
            </GuestPrimaryButton>

            <Link :href="route('logout')" method="post" as="button" class="mt-4 w-50 btn btn-warning">Log Out</Link>

        </form>
    </GuestLayout>
</template>
