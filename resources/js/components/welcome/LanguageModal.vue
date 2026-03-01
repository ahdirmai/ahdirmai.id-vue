<script setup lang="ts">
import { Globe } from 'lucide-vue-next';
import type { Lang } from '@/composables/usePortfolioData';

defineProps<{
    modelValue: boolean;
}>();

const emit = defineEmits<{
    (e: 'select', lang: Lang): void;
}>();
</script>

<template>
    <div
        v-if="modelValue"
        class="fixed inset-0 z-[1000] flex items-center justify-center"
        style="background: rgba(20, 18, 14, 0.6); backdrop-filter: blur(12px)"
    >
        <div
            class="w-[90%] max-w-[480px] rounded-[2.5rem] bg-white p-12 text-center"
            style="box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.18)"
        >
            <div class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50">
                <Globe class="h-7 w-7 text-amber-600" />
            </div>
            <h2 class="mb-2 text-2xl font-extrabold text-zinc-900">Choose Language</h2>
            <p class="mb-8 text-sm font-medium text-zinc-400">Pilih bahasa tampilan / Select display language</p>
            <div class="flex gap-4">
                <button
                    class="flex-1 rounded-2xl bg-zinc-950 py-4 text-sm font-bold text-white transition-all hover:bg-amber-600 active:scale-95"
                    @click="emit('select', 'id')"
                >
                    🇮🇩 &nbsp;Bahasa Indonesia
                </button>
                <button
                    class="flex-1 rounded-2xl border border-black/5 bg-zinc-100 py-4 text-sm font-bold text-zinc-800 transition-all hover:bg-amber-50 active:scale-95"
                    @click="emit('select', 'en')"
                >
                    🇬🇧 &nbsp;English
                </button>
            </div>
        </div>
    </div>
</template>
