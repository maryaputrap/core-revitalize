<script setup lang="ts">
import {computed, PropType, ref, toRef} from "vue";
import TextInput from "@/Components/TextInput.vue";
import { EyeIcon, EyeSlashIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    modelValue: {
        type: String as PropType<string>,
        required: true,
    },
    newPassword: {
        type: Boolean as PropType<boolean>,
        required: false,
        default: false,
    },
    withBorder: {
        type: Boolean as PropType<boolean>,
        required: false,
        default: false,
    },
});

const emit = defineEmits(['update:modelValue'])

const password = computed({
    get() {
        return props.modelValue
    },
    set(value) {
        emit('update:modelValue', value)
    },
})

const showPassword = ref(false);
const inputType = computed(() => showPassword.value ? 'text' : 'password');

const togglePassword = () => {
    showPassword.value = !showPassword.value;
};
</script>

<template>
        <div class="relative overflow-hidden rounded-xl border-0 p-0 text-grayscale-heading">
            <TextInput
                :type="inputType"
                :class="{
                    'border-0': !withBorder,
                    'border border-gray-100': withBorder,
                }"
                class="block w-full appearance-none pr-12"
                v-model="password"
                required
                placeholder="Masukkan password kamu"
                :autocomplete="newPassword ? 'new-password' : 'current-password'"
                :with-border="withBorder"
            />

            <div class="cursor-pointer absolute inset-y-0 right-0 flex items-center pr-6">
                <EyeSlashIcon class="h-4 w-4 text-grayscale-placeholder hover:text-grayscale-subheading" aria-hidden="true" v-show="!showPassword" @click="togglePassword" />
                <EyeIcon class="h-4 w-4 text-grayscale-placeholder hover:text-grayscale-subheading" aria-hidden="true" v-show="showPassword" @click="togglePassword" />
            </div>
        </div>
</template>
