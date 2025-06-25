<template>
    <div class="space-y-6">
        <!-- Título de la sección -->
        <div class="border-b border-gray-200 pb-4">
            <h3 class="text-lg font-medium text-gray-900">{{ title }}</h3>
            <p class="text-sm text-gray-500">{{ description }}</p>
        </div>

        <!-- Galería actual -->
        <div v-if="imagenes.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div 
                v-for="(imagen, index) in imagenes" 
                :key="index"
                class="relative group"
            >
                <img 
                    :src="getImageUrl(imagen.path)" 
                    :alt="imagen.alt || 'Imagen de galería'"
                    class="w-full h-32 object-cover rounded-lg"
                />
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg">
                    <div class="flex space-x-2">
                        <button 
                            @click="editarImagen(index)"
                            class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded"
                            title="Editar imagen"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </button>
                        <button 
                            @click="eliminarImagen(index)"
                            class="bg-red-500 hover:bg-red-600 text-white p-2 rounded"
                            title="Eliminar imagen"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
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
        <div class="flex justify-center">
            <button 
                @click="agregarNuevaImagen"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition-colors duration-200 flex items-center space-x-2"
                :disabled="isUploading"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>{{ isUploading ? 'Subiendo...' : 'Agregar imagen' }}</span>
            </button>
        </div>

        <!-- Input file oculto -->
        <input 
            type="file" 
            ref="fileInput" 
            @change="handleFileChange" 
            accept="image/*"
            multiple
            class="hidden"
        />

        <!-- Modal para editar imagen -->
        <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Editar imagen</h3>
                
                <div class="space-y-4">
                    <!-- Vista previa de la imagen actual -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Imagen actual:</label>
                        <img 
                            :src="getImageUrl(imagenEditando.path)" 
                            :alt="imagenEditando.alt"
                            class="w-full h-32 object-cover rounded"
                        />
                    </div>

                    <!-- Nueva imagen -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nueva imagen:</label>
                        <input 
                            type="file" 
                            @change="handleEditFileChange" 
                            accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                        />
                    </div>

                    <!-- Alt text -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Texto alternativo:</label>
                        <input 
                            v-model="imagenEditando.alt"
                            type="text"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Descripción de la imagen"
                        />
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button 
                        @click="cancelarEdicion"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md"
                    >
                        Cancelar
                    </button>
                    <button 
                        @click="guardarEdicion"
                        :disabled="isUploading"
                        class="bg-blue-500 hover:bg-blue-600 disabled:bg-gray-400 text-white px-4 py-2 rounded-md"
                    >
                        {{ isUploading ? 'Guardando...' : 'Guardar' }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Mensaje de estado -->
        <div v-if="mensaje" :class="[
            'mt-4 p-3 rounded text-sm',
            mensajeTipo === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
        ]">
            {{ mensaje }}
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';

// Props del componente
const props = defineProps({
    imagenes: {
        type: Array,
        default: () => []
    },
    section: {
        type: String,
        required: true
    },
    title: {
        type: String,
        default: 'Galería de imágenes'
    },
    description: {
        type: String,
        default: 'Gestiona las imágenes de esta sección'
    },
    maxImages: {
        type: Number,
        default: 10
    }
});

// Estado del componente
const fileInput = ref(null);
const isUploading = ref(false);
const mensaje = ref('');
const mensajeTipo = ref('');
const showEditModal = ref(false);
const imagenEditando = ref(null);
const nuevoArchivo = ref(null);

// Función para obtener la URL de la imagen
const getImageUrl = (path) => {
    if (!path) return '/images/placeholder.svg';
    
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

const agregarNuevaImagen = () => {
    if (props.imagenes.length >= props.maxImages) {
        mostrarMensaje(`No puedes agregar más de ${props.maxImages} imágenes`, 'error');
        return;
    }
    fileInput.value.click();
};

const handleFileChange = async (event) => {
    const files = Array.from(event.target.files);
    
    if (files.length === 0) return;
    
    // Validar número máximo de imágenes
    if (props.imagenes.length + files.length > props.maxImages) {
        mostrarMensaje(`No puedes agregar más de ${props.maxImages} imágenes en total`, 'error');
        return;
    }

    isUploading.value = true;
    mensaje.value = '';

    try {
        for (const file of files) {
            // Validar que sea una imagen
            if (!file.type.startsWith('image/')) {
                mostrarMensaje(`${file.name} no es una imagen válida`, 'error');
                continue;
            }

            // Validar tamaño (5MB por defecto)
            if (file.size > 5 * 1024 * 1024) {
                mostrarMensaje(`${file.name} es demasiado grande (máximo 5MB)`, 'error');
                continue;
            }

            const formData = new FormData();
            formData.append('image', file);
            formData.append('section', props.section);
            formData.append('name', `gallery_${Date.now()}_${file.name}`);

            const response = await axios.post('/api/media/upload-image', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });

            if (response.data.success) {
                emit('imageAdded', response.data.data);
            }
        }

        mostrarMensaje('Imágenes agregadas exitosamente', 'success');
        fileInput.value.value = '';
    } catch (error) {
        console.error('Error al subir imágenes:', error);
        mostrarMensaje(
            error.response?.data?.message || 'Error al subir las imágenes. Inténtalo de nuevo.',
            'error'
        );
    } finally {
        isUploading.value = false;
    }
};

const editarImagen = (index) => {
    imagenEditando.value = { ...props.imagenes[index] };
    showEditModal.value = true;
};

const handleEditFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        if (!file.type.startsWith('image/')) {
            mostrarMensaje('Por favor selecciona una imagen válida', 'error');
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            mostrarMensaje('La imagen es demasiado grande (máximo 5MB)', 'error');
            return;
        }
        nuevoArchivo.value = file;
    }
};

const guardarEdicion = async () => {
    isUploading.value = true;
    mensaje.value = '';

    try {
        let updatedImage = { ...imagenEditando.value };

        // Si hay un nuevo archivo, subirlo
        if (nuevoArchivo.value) {
            const formData = new FormData();
            formData.append('image', nuevoArchivo.value);
            formData.append('section', props.section);
            formData.append('name', `gallery_${Date.now()}_${nuevoArchivo.value.name}`);

            const response = await axios.post('/api/media/upload-image', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });

            if (response.data.success) {
                updatedImage = response.data.data;
                updatedImage.alt = imagenEditando.value.alt;
            }
        }

        emit('imageUpdated', updatedImage);
        mostrarMensaje('Imagen actualizada exitosamente', 'success');
        cancelarEdicion();
    } catch (error) {
        console.error('Error al actualizar imagen:', error);
        mostrarMensaje(
            error.response?.data?.message || 'Error al actualizar la imagen. Inténtalo de nuevo.',
            'error'
        );
    } finally {
        isUploading.value = false;
    }
};

const cancelarEdicion = () => {
    showEditModal.value = false;
    imagenEditando.value = null;
    nuevoArchivo.value = null;
};

const eliminarImagen = async (index) => {
    if (!confirm('¿Estás seguro de que quieres eliminar esta imagen?')) {
        return;
    }

    const imagen = props.imagenes[index];
    
    try {
        await axios.delete(`/api/media/${imagen.id}`);
        emit('imageDeleted', imagen);
        mostrarMensaje('Imagen eliminada exitosamente', 'success');
    } catch (error) {
        console.error('Error al eliminar imagen:', error);
        mostrarMensaje(
            error.response?.data?.message || 'Error al eliminar la imagen. Inténtalo de nuevo.',
            'error'
        );
    }
};

const mostrarMensaje = (texto, tipo) => {
    mensaje.value = texto;
    mensajeTipo.value = tipo;
    
    setTimeout(() => {
        mensaje.value = '';
    }, 5000);
};

// Definir eventos que emite el componente
const emit = defineEmits(['imageAdded', 'imageUpdated', 'imageDeleted']);
</script> 