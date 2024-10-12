<script setup>

import FormSection from '@/Components/FormSection.vue';

</script>

<template>
    <FormSection>
        <template #title>
            Connect Telegram
        </template>

        <template #description>
            Connect your telegram to stay up-to-date, and recieve realtime messages
        </template>

        <template #form>
            <div class="col-span-6">
                <a v-if="! $page.props.auth.user.telegram_chat_id" class="flex items-center gap-2 px-3 py-2 rounded-full bg-blue-500 hover:bg-blue-600 text-white capitalize font-bold w-fit" :href="route('redirect-to-telegram-widget')">
                    <i class="fa-brands fa-telegram text-3xl"></i>
                    <span>Connect Your telegram</span>
                </a>

                <div class="space-y-2" v-else >
                    <button type="button" disabled="disabled" class="flex items-center gap-2 px-3 py-2 rounded-full bg-gray-300 hover:cursor-not-allowed text-white capitalize font-bold w-fit">
                        <i class="fa-brands fa-telegram text-3xl"></i>
                        <span>Connect Your telegram</span>
                    </button>
                    <p class="text-gray-900 text-sm">You already connected a Telegram account</p>
                </div>
            </div>
        </template>

    </FormSection>
</template>
