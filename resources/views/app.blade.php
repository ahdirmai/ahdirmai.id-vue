<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Inline script to detect system dark mode preference and apply it immediately --}}
    <script>
        (function() {
            const appearance = '{{ $appearance ?? 'system' }}';

            if (appearance === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                if (prefersDark) {
                    document.documentElement.classList.add('dark');
                }
            }
        })();
    </script>

    {{-- Inline style to set the HTML background color based on our theme in app.css --}}
    <style>
        html {
            background-color: oklch(1 0 0);
        }

        html.dark {
            background-color: oklch(0.145 0 0);
        }
    </style>

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    @php
        $seo = \App\Models\SeoSetting::current();
        $ogImageUrl = $seo->og_image_path ? Storage::disk('public')->url($seo->og_image_path) : null;
    @endphp

    {{-- Standard Meta Tags --}}
    @if ($seo->meta_description)
        <meta name="description" content="{{ $seo->meta_description }}">
    @endif
    @if ($seo->meta_keywords)
        <meta name="keywords" content="{{ $seo->meta_keywords }}">
    @endif

    {{-- Open Graph / Facebook / LinkedIn / Discord --}}
    <meta property="og:type" content="website">
    @if ($seo->site_title)
        <meta property="og:title" content="{{ $seo->site_title }}">
    @endif
    @if ($seo->meta_description)
        <meta property="og:description" content="{{ $seo->meta_description }}">
    @endif
    @if ($ogImageUrl)
        <meta property="og:image" content="{{ $ogImageUrl }}">
    @endif

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    @if ($seo->site_title)
        <meta name="twitter:title" content="{{ $seo->site_title }}">
    @endif
    @if ($seo->meta_description)
        <meta name="twitter:description" content="{{ $seo->meta_description }}">
    @endif
    @if ($ogImageUrl)
        <meta name="twitter:image" content="{{ $ogImageUrl }}">
    @endif

    @if ($seo->favicon_path)
        <link rel="icon"
            href="{{ Storage::disk('public')->url($seo->favicon_path) }}?v={{ $seo->updated_at ? $seo->updated_at->timestamp : time() }}"
            sizes="any">
    @else
        <link rel="icon" href="/favicon.ico?v=1" sizes="any">
        <link rel="icon" href="/favicon.svg?v=1" type="image/svg+xml">
    @endif

    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
