<script setup>
import { computed, onMounted, reactive, readonly, ref, watch } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import axios from "axios";
import UserLayout from "@/Layouts/UserLayout.vue";
import Checkout from "@/Components/Checkout.vue";

const page = usePage();
const products = page.props.products || [];
console.log(page.props.products)
</script>
<template>
    <Head title="Checkout" />
    <UserLayout>
        <template #content>
            <main class="flex-grow">
                <div class="max-w-7xl mx-auto">
                    <Checkout :productsData="products" />
                </div>
            </main>
        </template>
    </UserLayout>
</template>
