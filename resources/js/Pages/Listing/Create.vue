<script setup>
import Container from '../../components/Container.vue';
import Title from '../../components/Title.vue';
import InputField from '../../components/InputField.vue';
import TextArea from '../../Components/TextArea.vue';
import ImageUpload from '../../Components/ImageUpload.vue';
import ErrorMessages from '../../components/ErrorMessages.vue';
import PrimaryBtn from '../../components/PrimaryBtn.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    title: null,
    desc: null,
    tags: null,
    email: null,
    link: null,
    image: null,
});
</script>

<template>

    <Head title="- New Listing" />

    <Container>
        <div class="mb-6">
            <Title>Create a new listing</Title>
        </div>

        <ErrorMessages :errors="form.errors" />

        <form 
            @submit.prevent="form.post(route('listing.store'))" 
            class="grid grid-cols-2 gap-6"
        >

            <div class="space-y-6">
                <InputField label="Title" icon="heading" placeholder="My new listing" v-model="form.title" />

                <InputField label="Tags (seperate with comma)" icon="tags" placeholder="one, two, three"
                    v-model="form.tags" />

                <TextArea label="Description" icon="newspaper" placeholder="Description of your listing"
                    v-model="form.desc"></TextArea>
            </div>

            <div class="space-y-6">
                <InputField label="Email" icon="at" placeholder="example@email.com" v-model="form.email" />

                <InputField label="External link" icon="up-right-from-square" placeholder="https://example.com"
                    v-model="form.link" />

                <ImageUpload @image="(e) => (form.image = e)" />
            </div>

            <div>
                <PrimaryBtn>Create</PrimaryBtn>
            </div>
        </form>
    </Container>
</template>