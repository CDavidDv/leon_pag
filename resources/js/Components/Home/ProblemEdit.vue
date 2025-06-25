<template>
    <div class="flex flex-col items-center justify-center py-16 max-w-4xl mx-auto">
        <EditableText
            v-model="headingText"
            :is-editing="isEditing"
            tag="h1"
            class="lg:text-7xl text-4xl font-extrabold transform scale-y-75 text-center"
            placeholder="WE MAKE LIGHT WORK OF WEIGHTY PROBLEMS"
            @change="handleHeadingChange"
        />
        <EditableText
            v-model="description1Text"
            :is-editing="isEditing"
            tag="p"
            class="text-center lg:max-w-2xl max-w-3xl"
            placeholder="We make light work of weighty problems, without any of the traditional agency baggage which can slow things down and pile on the pounds. We solve any project type and challenge using our simple yet rigorous three-stage process. Whether you want to be fully hands-on or favour a more light-touch approach, you're the hero of the story. The three stages ensure we carefully progress your solution with transparency, giving you plenty of opportunity to shape and guide it as it evolves from the initial planning stage to launch and beyond."
            :multiline="true"
            @change="handleDescription1Change"
        />
        <br>
        <EditableText
            v-model="description2Text"
            :is-editing="isEditing"
            tag="p"
            class="text-center max-w-2xl"
            placeholder="It's been proven to work time and again, for any type of project and level of complexity. It helps maximise efficiency and accelerate timescales when required, without compromising on quality."
            :multiline="true"
            @change="handleDescription2Change"
        />
    </div>
</template>

<style scoped>
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
        default: 'WE MAKE LIGHT WORK OF WEIGHTY PROBLEMS'
    },
    initialDescription1: {
        type: String,
        default: 'We make light work of weighty problems, without any of the traditional agency baggage which can slow things down and pile on the pounds. We solve any project type and challenge using our simple yet rigorous three-stage process. Whether you want to be fully hands-on or favour a more light-touch approach, you\'re the hero of the story. The three stages ensure we carefully progress your solution with transparency, giving you plenty of opportunity to shape and guide it as it evolves from the initial planning stage to launch and beyond.'
    },
    initialDescription2: {
        type: String,
        default: 'It\'s been proven to work time and again, for any type of project and level of complexity. It helps maximise efficiency and accelerate timescales when required, without compromising on quality.'
    }
});

const emit = defineEmits(['text-updated']);

const headingText = ref(props.initialHeading);
const description1Text = ref(props.initialDescription1);
const description2Text = ref(props.initialDescription2);

const handleHeadingChange = (newText) => {
    emit('text-updated', {
        section: 'problem',
        field: 'heading',
        value: newText
    });
};

const handleDescription1Change = (newText) => {
    emit('text-updated', {
        section: 'problem',
        field: 'description1',
        value: newText
    });
};

const handleDescription2Change = (newText) => {
    emit('text-updated', {
        section: 'problem',
        field: 'description2',
        value: newText
    });
};
</script>
