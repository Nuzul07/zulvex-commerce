<script setup>
import ContactPage from "@/Components/ContactPage.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
</script>
<template>
    <Head title="Contact Us" />
    <UserLayout>
        <template #content>
            <ContactPage />
        </template>
    </UserLayout>
</template>