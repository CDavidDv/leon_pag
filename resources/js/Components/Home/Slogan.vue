<template>
    <div class="flex flex-col items-center justify-center py-32 max-w-2xl mx-auto">
        <h1 class="lg:text-6xl text-4xl font-extrabold transform scale-y-75 text-center">
            {{ sloganText }}
        </h1>
    </div>
</template>

<style scoped>

</style>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const sloganText = ref('WE CREATE EXPERIENCES THAT GET YOU NOTICED AND HELP YOU GROW');

// Cargar texto desde la base de datos
const loadText = async () => {
    try {
        const response = await axios.get('/api/work-content/text-content');
        if (response.data.content && response.data.content.slogan && response.data.content.slogan.main_text) {
            sloganText.value = response.data.content.slogan.main_text.content || sloganText.value;
        }
    } catch (error) {
        console.error('Error al cargar texto del slogan:', error);
    }
};

onMounted(() => {
    loadText();
});
</script>

