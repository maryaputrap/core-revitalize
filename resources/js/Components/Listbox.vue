<script setup lang="ts">
import {onMounted, Ref, ref, toRaw, toRefs, watch} from 'vue'
import type { PropType } from 'vue'
import {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'

type Item = {
    label: string;
    value: string | null;
}

const model = defineModel({
    type: [String, Number, Array, null] as PropType<string | number | string[] | number[] | null>,
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
    disabled: {
        type: Boolean as PropType<boolean>,
        required: false,
        default: false,
    },
    withBorder: {
        type: Boolean as PropType<boolean>,
        required: false,
        default: false,
    },
    multiple: {
        type: Boolean as PropType<boolean>,
        required: false,
        default: false,
    },
})

const { items, placeholder } = toRefs(props)
const selectedItem: Ref<Item | Item[] | null> = ref(null)

// Prevent Redundant Unshift: Ensure that placeholder insertion is done only once, avoiding repetitive insertions.
let placeholderAdded = false

const loadSelectedItem = () => {
    const modelValueArray = Array.isArray(model.value) ? model.value : (model.value ? [model.value] : [])

    if (modelValueArray.length > 0) {
        if (props.multiple) {
            selectedItem.value = items.value.filter(item => modelValueArray.includes(item.value)) || []
        } else {
            selectedItem.value = items.value.find(item => item.value === model.value) || null
        }
    } else {
        if (!placeholderAdded && placeholder?.value) {
            items.value.unshift({ label: placeholder.value, value: null })
            placeholderAdded = true
        }

        const firstItem = items.value[0] || null
        selectedItem.value = props.multiple ? (firstItem ? [firstItem] : []) : firstItem
    }
}

onMounted(() => {
    loadSelectedItem()
})

watch(selectedItem, (newValue) => {
    if (props.multiple) {
        const newModelValue = (newValue as Item[]).map(item => item.value)
        if (JSON.stringify(toRaw(newModelValue)) !== JSON.stringify(toRaw(model.value))) {
            model.value = newModelValue
        }
    } else {
        const newModelValue = (newValue as Item | null)?.value || null
        if (newModelValue !== model.value) {
            model.value = newModelValue
        }
    }
}, { deep: true })

watch(model, (newValue, oldValue) => {
    if (JSON.stringify(toRaw(newValue)) !== JSON.stringify(toRaw(oldValue))) {
        loadSelectedItem()
    }
})
</script>


<template>
    <div class="">
        <Listbox v-model="selectedItem" :disabled="disabled" :multiple="multiple">
            <div class="relative mt-1">
                <ListboxButton
                    :class="[
                        withBorder ? 'border border-gray-100' : '',
                        disabled ? 'bg-gray-100 cursor-not-allowed' : 'bg-white',
                        'relative w-full cursor-default rounded-xl py-4 pr-10 pl-5 text-left font-normal tracking-wide text-grayscale-subheading focus:outline-none focus-visible:border-brand-secondary focus-visible:ring-offset-brand-secondary-light focus-visible:ring-1 focus-visible:ring-white/75 focus-visible:ring-offset-1'
                    ]"
                >
                    <span class="block truncate">
                        <span>
                            {{ [].concat(selectedItem).map((item: Item) => item?.label).join(', ') }}
                        </span>
                    </span>
                    <span
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                    >
                    <ChevronUpDownIcon
                        class="h-5 w-5 text-gray-400"
                        aria-hidden="true"
                    />
                  </span>
                </ListboxButton>

                <Transition
                    leave-active-class="transition duration-100 ease-in"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <ListboxOptions
                        class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-xl bg-white divide-y text-base shadow-md focus:outline-none sm:text-sm"
                    >
                        <ListboxOption
                            v-slot="{ active, selected }"
                            v-for="item in items"
                            :key="item.value"
                            :value="item"
                            as="template"
                        >
                            <li
                                :class="[
                                  active ? 'bg-gray-100 text-brand-secondary-light' : 'text-grayscale-subheading',
                                  'relative cursor-default select-none py-3 pl-10 pr-4',
                                ]"
                            >
                                <span
                                    :class="[
                                        selected ? 'font-medium' : 'font-normal', 'block truncate',
                                    ]"
                                >
                                    {{ item.label }}
                                </span>
                                <span
                                    v-if="selected"
                                    class="absolute inset-y-0 left-0 flex items-center pl-3 text-brand-secondary-light"
                                >
                                  <CheckIcon class="h-5 w-5" aria-hidden="true"/>
                                </span>
                            </li>
                        </ListboxOption>
                    </ListboxOptions>
                </Transition>
            </div>
        </Listbox>
    </div>
</template>
