<template>
    <div class="lg:text-center text-sm text-gray-100 pb-12 pt-12 px-12 lg:px-0">
        <EditableText
            :model-value="footerText"
            :is-editing="isEditing"
            tag="p"
            class="lg:text-center text-sm text-gray-100"
            :multiline="true"
            @update:model-value="handleTextUpdated"
        />
    </div>
</template>

<script setup>
import EditableText from '../EditableText.vue';

const props = defineProps({
    footerText: {
        type: String,
        default: "© By Experience Ltd, 2024. Guardian House, 42 Preston New Rd, Blackburn BB2 6AH    All Rights Reserved | Company registered in England & Wales number: 11469161"
    },
    isEditing: {
        type: Boolean,
        default: false
    },
    initialFooterText: {
        type: String,
        default: ""
    }
});

const emit = defineEmits(['text-updated']);

const handleTextUpdated = (value) => {
    emit('text-updated', {
        section: 'footer',
        field: 'footer_text',
        value: value
    });
};
</script>

<style scoped>
    * {
        font-family: 'New Times Roman', sans-serif;
    }
</style>