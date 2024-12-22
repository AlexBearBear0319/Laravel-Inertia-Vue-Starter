<script setup>
import Container from '../../Components/Container.vue'
import Title from '../../Components/Title.vue'
import TextLink from '../../Components/TextLink.vue';
import InputField from '../../Components/InputField.vue';
import PrimaryBtn from '../../Components/PrimaryBtn.vue';
import { useForm } from "@inertiajs/vue3";
import ErrorMessages from '../../Components/ErrorMessages.vue';
import CheckBox from '../../Components/CheckBox.vue';

const form = useForm({
    email: "",
    password: "",
    remember: null,
})

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>

    <Head title="- Login" />
    <Container class="w-3/4">
        <div class="mb-8 text-center">
            <Title>Login to your account</Title>
            <p class="mb-4">
                Need an account?
                <TextLink routeName="register" label="Register" />
            </p>

            <!-- Error message -->
            <ErrorMessages :errors="form.errors" />

            <form @submit.prevent="submit" class="space-y-6">

                <InputField label="Email" type="email" icon="at" v-model="form.email" />

                <InputField label="Password" type="password" icon="key" v-model="form.password" />

                <div class="flex items-center justify-between">

                    <CheckBox name="remember" v-model="form.remember">Remember me</CheckBox>

                    <TextLink routeName="home" label="Forgot Password?" />
                </div>

                <div class="text-left">
                    <PrimaryBtn :disable="form.processing">Login</PrimaryBtn>
                </div>

            </form>
        </div>
    </Container>
</template>