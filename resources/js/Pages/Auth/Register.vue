<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Swal from "sweetalert2";

defineProps({
    errors: Object,
});

const form = useForm({
    username: "",
    fullname: "",
    email: "",
    phone: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

const register = (event) => {
    event.preventDefault();
    form.post(route("register"), {
        onStart: () => {
            Swal.fire({
                title: "Memproses",
                text: "Mohon Tunggu",
                background: "#ffc300",
                allowOutsideClick: false,
                showConfirmButton: false,
                customClass: {
                    title: "text-black",
                    popup: "text-black",
                },
                didOpen: () => {
                    Swal.showLoading(); // Show loading spinner
                },
            });
        },
        onSuccess: () => {
            Swal.fire({
                title: "Berhasil Mendaftar",
                text: "Silahkan verifikasi email terlebih dahulu",
                icon: "success",
                iconColor: "#FFFFFF",
                background: "#ffc300",
                showConfirmButton: false,
                timer: 1300,
                customClass: {
                    title: "text-black", // Tailwind class for title text color
                    popup: "text-black", // Tailwind class for content text color
                },
            });
        },
        onError: (errors) => {
            console.log(errors);
            Swal.fire({
                title: "Terjadi kesalahan",
                text: "Periksa kembali inputannya",
                icon: "error",
                iconColor: "#FFFFFF",
                background: "#ba1c1c",
                showConfirmButton: true,
                confirmButtonColor: "#FFFFFF",
                customClass: {
                    title: "text-white",
                    popup: "text-white",
                    confirmButton: "text-black",
                },
            });
        },
        onFinish: () => {
            form.reset("password", "password_confirmation");
        },
    });
};

const passwordVisible = ref(false);
const passwordCfrVisible = ref(false); // State to track visibility

const togglePassword = () => {
    passwordVisible.value = !passwordVisible.value; // Toggle visibility
};

const togglePasswordCfr = () => {
    passwordCfrVisible.value = !passwordCfrVisible.value; // Toggle visibility
};
</script>

<template>
    <Head title="Register" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>
    <div class="min-h-screen flex items-stretch text-white">
        <div
            class="lg:flex w-1/2 hidden bg-gray-500 bg-no-repeat bg-cover relative items-center"
            style="
                background-image: url(https://images.unsplash.com/photo-1593055454503-531d165c2ed8?q=80&w=1430&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D);
            "
        >
            <div class="absolute bg-black opacity-60 inset-0 z-0"></div>
            <div class="w-full px-24 z-10">
                <h1 class="text-5xl font-bold text-left tracking-wide">
                    Keep it special
                </h1>
                <p class="text-3xl my-4">Make your device more beautiful,</p>
                <p class="text-3xl my-4">a lot of choice in ZULVEX</p>
            </div>
        </div>
        <div
            class="lg:w-1/2 w-full flex items-center justify-center text-center md:px-16 px-0 z-0"
            style="background-color: #000"
        >
            <div class="w-full py-6 z-10">
                <h1 class="my-6 text-5xl">REGISTER</h1>
                <div class="w-full px-4 lg:px-0 mx-auto">
                    <form @submit="register">
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-2 pt-4"
                        >
                            <div class="pb-2 pt-4">
                                <input
                                    type="text"
                                    name="username"
                                    id="username"
                                    placeholder="Username"
                                    v-model="form.username"
                                    class="block w-full p-4 text-lg rounded-sm bg-black focus:ring-yellow-600 focus:border-yellow-600 autofill:bg-black autofill:text-white"
                                />
                                <div v-if="errors.username" class="text-left">
                                    <span class="text-sm text-red-600"
                                        >*{{ errors.username }}</span
                                    >
                                </div>
                            </div>
                            <div class="pb-2 pt-4">
                                <input
                                    type="text"
                                    name="fullname"
                                    id="fullname"
                                    placeholder="Fullname"
                                    v-model="form.fullname"
                                    class="block w-full p-4 text-lg rounded-sm bg-black focus:ring-yellow-600 focus:border-yellow-600 autofill:bg-black autofill:text-white"
                                />
                                <div v-if="errors.fullname" class="text-left">
                                    <span class="text-sm text-red-600"
                                        >*{{ errors.fullname }}</span
                                    >
                                </div>
                            </div>
                            <div class="pb-2 pt-4">
                                <input
                                    type="text"
                                    name="email"
                                    id="email"
                                    placeholder="Email"
                                    v-model="form.email"
                                    class="block w-full p-4 text-lg rounded-sm bg-black focus:ring-yellow-600 focus:border-yellow-600 autofill:bg-black autofill:text-white"
                                />
                                <div v-if="errors.email" class="text-left">
                                    <span class="text-sm text-red-600"
                                        >*{{ errors.email }}</span
                                    >
                                </div>
                            </div>
                            <div class="pb-2 pt-4">
                                <input
                                    type="text"
                                    name="phone"
                                    id="phone"
                                    placeholder="Phone"
                                    v-model="form.phone"
                                    class="block w-full p-4 text-lg rounded-sm bg-black focus:ring-yellow-600 focus:border-yellow-600 autofill:bg-black autofill:text-white"
                                />
                                <div v-if="errors.phone" class="text-left">
                                    <span class="text-sm text-red-600"
                                        >*{{ errors.phone }}</span
                                    >
                                </div>
                            </div>
                            <div class="pb-2 pt-4 relative">
                                <input
                                    :type="
                                        passwordVisible ? 'text' : 'password'
                                    "
                                    name="password"
                                    id="password"
                                    placeholder="Password"
                                    v-model="form.password"
                                    class="block w-full p-4 text-lg rounded-sm bg-black focus:ring-yellow-600 focus:border-yellow-600"
                                />

                                <button
                                    type="button"
                                    @click="togglePassword"
                                    :class="
                                        errors.password
                                            ? 'absolute right-4 top-1/2 transform -translate-y-5'
                                            : 'absolute right-4 top-1/2 transform -translate-y-2'
                                    "
                                >
                                    <span v-if="passwordVisible">🙈</span>
                                    <span v-else>👁️</span>
                                </button>
                                <div v-if="errors.password" class="text-left">
                                    <span class="text-sm text-red-600"
                                        >*{{ errors.password }}</span
                                    >
                                </div>
                            </div>
                            <div class="pb-2 pt-4 relative">
                                <input
                                    :type="
                                        passwordCfrVisible ? 'text' : 'password'
                                    "
                                    name="password"
                                    id="password"
                                    placeholder="Confirmation Password"
                                    v-model="form.password_confirmation"
                                    class="block w-full p-4 text-lg rounded-sm bg-black focus:ring-yellow-600 focus:border-yellow-600"
                                />

                                <button
                                    type="button"
                                    @click="togglePasswordCfr"
                                    :class="
                                        errors.password_confirmation
                                            ? 'absolute right-4 top-1/2 transform -translate-y-5'
                                            : 'absolute right-4 top-1/2 transform -translate-y-2'
                                    "
                                >
                                    <span v-if="passwordCfrVisible">🙈</span>
                                    <span v-else>👁️</span>
                                </button>
                                <div
                                    v-if="errors.password_confirmation"
                                    class="text-left"
                                >
                                    <span class="text-sm text-red-600"
                                        >*{{
                                            errors.password_confirmation
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>
                        <div
                            class="text-right text-gray-400 hover:underline hover:text-gray-100"
                        >
                            <a href="login">Already have an account?</a>
                        </div>
                        <div class="px-4 pb-2 pt-4">
                            <button
                                type="submit"
                                class="uppercase block w-full p-4 text-lg rounded-full bg-yellow-500 hover:bg-yellow-600 focus:outline-none"
                            >
                                Sign Up
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
