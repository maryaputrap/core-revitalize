<script setup lang="ts">
import {ref, computed, toRefs, Ref, watch, onMounted} from 'vue'
import {
    Combobox,
    ComboboxInput,
    ComboboxButton,
    ComboboxOptions,
    ComboboxOption,
    TransitionRoot,
} from '@headlessui/vue'
import {ChevronUpDownIcon, CheckIcon} from '@heroicons/vue/20/solid'
import type {PropType} from "vue";

type Item = {
    label: string;
    value: string|null;
}

const model = defineModel({
    type: [String, Number, null] as PropType<string | number | null>,
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
})

const { items, placeholder, disabled } = toRefs(props)
const selectedItem: Ref<Item|null> = ref(null)
const query = ref('')

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

const filteredItem = computed(() =>
    query.value === ''
        ? items.value
        : items.value.filter((item) =>
            item.label
                .toLowerCase()
                .replace(/\s+/g, '')
                .includes(query.value.toLowerCase().replace(/\s+/g, ''))
        )
)

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
    <div class="w-full">
        <Combobox
            v-model="selectedItem"
            by="value"
            :default-value="selectedItem"
            :disabled="disabled"
        >
            <div class="relative mt-1">
                <div
                    class="relative w-full cursor-default overflow-hidden rounded-xl bg-white text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75 focus-visible:ring-offset-2 focus-visible:ring-offset-brand-secondary-light sm:text-sm"
                >
                    <ComboboxInput
                        class="w-full border-none py-4 pr-10 pl-5 font-normal tracking-wide text-grayscale-subheading  focus:ring-0"
                        :displayValue="(item: Item) => item?.label"
                        @change="query = $event.target.value"
                    />
                    <ComboboxButton
                        class="absolute inset-y-0 right-0 flex items-center pr-2"
                    >
                        <ChevronUpDownIcon
                            class="h-5 w-5 text-gray-400"
                            aria-hidden="true"
                        />
                    </ComboboxButton>
                </div>
                <TransitionRoot
                    leave="transition ease-in duration-100"
                    leaveFrom="opacity-100"
                    leaveTo="opacity-0"
                    @after-leave="query = ''"
                >
                    <ComboboxOptions
                        class="absolute mt-1 max-h-60 w-full overflow-auto rounded-xl bg-white py-1 text-base shadow-md ring-1 ring-black/5 focus:outline-none sm:text-sm z-10"
                    >
                        <div
                            v-if="filteredItem.length === 0 && query !== ''"
                            class="relative cursor-default select-none px-4 py-2 text-gray-700"
                        >
                            Nothing found.
                        </div>

                        <ComboboxOption
                            v-for="item in filteredItem"
                            as="template"
                            :key="item.value"
                            :value="item"
                            v-slot="{ selected, active }"
                        >
                            <li
                                class="relative cursor-default select-none py-2 pl-10 pr-4"
                                :class="{
                                      'bg-brand-secondary text-white': active,
                                      'text-gray-900': !active,
                                    }"
                            >
                                <span
                                    class="block truncate"
                                    :class="{ 'font-medium': selected, 'font-normal': !selected }"
                                >
                                  {{ item.label }}
                                </span>
                                <span
                                    v-if="selected"
                                    class="absolute inset-y-0 left-0 flex items-center pl-3"
                                    :class="{ 'text-white': active, 'text-teal-600': !active }"
                                >
                                  <CheckIcon class="h-5 w-5" aria-hidden="true" />
                                </span>
                            </li>
                        </ComboboxOption>
                    </ComboboxOptions>
                </TransitionRoot>
            </div>
        </Combobox>
    </div>
</template>
