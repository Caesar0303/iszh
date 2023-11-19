<script>
import {defineComponent} from "vue";
import {Link} from "@inertiajs/vue3";
import Swal from "sweetalert2";
import AppLayout from '@/Layouts/AppLayout.vue';

export default defineComponent({
    components:{
        AppLayout,
        Link,
        Swal,
    },
    props:{
        filteredAnimals: {
            type: Array
        }
    }
})

</script>

<template>
    {{filteredAnimals}}
</template>

<style scoped>

</style>
