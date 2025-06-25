<template>
    <div class="py-16 px-12">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-2xl font-bold text-white mb-6 text-center">{{ title || 'Galería Secundaria' }}</h2>
            
            <!-- Grid de imágenes -->
            <div v-if="processedImages && processedImages.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div 
                    v-for="(image, index) in processedImages" 
                    :key="index"
                    class="h-32"
                >
                    <GalleryImage
                        :section="section"
                        :image-index="index"
                        :current-image="image"
                        :is-editing="isEditing"
                        @image-updated="handleImageUpdated"
                    />
                </div>
            </div>

            <!-- Mensaje cuando no hay imágenes -->
            <div v-else class="text-center py-8">
                <div class="text-gray-400 mb-4">
                    <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <p class="text-gray-500">No hay imágenes en esta galería</p>
            </div>

            <!-- Botón para agregar nueva imagen -->
            <div v-if="isEditing" class="flex justify-center mt-6">
                <button 
                    @click="addNewImage"
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition-colors duration-200 flex items-center space-x-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Agregar imagen</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import GalleryImage from './GalleryImage.vue';
import axios from 'axios';

const props = defineProps({
    images: {
        type: Array,
        default: () => []
    },
    section: {
        type: String,
        default: 'gallery2'
    },
    title: {
        type: String,
        default: 'Galería Secundaria'
    },
    isEditing: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['images-updated']);

// Función para obtener la URL correcta de la imagen
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

// Computed para las imágenes procesadas
const processedImages = computed(() => {
    return props.images.map(image => ({
        ...image,
        path: image.url || getImageUrl(image.path)
    }));
});

// Función para manejar actualización de imagen individual
const handleImageUpdated = (data) => {
    console.log('Imagen de galería 2 actualizada:', data);
    emit('images-updated', data);
};

// Función para agregar nueva imagen
const addNewImage = () => {
    // Crear un input de archivo temporal
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.style.display = 'none';
    
    input.onchange = (event) => {
        const file = event.target.files[0];
        if (file) {
            // Encontrar el siguiente índice disponible
            let nextIndex = 1;
            const existingNames = processedImages.value.map(img => img.name);
            
            // Buscar el siguiente índice para imágenes
            while (existingNames.includes(`image_${nextIndex}`)) {
                nextIndex++;
            }
            
            console.log('Agregando nueva imagen:', { 
                nextIndex, 
                section: props.section 
            });
            
            // Emitir evento para agregar nueva imagen
            emit('images-updated', {
                section: props.section,
                imageIndex: nextIndex - 1,
                file: file,
                type: 'image',
                action: 'add'
            });
        }
        
        // Limpiar el input
        document.body.removeChild(input);
    };
    
    document.body.appendChild(input);
    input.click();
};
</script>

<style scoped>
</style> 