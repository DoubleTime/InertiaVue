<script setup>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { VueElement } from 'vue';

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    menu_list: {
        type: Array,
    },
    select_all_flag: {
        type: Boolean,
    }
});

const routeGroupName = 'users.menu';

const form = useForm({
    menus: props.data.menu_flags,
});

const cutName = (val) => {
    if (typeof val === "string") {
        return val.substring(0, val.lastIndexOf("."));
    }
};
const selectAll = () => {
    const updatedProps = { ...props }; // Create a local copy of props
    updatedProps.select_all_flag = !updatedProps.select_all_flag;

    const menuKeys = Object.keys(form.menus);
    for (const key of menuKeys) {
        if (!form.menus[key].active) {
            form.menus[key] = { ...form.menus[key], active: updatedProps.select_all_flag };
        }
    }
    document.getElementById('selectAll').style = "display:none";
    document.getElementById('removeAll').style = "display:block";
};
const removeAll = () => {
    const updatedProps = { ...props }; // Create a local copy of props
    updatedProps.select_all_flag = updatedProps.select_all_flag;

    const menuKeys = Object.keys(form.menus);
    for (const key of menuKeys) {
        if (form.menus[key].active) {
            form.menus[key] = { ...form.menus[key], active: updatedProps.select_all_flag };
        }
    }
    document.getElementById('removeAll').style = "display:none";
    document.getElementById('selectAll').style = "display:block";
};

</script>
<template>
    <form @submit.prevent="form.patch(route(routeGroupName + '.update', data.id))">
        <div class="row g-3">
            <div class="kt-checkbox-list">
                <div class="d-flex align-items-center mb-2">
                    <InputLabel for="selectAll" value="Check to Access" class="me-3" />
                    <PrimaryButton id="selectAll" style="display:block" type="button" @click="selectAll()">Select All
                    </PrimaryButton>
                    <PrimaryButton id="removeAll" style="display:none" type="button" @click="removeAll()">Remove All
                    </PrimaryButton>
                </div>
                <ul v-for="(menu, index) in menu_list">
                    <li v-if="menu.title != 'Dashboard'">
                        <!-- {{ menu }} -->
                        <InputLabel class="kt-checkbox">
                            <template v-if="menu.route">
                                <input type="hidden" :name="'form.menus[' + cutName(menu.route) + '][active]'" value="0">
                                <Checkbox :id="menu.title" :name="'form.menus[' + cutName(menu.route) + '][active]'"
                                    v-model:checked="form.menus[cutName(menu.route)].active" value="1">
                                    {{ menu.title }}
                                </Checkbox>
                                <span></span>
                                here
                            </template>
                            <template v-else>
                                <input type="hidden" :name="'form.menus[' + (menu.title) + '][active]'" value="0">
                                <Checkbox :id="menu.title" :name="'form.menus[' + menu.title + '][active]'"
                                    v-model:checked="form.menus[menu.title].active" value="1">
                                    {{ menu.title }}
                                </Checkbox>
                            </template>
                        </InputLabel>
                        <ul v-if="menu.submenus && menu.submenus.length > 0">
                            <li v-for="(sub, index) in menu.submenus">
                                <InputLabel class="kt-checkbox">
                                    <template v-if="sub.route">
                                        <input type="hidden" :name="'form.menus[' + cutName(sub.route) + '][active]'"
                                            value="0">
                                        <checkbox :id="sub.title" :name="'form.menus[' + cutName(sub.route) + '][active]'"
                                            v-model:checked="form.menus[cutName(sub.route)].active" value="1">
                                            {{ sub.title }}
                                        </checkbox>
                                    </template>
                                    <template v-else>
                                        <input type="hidden" :name="'form.menus[' + (sub.title) + '][active]'" value="0">
                                        <Checkbox :id="sub.title" :name="'form.menus[' + sub.title + '][active]'"
                                            v-model:checked="form.menus[sub.title].active" value="1">
                                            {{ sub.title }}
                                        </Checkbox>
                                    </template>
                                </InputLabel>
                                <ul v-if="sub.submenus && sub.submenus.length > 0">
                                    <li v-for="(sub2, index) in sub.submenus">
                                        <InputLabel class="kt-checkbox">
                                            <template v-if="sub2.route">
                                                <input type="hidden"
                                                    :name="'form.menus[' + cutName(sub2.route) + '][active]'" value="0">
                                                <Checkbox :id="sub2.title"
                                                    :name="'form.menus[' + cutName(sub2.route) + '][active]'"
                                                    v-model:checked="form.menus[cutName(sub2.route)].active" value="1">
                                                    {{ sub2.title }}
                                                </Checkbox>
                                            </template>
                                            <template v-else>
                                                <input type="hidden" :name="'form.menus[' + (sub2.title) + '][active]'"
                                                    value="0">
                                                <Checkbox :id="sub2.title" :name="'form.menus[' + sub2.title + '][active]'"
                                                    v-model:checked="form.menus[sub2.title].active" value="1">
                                                    {{ sub2.title }}
                                                </Checkbox>
                                            </template>
                                        </InputLabel>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-12">
                <PrimaryButton type="submit" v-html="'Save'"></PrimaryButton>
            </div>
        </div>
    </form>
</template>