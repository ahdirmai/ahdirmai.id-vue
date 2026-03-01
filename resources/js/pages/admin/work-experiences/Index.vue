<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type WorkExperience = {
    id: number;
    company: string;
    position: string;
    start_date: string;
    end_date: string | null;
    sort_order: number;
};

defineProps<{ workExperiences: WorkExperience[] }>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Work Experiences', href: '/admin/work-experiences' },
];

function destroy(id: number) {
    if (confirm('Are you sure?')) {
        router.delete(`/admin/work-experiences/${id}`);
    }
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Work Experiences" />

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <Heading title="Work Experiences" description="Manage your work experience entries" />
                <Button as-child>
                    <Link href="/admin/work-experiences/create"><Plus class="mr-2 h-4 w-4" /> Add New</Link>
                </Button>
            </div>

            <div class="rounded-lg border">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b bg-muted/50">
                            <th class="p-3 text-left font-medium">Company</th>
                            <th class="p-3 text-left font-medium">Position</th>
                            <th class="p-3 text-left font-medium">Period</th>
                            <th class="p-3 text-left font-medium">Order</th>
                            <th class="p-3 text-right font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="exp in workExperiences" :key="exp.id" class="border-b last:border-0">
                            <td class="p-3">{{ exp.company }}</td>
                            <td class="p-3">{{ exp.position }}</td>
                            <td class="p-3">{{ exp.start_date }} — {{ exp.end_date ?? 'Present' }}</td>
                            <td class="p-3">{{ exp.sort_order }}</td>
                            <td class="p-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <Button variant="ghost" size="sm" as-child>
                                        <Link :href="`/admin/work-experiences/${exp.id}/edit`"><Pencil class="h-4 w-4" /></Link>
                                    </Button>
                                    <Button variant="ghost" size="sm" @click="destroy(exp.id)"><Trash2 class="h-4 w-4 text-destructive" /></Button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="workExperiences.length === 0">
                            <td colspan="5" class="p-6 text-center text-muted-foreground">No work experiences yet.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
