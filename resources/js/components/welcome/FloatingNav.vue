<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

defineProps<{
    navHome: string;
    navCareer: string;
    navProjects: string;
    navContact: string;
    isDark?: boolean;
}>();

const mobileMenuOpen = ref(false);
const activeSection = ref('hero');

function toggleMobileMenu() {
    mobileMenuOpen.value = !mobileMenuOpen.value;
}

function closeMobileMenu() {
    mobileMenuOpen.value = false;
}

const sections = ['hero', 'experience', 'projects', 'contact'];
let observer: IntersectionObserver | null = null;

onMounted(() => {
    observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    activeSection.value = entry.target.id;
                }
            });
        },
        { threshold: 0.1, rootMargin: '0px 0px -50% 0px' },
    );
    sections.forEach((id) => {
        const el = document.getElementById(id);
        if (el) observer!.observe(el);
    });
});

onUnmounted(() => {
    observer?.disconnect();
});
</script>

<template>
    <!-- Desktop Glossy Pill Nav -->
    <nav class="fixed top-14 left-1/2 z-50 hidden -translate-x-1/2 md:block">
        <div class="floating-nav-glossy flex items-center gap-1 rounded-full p-1.5" :class="{ dark: isDark }">
            <a
                href="#hero"
                class="floating-nav-link"
                :class="{ active: activeSection === 'hero', dark: isDark }"
            >
                {{ navHome }}
            </a>
            <a
                href="#experience"
                class="floating-nav-link"
                :class="{ active: activeSection === 'experience', dark: isDark }"
            >
                {{ navCareer }}
            </a>
            <a
                href="#projects"
                class="floating-nav-link"
                :class="{ active: activeSection === 'projects', dark: isDark }"
            >
                {{ navProjects }}
            </a>
            <a
                href="#contact"
                class="floating-nav-link"
                :class="{ active: activeSection === 'contact', dark: isDark }"
            >
                {{ navContact }}
            </a>
        </div>
    </nav>

    <!-- Mobile Hamburger -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3 md:hidden">
        <div class="portfolio-mobile-menu" :class="{ open: mobileMenuOpen, dark: isDark }">
            <a
                href="#hero"
                class="portfolio-mobile-link"
                :class="{ 'mobile-active': activeSection === 'hero', dark: isDark }"
                @click="closeMobileMenu()"
            >{{ navHome }}</a>
            <a
                href="#experience"
                class="portfolio-mobile-link"
                :class="{ 'mobile-active': activeSection === 'experience', dark: isDark }"
                @click="closeMobileMenu()"
            >{{ navCareer }}</a>
            <a
                href="#projects"
                class="portfolio-mobile-link"
                :class="{ 'mobile-active': activeSection === 'projects', dark: isDark }"
                @click="closeMobileMenu()"
            >{{ navProjects }}</a>
            <a
                href="#contact"
                class="portfolio-mobile-cta"
                :class="{ dark: isDark }"
                @click="closeMobileMenu()"
            >{{ navContact }}</a>
        </div>
        <button
            class="portfolio-hamburger"
            :class="{ open: mobileMenuOpen, dark: isDark }"
            aria-label="Menu"
            @click="toggleMobileMenu()"
        >
            <span class="bar" />
            <span class="bar" />
            <span class="bar" />
        </button>
    </div>
</template>

<style scoped>
/* ── Desktop Glossy Nav — Light Mode ── */
.floating-nav-glossy {
    background: rgba(9, 9, 11, 0.82);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow:
        0 8px 32px rgba(0, 0, 0, 0.3),
        0 1px 0 rgba(255, 255, 255, 0.06) inset;
}

/* Dark mode: lighter frosted glass */
.floating-nav-glossy.dark {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow:
        0 8px 32px rgba(0, 0, 0, 0.4),
        0 1px 0 rgba(255, 255, 255, 0.08) inset;
}

.floating-nav-link {
    padding: 0.5rem 1.25rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.45);
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
}

.floating-nav-link:hover {
    color: rgba(255, 255, 255, 0.85);
}

/* Light mode: active = white pill */
.floating-nav-link.active {
    background: white;
    color: #09090b;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
}

/* Dark mode: active = subtle light pill */
.floating-nav-link.dark.active {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

/* ── Mobile Hamburger — Light ── */
.portfolio-hamburger {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(9, 9, 11, 0.82);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 5px;
    cursor: pointer;
    transition: all 0.2s;
}

.portfolio-hamburger.dark {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.12);
}

.portfolio-hamburger .bar {
    width: 18px;
    height: 2px;
    background: white;
    border-radius: 2px;
    transition: all 0.3s ease;
    transform-origin: center;
    display: block;
}

.portfolio-hamburger.open .bar:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
}

.portfolio-hamburger.open .bar:nth-child(2) {
    opacity: 0;
    transform: scaleX(0);
}

.portfolio-hamburger.open .bar:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
}

/* ── Mobile Menu — Light ── */
.portfolio-mobile-menu {
    position: fixed;
    bottom: 72px;
    left: 50%;
    transform: translateX(-50%) translateY(20px);
    z-index: 49;
    background: rgba(9, 9, 11, 0.9);
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.08);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    border-radius: 1.5rem;
    padding: 0.75rem;
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    width: 200px;
    opacity: 0;
    pointer-events: none;
    transition: all 0.25s cubic-bezier(0.2, 1, 0.3, 1);
}

.portfolio-mobile-menu.dark {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.12);
}

.portfolio-mobile-menu.open {
    opacity: 1;
    pointer-events: all;
    transform: translateX(-50%) translateY(0);
}

.portfolio-mobile-link {
    padding: 0.75rem 1.25rem;
    border-radius: 1rem;
    font-size: 0.8rem;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.6);
    text-decoration: none;
    transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
}

.portfolio-mobile-link:hover {
    background: rgba(255, 255, 255, 0.08);
    color: white;
}

.portfolio-mobile-link.mobile-active {
    background: white;
    color: #09090b;
    font-weight: 800;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.portfolio-mobile-link.dark.mobile-active {
    background: rgba(255, 255, 255, 0.15);
    color: white;
}

.portfolio-mobile-cta {
    padding: 0.75rem 1.25rem;
    border-radius: 1rem;
    font-size: 0.8rem;
    font-weight: 800;
    background: white;
    color: #09090b;
    text-align: center;
    text-decoration: none;
    margin-top: 0.25rem;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.portfolio-mobile-cta.dark {
    background: rgba(255, 255, 255, 0.15);
    color: white;
}
</style>
