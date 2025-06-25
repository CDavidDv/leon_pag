<template>
    <div class="flex flex-col items-center justify-center py-16 max-w-4xl mx-auto">
        <h1 class="lg:text-7xl text-4xl font-extrabold transform scale-y-75 text-center">
            {{ headingText }}
        </h1>
        <p class="text-center lg:max-w-2xl max-w-3xl">
            {{ description1Text }}
        </p>
        <br>
        <p class="text-center max-w-2xl">
            {{ description2Text }}
        </p>
    </div>
</template>

<style scoped>
    p {
        font-family: 'New Times Roman', sans-serif;
        line-height: 1.8;
        font-weight: 100;
    }
</style>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const headingText = ref('WE MAKE LIGHT WORK OF WEIGHTY PROBLEMS');
const description1Text = ref('We make light work of weighty problems, without any of the traditional agency baggage which can slow things down and pile on the pounds. We solve any project type and challenge using our simple yet rigorous three-stage process. Whether you want to be fully hands-on or favour a more light-touch approach, you\'re the hero of the story. The three stages ensure we carefully progress your solution with transparency, giving you plenty of opportunity to shape and guide it as it evolves from the initial planning stage to launch and beyond.');
const description2Text = ref('It\'s been proven to work time and again, for any type of project and level of complexity. It helps maximise efficiency and accelerate timescales when required, without compromising on quality.');

// Cargar textos desde la base de datos
const loadTexts = async () => {
    try {
        const response = await axios.get('/api/work-content/text-content');
        if (response.data.content && response.data.content.problem) {
            if (response.data.content.problem.heading) {
                headingText.value = response.data.content.problem.heading.content || headingText.value;
            }
            if (response.data.content.problem.description1) {
                description1Text.value = response.data.content.problem.description1.content || description1Text.value;
            }
            if (response.data.content.problem.description2) {
                description2Text.value = response.data.content.problem.description2.content || description2Text.value;
            }
        }
    } catch (error) {
        console.error('Error al cargar textos del problem:', error);
    }
};

onMounted(() => {
    loadTexts();
});
</script>
