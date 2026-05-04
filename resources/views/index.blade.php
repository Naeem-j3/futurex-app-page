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
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Cairo', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            margin: 0;
        }

        /* ── Hero gradient uses primary color ── */
        .hero-bg {
            background: linear-gradient(135deg, var(--secondary) 0%, color-mix(in srgb, var(--secondary) 70%, var(--primary)) 100%);
        }

        /* ── Buttons ── */
        .btn-primary {
            background: var(--primary);
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: opacity .2s, transform .15s;
        }
        .btn-primary:hover { opacity: .88; transform: translateY(-1px); }

        .btn-dark {
            background: #0f172a;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: opacity .2s, transform .15s;
        }
        .btn-dark:hover { opacity: .85; transform: translateY(-1px); }

        .btn-outline {
            background: transparent;
            color: #fff;
            border: 1.5px solid rgba(255,255,255,.45);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 22px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: background .2s, transform .15s;
        }
        .btn-outline:hover { background: rgba(255,255,255,.12); transform: translateY(-1px); }

        /* ── Screenshot slider ── */
        .screenshots-track {
            display: flex;
            gap: 16px;
            overflow-x: auto;
            padding-bottom: 12px;
            scroll-snap-type: x mandatory;
            /*height: 200px;*/
            -webkit-overflow-scrolling: touch;

        }
        .screenshots-track::-webkit-scrollbar { height: 4px; }
        .screenshots-track::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9px; }

        .screenshot-item {
            scroll-snap-align: start;
            flex: 0 0 auto;
            width: 360px;
            height: 300px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,.10);
            transition: transform .2s;
        }
        .screenshot-item:hover { transform: scale(1.03); }
        .screenshot-item img { width: 100%; height: 100%; object-fit: cover; display: block; }

        /* ── Contact badge ── */
        .contact-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            padding: 8px 16px;
            font-size: 14px;
            color: #475569;
            text-decoration: none;
            transition: border-color .2s;
        }
        .contact-badge:hover { border-color: var(--primary); color: var(--primary); }

        /* ── Section heading accent ── */
        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title::after {
            content: '';
            display: block;
            width: 4px;
            height: 22px;
            border-radius: 4px;
            background: var(--primary);
            order: -1;
        }

        @media (max-width: 640px) {
            .screenshot-item { width: 290px; height: 240px;}
        }
        @media (max-width: 768px) {
            #footer-grid {
                grid-template-columns: 1fr !important;
                gap: 32px !important;
            }
        }
    </style>
</head>

<body>

{{-- ════════════════ HERO ════════════════ --}}
<section class="hero-bg">
    <div style="max-width:800px; margin:0 auto; padding:60px 24px 52px; text-align:center;">

        {{-- Logo (optional) --}}
        @if($app?->logo)
            <img src="{{ asset('storage/'.$app->logo) }}"
                 style="width:88px;height:88px;border-radius:20px;margin:0 auto 24px;display:block;
                        box-shadow:0 8px 32px rgba(0,0,0,.25);object-fit:cover;">
        @endif

        <h1 style="font-size:clamp(28px,5vw,42px);font-weight:700;color:#fff;margin:0 0 14px;line-height:1.2;">
            {{ $app->name ?? 'App Name' }}
        </h1>

{{--        @if($app?->description)--}}
{{--            <p style="font-size:17px;color:rgba(255,255,255,.72);max-width:560px;margin:0 auto 36px;line-height:1.7;">--}}
{{--                {{ $app->description }}--}}
{{--            </p>--}}
{{--        @endif--}}

        {{-- Download / Link Buttons --}}
        <div style="display:flex;flex-wrap:wrap;gap:12px;justify-content:center;">

            @if($app?->google_play_url)
                <a href="/app-page/click/google" class="btn-primary">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3.18 23.76c.37.2.8.2 1.17 0l11.5-6.64-2.58-2.58L3.18 23.76zm-1.05-1.36V1.6c0-.46.26-.87.65-1.08l11.1 11.1L2.78 22.72a1.17 1.17 0 0 1-.65-1.06v-.26zM20.82 10.5 17.5 8.6l-2.9 2.9 2.9 2.9 3.34-1.93a1.17 1.17 0 0 0 0-2.02zM4.35.24c-.37-.2-.8-.2-1.17 0L13.28 10.4 15.86 7.8 4.35.24z"/>
                    </svg>
                   Google play
                </a>
            @endif

            @if($app?->apple_store_url)
                <a href="/app-page/click/apple" class="btn-dark">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                    </svg>
                    App Store
                </a>
            @endif

            @if($app?->direct_download_url)
                <a href="/app-page/click/download" class="btn-outline">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    تحميل مباشر
                </a>
            @endif

            @if($app?->website_url)
                <a href="/app-page/click/website" class="btn-outline">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="2" y1="12" x2="22" y2="12"/>
                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                    الموقع الرسمي
                </a>
            @endif

        </div>
    </div>
</section>
{{-- ════════════════ ABOUT / DESCRIPTION ════════════════ --}}
@if($app?->description)
    <section style="max-width:1200px;margin:20px auto 52px;padding:0 24px;">
        <div style="background:#fff;border-radius:20px;border:1px solid #e2e8f0;padding:36px;">
            <h2 class="section-title" style="margin-bottom:16px;">عن التطبيق</h2>
            <p style="font-size:16px;color:#475569;line-height:1.8;margin:0;">{{ $app->description }}</p>
        </div>
    </section>
@endif
{{-- ════════════════ SCREENSHOTS ════════════════ --}}
@if($app->images->isNotEmpty())
    <section style="max-width:1200px;margin:52px auto;padding:0 24px;">

        <h2 class="section-title" style="margin-bottom:24px;">لقطات التطبيق</h2>

        <div class="screenshots-track">
            @foreach($app->images->sortBy('order') as $image)
                <div class="screenshot-item">
                    <img
                        src="{{ asset('storage/'.$image->image) }}"
                        alt="Screenshot"
                        onclick="openImage('{{ asset('storage/'.$image->image) }}')"
                        style="cursor:pointer"
                    >
                </div>
            @endforeach
        </div>

    </section>
@endif


{{-- ════════════════ FOOTER ════════════════ --}}
<footer style="background:var(--secondary);padding:56px 24px 0;">
    <div style="max-width:1200px;margin:0 auto;">

        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:48px;margin-bottom:70px;" id="footer-grid">

            {{-- Col 1: Brand + Description --}}
            @if($app?->email || $app?->phone || $app?->address)
                <div>
                    <h4 style="color:#fff;font-size:14px;font-weight:700;margin:0 0 20px;padding-bottom:10px;
                               border-bottom:1px solid rgba(255,255,255,.1);">تواصل معنا</h4>
                    <div style="display:flex;flex-direction:column;gap:14px;">

                        @if($app?->phone)
                            <a href="tel:{{ $app->phone }}"
                               style="color:rgba(255,255,255,.6);font-size:14px;text-decoration:none;
                                      display:flex;align-items:center;gap:10px;"
                               onmouseover="this.style.color='rgba(255,255,255,1)'"
                               onmouseout="this.style.color='rgba(255,255,255,.6)'">
                                <span style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,.08);
                                             display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.6 3.36 2 2 0 0 1 3.57 1h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </span>
                                {{ $app->phone }}
                            </a>
                        @endif

                        @if($app?->email)
                            <a href="mailto:{{ $app->email }}"
                               style="color:rgba(255,255,255,.6);font-size:14px;text-decoration:none;
                                      display:flex;align-items:center;gap:10px;"
                               onmouseover="this.style.color='rgba(255,255,255,1)'"
                               onmouseout="this.style.color='rgba(255,255,255,.6)'">
                                <span style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,.08);
                                             display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                </span>
                                {{ $app->email }}
                            </a>
                        @endif

                        @if($app?->address)
                            <span style="color:rgba(255,255,255,.6);font-size:14px;
                                         display:flex;align-items:center;gap:10px;">
                                <span style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,.08);
                                             display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                </span>
                                {{ $app->address }}
                            </span>
                        @endif

                    </div>
                </div>
            @endif


            {{-- Col 2: روابط سريعة --}}
            <div>
                <h4 style="color:#fff;font-size:14px;font-weight:700;margin:0 0 20px;padding-bottom:10px;
                           border-bottom:1px solid rgba(255,255,255,.1);">روابط سريعة</h4>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    @if($app?->website_url)
                        <a href="/app-page/click/website"
                           style="color:rgba(255,255,255,.6);font-size:14px;text-decoration:none;
                                  display:flex;align-items:center;gap:8px;transition:color .2s;"
                           onmouseover="this.style.color='rgba(255,255,255,1)'"
                           onmouseout="this.style.color='rgba(255,255,255,.6)'">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                            الموقع الرسمي
                        </a>
                    @endif
                    @if($app?->google_play_url)
                        <a href="/app-page/click/google"
                           style="color:rgba(255,255,255,.6);font-size:14px;text-decoration:none;
                                  display:flex;align-items:center;gap:8px;"
                           onmouseover="this.style.color='rgba(255,255,255,1)'"
                           onmouseout="this.style.color='rgba(255,255,255,.6)'">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M3.18 23.76c.37.2.8.2 1.17 0l11.5-6.64-2.58-2.58L3.18 23.76zm-1.05-1.36V1.6c0-.46.26-.87.65-1.08l11.1 11.1L2.78 22.72a1.17 1.17 0 0 1-.65-1.06v-.26zM20.82 10.5 17.5 8.6l-2.9 2.9 2.9 2.9 3.34-1.93a1.17 1.17 0 0 0 0-2.02zM4.35.24c-.37-.2-.8-.2-1.17 0L13.28 10.4 15.86 7.8 4.35.24z"/></svg>
                            تحميل من Google Play
                        </a>
                    @endif
                    @if($app?->apple_store_url)
                        <a href="/app-page/click/apple"
                           style="color:rgba(255,255,255,.6);font-size:14px;text-decoration:none;
                                  display:flex;align-items:center;gap:8px;"
                           onmouseover="this.style.color='rgba(255,255,255,1)'"
                           onmouseout="this.style.color='rgba(255,255,255,.6)'">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>
                            تحميل من App Store
                        </a>
                    @endif
                </div>
            </div>

            {{-- Col 3: تواصل معنا --}}
            <div>
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
                    @if($app?->logo)
                        <img src="{{ asset('storage/'.$app->logo) }}"
                             style="width:44px;height:44px;border-radius:10px;object-fit:cover;flex-shrink:0;">
                    @endif
                    <span style="color:#fff;font-weight:700;font-size:18px;">
                        {{ $app->name }}
                    </span>
                </div>

{{--                @if($app?->description)--}}
{{--                    <p style="color:rgba(255,255,255,.45);font-size:14px;line-height:1.9;margin:0 0 20px;max-width:340px;">--}}
{{--                        {{ Str::limit($app->description, 120) }}--}}
{{--                    </p>--}}
{{--                @endif--}}

{{--                --}}{{-- Download buttons mini --}}
{{--                <div style="display:flex;flex-wrap:wrap;gap:10px;">--}}
{{--                    @if($app?->google_play_url)--}}
{{--                        <a href="/app-page/click/google"--}}
{{--                           style="display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,.08);--}}
{{--                                  border:1px solid rgba(255,255,255,.15);color:rgba(255,255,255,.85);--}}
{{--                                  padding:8px 14px;border-radius:8px;font-size:13px;text-decoration:none;--}}
{{--                                  transition:background .2s;"--}}
{{--                           onmouseover="this.style.background='rgba(255,255,255,.14)'"--}}
{{--                           onmouseout="this.style.background='rgba(255,255,255,.08)'">--}}
{{--                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M3.18 23.76c.37.2.8.2 1.17 0l11.5-6.64-2.58-2.58L3.18 23.76zm-1.05-1.36V1.6c0-.46.26-.87.65-1.08l11.1 11.1L2.78 22.72a1.17 1.17 0 0 1-.65-1.06v-.26zM20.82 10.5 17.5 8.6l-2.9 2.9 2.9 2.9 3.34-1.93a1.17 1.17 0 0 0 0-2.02zM4.35.24c-.37-.2-.8-.2-1.17 0L13.28 10.4 15.86 7.8 4.35.24z"/></svg>--}}
{{--                            Google Play--}}
{{--                        </a>--}}
{{--                    @endif--}}
{{--                    @if($app?->apple_store_url)--}}
{{--                        <a href="/app-page/click/apple"--}}
{{--                           style="display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,.08);--}}
{{--                                  border:1px solid rgba(255,255,255,.15);color:rgba(255,255,255,.85);--}}
{{--                                  padding:8px 14px;border-radius:8px;font-size:13px;text-decoration:none;--}}
{{--                                  transition:background .2s;"--}}
{{--                           onmouseover="this.style.background='rgba(255,255,255,.14)'"--}}
{{--                           onmouseout="this.style.background='rgba(255,255,255,.08)'">--}}
{{--                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/></svg>--}}
{{--                            App Store--}}
{{--                        </a>--}}
{{--                    @endif--}}
{{--                    @if($app?->direct_download_url)--}}
{{--                        <a href="/app-page/click/download"--}}
{{--                           style="display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,.08);--}}
{{--                                  border:1px solid rgba(255,255,255,.15);color:rgba(255,255,255,.85);--}}
{{--                                  padding:8px 14px;border-radius:8px;font-size:13px;text-decoration:none;"--}}
{{--                           onmouseover="this.style.background='rgba(255,255,255,.14)'"--}}
{{--                           onmouseout="this.style.background='rgba(255,255,255,.08)'">--}}
{{--                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>--}}
{{--                            تحميل مباشر--}}
{{--                        </a>--}}
{{--                    @endif--}}
{{--                </div>--}}
            </div>

        </div>

        {{-- Bottom bar --}}
        <div style="border-top:1px solid rgba(255,255,255,.08);padding:20px 0;
                    display:flex;align-items:center;justify-content:center;">
            <p style="color:rgba(255,255,255,.25);font-size:13px;margin:0;">
                © {{ date('Y') }} {{ $app->name }} &mdash; مدعوم من FutureX
            </p>
        </div>

    </div>
</footer>
<div id="imageModal"
     style="position:fixed; inset:0; background:rgba(0,0,0,.8);
            display:none; align-items:center; justify-content:center;
            z-index:9999;">

    <img id="modalImage"
         style="max-width:90%; max-height:90%; border-radius:16px; box-shadow:0 10px 40px rgba(0,0,0,.5);">

</div>
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
</script>
</body>
</html>
