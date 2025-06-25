<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Hero from '@/Components/Home/Hero.vue';
import Video from '@/Components/Home/Video.vue';
import Services from '@/Components/Home/Services.vue';
import Slogan from '@/Components/Home/Slogan.vue';
import Gallery from '@/Components/Home/Gallery.vue';
import Gallery2 from '@/Components/Home/Gallery2.vue';
import SubHeading from '@/Components/Home/SubHeading.vue';
import Problem from '@/Components/Home/Problem.vue';
import LastSlogan from '@/Components/Home/LastSlogan.vue';
import Marketing from '@/Components/Home/Marketing.vue';
import Footer from '@/Components/Home/Footer.vue';
import FloatingButton from '@/Components/Home/FloatingButton.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';

const appLayoutRef = ref(null);

// Estado para los textos
const textContent = ref({
    hero: {
        main_text: 'WE ARE A BRAND AND MARKETING AGENCY THAT SOLVE PROBLEMS AND MAKE THINGS HAPPEN'
    },
    slogan: {
        main_text: 'WE CREATE EXPERIENCES THAT GET YOU NOTICED AND HELP YOU GROW'
    },
    subheading: {
        heading: 'WE PRODUCE THINGS THAT MAKE PEOPLE CLICK AND ENGAGE WITH YOUR BRAND',
        description: 'Our experience has built us an enviable reputation for consistently delivering the wow factor, underpinned with intelligent and thoughtful design that is focused on delivering a clear return on your investment.'
    },
    lastslogan: {
        heading: 'EVERYTHING WE DO IS MADE BY EXPERIENCE',
        description: 'We deliver results that surge with strategic magic, creative excellence and intelligent design.'
    },
    problem: {
        heading: 'WE MAKE LIGHT WORK OF WEIGHTY PROBLEMS',
        description1: 'We make light work of weighty problems, without any of the traditional agency baggage which can slow things down and pile on the pounds. We solve any project type and challenge using our simple yet rigorous three-stage process. Whether you want to be fully hands-on or favour a more light-touch approach, you\'re the hero of the story. The three stages ensure we carefully progress your solution with transparency, giving you plenty of opportunity to shape and guide it as it evolves from the initial planning stage to launch and beyond.',
        description2: 'It\'s been proven to work time and again, for any type of project and level of complexity. It helps maximise efficiency and accelerate timescales when required, without compromising on quality.'
    },
    services: {
        service1_title: 'BRAND<br/>STRATEGY',
        service1_description: 'Full strategy design and execution for new and refresh brand projects, including positioning, brand architecture, identity, comprehensive guidelines and training.',
        service2_title: 'PROPOSITION<br/>DESIGN',
        service2_description: 'Product and Service design for new and existing solutions, including value proposition, UX, UI, visual design and marketing support.',
        service3_title: 'CREATIVE<br/>MARKETING',
        service3_description: 'Marketing strategy, campaign activation, events and creative support for internal and external communications and employee engagement.',
        service4_title: 'ON-DEMAND<br/>SERVICES',
        service4_description: 'Full-stack brand, marketing and creative services to complement and support short and long-term requirements.'
    },
    layout: {
        contact_title: "LET'S WORK TOGETHER",
        contact_description: "We'd love to hear from you, whether you just want to shoot the breeze or discuss a potential opportunity to achieve great things together.",
        get_in_touch: "Get in touch",
        send_button: "Send"
    },
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

// Estado para las imágenes y videos
const heroImage = ref('');
const videoHero = ref('');
const galleryImages = ref([]);
const galleryImages2 = ref([]);
const marketingImages = ref([]);
const props = usePage().props
console.log('Props media welcome:', props.media.welcome[0])
const floatingButtonImage = ref(null);

const showBarContact = () => {
    if (appLayoutRef.value) {
        appLayoutRef.value.showBarContact();
    }
};

// Cargar datos multimedia
const cargarMultimedia = async () => {
    try {
        // Cargar imagen del hero
        const heroResponse = await axios.get('/api/media/images/hero');
        if (heroResponse.data.success && heroResponse.data.data.length > 0) {
            heroImage.value = heroResponse.data.data[0].path;
        }

        // Cargar video del hero
        const videoResponse = await axios.get('/api/media/videos/hero');
        if (videoResponse.data.success && videoResponse.data.data.length > 0) {
            videoHero.value = videoResponse.data.data[0].path;
        }

        // Cargar imágenes de galería 1
        const galleryResponse = await axios.get('/api/media/images/gallery');
        if (galleryResponse.data.success) {
            galleryImages.value = galleryResponse.data.data;
        }

        // Cargar imágenes de galería 2
        const galleryResponse2 = await axios.get('/api/media/images/gallery2');
        if (galleryResponse2.data.success) {
            galleryImages2.value = galleryResponse2.data.data;
        }

        // Cargar imágenes de marketing
        const marketingResponse = await axios.get('/api/media/images/marketing');
        if (marketingResponse.data.success) {
            marketingImages.value = marketingResponse.data.data;
        }

        // Cargar imagen del botón flotante
        const floatingButtonResponse = await axios.get('/api/media/images/floating_button');
        if (floatingButtonResponse.data.success && floatingButtonResponse.data.data.length > 0) {
            floatingButtonImage.value = floatingButtonResponse.data.data[0];
            console.log('Floating button image loaded:', floatingButtonImage.value);
        }
    } catch (error) {
        console.error('Error al cargar multimedia:', error);
    }
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
    <AppLayout title="Work By Experience" ref="appLayoutRef">
        <div>
            <Hero :hero-text="textContent.hero.main_text" :hero-image="heroImage" />    
            <Video :videoHero="videoHero" />
            <Services 
                :service1-title="textContent.services.service1_title"
                :service1-description="textContent.services.service1_description"
                :service2-title="textContent.services.service2_title"
                :service2-description="textContent.services.service2_description"
                :service3-title="textContent.services.service3_title"
                :service3-description="textContent.services.service3_description"
                :service4-title="textContent.services.service4_title"
                :service4-description="textContent.services.service4_description"
            />
            <Slogan :slogan-text="textContent.slogan.main_text" />
            <Gallery 
                :images="galleryImages" 
                section="gallery"
                title="Galería Principal"
                :is-editing="false"
            />
            <SubHeading 
                :heading="textContent.subheading.heading"
                :description="textContent.subheading.description"
            />
            <Gallery2 
                :images="galleryImages2" 
                section="gallery2"
                title="Galería Secundaria"
                :is-editing="false"
            />
            <Problem 
                :heading="textContent.problem.heading"
                :description1="textContent.problem.description1"
                :description2="textContent.problem.description2"
            />
            <LastSlogan 
                :heading="textContent.lastslogan.heading"
                :description="textContent.lastslogan.description"
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