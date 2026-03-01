<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ArrowLeft, Clock, Globe, Mail, Trash2, User } from 'lucide-vue-next';
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

const props = defineProps<{ message: Msg }>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Messages', href: '/admin/messages' },
    { title: props.message.name, href: '#' },
];

function formatDate(date: string) {
    return new Date(date).toLocaleDateString('id-ID', {
        weekday: 'long', day: 'numeric', month: 'long', year: 'numeric',
        hour: '2-digit', minute: '2-digit',
    });
}

function destroy() {
    if (confirm('Delete this message?')) router.delete(`/admin/messages/${props.message.id}`);
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="`Message from ${message.name}`" />
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <Button variant="outline" size="sm" as-child>
                    <Link href="/admin/messages"><ArrowLeft class="mr-2 h-4 w-4" /> Back</Link>
                </Button>
                <Button variant="destructive" size="sm" @click="destroy">
                    <Trash2 class="mr-2 h-4 w-4" /> Delete
                </Button>
            </div>

            <div class="max-w-2xl space-y-6">
                <div class="rounded-lg border p-6">
                    <div class="mb-6 space-y-3">
                        <div class="flex items-center gap-3">
                            <User class="h-4 w-4 text-muted-foreground" />
                            <span class="text-sm font-medium">{{ message.name }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <Mail class="h-4 w-4 text-muted-foreground" />
                            <a :href="`mailto:${message.email}`" class="text-sm text-primary hover:underline">{{ message.email }}</a>
                        </div>
                        <div class="flex items-center gap-3">
                            <Clock class="h-4 w-4 text-muted-foreground" />
                            <span class="text-sm text-muted-foreground">{{ formatDate(message.created_at) }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <Globe class="h-4 w-4 text-muted-foreground" />
                            <span class="font-mono text-sm text-muted-foreground">{{ message.ip_address }}</span>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <p class="whitespace-pre-wrap text-sm leading-relaxed">{{ message.message }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
