<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import {computed, onMounted, ref} from "vue";
import type {Endpoint} from "@/types/models";
import type {PropType} from "vue";
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import ClusterCombobox from "@/Components/Partials/ClusterCombobox.vue";

const props = defineProps({
    endpoint: {
        required: route().current('jb.edit'),
        type: Object as PropType<Endpoint>
    }
})

const onMountedState = ref(false)

const form = useForm({
    hash: '',
    cluster_id: '',
    name: '',
    port_total: '0',
});

const handleSubmit = () => {
    const isEdit = route().current('jb.edit')

    if (isEdit && !props.endpoint && !props.endpoint?.hash) return

    const method = isEdit ? 'put' : 'post'
    const routeUrl = isEdit ?
        route('jb.update', props.endpoint.hash) :
        route('jb.store')

    form[method](routeUrl, {
        onSuccess: () => {
            form.reset()
        },
    })
}

const title = computed(() => route().current('jb.edit') ? 'Edit Endpoint' : 'Create Endpoint')



onMounted(async () => {
    if (route().current('jb.edit')) {
        form.hash = props.endpoint.hash
        form.cluster_id = props.endpoint.container.cluster.hash
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




