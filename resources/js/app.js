import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createPinia } from 'pinia';
import { useWishlistStore } from './Pages/User/Store/wishlistStore'; // Adjust the path if necessary
import { useCartStore } from './Pages/User/Store/cartStore';

const pinia = createPinia();

const appName = import.meta.env.VITE_APP_NAME || 'Zulvex';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia);

        const wishlistStore = useWishlistStore();
        const cartStore = useCartStore()
        wishlistStore.getWishlistCount(); // Fetch count here
        cartStore.getCartCount()

        app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
