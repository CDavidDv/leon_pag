<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
        'inline-flex items-center  p-10 border-b-2 border-orange-400 text-sm font-medium leading-5 text-gray-900  transition duration-150 ease-in-out m-20'
        
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<style scoped> 
* {
    font-family: 'Georgia' !important;
    font-size: 1.05rem !important;
    font-weight: 500 !important;
    color: #FFFF !important;
    text-decoration: none !important;
    transition: all 0.3s ease !important;
}
</style>