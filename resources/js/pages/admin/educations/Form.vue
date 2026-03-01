<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Education = {
    id: number;
    university: string;
    degree_id: string;
    degree_en: string;
    gpa: number | null;
    awards: string[];
    research_title: string;
    research_link: string;
    sort_order: number;
};

const props = defineProps<{ education?: Education }>();
const isEditing = !!props.education;

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Education', href: '/admin/educations' },
    { title: isEditing ? 'Edit' : 'Create', href: '#' },
];

const form = useForm({
    university: props.education?.university ?? '',
    degree_id: props.education?.degree_id ?? '',
    degree_en: props.education?.degree_en ?? '',
    gpa: props.education?.gpa ?? null,
    awards: props.education?.awards ?? [],
    research_title: props.education?.research_title ?? '',
    research_link: props.education?.research_link ?? '',
    sort_order: props.education?.sort_order ?? 0,
});

const newAward = defineModel<string>('newAward', { default: '' });

function addAward() {
    if (newAward.value.trim()) {
        form.awards.push(newAward.value.trim());
        newAward.value = '';
    }
}

function removeAward(i: number) {
    form.awards.splice(i, 1);
}

function submit() {
    if (isEditing) {
        form.put(`/admin/educations/${props.education!.id}`);
    } else {
        form.post('/admin/educations');
    }
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="isEditing ? 'Edit Education' : 'Create Education'" />

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Heading :title="isEditing ? 'Edit Education' : 'New Education'" description="Fill in the details below" />

            <form class="max-w-2xl space-y-6" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="university">University</Label>
                    <Input id="university" v-model="form.university" required />
                    <InputError :message="form.errors.university" />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="degree_id">Degree (ID)</Label>
                        <Input id="degree_id" v-model="form.degree_id" required />
                        <InputError :message="form.errors.degree_id" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="degree_en">Degree (EN)</Label>
                        <Input id="degree_en" v-model="form.degree_en" required />
                        <InputError :message="form.errors.degree_en" />
                    </div>
                </div>

                <div class="grid gap-2">
                    <Label for="gpa">GPA</Label>
                    <Input id="gpa" v-model.number="form.gpa" type="number" step="0.01" min="0" max="4" />
                    <InputError :message="form.errors.gpa" />
                </div>

                <div class="grid gap-2">
                    <Label>Awards & Honors</Label>
                    <div class="flex flex-wrap gap-2">
                        <span v-for="(award, i) in form.awards" :key="i" class="inline-flex items-center gap-1 rounded-full bg-primary px-3 py-1 text-xs font-medium text-primary-foreground">
                            {{ award }}
                            <button type="button" class="ml-1 opacity-70 hover:opacity-100" @click="removeAward(i)">×</button>
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <Input v-model="newAward" placeholder="Add award" @keydown.enter.prevent="addAward" />
                        <Button type="button" variant="outline" @click="addAward">Add</Button>
                    </div>
                </div>

                <div class="grid gap-2">
                    <Label for="research_title">Research Title</Label>
                    <Input id="research_title" v-model="form.research_title" />
                    <InputError :message="form.errors.research_title" />
                </div>

                <div class="grid gap-2">
                    <Label for="research_link">Research Link</Label>
                    <Input id="research_link" v-model="form.research_link" placeholder="https://..." />
                    <InputError :message="form.errors.research_link" />
                </div>

                <div class="grid gap-2">
                    <Label for="sort_order">Sort Order</Label>
                    <Input id="sort_order" v-model.number="form.sort_order" type="number" />
                </div>

                <div class="flex items-center gap-4">
                    <Button :disabled="form.processing">{{ isEditing ? 'Update' : 'Create' }}</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
