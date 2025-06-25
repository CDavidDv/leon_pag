<script setup>
import AppLayout from '@/Layouts/AppLayoutEdit.vue';
import Marketing from '@/Components/Home/Marketing.vue';
import Footer from '@/Components/Home/Footer.vue';
import VideoUploader from '@/Components/VideoUploader.vue';
import EditableText from '@/Components/EditableText.vue';
import FloatingButton from '@/Components/Home/FloatingButtonEdit.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

// Estado para el modo de edición
const isEditing = ref(false);
const changesSaved = ref(false);

// Estado para los textos
const textContent = ref({
    approach_hero: {
        heading: 'AN APPROACH DESIGNED TO GIVE YOU TRUE COMPETITIVE ADVANTAGE.',
        description1: "It's your journey. You've entrusted us with your business, and it's our job to get you to the outcome you're completely satisfied with.",
        description2: 'Before every project is commissioned, we undertake a detailed analysis of your needs and objectives. This helps establish the aiming point and key activities we will cover in order to get there.',
        description3: "We'll share initial thoughts, findings and supporting work samples, along with a fully costed roadmap of how we'll arrive to the right solution."
    },
    approach_main: {
        heading: "YOU'RE WITH US, EVERY STEP OF THE WAY",
        description1: 'We solve any project type and challenge using our simple yet rigorous three-stage process.',
        description2: "Whether you want to be fully hands-on or favour a more light-touch approach, you're the hero of the story. The three stages ensure we carefully progress your solution with transparency, giving you plenty of opportunity to shape and guide it as it evolves from the initial planning stage to launch and beyond. Every stage culminates with a highly interactive presentation and collaborative discussion to review the output with you.",
        description3: "It's been proven to work time and again, for any type of project and level of complexity. It helps maximise efficiency and accelerate timescales when required, without compromising on quality."
    },
    explore_phase: {
        heading: 'EXPLORE PHASE',
        description1: 'Where we set the strategic direction, carry out research, and generate an abundance of concepts and ideas.',
        description2: "At its heart, it's an intense and exciting period to think big, dream the impossible and out-think the competition. Whether we're mapping out a full-scale marketing strategy, value proposition or omnichannel integrated campaign, we use this phase to explore, share and assess a range of different approaches to the core problem.",
        description3: "It's often the unfiltered kernels of an idea shared with clients during this stage that lead to the winning solution."
    },
    design_phase: {
        heading: 'DESIGN PHASE',
        description1: 'Where we take forward a shortlist of concepts to refine and develop these to a greater level of maturity and fidelity.',
        description2: 'This is where we solidify the big idea and bring it to life through real-world scenarios. If we\'re creating or refreshing your brand, we craft the story, look and feel, and demonstrate how it would be realised via digital, out-of-home and in-person experiences.',
        description3: 'Depending on the project, we also visualise advertising concepts, marketing campaigns, social media experiences, events and applications that "look just like the real thing".',
        description4: 'We give you early confidence that we\'ve hit and exceeded the brief and are on the right track.'
    },
    create_phase: {
        heading: 'CREATE PHASE',
        description1: 'Where the magic happens, as ideas become reality, from production to full-scale roll-out of your project.',
        description2: 'This is when marketing strategy becomes detailed plans, brands are launched or refreshed, and digital experiences and marketing campaigns are activated at scale.',
        description3: 'Whether we take care of all your brand and marketing needs, or work alongside your in-house specialists, we make things happen together for your brand and audience.'
    },
    work_with_us: {
        heading: 'WORK WITH US IF:',
        description1: 'You value informed and impactful action at pace over procrastination, the status quo or analysis paralysis. (We make things happen)',
        description2: 'You value deep collaboration and integrity over "No problem, we\'ve written that down and will get it art-worked exactly as you\'ve described by COP tomorrow". (We are laser-focused on your audience)',
        description3: 'You value your time and money and want our full attention over a 25% \'cost of sale\' tax on your agency invoices. (We don\'t pitch)',
        description4: 'You value lasting relationships that grow together over "one and done" projects. (We thrive on trust and accountability)',
        description5: 'You value experience.'
    }
});

// Estado para los videos
const approachVideos = ref({
    hero: '',
    section1: '',
    section2: '',
    section3: ''
});

// Estado para la imagen del botón flotante
const floatingButtonImage = ref(null);

// Cargar datos multimedia
const cargarMultimedia = async () => {
    try {
        // Cargar videos de approach
        const videoResponse = await axios.get('/api/media/videos/approach');
        if (videoResponse.data.success) {
            videoResponse.data.data.forEach(video => {
                if (video.name === 'approach_hero') {
                    approachVideos.value.hero = video.path;
                } else if (video.name === 'approach_section1') {
                    approachVideos.value.section1 = video.path;
                } else if (video.name === 'approach_section2') {
                    approachVideos.value.section2 = video.path;
                } else if (video.name === 'approach_section3') {
                    approachVideos.value.section3 = video.path;
                }
            });
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

onMounted(() => {
    cargarMultimedia();
});
</script>

<template>
    <AppLayout title="Work By Experience">
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

            <div class="w-full h-full flex flex-col pt-8">
                <div class="flex lg:flex-col flex-col-reverse w-full">
                <div class="w-full lg:pl-32 px-20 pb-20 mt-14 h-full flex flex-col gap-5">
                    <EditableText
                        v-model="textContent.approach_hero.heading"
                        :is-editing="isEditing"
                        tag="p"
                        class="transform scale-y-75 lg:text-left text-center lg:text-7xl text-4xl font-extrabold max-w-4xl"
                        placeholder="AN APPROACH DESIGNED TO GIVE YOU TRUE COMPETITIVE ADVANTAGE."
                        @change="(value) => handleTextUpdated({section: 'approach_hero', field: 'heading', value})"
                    />
                    <EditableText
                        v-model="textContent.approach_hero.description1"
                        :is-editing="isEditing"
                        tag="p"
                        class="lg:pr-24 px-20 lg:px-0 lg:max-w-3xl text-center lg:text-left"
                        placeholder="It's your journey. You've entrusted us with your business, and it's our job to get you to the outcome you're completely satisfied with."
                        :multiline="true"
                        @change="(value) => handleTextUpdated({section: 'approach_hero', field: 'description1', value})"
                    />
                    <EditableText
                        v-model="textContent.approach_hero.description2"
                        :is-editing="isEditing"
                        tag="p"
                        class="lg:pr-24 px-20 lg:px-0 lg:max-w-3xl text-center lg:text-left"
                        placeholder="Before every project is commissioned, we undertake a detailed analysis of your needs and objectives. This helps establish the aiming point and key activities we will cover in order to get there."
                        :multiline="true"
                        @change="(value) => handleTextUpdated({section: 'approach_hero', field: 'description2', value})"
                    />
                    <EditableText
                        v-model="textContent.approach_hero.description3"
                        :is-editing="isEditing"
                        tag="p"
                        class="lg:pr-24 px-20 lg:px-0 lg:max-w-3xl text-center lg:text-left"
                        placeholder="We'll share initial thoughts, findings and supporting work samples, along with a fully costed roadmap of how we'll arrive to the right solution."
                        :multiline="true"
                        @change="(value) => handleTextUpdated({section: 'approach_hero', field: 'description3', value})"
                    />
                </div>
                
                <video 
                    v-if="approachVideos.hero"
                    :src="approachVideos.hero.startsWith('/storage/') ? approachVideos.hero : `/storage/${approachVideos.hero}`" 
                    autoplay 
                    muted 
                    loop 
                    class="w-full bg-black h-full object-cover"
                ></video>
                <video 
                    v-else
                    src="/videos/approach.mp4" 
                    autoplay 
                    muted 
                    loop 
                    class="w-full bg-black h-full object-cover"
                ></video>
                </div>
            </div>

            <div class="w-full h-full flex flex-col p-20 pl-32">
            <EditableText
                v-model="textContent.approach_main.heading"
                :is-editing="isEditing"
                tag="h1"
                class="lg:text-7xl text-4xl font-extrabold transform scale-y-75 lg:text-left text-center"
                placeholder="YOU'RE WITH US, EVERY STEP OF THE WAY"
                @change="(value) => handleTextUpdated({section: 'approach_main', field: 'heading', value})"
            />

            <div class="mt-4 lg:pr-24 px-20 lg:mx-0 max-w-3xl text-center lg:text-left flex flex-col gap-4">
                <EditableText
                    v-model="textContent.approach_main.description1"
                    :is-editing="isEditing"
                    tag="p"
                    placeholder="We solve any project type and challenge using our simple yet rigorous three-stage process."
                    :multiline="true"
                    @change="(value) => handleTextUpdated({section: 'approach_main', field: 'description1', value})"
                />
                <EditableText
                    v-model="textContent.approach_main.description2"
                    :is-editing="isEditing"
                    tag="p"
                    placeholder="Whether you want to be fully hands-on or favour a more light-touch approach, you're the hero of the story. The three stages ensure we carefully progress your solution with transparency, giving you plenty of opportunity to shape and guide it as it evolves from the initial planning stage to launch and beyond. Every stage culminates with a highly interactive presentation and collaborative discussion to review the output with you."
                    :multiline="true"
                    @change="(value) => handleTextUpdated({section: 'approach_main', field: 'description2', value})"
                />
                <EditableText
                    v-model="textContent.approach_main.description3"
                    :is-editing="isEditing"
                    tag="p"
                    placeholder="It's been proven to work time and again, for any type of project and level of complexity. It helps maximise efficiency and accelerate timescales when required, without compromising on quality."
                    :multiline="true"
                    @change="(value) => handleTextUpdated({section: 'approach_main', field: 'description3', value})"
                />
            </div>
        </div>

        <!-- Video de la sección 1 -->
        <div class="relative">
            <video 
                v-if="approachVideos.section1"
                :src="approachVideos.section1.startsWith('/storage/') ? approachVideos.section1 : `/storage/${approachVideos.section1}`" 
                autoplay 
                muted 
                loop 
                class="w-full bg-black h-full object-cover"
            ></video>
            <div v-else class="w-full bg-black h-96 flex items-center justify-center">
                <span class="text-white">Sin video</span>
            </div>

            <!-- Editor de video -->
            <div class="absolute top-4 right-4">
                <VideoUploader
                    :currentVideo="approachVideos.section1"
                    section="approach"
                    name="approach_section1"
                    alt="Video de la sección 1"
                    videoClass="w-32 h-20 object-cover rounded-lg"
                    previewClass="w-48 h-32 object-cover border-2 border-blue-300 rounded"
                    buttonText="Cambiar video"
                    :showEditButton="true"
                    :maxSize="100"
                />
            </div>
        </div>

            <div class="w-full h-full flex flex-col p-20 pl-32">
            <EditableText
                v-model="textContent.explore_phase.heading"
                :is-editing="isEditing"
                tag="h1"
                class="lg:text-7xl text-4xl font-extrabold transform scale-y-75 text-left"
                placeholder="EXPLORE PHASE"
                @change="(value) => handleTextUpdated({section: 'explore_phase', field: 'heading', value})"
            />
            <EditableText
                v-model="textContent.explore_phase.description1"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 lg:max-w-2xl mb-4"
                placeholder="Where we set the strategic direction, carry out research, and generate an abundance of concepts and ideas."
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'explore_phase', field: 'description1', value})"
            />
            <EditableText
                v-model="textContent.explore_phase.description2"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 lg:max-w-2xl mb-4"
                placeholder="At its heart, it's an intense and exciting period to think big, dream the impossible and out-think the competition. Whether we're mapping out a full-scale marketing strategy, value proposition or omnichannel integrated campaign, we use this phase to explore, share and assess a range of different approaches to the core problem."
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'explore_phase', field: 'description2', value})"
            />
            <EditableText
                v-model="textContent.explore_phase.description3"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 lg:max-w-2xl mb-4"
                placeholder="It's often the unfiltered kernels of an idea shared with clients during this stage that lead to the winning solution."
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'explore_phase', field: 'description3', value})"
            />
            </div>

        <!-- Video de la sección 2 -->
        <div class="relative">
            <video 
                v-if="approachVideos.section2"
                :src="approachVideos.section2.startsWith('/storage/') ? approachVideos.section2 : `/storage/${approachVideos.section2}`" 
                autoplay 
                muted 
                loop 
                class="w-full bg-black h-full object-cover"
            ></video>
            <div v-else class="w-full bg-black h-96 flex items-center justify-center">
                <span class="text-white">Sin video</span>
            </div>

            <!-- Editor de video -->
            <div class="absolute top-4 right-4">
                <VideoUploader
                    :currentVideo="approachVideos.section2"
                    section="approach"
                    name="approach_section2"
                    alt="Video de la sección 2"
                    videoClass="w-32 h-20 object-cover rounded-lg"
                    previewClass="w-48 h-32 object-cover border-2 border-blue-300 rounded"
                    buttonText="Cambiar video"
                    :showEditButton="true"
                    :maxSize="100"
                />
            </div>
        </div>

            <div class="w-full h-full flex flex-col p-20 lg:pl-32">
            <EditableText
                v-model="textContent.design_phase.heading"
                :is-editing="isEditing"
                tag="h1"
                class="lg:text-7xl text-4xl font-extrabold mb-10 transform scale-y-75 text-left"
                placeholder="DESIGN PHASE"
                @change="(value) => handleTextUpdated({section: 'design_phase', field: 'heading', value})"
            />
            <EditableText
                v-model="textContent.design_phase.description1"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 max-w-2xl mb-4"
                placeholder="Where we take forward a shortlist of concepts to refine and develop these to a greater level of maturity and fidelity."
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'design_phase', field: 'description1', value})"
            />
            <EditableText
                v-model="textContent.design_phase.description2"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 max-w-2xl mb-4"
                placeholder="This is where we solidify the big idea and bring it to life through real-world scenarios. If we're creating or refreshing your brand, we craft the story, look and feel, and demonstrate how it would be realised via digital, out-of-home and in-person experiences."
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'design_phase', field: 'description2', value})"
            />
            <EditableText
                v-model="textContent.design_phase.description3"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 max-w-2xl mb-4"
                placeholder="Depending on the project, we also visualise advertising concepts, marketing campaigns, social media experiences, events and applications that 'look just like the real thing'."
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'design_phase', field: 'description3', value})"
            />
            <EditableText
                v-model="textContent.design_phase.description4"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 max-w-2xl mb-4"
                placeholder="We give you early confidence that we've hit and exceeded the brief and are on the right track."
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'design_phase', field: 'description4', value})"
            />
        </div>

        <!-- Video de la sección 3 -->
        <div class="relative">
            <video 
                v-if="approachVideos.section3"
                :src="approachVideos.section3.startsWith('/storage/') ? approachVideos.section3 : `/storage/${approachVideos.section3}`" 
                autoplay 
                muted 
                loop 
                class="w-full bg-black h-full object-cover"
            ></video>
            <div v-else class="w-full bg-black h-96 flex items-center justify-center">
                <span class="text-white">Sin video</span>
            </div>

            <!-- Editor de video -->
            <div class="absolute top-4 right-4">
                <VideoUploader
                    :currentVideo="approachVideos.section3"
                    section="approach"
                    name="approach_section3"
                    alt="Video de la sección 3"
                    videoClass="w-32 h-20 object-cover rounded-lg"
                    previewClass="w-48 h-32 object-cover border-2 border-blue-300 rounded"
                    buttonText="Cambiar video"
                    :showEditButton="true"
                    :maxSize="100"
                />
            </div>
        </div>

            <div class="w-full h-full flex flex-col p-20 lg:pl-32">
            <EditableText
                v-model="textContent.create_phase.heading"
                :is-editing="isEditing"
                tag="h1"
                class="lg:text-7xl text-4xl font-extrabold mb-10 transform scale-y-75 text-left"
                placeholder="CREATE PHASE"
                @change="(value) => handleTextUpdated({section: 'create_phase', field: 'heading', value})"
            />
            <EditableText
                v-model="textContent.create_phase.description1"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 max-w-2xl mb-4"
                placeholder="Where the magic happens, as ideas become reality, from production to full-scale roll-out of your project."
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'create_phase', field: 'description1', value})"
            />
            <EditableText
                v-model="textContent.create_phase.description2"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 max-w-2xl mb-4"
                placeholder="This is when marketing strategy becomes detailed plans, brands are launched or refreshed, and digital experiences and marketing campaigns are activated at scale."
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'create_phase', field: 'description2', value})"
            />
            <EditableText
                v-model="textContent.create_phase.description3"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 max-w-2xl mb-4"
                placeholder="Whether we take care of all your brand and marketing needs, or work alongside your in-house specialists, we make things happen together for your brand and audience."
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'create_phase', field: 'description3', value})"
            />
            </div>

            <div class="w-full h-full flex flex-col p-20 lg:pl-32">
            <EditableText
                v-model="textContent.work_with_us.heading"
                :is-editing="isEditing"
                tag="h1"
                class="lg:text-7xl text-4xl font-extrabold mb-10 transform scale-y-75 text-left"
                placeholder="WORK WITH US IF:"
                @change="(value) => handleTextUpdated({section: 'work_with_us', field: 'heading', value})"
            />
            <EditableText
                v-model="textContent.work_with_us.description1"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 max-w-4xl mb-4"
                placeholder="You value informed and impactful action at pace over procrastination, the status quo or analysis paralysis. (We make things happen)"
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'work_with_us', field: 'description1', value})"
            />
            <EditableText
                v-model="textContent.work_with_us.description2"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 max-w-4xl mb-4"
                placeholder="You value deep collaboration and integrity over 'No problem, we've written that down and will get it art-worked exactly as you've described by COP tomorrow'. (We are laser-focused on your audience)"
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'work_with_us', field: 'description2', value})"
            />
            <EditableText
                v-model="textContent.work_with_us.description3"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 max-w-4xl mb-4"
                placeholder="You value your time and money and want our full attention over a 25% 'cost of sale' tax on your agency invoices. (We don't pitch)"
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'work_with_us', field: 'description3', value})"
            />
            <EditableText
                v-model="textContent.work_with_us.description4"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 max-w-4xl mb-4"
                placeholder="You value lasting relationships that grow together over 'one and done' projects. (We thrive on trust and accountability)"
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'work_with_us', field: 'description4', value})"
            />
            <EditableText
                v-model="textContent.work_with_us.description5"
                :is-editing="isEditing"
                tag="p"
                class="lg:pr-24 max-w-4xl mb-4"
                placeholder="You value experience."
                :multiline="true"
                @change="(value) => handleTextUpdated({section: 'work_with_us', field: 'description5', value})"
            />
            </div>
   
        <Marketing />
            <Footer />

            <FloatingButton 
                :floating-button-image="floatingButtonImage"
                @image-updated="handleFloatingButtonImageUpdated"
            />
    </AppLayout>
</template>

<style>
* {
    color: #fff;
}
</style>