<script setup lang="ts">
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Sparkles, Loader2 } from 'lucide-vue-next';
import axios from 'axios';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type SeoSettingType = {
    id: number;
    site_title: string;
    meta_description: string;
    meta_keywords: string;
    og_image_path: string;
    favicon_path: string;
};

const props = defineProps<{
    seoSetting: SeoSettingType;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'SEO Setting', href: '/admin/seo' },
];

const form = useForm({
    site_title: props.seoSetting.site_title ?? '',
    meta_description: props.seoSetting.meta_description ?? '',
    meta_keywords: props.seoSetting.meta_keywords ?? '',
    og_image_path: props.seoSetting.og_image_path ?? '',
    favicon_path: props.seoSetting.favicon_path ?? '',
    og_image_file: null as File | null,
    favicon_file: null as File | null,
    _method: 'put',
});

const isGenerating = ref(false);
const generateError = ref('');
const previewUrl = ref<string | null>(null);
const faviconPreviewUrl = ref<string | null>(null);

function handleImageUpload(e: Event) {
    const input = e.target as HTMLInputElement;
    if (input.files && input.files[0]) {
        form.og_image_file = input.files[0];
        previewUrl.value = URL.createObjectURL(input.files[0]);
    } else {
        form.og_image_file = null;
        previewUrl.value = null;
    }
}

function handleFaviconUpload(e: Event) {
    const input = e.target as HTMLInputElement;
    if (input.files && input.files[0]) {
        form.favicon_file = input.files[0];
        faviconPreviewUrl.value = URL.createObjectURL(input.files[0]);
    } else {
        form.favicon_file = null;
        faviconPreviewUrl.value = null;
    }
}

async function generateWithAI() {
    isGenerating.value = true;
    generateError.value = '';
    
    try {
        const response = await axios.post('/admin/seo/generate');
        const data = response.data;
        
        if (data.site_title) form.site_title = data.site_title;
        if (data.meta_description) form.meta_description = data.meta_description;
        if (data.meta_keywords) form.meta_keywords = data.meta_keywords;
        
    } catch (e: any) {
        generateError.value = e.response?.data?.error || e.message || 'An unexpected error occurred.';
    } finally {
        isGenerating.value = false;
    }
}

function submit() {
    form.post('/admin/seo');
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="SEO Setting" />

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center justify-between">
                <Heading title="SEO Setting" description="Configure search engine optimization metadata" />
                <Button type="button" variant="outline" class="gap-2 border-amber-200 bg-amber-50 text-amber-700 hover:bg-amber-100 hover:text-amber-800" @click="generateWithAI" :disabled="isGenerating">
                    <Loader2 v-if="isGenerating" class="h-4 w-4 animate-spin" />
                    <Sparkles v-else class="h-4 w-4" />
                    {{ isGenerating ? 'Generating...' : 'Generate with AI' }}
                </Button>
            </div>

            <div v-if="generateError" class="rounded-md bg-red-50 p-4 mb-4">
                <div class="text-sm text-red-700">{{ generateError }}</div>
            </div>

            <form class="max-w-2xl space-y-6" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="site_title">Site Title</Label>
                    <Input id="site_title" v-model="form.site_title" placeholder="Ridha Fahmi Junaidi | Software Engineer" />
                    <InputError :message="form.errors.site_title" />
                </div>

                <div class="grid gap-2">
                    <Label for="meta_description">Meta Description</Label>
                    <Textarea id="meta_description" v-model="form.meta_description" rows="3" placeholder="A brief description for search engines..." />
                    <InputError :message="form.errors.meta_description" />
                </div>

                <div class="grid gap-2">
                    <Label for="meta_keywords">Meta Keywords</Label>
                    <Input id="meta_keywords" v-model="form.meta_keywords" placeholder="software engineer, fullstack, laravel" />
                    <InputError :message="form.errors.meta_keywords" />
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="og_image_file">OG Image</Label>
                        <div v-if="form.og_image_path && !form.og_image_file" class="mb-2">
                            <img :src="form.og_image_path.startsWith('http') ? form.og_image_path : `/storage/${form.og_image_path}`" alt="OG Image" class="h-40 w-auto object-cover rounded shadow-sm border border-border" />
                        </div>
                        <div v-if="previewUrl" class="mb-2">
                            <img :src="previewUrl" alt="OG Image Preview" class="h-40 w-auto object-cover rounded shadow-sm border border-border" />
                        </div>
                        <Input id="og_image_file" type="file" accept="image/*" @change="handleImageUpload" class="cursor-pointer" />
                        <InputError :message="form.errors.og_image_file" />
                        <p class="text-xs text-muted-foreground">Upload a new OG image (Recommended: 1200x630px).</p>
                    </div>
                    
                    <div class="grid gap-2">
                        <Label for="favicon_file">Favicon</Label>
                        <div v-if="form.favicon_path && !form.favicon_file" class="mb-2">
                            <img :src="form.favicon_path.startsWith('http') ? form.favicon_path : `/storage/${form.favicon_path}`" alt="Favicon" class="h-16 w-16 object-contain rounded shadow-sm border border-border bg-stone-50 p-2" />
                        </div>
                        <div v-if="faviconPreviewUrl" class="mb-2">
                            <img :src="faviconPreviewUrl" alt="Favicon Preview" class="h-16 w-16 object-contain rounded shadow-sm border border-border bg-stone-50 p-2" />
                        </div>
                        <Input id="favicon_file" type="file" accept=".ico,.png,.jpg,.jpeg,.svg" @change="handleFaviconUpload" class="cursor-pointer" />
                        <InputError :message="form.errors.favicon_file" />
                        <p class="text-xs text-muted-foreground">Upload a Favicon (.ico, .png, .svg).</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <Button :disabled="form.processing">Save</Button>
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                    </Transition>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
