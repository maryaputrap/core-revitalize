<script setup lang="ts">

import axios from "axios";
import {onMounted, type PropType, Ref, ref, toRefs, watch} from "vue";
import Combobox from "@/Components/Combobox.vue";
import type {Endpoint, Port} from "@/types/models.ts";

type EndpointMapped = {
    label: string,
    value: string|null,
    ports: Port[]
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
    container: {
        type: String as PropType<string>,
        required: false,
        default: null
    },
    disabled: {
        type: Boolean as PropType<boolean>,
        required: false,
        default: false,
    },
    exceptId: {
        type: String as PropType<string>,
        required: false,
        default: null
    },
})

const {container, disabled} = toRefs(props)
const endpoints: Ref<EndpointMapped[]> = ref([])
const selectedEndpoint = ref<EndpointMapped>(null)

const loadEndpoints = async (cluster: string|null = props.cluster, container: string|null = props.container) => {
    if (!(container || cluster)) {
        return
    }

    const { data: responseData } = await axios.get(
        route(
            'api.endpoint.index',
            {
                'cluster': cluster,
                'container': container,
                'except_endpoint_id': props.exceptId
            }
        )
    )

    endpoints.value = responseData?.map((endpoint: Endpoint) => ({
        value: endpoint.hash,
        label: endpoint.name,
        ports: endpoint.ports
    })) || []
}

onMounted(() => {
    loadEndpoints()
})

watch(container, (newValue, oldValue) => {
    if (newValue !== oldValue) {
        loadEndpoints()
    }
})

watch(model, (newValue, oldValue) => {
    if (newValue !== oldValue) {
        selectedEndpoint.value = endpoints.value?.find(endpoint => endpoint.value === newValue)
    }
})

defineExpose({
    loadEndpoints,
    selectedEndpoint
})
</script>

<template>
    <Combobox
        v-model="model"
        :items="endpoints"
        placeholder="Pilih Endpoint"
        :disabled="disabled"
    />
</template>
