<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type HeroSetting = {
    id: number;
    role: string;
    summary_id: string;
    summary_en: string;
    focus_text_id: string;
    focus_text_en: string;
    years_of_experience: number;
    position_tags: string[];
};

const props = defineProps<{
    heroSetting: HeroSetting;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Hero Setting', href: '/admin/hero' },
];

const form = useForm({
    role: props.heroSetting.role,
    summary_id: props.heroSetting.summary_id,
    summary_en: props.heroSetting.summary_en,
    focus_text_id: props.heroSetting.focus_text_id,
    focus_text_en: props.heroSetting.focus_text_en,
    years_of_experience: props.heroSetting.years_of_experience,
    position_tags: props.heroSetting.position_tags ?? [],
});

const newTag = defineModel<string>('newTag', { default: '' });

function addTag() {
    if (newTag.value.trim() && !form.position_tags.includes(newTag.value.trim())) {
        form.position_tags.push(newTag.value.trim());
        newTag.value = '';
    }
}

function removeTag(index: number) {
    form.position_tags.splice(index, 1);
}

function submit() {
    form.put('/admin/hero');
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Hero Setting" />

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Heading title="Hero Setting" description="Configure your hero section content" />

            <form class="max-w-2xl space-y-6" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="role">Role / Title</Label>
                    <Input id="role" v-model="form.role" placeholder="Software Engineer" />
                    <InputError :message="form.errors.role" />
                </div>

                <div class="grid gap-2">
                    <Label for="summary_id">Summary (ID)</Label>
                    <Textarea id="summary_id" v-model="form.summary_id" rows="4" placeholder="Ringkasan dalam Bahasa Indonesia..." />
                    <InputError :message="form.errors.summary_id" />
                </div>

                <div class="grid gap-2">
                    <Label for="summary_en">Summary (EN)</Label>
                    <Textarea id="summary_en" v-model="form.summary_en" rows="4" placeholder="Summary in English..." />
                    <InputError :message="form.errors.summary_en" />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="focus_text_id">Current Focus (ID)</Label>
                        <Input id="focus_text_id" v-model="form.focus_text_id" placeholder="Fokus utama..." />
                        <InputError :message="form.errors.focus_text_id" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="focus_text_en">Current Focus (EN)</Label>
                        <Input id="focus_text_en" v-model="form.focus_text_en" placeholder="Current focus..." />
                        <InputError :message="form.errors.focus_text_en" />
                    </div>
                </div>

                <div class="grid gap-2">
                    <Label for="years_of_experience">Years of Experience</Label>
                    <Input id="years_of_experience" v-model.number="form.years_of_experience" type="number" min="0" />
                    <InputError :message="form.errors.years_of_experience" />
                </div>

                <div class="grid gap-2">
                    <Label>Position Tags</Label>
                    <div class="flex flex-wrap gap-2">
                        <span
                            v-for="(tag, i) in form.position_tags"
                            :key="i"
                            class="inline-flex items-center gap-1 rounded-full bg-primary px-3 py-1 text-xs font-medium text-primary-foreground"
                        >
                            {{ tag }}
                            <button type="button" class="ml-1 text-xs opacity-70 hover:opacity-100" @click="removeTag(i)">×</button>
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <Input v-model="newTag" placeholder="Add tag (e.g. Fullstack)" @keydown.enter.prevent="addTag" />
                        <Button type="button" variant="outline" @click="addTag">Add</Button>
                    </div>
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
