<script setup>
import Container from '../../components/Container.vue';
import Title from '../../components/Title.vue';
import InputField from '../../components/InputField.vue';
import TextArea from '../../Components/TextArea.vue';
import ImageUpload from '../../Components/ImageUpload.vue';
import ErrorMessages from '../../components/ErrorMessages.vue';
import PrimaryBtn from '../../components/PrimaryBtn.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    listing: Object,
});

const form = useForm({
    title: props.listing.title,
    desc: props.listing.desc,
    tags: props.listing.tags,
    email: props.listing.email,
    link: props.listing.link,
    image: null,
    // Add the method to the form data as PUT with POST method
    _method: 'PUT',
});
</script>

<template>

    <Head title="- Edit Listing" />

    <Container>
        <div class="mb-6">
            <Title>Edit your listing</Title>
        </div>

        <ErrorMessages :errors="form.errors" />

        <!-- handling the whole data including the image/files by using POST method instead of other -->
        <form @submit.prevent="form.post(route('listing.update', listing.id))" class="grid grid-cols-2 gap-6">

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

                <ImageUpload @image="(e) => (form.image = e)" :listingImage="listing.image" />
            </div>

            <div>
                <PrimaryBtn :disabled="form.processing">Update</PrimaryBtn>
            </div>
        </form>
    </Container>
</template>