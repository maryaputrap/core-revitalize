<script setup lang="ts">
import {ref, computed, toRefs, onMounted, watch} from 'vue'
import {
    Combobox,
    ComboboxInput,
    ComboboxOptions,
    ComboboxOption,
} from '@headlessui/vue'
import type {PropType, Ref} from "vue";

type Item = {
    label: string;
    value: string|null;
}

const model = defineModel({
    type: [String, null] as PropType<string | null>,
    required: true,
})

const props = defineProps({
    items: {
        type: Array as PropType<Item[]>,
        required: true,
    },
    placeholder: {
        type: [String, null] as PropType<string | null>,
        required: false,
    },
})

const { items, placeholder } = toRefs(props)
const selectedItem: Ref<Item|null> = ref(null)
const query = ref('')

const filteredItem = computed(() =>
    query.value.length === 0
        ? items.value
        : items.value.filter((item) => {
            return item.label.toLowerCase().includes(query.value.toLowerCase())
        })
)

const loadSelectedItem = () => {
    if (model.value) {
        selectedItem.value = items?.value?.find(item => item.value === model.value) || null
    } else {
        if (placeholder?.value) {
            items.value.unshift({label: placeholder.value, value: null})
        }

        selectedItem.value = items.value[0] || null
    }
}

onMounted(() => {
    loadSelectedItem()
})

watch(selectedItem, () => {
    model.value = selectedItem.value?.value || null
})

watch(model, () => {
    loadSelectedItem()
})
</script>

<template>
    <Combobox v-model="selectedItem">
        <ComboboxInput
            @change="query = $event.target.value"
            :displayValue="(item: Item) => item?.label"
        />
        <ComboboxOptions>
            <ComboboxOption
                v-for="(item, index) in filteredItem"
                :key="index"
                :value="item"
            >
                {{ item?.label }}
            </ComboboxOption>
        </ComboboxOptions>
    </Combobox>
</template>
