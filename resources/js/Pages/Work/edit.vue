<script setup>
import AppLayout from '@/Layouts/AppLayoutEdit.vue';
import ImgHero from '@/Components/Work/ImgHeroEdit.vue';
import Footer from '@/Components/Home/Footer.vue';
import Proyect from '@/Components/Work/Proyect.vue';
import FloatingButton from '@/Components/Home/FloatingButtonEdit.vue';
import { usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

const props = usePage().props;
const workContent = ref(props?.workContent || {});
const media = ref(props?.media || {});
const isEditing = ref(false);
const saving = ref(false);
const changesSaved = ref(false);

// Estado para las imágenes y videos
const heroImage = ref('');
const videoHero = ref('');
const galleryImages = ref([]);
const galleryImages2 = ref([]);
const marketingImages = ref([]);
const floatingButtonImage = ref(null);

// Estado para el contenido de texto
const textContent = ref({
    project_1: {
        title: 'SWISH FIBRE',
        description_1: 'Comprising several sets of yin and yang adverts, each playfully taps into a consumer pain-point such as online gaming, hybrid working and long-winded download and upload waiting times.',
        description_2: 'The campaign has subsequently led to Ofcom commissioning proposals to improve broadband information for consumers.'
    },
    project_2: {
        title: 'ACORA + GOOGLE CLOUD',
        description_1: 'We developed We have got your back and the two friendly giants at the heart of the campaign to literally stand up and above the noise. Every element of the campaign was designed to communicate the key benefits of their offering in a way that was playful, inventive and memeorable.'
    },
    footer: {
        footer_text: ''
    }
});

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

// Función para alternar el modo de edición
const toggleEditing = () => {
    isEditing.value = !isEditing.value;
};

// Función para obtener contenido de una sección
const getContent = (section, fieldName, defaultValue = '') => {
    return workContent.value[section]?.[fieldName]?.content || defaultValue;
};

// Función para obtener imagen de media
const getMediaImage = (section, name) => {
    const sectionMedia = media.value[section] || [];
    const image = sectionMedia.find(item => item.name === name);
    return image ? image.path : '';
};

// Función para manejar actualización de imagen
const handleImageUpdated = (data) => {
    console.log('Imagen actualizada:', data);
    // Actualizar el estado local
    if (data.section === 'work_hero' && data.name === 'hero') {
        heroImage.value = data.path;
    }
    
    // Mostrar notificación de cambios guardados
    changesSaved.value = true;
    setTimeout(() => {
        changesSaved.value = false;
    }, 3000);
};

// Función para manejar actualización de imagen del botón flotante (logo de la empresa)
const handleFloatingButtonImageUpdated = async (imageData) => {
    try {
        floatingButtonImage.value = imageData;
        // Mostrar notificación de cambios guardados
        changesSaved.value = true;
        setTimeout(() => {
            changesSaved.value = false;
        }, 3000);
    } catch (error) {
        console.error('Error al actualizar logo de la empresa:', error);
    }
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
        const response = await axios.post('/api/work-content/text', {
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
    return images.map(image => ({
        ...image,
        path: image.url || getImageUrl(image.path)
    }));
};

// Cargar datos multimedia
const cargarMultimedia = async () => {
    try {
        // Cargar contenido de texto desde WorkContent
        const workContentResponse = await axios.get('/api/work-content');
        if (workContentResponse.data.content) {
            workContent.value = workContentResponse.data.content;
        }
        if (workContentResponse.data.media) {
            media.value = workContentResponse.data.media;
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

        // Cargar imagen del botón flotante (logo de la empresa)
        const floatingButtonResponse = await axios.get('/api/media/images/floating_button');
        if (floatingButtonResponse.data.success && floatingButtonResponse.data.data.length > 0) {
            floatingButtonImage.value = floatingButtonResponse.data.data[0];
        }

        // Cargar imágenes de los proyectos
        for (let i = 1; i <= 9; i++) {
            const projectResponse = await axios.get(`/api/media/project/project_${i}`);
            if (projectResponse.data.success) {
                switch (i) {
                    case 1:
                        project1Images.value = projectResponse.data.data;
                        break;
                    case 2:
                        project2Images.value = projectResponse.data.data;
                        break;
                    case 3:
                        project3Images.value = projectResponse.data.data;
                        break;
                    case 4:
                        project4Images.value = projectResponse.data.data;
                        break;
                    case 5:
                        project5Images.value = projectResponse.data.data;
                        break;
                    case 6:
                        project6Images.value = projectResponse.data.data;
                        break;
                    case 7:
                        project7Images.value = projectResponse.data.data;
                        break;
                    case 8:
                        project8Images.value = projectResponse.data.data;
                        break;
                    case 9:
                        project9Images.value = projectResponse.data.data;
                        break;
                }
            }
        }
    } catch (error) {
        console.error('Error al cargar multimedia:', error);
    }
};

onMounted(() => {
    cargarMultimedia();
});

// Hero image
const heroImageComputed = computed(() => {
    return heroImage.value || getMediaImage('work_hero', 'hero') || 'https://placehold.co/400x600';
});

// Video/Media content
const mediaContent = computed(() => getContent('hero', 'media', 'https://www.youtube.com/embed/dQw4w9WgXcQ'));

</script>

<template>
    <AppLayout title="Work By Experience">
        <div>
            <!-- Botón de edición -->
            <div class="fixed top-20 right-8 z-50">
                <button 
                    @click="toggleEditing"
                    :class="[
                        'px-6 py-3 rounded-lg font-bold text-white transition-all duration-300 shadow-lg',
                        isEditing 
                            ? 'bg-red-600 hover:bg-red-700 border-2 border-red-400' 
                            : 'bg-blue-600 hover:bg-blue-700 border-2 border-blue-400'
                    ]"
                >
                    <div class="flex items-center gap-2">
                        <svg v-if="isEditing" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        {{ isEditing ? 'Salir Edición' : 'Editar Contenido' }}
                    </div>
                </button>
            </div>

            <!-- Notificación de cambios guardados -->
            <div 
                v-if="changesSaved" 
                class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg font-bold"
            >
                ✅ Cambios guardados
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

            <!-- Indicador de modo de edición -->
            <div 
                v-if="isEditing" 
                class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-yellow-500 text-black px-6 py-2 rounded-full shadow-lg font-bold"
            >
                🎨 MODO EDICIÓN ACTIVO
            </div>

            <!-- Indicador de modo de edición -->
            <div 
                v-if="isEditing" 
                class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-yellow-500 text-black px-6 py-2 rounded-full shadow-lg font-bold"
            >
                🎨 MODO EDICIÓN ACTIVO
            </div>

            <ImgHero :image="heroImageComputed" @image-updated="handleImageUpdated" /> 
            
            <!-- Proyecto 1 -->
            <Proyect
                project-id="project_1"
                :title="textContent.project_1.title"
                :link-text="getContent('project_1', 'link_text', 'SWISH FIBRE')"
                :link="getContent('project_1', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    textContent.project_1.description_1,
                    textContent.project_1.description_2
                ]"
                :images="project1Images"
                layout="dynamic"
                :is-editing="isEditing"
                :initial-title="textContent.project_1.title"
                :initial-description1="textContent.project_1.description_1"
                :initial-description2="textContent.project_1.description_2"
                @text-updated="handleTextUpdated"
            />
            
            <!-- Proyecto 2 -->
            <Proyect
                project-id="project_2"
                :title="textContent.project_2.title"
                :link-text="getContent('project_2', 'link_text', 'ACORA + GOOGLE CLOUD')"
                :link="getContent('project_2', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    textContent.project_2.description_1
                ]"
                :images="project2Images"
                layout="dynamic"
                :is-editing="isEditing"
                :initial-title="textContent.project_2.title"
                :initial-description1="textContent.project_2.description_1"
                @text-updated="handleTextUpdated"
            />

            <!-- Proyecto 3 -->
            <Proyect
                project-id="project_3"
                :title="getContent('project_3', 'title', 'NOMINET + SAMARITANS')"
                :link-text="getContent('project_3', 'link_text', 'NOMINET + SAMARITANS')"
                :link="getContent('project_3', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_3', 'description_1', 'By Experience arrived at the carefully crafted solution via a rigorous and iterative process, developing a design system and messaging framework to consider the demographics that would typically benefit from this innovative new online chat service.'),
                ]"
                :images="project3Images"
                layout="dynamic"
                :is-editing="isEditing"
            />

            <!-- Proyecto 4 -->
            <Proyect
                project-id="project_4"
                :title="getContent('project_4', 'title', 'SWISH FIBRE - BRANDING')"
                :link-text="getContent('project_4', 'link_text', 'SWISH FIBRE - BRANDING')"
                :link="getContent('project_4', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_4', 'description_1', 'Following an initial 18-month period where we provided full operational marketing support, we have continued to work with Swish on a diverse range of strategic projects.'),
                ]"
                :images="project4Images"
                layout="dynamic"
                :is-editing="isEditing"
            />

            <!-- Proyecto 5 -->
            <Proyect
                project-id="project_5"
                :title="getContent('project_5', 'title', 'EVRY 360')"
                :link-text="getContent('project_5', 'link_text', 'EVRY 360')"
                :link="getContent('project_5', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_5', 'description_1', 'The EVERY360 visual identity has gone on to help build a brand that is becoming synonymous with the right way to buy and sell property online.'),
                ]"
                :images="project5Images"
                layout="dynamic"
                :is-editing="isEditing"
            />

            <!-- Proyecto 6 -->
            <Proyect
                project-id="project_6"
                :title="getContent('project_6', 'title', 'SHAREDOWN')"
                :link-text="getContent('project_6', 'link_text', 'SHAREDOWN')"
                :link="getContent('project_6', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_6', 'description_1', 'Following their biggest year of growth to date in 2022, we continue to work closely with the team as they scale-up and gain market share in the UK and internationally.'),
                ]"
                :images="project6Images"
                layout="dynamic"
                :is-editing="isEditing"
            />

            <!-- Proyecto 7 -->
            <Proyect
                project-id="project_7"
                :title="getContent('project_7', 'title', 'WMUK')"
                :link-text="getContent('project_7', 'link_text', 'WMUK')"
                :link="getContent('project_7', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_7', 'description_1', 'By Experience arrived at the carefully crafted solution via a rigorous and iterative process, developing a design system and messaging framework to consider the demographics that would typically benefit from this innovative new online chat service.'),
                ]"
                :images="project7Images"
                layout="dynamic"
                :is-editing="isEditing"
            />

            <!-- Proyecto 8 -->
            <Proyect
                project-id="project_8"
                :title="getContent('project_8', 'title', 'SPARX')"
                :link-text="getContent('project_8', 'link_text', 'SPARX')"
                :link="getContent('project_8', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_8', 'description_1', 'By Experience arrived at the carefully crafted solution via a rigorous and iterative process, developing a design system and messaging framework to consider the demographics that would typically benefit from this innovative new online chat service.'),
                ]"
                :images="project8Images"
                layout="dynamic"
                :is-editing="isEditing"
            />

            <!-- Proyecto 9 -->
            <Proyect
                project-id="project_9"
                :title="getContent('project_9', 'title', 'NOMINET CYBER')"
                :link-text="getContent('project_9', 'link_text', 'NOMINET CYBER')"
                :link="getContent('project_9', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_9', 'description_1', 'By Experience arrived at the carefully crafted solution via a rigorous and iterative process, developing a design system and messaging framework to consider the demographics that would typically benefit from this innovative new online chat service.'),
                ]"
                :images="project9Images"
                layout="dynamic"
                :is-editing="isEditing"
            />

            <!-- Footer -->
            <Footer 
                :footer-text="textContent.footer.footer_text"
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

input, textarea {
    background: transparent;
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 8px;
    border-radius: 4px;
}

input:focus, textarea:focus {
    outline: none;
    border-color: white;
    background: rgba(255, 255, 255, 0.1);
}

input::placeholder, textarea::placeholder {
    color: rgba(255, 255, 255, 0.6);
}
</style>











