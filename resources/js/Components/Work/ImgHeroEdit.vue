<script setup>
import { ref } from 'vue';
import ImageUploader from '@/Components/ImageUploader.vue';

const props = defineProps({
    image: {
        type: String,
        default: 'https://placehold.co/400x600'
    }
});

const emit = defineEmits(['imageUpdated']);

const handleImageUpdated = (imageData) => {
    emit('imageUpdated', imageData);
};
</script>

<template>
    <div class="flex h-screen justify-center items-bottom cursor-pointer relative">
        <img class="h-full" :src="image" alt="Hero Image">
        
        <!-- Overlay de edición -->
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <ImageUploader
                :current-image="image"
                section="work_hero"
                name="hero"
                alt="Imagen Hero de Work"
                :image-class="'h-screen'"
                :preview-class="'h-screen object-cover border-2 border-blue-300 rounded'"
                button-text="Cambiar imagen"
                :show-edit-button="false"
                @image-updated="handleImageUpdated"
            />
        </div>
    </div>
</template>

