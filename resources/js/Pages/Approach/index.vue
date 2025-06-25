<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Marketing from '@/Components/Home/Marketing.vue';
import Footer from '@/Components/Home/Footer.vue';
import FloatingButton from '@/Components/Home/FloatingButton.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

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

// Estado para los videos
const approachVideos = ref({
    hero: '',
    section1: '',
    section2: '',
    section3: ''
});


// Función para mostrar el bar de contacto
const showBarContact = () => {
    // Esta función se maneja a través del AppLayout
    console.log('showBarContact desde Approach');
};

// Cargar textos desde la base de datos
const loadTexts = async () => {
    try {
        const response = await axios.get('/api/work-content/text-content');
        if (response.data.content) {
            Object.keys(response.data.content).forEach(section => {
                if (textContent.value[section]) {
                    Object.keys(response.data.content[section]).forEach(field => {
                        if (response.data.content[section][field] && response.data.content[section][field].content) {
                            textContent.value[section][field] = response.data.content[section][field].content;
                        }
                    });
                }
            });
        }
    } catch (error) {
        console.error('Error al cargar textos:', error);
    }
};

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
        
    } catch (error) {
        console.error('Error al cargar multimedia:', error);
    }
};

onMounted(() => {
    loadTexts();
    cargarMultimedia();
});
</script>

<template>
    <AppLayout title="Work By Experience">
            <div class="w-full h-full flex flex-col pt-8">
                <div class="flex lg:flex-col flex-col-reverse w-full">
                <div class="w-full lg:pl-32 px-20 pb-20 mt-14 h-full flex flex-col gap-5">
                    <p class="transform scale-y-75 lg:text-left text-center lg:text-7xl text-4xl font-extrabold max-w-4xl">
                            {{ textContent.approach_hero.heading }}
                        </p>
                    <p class="lg:pr-24 px-20 lg:px-0 lg:max-w-3xl text-center lg:text-left">
                            {{ textContent.approach_hero.description1 }}
                        </p>        
                    <p class="lg:pr-24 px-20 lg:px-0 lg:max-w-3xl text-center lg:text-left">
                            {{ textContent.approach_hero.description2 }}
                        </p>
                    <p class="lg:pr-24 px-20 lg:px-0 lg:max-w-3xl text-center lg:text-left">
                            {{ textContent.approach_hero.description3 }}
                        </p>
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
            <h1 class="lg:text-7xl text-4xl font-extrabold transform scale-y-75 lg:text-left text-center">
                    {{ textContent.approach_main.heading }}
                </h1>

            <div class="mt-4 lg:pr-24 px-20 lg:mx-0 max-w-3xl text-center lg:text-left flex flex-col gap-4">
                <p>{{ textContent.approach_main.description1 }}</p>
                <p>{{ textContent.approach_main.description2 }}</p>
                <p>{{ textContent.approach_main.description3 }}</p>
            </div>
        </div>

        <video 
            v-if="approachVideos.section1"
            :src="approachVideos.section1.startsWith('/storage/') ? approachVideos.section1 : `/storage/${approachVideos.section1}`" 
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

            <div class="w-full h-full flex flex-col p-20 pl-32">
            <h1 class="lg:text-7xl text-4xl font-extrabold transform scale-y-75 text-left">
                    {{ textContent.explore_phase.heading }}
                </h1>
            <p class="lg:pr-24 lg:max-w-2xl mb-4">{{ textContent.explore_phase.description1 }}</p>
            <p class="lg:pr-24 lg:max-w-2xl mb-4">{{ textContent.explore_phase.description2 }}</p>
            <p class="lg:pr-24 lg:max-w-2xl mb-4">{{ textContent.explore_phase.description3 }}</p>
            </div>

        <video 
            v-if="approachVideos.section2"
            :src="approachVideos.section2.startsWith('/storage/') ? approachVideos.section2 : `/storage/${approachVideos.section2}`" 
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

            <div class="w-full h-full flex flex-col p-20 lg:pl-32">
            <h1 class="lg:text-7xl text-4xl font-extrabold mb-10 transform scale-y-75 text-left">
                    {{ textContent.design_phase.heading }}
                </h1>
                <p class="lg:pr-24 max-w-2xl mb-4">{{ textContent.design_phase.description1 }}</p>
            <p class="lg:pr-24 max-w-2xl mb-4">{{ textContent.design_phase.description2 }}</p>
            <p class="lg:pr-24 max-w-2xl mb-4">{{ textContent.design_phase.description3 }}</p>
            <p class="lg:pr-24 max-w-2xl mb-4">{{ textContent.design_phase.description4 }}</p>
            </div>

        <video 
            v-if="approachVideos.section3"
            :src="approachVideos.section3.startsWith('/storage/') ? approachVideos.section3 : `/storage/${approachVideos.section3}`" 
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

            <div class="w-full h-full flex flex-col p-20 lg:pl-32">
            <h1 class="lg:text-7xl text-4xl font-extrabold mb-10 transform scale-y-75 text-left">
                    {{ textContent.create_phase.heading }}
                </h1>
            <p class="lg:pr-24 max-w-2xl mb-4">{{ textContent.create_phase.description1 }}</p>
            <p class="lg:pr-24 max-w-2xl mb-4">{{ textContent.create_phase.description2 }}</p>
            <p class="lg:pr-24 max-w-2xl mb-4">{{ textContent.create_phase.description3 }}</p>
            </div>

            <div class="w-full h-full flex flex-col p-20 lg:pl-32">
            <h1 class="lg:text-7xl text-4xl font-extrabold mb-10 transform scale-y-75 text-left">
                    {{ textContent.work_with_us.heading }}
                </h1>
            <p class="lg:pr-24 max-w-4xl mb-4">{{ textContent.work_with_us.description1 }}</p>
            <p class="lg:pr-24 max-w-4xl mb-4">{{ textContent.work_with_us.description2 }}</p>
            <p class="lg:pr-24 max-w-4xl mb-4">{{ textContent.work_with_us.description3 }}</p>
            <p class="lg:pr-24 max-w-4xl mb-4">{{ textContent.work_with_us.description4 }}</p>
            <p class="lg:pr-24 max-w-4xl mb-4">{{ textContent.work_with_us.description5 }}</p>
            </div>
   
            <Marketing 
                class="mb-40"
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

            
    </AppLayout>
</template>

<style>
* {
    color: #fff;
}
</style>