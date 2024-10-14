<template>
    <div class="max-w-7xl mx-auto p-8">
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-semibold">My Wishlist</h2>
        </div>
        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                v-for="(wishlist, index) in paginatedWishlists"
                :key="index"
                class="relative bg-white rounded-lg p-4 shadow-lg hover:shadow-xl transition-shadow duration-200 cursor-pointer group"
                @click="openProductModal(wishlist)"
            >
                <!-- Product Image -->
                <div class="relative">
                    <img
                        :src="`/storage/picture/productPhoto/${wishlist.p_code}/${wishlist.p_image}`"
                        alt="Product Image"
                        class="w-30 h-48 object-cover rounded-t-lg mb-4 mx-auto"
                    />

                    <!-- Remove from Wishlist (X) Button, shown only on hover -->
                    <button
                        @click.stop="removeFromWishlist(wishlist)"
                        class="absolute top-2 right-2 text-black hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Product Info -->
                <h3 class="text-lg font-medium">{{ wishlist.p_name }}</h3>
                <p class="text-sm text-gray-400">{{ wishlist.p_type }}</p>

                <!-- Price -->
                <div class="mt-2 text-lg font-semibold text-gray-800">
                    {{ formatRupiah(wishlist.p_price) }}
                </div>
            </div>
        </div>

        <!-- Product Modal -->
        <div
            v-if="showModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
        >
            <div class="bg-white rounded-lg p-8 w-full max-w-lg relative">
                <!-- Close Modal Button -->
                <button
                    @click="closeModal"
                    class="absolute top-2 right-2 text-gray-500 hover:text-red-600"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>

                <!-- Modal Content -->
                <div class="flex items-center">
                    <!-- Modal Image -->
                    <div class="w-1/2">
                        <img
                            :src="`/storage/picture/productPhoto/${selectedWishlist.p_code}/${selectedWishlist.p_image}`"
                            alt="Product Image"
                            class="w-full h-48 object-cover rounded-lg"
                        />
                    </div>

                    <!-- Modal Info -->
                    <div class="w-1/2 ml-4">
                        <h2 class="text-xl font-semibold mb-2">
                            {{ selectedWishlist.p_name }}
                        </h2>
                        <p class="text-gray-500 mb-4">
                            {{ selectedWishlist.p_type }}
                        </p>
                        <div class="text-gray-800 text-2xl font-bold">
                            {{ formatRupiah(selectedWishlist.p_price) }}
                        </div>
                        <div class="flex space-x-2 mt-4">
                            <button
                                class="bg-yellow-500 text-white px-6 py-2 rounded-lg"
                            >
                                Add To Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import { Notyf } from "notyf";
import "notyf/notyf.min.css";
import { useWishlistStore } from "@/Pages/User/Store/wishlistStore";

// Define props for the wishlistsData
const props = defineProps({
    wishlistsData: {
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

const itemsPerPage = 4;
const currentPage = ref(1);

const totalPages = computed(() =>
    Math.ceil(props.wishlistsData.length / itemsPerPage)
);

const paginatedWishlists = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.wishlistsData.slice(start, end);
});

const parseImages = (imageString) => {
    return JSON.parse(imageString);
}

const nextImage = (wishlistIndex) => {
    const totalImages = parseImages(
        paginatedWishlists.value[wishlistIndex].image
    ).length;
    imageIndexes.value[wishlistIndex] =
        (imageIndexes.value[wishlistIndex] + 1) % totalImages;
}

const prevImage = (wishlistIndex) => {
    const totalImages = parseImages(
        paginatedWishlists.value[wishlistIndex].image
    ).length;
    imageIndexes.value[wishlistIndex] =
        (imageIndexes.value[wishlistIndex] - 1 + totalImages) % totalImages;
}

const goToPage = (page) => {
    currentPage.value = page;
}

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
}

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
}

// Modal state
const showModal = ref(false);
const selectedWishlist = ref({});

// Methods to handle product modal
const openProductModal = (product) => {
    selectedWishlist.value = product;
    showModal.value = true;
}

const closeModal = () => {
    showModal.value = false;
}

const wishlistStore = useWishlistStore();
const emit = defineEmits(['remove-wishlist-item']);

// Remove product from wishlist
const removeFromWishlist = async (wishlistItem) => {
    try {
        const loadingNotification = notyf.open({
            type: "info",
            message: "Mohon Tunggu",
            duration: 0,
        });

        const response = await axios.post(route("deleteWishlist"), {
            user_id: userAuth.user_id,
        });

        notyf.dismiss(loadingNotification);
        notyf.open({
            type: "success",
            message: "Berhasil menghapus dari wishlist",
        });

        // Update wishlist count dynamically
        const updatedWishlistCount = response.data.wishlist_count;
        console.log(updatedWishlistCount)

        wishlistStore.setWishlistCount(updatedWishlistCount);

        // Emit event to parent to remove the item
        emit('remove-wishlist-item', wishlistItem);
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
</script>

<style scoped>
/* Add custom styles if necessary */
</style>
