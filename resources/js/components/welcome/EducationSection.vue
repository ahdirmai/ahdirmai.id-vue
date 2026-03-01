<script setup lang="ts">
import { Award, ExternalLink, GraduationCap } from 'lucide-vue-next';

defineProps<{
    educationLabel: string;
    campus: string;
    degree: string;
    awardsLabel: string;
    honors: string[];
    researchLabel: string;
    journal: string;
    indexed: string;
    gpaLabel: string;
    gpa: string;
    cumLaude: string;
}>();
</script>

<template>
    <div class="portfolio-reveal portfolio-edu-grid col-full" style="grid-column: 1 / -1">
        <!-- Main info -->
        <div class="bento-card flex flex-col justify-between bg-white">
            <div>
                <h3 class="mb-6 text-[9px] font-black uppercase tracking-[0.2em] text-stone-400">
                    {{ educationLabel }}
                </h3>
                <h4 class="text-3xl leading-tight font-extrabold tracking-tight text-zinc-900">
                    {{ campus }}
                </h4>
                <p class="mt-2 font-medium text-stone-500">{{ degree }}</p>
            </div>
            <!-- Awards sub-card -->
            <div class="bento-card glossy mt-6 p-6">
                <h3 class="mb-4 text-[8px] font-black uppercase tracking-widest text-amber-600">
                    {{ awardsLabel }}
                </h3>
                <ul class="space-y-2.5">
                    <li
                        v-for="(honor, i) in honors"
                        :key="i"
                        class="flex items-center gap-2.5 text-xs font-semibold text-zinc-600"
                    >
                        <Award class="h-3.5 w-3.5 shrink-0 text-amber-400" />{{ honor }}
                    </li>
                </ul>
            </div>
        </div>

        <!-- Research + GPA combined card -->
        <div class="bento-card flex flex-col justify-between gap-6 border-stone-100 bg-stone-50">
            <!-- Research top -->
            <div>
                <h3 class="mb-4 text-[9px] font-black uppercase tracking-widest text-stone-400">
                    {{ researchLabel }}
                </h3>
                <p class="serif-italic text-lg leading-snug font-bold text-zinc-800">{{ journal }}</p>
                <div
                    class="mt-4 flex items-center justify-between border-t border-stone-200 pt-4 text-[10px] font-bold text-amber-700"
                >
                    <span>{{ indexed }}</span>
                    <ExternalLink class="h-3.5 w-3.5" />
                </div>
            </div>
            <!-- GPA bottom -->
            <div class="bento-card glossy-dark flex items-center justify-between px-6 py-5 text-white">
                <div>
                    <h3 class="mb-1 text-[8px] font-black uppercase tracking-widest opacity-50">
                        {{ gpaLabel }}
                    </h3>
                    <p class="text-4xl font-black tracking-tighter text-amber-400">{{ gpa }}</p>
                </div>
                <div class="text-right">
                    <GraduationCap class="mb-2 ml-auto h-7 w-7 opacity-20" />
                    <span
                        class="block rounded-full bg-white/10 px-3 py-1 text-[8px] font-black uppercase tracking-widest"
                        >{{ cumLaude }}</span
                    >
                </div>
            </div>
        </div>
    </div>
</template>
