<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ImgHero from '@/Components/Work/ImgHero.vue';
import Proyect from '@/Components/Work/Proyect.vue';
import Marketing from '@/Components/Home/Marketing.vue';
import Footer from '@/Components/Home/Footer.vue';
import FloatingButton from '@/Components/Home/FloatingButton.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';

// Estado para las imágenes y videos
const heroImage = ref('');
const videoHero = ref('');
const galleryImages = ref([]);
const galleryImages2 = ref([]);
const marketingImages = ref([]);
const floatingButtonImage = ref(null);

// Estado para el contenido de texto
const workContent = ref({});

// Estado para los textos dinámicos de Marketing y Footer
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

const props = usePage().props;
console.log(props)

// Estado para las imágenes de los proyectos
const project1Images = ref([]);
const project2Images = ref([]);
const project3Images = ref([]);
const project4Images = ref([]);
const project5Images = ref([]);
const project6Images = ref([]);
const project7Images = ref([]);
const project8Images = ref([]);
const project9Images = ref([]);

// Función para obtener contenido de una sección
const getContent = (section, fieldName, defaultValue = '') => {
    return workContent.value[section]?.[fieldName]?.content || defaultValue;
};

// Función para obtener la URL correcta de la imagen
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

// Función para procesar un array de imágenes
const processImages = (images) => {
    if (!images || !Array.isArray(images)) return [];
    return images
        .filter(image => image && (image.url || image.path)) // Filtrar imágenes vacías
        .map(image => ({
            ...image,
            path: image.url || getImageUrl(image.path)
        }));
};
const appLayoutRef = ref(null);
// Función para mostrar el bar de contacto
const showBarContact = () => {
    console.log('showBarContact called from Work index');
    console.log('appLayoutRef.value:', appLayoutRef.value);
    
    if (appLayoutRef.value) {
        console.log('Calling appLayoutRef.value.showBarContact()');
        appLayoutRef.value.showBarContact();
    } else {
        console.error('appLayoutRef.value is null or undefined');
    }
};
// Cargar datos multimedia
const cargarMultimedia = async () => {
    try {
        // Cargar contenido de texto desde WorkContent
        const workContentResponse = await axios.get('/api/work-content');
        if (workContentResponse.data.content) {
            workContent.value = workContentResponse.data.content;
        }

        // Cargar imagen del hero
        const heroResponse = await axios.get('/api/media/images/work_hero');
        if (heroResponse.data.success && heroResponse.data.data.length > 0) {
            heroImage.value = heroResponse.data.data[0].url || getImageUrl(heroResponse.data.data[0].path);
        }

        // Cargar video del hero
        const videoResponse = await axios.get('/api/media/videos/hero');
        if (videoResponse.data.success && videoResponse.data.data.length > 0) {
            videoHero.value = videoResponse.data.data[0].url || getImageUrl(videoResponse.data.data[0].path);
        }

        // Cargar imágenes de galería 1
        const galleryResponse = await axios.get('/api/media/images/gallery');
        if (galleryResponse.data.success) {
            galleryImages.value = processImages(galleryResponse.data.data);
        }

        // Cargar imágenes de galería 2
        const galleryResponse2 = await axios.get('/api/media/images/gallery2');
        if (galleryResponse2.data.success) {
            galleryImages2.value = processImages(galleryResponse2.data.data);
        }

        // Cargar imágenes de marketing
        const marketingResponse = await axios.get('/api/media/images/marketing');
        if (marketingResponse.data.success) {
            marketingImages.value = processImages(marketingResponse.data.data);
        }

        // Cargar imagen del botón flotante
        const floatingButtonResponse = await axios.get('/api/media/images/floating_button');
        if (floatingButtonResponse.data.success && floatingButtonResponse.data.data.length > 0) {
            floatingButtonImage.value = floatingButtonResponse.data.data[0];
        }

        // Cargar imágenes de los proyectos
        for (let i = 1; i <= 9; i++) {
            const projectResponse = await axios.get(`/api/media/project/project_${i}`);
            console.log(`Cargando imágenes del proyecto ${i}:`, projectResponse.data);
            if (projectResponse.data.success) {
                const processedImages = processImages(projectResponse.data.data);
                console.log(`Imágenes procesadas del proyecto ${i}:`, processedImages);
                switch (i) {
                    case 1:
                        project1Images.value = processedImages;
                        break;
                    case 2:
                        project2Images.value = processedImages;
                        break;
                    case 3:
                        project3Images.value = processedImages;
                        break;
                    case 4:
                        project4Images.value = processedImages;
                        break;
                    case 5:
                        project5Images.value = processedImages;
                        break;
                    case 6:
                        project6Images.value = processedImages;
                        break;
                    case 7:
                        project7Images.value = processedImages;
                        break;
                    case 8:
                        project8Images.value = processedImages;
                        break;
                    case 9:
                        project9Images.value = processedImages;
                        break;
                }
            }
        }
    } catch (error) {
        console.error('Error al cargar multimedia:', error);
    }
    
    // Log final para verificar el estado de las imágenes
    console.log('Estado final de las imágenes de proyectos:', {
        project1: project1Images.value,
        project2: project2Images.value,
        project3: project3Images.value,
        project4: project4Images.value,
        project5: project5Images.value,
        project6: project6Images.value,
        project7: project7Images.value,
        project8: project8Images.value,
        project9: project9Images.value
    });
};

// Cargar textos desde la base de datos
const cargarTextos = async () => {
    try {
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
    <AppLayout title="dciimpresiones" ref="appLayoutRef">
        <div>
            <ImgHero :image="heroImage || 'https://placehold.co/400x600'" />
            
            <!-- Proyecto 1 -->
            <Proyect
                project-id="project_1"
                :title="getContent('project_1', 'title', 'CAMPAIGN AGAINST FAKE FIBRE')"
                :link-text="getContent('project_1', 'link_text', 'SWISH FIBRE')"
                :link="getContent('project_1', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_1', 'description_1', 'A disruptive wide-scale public interest campaign to alert consumers to the major performance differences between speed-sapping copper-mix \'Fibre Broadband\' and the superior capabilities of 100% fibre-optic alternatives known as Full Fibre.'),
                    getContent('project_1', 'description_2', 'Comprising several sets of \'yin and yang\' adverts, each playfully taps into a consumer pain-point such as online gaming, hybrid working and long-winded download and upload waiting times.'),
                    getContent('project_1', 'description_3', 'The campaign has subsequently led to Ofcom commissioning proposals to improve broadband information for consumers.')
                ]"
                :images="project1Images"
                layout="dynamic"
            />
  
            
            <!-- Proyecto 2 -->
            <Proyect
                project-id="project_2"
                :title="getContent('project_2', 'title', 'STANDING ON THE SHOULDERS OF GIANTS')"
                :link-text="getContent('project_2', 'link_text', 'ACORA + GOOGLE CLOUD')"
                :link="getContent('project_2', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_2', 'description_1', 'Acora (formerly Secrutiny) and Google were looking for an integrated campaign to help their products, services and vision to stand out within the crowded cyber security space.'),
                    getContent('project_2', 'description_2', 'We developed We have got your back and the two friendly giants at the heart of the campaign to literally stand up and above the noise. Every element of the campaign was designed to communicate the key benefits of their offering in a way that was playful, inventive and memeorable.')
                ]"
                :images="project2Images"
                layout="dynamic"
            />

            <!-- Proyecto 3 -->
            <Proyect
                project-id="project_3"
                :title="getContent('project_3', 'title', 'OPENING NEW LINES OF COMMUNICATION')"
                :link-text="getContent('project_3', 'link_text', 'NOMINET + SAMARITANS')"
                :link="getContent('project_3', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_3', 'description_1', 'A powerful co-designed multimedia advertising campaign underwritten by Nominet, the initiative raised £150,216 for Samaritans, more than 5% over the forecast, with reach of over 12 million over a six week period.'),
                    getContent('project_3', 'description_2', 'By Experience arrived at the carefully crafted solution via a rigorous and iterative process, developing a design system and messaging framework to consider the demographics that would typically benefit from this innovative new online chat service.')
                ]"
                :images="project3Images"
                layout="dynamic"
            />

            <!-- Proyecto 4 -->
            <Proyect
                project-id="project_4"
                :title="getContent('project_4', 'title', 'CREATING A BRAND THAT GOES BEYOND BROADBAND')"
                :link-text="getContent('project_4', 'link_text', 'SWISH FIBRE - BRANDING')"
                :link="getContent('project_4', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_4', 'description_1', 'Have you ever worked with a client that was simply an idea and didn\'t technically exist as a business in the truest sense?'),
                    getContent('project_4', 'description_2', 'The Swish founding team approached us in 2018 to help build a brand, marketing plans and compelling story to support their pending investment.'),
                    getContent('project_4', 'description_3', 'They needed a brand that was distinctive and fresh to achieve start-up status, while possessing the hallmarks of a more established to support subsequent scaling up.'),
                    getContent('project_4', 'description_4', 'Today, Swish is part of the Octopus Group and has unlocked in excess of £250m investment to establish a growing Full Fibre broadband network across South East England.'),
                    getContent('project_4', 'description_5', 'Following an initial 18-month period where we provided full operational marketing support, we have continued to work with Swish on a diverse range of strategic projects.')
                ]"
                :images="project4Images"
                layout="dynamic"
            />

            <!-- Proyecto 5 -->
            <Proyect
                project-id="project_5"
                :title="getContent('project_5', 'title', 'A BRAND THAT FINDS YOUR HAPPY PLACE')"
                :link-text="getContent('project_5', 'link_text', 'EVRY 360')"
                :link="getContent('project_5', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_5', 'description_1', 'A disruptive wide-scale public interest campaign to alert consumers to the major performance differences between speed-sapping copper-mix Fibre Broadband and the superior capabilities of 100% fibre-optic alternatives known as Full Fibre.EVRY360 came to By Experience to develop a strong, unique brand to help establish itself as the platform leader for enabling a superior home selling and buying experience for agents and their customers alike.'),
                    getContent('project_5', 'description_2', 'Like all great brand-marks, the EVRY360 identity is iconic and unmistakably it\'s own. It was tested and chosen for it\'s stand-out appeal and avoidance of typical VR tropes.'),
                    getContent('project_5', 'description_3', 'The EVERY360 visual identity has gone on to help build a brand that is becoming synonymous with the right way to buy and sell property online.')
                ]"
                :images="project5Images"
                layout="dynamic"
            />

            <!-- Proyecto 6 -->
            <Proyect
                project-id="project_6"
                :title="getContent('project_6', 'title', 'A BRAND TO SHARE AND DO MORE')"
                :link-text="getContent('project_6', 'link_text', 'SHAREDOWN')"
                :link="getContent('project_6', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_6', 'description_1', 'Sharedo is a legal case management platform that enables lawyers to achieve superhuman results. It creates more time by making light work of countless daily tasks, leaving you laser-focused on delivering the best outcomes for your clients.'),
                    getContent('project_6', 'description_2', 'In addition to creating this new way of talking about their exciting legal technology platform that you\'ve just read, we support Sharedo\'s ongoing brand and marketing needs. Since late 2021, we have undertaken a complete overall of their brand, positioning, online experience, social media and ongoing channel management.'),
                    getContent('project_6', 'description_3', 'Following their biggest year of growth to date in 2022, we continue to work closely with the team as they scale-up and gain market share in the UK and internationally.')
                ]"
                :images="project6Images"
                layout="dynamic"
            />

            <!-- Proyecto 7 -->
            <Proyect
                project-id="project_7"
                :title="getContent('project_7', 'title', 'A BRAND TO BUILD A COMMUNITY AND HELP PEOPLE LIVE WELL')"
                :link-text="getContent('project_7', 'link_text', 'WMUK')"
                :link="getContent('project_7', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_7', 'description_1', 'WMUK is a very special charity and community of people that are living well with a rare blood cancer that directly affects around 4,000 in the UK today.'),
                    getContent('project_7', 'description_2', 'We\'ve been working closely with the team to refresh their brand strategy, story, look, feel and online experience so that it better reflects its values and trusted voice of WM in the UK.'),
                    getContent('project_7', 'description_3', 'Reconstructing the brand from the ground up - from the logo and distinctive yellow scenarios through to communications - the online experience supports the WM community wherever they are on their journey.')
                ]"
                :images="project7Images"
                layout="dynamic"
            />

            <!-- Proyecto 8 -->
            <Proyect
                project-id="project_8"
                :title="getContent('project_8', 'title', 'A BRAND THAT IS ALWAYS LEARNING')"
                :link-text="getContent('project_8', 'link_text', 'SPARX LEARNING')"
                :link="getContent('project_8', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_8', 'description_1', 'Sparx Learning is on a mission to improve the life opportunities, of five million learners worldwide by 2030.'),
                    getContent('project_8', 'description_2', 'We\'ve been on that journey with them since 2018, during which time we\'ve worked closely with the team to position, launch and promote an ever-growing portfolio of learning products and services.'),
                    getContent('project_8', 'description_3', 'Most recently, we undertook a major brand review of its architecture and brand systems to better reflect and organise its portfolio, while ensuring they can continue to grow within this new strategic framework.')
                ]"
                :images="project8Images"
                layout="dynamic"
            />

            <!-- Proyecto 9 -->
            <Proyect
                project-id="project_9"
                :title="getContent('project_9', 'title', 'ADVERTISING WITH ADDED SWAGGER')"
                :link-text="getContent('project_9', 'link_text', 'NOMINET CYBER')"
                :link="getContent('project_9', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_9', 'description_1', 'We were approached by the Nominet team to develop a diverse range of advertising concepts to help their services stand out and disrupt the sea of homogeneous marketing occurring in the industry at the time.'),
                    getContent('project_9', 'description_2', 'A set of 25 concepts were chosen to be fully realised and extensively tested, with many going on to be rolled out across social media, ABM initiatives and international events.')
                ]"
                :images="project9Images"
                layout="dynamic"
            />
            
            <Marketing 
                :images="marketingImages"
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
                :is-editing="false"
                :floating-button-image="floatingButtonImage"
                @showBarContact="showBarContact"
            />
        </div>
    </AppLayout>
</template>

<style>
* {
    color: #fff;
}
</style>