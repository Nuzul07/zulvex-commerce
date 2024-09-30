<template>
  <div class="max-w-7xl mx-auto p-8">
    <!-- Section Header -->
    <div class="text-center mb-8">
      <h2 class="text-3xl font-semibold">Top Collection</h2>
      <p class="text-gray-500">Shop online for top collection and get free shipping!</p>
    </div>

    <!-- Filter Buttons -->
    <div class="flex justify-center space-x-4 mb-8">
      <button
        v-for="category in categories"
        :key="category"
        class="px-4 py-2 border rounded-md"
        :class="{'bg-black text-white': selectedCategory === category}"
        @click="filterProducts(category)"
      >
        {{ category }}
      </button>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div
        v-for="(product, index) in filteredProducts"
        :key="index"
        class="bg-white rounded-lg p-4 shadow-lg hover:shadow-xl transition-shadow duration-200"
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
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

// Available categories
const categories = ['All', 'Womens', 'Mens', 'Kids'];

// Products data
const products = ref([
  {
    title: 'Pink T-Shirt For Women',
    category: 'Womens',
    price: '$7.00',
    oldPrice: '$9.00',
    image: 'https://via.placeholder.com/150',
    rating: 4,
    sizes: [
      { label: 'S', active: false },
      { label: 'M', active: true },
      { label: 'L', active: false },
    ],
    badge: '50% Sale',
  },
  {
    title: 'Blue T-Shirt For Men',
    category: 'Mens',
    price: '$125.00',
    oldPrice: '$250.00',
    image: 'https://via.placeholder.com/150',
    rating: 5,
    sizes: [
      { label: 'M', active: true },
      { label: 'L', active: false },
      { label: 'XL', active: true },
    ],
  },
  {
    title: 'Jacket For Boy',
    category: 'Kids',
    price: '$65.00',
    oldPrice: '$95.00',
    image: 'https://via.placeholder.com/150',
    rating: 3,
    sizes: [
      { label: 'S', active: true },
      { label: 'M', active: false },
    ],
  },
  {
    title: 'Flower Top For Women',
    category: 'Womens',
    price: '$44.00',
    oldPrice: '$60.00',
    image: 'https://via.placeholder.com/150',
    rating: 4,
    sizes: [
      { label: 'S', active: true },
      { label: 'L', active: false },
    ],
    badge: 'New',
  },
  {
    title: 'Leather Jacket For Men',
    category: 'Mens',
    price: '$255.00',
    oldPrice: '$299.00',
    image: 'https://via.placeholder.com/150',
    rating: 5,
    sizes: [
      { label: 'M', active: true },
      { label: 'L', active: true },
    ],
  },
]);

const selectedCategory = ref('All');

// Computed function to filter products based on the selected category
const filteredProducts = computed(() => {
  if (selectedCategory.value === 'All') {
    return products.value;
  }
  return products.value.filter(product => product.category === selectedCategory.value);
});

// Function to set the selected category
function filterProducts(category) {
  selectedCategory.value = category;
}
</script>

<style scoped>
/* Add custom styles if needed */
</style>
