<template>
    <div class="p-4 bg-white rounded-lg shadow">
        <h3 class="text-lg font-bold mb-4">Test de Imágenes</h3>
        
        <div class="space-y-4">
            <!-- Logo -->
            <div>
                <h4 class="font-semibold mb-2">Logo:</h4>
                <img 
                    :src="logoUrl" 
                    alt="Logo" 
                    class="w-32 h-32 object-contain border"
                />
                <p class="text-sm text-gray-600 mt-1">URL: {{ logoUrl }}</p>
            </div>
            
            <!-- Hero Background -->
            <div>
                <h4 class="font-semibold mb-2">Hero Background:</h4>
                <img 
                    :src="heroUrl" 
                    alt="Hero Background" 
                    class="w-64 h-32 object-cover border"
                />
                <p class="text-sm text-gray-600 mt-1">URL: {{ heroUrl }}</p>
            </div>
            
            <!-- Project 1 -->
            <div>
                <h4 class="font-semibold mb-2">Project 1:</h4>
                <img 
                    :src="project1Url" 
                    alt="Project 1" 
                    class="w-64 h-32 object-cover border"
                />
                <p class="text-sm text-gray-600 mt-1">URL: {{ project1Url }}</p>
            </div>
        </div>
        
        <!-- Debug Info -->
        <div class="mt-4 p-2 bg-gray-100 rounded">
            <h4 class="font-semibold mb-2">Debug Info:</h4>
            <pre class="text-xs">{{ JSON.stringify(props.media, null, 2) }}</pre>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = usePage().props;

const logoUrl = computed(() => {
    const logoPath = props?.media?.logo?.[0]?.path;
    if (logoPath) {
        if (logoPath.startsWith('/storage/')) {
            return logoPath;
        }
        if (logoPath.startsWith('storage/')) {
            return '/' + logoPath;
        }
        return `/storage/${logoPath}`;
    }
    return '/images/logo.svg';
});

const heroUrl = computed(() => {
    const heroPath = props?.media?.hero?.[0]?.path;
    if (heroPath) {
        if (heroPath.startsWith('/storage/')) {
            return heroPath;
        }
        if (heroPath.startsWith('storage/')) {
            return '/' + heroPath;
        }
        return `/storage/${heroPath}`;
    }
    return '/images/hero-bg.svg';
});

const project1Url = computed(() => {
    const projectPath = props?.media?.project_1?.[0]?.path;
    if (projectPath) {
        if (projectPath.startsWith('/storage/')) {
            return projectPath;
        }
        if (projectPath.startsWith('storage/')) {
            return '/' + projectPath;
        }
        return `/storage/${projectPath}`;
    }
    return '/images/project-1.svg';
});
</script> 