<script setup lang="ts">
import { Briefcase, ArrowRight } from 'lucide-vue-next';

defineProps<{
    careerSub: string;
    careerTitle: string;
    careerBadge: string;
    stable: string;
    experience: { company: string; period: string }[];
    experienceRoles: string[];
    experienceDescs: string[];
}>();
</script>

<template>
    <div id="experience" class="portfolio-reveal col-full bento-card border-stone-100 bg-stone-50/80">
        <div class="mb-12 flex flex-col items-start justify-between gap-4 md:flex-row md:items-end">
            <div>
                <h3 class="mb-3 text-[9px] font-black uppercase tracking-widest text-stone-400">
                    {{ careerSub }}
                </h3>
                <h2 class="text-4xl font-extrabold tracking-tighter text-zinc-900">{{ careerTitle }}</h2>
            </div>
            <div
                class="flex items-center gap-2 rounded-full bg-zinc-900 px-4 py-2 text-[10px] font-bold text-white"
            >
                <Briefcase class="h-3 w-3" />
                {{ careerBadge }}
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div
                v-for="(exp, i) in experience"
                :key="i"
                class="flex flex-col justify-between rounded-[2rem] border border-black/[0.03] bg-white p-5 transition-all duration-500 hover:shadow-md md:p-8"
            >
                <div>
                    <div class="mb-6 flex items-start justify-between">
                        <span
                            class="font-mono text-[10px] font-bold uppercase tracking-widest text-stone-300"
                            >{{ exp.period }}</span
                        >
                        <div class="rounded-lg bg-stone-50 px-2.5 py-1 text-[8px] font-bold text-stone-400">
                            {{ stable }}
                        </div>
                    </div>
                    <h4 class="text-lg leading-tight font-extrabold text-zinc-900 md:text-xl">
                        {{ experienceRoles[i] }}
                    </h4>
                    <p class="mt-1.5 mb-4 text-[10px] font-bold uppercase tracking-wider text-amber-600 md:text-xs">
                        {{ exp.company }}
                    </p>
                    <!-- eslint-disable-next-line vue/no-v-html -->
                    <p
                        class="text-xs leading-relaxed font-medium text-stone-500 md:text-sm"
                        v-html="experienceDescs[i]"
                    />
                </div>
                <div class="mt-8 flex justify-end">
                    <ArrowRight class="h-4 w-4 text-stone-200" />
                </div>
            </div>
        </div>
    </div>
</template>
