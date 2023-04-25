<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import HeadRow from '@/Components/Table/HeadRow.vue';
import Paginate from '@/Components/Table/Paginate.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { formatDate } from '@/helper';

const props = defineProps({
    header: {
        type: Object
    },
    filters: {
        type: Object
    },
    list: {
        type: Object,
        default: () => ({}),
    },
});

const headerTitle = ref('Users');
const form = useForm(props.filters);

const sort = (field) => {
    form.sort.field = field;
    form.sort.direction = form.sort.direction == "" || form.sort.direction == "desc" ? "asc" : "desc";
    submit();
}

const submit = () => {
    form.get(route('users.index'), {
        preserveScroll: true,
    });
};

// watch(() => props.filters.search, (value) => {
//     router.get(
//         route('users.index'),
//         { search: value },
//         {
//             preserveState: true,
//         }
//     );
// });


</script>

<template>
    <Head title="headerTitle" />

    <AuthenticatedLayout>
        <template #header>
            {{ headerTitle }}
        </template>

        <div class="my-3 p-3 bg-body rounded shadow-sm">

            <form @submit.prevent="submit">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="form-floating mb-3">
                            <input v-model="form.keyword" type="text" class="form-control" id="keywordInput" placeholder="Keyword" autocomplete="off">
                            <label for="keywordInput">Keyword</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <PrimaryButton type="submit" :disabled="form.processing">
                            <i class="bi bi-search"></i>
                            Search
                        </PrimaryButton>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <HeadRow>Actions</HeadRow>
                        <HeadRow v-for="head in header" :field="head.field" :sort="head.sortable ? filters.sort : null" @sortEvent="sort" :disabled="form.processing">{{ head.title }}</HeadRow>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in list.data">
                        <td>{{ index + 1 }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ formatDate(item.created_at) }}</td>
                    </tr>
                </tbody>
            </table>
            <Paginate :data="list" />
        </div>


    </AuthenticatedLayout>
</template>

<style>
.table-hover th:hover {
    background-color: #f9fafb;
}
</style>