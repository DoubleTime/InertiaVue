<script setup>
import { computed, onMounted, onUnmounted, watch } from 'vue';

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    form: {
        type: Object
    },
    buttonYes: { //Button Label
        type: String,
        default: 'Save'
    },
    buttonNo: {
        type: String,
        default: 'Close'
    },
    buttonType: { //Button Style follow Bootstrap alert, warning, etc
        type: String,
        default: 'primary'
    }
});

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
});

const buttonClass = computed(() => 'btn-' + props.buttonType)

const close = () => {
    var myModal = document.getElementById(props.id);
    var modal = bootstrap.Modal.getInstance(myModal)
    modal.hide();
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

//Parent can access close() function
defineExpose({ close });
//Callback event to parent
defineEmits(['yesEvent']);
</script>

<template>
    <teleport to="body">
        <div :id="id" class="modal fade" tabindex="-1" aria-labelledby="vueModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="vueModalLabel">{{ title }}</h1>
                        <button type="button" class="btn-close" @click="close" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <slot />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ buttonNo }}</button>
                        <button type="button" class="btn" :class="buttonClass" @click="$emit('yesEvent')" :disabled="form.processing">{{ buttonYes }}</button>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
</template>
