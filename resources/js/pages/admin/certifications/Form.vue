<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Cert = { id: number; name: string; issued_by: string; link: string; sort_order: number };
const props = defineProps<{ certification?: Cert }>();
const isEditing = !!props.certification;

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Certifications', href: '/admin/certifications' },
    { title: isEditing ? 'Edit' : 'Create', href: '#' },
];

const form = useForm({
    name: props.certification?.name ?? '',
    issued_by: props.certification?.issued_by ?? '',
    link: props.certification?.link ?? '',
    sort_order: props.certification?.sort_order ?? 0,
});

function submit() {
    if (isEditing) {
        form.put(`/admin/certifications/${props.certification!.id}`);
    } else {
        form.post('/admin/certifications');
    }
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="isEditing ? 'Edit Certification' : 'Create Certification'" />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Heading :title="isEditing ? 'Edit Certification' : 'New Certification'" description="Fill in the details below" />
            <form class="max-w-2xl space-y-6" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="name">Certification Name</Label>
                    <Input id="name" v-model="form.name" required />
                    <InputError :message="form.errors.name" />
                </div>
                <div class="grid gap-2">
                    <Label for="issued_by">Issued By</Label>
                    <Input id="issued_by" v-model="form.issued_by" placeholder="Coursera, BNSP, etc." />
                    <InputError :message="form.errors.issued_by" />
                </div>
                <div class="grid gap-2">
                    <Label for="link">Link</Label>
                    <Input id="link" v-model="form.link" placeholder="https://..." />
                    <InputError :message="form.errors.link" />
                </div>
                <div class="grid gap-2">
                    <Label for="sort_order">Sort Order</Label>
                    <Input id="sort_order" v-model.number="form.sort_order" type="number" />
                </div>
                <Button :disabled="form.processing">{{ isEditing ? 'Update' : 'Create' }}</Button>
            </form>
        </div>
    </AppLayout>
</template>
