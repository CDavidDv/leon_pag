<template>
    <div class="relative min-h-42 pt-40 flex items-center justify-center">
        
        
        <!-- Contenido del hero -->
        <div class="relative z-20 flex lg:pt-20 transform scale-y-[0.75] justify-center pt-44 max-w-4xl mx-auto items-center text-6xl font-extrabold lg:text-center px-10">
            <EditableText
                v-model="heroText"
                :is-editing="isEditing"
                tag="h1"
                class="text-6xl font-extrabold text-white"
                placeholder="WE ARE A BRAND AND MARKETING AGENCY THAT SOLVE PROBLEMS AND MAKE THINGS HAPPEN"
                @change="handleTextChange"
            />
        </div>
        
    </div>
</template>

<script setup>
import { ref } from 'vue';
import EditableText from '@/Components/EditableText.vue';
import ImageUploader from '@/Components/ImageUploader.vue';

const props = defineProps({
    isEditing: {
        type: Boolean,
        default: false
    },
    heroImage: {
        type: String,
        default: ''
    },
    initialText: {
        type: String,
        default: 'WE ARE A BRAND AND MARKETING AGENCY THAT SOLVE PROBLEMS AND MAKE THINGS HAPPEN'
    }
});

const emit = defineEmits(['text-updated', 'image-updated']);

const heroText = ref(props.initialText);

const getImageUrl = (path) => {
    if (!path) return '';
    
    if (path.startsWith('/storage/')) {
        return path;
    }
    if (path.startsWith('storage/')) {
        return '/' + path;
    }
    if (path.startsWith('http')) {
        return path;
    }
    if (path.startsWith('/')) {
        return path;
    }
    return `/storage/${path}`;
};

const handleTextChange = (newText) => {
    emit('text-updated', {
        section: 'hero',
        field: 'main_text',
        value: newText
    });
};

const handleImageUpdated = (imageData) => {
    emit('image-updated', imageData);
};
</script>

<style scoped>
    * {
        font-weight: 1000 !important;
        line-height: 1.1 !important;
    }
</style>