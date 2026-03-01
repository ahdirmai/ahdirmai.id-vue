<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Org = { id: number; organization_name: string; position: string; year: string; sort_order: number };
const props = defineProps<{ organization?: Org }>();
const isEditing = !!props.organization;

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Organizations', href: '/admin/organizations' },
    { title: isEditing ? 'Edit' : 'Create', href: '#' },
];

const form = useForm({
    organization_name: props.organization?.organization_name ?? '',
    position: props.organization?.position ?? '',
    year: props.organization?.year ?? '',
    sort_order: props.organization?.sort_order ?? 0,
});

function submit() {
    if (isEditing) {
        form.put(`/admin/organizations/${props.organization!.id}`);
    } else {
        form.post('/admin/organizations');
    }
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="isEditing ? 'Edit Organization' : 'Create Organization'" />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Heading :title="isEditing ? 'Edit Organization' : 'New Organization'" description="Fill in the details below" />
            <form class="max-w-2xl space-y-6" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="organization_name">Organization Name</Label>
                    <Input id="organization_name" v-model="form.organization_name" required />
                    <InputError :message="form.errors.organization_name" />
                </div>
                <div class="grid gap-2">
                    <Label for="position">Position</Label>
                    <Input id="position" v-model="form.position" required />
                    <InputError :message="form.errors.position" />
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="year">Year</Label>
                        <Input id="year" v-model="form.year" placeholder="2021-2022" required />
                        <InputError :message="form.errors.year" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="sort_order">Sort Order</Label>
                        <Input id="sort_order" v-model.number="form.sort_order" type="number" />
                    </div>
                </div>
                <Button :disabled="form.processing">{{ isEditing ? 'Update' : 'Create' }}</Button>
            </form>
        </div>
    </AppLayout>
</template>
