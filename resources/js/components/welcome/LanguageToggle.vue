<script setup lang="ts">
import { Moon, Sun } from 'lucide-vue-next';
import type { Lang } from '@/composables/usePortfolioData';

defineProps<{
    currentLang: Lang | null;
    isDark: boolean;
}>();

const emit = defineEmits<{
    (e: 'toggleLang'): void;
    (e: 'toggleDark'): void;
}>();
</script>

<template>
    <div class="portfolio-top-controls fixed top-6 right-6 z-[200] flex items-center gap-2">
        <!-- Dark Mode Toggle -->
        <button
            class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-full border border-white/10 text-white transition-all hover:bg-amber-600/90"
            style="background: rgba(24, 24, 27, 0.88); backdrop-filter: blur(12px)"
            :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
            @click="emit('toggleDark')"
        >
            <Sun v-if="isDark" class="h-4 w-4" />
            <Moon v-else class="h-4 w-4" />
        </button>

        <!-- Language Toggle -->
        <button
            class="flex cursor-pointer items-center gap-2 rounded-full border border-white/10 px-4 py-1.5 text-[0.7rem] font-bold uppercase tracking-[0.1em] text-white transition-all hover:bg-amber-600/90"
            style="background: rgba(24, 24, 27, 0.88); backdrop-filter: blur(12px)"
            @click="emit('toggleLang')"
        >
            <span class="text-base">{{ currentLang === 'en' ? '🇬🇧' : '🇮🇩' }}</span>
            <span>{{ (currentLang ?? 'id').toUpperCase() }}</span>
        </button>
    </div>
</template>

<style scoped>
@media (max-width: 768px) {
    .portfolio-top-controls {
        top: 1rem;
        right: 1rem;
    }

    .portfolio-top-controls button:last-child {
        padding: 0.4rem 0.75rem;
        font-size: 0.65rem;
    }
}
</style>
