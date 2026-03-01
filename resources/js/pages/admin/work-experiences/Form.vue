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

type WorkExperience = {
    id: number;
    company: string;
    position: string;
    start_date: string;
    end_date: string | null;
    description_id: string;
    description_en: string;
    sort_order: number;
};

const props = defineProps<{
    workExperience?: WorkExperience;
}>();

const isEditing = !!props.workExperience;

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Work Experiences', href: '/admin/work-experiences' },
    { title: isEditing ? 'Edit' : 'Create', href: '#' },
];

const form = useForm({
    company: props.workExperience?.company ?? '',
    position: props.workExperience?.position ?? '',
    start_date: props.workExperience?.start_date?.substring(0, 10) ?? '',
    end_date: props.workExperience?.end_date?.substring(0, 10) ?? '',
    description_id: props.workExperience?.description_id ?? '',
    description_en: props.workExperience?.description_en ?? '',
    sort_order: props.workExperience?.sort_order ?? 0,
});

function submit() {
    if (isEditing) {
        form.put(`/admin/work-experiences/${props.workExperience!.id}`);
    } else {
        form.post('/admin/work-experiences');
    }
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="isEditing ? 'Edit Work Experience' : 'Create Work Experience'" />

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Heading :title="isEditing ? 'Edit Work Experience' : 'New Work Experience'" description="Fill in the details below" />

            <form class="max-w-2xl space-y-6" @submit.prevent="submit">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="company">Company</Label>
                        <Input id="company" v-model="form.company" required />
                        <InputError :message="form.errors.company" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="position">Position</Label>
                        <Input id="position" v-model="form.position" required />
                        <InputError :message="form.errors.position" />
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="start_date">Start Date</Label>
                        <Input id="start_date" v-model="form.start_date" type="date" required />
                        <InputError :message="form.errors.start_date" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="end_date">End Date (leave empty if current)</Label>
                        <Input id="end_date" v-model="form.end_date" type="date" />
                        <InputError :message="form.errors.end_date" />
                    </div>
                </div>

                <div class="grid gap-2">
                    <Label for="description_id">Description (ID)</Label>
                    <Textarea id="description_id" v-model="form.description_id" rows="4" />
                    <InputError :message="form.errors.description_id" />
                </div>

                <div class="grid gap-2">
                    <Label for="description_en">Description (EN)</Label>
                    <Textarea id="description_en" v-model="form.description_en" rows="4" />
                    <InputError :message="form.errors.description_en" />
                </div>

                <div class="grid gap-2">
                    <Label for="sort_order">Sort Order</Label>
                    <Input id="sort_order" v-model.number="form.sort_order" type="number" />
                    <InputError :message="form.errors.sort_order" />
                </div>

                <div class="flex items-center gap-4">
                    <Button :disabled="form.processing">{{ isEditing ? 'Update' : 'Create' }}</Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
