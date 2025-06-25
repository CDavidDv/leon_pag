<script setup>
import { ref } from 'vue';

const props = defineProps({
    image: {
        type: String,
        default: 'https://placehold.co/400x600'
    }
});


</script>
<template>
    <div class="flex h-screen justify-center items-bottom cursor-pointer">
        <img class="h-full" :src="image" alt="Hero Image">
    </div>
</template>

