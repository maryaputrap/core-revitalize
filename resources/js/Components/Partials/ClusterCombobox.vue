<script setup lang="ts">

import axios from "axios";
import {onMounted, type PropType, Ref, ref, toRefs, watch} from "vue";
import Combobox from "@/Components/Combobox.vue";
import type {Cluster} from "@/types/models.ts";

type ClusterMapped = {
    label: string,
    value: string|null
}

const model = defineModel({
    type: [String, null] as PropType<string | null>,
    required: true,
})

const props = defineProps({
    disabled: {
        type: Boolean as PropType<boolean>,
        required: false,
        default: false,
    },
})

const {disabled} = toRefs(props)
const clusters: Ref<ClusterMapped[]> = ref([])

const loadClusters = async () => {
    const { data: responseData } = await axios.get(
        route('api.cluster.index')
    )

    clusters.value = responseData?.map((cluster: Cluster) => ({
        value: cluster.hash,
        label: cluster.name
    })) || []
}

onMounted(() => {
    loadClusters()
})
</script>

<template>
    <Combobox
        v-model="model"
        :items="clusters"
        placeholder="Pilih Cluster"
        :disabled="disabled"
    />
</template>
