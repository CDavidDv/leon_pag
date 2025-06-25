<template>
    <div class="py-16 px-12">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-2xl font-bold text-white mb-6 text-center">Segunda Galería de Imágenes</h2>
            
            <GalleryEditor
                :imagenes="images"
                section="gallery2"
                title="Segunda Galería"
                description="Gestiona las imágenes de la segunda galería de la página"
                :maxImages="12"
                @imageAdded="handleImageAdded"
                @imageUpdated="handleImageUpdated"
                @imageDeleted="handleImageDeleted"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import GalleryEditor from '@/Components/GalleryEditor.vue';

const props = defineProps({
    images: {
        type: Array,
        default: () => []
    }
});

const handleImageAdded = (imageData) => {
    emit('imageAdded', imageData);
};

const handleImageUpdated = (imageData) => {
    emit('imageUpdated', imageData);
};

const handleImageDeleted = (imageData) => {
    emit('imageDeleted', imageData);
};

const emit = defineEmits(['imageAdded', 'imageUpdated', 'imageDeleted']);
</script>

<style scoped>
</style> 