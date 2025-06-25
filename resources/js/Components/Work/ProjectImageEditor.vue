<template>
    <div class="bg-white p-4 rounded-lg shadow-lg mb-4">
        <h3 class="text-lg font-bold mb-4 text-gray-800">{{ title }}</h3>
        
        <!-- Selector de disposición -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-black mb-2">Disposición de imágenes:</label>
            <select 
                v-model="selectedLayout" 
                @change="handleLayoutChange"
                class="w-full p-2 border  border-gray-300 text-black rounded-md"
            >
                <option value="1" class="text-black">1 imagen (ancho completo)</option>
                <option value="2" class="text-black">2 imágenes (lado a lado)</option>
                <option value="3" class="text-black">3 imágenes (1 grande, 2 pequeñas)</option>
                <option value="4" class="text-black">4 imágenes (2x2)</option>
                <option value="5" class="text-black">5 imágenes (2 arriba, 3 abajo)</option>
            </select>
        </div>

        <!-- Contenedor de imágenes -->
        <div class="grid gap-4" :class="gridClass">
            <div 
                v-for="(image, index) in images" 
                :key="index"
                class="relative border-2 border-dashed border-gray-300 rounded-lg p-4"
                :class="imageClass"
            >
                <img 
                    :src="getImageDisplayUrl(image) || '/images/placeholder.svg'" 
                    :alt="`Imagen ${index + 1}`"
                    class="w-full h-full object-cover rounded"
                />
                
                <!-- Overlay de edición -->
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-200 rounded">
                    <ImageUploader
                        :current-image="getImageDisplayUrl(image)"
                        :section="`${section}_${index + 1}`"
                        :name="`image_${index + 1}`"
                        :alt="`Imagen ${index + 1} de ${title}`"
                        :image-class="'w-full h-full object-cover rounded'"
                        :preview-class="'w-24 h-24 object-cover border-2 border-blue-300 rounded'"
                        button-text="Cambiar imagen"
                        :show-edit-button="false"
                        @image-updated="(data) => handleImageUpdated(data, index)"
                    />
                </div>
                
                <!-- Botón para eliminar imagen -->
                <button 
                    @click="removeImage(index)"
                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600"
                    v-if="images.length > 1"
                >
                    ×
                </button>
            </div>
        </div>

        <!-- Botón para agregar imagen -->
        <button 
            @click="addImage"
            class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors duration-200"
            v-if="images.length < maxImages"
        >
            Agregar imagen
        </button>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue';
import ImageUploader from '@/Components/ImageUploader.vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    section: {
        type: String,
        required: true
    },
    currentImages: {
        type: Array,
        default: () => []
    },
    maxImages: {
        type: Number,
        default: 10
    }
});

const emit = defineEmits(['imagesUpdated']);

const selectedLayout = ref('1');
const images = ref([...props.currentImages]);

// Función para obtener la URL correcta de la imagen
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

// Función para obtener la URL de la imagen (prioriza url sobre path)
const getImageDisplayUrl = (image) => {
    if (!image) return '/images/placeholder.svg';
    return image.url || getImageUrl(image.path);
};

// Computed para las clases CSS del grid
const gridClass = computed(() => {
    switch (selectedLayout.value) {
        case '1':
            return 'grid-cols-1';
        case '2':
            return 'grid-cols-2';
        case '3':
            return 'grid-cols-3';
        case '4':
            return 'grid-cols-2';
        case '5':
            return 'grid-cols-3';
        default:
            return 'grid-cols-1';
    }
});

// Computed para las clases CSS de las imágenes
const imageClass = computed(() => {
    switch (selectedLayout.value) {
        case '1':
            return 'h-64';
        case '2':
            return 'h-48';
        case '3':
            return selectedLayout.value === '3' ? 'h-48' : 'h-32';
        case '4':
            return 'h-32';
        case '5':
            return 'h-32';
        default:
            return 'h-48';
    }
});

// Función para manejar cambio de layout
const handleLayoutChange = () => {
    // Ajustar el número de imágenes según el layout
    const layoutImageCount = parseInt(selectedLayout.value);
    
    if (images.value.length < layoutImageCount) {
        // Agregar imágenes faltantes
        for (let i = images.value.length; i < layoutImageCount; i++) {
            images.value.push({ path: '', name: `image_${i + 1}` });
        }
    } else if (images.value.length > layoutImageCount) {
        // Remover imágenes excedentes
        images.value = images.value.slice(0, layoutImageCount);
    }
    
    emitImagesUpdated();
};

// Función para agregar imagen
const addImage = () => {
    if (images.value.length < props.maxImages) {
        images.value.push({ path: '', name: `image_${images.value.length + 1}` });
        emitImagesUpdated();
    }
};

// Función para remover imagen
const removeImage = (index) => {
    images.value.splice(index, 1);
    emitImagesUpdated();
};

// Función para manejar actualización de imagen
const handleImageUpdated = (data, index) => {
    if (index >= 0 && index < images.value.length) {
        images.value[index] = {
            path: data.path,
            name: data.name
        };
        emitImagesUpdated();
    }
};

// Función para emitir actualización de imágenes
const emitImagesUpdated = () => {
    emit('imagesUpdated', {
        section: props.section,
        layout: selectedLayout.value,
        images: images.value
    });
};

// Watch para cambios en las imágenes
watch(images, () => {
    emitImagesUpdated();
}, { deep: true });

// Inicializar con el layout por defecto
watch(() => props.currentImages, (newImages) => {
    images.value = [...newImages];
    if (images.value.length > 0) {
        selectedLayout.value = images.value.length.toString();
    }
}, { immediate: true });
</script> 