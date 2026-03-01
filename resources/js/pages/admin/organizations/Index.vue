<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Org = { id: number; organization_name: string; position: string; year: string; sort_order: number };
defineProps<{ organizations: Org[] }>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Organizations', href: '/admin/organizations' },
];

function destroy(id: number) {
    if (confirm('Are you sure?')) router.delete(`/admin/organizations/${id}`);
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Organizations" />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <Heading title="Organizations" description="Manage leadership & organizations" />
                <Button as-child><Link href="/admin/organizations/create"><Plus class="mr-2 h-4 w-4" /> Add New</Link></Button>
            </div>
            <div class="rounded-lg border">
                <table class="w-full text-sm">
                    <thead><tr class="border-b bg-muted/50">
                        <th class="p-3 text-left font-medium">Organization</th>
                        <th class="p-3 text-left font-medium">Position</th>
                        <th class="p-3 text-left font-medium">Year</th>
                        <th class="p-3 text-right font-medium">Actions</th>
                    </tr></thead>
                    <tbody>
                        <tr v-for="org in organizations" :key="org.id" class="border-b last:border-0">
                            <td class="p-3">{{ org.organization_name }}</td>
                            <td class="p-3">{{ org.position }}</td>
                            <td class="p-3">{{ org.year }}</td>
                            <td class="p-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <Button variant="ghost" size="sm" as-child><Link :href="`/admin/organizations/${org.id}/edit`"><Pencil class="h-4 w-4" /></Link></Button>
                                    <Button variant="ghost" size="sm" @click="destroy(org.id)"><Trash2 class="h-4 w-4 text-destructive" /></Button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="organizations.length === 0"><td colspan="4" class="p-6 text-center text-muted-foreground">No organizations yet.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
