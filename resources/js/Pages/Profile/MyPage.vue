<template>
    <AppLayout title="Dashboard">
        <div class="flex">
            <!-- User data container -->
            <div class="filter bg-white mr-6 mt-8 mb-32 ml-6 p-8 rounded sticky-container">
                <h2 class="text-xl font-semibold mb-4">Мои объявления</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div v-for="animal in animals" :key="animal.id" class="card border border-gray-300 rounded-md shadow-md overflow-hidden">
                        <div class="card-image">
                            <img :src="`/storage/` + animal.image" alt="Animal Image" class="w-full h-64 object-cover">
                        </div>
                        <div class="card-content p-4">
                            <h3 class="text-lg font-semibold">
                                {{ animal.type == 1 ? 'Лошадь' : (animal.type == 2 ? 'Корова' : '') }} - {{ animal.breed }}
                            </h3>
                            <p class="text-gray-600">{{ animal.gender }}, Дата рождения: {{ animal.date_of_birth }}</p>
                            <p class="text-gray-700 mt-2">{{ animal.note }}</p>
                            <div class="flex justify-between">
                                <Link :href="route('animal.show', [animal.id])" class="mt-4 text-blue-500 hover:underline">Подробнее</Link>
                                <Link :href="route('animal.delete', [animal.id])" class="mt-4 text-red-500 hover:underline">Удалить</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Cards container -->
            <div class="flex-1 bg-white rounded mt-8 mr-6 mb-32 p-8">
                <div>
                    <h3 class="text-lg font-semibold mb-2">{{ user.name }}</h3>
                    <p class="text-gray-600 mb-1">{{ user.email }}</p>
                    <p class="text-gray-600">Дата создания: {{ new Date(user.created_at).toLocaleDateString() }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>


<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link} from "@inertiajs/vue3";
import {defineComponent} from "vue";
import axios from "axios";

export default defineComponent({
    name: 'Autoplay',
    components: {
        Link,
        AppLayout,
    },
    props: {
        user: {
            type: Object,
        },
        animals: {
            type: Object,
        }
    }
})
</script>

<style scoped>
</style>
