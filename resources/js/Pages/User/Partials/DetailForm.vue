<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});

const routeGroupName = 'users';

const form = useForm({
    name: props.data.name ?? '',
    email: props.data.email ?? '',
    active: props.data.active,
    password: '',
});
</script>

<template>
    <form @submit.prevent="data.id == null ? form.post(route(routeGroupName + '.store')) : form.patch(route(routeGroupName + '.update', data.id))">

        <div class="row g-3">
            <div class="col-md-6">
                <InputLabel for="name" value="Name" />
                <TextInput id="name" type="text" v-model="form.name" :invalid="form.errors.name" required />
                <InputError :message="form.errors.name" />
            </div>
            <div class="col-md-6">
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" v-model="form.email" :invalid="form.errors.email" required />
                <InputError :message="form.errors.email" />
            </div>
            <div class="col-12">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" type="password" v-model="form.password" :invalid="form.errors.password" />
                <InputError :message="form.errors.password" />
            </div>
            <div class="col-12">
                <Checkbox id="checkActive" v-model:checked="form.active">
                    Active
                </Checkbox>
            </div>
            <div class="col-12">
                <PrimaryButton type="submit" v-html="data.id == null ? 'Create' : 'Save'"></PrimaryButton>
            </div>
        </div>
    </form>
</template>

