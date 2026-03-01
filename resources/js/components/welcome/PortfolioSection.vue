<script setup lang="ts">
import { ArrowUpRight, ArrowRight } from 'lucide-vue-next';

defineProps<{
    projectsSub: string;
    projectsTitle: string;
    projects: { title: string; tag: string; tech: string[]; size: string; images: string[] }[];
    projectDescs: string[];
}>();

const emit = defineEmits<{
    (e: 'openModal', index: number): void;
}>();
</script>

<template>
    <div id="projects" class="portfolio-reveal portfolio-grid" style="grid-column: 1 / -1">
        <div class="col-full mb-2" style="grid-column: 1 / -1">
            <h3 class="mb-1 text-[9px] font-black uppercase tracking-widest text-stone-400">
                {{ projectsSub }}
            </h3>
            <h2 class="text-4xl font-extrabold tracking-tighter text-zinc-900">{{ projectsTitle }}</h2>
        </div>

        <!-- Hulutalent — LARGEST card -->
        <div
            v-if="projects[0]"
            class="project-hero bento-card group relative cursor-pointer overflow-hidden border-none"
            :style="`
                min-height: 340px;
                background-image: url('${projects[0].images?.[0] || 'https://picsum.photos/800/600?random=1'}');
                background-size: cover;
                background-position: center;
            `"
            @click="emit('openModal', 0)"
        >
            <div
                class="absolute inset-0 bg-zinc-950/80 transition-colors duration-500 group-hover:bg-zinc-950/90"
            />
            <div class="relative z-10 flex h-full flex-col justify-between text-white">
                <div class="flex items-start justify-between">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-stone-400">{{
                        projects[0].tag
                    }}</span>
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 transition-all duration-500 group-hover:border-amber-500 group-hover:bg-amber-500"
                    >
                        <ArrowUpRight class="h-5 w-5" />
                    </div>
                </div>
                <div>
                    <h4
                        class="mb-4 text-4xl leading-tight font-extrabold tracking-tight text-white transition-colors group-hover:text-amber-400 md:text-5xl"
                    >
                        {{ projects[0].title }}
                    </h4>
                    <!-- eslint-disable-next-line vue/no-v-html -->
                    <p
                        class="mb-6 block text-sm leading-relaxed text-stone-300 md:max-w-md"
                        v-html="projectDescs[0]"
                    />
                    <div class="flex flex-wrap gap-2">
                        <span
                            v-for="(t, ti) in projects[0].tech"
                            :key="ti"
                            class="rounded-xl border border-white/10 bg-white/10 px-3 py-1 text-[9px] font-bold text-stone-200 backdrop-blur-md"
                            >{{ t }}</span
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- LMS — second card -->
        <div
            v-if="projects[1]"
            class="project-second bento-card group relative cursor-pointer overflow-hidden border-none text-white"
            :style="`
                min-height: 340px;
                background-image: url('${projects[1].images?.[0] || 'https://picsum.photos/800/600?random=2'}');
                background-size: cover;
                background-position: center;
            `"
            @click="emit('openModal', 1)"
        >
            <div
                class="absolute inset-0 bg-stone-900/40 backdrop-blur-sm transition-all duration-500 group-hover:bg-stone-900/60"
            />
            <div class="relative z-10 flex h-full flex-col justify-between text-white">
                <div class="flex items-start justify-between">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-stone-300">{{
                        projects[1].tag
                    }}</span>
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-full border border-white/20 transition-all duration-500 group-hover:border-amber-500 group-hover:bg-amber-500"
                    >
                        <ArrowUpRight class="h-4 w-4 text-white" />
                    </div>
                </div>
                <div>
                    <h4
                        class="mb-3 text-2xl leading-tight font-extrabold tracking-tight text-white drop-shadow-md transition-colors group-hover:text-amber-400 md:text-3xl"
                    >
                        {{ projects[1].title }}
                    </h4>
                    <!-- eslint-disable-next-line vue/no-v-html -->
                    <p
                        class="mb-5 text-xs leading-relaxed text-stone-200 drop-shadow-md"
                        v-html="projectDescs[1]"
                    />
                    <div class="flex flex-wrap gap-1.5">
                        <span
                            v-for="(t, ti) in projects[1].tech"
                            :key="ti"
                            class="rounded-xl border border-white/10 bg-white/10 px-3 py-1 text-[9px] font-bold text-stone-200 backdrop-blur-md"
                            >{{ t }}</span
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- POS — third card -->
        <div
            v-if="projects[2]"
            class="project-third bento-card group relative cursor-pointer overflow-hidden border-none text-white"
            :style="`
                background-image: url('${projects[2].images?.[0] || 'https://picsum.photos/400/400?random=3'}');
                background-size: cover;
                background-position: center;
            `"
            @click="emit('openModal', 2)"
        >
            <div
                class="absolute inset-0 bg-stone-900/60 transition-all duration-500 group-hover:bg-stone-900/70"
            />
            <div class="relative z-10">
                <div class="mb-6 flex items-start justify-between">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-amber-400">{{
                        projects[2].tag
                    }}</span>
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full border border-white/20 transition-all duration-500 group-hover:bg-amber-500"
                    >
                        <ArrowUpRight class="h-4 w-4" />
                    </div>
                </div>
                <h4
                    class="mb-2 text-xl font-extrabold tracking-tight text-white transition-colors group-hover:text-amber-400"
                >
                    {{ projects[2].title }}
                </h4>
                <!-- eslint-disable-next-line vue/no-v-html -->
                <p class="mb-4 text-xs leading-relaxed text-stone-300" v-html="projectDescs[2]" />
                <div class="flex flex-wrap gap-1.5">
                    <span
                        v-for="(t, ti) in projects[2].tech"
                        :key="ti"
                        class="rounded-lg border border-white/10 bg-white/10 px-2.5 py-1 text-[9px] font-bold text-stone-200 backdrop-blur"
                        >{{ t }}</span
                    >
                </div>
            </div>
        </div>

        <!-- FilesGI — smallest card -->
        <div
            v-if="projects[3]"
            class="project-fourth bento-card group relative cursor-pointer overflow-hidden border-none text-white"
            :style="`
                background-image: url('${projects[3].images?.[0] || 'https://picsum.photos/400/400?random=4'}');
                background-size: cover;
                background-position: center;
            `"
            @click="emit('openModal', 3)"
        >
            <div
                class="absolute inset-0 bg-stone-900/70 transition-all duration-500 group-hover:bg-stone-900/80"
            />
            <div class="relative z-10">
                <div class="mb-6 flex items-start justify-between">
                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-stone-400">{{
                        projects[3].tag
                    }}</span>
                    <div
                        class="flex h-8 w-8 items-center justify-center rounded-full border border-white/10 transition-all duration-500 group-hover:border-amber-500 group-hover:bg-amber-500"
                    >
                        <ArrowUpRight class="h-4 w-4" />
                    </div>
                </div>
                <h4
                    class="mb-2 text-xl font-extrabold tracking-tight text-white transition-colors group-hover:text-amber-400"
                >
                    {{ projects[3].title }}
                </h4>
                <!-- eslint-disable-next-line vue/no-v-html -->
                <p
                    class="mb-4 line-clamp-2 text-xs leading-relaxed text-stone-400"
                    v-html="projectDescs[3]"
                />
                <div class="flex flex-wrap gap-1.5">
                    <span
                        v-for="(t, ti) in projects[3].tech"
                        :key="ti"
                        class="rounded-lg border border-white/10 bg-white/10 px-2.5 py-1 text-[9px] font-bold text-stone-300 backdrop-blur"
                        >{{ t }}</span
                    >
                </div>
            </div>
        </div>

        <!-- Empty 5th slot — "View all" -->
        <div
            class="project-fifth bento-card group flex cursor-pointer flex-col items-center justify-center border-dashed border-stone-200 bg-stone-100/50 text-center transition-all hover:bg-stone-100"
        >
            <div
                class="mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-white shadow-sm transition-all group-hover:shadow-md"
            >
                <ArrowRight class="h-5 w-5 text-stone-400" />
            </div>
            <p class="text-xs font-bold uppercase tracking-widest text-stone-400">More Projects</p>
        </div>
    </div>
</template>
