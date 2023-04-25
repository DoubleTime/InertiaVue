<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section class="col-lg-6 p-3">
        <header>
            <h2>Update Password</h2>

            <p class="text-muted">
                Ensure your account is using a long, random password to stay secure.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div class="mb-3">
                <InputLabel for="current_password" value="Current Password" />
                <TextInput id="current_password" ref="currentPasswordInput" v-model="form.current_password" :invalid="form.errors.current_password" type="password" />
                <InputError :message="form.errors.current_password" />
            </div>

            <div class="mb-3">
                <InputLabel for="password" value="New Password" />
                <TextInput id="password" ref="passwordInput" v-model="form.password" :invalid="form.errors.password" type="password" />
                <InputError :message="form.errors.password" />
            </div>

            <div class="mb-3">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput id="password_confirmation" v-model="form.password_confirmation" :invalid="form.errors.password_confirmation" type="password" />
                <InputError :message="form.errors.password_confirmation" />
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
