<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';
import { Sparkles, Download, Mail, Linkedin, Github, Zap, MapPin } from 'lucide-vue-next';

defineProps<{
    role: string;
    name: string;
    degree: string;
    summary: string;
    downloadCv: string;
    contactMe: string;
    focusLabel: string;
    focusText: string;
    active: string;
    years: string;
    experienceLabel: string;
    yearsOfExperience?: number;
    positionTags?: string[];
    linkedinUrl?: string;
    githubUrl?: string;
    cvPath?: string | null;
}>();

const clock = ref('00:00:00 WITA');
let clockInterval: ReturnType<typeof setInterval> | null = null;

function updateClock() {
    const now = new Date();
    const t = now.toLocaleTimeString('en-GB', {
        timeZone: 'Asia/Makassar',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    });
    clock.value = t + ' WITA';
}

onMounted(() => {
    updateClock();
    clockInterval = setInterval(updateClock, 1000);
});

onUnmounted(() => {
    if (clockInterval) clearInterval(clockInterval);
});
</script>

<template>
    <div id="hero" class="portfolio-reveal portfolio-hero-section">
        <!-- ONE BIG L-shaped card -->
        <div class="hero-main-grid">
            <!-- Top part: Name, Role, Degree, About Me inline -->
            <div class="hero-bg-top">
                <p
                    class="mb-6 flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.45em] text-amber-600"
                >
                    <span class="h-[2px] w-10 bg-amber-500" />{{ role }}
                </p>
                <h1
                    class="mb-4 text-6xl leading-[0.85] font-extrabold tracking-tighter text-zinc-900 sm:text-7xl lg:text-8xl"
                >
                    {{ name }}
                </h1>
                <p class="serif-italic mb-6 text-xl font-medium text-stone-400">{{ degree }}</p>
                <div class="mt-4 flex items-start gap-3">
                    <Sparkles class="mt-2 h-4 w-4 shrink-0 text-amber-500" />
                    <!-- eslint-disable-next-line vue/no-v-html -->
                    <p
                        class="text-xl leading-snug font-medium text-stone-500 md:text-2xl lg:text-3xl"
                        v-html="summary"
                    />
                </div>
            </div>

            <!-- Bottom-left part: CTA and Socials -->
            <div class="hero-bg-bottom-left">
                <div class="mt-8">
                    <div class="flex flex-wrap items-center gap-4">
                        <!-- Primary CTA -->
                        <a
                            :href="cvPath ? `/storage/${cvPath}` : '#'"
                            :target="cvPath ? '_blank' : undefined"
                            class="flex items-center gap-2 rounded-full bg-zinc-900 px-6 py-3.5 text-xs font-bold uppercase tracking-widest text-white transition-colors hover:bg-zinc-800"
                        >
                            <Download class="h-4 w-4" />
                            {{ downloadCv }}
                        </a>
                        <!-- Secondary CTA -->
                        <a
                            href="#contact"
                            class="flex items-center gap-2 rounded-full border border-stone-200 bg-white px-6 py-3.5 text-xs font-bold uppercase tracking-widest text-zinc-900 shadow-sm transition-colors hover:bg-stone-50"
                        >
                            <Mail class="h-4 w-4" />
                            {{ contactMe }}
                        </a>

                        <!-- Divider -->
                        <div class="mx-2 hidden h-8 w-px bg-stone-300 sm:block" />

                        <!-- Social Links -->
                        <a
                            :href="linkedinUrl || '#'"
                            target="_blank"
                            class="flex h-11 w-11 items-center justify-center rounded-full border border-stone-200 bg-white text-stone-500 shadow-sm transition-colors hover:border-[#0A66C2] hover:text-[#0A66C2]"
                        >
                            <Linkedin class="h-5 w-5" />
                        </a>
                        <a
                            :href="githubUrl || '#'"
                            target="_blank"
                            class="flex h-11 w-11 items-center justify-center rounded-full border border-stone-200 bg-white text-stone-500 shadow-sm transition-colors hover:border-zinc-900 hover:text-zinc-900"
                        >
                            <Github class="h-5 w-5" />
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom-right part: Two inset cards -->
            <div class="hero-inset-cards mt-4">
                <!-- Card 1: Focus + clock -->
                <div class="hero-inset-card">
                    <div class="flex items-start justify-between">
                        <h4 class="text-[8px] font-black uppercase tracking-widest text-stone-400">
                            {{ focusLabel }}
                        </h4>
                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-amber-50">
                            <Zap class="h-3 w-3 text-amber-500" />
                        </div>
                    </div>
                    <p class="my-3 text-xs leading-snug font-bold text-zinc-700">{{ focusText }}</p>
                    <div class="flex items-center justify-between border-t border-stone-100 pt-2.5">
                        <span class="font-mono text-[8px] font-bold text-stone-400">{{ clock }}</span>
                        <span
                            class="flex items-center gap-1 text-[7px] font-black uppercase text-emerald-600"
                        >
                            <span class="h-1.5 w-1.5 animate-ping rounded-full bg-emerald-500" />{{
                                active
                            }}
                        </span>
                    </div>
                </div>

                <!-- Card 2: Years exp -->
                <div class="hero-inset-card dark">
                    <div class="text-4xl leading-none font-black tracking-tighter text-amber-400">{{ yearsOfExperience ?? 2 }}+</div>
                    <div>
                        <p class="mt-3 text-[10px] font-bold uppercase tracking-widest text-white">
                            {{ years }}
                        </p>
                        <p class="mt-0.5 text-[8px] uppercase tracking-widest text-white/40">
                            {{ experienceLabel }}
                        </p>
                        <div class="mt-3 flex flex-wrap gap-1">
                            <span
                                v-for="(tag, ti) in (positionTags ?? ['Fullstack', 'DevOps'])"
                                :key="ti"
                                class="rounded bg-white/10 px-2 py-0.5 text-[7px] font-bold uppercase text-white/70"
                                >{{ tag }}</span
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- THIN bottom status bar -->
        <div class="hero-bar justify-between">
            <div class="flex w-full flex-1 items-center gap-3 md:w-auto">
                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl border border-stone-200/60 bg-stone-50"
                >
                    <MapPin class="h-4 w-4 text-amber-600" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[8px] font-black uppercase tracking-widest text-stone-400">Location</p>
                    <p class="truncate text-xs font-bold text-zinc-800 sm:text-sm">Banjarmasin, Kalsel 🇮🇩</p>
                </div>
            </div>
            <div class="hidden h-6 w-px bg-stone-100 sm:block" />
            <div class="hidden flex-1 text-center sm:block">
                <p class="text-[8px] font-black uppercase tracking-widest text-stone-400">Status</p>
                <p class="text-xs font-bold text-emerald-600">Open to Work</p>
            </div>
            <div class="hidden h-6 w-px bg-stone-100 sm:block" />
            <div class="hidden flex-1 sm:block sm:text-right">
                <p class="text-[8px] font-black uppercase tracking-widest text-stone-400">Stack</p>
                <p class="text-[10px] font-bold text-zinc-700 sm:text-xs">Laravel · AWS</p>
            </div>
        </div>
    </div>
</template>
