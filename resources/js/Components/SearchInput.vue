<script setup>
import { ref } from "vue";

defineProps(['modelValue', 'label', 'id', 'type', 'placeholder', 'disabled', 'subClass', 'label']);
defineEmits(['update:modelValue']);

</script>

<template>
    <div class="relative z-10">
        <label class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase">{{ label }}</label>
        <div
            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
        >
        </div>
        <input
            type="search"
            :id="id"
            :value="modelValue"
            :class="subClass"
            :placeholder="placeholder"
            @input="$emit('update:modelValue', $event.target.value)"
            class="w-full mb-4 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring"
            placeholder="Search"
            required
        />
        <button
            type="submit"
            disabled
            class="absolute right-2 p-2 text-sm font-medium h-fit text-whiterounded-e-lg"><i><img src="/storage/icon/search.png"></i>
        </button>
    </div>
</template>
