<template>
    <div class="fixed bottom-0 right-14 z-[9]">
        <div 
            class="size-60 bg-white rounded-full flex justify-center items-center cursor-pointer shadow-lg hover:shadow-xl transition-all duration-300" 
            @click="handleClick"
            @mouseenter="handleMouseEnter"
            @mouseleave="handleMouseLeave"
        >
            <!-- Imagen del botón flotante -->
            <img 
                v-if="floatingButtonImage && getImageUrl(floatingButtonImage)" 
                :src="getImageUrl(floatingButtonImage)" 
                :alt="'Botón flotante'"
                class="w-full h-full object-cover rounded-full transition-transform duration-300" 
                :class="{ 'scale-110': isHovered }"
                @error="handleImageError"
            />
            <!-- Icono por defecto si no hay imagen -->
            <svg 
                v-else 
                xmlns="http://www.w3.org/2000/svg" 
                class="size-6 text-gray-700" 
                viewBox="0 0 24 24" 
                fill="none" 
                stroke="currentColor" 
                stroke-width="2" 
                stroke-linecap="round" 
                stroke-linejoin="round"
            >
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    floatingButtonImage: {
        type: Object,
        default: null
    }
});

const emit = defineEmits(['showBarContact']);
const isHovered = ref(false);

console.log('FloatingButtonImage:', props.floatingButtonImage);

const getImageUrl = (image) => {
    if (!image) return null;
    
    // Si es un string (path directo), manejarlo
    if (typeof image === 'string') {
        if (image.startsWith('/storage/')) {
            return image;
        }
        if (image.startsWith('storage/')) {
            return '/' + image;
        }
        if (image.startsWith('http')) {
            return image;
        }
        if (image.startsWith('/')) {
            return image;
        }
        return `/storage/${image}`;
    }
    
    // Si es un objeto, verificar las propiedades
    if (typeof image === 'object') {
        // Verificar si tiene url (formato más reciente)
        if (image.url) {
            return image.url;
        }
        
        // Verificar si tiene path
        if (image.path) {
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
        }
    }
    
    // Si no tiene ni url ni path, retornar null
    return null;
};

// Función para manejar el clic en el botón flotante
const handleClick = () => {
    console.log('FloatingButton clicked!');
    emit('showBarContact');
};

// Función para manejar el hover
const handleMouseEnter = () => {
    isHovered.value = true;
};

const handleMouseLeave = () => {
    isHovered.value = false;
};

// Función para manejar errores de imagen
const handleImageError = (event) => {
    console.error('Error loading floating button image:', event);
    // Ocultar la imagen si hay error
    event.target.style.display = 'none';
};

console.log('Image URL:', getImageUrl(props.floatingButtonImage));
</script> 