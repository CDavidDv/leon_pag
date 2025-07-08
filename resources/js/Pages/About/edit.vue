<script setup>
import AppLayout from '@/Layouts/AppLayoutEdit.vue';
import Marketing from '@/Components/Home/Marketing.vue';
import Footer from '@/Components/Home/Footer.vue';
import FloatingButton from '@/Components/Home/FloatingButtonEdit.vue';
import EditableSection from '@/Components/EditableSection.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const appLayoutRef = ref(null);

// Estado para las imágenes
const aboutImages = ref([]);
const teamImages = ref([]);
const backgroundImage = ref('');
const floatingButtonImage = ref(null);

// Estado para el contenido de texto
const textContent = ref({
    about: {
        title: 'MADE BY EXPERIENCE',
        paragraph_1: 'Over twenty years of agency and client-side experience created a burning itch of curiosity so great that we simply had to scratch it.',
        paragraph_2: 'Having spent decades railing against mediocrity, vacuum-packed marketing and increasingly homogeneous brands, we wanted to create an agency that does things better and more in line with what matters most to our clients.',
        section2_title: 'WHEN MONEY AND REPUTATION IS INVOLVED, IT\'S IMPORTANT YOU CHOOSE PEOPLE THAT FIERCELY PROTECT IT.',
        section2_paragraph_1: 'As former Marketing and Creative Directors, our founders have walked similar paths to yours. Our hand-picked team represent the best in their chosen areas.',
        section2_paragraph_2: 'Together, we bring bags of experience to the table, who get to the heart of what you\'re looking to achieve with creative efficiency.',
        section2_paragraph_3: 'We think and act like the agency you want to engage with.',
        section3_title: 'WHY PEOPLE WORK WITH US',
        section3_paragraph_1: 'We produce strategic brand, marketing and creative work that bottles the team\'s collective experience and energy to deliver exceptional results at lightning pace.',
        section3_paragraph_2: 'Whether we\'re creating a new or refreshed brand, revitalising your value proposition and product marketing, or launching an integrated marketing campaign, we consistently deliver the wow factor.',
        section3_paragraph_3: 'We trade in FOMO. We create the glue for your every word, and the itch to engage with your brand.',
        section3_paragraph_4: 'There\'s that itch again.',
        section4_title: 'ALWAYS HUNGRY. ALWAYS LEARNING. ALWAYS READY TO DELIVER.'
    },
    footer: {
        footer_text: ''
    }
});

const changesSaved = ref(false);

// Estado para el modo de edición
const isEditing = ref(false);

// Función para alternar el modo de edición
const toggleEditing = () => {
    isEditing.value = !isEditing.value;
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

        // Cargar imagen del botón flotante (logo de la empresa)
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
        }
    } catch (error) {
        console.error('Error al cargar textos:', error);
    }
};

// Manejar actualización de imagen del botón flotante (logo de la empresa)
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

onMounted(() => {
    cargarMultimedia();
    cargarTextos();
});

</script>

<template>
    <AppLayout title="Work By Experience" ref="appLayoutRef">
        <div class="w-full h-full flex flex-col">
            <!-- Imagen de fondo -->
            <div class="fixed inset-0 z-0">
                
            </div>
            
            <!-- Overlay -->
            <div class="fixed inset-0 bg-black bg-opacity-60 z-10"></div>
            
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
            
            <!-- Contenido principal -->
            <div class="relative top-11 z-20">
                <!-- Editor de imagen de fondo -->
                <div class="absolute top-4 right-4 z-30">
                    
                </div>

                <EditableSection
                    :title="textContent.about.title"
                    :paragraph1="textContent.about.paragraph_1"
                    :paragraph2="textContent.about.paragraph_2"
                    :is-editing="isEditing"
                    section="about"
                    @text-updated="handleTextUpdated"
                />

                <EditableSection
                    :title="textContent.about.section2_title"
                    :paragraph1="textContent.about.section2_paragraph_1"
                    :paragraph2="textContent.about.section2_paragraph_2"
                    :paragraph3="textContent.about.section2_paragraph_3"
                    :is-editing="isEditing"
                    section="about"
                    title-class="lg:text-5xl text-3xl max-w-4xl text-center font-extrabold transform scale-y-75 mb-10"
                    @text-updated="handleTextUpdated"
                />

                <EditableSection
                    :title="textContent.about.section3_title"
                    :paragraph1="textContent.about.section3_paragraph_1"
                    :paragraph2="textContent.about.section3_paragraph_2"
                    :paragraph3="textContent.about.section3_paragraph_3"
                    :paragraph4="textContent.about.section3_paragraph_4"
                    :is-editing="isEditing"
                    section="about"
                    title-class="lg:text-7xl text-4xl max-w-3xl text-center font-extrabold transform scale-y-75 mb-5"
                    paragraph-class="text-normal mb-5 max-w-4xl text-center"
                    @text-updated="handleTextUpdated"
                />
                
                <EditableSection
                    :title="textContent.about.section4_title"
                    :is-editing="isEditing"
                    section="about"
                    title-class="lg:text-7xl text-4xl max-w-3xl text-center font-extrabold transform scale-y-75 mb-5"
                    @text-updated="handleTextUpdated"
                />

                <Marketing class="lg:mb-40 mx-4" />
                <Footer 
                    :footer-text="textContent.footer.footer_text"
                    :is-editing="isEditing"
                    :initial-footer-text="textContent.footer.footer_text"
                    @text-updated="handleTextUpdated"
                />

                <FloatingButton 
                    :is-editing="true"
                    :floating-button-image="floatingButtonImage"
                    @image-updated="handleFloatingButtonImageUpdated"
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