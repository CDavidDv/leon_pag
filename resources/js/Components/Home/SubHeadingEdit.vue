<template>
    <div class="flex flex-col items-center justify-center py-16 max-w-4xl mx-auto">
        <EditableText
            v-model="headingText"
            :is-editing="isEditing"
            tag="h1"
            class="lg:text-7xl text-4xl font-extrabold transform scale-y-75 text-center"
            placeholder="WE PRODUCE THINGS THAT MAKE PEOPLE CLICK AND ENGAGE WITH YOUR BRAND"
            @change="handleHeadingChange"
        />
        <EditableText
            v-model="descriptionText"
            :is-editing="isEditing"
            tag="p"
            class="text-center max-w-lg"
            placeholder="Our experience has built us an enviable reputation for consistently delivering the wow factor, underpinned with intelligent and thoughtful design that is focused on delivering a clear return on your investment."
            :multiline="true"
            @change="handleDescriptionChange"
        />
    </div>
</template>

<style scoped>
    h1 {
        line-height: 1.2;
    }
    p {
        font-family: 'New Times Roman', sans-serif;
        line-height: 1.8;
        font-weight: 100;
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
    initialHeading: {
        type: String,
        default: 'WE PRODUCE THINGS THAT MAKE PEOPLE CLICK AND ENGAGE WITH YOUR BRAND'
    },
    initialDescription: {
        type: String,
        default: 'Our experience has built us an enviable reputation for consistently delivering the wow factor, underpinned with intelligent and thoughtful design that is focused on delivering a clear return on your investment.'
    }
});

const emit = defineEmits(['text-updated']);

const headingText = ref(props.initialHeading);
const descriptionText = ref(props.initialDescription);

const handleHeadingChange = (newText) => {
    emit('text-updated', {
        section: 'subheading',
        field: 'heading',
        value: newText
    });
};

const handleDescriptionChange = (newText) => {
    emit('text-updated', {
        section: 'subheading',
        field: 'description',
        value: newText
    });
};
</script>

