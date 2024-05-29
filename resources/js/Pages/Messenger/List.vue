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
        };
    },
    methods: {
        async sendMessage() {
            const response = await axios.post('send_message_to/')
        }
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
                        <div v-for="(message, index) in messages" :key="index" class="flex mb-2">
                            <div v-if="message.sender_id === sender_id" class="bg-blue-500 text-white rounded p-2 ml-auto">
                                {{ message.text }}
                            </div>
                            <div v-else class="bg-gray-200 text-gray-800 rounded p-2 mr-auto">
                                {{ message.text }}
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
