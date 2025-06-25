<template>
    <div class="grid lg:grid-cols-4  gap-8 lg:items-center items-start lg:justify-center justify-start lg:pt-32   px-8">
        <div class="lg:text-center lg:justify-center justify-start lg:items-center items-start flex flex-col">
            <h3 class=" font-extrabold stroke-2 stroke-white mb-4 text-2xl transform scale-y-75" v-html="service1Title">
            </h3>
            <p class="text-sm lg:w-4/5 pr-10 lg:pr-0">
                {{ service1Description }}
            </p>
        </div>
        <div class="lg:justify-center justify-start lg:items-center items-start flex flex-col">
            <h3 class=" font-extrabold stroke-2 stroke-white mb-4 text-2xl transform scale-y-75" v-html="service2Title">
            </h3>
            <p class="text-sm">
                {{ service2Description }}
            </p>
        </div>
        <div class="lg:justify-center justify-start lg:items-center items-start flex flex-col">
            <h3 class=" font-extrabold stroke-2 stroke-white mb-4 text-2xl transform scale-y-75" v-html="service3Title">
            </h3>
            <p class="text-sm">
                {{ service3Description }}
            </p>
        </div>
        <div class="lg:justify-center justify-start lg:items-center items-start flex flex-col">
            <h3 class=" font-extrabold stroke-2 stroke-white mb-4 text-2xl transform scale-y-75" v-html="service4Title">
            </h3>
            <p class="text-sm">
                {{ service4Description }}
            </p>
        </div>
    </div>
</template>

<style scoped>
p {
    font-size: 1.1rem;
    font-weight: 400;
    font-family: 'New Times Roman', serif;
}

</style>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const service1Title = ref('BRAND<br/>STRATEGY');
const service1Description = ref('Full strategy design and execution for new and refresh brand projects, including positioning, brand architecture, identity, comprehensive guidelines and training.');
const service2Title = ref('PROPOSITION<br/>DESIGN');
const service2Description = ref('Product and Service design for new and existing solutions, including value proposition, UX, UI, visual design and marketing support.');
const service3Title = ref('CREATIVE<br/>MARKETING');
const service3Description = ref('Marketing strategy, campaign activation, events and creative support for internal and external communications and employee engagement.');
const service4Title = ref('ON-DEMAND<br/>SERVICES');
const service4Description = ref('Full-stack brand, marketing and creative services to complement and support short and long-term requirements.');

// Cargar textos desde la base de datos
const loadTexts = async () => {
    try {
        const response = await axios.get('/api/work-content/text-content');
        if (response.data.content && response.data.content.services) {
            if (response.data.content.services.service1_title) {
                service1Title.value = response.data.content.services.service1_title.content || service1Title.value;
            }
            if (response.data.content.services.service1_description) {
                service1Description.value = response.data.content.services.service1_description.content || service1Description.value;
            }
            if (response.data.content.services.service2_title) {
                service2Title.value = response.data.content.services.service2_title.content || service2Title.value;
            }
            if (response.data.content.services.service2_description) {
                service2Description.value = response.data.content.services.service2_description.content || service2Description.value;
            }
            if (response.data.content.services.service3_title) {
                service3Title.value = response.data.content.services.service3_title.content || service3Title.value;
            }
            if (response.data.content.services.service3_description) {
                service3Description.value = response.data.content.services.service3_description.content || service3Description.value;
            }
            if (response.data.content.services.service4_title) {
                service4Title.value = response.data.content.services.service4_title.content || service4Title.value;
            }
            if (response.data.content.services.service4_description) {
                service4Description.value = response.data.content.services.service4_description.content || service4Description.value;
            }
        }
    } catch (error) {
        console.error('Error al cargar textos de services:', error);
    }
};

onMounted(() => {
    loadTexts();
});
</script>