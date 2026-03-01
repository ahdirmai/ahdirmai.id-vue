<script setup lang="ts">
import { Medal } from 'lucide-vue-next';

defineProps<{
    certLabel: string;
    certificates: string[];
}>();
</script>

<template>
    <div class="portfolio-reveal-right col-4 bento-card glossy-dark border-none text-white">
        <div class="mb-7 flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 text-amber-400">
                <Medal class="h-4 w-4" />
            </div>
            <h3 class="text-xs font-black uppercase tracking-widest">{{ certLabel }}</h3>
        </div>
        <ul class="space-y-4">
            <li
                v-for="(cert, i) in certificates"
                :key="i"
                class="group flex cursor-default items-center gap-3 text-xs"
            >
                <div
                    class="h-1.5 w-1.5 shrink-0 rounded-full bg-amber-500 transition-transform group-hover:scale-150"
                />
                <span class="font-medium opacity-75 group-hover:opacity-100">{{ cert }}</span>
            </li>
        </ul>
    </div>
</template>
