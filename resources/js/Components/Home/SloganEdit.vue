<template>
    <div class="flex flex-col items-center justify-center py-32 max-w-2xl mx-auto">
        <EditableText
            v-model="sloganText"
            :is-editing="isEditing"
            tag="h1"
            class="lg:text-6xl text-4xl font-extrabold transform scale-y-75 text-center"
            placeholder="WE CREATE EXPERIENCES THAT GET YOU NOTICED AND HELP YOU GROW"
            @change="handleTextChange"
        />
    </div>
</template>

<style scoped>

</style>

<script setup>
import { ref } from 'vue';
import EditableText from '@/Components/EditableText.vue';

const props = defineProps({
    isEditing: {
        type: Boolean,
        default: false
    },
    initialText: {
        type: String,
        default: 'WE CREATE EXPERIENCES THAT GET YOU NOTICED AND HELP YOU GROW'
    }
});

const emit = defineEmits(['text-updated']);

const sloganText = ref(props.initialText);

const handleTextChange = (newText) => {
    emit('text-updated', {
        section: 'slogan',
        field: 'main_text',
        value: newText
    });
};
</script>

