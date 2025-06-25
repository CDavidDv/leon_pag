<script setup>
import { ref, computed } from 'vue';
import VideoUploader from '@/Components/VideoUploader.vue';

const props = defineProps({
    videoHero: {
        type: String,
        default: ''
    }
});

const currentVideo = computed(() => props.videoHero);

const handleVideoUpdated = (videoData) => {
    // Emitir evento para actualizar el video en el componente padre
    emit('videoUpdated', videoData);
};

const emit = defineEmits(['videoUpdated']);
</script>

<template>
    <div class="flex flex-col justify-center items-center lg:h-screen lg:pt-44 py-16 px-12">
        <div class="w-full ">
            <h2 class="text-2xl font-bold text-white mb-6 text-center">Sección de Video</h2>
            
            <VideoUploader
                :currentVideo="currentVideo"
                section="hero"
                name="hero_video"
                alt="Video principal"
                videoClass="aspect-video w-full rounded-lg"
                previewClass="w-64 h-36 object-cover border-2 border-blue-300 rounded"
                buttonText="Cambiar video principal"
                :showEditButton="true"
                :maxSize="100"
                @videoUpdated="handleVideoUpdated"
            />
        </div>
    </div>
</template>

<style scoped>
video {
    width: 100%;
    height: 100%;
}

/* Estilos para el hover del botón de edición */
.aspect-video:hover + button,
button:hover {
    opacity: 1 !important;
}
</style>