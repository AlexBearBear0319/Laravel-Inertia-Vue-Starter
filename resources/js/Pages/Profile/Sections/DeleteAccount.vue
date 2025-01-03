<script setup>
import Container from '../../../Components/Container.vue';
import InputField from '../../../Components/InputField.vue';
import Title from '../../../Components/Title.vue';
import PrimaryBtn from '../../../Components/PrimaryBtn.vue';
import ErrorMessages from '../../../Components/ErrorMessages.vue';
import { useForm } from '@inertiajs/vue3';
import { space } from 'postcss/lib/list';

const form = useForm({
    password: '',
});

</script>

<template>
    <Container>
        <div class="mb-6">
            <Title>Delete Account</Title>
            <p>Once your account is deleted, all of its resources data will be permanently deleted. This action cannot
                be undone.</p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <form @submit.prevent="" class="space-y-6">
            <InputField label="Confirm Password" icon="key" type="password" class="w-1/2" v-model="form.password" />

            <div class="flex space-x-4">
                <PrimaryBtn :diabled="form.processing">Confirm</PrimaryBtn>
                <button>Cancel</button>
            </div>
        </form>
    </Container>
</template>