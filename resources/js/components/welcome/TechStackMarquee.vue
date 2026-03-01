<script setup lang="ts">
defineProps<{
    skills: string[];
}>();
</script>

<template>
    <div class="portfolio-reveal-zoom col-full bento-card glossy-dark border-none py-7 text-white">
        <div class="marquee-wrapper">
            <div class="marquee-content text-sm font-bold uppercase tracking-[0.25em]">
                <div
                    v-for="(skill, i) in [...skills, ...skills]"
                    :key="i"
                    class="flex cursor-default items-center gap-6 opacity-40 transition-opacity hover:opacity-100"
                >
                    <span>{{ skill }}</span>
                    <div class="h-1.5 w-1.5 rounded-full bg-amber-500" />
                </div>
            </div>
        </div>
    </div>
</template>
