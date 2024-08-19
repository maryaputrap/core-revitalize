<script setup lang="ts">
import {Head, router} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import NavLink from '@/Components/NavLink.vue';
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import type {PropType} from 'vue';
import type {Endpoint, Pagination as PaginationModel} from '@/types/models.ts';
import Pagination from "@/Components/Pagination.vue";

const props = defineProps(
    {
        endpoints: {
            type: Object as PropType<PaginationModel<Endpoint>>,
            required: true,
        }
    }
);

const handleDelete = (hash: string) => {
    if (confirm("Are you sure?")) {
        router.delete(route('endpoint.destroy', {endpoint:hash}), {
            preserveScroll: true,
        })
    }
}

</script>

<template>
    <Head title="Endpoint" />

    <DashboardLayout>
        <div>
            <div class=" mx-auto py-2 px-1 sm:px-2 lg:px-4">
                <div class="flex justify-end mb-6">
                    <!-- <button type="button" class="py-2 px-4  bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">
                        Tambah
                    </button> -->
                    <!-- <PrimaryButton type="button">Tambah</PrimaryButton> -->
                    <NavLink :href="route('endpoint.create')" :active="true">
                        <PrimaryButton type="button">Tambah</PrimaryButton>
                    </NavLink>
                </div>
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300 shadow bg-white rounded-lg">
                                <thead>
                                    <tr class="divide-x divide-gray-200">
                                        <th class=" p-2  whitespace-nowrap font-normal text-gray-900">
                                            No.
                                        </th>
                                        <th class=" p-2  whitespace-nowrap font-normal text-gray-900">
                                            Cluster
                                        </th>
                                        <th class=" p-2  whitespace-nowrap font-normal text-gray-900">
                                            Container
                                        </th>
                                        <th class=" p-2  whitespace-nowrap font-normal text-gray-900">
                                            Code
                                        </th>
                                        <th class=" p-2  whitespace-nowrap font-normal text-gray-900">
                                            Name
                                        </th>
                                        <th class=" p-2  whitespace-nowrap font-normal text-gray-900">
                                            Total Port
                                        </th>
                                        <th class=" p-2  whitespace-nowrap font-normal text-gray-900 relative">
                                            Action
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    <tr v-for="(endpoint, index) in endpoints.data" class="text-gray-700 divide-x divide-gray-200" :key="index">
                                        <td class=" p-2 ">
                                            {{ endpoints.from + index }}.
                                        </td>
                                        <td class=" p-2 ">
                                            {{ endpoint.container?.cluster?.name || '-' }}
                                        </td>
                                        <td class=" p-2 ">
                                            {{ endpoint.container?.name || '-' }}
                                        </td>
                                        <td class=" p-2 ">
                                            {{ endpoint.code }}
                                        </td>
                                        <td class=" p-2 ">
                                            {{ endpoint.name }}
                                        </td>
                                        <td class=" p-2 ">
                                            {{ endpoint.port_total }}
                                        </td>
                                        <td class="relative whitespace-nowrap p-2 text-right text-sm font-medium sm:pr-0">
                                            <div class="flex gap-2 ">
                                                <NavLink :href="route('endpoint.show', {'endpoint': endpoint.hash})" :active="true">
                                                    <SecondaryButton type="button">Show</SecondaryButton>
                                                </NavLink>
                                                <NavLink v-if="endpoint.deleted_at == null" :href="route('endpoint.edit', {'endpoint': endpoint.hash})" :active="true">
                                                    <SecondaryButton type="button">Edit</SecondaryButton>
                                                </NavLink>
                                                <DangerButton type="button" v-if="endpoint.deleted_at == null" @click="handleDelete(endpoint.hash)">
                                                    Delete
                                                </DangerButton>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="endpoints.data.length === 0">
                                        <td class="px-6 py-4" colspan="7">No data.</td>
                                    </tr>
                                </tbody>
                            </table>

                            <Pagination :data="endpoints" class="rounded-lg mt-2"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>




