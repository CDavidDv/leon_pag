<template>
    <div class="flex flex-col items-center justify-center py-16 max-w-3xl mx-auto">
        <EditableText
            v-model="headingText"
            :is-editing="isEditing"
            tag="h1"
            class="lg:text-7xl text-4xl font-extrabold transform scale-y-75 text-center"
            placeholder="EVERYTHING WE DO IS MADE BY EXPERIENCE"
            @change="handleHeadingChange"
        />
        <EditableText
            v-model="descriptionText"
            :is-editing="isEditing"
            tag="p"
            class="text-center"
            placeholder="We deliver results that surge with strategic magic, creative excellence and intelligent design."
            :multiline="true"
            @change="handleDescriptionChange"
        />
    </div>
</template>

<style scoped>
    h1 {
        line-height: 1.2;
    }
    p {
        font-family: 'New Times Roman', sans-serif;
        line-height: 1.8;
        font-weight: 100;
    }
</style>

<script setup>
import { ref } from 'vue';
import EditableText from '@/Components/EditableText.vue';

const props = defineProps({
    isEditing: {
        type: Boolean,
        default: false
    },
    initialHeading: {
        type: String,
        default: 'EVERYTHING WE DO IS MADE BY EXPERIENCE'
    },
    initialDescription: {
        type: String,
        default: 'We deliver results that surge with strategic magic, creative excellence and intelligent design.'
    }
});

const emit = defineEmits(['text-updated']);

const headingText = ref(props.initialHeading);
const descriptionText = ref(props.initialDescription);

const handleHeadingChange = (newText) => {
    emit('text-updated', {
        section: 'lastslogan',
        field: 'heading',
        value: newText
    });
};

const handleDescriptionChange = (newText) => {
    emit('text-updated', {
        section: 'lastslogan',
        field: 'description',
        value: newText
    });
};
</script>

