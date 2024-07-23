<script setup lang="ts">
import {PropType, watch} from "vue";
import TextInput from "@/Components/TextInput.vue";

const model = defineModel<string>({
    type: String as PropType<string>,
    required: true,
});

defineProps({
    withBorder: { type: Boolean, default: false },
})


watch(model, (value) => {
    if (value.trim().length > 0) {
        if (value.startsWith('0')) {
            model.value = value.replace(/^0/, '');
        }

        model.value = value.replace(/\D/g, '')
    }

});
</script>

<template>
    <div class="flex overflow-hidden rounded-xl border-0 p-0 text-grayscale-heading">
        <span
            class="inline-flex w-16 items-center justify-center overflow-hidden rounded-l-xl border px-5 py-4"
        >
            +62
        </span>

        <TextInput
            id="phone"
            type="text"
            :class="[
                { 'border-1 border-gray-100': withBorder },
                'appearance-none rounded-l-none'
            ]"
            v-model.trim="model"
            placeholder="Masukkan nomor whatsapp kamu"
            autocomplete="phone"
            :with-border="withBorder"
        />
    </div>
</template>
