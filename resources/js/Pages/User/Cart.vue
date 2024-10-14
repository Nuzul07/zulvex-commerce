<script setup>
import { computed, onMounted, reactive, readonly, ref, watch } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import CustTextInput from "@/Components/CustTextInput.vue";
import axios from "axios";
import { Notyf } from "notyf";
import "notyf/notyf.min.css";
import UserLayout from "@/Layouts/UserLayout.vue";
import ProductCollection from "@/Components/ProductCollection.vue";
import NewArrivals from "@/Components/NewArrivals.vue";
import ProductDetailFull from "@/Components/ProductDetailFull.vue";
import WishlistDetail from "@/Components/WishlistDetail.vue";
import Cart from "@/Components/Cart.vue";

onMounted(() => {
    getCart();
});

const page = usePage();
const userAuth = page.props.user_auth;

const cart = ref([]);
const getCart = async () => {
    if (userAuth) {
        try {
            const res = await axios.get(
                route("cartUser", { user_id: userAuth.user_id })
            );
            cart.value = res.data;
            console.log(cart.value);
        } catch (error) {
            console.log("error fetching wishlist:", error);
        }
    }
};

const handleRemoveCartItem = (cartItem) => {
    console.log()
    cart.value = cart.value.filter((item) => item.p_code !== cartItem.p_code);
};
</script>
<template>
    <Head title="Cart" />
    <UserLayout>
        <template #content>
            <main class="flex-grow">
                <div class="max-w-7xl mx-auto">
                    <div v-if="cart.length > 0">
                        <Cart
                        :cartsData="cart"
                        @remove-cart-item="handleRemoveCartItem"
                    />
                    </div>
                    <div class="mb-8 text-center" v-else>
                        <h2 class="text-3xl font-semibold py-10">My Cart</h2>
                        <h2 class="text-2xl text-gray-500 font-semibold">No Product In Here</h2>
                    </div>
                </div>
            </main>
        </template>
    </UserLayout>
</template>
