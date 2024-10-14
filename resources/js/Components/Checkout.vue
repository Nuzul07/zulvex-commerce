<template>
    <div class="p-8 text-center">
        <h2 class="text-3xl font-semibold">Checkout Your Case</h2>
    </div>
    <div class="max-w-7xl mx-auto p-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Summary Section -->
        <div class="lg:col-span-1">
            <div class="border p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Total Amount</h2>
                <div class="mb-4">
                    <!-- Products in Cart -->
                    <div class="mt-6">
                        <div
                            class="flex items-center mb-4"
                            v-for="(product, index) in props.productsData"
                            :key="index"
                        >
                            <img
                                src="https://via.placeholder.com/80"
                                alt="Product 1"
                                class="w-16 h-16 rounded mr-4"
                            />
                            <div>
                                <p class="font-semibold">{{ product.name }}</p>
                                <p class="text-gray-500">
                                    {{ formatRupiah(product.price) }}
                                    <span class="line-through">{{
                                        formatRupiah(product.old_price)
                                    }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <p class="flex justify-between">
                        <span>Sub Total</span>
                        <span>{{ formatRupiah(subTotal) }}</span>
                    </p>
                </div>
                <hr class="my-4" />
                <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                <div class="mb-4">
                    <label class="flex items-center mb-2">
                        <input
                            type="radio"
                            name="payment"
                            value="Cash on Delivery"
                            class="mr-2"
                        />
                        Cash On Delivery
                    </label>
                </div>
                <hr class="my-4" />
                <h2 class="text-xl font-semibold mb-4">Delivery Method</h2>
                <div class="mb-4">
                    <label class="flex items-center mb-2">
                        <input
                            type="radio"
                            name="delivery"
                            value="Free Shipping"
                            class="mr-2"
                        />
                        Free Shipping Rp 0
                    </label>
                    <label class="flex items-center">
                        <input
                            type="radio"
                            name="delivery"
                            value="Flat Rate"
                            class="mr-2"
                        />
                        Flat Rate Rp 50.000
                    </label>
                </div>
            </div>

            <!-- Delivery Method -->
            <div class="border p-6 rounded-lg shadow-lg mt-6"></div>

            <!-- Payment Method -->
            <div class="border p-6 rounded-lg shadow-lg mt-6">
                <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                <div class="mb-4">
                    <label class="flex items-center mb-2">
                        <input
                            type="radio"
                            name="payment"
                            value="Cash on Delivery"
                            class="mr-2"
                        />
                        Cash On Delivery
                    </label>
                </div>
            </div>
        </div>

        <!-- Checkout Forms -->
        <div class="lg:col-span-1">
            <!-- Billing Details -->
            <div class="border p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-4">Billing Details</h2>
                <div class="mb-4">
                    <label class="block mb-2">
                        <input
                            type="radio"
                            name="billing_address"
                            value="existing"
                            class="mr-2"
                        />
                        I want to use an existing address
                    </label>
                    <label class="block">
                        <input
                            type="radio"
                            name="billing_address"
                            value="new"
                            class="mr-2"
                        />
                        I want to use a new address
                    </label>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <input
                        type="text"
                        placeholder="First Name"
                        class="w-full p-3 border rounded-lg focus:ring focus:border-green-500"
                    />
                    <input
                        type="text"
                        placeholder="Last Name"
                        class="w-full p-3 border rounded-lg focus:ring focus:border-green-500"
                    />
                </div>
                <input
                    type="text"
                    placeholder="Address"
                    class="w-full p-3 border mt-4 rounded-lg focus:ring focus:border-green-500"
                />
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <input
                        type="text"
                        placeholder="City"
                        class="w-full p-3 border rounded-lg focus:ring focus:border-green-500"
                    />
                    <input
                        type="text"
                        placeholder="Post Code"
                        class="w-full p-3 border rounded-lg focus:ring focus:border-green-500"
                    />
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <select
                        class="w-full p-3 border rounded-lg focus:ring focus:border-green-500"
                    >
                        <option value="" disabled selected>Country</option>
                        <option>Country 1</option>
                        <option>Country 2</option>
                    </select>
                    <select
                        class="w-full p-3 border rounded-lg focus:ring focus:border-green-500"
                    >
                        <option value="" disabled selected>Region/State</option>
                        <option>State 1</option>
                        <option>State 2</option>
                    </select>
                </div>
                <button
                    class="bg-green-500 text-white px-6 py-2 mt-6 rounded-lg hover:bg-green-600 w-full"
                >
                    Place Order
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import { Notyf } from "notyf";
import "notyf/notyf.min.css";

const props = defineProps({
    productsData: {
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

const subTotal = computed(() => {
    return props.productsData.reduce((total, item) => {
        return total + item.price * item.quantity;
    }, 0);
});

const formatRupiah = (value) => {
    const numberFormat = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
        maximumFractionDigits: 0,
    });
    return numberFormat.format(value);
};

// Data and methods (if any) can go here
</script>

<style scoped>
/* Custom styles (if needed) */
</style>
