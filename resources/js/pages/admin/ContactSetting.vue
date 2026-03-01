<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type ContactSettingType = {
    id: number;
    email: string;
    github_url: string;
    linkedin_url: string;
    instagram_url: string;
    recaptcha_site_key: string;
    recaptcha_secret_key: string;
};

const props = defineProps<{
    contactSetting: ContactSettingType;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Contact Setting', href: '/admin/contact' },
];

const form = useForm({
    email: props.contactSetting.email ?? '',
    github_url: props.contactSetting.github_url ?? '',
    linkedin_url: props.contactSetting.linkedin_url ?? '',
    instagram_url: props.contactSetting.instagram_url ?? '',
    recaptcha_site_key: props.contactSetting.recaptcha_site_key ?? '',
    recaptcha_secret_key: props.contactSetting.recaptcha_secret_key ?? '',
});

function submit() {
    form.put('/admin/contact');
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Contact Setting" />

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Heading title="Contact Setting" description="Manage your social links and email" />

            <form class="max-w-2xl space-y-6" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="email">Email</Label>
                    <Input id="email" v-model="form.email" type="email" placeholder="your@email.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="github_url">GitHub URL</Label>
                    <Input id="github_url" v-model="form.github_url" placeholder="https://github.com/username" />
                    <InputError :message="form.errors.github_url" />
                </div>

                <div class="grid gap-2">
                    <Label for="linkedin_url">LinkedIn URL</Label>
                    <Input id="linkedin_url" v-model="form.linkedin_url" placeholder="https://linkedin.com/in/username" />
                    <InputError :message="form.errors.linkedin_url" />
                </div>

                <div class="grid gap-2">
                    <Label for="instagram_url">Instagram URL</Label>
                    <Input id="instagram_url" v-model="form.instagram_url" placeholder="https://instagram.com/username" />
                    <InputError :message="form.errors.instagram_url" />
                </div>

                <div class="grid gap-2">
                    <Label for="recaptcha_site_key">reCAPTCHA v3 Site Key</Label>
                    <Input id="recaptcha_site_key" v-model="form.recaptcha_site_key" placeholder="6Lc..." />
                    <InputError :message="form.errors.recaptcha_site_key" />
                </div>

                <div class="grid gap-2">
                    <Label for="recaptcha_secret_key">reCAPTCHA v3 Secret Key</Label>
                    <Input id="recaptcha_secret_key" v-model="form.recaptcha_secret_key" type="password" placeholder="6Lc..." />
                    <InputError :message="form.errors.recaptcha_secret_key" />
                    <p class="text-xs text-muted-foreground mt-1">If these are empty, rate-limiting and honeypot will be used instead of reCAPTCHA.</p>
                </div>

                <div class="flex items-center gap-4">
                    <Button :disabled="form.processing">Save</Button>
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                    </Transition>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
