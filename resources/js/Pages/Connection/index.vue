<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import NavLink from '@/Components/NavLink.vue';

interface Connection {
    id: number;
    from_port_id: number;
    to_port_id: number;
    tube: string;
    tube_color: string;
    cable: string;
    deleted_at: string
}

const props = defineProps<{
    datas: Connection[];
}>();

const form = useForm(props)

const handleDelete = (id: number) => {
    if (confirm("Are you sure?")) {
        form.delete(route('connection.destroy', {id:id}), {
            preserveScroll: true,
        })
    }
}

</script>

<template>
    <Head title="Connection" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Connection</h2>
        </template>


        <div>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-end mb-6">
                    <!-- <button type="button" class="py-2 px-4  bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">
                        Tambah
                    </button> -->
                    <!-- <PrimaryButton type="button">Tambah</PrimaryButton> -->
                    <NavLink :href="route('connection.create')" :active="true">
                        <PrimaryButton type="button">Tambah</PrimaryButton>
                    </NavLink>
                </div>
                <table class="table p-4 bg-white rounded-lg shadow w-full">
                    <thead>
                        <tr>
                            <th class="border p-4 dark:border-dark-5 whitespace-nowrap font-normal text-gray-900">
                                From Port
                            </th>
                            <th class="border p-4 dark:border-dark-5 whitespace-nowrap font-normal text-gray-900">
                                To Port
                            </th>
                            <th class="border p-4 dark:border-dark-5 whitespace-nowrap font-normal text-gray-900">
                                Tube
                            </th>
                            <th class="border p-4 dark:border-dark-5 whitespace-nowrap font-normal text-gray-900">
                                Tube Color
                            </th>
                            <th class="border p-4 dark:border-dark-5 whitespace-nowrap font-normal text-gray-900">
                                Cable
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="connection in datas" class="text-gray-700">
                            <td class="border p-4 dark:border-dark-5">
                                {{ connection.from_port_id }}
                            </td>
                            <td class="border p-4 dark:border-dark-5">
                                {{ connection.to_port_id }}
                            </td>
                            <td class="border p-4 dark:border-dark-5">
                                {{ connection.tube }}
                            </td>
                            <td class="border p-4 dark:border-dark-5">
                                {{ connection.tube_color }}
                            </td>
                            <td class="border p-4 dark:border-dark-5">
                                {{ connection.cable }}
                            </td>
                            <td class="border p-4 dark:border-dark-5 flex gap-2">
                                <NavLink v-if="connection.deleted_at == null" :href="route('connection.edit', {'id': connection.id})" :active="true">
                                    <SecondaryButton type="button">Edit</SecondaryButton>
                                </NavLink>
                                <DangerButton type="button" v-if="connection.deleted_at == null" @click="handleDelete(connection.id)">Delete</DangerButton>
                            </td>
                        </tr>
                        <tr v-if="props.datas.length === 0">
                            <td class="px-6 py-4" collspan="2">No data.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>




