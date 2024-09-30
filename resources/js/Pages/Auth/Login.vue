<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
// import { Notyf } from "notyf";
// import 'notyf/notyf.min.css';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

// const notyf = new Notyf({
//     position: {
//         x: "right",
//         y: "top",
//     },
//     types: [
//         {
//             type: "info",
//             background: "blue",
//             duration: 1000,
//         },
//         {
//             type: "success",
//             background: "green",
//             duration: 2500,
//         },
//         {
//             type: "error",
//             background: "red",
//             duration: 3000,
//         }
//     ]
// });

const form = useForm({
    twoauth: "",
    password: "",
    remember: false,
});

const login = (event) => {
    event.preventDefault(); // Prevent default form submission
    form.post(route("login"), {
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
                title: "Berhasil Login",
                text: "Selamat Datang admin",
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
            console.log(errors)
            if (errors.twoauth) {
                Swal.fire({
                    icon: "error",
                    title: "Username atau Email Salah",
                    text: "Ketikan dengan benar username dan email anda!",
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
            } else if (errors.password) {
                Swal.fire({
                    icon: "error",
                    title: "Password Salah",
                    text: "Ketikan password anda dengan benar!",
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
            }
        },
        onFinish: () => form.reset("password"),
    });
};

const passwordVisible = ref(false); // State to track visibility

const togglePassword = () => {
    passwordVisible.value = !passwordVisible.value; // Toggle visibility
};
</script>

<template>
    <Head title="Log in" />

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
            <div class="w-full py-6 z-20">
                <h1 class="my-6 text-5xl">LOGIN</h1>
                <div class="sm:w-2/3 w-full px-4 lg:px-0 mx-auto">
                    <form @submit="login">
                        <div class="pb-2 pt-4">
                            <input
                                type="text"
                                name="twoauth"
                                id="twoauth"
                                placeholder="Username or Email"
                                v-model="form.twoauth"
                                class="block w-full p-4 text-lg rounded-sm bg-black focus:ring-yellow-600 focus:border-yellow-600 autofill:bg-black autofill:text-white"
                            />
                        </div>
                        <div class="pb-2 pt-4 relative">
                            <input
                                :type="passwordVisible ? 'text' : 'password'"
                                name="password"
                                id="password"
                                placeholder="Password"
                                v-model="form.password"
                                class="block w-full p-4 text-lg rounded-sm bg-black focus:ring-yellow-600 focus:border-yellow-600"
                            />
                            <button
                                type="button"
                                @click="togglePassword"
                                class="absolute right-4 top-1/2 transform -translate-y-2"
                            >
                                <span v-if="passwordVisible">🙈</span>
                                <span v-else>👁️</span>
                            </button>
                        </div>
                        <div class="flex justify-between">
                            <div
                                class="text-gray-400 hover:underline hover:text-gray-100"
                            >
                                <a href="register">Didn't have an account?</a>
                            </div>
                            <div
                                class="text-gray-400 hover:underline hover:text-gray-100"
                            >
                                <a href="#">Forgot your password?</a>
                            </div>
                        </div>
                        <div class="px-4 pb-2 pt-4">
                            <button
                                type="submit"
                                class="uppercase block w-full p-4 text-lg rounded-full bg-yellow-500 hover:bg-yellow-600 focus:outline-none"
                            >
                                Sign in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
