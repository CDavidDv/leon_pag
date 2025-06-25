<script setup>
import AppLayout from '@/Layouts/AppLayoutEdit.vue';
import Marketing from '@/Components/Home/Marketing.vue';
import Footer from '@/Components/Home/Footer.vue';
import GalleryEditor from '@/Components/GalleryEditor.vue';
import ImageUploader from '@/Components/ImageUploader.vue';
import FloatingButton from '@/Components/Home/FloatingButtonEdit.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const appLayoutRef = ref(null);

// Estado para las imágenes
const aboutImages = ref([]);
const teamImages = ref([]);
const backgroundImage = ref('');
const floatingButtonImage = ref(null);

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

// Manejar actualización de imagen del botón flotante
const handleFloatingButtonImageUpdated = async (imageData) => {
    try {
        floatingButtonImage.value = imageData;
        // Aquí podrías mostrar una notificación de éxito si lo deseas
    } catch (error) {
        console.error('Error al actualizar imagen del botón flotante:', error);
    }
};

onMounted(() => {
    cargarMultimedia();
});
</script>

<template>
    <AppLayout title="Work By Experience" ref="appLayoutRef">
        <div class="w-full h-full flex flex-col">
            <!-- Imagen de fondo -->
            <div class="fixed inset-0 z-0">
                <img 
                    v-if="backgroundImage"
                    :src="backgroundImage.startsWith('/storage/') ? backgroundImage : `/storage/${backgroundImage}`" 
                    alt="Imagen de fondo"
                    class="w-full h-full object-cover"
                />
                <div v-else class="w-full h-full bg-gradient-to-br from-blue-900 to-purple-900"></div>
            </div>
            
            <!-- Overlay -->
            <div class="fixed inset-0 bg-black bg-opacity-60 z-10"></div>
            
            <!-- Contenido principal -->
            <div class="relative z-20">
                <!-- Editor de imagen de fondo -->
                <div class="absolute top-4 right-4 z-30">
                    <ImageUploader
                        :currentImage="backgroundImage"
                        section="about_background"
                        name="about_background"
                        alt="Imagen de fondo de About"
                        imageClass="w-32 h-20 object-cover rounded-lg"
                        previewClass="w-48 h-32 object-cover border-2 border-blue-300 rounded"
                        buttonText="Cambiar fondo"
                        :showEditButton="true"
                        :maxSize="5"
                    />
                </div>

                <div class="w-full lg:h-screen py-40 lg:py-0 flex flex-col justify-center items-center px-8">
                    <h1 class="lg:text-7xl text-4xl max-w-2xl text-center font-extrabold transform scale-y-75">
                        MADE BY EXPERIENCE
                    </h1>
                    <p class="text-normal mb-10 max-w-xl text-center">Over twenty years of agency and client-side experience created a burning itch of curiosity so great that we simply had to scratch it.</p>
                    <p class="text-normal mb-10 max-w-xl text-center">Having spent decades railing against mediocrity, vacuum-packed marketing and increasingly homogeneous brands, we wanted to create an agency that does things better and more in line with what matters most to our clients.</p>
                </div>

                <div class="w-full lg:h-screen py-40 lg:py-0 flex flex-col justify-center items-center px-8">
                    <h1 class="lg:text-7xl text-4xl max-w-3xl text-center font-extrabold transform scale-y-75">
                        WHEN MONEY AND REPUTATION IS INVOLVED, IT'S IMPORTANT YOU CHOOSE PEOPLE THAT FIERCELY PROTECT IT.
                    </h1>
                    <p class="text-normal mb-10 max-w-xl text-center">As former Marketing and Creative Directors, our founders have walked similar paths to yours. Our hand-picked team represent the best in their chosen areas.</p>
                    <p class="text-normal mb-10 max-w-xl text-center">Together, we bring bags of experience to the table, who get to the heart of what you're looking to achieve with creative efficiency.</p>
                    <p class="text-normal mb-10 max-w-xl text-center">We think and act like the agency you want to engage with.</p>
                </div>

                <!-- Sección de galería de imágenes -->
                <div class="w-full py-16 px-8">
                    <div class="max-w-6xl mx-auto">
                        <GalleryEditor
                            :imagenes="aboutImages"
                            section="about"
                            title="Imágenes de About"
                            description="Gestiona las imágenes de la página About"
                            :maxImages="8"
                        />
                    </div>
                </div>

                <div class="w-full lg:h-screen py-40 lg:py-0 flex flex-col justify-center items-center px-8">
                    <h1 class="lg:text-7xl text-4xl max-w-3xl text-center font-extrabold transform scale-y-75 mb-5">
                        WHY PEOPLE WORK WITH US
                    </h1>
                    <p class="text-normal mb-5 max-w-4xl text-center">We produce strategic brand, marketing and creative work that bottles the team's collective experience and energy to deliver exceptional results at lightning pace.</p>
                    <p class="text-normal mb-5 max-w-4xl text-center">Whether we're creating a new or refreshed brand, revitalising your value proposition and product marketing, or launching an integrated marketing campaign, we consistently deliver the wow factor.</p>
                    <p class="text-normal mb-5 max-w-4xl text-center">We trade in FOMO. We create the glue for your every word, and the itch to engage with your brand.</p>
                    <p class="text-normal mb-0 max-w-4xl text-center">There's that itch again.</p>
                </div>

                <!-- Sección de imágenes del equipo -->
                <div class="w-full py-16 px-8">
                    <div class="max-w-6xl mx-auto">
                        <GalleryEditor
                            :imagenes="teamImages"
                            section="team"
                            title="Imágenes del Equipo"
                            description="Gestiona las imágenes del equipo"
                            :maxImages="12"
                        />
                    </div>
                </div>
                
                <div class="w-full lg:h-screen py-40 lg:py-0 flex flex-col justify-center items-center px-8">
                    <h1 class="lg:text-7xl text-4xl max-w-3xl text-center font-extrabold transform scale-y-75 mb-5">
                        ALWAYS HUNGRY. ALWAYS LEARNING. ALWAYS READY TO DELIVER.
                    </h1>
                </div>

                <Marketing class="lg:mb-40 mx-4" />
                <Footer />

                <FloatingButton 
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