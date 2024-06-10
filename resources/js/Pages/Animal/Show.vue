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
        animal: {
            type: Object
        },
        animalData: {
            type: Object
        }
    },
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
                    Создание объявления
                </h2>
            </div>
        </template>

        <div class="py-12 fade">
            <div class="w-3/4 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 flex items-center">
                    <img :src="`/storage/` + animal.image" alt="Animal Image" class="image rounded mr-8">
                    <div class="ml-28">
                        <p class="text-2xl font-medium mb-2">{{ animal.note }}</p>
                        <div class="flex items-center mb-2 border-b border-gray-300">
                            <p class="mr-4">{{ animalData.created_at }}</p>
                            <p class="text-indigo-500">{{ animalData.region }}</p>
                            <p class="ml-3 text-indigo-500 ">{{ animalData.city }}</p>
                        </div>
                        <ul class="list-disc ml-8 mb-4 ">
                            <li><strong>Пол:</strong> {{ animal.gender }}</li>
                            <li><strong>Дата рождения:</strong> {{ animal.date_of_birth }}</li>
                            <li><strong>Порода:</strong> {{ animal.breed }}</li>
                            <li><strong>Цена:</strong> {{ animal.price }}&#8376;</li>
                        </ul>
                        <div class="border-t border-gray-300 pt-4">
                            <p class="text-xl font-semibold">Продавец</p>
                            <br>
                            <p class="mb-1">{{ animalData.owner }}</p>
                            <p>На сайте с {{ animalData.owner_date_registration }}</p>
                            <p class="text-white bg-indigo-500 px-6 py-2 rounded hover:bg-indigo-600"><a :href="'/send_message/' + animalData.owner_id">Отправить сообщение</a></p>
                        </div>
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
