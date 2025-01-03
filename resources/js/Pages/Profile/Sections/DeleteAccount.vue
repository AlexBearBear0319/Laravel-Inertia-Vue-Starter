<script setup>
import Container from '../../../Components/Container.vue';
import InputField from '../../../Components/InputField.vue';
import Title from '../../../Components/Title.vue';
import PrimaryBtn from '../../../Components/PrimaryBtn.vue';
import ErrorMessages from '../../../Components/ErrorMessages.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const showConfirmPassword = ref(false);

const form = useForm({
    password: '',
});

const submit = () => {
    form.delete(route("profile.destroy"), {
        onSuccess: () => form.reset(),
        onError: () => form.reset(),
        preserveScroll: true,
    });
};

</script>

<template>
    <Container>
        <div class="mb-6">
            <Title>Delete Account</Title>
            <p>Once your account is deleted, all of its resources data will be permanently deleted. This action cannot
                be undone.</p>
        </div>

        <ErrorMessages :errors="form.errors" />

        <div v-if="showConfirmPassword">
            <form @submit.prevent="submit" class="space-y-6">
                <InputField label="Confirm Password" icon="key" type="password" class="w-1/2" v-model="form.password" />

                <div class="flex space-x-4">
                    <PrimaryBtn :diabled="form.processing">Confirm</PrimaryBtn>
                    <button @click="showConfirmPassword = false"
                        class="text-indigo-500 font-medium underline dark:text-indigo-400">Cancel</button>
                </div>
            </form>
        </div>

        <button v-if="!showConfirmPassword" @click="showConfirmPassword = true"
            class="px-6 py-2 rounded-lg bg-red-500 text-white my-6">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i>
            Delete Account
        </button>
    </Container>
</template>