<script setup lang="ts">

import {onMounted, ref} from "vue";
import type {Ref, PropType} from "vue";
import Listbox from "@/Components/Listbox.vue";
import type {Port} from "@/types/models.ts";

type PortMapped = {
    label: string,
    value: string|null
}

const props = defineProps({
    ports: {
        type: Array as PropType<Port[]>,
        required: false,
        default: null
    }
})

const model = defineModel({
    type: [String, null] as PropType<string | null>,
    required: true,
})

const portsMapped: Ref<PortMapped[]> = ref([])

const loadPorts = (ports: Port[]|null = props.ports) => {
    if (!ports) {
        return
    }

    portsMapped.value = ports?.map((port: Port) => ({
        value: port.hash,
        label: port.name
    })) || []
}

onMounted(() => {
    loadPorts()
})

defineExpose({
    loadPorts
})
</script>

<template>
    <Listbox
        v-model="model"
        :items="portsMapped"
        placeholder="Pilih Port"
        :with-min-height="true"
    />
</template>
