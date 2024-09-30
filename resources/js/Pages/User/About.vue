<script setup>
import AboutUs from "@/Components/AboutUs.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
</script>
<template>
    <Head title="About Us" />
    <UserLayout>
        <template #content>
            <AboutUs />
        </template>
    </UserLayout>
</template>