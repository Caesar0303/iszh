<template>
    <AppLayout title="Dashboard">
        <div class="flex justify-center bg-white p-6  top-0">
            <button @click="showFilterModal = true" class="mr-9">
                <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" width="18" height="16.941176470588236" viewBox="0 0 17 16" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.17375 2.39015H15.5334C16.0239 2.39015 16.4216 2.78782 16.4216 3.27835C16.4216 3.76888 16.0239 4.16654 15.5334 4.16654H7.17375C6.80707 5.20032 5.81982 5.94292 4.66194 5.94292C3.50406 5.94292 2.51678 5.20032 2.15013 4.16654H0.896005C0.405474 4.16654 0.0078125 3.76888 0.0078125 3.27835C0.0078125 2.78782 0.405474 2.39015 0.896005 2.39015H2.15013C2.51681 1.35637 3.50406 0.61377 4.66194 0.61377C5.81982 0.61377 6.80707 1.35637 7.17375 2.39015ZM3.77465 3.27873C3.77465 3.76848 4.17309 4.16693 4.66284 4.16693C5.15259 4.16693 5.55103 3.76848 5.55103 3.27873C5.55103 2.78898 5.15259 2.39054 4.66284 2.39054C4.17309 2.39054 3.77465 2.78898 3.77465 3.27873ZM7.17375 12.338H15.5334C16.0239 12.338 16.4216 12.7357 16.4216 13.2262C16.4216 13.7168 16.0239 14.1144 15.5334 14.1144H7.17375C6.80707 15.1482 5.81982 15.8908 4.66194 15.8908C3.50406 15.8908 2.51678 15.1482 2.15013 14.1144H0.896005C0.405474 14.1144 0.0078125 13.7168 0.0078125 13.2262C0.0078125 12.7357 0.405474 12.338 0.896005 12.338H2.15013C2.51681 11.3043 3.50406 10.5617 4.66194 10.5617C5.81982 10.5617 6.8071 11.3043 7.17375 12.338ZM3.77465 13.2264C3.77465 13.7161 4.17309 14.1146 4.66284 14.1146C5.15259 14.1146 5.55103 13.7161 5.55103 13.2264C5.55103 12.7366 5.15259 12.3382 4.66284 12.3382C4.17309 12.3382 3.77465 12.7366 3.77465 13.2264ZM15.5334 7.36416H14.2793C13.9126 6.33037 12.9254 5.58777 11.7675 5.58777C10.6096 5.58777 9.62235 6.33037 9.25567 7.36416H0.896005C0.405474 7.36416 0.0078125 7.76182 0.0078125 8.25235C0.0078125 8.74288 0.405474 9.14054 0.896005 9.14054H9.25567C9.62232 10.1743 10.6096 10.9169 11.7675 10.9169C12.9254 10.9169 13.9126 10.1743 14.2793 9.14054H15.5334C16.0239 9.14054 16.4216 8.74288 16.4216 8.25235C16.4216 7.76182 16.0239 7.36416 15.5334 7.36416ZM11.7683 9.14069C11.2786 9.14069 10.8801 8.74225 10.8801 8.2525C10.8801 7.76275 11.2786 7.36431 11.7683 7.36431C12.2581 7.36431 12.6565 7.76275 12.6565 8.2525C12.6565 8.74225 12.2581 9.14069 11.7683 9.14069Z" fill="#1D262D"></path>
                </svg>
            </button>
            <input class="search w-1/2 py-2 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500" placeholder="Поиск">
        </div>
        <div class="flex">
            <div v-if="showFilterModal" class="fixed left-1 z-10 flex items-center justify-center fade" >
                <div class="bg-white mb-50 p-8 rounded w-80 top-0">
                    <form @submit.prevent="searchAnimals">
                        <div class="flex justify-between">
                        <Link :href="route('animals')" class="text-1xl text-blue-500 hover:text-blue-600">
                            <div class="flex items-center flex-row">
                                Сборосить
                            </div>
                        </Link>
                        <button @click="showFilterModal = false" class="text-1xl text-blue-500 hover:text-blue-600">
                            <div class="flex items-center flex-row">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 50 50">
                                    <path d="M 7.71875 6.28125 L 6.28125 7.71875 L 23.5625 25 L 6.28125 42.28125 L 7.71875 43.71875 L 25 26.4375 L 42.28125 43.71875 L 43.71875 42.28125 L 26.4375 25 L 43.71875 7.71875 L 42.28125 6.28125 L 25 23.5625 Z"></path>
                                </svg>
                            </div>
                        </button>
                        </div>
                        <br>
                        <select v-model="selectedType" class="w-full border border-gray-300 rounded-md mb-6">
                            <option selected disabled>Вид животного</option>
                            <option v-for="type in types" :value="type.id" :key="type.id">{{ type.name }}</option>
                        </select>
                        <br>
                        <select v-model="selectedRegion" class="w-full border border-gray-300 rounded-md mb-6">
                            <option selected disabled>Область</option>
                            <option v-for="region in regions" :value="region.id" :key="region.id">{{ region.name }}</option>
                        </select>
                        <br>
                        <select v-model="selectedCity" class="w-full border border-gray-300 rounded-md mb-6">
                            <option selected disabled>Город</option>
                            <option v-for="city in filteredCities" :value="city.id" :key="city.id">{{ city.name }}</option>
                        </select>
                        <br>
                        <select v-model="animalGender" class="w-full border border-gray-300 rounded-md mb-6">
                            <option selected disabled>Пол</option>
                            <option value="Самец"> Самец </option>
                            <option value="Самка"> Самка </option>
                        </select>
                        <br>
                        <input v-model="minPrice" type="number" class="w-full border border-gray-300 rounded-md mb-6" placeholder="Минимальная цена">
                        <br>
                        <input v-model="maxPrice" type="number" class="w-full border border-gray-300 rounded-md mb-6" placeholder="Максимальная цена">
                        <button type="submit" class="text-white bg-indigo-500 px-6 py-2 rounded hover:bg-indigo-600">Искать</button>
                        <br>
                        <br>
                    </form>
                </div>
            </div>
            <div class="py-12 carousel">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <Carousel :autoplay="2000" :wrap-around="true">
                            <Slide v-for="slide in slides" :key="slide">
                                <div class="carousel__item">
                                    <img :src="slide.src" :alt="slide.alt" width="1300px" height="400px" class="slide-image" />
                                </div>
                            </Slide>
                        </Carousel>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex cards-container">
            <div class="h-[1714px] w-[1280px]">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4">
                        <template v-if="filteredAnimalss && filteredAnimalss.length > 0">
                            <div v-for="animal in filteredAnimalss" :key="animal.id" class="card border border-gray-300 rounded-md shadow-md overflow-hidden">
                                <div class="card-image">
                                    <img :src="`/storage/` + animal.image" alt="Animal Image" class="w-full h-64 object-cover">
                                </div>
                                <div class="card-content p-4">
                                    <h3 class="text-lg font-semibold">
                                        {{ animal.type == 1 ? 'Лошадь' : (animal.type == 2 ? 'Корова' : '') }} - {{ animal.breed }}
                                    </h3>                                    <p class="text-gray-600">{{ animal.gender }}, Дата рождения: {{ animal.date_of_birth }}</p>
                                    <p class="text-gray-700 mt-2">{{ animal.note }}</p>
                                    <div class="flex justify-between">
                                        <Link :href="route('animal.show',[animal.id])" class="mt-4 text-blue-500 hover:underline">Подробнее</Link>
                                        <Link :href="route('animal.delete',[animal.id])" class="mt-4 text-red-500 hover:underline">Удалить</Link>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div v-for="animal in data" :key="animal.id" class="fade card border border-gray-300 rounded-md shadow-md overflow-hidden">
                                <div class="card-image">
                                    <img :src="`storage/` + animal.image" alt="Animal Image" class="w-full h-64 object-cover">
                                </div>
                                <div class="card-content p-4">
                                    <h3 class="text-lg font-semibold">
                                        {{ animal.type == 1 ? 'Лошадь' : (animal.type == 2 ? 'Корова' : '') }} - {{ animal.breed }}
                                    </h3>
                                    <p class="text-gray-600">{{ animal.gender }}, Дата рождения: {{ animal.date_of_birth }}</p>
                                    <p class="text-gray-700 mt-2">{{ animal.note }}</p>
                                    <div class="flex justify-between">
                                        <Link :href="route('animal.show',[animal.id])" class="mt-4 text-blue-500 hover:underline">Подробнее</Link>
                                        <Link :href="route('animal.delete',[animal.id])" class="mt-4 text-red-500 hover:underline">Удалить</Link>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showChatModal" class="chat fade">
            <div class="bg-white p-8 rounded-lg shadow-lg w-80">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Сообщения</h2>
                    <button @click="showChatModal = false" class="text-blue-500 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 1a9 9 0 0 0-9 9c0 4.967 4.037 9 9 9a9 9 0 0 0 9-9c0-4.967-4.037-9-9-9zm4.354 5.354a.5.5 0 1 0-.708-.708L10 9.293 6.354 5.646a.5.5 0 1 0-.708.708L9.293 10l-3.647 3.646a.5.5 0 0 0 .708.708L10 10.707l3.646 3.647a.5.5 0 0 0 .708-.708L10.707 10l3.647-3.646z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="overflow-y-auto h-48 rounded-lg shadow-md bg-gray-100 p-4">
                    <ul>
                        <li v-for="user in contacted_users" :key="user.id" class="py-2 flex justify-between items-center border-b border-gray-200">
                            <div class="flex items-center" >
                                <span class="text-lg" >{{ user.contact.name }}</span>
                                <span class="text-sm ml-2 unread-messages" v-if="user.unread_messages_count > 0" >{{ user.unread_messages_count }}</span>
                            </div>
                            <a :href="`/send_message/${user.contact.id}`" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-300">Написать</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="chat-button">
            <button @click="openChat()">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" x="0" y="0" viewBox="0 0 16 16" style="enable-background:new 0 0 512 512" xml:space="preserve">
            <g>
                <path d="M13 1H3A2.568 2.568 0 0 0 .5 3.625V10A2.568 2.568 0 0 0 3 12.625h6.723a.46.46 0 0 1 .246.073l3.248 2.071a1.437 1.437 0 0 0 1.481.05 1.568 1.568 0 0 0 .802-1.383V3.625A2.568 2.568 0 0 0 13 1zm1.5 12.436a.561.561 0 0 1-.283.506.44.44 0 0 1-.463-.016l-3.248-2.071a1.454 1.454 0 0 0-.783-.23H3A1.568 1.568 0 0 1 1.5 10V3.625A1.568 1.568 0 0 1 3 2h10a1.568 1.568 0 0 1 1.5 1.625z" fill="#000000" opacity="1" data-original="#000000"></path>
                <path d="M11 7.5H5a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1zM11 4.5H5a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1z" fill="#000000" opacity="1" data-original="#000000"></path>
            </g>
        </svg>
                <span class="no-unchecked" :class="{ 'unchecked-messages': unchecked_messages_count > 0 }">{{unchecked_messages_count}}</span>
            </button>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { defineComponent } from 'vue'
import { Carousel, Pagination, Slide } from 'vue3-carousel'

import 'vue3-carousel/dist/carousel.css'
import {Link} from "@inertiajs/vue3";
import axios from "axios";

export default defineComponent({
    name: 'Autoplay',
    components: {
        Link,
        AppLayout,
        Carousel,
        Slide,
        Pagination,
    },
    props: {
        data: {
            type: Object,
        },
        error: {
            type: Number,
        },
        filteredAnimals: {
            type: Array,
        },
        animals: {
            type: Object,
        },
        types: {
            type: Object,
        },
        regions: {
            type: Object,
        },
        cities: {
            type: Object,
        },
    },
    data() {
        return {
            unchecked_messages_count: 0,
            showChatModal: false,
            showFilterModal: false,
            filteredAnimalss: [],
            isFilterApplied: true,
            selectedType: 'Вид животного',
            selectedRegion: 'Область',
            selectedCity: 'Город',
            animalGender: 'Пол',
            minPrice: null,
            maxPrice: null,
            contacted_users: [],
        };
    },
    setup() {
        const slides = [
            { src: '/Logo/1.jpeg', alt: 'Image Preview 1' },
            { src: '/Logo/three.jpeg', alt: 'Image Preview 2' },
            { src: '/Logo/four.jpeg', alt: 'Image Preview 2' },
            { src: '/Logo/six.jpeg', alt: 'Image Preview 2' },
            { src: '/Logo/eight.jpeg', alt: 'Image Preview 2' },
        ];

        return {
            slides
        };
    },
    computed: {
        filteredCities() {
            return this.cities.filter(city => city.region_id == this.selectedRegion);
        }
    },
    methods: {
        async openChat() {
            const response = await axios.get('/chat/open/');
            this.showChatModal = true;
            this.contacted_users = response.data;
            console.log(response);
        },
        async searchAnimals() {
            const formData = {
                type: this.selectedType,
                region: this.selectedRegion,
                city: this.selectedCity,
                gender: this.animalGender,
            };

            try {
                const response = await axios.post('/animals/filter', formData);
                this.filteredAnimalss = response.data.filteredAnimals; // Update filteredAnimals
            } catch (error) {
                console.error(error);
            }
        }
    },
    mounted() {
        const getUncheckedMessages = async () => {
            try {
                const response = await axios.get('/get_messages_count');
                this.unchecked_messages_count = response.data;
                console.log(this.unchecked_messages_count);
            } catch (error) {
                console.error('Error fetching unchecked messages:', error);
            }
        };

        getUncheckedMessages();
    }
})
</script>

<style scoped>
.unread-messages {
    display: inline-block; /* Делаем элемент блочным, чтобы применить ширину и высоту */
    width: 20px; /* Фиксированная ширина */
    height: 20px; /* Фиксированная высота */
    line-height: 20px; /* Устанавливаем высоту строки, чтобы содержимое находилось по центру */
    text-align: center; /* Центрируем текст внутри круга */
    color: white; /* Белый текст */
    background-color: red; /* Красный фон */
    border-radius: 50%; /* Округляем углы, чтобы получить круг */
}

body {
    background-image: url('/Logo/12063968_4861242.jpg');
    background-size: cover; /* Изображение будет покрывать весь экран */
    background-position: center; /* Изображение будет центрировано */
    background-repeat: no-repeat; /* Изображение не будет повторяться */
    height: 100vh; /* Высота 100% высоты видимого окна браузера */
    width: 100vw; /* Ширина 100% ширины видимого окна браузера */
}

.no-unchecked {
    position: absolute; /* Абсолютное позиционирование */
    top: -5px; /* Располагаем текст над кнопкой */
    right: -5px; /* Располагаем текст справа от кнопки */
    color: white; /* Цвет текста */
    background-color: rgb(73, 124, 54); /* Цвет фона */
    padding: 3px 6px; /* Отступы вокруг текста */
    border-radius: 50%; /* Округление углов */
    font-size: 12px; /* Размер текста */
    border: 2px solid white; /* Белая обводка */
}

.unchecked-messages {
    position: absolute; /* Абсолютное позиционирование */
    top: -5px; /* Располагаем текст над кнопкой */
    right: -5px; /* Располагаем текст справа от кнопки */
    background-color: red; /* Цвет фона */
    color: white; /* Цвет текста */
    padding: 3px 6px; /* Отступы вокруг текста */
    border-radius: 50%; /* Округление углов */
    font-size: 12px; /* Размер текста */
    border: 2px solid white; /* Белая обводка */
}

.chat {
    position: fixed;
    margin-bottom: 100px;
    bottom: 0;
    right: 0;
}

.chat-button {
    position: fixed;
    margin-bottom: 30px;
    margin-right: 30px;
    bottom: 0;
    right: 0;
}

.search_wrapper {
    position: sticky;
    top: 0;
}

.carousel {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.cards-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.fade {
    opacity: 0; /* Начальная непрозрачность, чтобы скрыть элементы при загрузке */
    animation: fadeIn 0.5s ease-in-out forwards; /* Анимация появления с продолжительностью 0.5 секунды */
    transform: translateX(-20px); /* Начальное положение сдвига по X (-20px) */
}

@keyframes fadeIn {
    from {
        opacity: 0; /* Начальная непрозрачность */
        transform: translateX(-20px); /* Начальное положение сдвига по X (-20px) */
    }
    to {
        opacity: 1; /* Конечная непрозрачность */
        transform: translateX(0); /* Конечное положение сдвига (без сдвига) */
    }
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1rem;
    padding: 1rem;
}

.card {
    border: 1px solid rgba(204, 204, 204, 0.29);
    border-radius: 8px;
    transition: box-shadow 0.3s ease-in-out, border 0.3s ease-in-out;
    overflow: hidden;
    background-color: white;
}

.card:hover {
    border: 1px solid rgba(114, 211, 224, 0.3);
    box-shadow: 0 2px 4px #72B5E04C;
}

.card-image img {

    object-fit: cover;
}

.card h3 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.card p {
    color: #666;
    margin-bottom: 0.5rem;
}

.card button {
    background-color: transparent;
    color: #007bff;
    border: none;
    padding: 0;
    cursor: pointer;
    transition: color 0.3s ease-in-out;
}

.card button:hover {
    color: #0056b3;
}

.slide-image {
    width: 1300px;
    height: 400px;
    object-fit: cover;
}
</style>
