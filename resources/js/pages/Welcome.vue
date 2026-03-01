<script setup lang="ts">
import { ref, computed, onMounted, nextTick } from 'vue';
import { Head } from '@inertiajs/vue3';
import { usePortfolioData } from '@/composables/usePortfolioData';
import LanguageModal from '@/components/welcome/LanguageModal.vue';
import LanguageToggle from '@/components/welcome/LanguageToggle.vue';
import FloatingNav from '@/components/welcome/FloatingNav.vue';
import HeroSection from '@/components/welcome/HeroSection.vue';
import ExperienceSection from '@/components/welcome/ExperienceSection.vue';
import EducationSection from '@/components/welcome/EducationSection.vue';
import OrganizationsCard from '@/components/welcome/OrganizationsCard.vue';
import CertificationsCard from '@/components/welcome/CertificationsCard.vue';
import TechStackMarquee from '@/components/welcome/TechStackMarquee.vue';
import PortfolioSection from '@/components/welcome/PortfolioSection.vue';
import ProjectModal from '@/components/welcome/ProjectModal.vue';
import ContactSection from '@/components/welcome/ContactSection.vue';
import type { Lang } from '@/composables/usePortfolioData';

// --- Server data via Inertia props ---
type HeroData = {
    role: string;
    summary_id: string;
    summary_en: string;
    focus_text_id: string;
    focus_text_en: string;
    years_of_experience: number;
    position_tags: string[];
};

type WorkExp = {
    company: string;
    position: string;
    start_date: string;
    end_date: string | null;
    description_id: string;
    description_en: string;
};

type Edu = {
    university: string;
    degree_id: string;
    degree_en: string;
    gpa: string;
    awards: string[];
    research_title: string;
    research_link: string;
};

type Org = {
    organization_name: string;
    position: string;
    year: string;
};

type Cert = {
    name: string;
    issued_by: string;
    link: string;
};

type Tech = {
    name: string;
};

type PortfolioItem = {
    id: number;
    title: string;
    short_description: string;
    long_description: string;
    category: string;
    live_preview_url: string;
    github_url: string;
    stacks: string[];
    key_features: string[];
    images: { image_path: string }[];
};

type Contact = {
    email: string;
    github_url: string;
    linkedin_url: string;
    instagram_url: string;
};

type Seo = {
    site_title: string;
    meta_description: string;
    meta_keywords: string;
};

const props = defineProps<{
    hero: HeroData;
    workExperiences: WorkExp[];
    educations: Edu[];
    organizations: Org[];
    certifications: Cert[];
    techStacks: Tech[];
    portfolios: PortfolioItem[];
    contact: Contact;
    seo: Seo;
}>();

// --- i18n labels only ---
const { currentLang, t, tArray, setLang, toggleLang, initLang } = usePortfolioData();

const showLangModal = ref(false);
const selectedProjectIndex = ref<number | null>(null);
const isDark = ref(false);

function initDarkMode() {
    const saved = localStorage.getItem('portfolio_dark');
    isDark.value = saved === 'true';
}

function toggleDarkMode() {
    isDark.value = !isDark.value;
    localStorage.setItem('portfolio_dark', String(isDark.value));
}

// --- Language-aware computed data from server ---
const lang = computed<Lang>(() => currentLang.value ?? 'id');

const heroSummary = computed(() => lang.value === 'en' ? props.hero.summary_en : props.hero.summary_id);
const heroFocusText = computed(() => lang.value === 'en' ? props.hero.focus_text_en : props.hero.focus_text_id);

const firstEdu = computed(() => props.educations[0] ?? null);
const eduDegree = computed(() => {
    if (!firstEdu.value) return '';
    return lang.value === 'en' ? firstEdu.value.degree_en : firstEdu.value.degree_id;
});

const experienceList = computed(() => {
    return props.workExperiences.map((exp) => {
        const startDate = new Date(exp.start_date);
        const endDate = exp.end_date ? new Date(exp.end_date) : null;
        const startStr = startDate.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
        const endStr = endDate ? endDate.toLocaleDateString('en-US', { month: 'short', year: 'numeric' }) : 'Present';
        return { company: exp.company, period: `${startStr} - ${endStr}` };
    });
});

const experienceRoles = computed(() => props.workExperiences.map((exp) => exp.position));
const experienceDescs = computed(() =>
    props.workExperiences.map((exp) => (lang.value === 'en' ? exp.description_en : exp.description_id)),
);

const orgList = computed(() =>
    props.organizations.map((o) => ({ org: o.organization_name, period: o.year })),
);
const orgPositions = computed(() => props.organizations.map((o) => o.position));

const certList = computed(() =>
    props.certifications.map((c) => {
        const suffix = c.issued_by ? ` (${c.issued_by})` : '';
        return `${c.name}${suffix}`;
    }),
);

const techNames = computed(() => props.techStacks.map((s) => s.name));

const projectList = computed(() =>
    props.portfolios.map((p) => ({
        title: p.title,
        tag: p.category,
        tech: p.stacks ?? [],
        size: '',
        images: (p.images ?? []).map((img) => `/storage/${img.image_path}`),
    })),
);

const projectDescs = computed(() =>
    props.portfolios.map((p) => p.short_description ?? ''),
);

const selectedProject = computed(() => {
    if (selectedProjectIndex.value === null) return null;
    return projectList.value[selectedProjectIndex.value] ?? null;
});

const selectedProjectDesc = computed(() => {
    if (selectedProjectIndex.value === null) return '';
    return projectDescs.value[selectedProjectIndex.value] ?? '';
});

const siteTitle = computed(() => props.seo.site_title || 'Ridha Fahmi Junaidi | Software Engineer');

function handleLangSelect(lang: Lang) {
    showLangModal.value = false;
    setLang(lang);
    nextTick(() => initReveal());
}

function openProjectModal(index: number) {
    selectedProjectIndex.value = index;
}

function closeProjectModal() {
    selectedProjectIndex.value = null;
}

function initReveal() {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('active'), index * 100);
                }
            });
        },
        { threshold: 0.08 },
    );
    document.querySelectorAll('.portfolio-reveal, .portfolio-reveal-left, .portfolio-reveal-right, .portfolio-reveal-zoom').forEach((el) => observer.observe(el));
}

onMounted(() => {
    initDarkMode();
    const hasLang = initLang();
    if (!hasLang) {
        showLangModal.value = true;
    } else {
        nextTick(() => initReveal());
    }
});
</script>

<template>
    <Head :title="siteTitle">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous" />
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Instrument+Serif:ital@1&display=swap"
            rel="stylesheet"
        />
        <meta v-if="seo.meta_description" name="description" :content="seo.meta_description" />
        <meta v-if="seo.meta_keywords" name="keywords" :content="seo.meta_keywords" />
    </Head>

    <div class="portfolio-body" :class="{ 'portfolio-dark': isDark }">
    <!-- Language Modal -->
    <LanguageModal :model-value="showLangModal" @select="handleLangSelect" />

    <!-- Language & Dark Mode Toggle -->
    <LanguageToggle
        v-if="currentLang"
        :current-lang="currentLang"
        :is-dark="isDark"
        @toggle-lang="toggleLang"
        @toggle-dark="toggleDarkMode"
    />

    <!-- Floating Nav -->
    <FloatingNav
        v-if="currentLang"
        :nav-home="t('nav_home')"
        :nav-career="t('nav_career')"
        :nav-projects="t('nav_projects')"
        :nav-contact="t('nav_contact')"
        :is-dark="isDark"
    />

    <!-- Main Content -->
    <main
        v-if="currentLang"
        class="portfolio-bento-grid mx-auto max-w-7xl p-4 pb-32 md:p-6 lg:p-10"
    >
        <!-- 1. Hero -->
        <HeroSection
            :role="hero.role"
            name="Ridha Fahmi Junaidi"
            :degree="eduDegree"
            :summary="heroSummary"
            :download-cv="t('download_cv')"
            :contact-me="t('contact_me')"
            :focus-label="t('focus_label')"
            :focus-text="heroFocusText"
            :active="t('active')"
            :years="t('years')"
            :experience-label="t('experience_label')"
            :years-of-experience="hero.years_of_experience"
            :position-tags="hero.position_tags"
            :linkedin-url="contact.linkedin_url"
            :github-url="contact.github_url"
        />

        <!-- 2. Experience -->
        <ExperienceSection
            :career-sub="t('career_sub')"
            :career-title="t('career_title')"
            :career-badge="t('career_badge')"
            :stable="t('stable')"
            :experience="experienceList"
            :experience-roles="experienceRoles"
            :experience-descs="experienceDescs"
        />

        <!-- 3. Education -->
        <EducationSection
            v-if="firstEdu"
            :education-label="t('education_label')"
            :campus="firstEdu.university"
            :degree="eduDegree"
            :awards-label="t('awards_label')"
            :honors="firstEdu.awards ?? []"
            :research-label="t('research_label')"
            :journal="firstEdu.research_title ?? ''"
            :indexed="t('indexed')"
            :gpa-label="t('gpa_label')"
            :gpa="firstEdu.gpa"
            :cum-laude="t('cum_laude')"
        />

        <!-- 4. Organizations & Certs -->
        <OrganizationsCard
            :org-label="t('org_label')"
            :orgs="orgPositions"
            :organizations="orgList"
        />

        <CertificationsCard
            :cert-label="t('cert_label')"
            :certificates="certList"
        />

        <!-- 5. Tech Stack -->
        <TechStackMarquee :skills="techNames" />

        <!-- 6. Portfolio -->
        <PortfolioSection
            :projects-sub="t('projects_sub')"
            :projects-title="t('projects_title')"
            :projects="projectList"
            :project-descs="projectDescs"
            @open-modal="openProjectModal"
        />

        <!-- 7. Contact -->
        <ContactSection
            :contact-title="t('contact_title')"
            :contact-name="t('contact_name')"
            :contact-email-label="t('contact_email_label')"
            :contact-msg="t('contact_msg')"
            :contact-name-ph="t('contact_name_ph')"
            :contact-msg-ph="t('contact_msg_ph')"
            :contact-send="t('contact_send')"
            :email="contact.email"
            :github-url="contact.github_url"
            :linkedin-url="contact.linkedin_url"
            :instagram-url="contact.instagram_url"
        />

        <!-- Footer -->
        <div
            class="col-full py-20 text-center text-[9px] font-black uppercase tracking-[0.5em] opacity-20"
        >
            {{ t('footer') }}
        </div>
    </main>

    <!-- Project Modal -->
    <ProjectModal
        :project="selectedProject"
        :description="selectedProjectDesc"
        @close="closeProjectModal"
    />
    </div>
</template>
