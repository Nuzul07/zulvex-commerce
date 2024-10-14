<script setup>
import { computed, onMounted, reactive, readonly, ref, watch } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import axios from "axios";
import UserLayout from "@/Layouts/UserLayout.vue";
import WishlistDetail from "@/Components/WishlistDetail.vue";

onMounted(() => {
    getWishlist();
});

const page = usePage();
const userAuth = page.props.user_auth;

const wishlist = ref([]);
const getWishlist = async () => {
    if (userAuth) {
        try {
            const res = await axios.get(
                route("wishlistUser", { user_id: userAuth.user_id })
            );
            wishlist.value = res.data;
            console.log(wishlist.value);
        } catch (error) {
            console.log("error fetching wishlist:", error);
        }
    }
};

const handleRemoveWishlistItem = (wishlistItem) => {
    wishlist.value = wishlist.value.filter(
        (item) => item.p_code !== wishlistItem.p_code
    );
};
</script>
<template>
<Head title="Wishlist" />
    <UserLayout>
        <template #content>
            <main class="flex-grow">
                <div class="max-w-7xl mx-auto">
                    <div v-if="wishlist.length > 0">
                        <WishlistDetail
                            :wishlistsData="wishlist"
                            @remove-wishlist-item="handleRemoveWishlistItem"
                        />
                    </div>
                    <div class="mb-8 text-center" v-else>
                        <h2 class="text-3xl font-semibold py-10">My Wishlist</h2>
                        <h2 class="text-2xl text-gray-500 font-semibold">No Product In Here</h2>
                    </div>
                </div>
            </main>
        </template>
    </UserLayout>
</template>
