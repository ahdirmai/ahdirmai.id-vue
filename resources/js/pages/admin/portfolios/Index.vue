<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Pencil, Plus, Trash2 } from 'lucide-vue-next';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type PortfolioItem = {
    id: number;
    title: string;
    category: string;
    stacks: string[];
    sort_order: number;
    images: { id: number; image_path: string; sort_order: number }[];
};

defineProps<{ portfolios: PortfolioItem[] }>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Portfolios', href: '/admin/portfolios' },
];

function destroy(id: number) {
    if (confirm('Are you sure?')) router.delete(`/admin/portfolios/${id}`);
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Portfolios" />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <Heading title="Portfolios" description="Manage your portfolio projects" />
                <Button as-child><Link href="/admin/portfolios/create"><Plus class="mr-2 h-4 w-4" /> Add New</Link></Button>
            </div>
            <div class="rounded-lg border">
                <table class="w-full text-sm">
                    <thead><tr class="border-b bg-muted/50">
                        <th class="p-3 text-left font-medium w-16">Image</th>
                        <th class="p-3 text-left font-medium">Title</th>
                        <th class="p-3 text-left font-medium">Category</th>
                        <th class="p-3 text-left font-medium">Stacks</th>
                        <th class="p-3 text-left font-medium">Order</th>
                        <th class="p-3 text-right font-medium">Actions</th>
                    </tr></thead>
                    <tbody>
                        <tr v-for="p in portfolios" :key="p.id" class="border-b last:border-0">
                            <td class="p-3">
                                <img v-if="p.images?.length" :src="`/storage/${p.images[0].image_path}`" class="h-10 w-12 object-cover rounded shadow-sm border" />
                                <div v-else class="h-10 w-12 bg-muted rounded flex items-center justify-center text-[10px] text-muted-foreground border">None</div>
                            </td>
                            <td class="p-3 font-medium">{{ p.title }}</td>
                            <td class="p-3">
                                <span class="rounded-full px-2 py-0.5 text-xs font-medium" :class="p.category === 'public' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400'">
                                    {{ p.category }}
                                </span>
                            </td>
                            <td class="p-3">
                                <div class="flex flex-wrap gap-1">
                                    <span v-for="s in (p.stacks ?? [])" :key="s" class="rounded bg-muted px-1.5 py-0.5 text-xs">{{ s }}</span>
                                </div>
                            </td>
                            <td class="p-3">{{ p.sort_order }}</td>
                            <td class="p-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <Button variant="ghost" size="sm" as-child><Link :href="`/admin/portfolios/${p.id}/edit`"><Pencil class="h-4 w-4" /></Link></Button>
                                    <Button variant="ghost" size="sm" @click="destroy(p.id)"><Trash2 class="h-4 w-4 text-destructive" /></Button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="portfolios.length === 0"><td colspan="6" class="p-6 text-center text-muted-foreground">No portfolios yet.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
