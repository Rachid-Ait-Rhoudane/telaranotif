<script setup>

import InputText from './TextInput.vue';
import InputError from './InputError.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from './InputLabel.vue';
import FormSection from './FormSection.vue';
import PrimaryButton from './PrimaryButton.vue';

const form = useForm({
  message: ''
});

const sendMessage = () => {
    form.post('/send', {
        onSuccess: () => {
            form.reset();
        }
    });
}

</script>

<template>

    <div class="p-4">

        <FormSection @submitted="sendMessage">

            <template #title>
                Chat
            </template>

            <template #description>
                Send Telegram messages with Laravel notifications
            </template>

            <template #form>
                <div class="col-span-6">
                    <InputLabel>Message</InputLabel>
                    <InputText class="w-full" v-model="form.message" />
                    <InputError v-if="form.errors.message">{{ form.errors.message }}</InputError>
                </div>
            </template>

            <template #actions>
                <PrimaryButton type="submit">Send</PrimaryButton>
            </template>

        </FormSection>

    </div>

</template>
