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
        cities: {
            type: Object
        },
        regions: {
            type: Object
        },
        animal_types: {
            type: Object
        }
    },
    data() {
        return {
            selectedRegion: '...',
            selectedCity: '...',
            animalType: '...',
            animalGender: 'Пол',
            animalBreed: null,
            dateOfBitrh: null,
            note: null,
            price: null,
            image: null
        };
    },
    computed: {
        filteredCities() {
            return this.cities.filter(city => city.region_id == this.selectedRegion);
        }
    },
    methods: {
        async submit() {
            let formData = new FormData();
            formData.append('selectedRegion', this.selectedRegion);
            formData.append('selectedCity', this.selectedCity);
            formData.append('animalType', this.animalType);
            formData.append('animalGender', this.animalGender);
            formData.append('animalBreed', this.animalBreed);
            formData.append('dateOfBitrh', this.dateOfBitrh);
            formData.append('note', this.note);
            formData.append('price', this.price);
            formData.append('image', this.file);
            try {
                const response = await axios.post('/animal/store', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                if (response.status === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Успех!',
                        text: 'Объявление успешно загружено',
                    }).then(() => {
                        window.location.href = '/animals';
                    });
                }
            } catch (error) {
                console.error('Ошибка при отправке данных на сервер:', error);

                Swal.fire({
                    icon: 'error',
                    title: 'Ошибка!',
                    text: 'Произошла ошибка при отправке данных на сервер',
                });
            }
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },
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
                    Создание объявления
                </h2>
            </div>
        </template>

        <div class="py-12 fade">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 fade">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg fade">
                    <form class="p-4">
                        <div class="mb-4">
                            <form @submit.prevent="submit" enctype="multipart/form-data" >
                            <span class="fade"> Местоположение </span>
                            <br>
                            <select v-model="selectedRegion" class="select w-full border border-gray-300 p-2 rounded-md fade">
                                <option selected disabled>...</option>
                                <option v-for="region in regions" :value="region.id" :key="region.id"> {{ region.name }} </option>
                            </select>
                            <select v-if="selectedRegion !== '...'" v-model="selectedCity" class="select w-full border border-gray-300 p-2 rounded-md fade">
                                <option v-for="city in filteredCities" :value="city.id" :key="city.id">{{ city.name }}</option>
                            </select>
                            <br>
                            <span class="fade"> Выберите категорию животного </span>
                            <br>
                            <select v-model="animalType" class="select w-full border border-gray-300 p-2 rounded-md fade">
                                <option selected disabled>...</option>
                                <option v-for="type in animal_types" :value="type.id" :key="type.id"> {{ type.name }} </option>
                            </select>
                            <select v-if="animalType !== '...'" v-model="animalGender" class="select w-1/4 border border-gray-300 p-2 rounded-md fade">
                                <option selected disabled>Пол</option>
                                <option> Самец </option>
                                <option> Самка </option>
                            </select>
                            <input v-if="animalType !== '...'" v-model="animalBreed" placeholder="Порода" class="select w-2/3 border border-gray-300 p-2 rounded-md fade">
                            <br>
                                <span class="fade"> Дата рождения животного </span>
                            <br>
                            <input type="date" v-model="dateOfBitrh" placeholder="Порода" class="select w-full border border-gray-300 p-2 rounded-md fade">
                            <br>
                                <span class="fade"> Примечание </span>
                            <textarea v-model="note" id="text" name="text" class="w-full border border-gray-300 p-2 rounded-md fade"></textarea>
                            <br>
                                <span class="fade"> Цена </span>
                            <br>
                            <input type="number" v-model="price" class="w-full border border-gray-300 p-2 rounded-md select fade">
                            <br>
                                <span class="fade"> Загрузите изображение </span>
                            <input
                                name="image"
                                @change="handleFileUpload"
                                class="mt-2 fade relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-black-500 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-800 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-800 dark:text-neutral-800 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                                type="file"
                                id="formFile"
                            />
                            <br>
                            <button class="w-full text-white border border-gray-300 p-2 rounded-md bg-blue-500 hover:bg-blue-600 fade"> Добавить </button>
                            </form>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.fade {
    opacity: 0; /* Начальная непрозрачность, чтобы скрыть элементы при загрузке */
    animation: fadeIn 0.5s ease-in-out forwards; /* Анимация появления с продолжительностью 0.5 секунды */
    transform: translateX(-20px); /* Начальное положение сдвига по X (-20px) */
}

.select {
    margin-bottom: 20px;
    margin-right: 5px;
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

/* Остальные стили */
</style>
