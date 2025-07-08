<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Marketing from '@/Components/Home/Marketing.vue';
import Footer from '@/Components/Home/Footer.vue';
import FloatingButton from '@/Components/Home/FloatingButton.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const appLayoutRef = ref(null);

// Estado para las imágenes
const aboutImages = ref([]);
const teamImages = ref([]);
const backgroundImage = ref('');
const floatingButtonImage = ref(null);

// Estado para los textos dinámicos
const textContent = ref({
    marketing: {
        design_title: "DESIGN BY EXPERIENCE",
        marketing_title: "MARKETING BY EXPERIENCE",
        strategy_title: "STRATEGY BY EXPERIENCE",
        design_item_0: "Brand strategy",
        design_item_1: "Brand positioning",
        design_item_2: "Brand identity",
        design_item_3: "User Experience design",
        design_item_4: "User Interface design",
        design_item_5: "Website design",
        design_item_6: "Content marketing design",
        design_item_7: "Employee branding",
        design_item_8: "Motion design",
        marketing_item_0: "Marketing strategy",
        marketing_item_1: "Integrated marketing services",
        marketing_item_2: "Campaign design",
        marketing_item_3: "Content marketing",
        marketing_item_4: "Events design & marketing",
        marketing_item_5: "Social media content design",
        marketing_item_6: "Copywriting",
        marketing_item_7: "Lead generation",
        marketing_item_8: "Customer engagement",
        strategy_item_0: "Digital transformation",
        strategy_item_1: "New product development",
        strategy_item_2: "Value proposition design",
        strategy_item_3: "Product design",
        strategy_item_4: "Service design",
        strategy_item_5: "Brand consultancy",
        strategy_item_6: "Marketing consultancy",
        strategy_item_7: "Employee engagement"
    },
    footer: {
        footer_text: "© By Experience Ltd, 2024. Guardian House, 42 Preston New Rd, Blackburn BB2 6AH    All Rights Reserved | Company registered in England & Wales number: 11469161"
    }
});

// Estado para el contenido de texto de About
const aboutContent = ref({});

// Función para obtener contenido de una sección
const getContent = (section, fieldName, defaultValue = '') => {
    return aboutContent.value[section]?.[fieldName] || defaultValue;
};

const showBarContact = () => {
    if (appLayoutRef.value) {
        appLayoutRef.value.showBarContact();
    }
};

// Cargar datos multimedia
const cargarMultimedia = async () => {
    try {
        // Cargar imagen de fondo
        const bgResponse = await axios.get('/api/media/images/about_background');
        if (bgResponse.data.success && bgResponse.data.data.length > 0) {
            backgroundImage.value = bgResponse.data.data[0].path;
        }

        // Cargar imágenes de about
        const aboutResponse = await axios.get('/api/media/images/about');
        if (aboutResponse.data.success) {
            aboutImages.value = aboutResponse.data.data;
        }

        // Cargar imágenes del equipo
        const teamResponse = await axios.get('/api/media/images/team');
        if (teamResponse.data.success) {
            teamImages.value = teamResponse.data.data;
        }

        // Cargar imagen del botón flotante
        const floatingButtonResponse = await axios.get('/api/media/images/floating_button');
        if (floatingButtonResponse.data.success && floatingButtonResponse.data.data.length > 0) {
            floatingButtonImage.value = floatingButtonResponse.data.data[0];
        }
    } catch (error) {
        console.error('Error al cargar multimedia:', error);
    }
};

// Cargar textos desde la base de datos
const cargarTextos = async () => {
    try {
        // Cargar contenido de texto desde WorkContent
        const workContentResponse = await axios.get('/api/work-content');
        if (workContentResponse.data.content) {
            aboutContent.value = workContentResponse.data.content;
        }

        // Cargar textos de marketing, footer y about
        const response = await axios.get('/api/work-content/text-content');
        if (response.data.success) {
            // Actualizar el estado con los textos cargados
            Object.keys(response.data.content).forEach(section => {
                if (textContent.value[section]) {
                    Object.keys(response.data.content[section]).forEach(field => {
                        textContent.value[section][field] = response.data.content[section][field];
                    });
                }
            });
            
            // Cargar específicamente los textos de about
            if (response.data.content.about) {
                aboutContent.value.about = response.data.content.about;
            }
        }
    } catch (error) {
        console.error('Error al cargar textos:', error);
    }
};

onMounted(() => {
    cargarMultimedia();
    cargarTextos();
});
</script>

<template>
    <AppLayout title="Work By Experience" ref="appLayoutRef">
        <div class="w-full h-full flex flex-col"> 
            <!-- Contenido principal -->
            <div class="relative z-20">
           <div class="w-full lg:h-screen py-40 lg:py-0 flex flex-col justify-center items-center px-8">
               <h1 class="lg:text-7xl text-4xl max-w-2xl text-center font-extrabold transform scale-y-75">
                {{ getContent('about', 'title', 'MADE BY EXPERIENCE') }}
               </h1>
                    <p class="text-normal mb-10 max-w-xl text-center">{{ getContent('about', 'paragraph_1', 'Over twenty years of agency and client-side experience created a burning itch of curiosity so great that we simply had to scratch it.') }}</p>
                    <p class="text-normal mb-10 max-w-xl text-center">{{ getContent('about', 'paragraph_2', 'Having spent decades railing against mediocrity, vacuum-packed marketing and increasingly homogeneous brands, we wanted to create an agency that does things better and more in line with what matters most to our clients.') }}</p>
           </div>

           <div class="w-full lg:h-screen py-40 lg:py-0 flex flex-col justify-center items-center px-8">
               <h1 class="lg:text-7xl text-4xl max-w-3xl text-center font-extrabold transform scale-y-75">
                {{ getContent('about', 'section2_title', 'WHEN MONEY AND REPUTATION IS INVOLVED, IT\'S IMPORTANT YOU CHOOSE PEOPLE THAT FIERCELY PROTECT IT.') }}
               </h1>
                    <p class="text-normal mb-10 max-w-xl text-center">{{ getContent('about', 'section2_paragraph_1', 'As former Marketing and Creative Directors, our founders have walked similar paths to yours. Our hand-picked team represent the best in their chosen areas.') }}</p>
                    <p class="text-normal mb-10 max-w-xl text-center">{{ getContent('about', 'section2_paragraph_2', 'Together, we bring bags of experience to the table, who get to the heart of what you\'re looking to achieve with creative efficiency.') }}</p>
                    <p class="text-normal mb-10 max-w-xl text-center">{{ getContent('about', 'section2_paragraph_3', 'We think and act like the agency you want to engage with.') }}</p>
           </div>

                <!-- Galería de imágenes de About -->
                <div v-if="aboutImages.length > 0" class="w-full py-16 px-8">
                    <div class="max-w-6xl mx-auto">
                        
                    </div>
                </div>
           
           <div class="w-full lg:h-screen py-40 lg:py-0 flex flex-col justify-center items-center px-8">
               <h1 class="lg:text-7xl text-4xl max-w-3xl text-center font-extrabold transform scale-y-75 mb-5">
                {{ getContent('about', 'section3_title', 'WHY PEOPLE WORK WITH US') }}
               </h1>
                    <p class="text-normal mb-5 max-w-4xl text-center">{{ getContent('about', 'section3_paragraph_1', 'We produce strategic brand, marketing and creative work that bottles the team\'s collective experience and energy to deliver exceptional results at lightning pace.') }}</p>
                    <p class="text-normal mb-5 max-w-4xl text-center">{{ getContent('about', 'section3_paragraph_2', 'Whether we\'re creating a new or refreshed brand, revitalising your value proposition and product marketing, or launching an integrated marketing campaign, we consistently deliver the wow factor.') }}</p>
                    <p class="text-normal mb-5 max-w-4xl text-center">{{ getContent('about', 'section3_paragraph_3', 'We trade in FOMO. We create the glue for your every word, and the itch to engage with your brand.') }}</p>
                    <p class="text-normal mb-0 max-w-4xl text-center">{{ getContent('about', 'section3_paragraph_4', 'There\'s that itch again.') }}</p>
                </div>

                <!-- Galería de imágenes del equipo -->
                <div v-if="teamImages.length > 0" class="w-full py-16 px-8">
                    <div class="max-w-6xl mx-auto">
                        <h2 class="text-3xl font-bold text-center mb-8">NUESTRO EQUIPO</h2>
                    </div>
           </div>
            
           <div class="w-full lg:h-screen py-40 lg:py-0 flex flex-col justify-center items-center px-8">
            <h1 class="lg:text-7xl text-4xl max-w-3xl text-center font-extrabold transform scale-y-75 mb-5">
                {{ getContent('about', 'section4_title', 'ALWAYS HUNGRY. ALWAYS LEARNING. ALWAYS READY TO DELIVER.') }}
            </h1>
            </div>

            <Marketing 
                class="lg:mb-40 mx-4"
                :design-title="textContent.marketing.design_title"
                :marketing-title="textContent.marketing.marketing_title"
                :strategy-title="textContent.marketing.strategy_title"
                :design-items="[
                    textContent.marketing.design_item_0,
                    textContent.marketing.design_item_1,
                    textContent.marketing.design_item_2,
                    textContent.marketing.design_item_3,
                    textContent.marketing.design_item_4,
                    textContent.marketing.design_item_5,
                    textContent.marketing.design_item_6,
                    textContent.marketing.design_item_7,
                    textContent.marketing.design_item_8
                ]"
                :marketing-items="[
                    textContent.marketing.marketing_item_0,
                    textContent.marketing.marketing_item_1,
                    textContent.marketing.marketing_item_2,
                    textContent.marketing.marketing_item_3,
                    textContent.marketing.marketing_item_4,
                    textContent.marketing.marketing_item_5,
                    textContent.marketing.marketing_item_6,
                    textContent.marketing.marketing_item_7,
                    textContent.marketing.marketing_item_8
                ]"
                :strategy-items="[
                    textContent.marketing.strategy_item_0,
                    textContent.marketing.strategy_item_1,
                    textContent.marketing.strategy_item_2,
                    textContent.marketing.strategy_item_3,
                    textContent.marketing.strategy_item_4,
                    textContent.marketing.strategy_item_5,
                    textContent.marketing.strategy_item_6,
                    textContent.marketing.strategy_item_7
                ]"
            />
            <Footer :footer-text="textContent.footer.footer_text" />

            <FloatingButton 
                :floating-button-image="floatingButtonImage"
                @showBarContact="showBarContact"
            />
        </div>
        </div>
    </AppLayout>
</template>

<style>
* {
    color: #fff;
}
</style>