<script setup lang="ts">
import { Users } from 'lucide-vue-next';

defineProps<{
    orgLabel: string;
    orgs: string[];
    organizations: { org: string; period: string }[];
}>();
</script>

<template>
    <div class="portfolio-reveal-left col-8 bento-card bg-white">
        <div class="mb-7 flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                <Users class="h-4 w-4" />
            </div>
            <h3 class="text-xs font-black uppercase tracking-widest">{{ orgLabel }}</h3>
        </div>
        <div class="space-y-5">
            <div
                v-for="(org, i) in organizations"
                :key="i"
                class="group flex items-start justify-between"
            >
                <div>
                    <p class="text-sm font-bold text-zinc-900 transition-colors group-hover:text-amber-600">
                        {{ orgs[i] }}
                    </p>
                    <p class="mt-0.5 text-xs text-stone-400">{{ org.org }}</p>
                </div>
                <span class="font-mono text-[9px] font-bold text-stone-300">{{ org.period }}</span>
            </div>
        </div>
    </div>
</template>
