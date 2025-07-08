<template>
    <div class="flex flex-col items-center space-y-2">
        <!-- Imagen actual -->
        <img 
            :src="imagenActual" 
            alt="Logo de la empresa" 
            class="w-full h-full object-contain"
        />
        
        <!-- Botón para seleccionar imagen (solo visible en modo edición) -->
        <button 
            v-if="isEditing"
            class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs transition-colors duration-200"
            @click="seleccionarImagen"
            :disabled="isUploading"
        >
            {{ isUploading ? 'Subiendo...' : 'Cambiar logo' }}
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
        <div v-if="nuevaImagen && isEditing" class="mt-2">
            <h3 class="text-xs font-medium text-gray-700 mb-1">Vista previa:</h3>
            <img 
                :src="nuevaImagen" 
                alt="Vista previa" 
                class="w-16 h-16 object-cover border-2 border-blue-300 rounded"
            />
            <div class="mt-1 space-x-1">
                <button 
                    @click="confirmarCambio"
                    :disabled="isUploading"
                    class="bg-green-500 hover:bg-green-600 disabled:bg-gray-400 text-white px-2 py-1 rounded text-xs"
                >
                    {{ isUploading ? 'Subiendo...' : 'Confirmar' }}
                </button>
                <button 
                    @click="cancelarCambio"
                    :disabled="isUploading"
                    class="bg-red-500 hover:bg-red-600 disabled:bg-gray-400 text-white px-2 py-1 rounded text-xs"
                >
                    Cancelar
                </button>
            </div>
        </div>

        <!-- Mensaje de estado -->
        <div v-if="mensaje && isEditing" :class="[
            'mt-1 p-1 rounded text-xs',
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

const props = defineProps({
    isEditing: {
        type: Boolean,
        default: false
    }
});

const fileInput = ref(null);
const pageProps = usePage().props;

// Estado del componente
const nuevaImagen = ref(null);
const archivoSeleccionado = ref(null);
const isUploading = ref(false);
const mensaje = ref('');
const mensajeTipo = ref('');

// Computed para la imagen actual
const imagenActual = computed(() => {
    const logoPath = pageProps?.media?.logo?.[0]?.path;
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
    return `${props}`;
});

console.log(pageProps)

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
            
            mostrarMensaje('Logo actualizado exitosamente', 'success');
            
            // Emitir evento para notificar al componente padre
            emit('imageUpdated', response.data.data);
            
            // Recargar los datos usando Inertia
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