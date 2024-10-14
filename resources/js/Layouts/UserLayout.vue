<template>
    <div class="min-h-screen flex flex-col justify-between">
        <!-- Navbar -->
        <header class="bg-white shadow-md">
            <div
                class="flex justify-between items-center p-4 max-w-7xl mx-auto"
            >
                <!-- Hamburger Menu Icon -->
                <div class="lg:hidden">
                    <button
                        @click="toggleSidebar"
                        class="p-2 rounded-md hover:bg-gray-100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-gray-800"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Logo Section -->
                <div class="flex items-center space-x-2">
                    <img
                        src="/storage/image/zulvex_logo.png"
                        alt="Carrot Logo"
                        loading="lazy"
                        class="w-12"
                    />
                    <h1 class="text-2xl font-bold text-gray-800">Zulvex</h1>
                </div>

                <!-- Search Bar Section -->
                <div
                    class="lg:flex items-center border border-gray-300 rounded-lg flex mx-4"
                >
                    <input
                        type="text"
                        placeholder="Search For items..."
                        class="w-[400px] px-4 py-2 border-none focus:ring-yellow-500 focus:border-yellow-500 rounded-l-lg"
                    />
                    <button
                        class="text-white px-4 py-2 rounded-r-lg hover:bg-gray-200"
                    >
                        <img
                            src="/storage/icon/search.png"
                            alt=""
                            loading="lazy"
                        />
                    </button>
                </div>

                <!-- Menu Icons Section -->
                <div class="flex items-center space-x-5 text-gray-800">
                    <a
                        :href="route('account')"
                        class="flex items-center hover:text-yellow-500"
                    >
                        <img
                            src="/storage/icon/user.png"
                            alt=""
                            loading="lazy"
                        />
                        <span class="ml-1">Account</span>
                    </a>
                    <a
                        :href="route('wishlist')"
                        class="relative flex items-center hover:text-yellow-500"
                    >
                        <img
                            src="/storage/icon/heart.png"
                            alt=""
                            loading="lazy"
                        />
                        <span class="ml-1">Wishlist</span>
                        <!-- Badge for counter -->
                        <span
                            class="absolute top-0 right-16 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-xs font-bold rounded-full w-4 h-4 flex items-center justify-center"
                        >
                            {{ wishlistCount }}
                        </span>
                    </a>
                    <a
                        :href="route('cart')"
                        class="relative flex items-center hover:text-yellow-500"
                    >
                        <img
                            src="/storage/icon/cart.png"
                            alt=""
                            loading="lazy"
                        />
                        <span class="ml-1">Cart</span>
                        <!-- Badge for counter -->
                        <span
                            class="absolute top-0 right-9 transform translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-xs font-bold rounded-full w-4 h-4 flex items-center justify-center"
                        >
                            {{ cartCount }}
                        </span>
                    </a>
                </div>
            </div>
            <hr class="mx-10" />
            <!-- Dropdown Menu for Large Screens -->
            <nav
                class="hidden lg:flex justify-between items-center px-4 max-w-7xl mx-auto my-4"
            >
                <a href="/" class="hover:text-yellow-500">Home</a>
                <div class="relative group">
                    <button class="hover:text-yellow-500">Category</button>
                    <div
                        class="absolute left-0 hidden group-hover:block bg-white border mt-1 rounded-lg shadow-lg w-48 z-10"
                    >
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100"
                            >Category 1</a
                        >
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100"
                            >Category 2</a
                        >
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100"
                            >Category 3</a
                        >
                    </div>
                </div>
                <a :href="route('productCollect')" class="hover:text-yellow-500"
                    >Product</a
                >
                <a href="about-us" class="hover:text-yellow-500">About Us</a>
                <a href="contact-us" class="hover:text-yellow-500">Contact</a>
            </nav>
        </header>

        <!-- Main Content (Example) -->
        <slot name="content" />

        <!-- Footer -->
        <footer class="bg-gray-100 pt-10 pb-4">
            <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-4">
                <!-- Logo and Contact Info -->
                <div class="col-span-1">
                    <div class="flex items-center">
                        <img
                            src="/storage/image/zulvex_logo.png"
                            alt="Carrot Logo"
                            loading="lazy"
                            class="w-12"
                        />
                        <h1 class="ml-2 text-2xl font-bold text-gray-800">
                            Zulvex
                        </h1>
                    </div>
                    <p class="mt-4 text-gray-600">
                        Zulvex is a great choice of phone case in the world. Get
                        your daily case from our store.
                    </p>
                    <div class="mt-4">
                        <p class="flex items-center text-gray-600">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-yellow-500 mr-2"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M10.9 1.85l6 6A1 1 0 0117 10H3a1 1 0 01-.7-1.85l6-6a1 1 0 011.4 0zM2 12a1 1 0 011-1h14a1 1 0 011 1v7H2v-7z"
                                />
                            </svg>
                            51 yellow St. Huntington Ohio Beach <br />
                            Ontario, NY 11746 KY 4783, USA.
                        </p>
                        <p class="flex items-center text-gray-600 mt-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-yellow-500 mr-2"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M2.003 5.884L10 10.882l7.997-4.998A1 1 0 0017 4H3a1 1 0 00-.997 1.884zM18 8.118l-8 5-8-5V14a1 1 0 001 1h14a1 1 0 001-1V8.118z"
                                />
                            </svg>
                            example@email.com
                        </p>
                        <p class="flex items-center text-gray-600 mt-2">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-yellow-500 mr-2"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M2 3a1 1 0 011-1h14a1 1 0 011 1v14a1 1 0 01-1 1h-4.586l-2-2H7l-2 2H3a1 1 0 01-1-1V3zm11 9a4 4 0 10-8 0 4 4 0 008 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            +91 123 4567890
                        </p>
                    </div>
                </div>

                <!-- Company Links -->
                <div class="col-span-1">
                    <h3 class="text-lg font-bold text-gray-800">Company</h3>
                    <ul class="mt-4 space-y-2 text-gray-600">
                        <li>
                            <a href="#" class="hover:text-yellow-500"
                                >About Us</a
                            >
                        </li>
                        <li>
                            <a href="#" class="hover:text-yellow-500"
                                >Delivery Information</a
                            >
                        </li>
                        <li>
                            <a href="#" class="hover:text-yellow-500"
                                >Privacy Policy</a
                            >
                        </li>
                        <li>
                            <a href="#" class="hover:text-yellow-500"
                                >Terms & Conditions</a
                            >
                        </li>
                        <li>
                            <a href="#" class="hover:text-yellow-500"
                                >Contact Us</a
                            >
                        </li>
                        <li>
                            <a href="#" class="hover:text-yellow-500"
                                >Support Center</a
                            >
                        </li>
                    </ul>
                </div>

                <!-- Category Links -->
                <div class="col-span-1">
                    <h3 class="text-lg font-bold text-gray-800">Category</h3>
                    <ul class="mt-4 space-y-2 text-gray-600">
                        <li>
                            <a href="#" class="hover:text-yellow-500"
                                >Dairy & Bakery</a
                            >
                        </li>
                        <li>
                            <a href="#" class="hover:text-yellow-500"
                                >Fruits & Vegetables</a
                            >
                        </li>
                        <li>
                            <a href="#" class="hover:text-yellow-500"
                                >Snack & Spice</a
                            >
                        </li>
                        <li>
                            <a href="#" class="hover:text-yellow-500"
                                >Juice & Drinks</a
                            >
                        </li>
                        <li>
                            <a href="#" class="hover:text-yellow-500"
                                >Chicken & Meat</a
                            >
                        </li>
                        <li>
                            <a href="#" class="hover:text-yellow-500"
                                >Fast Food</a
                            >
                        </li>
                    </ul>
                </div>

                <!-- Subscribe Newsletter & Social Media -->
                <div class="col-span-1">
                    <h3 class="text-lg font-bold text-gray-800">
                        Subscribe Our Newsletter
                    </h3>
                    <div class="mt-4 flex">
                        <input
                            type="text"
                            placeholder="Search here..."
                            class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none w-full"
                        />
                        <button
                            class="bg-yellow-500 text-white px-4 py-2 rounded-r-md"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M2 5a1 1 0 011-1h14a1 1 0 011 1v10a1 1 0 01-1 1H3a1 1 0 01-1-1V5z"
                                />
                            </svg>
                        </button>
                    </div>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-600 hover:text-yellow-500">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M18 2h-3.76C12.93 2 12 2.93 12 4.24v3.52c0 1.31.93 2.24 2.24 2.24h3.52C19.07 10 20 9.07 20 7.76V4.24C20 2.93 19.07 2 17.76 2zM8 6H5.24C3.93 6 3 6.93 3 8.24v3.52C3 12.93 3.93 14 5.24 14H8v-8zM0 8v3.76C0 13.07.93 14 2.24 14h3.52C7.07 14 8 13.07 8 11.76V8.24C8 6.93 7.07 6 5.76 6H2.24C.93 6 0 6.93 0 8.24zM2.24 16H6V16.76C6 18.07 6.93 20 8.24 20h3.52C12.07 20 13 19.07 13 17.76V13H2.24C.93 13 0 14.93 0 16.24z"
                                />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-yellow-500">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M10 0C4.48 0 0 4.48 0 10s4.48 10 10 10 10-4.48 10-10S15.52 0 10 0zM8.36 15.64H5.8v-5.8h2.56v5.8zM7.08 8.76a1.4 1.4 0 110-2.8 1.4 1.4 0 010 2.8zm8.4 6.88h-2.56v-3.2c0-1.84-2.2-1.7-2.2 0v3.2h-2.56v-5.8h2.56v.8c1.6-2.4 5.08-1.56 5.08 2.4v2.6z"
                                />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-yellow-500">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M10.38 5.5h-1.44v2.5h1.44v2.5h-1.44v7.5h2.56v-7.5H12.5v-2.5h-1.56V6.38c0-.64.38-1.12 1.12-1.12h.94V2.56h-1.12c-2.06 0-2.94.88-2.94 2.94V5.5h-1.44v2.5h1.44z"
                                />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center pt-4 border-t">
                <p class="text-gray-600">
                    © 2024 <a href="#" class="text-yellow-500">Zulvex</a>, All
                    rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { useCartStore } from "@/Pages/User/Store/cartStore";
import { useWishlistStore } from "@/Pages/User/Store/wishlistStore";
import { computed } from "vue";

const wishlistStore = useWishlistStore();
const cartStore = useCartStore()

const wishlistCount = computed(() => wishlistStore.wishlistCount);
const cartCount = computed(() => cartStore.cartCount)
</script>

<style scoped>
/* Add any custom styling here if needed */
</style>
