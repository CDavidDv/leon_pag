<template>
    <div class="flex flex-col items-center justify-center py-16 max-w-3xl mx-auto">
        <h1 class="lg:text-7xl text-4xl font-extrabold transform scale-y-75 text-center">
            {{ headingText }}
        </h1>
        <p class="text-center">
            {{ descriptionText }}
        </p>
    </div>
</template>

<style scoped>
    h1 {
        line-height: 1.2;
    }
    p {
        font-family: 'New Times Roman', sans-serif;
        line-height: 1.8;
        font-weight: 100;
    }
</style>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const headingText = ref('EVERYTHING WE DO IS MADE BY EXPERIENCE');
const descriptionText = ref('We deliver results that surge with strategic magic, creative excellence and intelligent design.');

// Cargar textos desde la base de datos
const loadTexts = async () => {
    try {
        const response = await axios.get('/api/work-content/text-content');
        if (response.data.content) {
            if (response.data.content.lastslogan && response.data.content.lastslogan.heading) {
                headingText.value = response.data.content.lastslogan.heading.content || headingText.value;
            }
            if (response.data.content.lastslogan && response.data.content.lastslogan.description) {
                descriptionText.value = response.data.content.lastslogan.description.content || descriptionText.value;
            }
        }
    } catch (error) {
        console.error('Error al cargar textos del last slogan:', error);
    }
};

onMounted(() => {
    loadTexts();
});
</script>

