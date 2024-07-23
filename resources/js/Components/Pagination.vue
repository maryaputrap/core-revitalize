<script setup lang="ts">
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid'
import { computed } from 'vue';
import type { PropType } from "vue";
import type { Pagination } from "@/types/models.ts";

const props = defineProps({
    data: {
        required: true,
        type: Object as PropType<Pagination<any>>,
    }
});

const pageLinks = computed(() => props.data.links.slice(1, props.data.links.length - 1))
</script>

<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 select-none sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <a :href="data.prev_page_url || '#'"
               class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Previous
            </a>
            <a :href="data.next_page_url || '#'"
               class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
                Next
            </a>
        </div>
        <div class="hidden select-none sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span v-if="data.from" class="font-medium">{{ data.from }}</span>
                    <span v-if="data.from"> to </span>
                    <span v-if="data.to" class="font-medium">{{ data.to }}</span>
                    <span v-if="data.to"> of </span>
                    <span class="font-medium">{{ data.total }}</span>
                    results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a
                        v-if="data.prev_page_url"
                        :href="data.prev_page_url"
                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                    >
                        <span class="sr-only">Previous</span>
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </a>
                    <span
                        v-else
                        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                    >
                        <span class="sr-only">Previous</span>
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </span>

                    <template v-for="(link, index) in pageLinks" :key="index">
                        <a
                            v-if="link.url"
                            :href="link.url"
                            :class="[
                                'relative inline-flex items-center px-4 py-2 text-sm font-semibold',
                                link.active ? 'z-10 bg-brand-secondary text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-secondary' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0'
                            ]"
                            v-html="link.label"
                        />
                        <span
                            v-else
                            class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0"
                            v-html="link.label"
                        />
                    </template>

                    <a
                        v-if="data.next_page_url"
                        :href="data.next_page_url || '#'"
                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                    >
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                    </a>
                    <span
                        v-else
                        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                    >
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                    </span>
                </nav>
            </div>
        </div>
    </div>
</template>
