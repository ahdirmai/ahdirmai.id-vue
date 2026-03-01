<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Tech = { id: number; name: string; sort_order: number };
defineProps<{ techStacks: Tech[] }>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Tech Stack', href: '/admin/tech-stacks' },
];

function destroy(id: number) {
    if (confirm('Are you sure?')) router.delete(`/admin/tech-stacks/${id}`);
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Tech Stack" />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <Heading title="Tech Stack" description="Manage your tech stack marquee" />
                <Button as-child><Link href="/admin/tech-stacks/create"><Plus class="mr-2 h-4 w-4" /> Add New</Link></Button>
            </div>
            <div class="rounded-lg border">
                <table class="w-full text-sm">
                    <thead><tr class="border-b bg-muted/50">
                        <th class="p-3 text-left font-medium">Name</th>
                        <th class="p-3 text-left font-medium">Order</th>
                        <th class="p-3 text-right font-medium">Actions</th>
                    </tr></thead>
                    <tbody>
                        <tr v-for="tech in techStacks" :key="tech.id" class="border-b last:border-0">
                            <td class="p-3">{{ tech.name }}</td>
                            <td class="p-3">{{ tech.sort_order }}</td>
                            <td class="p-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <Button variant="ghost" size="sm" as-child><Link :href="`/admin/tech-stacks/${tech.id}/edit`"><Pencil class="h-4 w-4" /></Link></Button>
                                    <Button variant="ghost" size="sm" @click="destroy(tech.id)"><Trash2 class="h-4 w-4 text-destructive" /></Button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="techStacks.length === 0"><td colspan="3" class="p-6 text-center text-muted-foreground">No tech stacks yet.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
