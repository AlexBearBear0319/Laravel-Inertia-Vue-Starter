<script setup>
import Container from '../../Components/Container.vue'
import InputField from '../../Components/InputField.vue';
import PrimaryBtn from '../../Components/PrimaryBtn.vue';
import { useForm } from "@inertiajs/vue3";
import ErrorMessages from '../../Components/ErrorMessages.vue';
import SessionMessages from '../../Components/SessionMessages.vue';

const form = useForm({
    email: "",
})

defineProps({ status: String })

const submit = () => {
    form.post(route("password.email"))
}

</script>

<template>

    <Head title="- Forgot Password" />
    <Container class="w-1/2">
        <div class="mb-8 text-center">
            <p class="mb-4">
                Forgot your password? No problem. Just let us know your email address and we will email you a password
                reset link that will allow you to choose the new one.
            </p>

            <!-- Error message -->
            <ErrorMessages :errors="form.errors" />

            <SessionMessages :status="status" />

            <form @submit.prevent="submit" class="space-y-6">

                <InputField label="Email" type="email" icon="at" v-model="form.email" />

                <div class="text-left">
                    <PrimaryBtn :disable="form.processing">Send Password Reset Link</PrimaryBtn>
                </div>

            </form>
        </div>
    </Container>
</template>