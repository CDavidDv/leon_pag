<template>
    <div class="lg:text-center text-sm text-gray-100 pb-12 pt-12 px-12 lg:px-0">
        {{ footerText }}
    </div>
</template>

<script setup>
const props = defineProps({
    footerText: {
        type: String,
        default: "© By Experience Ltd, 2024. Guardian House, 42 Preston New Rd, Blackburn BB2 6AH    All Rights Reserved | Company registered in England & Wales number: 11469161"
    }
});
</script>

<style scoped>
    * {
        font-family: 'New Times Roman', sans-serif;
    }
</style>