<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Education = {
    id: number;
    university: string;
    degree_id: string;
    degree_en: string;
    gpa: number | null;
    sort_order: number;
};

defineProps<{ educations: Education[] }>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Education', href: '/admin/educations' },
];

function destroy(id: number) {
    if (confirm('Are you sure?')) {
        router.delete(`/admin/educations/${id}`);
    }
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Education" />

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <Heading title="Education" description="Manage your education entries" />
                <Button as-child>
                    <Link href="/admin/educations/create"><Plus class="mr-2 h-4 w-4" /> Add New</Link>
                </Button>
            </div>

            <div class="rounded-lg border">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b bg-muted/50">
                            <th class="p-3 text-left font-medium">University</th>
                            <th class="p-3 text-left font-medium">Degree</th>
                            <th class="p-3 text-left font-medium">GPA</th>
                            <th class="p-3 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="edu in educations" :key="edu.id" class="border-b last:border-0">
                            <td class="p-3">{{ edu.university }}</td>
                            <td class="p-3">{{ edu.degree_en }}</td>
                            <td class="p-3">{{ edu.gpa }}</td>
                            <td class="p-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <Button variant="ghost" size="sm" as-child>
                                        <Link :href="`/admin/educations/${edu.id}/edit`"><Pencil class="h-4 w-4" /></Link>
                                    </Button>
                                    <Button variant="ghost" size="sm" @click="destroy(edu.id)"><Trash2 class="h-4 w-4 text-destructive" /></Button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="educations.length === 0">
                            <td colspan="4" class="p-6 text-center text-muted-foreground">No education entries yet.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
