<template>
    <div class="fixed bottom-0 right-14">
        <div class="size-60 bg-white rounded-full flex justify-center items-center cursor-pointer relative" @click="showBarContact">
            <!-- Imagen del botón flotante -->
            <img 
                v-if="floatingButtonImage" 
                :src="getImageUrl(floatingButtonImage)" 
                :alt="'Botón flotante'"
                class="w-full h-full object-cover rounded-full" 
            />
            <!-- Icono por defecto si no hay imagen -->
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
            
            <!-- Editor de imagen en modo edición -->
            <div v-if="isEditing" class="absolute bottom-full right-0 z-10 bg-white p-2 rounded-lg shadow-lg border mb-2">
                <div class="text-xs text-gray-600 mb-2">Editar imagen</div>
                <ImageUploader
                    :currentImage="getImageUrl(floatingButtonImage)"
                    section="welcome"
                    name="floating_button"
                    alt="Imagen del botón flotante"
                    imageClass="w-16 h-16 object-cover rounded-lg"
                    previewClass="w-32 h-32 object-cover border-2 border-blue-300 rounded-full"
                    buttonText="Cambiar imagen"
                    :showEditButton="false"
                    :maxSize="5"
                    @imageUpdated="handleImageUpdated"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import ImageUploader from '@/Components/ImageUploader.vue';

const props = defineProps({
    isEditing: {
        type: Boolean,
        default: false
    },
    floatingButtonImage: {
        type: Object,
        default: null
    }
});

const emit = defineEmits(['image-updated']);

const getImageUrl = (image) => {
    if (!image || !image.path) return null;
    
    if (image.path.startsWith('/storage/')) {
        return image.path;
    }
    if (image.path.startsWith('storage/')) {
        return '/' + image.path;
    }
    if (image.path.startsWith('http')) {
        return image.path;
    }
    if (image.path.startsWith('/')) {
        return image.path;
    }
    return `/storage/${image.path}`;
};

const handleImageUpdated = (imageData) => {
    console.log('Imagen actualizada en FloatingButtonEdit:', imageData);
    emit('image-updated', imageData);
};

// Función para mostrar el bar de contacto (se expone para que el layout pueda acceder)
const showBarContact = () => {
    // Esta función será manejada por el layout
    console.log('showBarContact from floating button');
};
</script> 