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
        class="relative bg-white rounded-lg p-4 shadow-lg hover:shadow-xl transition-shadow duration-200"
      >
        <div class="relative">
          <!-- Discount Badge -->
          <span
            v-if="product.badge"
            class="absolute top-2 left-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full"
          >
            {{ product.badge }}
          </span>

          <!-- Product Image -->
          <img
            :src="product.image"
            alt="Product Image"
            class="w-full h-48 object-cover rounded-t-lg mb-4"
          />
        </div>

        <!-- Product Info -->
        <h3 class="text-lg font-medium">{{ product.title }}</h3>
        <p class="text-sm text-gray-400">{{ product.category }}</p>

        <!-- Price -->
        <div class="mt-2">
          <span class="text-lg font-semibold text-red-600">{{ product.price }}</span>
          <span
            v-if="product.oldPrice"
            class="ml-2 text-sm text-gray-500 line-through"
          >{{ product.oldPrice }}</span>
        </div>

        <!-- Star Rating -->
        <div class="flex items-center mt-2">
          <span v-for="i in 5" :key="i" class="text-yellow-500">
            <svg
              v-if="i <= product.rating"
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
              class="h-4 w-4"
              viewBox="0 0 24 24"
            >
              <path
                d="M12 .587l3.668 7.429 8.197 1.191-5.933 5.78 1.401 8.161L12 18.896l-7.333 3.852 1.401-8.161L.135 9.207l8.197-1.191z"
              />
            </svg>
          </span>
        </div>

        <!-- Available Sizes -->
        <div class="mt-4 flex space-x-2">
          <span
            v-for="size in product.sizes"
            :key="size"
            class="px-2 py-1 text-xs border rounded-full"
            :class="{
              'bg-gray-200': !size.active,
              'bg-gray-700 text-white': size.active,
            }"
          >{{ size.label }}</span>
        </div>

        <!-- Arrow Buttons -->
        <!-- Left Arrow on the first product -->
        <button
          v-if="index === 0"
          class="absolute top-1/2 -left-6 transform -translate-y-1/2 bg-white border border-gray-300 rounded-full p-2 shadow hover:shadow-md transition-all"
          @click="prevPage"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>

        <!-- Right Arrow on the last product -->
        <button
          v-if="index === paginatedProducts.length - 1"
          class="absolute top-1/2 -right-6 transform -translate-y-1/2 bg-white border border-gray-300 rounded-full p-2 shadow hover:shadow-md transition-all"
          @click="nextPage"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Pagination Controls
    <div class="flex justify-between mt-8">
      <button
        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg"
        :disabled="currentPage === 1"
        @click="prevPage"
      >
        Previous
      </button>
      <div class="flex space-x-2">
        <span
          v-for="page in totalPages"
          :key="page"
          class="px-3 py-1 border rounded-full"
          :class="{ 'bg-blue-500 text-white': page === currentPage }"
          @click="goToPage(page)"
        >{{ page }}</span>
      </div>
      <button
        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg"
        :disabled="currentPage === totalPages"
        @click="nextPage"
      >
        Next
      </button>
    </div> -->
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const products = ref([
  {
    title: 'Colorful Top For Women',
    category: 'Women Tops',
    price: '$6.00',
    oldPrice: '$9.00',
    image: 'https://via.placeholder.com/150',
    rating: 4,
    sizes: [
      { label: 'S', active: false },
      { label: 'M', active: true },
      { label: 'L', active: false },
      { label: 'XL', active: false },
    ],
    badge: '50% Sale',
  },
  {
    title: 'Blue T-Shirt For Men',
    category: 'Men T-shirt',
    price: '$11.00',
    oldPrice: '$22.00',
    image: 'https://via.placeholder.com/150',
    rating: 5,
    sizes: [
      { label: 'S', active: false },
      { label: 'M', active: true },
      { label: 'L', active: false },
      { label: 'XL', active: true },
    ],
    badge: 'Trending',
  },
  {
    title: 'Pink T-Shirt For Girl',
    category: 'Kids',
    price: '$29.00',
    oldPrice: '$39.00',
    image: 'https://via.placeholder.com/150',
    rating: 3,
    sizes: [
      { label: 'S', active: false },
      { label: 'M', active: true },
      { label: 'L', active: false },
    ],
  },
  {
    title: 'Girl Nightdress Shorts',
    category: 'Shorts',
    price: '$57.00',
    oldPrice: '$62.00',
    image: 'https://via.placeholder.com/150',
    rating: 4,
    sizes: [
      { label: 'S', active: false },
      { label: 'M', active: true },
      { label: 'L', active: true },
    ],
    badge: 'New',
  },
]);

const itemsPerPage = 4;
const currentPage = ref(1);

const totalPages = computed(() => Math.ceil(products.value.length / itemsPerPage));

const paginatedProducts = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  return products.value.slice(start, end);
});

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
</script>

<style scoped>
/* Add custom styles if needed */
</style>
