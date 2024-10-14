<template>
    <div class="max-w-7xl mx-auto p-8">
        <!-- Section Header -->
        <div class="mb-8 text-center">
        <h2 class="text-3xl font-semibold">New Arrivals</h2>
            <p class="text-gray-500">Browse The Collection of Top Products.</p>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-4 gap-6 relative">
            <div
                v-for="(product, index) in paginatedProducts"
                :key="index"
                class="relative bg-white rounded-lg p-4 shadow-lg hover:shadow-xl transition-shadow duration-200 cursor-pointer"
                @click="selectProduct(product)"
            >
                <!-- Product Image Carousel -->
                <div class="relative">
                    <img
                        v-for="(image, imageIndex) in parseImages(product.image)"
                        :key="imageIndex"
                        :src="`/storage/picture/productPhoto/${product.p_code}/${image}`"
                        alt="Product Image"
                        v-show="imageIndexes[index] === imageIndex"
                        class="w-30 h-42 m-auto rounded-t-lg mb-4"
                    />

                    <!-- Carousel Controls -->
                    <button v-if="parseImages(product.image).length > 1" class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-500 bg-opacity-50 p-1 rounded-full text-white" @click.stop="prevImage(index)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button v-if="parseImages(product.image).length > 1" class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-gray-500 bg-opacity-50 p-1 rounded-full text-white" @click.stop="nextImage(index)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>

                <!-- Product Info -->
                <h3 class="text-lg font-medium">{{ product.title }}</h3>
                <p class="text-sm text-gray-400">{{ product.name }}</p>
                <div class="mt-2">
                    <span class="text-lg font-semibold text-red-600">{{ formatRupiah(product.price) }}</span>
                    <span v-if="product.old_price" class="ml-2 text-sm text-gray-500 line-through">{{ formatRupiah(product.old_price) }}</span>
                </div>

                <!-- Star Rating -->
                <div class="flex items-center mt-2">
                    <span v-for="i in 5" :key="i" class="text-yellow-500">
                        <svg v-if="i <= product.rating" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="h-4 w-4" viewBox="0 0 24 24">
                            <path d="M12 .587l3.668 7.429 8.197 1.191-5.933 5.78 1.401 8.161L12 18.896l-7.333 3.852 1.401-8.161L.135 9.207l8.197-1.191z"/>
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watchEffect } from 'vue';

// Define props for the productsData
const props = defineProps({
    productsData: {
        type: Array,
        required: true,
    },
});

// Emit event to parent when a product is selected
const emit = defineEmits(['product-selected']);
function selectProduct(product) {
    emit('product-selected', product);
}

const itemsPerPage = 4;
const currentPage = ref(1);
const imageIndexes = ref([]);

watchEffect(() => {
    if (props.productsData.length > 0) {
        imageIndexes.value = props.productsData.map(() => 0);
    }
});

const totalPages = computed(() => Math.ceil(props.productsData.length / itemsPerPage));

const paginatedProducts = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return props.productsData.slice(start, end);
});

function parseImages(imageString) {
    return JSON.parse(imageString);
}

function nextImage(productIndex) {
    const totalImages = parseImages(paginatedProducts.value[productIndex].image).length;
    imageIndexes.value[productIndex] = (imageIndexes.value[productIndex] + 1) % totalImages;
}

function prevImage(productIndex) {
    const totalImages = parseImages(paginatedProducts.value[productIndex].image).length;
    imageIndexes.value[productIndex] = (imageIndexes.value[productIndex] - 1 + totalImages) % totalImages;
}

function goToPage(page) {
    currentPage.value = page;
}

function prevPage() {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
}

function nextPage() {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
}

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
