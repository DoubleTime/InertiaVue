<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section class="col-lg-6 p-3">
        <header>
            <h2>Profile Information</h2>
            <p class="text-muted">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))">
            <div class="mb-3">
                <InputLabel for="name" value="Name" />
                <TextInput id="name" type="text" v-model="form.name" :invalid="form.errors.name" />
                <InputError :message="form.errors.name" />
            </div>

            <div class="mb-3">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" v-model="form.email" :invalid="form.errors.email" required placeholder="john@email.com" />
                <InputError :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p>
                    Your email address is unverified.<br />
                    <Link :href="route('verification.send')" method="post" as="button" class="btn btn-danger">
                    Click here to re-send the verification email.
                    </Link>
                </p>

                <div v-show="status === 'verification-link-sent'" class="my-1 text-success fw-bold">
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div>
                <PrimaryButton type="submit" :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-active-class="fade transition ease-in-out duration-500" enter-from-class="opacity-0" enter-to-class="opacity-100"
                    leave-active-class="fade transition ease-in-out duration-500" leave-to-class="opacity-0">
                    <span v-if="form.recentlySuccessful" class="ms-2 text-success">Saved.</span>
                </Transition>
            </div>
        </form>
    </section>
</template>
