<template>
  <div class="max-w-7xl mx-auto p-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      
      <!-- Product Image Section -->
      <div class="flex flex-col items-center">
        <!-- Main Product Image -->
        <div class="w-full h-auto mb-4">
          <img
            :src="selectedImage"
            alt="Main Product"
            class="w-full h-96 object-cover rounded-lg"
          />
        </div>
        
        <!-- Thumbnails -->
        <div class="flex space-x-4">
          <img
            v-for="(image, index) in product.images"
            :key="index"
            :src="image"
            @click="selectedImage = image"
            class="w-16 h-16 object-cover rounded-lg cursor-pointer border-2"
            :class="{ 'border-yellow-500': selectedImage === image, 'border-gray-200': selectedImage !== image }"
          />
        </div>
      </div>

      <!-- Product Info Section -->
      <div>
        <!-- Product Title -->
        <h2 class="text-2xl font-bold mb-4">
          {{ product.title }}
        </h2>
        
        <!-- Description -->
        <p class="text-gray-500 mb-4">
          {{ product.description }}
        </p>
        
        <!-- Rating and Reviews -->
        <div class="flex items-center mb-4">
          <div class="flex space-x-1 text-yellow-500">
            <svg v-for="i in 5" :key="i" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5">
              <path v-if="i <= product.rating" d="M12 .587l3.668 7.429 8.197 1.191-5.933 5.78 1.401 8.161L12 18.896l-7.333 3.852 1.401-8.161L.135 9.207l8.197-1.191z"/>
            </svg>
          </div>
          <span class="ml-2 text-gray-500">({{ product.reviews }} Reviews)</span>
        </div>

        <!-- Product Details -->
        <ul class="space-y-2 text-sm">
          <li><strong>Brand:</strong> {{ product.brand }}</li>
          <li><strong>Flavour:</strong> {{ product.flavour }}</li>
          <li><strong>Diet Type:</strong> {{ product.dietType }}</li>
          <li><strong>Weight:</strong> {{ product.weight }}</li>
          <li><strong>Speciality:</strong> {{ product.speciality }}</li>
          <li><strong>Info:</strong> {{ product.info }}</li>
        </ul>

        <!-- Price -->
        <div class="text-3xl font-semibold text-yellow-600 mt-4">
          {{ product.price }}
          <span class="text-lg text-gray-500 line-through ml-2">{{ product.oldPrice }}</span>
        </div>

        <!-- Size/Weight Selection -->
        <div class="mt-6">
          <span class="font-semibold">Size/Weight:</span>
          <div class="flex space-x-4 mt-2">
            <button
              v-for="(size, index) in product.sizes"
              :key="index"
              @click="selectedSize = size"
              class="px-4 py-2 border rounded-lg"
              :class="{ 'bg-yellow-500 text-white': selectedSize === size, 'bg-white text-gray-700 border-gray-300': selectedSize !== size }"
            >
              {{ size }}
            </button>
          </div>
        </div>

        <!-- Quantity Selector and Add to Cart -->
        <div class="flex items-center space-x-4 mt-6">
          <div class="flex items-center border border-gray-300 rounded-lg">
            <button @click="decreaseQuantity" class="px-3 py-1">-</button>
            <input type="numeric" v-model="quantity" class="w-12 text-center border-l border-r border-gray-300" />
            <button @click="increaseQuantity" class="px-3 py-1">+</button>
          </div>
          <button class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
            Add To Cart
          </button>
          <button class="text-gray-500 hover:text-black">
            <img src="/storage/icon/heart.png" alt="">
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

// Product Data
const product = {
  title: 'Better Munch - Sweet Crunchy Nut Mix - Roasted Almonds, Dried Dates and Coconuts.',
  description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Necessitatibus sequ... ',
  brand: 'ESTA BETTERU CO',
  flavour: 'Super Saver Pack',
  dietType: 'Vegetarian',
  weight: '200 Grams',
  speciality: 'Gluten Free, Sugar Free',
  info: 'Egg Free, Allergen-Free',
  price: '$120.25',
  oldPrice: '$123.25',
  rating: 5,
  reviews: 75,
  sizes: ['50kg', '80kg', '120kg', '200kg'],
  images: [
    'https://via.placeholder.com/150/000000',
    'https://via.placeholder.com/150/FF0000',
    'https://via.placeholder.com/150/00FF00',
    'https://via.placeholder.com/150/0000FF',
    'https://via.placeholder.com/150/FFFF00',
  ],
};

// State for selected image and size
const selectedImage = ref(product.images[0]);
const selectedSize = ref(product.sizes[0]);

// Quantity management
const quantity = ref(1);

function increaseQuantity() {
  quantity.value++;
}

function decreaseQuantity() {
  if (quantity.value > 1) {
    quantity.value--;
  }
}
</script>

<style scoped>
/* Add custom styles if necessary */
</style>
