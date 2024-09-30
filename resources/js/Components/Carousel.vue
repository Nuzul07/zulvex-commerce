<template>
  <div class="relative w-full max-w-6xl mx-auto overflow-hidden rounded-lg">
    <!-- Carousel track -->
    <div
      class="flex transition-transform duration-500 ease-in-out"
      :style="{ transform: `translateX(-${activeSlide * 100}%)` }"
    >
      <div
        class="w-full flex-shrink-0 p-6"
        v-for="(slide, index) in slides"
        :key="index"
      >
        <div class="flex items-center justify-between space-x-8">
          <!-- Text section -->
          <div class="w-1/2">
            <h4 class="text-yellow-500 font-bold mb-2"><span class="font-semibold">100%</span> Cotton Fabric</h4>
            <h1 class="text-4xl font-bold mb-4">Fashion sale for women's.</h1>
            <p class="text-gray-500 mb-6">Lorem ipsum dolor sit amet consectetur adipisicing elit. Amet reiciendis beatae consequuntur.</p>
            <button class="px-6 py-3 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition">
              Shop Now
            </button>
          </div>
          <!-- Image section -->
          <div class="w-1/2">
            <img :src="slide.image" alt="Fashion Image" class="rounded-lg object-cover w-full" loading="lazy" />
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination Dots -->
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
      <span
        v-for="(slide, index) in slides"
        :key="index"
        class="w-3 h-3 bg-gray-300 rounded-full cursor-pointer"
        :class="{ 'bg-indigo-600': index === activeSlide }"
        @click="goToSlide(index)"
      ></span>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const slides = ref([
  { image: 'https://images.unsplash.com/photo-1672906674630-67866460f965?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NDZ8fHBob25lJTIwY2FzZXxlbnwwfDB8MHx8fDA%3D' },
  { image: 'https://images.unsplash.com/photo-1592756086927-9a334c956fd1?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' },
  { image: 'https://images.unsplash.com/photo-1618177941007-9775fe6f4f74?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D' },
]);

const activeSlide = ref(0);

function goToSlide(index) {
  activeSlide.value = index;
}

// Auto-slide logic
onMounted(() => {
  const interval = setInterval(() => {
    nextSlide();
  }, 5000); // 10 seconds

  onUnmounted(() => {
    clearInterval(interval);
  });
});

function nextSlide() {
  activeSlide.value = (activeSlide.value + 1) % slides.value.length;
}
</script>

<style scoped>
/* Custom styles if needed */
</style>
