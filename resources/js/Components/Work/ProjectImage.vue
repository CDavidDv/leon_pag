<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
    projectId: {
        type: String,
        required: true
    },
    imageIndex: {
        type: Number,
        required: true
    },
    currentImage: {
        type: Object,
        default: null
    },
    placeholderImage: {
        type: String,
        default: '/images/work/swish-fibre/1.png'
    },
    isEditing: {
        type: Boolean,
        default: false
    },
    layout: {
        type: String,
        default: 'full'
    }
});

const emit = defineEmits(['image-updated']);

const uploading = ref(false);
const showDeleteConfirm = ref(false);

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

// Computed para la URL de la imagen
const imageUrl = computed(() => {
    if (props.currentImage) {
        return props.currentImage.url || getImageUrl(props.currentImage.path);
    }
    return props.placeholderImage;
});

// Función para manejar cambio de imagen
const handleImageChange = async (event) => {
    const file = event.target.files[0];
    if (!file) return;

    try {
        uploading.value = true;
        const formData = new FormData();
        formData.append('image', file);
        formData.append('section', props.projectId);
        
        // Determinar el nombre del archivo basado en si ya existe una imagen
        let imageName;
        let action = 'add';
        
        if (props.currentImage && props.currentImage.name && props.currentImage.name.startsWith('image_')) {
            // Si ya existe una imagen con nombre image_X, reemplazarla
            imageName = props.currentImage.name;
            action = 'replace';
        } else {
            // Si no existe o es una imagen placeholder, crear un nuevo nombre
            const nextIndex = props.imageIndex + 1;
            imageName = `image_${nextIndex}`;
            action = 'add';
        }
        
        console.log('Subiendo imagen:', { imageName, action, projectId: props.projectId });
        formData.append('name', imageName);

        const response = await axios.post('/api/media/upload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        if (response.data.success) {
            console.log('Imagen subida exitosamente:', response.data);
            // Emitir evento para actualizar el estado padre
            emit('image-updated', {
                projectId: props.projectId,
                imageIndex: props.imageIndex,
                image: {
                    id: response.data.data.id,
                    path: response.data.data.path,
                    url: response.data.data.url,
                    name: response.data.data.name,
                    type: 'image'
                },
                action: action
            });
        }
    } catch (error) {
        console.error('Error al actualizar imagen:', error);
    } finally {
        uploading.value = false;
    }
};

// Función para manejar cambio de video
const handleVideoChange = async (event) => {
    const file = event.target.files[0];
    if (!file) return;

    try {
        uploading.value = true;
        const formData = new FormData();
        formData.append('video', file);
        formData.append('section', props.projectId);
        
        // Determinar el nombre del archivo basado en si ya existe un video
        let videoName;
        let action = 'add';
        
        if (props.currentImage && props.currentImage.name && props.currentImage.name.startsWith('video_')) {
            // Si ya existe un video con nombre video_X, reemplazarlo
            videoName = props.currentImage.name;
            action = 'replace';
        } else {
            // Si no existe o es una imagen placeholder, crear un nuevo nombre
            const nextIndex = props.imageIndex + 1;
            videoName = `video_${nextIndex}`;
            action = 'add';
        }
        
        console.log('Subiendo video:', { videoName, action, projectId: props.projectId });
        formData.append('name', videoName);

        const response = await axios.post('/api/media/upload-video', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        if (response.data.success) {
            console.log('Video subido exitosamente:', response.data);
            // Emitir evento para actualizar el estado padre
            emit('image-updated', {
                projectId: props.projectId,
                imageIndex: props.imageIndex,
                video: {
                    id: response.data.data.id,
                    path: response.data.data.path,
                    url: response.data.data.url,
                    name: response.data.data.name,
                    type: 'video'
                },
                action: action
            });
        }
    } catch (error) {
        console.error('Error al actualizar video:', error);
    } finally {
        uploading.value = false;
    }
};

// Determinar si es video basado en la extensión
const isVideo = computed(() => {
    if (!props.currentImage) return false;
    const path = props.currentImage.path || props.currentImage.url || '';
    return path.match(/\.(mp4|webm|ogg|mov)$/i);
});

// Función para mostrar el modal de confirmación de eliminación
const showDeleteModal = () => {
    showDeleteConfirm.value = true;
};

// Función para ocultar el modal de confirmación
const hideDeleteModal = () => {
    showDeleteConfirm.value = false;
};

// Función para manejar la eliminación de la imagen
const handleDelete = async () => {
    if (!props.currentImage || !props.currentImage.id) {
        console.error('No hay imagen para eliminar');
        return;
    }

    try {
        // Llamar a la API para eliminar la imagen
        const response = await axios.delete(`/api/media/${props.currentImage.id}`);
        
        if (response.data.success) {
            console.log('Imagen eliminada exitosamente');
            
            // Emitir evento para actualizar el estado padre
            emit('image-updated', {
                projectId: props.projectId,
                imageIndex: props.imageIndex,
                action: 'delete',
                deletedImageId: props.currentImage.id
            });
            
            // Ocultar el modal
            hideDeleteModal();
        } else {
            console.error('Error al eliminar la imagen:', response.data.message);
        }
    } catch (error) {
        console.error('Error al eliminar la imagen:', error);
    }
};
</script>

<template>
    <div class="relative w-full h-full">
        <!-- Imagen o Video -->
        <img 
            v-if="!isVideo" 
            :src="imageUrl" 
            :alt="`${projectId} - Imagen ${imageIndex + 1}`" 
            class="w-full h-full object-cover"
        />
        <video 
            v-else 
            :src="imageUrl" 
            :alt="`${projectId} - Video ${imageIndex + 1}`" 
            class="w-full h-full object-cover bg-black"
            controls
            autoplay
            muted
            loop
        />
        
        <!-- Overlay de edición -->
        <div v-if="isEditing" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white bg-opacity-90 p-4 rounded-lg shadow-lg">
                <div class="flex flex-col gap-2">
                    <label class="text-black text-sm font-medium">
                        Cambiar imagen:
                        <input 
                            type="file" 
                            @change="handleImageChange"
                            accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        />
                    </label>
                    <label class="text-black text-sm font-medium">
                        Cambiar video:
                        <input 
                            type="file" 
                            @change="handleVideoChange"
                            accept="video/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                        />
                    </label>
                    <!-- Botón de eliminar -->
                    <button 
                        v-if="currentImage && currentImage.id"
                        @click="showDeleteModal"
                        class="mt-2 px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm font-medium transition-colors"
                    >
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminar
                        </div>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Indicador de carga -->
        <div v-if="uploading" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-4 rounded-lg shadow-lg flex items-center gap-2">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-black">Subiendo...</span>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <div v-if="showDeleteConfirm" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    Confirmar eliminación
                </h3>
                <p class="text-sm text-gray-500 mb-6">
                    ¿Estás seguro de que quieres eliminar esta imagen? Esta acción no se puede deshacer.
                </p>
                <div class="flex gap-3 justify-center">
                    <button 
                        @click="hideDeleteModal"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md text-sm font-medium transition-colors"
                    >
                        Cancelar
                    </button>
                    <button 
                        @click="handleDelete"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-medium transition-colors"
                    >
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
video {
    background-color: #000;
}
</style> 