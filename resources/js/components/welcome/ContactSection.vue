<script setup lang="ts">
import { ref, onMounted, computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Github, Linkedin, Instagram, Send, CheckCircle } from 'lucide-vue-next';

defineProps<{
    contactTitle: string;
    contactName: string;
    contactEmailLabel: string;
    contactMsg: string;
    contactNamePh: string;
    contactMsgPh: string;
    contactSend: string;
    email?: string;
    githubUrl?: string;
    linkedinUrl?: string;
    instagramUrl?: string;
}>();

const form = ref({ name: '', email: '', message: '', website: '', recaptcha_token: '' });
const sending = ref(false);
const sent = ref(false);
const errors = ref<Record<string, string>>({});
const page = usePage();
const siteKey = computed(() => page.props.recaptcha_site_key as string | undefined);

onMounted(() => {
    loadRecaptcha();
});

watch(siteKey, () => {
    loadRecaptcha();
});

function loadRecaptcha() {
    if (siteKey.value && !document.getElementById('recaptcha-script')) {
        const script = document.createElement('script');
        script.id = 'recaptcha-script';
        script.src = `https://www.google.com/recaptcha/api.js?render=${siteKey.value}`;
        script.async = true;
        document.head.appendChild(script);
    }
}

async function submitForm() {
    sending.value = true;
    errors.value = {};

    if (siteKey.value && (window as any).grecaptcha) {
        (window as any).grecaptcha.ready(async () => {
            try {
                const token = await (window as any).grecaptcha.execute(siteKey.value, { action: 'submit' });
                form.value.recaptcha_token = token;
                await sendRequest();
            } catch (e) {
                // Ignore error and try normal submit
                await sendRequest();
            }
        });
    } else {
        await sendRequest();
    }
}

async function sendRequest() {

    try {
        const response = await fetch('/contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-XSRF-TOKEN': getCsrfToken(),
            },
            credentials: 'same-origin',
            body: JSON.stringify(form.value),
        });

        if (response.status === 422) {
            const data = await response.json();
            errors.value = Object.fromEntries(
                Object.entries(data.errors as Record<string, string[]>).map(([k, v]) => [k, v[0]])
            );
        } else if (response.ok || response.status === 302) {
            sent.value = true;
            form.value = { name: '', email: '', message: '', website: '', recaptcha_token: '' };
        }
    } catch {
        // Silently handle network errors
    } finally {
        sending.value = false;
    }
}

function getCsrfToken(): string {
    const match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
    return match ? decodeURIComponent(match[1]) : '';
}
</script>

<template>
    <div id="contact" class="portfolio-reveal-zoom col-full bento-card overflow-hidden bg-white p-6 md:p-10">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-2 lg:gap-16">
            <div>
                <h2
                    class="serif-italic mb-8 text-5xl italic leading-[0.9] text-zinc-900 md:text-6xl"
                    v-html="contactTitle.split('\n').join('<br>')"
                />
                <p class="mb-10 text-sm font-medium text-stone-400 md:text-base">
                    {{ email || 'ridhofahmij225@gmail.com' }}
                </p>
                <div class="flex gap-3">
                    <a
                        :href="githubUrl || '#'"
                        target="_blank"
                        class="flex h-12 w-12 items-center justify-center rounded-full border border-black/5 shadow-sm transition-all hover:bg-zinc-950 hover:text-white"
                    >
                        <Github class="h-5 w-5" />
                    </a>
                    <a
                        :href="linkedinUrl || '#'"
                        target="_blank"
                        class="flex h-12 w-12 items-center justify-center rounded-full border border-black/5 shadow-sm transition-all hover:bg-zinc-950 hover:text-white"
                    >
                        <Linkedin class="h-5 w-5" />
                    </a>
                    <a
                        :href="instagramUrl || '#'"
                        target="_blank"
                        class="flex h-12 w-12 items-center justify-center rounded-full border border-black/5 shadow-sm transition-all hover:bg-zinc-950 hover:text-white"
                    >
                        <Instagram class="h-5 w-5" />
                    </a>
                </div>
            </div>

            <!-- Success State -->
            <div v-if="sent" class="flex flex-col items-center justify-center rounded-[2rem] border border-emerald-200 bg-emerald-50 p-8 text-center">
                <CheckCircle class="mb-4 h-12 w-12 text-emerald-500" />
                <p class="text-lg font-bold text-emerald-700">Message Sent!</p>
                <p class="mt-2 text-sm text-emerald-600">Thank you for reaching out. I'll get back to you soon.</p>
                <button
                    class="mt-6 rounded-xl border border-emerald-300 px-6 py-2 text-xs font-bold uppercase tracking-wider text-emerald-700 transition-colors hover:bg-emerald-100"
                    @click="sent = false"
                >
                    Send Another
                </button>
            </div>

            <!-- Form State -->
            <form
                v-else
                class="space-y-4 rounded-[2rem] border border-black/[0.03] bg-stone-50 p-6 md:p-8"
                @submit.prevent="submitForm"
            >
                <!-- Honeypot: hidden from humans, visible to bots -->
                <div style="position: absolute; left: -9999px; opacity: 0; height: 0; overflow: hidden;" aria-hidden="true">
                    <input v-model="form.website" type="text" name="website" tabindex="-1" autocomplete="off" />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="space-y-1.5">
                        <label class="ml-1 text-[9px] font-black uppercase text-stone-400">{{
                            contactName
                        }}</label>
                        <input
                            v-model="form.name"
                            type="text"
                            :placeholder="contactNamePh"
                            required
                            class="w-full rounded-xl border border-black/5 bg-white p-3.5 text-sm outline-none transition-colors focus:border-amber-400"
                            :class="errors.name ? 'border-red-400' : ''"
                        />
                        <p v-if="errors.name" class="text-xs text-red-500">{{ errors.name }}</p>
                    </div>
                    <div class="space-y-1.5">
                        <label class="ml-1 text-[9px] font-black uppercase text-stone-400">{{
                            contactEmailLabel
                        }}</label>
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="example@mail.com"
                            required
                            class="w-full rounded-xl border border-black/5 bg-white p-3.5 text-sm outline-none transition-colors focus:border-amber-400"
                            :class="errors.email ? 'border-red-400' : ''"
                        />
                        <p v-if="errors.email" class="text-xs text-red-500">{{ errors.email }}</p>
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="ml-1 text-[9px] font-black uppercase text-stone-400">{{
                        contactMsg
                    }}</label>
                    <textarea
                        v-model="form.message"
                        rows="4"
                        :placeholder="contactMsgPh"
                        required
                        class="w-full resize-none rounded-xl border border-black/5 bg-white p-3.5 text-sm outline-none transition-colors focus:border-amber-400"
                        :class="errors.message ? 'border-red-400' : ''"
                    />
                    <p v-if="errors.message" class="text-xs text-red-500">{{ errors.message }}</p>
                </div>
                <p v-if="errors.recaptcha" class="mt-2 text-center text-xs text-red-500">{{ errors.recaptcha }}</p>
                <button
                    :disabled="sending"
                    class="flex w-full items-center justify-center gap-3 rounded-xl bg-zinc-950 py-4 text-xs font-bold uppercase tracking-widest text-white shadow-md transition-all hover:bg-amber-600 active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <template v-if="sending">
                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                        </svg>
                        Sending...
                    </template>
                    <template v-else>
                        {{ contactSend }} <Send class="h-3.5 w-3.5" />
                    </template>
                </button>
                
                <p v-if="siteKey" class="text-center text-[10px] text-stone-400 mt-4 leading-relaxed">
                    This site is protected by reCAPTCHA and the Google
                    <a href="https://policies.google.com/privacy" class="text-stone-500 hover:text-stone-700 underline" target="_blank">Privacy Policy</a> and
                    <a href="https://policies.google.com/terms" class="text-stone-500 hover:text-stone-700 underline" target="_blank">Terms of Service</a> apply.
                </p>
            </form>
        </div>
    </div>
</template>
