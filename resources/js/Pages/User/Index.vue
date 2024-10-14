<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import Carousel from "@/Components/Carousel.vue";
import CategoryGrid from "@/Components/CategoryGrid.vue";
import NewArrivals from "@/Components/NewArrivals.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import FeatureCards from "@/Components/FeatureCards.vue";
import ProductCollection from "@/Components/ProductCollection.vue";
import ProductDetails from "@/Components/ProductDetails.vue";
import Cart from "@/Components/Cart.vue";
import WishlistDetail from "@/Components/WishlistDetail.vue";
import AboutUs from "@/Components/AboutUs.vue";
import ContactPage from "@/Components/ContactPage.vue";
import Checkout from "@/Components/Checkout.vue";
import ProductDetailFull from "@/Components/ProductDetailFull.vue";

const props = defineProps({
    wishlist_count: Number,
});

console.log(props.wishlist_count)
</script>
<template>
    <Head title="Homepage" />
    <UserLayout :wishlist_count="props.wishlist_count">
        <template #content>
            <main class="flex-grow">
                <div class="max-w-7xl mx-auto py-10">
                    <Carousel />
                    <CategoryGrid />
                    <ProductDetailFull />
                    <FeatureCards />
                    <ProductCollection />
                    <ProductDetails />
                </div>
            </main>
        </template>
    </UserLayout>
</template>
