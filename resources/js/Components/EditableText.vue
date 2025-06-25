<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    placeholder: {
        type: String,
        default: 'Escribe aquí...'
    },
    isEditing: {
        type: Boolean,
        default: false
    },
    tag: {
        type: String,
        default: 'p'
    },
    className: {
        type: String,
        default: ''
    },
    multiline: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['update:modelValue', 'change']);

const isEditingLocal = ref(false);
const editValue = ref(props.modelValue);

// Computed para determinar si está en modo de edición
const isInEditMode = computed(() => {
    return props.isEditing && isEditingLocal.value;
});

// Función para iniciar edición
const startEdit = () => {
    if (props.isEditing) {
        isEditingLocal.value = true;
        editValue.value = props.modelValue;
    }
};

// Función para guardar cambios
const saveChanges = () => {
    if (editValue.value !== props.modelValue) {
        emit('update:modelValue', editValue.value);
        emit('change', editValue.value);
    }
    isEditingLocal.value = false;
};

// Función para cancelar edición
const cancelEdit = () => {
    editValue.value = props.modelValue;
    isEditingLocal.value = false;
};

// Función para manejar tecla Enter
const handleKeydown = (event) => {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        saveChanges();
    } else if (event.key === 'Escape') {
        cancelEdit();
    }
};

// Función para manejar pérdida de foco
const handleBlur = () => {
    saveChanges();
};
</script>

<template>
    <div class="relative">
        <!-- Modo de visualización -->
        <div v-if="!isInEditMode">
            <h1 
                v-if="tag === 'h1'"
                :class="[
                    className,
                    'cursor-pointer transition-all duration-200',
                    isEditing ? 'hover:bg-white hover:bg-opacity-10 hover:px-2 hover:py-1 hover:rounded' : ''
                ]"
                @click="startEdit"
                v-text="modelValue || placeholder"
            />
            <h2 
                v-else-if="tag === 'h2'"
                :class="[
                    className,
                    'cursor-pointer transition-all duration-200',
                    isEditing ? 'hover:bg-white hover:bg-opacity-10 hover:px-2 hover:py-1 hover:rounded' : ''
                ]"
                @click="startEdit"
                v-text="modelValue || placeholder"
            />
            <h3 
                v-else-if="tag === 'h3'"
                :class="[
                    className,
                    'cursor-pointer transition-all duration-200',
                    isEditing ? 'hover:bg-white hover:bg-opacity-10 hover:px-2 hover:py-1 hover:rounded' : ''
                ]"
                @click="startEdit"
                v-text="modelValue || placeholder"
            />
            <p 
                v-else
                :class="[
                    className,
                    'cursor-pointer transition-all duration-200',
                    isEditing ? 'hover:bg-white hover:bg-opacity-10 hover:px-2 hover:py-1 hover:rounded' : ''
                ]"
                @click="startEdit"
                v-text="modelValue || placeholder"
            />
        </div>
        
        <!-- Modo de edición -->
        <div v-else class="relative">
            <!-- Input de texto -->
            <textarea
                v-if="multiline"
                v-model="editValue"
                :placeholder="placeholder"
                :class="[
                    className,
                    'w-full bg-white bg-opacity-90 text-black px-3 py-2 rounded border-2 border-blue-500 focus:outline-none focus:border-blue-600 resize-none'
                ]"
                @keydown="handleKeydown"
                @blur="handleBlur"
                ref="textareaRef"
                rows="3"
            />
            
            <input
                v-else
                v-model="editValue"
                :placeholder="placeholder"
                :class="[
                    className,
                    'w-full bg-white bg-opacity-90 text-black px-3 py-2 rounded border-2 border-blue-500 focus:outline-none focus:border-blue-600'
                ]"
                @keydown="handleKeydown"
                @blur="handleBlur"
                ref="inputRef"
            />
            
            <!-- Botones de acción -->
            <div class="absolute top-0 right-0 transform translate-x-full ml-2 flex gap-1">
                <button
                    @click="saveChanges"
                    class="bg-green-500 hover:bg-green-600 text-white p-1 rounded text-xs"
                    title="Guardar"
                >
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </button>
                <button
                    @click="cancelEdit"
                    class="bg-red-500 hover:bg-red-600 text-white p-1 rounded text-xs"
                    title="Cancelar"
                >
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Estilos para el componente */
</style> 