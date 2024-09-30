<script setup>
import { defineProps, defineEmits, computed } from "vue";

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    readonly: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    modelValue: {
        type: String,
        required: true,
    },
    requiredIndicator: {
        type: Boolean,
        default: true,
    },
    ket: {
        type: String,
        default: false,
    },
    subClass: {
        type: String,
        default: "", // Default to an empty string if no class is provided
    },
});

const emits = defineEmits(["update:modelValue"]);

const inputClass = computed(() => ({
    "mt-1 block w-full px-3 py-2 border-2 border-yellow-500 border-dashed rounded-lg shadow-sm focus:outline-none focus:ring-0 focus:border-yellow-800": true,
    "mt-1 block w-full px-3 py-2 border-2 border-yellow-500 border-dashed shadow-sm focus:outline-none focus:ring-0 focus:border-yellow-800 bg-gray-300":
        props.disabled,
    [props.subClass]: !!props.subClass,
}));

const updateValue = (event) => {
    emits("update:modelValue", event.target.value);
};
</script>

<template>
    <div>
        <label
            :for="id"
            class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
        >
            {{ label }}
            <span v-if="requiredIndicator" class="text-sm text-red-600">*</span>
        </label>
        <input
            v-if="ket"
            :type="type"
            :id="id"
            :name="name"
            :value="`${modelValue} ${ket}`"
            :readonly="readonly"
            :disabled="disabled"
            :required="requiredIndicator"
            @input="updateValue"
            :class="inputClass"
            @dblclick="$emit('dblclick')"
        />
        <input
            v-else
            :type="type"
            :id="id"
            :name="name"
            :value="modelValue"
            :readonly="readonly"
            :disabled="disabled"
            :required="requiredIndicator"
            @input="updateValue"
            :class="inputClass"
            @dblclick="$emit('dblclick')"
        />
    </div>
</template>
