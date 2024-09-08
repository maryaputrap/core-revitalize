<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {
    HomeIcon,
    CubeTransparentIcon,
    CpuChipIcon,
} from "@heroicons/vue/24/outline";

interface activityLog {
    name: string;
    created_at: string;
}

const props = defineProps<{
    countCluster: Number;
    countEndpoint: Number;
    countPort: Number;
    activityLog: activityLog[];
}>();

function formattedDate(dateString: string): string {
    const date = new Date(dateString);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const seconds = String(date.getSeconds()).padStart(2, '0');

    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

</script>

<template>
    <Head title="Dashboard"/>

    <DashboardLayout>
        <!-- <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div> -->
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <div class="py-4 columns-4">
            <div class="rounded-xl p-4 bg-white shadow">
                <div class="p-2 bg-[#2c81ff] w-10 rounded-xl shadow mb-2">
                    <CubeTransparentIcon class="h-6 w-6 text-white" />
                </div>
                <h1>Cluster</h1>
                <h1 class="text-5xl font-bold">{{ countCluster }}</h1>
            </div>
            <div class="rounded-xl p-4 bg-white shadow">
                <div class="p-2 bg-[#C64CFF] w-10 rounded-xl shadow mb-2">
                    <CubeTransparentIcon class="h-6 w-6 text-white" />
                </div>
                <h1>Manuver Core</h1>
                <h1 class="text-5xl font-bold">200</h1>
            </div>
            <div class="rounded-xl p-4 bg-white shadow">
                <div class="p-2 bg-[#FEC53D] w-10 rounded-xl shadow mb-2">
                    <CpuChipIcon class="h-6 w-6 text-white" />
                </div>
                <h1>Endpoint</h1>
                <h1 class="text-5xl font-bold">{{ countEndpoint }}</h1>
            </div>
            <div class="rounded-xl p-4 bg-white shadow">
                <div class="p-2 bg-[#FF8B3F] w-10 rounded-xl shadow mb-2">
                    <CpuChipIcon class="h-6 w-6 text-white" />
                </div>
                <h1>Port</h1>
                <h1 class="text-5xl font-bold">{{ countPort }}</h1>
            </div>
        </div>
        <div class="shadow bg-white p-4 rounded-xl">
            <h1>Aktivitas Terakhir</h1>
            <table class="table p-4 bg-white rounded-lg shadow w-full mt-4">
                <thead>
                    <tr>
                        <th class="border p-4 dark:border-dark-5 whitespace-nowrap font-normal text-gray-900">
                            Aktivitas
                        </th>
                        <th class="border p-4 dark:border-dark-5 whitespace-nowrap font-normal text-gray-900">
                            Waktu
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="data in activityLog" class="text-gray-700">
                        <td class="border p-4 dark:border-dark-5">
                            {{ data.name }}
                        </td>
                        <td class="border p-4 dark:border-dark-5">
                            {{ formattedDate(data.created_at) }}
                        </td>
                    </tr>
                    <tr v-if="props.activityLog.length === 0">
                        <td class="px-6 py-4" collspan="2">No data.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </DashboardLayout>
</template>
