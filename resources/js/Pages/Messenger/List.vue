<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link} from "@inertiajs/vue3";
import {defineComponent} from "vue";
import Swal from 'sweetalert2';

export default defineComponent({
    components:{
        AppLayout,
        Link,
        Swal,
    },
    props:{
        messages: {
            type: Object
        },
        receiver: {
            type: Object
        },
        sender_id: {
            type: Object
        }
    },
    data() {
        return {
            newMessage: '',
            localMessages: this.messages,
        };
    },
    methods: {
        async sendMessage() {
            const response = await axios.post(`/send_message_to/${this.receiver.id}`, {
                newmessage: this.newMessage
            });
            this.localMessages = response.data
            console.log(response.data);
            this.newMessage = " ";
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${day}.${month}.${year} ${hours}:${minutes}`;
        }
    },
    mounted() {
        console.log('Component mounted');
        console.log('Messages:', this.messages);
        console.log('Receiver:', this.receiver);
        console.log('Sender ID:', this.sender_id);
    }
})
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex justify-between items-center">
                <Link :href="route('dashboard')" class="text-1xl text-blue-500 hover:text-blue-600">
                    <div class="flex items-center flex-row fade">
                        &larr; Назад
                    </div>
                </Link>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight fade">

                </h2>
            </div>
        </template>

        <div class="py-12 fade">
            <div class="w-3/4 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 flex items-center">
                    <div class="flex flex-col w-full">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Чат c {{receiver.name}}</h2>
                            <button @click="openChat" class="text-blue-500 hover:text-blue-600">Закрыть</button>
                        </div>
                        <div v-for="(message, index) in localMessages" :key="index" class="flex flex-col mb-2">
                            <div :class="{'bg-blue-500 text-white rounded p-2 ml-auto': message.sender_id === sender_id, 'bg-gray-500 text-white rounded p-2 mr-auto': message.sender_id !== sender_id}" style="max-width: 70%;">
                                <div :class="{'text-right': message.sender_id === sender_id, 'text-left': message.sender_id !== sender_id}">
                                    {{ message.text }}
                                    <span class="block text-xs text-gray-300">
                                        {{ formatDate(message.created_at) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <input v-model="newMessage" @keydown.enter="sendMessage" placeholder="Введите сообщение..." class="border border-gray-300 rounded p-2 mt-4">
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.image {
    width: 500px;
    height: 500px;
    object-fit: cover;
}

.fade {
    opacity: 0;
    animation: fadeIn 0.5s ease-in-out forwards;
    transform: translateX(-20px);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Остальные стили */
</style>
