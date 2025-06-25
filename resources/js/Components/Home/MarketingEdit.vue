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
                <EditableText
                    v-model="designTitle"
                    :is-editing="isEditing"
                    tag="h2"
                    class="text-lg font-bold mb-4"
                    placeholder="DESIGN BY EXPERIENCE"
                    @change="handleDesignTitleChange"
                />
                <ul>
                    <li v-for="(item, index) in designItems" :key="index">
                        <EditableText
                            v-model="designItems[index]"
                            :is-editing="isEditing"
                            tag="span"
                            placeholder="Brand strategy"
                            @change="(newText) => handleDesignItemChange(index, newText)"
                        />
                    </li>
                </ul>
            </div>
            <div class="flex flex-col lg:items-center lg:text-center">
                <EditableText
                    v-model="marketingTitle"
                    :is-editing="isEditing"
                    tag="h2"
                    class="text-lg font-bold mb-4"
                    placeholder="MARKETING BY EXPERIENCE"
                    @change="handleMarketingTitleChange"
                />
                <ul>
                    <li v-for="(item, index) in marketingItems" :key="index">
                        <EditableText
                            v-model="marketingItems[index]"
                            :is-editing="isEditing"
                            tag="span"
                            placeholder="Marketing strategy"
                            @change="(newText) => handleMarketingItemChange(index, newText)"
                        />
                    </li>
                </ul>
            </div>
            <div class="flex flex-col lg:items-center lg:text-center">
                <EditableText
                    v-model="strategyTitle"
                    :is-editing="isEditing"
                    tag="h2"
                    class="text-lg font-bold mb-4"
                    placeholder="STRATEGY BY EXPERIENCE"
                    @change="handleStrategyTitleChange"
                />
                <ul>
                    <li v-for="(item, index) in strategyItems" :key="index">
                        <EditableText
                            v-model="strategyItems[index]"
                            :is-editing="isEditing"
                            tag="span"
                            placeholder="Digital transformation"
                            @change="(newText) => handleStrategyItemChange(index, newText)"
                        />
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import EditableText from '@/Components/EditableText.vue';
import { ref } from 'vue';

const props = defineProps({
    images: {
        type: Array,
        default: () => []
    },
    isEditing: {
        type: Boolean,
        default: false
    },
    initialDesignTitle: {
        type: String,
        default: "DESIGN BY EXPERIENCE"
    },
    initialMarketingTitle: {
        type: String,
        default: "MARKETING BY EXPERIENCE"
    },
    initialStrategyTitle: {
        type: String,
        default: "STRATEGY BY EXPERIENCE"
    },
    initialDesignItems: {
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
    initialMarketingItems: {
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
    initialStrategyItems: {
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

const emit = defineEmits(['text-updated']);

// Textos editables
const designTitle = ref(props.initialDesignTitle);
const marketingTitle = ref(props.initialMarketingTitle);
const strategyTitle = ref(props.initialStrategyTitle);
const designItems = ref([...props.initialDesignItems]);
const marketingItems = ref([...props.initialMarketingItems]);
const strategyItems = ref([...props.initialStrategyItems]);

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

// Funciones para manejar cambios de texto
const handleDesignTitleChange = (newText) => {
    emit('text-updated', {
        section: 'marketing',
        field: 'design_title',
        value: newText
    });
};

const handleMarketingTitleChange = (newText) => {
    emit('text-updated', {
        section: 'marketing',
        field: 'marketing_title',
        value: newText
    });
};

const handleStrategyTitleChange = (newText) => {
    emit('text-updated', {
        section: 'marketing',
        field: 'strategy_title',
        value: newText
    });
};

const handleDesignItemChange = (index, newText) => {
    emit('text-updated', {
        section: 'marketing',
        field: `design_item_${index}`,
        value: newText
    });
};

const handleMarketingItemChange = (index, newText) => {
    emit('text-updated', {
        section: 'marketing',
        field: `marketing_item_${index}`,
        value: newText
    });
};

const handleStrategyItemChange = (index, newText) => {
    emit('text-updated', {
        section: 'marketing',
        field: `strategy_item_${index}`,
        value: newText
    });
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

