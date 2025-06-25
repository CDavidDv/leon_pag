<template>
    <div class="flex flex-col lg:items-center lg:justify-center py-16 max-w-7xl mx-auto">
        <!-- Galería de imágenes si existen -->
        <div v-if="images && images.length > 0" class="mb-8 w-full">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div 
                    v-for="(imagen, index) in images" 
                    :key="index"
                    class="relative aspect-[4/3] overflow-hidden rounded-lg"
                >
                    <img 
                        :src="getImageUrl(imagen.path)" 
                        :alt="imagen.alt || 'Imagen de marketing'"
                        class="w-full h-full object-cover" 
                    />
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 w-full pl-14 lg:pl-0">
            <div class="flex flex-col lg:items-center lg:text-center">
                <h2 class="text-lg font-bold mb-4">{{ designTitle }}</h2>
                <ul>
                    <li v-for="(item, index) in designItems" :key="index">{{ item }}</li>
                </ul>
            </div>
            <div class="flex flex-col lg:items-center lg:text-center">
                <h2 class="text-lg font-bold mb-4">{{ marketingTitle }}</h2>
                <ul>
                    <li v-for="(item, index) in marketingItems" :key="index">{{ item }}</li>
                </ul>
            </div>
            <div class="flex flex-col lg:items-center lg:text-center">
                <h2 class="text-lg font-bold mb-4">{{ strategyTitle }}</h2>
                <ul>
                    <li v-for="(item, index) in strategyItems" :key="index">{{ item }}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    images: {
        type: Array,
        default: () => []
    },
    designTitle: {
        type: String,
        default: "DESIGN BY EXPERIENCE"
    },
    marketingTitle: {
        type: String,
        default: "MARKETING BY EXPERIENCE"
    },
    strategyTitle: {
        type: String,
        default: "STRATEGY BY EXPERIENCE"
    },
    designItems: {
        type: Array,
        default: () => [
            "Brand strategy",
            "Brand positioning",
            "Brand identity",
            "User Experience design",
            "User Interface design",
            "Website design",
            "Content marketing design",
            "Employee branding",
            "Motion design"
        ]
    },
    marketingItems: {
        type: Array,
        default: () => [
            "Marketing strategy",
            "Integrated marketing services",
            "Campaign design",
            "Content marketing",
            "Events design & marketing",
            "Social media content design",
            "Copywriting",
            "Lead generation",
            "Customer engagement"
        ]
    },
    strategyItems: {
        type: Array,
        default: () => [
            "Digital transformation",
            "New product development",
            "Value proposition design",
            "Product design",
            "Service design",
            "Brand consultancy",
            "Marketing consultancy",
            "Employee engagement"
        ]
    }
});

const getImageUrl = (path) => {
    if (!path) return '/images/placeholder.svg';
    
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
    
    * {
        font-family: 'New Times Roman', sans-serif;
        font-weight: 100;
    }
    h1 {
        line-height: 1.6;
        line-height: 1;
        font-weight: 1000 !important;
    }
    h2 {
        font-weight: 1000 !important;
    }
</style>

