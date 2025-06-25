<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import EditableText from '@/Components/EditableText.vue';

const props = defineProps({
    title: String,
    isEditing: {
        type: Boolean,
        default: false
    },
    initialContactTitle: {
        type: String,
        default: "LET'S WORK TOGETHER"
    },
    initialContactDescription: {
        type: String,
        default: "We'd love to hear from you, whether you just want to shoot the breeze or discuss a potential opportunity to achieve great things together."
    },
    initialGetInTouch: {
        type: String,
        default: "Get in touch"
    },
    initialSendButton: {
        type: String,
        default: "Send"
    }
});

const emit = defineEmits(['text-updated']);

const showingNavigationDropdown = ref(false);
const isNavbarVisible = ref(true);
let lastScrollTop = 0;

// Textos editables
const contactTitle = ref(props.initialContactTitle);
const contactDescription = ref(props.initialContactDescription);
const getInTouch = ref(props.initialGetInTouch);
const sendButton = ref(props.initialSendButton);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};

const handleScroll = () => {
    const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
    
    // Si estamos cerca del tope (menos de 100px), mostrar el navbar
    if (currentScroll < 100) {
        isNavbarVisible.value = true;
    } else if (currentScroll > lastScrollTop && currentScroll > 300) {
        // Scroll hacia abajo y más de 300px
        isNavbarVisible.value = false;
    } else if (currentScroll < lastScrollTop && currentScroll < lastScrollTop - 20) {
        // Scroll hacia arriba y más de 20px
        isNavbarVisible.value = true;
    }
    
    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});

const showBarContact = () => {
    console.log('showBarContact');
    isShowBarContact.value = !isShowBarContact.value;
}

const isShowBarContact = ref(false);
const isShowBarContactMobile = ref(false);
const isShowMenuMobile = ref(false);

const showMenuMobile = () => {
    isShowMenuMobile.value = !isShowMenuMobile.value;
}

const showBarContactMobile = () => {
    isShowBarContactMobile.value = !isShowBarContactMobile.value;
    if(isShowBarContactMobile.value){
        isShowMenuMobile.value = false;
        isShowBarContact.value = false;
    }
}

// Funciones para manejar cambios de texto
const handleContactTitleChange = (newText) => {
    emit('text-updated', {
        section: 'layout',
        field: 'contact_title',
        value: newText
    });
};

const handleContactDescriptionChange = (newText) => {
    emit('text-updated', {
        section: 'layout',
        field: 'contact_description',
        value: newText
    });
};

const handleGetInTouchChange = (newText) => {
    emit('text-updated', {
        section: 'layout',
        field: 'get_in_touch',
        value: newText
    });
};

const handleSendButtonChange = (newText) => {
    emit('text-updated', {
        section: 'layout',
        field: 'send_button',
        value: newText
    });
};

// Exponer la función para que el componente hijo pueda acceder a ella
defineExpose({
    showBarContact
});
</script>

<template>
    <div class="overflow-x-hidden">
        <Head :title="title" />

        <Banner />

        <div v-if="isShowMenuMobile" id="menuMobile" class="fixed  w-full h-full flex flex-col justify-end bottom-0 bg-[#0A15E3] left-0 right-0 z-[100]" >
            <div class="fixed top-0 pr-14 mt-10 right-0">
                <div class="size-10  cursor-pointer  flex justify-center  items-center" @click="showMenuMobile">
                    <svg xmlns="http://www.w3.org/2000/svg"  clas1s="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </div>

            </div>
            <div class="flex flex-col gap-4 p-10 w-full h-full justify-center items-start font-extrabold text-white ">
                <div class="space-x-4 sm:-my-px sm:ms-10 lg:flex text-2xl">
                            <ResponsiveNavLink :href="route('index')" :active="route().current('index')">
                                Home
                            </ResponsiveNavLink>
                        </div>
                        <div class="space-x-4 sm:-my-px sm:ms-10 lg:flex">
                            <ResponsiveNavLink :href="route('work')" :active="route().current('work')">
                                Work
                            </ResponsiveNavLink>
                        </div>
                        <div class="space-x-4 sm:-my-px sm:ms-10 lg:flex">
                            <ResponsiveNavLink :href="route('approach')" :active="route().current('approach')">
                                Aproach
                            </ResponsiveNavLink>
                        </div>
                        
                        <div class="space-x-4 sm:-my-px sm:ms-10 lg:flex">
                            <ResponsiveNavLink :href="route('about')" :active="route().current('about')">
                                About Us
                            </ResponsiveNavLink>
                        </div>

                        <div class="cursor-pointer space-x-4 sm:-my-px sm:ms-10 lg:flex ">
                            <EditableText
                                v-model="getInTouch"
                                :is-editing="isEditing"
                                tag="div"
                                class="text-white text-5xl font-extrabold"
                                placeholder="Get in touch"
                                @change="handleGetInTouchChange"
                            />
                        </div>
            </div>
        </div>

        <div v-if="isShowBarContact" id="barContact" class="fixed w-full h-full  flex justify-end bottom-0 left-0 right-0 bg-black/40 z-[100]" @click.self="showBarContact">
            <div class="w-7/12 h-full bg-[#0A15E3] overflow-y-auto">
                <div class="p-4">
                    <div class="flex justify-between">
                        <div class="flex flex-col pl-10 pr-10">
                            <div class="flex justify-between -mt-14">
                                <EditableText
                                    v-model="contactTitle"
                                    :is-editing="isEditing"
                                    tag="h1"
                                    class="text-8xl font-extrabold transform scale-y-75"
                                    placeholder="LET'S WORK TOGETHER"
                                    @change="handleContactTitleChange"
                                />
                                <div class="w-1/2 h-full flex justify-end items-center">
                                    <div class="size-10 cursor-pointer flex justify-center  items-center" @click="showBarContact">
                                        <svg xmlns="http://www.w3.org/2000/svg"  clas1s="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <EditableText
                                v-model="contactDescription"
                                :is-editing="isEditing"
                                tag="p"
                                class="max-w-2xl pb-8"
                                placeholder="We'd love to hear from you, whether you just want to shoot the breeze or discuss a potential opportunity to achieve great things together."
                                :multiline="true"
                                @change="handleContactDescriptionChange"
                            />
                            
                            <div class="flex flex-col gap-2">
                                <input type="text" class="w-full hover:bg-white/10 h-10 border border-white bg-white/5 text-white rounded-md pl-8 py-10 mb-2 text-xl focus:border-white focus:bg-white/10 focus:border-2 placeholder-white" placeholder="Name">
                                <input type="text" class="w-full hover:bg-white/10 h-10 border border-white bg-white/5 text-white rounded-md pl-8 py-10 mb-2 text-xl focus:border-white focus:bg-white/10 focus:border-2 placeholder-white" placeholder="Your email address">
                                <input type="text" class="w-full hover:bg-white/10 h-10 border border-white bg-white/5 text-white rounded-md pl-8 py-10 mb-2 text-xl focus:border-white focus:bg-white/10 focus:border-2 placeholder-white" placeholder="Add message">
                                <EditableText
                                    v-model="sendButton"
                                    :is-editing="isEditing"
                                    tag="button"
                                    class="w-full h-32 bg-blue-950/70 uppercase font-extrabold text-white text-4xl transform scale-y-75 rounded-md p-2"
                                    placeholder="Send"
                                    @change="handleSendButtonChange"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div v-if="isShowBarContactMobile" id="barContactMobile" class="fixed  w-full h-full flex justify-end bottom-0 left-0 right-0 bg-black/40 z-[100]" @click.self="showBarContactMobile">
            <div class="w-full h-full bg-[#0A15E3]  overflow-y-auto">
                <div class="w-full flex  justify-end pr-10 pt-10" >
                    <div class="size-10 cursor-pointer flex justify-center  items-center" @click="showBarContactMobile">
                        <svg xmlns="http://www.w3.org/2000/svg"  clas1s="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </div>
                </div>
                <div class="p-4 pt-20">
                    
                    <div class="flex justify-between">
                        
                        <div class="flex flex-col pl-10 pr-10">
                            
                            <div class="flex justify-between -mt-14">
                                <EditableText
                                    v-model="contactTitle"
                                    :is-editing="isEditing"
                                    tag="h1"
                                    class="text-8xl font-extrabold transform scale-y-75"
                                    placeholder="LET'S WORK TOGETHER"
                                    @change="handleContactTitleChange"
                                />
                                <div class="w-1/2 h-full flex justify-end items-center">
                                    
                                </div>
                            </div>
                            <EditableText
                                v-model="contactDescription"
                                :is-editing="isEditing"
                                tag="p"
                                class="max-w-2xl pb-8"
                                placeholder="We'd love to hear from you, whether you just want to shoot the breeze or discuss a potential opportunity to achieve great things together."
                                :multiline="true"
                                @change="handleContactDescriptionChange"
                            />
                            
                            <div class="flex flex-col gap-2">
                                <input type="text" class="w-full hover:bg-white/10 h-10 border border-white bg-white/5 text-white rounded-md pl-8 py-10 mb-2 text-xl focus:border-white focus:bg-white/10 focus:border-2 placeholder-white" placeholder="Name">
                                <input type="text" class="w-full hover:bg-white/10 h-10 border border-white bg-white/5 text-white rounded-md pl-8 py-10 mb-2 text-xl focus:border-white focus:bg-white/10 focus:border-2 placeholder-white" placeholder="Your email address">
                                <input type="text" class="w-full hover:bg-white/10 h-10 border border-white bg-white/5 text-white rounded-md pl-8 py-10 mb-2 text-xl focus:border-white focus:bg-white/10 focus:border-2 placeholder-white" placeholder="Add message">
                                <EditableText
                                    v-model="sendButton"
                                    :is-editing="isEditing"
                                    tag="button"
                                    class="w-full h-32 bg-blue-950/70 uppercase font-extrabold text-white text-4xl transform scale-y-75 rounded-md p-2"
                                    placeholder="Send"
                                    @change="handleSendButtonChange"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <nav :class="[
                'fixed w-full z-50 transition-all duration-300 pt-5',
                isNavbarVisible ? 'translate-y-0' : '-translate-y-full',
                'lg:bg-transparent bg-[#0A15E3] pb-8 lg:pb-0'
            ]">

                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto   sm:px-6 md:px-1 lg:px-8">
                    <div class="flex justify-between h-16 pt-6">
                        <div class="flex justify-end">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <ApplicationMark class="block h-14 p-1 pl-8 w-auto" />
                            </div>
    
                            <!-- Navigation Links -->

                            
                        </div>
                        <div class="hidden xl:flex">

                            <div class="hidden space-x-4 sm:-my-px sm:ms-10 lg:flex">
                                <NavLink :href="route('index')" :active="route().current('index')">
                                    Home
                                </NavLink>
                            </div>
                            <div class="hidden space-x-4 sm:-my-px sm:ms-10 lg:flex">
                                <NavLink :href="route('work')" :active="route().current('work')">
                                    Work
                                </NavLink>
                            </div>
                            <div class="hidden space-x-4 sm:-my-px sm:ms-10 lg:flex">
                                <NavLink :href="route('approach')" :active="route().current('approach')">
                                    Aproach
                                </NavLink>
                            </div>
                            
                            <div class="hidden space-x-4 sm:-my-px sm:ms-10 lg:flex">
                                <NavLink :href="route('about')" :active="route().current('about')">
                                    About Us
                                </NavLink>
                            </div>

                            <div class="hidden cursor-pointer space-x-4 sm:-my-px sm:ms-10 lg:flex">
                                <EditableText
                                    v-model="getInTouch"
                                    :is-editing="isEditing"
                                    tag="div"
                                    placeholder="Get in touch"
                                    @change="handleGetInTouchChange"
                                />
                            </div>
                        </div>

                        <div class="flex xl:hidden">
                            <div class="flex justify-end size-10 cursor-pointer text-white p-2 mr-5 mt-0" @click="showMenuMobile">
                                <svg data-bbox="25.264 17.534 149.471 164.932" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" data-type="shape" class="text-white" currentColor="white">
                                    <g>
                                        <path d="M35.572 38.15h128.855c5.693 0 10.308-4.616 10.308-10.308s-4.616-10.308-10.308-10.308H35.572c-5.693 0-10.308 4.616-10.308 10.308S29.88 38.15 35.572 38.15z"></path>
                                        <path d="M164.428 89.692H35.572c-5.693 0-10.308 4.616-10.308 10.308s4.616 10.308 10.308 10.308h128.855c5.693 0 10.308-4.616 10.308-10.308s-4.615-10.308-10.307-10.308z"></path>
                                        <path d="M164.428 161.85H87.114c-5.693 0-10.308 4.616-10.308 10.308 0 5.693 4.616 10.308 10.308 10.308h77.313c5.693 0 10.308-4.616 10.308-10.308.001-5.692-4.615-10.308-10.307-10.308z"></path>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Home
                        </ResponsiveNavLink>
                    </div>
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Inventario
                        </ResponsiveNavLink>
                    </div>
                    
                    
                    
                    

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page?.props?.auth?.user?.profile_photo_url" :alt="$page?.props?.auth?.user?.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page?.props?.auth?.user?.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page?.props?.auth?.user?.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Perfil
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Cerrar sesión
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)" :active="route().current('teams.show')">
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">
                                    Create New Team
                                </ResponsiveNavLink>

                                <!-- Team Switcher -->
                                <template v-if="$page.props.auth.user.all_teams.length > 1">
                                    <div class="border-t border-gray-200" />

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Switch Teams
                                    </div>

                                    <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <ResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id == $page.props.auth.user.current_team_id" class="me-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>                    
                <slot />
            </main>
        </div>
    </div>
</template>

<style>
main {
    font-family: 'Anton', sans-serif;
    background-color: #0A15E3 !important;
}

main {
    padding: 0 !important;
    margin: 0 !important;
}

</style>