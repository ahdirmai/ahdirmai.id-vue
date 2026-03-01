<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\ContactSetting;
use App\Models\Education;
use App\Models\HeroSetting;
use App\Models\Organization;
use App\Models\Portfolio;
use App\Models\SeoSetting;
use App\Models\TechStack;
use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::factory()->create([
            'name' => 'Ridha Fahmi Junaidi',
            'email' => 'ridhofahmij225@gmail.com',
            'password' => bcrypt('Eigels21'),
        ]);

        // Hero Setting
        HeroSetting::create([
            'role' => 'Software Engineer',
            'summary_id' => 'Saya membangun <strong class="text-zinc-900">sistem yang cepat, skalabel, dan tahan banting</strong>. Fullstack developer berpengalaman <strong class="text-zinc-900">memimpin tim</strong>, mengoptimasi performa hingga <strong class="text-zinc-900">30% lebih efisien</strong>, dan mendeliver solusi dari <strong class="text-zinc-900">MVP ke skala Enterprise</strong>.',
            'summary_en' => 'I build <strong class="text-zinc-900">fast, scalable, and resilient systems</strong>. Fullstack developer experienced in <strong class="text-zinc-900">leading teams</strong>, optimizing performance by <strong class="text-zinc-900">up to 30%</strong>, and shipping solutions from <strong class="text-zinc-900">MVP to Enterprise scale</strong>.',
            'focus_text_id' => 'Arsitektur Database & Cloud Berkinerja Tinggi',
            'focus_text_en' => 'Database Architecture & High-Performance Cloud',
            'years_of_experience' => 2,
            'position_tags' => ['Fullstack', 'Backend', 'DevOps'],
        ]);

        // Work Experiences
        WorkExperience::create([
            'company' => 'Digitaliz by Yayasan Hasnur Centre',
            'position' => 'Web Developer',
            'start_date' => '2023-01-01',
            'end_date' => null,
            'description_id' => '<ul class="list-disc pl-4 space-y-1 mt-1 text-sm text-stone-500"><li>Merancang arsitektur MVP 1 <em>hulutalent.id</em> dengan 5 fitur inti</li><li><strong class="text-zinc-900">Meningkatkan efisiensi sistem sebesar 30%</strong> melalui optimasi database relasional dan clean code</li><li><strong class="text-zinc-900">Memangkas waktu penyelesaian bug server-side di bawah 24 jam</strong></li></ul>',
            'description_en' => '<ul class="list-disc pl-4 space-y-1 mt-1 text-sm text-stone-500"><li>Designed the MVP 1 architecture for <em>hulutalent.id</em> encompassing 5 core features</li><li><strong class="text-zinc-900">Improved system efficiency by 30%</strong> through relational database optimization and clean code</li><li><strong class="text-zinc-900">Slashed server-side bug resolution times to under 24 hours</strong></li></ul>',
            'sort_order' => 0,
        ]);

        WorkExperience::create([
            'company' => 'Digitaliz by Yayasan Hasnur Centre',
            'position' => 'Web Developer Intern',
            'start_date' => '2022-08-01',
            'end_date' => '2022-12-31',
            'description_id' => '<ul class="list-disc pl-4 space-y-1 mt-1 text-sm text-stone-500"><li><strong class="text-zinc-900">Memimpin pengembangan end-to-end</strong> sistem manajemen file edukatif (<em>FilesGI</em>)</li><li>Sukses <strong class="text-zinc-900">meningkatkan kecepatan query database hingga 20%</strong></li></ul>',
            'description_en' => '<ul class="list-disc pl-4 space-y-1 mt-1 text-sm text-stone-500"><li><strong class="text-zinc-900">Led the end-to-end development</strong> of an educational file management system (<em>FilesGI</em>)</li><li>Successfully <strong class="text-zinc-900">increased database query speeds by 20%</strong></li></ul>',
            'sort_order' => 1,
        ]);

        WorkExperience::create([
            'company' => 'Universitas Lambung Mangkurat',
            'position' => 'Coordinator of Teaching Assistants',
            'start_date' => '2021-01-01',
            'end_date' => '2021-12-31',
            'description_id' => '<ul class="list-disc pl-4 space-y-1 mt-1 text-sm text-stone-500"><li>Manajemen strategis atas 7 asisten laboratorium</li><li>Membimbing lebih dari 60 mahasiswa ilmu komputer</li><li>Berhasil mengamankan <strong class="text-zinc-900">tingkat keberhasilan pembelajaran di angka 95%</strong></li></ul>',
            'description_en' => '<ul class="list-disc pl-4 space-y-1 mt-1 text-sm text-stone-500"><li>Provided strategic management for 7 laboratory assistants</li><li>Mentored over 60 computer science students</li><li>Secured an <strong class="text-zinc-900">outstanding 95% learning success rate</strong></li></ul>',
            'sort_order' => 2,
        ]);

        // Education
        Education::create([
            'university' => 'Universitas Lambung Mangkurat',
            'degree_id' => 'S1 Ilmu Komputer',
            'degree_en' => 'B.Sc. Computer Science',
            'gpa' => 3.74,
            'awards' => [
                'Penerima Beasiswa PPA 2019',
                'Penerima Beasiswa GenBI 2020',
                'Pemenang Pendanaan Talenta Inovasi 2021',
            ],
            'research_title' => 'Baby Cry Sound Detection using CNN at jeeemi.org',
            'research_link' => 'https://jeeemi.org',
            'sort_order' => 0,
        ]);

        // Organizations
        Organization::create(['organization_name' => 'HIMAKOM ULM', 'position' => 'Koordinator Kaderisasi', 'year' => '2021-2022', 'sort_order' => 0]);
        Organization::create(['organization_name' => 'GenBI', 'position' => 'Anggota Divisi Kaderisasi', 'year' => '2020-2021', 'sort_order' => 1]);
        Organization::create(['organization_name' => 'UPTKM FMIPA ULM', 'position' => 'Ketua Pelaksana Program', 'year' => '2020', 'sort_order' => 2]);

        // Certifications
        Certification::create(['name' => 'IBM DevOps & Software Engineering', 'issued_by' => 'Coursera', 'link' => null, 'sort_order' => 0]);
        Certification::create(['name' => 'Google IT Automation with Python', 'issued_by' => 'Coursera', 'link' => null, 'sort_order' => 1]);
        Certification::create(['name' => 'Junior Web Developer', 'issued_by' => 'BNSP', 'link' => null, 'sort_order' => 2]);
        Certification::create(['name' => 'Dicoding Developer Programs', 'issued_by' => 'Dicoding', 'link' => null, 'sort_order' => 3]);

        // Tech Stacks
        $stacks = ['PHP', 'JavaScript', 'Python', 'Laravel', 'React', 'HTML', 'CSS', 'AWS', 'IBM Cloud', 'SQL', 'Tableau', 'Git', 'Canva'];
        foreach ($stacks as $i => $name) {
            TechStack::create(['name' => $name, 'sort_order' => $i]);
        }

        // Portfolios
        Portfolio::create([
            'title' => 'hulutalent.id',
            'short_description' => 'Digital recruitment platform',
            'long_description' => 'Membangun MVP 1 platform rekrutmen digital dengan 5 fitur krusial. Merancang ERD untuk mengakomodasi pertumbuhan jutaan baris data, memastikan skalabilitas tinggi untuk perusahaan Enterprise.',
            'category' => 'public',
            'stacks' => ['Laravel', 'AWS', 'SQL', 'Redis'],
            'key_features' => ['MVP Architecture', 'High Scalability ERD', 'Enterprise-grade'],
            'sort_order' => 0,
        ]);

        Portfolio::create([
            'title' => 'LMS Onboarding Docking',
            'short_description' => 'Learning Management System',
            'long_description' => 'Merancang Learning Management System (LMS) khusus yang mengotomatisasi proses onboarding dan pelatihan lebih dari 500 karyawan di perusahaan Docking.',
            'category' => 'public',
            'stacks' => ['Laravel', 'MySQL', 'PHP'],
            'key_features' => ['Automated Onboarding', '500+ Employees', 'Custom LMS'],
            'sort_order' => 1,
        ]);

        Portfolio::create([
            'title' => 'Online Shop + POS',
            'short_description' => 'Retail POS & E-Commerce',
            'long_description' => 'Mengintegrasikan aplikasi Point of Sale (POS) cerdas dan E-Commerce untuk mengotomatisasi inventaris toko ritel dan meminimalisir kesalahan pelaporan keuangan.',
            'category' => 'public',
            'stacks' => ['PHP', 'SQL', 'Tailwind'],
            'key_features' => ['Smart POS', 'Inventory Automation', 'Financial Reporting'],
            'sort_order' => 2,
        ]);

        Portfolio::create([
            'title' => 'FilesGI',
            'short_description' => 'Digital asset management',
            'long_description' => 'Sistem manajemen aset digital skalabel. Arsitektur database dirombak total untuk optimasi read/write kecepatan tinggi, melayani ribuan file edukatif secara instan.',
            'category' => 'public',
            'stacks' => ['PHP', 'Optimized SQL'],
            'key_features' => ['High-speed R/W', 'Scalable Architecture', 'Educational Files'],
            'sort_order' => 3,
        ]);

        // Contact Setting
        ContactSetting::create([
            'email' => 'ridhofahmij225@gmail.com',
            'github_url' => 'https://github.com/ridhofahmi',
            'linkedin_url' => 'https://linkedin.com/in/ridhofahmi',
            'instagram_url' => 'https://instagram.com/ridhofahmi',
            'recaptcha_site_key' => null,
            'recaptcha_secret_key' => null,
        ]);

        // SEO Setting
        SeoSetting::create([
            'site_title' => 'Ridha Fahmi Junaidi | Software Engineer',
            'meta_description' => 'Portfolio of Ridha Fahmi Junaidi — Fullstack Software Engineer specializing in Laravel, database architecture, and scalable cloud solutions.',
            'meta_keywords' => 'software engineer, fullstack, laravel, php, web developer',
        ]);
    }
}
