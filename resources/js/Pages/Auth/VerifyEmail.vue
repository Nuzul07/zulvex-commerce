<script setup>
import { computed } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Swal from "sweetalert2";

const props = defineProps({
    status: String,
});

const form = useForm({
    otp: "",
});

const verify = (event) => {
    event.preventDefault();
    form.post(route("verify-otp"), {
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
            });
        },
        onSuccess: () => {
            Swal.fire({
                title: "Berhasil Verifikasi Email",
                text: "Silahkan login untuk melanjutkan",
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
                text: errors.otp,
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
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Email Verification" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>
    <div class="min-h-screen text-white bg-black">
        <div class="w-full text-center md:px-16 px-0 z-0">
            <div class="w-full py-20 z-20">
                <h1 class="my-6 text-5xl">
                    Before continuing, could you verify your email address by
                    input otp code on the email we just send to you?
                </h1>
                <div class="sm:w-2/5 w-full px-4 lg:px-0 mx-auto">
                    <form @submit="verify">
                        <div class="pb-2 pt-4">
                            <input
                                type="text"
                                name="otp"
                                id="otp"
                                placeholder="OTP Code"
                                v-model="form.otp"
                                class="block w-full p-4 text-lg rounded-sm bg-black focus:ring-yellow-600 focus:border-yellow-600 autofill:bg-black autofill:text-white"
                            />
                        </div>
                        <div class="px-4 pb-2 pt-4">
                            <button
                                type="submit"
                                class="uppercase block w-full p-4 text-lg rounded-full bg-yellow-500 hover:bg-yellow-600 focus:outline-none"
                            >
                                Verify
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
