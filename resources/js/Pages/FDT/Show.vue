<script setup lang="ts">
import {Head, router, useForm} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {computed, onMounted, PropType, ref, watch} from 'vue';
import type {Endpoint, Port} from '@/types/models.ts';
import Modal from "@/Components/Modal.vue";
import {XMarkIcon} from "@heroicons/vue/24/solid";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import EndpointCombobox from "@/Components/Partials/EndpointCombobox.vue";
import PortListbox from "@/Components/Partials/PortListbox.vue";

const props = defineProps(
    {
        endpoint: {
            type: Object as PropType<Endpoint>,
            required: true,
        }
    }
);

const endpointCombobox = ref(null)
const portListbox = ref(null)
const ports = ref<Port[]>([])
const openModal = ref(false)

const form = useForm({
    to_endpoint_id: '',
    from_port_id: '',
    to_port_id: '',
})

const closeModal = () => {
    form.reset()
    openModal.value = false
}

const handleConnect = () => {
    form.post(route('connection.connect', {
        endpoint: props.endpoint.hash
    }), {
        preserveScroll: false,
        preserveState: false,
        onSuccess: () => {
            closeModal()
        }
    })
}

const handleDelete = (hash: string) => {
    if (confirm("Are you sure?")) {
        router.post(route('connection.disconnect', {
            endpoint: props.endpoint.hash,
            port: hash
        }), {}, {
            preserveScroll: true,
            preserveState: false,
        })
    }
}

const portsCanBeConnected = computed(() => {
    return ports.value.filter(port => port.to_ports.length === 0)
})

watch(() => endpointCombobox.value?.selectedEndpoint, (newValue, oldValue) => {
    if (newValue !== oldValue) {
        const ports = (newValue?.ports || []).filter(port => {
            return port.is_connected === false
        })
        portListbox.value?.loadPorts(ports)
    }
})

onMounted(() => {
    ports.value = props.endpoint.ports || []
})
</script>

<template>
    <Head title="Port" />

    <DashboardLayout>
        <div>
            <div class=" mx-auto py-2 px-1 sm:px-2 lg:px-4">
                <div class="mb-5">
<!--                    <h1 class="text-2xl font-semibold text-gray-900">-->
<!--                        Cluster {{ endpoint.container.cluster.name }}-->
<!--                    </h1>-->
                    <h3 class="text-lg font-semibold text-gray-700 mt-3">
                        Endpoint {{ endpoint.name }}
                    </h3>
                </div>
                <div class="flex justify-end mb-6">
                    <!-- <button type="button" class="py-2 px-4  bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-lg ">
                        Tambah
                    </button> -->
                    <!-- <PrimaryButton type="button">Tambah</PrimaryButton> -->
                    <PrimaryButton type="button" @click="openModal = true">Connect</PrimaryButton>
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
                                            Port
                                        </th>
                                        <th class=" p-2  whitespace-nowrap font-normal text-gray-900">
                                            To Endpoint
                                        </th>
                                        <th class=" p-2  whitespace-nowrap font-normal text-gray-900">
                                            To Port
                                        </th>
                                        <th class=" p-2  whitespace-nowrap font-normal text-gray-900 relative">
                                            Action
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    <tr v-for="(port, index) in ports" class="text-gray-700 divide-x divide-gray-200" :key="index">
                                        <td class=" p-2 ">
                                            {{ index + 1 }}.
                                        </td>
                                        <td class=" p-2 ">
                                            {{ port.name }} - {{ port.additional_data?.position }}
                                        </td>
                                        <td class=" p-2 ">
                                            {{ port.to_ports.length > 0 ? port.to_ports[0].endpoint?.name : '-' }}
                                        </td>
                                        <td class=" p-2 ">
                                            {{ port.to_ports.length > 0 ? port.to_ports[0].name : '-' }}
                                        </td>
                                        <td class="relative whitespace-nowrap p-2 text-right text-sm font-medium sm:pr-0">
                                            <div class="flex gap-2 ">
                                                <DangerButton type="button" v-if="port.to_ports.length > 0" @click="handleDelete(port.hash)">
                                                    Disconnect
                                                </DangerButton>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="ports.length === 0">
                                        <td class="px-6 py-4" colspan="7">No data.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Modal
            :show="openModal"
            :closeable="true"
        >
            <div class="p-4">
                <div class="absolute right-0 top-0 hidden pr-4 pt-4 sm:block">
                    <button type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" @click="openModal = false">
                        <span class="sr-only">Close</span>
                        <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                    </button>
                </div>
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Connect to other port</h3>
                        <div class="mt-2">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="w-full">
                                    <InputLabel value="From Port" />
                                    <PortListbox
                                        :ports="portsCanBeConnected"
                                        v-model="form.from_port_id"
                                    />
                                    <InputError :message="form.errors.from_port_id" />
                                </div>

                                <div></div>

                                <div class="w-full">
                                    <InputLabel value="To Endpoint" />
                                    <EndpointCombobox
                                        ref="endpointCombobox"
                                        v-model="form.to_endpoint_id"
                                        :container="endpoint.container.hash"
                                        :disabled="false"
                                        :except-id="props.endpoint.hash"
                                    />
                                    <InputError :message="form.errors.to_endpoint_id" />
                                </div>

                                <div class="w-full">
                                    <InputLabel value="To Port" />
                                    <PortListbox
                                        ref="portListbox"
                                        v-model="form.to_port_id"
                                    />
                                    <InputError :message="form.errors.to_port_id" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button type="button" class="inline-flex w-full justify-center rounded-md bg-primary px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-light sm:ml-3 sm:w-auto" @click="handleConnect">Connect</button>
                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="closeModal">Cancel</button>
                </div>
            </div>
        </Modal>
    </DashboardLayout>
</template>




