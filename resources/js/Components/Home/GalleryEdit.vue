<template>
    <div class="py-16 px-12">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-2xl font-bold text-white mb-6 text-center">{{ title || 'Galería de Imágenes' }}</h2>
            
            <GalleryEditor
                :imagenes="images"
                :section="section"
                :title="title || 'Galería Principal'"
                :description="description || 'Gestiona las imágenes de esta galería'"
                :maxImages="maxImages || 12"
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
    },
    section: {
        type: String,
        default: 'gallery'
    },
    title: {
        type: String,
        default: 'Galería Principal'
    },
    description: {
        type: String,
        default: 'Gestiona las imágenes de esta galería'
    },
    maxImages: {
        type: Number,
        default: 12
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

