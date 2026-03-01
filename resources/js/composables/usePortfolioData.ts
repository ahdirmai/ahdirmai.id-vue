import { ref, computed } from 'vue';

export type Lang = 'id' | 'en';

const currentLang = ref<Lang | null>(null);

const i18n: Record<Lang, Record<string, unknown>> = {
    id: {
        nav_home: 'Beranda',
        nav_career: 'Karier',
        nav_projects: 'Proyek',
        nav_contact: 'Kontak',
        role: 'Software Engineer',
        degree: 'S1 Ilmu Komputer',
        summary:
            'Saya membangun <strong class="text-zinc-900">sistem yang cepat, skalabel, dan tahan banting</strong>. Fullstack developer berpengalaman <strong class="text-zinc-900">memimpin tim</strong>, mengoptimasi performa hingga <strong class="text-zinc-900">30% lebih efisien</strong>, dan mendeliver solusi dari <strong class="text-zinc-900">MVP ke skala Enterprise</strong>.',
        about_label: 'Tentang Saya',
        focus_label: 'Fokus Utama',
        download_cv: 'Unduh CV',
        contact_me: 'Hubungi Saya',
        focus_text: 'Arsitektur Database & Cloud Berkinerja Tinggi',
        active: 'Aktif',
        years: 'Tahun',
        experience_label: 'Pengalaman',
        education_label: 'Pendidikan',
        gpa_label: 'IPK',
        cum_laude: 'Cum Laude',
        awards_label: 'Penghargaan',
        research_label: 'Publikasi Riset',
        indexed: 'Indexed Sinta 2',
        org_label: 'Kepemimpinan & Organisasi',
        cert_label: 'Sertifikasi Profesional',
        career_sub: 'Jejak Rekam Karir',
        career_title: 'Pengalaman Profesional',
        career_badge: 'Karir',
        projects_title: 'Portofolio',
        projects_sub: 'Proyek Pilihan Resolusi Tinggi',
        contact_title: 'Mencari Engineer Tangguh?\nAyo Diskusi.',
        contact_name: 'Nama Lengkap',
        contact_email_label: 'Email Perusahaan',
        contact_msg: 'Bagaimana saya bisa membantu perusahaan Anda?',
        contact_name_ph: 'Budi Santoso',
        contact_msg_ph: 'Kami memiliki posisi terbuka untuk tim Anda...',
        contact_send: 'Kirim Pesan',
        footer: '© 2024 Ridha Fahmi Junaidi · Banjarmasin, ID',
        stable: 'STABIL',
        enterprise: 'Enterprise',
        experience_roles: ['Web Developer', 'Web Developer Intern', 'Coordinator of Teaching Assistants'],
        experience_descs: [
            '<ul class="list-disc pl-4 space-y-1 mt-1 text-sm text-stone-500"><li>Merancang arsitektur MVP 1 <em>hulutalent.id</em> dengan 5 fitur inti</li><li><strong class="text-zinc-900">Meningkatkan efisiensi sistem sebesar 30%</strong> melalui optimasi database relasional dan clean code</li><li><strong class="text-zinc-900">Memangkas waktu penyelesaian bug server-side di bawah 24 jam</strong></li></ul>',
            '<ul class="list-disc pl-4 space-y-1 mt-1 text-sm text-stone-500"><li><strong class="text-zinc-900">Memimpin pengembangan end-to-end</strong> sistem manajemen file edukatif (<em>FilesGI</em>)</li><li>Sukses <strong class="text-zinc-900">meningkatkan kecepatan query database hingga 20%</strong></li></ul>',
            '<ul class="list-disc pl-4 space-y-1 mt-1 text-sm text-stone-500"><li>Manajemen strategis atas 7 asisten laboratorium</li><li>Membimbing lebih dari 60 mahasiswa ilmu komputer</li><li>Berhasil mengamankan <strong class="text-zinc-900">tingkat keberhasilan pembelajaran di angka 95%</strong></li></ul>',
        ],
        project_descs: [
            'Membangun MVP 1 platform rekrutmen digital dengan 5 fitur krusial. Merancang ERD untuk mengakomodasi pertumbuhan jutaan baris data, memastikan <strong class="text-zinc-900">skalabilitas tinggi untuk perusahaan Enterprise</strong>.',
            'Merancang Learning Management System (LMS) khusus yang mengotomatisasi proses onboarding dan pelatihan lebih dari 500 karyawan di perusahaan Docking.',
            'Mengintegrasikan aplikasi Point of Sale (POS) cerdas dan E-Commerce untuk mengotomatisasi inventaris toko ritel dan meminimalisir kesalahan pelaporan keuangan.',
            'Sistem manajemen aset digital skalabel. Arsitektur database dirombak total untuk <strong class="text-zinc-900">optimasi read/write kecepatan tinggi</strong>, melayani ribuan file edukatif secara instan.',
        ],
        honors: ['Penerima Beasiswa PPA 2019', 'Penerima Beasiswa GenBI 2020', 'Pemenang Pendanaan Talenta Inovasi 2021'],
        orgs: ['Koordinator Kaderisasi', 'Anggota Divisi Kaderisasi', 'Ketua Pelaksana Program'],
    },
    en: {
        nav_home: 'Home',
        nav_career: 'Career',
        nav_projects: 'Projects',
        nav_contact: 'Contact',
        role: 'Software Engineer',
        degree: 'B.Sc. Computer Science',
        summary:
            'I build <strong class="text-zinc-900">fast, scalable, and resilient systems</strong>. Fullstack developer experienced in <strong class="text-zinc-900">leading teams</strong>, optimizing performance by <strong class="text-zinc-900">up to 30%</strong>, and shipping solutions from <strong class="text-zinc-900">MVP to Enterprise scale</strong>.',
        about_label: 'About Me',
        focus_label: 'Current Focus',
        download_cv: 'Download CV',
        contact_me: 'Contact Me',
        focus_text: 'Database Architecture & High-Performance Cloud',
        active: 'Active',
        years: 'Years',
        experience_label: 'Experience',
        education_label: 'Education',
        gpa_label: 'GPA',
        cum_laude: 'Cum Laude',
        awards_label: 'Awards & Honors',
        research_label: 'Published Research',
        indexed: 'Indexed Sinta 2',
        org_label: 'Leadership & Organizations',
        cert_label: 'Professional Certifications',
        career_sub: 'Professional Track Record',
        career_title: 'Work Experience',
        career_badge: 'Career',
        projects_title: 'Portfolio',
        projects_sub: 'High-Impact Selected Projects',
        contact_title: "Looking for a solid Engineer?\nLet's talk.",
        contact_name: 'Full Name',
        contact_email_label: 'Work Email',
        contact_msg: 'How can I add value to your company?',
        contact_name_ph: 'John Doe',
        contact_msg_ph: 'We have an open position on our tech team...',
        contact_send: 'Send Message',
        footer: '© 2024 Ridha Fahmi Junaidi · Banjarmasin, ID',
        stable: 'ONGOING',
        enterprise: 'Enterprise',
        experience_roles: ['Web Developer', 'Web Developer Intern', 'Coordinator of Teaching Assistants'],
        experience_descs: [
            '<ul class="list-disc pl-4 space-y-1 mt-1 text-sm text-stone-500"><li>Designed the MVP 1 architecture for <em>hulutalent.id</em> encompassing 5 core features</li><li><strong class="text-zinc-900">Improved system efficiency by 30%</strong> through relational database optimization and clean code</li><li><strong class="text-zinc-900">Slashed server-side bug resolution times to under 24 hours</strong></li></ul>',
            '<ul class="list-disc pl-4 space-y-1 mt-1 text-sm text-stone-500"><li><strong class="text-zinc-900">Led the end-to-end development</strong> of an educational file management system (<em>FilesGI</em>)</li><li>Successfully <strong class="text-zinc-900">increased database query speeds by 20%</strong></li></ul>',
            '<ul class="list-disc pl-4 space-y-1 mt-1 text-sm text-stone-500"><li>Provided strategic management for 7 laboratory assistants</li><li>Mentored over 60 computer science students</li><li>Secured an <strong class="text-zinc-900">outstanding 95% learning success rate</strong></li></ul>',
        ],
        project_descs: [
            'Built MVP 1 for a digital recruitment platform with 5 crucial features. Designed an ERD capable of accommodating millions of rows of data, ensuring <strong class="text-zinc-900">high scalability for Enterprise clients</strong>.',
            'Engineered a custom Learning Management System (LMS) that automates the onboarding and training process for over 500 employees at a Docking company.',
            'Integrated a smart Point of Sale (POS) application with an E-Commerce storefront to automate retail inventory and minimize financial reporting discrepancies.',
            'Scalable digital asset management system. Radically overhauled the database architecture for <strong class="text-zinc-900">high-speed read/write optimization</strong>, serving thousands of educational files instantly.',
        ],
        honors: ['PPA Scholarship Awardee 2019', 'Bank Indonesia GenBI Scholar 2020', 'Talenta Inovasi Indonesia Funding Winner 2021'],
        orgs: ['Recruitment Coordinator', 'Recruitment Division Member', 'Event Chairman'],
    },
};

const portfolioData = {
    profile: {
        name: 'Ridha Fahmi Junaidi',
        campus: 'Universitas Lambung Mangkurat',
        gpa: '3.74',
        journal: 'Baby Cry Sound Detection using CNN at jeeemi.org',
    },
    skills: ['PHP', 'JavaScript', 'Python', 'Laravel', 'React', 'HTML', 'CSS', 'AWS', 'IBM Cloud', 'SQL', 'Tableau', 'Git', 'Canva'],
    experience: [
        { company: 'Digitaliz by Yayasan Hasnur Centre', period: 'Jan 2023 - Present' },
        { company: 'Digitaliz by Yayasan Hasnur Centre', period: 'Aug - Dec 2022' },
        { company: 'Universitas Lambung Mangkurat', period: '2021' },
    ],
    projects: [
        {
            title: 'hulutalent.id',
            tag: 'Enterprise',
            tech: ['Laravel', 'AWS', 'SQL', 'Redis'],
            size: 'hero',
            images: ['https://picsum.photos/800/600?random=11', 'https://picsum.photos/800/600?random=12'],
        },
        {
            title: 'LMS Onboarding Docking',
            tag: 'E-Learning',
            tech: ['Laravel', 'MySQL', 'PHP'],
            size: 'second',
            images: ['https://picsum.photos/800/600?random=21', 'https://picsum.photos/800/600?random=22'],
        },
        {
            title: 'Online Shop + POS',
            tag: 'Retail',
            tech: ['PHP', 'SQL', 'Tailwind'],
            size: 'third',
            images: ['https://picsum.photos/800/600?random=31', 'https://picsum.photos/800/600?random=32'],
        },
        {
            title: 'FilesGI',
            tag: 'E-Learning',
            tech: ['PHP', 'Optimized SQL'],
            size: 'fourth',
            images: ['https://picsum.photos/800/600?random=41', 'https://picsum.photos/800/600?random=42'],
        },
    ],
    organizations: [
        { org: 'HIMAKOM ULM', period: '2021-2022' },
        { org: 'GenBI', period: '2020-2021' },
        { org: 'UPTKM FMIPA ULM', period: '2020' },
    ],
    certificates: [
        'IBM DevOps & Software Engineering (Coursera)',
        'Google IT Automation with Python (Coursera)',
        'Junior Web Developer (BNSP)',
        'Dicoding Developer Programs',
    ],
};

export function usePortfolioData() {
    function setLang(lang: Lang) {
        currentLang.value = lang;
        localStorage.setItem('portfolio_lang', lang);
        document.documentElement.lang = lang;
    }

    function toggleLang() {
        setLang(currentLang.value === 'id' ? 'en' : 'id');
    }

    function initLang(): boolean {
        const saved = localStorage.getItem('portfolio_lang') as Lang | null;
        if (saved) {
            setLang(saved);
            return true;
        }
        return false;
    }

    const L = computed(() => {
        return (i18n[currentLang.value ?? 'id'] ?? i18n.id) as Record<string, unknown>;
    });

    const t = (key: string): string => {
        return (L.value[key] as string) ?? key;
    };

    const tArray = (key: string): string[] => {
        return (L.value[key] as string[]) ?? [];
    };

    return {
        currentLang,
        portfolioData,
        L,
        t,
        tArray,
        setLang,
        toggleLang,
        initLang,
    };
}
