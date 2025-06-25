<template>
    <div class="flex justify-center items-center lg:h-screen lg:pt-44 py-16 px-12">
        <div class="w-full ">
            <video 
                v-if="videoHero"
                :src="getVideoUrl(videoHero)"
                class="aspect-video w-full"
                controls
                preload="metadata"
            >
                Tu navegador no soporta el elemento video.
            </video>
            
            <iframe 
                v-else
                class="aspect-video w-full"
                src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                title="YouTube video player" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                allowfullscreen>
            </iframe>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    videoHero: {
        type: String,
        default: ''
    }
});

const getVideoUrl = (path) => {
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
</script>

<style scoped>
    video {
        width: 100%;
        height: 100%;
    }
</style>