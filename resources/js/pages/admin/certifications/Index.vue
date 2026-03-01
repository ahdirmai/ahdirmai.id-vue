<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Cert = { id: number; name: string; issued_by: string; link: string; sort_order: number };
defineProps<{ certifications: Cert[] }>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Certifications', href: '/admin/certifications' },
];

function destroy(id: number) {
    if (confirm('Are you sure?')) router.delete(`/admin/certifications/${id}`);
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Certifications" />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <Heading title="Certifications" description="Manage your certifications" />
                <Button as-child><Link href="/admin/certifications/create"><Plus class="mr-2 h-4 w-4" /> Add New</Link></Button>
            </div>
            <div class="rounded-lg border">
                <table class="w-full text-sm">
                    <thead><tr class="border-b bg-muted/50">
                        <th class="p-3 text-left font-medium">Name</th>
                        <th class="p-3 text-left font-medium">Issued By</th>
                        <th class="p-3 text-left font-medium">Link</th>
                        <th class="p-3 text-right font-medium">Actions</th>
                    </tr></thead>
                    <tbody>
                        <tr v-for="cert in certifications" :key="cert.id" class="border-b last:border-0">
                            <td class="p-3">{{ cert.name }}</td>
                            <td class="p-3">{{ cert.issued_by }}</td>
                            <td class="p-3"><a v-if="cert.link" :href="cert.link" target="_blank" class="text-primary underline">View</a></td>
                            <td class="p-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <Button variant="ghost" size="sm" as-child><Link :href="`/admin/certifications/${cert.id}/edit`"><Pencil class="h-4 w-4" /></Link></Button>
                                    <Button variant="ghost" size="sm" @click="destroy(cert.id)"><Trash2 class="h-4 w-4 text-destructive" /></Button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="certifications.length === 0"><td colspan="4" class="p-6 text-center text-muted-foreground">No certifications yet.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
