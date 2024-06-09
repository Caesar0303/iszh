<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});


</script>

<template>
    <Head title="Welcome" />

    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center selection:bg-red-500 selection:text-white">
        <nav class="bg-white shadow p-6 fixed top-0 w-full z-10">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                    <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</Link>

                    <template v-else>
                        <Link :href="route('login')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</Link>

                        <Link v-if="canRegister" :href="route('register')" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</Link>
                    </template>
                </div>
            </div>
        </nav>
    </div>
</template>

<style>

</style>
