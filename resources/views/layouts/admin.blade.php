<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | Emmanuel Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-body antialiased min-h-screen">

    <div class="admin-shell">

        {{-- ── SIDEBAR ──────────────────────────────────────────── --}}
        <aside class="admin-sidebar hidden lg:flex flex-col w-64 flex-shrink-0">
            {{-- Logo --}}
            <div class="admin-brand h-16 flex items-center px-6 border-b border-white/5">
                <a href="{{ route('admin.dashboard') }}" class="font-display font-bold text-lg">
                    <span class="text-blue-400">&lt;</span><span>ET</span><span class="text-blue-400">/&gt;</span>
                    <span class="text-xs text-slate-400 font-normal ml-2">Admin</span>
                </a>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto scrollbar-none">
                @php
                $nav = [
                ['route'=>'admin.dashboard', 'label'=>'Dashboard', 'icon'=>'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z'],
                ['route'=>'admin.profile.edit', 'label'=>'Profile', 'icon'=>'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                ['route'=>'admin.skills.index', 'label'=>'Skills', 'icon'=>'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z'],
                ['route'=>'admin.projects.index', 'label'=>'Projects', 'icon'=>'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4'],
                ['route'=>'admin.experience.index', 'label'=>'Experience', 'icon'=>'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                ['route'=>'admin.education.index', 'label'=>'Education', 'icon'=>'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'],
                ['route'=>'admin.certificates.index', 'label'=>'Certificates', 'icon'=>'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'],
                ['route'=>'admin.social.index', 'label'=>'Social Links', 'icon'=>'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'],
                ['route'=>'admin.seo.edit', 'label'=>'SEO', 'icon'=>'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'],
                ['route'=>'admin.theme.edit', 'label'=>'Theme', 'icon'=>'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01'],
                ];
                @endphp

                @foreach($nav as $item)
                <a href="{{ route($item['route']) }}"
                    class="sidebar-link {{ request()->routeIs($item['route'].'*') ? 'active' : '' }}">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                    </svg>
                    {{ $item['label'] }}
                </a>
                @endforeach
            </nav>

            {{-- Bottom --}}
            <div class="px-3 py-4 border-t border-white/5 space-y-1">
                <a href="{{ route('home') }}" target="_blank" class="sidebar-link text-xs">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    View Site
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-left text-red-400 hover:text-red-300 hover:bg-red-400/10">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- ── MAIN ─────────────────────────────────────────────── --}}
        <div class="flex-1 flex flex-col min-w-0">

            {{-- Top bar --}}
            <header class="admin-topbar h-16 flex items-center px-6 gap-4 sticky top-0 z-40">
                <h1 class="font-display font-bold text-base text-slate-50 flex-1">@yield('page-title', 'Dashboard')</h1>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-slate-400">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center text-xs font-bold text-white">ET</div>
                </div>
            </header>

            {{-- Flash messages --}}
            @if(session('success'))
            <div class="admin-flash admin-flash-success mx-6 mt-4 flex items-center gap-3 px-4 py-3 rounded-xl text-sm">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div class="admin-flash admin-flash-error mx-6 mt-4 px-4 py-3 rounded-xl text-sm">
                <ul class="space-y-1">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            {{-- Content --}}
            <main class="admin-main flex-1 p-6 overflow-auto">
                @yield('admin-content')
            </main>
        </div>

    </div>
</body>

</html>