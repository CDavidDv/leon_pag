<template>
    <div class="fixed top-32 left-4 z-40">
        <div class="bg-white rounded-lg shadow-lg p-4 min-w-64">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Color de Fondo</h3>
            
            <div class="space-y-4">
                <!-- Selector de color -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Color de fondo principal
                    </label>
                    <div class="flex items-center space-x-2">
                        <input
                            type="color"
                            v-model="backgroundColor"
                            class="w-12 h-10 border border-gray-300 rounded cursor-pointer"
                            @change="updateBackgroundColor"
                        />
                        <input
                            type="text"
                            v-model="backgroundColor"
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md text-sm"
                            placeholder="#0A15E3"
                            @input="updateBackgroundColor"
                        />
                    </div>
                </div>

                <!-- Vista previa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Vista previa
                    </label>
                    <div 
                        class="w-full h-16 rounded-md border border-gray-300"
                        :style="{ backgroundColor: backgroundColor }"
                    ></div>
                </div>

                <!-- Botón para aplicar -->
                <button
                    @click="applyBackgroundColor"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md text-sm font-medium transition-colors"
                    :disabled="isUpdating"
                >
                    <span v-if="isUpdating">Aplicando...</span>
                    <span v-else>Aplicar Color</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    isEditing: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['background-color-updated']);

const backgroundColor = ref('#0A15E3');
const isUpdating = ref(false);

// Cargar el color de fondo actual
const loadBackgroundColor = async () => {
    try {
        const response = await axios.get('/api/site-config/background-color');
        if (response.data.success && response.data.data) {
            backgroundColor.value = response.data.data;
        }
    } catch (error) {
        console.error('Error al cargar el color de fondo:', error);
    }
};

// Actualizar el color de fondo
const updateBackgroundColor = async () => {
    if (!props.isEditing) return;
    
    try {
        isUpdating.value = true;
        
        const response = await axios.post('/api/site-config/background-color', {
            background_color: backgroundColor.value
        });
        
        if (response.data.success) {
            // Emitir evento para que el componente padre sepa que se actualizó
            emit('background-color-updated', backgroundColor.value);
            
            // Aplicar el color inmediatamente al CSS
            applyColorToCSS(backgroundColor.value);
        }
    } catch (error) {
        console.error('Error al actualizar el color de fondo:', error);
    } finally {
        isUpdating.value = false;
    }
};

// Aplicar color al CSS
const applyColorToCSS = (color) => {
    // Crear o actualizar la variable CSS personalizada
    const root = document.documentElement;
    root.style.setProperty('--site-background-color', color);
    root.style.setProperty('--site-primary-color', color);
    
    // Aplicar a elementos que usan la clase bg-site-primary
    const sitePrimaryElements = document.querySelectorAll('.bg-site-primary');
    sitePrimaryElements.forEach(element => {
        element.style.backgroundColor = color;
    });
    
    // Aplicar a elementos que usan estilos inline con la variable CSS
    const elementsWithVar = document.querySelectorAll('[style*="var(--site-background-color)"]');
    elementsWithVar.forEach(element => {
        element.style.backgroundColor = color;
    });
};

// Aplicar color de fondo
const applyBackgroundColor = () => {
    applyColorToCSS(backgroundColor.value);
};

onMounted(() => {
    loadBackgroundColor();
});
</script> 