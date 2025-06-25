<template>
    <Link :href="route('index')">   
        <img :src="imagenActual" alt="Logo de la empresa" class="size-full rounded-full">
    </Link>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = usePage().props;
console.log(props);
const imagenActual = computed(() => {
    const logoPath = props?.media?.logo?.[0]?.path;
    if (logoPath) {
        // Si ya tiene /storage/, no agregar nada
        if (logoPath.startsWith('/storage/')) {
            return logoPath;
        }
        // Si empieza con storage/, agregar /
        if (logoPath.startsWith('storage/')) {
            return '/' + logoPath;
        }
        // Por defecto, asumir que está en storage
        return `/storage/${logoPath}`;
    }
});
</script>