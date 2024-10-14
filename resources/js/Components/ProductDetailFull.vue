<script setup>
import { usePage } from "@inertiajs/vue3";
import axios from "axios";
import { computed, onMounted, ref } from "vue";
import { Notyf } from "notyf";
import "notyf/notyf.min.css";
import { useWishlistStore } from "@/Pages/User/Store/wishlistStore";
import { useCartStore } from "@/Pages/User/Store/cartStore";

onMounted(() => {
    getWishlist();
    getCart();
});

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const page = usePage();
const userAuth = page.props.user_auth;

const notyf = new Notyf({
    position: {
        x: "right",
        y: "top",
    },
    types: [
        {
            type: "info",
            background: "blue",
            duration: 1000,
        },
        {
            type: "success",
            background: "green",
            duration: 2500,
        },
        {
            type: "error",
            background: "red",
            duration: 3000,
        },
    ],
});

const wishlist = ref([]);
const isInWishlist = ref(false);
const getWishlist = async () => {
    if (userAuth) {
        try {
            const res = await axios.get(
                route("wishlistUser", { user_id: userAuth.user_id })
            );
            wishlist.value = res.data;
            // Check if the product is in the wishlist and update isInWishlist ref
            isInWishlist.value = wishlist.value.some(
                (item) => item.p_code === props.product.p_code
            )
                ? true
                : false;
        } catch (error) {
            console.log("error fetching wishlist:", error);
        }
    }
};

const cart = ref([]);
const isInCart = ref(false);
const getCart = async () => {
    if (userAuth) {
        try {
            const res = await axios.get(
                route("cartUser", { user_id: userAuth.user_id })
            );
            cart.value = res.data;

            isInCart.value = cart.value.some(
                (item) => item.p_code === props.product.p_code
            )
                ? true
                : false;
        } catch (error) {
            console.log("error fetching cart:", error);
        }
    }
};

// Reactive state for managing the active tab
const activeTab = ref("description"); // Set default tab to "description"

// Function to switch the active tab
function switchTab(tab) {
    activeTab.value = tab;
}

const quantity = ref(1);

function increaseQuantity() {
    quantity.value++;
}

function decreaseQuantity() {
    if (quantity.value > 1) {
        quantity.value--;
    }
}

const parseImages = (imageString) => {
    return JSON.parse(imageString);
};

const formatRupiah = (value) => {
    const numberFormat = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    });
    return numberFormat.format(value);
};

const wishlistStore = useWishlistStore();
const cartStore = useCartStore();

const storeWishlist = async () => {
    if (userAuth == null) {
        notyf.open({
            type: "error",
            message: "Silahkan login terlebih dahulu",
        });
    } else {
        try {
            if (isInWishlist.value) {
                const loadingNotification = notyf.open({
                    type: "info",
                    message: "Mohon Tunggu",
                    duration: 0,
                });

                const response = await axios.post(route("deleteWishlist"), {
                    user_id: userAuth.user_id,
                });

                isInWishlist.value = false;

                notyf.dismiss(loadingNotification);
                notyf.open({
                    type: "success",
                    message: "Berhasil menghapus dari wishlist",
                });

                // Update wishlist count dynamically
                const updatedWishlistCount = response.data.wishlist_count;

                wishlistStore.setWishlistCount(updatedWishlistCount);
            } else {
                const wishlistInput = {
                    p_code: props.product.p_code,
                    p_name: props.product.name,
                    p_type: props.product.phone_type,
                    p_price: props.product.price,
                    p_description: props.product.description,
                    p_image: String(parseImages(props.product.image)[0]),
                };

                const loadingNotification = notyf.open({
                    type: "info",
                    message: "Mohon Tunggu",
                    duration: 0,
                });

                const response = await axios.post(
                    route("storeWishlist"),
                    wishlistInput
                );

                isInWishlist.value = true;

                notyf.dismiss(loadingNotification);
                notyf.open({
                    type: "success",
                    message: "Berhasil menambahkan ke wishlist",
                });

                // Update wishlist count dynamically
                const updatedWishlistCount = response.data.wishlist_count;

                wishlistStore.setWishlistCount(updatedWishlistCount);
            }
        } catch (error) {
            notyf.open({ type: "error", message: "Terjadi Kesalahan" });
            console.log(error);
        }
    }
};

const storeCart = async () => {
    if (userAuth == null) {
        notyf.open({
            type: "error",
            message: "Silahkan login terlebih dahulu",
        });
    } else {
        try {
            if (isInCart.value) {
                const loadingNotification = notyf.open({
                    type: "info",
                    message: "Mohon Tunggu",
                    duration: 0,
                });

                const response = await axios.post(route("updateExistCart"), {
                    user_id: userAuth.user_id,
                    p_code: props.product.p_code,
                    quantity: quantity.value
                });

                isInCart.value = true;

                notyf.dismiss(loadingNotification);
                notyf.open({
                    type: "success",
                    message: "Berhasil menambahkan ke cart",
                });

            } else {
                const cartInput = {
                    p_code: props.product.p_code,
                    user_id: userAuth.user_id,
                    quantity: quantity.value,
                };

                const loadingNotification = notyf.open({
                    type: "info",
                    message: "Mohon Tunggu",
                    duration: 0,
                });

                const response = await axios.post(
                    route("storeCart"),
                    cartInput
                );

                console.log(response.data)

                isInCart.value = true;

                notyf.dismiss(loadingNotification);
                notyf.open({
                    type: "success",
                    message: "Berhasil menambahkan ke cart",
                });

                // Update cart count dynamically
                const updateCartCount = response.data.cart_count;

                cartStore.setCartCount(updateCartCount);
            }
        } catch (error) {
            notyf.open({ type: "error", message: "Terjadi Kesalahan" });
            console.log(error);
        }
    }
};
</script>

<template>
    <div v-if="product" class="container mx-auto p-6">
        <!-- Product Section -->
        <div class="flex flex-col md:flex-row">
            <div class="flex-none w-full md:w-1/2">
                <img
                    v-if="product.image && product.image.length > 0"
                    :src="`/storage/picture/productPhoto/${
                        product.p_code
                    }/${parseImages(product.image)}`"
                    alt="Product Image"
                    class="w-96 m-auto rounded-lg"
                />
            </div>

            <!-- Product Information -->
            <div class="flex-grow md:ml-10 mt-6 md:mt-0">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ product.title }}
                </h2>
                <p class="mt-2 text-gray-600">{{ product.description }}</p>

                <div class="flex items-center mt-4">
                    <span class="text-yellow-500"
                        >&#9733;&#9733;&#9733;&#9733;&#9733;</span
                    >
                    <span class="ml-2 text-sm text-gray-500"
                        >({{ product.rating }} Reviews)</span
                    >
                </div>

                <ul class="mt-4 text-gray-700">
                    <li><strong>Material :</strong> Rubber</li>
                    <li><strong>Weight :</strong> 100 grams</li>
                    <li><strong>Color :</strong> {{ product.color }}</li>
                    <li>
                        <strong>Phone Type :</strong> {{ product.phone_type }}
                    </li>
                    <li><strong>Available :</strong> {{ product.stock }}</li>
                </ul>

                <!-- Price and Add to Cart -->
                <div class="mt-6">
                    <div class="flex items-center">
                        <span class="text-2xl font-bold text-gray-800">{{
                            formatRupiah(product.price)
                        }}</span>
                        <span
                            v-if="product.old_price"
                            class="ml-2 text-gray-500 line-through"
                            >{{ formatRupiah(product.old_price) }}</span
                        >
                    </div>

                    <!-- Quantity Selector and Add to Cart -->
                    <div class="flex items-center space-x-4 mt-6">
                        <div
                            class="flex items-center border border-gray-300 rounded-lg"
                        >
                            <button @click="decreaseQuantity" class="px-3 py-1">
                                -
                            </button>
                            <input
                                type="numeric"
                                v-model="quantity"
                                class="w-12 text-center border-l border-r border-gray-300"
                            />
                            <button @click="increaseQuantity" class="px-3 py-1">
                                +
                            </button>
                        </div>
                        <button
                            class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600"
                            @click="storeCart"
                        >
                            Add To Cart
                        </button>
                        <button
                            class="text-gray-500 hover:text-black"
                            @click="storeWishlist"
                        >
                            <img
                                :src="
                                    isInWishlist
                                        ? '/storage/icon/heart-filled.png'
                                        : '/storage/icon/heart.png'
                                "
                                alt="Tambahkan Ke Wishlist"
                            />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs for Description, Information, and Review -->
        <div class="mt-10">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <a
                        href="#"
                        @click.prevent="switchTab('description')"
                        :class="{
                            'border-indigo-500 text-indigo-600':
                                activeTab === 'description',
                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300':
                                activeTab !== 'description',
                        }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                    >
                        Description
                    </a>
                    <a
                        href="#"
                        @click.prevent="switchTab('information')"
                        :class="{
                            'border-indigo-500 text-indigo-600':
                                activeTab === 'information',
                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300':
                                activeTab !== 'information',
                        }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                    >
                        Information
                    </a>
                    <a
                        href="#"
                        @click.prevent="switchTab('review')"
                        :class="{
                            'border-indigo-500 text-indigo-600':
                                activeTab === 'review',
                            'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300':
                                activeTab !== 'review',
                        }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                    >
                        Review
                    </a>
                </nav>
            </div>

            <!-- Conditionally Render Tab Content -->
            <div class="mt-6">
                <div v-if="activeTab === 'description'">
                    <p class="text-gray-700">{{ product.description }}</p>
                </div>
                <div v-if="activeTab === 'information'">
                    <ul class="mt-4 text-gray-700">
                        <li><strong>Material :</strong> Rubber</li>
                        <li><strong>Weight :</strong> 100 grams</li>
                        <li><strong>Color :</strong> {{ product.color }}</li>
                        <li>
                            <strong>Phone Type :</strong>
                            {{ product.phone_type }}
                        </li>
                        <li>
                            <strong>Available :</strong> {{ product.stock }}
                        </li>
                    </ul>
                </div>
                <div v-if="activeTab === 'review'">
                    <p class="text-gray-700">No reviews yet.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading placeholder if product is not available yet -->
    <div v-else>
        <p>Loading product details...</p>
    </div>
</template>
