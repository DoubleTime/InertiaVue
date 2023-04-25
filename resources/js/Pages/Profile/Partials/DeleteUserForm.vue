<script setup>
import Alert from '@/Components/Alert.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const passwordInput = ref(null);
// To access deleteModal function
const deleteModal = ref(null);

const form = useForm({
    password: '',
});

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    deleteModal.value.close();
    form.reset();
};
</script>

<template>
    <section class="col-lg-6 p-3">
        <header>
            <h2>Delete Account</h2>

            <p class="text-muted">
                Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting
                your account, please download any data or information that you wish to retain.
            </p>
        </header>

        <DangerButton type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete Account</DangerButton>

        <Modal ref="deleteModal" @yesEvent="deleteUser" :id="'deleteModal'" :title="' Are you sure you want to delete your account?'" :buttonYes="'Delete Account'" :buttonType="'danger'" :form="form">

            <p class="text-danger">
                Once your account is deleted, all of its resources and data will be permanently deleted. Please
                enter your password to confirm you would like to permanently delete your account.
            </p>

            <div class="mt-6">
                <InputLabel for="delete_password" value="Password" class="sr-only" />

                <TextInput id="delete_password" ref="passwordInput" v-model="form.password" :invalid="form.errors.password" type="password" placeholder="Password" @keyup.enter="deleteUser" />

                <InputError :message="form.errors.password" class="mt-2" />
            </div>
        </Modal>
    </section>
</template>
