<script setup>
import AppLayout from '@/Layouts/AppLayoutEdit.vue';
import ImgHero from '@/Components/Work/ImgHeroEdit.vue';
import VideoEdit from '@/Components/Home/VideoEdit.vue';
import Marketing from '@/Components/Home/Marketing.vue';
import Footer from '@/Components/Home/Footer.vue';
import ProjectImageEditor from '@/Components/Work/ProjectImageEditor.vue';
import Proyect from '@/Components/Work/Proyect.vue';
import TestImage from '@/Components/TestImage.vue';
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

// Función para manejar actualización de imágenes de proyectos
const handleProjectImagesUpdated = (data) => {
    console.log('Imágenes de proyecto actualizadas:', data);
    
    // Actualizar el estado local según el proyecto
    switch (data.section) {
        case 'project_1':
            project1Images.value = data.images;
            break;
        case 'project_2':
            project2Images.value = data.images;
            break;
        case 'project_3':
            project3Images.value = data.images;
            break;
        case 'project_4':
            project4Images.value = data.images;
            break;
        case 'project_5':
            project5Images.value = data.images;
            break;
        case 'project_6':
            project6Images.value = data.images;
            break;
        case 'project_7':
            project7Images.value = data.images;
            break;
        case 'project_8':
            project8Images.value = data.images;
            break;
        case 'project_9':
            project9Images.value = data.images;
            break;
    }
    
    // Mostrar notificación de cambios guardados
    changesSaved.value = true;
    setTimeout(() => {
        changesSaved.value = false;
    }, 3000);
};

// Función para actualizar texto
const updateText = async (section, fieldName, newValue) => {
    try {
        saving.value = true;
        changesSaved.value = false;
        const response = await axios.post('/api/work-content/text', {
            section,
            field_name: fieldName,
            content: newValue
        });
        
        if (response.data.success) {
            if (!workContent.value[section]) {
                workContent.value[section] = {};
            }
            if (!workContent.value[section][fieldName]) {
                workContent.value[section][fieldName] = {};
            }
            workContent.value[section][fieldName].content = newValue;
            
            // Mostrar notificación de cambios guardados
            changesSaved.value = true;
            setTimeout(() => {
                changesSaved.value = false;
            }, 3000);
        }
    } catch (error) {
        console.error('Error al actualizar texto:', error);
    } finally {
        saving.value = false;
    }
};

// Función para actualizar imagen
const updateImage = async (section, fieldName, file) => {
    try {
        saving.value = true;
        changesSaved.value = false;
        const formData = new FormData();
        formData.append('section', section);
        formData.append('field_name', fieldName);
        formData.append('image', file);

        const response = await axios.post('/api/work-content/image', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        if (response.data.success) {
            if (!workContent.value[section]) {
                workContent.value[section] = {};
            }
            if (!workContent.value[section][fieldName]) {
                workContent.value[section][fieldName] = {};
            }
            workContent.value[section][fieldName].content = response.data.url;
            
            // Mostrar notificación de cambios guardados
            changesSaved.value = true;
            setTimeout(() => {
                changesSaved.value = false;
            }, 3000);
        }
    } catch (error) {
        console.error('Error al actualizar imagen:', error);
    } finally {
        saving.value = false;
    }
};

// Función para actualizar enlace
const updateLink = async (section, fieldName, newValue) => {
    try {
        saving.value = true;
        changesSaved.value = false;
        const response = await axios.post('/api/work-content/link', {
            section,
            field_name: fieldName,
            content: newValue
        });
        
        if (response.data.success) {
            if (!workContent.value[section]) {
                workContent.value[section] = {};
            }
            if (!workContent.value[section][fieldName]) {
                workContent.value[section][fieldName] = {};
            }
            workContent.value[section][fieldName].content = newValue;
            
            // Mostrar notificación de cambios guardados
            changesSaved.value = true;
            setTimeout(() => {
                changesSaved.value = false;
            }, 3000);
        }
    } catch (error) {
        console.error('Error al actualizar enlace:', error);
    } finally {
        saving.value = false;
    }
};

// Función para manejar actualización de imagen del botón flotante
const handleFloatingButtonImageUpdated = async (imageData) => {
    try {
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

// Función para manejar cambio de imagen
const handleImageChange = (event, section, fieldName) => {
    const file = event.target.files[0];
    if (file) {
        updateImage(section, fieldName, file);
    }
};

// Función para manejar cambio de texto
const handleTextChange = (event, section, fieldName) => {
    const newValue = event.target.value;
    updateText(section, fieldName, newValue);
};

// Función para manejar cambio de enlace
const handleLinkChange = (event, section, fieldName) => {
    const newValue = event.target.value;
    updateLink(section, fieldName, newValue);
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

        // Cargar imagen del botón flotante
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

// Función para manejar actualización de imagen individual de proyecto
const handleProjectImageUpdated = async (data) => {
    console.log('Imagen de proyecto actualizada:', data);
    
    // Si es una acción de eliminación
    if (data.action === 'delete') {
        const projectImages = getProjectImagesArray(data.projectId);
        if (projectImages) {
            // Eliminar la imagen del array local
            projectImages.value = projectImages.value.filter(img => img.id !== data.deletedImageId);
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
            const isVideo = data.type === 'video';
            const projectImages = getProjectImagesArray(data.projectId);
            
            // Encontrar el siguiente índice disponible
            let nextIndex = 1;
            const existingNames = projectImages ? projectImages.value.map(img => img.name) : [];
            
            if (isVideo) {
                // Buscar el siguiente índice para videos
                while (existingNames.includes(`video_${nextIndex}`)) {
                    nextIndex++;
                }
                formData.append('video', data.file);
                formData.append('section', data.projectId);
                formData.append('name', `video_${nextIndex}`);
                
                const response = await axios.post('/api/media/upload-video', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                
                if (response.data.success) {
                    if (projectImages) {
                        projectImages.value.push({
                            id: response.data.data.id,
                            path: response.data.data.path,
                            url: response.data.data.url,
                            name: response.data.data.name,
                            type: 'video'
                        });
                    }
                }
            } else {
                // Buscar el siguiente índice para imágenes
                while (existingNames.includes(`image_${nextIndex}`)) {
                    nextIndex++;
                }
                formData.append('image', data.file);
                formData.append('section', data.projectId);
                formData.append('name', `image_${nextIndex}`);
                
                const response = await axios.post('/api/media/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                
                if (response.data.success) {
                    if (projectImages) {
                        projectImages.value.push({
                            id: response.data.data.id,
                            path: response.data.data.path,
                            url: response.data.data.url,
                            name: response.data.data.name,
                            type: 'image'
                        });
                    }
                }
            }
        } catch (error) {
            console.error('Error al subir archivo:', error);
        }
    } else {
        // Actualizar el estado local según el proyecto (reemplazo)
        const projectImages = getProjectImagesArray(data.projectId);
        if (projectImages) {
            if (data.action === 'replace') {
                // Reemplazar la imagen existente
                if (data.image) {
                    projectImages.value[data.imageIndex] = data.image;
                }
                if (data.video) {
                    projectImages.value[data.imageIndex] = data.video;
                }
            } else if (data.action === 'add') {
                // Agregar nueva imagen al final del array
                if (data.image) {
                    projectImages.value.push(data.image);
                }
                if (data.video) {
                    projectImages.value.push(data.video);
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

// Función para obtener el array de imágenes del proyecto
const getProjectImagesArray = (projectId) => {
    switch (projectId) {
        case 'project_1':
            return project1Images;
        case 'project_2':
            return project2Images;
        case 'project_3':
            return project3Images;
        case 'project_4':
            return project4Images;
        case 'project_5':
            return project5Images;
        case 'project_6':
            return project6Images;
        case 'project_7':
            return project7Images;
        case 'project_8':
            return project8Images;
        case 'project_9':
            return project9Images;
        default:
            return null;
    }
};
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
                :title="getContent('project_1', 'title', 'CAMPAIGN AGAINST FAKE FIBRE')"
                :link-text="getContent('project_1', 'link_text', 'SWISH FIBRE')"
                :link="getContent('project_1', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_1', 'description_1', 'A disruptive wide-scale public interest campaign to alert consumers to the major performance differences between speed-sapping copper-mix Fibre Broadband and the superior capabilities of 100% fibre-optic alternatives known as Full Fibre.'),
                    getContent('project_1', 'description_2', 'Comprising several sets of yin and yang adverts, each playfully taps into a consumer pain-point such as online gaming, hybrid working and long-winded download and upload waiting times.'),
                    getContent('project_1', 'description_3', 'The campaign has subsequently led to Ofcom commissioning proposals to improve broadband information for consumers.')
                ]"
                :images="project1Images"
                layout="dynamic"
                :is-editing="isEditing"
                @image-updated="handleProjectImageUpdated"
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
                :is-editing="isEditing"
                @image-updated="handleProjectImageUpdated"
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
                :is-editing="isEditing"
                @image-updated="handleProjectImageUpdated"
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
                :is-editing="isEditing"
                @image-updated="handleProjectImageUpdated"
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
                :is-editing="isEditing"
                @image-updated="handleProjectImageUpdated"
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
                :is-editing="isEditing"
                @image-updated="handleProjectImageUpdated"
            />

            <!-- Proyecto 7 -->
            <Proyect
                project-id="project_7"
                :title="getContent('project_7', 'title', 'A BRAND TO BUILD A COMMUNITY AND HELP PEOPLE LIVE WELL')"
                :link-text="getContent('project_7', 'link_text', 'WMUK')"
                :link="getContent('project_7', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_7', 'description_1', 'A powerful co-designed multimedia advertising campaign underwritten by Nominet, the initiative raised £150,216 for Samaritans, more than 5% over the forecast, with reach of over 12 million over a six week period.'),
                    getContent('project_7', 'description_2', 'By Experience arrived at the carefully crafted solution via a rigorous and iterative process, developing a design system and messaging framework to consider the demographics that would typically benefit from this innovative new online chat service.')
                ]"
                :images="project7Images"
                layout="dynamic"
                :is-editing="isEditing"
                @image-updated="handleProjectImageUpdated"
            />

            <!-- Proyecto 8 -->
            <Proyect
                project-id="project_8"
                :title="getContent('project_8', 'title', 'A BRAND TO BUILD A COMMUNITY AND HELP PEOPLE LIVE WELL')"
                :link-text="getContent('project_8', 'link_text', 'SPARX')"
                :link="getContent('project_8', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_8', 'description_1', 'A powerful co-designed multimedia advertising campaign underwritten by Nominet, the initiative raised £150,216 for Samaritans, more than 5% over the forecast, with reach of over 12 million over a six week period.'),
                    getContent('project_8', 'description_2', 'By Experience arrived at the carefully crafted solution via a rigorous and iterative process, developing a design system and messaging framework to consider the demographics that would typically benefit from this innovative new online chat service.')
                ]"
                :images="project8Images"
                layout="dynamic"
                :is-editing="isEditing"
                @image-updated="handleProjectImageUpdated"
            />

            <!-- Proyecto 9 -->
            <Proyect
                project-id="project_9"
                :title="getContent('project_9', 'title', 'A BRAND TO BUILD A COMMUNITY AND HELP PEOPLE LIVE WELL')"
                :link-text="getContent('project_9', 'link_text', 'NOMINET CYBER')"
                :link="getContent('project_9', 'link', 'https://www.swishfibre.com/')"
                :descriptions="[
                    getContent('project_9', 'description_1', 'A powerful co-designed multimedia advertising campaign underwritten by Nominet, the initiative raised £150,216 for Samaritans, more than 5% over the forecast, with reach of over 12 million over a six week period.'),
                    getContent('project_9', 'description_2', 'By Experience arrived at the carefully crafted solution via a rigorous and iterative process, developing a design system and messaging framework to consider the demographics that would typically benefit from this innovative new online chat service.')
                ]"
                :images="project9Images"
                layout="dynamic"
                :is-editing="isEditing"
                @image-updated="handleProjectImageUpdated"
            />

            <Footer />

            <FloatingButton 
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











