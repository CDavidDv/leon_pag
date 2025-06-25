<template>
    <div class="flex flex-col items-center justify-center py-16 max-w-4xl mx-auto">
        <h1 class="lg:text-7xl text-4xl font-extrabold transform scale-y-75 text-center">
            {{ headingText }}
        </h1>
        <p class="text-center max-w-lg">
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

const headingText = ref('WE PRODUCE THINGS THAT MAKE PEOPLE CLICK AND ENGAGE WITH YOUR BRAND');
const descriptionText = ref('Our experience has built us an enviable reputation for consistently delivering the wow factor, underpinned with intelligent and thoughtful design that is focused on delivering a clear return on your investment.');

// Cargar textos desde la base de datos
const loadTexts = async () => {
    try {
        const response = await axios.get('/api/work-content/text-content');
        if (response.data.content) {
            if (response.data.content.subheading && response.data.content.subheading.heading) {
                headingText.value = response.data.content.subheading.heading.content || headingText.value;
            }
            if (response.data.content.subheading && response.data.content.subheading.description) {
                descriptionText.value = response.data.content.subheading.description.content || descriptionText.value;
            }
        }
    } catch (error) {
        console.error('Error al cargar textos del subheading:', error);
    }
};

onMounted(() => {
    loadTexts();
});
</script>

