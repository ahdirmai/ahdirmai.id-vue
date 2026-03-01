<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Tech = { id: number; name: string; sort_order: number };
const props = defineProps<{ techStack?: Tech }>();
const isEditing = !!props.techStack;

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Tech Stack', href: '/admin/tech-stacks' },
    { title: isEditing ? 'Edit' : 'Create', href: '#' },
];

const form = useForm({
    name: props.techStack?.name ?? '',
    sort_order: props.techStack?.sort_order ?? 0,
});

function submit() {
    if (isEditing) {
        form.put(`/admin/tech-stacks/${props.techStack!.id}`);
    } else {
        form.post('/admin/tech-stacks');
    }
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="isEditing ? 'Edit Tech Stack' : 'Create Tech Stack'" />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Heading :title="isEditing ? 'Edit Tech Stack' : 'New Tech Stack'" description="Add a technology to your marquee" />
            <form class="max-w-md space-y-6" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input id="name" v-model="form.name" placeholder="Laravel, React, etc." required />
                    <InputError :message="form.errors.name" />
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
