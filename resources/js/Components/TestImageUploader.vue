<template>
    <div class="p-4 bg-gray-100 rounded-lg">
        <h3 class="text-lg font-bold mb-4">Test ImageUploader</h3>
        <ImageUploader
            :currentImage="currentImage"
            section="test"
            name="test_image"
            alt="Imagen de prueba"
            imageClass="w-32 h-32 object-cover rounded-lg"
            previewClass="w-48 h-32 object-cover border-2 border-blue-300 rounded"
            buttonText="Seleccionar imagen de prueba"
            :showEditButton="true"
            :maxSize="5"
            @imageUpdated="handleImageUpdated"
        />
    </div>
</template>

<script setup>
import ImageUploader from '@/Components/ImageUploader.vue';
import { ref } from 'vue';

const currentImage = ref('/images/placeholder.svg');

const handleImageUpdated = (imageData) => {
    console.log('Imagen actualizada en TestImageUploader:', imageData);
    currentImage.value = imageData.url || imageData.path;
};
</script> 