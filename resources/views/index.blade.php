<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $app->name ?? 'تطبيق' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        const startTime = Date.now();
        const visitId = {{ $visitId ?? 'null' }};
        window.addEventListener("beforeunload", function () {
            if (!visitId) return;
            const duration = Math.floor((Date.now() - startTime) / 1000);
            navigator.sendBeacon('/app-page/track-duration',
                new Blob([JSON.stringify({ visit_id: visitId, duration })], { type: 'application/json' })
            );
        });
    </script>

    <style>
        :root {
            --primary:   {{ $app->theme_color     ?? '#2563eb' }};
            --secondary: {{ $app->secondary_color ?? '#111827' }};
            --primary-light: color-mix(in srgb, var(--primary) 85%, white);
            --primary-dark: color-mix(in srgb, var(--primary) 85%, black);
            --secondary-light: color-mix(in srgb, var(--secondary) 70%, white);
            --shadow-sm: 0 4px 12px rgba(0,0,0,0.05);
            --shadow-md: 0 8px 24px rgba(0,0,0,0.08);
            --shadow-lg: 0 12px 32px rgba(0,0,0,0.12);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Cairo', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            margin: 0;
            scroll-behavior: smooth;
        }

        /* Hero gradient – richer blend */
        .hero-bg {
            background: linear-gradient(135deg, var(--secondary) 0%, color-mix(in srgb, var(--secondary) 60%, var(--primary)) 100%);
            position: relative;
            overflow: hidden;
        }
        .hero-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 40%, rgba(255,255,255,0.08) 0%, transparent 60%);
            pointer-events: none;
        }

        /* Buttons – primary & secondary variants */
        .btn-primary {
            background: var(--primary);
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: var(--shadow-sm);
            border: none;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        .btn-dark {
            background: #0f172a;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: var(--shadow-sm);
            border: none;
        }
        .btn-dark:hover { opacity: .85; transform: translateY(-1px); }
        .btn-secondary {
            background: var(--secondary);
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: var(--shadow-sm);
        }
        .btn-secondary:hover {
            background: color-mix(in srgb, var(--secondary) 85%, white);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-outline {
            background: transparent;
            color: #fff;
            border: 1.5px solid rgba(255,255,255,0.5);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 24px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .btn-outline:hover {
            background: rgba(255,255,255,0.12);
            border-color: #fff;
            transform: translateY(-2px);
        }

        /* Screenshot slider */
        .screenshots-track {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding-bottom: 16px;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }
        .screenshots-track::-webkit-scrollbar { height: 6px; }
        .screenshots-track::-webkit-scrollbar-thumb { background: var(--primary); border-radius: 10px; }

        .screenshot-item {
            scroll-snap-align: start;
            flex: 0 0 auto;
            width: 360px;
            height: 300px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .screenshot-item:hover {
            transform: scale(1.02);
            border-color: var(--primary);
            box-shadow: var(--shadow-lg);
        }
        .screenshot-item img { width: 100%; height: 100%; object-fit: cover; display: block; }

        /* Section title with primary accent */
        .section-title {
            font-size: 26px;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
            position: relative;
        }
        .section-title::after {
            content: '';
            display: block;
            width: 5px;
            height: 28px;
            border-radius: 6px;
            background: var(--primary);
            order: -1;
        }

        /* Feature card – more color */
        .feature-card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            display: flex;
            align-items: flex-start;
            gap: 18px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }
        .feature-card:hover {
            transform: translateY(-4px);
            border-color: var(--primary);
            box-shadow: var(--shadow-lg);
        }
        .feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: color-mix(in srgb, var(--primary) 12%, white);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s;
        }
        .feature-card:hover .feature-icon {
            background: var(--primary);
        }
        .feature-card:hover .feature-icon svg {
            color: white !important;
            stroke: white !important;
        }

        /* Contact badges with primary hover */
        .contact-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 60px;
            padding: 10px 20px;
            font-size: 14px;
            color: #475569;
            text-decoration: none;
            transition: all 0.2s;
        }
        .contact-badge:hover {
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        /* Footer enhancements */
        .footer-gradient {
            position: relative;
            background: var(--secondary);
            padding: 60px 24px 0;
        }
        .footer-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary-light), var(--primary));
        }
        .footer-link {
            color: rgba(255,255,255,0.7);
            font-size: 14px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }
        .footer-link:hover {
            color: var(--primary);
            transform: translateX(-4px) translateY(-1px);
        }
        .footer-heading {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(255,255,255,0.15);
            display: inline-block;
        }
        .social-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: rgba(255,255,255,0.08);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .social-icon:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        /* Back to top button */
        .back-to-top {
            position: fixed;
            bottom: 24px;
            left: 24px;
            background: var(--primary);
            color: white;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-md);
            transition: all 0.2s;
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            border: none;
        }
        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }
        .back-to-top:hover {
            transform: scale(1.08);
            background: var(--primary-dark);
        }


        @media (max-width: 640px) {
            .screenshot-item { width: 280px; height: 240px; }
            .section-title { font-size: 22px; }
        }
    </style>
</head>

<body>

{{-- HERO SECTION --}}
<section class="hero-bg">
    <div style="max-width:800px; margin:0 auto; padding:70px 24px 60px; text-align:center;">
        @if($app?->logo)
            <img src="{{ asset('storage/'.$app->logo) }}"
                 style="width:96px;height:96px;border-radius:24px;margin:0 auto 28px;display:block;
                        box-shadow:0 12px 32px rgba(0,0,0,.3);object-fit:cover;border:2px solid rgba(255,255,255,0.2);">
        @endif
        <h1 style="font-size:clamp(32px,6vw,48px);font-weight:800;color:#fff;margin:0 0 16px;line-height:1.2;text-shadow:0 2px 10px rgba(0,0,0,0.2);">
            {{ $app->name ?? 'App Name' }}
        </h1>
        @if($app?->description)
            <p style="font-size:18px;color:rgba(255,255,255,.85);max-width:560px;margin:0 auto 36px;line-height:1.8;">
                {{ $app->description }}
            </p>
        @endif
        <div style="display:flex;flex-wrap:wrap;gap:14px;justify-content:center;">
            @if($app?->google_play_url)
                <a href="/app-page/click/google" class="btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M3.18 23.76c.37.2.8.2 1.17 0l11.5-6.64-2.58-2.58L3.18 23.76zm-1.05-1.36V1.6c0-.46.26-.87.65-1.08l11.1 11.1L2.78 22.72a1.17 1.17 0 0 1-.65-1.06v-.26zM20.82 10.5 17.5 8.6l-2.9 2.9 2.9 2.9 3.34-1.93a1.17 1.17 0 0 0 0-2.02zM4.35.24c-.37-.2-.8-.2-1.17 0L13.28 10.4 15.86 7.8 4.35.24z"/></svg>
                    Google Play
                </a>
            @endif
            @if($app?->apple_store_url)
                <a href="/app-page/click/apple"  class="btn-dark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                    App Store
                </a>
            @endif
            @if($app?->direct_download_url)
                <a href="/app-page/click/download" class="btn-outline">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    تحميل مباشر
                </a>
            @endif
            @if($app?->website_url)
                <a href="/app-page/click/website" class="btn-outline">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    الموقع الرسمي
                </a>
            @endif
        </div>
    </div>
</section>

{{-- DESCRIPTION SECTION --}}
@if($app?->description)
    <section style="max-width:1200px;margin:48px auto 40px;padding:0 24px;">
        <div style="background:#fff;border-radius:24px;border:1px solid #e2e8f0;padding:40px;box-shadow:var(--shadow-sm);">
            <h2 class="section-title" style="margin-bottom:20px;">عن التطبيق</h2>
            <p style="font-size:16px;color:#334155;line-height:1.9;margin:0;">{{ $app->description }}</p>
        </div>
    </section>
@endif

{{-- SCREENSHOTS --}}
@if($app->images->isNotEmpty())
    <section style="max-width:1200px;margin:60px auto;padding:0 24px;">
        <h2 class="section-title">لقطات التطبيق</h2>
        <div class="screenshots-track">
            @foreach($app->images->sortBy('order') as $image)
                <div class="screenshot-item">
                    <img src="{{ asset('storage/'.$image->image) }}" alt="Screenshot" onclick="openImage('{{ asset('storage/'.$image->image) }}')" style="cursor:pointer">
                </div>
            @endforeach
        </div>
    </section>
@endif

{{-- FEATURES --}}
@if($app->features->isNotEmpty())
    <section style="max-width:1200px;margin:60px auto;padding:0 24px;">
        <h2 class="section-title">مزايا التطبيق</h2>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:24px;">
            @foreach($app->features as $feature)
                <div class="feature-card">
                    <div class="feature-icon">
                        @if($feature->icon)
                            <x-dynamic-component :component="'heroicon-o-'.$feature->icon" style="width:24px;height:24px;color:var(--primary);transition:color 0.2s;" />
                        @else
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        @endif
                    </div>
                    <div>
                        <h3 style="font-size:18px;font-weight:700;color:#0f172a;margin:0 0 8px;">{{ $feature->title }}</h3>
                        @if($feature->description)
                            <p style="font-size:14px;color:#475569;line-height:1.7;margin:0;">{{ $feature->description }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif

{{-- ENHANCED FOOTER --}}
<footer class="footer-gradient">
    <div style="max-width:1200px;margin:0 auto;">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:48px;margin-bottom:60px;">
            {{-- Brand column --}}
            <div>
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:20px;">
                    @if($app?->logo)
                        <img src="{{ asset('storage/'.$app->logo) }}" style="width:48px;height:48px;border-radius:16px;object-fit:cover;">
                    @endif
                    <span style="color:#fff;font-weight:800;font-size:20px;">{{ $app->name }}</span>
                </div>
                <p style="color:rgba(255,255,255,0.6);font-size:14px;line-height:1.8;margin:0 0 20px;">تطبيق مبتكر يقدم لك تجربة فريدة وميزات متطورة.</p>
{{--                <div style="display:flex;gap:12px;">--}}
{{--                    <a href="#" class="social-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="white"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95z"/></svg></a>--}}
{{--                    <a href="#" class="social-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="white"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.937 4.937 0 004.604 3.417 9.868 9.868 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 0021.386-6.643 9.877 9.877 0 002.104-4.565z"/></svg></a>--}}
{{--                    <a href="#" class="social-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="white"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>--}}
{{--                </div>--}}
            </div>

            {{-- Quick links --}}
            <div>
                <h4 class="footer-heading">روابط سريعة</h4>
                <div style="display:flex;flex-direction:column;gap:14px;">
                    @if($app?->website_url)
                        <a href="/app-page/click/website" class="footer-link"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>الموقع الرسمي</a>
                    @endif
                    @if($app?->google_play_url)
                        <a href="/app-page/click/google" class="footer-link"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M3.18 23.76c.37.2.8.2 1.17 0l11.5-6.64-2.58-2.58L3.18 23.76zm-1.05-1.36V1.6c0-.46.26-.87.65-1.08l11.1 11.1L2.78 22.72a1.17 1.17 0 0 1-.65-1.06v-.26zM20.82 10.5 17.5 8.6l-2.9 2.9 2.9 2.9 3.34-1.93a1.17 1.17 0 0 0 0-2.02zM4.35.24c-.37-.2-.8-.2-1.17 0L13.28 10.4 15.86 7.8 4.35.24z"/></svg>Google Play</a>
                    @endif
                    @if($app?->apple_store_url)
                        <a href="/app-page/click/apple" class="footer-link"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>App Store</a>
                    @endif
                    @if($app?->direct_download_url)
                        <a href="/app-page/click/download" class="footer-link"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>تحميل مباشر</a>
                    @endif
                </div>
            </div>

            {{-- Contact info --}}
            @if($app?->email || $app?->phone || $app?->address)
                <div>
                    <h4 class="footer-heading">تواصل معنا</h4>
                    <div style="display:flex;flex-direction:column;gap:16px;">
                        @if($app?->phone)
                            <a href="tel:{{ $app->phone }}" class="footer-link">
                                <span style="width:32px;height:32px;border-radius:10px;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.6 3.36 2 2 0 0 1 3.57 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></span>
                                {{ $app->phone }}
                            </a>
                        @endif
                        @if($app?->email)
                            <a href="mailto:{{ $app->email }}" class="footer-link">
                                <span style="width:32px;height:32px;border-radius:10px;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></span>
                                {{ $app->email }}
                            </a>
                        @endif
                        @if($app?->address)
                            <span class="footer-link" style="cursor:default;">
                                <span style="width:32px;height:32px;border-radius:10px;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></span>
                                {{ $app->address }}
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div style="border-top:1px solid rgba(255,255,255,0.12);padding:24px 0;text-align:center;">
            <p style="color:rgba(255,255,255,0.4);font-size:13px;margin:0;">© {{ date('Y') }} {{ $app->name }} &mdash; مدعوم من FutureX</p>
        </div>
    </div>
</footer>

{{-- Image Modal --}}
<div id="imageModal" style="position:fixed; inset:0; background:rgba(0,0,0,0.85); display:none; align-items:center; justify-content:center; z-index:9999; backdrop-filter:blur(8px);">
    <img id="modalImage" style="max-width:90%; max-height:90%; border-radius:20px; box-shadow:0 20px 40px rgba(0,0,0,0.4);">
</div>

{{-- Back to Top Button --}}
<button id="backToTop" class="back-to-top" aria-label="العودة للأعلى">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="18 15 12 9 6 15"/></svg>
</button>

<script>
    function openImage(src) {
        const modal = document.getElementById('imageModal');
        const img = document.getElementById('modalImage');
        img.src = src;
        modal.style.display = 'flex';
    }
    document.getElementById('imageModal').addEventListener('click', function () {
        this.style.display = 'none';
    });

    // Back to top button logic
    const backBtn = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) {
            backBtn.classList.add('visible');
        } else {
            backBtn.classList.remove('visible');
        }
    });
    backBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>
</body>
</html>
