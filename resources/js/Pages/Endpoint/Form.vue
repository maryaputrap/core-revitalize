<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import {computed, onMounted, ref, toRefs, watch} from "vue";
import type {Endpoint} from "@/types/models";
import type {PropType} from "vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import ClusterCombobox from "@/Components/Partials/ClusterCombobox.vue";
import ContainerCombobox from "@/Components/Partials/ContainerCombobox.vue";
import EndpointTypeListbox from "@/Components/Partials/EndpointTypeListbox.vue";

const props = defineProps({
    endpoint: {
        required: route().current('endpoint.edit'),
        type: Object as PropType<Endpoint>
    }
})

const containerCombobox = ref(null)
const onMountedState = ref(false)

const form = useForm({
    hash: '',
    type_id: '',
    cluster_id: '',
    container_id: '',
    code: '',
    name: '',
    port_total: '0',
});

const handleSubmit = () => {
    const isEdit = route().current('endpoint.edit')

    if (isEdit && !props.endpoint && !props.endpoint?.hash) return

    const method = isEdit ? 'put' : 'post'
    const routeUrl = isEdit ?
        route('endpoint.update', props.endpoint.hash) :
        route('endpoint.store')

    form[method](routeUrl, {
        onSuccess: () => {
            form.reset()
        },
    })
}

const title = computed(() => route().current('endpoint.edit') ? 'Edit Endpoint' : 'Create Endpoint')

watch(() => form.cluster_id, async (newValue, oldValue) => {
    if ((newValue !== oldValue) && onMountedState.value) {
        await containerCombobox.value.loadContainers(newValue)
        form.container_id = null
    }
})

onMounted(async () => {
    if (route().current('endpoint.edit')) {
        form.hash = props.endpoint.hash
        form.cluster_id = props.endpoint.container.cluster.hash
        await containerCombobox.value.loadContainers(form.cluster_id)
        form.container_id = props.endpoint.container.hash
        form.type_id = props.endpoint.type.hash
        form.code = props.endpoint.code
        form.name = props.endpoint.name
        form.port_total = props.endpoint.port_total
    }

    onMountedState.value = true
})
</script>

<template>
    <Head :title="title" />

    <DashboardLayout>
        <div>
            <div class=" mx-auto py-2 px-1 sm:px-2 lg:px-4">
                <div class="flex items-center justify-between">
                    <div class="sm:flex-auto">
                        <h1 class="text-base font-semibold leading-6 text-gray-900">{{ title }}</h1>
                    </div>
                </div>

                <div class="mt-8 flow-root">
                    <form @submit.prevent="handleSubmit" action="">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <InputLabel value="Cluster" />
                                <ClusterCombobox v-model="form.cluster_id" />
                                <InputError :message="form.errors.cluster_id" />
                            </div>

                            <div>
                                <InputLabel value="Container" />
                                <ContainerCombobox
                                    ref="containerCombobox"
                                    v-model="form.container_id"
                                    :disabled="!form.cluster_id"
                                />
                                <InputError :message="form.errors.container_id" />
                            </div>

                            <div>
                                <InputLabel value="Type" />
                                <EndpointTypeListbox v-model="form.type_id" />
                                <InputError :message="form.errors.type_id" />
                            </div>

                            <div>
                                <InputLabel value="Code" />
                                <TextInput v-model="form.code" />
                                <InputError :message="form.errors.code" />
                            </div>

                            <div>
                                <InputLabel value="Name" />
                                <TextInput v-model="form.name" />
                                <InputError :message="form.errors.name" />
                            </div>

                            <div>
                                <InputLabel value="Total Port" />
                                <TextInput
                                    v-model="form.port_total"
                                />
                                <InputError :message="form.errors.port_total" />
                            </div>


                        </div>

                        <PrimaryButton type="submit" class="mt-4">Submit</PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>




