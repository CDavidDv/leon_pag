<script setup>
import AppLayout from '@/Layouts/AppLayoutEdit.vue';
import Hero from '@/Components/Home/HeroEdit.vue';
import Video from '@/Components/Home/VideoEdit.vue';
import Services from '@/Components/Home/ServicesEdit.vue';
import Slogan from '@/Components/Home/SloganEdit.vue';
import Gallery from '@/Components/Home/Gallery.vue';
import Gallery2 from '@/Components/Home/Gallery2.vue';
import SubHeading from '@/Components/Home/SubHeadingEdit.vue';
import Problem from '@/Components/Home/ProblemEdit.vue';
import LastSlogan from '@/Components/Home/LastSloganEdit.vue';
import Marketing from '@/Components/Home/MarketingEdit.vue';
import Footer from '@/Components/Home/FooterEdit.vue';
import FloatingButton from '@/Components/Home/FloatingButtonEdit.vue';
import TestImageUploader from '@/Components/TestImageUploader.vue';
import BackgroundColorEditor from '@/Components/BackgroundColorEditor.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const appLayoutRef = ref(null);

// Estado para el modo de edición
const isEditing = ref(false);
const changesSaved = ref(false);

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
const floatingButtonImage = ref(null);

// Función para alternar el modo de edición
const toggleEditing = () => {
    isEditing.value = !isEditing.value;
};

// Función para manejar actualización de textos
const handleTextUpdated = async (data) => {
    console.log('Texto actualizado:', data);
    
    try {
        // Actualizar el estado local
        if (!textContent.value[data.section]) {
            textContent.value[data.section] = {};
        }
        textContent.value[data.section][data.field] = data.value;
        
        // Guardar en la base de datos
        const response = await axios.post('/api/work-content/text-content', {
            section: data.section,
            field_name: data.field,
            content: data.value
        });
        
        if (response.data.success) {
            // Mostrar notificación de cambios guardados
            changesSaved.value = true;
            setTimeout(() => {
                changesSaved.value = false;
            }, 3000);
        }
    } catch (error) {
        console.error('Error al actualizar texto:', error);
    }
};

// Función para manejar actualización de imágenes de galería
const handleGalleryImagesUpdated = async (data) => {
    console.log('Imágenes de galería actualizadas:', data);
    
    // Si es una acción de eliminación
    if (data.action === 'delete') {
        if (data.section === 'gallery') {
            galleryImages.value = galleryImages.value.filter(img => img.id !== data.deletedImageId);
        } else if (data.section === 'gallery2') {
            galleryImages2.value = galleryImages2.value.filter(img => img.id !== data.deletedImageId);
        }
        
        // Mostrar notificación de cambios guardados
        changesSaved.value = true;
        setTimeout(() => {
            changesSaved.value = false;
        }, 3000);
        return;
    }
    
    // Si se envió un archivo directamente (desde el botón agregar)
    if (data.file) {
        try {
            const formData = new FormData();
            formData.append('image', data.file);
            formData.append('section', data.section);
            
            // Encontrar el siguiente índice disponible
            let nextIndex = 1;
            const existingImages = data.section === 'gallery' ? galleryImages.value : galleryImages2.value;
            const existingNames = existingImages.map(img => img.name);
            
            // Buscar el siguiente índice para imágenes
            while (existingNames.includes(`image_${nextIndex}`)) {
                nextIndex++;
            }
            
            formData.append('name', `image_${nextIndex}`);
            
            const response = await axios.post('/api/media/upload', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            
            if (response.data.success) {
                const newImage = {
                    id: response.data.data.id,
                    path: response.data.data.path,
                    url: response.data.data.url,
                    name: response.data.data.name,
                    type: 'image'
                };
                
                if (data.section === 'gallery') {
                    galleryImages.value.push(newImage);
                } else if (data.section === 'gallery2') {
                    galleryImages2.value.push(newImage);
                }
            }
        } catch (error) {
            console.error('Error al subir archivo:', error);
        }
    } else {
        // Actualizar el estado local según la sección (reemplazo)
        if (data.section === 'gallery') {
            if (data.action === 'replace') {
                if (data.image) {
                    galleryImages.value[data.imageIndex] = data.image;
                }
            } else if (data.action === 'add') {
                if (data.image) {
                    galleryImages.value.push(data.image);
                }
            }
        } else if (data.section === 'gallery2') {
            if (data.action === 'replace') {
                if (data.image) {
                    galleryImages2.value[data.imageIndex] = data.image;
                }
            } else if (data.action === 'add') {
                if (data.image) {
                    galleryImages2.value.push(data.image);
                }
            }
        }
    }
    
    // Mostrar notificación de cambios guardados
    changesSaved.value = true;
    setTimeout(() => {
        changesSaved.value = false;
    }, 3000);
};

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
            console.log('Props media welcome:', props.media.welcome[0])
            floatingButtonImage.value = ref(props.media.welcome[0].path);
        }
    } catch (error) {
        console.error('Error al cargar multimedia:', error);
    }
};

// Función para manejar actualización de imagen del hero
const handleHeroImageUpdated = async (imageData) => {
    console.log('Imagen del hero actualizada:', imageData);
    
    try {
        // Actualizar el estado local
        heroImage.value = imageData.url;
        
        // Mostrar notificación de cambios guardados
        changesSaved.value = true;
        setTimeout(() => {
            changesSaved.value = false;
        }, 3000);
    } catch (error) {
        console.error('Error al actualizar imagen del hero:', error);
    }
};

// Función para manejar actualización de imagen del botón flotante
const handleFloatingButtonImageUpdated = async (imageData) => {
    console.log('Imagen del botón flotante actualizada:', imageData);
    
    try {
        // Actualizar el estado local
        floatingButtonImage.value = imageData;
        
        // Mostrar notificación de cambios guardados
        changesSaved.value = true;
        setTimeout(() => {
            changesSaved.value = false;
        }, 3000);
    } catch (error) {
        console.error('Error al actualizar imagen del botón flotante:', error);
    }
};

// Función para manejar actualización del color de fondo
const handleBackgroundColorUpdated = (newColor) => {
    console.log('Color de fondo actualizado:', newColor);
    
    // Mostrar notificación de cambios guardados
    changesSaved.value = true;
    setTimeout(() => {
        changesSaved.value = false;
    }, 3000);
};

onMounted(() => {
    cargarMultimedia();
});

</script>

<template>
    <AppLayout 
        title="Work By Experience" 
        ref="appLayoutRef"
        :is-editing="isEditing"
        :initial-contact-title="textContent.layout.contact_title"
        :initial-contact-description="textContent.layout.contact_description"
        :initial-get-in-touch="textContent.layout.get_in_touch"
        :initial-send-button="textContent.layout.send_button"
        @text-updated="handleTextUpdated"
    >
        <div>
            <!-- Notificación de cambios guardados -->
            <div v-if="changesSaved" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Cambios guardados</span>
                </div>
            </div>

            <!-- Botón de edición -->
            <div class="fixed top-20 left-4 z-40">
                <button
                    @click="toggleEditing"
                    :class="[
                        'px-4 py-2 rounded-lg shadow-lg transition-all duration-300 flex items-center gap-2',
                        isEditing 
                            ? 'bg-red-500 hover:bg-red-600 text-white' 
                            : 'bg-blue-500 hover:bg-blue-600 text-white'
                    ]"
                >
                    <svg v-if="isEditing" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ isEditing ? 'Salir Edición' : 'Editar' }}
                </button>
            </div>

            <!-- Editor de color de fondo -->
            <BackgroundColorEditor 
                v-if="isEditing"
                :is-editing="isEditing"
                @background-color-updated="handleBackgroundColorUpdated"
            />

            <!-- Indicador de modo de edición -->
            <div 
                v-if="isEditing" 
                class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-yellow-500 text-black px-6 py-2 rounded-full shadow-lg font-bold"
            >
                🎨 MODO EDICIÓN ACTIVO
            </div>

            
            <Hero 
                :is-editing="isEditing"
                :hero-image="heroImage"
                :initial-text="textContent.hero.main_text"
                @text-updated="handleTextUpdated"
                @image-updated="handleHeroImageUpdated"
            />
            <Video :videoHero="videoHero" />
            <Services 
                :is-editing="isEditing"
                :initial-service1-title="textContent.services.service1_title"
                :initial-service1-description="textContent.services.service1_description"
                :initial-service2-title="textContent.services.service2_title"
                :initial-service2-description="textContent.services.service2_description"
                :initial-service3-title="textContent.services.service3_title"
                :initial-service3-description="textContent.services.service3_description"
                :initial-service4-title="textContent.services.service4_title"
                :initial-service4-description="textContent.services.service4_description"
                @text-updated="handleTextUpdated"
            />
            <Slogan 
                :is-editing="isEditing"
                :initial-text="textContent.slogan.main_text"
                @text-updated="handleTextUpdated"
            />
            <Gallery 
                :images="galleryImages" 
                section="gallery"
                title="Galería Principal"
                :is-editing="isEditing"
                @images-updated="handleGalleryImagesUpdated"
            />
            <SubHeading 
                :is-editing="isEditing"
                :initial-heading="textContent.subheading.heading"
                :initial-description="textContent.subheading.description"
                @text-updated="handleTextUpdated"
            />
            <Gallery2 
                :images="galleryImages2" 
                section="gallery2"
                title="Galería Secundaria"
                :is-editing="isEditing"
                @images-updated="handleGalleryImagesUpdated"
            />
            <Problem 
                :is-editing="isEditing"
                :initial-heading="textContent.problem.heading"
                :initial-description1="textContent.problem.description1"
                :initial-description2="textContent.problem.description2"
                @text-updated="handleTextUpdated"
            />
            <LastSlogan 
                :is-editing="isEditing"
                :initial-heading="textContent.lastslogan.heading"
                :initial-description="textContent.lastslogan.description"
                @text-updated="handleTextUpdated"
            />
            <Marketing 
                :images="marketingImages"
                :is-editing="isEditing"
                :initial-design-title="textContent.marketing.design_title"
                :initial-marketing-title="textContent.marketing.marketing_title"
                :initial-strategy-title="textContent.marketing.strategy_title"
                :initial-design-items="[
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
                :initial-marketing-items="[
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
                :initial-strategy-items="[
                    textContent.marketing.strategy_item_0,
                    textContent.marketing.strategy_item_1,
                    textContent.marketing.strategy_item_2,
                    textContent.marketing.strategy_item_3,
                    textContent.marketing.strategy_item_4,
                    textContent.marketing.strategy_item_5,
                    textContent.marketing.strategy_item_6,
                    textContent.marketing.strategy_item_7
                ]"
                @text-updated="handleTextUpdated"
            />
            <Footer 
                :is-editing="isEditing"
                :initial-footer-text="textContent.footer.footer_text"
                @text-updated="handleTextUpdated"
            />
            <FloatingButton 
                :is-editing="isEditing"
                :floating-button-image="floatingButtonImage"
                @image-updated="handleFloatingButtonImageUpdated"
            />
        </div>
    </AppLayout>
</template>

<style>
* {
    color: #fff;
}
</style>