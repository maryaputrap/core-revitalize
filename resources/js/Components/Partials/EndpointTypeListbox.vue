<script setup lang="ts">

import axios from "axios";
import {onMounted, ref} from "vue";
import type {Ref, PropType} from "vue";
import Listbox from "@/Components/Listbox.vue";

type Type = {
    hash: string,
    content: string
}

type TypeMapped = {
    label: string,
    value: string|null
}

const model = defineModel({
    type: [String, null] as PropType<string | null>,
    required: true,
})
const tags: Ref<TypeMapped[]> = ref([])

const loadTypes = async () => {
    const { data: responseData } = await axios.get(
        route('api.option.endpoint-type')
    )

    tags.value = responseData?.map((type: Type) => ({
        value: type.hash,
        label: type.content
    })) || []
}

onMounted(() => {
    loadTypes()
})
</script>

<template>
    <Listbox
        v-model="model"
        :items="tags"
        placeholder="Pilih Tipe"
    />
</template>
