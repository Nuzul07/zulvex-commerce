import axios from "axios";
import { defineStore } from "pinia";

export const useCartStore = defineStore('cart', {
    state: () => ({
        cartCount: 0
    }),
    actions: {
        async getCartCount() {
            try {
                const response = await axios.get(route("getCounter"))
                this.cartCount = response.data.cart_count
            } catch (error) {
                console.error("Failed to fetch cart count", error);
            }
        },
        setCartCount(count) {
            this.cartCount = count;
        },
        incrementCartCount() {
            this.cartCount++;
        },
    },
});