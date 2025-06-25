<template>
    <div class="flex flex-col items-center space-y-4">
        <!-- Imagen actual -->
        <div class="relative">
            <img 
                :src="imagenActual" 
                :alt="alt" 
                :class="imageClass"
            />
            <div v-if="showEditButton" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded">
                <button 
                    class="bg-white text-gray-800 px-3 py-1 rounded text-sm font-medium"
                    @click="seleccionarImagen"
                    :disabled="isUploading"
                >
                    {{ isUploading ? 'Subiendo...' : 'Editar' }}
                </button>
            </div>
        </div>
        
        <!-- Botón para seleccionar imagen (si no está en modo hover) -->
        <button 
            v-if="!showEditButton"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors duration-200"
            @click="seleccionarImagen"
            :disabled="isUploading"
        >
            {{ isUploading ? 'Subiendo...' : buttonText }}
        </button>
        
        <!-- Input file oculto -->
        <input 
            type="file" 
            ref="fileInput" 
            @change="handleFileChange" 
            accept="image/*"
            class="hidden"
        />
        
        <!-- Vista previa de la nueva imagen -->
        <div v-if="nuevaImagen" class="mt-4">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Vista previa:</h3>
            <img 
                :src="nuevaImagen" 
                alt="Vista previa" 
                :class="previewClass"
            />
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
    currentImage: {
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
        default: 'Imagen'
    },
    imageClass: {
        type: String,
        default: 'w-32 h-32 object-contain'
    },
    previewClass: {
        type: String,
        default: 'w-24 h-24 object-cover border-2 border-blue-300 rounded'
    },
    buttonText: {
        type: String,
        default: 'Seleccionar imagen'
    },
    showEditButton: {
        type: Boolean,
        default: false
    },
    maxSize: {
        type: Number,
        default: 5 // 5MB por defecto
    }
});

// Estado del componente
const fileInput = ref(null);
const nuevaImagen = ref(null);
const archivoSeleccionado = ref(null);
const isUploading = ref(false);
const mensaje = ref('');
const mensajeTipo = ref('');

// Computed para la imagen actual
const imagenActual = computed(() => {
    if (props.currentImage) {
        // Si ya tiene /storage/, no agregar nada
        if (props.currentImage.startsWith('/storage/')) {
            return props.currentImage;
        }
        // Si empieza con storage/, agregar /
        if (props.currentImage.startsWith('storage/')) {
            return '/' + props.currentImage;
        }
        // Si es una URL completa
        if (props.currentImage.startsWith('http')) {
            return props.currentImage;
        }
        // Si empieza con /, es una ruta absoluta
        if (props.currentImage.startsWith('/')) {
            return props.currentImage;
        }
        // Por defecto, asumir que está en storage
        return `/storage/${props.currentImage}`;
    }
    return '/images/placeholder.svg';
});

const seleccionarImagen = () => {
    fileInput.value.click();
};

const handleFileChange = (event) => {
    const file = event.target.files[0];
    console.log('Archivo seleccionado:', file);
    if (file) {
        // Validar que sea una imagen
        if (!file.type.startsWith('image/')) {
            mostrarMensaje('Por favor selecciona un archivo de imagen válido', 'error');
            return;
        }
        
        // Validar tamaño
        if (file.size > props.maxSize * 1024 * 1024) {
            mostrarMensaje(`La imagen debe ser menor a ${props.maxSize}MB`, 'error');
            return;
        }
        
        archivoSeleccionado.value = file;
        console.log('Archivo guardado en archivoSeleccionado:', archivoSeleccionado.value);
        
        // Crear URL para vista previa
        const reader = new FileReader();
        reader.onload = (e) => {
            nuevaImagen.value = e.target.result;
            console.log('Nueva imagen establecida:', nuevaImagen.value);
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
        formData.append('image', archivoSeleccionado.value);
        formData.append('section', props.section);
        formData.append('name', props.name);

        // Enviar la imagen al servidor
        const response = await axios.post('/api/media/upload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        if (response.data.success) {
            // Limpiar el estado
            nuevaImagen.value = null;
            archivoSeleccionado.value = null;
            fileInput.value.value = '';
            
            mostrarMensaje('Imagen actualizada exitosamente', 'success');
            
            // Emitir evento para notificar al componente padre
            emit('imageUpdated', response.data.data);
        } else {
            mostrarMensaje(response.data.message || 'Error al subir la imagen', 'error');
        }
    } catch (error) {
        console.error('Error al subir la imagen:', error);
        mostrarMensaje(
            error.response?.data?.message || 'Error al subir la imagen. Inténtalo de nuevo.',
            'error'
        );
    } finally {
        isUploading.value = false;
    }
};

const cancelarCambio = () => {
    nuevaImagen.value = null;
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
const emit = defineEmits(['imageUpdated']);
</script> 