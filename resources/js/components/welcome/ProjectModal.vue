<script setup lang="ts">
import { ref, watch } from 'vue';
import { X, ExternalLink } from 'lucide-vue-next';

const props = defineProps<{
    project: { title: string; tag: string; tech: string[]; images: string[] } | null;
    description: string;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const visible = ref(false);
const animateContent = ref(false);

watch(
    () => props.project,
    (val) => {
        if (val) {
            visible.value = true;
            setTimeout(() => {
                animateContent.value = true;
            }, 10);
            document.body.style.overflow = 'hidden';
        } else {
            animateContent.value = false;
            setTimeout(() => {
                visible.value = false;
            }, 300);
            document.body.style.overflow = '';
        }
    },
);

function close() {
    emit('close');
}
</script>

<template>
    <div
        v-if="visible"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 transition-all duration-300"
        :class="animateContent ? 'bg-zinc-950/80 backdrop-blur-sm' : 'pointer-events-none opacity-0'"
    >
        <!-- Close overlay -->
        <div class="absolute inset-0 cursor-pointer" @click="close()" />
        <!-- Modal content -->
        <div
            class="relative max-h-[90vh] w-full max-w-2xl transform overflow-y-auto rounded-[2.5rem] bg-white p-8 transition-all duration-300 md:p-12"
            :class="animateContent ? 'translate-y-0' : 'translate-y-8'"
        >
            <button
                class="absolute top-6 right-6 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-stone-100 text-stone-500 transition-colors hover:bg-zinc-900 hover:text-white"
                @click="close()"
            >
                <X class="h-5 w-5" />
            </button>
            <template v-if="project">
                <div
                    class="mb-4 text-[10px] font-black uppercase tracking-[0.3em] text-amber-600"
                >
                    {{ project.tag }}
                </div>
                <h2 class="mb-6 text-3xl font-extrabold tracking-tight text-zinc-900 md:text-5xl">
                    {{ project.title }}
                </h2>

                <!-- Gallery -->
                <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <img
                        v-for="(img, i) in project.images"
                        :key="i"
                        :src="img"
                        alt="Project screenshot"
                        class="h-48 w-full rounded-2xl border border-black/5 object-cover shadow-sm md:h-64"
                    />
                </div>

                <!-- eslint-disable-next-line vue/no-v-html -->
                <p
                    class="mb-8 text-sm leading-relaxed text-stone-500 md:text-base"
                    v-html="description"
                />
                <div class="mb-8 flex flex-wrap gap-2">
                    <span
                        v-for="(t, ti) in project.tech"
                        :key="ti"
                        class="rounded-xl border border-stone-200 px-3 py-1 text-[10px] font-bold text-stone-500"
                        >{{ t }}</span
                    >
                </div>
                <a
                    href="#"
                    class="inline-flex items-center gap-2 rounded-full bg-zinc-900 px-6 py-3.5 text-xs font-bold uppercase tracking-widest text-white shadow-md transition-all hover:bg-amber-600 active:scale-95"
                >
                    Visit Project <ExternalLink class="h-4 w-4" />
                </a>
            </template>
        </div>
    </div>
</template>
