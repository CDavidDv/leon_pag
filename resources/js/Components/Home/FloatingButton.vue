<template>
    <div class="fixed bottom-0 right-14">
        <div class="size-60 bg-white rounded-full flex justify-center items-center cursor-pointer" @click="handleClick">
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
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    floatingButtonImage: {
        type: Object,
        default: null
    }
});

console.log('FloatingButtonImage:', props.floatingButtonImage);

const emit = defineEmits(['showBarContact']);

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
    emit('showBarContact');
};

console.log('Image URL:', getImageUrl(props.floatingButtonImage));
</script> 