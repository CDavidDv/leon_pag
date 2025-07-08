<template>
    <div class="w-full lg:h-screen py-40 lg:py-0 flex flex-col justify-center items-center px-8 relative">
        <EditableText
            :model-value="title"
            :is-editing="isEditing"
            tag="h1"
            :class="titleClass"
            @update:model-value="(value) => handleTextUpdated('title', value)"
        />
        <EditableText
            v-if="paragraph1"
            :model-value="paragraph1"
            :is-editing="isEditing"
            tag="p"
            :class="paragraphClass"
            :multiline="true"
            @update:model-value="(value) => handleTextUpdated('paragraph_1', value)"
        />
        <EditableText
            v-if="paragraph2"
            :model-value="paragraph2"
            :is-editing="isEditing"
            tag="p"
            :class="paragraphClass"
            :multiline="true"
            @update:model-value="(value) => handleTextUpdated('paragraph_2', value)"
        />
        <EditableText
            v-if="paragraph3"
            :model-value="paragraph3"
            :is-editing="isEditing"
            tag="p"
            :class="paragraphClass"
            :multiline="true"
            @update:model-value="(value) => handleTextUpdated('paragraph_3', value)"
        />
        <EditableText
            v-if="paragraph4"
            :model-value="paragraph4"
            :is-editing="isEditing"
            tag="p"
            :class="paragraphClass"
            :multiline="true"
            @update:model-value="(value) => handleTextUpdated('paragraph_4', value)"
        />
    </div>
</template>

<script setup>
import EditableText from './EditableText.vue';

const props = defineProps({
    title: {
        type: String,
        default: ''
    },
    paragraph1: {
        type: String,
        default: ''
    },
    paragraph2: {
        type: String,
        default: ''
    },
    paragraph3: {
        type: String,
        default: ''
    },
    paragraph4: {
        type: String,
        default: ''
    },
    isEditing: {
        type: Boolean,
        default: false
    },
    section: {
        type: String,
        required: true
    },
    titleClass: {
        type: String,
        default: 'lg:text-7xl text-4xl max-w-2xl text-center font-extrabold transform scale-y-75'
    },
    paragraphClass: {
        type: String,
        default: 'text-normal mb-10 max-w-xl text-center'
    }
});

const emit = defineEmits(['text-updated']);

const handleTextUpdated = (field, value) => {
    emit('text-updated', {
        section: props.section,
        field: field,
        value: value
    });
};
</script> 