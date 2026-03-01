<script setup lang="ts">
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Trash2 } from 'lucide-vue-next';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type PortfolioItem = {
    id: number;
    title: string;
    short_description: string;
    long_description: string;
    category: string;
    live_preview_url: string;
    github_url: string;
    stacks: string[];
    key_features: string[];
    sort_order: number;
    images?: { id: number; image_path: string; sort_order: number }[];
};

const props = defineProps<{ portfolio?: PortfolioItem }>();
const isEditing = !!props.portfolio;

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Portfolios', href: '/admin/portfolios' },
    { title: isEditing ? 'Edit' : 'Create', href: '#' },
];

const form = useForm({
    _method: isEditing ? 'put' : 'post',
    title: props.portfolio?.title ?? '',
    short_description: props.portfolio?.short_description ?? '',
    long_description: props.portfolio?.long_description ?? '',
    category: props.portfolio?.category ?? 'public',
    live_preview_url: props.portfolio?.live_preview_url ?? '',
    github_url: props.portfolio?.github_url ?? '',
    stacks: props.portfolio?.stacks ?? [],
    key_features: props.portfolio?.key_features ?? [],
    sort_order: props.portfolio?.sort_order ?? 0,
    images: [] as File[],
    deleted_images: [] as number[],
});

// Image handling
const existingImages = ref(props.portfolio?.images ? [...props.portfolio.images] : []);
const previewImages = ref<string[]>([]);
const fileInput = ref<HTMLInputElement | null>(null);

function handleFileChange(e: Event) {
    const target = e.target as HTMLInputElement;
    if (!target.files) return;
    
    for (let i = 0; i < target.files.length; i++) {
        const file = target.files[i];
        form.images.push(file);
        previewImages.value.push(URL.createObjectURL(file));
    }
    
    // reset input so the same files can be selected again if removed
    target.value = '';
}

function removeNewImage(index: number) {
    URL.revokeObjectURL(previewImages.value[index]);
    previewImages.value.splice(index, 1);
    form.images.splice(index, 1);
}

function removeExistingImage(id: number) {
    form.deleted_images.push(id);
    existingImages.value = existingImages.value.filter(img => img.id !== id);
}

const newStack = defineModel<string>('newStack', { default: '' });
const newFeature = defineModel<string>('newFeature', { default: '' });

function addStack() {
    if (newStack.value.trim()) { form.stacks.push(newStack.value.trim()); newStack.value = ''; }
}
function removeStack(i: number) { form.stacks.splice(i, 1); }

function addFeature() {
    if (newFeature.value.trim()) { form.key_features.push(newFeature.value.trim()); newFeature.value = ''; }
}
function removeFeature(i: number) { form.key_features.splice(i, 1); }

function submit() {
    // When using FormData with PUT, it's highly recommended to use POST and method spoofing.
    // Inertia's `useForm` automatically converts to FormData when a `File` is present,
    // but we still need to send it via `post(...)` if it contains files.
    if (isEditing) {
        form.post(`/admin/portfolios/${props.portfolio!.id}`);
    } else {
        form.post('/admin/portfolios');
    }
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head :title="isEditing ? 'Edit Portfolio' : 'Create Portfolio'" />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Heading :title="isEditing ? 'Edit Portfolio' : 'New Portfolio'" description="Fill in the project details" />
            <form class="max-w-2xl space-y-6" @submit.prevent="submit">
                <div class="grid gap-2">
                    <Label for="title">Title</Label>
                    <Input id="title" v-model="form.title" required />
                    <InputError :message="form.errors.title" />
                </div>

                <div class="grid gap-2">
                    <Label for="short_description">Short Description</Label>
                    <Textarea id="short_description" v-model="form.short_description" rows="2" />
                    <InputError :message="form.errors.short_description" />
                </div>

                <div class="grid gap-2">
                    <Label for="long_description">Long Description (Problem - Solution - Result)</Label>
                    <Textarea id="long_description" v-model="form.long_description" rows="6" />
                    <InputError :message="form.errors.long_description" />
                </div>

                <div class="grid gap-2">
                    <Label for="category">Category</Label>
                    <select id="category" v-model="form.category" class="flex h-9 w-full rounded-md border border-input bg-transparent px-3 py-1 text-sm shadow-sm">
                        <option value="public">Public</option>
                        <option value="private">Private</option>
                    </select>
                    <InputError :message="form.errors.category" />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="grid gap-2">
                        <Label for="live_preview_url">Live Preview URL</Label>
                        <Input id="live_preview_url" v-model="form.live_preview_url" placeholder="https://..." />
                        <InputError :message="form.errors.live_preview_url" />
                    </div>
                    <div class="grid gap-2">
                        <Label for="github_url">GitHub URL</Label>
                        <Input id="github_url" v-model="form.github_url" placeholder="https://github.com/..." />
                        <InputError :message="form.errors.github_url" />
                    </div>
                </div>

                <!-- Stacks -->
                <div class="grid gap-2">
                    <Label>Tech Stacks</Label>
                    <div class="flex flex-wrap gap-2">
                        <span v-for="(s, i) in form.stacks" :key="i" class="inline-flex items-center gap-1 rounded-full bg-primary px-3 py-1 text-xs font-medium text-primary-foreground">
                            {{ s }} <button type="button" class="ml-1 opacity-70 hover:opacity-100" @click="removeStack(i)">×</button>
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <Input v-model="newStack" placeholder="Add stack" @keydown.enter.prevent="addStack" />
                        <Button type="button" variant="outline" @click="addStack">Add</Button>
                    </div>
                </div>

                <!-- Key Features -->
                <div class="grid gap-2">
                    <Label>Key Features</Label>
                    <div class="flex flex-wrap gap-2">
                        <span v-for="(f, i) in form.key_features" :key="i" class="inline-flex items-center gap-1 rounded-full bg-secondary px-3 py-1 text-xs font-medium text-secondary-foreground">
                            {{ f }} <button type="button" class="ml-1 opacity-70 hover:opacity-100" @click="removeFeature(i)">×</button>
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <Input v-model="newFeature" placeholder="Add feature" @keydown.enter.prevent="addFeature" />
                        <Button type="button" variant="outline" @click="addFeature">Add</Button>
                    </div>
                </div>

                <!-- Gallery Upload -->
                <div class="grid gap-2">
                    <Label>Thumbnail & Gallery Images</Label>
                    <p class="text-xs text-muted-foreground -mt-1">
                        The first image will be used as the project thumbnail. You can upload multiple images. Max 5MB per image.
                    </p>
                    
                    <div class="flex flex-wrap gap-4 mt-2">
                        <!-- Existing Images -->
                        <div v-for="image in existingImages" :key="image.id" class="relative group">
                            <img :src="`/storage/${image.image_path}`" class="h-24 w-auto object-cover rounded border shadow-sm" />
                            <button 
                                type="button" 
                                class="absolute -top-2 -right-2 bg-destructive text-destructive-foreground p-1.5 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all hover:scale-110"
                                @click="removeExistingImage(image.id)"
                            >
                                <Trash2 class="h-3 w-3" />
                            </button>
                        </div>

                        <!-- New Preview Images -->
                        <div v-for="(preview, index) in previewImages" :key="`new-${index}`" class="relative group">
                            <img :src="preview" class="h-24 w-auto object-cover rounded border border-amber-400 shadow-sm" />
                            <button 
                                type="button" 
                                class="absolute -top-2 -right-2 bg-destructive text-destructive-foreground p-1.5 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-all hover:scale-110"
                                @click="removeNewImage(index)"
                            >
                                <Trash2 class="h-3 w-3" />
                            </button>
                        </div>
                    </div>

                    <div class="mt-2 text-sm text-red-500" v-if="form.errors.images">{{ form.errors.images }}</div>
                    <InputError v-for="(err, key) in form.errors" :key="key" :message="key.startsWith('images.') ? err : ''" />

                    <div class="mt-2 flex items-center gap-4">
                        <Input 
                            type="file" 
                            multiple 
                            accept="image/jpeg,image/png,image/gif,image/webp" 
                            @change="handleFileChange" 
                            ref="fileInput" 
                            class="w-full text-muted-foreground" 
                        />
                    </div>
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
