<script setup lang="ts">

import axios from "axios";
import {onMounted, type PropType, Ref, ref, toRefs, watch} from "vue";
import Combobox from "@/Components/Combobox.vue";
import type {Container} from "@/types/models.ts";

type ContainerMapped = {
    label: string,
    value: string|null
}

const model = defineModel({
    type: [String, null] as PropType<string | null>,
    required: true,
})

const props = defineProps({
    cluster: {
        type: String as PropType<string>,
        required: false,
        default: null
    },
    disabled: {
        type: Boolean as PropType<boolean>,
        required: false,
        default: false,
    },
})

const {cluster, disabled} = toRefs(props)
const containers: Ref<ContainerMapped[]> = ref([])

const loadContainers = async (cluster: string|null = props.cluster) => {
    if (!cluster) {
        return
    }

    const { data: responseData } = await axios.get(
        route('api.container.index', {'cluster': cluster})
    )

    containers.value = responseData?.map((container: Container) => ({
        value: container.hash,
        label: container.name
    })) || []
}

onMounted(() => {
    loadContainers()
})

watch(cluster, (newValue, oldValue) => {
    if (newValue !== oldValue) {
        loadContainers()
    }
})

defineExpose({
    loadContainers
})
</script>

<template>
    <Combobox
        v-model="model"
        :items="containers"
        placeholder="Pilih Container"
        :disabled="disabled"
    />
</template>
