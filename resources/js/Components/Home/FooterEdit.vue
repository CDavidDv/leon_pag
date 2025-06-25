<template>
    <div class="lg:text-center text-sm text-gray-100 pb-12 pt-12 px-12 lg:px-0">
        <EditableText
            v-model="footerText"
            :is-editing="isEditing"
            tag="div"
            placeholder="© By Experience Ltd, 2024. Guardian House, 42 Preston New Rd, Blackburn BB2 6AH    All Rights Reserved | Company registered in England & Wales number: 11469161"
            :multiline="true"
            @change="handleFooterTextChange"
        />
    </div>
</template>

<script setup>
import EditableText from '@/Components/EditableText.vue';
import { ref } from 'vue';

const props = defineProps({
    isEditing: {
        type: Boolean,
        default: false
    },
    initialFooterText: {
        type: String,
        default: "© By Experience Ltd, 2024. Guardian House, 42 Preston New Rd, Blackburn BB2 6AH    All Rights Reserved | Company registered in England & Wales number: 11469161"
    }
});

const emit = defineEmits(['text-updated']);

// Texto editable
const footerText = ref(props.initialFooterText);

// Función para manejar cambios de texto
const handleFooterTextChange = (newText) => {
    emit('text-updated', {
        section: 'footer',
        field: 'footer_text',
        value: newText
    });
};
</script>

<style scoped>
    * {
        font-family: 'New Times Roman', sans-serif;
    }
</style>