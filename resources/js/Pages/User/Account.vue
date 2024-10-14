<script setup>
import { ref, computed, reactive, onMounted } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { Notyf } from "notyf";
import "notyf/notyf.min.css";
import UserLayout from "@/Layouts/UserLayout.vue";
import Modal from "@/Components/DialogModal.vue";
import CustTextInput from "@/Components/CustTextInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import axios from "axios";
import CustPhoneInput from "@/Components/CustPhoneInput.vue";

onMounted(() => {
    addressData();
});

defineProps({
    errors: Object,
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

const input = useForm({
    adr_code: "",
    adr_name: "",
    adr_phone: "",
    province: "",
    city: "",
    district: "",
    neighborhood: "",
    zipcode: "",
    full_address: "",
    type: "",
});

const page = usePage();
const userAuth = page.props.user_auth;

const logout = async () => {
    try {
        await axios.post(route("logout"));
        window.location.href = route("login");
    } catch (error) {
        console.error("Logout failed:", error);
    }
};

const modal = reactive({
    addAddress: false,
    editAddress: false,
});

const modalAddAddress = () => {
    modal.addAddress = true;
};

const modalEditAddress = (d) => {
    selectAddress(d);
    modal.editAddress = true;
};

const closeAddAddress = () => {
    modal.addAddress = false;
    inputReset();
};

const closeEditAddress = () => {
    (modal.editAddress = false), inputReset();
};

const selectAddress = (d) => {
    input.adr_code = d.adr_code;
    input.adr_name = d.adr_name;
    input.adr_phone = d.adr_phone;
    input.province = d.province;
    input.city = d.city;
    input.district = d.district;
    input.neighborhood = d.neighborhood;
    input.zipcode = d.zipcode;
    input.full_address = d.full_address;
    input.type = d.type;
};

const inputReset = () => {
    input.adr_name = "";
    input.adr_phone = "";
    input.province = "";
    input.city = "";
    input.district = "";
    input.neighborhood = "";
    input.zipcode = "";
    input.full_address = "";
    input.type = "";
};

const address = ref([]);
const addressLoading = ref(false);
const addressData = async () => {
    try {
        addressLoading.value = true;
        const res = await axios.get(
            route("addressUser", { user_id: userAuth.user_id })
        );
        const data = res.data;
        address.value = data;
        console.log(address.value);
        addressLoading.value = false;
    } catch (error) {
        console.log("errro fetch data:", error);
    }
};

const store = async () => {
    try {
        // Show loading state
        const loadingNotification = notyf.open({
            type: "info",
            message: "Mohon Tunggu",
            duration: 0,
        });

        await axios.post(route("storeAddress"), input);

        notyf.dismiss(loadingNotification);
        notyf.open({
            type: "success",
            message: "Berhasil menambah alamat baru",
        });

        addressData();
        closeAddAddress();
    } catch (error) {
        console.log("error", error);
        notyf.dismissAll();
        // Show error message
        notyf.open({ type: "error", message: "Terjadi Kesalahan" });
    }
};

const update = async () => {
    try {
        // Show loading state
        const loadingNotification = notyf.open({
            type: "info",
            message: "Mohon Tunggu",
            duration: 0,
        });

        await axios.post(route("updateAddress"), input);

        notyf.dismiss(loadingNotification);
        notyf.open({
            type: "success",
            message: "Berhasil merubah alamat",
        });
        addressData();
        closeEditAddress();
    } catch (error) {
        console.log("error", error);
        notyf.dismissAll();
        // Show error message
        notyf.open({ type: "error", message: "Terjadi Kesalahan" });
    }
};
</script>
<template>
    <Head title="Account" />
    <UserLayout>
        <template #content>
            <div class="mt-8 text-center">
                <h2 class="text-3xl font-semibold">My Account</h2>
                <h2 class="mt-2 text-1xl font-semibold">
                    #{{ userAuth.user_id }}
                </h2>
            </div>
            <div class="w-lg mx-10 my-5 p-6 bg-white shadow-md rounded-lg">
                <!-- Logo Section -->
                <div class="flex justify-center mb-6">
                    <img src="/storage/image/default-avatar.png" alt="Logo" />
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label
                            for="first-name"
                            class="block text-sm font-medium text-gray-700"
                            >Username</label
                        >
                        <input
                            type="text"
                            id="first-name"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Enter Your First Name"
                            v-model="userAuth.username"
                        />
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label
                            for="last-name"
                            class="block text-sm font-medium text-gray-700"
                            >Fullname</label
                        >
                        <input
                            type="text"
                            id="last-name"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            v-model="userAuth.fullname"
                        />
                    </div>

                    <!-- Email -->
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700"
                            >Email</label
                        >
                        <input
                            type="email"
                            id="email"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            v-model="userAuth.email"
                        />
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label
                            for="phone-number"
                            class="block text-sm font-medium text-gray-700"
                            >Phone  Number</label
                        >
                        <input
                            type="text"
                            id="phone-number"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            v-model="userAuth.phone"
                        />
                    </div>
                </div>

                <Modal
                    :show="modal.addAddress"
                    maxWidth="3xl"
                    @close="closeAddAddress"
                >
                    <template #title> Add Address </template>
                    <template #content>
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Name Own :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="name_own"
                                    type="text"
                                    name="name_own"
                                    v-model="input.adr_name"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Phone :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustPhoneInput
                                    id="phone"
                                    type="text"
                                    name="phone"
                                    v-model="input.adr_phone"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Province :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="province"
                                    type="text"
                                    name="province"
                                    v-model="input.province"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    City :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="city"
                                    type="text"
                                    name="city"
                                    v-model="input.city"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    District :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="district"
                                    type="text"
                                    name="district"
                                    v-model="input.district"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Neighborhood :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="neighborhood"
                                    type="text"
                                    name="neighborhood"
                                    v-model="input.neighborhood"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Zipcode :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="zipcode"
                                    type="text"
                                    name="zipcode"
                                    v-model="input.zipcode"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Full Adress :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <TextAreaInput
                                    id="full_address"
                                    name="full_address"
                                    rows="5"
                                    :required-indicator="false"
                                    v-model="input.full_address"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Type :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="type"
                                    type="text"
                                    name="type"
                                    v-model="input.type"
                                />
                            </div>
                        </div>
                        <div class="flex justify-end items">
                            <div class="ml-4">
                                <div class="text-black">
                                    <button
                                        @click="modal.addAddress = false"
                                        title="Close Modal"
                                        class="mt-7 ml-2 bg-red-700 text-white py-2 px-4 rounded"
                                    >
                                        Close
                                    </button>
                                    <button
                                        @click="store"
                                        title="Submit"
                                        class="mt-7 ml-2 bg-green-700 text-white py-2 px-4 rounded"
                                    >
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </Modal>

                <Modal
                    :show="modal.editAddress"
                    maxWidth="3xl"
                    @close="closeEditAddress"
                >
                    <template #title> Edit Address </template>
                    <template #content>
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Name Own :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="name_own"
                                    type="text"
                                    name="name_own"
                                    v-model="input.adr_name"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Phone :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustPhoneInput
                                    id="phone"
                                    type="text"
                                    name="phone"
                                    v-model="input.adr_phone"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Province :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="province"
                                    type="text"
                                    name="province"
                                    v-model="input.province"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    City :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="city"
                                    type="text"
                                    name="city"
                                    v-model="input.city"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    District :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="district"
                                    type="text"
                                    name="district"
                                    v-model="input.district"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Neighborhood :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="neighborhood"
                                    type="text"
                                    name="neighborhood"
                                    v-model="input.neighborhood"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Zipcode :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="zipcode"
                                    type="text"
                                    name="zipcode"
                                    v-model="input.zipcode"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Full Adress :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <TextAreaInput
                                    id="full_address"
                                    name="full_address"
                                    rows="5"
                                    :required-indicator="false"
                                    v-model="input.full_address"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Type :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="type"
                                    type="text"
                                    name="type"
                                    v-model="input.type"
                                />
                            </div>
                        </div>
                        <div class="flex justify-end items">
                            <div class="ml-4">
                                <div class="text-black">
                                    <button
                                        @click="closeEditAddress"
                                        title="Close Modal"
                                        class="mt-7 ml-2 bg-red-700 text-white py-2 px-4 rounded"
                                    >
                                        Close
                                    </button>
                                    <button
                                        @click="update"
                                        title="Submit"
                                        class="mt-7 ml-2 bg-green-700 text-white py-2 px-4 rounded"
                                    >
                                        Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </Modal>

                <div class="mt-8">
                    <hr class="border-1 border-gray-400" />
                </div>

                <!-- Add Button (Outside Card and Aligned to the Right) -->
                <div class="mt-3 mx-auto text-right">
                    <a
                        class="text-green-500 cursor-pointer"
                        @click="modalAddAddress"
                    >
                        Add Address
                    </a>
                </div>

                <div class="my-5 text-center">
                    <h2 class="text-3xl text-gray-600">Address List</h2>
                </div>

                <div
                    class="max-w-md mx-auto p-6 bg-yellow-600 text-white rounded-lg shadow-lg"
                    v-for="(adr, index) in address"
                    :key="index"
                >
                    <!-- Address Type -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex space-x-2">
                            <span
                                v-if="adr.type == 1"
                                class="bg-yellow-500 text-white px-2 py-1 rounded-md text-sm"
                                >Rumah</span
                            >
                            <span
                                v-else-if="adr.type == 2"
                                class="bg-yellow-500 text-white px-2 py-1 rounded-md text-sm"
                                >Kantor</span
                            >
                        </div>
                    </div>

                    <!-- User Info -->
                    <h2 class="text-xl font-bold">{{ adr.adr_name }}</h2>
                    <p class="text-gray-300 mt-1">+62{{ adr.adr_phone }}</p>
                    <p class="text-gray-300 mt-1">{{ adr.province }}</p>
                    <p class="text-gray-300 mt-1">
                        {{ adr.full_address }}
                    </p>

                    <!-- Edit Button -->
                    <div class="mt-4">
                        <button
                            class="w-full bg-gray-800 hover:bg-gray-700 text-white py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            @click="modalEditAddress(adr)"
                        >
                            Ubah Alamat
                        </button>
                    </div>
                </div>

                <div class="mt-8">
                    <hr class="border-1 border-gray-400" />
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button
                        type="button"
                        class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:ring-2 focus:ring-red-500"
                        @click="logout"
                    >
                        Logout
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <a
                        href="/"
                        class="text-sm text-gray-600 hover:text-gray-900"
                        >Back to Homepage</a
                    >
                </div>
            </div>
        </template>
    </UserLayout>
</template>
