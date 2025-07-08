<template>
    <div class="contact-form">
        <form @submit.prevent="submitForm" class="space-y-4">
            <!-- Nombre -->
            <div>
                <input
                    v-model="form.name"
                    type="text"
                    placeholder="Nombre"
                    class="w-full hover:bg-white/10 h-10 border border-white bg-white/5 text-white rounded-md pl-8 py-10 mb-2 text-xl focus:border-white focus:bg-white/10 focus:border-2 placeholder-white"
                    :class="{ 'border-red-500': errors.name }"
                    required
                />
                <div v-if="errors.name" class="text-red-400 text-sm mt-1">{{ errors.name[0] }}</div>
            </div>

            <!-- Email -->
            <div>
                <input
                    v-model="form.email"
                    type="email"
                    placeholder="Tu correo electrónico"
                    class="w-full hover:bg-white/10 h-10 border border-white bg-white/5 text-white rounded-md pl-8 py-10 mb-2 text-xl focus:border-white focus:bg-white/10 focus:border-2 placeholder-white"
                    :class="{ 'border-red-500': errors.email }"
                    required
                />
                <div v-if="errors.email" class="text-red-400 text-sm mt-1">{{ errors.email[0] }}</div>
            </div>

            <!-- Mensaje -->
            <div>
                <textarea
                    v-model="form.message"
                    placeholder="Mensaje"
                    rows="4"
                    class="w-full hover:bg-white/10 border border-white bg-white/5 text-white rounded-md pl-8 py-10 mb-2 text-xl focus:border-white focus:bg-white/10 focus:border-2 placeholder-white resize-none"
                    :class="{ 'border-red-500': errors.message }"
                    required
                ></textarea>
                <div v-if="errors.message" class="text-red-400 text-sm mt-1">{{ errors.message[0] }}</div>
            </div>

            <!-- Botón de envío -->
            <button
                type="submit"
                class="w-full h-32 bg-blue-950/70 uppercase font-extrabold text-white text-4xl transform scale-y-75 rounded-md p-2 hover:bg-blue-900/70 transition-colors"
                :disabled="isSubmitting"
            >
                <span v-if="isSubmitting">Enviando...</span>
                <span v-else>{{ sendButtonText }}</span>
            </button>
        </form>

        <!-- Notificaciones -->
        <div v-if="notification.show" class="fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg" :class="notificationClass">
            <div class="flex items-center gap-2">
                <svg v-if="notification.type === 'success'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span>{{ notification.message }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
    sendButtonText: {
        type: String,
        default: 'Enviar'
    }
});

const emit = defineEmits(['message-sent']);

const form = ref({
    name: '',
    email: '',
    message: ''
});

const errors = ref({});
const isSubmitting = ref(false);
const notification = ref({
    show: false,
    type: 'success',
    message: ''
});

const notificationClass = computed(() => {
    return {
        'bg-green-500 text-white': notification.value.type === 'success',
        'bg-red-500 text-white': notification.value.type === 'error'
    };
});

const showNotification = (type, message) => {
    notification.value = {
        show: true,
        type,
        message
    };
    
    setTimeout(() => {
        notification.value.show = false;
    }, 5000);
};

const submitForm = async () => {
    isSubmitting.value = true;
    errors.value = {};

    try {
        const response = await axios.post('/api/contact/send', form.value);
        
        if (response.data.success) {
            showNotification('success', 'Mensaje enviado correctamente');
            form.value = { name: '', email: '', message: '' };
            emit('message-sent');
        }
    } catch (error) {
        if (error.response?.data?.errors) {
            errors.value = error.response.data.errors;
        } else {
            showNotification('error', 'Error al enviar el mensaje. Inténtalo de nuevo.');
        }
    } finally {
        isSubmitting.value = false;
    }
};
</script> 