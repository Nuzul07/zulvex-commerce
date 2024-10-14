<script setup>
import { ref, onMounted, onUnmounted } from "vue";

// Sidebar Toggle
const sidebarOpen = ref(true);

const toggleSidebar = () => {
    sidebarOpen.value = !sidebarOpen.value;
}
// Dropdown Menu State
const openDropdown = ref(null);

const toggleDropdown = (menu) => {
    openDropdown.value = openDropdown.value === menu ? null : menu;
}

const avatarOpen = ref(false);
const avatarMenu = ref(null);

const toggleAvatar = () => {
    avatarOpen.value = !avatarOpen.value;
}

const logout = async () => {
    try {
        await axios.post(route("logout"));
        window.location.href = route("login");
    } catch (error) {
        console.error("Logout failed:", error);
    }
};
</script>
<template>
    <div class="flex h-screen" ref="avatarMenu">
        <!-- Sidebar -->
        <aside
            :class="[
                'bg-gray-100 p-6 shadow-lg transition-all duration-300',
                sidebarOpen ? 'w-64' : 'w-16',
            ]"
        >
            <div
                class="flex justify-between items-center mb-8"
                v-if="sidebarOpen"
            >
                <!-- Logo and Title (Only when sidebar is open) -->
                <div class="flex items-center">
                    <img
                        src="/storage/image/zulvex_logo.png"
                        alt="Logo"
                        class="w-10 h-10"
                    />
                    <h1 class="text-xl font-bold">Zulvex</h1>
                </div>

                <!-- Toggle Button (Always visible) -->
                <button
                    @click="toggleSidebar"
                    class="p-2 bg-white shadow-md rounded-full hover:bg-gray-200 transition-all duration-300"
                >
                    <img
                        src="/storage/icon/burger-bar.png"
                        :class="[
                            'h-6 w-6 transition-transform duration-300',
                            !sidebarOpen ? 'rotate-180' : '',
                        ]"
                        alt="Toggle Sidebar"
                    />
                </button>
            </div>

            <!-- Hamburger button when sidebar is collapsed -->
            <button
                v-if="!sidebarOpen"
                @click="toggleSidebar"
                class="p-2 absolute top-4 left-3 bg-white shadow-md rounded-full hover:bg-gray-200 transition-all duration-300 z-50"
            >
                <img
                    src="/storage/icon/burger-bar.png"
                    :class="[
                        'h-6 w-6 transition-transform duration-300',
                        sidebarOpen ? '' : 'rotate-180',
                    ]"
                    alt="Toggle Sidebar"
                />
            </button>

            <nav v-if="sidebarOpen">
                <ul>
                    <li class="mb-1">
                        <button
                            @click="toggleDropdown('masterData')"
                            class="flex justify-between items-center w-full text-left p-2 rounded-lg hover:bg-gray-200"
                        >
                            Master Data
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>
                        <ul
                            v-if="openDropdown === 'masterData'"
                            class="ml-4 mt-2 space-y-2"
                        >
                            <li>
                                <a :href="route('address')" class="text-sm hover:text-blue-500"
                                    >Address</a
                                >
                            </li>
                            <li>
                                <a :href="route('voucher')" class="text-sm hover:text-blue-500"
                                    >Voucher</a
                                >
                            </li>
                            <li>
                                <a :href="route('users')" class="text-sm hover:text-blue-500"
                                    >Users</a
                                >
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a
                            :href="route('product')"
                            class="block p-2 rounded-lg hover:bg-gray-200"
                            >Products</a
                        >
                    </li>
                    <li>
                        <a
                            :href="route('trans')"
                            class="block p-2 rounded-lg hover:bg-gray-200"
                            >Transactions</a
                        >
                    </li>
                    <li>
                        <a
                            :href="route('review')"
                            class="block p-2 rounded-lg hover:bg-gray-200"
                            >Reviews</a
                        >
                    </li>
                    <li>
                        <a
                            :href="route('payment')"
                            class="block p-2 rounded-lg hover:bg-gray-200"
                            >Payment</a
                        >
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 p-6 bg-gray-50">
            <!-- Top Navigation -->
            <header
                class="flex justify-between items-center mb-6 bg-white p-4 shadow-lg rounded-lg"
            >
                <!-- Search Bar -->
                <div class="relative w-1/3">
                    <input
                        type="text"
                        placeholder="Search for..."
                        class="px-4 py-2 w-full rounded-lg border border-gray-300 focus:outline-none focus:ring"
                    />
                </div>
                <!-- Right Section (Icons, Cart, Notifications) -->
                <div class="flex items-center space-x-6">
                    <a href="#" class="relative hover:text-gray-600">
                        <img
                            src="/storage/icon/notification.png"
                            alt="User"
                            class="w-8 h-8 rounded-full cursor-pointer"
                        />
                        <span
                            class="absolute top-0 right-0 inline-flex items-center justify-center px-1 py-0.5 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full"
                            >0</span
                        >
                    </a>
                    <img
                        src="/storage/icon/user.png"
                        alt="User"
                        class="w-8 h-8 rounded-full cursor-pointer"
                        @click="toggleAvatar"
                    />
                    <div
                        v-if="avatarOpen"
                        class="absolute right-6 top-10 mt-16 w-56 bg-white rounded-lg shadow-lg py-2 z-20"
                    >
                        <div class="px-4 py-2">
                            <span class="block text-sm font-semibold"
                                >Welcome to Tailwick</span
                            >
                            <div class="flex items-center mt-2 space-x-3">
                                <img
                                    src="/path/to/avatar.png"
                                    alt="User Avatar"
                                    class="w-10 h-10 rounded-full"
                                />
                                <div>
                                    <h3 class="text-sm font-bold">
                                        Paula Keenan
                                    </h3>
                                    <p class="text-xs text-gray-500">
                                        CEO & Founder
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-2">
                            <a
                                href="#"
                                class="flex items-center space-x-2 hover:bg-gray-100 px-2 py-1 rounded"
                            >
                                <img
                                    src="/storage/icon/profile-edit.png"
                                    alt="User"
                                    class="cursor-pointer"
                                />
                                
                                <span>Profile</span>
                            </a>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <div class="px-4 py-2">
                            <a
                                @click="logout"
                                class="flex items-center space-x-2 hover:bg-gray-100 px-2 py-1 rounded cursor-pointer"
                            >
                                <img
                                    src="/storage/icon/logout.png"
                                    alt="User"
                                    class="cursor-pointer"
                                />
                                <span>Sign Out</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Product Orders Table -->
            <slot name="content" />
        </div>
    </div>
</template>

<style scoped>
/* Add custom styles if necessary */
</style>
