<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Eye, Mail, MailOpen, Trash2 } from 'lucide-vue-next';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Msg = {
    id: number;
    name: string;
    email: string;
    message: string;
    ip_address: string;
    is_read: boolean;
    created_at: string;
};

type Paginated = {
    data: Msg[];
    current_page: number;
    last_page: number;
    next_page_url: string | null;
    prev_page_url: string | null;
};

defineProps<{ messages: Paginated }>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Messages', href: '/admin/messages' },
];

function destroy(id: number) {
    if (confirm('Delete this message?')) router.delete(`/admin/messages/${id}`);
}

function formatDate(date: string) {
    return new Date(date).toLocaleDateString('id-ID', {
        day: 'numeric', month: 'short', year: 'numeric',
        hour: '2-digit', minute: '2-digit',
    });
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Messages" />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Heading title="Messages" description="Contact form submissions from visitors" />

            <div class="rounded-lg border">
                <table class="w-full text-sm">
                    <thead><tr class="border-b bg-muted/50">
                        <th class="w-10 p-3"></th>
                        <th class="p-3 text-left font-medium">Name</th>
                        <th class="p-3 text-left font-medium">Email</th>
                        <th class="p-3 text-left font-medium">Message</th>
                        <th class="p-3 text-left font-medium">IP</th>
                        <th class="p-3 text-left font-medium">Date</th>
                        <th class="p-3 text-right font-medium">Actions</th>
                    </tr></thead>
                    <tbody>
                        <tr
                            v-for="msg in messages.data"
                            :key="msg.id"
                            class="border-b last:border-0"
                            :class="msg.is_read ? 'opacity-60' : 'font-semibold'"
                        >
                            <td class="p-3 text-center">
                                <MailOpen v-if="msg.is_read" class="mx-auto h-4 w-4 text-muted-foreground" />
                                <Mail v-else class="mx-auto h-4 w-4 text-amber-500" />
                            </td>
                            <td class="p-3">{{ msg.name }}</td>
                            <td class="p-3 text-muted-foreground">{{ msg.email }}</td>
                            <td class="max-w-xs truncate p-3">{{ msg.message }}</td>
                            <td class="p-3 font-mono text-xs text-muted-foreground">{{ msg.ip_address }}</td>
                            <td class="whitespace-nowrap p-3 text-muted-foreground">{{ formatDate(msg.created_at) }}</td>
                            <td class="p-3 text-right">
                                <div class="flex justify-end gap-2">
                                    <Button variant="ghost" size="sm" as-child>
                                        <Link :href="`/admin/messages/${msg.id}`"><Eye class="h-4 w-4" /></Link>
                                    </Button>
                                    <Button variant="ghost" size="sm" @click="destroy(msg.id)">
                                        <Trash2 class="h-4 w-4 text-destructive" />
                                    </Button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="messages.data.length === 0">
                            <td colspan="7" class="p-6 text-center text-muted-foreground">No messages yet.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div v-if="messages.last_page > 1" class="flex justify-center gap-2">
                <Button v-if="messages.prev_page_url" variant="outline" size="sm" as-child>
                    <Link :href="messages.prev_page_url">Previous</Link>
                </Button>
                <span class="flex items-center px-3 text-sm text-muted-foreground">
                    Page {{ messages.current_page }} / {{ messages.last_page }}
                </span>
                <Button v-if="messages.next_page_url" variant="outline" size="sm" as-child>
                    <Link :href="messages.next_page_url">Next</Link>
                </Button>
            </div>
        </div>
    </AppLayout>
</template>
