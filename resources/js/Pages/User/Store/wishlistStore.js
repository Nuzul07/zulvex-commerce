import axios from "axios";
import { defineStore } from "pinia";

export const useWishlistStore = defineStore('wishlist', {
    state: () => ({
        wishlistCount: 0
    }),
    actions: {
        async getWishlistCount() {
            try {
                const response = await axios.get(route("getCounter"))
                this.wishlistCount = response.data.wishlist_count
            } catch (error) {
                console.error("Failed to fetch wishlist count", error);
            }
        },
        setWishlistCount(count) {
            this.wishlistCount = count;
        },
        incrementWishlistCount() {
            this.wishlistCount++;
        },
    },
});