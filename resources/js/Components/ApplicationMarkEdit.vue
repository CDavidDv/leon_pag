<template>
    <div class="flex w-full justify-center items-center space-y-4">
        <!-- Imagen actual -->
        <img 
            :src="imagenActual" 
            alt="Logo de la empresa" 
            class="w-32 h-32 object-contain"
        />
        
        <!-- Botón para seleccionar imagen -->
        <button 
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors duration-200"
            @click="seleccionarImagen"
            :disabled="isUploading"
        >
            {{ isUploading ? 'Subiendo...' : 'Seleccionar imagen nueva' }}
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
                class="rounded-full w-24 h-24 object-cover border-2 border-blue-300"
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
import { usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

const fileInput = ref(null);
const props = usePage().props;

// Estado del componente
const nuevaImagen = ref(null);
const archivoSeleccionado = ref(null);
const isUploading = ref(false);
const mensaje = ref('');
const mensajeTipo = ref('');

// Computed para la imagen actual
const imagenActual = computed(() => {
    const logoPath = props?.media?.logo?.[0]?.path;
    if (logoPath) {
        // Si ya tiene /storage/, no agregar nada
        if (logoPath.startsWith('/storage/')) {
            return logoPath;
        }
        // Si empieza con storage/, agregar /
        if (logoPath.startsWith('storage/')) {
            return '/' + logoPath;
        }
        // Por defecto, asumir que está en storage
        return `/storage/${logoPath}`;
    }
    return '/images/logo.svg';
});

const seleccionarImagen = () => {
    fileInput.value.click();
};

const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Validar que sea una imagen
        if (!file.type.startsWith('image/')) {
            mostrarMensaje('Por favor selecciona un archivo de imagen válido', 'error');
            return;
        }
        
        // Validar tamaño (máximo 5MB)
        if (file.size > 5 * 1024 * 1024) {
            mostrarMensaje('La imagen debe ser menor a 5MB', 'error');
            return;
        }
        
        archivoSeleccionado.value = file;
        
        // Crear URL para vista previa
        const reader = new FileReader();
        reader.onload = (e) => {
            nuevaImagen.value = e.target.result;
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
        formData.append('section', 'logo');
        formData.append('name', 'logo');

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
            
            // Recargar los datos usando Inertia (más eficiente que window.location.reload())
            router.reload({ only: ['media'] });
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