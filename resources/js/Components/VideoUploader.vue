<template>
    <div class="flex flex-col items-center space-y-4">
        <!-- Video actual -->
        <div class="relative">
            <video 
                v-if="videoActual && videoActual !== '/videos/placeholder.mp4'"
                :src="videoActual" 
                :alt="alt" 
                :class="videoClass"
                controls
                preload="metadata"
            ></video>
            <div v-else class="bg-gray-200 flex items-center justify-center" :class="videoClass">
                <span class="text-gray-500">Sin video</span>
            </div>
            <div v-if="showEditButton" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-200 rounded">
                <button 
                    class="bg-white text-gray-800 px-3 py-1 rounded text-sm font-medium"
                    @click="seleccionarVideo"
                    :disabled="isUploading"
                >
                    {{ isUploading ? 'Subiendo...' : 'Editar' }}
                </button>
            </div>
        </div>
        
        <!-- Botón para seleccionar video (si no está en modo hover) -->
        <button 
            v-if="!showEditButton"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors duration-200"
            @click="seleccionarVideo"
            :disabled="isUploading"
        >
            {{ isUploading ? 'Subiendo...' : buttonText }}
        </button>
        
        <!-- Input file oculto -->
        <input 
            type="file" 
            ref="fileInput" 
            @change="handleFileChange" 
            accept="video/*"
            class="hidden"
        />
        
        <!-- Vista previa del nuevo video -->
        <div v-if="nuevoVideo" class="mt-4">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Vista previa:</h3>
            <video 
                :src="nuevoVideo" 
                alt="Vista previa" 
                :class="previewClass"
                controls
                preload="metadata"
            ></video>
            <div class="mt-2 space-x-2">
                <button 
                    @click="confirmarCambio"
                    :disabled="isUploading"
                    class="bg-green-500 hover:bg-green-600 disabled:bg-gray-400 text-white px-3 py-1 rounded text-sm"
                >
                    {{ isUploading ? 'Subiendo...' : 'Confirmar' }}
                </button>
                <button 
                    @click="cancelarCambio"
                    :disabled="isUploading"
                    class="bg-red-500 hover:bg-red-600 disabled:bg-gray-400 text-white px-3 py-1 rounded text-sm"
                >
                    Cancelar
                </button>
            </div>
        </div>

        <!-- Mensaje de estado -->
        <div v-if="mensaje" :class="[
            'mt-2 p-2 rounded text-sm',
            mensajeTipo === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
        ]">
            {{ mensaje }}
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import axios from 'axios';

// Props del componente
const props = defineProps({
    currentVideo: {
        type: String,
        default: ''
    },
    section: {
        type: String,
        required: true
    },
    name: {
        type: String,
        required: true
    },
    alt: {
        type: String,
        default: 'Video'
    },
    videoClass: {
        type: String,
        default: 'w-full h-64 object-cover rounded'
    },
    previewClass: {
        type: String,
        default: 'w-48 h-32 object-cover border-2 border-blue-300 rounded'
    },
    buttonText: {
        type: String,
        default: 'Seleccionar video'
    },
    showEditButton: {
        type: Boolean,
        default: false
    },
    maxSize: {
        type: Number,
        default: 100 // 100MB por defecto para videos
    }
});

// Estado del componente
const fileInput = ref(null);
const nuevoVideo = ref(null);
const archivoSeleccionado = ref(null);
const isUploading = ref(false);
const mensaje = ref('');
const mensajeTipo = ref('');

// Computed para el video actual
const videoActual = computed(() => {
    if (props.currentVideo) {
        // Si ya tiene /storage/, no agregar nada
        if (props.currentVideo.startsWith('/storage/')) {
            return props.currentVideo;
        }
        // Si empieza con storage/, agregar /
        if (props.currentVideo.startsWith('storage/')) {
            return '/' + props.currentVideo;
        }
        // Si es una URL completa
        if (props.currentVideo.startsWith('http')) {
            return props.currentVideo;
        }
        // Si empieza con /, es una ruta absoluta
        if (props.currentVideo.startsWith('/')) {
            return props.currentVideo;
        }
        // Por defecto, asumir que está en storage
        return `/storage/${props.currentVideo}`;
    }
    return '/videos/placeholder.mp4';
});

const seleccionarVideo = () => {
    fileInput.value.click();
};

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Validar que sea un video
        if (!file.type.startsWith('video/')) {
            mostrarMensaje('Por favor selecciona un archivo de video válido', 'error');
            return;
        }
        
        // Validar tamaño
        if (file.size > props.maxSize * 1024 * 1024) {
            mostrarMensaje(`El video debe ser menor a ${props.maxSize}MB`, 'error');
            return;
        }
        
        archivoSeleccionado.value = file;
        
        // Crear URL para vista previa
        const reader = new FileReader();
        reader.onload = (e) => {
            nuevoVideo.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const confirmarCambio = async () => {
    if (!archivoSeleccionado.value) {
        mostrarMensaje('No hay archivo seleccionado', 'error');
        return;
    }

    isUploading.value = true;
    mensaje.value = '';

    try {
        // Crear FormData para enviar el archivo
        const formData = new FormData();
        formData.append('video', archivoSeleccionado.value);
        formData.append('section', props.section);
        formData.append('name', props.name);

        // Enviar el video al servidor
        const response = await axios.post('/api/media/upload-video', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        if (response.data.success) {
            // Limpiar el estado
            nuevoVideo.value = null;
            archivoSeleccionado.value = null;
            fileInput.value.value = '';
            
            mostrarMensaje('Video actualizado exitosamente', 'success');
            
            // Emitir evento para notificar al componente padre
            emit('videoUpdated', response.data.data);
        } else {
            mostrarMensaje(response.data.message || 'Error al subir el video', 'error');
        }
    } catch (error) {
        console.error('Error al subir el video:', error);
        mostrarMensaje(
            error.response?.data?.message || 'Error al subir el video. Inténtalo de nuevo.',
            'error'
        );
    } finally {
        isUploading.value = false;
    }
};

const cancelarCambio = () => {
    nuevoVideo.value = null;
    archivoSeleccionado.value = null;
    fileInput.value.value = '';
    mensaje.value = '';
};

const mostrarMensaje = (texto, tipo) => {
    mensaje.value = texto;
    mensajeTipo.value = tipo;
    
    // Limpiar el mensaje después de 5 segundos
    setTimeout(() => {
        mensaje.value = '';
    }, 5000);
};

// Definir eventos que emite el componente
const emit = defineEmits(['videoUpdated']);
</script> 