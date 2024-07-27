<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

interface Cluster {
    id: number;
    name: string;
    address: string;
    latitude: string;
    longitude: string;
    deleted_at: string;
}

const props = defineProps<{
    data: Cluster;
}>();

// console.log(props.data.code);

const inputForm = useForm({
    name: props.data.name,
    code: props.data.address,
    latitude: props.data.latitude,
    longitude: props.data.longitude,
});

const handleSubmit = () => {
    inputForm.put(route('cluster.update', props.data.id));
}

</script>

<template>
    <Head title="Edit Cluster" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Cluster</h2>
        </template>


        <div>
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <form @submit.prevent="handleSubmit" action="">
                    <div class="w-1/2">
                        <div class="mb-2">
                            <InputLabel value="Code" />
                            <TextInput v-model="inputForm.code" />
                            <InputError :message="inputForm.errors.code" />
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div class="mb-2">
                            <InputLabel value="Name" />
                            <TextInput v-model="inputForm.name" />
                            <InputError :message="inputForm.errors.name" />
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div class="mb-2">
                            <InputLabel value="Latitude" />
                            <TextInput v-model="inputForm.latitude" />
                            <InputError :message="inputForm.errors.latitude" />
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div class="mb-2">
                            <InputLabel value="Longitude" />
                            <TextInput v-model="inputForm.longitude" />
                            <InputError :message="inputForm.errors.longitude" />
                        </div>
                    </div>
                    <PrimaryButton type="submit">Submit</PrimaryButton>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>




