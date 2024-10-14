<template>
    <div class="max-w-7xl mx-auto p-8">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-semibold">My Cart</h2>
        </div>
        <!-- Cart Table -->
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-4 border-b-2">Product</th>
                    <th class="p-4 border-b-2 text-center">Price</th>
                    <th class="p-4 border-b-2 text-center">Quantity</th>
                    <th class="p-4 border-b-2 text-center">Total</th>
                    <th class="p-4 border-b-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(item, index) in paginatedCarts"
                    :key="index"
                    class="border-t"
                >
                    <!-- Product Information -->
                    <td class="p-4 flex items-center">
                        <!-- <img
                            :src="item.image"
                            alt="Product Image"
                            class="w-12 h-12 object-cover mr-4"
                        /> -->
                        <span>{{ item.product.name }}</span>
                    </td>

                    <!-- Price -->
                    <td class="p-4 text-center text-gray-700">
                        {{ formatRupiah(item.product.price) }}
                    </td>

                    <!-- Quantity -->
                    <td class="p-4 text-center">
                        <div
                            class="flex items-center m-auto border rounded-lg w-max"
                        >
                            <button
                                @click="decreaseQuantity(item)"
                                class="px-3 py-1"
                            >
                                -
                            </button>
                            <input
                                type="numeric"
                                v-model="item.quantity"
                                class="w-12 text-center border-l border-r"
                                min="1"
                            />
                            <button
                                @click="increaseQuantity(item)"
                                class="px-3 py-1"
                            >
                                +
                            </button>
                        </div>
                    </td>

                    <!-- Total -->
                    <td class="p-4 text-center text-gray-700">
                        {{ formatRupiah(item.product.price * item.quantity) }}
                    </td>

                    <!-- Remove Action -->
                    <td class="p-4 text-center">
                        <button
                            @click="removeFromCart(item)"
                            class="text-red-500 hover:text-red-700"
                        >
                            <img
                                class="m-auto"
                                src="/storage/icon/trash.png"
                                alt="Delete"
                            />
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Continue Shopping and Check Out Buttons -->
        <div class="flex justify-between mt-8">
            <button class="text-gray-500 hover:underline">
                Continue Shopping
            </button>
            <button
                class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600"
                @click="checkout"
            >
                Check Out
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { Notyf } from "notyf";
import "notyf/notyf.min.css";
import { useCartStore } from "@/Pages/User/Store/cartStore";
import axios from "axios";

const props = defineProps({
    cartsData: {
        type: Array,
        required: true,
    },
});

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

const page = usePage();
const userAuth = page.props.user_auth;

const itemsPerPage = 5;
const currentPage = ref(1);

const totalPages = computed(() =>
    Math.ceil(props.cartsData.length / itemsPerPage)
);

const paginatedCarts = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.cartsData.slice(start, end);
});

const parseImages = (imageString) => {
    return JSON.parse(imageString);
};

const goToPage = (page) => {
    currentPage.value = page;
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

// Methods to handle quantity changes and item removal
const increaseQuantity = (item) => {
    item.quantity++;
};

const decreaseQuantity = (item) => {
    if (item.quantity > 1) {
        item.quantity--;
    }
};

const cartStore = useCartStore();
const emit = defineEmits(["remove-cart-item"]);

const removeFromCart = async (cartItem) => {
    try {
        const loadingNotification = notyf.open({
            type: "info",
            message: "Mohon Tunggu",
            duration: 0,
        });

        const response = await axios.post(route("deleteCart"), {
            user_id: userAuth.user_id,
        });

        notyf.dismiss(loadingNotification);
        notyf.open({
            type: "success",
            message: "Berhasil menghapus dari cart",
        });

        const updatedCartCount = response.data.cart_count;
        console.log(updatedCartCount);

        cartStore.setCartCount(updatedCartCount);

        emit("remove-cart-item", cartItem);
    } catch (error) {
        console.log(error);
    }
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

const checkout = () => {
    const products = paginatedCarts.value.map((item) => {
        return {
            p_code: item.product.p_code,
            name: item.product.name,
            color: item.product.color,
            price: item.product.price,
            old_price: item.product.old_price,
            quantity: item.quantity,
            phone_type: item.product.phone_type,
        };
    });

    router.post(route('checkout'), { products })
};
</script>

<style scoped>
/* Add custom styles if needed */
</style>
