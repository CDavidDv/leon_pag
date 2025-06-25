<template>
    <div class="relative min-h-40 flex items-center justify-center">
        <!-- Imagen de fondo -->
        <div 
            v-if="heroImage" 
            class="absolute inset-0 z-0"
            :style="{ backgroundImage: `url(${getImageUrl(heroImage)})`, backgroundSize: 'cover', backgroundPosition: 'center' }"
        ></div>
        
        
        <div class="relative z-20 pt-40 flex transform scale-y-[0.75] justify-center max-w-4xl mx-auto items-center text-6xl font-extrabold lg:text-center px-10 text-white">
            {{ heroText }}
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps({
    heroImage: {
        type: String,
        default: ''
    }
});

const heroText = ref('WE ARE A BRAND AND MARKETING AGENCY THAT SOLVE PROBLEMS AND MAKE THINGS HAPPEN');

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

// Cargar texto desde la base de datos
const loadText = async () => {
    try {
        const response = await axios.get('/api/work-content/text-content');
        if (response.data.content && response.data.content.hero && response.data.content.hero.main_text) {
            heroText.value = response.data.content.hero.main_text.content || heroText.value;
        }
    } catch (error) {
        console.error('Error al cargar texto del hero:', error);
    }
};

onMounted(() => {
    loadText();
});
</script>

<style scoped>
    * {
        font-weight: 1000 !important;
        line-height: 1.1 !important;
    }
</style>