<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { defineComponent } from 'vue';
import {Link} from "@inertiajs/vue3";


export default defineComponent({
    components: {
        AppLayout,
        Link,
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
            filteredAnimalss: [],
            isFilterApplied: true,
            selectedType: 'Вид животного',
            selectedRegion: 'Область',
            selectedCity: 'Город',
            animalGender: 'Пол',
            minPrice: null,
            maxPrice: null,
        };
    },
    computed: {
        filteredCities() {
            return this.cities.filter(city => city.region_id == this.selectedRegion);
        }
    },
    methods: {
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
});
</script>
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex justify-between items-center">
            </div>
        </template>
        <div class="flex">
            <div class="filter bg-white mr-24 mt-16 mb-32 ml-6 p-8 rounded sticky-container">
                <form @submit.prevent="searchAnimals">
                    <Link :href="route('animals')" class="text-1xl text-blue-500 hover:text-blue-600">
                        <div class="flex items-center flex-row">
                            Сборосить
                        </div>
                    </Link>
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
            <div class="py-12 h-[1714px] w-[1280px]">
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
    </AppLayout>
</template>

<style scoped lang="scss">
.sticky-container {
    position: sticky;
    top: 0;
    background-color: white;
    z-index: 1000;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.filter {
    max-height: 550px;
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
</style>


