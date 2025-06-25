<template>
    <div class="grid lg:grid-cols-4  gap-8 lg:items-center items-start lg:justify-center justify-start lg:pt-32   px-8">
        <div class="lg:text-center lg:justify-center justify-start lg:items-center items-start flex flex-col">
            <EditableText
                v-model="service1Title"
                :is-editing="isEditing"
                tag="h3"
                class="font-extrabold stroke-2 stroke-white mb-4 text-2xl transform scale-y-75"
                placeholder="BRAND<br/>STRATEGY"
                @change="handleService1TitleChange"
            />
            <EditableText
                v-model="service1Description"
                :is-editing="isEditing"
                tag="p"
                class="text-sm lg:w-4/5 pr-10 lg:pr-0"
                placeholder="Full strategy design and execution for new and refresh brand projects, including positioning, brand architecture, identity, comprehensive guidelines and training."
                :multiline="true"
                @change="handleService1DescriptionChange"
            />
        </div>
        <div class="lg:justify-center justify-start lg:items-center items-start flex flex-col">
            <EditableText
                v-model="service2Title"
                :is-editing="isEditing"
                tag="h3"
                class="font-extrabold stroke-2 stroke-white mb-4 text-2xl transform scale-y-75"
                placeholder="PROPOSITION<br/>DESIGN"
                @change="handleService2TitleChange"
            />
            <EditableText
                v-model="service2Description"
                :is-editing="isEditing"
                tag="p"
                class="text-sm"
                placeholder="Product and Service design for new and existing solutions, including value proposition, UX, UI, visual design and marketing support."
                :multiline="true"
                @change="handleService2DescriptionChange"
            />
        </div>
        <div class="lg:justify-center justify-start lg:items-center items-start flex flex-col">
            <EditableText
                v-model="service3Title"
                :is-editing="isEditing"
                tag="h3"
                class="font-extrabold stroke-2 stroke-white mb-4 text-2xl transform scale-y-75"
                placeholder="CREATIVE<br/>MARKETING"
                @change="handleService3TitleChange"
            />
            <EditableText
                v-model="service3Description"
                :is-editing="isEditing"
                tag="p"
                class="text-sm"
                placeholder="Marketing strategy, campaign activation, events and creative support for internal and external communications and employee engagement."
                :multiline="true"
                @change="handleService3DescriptionChange"
            />
        </div>
        <div class="lg:justify-center justify-start lg:items-center items-start flex flex-col">
            <EditableText
                v-model="service4Title"
                :is-editing="isEditing"
                tag="h3"
                class="font-extrabold stroke-2 stroke-white mb-4 text-2xl transform scale-y-75"
                placeholder="ON-DEMAND<br/>SERVICES"
                @change="handleService4TitleChange"
            />
            <EditableText
                v-model="service4Description"
                :is-editing="isEditing"
                tag="p"
                class="text-sm"
                placeholder="Full-stack brand, marketing and creative services to complement and support short and long-term requirements."
                :multiline="true"
                @change="handleService4DescriptionChange"
            />
        </div>
    </div>
</template>

<style scoped>
p {
    font-size: 1.1rem;
    font-weight: 400;
    font-family: 'New Times Roman', serif;
}

</style>

<script setup>
import { ref } from 'vue';
import EditableText from '@/Components/EditableText.vue';

const props = defineProps({
    isEditing: {
        type: Boolean,
        default: false
    },
    initialService1Title: {
        type: String,
        default: 'BRAND<br/>STRATEGY'
    },
    initialService1Description: {
        type: String,
        default: 'Full strategy design and execution for new and refresh brand projects, including positioning, brand architecture, identity, comprehensive guidelines and training.'
    },
    initialService2Title: {
        type: String,
        default: 'PROPOSITION<br/>DESIGN'
    },
    initialService2Description: {
        type: String,
        default: 'Product and Service design for new and existing solutions, including value proposition, UX, UI, visual design and marketing support.'
    },
    initialService3Title: {
        type: String,
        default: 'CREATIVE<br/>MARKETING'
    },
    initialService3Description: {
        type: String,
        default: 'Marketing strategy, campaign activation, events and creative support for internal and external communications and employee engagement.'
    },
    initialService4Title: {
        type: String,
        default: 'ON-DEMAND<br/>SERVICES'
    },
    initialService4Description: {
        type: String,
        default: 'Full-stack brand, marketing and creative services to complement and support short and long-term requirements.'
    }
});

const emit = defineEmits(['text-updated']);

const service1Title = ref(props.initialService1Title);
const service1Description = ref(props.initialService1Description);
const service2Title = ref(props.initialService2Title);
const service2Description = ref(props.initialService2Description);
const service3Title = ref(props.initialService3Title);
const service3Description = ref(props.initialService3Description);
const service4Title = ref(props.initialService4Title);
const service4Description = ref(props.initialService4Description);

const handleService1TitleChange = (newText) => {
    emit('text-updated', {
        section: 'services',
        field: 'service1_title',
        value: newText
    });
};

const handleService1DescriptionChange = (newText) => {
    emit('text-updated', {
        section: 'services',
        field: 'service1_description',
        value: newText
    });
};

const handleService2TitleChange = (newText) => {
    emit('text-updated', {
        section: 'services',
        field: 'service2_title',
        value: newText
    });
};

const handleService2DescriptionChange = (newText) => {
    emit('text-updated', {
        section: 'services',
        field: 'service2_description',
        value: newText
    });
};

const handleService3TitleChange = (newText) => {
    emit('text-updated', {
        section: 'services',
        field: 'service3_title',
        value: newText
    });
};

const handleService3DescriptionChange = (newText) => {
    emit('text-updated', {
        section: 'services',
        field: 'service3_description',
        value: newText
    });
};

const handleService4TitleChange = (newText) => {
    emit('text-updated', {
        section: 'services',
        field: 'service4_title',
        value: newText
    });
};

const handleService4DescriptionChange = (newText) => {
    emit('text-updated', {
        section: 'services',
        field: 'service4_description',
        value: newText
    });
};
</script>