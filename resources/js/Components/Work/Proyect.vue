<script setup>
import { computed } from 'vue';
import ProjectImage from './ProjectImage.vue';

const props = defineProps({
    title: {
        type: String,
        default: 'Título del proyecto'
    },
    linkText: {
        type: String,
        default: 'Enlace del proyecto'
    },
    link: {
        type: String,
        default: '#'
    },
    descriptions: {
        type: Array,
        default: () => []
    },
    images: {
        type: Array,
        default: () => []
    },
    layout: {
        type: String,
        default: '2'
    },
    projectId: {
        type: String,
        required: true
    },
    isEditing: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['image-updated']);

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

// Computed para las imágenes con URLs corregidas
const processedImages = computed(() => {
    return props.images.map(image => ({
        ...image,
        path: image.url || getImageUrl(image.path)
    }));
});

// Función para manejar actualización de imagen individual
const handleImageUpdated = (data) => {
    emit('image-updated', data);
};

// Función para agregar nueva imagen
const addNewImage = () => {
    // Crear un input de archivo temporal
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*,video/*';
    input.style.display = 'none';
    
    input.onchange = (event) => {
        const file = event.target.files[0];
        if (file) {
            // Determinar si es imagen o video
            const isVideo = file.type.startsWith('video/');
            
            // Encontrar el siguiente índice disponible
            let nextIndex = 1;
            const existingNames = processedImages.value.map(img => img.name);
            
            if (isVideo) {
                // Buscar el siguiente índice para videos
                while (existingNames.includes(`video_${nextIndex}`)) {
                    nextIndex++;
                }
            } else {
                // Buscar el siguiente índice para imágenes
                while (existingNames.includes(`image_${nextIndex}`)) {
                    nextIndex++;
                }
            }
            
            console.log('Agregando nueva imagen/video:', { 
                type: isVideo ? 'video' : 'image', 
                nextIndex, 
                projectId: props.projectId 
            });
            
            // Emitir evento para agregar nueva imagen/video
            emit('image-updated', {
                projectId: props.projectId,
                imageIndex: nextIndex - 1,
                file: file,
                type: isVideo ? 'video' : 'image',
                action: 'add'
            });
        }
        
        // Limpiar el input
        document.body.removeChild(input);
    };
    
    document.body.appendChild(input);
    input.click();
};

function getMediaIndex(rowIndex, colIndex) {
    let index = 0;
    for (let i = 0; i < rowIndex; i++) {
        index += props.imageColumns[i];
    }
    return index + colIndex - 1;
}
</script>

<template>
    <div>
        <!-- Contenido del proyecto -->
        <div class="flex flex-col gap-4 pl-20 pt-20">
            <a :href="link" class="text-white lg:text-2xl text-xl font-bold">{{ linkText }}</a>
            <h1 class="text-white lg:text-7xl text-4xl font-extrabold leading-none max-w-[500px]">{{ title }}</h1>
            <div class="text-white max-w-md flex flex-col gap-4 mb-20 pr-14">
                <p v-for="(description, index) in descriptions" :key="index">{{ description }}</p>
            </div>
        </div>

        <!-- Imágenes del proyecto -->
        <div v-if="processedImages && processedImages.length > 0">
            <!-- Layout 1: 1 imagen (ancho completo) -->
            <div v-if="layout === '1'" class="w-full h-full">
                <ProjectImage
                    :project-id="projectId"
                    :image-index="0"
                    :current-image="processedImages[0]"
                    :is-editing="isEditing"
                    @image-updated="handleImageUpdated"
                />
            </div>

            <!-- Layout 2: 2 imágenes (lado a lado) -->
            <div v-else-if="layout === '2'" class="flex lg:flex-row flex-col w-full">
                <div v-for="(image, index) in processedImages.slice(0, 2)" :key="index" class="lg:w-1/2 w-full h-full">
                    <ProjectImage
                        :project-id="projectId"
                        :image-index="index"
                        :current-image="image"
                        :is-editing="isEditing"
                        @image-updated="handleImageUpdated"
                    />
                </div>
            </div>
            
            <!-- Layout 3: 3 imágenes (1 grande, 2 pequeñas) -->
            <div v-else-if="layout === '3'">
                <div class="w-full h-full">
                    <ProjectImage
                        :project-id="projectId"
                        :image-index="0"
                        :current-image="processedImages[0]"
                        :is-editing="isEditing"
                        @image-updated="handleImageUpdated"
                    />
                </div>
                <div class="flex lg:flex-row flex-col w-full">
                    <div v-for="(image, index) in processedImages.slice(1, 3)" :key="index" class="lg:w-1/2 w-full h-full">
                        <ProjectImage
                            :project-id="projectId"
                            :image-index="index + 1"
                            :current-image="image"
                            :is-editing="isEditing"
                            @image-updated="handleImageUpdated"
                        />
                    </div>
                </div>
            </div>

            <!-- Layout 4: 4 imágenes (2x2) -->
            <div v-else-if="layout === '4'">
                <div class="flex lg:flex-row flex-col w-full">
                    <div v-for="(image, index) in processedImages.slice(0, 2)" :key="index" class="lg:w-1/2 w-full h-full">
                        <ProjectImage
                            :project-id="projectId"
                            :image-index="index"
                            :current-image="image"
                            :is-editing="isEditing"
                            @image-updated="handleImageUpdated"
                        />
                    </div>
                </div>
                <div class="flex lg:flex-row flex-col w-full">
                    <div v-for="(image, index) in processedImages.slice(2, 4)" :key="index" class="lg:w-1/2 w-full h-full">
                        <ProjectImage
                            :project-id="projectId"
                            :image-index="index + 2"
                            :current-image="image"
                            :is-editing="isEditing"
                            @image-updated="handleImageUpdated"
                        />
                    </div>
                </div>
            </div>

            <!-- Layout 5: 5 imágenes (2 arriba, 3 abajo) -->
            <div v-else-if="layout === '5'">
                <div class="flex lg:flex-row flex-col w-full">
                    <div v-for="(image, index) in processedImages.slice(0, 2)" :key="index" class="lg:w-1/2 w-full h-full">
                        <ProjectImage
                            :project-id="projectId"
                            :image-index="index"
                            :current-image="image"
                            :is-editing="isEditing"
                            @image-updated="handleImageUpdated"
                        />
                    </div>
                </div>
                <div class="flex lg:flex-row flex-col w-full">
                    <div v-for="(image, index) in processedImages.slice(2, 5)" :key="index" class="lg:w-1/3 w-full h-full">
                        <ProjectImage
                            :project-id="projectId"
                            :image-index="index + 2"
                            :current-image="image"
                            :is-editing="isEditing"
                            @image-updated="handleImageUpdated"
                        />
                    </div>
                </div>
            </div>

            <!-- Layout dinámico: mostrar todas las imágenes en grid responsivo -->
            <div v-else-if="layout === 'dynamic'">
                <!-- Si solo hay una imagen, mostrarla a ancho completo -->
                <div v-if="processedImages.length === 1" class="w-full h-96 lg:h-[500px]">
                    <ProjectImage
                        :project-id="projectId"
                        :image-index="0"
                        :current-image="processedImages[0]"
                        :is-editing="isEditing"
                        @image-updated="handleImageUpdated"
                    />
                </div>
                <!-- Si hay múltiples imágenes, usar grid -->
                <div v-else class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                    <div v-for="(image, index) in processedImages" :key="index" class="w-full h-64 lg:h-80">
                        <ProjectImage
                            :project-id="projectId"
                            :image-index="index"
                            :current-image="image"
                            :is-editing="isEditing"
                            @image-updated="handleImageUpdated"
                        />
                    </div>
                </div>
            </div>

            <!-- Layout por defecto: mostrar todas las imágenes en fila -->
            <div v-else class="flex lg:flex-row flex-col w-full flex-wrap">
                <div v-for="(image, index) in processedImages" :key="index" class="lg:w-1/2 w-full h-full">
                    <ProjectImage
                        :project-id="projectId"
                        :image-index="index"
                        :current-image="image"
                        :is-editing="isEditing"
                        @image-updated="handleImageUpdated"
                    />
                </div>
            </div>
        </div>

        <!-- Placeholder si no hay imágenes -->
        <div v-else class="flex lg:flex-row flex-col w-full">
            <div class="lg:w-1/2 w-full h-full">
                <ProjectImage
                    :project-id="projectId"
                    :image-index="0"
                    :current-image="null"
                    :placeholder-image="'/images/work/swish-fibre/1.png'"
                    :is-editing="isEditing"
                    @image-updated="handleImageUpdated"
                />
            </div>
            <div class="lg:w-1/2 w-full h-full">
                <ProjectImage
                    :project-id="projectId"
                    :image-index="1"
                    :current-image="null"
                    :placeholder-image="'/images/work/swish-fibre/2.png'"
                    :is-editing="isEditing"
                    @image-updated="handleImageUpdated"
                />
            </div>
        </div>

        <!-- Botón para agregar nueva imagen -->
        <div v-if="isEditing" class="flex justify-center mt-8 mb-8">
            <button 
                @click="addNewImage"
                class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-bold transition-all duration-300 flex items-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Agregar Nueva Imagen
            </button>
        </div>
    </div>
</template>

<style scoped>
p {
    font-family: 'Times New Roman';
    font-size: 1.2rem;
    font-weight: 100;
    letter-spacing: -0.02em;
}

video {
    background-color: #000;
}
</style>
