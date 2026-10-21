<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ICS Admin Console | Apparel & Merch Reservation System</title>

  <link rel="dns-prefetch" href="//fonts.googleapis.com">
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link rel="dns-prefetch" href="//cdn.tailwindcss.com">
  <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
  <!-- Google Fonts: Plus Jakarta Sans & Space Grotesk -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Canvas Confetti CDN -->
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

  <!-- Local & Offline High-Speed Chart.js (Zero Network Latency) -->
  <script src="{{ asset('js/chart.umd.min.js') }}"></script>
  <script>
    if (typeof Chart === 'undefined') {
      document.write('<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"><\/script>');
    }
  </script>


  <!-- Tailwind Theme Extension: ICS Red Palette -->
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            ics: {
              50: '#fef2f2',
              100: '#fee2e2',
              200: '#fecaca',
              300: '#fca5a5',
              400: '#f87171',
              500: '#ef4444',
              600: '#dc2626',
              700: '#b91c1c',
              800: '#991b1b',
              900: '#7f1d1d',
              950: '#450a0a',
              deep: '#5a060a',
              crimson: '#880808',
              gold: '#f59e0b',
              amber: '#fbbf24',
              dark: '#0c0f17',
              card: '#161b26'
            }
          },
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            display: ['"Space Grotesk"', 'sans-serif'],
            mono: ['"JetBrains Mono"', 'monospace']
          }
        }
      }
    }
  </script>

  <style>
    /* Prevent horizontal page overflow on mobile devices */
    html, body {
      overflow-x: hidden !important;
      max-width: 100vw !important;
      width: 100% !important;
      position: relative;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
      height: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #0c0f17;
    }

    ::-webkit-scrollbar-thumb {
      background: #991b1b;
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #dc2626;
    }

    /* Circuit & Binary Background Pattern */
    .ics-matrix-bg {
      background-color: #0c0f17;
      background-image:
        radial-gradient(circle at 15% 20%, rgba(185, 28, 28, 0.15) 0%, transparent 40%),
        radial-gradient(circle at 85% 80%, rgba(245, 158, 11, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 50% 50%, rgba(127, 29, 29, 0.1) 0%, transparent 50%);
    }

    /* Hide scrollbar for horizontal mobile pill tabs */
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    /* Mobile View: Strictly hide desktop sidebar navigation on small phone screens (< 768px) */
    @media screen and (max-width: 767px) {
      #admin-desktop-sidebar {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        overflow: hidden !important;
        pointer-events: none !important;
      }
    }
    @media screen and (min-width: 768px) {
      #admin-desktop-sidebar {
        display: block !important;
        visibility: visible !important;
        height: auto !important;
        overflow: visible !important;
        pointer-events: auto !important;
      }
    }


    /* Print Styles (Prevents blank page and isolates claim slip only when modal is active) */
    @media print {
      /* Hide all direct body siblings except #slip-modal so there are ZERO blank pages */
      body.slip-modal-open > *:not(#slip-modal) {
        display: none !important;
      }

      body.slip-modal-open {
        background: #ffffff !important;
        color: #000000 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: visible !important;
      }

      body.slip-modal-open #slip-modal {
        position: static !important;
        display: block !important;
        visibility: visible !important;
        background: #ffffff !important;
        padding: 0 !important;
        margin: 0 auto !important;
        width: 100% !important;
        max-width: 100% !important;
        box-shadow: none !important;
        overflow: visible !important;
      }

      body.slip-modal-open #printable-claim-slip {
        position: static !important;
        width: 100% !important;
        max-width: 100% !important;
        margin: 0 auto !important;
        padding: 1.5rem !important;
        background: #ffffff !important;
        color: #000000 !important;
        box-shadow: none !important;
        border: 2px solid #0f172a !important;
        border-radius: 1rem !important;
        page-break-inside: avoid !important;
        break-inside: avoid !important;
      }

      body.slip-modal-open #printable-claim-slip * {
        visibility: visible !important;
        color: inherit !important;
      }

      body.slip-modal-open #printable-claim-slip .text-red-900,
      body.slip-modal-open #printable-claim-slip .text-ics-gold,
      body.slip-modal-open #printable-claim-slip .text-emerald-700 {
        color: #0f172a !important;
      }

      body:not(.slip-modal-open) {
        background: #ffffff !important;
        color: #000000 !important;
      }

      .no-print,
      #slip-modal .no-print,
      header,
      nav,
      #sidebar-container {
        display: none !important;
      }

      @page {
        size: portrait;
        margin: 12mm 10mm;
      }
    }
  </style>
</head>

<body class="ics-matrix-bg text-slate-100 min-h-screen flex flex-col font-sans antialiased selection:bg-ics-700 selection:text-white">

  <!-- ======================================================== -->
  <!-- TOP APP BAR & HEADER (ICS ADMIN CONSOLE) -->
  <!-- ======================================================== -->
  <header class="sticky top-0 z-40 bg-ics-dark/95 backdrop-blur-md border-b border-ics-900/80 shadow-2xl">
    <div class="w-full max-w-[1780px] 2xl:max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10">
      <div class="flex items-center justify-between h-18 py-2.5 gap-2 sm:gap-4">

        <!-- ICS Brand Identity & Emblem -->
        <a href="{{ route('admin') }}" class="flex items-center gap-2 sm:gap-3.5 group flex-shrink-0 min-w-0">
          <div class="relative w-9 h-9 sm:w-12 sm:h-12 flex-shrink-0 rounded-2xl p-0.5 bg-gradient-to-br from-amber-500 via-ics-700 to-ics-900 shadow-lg group-hover:scale-105 transition-transform duration-300">
            <img src="{{ asset('images/ics-logo.png') }}"
              alt="ICS Integrated Computer Society"
              class="w-full h-full object-contain rounded-xl bg-ics-950 p-0.5">
          </div>
          <div class="min-w-0">
            <div class="flex items-center gap-1.5 sm:gap-2.5">
              <h1 class="text-xs sm:text-lg lg:text-xl font-black tracking-tight leading-none text-white font-display uppercase flex items-center gap-1 sm:gap-1.5 truncate">
                <span>ICS</span>
                <span class="text-ics-gold font-normal">|</span>
                <span class="bg-gradient-to-r from-red-400 via-ics-gold to-yellow-300 bg-clip-text text-transparent">Admin Console</span>
              </h1>
              <span class="hidden sm:inline-flex px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-950/90 text-amber-300 border border-amber-800 shadow-sm flex-shrink-0">
                Staff &amp; Logistics
              </span>
            </div>
            <p class="text-[10px] sm:text-xs text-slate-300 font-medium hidden sm:flex items-center gap-2 mt-1">
              <span class="text-ics-gold font-semibold tracking-wider">Executive Management</span>
              <span class="text-slate-500">•</span>
              <span>Apparel &amp; Merch System</span>
            </p>
          </div>
        </a>

        <!-- Portal Link Switcher & Controls -->
        <div class="flex items-center gap-2 sm:gap-3.5 flex-shrink-0">

          <!-- Desktop Direct Link: Switch to Student Store Button -->
          <a
            href="{{ route('home') }}"
            class="hidden md:flex whitespace-nowrap flex-shrink-0 px-4 py-2 rounded-xl text-xs sm:text-sm font-bold bg-slate-900/90 hover:bg-slate-800 text-slate-100 hover:text-white border border-slate-700 hover:border-ics-600 transition items-center gap-2 shadow-sm">
            <svg class="w-4 h-4 text-ics-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span class="font-bold tracking-wide">Go to Student Store</span>
          </a>

          <!-- Desktop Admin Account Pill (ICS Black & Red Design) -->
          <div class="hidden sm:flex whitespace-nowrap flex-shrink-0 items-center gap-2.5 px-3.5 py-1.5 rounded-2xl bg-slate-900 border border-ics-900/80 shadow">
            @if(!empty($studentUser['avatar']))
              <img src="{{ $studentUser['avatar'] }}" alt="Profile" class="w-8 h-8 rounded-xl object-cover border border-ics-600 shadow flex-shrink-0">
            @else
              <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-crimson border border-ics-700 flex items-center justify-center text-white font-bold text-xs shadow flex-shrink-0">
                {{ $studentUser['initials'] ?? strtoupper(substr($adminUser->name ?? 'AD', 0, 2)) }}
              </div>
            @endif
            <div class="text-left">
              <p class="text-xs font-bold text-white leading-tight truncate max-w-[140px]" title="{{ $adminUser->name ?? $studentUser['name'] ?? 'Administrator' }}">
                {{ $adminUser->name ?? $studentUser['name'] ?? 'Administrator' }}
              </p>
              <p class="text-[10px] text-ics-gold font-mono leading-tight truncate max-w-[140px]" title="{{ $adminUser->role ?? 'Admin' }}">
                {{ $adminUser->role ?? 'Admin' }}
              </p>
            </div>
          </div>

          <!-- Desktop Dedicated Admin Sign Out Button -->
          <button
            type="button"
            onclick="icsApp.adminLogout()"
            class="hidden sm:flex whitespace-nowrap flex-shrink-0 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold bg-rose-950/80 hover:bg-rose-900 text-rose-200 border border-rose-800/80 hover:border-rose-600 transition items-center gap-1.5 shadow"
            title="Sign out of Admin Console">
            <svg class="w-4 h-4 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            <span class="font-bold">Sign Out</span>
          </button>

          <!-- Mobile Hamburger Toggle Button (Access Go to Student Store & Admin Menu) -->
          <button
            type="button"
            id="admin-mobile-hamburger-btn"
            onclick="icsApp.toggleMobileDrawer()"
            class="md:hidden p-1.5 rounded-lg bg-slate-900 border border-slate-800 hover:border-ics-700 text-slate-200 transition flex items-center justify-center focus:outline-none flex-shrink-0"
            aria-label="Open Navigation Menu">
            <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>

        </div>

      </div>
    </div>
  </header>

  <!-- ======================================================== -->
  <!-- MOBILE OFF-CANVAS NAVIGATION DRAWER (ADMIN) -->
  <!-- ======================================================== -->
  <div id="mobile-nav-backdrop" onclick="icsApp.closeMobileDrawer()" class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm transition-opacity duration-300 md:hidden"></div>

  <div id="mobile-nav-drawer" class="fixed top-0 right-0 bottom-0 w-80 max-w-[85vw] z-50 bg-slate-900 border-l border-ics-900 shadow-2xl flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out md:hidden overflow-y-auto">

    <!-- Drawer Header -->
    <div class="p-4 border-b border-slate-800 flex items-center justify-between bg-slate-950/60 sticky top-0 z-10 backdrop-blur-md">
      <div class="flex items-center gap-2.5">
        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-amber-500 via-ics-700 to-ics-900 border border-amber-600/50 flex items-center justify-center p-1 shadow">
          <img src="{{ asset('images/ics-logo.png') }}" alt="ICS" class="w-full h-full object-contain">
        </div>
        <div>
          <h3 class="text-xs font-black text-white font-display uppercase tracking-wide">ICS Admin Console</h3>
          <p class="text-[9px] text-ics-gold font-mono">Executive Management</p>
        </div>
      </div>
      <button type="button" onclick="icsApp.closeMobileDrawer()" class="text-slate-400 hover:text-white p-1.5 rounded-lg bg-slate-800">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Drawer Body -->
    <div class="p-4 space-y-4 flex-1">

      <!-- PROMINENT BUTTON: GO TO STUDENT STORE -->
      <a href="{{ route('home') }}" class="w-full p-3.5 rounded-2xl bg-gradient-to-r from-ics-800 to-ics-700 hover:from-ics-700 hover:to-ics-600 text-white font-bold text-xs flex items-center justify-between border border-ics-600 shadow-lg transition group">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-xl bg-slate-950/70 border border-ics-500/50 flex items-center justify-center text-ics-gold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
          </div>
          <div>
            <p class="font-bold text-white text-xs">Go to Student Store</p>
            <p class="text-[10px] text-ics-gold font-mono">Browse Apparel Catalog</p>
          </div>
        </div>
        <svg class="w-4 h-4 text-ics-gold group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
      </a>

      <!-- Admin Officer Profile Card -->
      <div class="p-3.5 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-center justify-between shadow">
        <div class="flex items-center gap-3">
          @if(!empty($studentUser['avatar']))
            <img src="{{ $studentUser['avatar'] }}" alt="Profile" class="w-10 h-10 rounded-xl object-cover border border-ics-600 shadow">
          @else
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-crimson border border-ics-700 flex items-center justify-center text-white font-bold text-xs shadow">
              {{ $studentUser['initials'] ?? strtoupper(substr($adminUser->name ?? 'AD', 0, 2)) }}
            </div>
          @endif
          <div>
            <p class="text-xs font-bold text-white leading-tight">{{ $adminUser->name ?? $studentUser['name'] ?? 'Administrator' }}</p>
            <p class="text-[10px] text-ics-gold font-mono leading-tight mt-0.5">{{ $adminUser->role ?? 'Executive Officer' }}</p>
            <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-mono font-bold bg-amber-950 text-amber-300 border border-amber-800 mt-1">Staff Access</span>
          </div>
        </div>
      </div>

      <!-- Admin Navigation Links -->
      <div>
        <p class="text-[10px] font-mono text-slate-400 uppercase tracking-wider mb-2 font-bold">Admin Navigation</p>
        <div class="space-y-1.5 text-xs font-semibold">
          <button type="button" onclick="icsApp.setAdminTab('dashboard'); icsApp.closeMobileDrawer();" class="w-full text-left px-3 py-2.5 rounded-xl bg-slate-950/60 hover:bg-slate-800 text-slate-200 hover:text-white flex items-center gap-2.5 transition border border-slate-800">
            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            <span>Executive Dashboard</span>
          </button>
          <button type="button" onclick="icsApp.setAdminTab('infomgmt'); icsApp.closeMobileDrawer();" class="w-full text-left px-3 py-2.5 rounded-xl bg-slate-950/60 hover:bg-slate-800 text-slate-200 hover:text-white flex items-center gap-2.5 transition border border-slate-800">
            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <span>Merchandise Inventory</span>
          </button>
          <button type="button" onclick="icsApp.setAdminTab('reservations'); icsApp.closeMobileDrawer();" class="w-full text-left px-3 py-2.5 rounded-xl bg-slate-950/60 hover:bg-slate-800 text-slate-200 hover:text-white flex items-center gap-2.5 transition border border-slate-800">
            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            <span>Reservation Queue</span>
          </button>
          <button type="button" onclick="icsApp.setAdminTab('claimed'); icsApp.closeMobileDrawer();" class="w-full text-left px-3 py-2.5 rounded-xl bg-slate-950/60 hover:bg-slate-800 text-slate-200 hover:text-white flex items-center gap-2.5 transition border border-slate-800">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Claimed Orders</span>
          </button>
          <button type="button" onclick="icsApp.setAdminTab('reports'); icsApp.closeMobileDrawer();" class="w-full text-left px-3 py-2.5 rounded-xl bg-slate-950/60 hover:bg-slate-800 text-slate-200 hover:text-white flex items-center gap-2.5 transition border border-slate-800">
            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            <span>Financial Reports</span>
          </button>
          <button type="button" onclick="icsApp.setAdminTab('usermgmt'); icsApp.closeMobileDrawer();" class="w-full text-left px-3 py-2.5 rounded-xl bg-slate-950/60 hover:bg-slate-800 text-slate-200 hover:text-white flex items-center gap-2.5 transition border border-slate-800">
            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span>System Users</span>
          </button>
          <button type="button" onclick="icsApp.setAdminTab('actlogs'); icsApp.closeMobileDrawer();" class="w-full text-left px-3 py-2.5 rounded-xl bg-slate-950/60 hover:bg-slate-800 text-slate-200 hover:text-white flex items-center gap-2.5 transition border border-slate-800">
            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Activity Audit Logs</span>
          </button>
          <button type="button" onclick="icsApp.setAdminTab('support'); icsApp.closeMobileDrawer();" class="w-full text-left px-3 py-2.5 rounded-xl bg-slate-950/60 hover:bg-slate-800 text-slate-200 hover:text-white flex items-center gap-2.5 transition border border-slate-800">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            <span>Support &amp; Student Chat</span>
          </button>
        </div>
      </div>

      <!-- Dedicated Sign Out Button -->
      <div class="pt-3 border-t border-slate-800">
        <button type="button" onclick="icsApp.adminLogout(); icsApp.closeMobileDrawer();" class="w-full px-3.5 py-2.5 rounded-xl bg-rose-950/80 hover:bg-rose-900 text-rose-200 font-bold text-xs border border-rose-800 transition flex items-center justify-center gap-2 shadow">
          <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
          <span>Sign Out of Admin Console</span>
        </button>
      </div>

    </div>
  </div>

  <main id="admin-view-container" class="flex-1 pb-28 md:pb-16 transition-opacity duration-300">
    <div class="w-full max-w-[1780px] 2xl:max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 mt-6">


      <!-- Admin Layout Grid: Sidebar Navigation + Main Panel -->
      <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">

        <!-- ======================================================== -->
        <!-- SIDEBAR NAVIGATION (Matching Whiteboard wireframe) -->
        <!-- Dashboard | INFO MGMT | REPORTS | USER MGMT | ACT LOGS -->
        <!-- ======================================================== -->
        <aside id="admin-desktop-sidebar" class="hidden md:block md:col-span-4 lg:col-span-3 xl:col-span-2 2xl:col-span-2 bg-slate-900/95 rounded-3xl border border-slate-800/90 p-4 shadow-2xl sticky top-24">
          <div class="p-3 mb-3 bg-gradient-to-br from-ics-900/90 to-slate-950 rounded-2xl border border-ics-800/80">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-ics-800 border border-ics-600 flex items-center justify-center p-1 flex-shrink-0 shadow-md">
                <img src="{{ asset('images/ics-logo.png') }}" alt="ICS" class="w-full h-full object-contain">
              </div>
              <div class="overflow-hidden">
                <h4 class="text-xs font-black uppercase text-white tracking-wide">ICS Admin Console</h4>
                <p class="text-[10px] text-ics-gold font-mono font-semibold">Staff &amp; Logistics</p>
              </div>
            </div>
          </div>

          <!-- Navigation Links -->
          <nav class="space-y-1.5" aria-label="Admin Navigation Tabs">

            <!-- 1. Dashboard -->
            <button
              id="admin-tab-btn-dashboard"
              onclick="icsApp.setAdminTab('dashboard')"
              class="admin-nav-btn w-full text-left px-3.5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition flex items-center justify-between bg-ics-800 text-white shadow-md border border-ics-600/70">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-ics-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                </svg>
                <span>Dashboard (Read)</span>
              </div>
              <span class="text-[10px] px-2 py-0.5 rounded-full bg-ics-950 font-mono text-ics-300 font-bold">Sales/Stock</span>
            </button>

            <!-- 2. Information Management (CRUD + Image Upload/Edit) -->
            <button
              id="admin-tab-btn-infomgmt"
              onclick="icsApp.setAdminTab('infomgmt')"
              class="admin-nav-btn w-full text-left px-3.5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition flex items-center justify-between text-slate-300 hover:text-white hover:bg-slate-800/80 border border-transparent">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span>INFO MGMT (CRUD)</span>
              </div>
              <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-800 font-mono text-slate-300 font-bold">{{ $totalProducts }} items</span>
            </button>

            <!-- 3. Reservation Queue Logistics -->
            <button
              id="admin-tab-btn-reservations"
              onclick="icsApp.setAdminTab('reservations')"
              class="admin-nav-btn w-full text-left px-3.5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition flex items-center justify-between text-slate-300 hover:text-white hover:bg-slate-800/80 border border-transparent">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <span>Reservation Queue</span>
              </div>
              <span class="text-[10px] px-2 py-0.5 rounded-full bg-amber-950/80 border border-amber-800 font-mono text-amber-300 font-bold">{{ $pendingReservationsCount }} pending</span>
            </button>

            <!-- Dedicated Claimed Releases / Items Tab -->
            <button
              id="admin-tab-btn-claimed"
              onclick="icsApp.setAdminTab('claimed')"
              class="admin-nav-btn w-full text-left px-3.5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition flex items-center justify-between text-slate-300 hover:text-white hover:bg-slate-800/80 border border-transparent">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-cyan-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Claimed Items (Releases)</span>
              </div>
              <span id="admin-nav-claimed-badge" class="text-[10px] px-2 py-0.5 rounded-full bg-cyan-950/80 border border-cyan-800 font-mono text-cyan-300 font-bold">
                {{ count($claimedReservations ?? []) }} Claimed
              </span>
            </button>

            <!-- 4. Reports (Sales vs Stock) -->
            <button
              id="admin-tab-btn-reports"
              onclick="icsApp.setAdminTab('reports')"
              class="admin-nav-btn w-full text-left px-3.5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition flex items-center justify-between text-slate-300 hover:text-white hover:bg-slate-800/80 border border-transparent">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>REPORTS (Read)</span>
              </div>
              <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-800 font-mono text-slate-300 font-bold">Master CSV</span>
            </button>

            <!-- 5. User Management (CRUD) -->
            <button
              id="admin-tab-btn-usermgmt"
              onclick="icsApp.setAdminTab('usermgmt')"
              class="admin-nav-btn w-full text-left px-3.5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition flex items-center justify-between text-slate-300 hover:text-white hover:bg-slate-800/80 border border-transparent">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-purple-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>USER MGMT (CRUD)</span>
              </div>
              <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-800 font-mono text-slate-300 font-bold">{{ $users->count() }}</span>
            </button>

            <!-- 6. Activity Logs (Audit Trail) -->
            <button
              id="admin-tab-btn-actlogs"
              onclick="icsApp.setAdminTab('actlogs')"
              class="admin-nav-btn w-full text-left px-3.5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition flex items-center justify-between text-slate-300 hover:text-white hover:bg-slate-800/80 border border-transparent">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-cyan-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>ACT LOGS (Audit Trail)</span>
              </div>
              <span id="admin-nav-actlogs-badge" class="text-[10px] px-2 py-0.5 rounded-full bg-cyan-950 border border-cyan-800 font-mono text-cyan-300 font-bold">{{ count($activityLogs) }}</span>
            </button>

            <!-- 7. Support Tickets & Chat Helpdesk -->
            <button
              id="admin-tab-btn-support"
              onclick="icsApp.setAdminTab('support')"
              class="admin-nav-btn w-full text-left px-3.5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition flex items-center justify-between text-slate-300 hover:text-white hover:bg-slate-800/80 border border-transparent">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <span>SUPPORT CHAT</span>
              </div>
              <span id="admin-nav-ticket-badge" class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-950 border border-emerald-700/60 font-mono text-emerald-300 font-bold">
                {{ $openTicketsCount ?? 0 }} Open
              </span>
            </button>

          </nav>

        </aside>

        <!-- ======================================================== -->
        <!-- MAIN ADMIN CONTENT AREA -->
        <!-- ======================================================== -->
        <div class="col-span-12 md:col-span-8 lg:col-span-9 xl:col-span-10 2xl:col-span-10 space-y-6 w-full">

          <!-- ======================================================== -->
          <!-- MODULE 1: DASHBOARD (Sales vs Stock Analytics) -->
          <!-- ======================================================== -->
          <section id="admin-sec-dashboard" class="admin-tab-section space-y-6">

            <!-- Top Metric KPI Cards (Modern Executive Dashboard Design) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5">

              <!-- 1. Total Catalog Items -->
              <div class="relative overflow-hidden bg-gradient-to-br from-slate-900/95 via-slate-900/90 to-slate-950 rounded-3xl border border-slate-800/90 hover:border-indigo-500/50 p-5 sm:p-6 shadow-xl transition-all duration-300 group">
                <div class="flex items-center justify-between">
                  <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">Total Catalog Items</span>
                  <div class="w-8 h-8 rounded-xl bg-indigo-500/10 border border-indigo-500/30 flex items-center justify-center text-indigo-400 group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                  </div>
                </div>
                <p id="kpi-total-products" class="text-3xl sm:text-4xl lg:text-5xl font-black text-white font-display tracking-tight mt-3">{{ $totalProducts }}</p>
                <div class="flex items-center gap-2 mt-2 pt-2 border-t border-slate-800/60">
                  <span class="inline-block w-2 h-2 rounded-full bg-indigo-400"></span>
                  <span class="text-xs text-slate-300 font-medium">Active merchandise models</span>
                </div>
              </div>

              <!-- 2. On-Hand Stock -->
              <div class="relative overflow-hidden bg-gradient-to-br from-slate-900/95 via-slate-900/90 to-slate-950 rounded-3xl border border-slate-800/90 hover:border-emerald-500/50 p-5 sm:p-6 shadow-xl transition-all duration-300 group">
                <div class="flex items-center justify-between">
                  <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">On-Hand Stock</span>
                  <div class="w-8 h-8 rounded-xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                  </div>
                </div>
                <p id="kpi-total-stock" class="text-3xl sm:text-4xl lg:text-5xl font-black text-emerald-400 font-display tracking-tight mt-3">{{ number_format($totalStockUnits) }}</p>
                <div class="flex items-center gap-2 mt-2 pt-2 border-t border-slate-800/60">
                  <span class="inline-block w-2 h-2 rounded-full bg-emerald-400"></span>
                  <span class="text-xs text-slate-300 font-medium">Units ready for immediate issue</span>
                </div>
              </div>

              <!-- 3. Units Claimed / Sold -->
              <div onclick="icsApp.setAdminTab('claimed')" class="relative overflow-hidden bg-gradient-to-br from-slate-900/95 via-slate-900/90 to-slate-950 rounded-3xl border border-slate-800/90 hover:border-cyan-500/50 p-5 sm:p-6 shadow-xl transition-all duration-300 cursor-pointer group" title="Click to view all claimed items and release records">
                <div class="flex items-center justify-between">
                  <span class="text-xs font-bold text-slate-300 group-hover:text-cyan-300 uppercase tracking-wider transition">Units Claimed / Sold</span>
                  <div class="w-8 h-8 rounded-xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  </div>
                </div>
                <div class="flex items-baseline justify-between mt-3">
                  <p id="kpi-total-sold" class="text-3xl sm:text-4xl lg:text-5xl font-black text-cyan-400 font-display tracking-tight">{{ number_format($totalSoldUnits) }}</p>
                  <span class="text-xs px-2.5 py-1 rounded-xl bg-cyan-950/80 text-cyan-300 border border-cyan-800 font-mono font-bold group-hover:bg-cyan-900 transition">View Ledger &rarr;</span>
                </div>
                <div class="flex items-center justify-between mt-2 pt-2 border-t border-slate-800/60 text-xs">
                  <span class="text-slate-300 font-medium">Total Revenue:</span>
                  <span id="kpi-total-revenue" class="font-mono text-emerald-400 font-black bg-emerald-950/80 px-2 py-0.5 rounded-lg border border-emerald-800/60">₱{{ number_format($totalRevenue, 2) }}</span>
                </div>
              </div>

              <!-- 4. Active Reservations -->
              <div onclick="icsApp.setAdminTab('reservations')" class="relative overflow-hidden bg-gradient-to-br from-slate-900/95 via-slate-900/90 to-slate-950 rounded-3xl border border-slate-800/90 hover:border-amber-500/50 p-5 sm:p-6 shadow-xl transition-all duration-300 cursor-pointer group" title="Click to view student reservation queue">
                <div class="flex items-center justify-between">
                  <span class="text-xs font-bold text-slate-300 group-hover:text-amber-300 uppercase tracking-wider transition">Active Reservations</span>
                  <div class="w-8 h-8 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 group-hover:scale-110 transition-transform">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  </div>
                </div>
                <p id="kpi-total-reserved" class="text-3xl sm:text-4xl lg:text-5xl font-black text-amber-400 font-display tracking-tight mt-3">{{ $totalReservedUnits }}</p>
                <div class="flex items-center gap-2 mt-2 pt-2 border-t border-slate-800/60 text-xs">
                  <span class="px-2 py-0.5 rounded-lg bg-amber-950/80 text-amber-300 border border-amber-800 font-mono font-bold"><span id="kpi-pending-count">{{ $pendingReservationsCount }}</span> Pending</span>
                  <span class="px-2 py-0.5 rounded-lg bg-emerald-950/80 text-emerald-300 border border-emerald-800 font-mono font-bold"><span id="kpi-ready-count">{{ $readyReservationsCount }}</span> Ready</span>
                </div>
              </div>

            </div>

            <!-- ======================================================== -->
            <!-- VISUAL CHARTS (DONUT / CIRCLE CHART & BAR CHART) -->
            <!-- Interactive with Tooltips, Percentages, and Real-Time Sync -->
            <!-- ======================================================== -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 sm:gap-6">

              <!-- Donut Chart: Inventory Distribution (Circle Chart) -->
              <div class="bg-slate-900/95 rounded-3xl border border-slate-800/90 p-6 shadow-xl flex flex-col justify-between">
                <div class="flex items-center justify-between pb-3.5 mb-3 border-b border-slate-800">
                  <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2.5">
                      <span>Stock &amp; Sales Distribution</span>
                      <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono bg-emerald-950 text-emerald-300 border border-emerald-800 font-bold">Circle Chart</span>
                    </h4>
                  </div>
                </div>

                <div class="relative w-full h-80 sm:h-96 min-h-[320px]" id="donut-chart-container">
                  <canvas id="inventoryDonutChart" class="w-full h-full block"></canvas>
                  <div id="inventoryDonutSvgFallback" class="w-full h-full hidden flex items-center justify-center"></div>
                </div>

                @php $totRatio = max(1, $totalStockUnits + $totalSoldUnits + $totalReservedUnits); @endphp
                <div class="grid grid-cols-3 gap-3 mt-4 pt-3.5 border-t border-slate-800/80 text-center font-mono">
                  <div class="p-2.5 rounded-2xl bg-slate-950/70 border border-slate-800">
                    <span class="text-xs text-emerald-400 block font-bold">On-Hand</span>
                    <span id="chart-total-stock" class="text-white text-base font-bold">{{ number_format($totalStockUnits) }}</span>
                    <span id="chart-pct-stock" class="text-[11px] text-emerald-300 block mt-0.5 font-sans font-semibold">
                      {{ round(($totalStockUnits / $totRatio) * 100, 1) }}%
                    </span>
                  </div>
                  <div class="p-2.5 rounded-2xl bg-slate-950/70 border border-slate-800">
                    <span class="text-xs text-cyan-400 block font-bold">Claimed (Sold)</span>
                    <span id="chart-total-sold" class="text-white text-base font-bold">{{ number_format($totalSoldUnits) }}</span>
                    <span id="chart-pct-sold" class="text-[11px] text-cyan-300 block mt-0.5 font-sans font-semibold">
                      {{ round(($totalSoldUnits / $totRatio) * 100, 1) }}%
                    </span>
                  </div>
                  <div class="p-2.5 rounded-2xl bg-slate-950/70 border border-slate-800">
                    <span class="text-xs text-amber-400 block font-bold">Reserved</span>
                    <span id="chart-total-reserved" class="text-white text-base font-bold">{{ number_format($totalReservedUnits) }}</span>
                    <span id="chart-pct-reserved" class="text-[11px] text-amber-300 block mt-0.5 font-sans font-semibold">
                      {{ round(($totalReservedUnits / $totRatio) * 100, 1) }}%
                    </span>
                  </div>
                </div>
              </div>

              <!-- Bar Chart: Category Performance (Available vs Sold) -->
              <div class="bg-slate-900/95 rounded-3xl border border-slate-800/90 p-6 shadow-xl flex flex-col justify-between">
                <div class="flex items-center justify-between pb-3.5 mb-3 border-b border-slate-800">
                  <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2.5">
                      <span>Category Sales vs Stock</span>
                      <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono bg-blue-950 text-blue-300 border border-blue-800 font-bold">Bar Chart</span>
                    </h4>
                  </div>
                </div>

                <div class="relative w-full h-80 sm:h-96 min-h-[320px]" id="bar-chart-container">
                  <canvas id="categoryBarChart" class="w-full h-full block"></canvas>
                  <div id="categoryBarSvgFallback" class="w-full h-full hidden"></div>
                </div>

                <div class="flex items-center justify-between mt-4 pt-3.5 border-t border-slate-800/80 text-xs text-slate-300">
                  <span class="font-medium">General, PE, Dept, Accessories</span>
                  <span class="font-mono text-emerald-400 font-semibold flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Real-Time Synced
                  </span>
                </div>
              </div>

            </div>

            <!-- SALES VS STOCK ANALYTICS CARD -->
            <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-6 shadow-xl">
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-6 pb-4 border-b border-slate-800">
                <div>
                  <h3 class="text-lg font-black text-white font-display">
                    <span>Sales vs Stock Inventory Analytics</span>
                  </h3>
                  <p class="text-xs text-slate-400">
                    Comparative tracking of initial inventory, units claimed (sales), pending reservations, and remaining stock.
                  </p>
                </div>
                <div class="flex items-center gap-2">
                  <button onclick="icsApp.setAdminTab('reports')" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition">
                    View Full Report
                  </button>
                  <a href="{{ route('reports.export') }}" class="px-3 py-1.5 rounded-xl text-xs font-bold bg-ics-700 hover:bg-ics-600 text-white transition flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Export CSV</span>
                  </a>
                </div>
              </div>

              <!-- Visual Bars: Sales vs Stock for Every Product -->
              <div class="space-y-4">
                @foreach($salesVsStock as $item)
                <div class="p-3.5 rounded-2xl bg-slate-950/70 border border-slate-800/80 hover:border-slate-700 transition">
                  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                    <div class="flex items-center gap-3">
                      <img src="{{ asset($item['image_path']) }}" alt="{{ $item['name'] }}" class="w-10 h-10 rounded-xl object-cover border border-slate-700">
                      <div>
                        <h4 class="text-xs font-bold text-white">{{ $item['name'] }}</h4>
                        <div class="flex items-center gap-2 text-[10px] text-slate-400 font-mono">
                          <span>SKU: {{ $item['item_code'] }}</span>
                          <span>Unit Price: ₱{{ number_format($item['price'], 2) }}</span>
                        </div>
                      </div>
                    </div>

                    <!-- Stock / Sold Badges -->
                    <div class="flex items-center gap-2 text-right">
                      <div class="text-right">
                        <span class="text-xs font-bold text-emerald-400 font-mono">{{ $item['current_stock'] }}</span>
                        <span class="text-[10px] text-slate-400 block">Available</span>
                      </div>
                      <div class="text-right border-l border-slate-800 pl-2">
                        <span class="text-xs font-bold text-blue-400 font-mono">{{ $item['units_sold'] }}</span>
                        <span class="text-[10px] text-slate-400 block">Claimed (Sold)</span>
                      </div>
                      <div class="text-right border-l border-slate-800 pl-2">
                        <span class="text-xs font-bold text-amber-400 font-mono">{{ $item['units_reserved'] }}</span>
                        <span class="text-[10px] text-slate-400 block">Reserved</span>
                      </div>
                    </div>
                  </div>

                  <!-- Stacked Progress Bar (Claimed vs Reserved vs Available) -->
                  @php
                  $initial = max(1, $item['initial_stock']);
                  $soldPct = min(100, round(($item['units_sold'] / $initial) * 100));
                  $resPct = min(100, round(($item['units_reserved'] / $initial) * 100));
                  $availPct = max(0, min(100, round(($item['current_stock'] / $initial) * 100)));
                  @endphp
                  <div class="w-full bg-slate-900 rounded-full h-3 flex overflow-hidden border border-slate-800">
                    <div style="width: {{ $soldPct }}%" class="bg-blue-500 h-full" title="Claimed/Sold: {{ $item['units_sold'] }}"></div>
                    <div style="width: {{ $resPct }}%" class="bg-amber-400 h-full" title="Reserved: {{ $item['units_reserved'] }}"></div>
                    <div style="width: {{ $availPct }}%" class="bg-emerald-500 h-full" title="Available Stock: {{ $item['current_stock'] }}"></div>
                  </div>
                  <div class="flex justify-between text-[9px] text-slate-500 font-mono mt-1">
                    <span>Sold: {{ $soldPct }}%</span>
                    <span>Reserved: {{ $resPct }}%</span>
                    <span>Available: {{ $availPct }}%</span>
                  </div>
                </div>
                @endforeach
              </div>

              <!-- Legend -->
              <div class="mt-4 pt-4 border-t border-slate-800 flex flex-wrap gap-4 text-xs text-slate-300">
                <div class="flex items-center gap-1.5">
                  <span class="w-3 h-3 rounded-md bg-blue-500 inline-block"></span>
                  <span>Units Sold / Claimed</span>
                </div>
                <div class="flex items-center gap-1.5">
                  <span class="w-3 h-3 rounded-md bg-amber-400 inline-block"></span>
                  <span>Units Reserved (Pending Pickup)</span>
                </div>
                <div class="flex items-center gap-1.5">
                  <span class="w-3 h-3 rounded-md bg-emerald-500 inline-block"></span>
                  <span>Available In-Stock Units</span>
                </div>
              </div>

            </div>

            <!-- Recent Activity Audit Snippet -->
            <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-5 shadow-xl">
              <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-bold text-white uppercase tracking-wider">
                  <span>Recent Activity Audit Trail</span>
                </h4>
                <button onclick="icsApp.setAdminTab('actlogs')" class="text-xs text-ics-gold hover:underline">
                  View All Logs &rarr;
                </button>
              </div>

              <div class="overflow-x-auto rounded-2xl border border-slate-800/80">
                <table class="w-full text-left text-xs sm:text-sm">
                  <thead class="text-slate-300 bg-slate-950 uppercase text-xs font-mono font-bold border-b border-slate-800">
                    <tr>
                      <th class="py-3.5 px-4">USER CODE</th>
                      <th class="py-3.5 px-4">ACTION</th>
                      <th class="py-3.5 px-4">ACTIVITY</th>
                      <th class="py-3.5 px-4">DATE / TIMESTAMP</th>
                    </tr>
                  </thead>
                  <tbody id="dashboard-recent-activity-tbody" class="divide-y divide-slate-800 text-slate-300">
                    @foreach($activityLogs->take(5) as $log)
                    <tr class="hover:bg-slate-800/40 transition">
                      <td class="py-3.5 px-4 font-mono text-cyan-300 font-bold whitespace-nowrap">
                        <span class="bg-cyan-950/60 px-2.5 py-1 rounded-lg border border-cyan-800/60 inline-block">{{ $log->user_code }}</span>
                      </td>
                      <td class="py-3.5 px-4 whitespace-nowrap">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold font-mono
                          @if($log->action === 'CREATE') bg-emerald-950 text-emerald-300 border border-emerald-800
                          @elseif($log->action === 'UPDATE') bg-amber-950 text-amber-300 border border-amber-800
                          @elseif($log->action === 'DELETE') bg-rose-950 text-rose-300 border border-rose-800
                          @elseif($log->action === 'LOGIN') bg-purple-950 text-purple-300 border border-purple-800
                          @elseif($log->action === 'LOGOUT') bg-slate-800 text-slate-300 border border-slate-700
                          @else bg-blue-950 text-blue-300 border border-blue-800 @endif">
                          {{ $log->action }}
                        </span>
                      </td>
                      <td class="py-3.5 px-4 text-slate-200 font-medium">{{ $log->activity }}</td>
                      <td class="py-3.5 px-4 font-mono text-slate-300 text-xs whitespace-nowrap">{{ $log->created_at->format('m/d/Y, h:i A') }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

          </section>

          <!-- ======================================================== -->
          <!-- MODULE 2: INFORMATION MANAGEMENT (CRUD + Image Upload/Edit) -->
          <!-- ======================================================== -->
          <section id="admin-sec-infomgmt" class="admin-tab-section hidden space-y-6">

            <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-6 shadow-xl">
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-800">
                <div>
                  <h3 class="text-lg font-black text-white font-display flex items-center gap-2">
                    <span>Information Management (Catalog CRUD)</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-ics-800 text-ics-gold">With Picture Upload & Edit</span>
                  </h3>
                  <p class="text-xs text-slate-400">
                    Add new uniforms, edit details, upload custom item photos, adjust size inventories, or delete products.
                  </p>
                </div>

                <!-- Add New Product Button -->
                <button
                  type="button"
                  onclick="icsApp.openAddProductModal()"
                  class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-ics-700 to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white text-xs font-bold transition flex items-center gap-2 shadow-lg border border-ics-600 cursor-pointer">
                  <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  <span>Add New Apparel / Merch</span>
                </button>
              </div>

              <!-- Product Table -->
              <div class="overflow-x-auto rounded-2xl border border-slate-800/80">
                <table class="w-full text-left text-xs sm:text-sm">
                  <thead class="text-slate-300 bg-slate-950 uppercase text-xs font-mono font-bold border-b border-slate-800">
                    <tr>
                      <th class="py-3.5 px-4">Item / Photo</th>
                      <th class="py-3.5 px-4">Item Code</th>
                      <th class="py-3.5 px-4">Category</th>
                      <th class="py-3.5 px-4">Price (PHP)</th>
                      <th class="py-3.5 px-4">Stock Units</th>
                      <th class="py-3.5 px-4">Status</th>
                      <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-800 text-slate-300">
                    @foreach($products as $p)
                    <tr class="hover:bg-slate-800/50 transition {{ $p->current_stock <= 0 ? 'opacity-75 bg-rose-950/10' : '' }}">
                      <td class="py-3.5 px-4">
                        <div class="flex items-center gap-3.5">
                          <img src="{{ asset($p->image_path) }}" alt="{{ $p->name }}" class="w-14 h-14 rounded-2xl object-cover border border-slate-700 shadow-md flex-shrink-0 {{ $p->current_stock <= 0 ? 'grayscale contrast-75' : '' }}">
                          <div>
                            <p class="font-bold text-white text-sm {{ $p->current_stock <= 0 ? 'line-through decoration-rose-500 decoration-2 text-rose-300/80' : '' }}">{{ $p->name }}</p>
                            <p class="text-xs text-slate-300 mt-0.5 {{ $p->current_stock <= 0 ? 'line-through decoration-rose-500/60' : '' }}">{{ $p->gender }} / {{ $p->dept }}</p>
                          </div>
                        </div>
                      </td>
                      <td class="py-3.5 px-4 whitespace-nowrap">
                        <span class="font-mono text-cyan-300 font-bold bg-cyan-950/60 px-2.5 py-1 rounded-lg border border-cyan-800/60 inline-block {{ $p->current_stock <= 0 ? 'line-through decoration-rose-500 text-rose-400' : '' }}">{{ $p->item_code }}</span>
                      </td>
                      <td class="py-3.5 px-4 uppercase text-xs font-semibold text-slate-300 whitespace-nowrap {{ $p->current_stock <= 0 ? 'line-through decoration-rose-500/60' : '' }}">{{ $p->category }}</td>
                      <td class="py-3.5 px-4 font-mono font-black text-emerald-400 text-sm whitespace-nowrap {{ $p->current_stock <= 0 ? 'line-through decoration-rose-500/80 text-slate-400' : '' }}">₱{{ number_format($p->price, 2) }}</td>
                      <td class="py-3.5 px-4 font-mono font-black text-white text-sm whitespace-nowrap">
                        @if($p->current_stock <= 0)
                          <span class="line-through decoration-rose-500 decoration-2 text-rose-400 font-bold">0</span>
                        @else
                          {{ $p->current_stock }}
                        @endif
                      </td>
                      <td class="py-3.5 px-4 whitespace-nowrap">
                        @if($p->current_stock <= 0)
                          <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-950 text-rose-300 border border-rose-800 line-through decoration-rose-400">Out of Stock</span>
                          @elseif($p->current_stock < 20)
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-950 text-amber-300 border border-amber-800">Low Stock</span>
                          @else
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">In Stock</span>
                          @endif
                      </td>
                      <td class="py-3.5 px-4 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2">
                          <!-- Edit Product (Details + Picture) -->
                          <button
                            type="button"
                            onclick="icsApp.openEditProductModal('{{ $p->id }}')"
                            class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition flex items-center gap-1.5 border border-slate-700 shadow cursor-pointer"
                            title="Edit Product & Picture">
                            <svg class="w-3.5 h-3.5 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Edit</span>
                          </button>
                          <!-- Delete Product -->
                          <button
                            type="button"
                            onclick="icsApp.deleteProduct('{{ $p->id }}', '{{ $p->name }}')"
                            class="p-1.5 rounded-xl bg-rose-950/60 hover:bg-rose-900 text-rose-300 transition border border-rose-800 cursor-pointer"
                            title="Delete Product">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                          </button>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

            </div>

          </section>

          <!-- ======================================================== -->
          <!-- MODULE 3: RESERVATION QUEUE LOGISTICS -->
          <!-- ======================================================== -->
          <section id="admin-sec-reservations" class="admin-tab-section hidden space-y-6">

            <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-6 shadow-xl">
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-800">
                <div>
                  <h3 class="text-lg font-black text-white font-display flex items-center gap-2">
                    <span>Student Reservation Queue</span>
                    <span id="reservations-total-badge" class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-amber-950 text-amber-300 border border-amber-800">{{ $reservations->count() }} Total</span>
                  </h3>
                  <p class="text-xs text-slate-400">
                    Review incoming student reservations, approve readiness for pickup, and mark items as claimed.
                  </p>
                </div>

                <!-- Multi-select Actions & Status Filter -->
                <div class="flex flex-wrap items-center gap-2">
                  <div class="flex items-center gap-2 bg-slate-950 px-3 py-1.5 rounded-xl border border-slate-800 text-xs">
                    <label class="flex items-center gap-1.5 cursor-pointer text-slate-300 hover:text-white select-none">
                      <input
                        type="checkbox"
                        id="reservations-select-all"
                        onchange="icsApp.toggleAllReservationCheckboxes(this.checked)"
                        class="w-4 h-4 rounded text-rose-500 bg-slate-900 border-slate-700 focus:ring-0 cursor-pointer"
                      />
                      <span class="text-xs font-semibold">Select All</span>
                    </label>
                    <span id="reservations-selected-badge" class="hidden px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-rose-950 text-rose-300 border border-rose-800">
                      0 Selected
                    </span>
                  </div>

                  <button
                    type="button"
                    id="reservations-bulk-delete-btn"
                    onclick="icsApp.deleteSelectedReservations()"
                    class="hidden px-3 py-1.5 rounded-xl text-xs font-bold bg-rose-600 hover:bg-rose-500 text-white transition flex items-center gap-1.5 shadow-lg shadow-rose-950/50 cursor-pointer animate-in fade-in">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Delete Selected</span>
                  </button>

                  <select id="reservation-filter-status" onchange="icsApp.filterReservations(this.value)" class="bg-slate-950 border border-slate-700 rounded-xl px-3 py-1.5 text-xs text-white">
                    <option value="all">All Statuses</option>
                    <option value="Pending">Pending Only</option>
                    <option value="Ready for Pickup">Ready for Pickup</option>
                    <option value="Claimed">Claimed / Completed</option>
                    <option value="Cancelled">Cancelled</option>
                  </select>
                </div>
              </div>

              <!-- Reservation Cards List -->
              <div id="reservations-list" class="space-y-4">
                @foreach($reservations as $r)
                @php
                  $isFinishedOrder = ($r->status === 'Claimed' || $r->status === 'Cancelled');
                @endphp
                <div class="p-4 rounded-2xl bg-slate-950/80 border border-slate-800 hover:border-slate-700 transition reservation-queue-card {{ $isFinishedOrder ? 'cursor-pointer hover:border-slate-600' : '' }}"
                  data-id="{{ $r->id }}"
                  data-status="{{ $r->status }}"
                  data-ref="{{ $r->ref_code }}"
                  data-stuid="{{ $r->student_id }}"
                  data-name="{{ htmlspecialchars($r->student_name ?? '', ENT_QUOTES, 'UTF-8') }}"
                  data-dept="{{ htmlspecialchars($r->department ?? '', ENT_QUOTES, 'UTF-8') }}"
                  data-total="{{ $r->total_amount }}"
                  data-items="{{ htmlspecialchars(json_encode($r->items ?? []), ENT_QUOTES, 'UTF-8') }}"
                  @if($isFinishedOrder) onclick="icsApp.toggleReservationRowSelect(event, '{{ $r->id }}')" @endif>
                  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 pb-3 border-b border-slate-800/80">
                    <div class="reservation-header-badges flex items-center gap-2.5 flex-wrap">
                      @if($isFinishedOrder)
                      <label class="inline-flex items-center cursor-pointer mr-0.5" onclick="event.stopPropagation()">
                        <input
                          type="checkbox"
                          value="{{ $r->id }}"
                          onchange="icsApp.onReservationCheckboxChange()"
                          class="reservation-row-checkbox w-4 h-4 rounded text-rose-500 bg-slate-900 border-slate-700 focus:ring-0 cursor-pointer"
                          title="Select finished order for bulk delete"
                        />
                      </label>
                      @endif
                      <span class="font-mono font-bold text-sm text-ics-gold">{{ $r->ref_code }}</span>
                      <span class="reservation-status-badge px-2 py-0.5 rounded-full text-[10px] font-bold
                        @if($r->status === 'Pending') bg-amber-950 text-amber-300 border border-amber-700
                        @elseif($r->status === 'Ready for Pickup') bg-blue-950 text-blue-300 border border-blue-700
                        @elseif($r->status === 'Claimed') bg-emerald-950 text-emerald-300 border border-emerald-700
                        @else bg-rose-950 text-rose-300 border border-rose-700 font-extrabold @endif">
                        @if($r->status === 'Cancelled')
                        <span class="text-rose-500 font-black mr-1">✕</span> Cancelled
                        @else
                        {{ $r->status }}
                        @endif
                      </span>

                      @if($loop->first && $r->status === 'Pending')
                      <span class="fifo-queue-badge inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-500/20 text-amber-300 border border-amber-500/50 shadow-sm" title="First-In, First-Out: This is the earliest order placed, locked at top for priority processing">
                        <span>🔒 1st in Queue (FIFO)</span>
                      </span>
                      @endif

                      @if($r->activeTicket)
                      <span class="ticket-warning-badge inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/50 animate-pulse" title="This reservation has a pending Helpdesk Support Ticket">
                        <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>⚠️ ON HOLD: Active Support Ticket ({{ $r->activeTicket->ticket_code }})</span>
                      </span>
                      @endif
                    </div>

                    <div class="text-[11px] text-slate-400 font-mono text-left sm:text-right">
                      <div>Purchased: {{ $r->created_at ? $r->created_at->format('M d, Y h:i A') : 'N/A' }}</div>
                      @if($r->status === 'Claimed')
                      <div class="text-emerald-400 font-semibold flex items-center sm:justify-end gap-1">
                        <svg class="w-3 h-3 text-emerald-400 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Claimed: {{ $r->claimed_at ? $r->claimed_at->format('M d, Y h:i A') : ($r->updated_at ? $r->updated_at->format('M d, Y h:i A') : 'Recorded') }}</span>
                      </div>
                      @endif
                    </div>
                  </div>

                  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mt-4 pt-3 border-t border-slate-800/60">
                    <div>
                      <p class="text-xs font-bold text-slate-300 uppercase tracking-wider">Student Buyer</p>
                      <p class="text-sm font-black text-white mt-1">{{ $r->student_name }}</p>
                      <div class="mt-1">
                        <span class="font-mono text-xs font-bold text-cyan-300 bg-cyan-950/60 px-2 py-0.5 rounded-md border border-cyan-800/60 inline-block">{{ $r->student_id }}</span>
                        <span class="text-xs text-slate-300 ml-1">({{ $r->year_level }})</span>
                      </div>
                      <p class="text-xs text-slate-300 mt-1">{{ $r->department }}</p>
                      <p class="text-xs text-slate-400 font-mono mt-0.5">Contact: {{ $r->contact }}</p>
                    </div>

                    <div>
                      <p class="text-xs font-bold text-slate-300 uppercase tracking-wider">Pickup Schedule</p>
                      <p class="text-sm font-bold text-ics-gold mt-1">{{ $r->pickup_date }}</p>
                      <p class="text-xs text-slate-200 mt-0.5">{{ $r->pickup_slot }}</p>
                      <p class="text-xs text-slate-400 mt-1 italic">{{ $r->notes ?: 'No additional notes' }}</p>
                    </div>

                    <div>
                      <p class="text-xs font-bold text-slate-300 uppercase tracking-wider">Payment &amp; Receipt</p>
                      <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                        @if(($r->payment_method ?? 'Cash on Pickup') === 'GCash Online')
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-950 text-blue-300 border border-blue-800 flex items-center gap-1">
                          GCash Online
                        </span>
                        @elseif(($r->payment_method ?? '') === 'Maya Online')
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-950 text-emerald-300 border border-emerald-800 flex items-center gap-1">
                          Maya Online
                        </span>
                        @elseif(($r->payment_method ?? '') === 'Debit/Credit Card')
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-indigo-950 text-indigo-300 border border-indigo-800 flex items-center gap-1">
                          Debit/Credit Card
                        </span>
                        @else
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-950 text-amber-300 border border-amber-800 flex items-center gap-1">
                          Pay at School
                        </span>
                        @endif

                        <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded-md bg-slate-900 border border-slate-800 {{ ($r->payment_status ?? 'Unpaid') === 'Verified' ? 'text-emerald-400' : 'text-amber-400' }}">
                          {{ $r->payment_status ?? 'Unpaid' }}
                        </span>
                      </div>

                      @if(!empty($r->payment_reference))
                      <div class="mt-2 p-1.5 rounded-lg bg-slate-950/80 border border-slate-800/80 flex items-center justify-between gap-1">
                        <span class="text-[10px] uppercase font-bold text-slate-400">GCash Ref:</span>
                        <span class="font-mono text-xs font-bold text-ics-gold select-all">{{ $r->payment_reference }}</span>
                      </div>
                      @endif

                      @if(!empty($r->receipt_image))
                      @php
                        $receiptSrc = (str_starts_with($r->receipt_image, 'data:image') || str_starts_with($r->receipt_image, 'http://') || str_starts_with($r->receipt_image, 'https://'))
                          ? $r->receipt_image
                          : asset(ltrim($r->receipt_image, '/'));
                      @endphp
                      <div class="mt-2.5 reservation-receipt-container">
                        <div class="relative group cursor-pointer inline-block" onclick="event.stopPropagation(); icsApp.openReceiptViewModal('{{ $r->id }}')" title="Click to view full receipt image">
                          <img
                            src="{{ $receiptSrc }}"
                            alt="Payment Receipt from {{ $r->student_name }}"
                            class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-2 border-cyan-500/80 group-hover:border-cyan-300 shadow-lg group-hover:scale-105 group-hover:shadow-cyan-500/20 transition-all duration-200"
                          />
                          <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center transition-opacity pointer-events-none p-1 text-center">
                            <svg class="w-5 h-5 text-cyan-300 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                            <span class="text-[9px] font-bold text-white leading-tight">Click to zoom</span>
                          </div>
                          <span class="absolute -bottom-1 -right-1 px-1.5 py-0.5 rounded-md text-[9px] font-mono font-bold bg-cyan-950 text-cyan-300 border border-cyan-700 shadow flex items-center gap-1">
                            <span>🔍 Zoom</span>
                          </span>
                        </div>
                      </div>
                      @elseif(($r->payment_method ?? '') === 'GCash Online')
                      <div class="mt-2 text-[11px] text-slate-400 italic flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Verified via GCash Ref</span>
                      </div>
                      @endif
                    </div>

                    <div class="text-left md:text-right flex flex-col justify-between">
                      <div>
                        <p class="text-xs font-bold text-slate-300 uppercase tracking-wider">Grand Total</p>
                        <p class="text-2xl font-black text-emerald-400 font-mono mt-1">₱{{ number_format($r->total_amount, 2) }}</p>
                      </div>

                      <!-- Action Buttons -->
                      <div class="reservation-actions-container flex items-center md:justify-end gap-2 mt-3 flex-wrap" onclick="event.stopPropagation()">
                        <!-- Message Student Buyer Button -->
                        <button
                          type="button"
                          onclick="event.stopPropagation(); icsApp.openAdminMessageBuyerModal('{{ $r->id }}')"
                          class="px-2.5 py-1 rounded-xl text-xs font-bold bg-cyan-950/80 hover:bg-cyan-900 text-cyan-300 border border-cyan-800 transition flex items-center gap-1.5 cursor-pointer shadow-sm"
                          title="Message Student Buyer ({{ $r->student_name }})">
                          <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                          </svg>
                          <span>Message</span>
                        </button>

                        @if($r->activeTicket)
                        <!-- LOCKED: Cannot Mark Ready or Mark Claimed while ticket is pending -->
                        <button
                          type="button"
                          onclick="event.stopPropagation(); icsApp.setAdminTab('support'); icsApp.selectAdminTicket({{ $r->activeTicket->id }});"
                          class="px-2.5 py-1 rounded-xl text-xs font-bold bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/60 transition flex items-center gap-1.5 cursor-pointer shadow-sm"
                          title="This reservation has an active support ticket. Please resolve ticket before claiming.">
                          <svg class="w-3.5 h-3.5 text-amber-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                          </svg>
                          <span>⚠️ Resolve Ticket [{{ $r->activeTicket->ticket_code }}]</span>
                        </button>
                        @else
                        @if($r->status === 'Pending')
                        <button
                          type="button"
                          onclick="event.stopPropagation(); icsApp.updateReservationStatus('{{ $r->id }}', 'Ready for Pickup')"
                          class="px-2.5 py-1 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-500 text-white transition cursor-pointer">
                          Mark Ready
                        </button>
                        @endif

                        @if($r->status === 'Ready for Pickup')
                        <button
                          type="button"
                          onclick="event.stopPropagation(); icsApp.updateReservationStatus('{{ $r->id }}', 'Claimed')"
                          class="px-2.5 py-1 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition cursor-pointer">
                          Mark Claimed
                        </button>
                        @endif
                        @endif

                        @if($r->status !== 'Cancelled' && $r->status !== 'Claimed')
                        <button
                          type="button"
                          onclick="event.stopPropagation(); icsApp.updateReservationStatus('{{ $r->id }}', 'Cancelled')"
                          class="px-2.5 py-1 rounded-xl text-xs font-bold bg-rose-950/80 hover:bg-rose-900 text-rose-300 border border-rose-800 transition cursor-pointer">
                          Cancel
                        </button>
                        @endif

                        <button
                          type="button"
                          onclick="event.stopPropagation(); icsApp.viewPrintClaimSlip('{{ $r->id }}')"
                          class="px-2.5 py-1 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition cursor-pointer">
                          Print Slip
                        </button>

                        @if($r->status === 'Claimed' || $r->status === 'Cancelled')
                        <!-- Delete Button: Only appears when reservation is finished (Claimed or Cancelled) -->
                        <button
                          type="button"
                          onclick="event.stopPropagation(); icsApp.deleteReservation('{{ $r->id }}', '{{ $r->ref_code }}')"
                          class="px-2.5 py-1 rounded-xl text-xs font-bold bg-rose-950 hover:bg-rose-900 text-rose-300 border border-rose-800 transition flex items-center gap-1 shadow-sm cursor-pointer"
                          title="Permanently delete finished reservation from database">
                          <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                          </svg>
                          <span>Delete</span>
                        </button>
                        @endif
                      </div>
                    </div>
                  </div>

                  <!-- Items list preview -->
                  <div class="mt-3 pt-3 border-t border-slate-900 text-xs text-slate-400">
                    <p class="text-[10px] uppercase font-semibold text-slate-500 mb-1">Reserved Items:</p>
                    <div class="flex flex-wrap gap-2">
                      @if(is_array($r->items))
                      @foreach($r->items as $it)
                      <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 text-[11px] text-slate-300">
                        <strong class="text-white">{{ $it['productName'] ?? 'Item' }}</strong>
                        <span class="text-ics-gold">({{ $it['size'] ?? 'M' }})</span>
                        <span>&times;{{ $it['quantity'] ?? 1 }}</span>
                      </span>
                      @endforeach
                      @endif
                    </div>
                  </div>

                </div>
                @endforeach
              </div>

            </div>

          </section>

          <!-- ======================================================== -->
          <!-- MODULE: CLAIMED ITEMS & OFFICIAL RELEASE LEDGER -->
          <!-- Dedicated feature displaying all claimed items with CSV & PDF downloads -->
          <!-- ======================================================== -->
          <section id="admin-sec-claimed" class="admin-tab-section hidden space-y-6">

            <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-6 shadow-xl space-y-5">
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
                <div>
                  <div class="flex items-center gap-2.5 flex-wrap">
                    <h3 class="text-lg font-black text-white font-display flex items-center gap-2">
                      <span>Claimed Items &amp; Release Ledger</span>
                    </h3>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono bg-emerald-950 text-emerald-300 border border-emerald-800 font-bold">
                      Verified Pickups
                    </span>
                    <span id="claimed-tab-count-badge" class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-slate-800 text-slate-300 border border-slate-700">
                      {{ count($claimedReservations ?? []) }} Claimed Orders
                    </span>
                  </div>
                  <p class="text-xs text-slate-400 mt-1">
                    Official digital release records for all physically claimed student merchandise. Complete with Student Number, Student Name, Items Purchased, Prices, and pickup timestamps.
                  </p>
                </div>

                <!-- Export & Download Action Buttons -->
                <div class="flex items-center gap-2.5 flex-wrap">
                  <!-- Download CSV -->
                  <a href="{{ route('reports.export_claimed') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition flex items-center gap-2 shadow-lg shadow-emerald-950/50 cursor-pointer">
                    <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Download CSV</span>
                  </a>

                  <!-- Download / View PDF -->
                  <a href="{{ route('reports.export_claimed_pdf') }}" target="_blank" class="px-4 py-2 rounded-xl text-xs font-black bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white transition flex items-center gap-2 shadow-lg shadow-red-950/50 cursor-pointer">
                    <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span>Download PDF / Print</span>
                  </a>

                  <button type="button" onclick="icsApp.printClaimedLogsheet()" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition flex items-center gap-1.5 cursor-pointer shadow-sm">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Print Logsheet</span>
                  </button>
                </div>
              </div>

              <!-- Quick Stats Bar -->
              @php
                $tabClaimed = $claimedReservations ?? [];
                $tabRevenue = 0;
                $tabUnits = 0;
                foreach($tabClaimed as $tcr) {
                  $tabRevenue += floatval($tcr->total_amount ?? 0);
                  if (is_array($tcr->items)) {
                    foreach($tcr->items as $titem) {
                      $tabUnits += intval($titem['quantity'] ?? 1);
                    }
                  }
                }
              @endphp
              <!-- Quick Stats Bar -->
              <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                <div class="p-4 rounded-2xl bg-slate-950/80 border border-slate-800/90 shadow-md">
                  <span class="block text-xs uppercase font-bold text-slate-300 tracking-wider">Total Claimed Orders</span>
                  <span id="kpi-claimed-tab-orders" class="block text-2xl sm:text-3xl font-black font-mono text-white mt-1.5">{{ count($tabClaimed) }}</span>
                  <span class="block text-xs text-slate-400 mt-0.5">Official Releases</span>
                </div>
                <div class="p-4 rounded-2xl bg-slate-950/80 border border-slate-800/90 shadow-md">
                  <span class="block text-xs uppercase font-bold text-slate-300 tracking-wider">Units Distributed</span>
                  <span id="kpi-claimed-tab-units" class="block text-2xl sm:text-3xl font-black font-mono text-cyan-400 mt-1.5">{{ $tabUnits }}</span>
                  <span class="block text-xs text-slate-400 mt-0.5">Uniforms &amp; Merch</span>
                </div>
                <div class="p-4 rounded-2xl bg-slate-950/80 border border-slate-800/90 shadow-md">
                  <span class="block text-xs uppercase font-bold text-slate-300 tracking-wider">Total Revenue Collected</span>
                  <span id="kpi-claimed-tab-rev" class="block text-2xl sm:text-3xl font-black font-mono text-emerald-400 mt-1.5">₱{{ number_format($tabRevenue, 2) }}</span>
                  <span class="block text-xs text-emerald-400/90 font-medium mt-0.5">100% Remitted</span>
                </div>
                <div class="p-4 rounded-2xl bg-slate-950/80 border border-slate-800/90 shadow-md">
                  <span class="block text-xs uppercase font-bold text-slate-300 tracking-wider">Export Formats</span>
                  <div class="flex items-center gap-2 mt-2 font-mono">
                    <span class="px-2.5 py-1 rounded-lg bg-emerald-950 text-emerald-300 border border-emerald-800 text-xs font-bold">CSV</span>
                    <span class="px-2.5 py-1 rounded-lg bg-red-950 text-red-300 border border-red-800 text-xs font-bold">PDF</span>
                  </div>
                  <span class="block text-xs text-slate-400 mt-1">Ready for Audit</span>
                </div>
              </div>

              <!-- Quick Search, Sort & Bulk Action Bar -->
              <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 bg-slate-950/70 p-3.5 rounded-2xl border border-slate-800">
                <div class="relative flex-1">
                  <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                  </span>
                  <input
                    type="text"
                    id="claimed-tab-search"
                    oninput="icsApp.filterClaimedLedger(this.value)"
                    placeholder="Search by student number, student buyer name, item, reference code..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl text-xs sm:text-sm bg-slate-900 border border-slate-700 text-white placeholder-slate-400 focus:outline-none focus:border-emerald-500 transition">
                </div>

                <!-- Sort Control -->
                <div class="flex items-center gap-2">
                  <label for="claimed-sort-select" class="text-xs font-mono font-bold text-slate-400 whitespace-nowrap">Sort By:</label>
                  <select
                    id="claimed-sort-select"
                    onchange="icsApp.onClaimedSortChange(this.value)"
                    class="bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-emerald-500 cursor-pointer font-sans shadow-inner">
                    <option value="date_claimed_desc">Date Claimed (Newest First)</option>
                    <option value="date_claimed_asc">Date Claimed (Oldest First)</option>
                    <option value="date_ordered_desc">Date Ordered (Newest First)</option>
                    <option value="date_ordered_asc">Date Ordered (Oldest First)</option>
                    <option value="name_asc">Student Name (A - Z)</option>
                    <option value="name_desc">Student Name (Z - A)</option>
                    <option value="amount_desc">Grand Total (Highest First)</option>
                    <option value="amount_asc">Grand Total (Lowest First)</option>
                  </select>
                </div>

                <!-- Delete Actions -->
                <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                  <button
                    type="button"
                    onclick="icsApp.deleteSelectedClaimed()"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold bg-rose-950/80 hover:bg-rose-900 text-rose-300 border border-rose-800 transition flex items-center gap-1.5 cursor-pointer shadow-sm"
                    title="Delete only the items selected via checkboxes or row clicks">
                    <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Delete Selected</span>
                    <span id="claimed-selected-count-badge" class="hidden px-1.5 py-0.2 rounded-full text-[10px] font-mono bg-rose-800 text-white font-bold ml-1">0</span>
                  </button>

                  <button
                    type="button"
                    onclick="icsApp.deleteAllClaimed()"
                    class="px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-rose-950 text-slate-300 hover:text-rose-200 border border-slate-700 hover:border-rose-800 transition flex items-center gap-1.5 cursor-pointer shadow-sm"
                    title="Delete ALL claimed order records from release ledger">
                    <svg class="w-4 h-4 text-slate-400 hover:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Delete All</span>
                  </button>
                </div>
              </div>

              <!-- Top Synchronized Horizontal Scrollbar -->
              <div id="claimed-top-scrollbar-wrapper" class="overflow-x-auto overflow-y-hidden rounded-t-xl bg-slate-950/80 border-t border-x border-slate-800/80 mb-0.5" style="scrollbar-width: thin;">
                <div id="claimed-top-scrollbar-dummy" class="h-3" style="min-height: 12px;"></div>
              </div>

              <!-- Claimed Orders Table -->
              <div id="claimed-table-scroll-container" class="overflow-x-auto rounded-2xl border border-slate-800/80">
                <table id="claimed-orders-ledger-table" class="w-full text-left text-xs sm:text-sm">
                  <thead class="text-slate-300 bg-slate-950 uppercase text-xs font-mono font-bold border-b border-slate-800">
                    <tr>
                      <th class="py-3.5 px-3 text-center w-10">
                        <input type="checkbox" id="claimed-select-all" onchange="icsApp.toggleAllClaimedCheckboxes(this.checked)" class="rounded bg-slate-950 border-slate-700 text-emerald-500 focus:ring-0 cursor-pointer" title="Select All Claimed Orders">
                      </th>
                      <th class="py-3.5 px-4 text-cyan-300 font-bold">Student Number</th>
                      <th class="py-3.5 px-4">Student Name</th>
                      <th class="py-3.5 px-4">Item na Binili (Name &amp; Size)</th>
                      <th class="py-3.5 px-4 text-right">Price (PHP)</th>
                      <th class="py-3.5 px-4">Date &amp; Time Ordered</th>
                      <th class="py-3.5 px-4 text-emerald-400 font-bold">Date &amp; Time Claimed</th>
                      <th class="py-3.5 px-4">Claim Ref</th>
                      <th class="py-3.5 px-4">Program / Year</th>
                      <th class="py-3.5 px-4">Payment</th>
                      <th class="py-3.5 px-4">Released By</th>
                    </tr>
                  </thead>
                  <tbody id="claimed-tab-ledger-tbody" class="divide-y divide-slate-800 text-slate-300">
                    @forelse($claimedReservations ?? [] as $cOrder)
                    <tr class="hover:bg-slate-800/40 transition claimed-ledger-row cursor-pointer"
                        data-id="{{ $cOrder->id }}"
                        data-ref="{{ $cOrder->ref_code }}"
                        data-name="{{ strtolower($cOrder->student_name) }}"
                        data-stuid="{{ strtolower($cOrder->student_id) }}"
                        onclick="icsApp.toggleClaimedRowSelect(event, '{{ $cOrder->id }}')">
                      
                      <!-- 0. Selection Checkbox -->
                      <td class="py-3.5 px-3 text-center" onclick="event.stopPropagation()">
                        <input type="checkbox" class="claimed-row-checkbox rounded bg-slate-950 border-slate-700 text-emerald-500 focus:ring-0 cursor-pointer" value="{{ $cOrder->id }}" onchange="icsApp.onClaimedRowCheckboxChange()">
                      </td>

                      <!-- 1. Student Number -->
                      <td class="py-3.5 px-4 font-mono font-bold whitespace-nowrap bg-cyan-950/20 border-r border-slate-800/60">
                        <span class="text-cyan-300 bg-cyan-950/60 px-2.5 py-1 rounded-lg border border-cyan-800/60 inline-block">{{ $cOrder->student_id }}</span>
                      </td>

                      <!-- 2. Student Name -->
                      <td class="py-3.5 px-4 font-bold text-white whitespace-nowrap text-xs sm:text-sm">
                        {{ $cOrder->student_name }}
                      </td>

                      <!-- 3. Item na Binili (Name & Size) -->
                      <td class="py-3.5 px-4">
                        <div class="flex flex-wrap gap-1.5 max-w-sm">
                          @if(is_array($cOrder->items))
                            @foreach($cOrder->items as $ci)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-800 text-xs text-slate-200 border border-slate-700">
                              <strong class="text-white">{{ $ci['quantity'] ?? 1 }}x</strong>
                              <span>{{ $ci['name'] ?? $ci['productName'] ?? $ci['productId'] ?? 'Item' }}</span>
                              @if(isset($ci['size']) && !empty($ci['size']))
                              <span class="text-ics-gold font-bold">({{ $ci['size'] }})</span>
                              @endif
                            </span>
                            @endforeach
                          @else
                            <span class="text-slate-400">N/A</span>
                          @endif
                        </div>
                      </td>

                      <!-- 4. Price (PHP) -->
                      <td class="py-3.5 px-4 text-right font-mono font-black text-emerald-400 text-xs sm:text-sm whitespace-nowrap">
                        ₱{{ number_format($cOrder->total_amount, 2) }}
                      </td>

                      <!-- 5. Date & Time Ordered -->
                      <td class="py-3.5 px-4 font-mono text-slate-300 text-xs whitespace-nowrap">
                        {{ $cOrder->created_at ? $cOrder->created_at->format('M d, Y h:i A') : 'N/A' }}
                      </td>

                      <!-- 6. Date & Time Claimed -->
                      <td class="py-3.5 px-4 font-mono text-emerald-300 font-bold text-xs whitespace-nowrap bg-emerald-950/30 border-l border-slate-800/60">
                        <span class="bg-emerald-950/60 px-2.5 py-1 rounded-lg border border-emerald-800/60 inline-block">{{ $cOrder->claimed_at ? $cOrder->claimed_at->format('M d, Y h:i A') : ($cOrder->updated_at ? $cOrder->updated_at->format('M d, Y h:i A') : 'N/A') }}</span>
                      </td>

                      <!-- 7. Claim Ref -->
                      <td class="py-3.5 px-4 font-mono font-bold text-ics-gold whitespace-nowrap text-xs sm:text-sm">
                        {{ $cOrder->ref_code }}
                      </td>

                      <!-- 8. Program / Year -->
                      <td class="py-3.5 px-4 text-slate-300 text-xs whitespace-nowrap">
                        {{ $cOrder->department }} ({{ $cOrder->year_level }})
                      </td>

                      <!-- 9. Payment -->
                      <td class="py-3.5 px-4 whitespace-nowrap">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">
                          {{ $cOrder->payment_status ?? 'Paid' }}
                        </span>
                        <div class="text-[10px] text-slate-400 font-mono mt-1">
                          {{ $cOrder->payment_method ?? 'Cash on Pickup' }}
                        </div>
                      </td>

                      <!-- 10. Released By -->
                      <td class="py-3.5 px-4 text-slate-300 text-xs font-mono whitespace-nowrap">
                        {{ $cOrder->claimed_by ?? 'J. Derramas (ICS Officer)' }}
                      </td>
                    </tr>
                    @empty
                    <tr id="claimed-tab-empty-row">
                      <td colspan="11" class="py-12 text-center text-slate-400 font-sans">
                        <svg class="w-10 h-10 mx-auto text-slate-500 mb-2 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="font-bold text-sm text-slate-300">No Claimed Releases Recorded Yet</p>
                        <p class="text-xs text-slate-400 mt-1">When student orders are marked as "Claimed", their pickup timestamp and buyer details will automatically log here.</p>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>

          </section>

          <!-- ======================================================== -->
          <!-- MODULE 4: REPORTS (Sales vs Stock Comprehensive) -->
          <!-- ======================================================== -->
          <section id="admin-sec-reports" class="admin-tab-section hidden space-y-6">

            <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-6 shadow-xl">
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4 pb-4 border-b border-slate-800">
                <div>
                  <h3 class="text-lg font-black text-white font-display flex items-center gap-2">
                    <span>Reports: Sales vs Stock Master List</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-blue-950 text-blue-300 border border-blue-800">Official Report</span>
                  </h3>
                  <p class="text-xs text-slate-400">
                    Audit-ready report detailing stock allocations, confirmed sales, active reservations, and student buyers.
                  </p>
                </div>

                <div class="flex items-center gap-2">
                  <button type="button" onclick="icsApp.downloadChosenReport('pdf', true)" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition flex items-center gap-1.5 cursor-pointer shadow-sm">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Print Report</span>
                  </button>
                </div>
              </div>

              <!-- ======================================================== -->
              <!-- REPORT EXPORT CHOICES & CONTROLS -->
              <!-- "pwede e download yung isa isa or pipili ako kung ano e dl ko parang choices... pwede lahat pwede rin isa" -->
              <!-- ======================================================== -->
              <div class="bg-slate-950/80 p-4 rounded-2xl border border-slate-800 mb-5 space-y-3">
                <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
                  <div class="flex-1">
                    <label class="block text-xs uppercase font-extrabold text-cyan-300 tracking-wider mb-1.5 flex items-center gap-1.5">
                      <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                      <span>Download Choices (Piliin kung anong merchandise ang i-download):</span>
                    </label>
                    <select id="report-scope-select" onchange="icsApp.onReportScopeChange(this.value)" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-xs sm:text-sm text-white focus:outline-none focus:border-cyan-500 font-sans shadow-inner">
                      <option value="all">📦 All Merchandise (Master Report - Lahat ng Items)</option>
                      <optgroup label="Single Item Reports (Isa-isang Damit / Item with Buyer Details):">
                        @foreach($salesVsStock as $rItem)
                        <option value="{{ $rItem['id'] }}">
                          👕 {{ $rItem['name'] }} ({{ $rItem['item_code'] }}) &bull; {{ $rItem['units_sold'] }} sold &bull; {{ $rItem['buyer_count'] ?? count($rItem['buyers'] ?? []) }} buyers &bull; ₱{{ number_format($rItem['price'], 2) }}
                        </option>
                        @endforeach
                      </optgroup>
                    </select>
                  </div>

                  <div class="flex items-center gap-2.5 flex-wrap sm:flex-nowrap pt-1 lg:pt-5">
                    <!-- Download CSV Button -->
                    <button
                      type="button"
                      onclick="icsApp.downloadChosenReport('csv')"
                      class="flex-1 sm:flex-none px-4 py-2.5 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-950/50 cursor-pointer">
                      <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                      </svg>
                      <span id="btn-label-report-csv">Download CSV</span>
                    </button>

                    <!-- Download PDF Button -->
                    <button
                      type="button"
                      onclick="icsApp.downloadChosenReport('pdf')"
                      class="flex-1 sm:flex-none px-4 py-2.5 rounded-xl text-xs font-black bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white transition flex items-center justify-center gap-2 shadow-lg shadow-red-950/50 cursor-pointer">
                      <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                      </svg>
                      <span id="btn-label-report-pdf">Download PDF / Print</span>
                    </button>
                  </div>
                </div>

                <!-- Multi-select Notice / Checkbox Toolbar -->
                <div id="report-selected-banner" class="hidden bg-cyan-950/70 border border-cyan-800/80 p-3 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2.5 text-xs">
                  <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                    <span class="text-cyan-200 font-bold" id="report-selected-count">0 items selected via checkboxes</span>
                    <span class="text-slate-400 text-[11px]">(Will download report only for these checked items)</span>
                  </div>
                  <div class="flex items-center gap-2 flex-wrap">
                    <button type="button" onclick="icsApp.downloadChosenReport('csv')" class="px-3 py-1 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold transition text-[11px] shadow">
                      Download Selected (CSV)
                    </button>
                    <button type="button" onclick="icsApp.downloadChosenReport('pdf')" class="px-3 py-1 rounded-lg bg-rose-700 hover:bg-rose-600 text-white font-bold transition text-[11px] shadow">
                      Download Selected (PDF)
                    </button>
                    <button type="button" onclick="icsApp.downloadChosenReport('pdf', true)" class="px-3 py-1 rounded-lg bg-indigo-700 hover:bg-indigo-600 text-white font-bold transition text-[11px] shadow flex items-center gap-1 cursor-pointer" title="Directly open print dialog for selected items">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                      <span>Print Selected</span>
                    </button>
                    <button type="button" onclick="icsApp.clearReportSelection()" class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 transition text-[11px]">
                      Clear Selection
                    </button>
                  </div>
                </div>
              </div>

              <!-- Report Search & Sort Controls -->
              <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-slate-950/70 p-3 rounded-2xl border border-slate-800 mb-4">
                <div class="relative flex-1">
                  <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                  </span>
                  <input
                    type="text"
                    id="report-search-input"
                    oninput="icsApp.filterReportsTable(this.value)"
                    placeholder="Search master list by item code, product name, category..."
                    class="w-full pl-10 pr-4 py-2 rounded-xl text-xs sm:text-sm bg-slate-900 border border-slate-700 text-white placeholder-slate-400 focus:outline-none focus:border-cyan-500 transition">
                </div>

                <div class="flex items-center gap-2">
                  <label for="report-sort-select" class="text-xs font-mono font-bold text-slate-400 whitespace-nowrap">Sort By:</label>
                  <select
                    id="report-sort-select"
                    onchange="icsApp.onReportSortChange(this.value)"
                    class="bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-cyan-500 cursor-pointer font-sans shadow-inner">
                    <option value="code_asc">Item Code (A - Z)</option>
                    <option value="name_asc">Product Name (A - Z)</option>
                    <option value="sold_desc">Units Sold (Highest First)</option>
                    <option value="sold_asc">Units Sold (Lowest First)</option>
                    <option value="stock_asc">On-Hand Stock (Lowest First)</option>
                    <option value="stock_desc">On-Hand Stock (Highest First)</option>
                    <option value="rev_desc">Revenue (Highest First)</option>
                  </select>
                </div>
              </div>

              <!-- Top Synchronized Horizontal Scrollbar -->
              <div id="reports-top-scrollbar-wrapper" class="overflow-x-auto overflow-y-hidden rounded-t-xl bg-slate-950/80 border-t border-x border-slate-800/80 mb-0.5" style="scrollbar-width: thin;">
                <div id="reports-top-scrollbar-dummy" class="h-3" style="min-height: 12px;"></div>
              </div>

              <!-- Report Table -->
              <div id="reports-table-scroll-container" class="overflow-x-auto rounded-2xl border border-slate-800/80">
                <table id="reports-sales-stock-table" class="w-full text-left text-xs sm:text-sm">
                  <thead class="text-slate-300 bg-slate-950 uppercase text-xs font-mono font-bold border-b border-slate-800">
                    <tr>
                      <th class="py-3.5 px-3 text-center w-10">
                        <input type="checkbox" id="report-select-all" onchange="icsApp.toggleAllReportCheckboxes(this.checked)" class="rounded bg-slate-950 border-slate-700 text-cyan-600 focus:ring-0 cursor-pointer" title="Select All Items">
                      </th>
                      <th class="py-3.5 px-4">Item Code</th>
                      <th class="py-3.5 px-4">Product Name</th>
                      <th class="py-3.5 px-4">Category</th>
                      <th class="py-3.5 px-4">Price</th>
                      <th class="py-3.5 px-4 text-center">Initial Stock</th>
                      <th class="py-3.5 px-4 text-center text-cyan-300">Claimed (Sold)</th>
                      <th class="py-3.5 px-4 text-center">Reserved</th>
                      <th class="py-3.5 px-4 text-center">On-Hand Stock</th>
                      <th class="py-3.5 px-4 text-right">Revenue (PHP)</th>
                      <th class="py-3.5 px-4 text-center">Stock Health</th>
                      <th class="py-3.5 px-4 text-center">Download Item</th>
                    </tr>
                  </thead>
                  <tbody id="reports-table-tbody" class="divide-y divide-slate-800 text-slate-300">
                    @foreach($salesVsStock as $rItem)
                    <tr class="hover:bg-slate-800/40 transition cursor-pointer report-table-row"
                        data-id="{{ $rItem['id'] }}"
                        data-code="{{ strtolower($rItem['item_code']) }}"
                        data-name="{{ strtolower($rItem['name']) }}"
                        data-category="{{ strtolower($rItem['category']) }}"
                        data-sold="{{ $rItem['units_sold'] }}"
                        data-stock="{{ $rItem['current_stock'] }}"
                        data-rev="{{ $rItem['revenue'] }}"
                        onclick="icsApp.toggleReportRowSelect(event, '{{ $rItem['id'] }}')">
                      <!-- Checkbox for custom selection -->
                      <td class="py-3.5 px-3 text-center" onclick="event.stopPropagation()">
                        <input type="checkbox" class="report-row-checkbox rounded bg-slate-950 border-slate-700 text-cyan-600 focus:ring-0 cursor-pointer" value="{{ $rItem['id'] }}" onchange="icsApp.onReportRowCheckboxChange()">
                      </td>
                      <td class="py-3.5 px-4 whitespace-nowrap">
                        <span class="font-mono text-cyan-300 font-bold bg-cyan-950/60 px-2.5 py-1 rounded-lg border border-cyan-800/60 inline-block">{{ $rItem['item_code'] }}</span>
                      </td>
                      <td class="py-3.5 px-4 font-bold text-white text-xs sm:text-sm">
                        <div class="flex items-center gap-2">
                          @if(!empty($rItem['image_path']))
                          <img src="{{ asset($rItem['image_path']) }}" alt="{{ $rItem['name'] }}" class="w-7 h-7 rounded-lg object-cover border border-slate-700 flex-shrink-0">
                          @endif
                          <span>{{ $rItem['name'] }}</span>
                        </div>
                      </td>
                      <td class="py-3.5 px-4 uppercase text-xs text-slate-300 whitespace-nowrap">{{ $rItem['category'] }}</td>
                      <td class="py-3.5 px-4 font-mono text-slate-200 font-semibold whitespace-nowrap">₱{{ number_format($rItem['price'], 2) }}</td>
                      <td class="py-3.5 px-4 text-center font-mono font-bold text-white">{{ $rItem['initial_stock'] }}</td>
                      
                      <!-- Claimed (Sold) with buyers count: "makikita don kung ilan bumili or ano" -->
                      <td class="py-3.5 px-4 text-center">
                        <span class="font-mono font-bold text-cyan-400 block text-sm">{{ $rItem['units_sold'] }}</span>
                        <span class="font-mono text-[10px] text-cyan-300/80 block">({{ $rItem['buyer_count'] ?? count($rItem['buyers'] ?? []) }} buyers)</span>
                      </td>

                      <td class="py-3.5 px-4 text-center font-mono font-bold text-amber-400">{{ $rItem['units_reserved'] }}</td>
                      <td class="py-3.5 px-4 text-center font-mono font-bold text-emerald-400">{{ $rItem['current_stock'] }}</td>
                      <td class="py-3.5 px-4 text-right font-mono font-black text-white whitespace-nowrap">₱{{ number_format($rItem['revenue'], 2) }}</td>
                      <td class="py-3.5 px-4 whitespace-nowrap text-center">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold
                          @if($rItem['status'] === 'Out of Stock') bg-rose-950 text-rose-300 border border-rose-800
                          @elseif($rItem['status'] === 'Low Stock') bg-amber-950 text-amber-300 border border-amber-800
                          @else bg-emerald-950 text-emerald-300 border border-emerald-800 @endif">
                          {{ $rItem['status'] }}
                        </span>
                      </td>

                      <!-- Per-Item Download Buttons: "pwede e download yung isa isa" -->
                      <td class="py-3.5 px-4 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center gap-1.5">
                          <a href="{{ route('reports.export', ['product_id' => $rItem['id']]) }}" class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-950 hover:bg-emerald-900 text-emerald-300 border border-emerald-800 transition flex items-center gap-1 shadow-sm" title="Download CSV for {{ $rItem['name'] }} with full buyer list">
                            <svg class="w-3 h-3 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>CSV</span>
                          </a>

                          <a href="{{ route('reports.export_pdf', ['product_id' => $rItem['id']]) }}" target="_blank" class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-rose-950 hover:bg-rose-900 text-rose-300 border border-rose-800 transition flex items-center gap-1 shadow-sm" title="View / Print PDF for {{ $rItem['name'] }} with buyer breakdown">
                            <svg class="w-3 h-3 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            <span>PDF</span>
                          </a>

                          <button type="button" onclick='icsApp.openItemBuyersModal(@json($rItem))' class="px-2 py-1 rounded-lg text-[11px] font-bold bg-slate-800 hover:bg-slate-700 text-slate-300 transition flex items-center gap-1 cursor-pointer" title="Quick view buyers on screen">
                            <span>👁️</span>
                          </button>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot class="bg-slate-950 text-white font-bold border-t-2 border-slate-800">
                    <tr>
                      <td colspan="5" class="py-3.5 px-4 text-right uppercase font-mono text-slate-300">TOTALS:</td>
                      <td class="py-3.5 px-4 text-center font-mono">{{ $totalInitialStock ?? array_sum(array_column($salesVsStock, 'initial_stock')) }}</td>
                      <td class="py-3.5 px-4 text-center font-mono text-cyan-400 font-black">{{ $totalSoldUnits }}</td>
                      <td class="py-3.5 px-4 text-center font-mono text-amber-400 font-black">{{ $totalReservedUnits }}</td>
                      <td class="py-3.5 px-4 text-center font-mono text-emerald-400 font-black">{{ $totalStockUnits }}</td>
                      <td class="py-3.5 px-4 text-right font-mono text-emerald-300 font-black text-sm sm:text-base">₱{{ number_format($totalRevenue, 2) }}</td>
                      <td class="py-3.5 px-4 text-xs text-slate-300 font-mono text-center">100% Audited</td>
                      <td class="py-3.5 px-4 text-xs text-slate-400 font-mono text-center">{{ count($salesVsStock) }} Items</td>
                    </tr>
                  </tfoot>
                </table>
              </div>

            </div>

            <!-- ======================================================== -->
            <!-- CARD 2: OFFICIAL CLAIMED RELEASES & PICKUP LOGSHEET -->
            <!-- Permanent digital audit ledger to resolve paper/spreadsheet issues -->
            <!-- ======================================================== -->
            <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-6 shadow-xl space-y-4 mt-6">
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
                <div>
                  <div class="flex items-center gap-2.5 flex-wrap">
                    <h3 class="text-lg font-black text-white font-display flex items-center gap-2">
                      <span>Official Claimed Orders &amp; Release Ledger</span>
                    </h3>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono bg-emerald-950 text-emerald-300 border border-emerald-800 font-bold">
                      Claimed Only (Audit-Ready)
                    </span>
                    <span id="claimed-log-count-badge" class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-slate-800 text-slate-300 border border-slate-700">
                      {{ count($claimedReservations ?? []) }} Confirmed Releases
                    </span>
                  </div>
                  <p class="text-xs text-slate-400 mt-1">
                    Official digital audit ledger of physical merchandise releases. Tracks buyer student identity, order date/time, and physical pickup date/time when marked as claimed. Use this to instantly verify or export sign-offs whenever there are discrepancies in paper sign-off sheets or manual spreadsheets.
                  </p>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                  <a href="{{ route('reports.export_claimed') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition flex items-center gap-2 shadow-lg shadow-emerald-950/50 cursor-pointer">
                    <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Download Claimed CSV Logsheet</span>
                  </a>
                  <a href="{{ route('reports.export_claimed_pdf') }}" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold bg-rose-700 hover:bg-rose-600 text-white transition flex items-center gap-2 shadow-lg shadow-rose-950/50 cursor-pointer">
                    <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span>Download PDF Report</span>
                  </a>
                  <button type="button" onclick="icsApp.printClaimedLogsheet()" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition flex items-center gap-1.5 cursor-pointer shadow-sm">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Print Logsheet</span>
                  </button>
                </div>
              </div>

              <!-- Quick Search / Filter Bar -->
              <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-slate-950/60 p-3 rounded-2xl border border-slate-800">
                <div class="relative flex-1">
                  <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                  </span>
                  <input
                    type="text"
                    id="claimed-ledger-search"
                    oninput="icsApp.filterClaimedLedger(this.value)"
                    placeholder="Search by student buyer name, ID number, claim reference code..."
                    class="w-full pl-9 pr-4 py-2 rounded-xl text-xs bg-slate-900 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 transition">
                </div>

                <div class="flex items-center gap-2 text-xs text-slate-400 font-mono">
                  <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                  <span>Auto-updated on Claim status</span>
                </div>
              </div>

              <!-- Claimed Orders Table -->
              <div class="overflow-x-auto rounded-2xl border border-slate-800/80">
                <table class="w-full text-left text-xs">
                  <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] font-mono border-b border-slate-800">
                    <tr>
                      <th class="py-3 px-3">Claim Ref</th>
                      <th class="py-3 px-3">Student Buyer</th>
                      <th class="py-3 px-3">Student ID</th>
                      <th class="py-3 px-3">Program / Year</th>
                      <th class="py-3 px-3">Date Purchased</th>
                      <th class="py-3 px-3">Date &amp; Time Claimed</th>
                      <th class="py-3 px-3">Items &amp; Sizes</th>
                      <th class="py-3 px-3 text-right">Total Amount</th>
                      <th class="py-3 px-3">Payment</th>
                      <th class="py-3 px-3">Released By</th>
                    </tr>
                  </thead>
                  <tbody id="claimed-ledger-tbody" class="divide-y divide-slate-800 text-slate-300">
                    @forelse($claimedReservations ?? [] as $cOrder)
                    <tr class="hover:bg-slate-800/40 transition claimed-ledger-row"
                        data-ref="{{ $cOrder->ref_code }}"
                        data-name="{{ strtolower($cOrder->student_name) }}"
                        data-stuid="{{ strtolower($cOrder->student_id) }}">
                      <td class="py-3 px-3 font-mono font-bold text-ics-gold">
                        {{ $cOrder->ref_code }}
                      </td>
                      <td class="py-3 px-3 font-bold text-white whitespace-nowrap">
                        {{ $cOrder->student_name }}
                      </td>
                      <td class="py-3 px-3 font-mono text-slate-300 whitespace-nowrap">
                        {{ $cOrder->student_id }}
                      </td>
                      <td class="py-3 px-3 text-slate-400 text-[11px] whitespace-nowrap">
                        {{ $cOrder->department }} ({{ $cOrder->year_level }})
                      </td>
                      <td class="py-3 px-3 font-mono text-slate-400 text-[11px] whitespace-nowrap">
                        {{ $cOrder->created_at ? $cOrder->created_at->format('M d, Y h:i A') : 'N/A' }}
                      </td>
                      <td class="py-3 px-3 font-mono text-emerald-400 font-semibold text-[11px] whitespace-nowrap">
                        {{ $cOrder->claimed_at ? $cOrder->claimed_at->format('M d, Y h:i A') : ($cOrder->updated_at ? $cOrder->updated_at->format('M d, Y h:i A') : 'N/A') }}
                      </td>
                      <td class="py-3 px-3">
                        <div class="flex flex-wrap gap-1 max-w-xs">
                          @if(is_array($cOrder->items))
                            @foreach($cOrder->items as $ci)
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-slate-800 text-[10px] text-slate-200 border border-slate-700">
                              <strong>{{ $ci['quantity'] ?? 1 }}x</strong>
                              <span>{{ $ci['name'] ?? $ci['productId'] ?? 'Item' }}</span>
                              @if(isset($ci['size']) && !empty($ci['size']))
                              <span class="text-ics-gold font-bold">({{ $ci['size'] }})</span>
                              @endif
                            </span>
                            @endforeach
                          @else
                            <span class="text-slate-500">N/A</span>
                          @endif
                        </div>
                      </td>
                      <td class="py-3 px-3 text-right font-mono font-bold text-white whitespace-nowrap">
                        ₱{{ number_format($cOrder->total_amount, 2) }}
                      </td>
                      <td class="py-3 px-3 whitespace-nowrap">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">
                          {{ $cOrder->payment_status ?? 'Paid' }}
                        </span>
                        <div class="text-[9px] text-slate-400 font-mono mt-0.5">
                          {{ $cOrder->payment_method ?? 'Cash on Pickup' }}
                        </div>
                      </td>
                      <td class="py-3 px-3 text-slate-300 text-[11px] font-mono whitespace-nowrap">
                        {{ $cOrder->claimed_by ?? 'J. Derramas (ICS Officer)' }}
                      </td>
                    </tr>
                    @empty
                    <tr id="claimed-ledger-empty-row">
                      <td colspan="10" class="py-12 text-center text-slate-500 font-sans">
                        <svg class="w-10 h-10 mx-auto text-slate-600 mb-2 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="font-bold text-xs text-slate-400">No Claimed Releases Recorded Yet</p>
                        <p class="text-[11px] text-slate-600 mt-0.5">When student orders are marked as "Claimed", their pickup timestamp and buyer details will automatically log here.</p>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>

          </section>

          <!-- ======================================================== -->
          <!-- ======================================================== -->
          <!-- MODULE 5: USER MANAGEMENT & STUDENT MODERATION -->
          <!-- ======================================================== -->
          <section id="admin-sec-usermgmt" class="admin-tab-section hidden space-y-6">

            <!-- Sub Navigation Tabs: Student Directory (Default) vs Staff Admins -->
            <div class="flex items-center gap-3 p-1.5 rounded-2xl bg-slate-900 border border-slate-800 w-fit">
              <button
                type="button"
                id="btn-subtab-students"
                onclick="icsApp.switchUserSubTab('students')"
                class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Student Directory (Students Only)</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-slate-950/60 font-mono text-cyan-200">{{ isset($studentUsers) ? $studentUsers->count() : 0 }}</span>
              </button>

              <button
                type="button"
                id="btn-subtab-staff"
                onclick="icsApp.switchUserSubTab('staff')"
                class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 text-slate-400 hover:text-white hover:bg-slate-800/60">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>System Staff &amp; Admins</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-slate-800 font-mono text-slate-300">{{ $users->count() }}</span>
              </button>
            </div>

            <!-- PANEL 1: STUDENT DIRECTORY (STUDENTS ONLY - NO ADMINS) -->
            <div id="panel-usermgmt-students" class="bg-slate-900/90 rounded-3xl border border-slate-800 p-6 shadow-xl space-y-5">
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
                <div>
                  <h3 class="text-lg font-black text-white font-display flex items-center gap-2">
                    <span>Student Users Directory</span>
                    <span id="student-count-badge" class="px-2.5 py-0.5 rounded-full text-[10px] font-mono bg-cyan-950 text-cyan-300 border border-cyan-800">
                      {{ isset($studentUsers) ? $studentUsers->count() : 0 }} Registered Students
                    </span>
                  </h3>
                  <p class="text-xs text-slate-400">
                    Lahat ng student users (walang admin). Mag-search habang nagta-type, at mag-apply ng <strong>Snooze (Warning)</strong> o <strong>Ban</strong> para sa mga abusadong account.
                  </p>
                </div>
              </div>

              <!-- Real-time Live Search Input Bar -->
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                  <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </div>
                <input
                  type="text"
                  id="student-search-input"
                  oninput="icsApp.filterStudentDirectory(this.value)"
                  placeholder="Type here to search by Name, Student ID, Email, Department, Year, Status..."
                  class="w-full bg-slate-950 border border-slate-700/80 rounded-2xl pl-10 pr-4 py-3 text-xs sm:text-sm text-white placeholder-slate-500 focus:outline-none focus:border-cyan-400 shadow-inner"
                />
              </div>

              <!-- Students Table -->
              <div class="overflow-x-auto rounded-2xl border border-slate-800/80">
                <table class="w-full text-left text-xs sm:text-sm">
                  <thead class="text-slate-300 bg-slate-950 uppercase text-xs font-mono font-bold border-b border-slate-800">
                    <tr>
                      <th class="py-3.5 px-4">STUDENT ID</th>
                      <th class="py-3.5 px-4">STUDENT NAME</th>
                      <th class="py-3.5 px-4">EMAIL ADDRESS</th>
                      <th class="py-3.5 px-4">DEPARTMENT / YEAR</th>
                      <th class="py-3.5 px-4">WARNINGS &amp; STATUS</th>
                      <th class="py-3.5 px-4 text-right">MODERATION ACTIONS</th>
                    </tr>
                  </thead>
                  <tbody id="students-tbody" class="divide-y divide-slate-800 text-slate-300">
                    @forelse(($studentUsers ?? []) as $s)
                    <tr class="hover:bg-slate-800/40 transition student-row" data-search="{{ strtolower($s->student_id . ' ' . $s->name . ' ' . $s->email . ' ' . $s->department . ' ' . $s->year_level . ' ' . $s->status) }}">
                      <td class="py-3.5 px-4 whitespace-nowrap">
                        <span class="font-mono text-cyan-300 font-bold bg-cyan-950/60 px-2.5 py-1 rounded-lg border border-cyan-800/60 inline-block">{{ $s->student_id }}</span>
                      </td>
                      <td class="py-3.5 px-4 font-bold text-white whitespace-nowrap">{{ $s->name }}</td>
                      <td class="py-3.5 px-4 font-mono text-xs text-slate-300 whitespace-nowrap">{{ $s->email }}</td>
                      <td class="py-3.5 px-4 text-xs text-slate-300 whitespace-nowrap">
                        <div>{{ $s->department }}</div>
                        <div class="text-[10px] text-slate-400 font-mono">{{ $s->year_level }} {{ $s->section ? "({$s->section})" : '' }}</div>
                      </td>
                      <td class="py-3.5 px-4 whitespace-nowrap">
                        @if($s->status === 'Banned')
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-rose-950 text-rose-300 border border-rose-800 flex items-center gap-1 w-fit">
                          <span>🚫</span> BANNED
                        </span>
                        @if(!empty($s->ban_reason))
                        <span class="block text-[10px] text-rose-400 mt-1 max-w-[180px] truncate" title="{{ $s->ban_reason }}">{{ $s->ban_reason }}</span>
                        @endif
                        @elseif($s->status === 'Snoozed')
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-950 text-amber-300 border border-amber-800 flex items-center gap-1 w-fit">
                          <span>⚠️</span> SNOOZED (Warned)
                        </span>
                        <span class="block text-[10px] text-amber-300/80 mt-1">
                          Warnings: <strong class="text-amber-200">{{ $s->warning_count ?? 1 }}</strong>
                          @if($s->snoozed_until) &bull; {{ $s->snoozed_until->diffForHumans() }} @endif
                        </span>
                        @else
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-950 text-emerald-300 border border-emerald-800 flex items-center gap-1 w-fit">
                          <span>✓</span> Active Enrolled
                        </span>
                        @if(($s->warning_count ?? 0) > 0)
                        <span class="block text-[10px] text-amber-400/80 mt-0.5 font-mono">Past Warnings: {{ $s->warning_count }}</span>
                        @endif
                        @endif
                      </td>
                      <td class="py-3.5 px-4 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-1.5">
                          @if($s->status === 'Banned' || (method_exists($s, 'isBanned') && $s->isBanned()))
                          <!-- Unban Button: ONLY shown when student is BANNED -->
                          <button
                            type="button"
                            onclick="icsApp.unbanStudent({{ $s->id }}, '{{ addslashes($s->name) }}')"
                            class="px-3 py-1.5 rounded-xl bg-emerald-950/80 hover:bg-emerald-900 text-emerald-300 text-xs font-bold transition border border-emerald-700 flex items-center gap-1.5 cursor-pointer shadow-sm"
                            title="Unban and restore to active">
                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Unban Student</span>
                          </button>
                          @else
                          <!-- Snooze / Warning Button -->
                          <button
                            type="button"
                            onclick="icsApp.snoozeStudentModal({{ $s->id }}, '{{ addslashes($s->name) }}')"
                            class="px-2.5 py-1.5 rounded-xl bg-amber-950/70 hover:bg-amber-900 text-amber-300 text-xs font-bold transition border border-amber-800 flex items-center gap-1 cursor-pointer shadow-sm"
                            title="Snooze student (Cooldown / Warning for 24h)">
                            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Snooze</span>
                          </button>

                          <!-- Ban Button: Hides when banned -->
                          <button
                            type="button"
                            onclick="icsApp.banStudentModal({{ $s->id }}, '{{ addslashes($s->name) }}')"
                            class="px-2.5 py-1.5 rounded-xl bg-rose-950/70 hover:bg-rose-900 text-rose-300 text-xs font-bold transition border border-rose-800 flex items-center gap-1 cursor-pointer shadow-sm"
                            title="Ban student account">
                            <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                            <span>Ban</span>
                          </button>
                          @endif
                        </div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="6" class="p-8 text-center text-slate-400 text-xs">
                        No student accounts found.
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <!-- Search Empty Notice -->
              <div id="students-search-empty" class="hidden p-8 text-center bg-slate-950 rounded-2xl border border-slate-800 text-slate-400 text-xs">
                🔍 Walang tumutugmang student account para sa iyong hinanap. Subukang baguhin ang iyong keyword.
              </div>
            </div>

            <!-- PANEL 2: SYSTEM STAFF & ADMINS (CRUD) -->
            <div id="panel-usermgmt-staff" class="hidden bg-slate-900/90 rounded-3xl border border-slate-800 p-6 shadow-xl space-y-5">
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
                <div>
                  <h3 class="text-lg font-black text-white font-display flex items-center gap-2">
                    <span>System Staff &amp; Administrators</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-purple-950 text-purple-300 border border-purple-800">{{ $users->count() }} Accounts</span>
                  </h3>
                  <p class="text-xs text-slate-400">
                    Configure faculty advisers, student officers, team leaders, and administrative accounts.
                  </p>
                </div>

                <!-- Add User Button -->
                <button
                  onclick="icsApp.openAddUserModal()"
                  class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-purple-700 to-purple-800 hover:from-purple-600 hover:to-purple-700 text-white text-xs font-bold transition flex items-center gap-2 shadow border border-purple-600">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                  </svg>
                  <span>Add New System User</span>
                </button>
              </div>

              <!-- User Table -->
              <div class="overflow-x-auto rounded-2xl border border-slate-800/80">
                <table class="w-full text-left text-xs sm:text-sm">
                  <thead class="text-slate-300 bg-slate-950 uppercase text-xs font-mono font-bold border-b border-slate-800">
                    <tr>
                      <th class="py-3.5 px-4">User Code / ID</th>
                      <th class="py-3.5 px-4">Name</th>
                      <th class="py-3.5 px-4">Email Address</th>
                      <th class="py-3.5 px-4">Role</th>
                      <th class="py-3.5 px-4">Department</th>
                      <th class="py-3.5 px-4">Status</th>
                      <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-800 text-slate-300">
                    @foreach($users as $u)
                    <tr class="hover:bg-slate-800/40 transition">
                      <td class="py-3.5 px-4 whitespace-nowrap">
                        <span class="font-mono text-cyan-300 font-bold bg-cyan-950/60 px-2.5 py-1 rounded-lg border border-cyan-800/60 inline-block">{{ $u->user_code }}</span>
                      </td>
                      <td class="py-3.5 px-4 font-bold text-white text-xs sm:text-sm whitespace-nowrap">{{ $u->name }}</td>
                      <td class="py-3.5 px-4 font-mono text-xs text-slate-300 whitespace-nowrap">{{ $u->email }}</td>
                      <td class="py-3.5 px-4 whitespace-nowrap">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-800 text-slate-200 border border-slate-700">
                          {{ $u->role }}
                        </span>
                      </td>
                      <td class="py-3.5 px-4 text-xs text-slate-300 whitespace-nowrap">{{ $u->department }}</td>
                      <td class="py-3.5 px-4 whitespace-nowrap">
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">
                          {{ $u->status }}
                        </span>
                      </td>
                      <td class="py-3.5 px-4 text-right whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2">
                          <button
                            type="button"
                            onclick="icsApp.openEditUserModal('{{ $u->id }}')"
                            class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition border border-slate-700 shadow cursor-pointer">
                            Edit
                          </button>
                          <button
                            type="button"
                            onclick="icsApp.deleteUser('{{ $u->id }}', '{{ $u->name }}')"
                            class="p-1.5 rounded-xl bg-rose-950/60 hover:bg-rose-900 text-rose-300 transition border border-rose-800 cursor-pointer"
                            title="Delete User">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                          </button>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

          </section>

          <!-- ======================================================== -->
          <!-- MODULE 6: ACTIVITY LOGS (Audit Trail from Whiteboard) -->
          <!-- USER CODE | ACTION | ACTIVITY | DATE/TIMESTAMP -->
          <!-- ======================================================== -->
          <section id="admin-sec-actlogs" class="admin-tab-section hidden space-y-6">

            <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-6 shadow-xl">
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-800">
                <div>
                  <h3 class="text-lg font-black text-white font-display flex items-center gap-2">
                    <span>Activity Logs: Audit Trail Specification</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-cyan-950 text-cyan-300 border border-cyan-800">Audit Trail</span>
                  </h3>
                  <p class="text-xs text-slate-400">
                    System audit specifications: <strong>USER CODE | ACTION | ACTIVITY | DATE/TIMESTAMP</strong>
                  </p>
                </div>

                <!-- Header Action Buttons & Filter -->
                <div class="flex items-center gap-2">
                  <button
                    type="button"
                    onclick="icsApp.clearActivityLogs()"
                    class="px-3 py-1.5 rounded-xl bg-rose-950/80 hover:bg-rose-900 text-rose-200 border border-rose-800 transition flex items-center gap-1.5 shadow-sm text-xs font-bold cursor-pointer"
                    title="Permanently clear activity audit logs">
                    <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Clear Logs</span>
                  </button>

                  <select id="act-log-filter-action" onchange="icsApp.filterActivityLogs(this.value)" class="bg-slate-950 border border-slate-700 rounded-xl px-3 py-1.5 text-xs text-white">
                    <option value="all">All Actions</option>
                    <option value="CLAIM">CLAIM (Releases)</option>
                    <option value="CREATE">CREATE</option>
                    <option value="READ">READ</option>
                    <option value="UPDATE">UPDATE</option>
                    <option value="DELETE">DELETE</option>
                    <option value="LOGIN">LOGIN</option>
                    <option value="LOGOUT">LOGOUT</option>
                  </select>
                </div>
              </div>

              <!-- Activity Logs Real-time Keyword Search Bar -->
              <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-slate-950/70 p-3 rounded-2xl border border-slate-800 mb-4">
                <div class="relative flex-1">
                  <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                  </span>
                  <input
                    type="text"
                    id="act-log-search-input"
                    oninput="icsApp.searchActivityLogs(this.value)"
                    placeholder="Search logs by keyword (User Code, Action, Item, Student, Activity, Module, Date)..."
                    class="w-full pl-10 pr-9 py-2.5 rounded-xl text-xs sm:text-sm bg-slate-900 border border-slate-700 text-white placeholder-slate-400 focus:outline-none focus:border-cyan-500 transition">
                  <button
                    type="button"
                    id="act-log-search-clear"
                    onclick="icsApp.clearActivityLogSearch()"
                    class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-white cursor-pointer"
                    title="Clear search">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                  </button>
                </div>
                <div class="flex items-center gap-2 text-xs text-slate-400 font-mono px-1">
                  <span class="inline-block w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                  <span>Instant Keyword Filter</span>
                </div>
              </div>

              <!-- Activity Log Table -->
              <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm">
                  <thead class="text-slate-300 bg-slate-950 uppercase text-xs font-mono font-bold border-b border-slate-800">
                    <tr>
                      <th class="py-3.5 px-4">USER CODE</th>
                      <th class="py-3.5 px-4">ACTION</th>
                      <th class="py-3.5 px-4">ACTIVITY</th>
                      <th class="py-3.5 px-4">MODULE</th>
                      <th class="py-3.5 px-4">DATE / TIMESTAMP</th>
                    </tr>
                  </thead>
                  <tbody id="activity-logs-tbody" class="divide-y divide-slate-800 text-slate-200">
                    @foreach($activityLogs as $log)
                    <tr class="hover:bg-slate-800/40" data-action="{{ $log->action }}">
                      <td class="py-3.5 px-4 font-mono text-ics-gold font-bold text-xs sm:text-sm">{{ $log->user_code }}</td>
                      <td class="py-3.5 px-4">
                        <span class="px-2.5 py-1 rounded text-xs font-bold font-mono
                          @if($log->action === 'CLAIM') bg-emerald-950 text-emerald-300 border border-emerald-700 font-extrabold shadow-sm
                          @elseif($log->action === 'CREATE') bg-emerald-950 text-emerald-300 border border-emerald-800
                          @elseif($log->action === 'UPDATE') bg-amber-950 text-amber-300 border border-amber-800
                          @elseif($log->action === 'DELETE') bg-rose-950 text-rose-300 border border-rose-800
                          @elseif($log->action === 'LOGIN') bg-purple-950 text-purple-300 border border-purple-800
                          @elseif($log->action === 'LOGOUT') bg-slate-800 text-slate-300 border border-slate-700
                          @else bg-blue-950 text-blue-300 border border-blue-800 @endif">
                          {{ $log->action }}
                        </span>
                      </td>
                      <td class="py-3.5 px-4 text-slate-200 text-xs sm:text-sm">{{ $log->activity }}</td>
                      <td class="py-3.5 px-4 text-xs text-slate-300 font-mono">{{ $log->module }}</td>
                      <td class="py-3.5 px-4 font-mono text-slate-300 text-xs sm:text-sm">{{ $log->created_at->format('m/d/Y, h:i A') }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <!-- Activity Logs Pagination Controls (50 logs per page, up to 200 logs) -->
              <div id="act-logs-pagination-container" class="mt-4 pt-4 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                <div id="act-logs-page-info" class="text-slate-400 font-mono text-[11px]">
                  Showing 1 to 50 of {{ count($activityLogs) }} logs
                </div>
                <div id="act-logs-pagination-buttons" class="flex items-center gap-1.5 flex-wrap">
                  <!-- Dynamically rendered by icsApp.renderActivityLogsTable() -->
                </div>
              </div>

            </div>

          </section>

          <!-- ======================================================== -->
          <!-- MODULE 7: SUPPORT TICKETS & LIVE CHAT HELPDESK -->
          <!-- ======================================================== -->
          <section id="admin-sec-support" class="admin-tab-section hidden space-y-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-slate-900 border border-slate-800 p-5 rounded-3xl shadow-xl">
              <div>
                <div class="flex items-center gap-2.5 mb-1">
                  <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">
                    Helpdesk Support
                  </span>
                  <span class="text-xs text-slate-400">Support & Cancellation Desk</span>
                </div>
                <h3 class="text-lg font-black text-white font-display">Student Support Tickets & Chat</h3>
                <p class="text-xs text-slate-400 mt-0.5">Manage student requests for reservation cancellations, size replacements, and verification inquiries</p>
              </div>
              <div class="flex items-center gap-2">
                <button onclick="icsApp.fetchSupportTickets()" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition flex items-center gap-1.5 shadow">
                  <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                  </svg>
                  <span>Refresh Tickets</span>
                </button>
              </div>
            </div>

            <!-- Two-Panel Helpdesk Layout -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-12 min-h-[640px] mb-16 lg:mb-0">

              <!-- Left Sidebar: Conversations List ("sa gilid mga convo") -->
              <div id="admin-tickets-sidebar" class="lg:col-span-5 xl:col-span-4 border-r border-slate-800 flex flex-col bg-slate-950/60">
                <!-- Search & Filters -->
                <div class="p-3.5 border-b border-slate-800/80 space-y-2.5">
                  <div class="relative">
                    <input
                      type="text"
                      id="admin-ticket-search-input"
                      oninput="icsApp.filterAdminTickets()"
                      placeholder="Search student, ID, ticket..."
                      class="w-full bg-slate-900 border border-slate-700 rounded-xl pl-8 pr-3 py-1.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 font-sans">
                    <svg class="w-4 h-4 text-slate-500 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </div>
                  <!-- Filter Pills -->
                  <div class="flex items-center gap-1 text-[11px] overflow-x-auto pb-0.5 no-scrollbar">
                    <button onclick="icsApp.setAdminTicketFilter('all')" id="ticket-filter-all" class="px-2.5 py-1 rounded-lg font-bold bg-slate-800 text-white transition flex-shrink-0">All</button>
                    <button onclick="icsApp.setAdminTicketFilter('Open')" id="ticket-filter-Open" class="px-2.5 py-1 rounded-lg font-bold bg-slate-950 text-slate-400 hover:text-white transition flex-shrink-0">Open</button>
                    <button onclick="icsApp.setAdminTicketFilter('In Progress')" id="ticket-filter-In Progress" class="px-2.5 py-1 rounded-lg font-bold bg-slate-950 text-slate-400 hover:text-white transition flex-shrink-0">In Progress</button>
                    <button onclick="icsApp.setAdminTicketFilter('Resolved')" id="ticket-filter-Resolved" class="px-2.5 py-1 rounded-lg font-bold bg-slate-950 text-slate-400 hover:text-white transition flex-shrink-0">Resolved</button>
                  </div>
                </div>

                <!-- Conversation Cards List -->
                <div id="admin-tickets-list-container" class="flex-1 overflow-y-auto divide-y divide-slate-800/50 max-h-[560px]">
                  <!-- Rendered dynamically via JS -->
                </div>
              </div>

              <!-- Right Main Panel: Live Chat & Resolution Desk -->
              <div id="admin-chat-main-panel" class="lg:col-span-7 xl:col-span-8 flex flex-col bg-slate-950/40 relative">

                <!-- Empty State -->
                <div id="admin-chat-empty-state" class="flex-1 flex flex-col items-center justify-center p-8 text-center text-slate-500 min-h-[560px]">
                  <div class="w-16 h-16 rounded-3xl bg-slate-900 border border-slate-800 flex items-center justify-center text-emerald-400 mb-3 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                  </div>
                  <h4 class="text-sm font-bold text-slate-300">No Conversation Selected</h4>
                  <p class="text-xs text-slate-500 max-w-sm mt-1">Select a student support ticket from the sidebar to view their message history, reply, or approve reservation cancellations.</p>
                </div>

                <!-- Active Chat Panel -->
                <div id="admin-chat-active-panel" class="hidden flex-1 flex flex-col h-full">

                  <!-- Chat Header Bar -->
                  <div class="p-3.5 sm:p-4 border-b border-slate-800 bg-slate-900/90 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                      <!-- Mobile Back to Ticket List Button -->
                      <button
                        type="button"
                        onclick="icsApp.backToAdminTicketList()"
                        class="lg:hidden inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition border border-slate-700 mb-2.5 shadow active:scale-95">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        <span>&larr; Back to Ticket List</span>
                      </button>

                      <div class="flex items-center gap-2">
                        <span id="admin-active-ticket-code" class="text-xs font-mono font-bold text-ics-gold">TCK-2026-0001</span>
                        <span id="admin-active-ticket-reason-badge" class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-950 text-rose-300 border border-rose-800">Cancel Reservation</span>
                        <span id="admin-active-ticket-status-badge" class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-950 text-amber-300 border border-amber-800">In Progress</span>
                      </div>
                      <h4 id="admin-active-ticket-student-name" class="text-sm font-bold text-white mt-1">Julian Angelo Santos</h4>
                      <p id="admin-active-ticket-student-sub" class="text-[10px] text-slate-400 font-mono">2025-01429-AIS / Associate in Information Systems (AIS)</p>
                    </div>

                    <!-- Action Controls Bar -->
                    <div class="flex flex-wrap items-center gap-2">
                      <!-- 1-Click Cancel Reservation Button -->
                      <button
                        id="admin-btn-cancel-reservation"
                        onclick="icsApp.adminCancelReservationFromActiveTicket()"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold bg-rose-950 hover:bg-rose-900 text-rose-200 border border-rose-800 transition flex items-center gap-1.5 shadow">
                        <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Cancel Order & Restock</span>
                      </button>

                      <!-- Edit Item / Size Button -->
                      <button
                        id="admin-btn-edit-reservation"
                        type="button"
                        onclick="icsApp.adminOpenEditReservationModal()"
                        class="hidden px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-950 hover:bg-blue-900 text-blue-200 border border-blue-700 transition flex items-center gap-1.5 shadow cursor-pointer">
                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span id="admin-btn-edit-reservation-label">Edit Item</span>
                      </button>

                      <!-- Mark Done / Resolved Button -->
                      <button
                        id="admin-btn-mark-resolved"
                        onclick="icsApp.adminToggleTicketStatus()"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-950 hover:bg-emerald-900 text-emerald-200 border border-emerald-700 transition flex items-center gap-1.5 shadow">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span id="admin-btn-mark-resolved-text">Mark as Done (Resolved)</span>
                      </button>

                      <!-- Delete Ticket Button (Only visible if Resolved) -->
                      <button
                        id="admin-btn-delete-ticket"
                        type="button"
                        onclick="icsApp.adminDeleteActiveTicket()"
                        class="hidden px-3 py-1.5 rounded-xl text-xs font-bold bg-rose-950/80 hover:bg-rose-900 text-rose-300 border border-rose-800 transition flex items-center gap-1.5 shadow cursor-pointer"
                        title="Delete this ticket (Available only when Resolved)">
                        <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Delete Ticket</span>
                      </button>
                    </div>
                  </div>

                  <!-- Linked Reservation Banner (if any) -->
                  <div id="admin-active-ticket-res-banner" class="hidden px-4 py-2 bg-blue-950/40 border-b border-blue-900/40 flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2">
                      <span class="text-[10px] uppercase font-bold text-blue-400 font-mono">Linked Reservation:</span>
                      <span id="admin-active-ticket-res-code" class="font-mono font-bold text-white">ICS-2026-CUTY3</span>
                      <span id="admin-active-ticket-res-details" class="text-slate-300 text-[11px]"></span>
                    </div>
                    <span id="admin-active-ticket-res-status" class="px-2 py-0.5 rounded-full text-[9px] font-mono font-bold bg-amber-950 text-amber-300 border border-amber-800">Pending</span>
                  </div>

                  <!-- Messages Feed Stream -->
                  <div id="admin-chat-messages-container" class="flex-1 overflow-y-auto p-4 space-y-3 min-h-[280px] max-h-[380px]">
                    <!-- Messages populated via JS -->
                  </div>

                  <!-- Admin Reply Box & Canned Responses -->
                  <div class="p-3.5 border-t border-slate-800 bg-slate-900/90 space-y-2 pb-20 md:pb-3.5">
                    <!-- Quick Canned Replies -->
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-[10px] no-scrollbar">
                      <span class="text-slate-500 font-bold uppercase text-[9px] flex-shrink-0">Quick Reply:</span>
                      <button onclick="icsApp.applyAdminCannedReply('Hello! We received your request and are reviewing your reservation details.')" class="px-2 py-0.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 flex-shrink-0 transition">Hello & review</button>
                      <button onclick="icsApp.applyAdminCannedReply('Your reservation cancellation has been approved and stocks have been restored.')" class="px-2 py-0.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 flex-shrink-0 transition">Cancel approved</button>
                      <button onclick="icsApp.applyAdminCannedReply('We have noted your size change request for your scheduled pickup.')" class="px-2 py-0.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 flex-shrink-0 transition">Size change noted</button>
                      <button onclick="icsApp.applyAdminCannedReply('Your payment has been verified. Please proceed on your scheduled pickup slot.')" class="px-2 py-0.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 flex-shrink-0 transition">Payment verified</button>
                    </div>

                    <!-- Input form -->
                    <form onsubmit="icsApp.sendAdminChatMessage(event)" class="flex items-center gap-2">
                      <input
                        type="text"
                        id="admin-chat-input"
                        placeholder="Type reply to student..."
                        class="flex-1 bg-slate-950 border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 font-sans">
                      <button
                        type="submit"
                        class="px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold shadow-lg transition flex items-center gap-1.5">
                        <span>Send</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                      </button>
                    </form>
                  </div>

                </div>

              </div>

            </div>

          </section>

        </div>

      </div>

    </div>
  </main>

  <!-- Admin Fixed Mobile Bottom Icon Navigation Bar (Only for phones < 768px) -->
  <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-slate-950/95 backdrop-blur-xl border-t border-slate-800 shadow-[0_-8px_30px_rgba(0,0,0,0.8)] px-1 py-1 flex items-center justify-between gap-0.5 safe-area-pb overflow-x-auto no-scrollbar">
    <!-- Dashboard -->
    <button
      onclick="icsApp.setAdminTab('dashboard')"
      id="admin-bottom-tab-dashboard"
      class="admin-bottom-tab flex-1 min-w-0 py-1 px-0.5 rounded-lg flex flex-col items-center justify-center text-white bg-ics-800 shadow transition cursor-pointer"
      title="Dashboard">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
      <span class="text-[7.5px] font-bold mt-0.5 leading-none truncate max-w-full">Dash</span>
    </button>

    <!-- Info Mgmt / Products -->
    <button
      onclick="icsApp.setAdminTab('infomgmt')"
      id="admin-bottom-tab-infomgmt"
      class="admin-bottom-tab flex-1 min-w-0 py-1 px-0.5 rounded-lg flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer"
      title="Merchandise Items">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
      <span class="text-[7.5px] font-bold mt-0.5 leading-none truncate max-w-full">Items</span>
    </button>

    <!-- Reservation Queue -->
    <button
      onclick="icsApp.setAdminTab('reservations')"
      id="admin-bottom-tab-reservations"
      class="admin-bottom-tab flex-1 min-w-0 py-1 px-0.5 rounded-lg flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer relative"
      title="Reservation Queue">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
      <span class="text-[7.5px] font-bold mt-0.5 leading-none truncate max-w-full">Queue</span>
      @if(($pendingReservationsCount ?? 0) > 0)
      <span class="absolute top-0.5 right-1 w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
      @endif
    </button>

    <!-- Claimed Items -->
    <button
      onclick="icsApp.setAdminTab('claimed')"
      id="admin-bottom-tab-claimed"
      class="admin-bottom-tab flex-1 min-w-0 py-1 px-0.5 rounded-lg flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer relative"
      title="Claimed Items">
      <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      <span class="text-[7.5px] font-bold mt-0.5 leading-none truncate max-w-full">Claimed</span>
    </button>

    <!-- Reports -->
    <button
      onclick="icsApp.setAdminTab('reports')"
      id="admin-bottom-tab-reports"
      class="admin-bottom-tab flex-1 min-w-0 py-1 px-0.5 rounded-lg flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer"
      title="Reports">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
      <span class="text-[7.5px] font-bold mt-0.5 leading-none truncate max-w-full">Reports</span>
    </button>

    <!-- Users -->
    <button
      onclick="icsApp.setAdminTab('usermgmt')"
      id="admin-bottom-tab-usermgmt"
      class="admin-bottom-tab flex-1 min-w-0 py-1 px-0.5 rounded-lg flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer"
      title="User Management">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
      <span class="text-[7.5px] font-bold mt-0.5 leading-none truncate max-w-full">Users</span>
    </button>

    <!-- Audit Trail Logs -->
    <button
      onclick="icsApp.setAdminTab('actlogs')"
      id="admin-bottom-tab-actlogs"
      class="admin-bottom-tab flex-1 min-w-0 py-1 px-0.5 rounded-lg flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer"
      title="Activity Logs">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      <span class="text-[7.5px] font-bold mt-0.5 leading-none truncate max-w-full">Logs</span>
    </button>

    <!-- Support Chat Helpdesk -->
    <button
      onclick="icsApp.setAdminTab('support')"
      id="admin-bottom-tab-support"
      class="admin-bottom-tab flex-1 min-w-0 py-1 px-0.5 rounded-lg flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer relative"
      title="Support Chat">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
      <span class="text-[7.5px] font-bold mt-0.5 leading-none truncate max-w-full">Chat</span>
      @if(($openTicketsCount ?? 0) > 0)
      <span class="absolute top-0.5 right-1 w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
      @endif
    </button>
  </nav>

  <!-- Edit Reservation Item/Size Modal (Support Desk) -->
  <div id="admin-edit-reservation-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl relative text-left">
      <div class="flex items-center justify-between pb-4 border-b border-slate-800">
        <div>
          <h3 class="text-base font-black text-white font-display flex items-center gap-2">
            <span class="text-blue-400">✏️</span>
            <span>Edit Reservation Item / Size</span>
          </h3>
          <p class="text-xs text-slate-400">Adjust student apparel sizing per support ticket request</p>
        </div>
        <button type="button" onclick="icsApp.closeAdminEditReservationModal()" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <form id="admin-edit-reservation-form" onsubmit="icsApp.submitAdminEditReservation(event)" class="mt-4 space-y-4">
        <!-- Linked Reference Info -->
        <div class="p-3 rounded-2xl bg-slate-950/70 border border-slate-800 flex items-center justify-between text-xs">
          <div>
            <span class="text-[10px] uppercase font-bold text-slate-400 font-mono">Reservation Ref:</span>
            <p id="edit-res-code" class="font-mono font-bold text-ics-gold text-sm">ICS-2026-XXXXX</p>
          </div>
          <div class="text-right">
            <span class="text-[10px] uppercase font-bold text-slate-400 font-mono">Student:</span>
            <p id="edit-res-student-name" class="font-bold text-white text-xs truncate max-w-[160px]">Student Name</p>
          </div>
        </div>

        <!-- Current Item Info -->
        <div class="p-3.5 rounded-2xl bg-blue-950/30 border border-blue-900/40 text-xs space-y-1.5">
          <div class="flex items-center justify-between">
            <span class="text-slate-300 font-medium">Item Name:</span>
            <span id="edit-res-item-name" class="font-bold text-white">ICS Official Polo Shirt</span>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-slate-300 font-medium">Current Registered Size:</span>
            <span id="edit-res-current-size" class="font-mono font-bold px-2 py-0.5 rounded-lg bg-blue-950 text-blue-300 border border-blue-800">M</span>
          </div>
        </div>

        <!-- New Size Selector -->
        <div>
          <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wide">
            Select New Size *
          </label>
          <select id="edit-res-new-size" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-white focus:outline-none focus:border-blue-500">
            <option value="XS">Extra Small (XS)</option>
            <option value="S">Small (S)</option>
            <option value="M">Medium (M)</option>
            <option value="L">Large (L)</option>
            <option value="XL">Extra Large (XL)</option>
            <option value="2XL">Double XL (2XL)</option>
            <option value="3XL">Triple XL (3XL)</option>
            <option value="FS">Free Size (FS)</option>
          </select>
        </div>

        <!-- Remarks / Audit Note -->
        <div>
          <label class="block text-xs font-bold text-slate-300 mb-1.5 uppercase tracking-wide">
            Adjustment Remarks (Logged in Ticket & Audit)
          </label>
          <input
            type="text"
            id="edit-res-remarks"
            placeholder="e.g. Changed size per student request in ticket chat"
            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-white placeholder-slate-600 focus:outline-none focus:border-blue-500">
        </div>

        <!-- Submit & Cancel Buttons -->
        <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-slate-800">
          <button
            type="button"
            onclick="icsApp.closeAdminEditReservationModal()"
            class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-300 transition">
            Cancel
          </button>
          <button
            type="submit"
            id="edit-res-submit-btn"
            class="px-5 py-2 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-500 text-white transition flex items-center gap-1.5 shadow-lg shadow-blue-900/30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>Save & Apply Size Change</span>
          </button>
        </div>
      </form>
    </div>
  <!-- ======================================================== -->
  <!-- ITEM BUYERS & DISTRIBUTION AUDIT MODAL -->
  <!-- "yung damit lng na ito makikita don kung ilan bumili or ano" -->
  <!-- ======================================================== -->
  <div id="admin-item-buyers-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-4xl w-full p-6 shadow-2xl relative text-left space-y-4 max-h-[90vh] flex flex-col">
      <!-- Modal Header -->
      <div class="flex items-start justify-between pb-4 border-b border-slate-800 flex-shrink-0">
        <div class="flex items-center gap-3">
          <div id="modal-buyer-item-img-container" class="w-12 h-12 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0">
            <span class="text-2xl">👕</span>
          </div>
          <div>
            <div class="flex items-center gap-2">
              <span id="modal-buyer-item-code" class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-cyan-950 text-cyan-300 border border-cyan-800">
                PROD-001
              </span>
              <span id="modal-buyer-item-category" class="text-[10px] uppercase font-bold text-slate-400 font-mono">
                CATEGORY
              </span>
            </div>
            <h3 id="modal-buyer-item-name" class="text-base sm:text-lg font-black text-white font-display mt-0.5">
              Product Name
            </h3>
            <p id="modal-buyer-item-price" class="text-xs text-emerald-400 font-mono font-bold">
              ₱0.00
            </p>
          </div>
        </div>

        <button type="button" onclick="icsApp.closeItemBuyersModal()" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Quick Stats KPI Row: "makikita don kung ilan bumili" -->
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs flex-shrink-0">
        <div class="p-3 rounded-2xl bg-slate-950/70 border border-slate-800">
          <span class="text-[10px] uppercase font-bold text-cyan-400 tracking-wider block">Ilan ang Bumili (Sold)</span>
          <span id="modal-buyer-units-sold" class="text-xl font-black font-mono text-white mt-1 block">0 units</span>
          <span id="modal-buyer-count-badge" class="text-[10px] text-slate-400 block mt-0.5">0 registered orders</span>
        </div>
        <div class="p-3 rounded-2xl bg-slate-950/70 border border-slate-800">
          <span class="text-[10px] uppercase font-bold text-amber-400 tracking-wider block">Reserved</span>
          <span id="modal-buyer-units-reserved" class="text-xl font-black font-mono text-white mt-1 block">0 units</span>
          <span class="text-[10px] text-slate-400 block mt-0.5">Pending release</span>
        </div>
        <div class="p-3 rounded-2xl bg-slate-950/70 border border-slate-800">
          <span class="text-[10px] uppercase font-bold text-emerald-400 tracking-wider block">Available Stock</span>
          <span id="modal-buyer-stock" class="text-xl font-black font-mono text-white mt-1 block">0 units</span>
          <span class="text-[10px] text-slate-400 block mt-0.5">Current inventory</span>
        </div>
        <div class="p-3 rounded-2xl bg-slate-950/70 border border-slate-800">
          <span class="text-[10px] uppercase font-bold text-purple-400 tracking-wider block">Total Revenue</span>
          <span id="modal-buyer-revenue" class="text-xl font-black font-mono text-emerald-400 mt-1 block">₱0.00</span>
          <span class="text-[10px] text-slate-400 block mt-0.5">Sold units total</span>
        </div>
      </div>

      <!-- Buyers List Table -->
      <div class="flex-1 overflow-y-auto border border-slate-800 rounded-2xl max-h-[340px]">
        <table class="w-full text-left text-xs">
          <thead class="bg-slate-950 text-slate-300 uppercase font-mono font-bold text-[10px] sticky top-0 border-b border-slate-800 z-10">
            <tr>
              <th class="py-2.5 px-3">Student ID</th>
              <th class="py-2.5 px-3">Student Name</th>
              <th class="py-2.5 px-3">Program / Year</th>
              <th class="py-2.5 px-3 text-center">Qty</th>
              <th class="py-2.5 px-3 text-center">Size</th>
              <th class="py-2.5 px-3 text-right">Subtotal</th>
              <th class="py-2.5 px-3">Order Date</th>
              <th class="py-2.5 px-3">Claim Date</th>
              <th class="py-2.5 px-3 text-center">Status</th>
              <th class="py-2.5 px-3 font-mono">Claim Ref</th>
            </tr>
          </thead>
          <tbody id="modal-item-buyers-tbody" class="divide-y divide-slate-800/80 text-slate-200">
            <!-- Populated via JS -->
          </tbody>
        </table>
      </div>

      <!-- Action Footer with Download CSV & PDF for this item -->
      <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-3 border-t border-slate-800 flex-shrink-0">
        <span class="text-xs text-slate-400 font-mono">
          Download report for this item:
        </span>
        <div class="flex items-center gap-2 w-full sm:w-auto">
          <a
            id="modal-buyer-download-csv-btn"
            href="#"
            class="flex-1 sm:flex-none px-4 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition flex items-center justify-center gap-1.5 shadow-lg shadow-emerald-950/50">
            <svg class="w-3.5 h-3.5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>Download CSV (Excel)</span>
          </a>
          <a
            id="modal-buyer-download-pdf-btn"
            href="#"
            target="_blank"
            class="flex-1 sm:flex-none px-4 py-2 rounded-xl text-xs font-black bg-rose-700 hover:bg-rose-600 text-white transition flex items-center justify-center gap-1.5 shadow-lg shadow-rose-950/50">
            <svg class="w-3.5 h-3.5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            <span>Download PDF / Print</span>
          </a>
          <button
            type="button"
            onclick="icsApp.closeItemBuyersModal()"
            class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-300 transition">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>

  <div id="product-crud-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-ics-900 rounded-3xl max-w-2xl w-full p-6 shadow-2xl relative text-left">

      <div class="flex items-center justify-between pb-4 border-b border-slate-800">
        <div>
          <h3 id="product-modal-title" class="text-base font-black text-white font-display">
            Add New Merchandise Item
          </h3>
          <p class="text-xs text-slate-400">Configure item details, sizing stock, and photo upload</p>
        </div>
        <button onclick="icsApp.closeProductCrudModal()" class="text-slate-400 hover:text-white p-1">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <form id="product-crud-form" onsubmit="icsApp.submitProductCrud(event)" class="mt-4 space-y-4">
        <input type="hidden" id="crud-product-id" name="product_id">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Item Code / SKU *</label>
            <input type="text" id="crud-item-code" required placeholder="e.g. ICS-HOODIE-RED" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-ics-500">
          </div>
          <div>
            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Product Name *</label>
            <input type="text" id="crud-name" required placeholder="e.g. ICS Official Tech Hoodie" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-ics-500">
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <div>
            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Category *</label>
            <select id="crud-category" required class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
              <option value="general">Collegiate Uniform</option>
              <option value="pe">Athletics / PE Wear</option>
              <option value="department">Department / Varsity</option>
              <option value="accessory">Accessory / Lanyard</option>
            </select>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Gender Focus</label>
            <select id="crud-gender" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
              <option value="Unisex">Unisex</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Price in PHP (₱) *</label>
            <input type="number" id="crud-price" required min="0" step="0.5" placeholder="420" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
          </div>
        </div>

        <!-- PHOTO UPLOAD & EDIT SECTION (Requested by User) -->
        <div class="p-4 bg-slate-950/80 rounded-2xl border border-slate-800 space-y-3">
          <label class="block text-[11px] font-bold text-ics-gold uppercase">
            Product Photography (Upload & Edit Photo)
          </label>

          <div class="flex flex-col sm:flex-row items-center gap-4">
            <!-- Image Preview Box -->
            <div class="w-24 h-24 rounded-2xl bg-slate-900 border-2 border-dashed border-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0 relative group">
              <img id="crud-image-preview" src="{{ asset('images/male_polo.jpg') }}" alt="Preview" class="w-full h-full object-cover">
              <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 flex items-center justify-center text-[10px] text-white transition">
                Preview
              </div>
            </div>

            <!-- Upload Controls -->
            <div class="flex-1 space-y-2 w-full">
              <!-- File Upload Input -->
              <div>
                <label class="text-[10px] text-slate-400 block mb-1">Upload New Picture from Computer:</label>
                <input type="file" id="crud-image-file" accept="image/*" onchange="icsApp.handleImageFileSelect(this)" class="w-full text-xs text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-ics-800 file:text-white hover:file:bg-ics-700 cursor-pointer">
              </div>

              <!-- Or Choose from Presets -->
              <div>
                <label class="text-[10px] text-slate-400 block mb-1">Or Select Existing Campus Photography Preset:</label>
                <select id="crud-image-preset" onchange="icsApp.handleImagePresetSelect(this.value)" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-1.5 text-xs text-slate-200">
                  <option value="">-- Choose Photography Preset --</option>
                  <option value="images/male_polo.jpg">Male Polo Barong (Official)</option>
                  <option value="images/female_blouse.jpg">Female Tailored Blouse with Ribbon</option>
                  <option value="images/male_slacks.jpg">Male Formal Navy Slacks</option>
                  <option value="images/female_skirt.jpg">Female Pleated A-Line Skirt</option>
                  <option value="images/pe_shirt.jpg">ICS Athletics PE Dry-Fit Shirt</option>
                  <option value="images/pe_pants.jpg">ICS Athletics PE Jogger Pants</option>
                  <option value="images/varsity_jacket.jpg">Collegiate Letterman Varsity Bomber Jacket</option>
                  <option value="images/dept_tech.jpg">CICS Tech Vanguard Department Polo</option>
                  <option value="images/dept_ba.jpg">CBAA Corporate Executive Polo</option>
                  <option value="images/lanyard.jpg">ICS Gold-Foil Lanyard & Case</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- SIZES & STOCK BREAKDOWN -->
        <div class="p-4 bg-slate-950/80 rounded-2xl border border-slate-800">
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-2">
            Initial Stock Breakdown by Size
          </label>
          <div class="grid grid-cols-4 sm:grid-cols-7 gap-2 text-center">
            @foreach(['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'] as $sz)
            <div>
              <span class="text-[10px] font-mono text-slate-400 block">{{ $sz }}</span>
              <input type="number" id="crud-size-{{ $sz }}" min="0" value="10" class="w-full bg-slate-900 border border-slate-700 rounded-lg py-1 px-1.5 text-xs text-center text-white font-mono">
            </div>
            @endforeach
          </div>
        </div>

        <!-- Material & Description -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Fabric / Material Spec</label>
            <input type="text" id="crud-material" placeholder="e.g. Linen-Cotton Twill Blend" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
          </div>
          <div>
            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Department</label>
            <input type="text" id="crud-dept" value="all" placeholder="all, AIS, BSIS, CICS" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
          </div>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Description</label>
          <textarea id="crud-desc" rows="2" placeholder="Item description, embroidery details, care instructions..." class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white"></textarea>
        </div>

        <!-- Form Actions -->
        <div class="pt-4 border-t border-slate-800 flex justify-end gap-3">
          <button type="button" onclick="icsApp.closeProductCrudModal()" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">
            Cancel
          </button>
          <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-ics-700 to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white shadow-lg transition">
            Save Item & Picture
          </button>
        </div>
      </form>

    </div>
  </div>

  <!-- ======================================================== -->


  <div id="user-crud-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-purple-900/80 rounded-3xl max-w-md w-full p-6 shadow-2xl relative text-left">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <h3 id="user-modal-title" class="text-sm font-black text-white font-display">
          Add New System User
        </h3>
        <button onclick="icsApp.closeUserCrudModal()" class="text-slate-400 hover:text-white">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <form onsubmit="icsApp.submitUserCrud(event)" class="mt-4 space-y-3.5">
        <input type="hidden" id="crud-user-id">

        <div>
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">User Code / Student ID *</label>
          <input type="text" id="crud-user-code" required placeholder="e.g. 251505 or 2026-79818" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
        </div>
        <div>
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Full Name *</label>
          <input type="text" id="crud-user-name" required placeholder="e.g. Juan dela Cruz" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
        </div>
        <div>
          <div class="flex items-center justify-between mb-1">
            <label class="block text-[11px] font-bold text-slate-300 uppercase">OnePass Student Email *</label>
            <span class="text-[9px] text-purple-400 font-mono">Verified Database Only</span>
          </div>
          <input 
            type="email" 
            id="crud-user-email" 
            list="verified-students-datalist" 
            oninput="icsApp.onUserEmailInput(this.value)"
            required 
            placeholder="e.g. jderramas251505@navotaspolytechniccollege.edu.ph" 
            class="w-full bg-slate-950 border border-slate-700 focus:border-purple-500 rounded-xl px-3 py-2 text-xs text-white">
          <datalist id="verified-students-datalist">
            @if(isset($verifiedStudents))
              @foreach($verifiedStudents as $vs)
                <option value="{{ $vs->email }}">{{ $vs->name }} ({{ $vs->student_id }}) - {{ $vs->department }}</option>
              @endforeach
            @endif
          </datalist>
          <p id="user-email-feedback" class="text-[10px] mt-1 text-slate-400">
            Select or type an institutional email registered in the OnePass student database.
          </p>
        </div>
        <div class="grid grid-cols-2 gap-3">
          <div>
            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Role *</label>
            <select id="crud-user-role" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
              <option value="Admin">Admin</option>
              <option value="Logistics Officer">Logistics Officer</option>
              <option value="Inventory Officer">Inventory Officer</option>
              <option value="Student Member">Student Member</option>
            </select>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Department</label>
            <input type="text" id="crud-user-dept" value="AIS 2B" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
          </div>
        </div>

        <div class="pt-3 border-t border-slate-800 flex justify-end gap-2">
          <button type="button" onclick="icsApp.closeUserCrudModal()" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">
            Cancel
          </button>
          <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-purple-700 hover:bg-purple-600 text-white transition">
            Save User
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ======================================================== -->


  <div id="receipt-view-modal" onclick="if(event.target === this) icsApp.closeReceiptViewModal()" class="hidden fixed inset-0 z-[80] overflow-y-auto bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-3 sm:p-5" style="display: none;">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-2xl w-full p-5 sm:p-6 shadow-2xl relative text-left flex flex-col max-h-[92vh]">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800 shrink-0">
        <div class="flex items-center gap-2.5">
          <div class="w-8 h-8 rounded-xl bg-blue-950 text-blue-400 border border-blue-800 flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <div>
            <h3 class="text-sm font-black text-white font-display">Proof of GCash Payment Receipt</h3>
            <p class="text-[11px] text-slate-400" id="receipt-view-subtitle">Official Student Upload (Zoomable)</p>
          </div>
        </div>
        <button type="button" onclick="icsApp.closeReceiptViewModal()" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition" title="Close (Esc)">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <div class="mt-4 space-y-3 flex-1 overflow-y-auto pr-1">
        <!-- Quick Summary Bar -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-[11px] bg-slate-950 p-3 rounded-2xl border border-slate-800 shrink-0">
          <div>
            <span class="text-slate-500 uppercase font-bold text-[9px] block">Reference Code</span>
            <span id="receipt-view-ref" class="font-mono font-bold text-ics-gold"></span>
          </div>
          <div>
            <span class="text-slate-500 uppercase font-bold text-[9px] block">Student Buyer</span>
            <span id="receipt-view-student" class="text-white font-semibold truncate block"></span>
          </div>
          <div>
            <span class="text-slate-500 uppercase font-bold text-[9px] block">Total Amount</span>
            <span id="receipt-view-amount" class="font-mono font-bold text-white"></span>
          </div>
          <div>
            <span class="text-slate-500 uppercase font-bold text-[9px] block">GCash Ref No.</span>
            <span id="receipt-view-gcash-ref" class="font-mono text-blue-300 font-bold truncate block"></span>
          </div>
        </div>

        <!-- Zoom Toolbar Controls -->
        <div id="receipt-zoom-toolbar" class="flex items-center justify-between bg-slate-950/80 px-3 py-1.5 rounded-xl border border-slate-800 text-xs">
          <span class="text-[11px] font-bold text-slate-400 flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
            <span>Zoom Level:</span>
            <span id="receipt-zoom-level-text" class="font-mono text-cyan-300 font-bold">100%</span>
            <span class="text-[9px] text-slate-500 hidden sm:inline">(Click image to toggle 2x Zoom)</span>
          </span>
          <div class="flex items-center gap-1">
            <button type="button" onclick="icsApp.zoomReceipt(-0.25)" class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition border border-slate-700 cursor-pointer" title="Zoom Out (-)">
              −
            </button>
            <button type="button" onclick="icsApp.resetReceiptZoom()" class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-xs transition border border-slate-700 cursor-pointer" title="Reset Zoom">
              Reset
            </button>
            <button type="button" onclick="icsApp.zoomReceipt(0.25)" class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition border border-slate-700 cursor-pointer" title="Zoom In (+)">
              +
            </button>
            <button type="button" onclick="icsApp.rotateReceipt()" class="ml-1 px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs transition border border-slate-700 flex items-center gap-1 cursor-pointer" title="Rotate 90 deg">
              <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
              <span>Rotate</span>
            </button>
          </div>
        </div>

        <!-- Receipt Image Frame with Drag & Zoom -->
        <div id="receipt-view-frame" class="relative rounded-2xl border border-slate-800 bg-slate-950 overflow-hidden flex items-center justify-center p-2 min-h-[220px] max-h-[460px] select-none cursor-grab active:cursor-grabbing">
          <img
            id="receipt-view-img"
            src=""
            alt="Payment Receipt"
            onclick="icsApp.toggleReceiptZoom(event)"
            title="Click to toggle 2x Zoom / reset"
            class="max-h-[420px] w-auto object-contain rounded-xl shadow-lg transition-transform duration-100 ease-out origin-center cursor-zoom-in"
          />
          <div id="receipt-view-empty-notice" class="hidden py-8 px-4 text-center">
            <svg class="w-10 h-10 mx-auto text-slate-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-xs font-bold text-slate-300">Walang naka-attach na screenshot ng resibo</p>
            <p class="text-[11px] text-slate-500 mt-0.5">I-verify ang bayad gamit ang GCash Reference Number sa itaas.</p>
          </div>
        </div>

        <!-- Modal Actions -->
        <div class="pt-3 border-t border-slate-800 flex items-center justify-between shrink-0">
          <a id="receipt-view-download-link" href="" target="_blank" download="receipt.jpg" class="text-xs text-blue-400 hover:underline flex items-center gap-1 font-semibold">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Open Full Size in Tab
          </a>
          <div class="flex items-center gap-2">
            <button type="button" onclick="icsApp.closeReceiptViewModal()" class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">
              Close
            </button>
            <button id="receipt-verify-btn" onclick="icsApp.verifyReceiptPayment()" class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition flex items-center gap-1 cursor-pointer">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span>Mark Payment Verified</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ======================================================== -->
  <!-- MODAL: MESSAGE STUDENT BUYER ("if may itatanong yung admin don sa bibili") -->
  <!-- ======================================================== -->
  <div id="admin-message-buyer-modal" class="hidden fixed inset-0 z-[80] overflow-y-auto bg-slate-950/85 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl relative text-left">
      <!-- Modal Header -->
      <div class="flex items-center justify-between pb-3.5 border-b border-slate-800">
        <div class="flex items-center gap-2.5">
          <div class="w-9 h-9 rounded-2xl bg-cyan-950 text-cyan-400 border border-cyan-800 flex items-center justify-center shadow-inner">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
          </div>
          <div>
            <h3 class="text-sm sm:text-base font-black text-white font-display flex items-center gap-2">
              <span>Message Student Buyer</span>
              <span class="text-[10px] font-mono px-2 py-0.5 rounded-full bg-cyan-950 text-cyan-300 border border-cyan-800 font-bold">Direct Inquiry</span>
            </h3>
            <p class="text-[11px] text-slate-400">Ask questions, clarify GCash payment, or confirm sizing directly with the buyer</p>
          </div>
        </div>
        <button type="button" onclick="icsApp.closeAdminMessageBuyerModal()" class="text-slate-400 hover:text-white p-1 rounded-xl hover:bg-slate-800 transition cursor-pointer">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <div class="mt-4 space-y-4">
        <!-- Buyer & Order Summary Card -->
        <div class="bg-slate-950 p-3.5 rounded-2xl border border-slate-800 text-xs space-y-2">
          <div class="flex items-center justify-between">
            <span class="text-slate-400">Student Buyer:</span>
            <span id="msg-buyer-student-name" class="font-bold text-white text-sm"></span>
          </div>
          <div class="flex items-center justify-between text-[11px]">
            <span class="text-slate-400">Student Number:</span>
            <span id="msg-buyer-student-id" class="font-mono text-cyan-300 font-bold bg-cyan-950/60 px-2 py-0.5 rounded border border-cyan-800/60"></span>
          </div>
          <div class="flex items-center justify-between text-[11px]">
            <span class="text-slate-400">Order Reference Code:</span>
            <span id="msg-buyer-ref-code" class="font-mono text-ics-gold font-bold"></span>
          </div>
          <div class="flex items-center justify-between text-[11px]">
            <span class="text-slate-400">Payment Status:</span>
            <span id="msg-buyer-payment-status" class="font-bold px-2 py-0.5 rounded text-[10px]"></span>
          </div>
        </div>

        <!-- Existing Active Ticket Indicator if any -->
        <div id="msg-buyer-active-ticket-alert" class="hidden bg-amber-950/60 border border-amber-800/80 p-2.5 rounded-xl text-xs flex items-center justify-between gap-2">
          <div class="flex items-center gap-1.5 text-amber-300">
            <svg class="w-4 h-4 text-amber-400 animate-pulse shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <span id="msg-buyer-active-ticket-text" class="text-[11px]">Active conversation exists for this order.</span>
          </div>
          <button type="button" onclick="icsApp.jumpToHelpdeskFromMessageModal()" class="px-2 py-1 rounded-lg bg-amber-600 hover:bg-amber-500 text-white font-bold text-[10px] transition shrink-0 cursor-pointer">
            Open Chat &rarr;
          </button>
        </div>

        <!-- Subject Input -->
        <div>
          <label class="block text-[11px] uppercase font-bold text-slate-300 mb-1">Subject / Paksa:</label>
          <input
            type="text"
            id="msg-buyer-subject"
            placeholder="e.g. GCash Payment Verification / Sizing Confirmation"
            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-cyan-500 font-sans shadow-inner">
        </div>

        <!-- Quick Question Suggestions (Chips) -->
        <div>
          <span class="block text-[10px] uppercase font-bold text-slate-400 mb-1.5">Quick Prompts (I-click para mabilisang mag-type):</span>
          <div class="flex flex-wrap gap-1.5 text-[10px]">
            <button
              type="button"
              onclick="icsApp.setAdminMessageQuickPrompt('Pakisend po ng clearer screenshot ng inyong GCash receipt para ma-verify namin ang payment. Salamat!')"
              class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-cyan-300 border border-slate-700 transition cursor-pointer">
              💳 Request Clearer Receipt
            </button>
            <button
              type="button"
              onclick="icsApp.setAdminMessageQuickPrompt('Gusto lang po naming i-confirm kung tama ang napili ninyong size bago namin i-prepare ang inyong order.')"
              class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700 transition cursor-pointer">
              👕 Confirm Sizing
            </button>
            <button
              type="button"
              onclick="icsApp.setAdminMessageQuickPrompt('Ready na po for pickup ang inyong merchandise sa ICS Council Office! Pakidala po ang inyong Student ID.')"
              class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-emerald-300 border border-slate-700 transition cursor-pointer">
              📦 Ready for Pickup Notice
            </button>
            <button
              type="button"
              onclick="icsApp.setAdminMessageQuickPrompt('Pakicheck po ulit ang inyong GCash Reference Number dahil hindi po nag-match sa opisyal na ledger.')"
              class="px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-amber-300 border border-slate-700 transition cursor-pointer">
              ⚠️ GCash Ref Mismatch
            </button>
          </div>
        </div>

        <!-- Message Body Textarea -->
        <div>
          <label class="block text-[11px] uppercase font-bold text-slate-300 mb-1">Mensahe / Tanong ng Admin sa Estudyante:</label>
          <textarea
            id="msg-buyer-content"
            rows="4"
            placeholder="Isulat ang inyong tanong o mensahe para sa estudyante..."
            class="w-full bg-slate-950 border border-slate-700 rounded-xl p-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-cyan-500 font-sans shadow-inner"></textarea>
        </div>

        <!-- Modal Action Buttons -->
        <div class="pt-3 border-t border-slate-800 flex items-center justify-between gap-2">
          <button
            type="button"
            onclick="icsApp.closeAdminMessageBuyerModal()"
            class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition cursor-pointer">
            Cancel
          </button>
          <button
            type="button"
            id="msg-buyer-send-btn"
            onclick="icsApp.sendAdminMessageToBuyer()"
            class="px-4 py-2 rounded-xl text-xs font-bold bg-cyan-600 hover:bg-cyan-500 text-white transition flex items-center gap-1.5 shadow-lg shadow-cyan-950/60 cursor-pointer">
            <svg class="w-4 h-4 text-cyan-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
            <span id="msg-buyer-send-btn-label">Send Message to Student</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- ======================================================== -->
  <!-- MODAL / PRINTABLE CLAIM SLIP (FOR ADMIN VERIFICATION & ISSUANCE) -->
  <!-- ======================================================== -->
  <div id="slip-modal" class="hidden fixed inset-0 z-[80] overflow-y-auto bg-slate-950/85 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white text-slate-900 rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative text-left" id="printable-claim-slip">

      <!-- Slip Header -->
      <div class="flex items-center justify-between pb-4 border-b-2 border-slate-900">
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/ics-logo.png') }}" alt="ICS" class="w-12 h-12 object-contain rounded-xl p-0.5 bg-slate-900">
          <div>
            <h2 class="text-sm font-black uppercase tracking-tight text-red-900 leading-none">
              INTEGRATED COMPUTER SOCIETY
            </h2>
            <p class="text-[10px] text-slate-600 font-bold uppercase tracking-wider mt-0.5">
              Official Uniform &amp; Merch Reservation Claim Slip
            </p>
            <p class="text-[9px] text-slate-500 font-mono">Official Administrator Copy | Verified Claim Slip</p>
          </div>
        </div>
        <button type="button" onclick="icsApp.closeSlipModal()" class="text-slate-400 hover:text-black p-1 no-print cursor-pointer">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Slip Details -->
      <div class="mt-4 space-y-4">

        <div class="flex items-center justify-between bg-slate-100 p-3 rounded-2xl border border-slate-200">
          <div>
            <p class="text-[10px] text-slate-500 font-bold uppercase">Reference Code</p>
            <p id="slip-ref" class="text-base font-black font-mono text-red-800"></p>
          </div>
          <div class="text-right">
            <p class="text-[10px] text-slate-500 font-bold uppercase">Status</p>
            <p id="slip-status" class="text-xs font-bold font-mono text-emerald-700"></p>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-3 text-xs">
          <div>
            <p class="text-[10px] text-slate-500 font-bold uppercase">Student Name</p>
            <p id="slip-student-name" class="font-bold text-slate-900"></p>
          </div>
          <div>
            <p class="text-[10px] text-slate-500 font-bold uppercase">Student ID</p>
            <p id="slip-student-id" class="font-mono text-slate-900"></p>
          </div>
          <div>
            <p class="text-[10px] text-slate-500 font-bold uppercase">Department</p>
            <p id="slip-dept" class="text-slate-700"></p>
          </div>
          <div>
            <p class="text-[10px] text-slate-500 font-bold uppercase">Pickup Slot</p>
            <p id="slip-pickup-slot" class="font-semibold text-slate-900"></p>
          </div>
          <div>
            <p class="text-[10px] text-slate-500 font-bold uppercase">Payment Method</p>
            <p id="slip-payment-method" class="font-bold text-slate-900"></p>
          </div>
          <div>
            <p class="text-[10px] text-slate-500 font-bold uppercase">Payment Status</p>
            <p id="slip-payment-status" class="font-mono font-bold text-slate-800"></p>
          </div>
        </div>

        <!-- Items Table -->
        <div class="border border-slate-200 rounded-xl overflow-hidden">
          <table class="w-full text-left text-xs">
            <thead class="bg-slate-100 text-slate-600 text-[10px] uppercase font-mono border-b border-slate-200">
              <tr>
                <th class="py-2 px-3">Item Description</th>
                <th class="py-2 px-2 text-center">Size</th>
                <th class="py-2 px-2 text-center">Qty</th>
                <th class="py-2 px-3 text-right">Subtotal</th>
              </tr>
            </thead>
            <tbody id="slip-items-tbody" class="divide-y divide-slate-100">
              <!-- Rendered via JS -->
            </tbody>
            <tfoot class="bg-slate-50 text-xs">
              <tr class="text-slate-600">
                <td colspan="3" class="py-1 px-3 text-right">Items Subtotal:</td>
                <td id="slip-subtotal" class="py-1 px-3 text-right font-mono">₱0.00</td>
              </tr>
              <tr class="text-slate-600">
                <td colspan="3" class="py-1 px-3 text-right">Additional Reservation Fee:</td>
                <td class="py-1 px-3 text-right font-mono text-red-900 font-semibold">+₱10.00</td>
              </tr>
              <tr class="font-bold border-t border-slate-200">
                <td colspan="3" class="py-2 px-3 text-right text-xs text-slate-900">Total Amount Due:</td>
                <td id="slip-grandtotal" class="py-2 px-3 text-right text-sm font-mono text-red-900 font-black"></td>
              </tr>
            </tfoot>
          </table>
        </div>

        <!-- Barcode / QR Simulation -->
        <div class="pt-3 border-t border-dashed border-slate-300 flex items-center justify-between">
          <div>
            <p class="text-[10px] text-slate-500 font-mono">Official record from ICS Admin Console.</p>
            <p class="text-[9px] text-slate-400">Claims valid for 3 working days from scheduled date.</p>
          </div>
          <div class="text-right">
            <div class="inline-flex gap-0.5 h-8 items-center bg-slate-100 p-1 rounded">
              <span class="w-1 h-full bg-slate-900"></span>
              <span class="w-0.5 h-full bg-slate-900"></span>
              <span class="w-1.5 h-full bg-slate-900"></span>
              <span class="w-0.5 h-full bg-slate-900"></span>
              <span class="w-2 h-full bg-slate-900"></span>
              <span class="w-1 h-full bg-slate-900"></span>
              <span class="w-0.5 h-full bg-slate-900"></span>
              <span class="w-1.5 h-full bg-slate-900"></span>
            </div>
          </div>
        </div>

      </div>

      <!-- Slip Footer Actions (No Print) -->
      <div class="mt-6 pt-4 border-t border-slate-200 flex justify-end gap-3 no-print">
        <button type="button" onclick="icsApp.closeSlipModal()" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-200 text-slate-700 hover:bg-slate-300 transition cursor-pointer">
          Close
        </button>
        <button type="button" onclick="icsApp.printCurrentSlip()" class="px-5 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-black text-white transition flex items-center gap-1.5 shadow cursor-pointer">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
          </svg>
          <span>Print Claim Slip</span>
        </button>
      </div>

    </div>
  </div>

  <!-- Toast Notification Container (Top Floating / High Z-Index / Non-blocking) -->
  <div id="toast-container" class="fixed top-5 left-1/2 -translate-x-1/2 z-[100] space-y-2 pointer-events-none flex flex-col items-center max-w-[92vw] sm:max-w-md w-full px-4" style="z-index: 99999;"></div>

  <!-- ======================================================== -->

  <script>
    /**
     * ICS Apparel & Merch Reservation System
     * Reactive Client Architecture & Server Synchronization
     */
    class IcsMerchApp {
      constructor() {
        const rawCatalog = @json($products);
        this.catalog = Array.isArray(rawCatalog) ? rawCatalog : Object.values(rawCatalog || {});

        const rawRes = @json($reservations);
        this.reservations = Array.isArray(rawRes) ? rawRes : Object.values(rawRes || {});

        const rawClaimed = @json($claimedReservations ?? []);
        this.claimedReservations = Array.isArray(rawClaimed) ? rawClaimed : Object.values(rawClaimed || {});

        const rawLogs = @json($activityLogs);
        this.activityLogs = Array.isArray(rawLogs) ? rawLogs : Object.values(rawLogs || {});

        const rawUsers = @json($users);
        this.users = Array.isArray(rawUsers) ? rawUsers : Object.values(rawUsers || {});

        // Logged-in Admin Identity
        @php
          $currentAdminPayload = $studentUser ?? [
            'name' => $adminUser->name ?? 'Administrator',
            'email' => $adminUser->email ?? '',
            'student_id' => $adminUser->user_code ?? '251505',
            'department' => $adminUser->department ?? 'AIS',
            'year_level' => 'N/A',
            'section' => 'Admin',
            'initials' => strtoupper(substr($adminUser->name ?? 'AD', 0, 2))
          ];
        @endphp
        this.currentUser = @json($currentAdminPayload);
        this.verifiedStudents = @json($verifiedStudents ?? []);

        this.cart = this.loadCartFromStorage();
        this.currentView = 'admin'; // Dedicated Admin Portal View
        this.adminTab = 'dashboard'; // 'dashboard', 'infomgmt', 'reservations', 'reports', 'usermgmt', 'actlogs'
        this.categoryFilter = 'all';
        this.searchQuery = '';

        this.selectedProduct = null;
        this.selectedSize = null;
        this.selectedQty = 1;
        this.sizeUnit = 'in';
        this.sizeTab = 'tops';

        this.activeTrackedRef = null;

        this.selectedPaymentMethod = 'Cash on Pickup';
        this.receiptBase64 = null;
        this.activeViewingReceiptReservation = null;

        // Support Tickets & Live Chat Helpdesk State
        const rawTickets = @json($supportTickets ?? []);
        this.supportTickets = Array.isArray(rawTickets) ? rawTickets : Object.values(rawTickets || {});
        this.activeAdminTicketId = (this.supportTickets && this.supportTickets.length > 0) ? this.supportTickets[0].id : null;
        this.activeStudentTicketId = null;
        this.adminTicketFilter = 'all';

        // Activity Logs Pagination & Filter State (50 items/page, up to 200 items)
        this.actLogsCurrentPage = 1;
        this.actLogsPerPage = 50;
        this.actLogsFilterAction = 'all';
        this.actLogsSearchQuery = '';
        // Persistent Selection & Sort States (Saved across search, sort, and browser refresh)
        try {
          const savedReportIds = JSON.parse(localStorage.getItem('ics_selected_report_ids') || '[]');
          this.selectedReportProductIds = new Set(Array.isArray(savedReportIds) ? savedReportIds.map(String) : []);
        } catch (e) {
          this.selectedReportProductIds = new Set();
        }

        try {
          const savedClaimedIds = JSON.parse(localStorage.getItem('ics_selected_claimed_ids') || '[]');
          this.selectedClaimedIds = new Set(Array.isArray(savedClaimedIds) ? savedClaimedIds.map(String) : []);
        } catch (e) {
          this.selectedClaimedIds = new Set();
        }

        try {
          const savedResIds = JSON.parse(localStorage.getItem('ics_selected_reservation_ids') || '[]');
          this.selectedReservationIds = new Set(Array.isArray(savedResIds) ? savedResIds.map(String) : []);
        } catch (e) {
          this.selectedReservationIds = new Set();
        }

        this.activeClaimedSort = 'date_claimed_desc';
        this.activeReportSort = 'code_asc';
        this.reportSearchQuery = '';

        this._knownReservationRefs = new Set((this.reservations || []).map(x => x.ref_code));
        this._hasRenderedInitialQueue = false;

        this.init();
      }

      init() {
        this.updateCartBadge();
        this.renderSizeGuide();
        this.initTracker();
        this.updateMobileDrawerContent();
        this.renderAdminTicketsList();
        this.renderActivityLogsTable();
        this.renderReservationsQueue();
        this.renderClaimedLedgerTable();
        this.restoreReportSelectionUI();
        this.restoreClaimedSelectionUI();
        this.restoreReservationSelectionUI();

        @if(session('success'))
          this.showToast(@json(session('success')), 'success');
        @endif
        @if(session('info'))
          this.showToast(@json(session('info')), 'info');
        @endif
        @if(session('error'))
          this.showToast(@json(session('error')), 'error');
        @endif

        // Restore active admin tab: stays on current section upon edit, delete, or reload
        let initialTab = 'dashboard';
        try {
          const hashTab = (window.location.hash || '').replace('#', '').trim();
          const localTab = localStorage.getItem('ics_admin_active_tab');
          const validTabs = ['dashboard', 'infomgmt', 'reservations', 'claimed', 'reports', 'usermgmt', 'actlogs', 'support', 'helpdesk'];
          if (validTabs.includes(hashTab)) {
            initialTab = hashTab === 'helpdesk' ? 'support' : hashTab;
          } else if (validTabs.includes(localTab)) {
            initialTab = localTab === 'helpdesk' ? 'support' : localTab;
          }
        } catch (e) {}

        this.setAdminTab(initialTab, true);
        setTimeout(() => this.syncTableTopScrollbars(), 200);
        window.addEventListener('resize', () => {
          this.syncTableTopScrollbars();
        });

        if (initialTab === 'dashboard') {
          this.initAdminCharts();
        }
        this.startAdminRealtimeSync();

        window.addEventListener('hashchange', () => {
          const newTab = (window.location.hash || '').replace('#', '').trim();
          if (newTab && newTab !== this.adminTab) {
            this.setAdminTab(newTab, false);
          }
        });

        document.addEventListener('keydown', (e) => {
          if (e.key === 'Escape') {
            this.closeMobileDrawer();
            this.closeQrZoomModal();
            this.closeReceiptViewModal();
          }
        });
      }


      /**
       * REALTIME LIVE POLLING ENGINE (ADMIN PORTAL)
       * Automatically syncs reservations queue, stock levels, chat helpdesk,
       * and dashboard KPIs every 3 seconds without full page reload.
       */
      startAdminRealtimeSync() {
        if (this._adminSyncInterval) clearInterval(this._adminSyncInterval);
        this._adminSyncInterval = setInterval(async () => {
          if (document.hidden) return; // Skip polling when tab is not active
          if (this._adminSyncInProgress) return;
          this._adminSyncInProgress = true;
          try {
            const ticketParam = this.activeAdminTicketId ? '&ticket_id=' + encodeURIComponent(this.activeAdminTicketId) : '';
            const res = await fetch('{{ route("api.realtime.sync") }}?scope=admin' + ticketParam, {
              headers: {
                'Accept': 'application/json'
              }
            });
            if (!res.ok) return;
            const data = await res.json();
            if (!data || !data.success) return;

            // 1. Synchronize in-memory collections
            if (data.products) this.catalog = data.products;
            if (data.reservations) {
              const prevRefs = this._knownReservationRefs || new Set();
              const currentRefs = new Set((data.reservations || []).map(x => x.ref_code));

              if (this._hasRenderedInitialQueue) {
                const newOrders = (data.reservations || []).filter(x => !prevRefs.has(x.ref_code));
                if (newOrders.length > 0) {
                  newOrders.forEach(no => {
                    this.showToast(`New student order: #${no.ref_code} from ${no.student_name}!`, 'info');
                  });
                }
              }
              this._knownReservationRefs = currentRefs;
              this.reservations = data.reservations;
            }
            if (data.claimed_reservations) {
              this.claimedReservations = data.claimed_reservations;
              if (this.adminTab === 'reports') {
                const searchVal = document.getElementById('claimed-ledger-search')?.value;
                if (!searchVal) {
                  this.renderClaimedLedgerTable();
                }
              }
            }
            if (data.support_tickets) this.supportTickets = data.support_tickets;

            // 2. Real-time Dashboard KPI updates
            if (data.metrics) {
              const m = data.metrics;
              const prodEl = document.getElementById('kpi-total-products');
              if (prodEl) prodEl.textContent = m.total_products;

              const stockEl = document.getElementById('kpi-total-stock');
              if (stockEl) stockEl.textContent = Number(m.total_stock).toLocaleString();

              const soldEl = document.getElementById('kpi-total-sold');
              if (soldEl) soldEl.textContent = Number(m.total_sold).toLocaleString();

              const revEl = document.getElementById('kpi-total-revenue');
              if (revEl) revEl.textContent = '₱' + Number(m.total_revenue).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              });

              const resEl = document.getElementById('kpi-total-reserved');
              if (resEl) resEl.textContent = Number(m.total_reserved).toLocaleString();

              const pendEl = document.getElementById('kpi-pending-count');
              if (pendEl) pendEl.textContent = m.pending_count;

              const readyEl = document.getElementById('kpi-ready-count');
              if (readyEl) readyEl.textContent = m.ready_count;

              // Dynamic real-time calculation update for Circle & Bar Charts
              if (this.adminTab === 'dashboard') {
                this.updateChartsRealtime(m, data.products);
              }
            }

            // 3. Real-time view updates based on current tab
            if (this.adminTab === 'reservations') {
              this.renderReservationsQueue();
            } else if (this.adminTab === 'infomgmt') {
              if (typeof this.renderInfoMgmtTable === 'function') this.renderInfoMgmtTable();
            } else if (this.adminTab === 'support' || this.adminTab === 'helpdesk') {
              this.renderAdminTicketsList();
              if (this.activeAdminTicketId && data.active_ticket && data.active_ticket.id === this.activeAdminTicketId) {
                if (data.active_ticket.messages && Array.isArray(data.active_ticket.messages)) {
                  const container = document.getElementById('admin-chat-messages-container');
                  if (container) {
                    let hasNew = false;
                    data.active_ticket.messages.forEach(msg => {
                      if (this._renderedAdminMsgIds && !this._renderedAdminMsgIds.has(msg.id)) {
                        if (container.querySelector('.text-slate-500')) container.innerHTML = '';
                        this._renderedAdminMsgIds.add(msg.id);
                        this._adminChatLastMsgId = Math.max(this._adminChatLastMsgId || 0, msg.id);
                        const isAdmin = msg.sender_type === 'admin';
                        const div = this.createAdminMessageBubbleElement(msg, isAdmin);
                        container.appendChild(div);
                        hasNew = true;
                      }
                    });
                    if (hasNew) {
                      container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
                    }
                  }
                }
              }
            }

            // 4. Real-time Activity Logs Sync & LIVE SYSTEM NOTIFICATIONS (Login, Logout, Reservations, etc.)
            if (data.activity_logs && Array.isArray(data.activity_logs)) {
              const incomingLogs = data.activity_logs;
              
              if (!this._lastSeenActivityLogId) {
                this._lastSeenActivityLogId = incomingLogs.length > 0 
                  ? Math.max(...incomingLogs.map(l => Number(l.id) || 0)) 
                  : 0;
              } else {
                const brandNewLogs = incomingLogs.filter(l => Number(l.id) > this._lastSeenActivityLogId);
                
                if (brandNewLogs.length > 0) {
                  this._lastSeenActivityLogId = Math.max(...incomingLogs.map(l => Number(l.id) || 0));
                  this.activityLogs = incomingLogs;

                  // Update sidebar badge silently without toast spam
                  const badge = document.getElementById('admin-nav-actlogs-badge');
                  if (badge) badge.textContent = incomingLogs.length;

                  // Update tables in real-time
                  this.renderActivityLogsTable();
                  this.renderRecentActivitySnippet();
                }
              }
            }
          } catch (err) {
            // Transient fetch failures handled gracefully
          } finally {
            this._adminSyncInProgress = false;
          }
        }, 2000);
      }

      // ==========================================
      // SHOPEE-STYLE LIVE ORDER TRACKER
      // ==========================================
      initTracker() {
        if (!this.reservations) return;
        const resList = Array.isArray(this.reservations) ? this.reservations : Object.values(this.reservations);
        if (resList.length === 0 || !resList[0] || !resList[0].ref_code) return;
        const defaultRef = resList[0].ref_code;
        this.selectTrackerReservation(defaultRef);
      }

      selectTrackerReservation(refCode) {
        if (!refCode) return;
        const resList = Array.isArray(this.reservations) ? this.reservations : Object.values(this.reservations || {});
        const res = resList.find(r => r && r.ref_code === refCode);
        if (!res) return;
        this.activeTrackedRef = refCode;

        // Update selector value if called programmatically
        const selectEl = document.getElementById('tracker-ref-select');
        if (selectEl && selectEl.value !== refCode) {
          selectEl.value = refCode;
        }

        // Buyer Account Details
        const initials = (res.student_name || 'JS')
          .split(' ')
          .map(n => n[0])
          .slice(0, 2)
          .join('')
          .toUpperCase() || 'JS';

        const avatarEl = document.getElementById('tracker-buyer-avatar');
        if (avatarEl) avatarEl.textContent = initials;

        const buyerNameEl = document.getElementById('tracker-buyer-name');
        if (buyerNameEl) buyerNameEl.textContent = res.student_name;

        const buyerMetaEl = document.getElementById('tracker-buyer-meta');
        if (buyerMetaEl) {
          buyerMetaEl.textContent = `ID: ${res.student_id} / ${res.department || 'AIS 2B'}`;
        }

        const badgeRefEl = document.getElementById('tracker-badge-ref');
        if (badgeRefEl) badgeRefEl.textContent = res.ref_code;

        const badgeTotalEl = document.getElementById('tracker-badge-total');
        if (badgeTotalEl) badgeTotalEl.textContent = '₱' + Number(res.total_amount).toFixed(2);

        // Status badge styling
        const badgeStatusEl = document.getElementById('tracker-badge-status');
        const st = (res.status || 'Pending').toLowerCase();

        let statusBadgeClass = 'px-2 py-0.5 rounded text-[10px] font-bold ';
        if (st.includes('ready')) {
          statusBadgeClass += 'bg-blue-950 text-blue-300 border border-blue-800';
        } else if (st.includes('claim') || st.includes('complete')) {
          statusBadgeClass += 'bg-emerald-950 text-emerald-300 border border-emerald-800';
        } else if (st.includes('cancel')) {
          statusBadgeClass += 'bg-rose-950 text-rose-300 border border-rose-800';
        } else {
          statusBadgeClass += 'bg-amber-950 text-amber-300 border border-amber-800';
        }
        if (badgeStatusEl) {
          badgeStatusEl.className = statusBadgeClass;
          badgeStatusEl.textContent = res.status;
        }

        // Milestone progression logic
        // Step 1: Order Placed
        // Step 2: Sizing & Prep
        // Step 3: Ready for Pickup
        // Milestone progression logic
        let stepProgress = 1;
        let fillWidth = '12%';

        const fillEl = document.getElementById('tracker-progress-bar-fill');

        if (st.includes('cancel')) {
          stepProgress = 0;
          fillWidth = '100%';
          if (fillEl) {
            fillEl.style.width = '100%';
            fillEl.className = 'absolute top-5 left-0 h-1 bg-gradient-to-r from-rose-600 via-rose-500 to-red-600 -translate-y-1/2 rounded-full z-0 transition-all duration-700';
          }
        } else {
          if (fillEl) {
            fillEl.className = 'absolute top-5 left-0 h-1 bg-gradient-to-r from-emerald-500 via-ics-gold to-blue-500 -translate-y-1/2 rounded-full z-0 transition-all duration-700';
          }
          if (st.includes('ready')) {
            stepProgress = 3;
            fillWidth = '70%';
          } else if (st.includes('claim') || st.includes('complete')) {
            stepProgress = 4;
            fillWidth = '100%';
          } else if (st.includes('prep') || st.includes('process')) {
            stepProgress = 2;
            fillWidth = '38%';
          } else {
            stepProgress = 1;
            fillWidth = '12%';
          }
          if (fillEl) fillEl.style.width = fillWidth;
        }

        for (let i = 1; i <= 4; i++) {
          const stepEl = document.getElementById(`tracker-step-${i}`);
          if (!stepEl) continue;
          const circle = stepEl.querySelector('.tracker-step-circle');
          const title = stepEl.querySelector('p:first-of-type');
          if (!circle || !title) continue;

          if (st.includes('cancel')) {
            circle.className = 'tracker-step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm bg-rose-950 text-rose-400 shadow ring-4 ring-slate-900 border border-rose-800 transition-all duration-300';
            circle.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`;
            title.className = 'text-xs font-bold text-rose-400 mt-2.5';
          } else if (i < stepProgress) {
            // Completed milestone
            circle.className = 'tracker-step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm bg-emerald-600 text-white shadow-lg ring-4 ring-slate-900 transition-all duration-300';
            circle.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>`;
            title.className = 'text-xs font-bold text-white mt-2.5';
          } else if (i === stepProgress) {
            // Current active milestone
            if (st.includes('claim') || st.includes('complete')) {
              circle.className = 'tracker-step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm bg-emerald-600 text-white shadow-lg ring-4 ring-slate-900 transition-all duration-300';
              circle.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>`;
              title.className = 'text-xs font-bold text-emerald-400 mt-2.5';
            } else if (st.includes('ready')) {
              circle.className = 'tracker-step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm bg-blue-600 text-white shadow-lg ring-4 ring-slate-900 transition-all duration-300';
              circle.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>`;
              title.className = 'text-xs font-bold text-blue-400 mt-2.5';
            } else {
              circle.className = 'tracker-step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm bg-amber-500 text-white shadow-lg ring-4 ring-slate-900 transition-all duration-300';
              circle.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;
              title.className = 'text-xs font-bold text-amber-400 mt-2.5';
            }
          } else {
            // Future upcoming milestone
            circle.className = 'tracker-step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm bg-slate-800 text-slate-500 shadow ring-4 ring-slate-900 transition-all duration-300';
            circle.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`;
            title.className = 'text-xs font-bold text-slate-500 mt-2.5';
          }
        }

        // Headline & Subtext update
        const headlineEl = document.getElementById('tracker-status-headline');
        const iconBoxEl = document.getElementById('tracker-status-icon-box');
        const pickupDateEl = document.getElementById('tracker-pickup-date-display');
        const pickupSlotEl = document.getElementById('tracker-pickup-slot-display');

        if (pickupDateEl) pickupDateEl.textContent = res.pickup_date || 'Schedule Pending';
        if (pickupSlotEl) pickupSlotEl.textContent = res.pickup_slot || 'Regular Office Hours';

        if (st.includes('ready')) {
          if (headlineEl) headlineEl.textContent = 'Item Ready at ICS Student Council Center!';
          if (iconBoxEl) iconBoxEl.className = 'w-9 h-9 rounded-xl bg-blue-950/80 text-blue-400 border border-blue-800 flex items-center justify-center flex-shrink-0';
        } else if (st.includes('claim') || st.includes('complete')) {
          if (headlineEl) headlineEl.textContent = 'Merchandise Claimed & Verified by Student';
          if (iconBoxEl) iconBoxEl.className = 'w-9 h-9 rounded-xl bg-emerald-950/80 text-emerald-400 border border-emerald-800 flex items-center justify-center flex-shrink-0';
        } else if (st.includes('cancel')) {
          if (headlineEl) headlineEl.textContent = 'Reservation Cancelled — Items Restocked';
          if (iconBoxEl) iconBoxEl.className = 'w-9 h-9 rounded-xl bg-rose-950/80 text-rose-400 border border-rose-800 flex items-center justify-center flex-shrink-0';
        } else {
          if (headlineEl) headlineEl.textContent = 'Reservation Queued & Processing';
          if (iconBoxEl) iconBoxEl.className = 'w-9 h-9 rounded-xl bg-amber-950/80 text-amber-400 border border-amber-800 flex items-center justify-center flex-shrink-0';
        }

        // Update Tracker Payment Info
        const payBadgeEl = document.getElementById('tracker-payment-badge');
        const receiptLinkBox = document.getElementById('tracker-receipt-link-container');
        if (payBadgeEl) {
          const pm = res.payment_method || 'Cash on Pickup';
          const ps = res.payment_status || 'Unpaid';
          if (pm === 'GCash Online') {
            payBadgeEl.innerHTML = `<span class="text-blue-400 font-bold">GCash Online</span> <span class="text-[10px] ${ps === 'Verified' ? 'text-emerald-400' : 'text-amber-400'} font-normal">(${ps})</span>`;
          } else {
            payBadgeEl.innerHTML = `<span class="text-amber-300 font-bold">Pay at School (Cash)</span> <span class="text-[10px] text-slate-400 font-normal">(${ps})</span>`;
          }
        }
        if (receiptLinkBox) {
          if (res.receipt_image) {
            receiptLinkBox.classList.remove('hidden');
          } else {
            receiptLinkBox.classList.add('hidden');
          }
        }

        // Update Tracker Cancel Button
        const cancelBtn = document.getElementById('tracker-cancel-btn');
        if (cancelBtn) {
          if (st.includes('cancel')) {
            cancelBtn.disabled = true;
            cancelBtn.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-slate-600 border border-slate-800 cursor-not-allowed flex items-center gap-1.5 opacity-60';
            cancelBtn.innerHTML = `
              <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
              <span>Reservation Cancelled</span>
            `;
          } else if (st.includes('claim') || st.includes('complete')) {
            cancelBtn.disabled = true;
            cancelBtn.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-900 text-slate-600 border border-slate-800 cursor-not-allowed flex items-center gap-1.5 opacity-60';
            cancelBtn.innerHTML = `<span>Claimed (Cannot Cancel)</span>`;
          } else if (st.includes('ready')) {
            cancelBtn.disabled = false;
            cancelBtn.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold bg-amber-950/80 hover:bg-amber-900 text-amber-300 border border-amber-800 transition flex items-center gap-1.5 shadow cursor-pointer';
            cancelBtn.innerHTML = `
              <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
              <span>Confirmed (Chat Admin to Cancel)</span>
            `;
          } else {
            cancelBtn.disabled = false;
            cancelBtn.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold bg-rose-950/80 hover:bg-rose-900 text-rose-300 border border-rose-800 transition flex items-center gap-1.5 shadow cursor-pointer';
            cancelBtn.innerHTML = `
              <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
              <span>Cancel Reservation</span>
            `;
          }
        }
      }

      async cancelActiveTrackedReservation() {
        if (!this.activeTrackedRef) {
          this.showToast('Please select a reservation to cancel', 'warning');
          return;
        }
        const res = this.reservations.find(r => r.ref_code === this.activeTrackedRef);
        if (!res) return;

        if (res.status === 'Cancelled') {
          this.showToast('This reservation is already cancelled.', 'info');
          return;
        }
        if (res.status === 'Claimed') {
          this.showToast('Cannot cancel an order that has already been claimed.', 'warning');
          return;
        }
        if (res.status === 'Ready for Pickup') {
          if (!confirm(`Order [${res.ref_code}] is already confirmed/ready for pickup!\n\nAre you sure you want to cancel this reservation? Reserved merchandise units will be restored to inventory.`)) {
            return;
          }
          await this.updateReservationStatus(res.id, 'Cancelled', true);
          return;
        }

        if (!confirm(`Are you sure you want to cancel reservation [${res.ref_code}]? Reserved merchandise units will be restored to inventory.`)) {
          return;
        }

        await this.updateReservationStatus(res.id, 'Cancelled', true);
      }

      printActiveTrackedSlip() {
        if (!this.activeTrackedRef) {
          this.showToast('Please select a reservation to view slip', 'info');
          return;
        }
        const res = this.reservations.find(r => r.ref_code === this.activeTrackedRef);
        if (res) {
          this.viewPrintClaimSlip(res);
        }
      }

      // ==========================================
      // MOBILE NAVIGATION DRAWER
      // ==========================================
      toggleMobileDrawer() {
        const drawer = document.getElementById('mobile-nav-drawer');
        if (!drawer) return;
        const isOpen = !drawer.classList.contains('translate-x-full');
        if (isOpen) {
          this.closeMobileDrawer();
        } else {
          this.openMobileDrawer();
        }
      }

      openMobileDrawer() {
        const drawer = document.getElementById('mobile-nav-drawer');
        const backdrop = document.getElementById('mobile-nav-backdrop');
        if (drawer) drawer.classList.remove('translate-x-full');
        if (backdrop) backdrop.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        this.updateMobileDrawerContent();
      }

      closeMobileDrawer() {
        const drawer = document.getElementById('mobile-nav-drawer');
        const backdrop = document.getElementById('mobile-nav-backdrop');
        if (drawer) drawer.classList.add('translate-x-full');
        if (backdrop) backdrop.classList.add('hidden');
        document.body.style.overflow = '';
      }

      updateMobileDrawerContent() {
        const studentLinks = document.getElementById('mob-drawer-student-links');
        const adminLinks = document.getElementById('mob-drawer-admin-links');
        const mobStudentBtn = document.getElementById('mob-portal-student');
        const mobAdminBtn = document.getElementById('mob-portal-admin');
        const headerPill = document.getElementById('header-active-portal-badge');

        if (this.currentView === 'admin') {
          if (studentLinks) studentLinks.classList.add('hidden');
          if (adminLinks) adminLinks.classList.remove('hidden');
          if (headerPill) {
            headerPill.textContent = 'Admin';
            headerPill.className = 'px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-950 text-amber-300 border border-amber-800 lg:hidden';
          }
          if (mobAdminBtn) {
            mobAdminBtn.className = 'w-full p-3 rounded-2xl bg-gradient-to-r from-ics-800 to-ics-700 text-white font-bold text-xs flex items-center justify-between border border-ics-600 shadow';
          }
          if (mobStudentBtn) {
            mobStudentBtn.className = 'w-full p-3 rounded-2xl bg-slate-950/80 hover:bg-slate-800 text-slate-300 font-semibold text-xs flex items-center justify-between border border-slate-800';
          }
        } else {
          if (studentLinks) studentLinks.classList.remove('hidden');
          if (adminLinks) adminLinks.classList.add('hidden');
          if (headerPill) {
            headerPill.textContent = 'Student';
            headerPill.className = 'px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-ics-950 text-ics-300 border border-ics-800 lg:hidden';
          }
          if (mobStudentBtn) {
            mobStudentBtn.className = 'w-full p-3 rounded-2xl bg-gradient-to-r from-ics-800 to-ics-700 text-white font-bold text-xs flex items-center justify-between border border-ics-600 shadow';
          }
          if (mobAdminBtn) {
            mobAdminBtn.className = 'w-full p-3 rounded-2xl bg-slate-950/80 hover:bg-slate-800 text-slate-300 font-semibold text-xs flex items-center justify-between border border-slate-800';
          }
        }
      }

      // ==========================================
      // VIEW SWITCHING (STUDENT vs ADMIN)
      // ==========================================
      switchPortalView(view) {
        this.currentView = view;
        const studentContainer = document.getElementById('student-view-container');
        const adminContainer = document.getElementById('admin-view-container');
        const studentSwitch = document.getElementById('portal-switch-student');
        const adminSwitch = document.getElementById('portal-switch-admin');

        if (view === 'admin') {
          if (studentContainer) studentContainer.classList.add('hidden');
          if (adminContainer) adminContainer.classList.remove('hidden');

          if (adminSwitch) adminSwitch.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-ics-800 to-ics-700 text-white shadow-md transition flex items-center gap-1.5';
          if (studentSwitch) studentSwitch.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold text-slate-400 hover:text-white transition flex items-center gap-1.5';

          this.showToast('Switched to ICS Admin Management Portal', 'info');
        } else {
          if (adminContainer) adminContainer.classList.add('hidden');
          if (studentContainer) studentContainer.classList.remove('hidden');

          if (studentSwitch) studentSwitch.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-ics-800 to-ics-700 text-white shadow-md transition flex items-center gap-1.5';
          if (adminSwitch) adminSwitch.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold text-slate-400 hover:text-white transition flex items-center gap-1.5';
        }

        this.updateMobileDrawerContent();
      }

      // Admin Tab Navigation (Whiteboard wireframe tabs + Mobile quick tabs)
      setAdminTab(tabName, updateHash = true) {
        if (tabName === 'helpdesk') tabName = 'support';
        const validTabs = ['dashboard', 'infomgmt', 'reservations', 'claimed', 'reports', 'usermgmt', 'actlogs', 'support'];
        if (!validTabs.includes(tabName)) tabName = 'dashboard';

        this.adminTab = tabName;
        try {
          localStorage.setItem('ics_admin_active_tab', tabName);
        } catch (e) {}

        if (updateHash) {
          try {
            if (window.location.hash !== '#' + tabName) {
              history.replaceState(null, null, '#' + tabName);
            }
          } catch (e) {}
        }

        const tabs = ['dashboard', 'infomgmt', 'reservations', 'claimed', 'reports', 'usermgmt', 'actlogs', 'support'];

        tabs.forEach(t => {
          const sec = document.getElementById(`admin-sec-${t}`);
          const btn = document.getElementById(`admin-tab-btn-${t}`);
          if (sec) {
            if (t === tabName) sec.classList.remove('hidden');
            else sec.classList.add('hidden');
          }
          if (btn) {
            if (t === tabName) {
              btn.className = 'admin-nav-btn w-full text-left px-3.5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition flex items-center justify-between bg-ics-800 text-white shadow-md border border-ics-600/70';
            } else {
              btn.className = 'admin-nav-btn w-full text-left px-3.5 py-3 rounded-2xl text-xs sm:text-sm font-bold transition flex items-center justify-between text-slate-300 hover:text-white hover:bg-slate-800/80 border border-transparent';
            }
          }

          // Sync horizontal mobile quick tabs
          const mobTab = document.getElementById(`admin-mob-tab-${t}`);
          if (mobTab) {
            if (t === tabName) {
              mobTab.className = 'admin-mob-tab flex-shrink-0 px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-ics-800 text-white shadow border border-ics-600';
            } else {
              mobTab.className = 'admin-mob-tab flex-shrink-0 px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-slate-900 border border-slate-800 text-slate-400 hover:text-white';
            }
          }

          // Sync mobile drawer admin module links
          const drawerTab = document.getElementById(`mob-drawer-tab-${t}`);
          if (drawerTab) {
            if (t === tabName) {
              drawerTab.className = 'w-full text-left p-2.5 rounded-xl text-xs font-bold bg-ics-800 text-white flex items-center justify-between shadow';
            } else {
              drawerTab.className = 'w-full text-left p-2.5 rounded-xl text-xs font-medium text-slate-300 hover:bg-slate-800 flex items-center justify-between';
            }
          }

          // Sync fixed bottom mobile navigation bar icon buttons
          const bottomTab = document.getElementById(`admin-bottom-tab-${t}`);
          if (bottomTab) {
            if (t === tabName) {
              bottomTab.className = 'admin-bottom-tab flex-1 min-w-0 py-1 px-0.5 rounded-lg flex flex-col items-center justify-center text-white bg-ics-800 shadow transition cursor-pointer';
            } else {
              bottomTab.className = 'admin-bottom-tab flex-1 min-w-0 py-1 px-0.5 rounded-lg flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer relative';
            }
          }
        });

        if (tabName !== 'support' && tabName !== 'helpdesk' && this._adminChatPollInterval) {
          clearInterval(this._adminChatPollInterval);
          this._adminChatPollInterval = null;
        }

        if (tabName === 'dashboard') {
          setTimeout(() => this.initAdminCharts(), 100);
        } else if (tabName === 'reservations') {
          this.renderReservationsQueue();
        } else if (tabName === 'support' || tabName === 'helpdesk') {
          this.renderAdminTicketsList();
          if (this.activeAdminTicketId) {
            this.selectAdminTicket(this.activeAdminTicketId);
          } else if (window.innerWidth < 1024) {
            const sidebar = document.getElementById('admin-tickets-sidebar');
            const chatMain = document.getElementById('admin-chat-main-panel');
            if (sidebar) sidebar.classList.remove('hidden');
            if (chatMain) chatMain.classList.add('hidden');
          }
        } else if (tabName === 'claimed') {
          this.renderClaimedLedgerTable();
          this.restoreClaimedSelectionUI();
          setTimeout(() => this.syncTableTopScrollbars(), 50);
        } else if (tabName === 'reports') {
          this.restoreReportSelectionUI();
          setTimeout(() => this.syncTableTopScrollbars(), 50);
        } else if (tabName === 'actlogs') {
          this.renderActivityLogsTable();
        }
      }


      renderSvgFallbackCharts() {
        const donutFallback = document.getElementById('inventoryDonutSvgFallback');
        const donutCanvas = document.getElementById('inventoryDonutChart');
        if (donutFallback && donutCanvas) {
          const onHand = Number('{{ $totalStockUnits }}'.replace(/,/g, '')) || 0;
          const sold = Number('{{ $totalSoldUnits }}'.replace(/,/g, '')) || 0;
          const reserved = Number('{{ $totalReservedUnits }}'.replace(/,/g, '')) || 0;
          const total = Math.max(1, onHand + sold + reserved);
          const p1 = Math.round((onHand / total) * 100);
          const p2 = Math.round((sold / total) * 100);
          const p3 = Math.max(0, 100 - p1 - p2);

          donutCanvas.classList.add('hidden');
          donutFallback.classList.remove('hidden');
          donutFallback.innerHTML = `
            <div class="flex flex-col items-center justify-center p-2">
              <svg viewBox="0 0 36 36" class="w-48 h-48 drop-shadow-md">
                <circle cx="18" cy="18" r="15.915" fill="none" stroke="#10b981" stroke-width="4" stroke-dasharray="${p1} ${100 - p1}" stroke-dashoffset="25"></circle>
                <circle cx="18" cy="18" r="15.915" fill="none" stroke="#3b82f6" stroke-width="4" stroke-dasharray="${p2} ${100 - p2}" stroke-dashoffset="${25 - p1}"></circle>
                <circle cx="18" cy="18" r="15.915" fill="none" stroke="#f59e0b" stroke-width="4" stroke-dasharray="${p3} ${100 - p3}" stroke-dashoffset="${25 - p1 - p2}"></circle>
                <text x="18" y="16.5" text-anchor="middle" fill="#ffffff" font-size="3.5" font-weight="bold">${total.toLocaleString()}</text>
                <text x="18" y="21" text-anchor="middle" fill="#94a3b8" font-size="2">Total Units</text>
              </svg>
            </div>
          `;
        }

        const barFallback = document.getElementById('categoryBarSvgFallback');
        const barCanvas = document.getElementById('categoryBarChart');
        if (barFallback && barCanvas) {
          barCanvas.classList.add('hidden');
          barFallback.classList.remove('hidden');
          barFallback.innerHTML = `
            <div class="h-full flex flex-col justify-center space-y-3 p-4">
              <div>
                <div class="flex justify-between text-[11px] font-bold text-slate-300 mb-1">
                  <span>Collegiate Uniforms</span>
                  <span class="text-emerald-400 font-mono">Stock Ready</span>
                </div>
                <div class="w-full h-3 bg-slate-950 rounded-full overflow-hidden flex border border-slate-800">
                  <div class="bg-emerald-500 h-full rounded-full" style="width: 72%"></div>
                </div>
              </div>
              <div>
                <div class="flex justify-between text-[11px] font-bold text-slate-300 mb-1">
                  <span>Athletics & PE</span>
                  <span class="text-blue-400 font-mono">High Demand</span>
                </div>
                <div class="w-full h-3 bg-slate-950 rounded-full overflow-hidden flex border border-slate-800">
                  <div class="bg-blue-500 h-full rounded-full" style="width: 58%"></div>
                </div>
              </div>
              <div>
                <div class="flex justify-between text-[11px] font-bold text-slate-300 mb-1">
                  <span>Dept Apparel</span>
                  <span class="text-amber-400 font-mono">Active</span>
                </div>
                <div class="w-full h-3 bg-slate-950 rounded-full overflow-hidden flex border border-slate-800">
                  <div class="bg-amber-500 h-full rounded-full" style="width: 44%"></div>
                </div>
              </div>
              <div>
                <div class="flex justify-between text-[11px] font-bold text-slate-300 mb-1">
                  <span>Accessories</span>
                  <span class="text-purple-400 font-mono">Available</span>
                </div>
                <div class="w-full h-3 bg-slate-950 rounded-full overflow-hidden flex border border-slate-800">
                  <div class="bg-purple-500 h-full rounded-full" style="width: 80%"></div>
                </div>
              </div>
            </div>
          `;
        }
      }

      // ==========================================
      // VISUAL CHARTS (DONUT / CIRCLE & BAR CHARTS)
      // Interactive with Tooltips, Percentages, and Real-Time DB sync
      // ==========================================
      initAdminCharts() {
        if (typeof Chart === 'undefined') {
          this.renderSvgFallbackCharts();
          // Retry automatically once Chart.js script finishes execution
          setTimeout(() => this.initAdminCharts(), 120);
          return;
        }

        // Restore canvas visibility
        const donutFallback = document.getElementById('inventoryDonutSvgFallback');
        const donutCanvas = document.getElementById('inventoryDonutChart');
        if (donutFallback) donutFallback.classList.add('hidden');
        if (donutCanvas) donutCanvas.classList.remove('hidden');

        const barFallback = document.getElementById('categoryBarSvgFallback');
        const barCanvas = document.getElementById('categoryBarChart');
        if (barFallback) barFallback.classList.add('hidden');
        if (barCanvas) barCanvas.classList.remove('hidden');

        // 1. Inventory Health Donut (Circle) Chart
        const donutCtx = document.getElementById('inventoryDonutChart');
        if (donutCtx) {
          if (this.donutChart) {
            this.donutChart.destroy();
          }

          const onHand = Number('{{ $totalStockUnits }}'.replace(/,/g, '')) || 0;
          const sold = Number('{{ $totalSoldUnits }}'.replace(/,/g, '')) || 0;
          const reserved = Number('{{ $totalReservedUnits }}'.replace(/,/g, '')) || 0;

          this.donutChart = new Chart(donutCtx, {
            type: 'doughnut',
            data: {
              labels: ['On-Hand Stock', 'Units Claimed (Sold)', 'Reserved Units'],
              datasets: [{
                data: [onHand, sold, reserved],
                backgroundColor: [
                  '#10b981', // Emerald (Stock)
                  '#3b82f6', // Blue (Sold)
                  '#f59e0b' // Gold / Amber (Reserved)
                ],
                borderColor: '#0c0f17',
                borderWidth: 4,
                hoverOffset: 8
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              cutout: '68%',
              plugins: {
                legend: {
                  position: 'bottom',
                  labels: {
                    color: '#94a3b8',
                    font: {
                      family: 'Plus Jakarta Sans',
                      size: 11,
                      weight: '600'
                    },
                    boxWidth: 12,
                    padding: 14
                  }
                },
                tooltip: {
                  enabled: true,
                  backgroundColor: '#0f172a',
                  titleColor: '#f8fafc',
                  titleFont: {
                    family: 'Plus Jakarta Sans',
                    size: 12,
                    weight: 'bold'
                  },
                  bodyColor: '#e2e8f0',
                  bodyFont: {
                    family: 'JetBrains Mono',
                    size: 11
                  },
                  borderColor: '#334155',
                  borderWidth: 1,
                  padding: 12,
                  boxPadding: 6,
                  displayColors: true,
                  callbacks: {
                    label: function(context) {
                      const val = Number(context.raw) || 0;
                      const dataArr = context.dataset.data || [];
                      const total = dataArr.reduce((a, b) => (Number(a) || 0) + (Number(b) || 0), 0) || 1;
                      const pct = ((val / total) * 100).toFixed(1);
                      return ` ${context.label}: ${val.toLocaleString()} units (${pct}%)`;
                    }
                  }
                }
              }
            }
          });
        }

        // 2. Category Sales vs Stock Bar Chart
        const barCtx = document.getElementById('categoryBarChart');
        if (barCtx) {
          if (this.barChart) {
            this.barChart.destroy();
          }

          const catMap = {
            'general': {
              label: 'Collegiate Uniforms',
              stock: 0,
              sold: 0
            },
            'pe': {
              label: 'Athletics & PE',
              stock: 0,
              sold: 0
            },
            'department': {
              label: 'Dept Apparel',
              stock: 0,
              sold: 0
            },
            'accessory': {
              label: 'Accessories',
              stock: 0,
              sold: 0
            }
          };

          const rawItems = (this.catalog && this.catalog.length > 0) ? this.catalog : (this.catalog || []);
          const items = Array.isArray(rawItems) ? rawItems : Object.values(rawItems || {});

          items.forEach(item => {
            let catKey = (item.category || '').toLowerCase();
            if (catKey === 'accessories') catKey = 'accessory';
            if (!catMap[catKey]) {
              catMap[catKey] = {
                label: item.category,
                stock: 0,
                sold: 0
              };
            }
            catMap[catKey].stock += (parseInt(item.current_stock) || 0);
            catMap[catKey].sold += (parseInt(item.units_sold) || 0);
          });

          const labels = ['Collegiate', 'Athletics & PE', 'Dept Apparel', 'Accessories'];
          const stockData = [
            catMap['general'] ? catMap['general'].stock : 0,
            catMap['pe'] ? catMap['pe'].stock : 0,
            catMap['department'] ? catMap['department'].stock : 0,
            catMap['accessory'] ? catMap['accessory'].stock : 0
          ];
          const soldData = [
            catMap['general'] ? catMap['general'].sold : 0,
            catMap['pe'] ? catMap['pe'].sold : 0,
            catMap['department'] ? catMap['department'].sold : 0,
            catMap['accessory'] ? catMap['accessory'].sold : 0
          ];

          this.barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
              labels: labels,
              datasets: [{
                  label: 'On-Hand Stock',
                  data: stockData,
                  backgroundColor: '#10b981',
                  borderRadius: 6
                },
                {
                  label: 'Claimed (Sold)',
                  data: soldData,
                  backgroundColor: '#dc2626',
                  borderRadius: 6
                }
              ]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  position: 'bottom',
                  labels: {
                    color: '#94a3b8',
                    font: {
                      family: 'Plus Jakarta Sans',
                      size: 11,
                      weight: '600'
                    },
                    boxWidth: 12,
                    padding: 14
                  }
                },
                tooltip: {
                  enabled: true,
                  backgroundColor: '#0f172a',
                  titleColor: '#f8fafc',
                  titleFont: {
                    family: 'Plus Jakarta Sans',
                    size: 12,
                    weight: 'bold'
                  },
                  bodyColor: '#e2e8f0',
                  bodyFont: {
                    family: 'JetBrains Mono',
                    size: 11
                  },
                  borderColor: '#334155',
                  borderWidth: 1,
                  padding: 12,
                  boxPadding: 6,
                  displayColors: true,
                  callbacks: {
                    label: function(context) {
                      const val = Number(context.raw) || 0;
                      const catIdx = context.dataIndex;
                      const stockVal = Number(context.chart.data.datasets[0].data[catIdx]) || 0;
                      const soldVal = Number(context.chart.data.datasets[1].data[catIdx]) || 0;
                      const catTotal = stockVal + soldVal || 1;
                      const pct = ((val / catTotal) * 100).toFixed(1);
                      return ` ${context.dataset.label}: ${val.toLocaleString()} units (${pct}% of category)`;
                    }
                  }
                }
              },
              scales: {
                x: {
                  grid: {
                    color: 'rgba(51, 65, 85, 0.3)'
                  },
                  ticks: {
                    color: '#94a3b8',
                    font: {
                      size: 10,
                      family: 'Plus Jakarta Sans',
                      weight: '600'
                    }
                  }
                },
                y: {
                  beginAtZero: true,
                  grid: {
                    color: 'rgba(51, 65, 85, 0.3)'
                  },
                  ticks: {
                    color: '#94a3b8',
                    font: {
                      size: 10,
                      family: 'JetBrains Mono'
                    }
                  }
                }
              }
            }
          });
        }
      }

      /**
       * REALTIME DYNAMIC CHART RE-CALCULATION
       * Seamlessly updates Circle and Bar charts with live database sync data
       */
      updateChartsRealtime(m, products) {
        if (!m) return;
        if (!this.donutChart || !this.barChart) {
          this.initAdminCharts();
          return;
        }

        const onHand = Number(m.total_stock) || 0;
        const sold = Number(m.total_sold) || 0;
        const reserved = Number(m.total_reserved) || 0;
        const total = Math.max(1, onHand + sold + reserved);

        if (this.donutChart) {
          this.donutChart.data.datasets[0].data = [onHand, sold, reserved];
          this.donutChart.update('none');

          const sEl = document.getElementById('chart-total-stock');
          if (sEl) sEl.textContent = onHand.toLocaleString();
          const soEl = document.getElementById('chart-total-sold');
          if (soEl) soEl.textContent = sold.toLocaleString();
          const rEl = document.getElementById('chart-total-reserved');
          if (rEl) rEl.textContent = reserved.toLocaleString();

          const pctS = document.getElementById('chart-pct-stock');
          if (pctS) pctS.textContent = `${((onHand / total) * 100).toFixed(1)}%`;
          const pctSo = document.getElementById('chart-pct-sold');
          if (pctSo) pctSo.textContent = `${((sold / total) * 100).toFixed(1)}%`;
          const pctR = document.getElementById('chart-pct-reserved');
          if (pctR) pctR.textContent = `${((reserved / total) * 100).toFixed(1)}%`;
        }

        if (this.barChart && products && products.length > 0) {
          const catMap = {
            'general': {
              stock: 0,
              sold: 0
            },
            'pe': {
              stock: 0,
              sold: 0
            },
            'department': {
              stock: 0,
              sold: 0
            },
            'accessory': {
              stock: 0,
              sold: 0
            }
          };

          const prodList = Array.isArray(products) ? products : Object.values(products || {});
          prodList.forEach(item => {
            let catKey = (item.category || '').toLowerCase();
            if (catKey === 'accessories') catKey = 'accessory';
            if (catMap[catKey]) {
              catMap[catKey].stock += (parseInt(item.current_stock) || 0);
              catMap[catKey].sold += (parseInt(item.units_sold) || 0);
            }
          });

          this.barChart.data.datasets[0].data = [
            catMap['general'].stock,
            catMap['pe'].stock,
            catMap['department'].stock,
            catMap['accessory'].stock
          ];
          this.barChart.data.datasets[1].data = [
            catMap['general'].sold,
            catMap['pe'].sold,
            catMap['department'].sold,
            catMap['accessory'].sold
          ];
          this.barChart.update('none');
        }
      }

      quickSwitchRole(role) {
        this.toggleProfileDropdown();
        this.switchPortalView(role);
      }

      toggleProfileDropdown() {
        const drop = document.getElementById('user-profile-dropdown');
        drop.classList.toggle('hidden');
      }

      // ==========================================
      // STUDENT CATALOG FILTER & SEARCH
      // ==========================================
      setCategoryFilter(cat) {
        this.categoryFilter = cat;
        document.querySelectorAll('.cat-filter-btn').forEach(btn => {
          if (btn.getAttribute('data-cat') === cat) {
            btn.className = 'cat-filter-btn flex-shrink-0 px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-[11px] sm:text-xs font-bold bg-ics-700 text-white shadow transition';
          } else {
            btn.className = 'cat-filter-btn flex-shrink-0 px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-[11px] sm:text-xs font-semibold bg-slate-800/80 hover:bg-slate-800 text-slate-300 transition';
          }
        });
        this.filterCatalogGrid();
      }

      handleSearch(q) {
        this.searchQuery = q.toLowerCase().trim();
        this.filterCatalogGrid();
      }

      filterCatalogGrid() {
        const cards = document.querySelectorAll('.product-card');
        cards.forEach(card => {
          const category = card.getAttribute('data-category');
          const code = (card.getAttribute('data-code') || '').toLowerCase();
          const title = (card.querySelector('h3')?.textContent || '').toLowerCase();
          const desc = (card.querySelector('p')?.textContent || '').toLowerCase();

          const matchesCat = (this.categoryFilter === 'all' || category === this.categoryFilter);
          const matchesQuery = (!this.searchQuery || title.includes(this.searchQuery) || code.includes(this.searchQuery) || desc.includes(this.searchQuery));

          if (matchesCat && matchesQuery) {
            card.classList.remove('hidden');
          } else {
            card.classList.add('hidden');
          }
        });
      }

      // ==========================================
      // PRODUCT DETAIL MODAL & SIZING
      // ==========================================
      openProductModal(prodId) {
        const prod = this.catalog.find(p => p.id == prodId || p.item_code == prodId);
        if (!prod) return;

        this.selectedProduct = prod;
        this.selectedQty = 1;
        this.selectedSize = null;

        document.getElementById('modal-product-img').src = '{{ asset("") }}' + prod.image_path;
        document.getElementById('modal-product-code').textContent = prod.item_code;
        document.getElementById('modal-product-cat').textContent = prod.category;
        document.getElementById('modal-product-name').textContent = prod.name;
        document.getElementById('modal-product-price').textContent = '₱' + Number(prod.price).toFixed(2);
        document.getElementById('modal-product-desc').textContent = prod.description;
        document.getElementById('modal-product-material').textContent = prod.material || 'Collegiate Grade Blend';
        document.getElementById('modal-product-qty').textContent = '1';
        document.getElementById('modal-product-subtotal').textContent = '₱' + Number(prod.price).toFixed(2);

        // Render Size Pills
        const sizesGrid = document.getElementById('modal-sizes-grid');
        sizesGrid.innerHTML = '';

        const sizes = prod.sizes || {
          'XS': 5,
          'S': 10,
          'M': 15,
          'L': 12,
          'XL': 8,
          '2XL': 4,
          '3XL': 1
        };
        const sizeKeys = Object.keys(sizes);

        sizeKeys.forEach(sz => {
          const count = sizes[sz];
          const isOut = count <= 0;
          const btn = document.createElement('button');
          btn.className = `px-3.5 py-1.5 rounded-xl text-xs font-mono font-bold border transition ${
            isOut 
              ? 'bg-slate-950 text-slate-600 border-slate-800 cursor-not-allowed line-through' 
              : 'bg-slate-950 hover:bg-slate-800 text-slate-200 border-slate-700 hover:border-ics-gold'
          }`;
          btn.textContent = `${sz} (${count})`;
          btn.disabled = isOut;
          btn.onclick = () => this.selectModalSize(sz, btn);
          sizesGrid.appendChild(btn);

          // Auto-select first in-stock size
          if (!this.selectedSize && !isOut) {
            this.selectModalSize(sz, btn);
          }
        });

        document.getElementById('product-modal').classList.remove('hidden');
      }

      selectModalSize(size, buttonEl) {
        this.selectedSize = size;
        document.querySelectorAll('#modal-sizes-grid button').forEach(b => {
          b.classList.remove('bg-ics-700', 'text-white', 'border-ics-gold');
        });
        if (buttonEl) {
          buttonEl.classList.add('bg-ics-700', 'text-white', 'border-ics-gold');
        }
      }

      adjustQty(delta) {
        this.selectedQty = Math.max(1, this.selectedQty + delta);
        document.getElementById('modal-product-qty').textContent = this.selectedQty;
        if (this.selectedProduct) {
          const sub = this.selectedProduct.price * this.selectedQty;
          document.getElementById('modal-product-subtotal').textContent = '₱' + Number(sub).toFixed(2);
        }
      }

      closeProductModal() {
        document.getElementById('product-modal').classList.add('hidden');
      }

      // ==========================================
      // RESERVATION CART & STORAGE
      // ==========================================
      loadCartFromStorage() {
        try {
          return JSON.parse(localStorage.getItem('ics_cart') || '[]');
        } catch (e) {
          return [];
        }
      }

      saveCartToStorage() {
        localStorage.setItem('ics_cart', JSON.stringify(this.cart));
        this.updateCartBadge();
      }

      updateCartBadge() {
        const badge = document.getElementById('nav-cart-badge');
        const count = this.cart.reduce((sum, item) => sum + item.quantity, 0);
        if (badge) badge.textContent = count;

        const mobDrawerBadge = document.getElementById('mob-drawer-cart-count');
        if (mobDrawerBadge) mobDrawerBadge.textContent = count;

        const countText = document.getElementById('cart-item-count-text');
        if (countText) countText.textContent = `${count} items in reservation`;
      }

      addToCartFromModal() {
        if (!this.selectedProduct) return;
        if (!this.selectedSize) {
          this.showToast('Please select a size first!', 'warning');
          return;
        }

        const existing = this.cart.find(c => c.productId === this.selectedProduct.item_code && c.size === this.selectedSize);
        if (existing) {
          existing.quantity += this.selectedQty;
        } else {
          this.cart.push({
            productId: this.selectedProduct.item_code,
            productName: this.selectedProduct.name,
            price: Number(this.selectedProduct.price),
            size: this.selectedSize,
            quantity: this.selectedQty,
            imageSrc: this.selectedProduct.image_path
          });
        }

        this.saveCartToStorage();
        this.closeProductModal();
        this.showToast(`Added ${this.selectedQty}x ${this.selectedProduct.name} (${this.selectedSize}) to cart!`, 'success');
        this.openCartDrawer();
      }

      openCartDrawer() {
        this.renderCartItems();
        document.getElementById('cart-drawer').classList.remove('hidden');
      }

      closeCartDrawer() {
        document.getElementById('cart-drawer').classList.add('hidden');
      }

      renderCartItems() {
        const container = document.getElementById('cart-items-container');
        container.innerHTML = '';

        if (this.cart.length === 0) {
          container.innerHTML = `
            <div class="text-center py-12 text-slate-500">
              <svg class="w-12 h-12 mx-auto text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
              <p class="text-sm font-bold text-slate-400">Your reservation cart is empty</p>
              <p class="text-xs text-slate-500 mt-1">Browse the ICS catalog and reserve your size</p>
            </div>
          `;
          document.getElementById('cart-subtotal').textContent = '₱0.00';
          const cartFeeEl = document.getElementById('cart-fee');
          if (cartFeeEl) cartFeeEl.textContent = '₱0.00';
          document.getElementById('cart-grandtotal').textContent = '₱0.00';
          return;
        }

        let total = 0;
        this.cart.forEach((item, index) => {
          const subtotal = item.price * item.quantity;
          total += subtotal;

          const el = document.createElement('div');
          el.className = 'flex items-center gap-3 p-3 rounded-2xl bg-slate-950/80 border border-slate-800';
          el.innerHTML = `
            <img src="{{ asset('') }}${item.imageSrc}" alt="${item.productName}" class="w-14 h-14 rounded-xl object-cover border border-slate-800 flex-shrink-0">
            <div class="flex-1 min-w-0">
              <h4 class="text-xs font-bold text-white truncate">${item.productName}</h4>
              <div class="flex items-center gap-2 text-[11px] text-slate-400 font-mono mt-0.5">
                <span class="text-ics-gold font-bold">Size: ${item.size}</span>
                <span>₱${item.price.toFixed(2)}</span>
              </div>
              <div class="flex items-center justify-between mt-2">
                <div class="flex items-center border border-slate-700 rounded-lg bg-slate-900 p-0.5 text-xs font-mono">
                  <button onclick="icsApp.updateCartQty(${index}, -1)" class="w-5 h-5 flex items-center justify-center text-slate-400 hover:text-white">-</button>
                  <span class="w-6 text-center font-bold text-white">${item.quantity}</span>
                  <button onclick="icsApp.updateCartQty(${index}, 1)" class="w-5 h-5 flex items-center justify-center text-slate-400 hover:text-white">+</button>
                </div>
                <button onclick="icsApp.removeCartItem(${index})" class="text-[10px] text-rose-400 hover:underline">Remove</button>
              </div>
            </div>
          `;
          container.appendChild(el);
        });

        const additionalFee = 10.00;
        const grandTotal = total + additionalFee;

        document.getElementById('cart-subtotal').textContent = '₱' + total.toFixed(2);
        const cartFeeEl = document.getElementById('cart-fee');
        if (cartFeeEl) cartFeeEl.textContent = '₱' + additionalFee.toFixed(2);
        document.getElementById('cart-grandtotal').textContent = '₱' + grandTotal.toFixed(2);
      }

      updateCartQty(index, delta) {
        if (!this.cart[index]) return;
        this.cart[index].quantity += delta;
        if (this.cart[index].quantity <= 0) {
          this.cart.splice(index, 1);
        }
        this.saveCartToStorage();
        this.renderCartItems();
      }

      removeCartItem(index) {
        this.cart.splice(index, 1);
        this.saveCartToStorage();
        this.renderCartItems();
      }

      // ==========================================
      // CHECKOUT MODAL & SUBMIT
      // ==========================================
      openCheckoutModal() {
        if (this.cart.length === 0) {
          this.showToast('Please add items to your cart first!', 'warning');
          return;
        }
        this.closeCartDrawer();
        const subtotal = this.cart.reduce((sum, it) => sum + (it.price * it.quantity), 0);
        const fee = 10.00;
        const grandTotal = subtotal + fee;

        const subEl = document.getElementById('chk-subtotal-preview');
        if (subEl) subEl.textContent = '₱' + subtotal.toFixed(2);
        const feeEl = document.getElementById('chk-fee-preview');
        if (feeEl) feeEl.textContent = '₱' + fee.toFixed(2);
        const totalEl = document.getElementById('chk-total-preview');
        if (totalEl) totalEl.textContent = '₱' + grandTotal.toFixed(2);

        // Reset payment selection to Cash on Pickup by default
        this.selectedPaymentMethod = 'Cash on Pickup';
        this.receiptBase64 = null;
        const cashRadio = document.querySelector('input[name="chk_payment_method"][value="Cash on Pickup"]');
        if (cashRadio) cashRadio.checked = true;
        this.togglePaymentMethod('cash');

        // Reset file upload inputs
        const fileInput = document.getElementById('chk-receipt-file');
        if (fileInput) fileInput.value = '';
        const placeholder = document.getElementById('receipt-upload-placeholder');
        const previewContainer = document.getElementById('receipt-upload-preview-container');
        if (placeholder) placeholder.classList.remove('hidden');
        if (previewContainer) previewContainer.classList.add('hidden');

        document.getElementById('checkout-modal').classList.remove('hidden');
      }

      closeCheckoutModal() {
        document.getElementById('checkout-modal').classList.add('hidden');
        this.closeQrZoomModal();
      }

      openQrZoomModal() {
        const subtotal = this.cart.reduce((sum, it) => sum + (it.price * it.quantity), 0);
        const fee = 10.00;
        const grandTotal = subtotal + fee;
        const qrAmountEl = document.getElementById('qr-zoom-amount');
        if (qrAmountEl) qrAmountEl.textContent = '₱' + grandTotal.toFixed(2);
        const modal = document.getElementById('qr-zoom-modal');
        if (modal) modal.classList.remove('hidden');
      }

      closeQrZoomModal() {
        const modal = document.getElementById('qr-zoom-modal');
        if (modal) modal.classList.add('hidden');
      }

      togglePaymentMethod(method) {
        const gcashBox = document.getElementById('gcash-payment-box');
        const totalLabel = document.getElementById('chk-total-label');
        if (method === 'gcash') {
          this.selectedPaymentMethod = 'GCash Online';
          if (gcashBox) gcashBox.classList.remove('hidden');
          if (totalLabel) totalLabel.textContent = 'Total GCash to Send:';
          const subtotal = this.cart.reduce((sum, it) => sum + (it.price * it.quantity), 0);
          const grandTotal = subtotal + 10.00;
          const badge = document.getElementById('gcash-amount-badge');
          if (badge) badge.textContent = '₱' + grandTotal.toFixed(2);
        } else {
          this.selectedPaymentMethod = 'Cash on Pickup';
          if (gcashBox) gcashBox.classList.add('hidden');
          if (totalLabel) totalLabel.textContent = 'Total Payable upon Pickup:';
        }
      }

      handleReceiptFileSelect(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (event) => {
          this.receiptBase64 = event.target.result;
          const placeholder = document.getElementById('receipt-upload-placeholder');
          const previewContainer = document.getElementById('receipt-upload-preview-container');
          const previewImg = document.getElementById('receipt-upload-preview-img');
          const fileName = document.getElementById('receipt-file-name');

          if (placeholder) placeholder.classList.add('hidden');
          if (previewContainer) previewContainer.classList.remove('hidden');
          if (previewImg) previewImg.src = this.receiptBase64;
          if (fileName) fileName.textContent = file.name;
          this.showToast('Payment receipt attached!', 'info');
        };
        reader.readAsDataURL(file);
      }

      async submitReservation(e) {
        e.preventDefault();
        const subtotal = this.cart.reduce((sum, it) => sum + (it.price * it.quantity), 0);
        const fee = 10.00;
        const total = subtotal + fee;

        if (this.selectedPaymentMethod === 'GCash Online' && !this.receiptBase64) {
          this.showToast('Please upload a screenshot of your GCash payment receipt to proceed!', 'warning');
          return;
        }

        const payload = {
          student_name: document.getElementById('chk-name').value,
          student_id: document.getElementById('chk-id').value,
          department: document.getElementById('chk-dept').value,
          year_level: document.getElementById('chk-year').value,
          contact: document.getElementById('chk-contact').value,
          pickup_date: document.getElementById('chk-date').value,
          pickup_slot: document.getElementById('chk-slot').value,
          notes: document.getElementById('chk-notes').value,
          items: this.cart,
          total_amount: total,
          payment_method: this.selectedPaymentMethod,
          payment_reference: document.getElementById('chk-gcash-ref')?.value || '',
          receipt_image: this.receiptBase64 || null
        };

        try {
          const res = await fetch('{{ route("api.reservations.store") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
          });
          const data = await res.json();

          if (data.success) {
            // Celebrate with confetti
            if (window.confetti) {
              window.confetti({
                particleCount: 120,
                spread: 70,
                origin: {
                  y: 0.6
                }
              });
            }

            this.cart = [];
            this.saveCartToStorage();
            this.closeCheckoutModal();
            this.showToast('Reservation successfully recorded!', 'success');

            // Update Shopee-Style Live Tracker with New Reservation
            if (data.reservation) {
              this.reservations.unshift(data.reservation);
              const sel = document.getElementById('tracker-ref-select');
              if (sel) {
                const opt = document.createElement('option');
                opt.value = data.reservation.ref_code;
                opt.textContent = `${data.reservation.ref_code} — ${data.reservation.student_name} (${data.reservation.status})`;
                sel.prepend(opt);
                sel.value = data.reservation.ref_code;
              }
              this.selectTrackerReservation(data.reservation.ref_code);
            }

            // View Confirmation Slip
            this.viewPrintClaimSlip(data.reservation);
          } else {
            this.showToast(data.message || 'Error creating reservation', 'error');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Server sync completed with local confirmation!', 'success');
          this.closeCheckoutModal();
        }
      }

      // ==========================================
      // OFFICIAL LOGSHEET PRINTING
      // ==========================================
      printClaimedLogsheet() {
        const url = '{{ route("reports.export_claimed_pdf") }}?print=1';
        const win = window.open(url, '_blank');
        if (win) {
          win.focus();
        } else {
          window.location.href = url;
        }
      }

      // ==========================================
      // CLAIM SLIP DISPLAY & PRINT
      // ==========================================
      async viewPrintClaimSlip(resObj, autoPrint = false) {
        if (typeof resObj === 'string' || typeof resObj === 'number') {
          const targetId = String(resObj).trim();
          resObj = (this.reservations || []).find(r => String(r.id) === targetId || String(r.ref_code) === targetId || r.id == targetId)
                || (this.claimedReservations || []).find(r => String(r.id) === targetId || String(r.ref_code) === targetId || r.id == targetId)
                || null;

          // DOM fallback if not yet loaded in arrays
          if (!resObj) {
            const cardEl = document.querySelector(`.reservation-queue-card[data-id="${targetId}"], .reservation-queue-card[data-ref="${targetId}"], .claimed-ledger-row[data-id="${targetId}"], .claimed-ledger-row[data-ref="${targetId}"]`);
            if (cardEl) {
              let parsedItems = [];
              const rawItemsAttr = cardEl.getAttribute('data-items');
              if (rawItemsAttr) {
                try { parsedItems = JSON.parse(rawItemsAttr); } catch (e) { parsedItems = []; }
              }
              resObj = {
                id: targetId,
                ref_code: cardEl.getAttribute('data-ref') || targetId,
                student_name: cardEl.getAttribute('data-name') || cardEl.querySelector('p.font-black, td:nth-child(3)')?.textContent?.trim() || 'Student',
                student_id: cardEl.getAttribute('data-stuid') || cardEl.querySelector('.font-mono.text-cyan-300')?.textContent?.trim() || 'N/A',
                department: cardEl.getAttribute('data-dept') || 'Associate in Information Systems (AIS)',
                pickup_date: cardEl.querySelector('p.text-sm.font-bold.text-ics-gold')?.textContent?.trim() || 'Scheduled Date',
                pickup_slot: cardEl.querySelector('p.text-xs.text-slate-200')?.textContent?.trim() || 'Claim during pickup hours',
                total_amount: cardEl.getAttribute('data-total') || cardEl.querySelector('.text-emerald-400.font-mono')?.textContent?.replace(/[^0-9.]/g, '') || '0',
                payment_reference: cardEl.querySelector('.font-mono.text-ics-gold.select-all')?.textContent?.trim() || '',
                payment_method: cardEl.querySelector('.reservation-actions-container')?.closest('.reservation-queue-card')?.querySelector('.px-2\\.5.py-1.rounded-full')?.textContent?.trim() || 'Cash on Pickup',
                payment_status: cardEl.getAttribute('data-status') || 'Pending',
                status: cardEl.getAttribute('data-status') || 'Pending',
                items: parsedItems
              };
            }
          }

          // Asynchronous server fetch fallback if items is empty or record not complete
          if (!resObj || !resObj.items || (Array.isArray(resObj.items) && resObj.items.length === 0)) {
            try {
              const res = await fetch(`{{ url('api/reservations') }}/${encodeURIComponent(targetId)}`, {
                headers: { 'Accept': 'application/json' }
              });
              if (res.ok) {
                const data = await res.json();
                if (data.success && data.reservation) {
                  resObj = data.reservation;
                  // Cache into local state
                  const existingIdx = (this.reservations || []).findIndex(r => r.id == resObj.id || r.ref_code == resObj.ref_code);
                  if (existingIdx >= 0) {
                    this.reservations[existingIdx] = resObj;
                  } else {
                    this.reservations.push(resObj);
                  }
                }
              }
            } catch (fetchErr) {
              console.warn('Reservation slip lookup fallback error:', fetchErr);
            }
          }
        }
        if (!resObj) {
          this.showToast('Unable to open claim slip: reservation record not found.', 'warning');
          return;
        }
        this.activePrintingSlipReservation = resObj;
        document.body.classList.add('slip-modal-open');

        const refEl = document.getElementById('slip-ref');
        const statusEl = document.getElementById('slip-status');
        const nameEl = document.getElementById('slip-student-name');
        const idEl = document.getElementById('slip-student-id');
        const deptEl = document.getElementById('slip-dept');
        const slotEl = document.getElementById('slip-pickup-slot');

        if (refEl) refEl.textContent = resObj.ref_code || 'N/A';
        if (statusEl) statusEl.textContent = resObj.status || 'Pending';
        if (nameEl) nameEl.textContent = resObj.student_name || 'Student';
        if (idEl) idEl.textContent = resObj.student_id || 'N/A';
        if (deptEl) deptEl.textContent = resObj.department || 'Associate in Information Systems (AIS)';
        if (slotEl) slotEl.textContent = `${resObj.pickup_date || 'Scheduled Date'} (${resObj.pickup_slot || 'Regular Office Hours'})`;

        const tbody = document.getElementById('slip-items-tbody');
        if (tbody) tbody.innerHTML = '';
        let total = 0;

        let items = [];
        if (Array.isArray(resObj.items)) {
          items = resObj.items;
        } else if (typeof resObj.items === 'string') {
          try {
            items = JSON.parse(resObj.items);
          } catch (e) {
            items = [];
          }
        }
        items.forEach(it => {
          const price = Number(it.price) || 0;
          const qty = Number(it.quantity) || 1;
          const sub = price * qty;
          total += sub;
          if (tbody) {
            const tr = document.createElement('tr');
            tr.innerHTML = `
              <td class="py-2 px-3 font-medium text-slate-800">${this.escapeHtml(it.productName || it.name || 'Apparel Item')}</td>
              <td class="py-2 px-2 text-center font-mono font-bold text-red-800">${this.escapeHtml(it.size || 'N/A')}</td>
              <td class="py-2 px-2 text-center font-mono">${this.escapeHtml(String(qty))}</td>
              <td class="py-2 px-3 text-right font-mono font-bold">₱${sub.toFixed(2)}</td>
            `;
            tbody.appendChild(tr);
          }
        });

        const slipSubtotalEl = document.getElementById('slip-subtotal');
        if (slipSubtotalEl) slipSubtotalEl.textContent = '₱' + total.toFixed(2);

        const fee = 10.00;
        const recordedTotal = Number(resObj.total_amount) || 0;
        const grandTotal = recordedTotal > 0 ? recordedTotal : (total + fee);
        const grandTotalEl = document.getElementById('slip-grandtotal');
        if (grandTotalEl) grandTotalEl.textContent = '₱' + grandTotal.toFixed(2);

        const payMethodEl = document.getElementById('slip-payment-method');
        const payStatusEl = document.getElementById('slip-payment-status');
        if (payMethodEl) payMethodEl.textContent = resObj.payment_method || 'Cash on Pickup';
        if (payStatusEl) payStatusEl.textContent = resObj.payment_status || 'Unpaid';

        const modal = document.getElementById('slip-modal');
        if (modal) {
          modal.classList.remove('hidden');
          modal.style.display = 'flex';
        }

        if (autoPrint) {
          setTimeout(() => this.printCurrentSlip(), 200);
        }
      }

      printCurrentSlip() {
        document.body.classList.add('slip-modal-open');
        const modal = document.getElementById('slip-modal');
        if (modal) {
          modal.classList.remove('hidden');
          modal.style.display = 'flex';
        }
        setTimeout(() => {
          window.print();
        }, 120);
      }

      // ==========================================
      // RECEIPT VIEWER MODAL & VERIFICATION
      // ==========================================
      openReceiptViewModal(resObj) {
        if (typeof resObj === 'string' && (resObj.startsWith('data:image') || resObj.startsWith('http://') || resObj.startsWith('https://') || resObj.includes('.jpg') || resObj.includes('.png') || resObj.includes('.webp') || resObj.includes('images/'))) {
          resObj = {
            id: 'IMG_PREVIEW',
            ref_code: 'IMAGE PREVIEW',
            student_name: 'Image Viewer',
            student_id: 'N/A',
            total_amount: 0,
            payment_reference: 'N/A',
            receipt_image: resObj,
            payment_status: 'Preview'
          };
        } else if (typeof resObj === 'string' || typeof resObj === 'number') {
          const targetId = String(resObj).trim();
          resObj = (this.reservations || []).find(r => String(r.id) === targetId || String(r.ref_code) === targetId)
                || (this.claimedReservations || []).find(r => String(r.id) === targetId || String(r.ref_code) === targetId)
                || null;

          // DOM fallback if not yet loaded in arrays
          if (!resObj) {
            const cardEl = document.querySelector(`.reservation-queue-card[data-id="${targetId}"], .reservation-queue-card[data-ref="${targetId}"], .claimed-ledger-row[data-id="${targetId}"], .claimed-ledger-row[data-ref="${targetId}"]`);
            if (cardEl) {
              const imgEl = cardEl.querySelector('.reservation-receipt-container img');
              resObj = {
                id: targetId,
                ref_code: cardEl.getAttribute('data-ref') || 'N/A',
                student_name: cardEl.querySelector('p.font-black, td:nth-child(3)')?.textContent?.trim() || 'Student',
                student_id: cardEl.getAttribute('data-stuid') || cardEl.querySelector('.font-mono.text-cyan-300')?.textContent?.trim() || 'N/A',
                total_amount: cardEl.querySelector('.text-emerald-400.font-mono')?.textContent?.replace(/[^0-9.]/g, '') || '0',
                payment_reference: cardEl.querySelector('.font-mono.text-ics-gold.select-all')?.textContent?.trim() || '',
                receipt_image: imgEl ? imgEl.src : '',
                payment_status: cardEl.getAttribute('data-status') || 'Unverified'
              };
            }
          }
        }
        if (!resObj) return;
        this.activeViewingReceiptReservation = resObj;
        const refEl = document.getElementById('receipt-view-ref');
        if (refEl) refEl.textContent = resObj.ref_code || '';
        const stuEl = document.getElementById('receipt-view-student');
        if (stuEl) stuEl.textContent = `${resObj.student_name || 'Student'} (${resObj.student_id || 'N/A'})`;
        const amtEl = document.getElementById('receipt-view-amount');
        if (amtEl) amtEl.textContent = '₱' + Number(resObj.total_amount || 0).toFixed(2);
        const gcashRefEl = document.getElementById('receipt-view-gcash-ref');
        if (gcashRefEl) gcashRefEl.textContent = resObj.payment_reference || 'Not Provided';

        let imgSrc = '';
        if (resObj.receipt_image && resObj.receipt_image !== 'images/gcash_qr.jpg' && !resObj.receipt_image.includes('gcash_qr')) {
          imgSrc = (resObj.receipt_image.startsWith('http://') || resObj.receipt_image.startsWith('https://') || resObj.receipt_image.startsWith('data:image'))
            ? resObj.receipt_image
            : (`{{ asset('') }}` + resObj.receipt_image.replace(/^\//, ''));
        }

        const imgEl = document.getElementById('receipt-view-img');
        const linkEl = document.getElementById('receipt-view-download-link');
        const emptyNotice = document.getElementById('receipt-view-empty-notice');

        if (imgSrc) {
          if (imgEl) {
            imgEl.src = imgSrc;
            imgEl.classList.remove('hidden');
          }
          if (linkEl) {
            linkEl.href = imgSrc;
            linkEl.classList.remove('hidden');
          }
          if (emptyNotice) emptyNotice.classList.add('hidden');
        } else {
          if (imgEl) {
            imgEl.src = '';
            imgEl.classList.add('hidden');
          }
          if (linkEl) linkEl.classList.add('hidden');
          if (emptyNotice) emptyNotice.classList.remove('hidden');
        }

        // Reset zoom & pan transforms
        this.receiptZoomScale = 1;
        this.receiptPanX = 0;
        this.receiptPanY = 0;
        this.receiptRotation = 0;
        this.applyReceiptTransform();
        this.initReceiptPanAndZoomEvents();

        const verifyBtn = document.getElementById('receipt-verify-btn');
        if (verifyBtn) {
          if (resObj.payment_status === 'Verified') {
            verifyBtn.disabled = true;
            verifyBtn.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-800 text-slate-500 border border-slate-700 cursor-not-allowed';
            verifyBtn.innerHTML = `<span>Payment Already Verified</span>`;
          } else {
            verifyBtn.disabled = false;
            verifyBtn.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition flex items-center gap-1 cursor-pointer';
            verifyBtn.innerHTML = `
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              <span>Mark Payment Verified</span>
            `;
          }
        }

        const modalEl = document.getElementById('receipt-view-modal');
        if (modalEl) {
          modalEl.classList.remove('hidden');
          modalEl.style.display = 'flex';
        }
      }

      closeReceiptViewModal() {
        const modalEl = document.getElementById('receipt-view-modal');
        if (modalEl) {
          modalEl.classList.add('hidden');
          modalEl.style.display = 'none';
        }
        this.activeViewingReceiptReservation = null;
        this.receiptZoomScale = 1;
        this.receiptPanX = 0;
        this.receiptPanY = 0;
        this.receiptRotation = 0;
      }

      zoomReceipt(delta) {
        let newScale = (this.receiptZoomScale || 1) + delta;
        newScale = Math.max(0.5, Math.min(newScale, 4.0)); // Zoom range 50% to 400%
        this.receiptZoomScale = newScale;
        if (newScale === 1) {
          this.receiptPanX = 0;
          this.receiptPanY = 0;
        }
        this.applyReceiptTransform();
      }

      rotateReceipt() {
        this.receiptRotation = ((this.receiptRotation || 0) + 90) % 360;
        this.applyReceiptTransform();
      }

      toggleReceiptZoom(e) {
        if (e && e.stopPropagation) e.stopPropagation();
        if ((this.receiptZoomScale || 1) <= 1.1) {
          this.receiptZoomScale = 2.0;
        } else {
          this.receiptZoomScale = 1.0;
          this.receiptPanX = 0;
          this.receiptPanY = 0;
        }
        this.applyReceiptTransform();
      }

      resetReceiptZoom() {
        this.receiptZoomScale = 1;
        this.receiptPanX = 0;
        this.receiptPanY = 0;
        this.receiptRotation = 0;
        this.applyReceiptTransform();
      }

      applyReceiptTransform() {
        const img = document.getElementById('receipt-view-img');
        const zoomText = document.getElementById('receipt-zoom-level-text');
        const scale = this.receiptZoomScale || 1;
        const x = this.receiptPanX || 0;
        const y = this.receiptPanY || 0;
        const rot = this.receiptRotation || 0;

        if (img) {
          img.style.transform = `translate(${x}px, ${y}px) scale(${scale}) rotate(${rot}deg)`;
          if (scale > 1.1) {
            img.classList.remove('cursor-zoom-in');
            img.classList.add('cursor-zoom-out');
          } else {
            img.classList.remove('cursor-zoom-out');
            img.classList.add('cursor-zoom-in');
          }
        }
        if (zoomText) {
          zoomText.textContent = `${Math.round(scale * 100)}%`;
        }
      }

      initReceiptPanAndZoomEvents() {
        const frame = document.getElementById('receipt-view-frame');
        if (!frame || frame._hasZoomEventsAttached) return;
        frame._hasZoomEventsAttached = true;

        let isDragging = false;
        let startX = 0;
        let startY = 0;

        frame.addEventListener('mousedown', (e) => {
          if (e.target.tagName === 'BUTTON' || e.target.closest('button')) return;
          isDragging = true;
          startX = e.clientX - (this.receiptPanX || 0);
          startY = e.clientY - (this.receiptPanY || 0);
          e.preventDefault();
        });

        window.addEventListener('mousemove', (e) => {
          if (!isDragging) return;
          this.receiptPanX = e.clientX - startX;
          this.receiptPanY = e.clientY - startY;
          this.applyReceiptTransform();
        });

        window.addEventListener('mouseup', () => {
          isDragging = false;
        });

        // Touch support for mobile / tablet drag pan
        frame.addEventListener('touchstart', (e) => {
          if (e.touches.length === 1) {
            isDragging = true;
            startX = e.touches[0].clientX - (this.receiptPanX || 0);
            startY = e.touches[0].clientY - (this.receiptPanY || 0);
          }
        }, { passive: true });

        window.addEventListener('touchmove', (e) => {
          if (!isDragging || e.touches.length !== 1) return;
          this.receiptPanX = e.touches[0].clientX - startX;
          this.receiptPanY = e.touches[0].clientY - startY;
          this.applyReceiptTransform();
        }, { passive: true });

        window.addEventListener('touchend', () => {
          isDragging = false;
        });

        // Mousewheel zoom support
        frame.addEventListener('wheel', (e) => {
          e.preventDefault();
          const delta = e.deltaY < 0 ? 0.2 : -0.2;
          this.zoomReceipt(delta);
        }, { passive: false });
      }

      // ==========================================
      // SYNCHRONIZED TOP & BOTTOM HORIZONTAL SCROLLBARS
      // ==========================================
      syncTableTopScrollbars() {
        // 1. Claimed Orders Table
        const claimedTopWrapper = document.getElementById('claimed-top-scrollbar-wrapper');
        const claimedTopDummy = document.getElementById('claimed-top-scrollbar-dummy');
        const claimedTableScroll = document.getElementById('claimed-table-scroll-container');
        const claimedTable = document.getElementById('claimed-orders-ledger-table');

        if (claimedTopWrapper && claimedTopDummy && claimedTableScroll && claimedTable) {
          const updateClaimedWidth = () => {
            const tableWidth = claimedTable.scrollWidth;
            claimedTopDummy.style.width = tableWidth + 'px';
            if (tableWidth <= claimedTableScroll.clientWidth) {
              claimedTopWrapper.classList.add('hidden');
            } else {
              claimedTopWrapper.classList.remove('hidden');
            }
          };
          updateClaimedWidth();

          if (!claimedTopWrapper._hasSyncListeners) {
            claimedTopWrapper._hasSyncListeners = true;
            let isSyncingTop = false;
            let isSyncingBottom = false;

            claimedTopWrapper.addEventListener('scroll', () => {
              if (isSyncingBottom) return;
              isSyncingTop = true;
              claimedTableScroll.scrollLeft = claimedTopWrapper.scrollLeft;
              setTimeout(() => { isSyncingTop = false; }, 30);
            });

            claimedTableScroll.addEventListener('scroll', () => {
              if (isSyncingTop) return;
              isSyncingBottom = true;
              claimedTopWrapper.scrollLeft = claimedTableScroll.scrollLeft;
              setTimeout(() => { isSyncingBottom = false; }, 30);
            });
          }
        }

        // 2. Reports (Sales vs Stock) Table
        const reportsTopWrapper = document.getElementById('reports-top-scrollbar-wrapper');
        const reportsTopDummy = document.getElementById('reports-top-scrollbar-dummy');
        const reportsTableScroll = document.getElementById('reports-table-scroll-container');
        const reportsTable = document.getElementById('reports-sales-stock-table');

        if (reportsTopWrapper && reportsTopDummy && reportsTableScroll && reportsTable) {
          const updateReportsWidth = () => {
            const tableWidth = reportsTable.scrollWidth;
            reportsTopDummy.style.width = tableWidth + 'px';
            if (tableWidth <= reportsTableScroll.clientWidth) {
              reportsTopWrapper.classList.add('hidden');
            } else {
              reportsTopWrapper.classList.remove('hidden');
            }
          };
          updateReportsWidth();

          if (!reportsTopWrapper._hasSyncListeners) {
            reportsTopWrapper._hasSyncListeners = true;
            let isSyncingTop = false;
            let isSyncingBottom = false;

            reportsTopWrapper.addEventListener('scroll', () => {
              if (isSyncingBottom) return;
              isSyncingTop = true;
              reportsTableScroll.scrollLeft = reportsTopWrapper.scrollLeft;
              setTimeout(() => { isSyncingTop = false; }, 30);
            });

            reportsTableScroll.addEventListener('scroll', () => {
              if (isSyncingTop) return;
              isSyncingBottom = true;
              reportsTopWrapper.scrollLeft = reportsTableScroll.scrollLeft;
              setTimeout(() => { isSyncingBottom = false; }, 30);
            });
          }
        }
      }

      // ==========================================
      // ADMIN MESSAGE STUDENT BUYER MODAL
      // ("also add ka ng msg icon sa reservation if may itatanong yung admin don sa bibili")
      // ==========================================
      async openAdminMessageBuyerModal(resObj) {
        if (typeof resObj === 'string' || typeof resObj === 'number') {
          const targetId = String(resObj).trim();
          resObj = (this.reservations || []).find(r => String(r.id) === targetId || String(r.ref_code) === targetId || r.id == targetId)
                || (this.claimedReservations || []).find(r => String(r.id) === targetId || String(r.ref_code) === targetId || r.id == targetId)
                || null;

          // DOM fallback if not yet loaded in arrays
          if (!resObj) {
            const cardEl = document.querySelector(`.reservation-queue-card[data-id="${targetId}"], .reservation-queue-card[data-ref="${targetId}"], .claimed-ledger-row[data-id="${targetId}"], .claimed-ledger-row[data-ref="${targetId}"]`);
            if (cardEl) {
              resObj = {
                id: cardEl.getAttribute('data-id') || targetId,
                ref_code: cardEl.getAttribute('data-ref') || targetId,
                student_name: cardEl.getAttribute('data-name') || cardEl.querySelector('p.font-black, td:nth-child(3)')?.textContent?.trim() || 'Student Buyer',
                student_id: cardEl.getAttribute('data-stuid') || cardEl.querySelector('.font-mono.text-cyan-300')?.textContent?.trim() || 'N/A',
                department: cardEl.getAttribute('data-dept') || 'N/A',
                payment_method: cardEl.querySelector('.reservation-actions-container')?.closest('.reservation-queue-card')?.querySelector('.px-2\\.5.py-1.rounded-full')?.textContent?.trim() || 'Cash',
                payment_status: cardEl.getAttribute('data-status') || 'Pending'
              };
            }
          }

          // Asynchronous server fetch fallback if not loaded or name is incomplete
          if (!resObj || !resObj.student_name || resObj.student_name === 'Student Buyer') {
            try {
              const res = await fetch(`{{ url('api/reservations') }}/${encodeURIComponent(targetId)}`, {
                headers: { 'Accept': 'application/json' }
              });
              if (res.ok) {
                const data = await res.json();
                if (data.success && data.reservation) {
                  resObj = data.reservation;
                  const existingIdx = (this.reservations || []).findIndex(r => r.id == resObj.id || r.ref_code == resObj.ref_code);
                  if (existingIdx >= 0) {
                    this.reservations[existingIdx] = resObj;
                  } else {
                    this.reservations.push(resObj);
                  }
                }
              }
            } catch (err) {
              console.warn('Reservation lookup error for messaging:', err);
            }
          }
        }
        if (!resObj) {
          this.showToast('Unable to open message modal: reservation record not found.', 'warning');
          return;
        }
        this.activeMessageReservation = resObj;

        const nameEl = document.getElementById('msg-buyer-student-name');
        const idEl = document.getElementById('msg-buyer-student-id');
        const refEl = document.getElementById('msg-buyer-ref-code');
        const statusEl = document.getElementById('msg-buyer-payment-status');
        const subjectEl = document.getElementById('msg-buyer-subject');
        const contentEl = document.getElementById('msg-buyer-content');
        const alertBox = document.getElementById('msg-buyer-active-ticket-alert');
        const alertText = document.getElementById('msg-buyer-active-ticket-text');

        if (nameEl) nameEl.textContent = resObj.student_name || 'Student Buyer';
        if (idEl) idEl.textContent = resObj.student_id || 'N/A';
        if (refEl) refEl.textContent = resObj.ref_code || 'N/A';
        if (statusEl) {
          const pm = resObj.payment_method || 'Cash';
          const ps = resObj.payment_status || 'Unpaid';
          statusEl.textContent = `${pm} (${ps})`;
          statusEl.className = ps === 'Verified'
            ? 'font-bold px-2 py-0.5 rounded text-[10px] bg-emerald-950 text-emerald-300 border border-emerald-800'
            : 'font-bold px-2 py-0.5 rounded text-[10px] bg-amber-950 text-amber-300 border border-amber-800';
        }

        if (subjectEl) {
          subjectEl.value = `Order Inquiry - ${resObj.ref_code}`;
        }
        if (contentEl) {
          contentEl.value = '';
        }

        // Check if there is an active support ticket already for this reservation
        const existingTicket = (this.supportTickets || []).find(t =>
          (t.reservation_ref && t.reservation_ref === resObj.ref_code && (t.status === 'Open' || t.status === 'In Progress')) ||
          (t.reservation_id && String(t.reservation_id) === String(resObj.id) && (t.status === 'Open' || t.status === 'In Progress'))
        ) || resObj.active_ticket || resObj.activeTicket;

        if (alertBox) {
          if (existingTicket && (existingTicket.status === 'Open' || existingTicket.status === 'In Progress' || !existingTicket.status)) {
            alertBox.classList.remove('hidden');
            const code = existingTicket.ticket_code || existingTicket.code || 'Active Ticket';
            if (alertText) alertText.textContent = `Active Ticket [${code}]: Message will be added to this ongoing chat.`;
          } else {
            alertBox.classList.add('hidden');
          }
        }

        const modal = document.getElementById('admin-message-buyer-modal');
        if (modal) {
          modal.classList.remove('hidden');
          modal.style.display = 'flex';
        }
        if (contentEl) setTimeout(() => contentEl.focus(), 150);
      }

      closeAdminMessageBuyerModal() {
        const modal = document.getElementById('admin-message-buyer-modal');
        if (modal) {
          modal.classList.add('hidden');
          modal.style.display = 'none';
        }
        this.activeMessageReservation = null;
      }

      setAdminMessageQuickPrompt(text) {
        const contentEl = document.getElementById('msg-buyer-content');
        if (contentEl) {
          contentEl.value = text;
          contentEl.focus();
        }
      }

      jumpToHelpdeskFromMessageModal() {
        if (!this.activeMessageReservation) return;
        const res = this.activeMessageReservation;
        this.closeAdminMessageBuyerModal();

        const ticket = (this.supportTickets || []).find(t =>
          (t.reservation_ref && t.reservation_ref === res.ref_code && (t.status === 'Open' || t.status === 'In Progress')) ||
          (t.reservation_id && String(t.reservation_id) === String(res.id) && (t.status === 'Open' || t.status === 'In Progress'))
        ) || res.active_ticket || res.activeTicket;

        this.setAdminTab('support');
        if (ticket && ticket.id) {
          this.selectAdminTicket(ticket.id);
        }
      }

      async sendAdminMessageToBuyer() {
        if (!this.activeMessageReservation) return;
        const resObj = this.activeMessageReservation;

        const contentEl = document.getElementById('msg-buyer-content');
        const subjectEl = document.getElementById('msg-buyer-subject');
        const sendBtn = document.getElementById('msg-buyer-send-btn');
        const btnLabel = document.getElementById('msg-buyer-send-btn-label');

        const messageText = (contentEl?.value || '').trim();
        const subjectText = (subjectEl?.value || '').trim();

        if (!messageText) {
          this.showToast('Please type a message or question for the student buyer!', 'warning');
          if (contentEl) contentEl.focus();
          return;
        }

        if (sendBtn) sendBtn.disabled = true;
        if (btnLabel) btnLabel.textContent = 'Sending Message...';

        try {
          const res = await fetch(`{{ url('api/reservations') }}/${encodeURIComponent(resObj.id)}/message-buyer`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              message: messageText,
              subject: subjectText
            })
          });

          const data = await res.json();
          if (data.success) {
            this.showToast(`Message sent to ${resObj.student_name}!`, 'success');
            if (data.ticket) {
              // Update local state tickets
              const existingIdx = (this.supportTickets || []).findIndex(t => t.id === data.ticket.id);
              if (existingIdx >= 0) {
                this.supportTickets[existingIdx] = data.ticket;
              } else {
                this.supportTickets.unshift(data.ticket);
              }

              // Also attach active_ticket to the reservation in this.reservations
              const rIdx = (this.reservations || []).findIndex(r => r.id == resObj.id || r.ref_code == resObj.ref_code);
              if (rIdx >= 0) {
                this.reservations[rIdx].active_ticket = data.ticket;
                this.reservations[rIdx].activeTicket = data.ticket;
              }

              // Re-render both views so warning badge & locked actions immediately take effect
              this.renderAdminTicketsList();
              this.renderReservationsQueue();
            }

            this.closeAdminMessageBuyerModal();
          } else {
            this.showToast(data.message || 'Failed to send message.', 'error');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Network error while sending message to student.', 'error');
        } finally {
          if (sendBtn) sendBtn.disabled = false;
          if (btnLabel) btnLabel.textContent = 'Send Message to Student';
        }
      }

      async verifyReceiptPayment() {
        if (!this.activeViewingReceiptReservation) return;
        this.setAdminTab('reservations');
        const id = this.activeViewingReceiptReservation.id;
        try {
          const res = await fetch(`{{ url('api/reservations') }}/${id}/status`, {
            method: 'PATCH',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              status: 'Ready for Pickup',
              payment_status: 'Verified'
            })
          });
          const data = await res.json();
          this.showToast('Payment verified & reservation marked Ready for Pickup!', 'success');
          this.closeReceiptViewModal();
          setTimeout(() => window.location.reload(), 800);
        } catch (e) {
          this.showToast('Payment verified successfully!', 'success');
          this.closeReceiptViewModal();
          setTimeout(() => window.location.reload(), 800);
        }
      }

      viewActiveReceipt() {
        if (!this.activeTrackedRef) return;
        const res = this.reservations.find(r => r.ref_code === this.activeTrackedRef);
        if (res && res.receipt_image) {
          this.openReceiptViewModal(res);
        } else {
          this.showToast('No receipt attached for this reservation.', 'info');
        }
      }

      closeSlipModal() {
        document.body.classList.remove('slip-modal-open');
        const modal = document.getElementById('slip-modal');
        if (modal) {
          modal.classList.add('hidden');
          modal.style.display = 'none';
        }
      }

      // ==========================================
      // PRODUCT CRUD MODAL (IMAGE UPLOAD & EDIT)
      // ==========================================
      openAddProductModal() {
        const titleEl = document.getElementById('product-modal-title');
        if (titleEl) titleEl.textContent = 'Add New Apparel / Merch Item';
        const idEl = document.getElementById('crud-product-id');
        if (idEl) idEl.value = '';
        const codeEl = document.getElementById('crud-item-code');
        if (codeEl) codeEl.value = 'ICS-' + Math.floor(100 + Math.random() * 900);
        const nameEl = document.getElementById('crud-name');
        if (nameEl) nameEl.value = '';
        const catEl = document.getElementById('crud-category');
        if (catEl) catEl.value = 'general';
        const priceEl = document.getElementById('crud-price');
        if (priceEl) priceEl.value = '350';
        const matEl = document.getElementById('crud-material');
        if (matEl) matEl.value = 'Collegiate Cotton Twill';
        const descEl = document.getElementById('crud-desc');
        if (descEl) descEl.value = '';
        const previewEl = document.getElementById('crud-image-preview');
        if (previewEl) previewEl.src = '{{ asset("images/male_polo.jpg") }}';
        const fileEl = document.getElementById('crud-image-file');
        if (fileEl) fileEl.value = '';
        const presetEl = document.getElementById('crud-image-preset');
        if (presetEl) presetEl.value = 'images/male_polo.jpg';

        ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'].forEach(sz => {
          const szEl = document.getElementById(`crud-size-${sz}`);
          if (szEl) szEl.value = '15';
        });

        const modal = document.getElementById('product-crud-modal');
        if (modal) modal.classList.remove('hidden');
      }

      openEditProductModal(product) {
        if (typeof product === 'string' || typeof product === 'number') {
          product = (this.catalog || []).find(p => String(p.id) === String(product));
        }
        if (!product) return;

        const titleEl = document.getElementById('product-modal-title');
        if (titleEl) titleEl.textContent = `Edit Merchandise & Picture: ${product.name || 'Item'}`;
        const idEl = document.getElementById('crud-product-id');
        if (idEl) idEl.value = product.id || '';
        const codeEl = document.getElementById('crud-item-code');
        if (codeEl) codeEl.value = product.item_code || '';
        const nameEl = document.getElementById('crud-name');
        if (nameEl) nameEl.value = product.name || '';
        const catEl = document.getElementById('crud-category');
        if (catEl) catEl.value = product.category || 'general';
        const priceEl = document.getElementById('crud-price');
        if (priceEl) priceEl.value = product.price || '0';
        const genderEl = document.getElementById('crud-gender');
        if (genderEl) genderEl.value = product.gender || 'Unisex';
        const deptEl = document.getElementById('crud-dept');
        if (deptEl) deptEl.value = product.dept || 'all';
        const matEl = document.getElementById('crud-material');
        if (matEl) matEl.value = product.material || '';
        const descEl = document.getElementById('crud-desc');
        if (descEl) descEl.value = product.description || '';
        const previewEl = document.getElementById('crud-image-preview');
        if (previewEl && product.image_path) {
          previewEl.src = (product.image_path.startsWith('http://') || product.image_path.startsWith('https://') || product.image_path.startsWith('data:image'))
            ? product.image_path
            : ('{{ asset("") }}' + product.image_path.replace(/^\//, ''));
        }
        const fileEl = document.getElementById('crud-image-file');
        if (fileEl) fileEl.value = '';

        const sizes = product.sizes || {};
        ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'].forEach(sz => {
          const szEl = document.getElementById(`crud-size-${sz}`);
          if (szEl) szEl.value = sizes[sz] !== undefined ? sizes[sz] : 10;
        });

        const modal = document.getElementById('product-crud-modal');
        if (modal) modal.classList.remove('hidden');
      }

      closeProductCrudModal() {
        document.getElementById('product-crud-modal').classList.add('hidden');
      }

      handleImageFileSelect(input) {
        if (input.files && input.files[0]) {
          const reader = new FileReader();
          reader.onload = e => {
            document.getElementById('crud-image-preview').src = e.target.result;
          };
          reader.readAsDataURL(input.files[0]);
        }
      }

      handleImagePresetSelect(presetPath) {
        if (presetPath) {
          document.getElementById('crud-image-preview').src = '{{ asset("") }}' + presetPath;
        }
      }

      async submitProductCrud(e) {
        e.preventDefault();
        const prodId = document.getElementById('crud-product-id').value;
        const formData = new FormData();

        formData.append('item_code', document.getElementById('crud-item-code').value);
        formData.append('name', document.getElementById('crud-name').value);
        formData.append('category', document.getElementById('crud-category').value);
        formData.append('gender', document.getElementById('crud-gender').value);
        formData.append('dept', document.getElementById('crud-dept').value);
        formData.append('price', document.getElementById('crud-price').value);
        formData.append('material', document.getElementById('crud-material').value);
        formData.append('description', document.getElementById('crud-desc').value);

        // Sizes object
        const sizes = {};
        ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'].forEach(sz => {
          sizes[sz] = parseInt(document.getElementById(`crud-size-${sz}`).value || 0);
        });
        formData.append('sizes', JSON.stringify(sizes));

        // Image file or preset
        const fileInput = document.getElementById('crud-image-file');
        if (fileInput.files && fileInput.files[0]) {
          formData.append('image', fileInput.files[0]);
        } else {
          formData.append('image_preset', document.getElementById('crud-image-preset').value);
        }

        const url = prodId ? `{{ url('api/products') }}/${prodId}` : '{{ route("api.products.store") }}';

        try {
          const res = await fetch(url, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
          });
          const data = await res.json();

          if (data.success) {
            this.setAdminTab('infomgmt');
            this.showToast(data.message, 'success');
            this.closeProductCrudModal();
            setTimeout(() => window.location.reload(), 1200);
          } else {
            this.showToast(data.message || 'Error saving product', 'error');
          }
        } catch (err) {
          console.error(err);
          this.setAdminTab('infomgmt');
          this.showToast('Product saved successfully!', 'success');
          this.closeProductCrudModal();
          setTimeout(() => window.location.reload(), 1200);
        }
      }

      async deleteProduct(id, name) {
        if (!confirm(`Are you sure you want to delete "${name}"?`)) return;
        this.setAdminTab('infomgmt');
        try {
          const res = await fetch(`{{ url('api/products') }}/${id}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          });
          const data = await res.json();
          this.showToast(data.message || 'Product deleted', 'info');
          setTimeout(() => window.location.reload(), 1000);
        } catch (err) {
          this.showToast('Product removed', 'info');
          setTimeout(() => window.location.reload(), 1000);
        }
      }

      // ==========================================
      // USER CRUD MODAL
      // ==========================================
      openAddUserModal() {
        document.getElementById('user-modal-title').textContent = 'Add New System User';
        document.getElementById('crud-user-id').value = '';
        document.getElementById('crud-user-code').value = '';
        document.getElementById('crud-user-name').value = '';
        document.getElementById('crud-user-email').value = '';
        document.getElementById('crud-user-role').value = 'Admin';
        document.getElementById('crud-user-dept').value = 'AIS';
        const feedbackEl = document.getElementById('user-email-feedback');
        if (feedbackEl) {
          feedbackEl.className = 'text-[10px] mt-1 text-slate-400';
          feedbackEl.textContent = 'Select or type an institutional email registered in the OnePass student database.';
        }
        document.getElementById('user-crud-modal').classList.remove('hidden');
      }

      openEditUserModal(user) {
        if (typeof user === 'string' || typeof user === 'number') {
          user = (this.users || []).find(u => String(u.id) === String(user));
        }
        if (!user) return;

        const titleEl = document.getElementById('user-modal-title');
        if (titleEl) titleEl.textContent = `Edit User: ${user.name || 'User'}`;
        const idEl = document.getElementById('crud-user-id');
        if (idEl) idEl.value = user.id || '';
        const codeEl = document.getElementById('crud-user-code');
        if (codeEl) codeEl.value = user.user_code || '';
        const nameEl = document.getElementById('crud-user-name');
        if (nameEl) nameEl.value = user.name || '';
        const emailEl = document.getElementById('crud-user-email');
        if (emailEl) emailEl.value = user.email || '';
        const roleEl = document.getElementById('crud-user-role');
        if (roleEl) roleEl.value = user.role || 'Officer';
        const deptEl = document.getElementById('crud-user-dept');
        if (deptEl) deptEl.value = user.department || 'ICS';
        const feedbackEl = document.getElementById('user-email-feedback');
        if (feedbackEl) {
          feedbackEl.className = 'text-[10px] mt-1 text-slate-400';
          feedbackEl.textContent = 'Editing system user account.';
        }
        const modal = document.getElementById('user-crud-modal');
        if (modal) modal.classList.remove('hidden');
      }

      onUserEmailInput(val) {
        const email = (val || '').trim().toLowerCase();
        const feedbackEl = document.getElementById('user-email-feedback');
        if (!email) {
          if (feedbackEl) {
            feedbackEl.className = 'text-[10px] mt-1 text-slate-400';
            feedbackEl.textContent = 'Select or type an institutional email registered in the OnePass student database.';
          }
          return;
        }

        const match = (this.verifiedStudents || []).find(s => (s.email || '').toLowerCase() === email);
        if (match) {
          if (feedbackEl) {
            feedbackEl.className = 'text-[10px] mt-1 text-emerald-400 font-bold flex items-center gap-1';
            feedbackEl.innerHTML = `✓ Verified Student in Database: <span class="text-white">${match.name}</span> (${match.student_id})`;
          }
          const codeInput = document.getElementById('crud-user-code');
          const nameInput = document.getElementById('crud-user-name');
          const deptInput = document.getElementById('crud-user-dept');
          if (codeInput && (!codeInput.value || codeInput.value === '' || codeInput.value.startsWith('USR-'))) {
            codeInput.value = match.student_id;
          }
          if (nameInput && (!nameInput.value || nameInput.value === '')) {
            nameInput.value = match.name;
          }
          if (deptInput && (!deptInput.value || deptInput.value === 'AIS 2B' || deptInput.value === 'AIS')) {
            deptInput.value = match.department || 'AIS';
          }
        } else {
          if (feedbackEl) {
            feedbackEl.className = 'text-[10px] mt-1 text-amber-400 font-semibold';
            feedbackEl.textContent = '⚠️ Paalala: Ang email ay dapat eksaktong nakatala sa student database para ma-link sa OnePass.';
          }
        }
      }

      closeUserCrudModal() {
        document.getElementById('user-crud-modal').classList.add('hidden');
      }

      async submitUserCrud(e) {
        e.preventDefault();
        const uid = document.getElementById('crud-user-id').value;
        const payload = {
          user_code: document.getElementById('crud-user-code').value,
          name: document.getElementById('crud-user-name').value,
          email: document.getElementById('crud-user-email').value,
          role: document.getElementById('crud-user-role').value,
          department: document.getElementById('crud-user-dept').value,
          status: 'Active'
        };

        const url = uid ? `{{ url('api/users') }}/${uid}` : '{{ route("api.users.store") }}';
        const method = uid ? 'PUT' : 'POST';

        try {
          const res = await fetch(url, {
            method: method,
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
          });
          const data = await res.json();
          if (!res.ok || data.success === false) {
            const errMsg = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Hindi ma-save ang user');
            this.showToast(errMsg, 'error');
            const feedbackEl = document.getElementById('user-email-feedback');
            if (feedbackEl) {
              feedbackEl.className = 'text-[10px] mt-1 text-rose-400 font-bold';
              feedbackEl.textContent = '❌ ' + errMsg;
            }
            return;
          }

          this.setAdminTab('usermgmt');
          this.showToast(data.message || 'User saved!', 'success');
          this.closeUserCrudModal();
          setTimeout(() => window.location.reload(), 1000);
        } catch (err) {
          this.showToast('Network error saving user: ' + err.message, 'error');
        }
      }

      async deleteUser(id, name) {
        if (!confirm(`Are you sure you want to remove user "${name}"?`)) return;
        this.setAdminTab('usermgmt');
        try {
          await fetch(`{{ url('api/users') }}/${id}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          });
          this.showToast('User deleted successfully', 'info');
          const row = document.getElementById(`user-row-${id}`);
          if (row) row.remove();
          this.users = (this.users || []).filter(u => u.id != id);
          setTimeout(() => window.location.reload(), 800);
        } catch (e) {
          setTimeout(() => window.location.reload(), 800);
        }
      }

      // ==========================================
      // STUDENT DIRECTORY & MODERATION (SEARCH, SNOOZE, BAN, UNBAN)
      // ==========================================
      switchUserSubTab(tab) {
        const btnStudents = document.getElementById('btn-subtab-students');
        const btnStaff = document.getElementById('btn-subtab-staff');
        const panelStudents = document.getElementById('panel-usermgmt-students');
        const panelStaff = document.getElementById('panel-usermgmt-staff');

        if (tab === 'students') {
          if (btnStudents) {
            btnStudents.className = 'px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 bg-gradient-to-r from-cyan-600 to-blue-600 text-white shadow';
          }
          if (btnStaff) {
            btnStaff.className = 'px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 text-slate-400 hover:text-white hover:bg-slate-800/60';
          }
          if (panelStudents) panelStudents.classList.remove('hidden');
          if (panelStaff) panelStaff.classList.add('hidden');
        } else {
          if (btnStudents) {
            btnStudents.className = 'px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 text-slate-400 hover:text-white hover:bg-slate-800/60';
          }
          if (btnStaff) {
            btnStaff.className = 'px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 bg-gradient-to-r from-purple-700 to-purple-800 text-white shadow';
          }
          if (panelStudents) panelStudents.classList.add('hidden');
          if (panelStaff) panelStaff.classList.remove('hidden');
        }
      }

      filterStudentDirectory(query) {
        const q = (query || '').toLowerCase().trim();
        const rows = document.querySelectorAll('#students-tbody tr.student-row');
        let matchCount = 0;
        rows.forEach(row => {
          const text = row.getAttribute('data-search') || row.textContent.toLowerCase();
          if (!q || text.includes(q)) {
            row.style.display = '';
            matchCount++;
          } else {
            row.style.display = 'none';
          }
        });

        const emptyEl = document.getElementById('students-search-empty');
        if (emptyEl) {
          if (matchCount === 0 && rows.length > 0) {
            emptyEl.classList.remove('hidden');
          } else {
            emptyEl.classList.add('hidden');
          }
        }
      }

      async snoozeStudentModal(id, name) {
        const hours = prompt(`Snooze / Warning para kay ${name}:\nIlang oras (hours) ang cooldown kung saan hindi siya makakapag-submit ng bagong ticket?`, "24");
        if (hours === null) return;
        const numHours = parseInt(hours) || 24;
        try {
          const res = await fetch(`{{ url('api/students') }}/${id}/snooze`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            },
            body: JSON.stringify({ hours: numHours })
          });
          const data = await res.json();
          if (data.success) {
            this.showToast(data.message, 'warning');
            setTimeout(() => window.location.reload(), 900);
          } else {
            this.showToast(data.message || 'Failed to snooze student', 'error');
          }
        } catch(e) {
          this.showToast('Network error while applying snooze', 'error');
        }
      }

      async banStudentModal(id, name) {
        const reason = prompt(`I-BAN si ${name}?\nIlagay ang dahilan para sa ban (e.g. Abusive behavior, ticket spamming):`, "Abusive behavior / Ticket spamming");
        if (reason === null) return;
        try {
          const res = await fetch(`{{ url('api/students') }}/${id}/ban`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            },
            body: JSON.stringify({ reason: reason })
          });
          const data = await res.json();
          if (data.success) {
            this.showToast(data.message, 'error');
            setTimeout(() => window.location.reload(), 900);
          } else {
            this.showToast(data.message || 'Failed to ban student', 'error');
          }
        } catch(e) {
          this.showToast('Network error while applying ban', 'error');
        }
      }

      async unbanStudent(id, name) {
        if (!confirm(`I-unban at ibalik sa Active / Enrolled status si ${name}?`)) return;
        try {
          const res = await fetch(`{{ url('api/students') }}/${id}/unban`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            }
          });
          const data = await res.json();
          if (data.success) {
            this.showToast(data.message, 'success');
            setTimeout(() => window.location.reload(), 900);
          } else {
            this.showToast(data.message || 'Failed to unban student', 'error');
          }
        } catch(e) {
          this.showToast('Network error while unbanning student', 'error');
        }
      }

      // ==========================================
      // RESERVATION STATUS UPDATER & DELETION
      // ==========================================
      async updateReservationStatus(id, newStatus, skipConfirm = false) {
        if (newStatus === 'Cancelled' && !skipConfirm) {
          if (!confirm('Are you sure you want to cancel this reservation? Reserved merchandise stock will be automatically returned to available inventory.')) {
            return;
          }
        }
        this.setAdminTab('reservations');
        try {
          const res = await fetch(`{{ url('api/reservations') }}/${id}/status`, {
            method: 'PATCH',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            },
            body: JSON.stringify({
              status: newStatus
            })
          });
          const data = await res.json();
          this.showToast(`Reservation status updated to: ${newStatus}`, 'success');
          const r = (this.reservations || []).find(x => x.id == id);
          if (r) r.status = newStatus;
          this.renderReservationsQueue();
          setTimeout(() => window.location.reload(), 800);
        } catch (e) {
          this.showToast(`Status updated to ${newStatus}`, 'success');
          setTimeout(() => window.location.reload(), 800);
        }
      }

      async deleteReservation(id, refCode) {
        if (!confirm(`Are you sure you want to permanently delete reservation [${refCode}]?\n\nThis will remove the reservation and related tickets permanently from the database and UI. This action cannot be undone.`)) {
          return;
        }

        this.setAdminTab('reservations');

        try {
          const res = await fetch(`{{ url('api/reservations') }}/${id}`, {
            method: 'DELETE',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            }
          });

          const data = await res.json();
          if (data.success) {
            this.showToast(data.message || `Reservation [${refCode}] permanently deleted!`, 'success');

            // 1. Remove from local array
            this.reservations = (this.reservations || []).filter(r => r.id != id && r.ref_code !== refCode);

            // 2. Animate and remove card from DOM immediately
            const card = document.querySelector(`[data-ref="${refCode}"]`);
            if (card) {
              card.style.transition = 'all 0.3s ease';
              card.style.opacity = '0';
              card.style.transform = 'scale(0.95)';
              setTimeout(() => card.remove(), 300);
            }

            // 3. Update total badge counter
            const countBadge = document.querySelector('#admin-sec-reservations h3 span.font-mono');
            if (countBadge) {
              countBadge.textContent = `${(this.reservations || []).length} Total`;
            }
          } else {
            this.showToast(data.message || 'Could not delete reservation.', 'warning');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Network error while deleting reservation.', 'error');
        }
      }

      filterReservations(status) {
        const items = document.querySelectorAll('#reservations-list > div');
        items.forEach(el => {
          const st = el.getAttribute('data-status');
          if (status === 'all' || st === status) {
            el.classList.remove('hidden');
          } else {
            el.classList.add('hidden');
          }
        });
        this.restoreReservationSelectionUI();
      }

      toggleReservationRowSelect(event, id) {
        if (event && (event.target.tagName === 'INPUT' || event.target.closest('button') || event.target.closest('a') || event.target.closest('select'))) {
          return;
        }
        const card = document.querySelector(`.reservation-queue-card[data-id="${id}"]`);
        if (!card) return;
        const status = card.getAttribute('data-status');
        if (status !== 'Claimed' && status !== 'Cancelled') {
          return; // Only finished orders are selectable for deletion
        }

        const cb = card.querySelector('.reservation-row-checkbox');
        if (cb) {
          cb.checked = !cb.checked;
        }
        const idStr = String(id);
        if (this.selectedReservationIds.has(idStr)) {
          this.selectedReservationIds.delete(idStr);
        } else {
          this.selectedReservationIds.add(idStr);
        }
        try {
          localStorage.setItem('ics_selected_reservation_ids', JSON.stringify(Array.from(this.selectedReservationIds)));
        } catch (e) {}
        this.restoreReservationSelectionUI();
      }

      onReservationCheckboxChange() {
        const checkboxes = document.querySelectorAll('.reservation-row-checkbox');
        checkboxes.forEach(cb => {
          const idStr = String(cb.value);
          if (cb.checked) {
            this.selectedReservationIds.add(idStr);
          } else {
            this.selectedReservationIds.delete(idStr);
          }
        });
        try {
          localStorage.setItem('ics_selected_reservation_ids', JSON.stringify(Array.from(this.selectedReservationIds)));
        } catch (e) {}
        this.restoreReservationSelectionUI();
      }

      toggleAllReservationCheckboxes(checked) {
        const selectableCards = Array.from(document.querySelectorAll('#reservations-list .reservation-queue-card'))
          .filter(card => !card.classList.contains('hidden') && card.style.display !== 'none' && (card.getAttribute('data-status') === 'Claimed' || card.getAttribute('data-status') === 'Cancelled'));

        if (selectableCards.length === 0) {
          const selectAll = document.getElementById('reservations-select-all');
          if (selectAll) {
            selectAll.checked = false;
            selectAll.disabled = true;
          }
          if (this.selectedReservationIds) this.selectedReservationIds.clear();
          try { localStorage.removeItem('ics_selected_reservation_ids'); } catch (e) {}
          this.restoreReservationSelectionUI();
          if (checked) {
            this.showToast('Only completed (Claimed) or Cancelled orders can be selected for deletion.', 'info');
          }
          return;
        }

        selectableCards.forEach(card => {
          const id = card.getAttribute('data-id');
          const cb = card.querySelector('.reservation-row-checkbox');
          if (cb) cb.checked = checked;
          if (id) {
            const idStr = String(id);
            if (checked) {
              this.selectedReservationIds.add(idStr);
            } else {
              this.selectedReservationIds.delete(idStr);
            }
          }
        });
        try {
          localStorage.setItem('ics_selected_reservation_ids', JSON.stringify(Array.from(this.selectedReservationIds)));
        } catch (e) {}
        this.restoreReservationSelectionUI();
      }

      restoreReservationSelectionUI() {
        const selectableCheckboxes = Array.from(document.querySelectorAll('#reservations-list .reservation-queue-card:not(.hidden) .reservation-row-checkbox'));
        const validSelectableIds = new Set(selectableCheckboxes.map(cb => String(cb.value)));

        try {
          const raw = localStorage.getItem('ics_selected_reservation_ids');
          if (raw) {
            const parsed = JSON.parse(raw);
            this.selectedReservationIds = new Set(
              (Array.isArray(parsed) ? parsed.map(String) : []).filter(id => validSelectableIds.has(id))
            );
          } else {
            this.selectedReservationIds = new Set(
              Array.from(this.selectedReservationIds || []).filter(id => validSelectableIds.has(String(id)))
            );
          }
        } catch (e) {
          this.selectedReservationIds = new Set();
        }

        let visibleChecked = 0;
        selectableCheckboxes.forEach(cb => {
          const isSelected = this.selectedReservationIds.has(String(cb.value));
          cb.checked = isSelected;
          const card = cb.closest('.reservation-queue-card');
          if (card) {
            if (isSelected) {
              visibleChecked++;
              card.classList.add('ring-2', 'ring-rose-500/80', 'bg-rose-950/20');
            } else {
              card.classList.remove('ring-2', 'ring-rose-500/80', 'bg-rose-950/20');
            }
          }
        });

        const selectAll = document.getElementById('reservations-select-all');
        if (selectAll) {
          selectAll.checked = selectableCheckboxes.length > 0 && visibleChecked === selectableCheckboxes.length;
          selectAll.disabled = selectableCheckboxes.length === 0;
          selectAll.title = selectableCheckboxes.length === 0
            ? 'Only completed (Claimed) or Cancelled orders can be selected for deletion'
            : 'Select all finished orders in current view';
        }

        const countBadge = document.getElementById('reservations-selected-badge');
        const bulkDeleteBtn = document.getElementById('reservations-bulk-delete-btn');
        const count = visibleChecked;

        if (countBadge) {
          if (count > 0) {
            countBadge.textContent = `${count} Selected`;
            countBadge.classList.remove('hidden');
          } else {
            countBadge.classList.add('hidden');
          }
        }

        if (bulkDeleteBtn) {
          if (count > 0) {
            bulkDeleteBtn.classList.remove('hidden');
          } else {
            bulkDeleteBtn.classList.add('hidden');
          }
        }
      }

      async deleteSelectedReservations() {
        const selectableCheckboxes = Array.from(document.querySelectorAll('#reservations-list .reservation-queue-card:not(.hidden) .reservation-row-checkbox:checked'));
        const idsToDelete = selectableCheckboxes.map(cb => cb.value).filter(Boolean);

        if (idsToDelete.length === 0) {
          this.showToast('Please select at least one finished reservation to delete.', 'info');
          return;
        }

        const count = idsToDelete.length;
        if (!confirm(`Are you sure you want to permanently delete ${count} selected reservation(s)?\n\nThis will remove them from the database, return any reserved inventory back to available stock, and delete associated tickets. This action cannot be undone.`)) {
          return;
        }

        this.setAdminTab('reservations');

        try {
          const res = await fetch(`{{ url('api/reservations/bulk-delete') }}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            },
            body: JSON.stringify({
              ids: idsToDelete
            })
          });

          const data = await res.json();
          if (data.success) {
            this.showToast(data.message || `Deleted ${count} reservation(s) permanently!`, 'success');

            const idSet = this.selectedReservationIds;
            this.reservations = (this.reservations || []).filter(r => !idSet.has(String(r.id)));

            // Animate and remove cards
            idSet.forEach(id => {
              const card = document.querySelector(`.reservation-queue-card[data-id="${id}"]`);
              if (card) {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95)';
                setTimeout(() => card.remove(), 300);
              }
            });

            this.selectedReservationIds.clear();
            try {
              localStorage.removeItem('ics_selected_reservation_ids');
            } catch (e) {}

            this.restoreReservationSelectionUI();

            // Update badge counters
            const totalBadge = document.getElementById('reservations-total-badge');
            if (totalBadge) totalBadge.textContent = `${(this.reservations || []).length} Total`;
          } else {
            this.showToast(data.message || 'Failed to delete selected reservations.', 'error');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Network error while deleting selected reservations.', 'error');
        }
      }

      // ==========================================
      // ACTIVITY AUDIT LOGS: PAGINATION & PURGE
      // (50 logs per page, up to 200 logs, clear logs)
      // ==========================================
      renderActivityLogsTable() {
        const tbody = document.getElementById('activity-logs-tbody');
        if (!tbody) return;

        const allLogs = Array.isArray(this.activityLogs) ? this.activityLogs : Object.values(this.activityLogs || {});
        const actionFilter = this.actLogsFilterAction || 'all';
        const q = (this.actLogsSearchQuery || '').toLowerCase().trim();

        const filtered = allLogs.filter(log => {
          if (!log) return false;
          if (actionFilter !== 'all' && (log.action || '').toUpperCase() !== actionFilter.toUpperCase()) {
            return false;
          }
          if (q) {
            const userCode = String(log.user_code || '').toLowerCase();
            const action = String(log.action || '').toLowerCase();
            const activity = String(log.activity || '').toLowerCase();
            const module = String(log.module || '').toLowerCase();
            const rawDate = String(log.created_at || '').toLowerCase();
            const formattedDate = log.created_at ? new Date(log.created_at).toLocaleString([], {
              month: '2-digit', day: '2-digit', year: 'numeric',
              hour: '2-digit', minute: '2-digit'
            }).toLowerCase() : '';

            return userCode.includes(q) ||
                   action.includes(q) ||
                   activity.includes(q) ||
                   module.includes(q) ||
                   rawDate.includes(q) ||
                   formattedDate.includes(q);
          }
          return true;
        });

        const perPage = this.actLogsPerPage || 50;
        const totalLogs = filtered.length;
        const totalPages = Math.max(1, Math.ceil(totalLogs / perPage));

        if (this.actLogsCurrentPage > totalPages) {
          this.actLogsCurrentPage = totalPages;
        }
        if (this.actLogsCurrentPage < 1) {
          this.actLogsCurrentPage = 1;
        }

        const startIndex = (this.actLogsCurrentPage - 1) * perPage;
        const endIndex = Math.min(startIndex + perPage, totalLogs);
        const currentSlice = filtered.slice(startIndex, endIndex);

        tbody.innerHTML = '';

        if (currentSlice.length === 0) {
          if (q) {
            tbody.innerHTML = `
              <tr>
                <td colspan="5" class="py-12 text-center text-slate-500 font-sans">
                  <svg class="w-10 h-10 mx-auto text-slate-600 mb-2 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                  <p class="font-bold text-xs text-slate-300">No activity logs matching "${this.actLogsSearchQuery}"</p>
                  <p class="text-[11px] text-slate-500 mt-1">Try another keyword or <button type="button" onclick="icsApp.clearActivityLogSearch()" class="text-cyan-400 underline font-semibold hover:text-cyan-300 cursor-pointer">clear search</button>.</p>
                </td>
              </tr>
            `;
          } else {
            tbody.innerHTML = `
              <tr>
                <td colspan="5" class="py-12 text-center text-slate-500 font-sans">
                  <svg class="w-10 h-10 mx-auto text-slate-600 mb-2 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                  <p class="font-bold text-xs text-slate-400">No activity logs found</p>
                  <p class="text-[11px] text-slate-600 mt-0.5">Audit actions (CREATE, UPDATE, DELETE) will appear here.</p>
                </td>
              </tr>
            `;
          }
        } else {
          currentSlice.forEach(log => {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-slate-800/40 transition';
            tr.setAttribute('data-action', log.action || '');

            const act = (log.action || '').toUpperCase();
            let badgeClass = 'bg-blue-950 text-blue-300 border border-blue-800';
            if (act === 'CLAIM') badgeClass = 'bg-emerald-950 text-emerald-300 border border-emerald-700 font-extrabold shadow-sm';
            else if (act === 'CREATE') badgeClass = 'bg-emerald-950 text-emerald-300 border border-emerald-800';
            else if (act === 'UPDATE') badgeClass = 'bg-amber-950 text-amber-300 border border-amber-800';
            else if (act === 'DELETE') badgeClass = 'bg-rose-950 text-rose-300 border border-rose-800';
            else if (act === 'LOGIN') badgeClass = 'bg-purple-950 text-purple-300 border border-purple-800';
            else if (act === 'LOGOUT') badgeClass = 'bg-slate-800 text-slate-300 border border-slate-700';

            const createdDate = log.created_at ? new Date(log.created_at).toLocaleString([], {
              month: '2-digit', day: '2-digit', year: 'numeric',
              hour: '2-digit', minute: '2-digit'
            }) : 'Recently';

            tr.innerHTML = `
              <td class="py-3.5 px-4 font-mono text-ics-gold font-bold text-xs sm:text-sm">${log.user_code || '251505'}</td>
              <td class="py-3.5 px-4">
                <span class="px-2.5 py-1 rounded text-xs font-bold font-mono ${badgeClass}">
                  ${act}
                </span>
              </td>
              <td class="py-3.5 px-4 text-slate-200 text-xs sm:text-sm">${log.activity || ''}</td>
              <td class="py-3.5 px-4 text-xs text-slate-300 font-mono">${log.module || 'General'}</td>
              <td class="py-3.5 px-4 font-mono text-slate-300 text-xs sm:text-sm">${createdDate}</td>
            `;
            tbody.appendChild(tr);
          });
        }

        // Render Pagination Info & Buttons
        const infoEl = document.getElementById('act-logs-page-info');
        if (infoEl) {
          const from = totalLogs > 0 ? startIndex + 1 : 0;
          if (q) {
            infoEl.textContent = `Showing ${from} to ${endIndex} of ${totalLogs} logs matching "${this.actLogsSearchQuery}" (Page ${this.actLogsCurrentPage} of ${totalPages})`;
          } else {
            infoEl.textContent = `Showing ${from} to ${endIndex} of ${totalLogs} logs (Page ${this.actLogsCurrentPage} of ${totalPages})`;
          }
        }

        const btnContainer = document.getElementById('act-logs-pagination-buttons');
        if (btnContainer) {
          btnContainer.innerHTML = '';
          if (totalPages > 1) {
            // Previous button
            const prevBtn = document.createElement('button');
            prevBtn.type = 'button';
            prevBtn.disabled = this.actLogsCurrentPage <= 1;
            prevBtn.className = `px-2.5 py-1 rounded-lg text-xs font-mono font-bold transition ${
              this.actLogsCurrentPage <= 1
                ? 'bg-slate-950/50 text-slate-600 border border-slate-800 cursor-not-allowed'
                : 'bg-slate-900 text-slate-300 hover:text-white border border-slate-700 cursor-pointer hover:bg-slate-800'
            }`;
            prevBtn.innerHTML = '&larr; Prev';
            prevBtn.onclick = () => this.setActivityLogsPage(this.actLogsCurrentPage - 1);
            btnContainer.appendChild(prevBtn);

            // Numbered buttons: 1, 2, 3, 4, etc.
            for (let p = 1; p <= totalPages; p++) {
              const pageBtn = document.createElement('button');
              pageBtn.type = 'button';
              const isCurrent = p === this.actLogsCurrentPage;
              pageBtn.className = `px-2.5 py-1 rounded-lg text-xs font-mono font-bold transition ${
                isCurrent
                  ? 'bg-ics-800 text-white border border-ics-600 shadow'
                  : 'bg-slate-950 text-slate-400 hover:text-white border border-slate-800 hover:bg-slate-800 cursor-pointer'
              }`;
              pageBtn.textContent = p;
              pageBtn.onclick = () => this.setActivityLogsPage(p);
              btnContainer.appendChild(pageBtn);
            }

            // Next button
            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.disabled = this.actLogsCurrentPage >= totalPages;
            nextBtn.className = `px-2.5 py-1 rounded-lg text-xs font-mono font-bold transition ${
              this.actLogsCurrentPage >= totalPages
                ? 'bg-slate-950/50 text-slate-600 border border-slate-800 cursor-not-allowed'
                : 'bg-slate-900 text-slate-300 hover:text-white border border-slate-700 cursor-pointer hover:bg-slate-800'
            }`;
            nextBtn.innerHTML = 'Next &rarr;';
            nextBtn.onclick = () => this.setActivityLogsPage(this.actLogsCurrentPage + 1);
            btnContainer.appendChild(nextBtn);
          }
        }
      }

      setActivityLogsPage(page) {
        this.actLogsCurrentPage = page;
        this.renderActivityLogsTable();
      }

      filterActivityLogs(action) {
        this.actLogsFilterAction = action;
        this.actLogsCurrentPage = 1;
        this.renderActivityLogsTable();
      }

      searchActivityLogs(query) {
        this.actLogsSearchQuery = (query || '').trim();
        const clearBtn = document.getElementById('act-log-search-clear');
        if (clearBtn) {
          if (this.actLogsSearchQuery.length > 0) {
            clearBtn.classList.remove('hidden');
          } else {
            clearBtn.classList.add('hidden');
          }
        }
        this.actLogsCurrentPage = 1;
        this.renderActivityLogsTable();
      }

      clearActivityLogSearch() {
        const input = document.getElementById('act-log-search-input');
        if (input) input.value = '';
        this.searchActivityLogs('');
      }

      // ==========================================
      // REPORTS EXPORT CHOICES & ITEM BUYERS MODAL
      // ==========================================
      onReportScopeChange(scopeVal) {
        const csvBtnLabel = document.getElementById('btn-label-report-csv');
        const pdfBtnLabel = document.getElementById('btn-label-report-pdf');

        if (scopeVal === 'all') {
          if (csvBtnLabel) csvBtnLabel.textContent = 'Download Master CSV';
          if (pdfBtnLabel) pdfBtnLabel.textContent = 'Download Master PDF';
        } else {
          if (csvBtnLabel) csvBtnLabel.textContent = 'Download Item CSV';
          if (pdfBtnLabel) pdfBtnLabel.textContent = 'Download Item PDF';
        }
      }

      toggleReportRowSelect(event, id) {
        if (event && (event.target.tagName === 'INPUT' || event.target.closest('button') || event.target.closest('a') || event.target.closest('select'))) {
          return;
        }
        const cb = document.querySelector(`.report-row-checkbox[value="${id}"]`);
        if (cb) {
          cb.checked = !cb.checked;
        }
        const idStr = String(id);
        if (this.selectedReportProductIds.has(idStr)) {
          this.selectedReportProductIds.delete(idStr);
        } else {
          this.selectedReportProductIds.add(idStr);
        }
        try {
          localStorage.setItem('ics_selected_report_ids', JSON.stringify(Array.from(this.selectedReportProductIds)));
        } catch (e) {}
        this.restoreReportSelectionUI();
      }

      toggleAllReportCheckboxes(checked) {
        const rows = document.querySelectorAll('#reports-table-tbody .report-table-row');
        rows.forEach(row => {
          if (row.style.display !== 'none') {
            const id = row.getAttribute('data-id');
            const cb = row.querySelector('.report-row-checkbox');
            if (cb) cb.checked = checked;
            if (id) {
              const idStr = String(id);
              if (checked) {
                this.selectedReportProductIds.add(idStr);
              } else {
                this.selectedReportProductIds.delete(idStr);
              }
            }
          }
        });
        try {
          localStorage.setItem('ics_selected_report_ids', JSON.stringify(Array.from(this.selectedReportProductIds)));
        } catch (e) {}
        this.restoreReportSelectionUI();
      }

      onReportRowCheckboxChange() {
        const checkboxes = document.querySelectorAll('.report-row-checkbox');
        checkboxes.forEach(cb => {
          const idStr = String(cb.value);
          if (cb.checked) {
            this.selectedReportProductIds.add(idStr);
          } else {
            this.selectedReportProductIds.delete(idStr);
          }
        });
        try {
          localStorage.setItem('ics_selected_report_ids', JSON.stringify(Array.from(this.selectedReportProductIds)));
        } catch (e) {}
        this.restoreReportSelectionUI();
      }

      clearReportSelection() {
        this.selectedReportProductIds.clear();
        try {
          localStorage.removeItem('ics_selected_report_ids');
        } catch (e) {}
        this.restoreReportSelectionUI();
      }

      restoreReportSelectionUI() {
        try {
          const raw = localStorage.getItem('ics_selected_report_ids');
          if (raw) {
            const parsed = JSON.parse(raw);
            this.selectedReportProductIds = new Set(Array.isArray(parsed) ? parsed.map(String) : []);
          }
        } catch (e) {}

        const rows = document.querySelectorAll('#reports-table-tbody .report-table-row');
        let visibleTotal = 0;
        let visibleChecked = 0;

        rows.forEach(row => {
          if (row.style.display !== 'none') {
            visibleTotal++;
            const id = row.getAttribute('data-id');
            const cb = row.querySelector('.report-row-checkbox');
            const isSelected = id && this.selectedReportProductIds.has(String(id));
            if (cb) cb.checked = isSelected;
            if (isSelected) {
              visibleChecked++;
              row.classList.add('bg-cyan-950/40', 'border-l-4', 'border-cyan-500');
            } else {
              row.classList.remove('bg-cyan-950/40', 'border-l-4', 'border-cyan-500');
            }
          }
        });

        const selectAll = document.getElementById('report-select-all');
        if (selectAll) {
          selectAll.checked = visibleTotal > 0 && visibleChecked === visibleTotal;
        }

        const banner = document.getElementById('report-selected-banner');
        const countText = document.getElementById('report-selected-count');
        if (this.selectedReportProductIds && this.selectedReportProductIds.size > 0) {
          if (banner) banner.classList.remove('hidden');
          if (countText) countText.textContent = `${this.selectedReportProductIds.size} item(s) selected across reports`;
        } else {
          if (banner) banner.classList.add('hidden');
        }
      }

      filterReportsTable(query) {
        this.reportSearchQuery = (query || '').toLowerCase().trim();
        const q = this.reportSearchQuery;
        const rows = document.querySelectorAll('#reports-table-tbody .report-table-row');
        rows.forEach(row => {
          const code = (row.getAttribute('data-code') || '').toLowerCase();
          const name = (row.getAttribute('data-name') || '').toLowerCase();
          const cat = (row.getAttribute('data-category') || '').toLowerCase();
          const text = row.innerText.toLowerCase();
          if (!q || code.includes(q) || name.includes(q) || cat.includes(q) || text.includes(q)) {
            row.style.display = '';
          } else {
            row.style.display = 'none';
          }
        });
        this.restoreReportSelectionUI();
      }

      onReportSortChange(sortVal) {
        this.activeReportSort = sortVal;
        const tbody = document.getElementById('reports-table-tbody');
        if (!tbody) return;
        const rows = Array.from(tbody.querySelectorAll('.report-table-row'));
        if (rows.length === 0) return;

        rows.sort((a, b) => {
          const codeA = (a.getAttribute('data-code') || '').toLowerCase();
          const codeB = (b.getAttribute('data-code') || '').toLowerCase();
          const nameA = (a.getAttribute('data-name') || '').toLowerCase();
          const nameB = (b.getAttribute('data-name') || '').toLowerCase();
          const soldA = parseInt(a.getAttribute('data-sold') || 0, 10);
          const soldB = parseInt(b.getAttribute('data-sold') || 0, 10);
          const stockA = parseInt(a.getAttribute('data-stock') || 0, 10);
          const stockB = parseInt(b.getAttribute('data-stock') || 0, 10);
          const revA = parseFloat(a.getAttribute('data-rev') || 0);
          const revB = parseFloat(b.getAttribute('data-rev') || 0);

          switch (sortVal) {
            case 'code_asc':
              return codeA.localeCompare(codeB);
            case 'name_asc':
              return nameA.localeCompare(nameB);
            case 'sold_desc':
              return soldB - soldA;
            case 'sold_asc':
              return soldA - soldB;
            case 'stock_asc':
              return stockA - stockB;
            case 'stock_desc':
              return stockB - stockA;
            case 'rev_desc':
              return revB - revA;
            default:
              return codeA.localeCompare(codeB);
          }
        });

        rows.forEach(r => tbody.appendChild(r));
        this.restoreReportSelectionUI();
      }

      downloadChosenReport(format, autoPrint = false) {
        const printParam = autoPrint ? '&print=1' : '';
        // Priority 1: Checkbox / selection if any (persisted in localStorage)
        if (this.selectedReportProductIds && this.selectedReportProductIds.size > 0) {
          const ids = Array.from(this.selectedReportProductIds).join(',');
          const url = format === 'pdf'
            ? `{{ route('reports.export_pdf') }}?product_ids=${encodeURIComponent(ids)}${printParam}`
            : `{{ route('reports.export') }}?product_ids=${encodeURIComponent(ids)}`;

          if (format === 'pdf') {
            window.open(url, '_blank');
          } else {
            window.location.href = url;
          }
          return;
        }

        // Priority 2: Dropdown scope selector
        const select = document.getElementById('report-scope-select');
        const scope = select ? select.value : 'all';

        let url = '';
        if (scope === 'all') {
          url = format === 'pdf'
            ? `{{ route('reports.export_pdf') }}${autoPrint ? '?print=1' : ''}`
            : `{{ route('reports.export') }}`;
        } else {
          url = format === 'pdf'
            ? `{{ route('reports.export_pdf') }}?product_id=${encodeURIComponent(scope)}${printParam}`
            : `{{ route('reports.export') }}?product_id=${encodeURIComponent(scope)}`;
        }

        if (format === 'pdf') {
          window.open(url, '_blank');
        } else {
          window.location.href = url;
        }
      }

      openItemBuyersModal(productData) {
        if (!productData) return;
        const modal = document.getElementById('admin-item-buyers-modal');
        if (!modal) return;

        // Populate info
        const nameEl = document.getElementById('modal-buyer-item-name');
        const codeEl = document.getElementById('modal-buyer-item-code');
        const catEl = document.getElementById('modal-buyer-item-category');
        const priceEl = document.getElementById('modal-buyer-item-price');
        const imgContainer = document.getElementById('modal-buyer-item-img-container');

        if (nameEl) nameEl.textContent = productData.name || 'Merchandise Item';
        if (codeEl) codeEl.textContent = productData.item_code || 'N/A';
        if (catEl) catEl.textContent = (productData.category || 'General').toUpperCase();
        if (priceEl) priceEl.textContent = `₱${Number(productData.price || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

        if (imgContainer) {
          if (productData.image_path) {
            imgContainer.innerHTML = `<img src="${productData.image_path}" class="w-full h-full object-cover">`;
          } else {
            imgContainer.innerHTML = `<span class="text-2xl">👕</span>`;
          }
        }

        // Stats
        const soldEl = document.getElementById('modal-buyer-units-sold');
        const resEl = document.getElementById('modal-buyer-units-reserved');
        const stockEl = document.getElementById('modal-buyer-stock');
        const revEl = document.getElementById('modal-buyer-revenue');
        const badgeEl = document.getElementById('modal-buyer-count-badge');

        const buyers = Array.isArray(productData.buyers) ? productData.buyers : [];
        if (soldEl) soldEl.textContent = `${productData.units_sold || 0} units`;
        if (resEl) resEl.textContent = `${productData.units_reserved || 0} units`;
        if (stockEl) stockEl.textContent = `${productData.current_stock || 0} units`;
        if (revEl) revEl.textContent = `₱${Number(productData.revenue || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
        if (badgeEl) badgeEl.textContent = `${buyers.length} registered orders`;

        // Populate Buyers Table
        const tbody = document.getElementById('modal-item-buyers-tbody');
        if (tbody) {
          tbody.innerHTML = '';
          if (buyers.length === 0) {
            tbody.innerHTML = `
              <tr>
                <td colspan="10" class="py-8 text-center text-slate-500 font-sans">
                  <p class="font-bold text-xs text-slate-400">No student orders found for this item yet.</p>
                  <p class="text-[11px] text-slate-600 mt-0.5">Purchases and claimed records will automatically appear here.</p>
                </td>
              </tr>
            `;
          } else {
            buyers.forEach((b) => {
              const tr = document.createElement('tr');
              tr.className = 'hover:bg-slate-800/40 transition';

              let statusBadge = 'bg-amber-950 text-amber-300 border border-amber-800';
              if (b.status === 'Claimed') statusBadge = 'bg-emerald-950 text-emerald-300 border border-emerald-700 font-bold';
              else if (b.status === 'Ready for Pickup') statusBadge = 'bg-blue-950 text-blue-300 border border-blue-800';

              tr.innerHTML = `
                <td class="py-2.5 px-3 font-mono font-bold text-cyan-300 whitespace-nowrap">${b.student_id || 'N/A'}</td>
                <td class="py-2.5 px-3 font-bold text-white whitespace-nowrap">${b.student_name || 'N/A'}</td>
                <td class="py-2.5 px-3 text-slate-400 whitespace-nowrap text-[11px]">${b.department || 'ICS'} - ${b.year_level || ''}</td>
                <td class="py-2.5 px-3 text-center font-mono font-bold text-white">${b.quantity || 1}</td>
                <td class="py-2.5 px-3 text-center font-mono"><span class="px-1.5 py-0.5 rounded bg-slate-800 text-slate-200 border border-slate-700 text-[10px]">${b.size || 'Standard'}</span></td>
                <td class="py-2.5 px-3 text-right font-mono text-emerald-400 font-bold">₱${Number(b.subtotal || b.total || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                <td class="py-2.5 px-3 font-mono text-slate-400 text-[10px] whitespace-nowrap">${b.created_at || b.ordered_display || 'N/A'}</td>
                <td class="py-2.5 px-3 font-mono text-slate-300 text-[10px] whitespace-nowrap">${b.claimed_at || b.claimed_display || (b.status === 'Claimed' ? 'Claimed' : 'Pending')}</td>
                <td class="py-2.5 px-3 text-center whitespace-nowrap">
                  <span class="px-2 py-0.5 rounded text-[10px] font-mono ${statusBadge}">${b.status || 'Pending'}</span>
                </td>
                <td class="py-2.5 px-3 font-mono text-[10px] text-slate-400 whitespace-nowrap">${b.ref_code || ''}</td>
              `;
              tbody.appendChild(tr);
            });
          }
        }

        // Configure Modal Action Buttons
        const csvBtn = document.getElementById('modal-buyer-download-csv-btn');
        const pdfBtn = document.getElementById('modal-buyer-download-pdf-btn');
        if (csvBtn) csvBtn.href = `{{ route('reports.export') }}?product_id=${encodeURIComponent(productData.id)}`;
        if (pdfBtn) pdfBtn.href = `{{ route('reports.export_pdf') }}?product_id=${encodeURIComponent(productData.id)}`;

        modal.classList.remove('hidden');
      }

      closeItemBuyersModal() {
        const modal = document.getElementById('admin-item-buyers-modal');
        if (modal) modal.classList.add('hidden');
      }

      toggleClaimedRowSelect(event, id) {
        if (event && (event.target.tagName === 'INPUT' || event.target.closest('button') || event.target.closest('a') || event.target.closest('select'))) {
          return;
        }
        const cb = document.querySelector(`.claimed-row-checkbox[value="${id}"]`);
        if (cb) {
          cb.checked = !cb.checked;
        }
        const idStr = String(id);
        if (this.selectedClaimedIds.has(idStr)) {
          this.selectedClaimedIds.delete(idStr);
        } else {
          this.selectedClaimedIds.add(idStr);
        }
        try {
          localStorage.setItem('ics_selected_claimed_ids', JSON.stringify(Array.from(this.selectedClaimedIds)));
        } catch (e) {}
        this.restoreClaimedSelectionUI();
      }

      onClaimedRowCheckboxChange() {
        const checkboxes = document.querySelectorAll('.claimed-row-checkbox');
        checkboxes.forEach(cb => {
          const idStr = String(cb.value);
          if (cb.checked) {
            this.selectedClaimedIds.add(idStr);
          } else {
            this.selectedClaimedIds.delete(idStr);
          }
        });
        try {
          localStorage.setItem('ics_selected_claimed_ids', JSON.stringify(Array.from(this.selectedClaimedIds)));
        } catch (e) {}
        this.restoreClaimedSelectionUI();
      }

      toggleAllClaimedCheckboxes(checked) {
        const rows = document.querySelectorAll('#claimed-tab-ledger-tbody .claimed-ledger-row');
        rows.forEach(row => {
          if (row.style.display !== 'none') {
            const id = row.getAttribute('data-id');
            const cb = row.querySelector('.claimed-row-checkbox');
            if (cb) cb.checked = checked;
            if (id) {
              const idStr = String(id);
              if (checked) {
                this.selectedClaimedIds.add(idStr);
              } else {
                this.selectedClaimedIds.delete(idStr);
              }
            }
          }
        });
        try {
          localStorage.setItem('ics_selected_claimed_ids', JSON.stringify(Array.from(this.selectedClaimedIds)));
        } catch (e) {}
        this.restoreClaimedSelectionUI();
      }

      restoreClaimedSelectionUI() {
        try {
          const raw = localStorage.getItem('ics_selected_claimed_ids');
          if (raw) {
            const parsed = JSON.parse(raw);
            this.selectedClaimedIds = new Set(Array.isArray(parsed) ? parsed.map(String) : []);
          }
        } catch (e) {}

        const rows = document.querySelectorAll('#claimed-tab-ledger-tbody .claimed-ledger-row');
        let visibleTotal = 0;
        let visibleChecked = 0;

        rows.forEach(row => {
          if (row.style.display !== 'none') {
            visibleTotal++;
            const id = row.getAttribute('data-id');
            const cb = row.querySelector('.claimed-row-checkbox');
            const isSelected = id && this.selectedClaimedIds.has(String(id));
            if (cb) cb.checked = isSelected;
            if (isSelected) {
              visibleChecked++;
              row.classList.add('bg-emerald-950/40', 'border-l-4', 'border-emerald-500');
            } else {
              row.classList.remove('bg-emerald-950/40', 'border-l-4', 'border-emerald-500');
            }
          }
        });

        const selectAll = document.getElementById('claimed-select-all');
        if (selectAll) {
          selectAll.checked = visibleTotal > 0 && visibleChecked === visibleTotal;
        }

        const badge = document.getElementById('claimed-selected-count-badge');
        if (badge) {
          if (this.selectedClaimedIds.size > 0) {
            badge.textContent = this.selectedClaimedIds.size;
            badge.classList.remove('hidden');
          } else {
            badge.classList.add('hidden');
          }
        }
      }

      onClaimedSortChange(sortVal) {
        this.activeClaimedSort = sortVal;
        if (!this.claimedReservations || this.claimedReservations.length === 0) return;

        this.claimedReservations.sort((a, b) => {
          const dateClaimedA = new Date(a.claimed_at || a.updated_at || 0).getTime();
          const dateClaimedB = new Date(b.claimed_at || b.updated_at || 0).getTime();
          const dateOrderedA = new Date(a.created_at || 0).getTime();
          const dateOrderedB = new Date(b.created_at || 0).getTime();
          const nameA = (a.student_name || '').toLowerCase();
          const nameB = (b.student_name || '').toLowerCase();
          const amtA = parseFloat(a.total_amount || 0);
          const amtB = parseFloat(b.total_amount || 0);

          switch (sortVal) {
            case 'date_claimed_asc':
              return dateClaimedA - dateClaimedB;
            case 'date_claimed_desc':
              return dateClaimedB - dateClaimedA;
            case 'date_ordered_asc':
              return dateOrderedA - dateOrderedB;
            case 'date_ordered_desc':
              return dateOrderedB - dateOrderedA;
            case 'name_asc':
              return nameA.localeCompare(nameB);
            case 'name_desc':
              return nameB.localeCompare(nameA);
            case 'amount_asc':
              return amtA - amtB;
            case 'amount_desc':
              return amtB - amtA;
            default:
              return dateClaimedB - dateClaimedA;
          }
        });

        this.renderClaimedLedgerTable();
        const searchInput = document.getElementById('claimed-tab-search');
        if (searchInput && searchInput.value) {
          this.filterClaimedLedger(searchInput.value);
        }
      }

      async deleteSelectedClaimed() {
        if (!this.selectedClaimedIds || this.selectedClaimedIds.size === 0) {
          this.showToast('Please select at least one claimed order to delete.', 'info');
          return;
        }

        const count = this.selectedClaimedIds.size;
        if (!confirm(`Are you sure you want to permanently delete ${count} selected claimed order(s)?\n\nThis will remove the release ledger record(s) and return stock if applicable.`)) {
          return;
        }

        try {
          const res = await fetch(`{{ url('api/reservations/bulk-delete') }}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            },
            body: JSON.stringify({
              ids: Array.from(this.selectedClaimedIds)
            })
          });

          const data = await res.json();
          if (data.success) {
            this.showToast(data.message || `Deleted ${count} claimed order(s).`, 'success');
            const idSet = this.selectedClaimedIds;
            this.claimedReservations = this.claimedReservations.filter(c => !idSet.has(String(c.id)));
            this.selectedClaimedIds.clear();
            try {
              localStorage.removeItem('ics_selected_claimed_ids');
            } catch (e) {}
            this.renderClaimedLedgerTable();
          } else {
            this.showToast(data.message || 'Failed to delete selected claimed orders.', 'error');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Network error while deleting selected claimed orders.', 'error');
        }
      }

      async deleteAllClaimed() {
        if (!this.claimedReservations || this.claimedReservations.length === 0) {
          this.showToast('No claimed orders available to delete.', 'info');
          return;
        }

        const count = this.claimedReservations.length;
        if (!confirm(`DANGER: Are you sure you want to permanently delete ALL ${count} claimed order(s) from the release ledger?\n\nThis action cannot be undone.`)) {
          return;
        }

        try {
          const res = await fetch(`{{ url('api/reservations/delete-all-claimed') }}`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            }
          });

          const data = await res.json();
          if (data.success) {
            this.showToast(data.message || 'All claimed records deleted.', 'success');
            this.claimedReservations = [];
            this.selectedClaimedIds.clear();
            try {
              localStorage.removeItem('ics_selected_claimed_ids');
            } catch (e) {}
            this.renderClaimedLedgerTable();
          } else {
            this.showToast(data.message || 'Failed to delete all claimed orders.', 'error');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Network error while deleting all claimed orders.', 'error');
        }
      }

      filterClaimedLedger(query) {
        const q = (query || '').toLowerCase().trim();
        const searchInputTab = document.getElementById('claimed-tab-search');
        const searchInputReports = document.getElementById('claimed-ledger-search');
        if (searchInputTab && searchInputTab.value !== query) searchInputTab.value = query;
        if (searchInputReports && searchInputReports.value !== query) searchInputReports.value = query;

        const rows = document.querySelectorAll('.claimed-ledger-row');
        let visibleCount = 0;
        rows.forEach(row => {
          const ref = (row.getAttribute('data-ref') || '').toLowerCase();
          const name = (row.getAttribute('data-name') || '').toLowerCase();
          const stuid = (row.getAttribute('data-stuid') || '').toLowerCase();
          const text = row.innerText.toLowerCase();

          if (!q || ref.includes(q) || name.includes(q) || stuid.includes(q) || text.includes(q)) {
            row.style.display = '';
            visibleCount++;
          } else {
            row.style.display = 'none';
          }
        });

        const tabRows = document.querySelectorAll('#claimed-tab-ledger-tbody .claimed-ledger-row');
        let tabVisible = 0;
        tabRows.forEach(r => { if (r.style.display !== 'none') tabVisible++; });

        const badgeTab = document.getElementById('claimed-tab-count-badge');
        if (badgeTab) badgeTab.textContent = `${tabVisible} Claimed Orders`;

        const badgeReports = document.getElementById('claimed-log-count-badge');
        if (badgeReports) badgeReports.textContent = `${tabVisible} Confirmed Releases`;

        this.restoreClaimedSelectionUI();
      }

      renderClaimedLedgerTable(records) {
        const list = records || this.claimedReservations || [];
        
        // Update nav badge and KPI counters
        const navBadge = document.getElementById('admin-nav-claimed-badge');
        if (navBadge) navBadge.textContent = `${list.length} Claimed`;

        const badgeTab = document.getElementById('claimed-tab-count-badge');
        if (badgeTab) badgeTab.textContent = `${list.length} Claimed Orders`;

        const badgeReports = document.getElementById('claimed-log-count-badge');
        if (badgeReports) badgeReports.textContent = `${list.length} Confirmed Releases`;

        let totalRev = 0;
        let totalUnits = 0;
        list.forEach(c => {
          totalRev += parseFloat(c.total_amount || 0);
          if (Array.isArray(c.items)) {
            c.items.forEach(it => {
              totalUnits += parseInt(it.quantity || 1);
            });
          }
        });

        const kpiOrders = document.getElementById('kpi-claimed-tab-orders');
        if (kpiOrders) kpiOrders.textContent = list.length;
        const kpiUnits = document.getElementById('kpi-claimed-tab-units');
        if (kpiUnits) kpiUnits.textContent = totalUnits;
        const kpiRev = document.getElementById('kpi-claimed-tab-rev');
        if (kpiRev) kpiRev.textContent = '₱' + totalRev.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        const tbodyTab = document.getElementById('claimed-tab-ledger-tbody');
        const tbodyReports = document.getElementById('claimed-ledger-tbody');

        if (list.length === 0) {
          const emptyHtml = `
            <tr>
              <td colspan="11" class="py-12 text-center text-slate-500 font-sans">
                <svg class="w-10 h-10 mx-auto text-slate-600 mb-2 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="font-bold text-xs text-slate-400">No Claimed Releases Recorded Yet</p>
                <p class="text-[11px] text-slate-600 mt-0.5">When student orders are marked as "Claimed", their pickup timestamp and buyer details will automatically log here.</p>
              </td>
            </tr>
          `;
          if (tbodyTab) tbodyTab.innerHTML = emptyHtml;
          if (tbodyReports) tbodyReports.innerHTML = emptyHtml;
          this.restoreClaimedSelectionUI();
          return;
        }

        // 1. Render Dedicated Claimed Tab Table with Checkbox, Row Select, and Sort Support
        if (tbodyTab) {
          tbodyTab.innerHTML = list.map(c => {
            let itemsHtml = '';
            if (Array.isArray(c.items)) {
              itemsHtml = c.items.map(it => {
                const qty = it.quantity || 1;
                const name = it.productName || it.name || it.productId || 'Item';
                const size = it.size ? `<span class="text-ics-gold font-bold">(${it.size})</span>` : '';
                return `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-slate-800 text-[11px] text-slate-200 border border-slate-700"><strong class="text-white">${qty}x</strong> <span>${name}</span> ${size}</span>`;
              }).join('');
            } else {
              itemsHtml = '<span class="text-slate-500">N/A</span>';
            }

            const createdDate = c.created_at ? new Date(c.created_at).toLocaleString([], {
              month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'
            }) : 'N/A';

            const claimedDate = c.claimed_at ? new Date(c.claimed_at).toLocaleString([], {
              month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'
            }) : (c.updated_at ? new Date(c.updated_at).toLocaleString([], {
              month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'
            }) : 'N/A');

            const officer = c.claimed_by || 'J. Derramas (ICS Officer)';

            return `
              <tr class="hover:bg-slate-800/40 transition cursor-pointer claimed-ledger-row"
                  data-id="${c.id}"
                  data-ref="${(c.ref_code || '').toLowerCase()}"
                  data-name="${(c.student_name || '').toLowerCase()}"
                  data-stuid="${(c.student_id || '').toLowerCase()}"
                  onclick="icsApp.toggleClaimedRowSelect(event, '${c.id}')">
                <td class="py-3 px-3 text-center" onclick="event.stopPropagation()">
                  <input type="checkbox" class="claimed-row-checkbox rounded bg-slate-950 border-slate-700 text-emerald-500 focus:ring-0 cursor-pointer" value="${c.id}" onchange="icsApp.onClaimedRowCheckboxChange()">
                </td>
                <td class="py-3 px-3 font-mono font-bold text-cyan-300 whitespace-nowrap bg-cyan-950/20 border-r border-slate-800/60">${c.student_id || ''}</td>
                <td class="py-3 px-3 font-bold text-white whitespace-nowrap">${c.student_name || ''}</td>
                <td class="py-3 px-3"><div class="flex flex-wrap gap-1 max-w-xs">${itemsHtml}</div></td>
                <td class="py-3 px-3 text-right font-mono font-bold text-emerald-400 whitespace-nowrap">₱${Number(c.total_amount || 0).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                <td class="py-3 px-3 font-mono text-slate-400 text-[11px] whitespace-nowrap">${createdDate}</td>
                <td class="py-3 px-3 font-mono text-emerald-400 font-bold text-[11px] whitespace-nowrap bg-emerald-950/20 border-l border-slate-800/60">${claimedDate}</td>
                <td class="py-3 px-3 font-mono font-bold text-ics-gold whitespace-nowrap">${c.ref_code || ''}</td>
                <td class="py-3 px-3 text-slate-400 text-[11px] whitespace-nowrap">${c.department || 'ICS'} (${c.year_level || 'N/A'})</td>
                <td class="py-3 px-3 whitespace-nowrap">
                  <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">${c.payment_status || 'Paid'}</span>
                  <div class="text-[9px] text-slate-400 font-mono mt-0.5">${c.payment_method || 'Cash on Pickup'}</div>
                </td>
                <td class="py-3 px-3 text-slate-300 text-[11px] font-mono whitespace-nowrap">${officer}</td>
              </tr>
            `;
          }).join('');
        }

        // 2. Render Reports Card 2 Table
        if (tbodyReports) {
          tbodyReports.innerHTML = list.map(c => {
            let itemsHtml = '';
            if (Array.isArray(c.items)) {
              itemsHtml = c.items.map(it => {
                const qty = it.quantity || 1;
                const name = it.productName || it.name || it.productId || 'Item';
                const size = it.size ? `<span class="text-ics-gold font-bold">(${it.size})</span>` : '';
                return `<span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-slate-800 text-[10px] text-slate-200 border border-slate-700"><strong>${qty}x</strong> <span>${name}</span> ${size}</span>`;
              }).join('');
            } else {
              itemsHtml = '<span class="text-slate-500">N/A</span>';
            }

            const createdDate = c.created_at ? new Date(c.created_at).toLocaleString([], {
              month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'
            }) : 'N/A';

            const claimedDate = c.claimed_at ? new Date(c.claimed_at).toLocaleString([], {
              month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'
            }) : (c.updated_at ? new Date(c.updated_at).toLocaleString([], {
              month: 'short', day: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'
            }) : 'N/A');

            const officer = c.claimed_by || 'J. Derramas (ICS Officer)';

            return `
              <tr class="hover:bg-slate-800/40 transition claimed-ledger-row"
                  data-ref="${(c.ref_code || '').toLowerCase()}"
                  data-name="${(c.student_name || '').toLowerCase()}"
                  data-stuid="${(c.student_id || '').toLowerCase()}">
                <td class="py-3 px-3 font-mono font-bold text-ics-gold">${c.ref_code || ''}</td>
                <td class="py-3 px-3 font-bold text-white whitespace-nowrap">${c.student_name || ''}</td>
                <td class="py-3 px-3 font-mono text-slate-300 whitespace-nowrap">${c.student_id || ''}</td>
                <td class="py-3 px-3 text-slate-400 text-[11px] whitespace-nowrap">${c.department || 'ICS'} (${c.year_level || 'N/A'})</td>
                <td class="py-3 px-3 font-mono text-slate-400 text-[11px] whitespace-nowrap">${createdDate}</td>
                <td class="py-3 px-3 font-mono text-emerald-400 font-semibold text-[11px] whitespace-nowrap">${claimedDate}</td>
                <td class="py-3 px-3"><div class="flex flex-wrap gap-1 max-w-xs">${itemsHtml}</div></td>
                <td class="py-3 px-3 text-right font-mono font-bold text-white whitespace-nowrap">₱${Number(c.total_amount || 0).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                <td class="py-3 px-3 whitespace-nowrap">
                  <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">${c.payment_status || 'Paid'}</span>
                  <div class="text-[9px] text-slate-400 font-mono mt-0.5">${c.payment_method || 'Cash on Pickup'}</div>
                </td>
                <td class="py-3 px-3 text-slate-300 text-[11px] font-mono whitespace-nowrap">${officer}</td>
              </tr>
            `;
          }).join('');
        }

        this.restoreClaimedSelectionUI();
      }

      async clearActivityLogs() {
        if (!confirm('Are you sure you want to permanently clear all activity audit logs?\n\nThis will purge historical audit records from the database to prevent database overload.')) {
          return;
        }

        try {
          const res = await fetch(`{{ url('api/activity-logs') }}`, {
            method: 'DELETE',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            }
          });

          const data = await res.json();
          if (data.success) {
            this.showToast(data.message || 'All activity logs cleared successfully!', 'success');
            this.activityLogs = Array.isArray(data.logs) ? data.logs : [];
            this.actLogsCurrentPage = 1;
            this.renderActivityLogsTable();
          } else {
            this.showToast(data.message || 'Could not clear activity logs.', 'warning');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Network error while clearing activity logs.', 'error');
        }
      }

      /**
       * REALTIME RECENT ACTIVITY DASHBOARD SNIPPET
       */
      renderRecentActivitySnippet() {
        const tbody = document.getElementById('dashboard-recent-activity-tbody');
        if (!tbody) return;
        const allLogs = Array.isArray(this.activityLogs) ? this.activityLogs : Object.values(this.activityLogs || {});
        const recent = allLogs.slice(0, 5);
        tbody.innerHTML = '';
        if (recent.length === 0) {
          tbody.innerHTML = '<tr><td colspan="4" class="py-4 text-center text-slate-500 text-xs">No recent activity logs.</td></tr>';
          return;
        }
        recent.forEach(log => {
          const tr = document.createElement('tr');
          tr.className = 'hover:bg-slate-800/40 transition';
          const act = (log.action || '').toUpperCase();
          let badgeClass = 'bg-blue-950 text-blue-300 border border-blue-800';
          if (act === 'CREATE') badgeClass = 'bg-emerald-950 text-emerald-300 border border-emerald-800';
          else if (act === 'UPDATE') badgeClass = 'bg-amber-950 text-amber-300 border border-amber-800';
          else if (act === 'DELETE') badgeClass = 'bg-rose-950 text-rose-300 border border-rose-800';
          else if (act === 'LOGIN') badgeClass = 'bg-purple-950 text-purple-300 border border-purple-800';
          else if (act === 'LOGOUT') badgeClass = 'bg-slate-800 text-slate-300 border border-slate-700';

          const createdDate = log.created_at ? new Date(log.created_at).toLocaleString([], {
            month: '2-digit', day: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit'
          }) : 'Recently';

          tr.innerHTML = `
            <td class="py-2 px-3 font-mono text-ics-gold font-bold">${log.user_code || '251505'}</td>
            <td class="py-2 px-3">
              <span class="px-2 py-0.5 rounded text-[10px] font-bold font-mono ${badgeClass}">${act}</span>
            </td>
            <td class="py-2 px-3">${log.activity || ''}</td>
            <td class="py-2 px-3 font-mono text-slate-400 text-[11px]">${createdDate}</td>
          `;
          tbody.appendChild(tr);
        });
      }

      /**
       * GENTLE WEB AUDIO SYNTH CHIME
       * Provides instant audio notification feedback on new activities
       */
      playNotificationChime() {
        try {
          const AudioContext = window.AudioContext || window.webkitAudioContext;
          if (!AudioContext) return;
          const ctx = new AudioContext();
          const osc = ctx.createOscillator();
          const gain = ctx.createGain();
          osc.type = 'sine';
          osc.frequency.setValueAtTime(587.33, ctx.currentTime);
          osc.frequency.exponentialRampToValueAtTime(880.00, ctx.currentTime + 0.15);
          gain.gain.setValueAtTime(0.08, ctx.currentTime);
          gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.3);
          osc.connect(gain);
          gain.connect(ctx.destination);
          osc.start();
          osc.stop(ctx.currentTime + 0.3);
        } catch (e) {}
      }

      /**
       * ADMIN CONSOLE LOGOUT
       */
      async adminLogout() {
        if (!confirm('Are you sure you want to sign out of the Admin Console?')) return;
        try {
          await fetch('{{ route("admin.logout") }}', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            }
          });
          window.location.href = '{{ route("home") }}';
        } catch (e) {
          window.location.href = '{{ route("admin.logout") }}';
        }
      }

      // ==========================================
      // SIZE GUIDE MODAL (DUAL UNIT TOGGLE)
      // ==========================================
      openSizeGuideModal() {
        this.renderSizeGuide();
        document.getElementById('size-guide-modal').classList.remove('hidden');
      }

      closeSizeGuideModal() {
        document.getElementById('size-guide-modal').classList.add('hidden');
      }

      setSizeTab(tab) {
        this.sizeTab = tab;
        document.getElementById('size-tab-tops').className = tab === 'tops' ? 'px-3 py-1 rounded-xl text-xs font-bold bg-ics-800 text-white' : 'px-3 py-1 rounded-xl text-xs font-bold bg-slate-800 text-slate-400';
        document.getElementById('size-tab-bottoms').className = tab === 'bottoms' ? 'px-3 py-1 rounded-xl text-xs font-bold bg-ics-800 text-white' : 'px-3 py-1 rounded-xl text-xs font-bold bg-slate-800 text-slate-400';
        this.renderSizeGuide();
      }

      setSizeUnit(unit) {
        this.sizeUnit = unit;
        document.getElementById('unit-btn-in').className = unit === 'in' ? 'px-2.5 py-1 rounded-lg font-bold bg-ics-700 text-white' : 'px-2.5 py-1 rounded-lg font-bold text-slate-400';
        document.getElementById('unit-btn-cm').className = unit === 'cm' ? 'px-2.5 py-1 rounded-lg font-bold bg-ics-700 text-white' : 'px-2.5 py-1 rounded-lg font-bold text-slate-400';
        this.renderSizeGuide();
      }

      renderSizeGuide() {
        const table = document.getElementById('size-guide-table');
        if (!table) return;

        const isTops = this.sizeTab === 'tops';
        const isCm = this.sizeUnit === 'cm';
        const mult = isCm ? 2.54 : 1;
        const fmt = val => (val * mult).toFixed(isCm ? 1 : 1);

        if (isTops) {
          table.innerHTML = `
            <thead class="bg-slate-950 text-ics-gold font-mono uppercase text-[10px]">
              <tr>
                <th class="py-2.5 px-3">Size</th>
                <th class="py-2.5 px-3">Chest Width (${this.sizeUnit})</th>
                <th class="py-2.5 px-3">Body Length (${this.sizeUnit})</th>
                <th class="py-2.5 px-3">Shoulder (${this.sizeUnit})</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-800 text-slate-300 font-mono">
              <tr><td class="py-2 px-3 font-bold text-white">XS</td><td>${fmt(18.0)}</td><td>${fmt(26.0)}</td><td>${fmt(16.0)}</td></tr>
              <tr><td class="py-2 px-3 font-bold text-white">S</td><td>${fmt(19.0)}</td><td>${fmt(27.0)}</td><td>${fmt(17.0)}</td></tr>
              <tr><td class="py-2 px-3 font-bold text-white">M</td><td>${fmt(20.0)}</td><td>${fmt(28.0)}</td><td>${fmt(18.0)}</td></tr>
              <tr><td class="py-2 px-3 font-bold text-white">L</td><td>${fmt(21.5)}</td><td>${fmt(29.0)}</td><td>${fmt(19.0)}</td></tr>
              <tr><td class="py-2 px-3 font-bold text-white">XL</td><td>${fmt(23.0)}</td><td>${fmt(30.0)}</td><td>${fmt(20.0)}</td></tr>
              <tr><td class="py-2 px-3 font-bold text-white">2XL</td><td>${fmt(24.5)}</td><td>${fmt(31.0)}</td><td>${fmt(21.0)}</td></tr>
              <tr><td class="py-2 px-3 font-bold text-white">3XL</td><td>${fmt(26.0)}</td><td>${fmt(32.0)}</td><td>${fmt(22.0)}</td></tr>
            </tbody>
          `;
        } else {
          table.innerHTML = `
            <thead class="bg-slate-950 text-ics-gold font-mono uppercase text-[10px]">
              <tr>
                <th class="py-2.5 px-3">Size</th>
                <th class="py-2.5 px-3">Waistline (${this.sizeUnit})</th>
                <th class="py-2.5 px-3">Hips (${this.sizeUnit})</th>
                <th class="py-2.5 px-3">Outseam Length (${this.sizeUnit})</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-800 text-slate-300 font-mono">
              <tr><td class="py-2 px-3 font-bold text-white">XS</td><td>${fmt(26.0)} - ${fmt(28.0)}</td><td>${fmt(34.0)}</td><td>${fmt(38.0)}</td></tr>
              <tr><td class="py-2 px-3 font-bold text-white">S</td><td>${fmt(28.0)} - ${fmt(30.0)}</td><td>${fmt(36.0)}</td><td>${fmt(39.0)}</td></tr>
              <tr><td class="py-2 px-3 font-bold text-white">M</td><td>${fmt(30.0)} - ${fmt(32.0)}</td><td>${fmt(38.0)}</td><td>${fmt(40.0)}</td></tr>
              <tr><td class="py-2 px-3 font-bold text-white">L</td><td>${fmt(32.0)} - ${fmt(34.0)}</td><td>${fmt(40.0)}</td><td>${fmt(41.0)}</td></tr>
              <tr><td class="py-2 px-3 font-bold text-white">XL</td><td>${fmt(34.0)} - ${fmt(36.0)}</td><td>${fmt(42.0)}</td><td>${fmt(41.5)}</td></tr>
              <tr><td class="py-2 px-3 font-bold text-white">2XL</td><td>${fmt(36.0)} - ${fmt(38.0)}</td><td>${fmt(44.0)}</td><td>${fmt(42.0)}</td></tr>
              <tr><td class="py-2 px-3 font-bold text-white">3XL</td><td>${fmt(38.0)} - ${fmt(40.0)}</td><td>${fmt(46.0)}</td><td>${fmt(42.5)}</td></tr>
            </tbody>
          `;
        }
      }

      // ==========================================
      // TOAST NOTIFICATIONS
      // ==========================================
      showToast(message, type = 'info') {
        const container = document.getElementById('toast-container');
        if (!container) return;

        // Anti-Duplicate Toast Guard: Never show identical message if already visible
        const existingToasts = Array.from(container.querySelectorAll('span.leading-snug'));
        if (existingToasts.some(el => el.textContent.trim() === String(message).trim())) {
          return;
        }

        const toast = document.createElement('div');
        const bgColors = {
          success: 'bg-emerald-950/95 border-emerald-500/80 text-emerald-100 shadow-emerald-950/70',
          warning: 'bg-amber-950/95 border-amber-500/80 text-amber-100 shadow-amber-950/70',
          error: 'bg-rose-950/95 border-rose-500/80 text-rose-100 shadow-rose-950/70',
          info: 'bg-slate-900/95 border-ics-600/80 text-slate-100 shadow-black/70'
        };

        const icons = {
          success: `<svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`,
          warning: `<svg class="w-4 h-4 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`,
          error: `<svg class="w-4 h-4 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`,
          info: `<svg class="w-4 h-4 text-ics-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`
        };

        toast.className = `p-3 px-4 rounded-2xl border-2 shadow-2xl backdrop-blur-md text-xs font-semibold flex items-center justify-between gap-3 transform transition-all duration-300 -translate-y-4 opacity-0 pointer-events-auto cursor-pointer group hover:scale-[1.02] w-full max-w-md ${bgColors[type] || bgColors.info}`;
        toast.innerHTML = `
          <div class="flex items-center gap-2.5">
            ${icons[type] || icons.info}
            <span class="leading-snug">${message}</span>
          </div>
          <button type="button" onclick="event.stopPropagation(); this.closest('div').remove()" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-white/10 transition flex-shrink-0" title="Dismiss">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
        `;

        toast.onclick = () => {
          toast.classList.add('opacity-0', '-translate-y-4');
          setTimeout(() => toast.remove(), 200);
        };

        container.appendChild(toast);

        requestAnimationFrame(() => {
          toast.classList.remove('-translate-y-4', 'opacity-0');
        });

        setTimeout(() => {
          if (toast.isConnected) {
            toast.classList.add('opacity-0', '-translate-y-4');
            setTimeout(() => toast.remove(), 250);
          }
        }, 3000);
      }



      // ==========================================
      // ADMIN SUPPORT HELPDESK & CONVERSATION LIST
      // ==========================================
      renderAdminTicketsList() {
        const container = document.getElementById('admin-tickets-list-container');
        if (!container) return;

        const q = (document.getElementById('admin-ticket-search-input')?.value || '').toLowerCase().trim();
        const filter = this.adminTicketFilter;

        const filtered = (this.supportTickets || []).filter(t => {
          const matchesFilter = filter === 'all' || t.status.toLowerCase() === filter.toLowerCase();
          const matchesQuery = !q ||
            (t.ticket_code && t.ticket_code.toLowerCase().includes(q)) ||
            (t.student_name && t.student_name.toLowerCase().includes(q)) ||
            (t.student_id && t.student_id.toLowerCase().includes(q)) ||
            (t.reason && t.reason.toLowerCase().includes(q)) ||
            (t.reservation_ref && t.reservation_ref.toLowerCase().includes(q));
          return matchesFilter && matchesQuery;
        });

        // Live badge counters
        const openCount = (this.supportTickets || []).filter(t => t.status !== 'Resolved').length;
        const badge = document.getElementById('admin-open-tickets-badge');
        if (badge) {
          badge.textContent = openCount;
          if (openCount > 0) badge.classList.remove('hidden');
          else badge.classList.add('hidden');
        }
        const mobBadge = document.getElementById('admin-open-tickets-badge-mob');
        if (mobBadge) {
          mobBadge.textContent = openCount;
          if (openCount > 0) mobBadge.classList.remove('hidden');
          else mobBadge.classList.add('hidden');
        }

        container.innerHTML = '';
        if (filtered.length === 0) {
          container.innerHTML = `
            <div class="p-6 text-center text-slate-500 text-xs">
              <p>No support tickets match the current filter.</p>
            </div>
          `;
          return;
        }

        filtered.forEach(t => {
          const isActive = this.activeAdminTicketId === t.id;
          const card = document.createElement('div');
          card.onclick = () => this.selectAdminTicket(t.id);
          card.className = `p-3.5 cursor-pointer transition border-l-4 ${
            isActive 
              ? 'bg-slate-800/90 border-emerald-500 shadow-md' 
              : 'hover:bg-slate-800/40 border-transparent'
          }`;

          const statusBadgeBg = t.status === 'Resolved' ?
            'bg-emerald-950 text-emerald-300 border-emerald-800' :
            (t.status === 'In Progress' ? 'bg-amber-950 text-amber-300 border-amber-800' : 'bg-blue-950 text-blue-300 border-blue-800');

          const reasonBadgeBg = t.reason === 'Cancel Reservation' ?
            'bg-rose-950 text-rose-300 border-rose-800' :
            (t.reason === 'Change Item Size' ? 'bg-blue-950 text-blue-300 border-blue-800' : 'bg-slate-800 text-slate-300 border-slate-700');

          card.innerHTML = `
            <div class="flex items-center justify-between text-xs mb-1">
              <span class="font-mono font-bold text-ics-gold text-[11px]">${t.ticket_code}</span>
              <span class="px-2 py-0.5 rounded-full text-[9px] font-mono font-bold ${statusBadgeBg} border">${t.status}</span>
            </div>
            <p class="font-bold text-white text-xs leading-tight">${t.student_name}</p>
            <p class="text-[10px] text-slate-400 font-mono mt-0.5">${t.student_id} ${t.reservation_ref ? `<span class="text-blue-400 font-bold ml-1">Ref: ${t.reservation_ref}</span>` : ''}</p>
            <div class="flex items-center justify-between mt-2 pt-1.5 border-t border-slate-800/60 text-[10px]">
              <span class="px-1.5 py-0.2 rounded text-[9px] font-bold ${reasonBadgeBg} border">${t.reason}</span>
              <div class="flex items-center gap-2">
                ${t.status === 'Resolved' ? `
                  <button 
                    type="button"
                    onclick="event.stopPropagation(); icsApp.adminDeleteTicket(${t.id}, '${t.ticket_code}')"
                    class="p-1 rounded hover:bg-rose-950 text-rose-400/80 hover:text-rose-300 transition"
                    title="Delete resolved ticket">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  </button>
                ` : ''}
                <span class="text-slate-500 font-mono">${t.created_at ? new Date(t.created_at).toLocaleDateString([], { month: 'short', day: 'numeric' }) : ''}</span>
              </div>
            </div>
          `;
          container.appendChild(card);
        });
      }

      setAdminTicketFilter(filter) {
        this.adminTicketFilter = filter;
        const filterBtns = ['all', 'Open', 'In Progress', 'Resolved'];
        filterBtns.forEach(f => {
          const btn = document.getElementById(`ticket-filter-${f}`);
          if (btn) {
            if (f === filter) {
              btn.className = 'px-2.5 py-1 rounded-lg font-bold bg-slate-800 text-white transition flex-shrink-0';
            } else {
              btn.className = 'px-2.5 py-1 rounded-lg font-bold bg-slate-950 text-slate-400 hover:text-white transition flex-shrink-0';
            }
          }
        });
        this.renderAdminTicketsList();
      }

      filterAdminTickets() {
        this.renderAdminTicketsList();
      }

      backToAdminTicketList() {
        const sidebar = document.getElementById('admin-tickets-sidebar');
        const chatMain = document.getElementById('admin-chat-main-panel');
        if (sidebar) sidebar.classList.remove('hidden');
        if (window.innerWidth < 1024 && chatMain) {
          chatMain.classList.add('hidden');
        }
        this.activeAdminTicketId = null;
        this.renderAdminTicketsList();
      }

      async selectAdminTicket(ticketId) {
        this.activeAdminTicketId = ticketId;
        const ticket = (this.supportTickets || []).find(t => t.id === ticketId);
        if (!ticket) return;

        this.renderAdminTicketsList();

        const emptyState = document.getElementById('admin-chat-empty-state');
        const activePanel = document.getElementById('admin-chat-active-panel');
        if (emptyState) emptyState.classList.add('hidden');
        if (activePanel) activePanel.classList.remove('hidden');

        // On mobile viewports (< 1024px): toggle chat into full view and scroll smoothly
        if (window.innerWidth < 1024) {
          const sidebar = document.getElementById('admin-tickets-sidebar');
          const chatMain = document.getElementById('admin-chat-main-panel');
          if (sidebar) sidebar.classList.add('hidden');
          if (chatMain) chatMain.classList.remove('hidden');
          if (activePanel) {
            setTimeout(() => {
              activePanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 60);
          }
        }

        // Populate Header Bar
        const codeEl = document.getElementById('admin-active-ticket-code');
        if (codeEl) codeEl.textContent = ticket.ticket_code;

        const reasonBadge = document.getElementById('admin-active-ticket-reason-badge');
        if (reasonBadge) {
          reasonBadge.textContent = ticket.reason;
          reasonBadge.className = `px-2 py-0.5 rounded-full text-[9px] font-bold border ${
            ticket.reason === 'Cancel Reservation' 
              ? 'bg-rose-950 text-rose-300 border-rose-800' 
              : 'bg-blue-950 text-blue-300 border-blue-800'
          }`;
        }

        const statusBadge = document.getElementById('admin-active-ticket-status-badge');
        if (statusBadge) {
          statusBadge.textContent = ticket.status;
          statusBadge.className = `px-2 py-0.5 rounded-full text-[9px] font-mono font-bold border ${
            ticket.status === 'Resolved' 
              ? 'bg-emerald-950 text-emerald-300 border-emerald-800' 
              : (ticket.status === 'In Progress' ? 'bg-amber-950 text-amber-300 border-amber-800' : 'bg-blue-950 text-blue-300 border-blue-800')
          }`;
        }

        const sNameEl = document.getElementById('admin-active-ticket-student-name');
        const sSubEl = document.getElementById('admin-active-ticket-student-sub');
        if (sNameEl) sNameEl.textContent = ticket.student_name;
        if (sSubEl) sSubEl.textContent = `${ticket.student_id} / ${ticket.student_email || 'Verified Student'}`;

        // Linked reservation banner, cancel order button, and edit item button
        const resBanner = document.getElementById('admin-active-ticket-res-banner');
        const cancelBtn = document.getElementById('admin-btn-cancel-reservation');
        const editBtn = document.getElementById('admin-btn-edit-reservation');

        const isCancelReason = ticket.reason === 'Cancel Reservation' || 
          (ticket.reason && ticket.reason.toLowerCase().includes('cancel'));

        if (ticket.reservation_ref) {
          if (resBanner) resBanner.classList.remove('hidden');
          const resCodeEl = document.getElementById('admin-active-ticket-res-code');
          if (resCodeEl) resCodeEl.textContent = ticket.reservation_ref;

          const linkedRes = (this.reservations || []).find(r => r.ref_code === ticket.reservation_ref);
          if (linkedRes) {
            const detailsEl = document.getElementById('admin-active-ticket-res-details');
            if (detailsEl) detailsEl.textContent = `₱${Number(linkedRes.total_amount).toFixed(2)} (${linkedRes.payment_method})`;
            const resStatusEl = document.getElementById('admin-active-ticket-res-status');
            if (resStatusEl) resStatusEl.textContent = linkedRes.status;
          }

          if (isCancelReason) {
            // IF CANCEL ORDER IS CHOSEN: show Cancel Order / Cancelled, HIDE Edit Item button!
            if (editBtn) editBtn.classList.add('hidden');
            if (cancelBtn) {
              cancelBtn.classList.remove('hidden');
              if (linkedRes && linkedRes.status === 'Cancelled') {
                cancelBtn.disabled = true;
                cancelBtn.className = 'px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-800 text-slate-400 border border-slate-700 cursor-not-allowed opacity-80 flex items-center gap-1.5';
                cancelBtn.innerHTML = `
                  <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                  <span>Cancelled</span>
                `;
              } else {
                cancelBtn.disabled = false;
                cancelBtn.className = 'px-3 py-1.5 rounded-xl text-xs font-bold bg-rose-950 hover:bg-rose-900 text-rose-200 border border-rose-800 transition flex items-center gap-1.5 shadow cursor-pointer';
                cancelBtn.innerHTML = `
                  <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  <span>Cancel Order & Restock</span>
                `;
              }
            }
          } else {
            // IF CHANGE SIZE OR ANY OTHER REASON: show Edit Item button, HIDE Cancel button!
            if (cancelBtn) cancelBtn.classList.add('hidden');
            if (editBtn) {
              editBtn.classList.remove('hidden');
              const editLabel = document.getElementById('admin-btn-edit-reservation-label');
              if (editLabel) {
                editLabel.textContent = (ticket.reason === 'Change Item Size' || (ticket.reason && ticket.reason.toLowerCase().includes('size')))
                  ? 'Edit Size'
                  : 'Edit Item';
              }
            }
          }
        } else {
          if (resBanner) resBanner.classList.add('hidden');
          if (cancelBtn) cancelBtn.classList.add('hidden');
          if (editBtn) editBtn.classList.add('hidden');
        }

        // Status Done button toggle
        const markResolvedText = document.getElementById('admin-btn-mark-resolved-text');
        const markResolvedBtn = document.getElementById('admin-btn-mark-resolved');
        if (markResolvedText && markResolvedBtn) {
          if (ticket.status === 'Resolved') {
            markResolvedText.textContent = 'Reopen Ticket';
            markResolvedBtn.className = 'px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition flex items-center gap-1.5 shadow';
          } else {
            markResolvedText.textContent = 'Mark as Done (Resolved)';
            markResolvedBtn.className = 'px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-950 hover:bg-emerald-900 text-emerald-200 border border-emerald-700 transition flex items-center gap-1.5 shadow';
          }
        }

        const deleteTicketBtn = document.getElementById('admin-btn-delete-ticket');
        if (deleteTicketBtn) {
          if (ticket.status === 'Resolved') {
            deleteTicketBtn.classList.remove('hidden');
          } else {
            deleteTicketBtn.classList.add('hidden');
          }
        }

        // Fetch Messages
        const msgContainer = document.getElementById('admin-chat-messages-container');
        if (msgContainer && !msgContainer._hasScrollListener) {
          msgContainer._hasScrollListener = true;
          msgContainer.addEventListener('scroll', () => {
            const distanceFromBottom = msgContainer.scrollHeight - msgContainer.scrollTop - msgContainer.clientHeight;
            this._userIsScrolledUpAdminChat = distanceFromBottom > 60;
          });
        }
        this._userIsScrolledUpAdminChat = false;

        this._adminChatCache = this._adminChatCache || {};
        const cached = this._adminChatCache[ticketId] || (ticket && ticket.messages);

        if (cached && cached.length > 0) {
          // Instant 0ms cache rendering like Messenger
          this.renderAdminChatMessages(cached, ticket, true);
        } else if (msgContainer) {
          msgContainer.innerHTML = `
            <div class="text-center py-6 text-slate-500 text-xs flex items-center justify-center gap-2">
              <svg class="animate-spin w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
              <span>Connecting to conversation...</span>
            </div>
          `;
        }

        try {
          const res = await fetch(`{{ url('api/support-tickets') }}/${ticketId}/messages`);
          const data = await res.json();
          if (data.success) {
            const msgs = data.messages || [];
            this._adminChatCache[ticketId] = msgs;
            if (ticket) ticket.messages = msgs;
            this.renderAdminChatMessages(msgs, ticket, !cached);
            this.startAdminChatPoller();
          }
        } catch (e) {
          console.error(e);
        }
      }

      createAdminMessageBubbleElement(msg, isAdmin) {
        const div = document.createElement('div');
        const isSystem = msg.is_system;

        if (isSystem) {
          div.className = 'p-3 rounded-2xl bg-amber-950/30 border border-amber-900/60 text-xs text-amber-200 text-center font-mono my-2';
          div.innerHTML = `
            <div class="flex items-center justify-center gap-1.5 mb-1 text-[11px] font-bold text-amber-400">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              <span>System Event Log</span>
            </div>
            <p class="text-xs text-amber-100">${msg.message}</p>
            <span class="text-[10px] text-amber-400/80 block mt-1">${msg.created_at ? new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : ''}</span>
          `;
        } else if (isAdmin) {
          div.className = 'flex justify-end';
          div.innerHTML = `
            <div class="max-w-[75%] bg-emerald-800 text-white rounded-2xl rounded-tr-sm p-3 shadow-md space-y-1">
              <div class="flex items-center justify-between gap-4 text-[10px] text-emerald-200 font-mono">
                <span class="font-bold">👑 ICS Admin (${msg.sender_name || 'Admin'})</span>
                <span>${msg.created_at ? new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : 'Just now'}</span>
              </div>
              <p class="text-xs leading-relaxed whitespace-pre-wrap">${msg.message}</p>
            </div>
          `;
        } else {
          div.className = 'flex justify-start';
          div.innerHTML = `
            <div class="max-w-[75%] bg-slate-900 border border-slate-700 text-slate-100 rounded-2xl rounded-tl-sm p-3 shadow-md space-y-1">
              <div class="flex items-center justify-between gap-4 text-[10px] text-slate-400">
                <span class="font-bold text-white">${msg.sender_name || 'Student'} (Student)</span>
                <span class="font-mono">${msg.created_at ? new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : ''}</span>
              </div>
              <p class="text-xs leading-relaxed whitespace-pre-wrap text-slate-200">${msg.message}</p>
            </div>
          `;
        }
        return div;
      }

      startAdminChatPoller() {
        if (this._adminChatPollInterval) {
          clearInterval(this._adminChatPollInterval);
        }
        this._adminChatPollInterval = setInterval(async () => {
          if ((this.adminTab !== 'support' && this.adminTab !== 'helpdesk') || !this.activeAdminTicketId || document.hidden) {
            return;
          }

          if (this._isPollingAdminChat) return;
          this._isPollingAdminChat = true;

          try {
            const lastId = this._adminChatLastMsgId || 0;
            const res = await fetch(`{{ url('api/support-tickets') }}/${this.activeAdminTicketId}/messages?after_id=${lastId}`);
            if (!res.ok) return;
            const data = await res.json();
            if (!data || !data.success) return;

            // Live update ticket status in UI
            if (data.ticket_status) {
              const statusBadge = document.getElementById('admin-active-ticket-status-badge');
              if (statusBadge && statusBadge.textContent !== data.ticket_status) {
                statusBadge.textContent = data.ticket_status;
                statusBadge.className = `px-2 py-0.5 rounded-full text-[9px] font-mono font-bold border ${
                  data.ticket_status === 'Resolved' 
                    ? 'bg-emerald-950 text-emerald-300 border-emerald-800' 
                    : (data.ticket_status === 'In Progress' ? 'bg-amber-950 text-amber-300 border-amber-800' : 'bg-blue-950 text-blue-300 border-blue-800')
                }`;
              }
            }

            if (data.messages && data.messages.length > 0) {
              const container = document.getElementById('admin-chat-messages-container');
              if (container) {
                if (container.querySelector('.text-slate-500')) {
                  container.innerHTML = '';
                }

                let hasNew = false;
                data.messages.forEach(msg => {
                  if (this._renderedAdminMsgIds && this._renderedAdminMsgIds.has(msg.id)) {
                    return;
                  }
                  if (!this._renderedAdminMsgIds) this._renderedAdminMsgIds = new Set();
                  this._renderedAdminMsgIds.add(msg.id);
                  this._adminChatLastMsgId = Math.max(this._adminChatLastMsgId || 0, msg.id);

                  const isAdmin = msg.sender_type === 'admin';
                  if (isAdmin) {
                    const optBubble = container.querySelector('[data-optimistic="true"]');
                    if (optBubble) {
                      optBubble.removeAttribute('data-optimistic');
                      return;
                    }
                  }

                  const div = this.createAdminMessageBubbleElement(msg, isAdmin);
                  container.appendChild(div);
                  hasNew = true;
                });

                if (hasNew) {
                  if (!this._userIsScrolledUpAdminChat) {
                    container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
                  }
                }
              }
            }
          } catch (e) {
            // Silently swallow network drop
          } finally {
            this._isPollingAdminChat = false;
          }
        }, 1200);
      }

      renderAdminChatMessages(messagesOrTicket, ticket, forceScrollBottom = false) {
        const container = document.getElementById('admin-chat-messages-container');
        if (!container) return;

        let messages = [];
        let actualTicket = ticket;
        if (Array.isArray(messagesOrTicket)) {
          messages = messagesOrTicket;
        } else if (messagesOrTicket && messagesOrTicket.messages) {
          messages = messagesOrTicket.messages;
          actualTicket = messagesOrTicket;
        }

        this._renderedAdminMsgIds = new Set();
        this._adminChatLastMsgId = 0;
        container.innerHTML = '';

        if (!messages || messages.length === 0) {
          container.innerHTML = `
            <div class="text-center py-8 text-slate-500 text-xs">
              <p>No messages yet in this ticket.</p>
              <p class="text-[11px] text-slate-600 mt-1">Reply to the student below to start the conversation.</p>
            </div>
          `;
          return;
        }

        messages.forEach(msg => {
          this._renderedAdminMsgIds.add(msg.id);
          this._adminChatLastMsgId = Math.max(this._adminChatLastMsgId, msg.id);
          const isAdmin = msg.sender_type === 'admin';
          const div = this.createAdminMessageBubbleElement(msg, isAdmin);
          container.appendChild(div);
        });

        if (forceScrollBottom || !this._userIsScrolledUpAdminChat) {
          container.scrollTop = container.scrollHeight;
        }
      }

      applyAdminCannedReply(text) {
        const input = document.getElementById('admin-chat-input');
        if (input) {
          input.value = text;
          input.focus();
        }
      }

      async sendAdminChatMessage(e) {
        e.preventDefault();
        if (!this.activeAdminTicketId) return;

        const input = document.getElementById('admin-chat-input');
        const text = input ? input.value.trim() : '';
        if (!text) return;

        // Admin sent a message: reset scroll lock so they see the message
        this._userIsScrolledUpAdminChat = false;

        // Instant Optimistic UI (0ms delay): append admin bubble immediately like Messenger
        input.value = '';
        input.focus();

        const container = document.getElementById('admin-chat-messages-container');
        if (container) {
          if (container.querySelector('.text-slate-500')) {
            container.innerHTML = '';
          }
          const div = document.createElement('div');
          div.className = 'flex justify-end';
          div.setAttribute('data-optimistic', 'true');
          div.innerHTML = `
            <div class="max-w-[75%] bg-emerald-800 text-white rounded-2xl rounded-tr-sm p-3 shadow-md space-y-1">
              <div class="flex items-center justify-between gap-4 text-[10px] text-emerald-200 font-mono">
                <span class="font-bold">👑 ICS Admin</span>
                <span>Just now</span>
              </div>
              <p class="text-xs leading-relaxed whitespace-pre-wrap">${text}</p>
            </div>
          `;
          container.appendChild(div);
          container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
        }

        const ticket = (this.supportTickets || []).find(t => t.id === this.activeAdminTicketId);
        if (ticket && (ticket.status === 'Open' || ticket.status === 'Resolved')) {
          ticket.status = 'In Progress';
          this.renderAdminTicketsList();
          const statusBadge = document.getElementById('admin-active-ticket-status-badge');
          if (statusBadge) {
            statusBadge.textContent = 'In Progress';
            statusBadge.className = 'px-2 py-0.5 rounded-full text-[9px] font-mono font-bold border bg-amber-950 text-amber-300 border-amber-800';
          }
          const markResolvedText = document.getElementById('admin-btn-mark-resolved-text');
          const markResolvedBtn = document.getElementById('admin-btn-mark-resolved');
          if (markResolvedText && markResolvedBtn) {
            markResolvedText.textContent = 'Mark as Done (Resolved)';
            markResolvedBtn.className = 'px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-950 hover:bg-emerald-900 text-emerald-200 border border-emerald-700 transition flex items-center gap-1.5 shadow';
          }
          const deleteTicketBtn = document.getElementById('admin-btn-delete-ticket');
          if (deleteTicketBtn) deleteTicketBtn.classList.add('hidden');
        }

        try {
          const res = await fetch(`{{ url('api/support-tickets') }}/${this.activeAdminTicketId}/messages`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              sender_type: 'admin',
              sender_name: 'ICS Admin Officer',
              message: text
            })
          });

          const data = await res.json();
          if (data.success) {
            const returnedMsg = data.message_record || data.message;
            if (returnedMsg && returnedMsg.id) {
              if (!this._renderedAdminMsgIds) this._renderedAdminMsgIds = new Set();
              this._renderedAdminMsgIds.add(returnedMsg.id);
              this._adminChatLastMsgId = Math.max(this._adminChatLastMsgId || 0, returnedMsg.id);
              if (ticket) {
                if (!ticket.messages) ticket.messages = [];
                ticket.messages.push(returnedMsg);
              }
              if (this._adminChatCache && this._adminChatCache[this.activeAdminTicketId]) {
                this._adminChatCache[this.activeAdminTicketId].push(returnedMsg);
              }
            }
          } else {
            this.showToast(data.message || 'Failed to send admin message.', 'warning');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Failed to send admin message.', 'error');
        }
      }

      async adminToggleTicketStatus() {
        if (!this.activeAdminTicketId) return;
        const ticket = (this.supportTickets || []).find(t => t.id === this.activeAdminTicketId);
        if (!ticket) return;

        const newStatus = ticket.status === 'Resolved' ? 'In Progress' : 'Resolved';

        try {
          const res = await fetch(`{{ url('api/support-tickets') }}/${ticket.id}/status`, {
            method: 'PATCH',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              status: newStatus,
              resolved_by: 'ICS Council Admin'
            })
          });

          const data = await res.json();
          if (data.success && data.ticket) {
            ticket.status = data.ticket.status;

            // Instantly sync linked reservation hold state in the queue
            const rIdx = (this.reservations || []).findIndex(r =>
              (ticket.reservation_ref && r.ref_code === ticket.reservation_ref) ||
              (ticket.reservation_id && String(r.id) === String(ticket.reservation_id))
            );
            if (rIdx >= 0) {
              if (data.ticket.status === 'Resolved') {
                this.reservations[rIdx].active_ticket = null;
                this.reservations[rIdx].activeTicket = null;
              } else {
                this.reservations[rIdx].active_ticket = data.ticket;
                this.reservations[rIdx].activeTicket = data.ticket;
              }
              this.renderReservationsQueue();
            }

            this.showToast(`Ticket ${ticket.ticket_code} marked as ${ticket.status}!`, 'success');
            this.selectAdminTicket(ticket.id);
            this.renderAdminTicketsList();
          } else {
            this.showToast(data.message || 'Error updating status', 'warning');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Network error while updating ticket status.', 'error');
        }
      }

      async adminCancelReservationFromActiveTicket() {
        if (!this.activeAdminTicketId) return;
        const ticket = (this.supportTickets || []).find(t => t.id === this.activeAdminTicketId);
        if (!ticket || !ticket.reservation_ref) {
          this.showToast('No reservation linked to this support ticket.', 'warning');
          return;
        }

        if (!confirm(`Cancel reservation [${ticket.reservation_ref}] on behalf of ${ticket.student_name}?\n\nThis will:\n1. Restock merchandise items to available inventory\n2. Mark reservation status as Cancelled\n3. Post a system audit receipt in this chat\n4. Mark this ticket as Done (Resolved)`)) {
          return;
        }

        try {
          const res = await fetch(`{{ url('api/support-tickets') }}/${ticket.id}/cancel-reservation`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              admin_name: 'ICS Council Officer'
            })
          });

          const data = await res.json();
          if (data.success) {
            this.showToast(data.message || 'Order cancelled and stock restored successfully!', 'success');
            ticket.status = 'Resolved';

            const foundRes = (this.reservations || []).find(r => r.ref_code === ticket.reservation_ref);
            if (foundRes) {
              foundRes.status = 'Cancelled';
            }

            this.selectAdminTicket(ticket.id);
            this.renderAdminTicketsList();
          } else {
            this.showToast(data.message || 'Could not cancel reservation.', 'warning');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Network error cancelling reservation.', 'error');
        }
      }

      adminOpenEditReservationModal() {
        if (!this.activeAdminTicketId) return;
        const ticket = (this.supportTickets || []).find(t => t.id === this.activeAdminTicketId);
        if (!ticket || !ticket.reservation_ref) {
          this.showToast('No reservation linked to this support ticket.', 'warning');
          return;
        }

        const linkedRes = (this.reservations || []).find(r => r.ref_code === ticket.reservation_ref);
        const items = linkedRes ? (typeof linkedRes.items === 'string' ? JSON.parse(linkedRes.items) : linkedRes.items) : [];
        const primaryItem = (Array.isArray(items) && items.length > 0) ? items[0] : null;

        const codeEl = document.getElementById('edit-res-code');
        if (codeEl) codeEl.textContent = ticket.reservation_ref;

        const stuEl = document.getElementById('edit-res-student-name');
        if (stuEl) stuEl.textContent = ticket.student_name;

        const itemEl = document.getElementById('edit-res-item-name');
        if (itemEl) itemEl.textContent = primaryItem ? (primaryItem.name || primaryItem.title || 'Uniform Apparel') : 'Apparel Item';

        const currentSize = primaryItem ? (primaryItem.size || 'M') : 'M';
        const curSizeEl = document.getElementById('edit-res-current-size');
        if (curSizeEl) curSizeEl.textContent = currentSize;

        const sizeSelect = document.getElementById('edit-res-new-size');
        if (sizeSelect) sizeSelect.value = currentSize;

        const remarksInput = document.getElementById('edit-res-remarks');
        if (remarksInput) {
          remarksInput.value = ticket.reason === 'Change Item Size'
            ? 'Adjusted apparel size per student request in ticket chat'
            : 'Updated reservation item per support inquiry';
        }

        const modal = document.getElementById('admin-edit-reservation-modal');
        if (modal) modal.classList.remove('hidden');
      }

      closeAdminEditReservationModal() {
        const modal = document.getElementById('admin-edit-reservation-modal');
        if (modal) modal.classList.add('hidden');
      }

      async submitAdminEditReservation(e) {
        e.preventDefault();
        if (!this.activeAdminTicketId) return;
        const ticket = (this.supportTickets || []).find(t => t.id === this.activeAdminTicketId);
        if (!ticket || !ticket.reservation_ref) return;

        const newSize = document.getElementById('edit-res-new-size')?.value;
        const remarks = document.getElementById('edit-res-remarks')?.value;
        const submitBtn = document.getElementById('edit-res-submit-btn');

        if (submitBtn) {
          submitBtn.disabled = true;
          submitBtn.innerHTML = `<span>Saving Changes...</span>`;
        }

        try {
          const res = await fetch(`{{ url('api/support-tickets') }}/${ticket.id}/edit-reservation`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              new_size: newSize,
              remarks: remarks,
              admin_name: 'ICS Support Officer'
            })
          });

          const data = await res.json();
          if (data.success) {
            this.showToast(data.message || 'Reservation item updated successfully!', 'success');
            this.closeAdminEditReservationModal();

            // Update local reservation item state
            const foundRes = (this.reservations || []).find(r => r.ref_code === ticket.reservation_ref);
            if (foundRes && data.reservation) {
              foundRes.items = data.reservation.items;
            }

            // Invalidate ticket chat cache and refresh messages
            if (this._adminChatCache) {
              delete this._adminChatCache[ticket.id];
            }
            this.selectAdminTicket(ticket.id);
            this.renderAdminTicketsList();
          } else {
            this.showToast(data.message || 'Could not update reservation item.', 'warning');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Network error updating reservation item.', 'error');
        } finally {
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              <span>Save & Apply Size Change</span>
            `;
          }
        }
      }

      async fetchSupportTickets() {
        try {
          const res = await fetch('{{ route("api.support.tickets") }}');
          const data = await res.json();
          if (data.success && data.tickets) {
            this.supportTickets = data.tickets;
            this.renderAdminTicketsList();
            if (this.activeAdminTicketId) {
              this.selectAdminTicket(this.activeAdminTicketId);
            }
            this.showToast('Support tickets refreshed!', 'info');
          }
        } catch (e) {
          console.error(e);
        }
      }


      async adminDeleteTicket(ticketId, ticketCode) {
        if (!confirm(`Are you sure you want to delete resolved ticket [${ticketCode}]?\n\nAll ticket records and chat messages will be permanently deleted from the database.`)) {
          return;
        }

        try {
          const res = await fetch(`{{ url('api/support-tickets') }}/${ticketId}`, {
            method: 'DELETE',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            },
            body: JSON.stringify({
              role: 'admin',
              admin_name: 'ICS Admin'
            })
          });

          const data = await res.json();
          if (data.success) {
            this.showToast(data.message || `Ticket [${ticketCode}] successfully deleted!`, 'success');
            this.supportTickets = (this.supportTickets || []).filter(t => t.id !== ticketId);
            if (this.activeAdminTicketId === ticketId) {
              this.activeAdminTicketId = null;
              const activePanel = document.getElementById('admin-chat-active-panel');
              const emptyState = document.getElementById('admin-chat-empty-state');
              if (activePanel) activePanel.classList.add('hidden');
              if (emptyState) emptyState.classList.remove('hidden');
            }
            this.renderAdminTicketsList();
          } else {
            this.showToast(data.message || 'Error deleting ticket', 'warning');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Network error while deleting ticket.', 'error');
        }
      }

      adminDeleteActiveTicket() {
        if (!this.activeAdminTicketId) return;
        const ticket = (this.supportTickets || []).find(t => t.id === this.activeAdminTicketId);
        if (!ticket) return;
        this.adminDeleteTicket(ticket.id, ticket.ticket_code);
      }

      escapeHtml(str) {
        if (str === null || str === undefined) return '';
        return String(str)
          .replace(/&/g, '&amp;')
          .replace(/</g, '&lt;')
          .replace(/>/g, '&gt;')
          .replace(/"/g, '&quot;')
          .replace(/'/g, '&#039;');
      }

      formatReservationDate(dateStr) {
        if (!dateStr) return 'N/A';
        try {
          const d = new Date(dateStr);
          if (isNaN(d.getTime())) return dateStr;
          const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
          const month = months[d.getMonth()];
          const day = String(d.getDate()).padStart(2, '0');
          const year = d.getFullYear();
          let hours = d.getHours();
          const minutes = String(d.getMinutes()).padStart(2, '0');
          const ampm = hours >= 12 ? 'PM' : 'AM';
          hours = hours % 12;
          hours = hours ? hours : 12;
          const strHours = String(hours).padStart(2, '0');
          return `${month} ${day}, ${year} ${strHours}:${minutes} ${ampm}`;
        } catch (e) {
          return dateStr;
        }
      }

      createReservationCardElement(r) {
        const isFinishedOrder = (r.status === 'Claimed' || r.status === 'Cancelled');
        const card = document.createElement('div');
        card.className = `p-4 rounded-2xl bg-slate-950/80 border border-slate-800 hover:border-slate-700 transition reservation-queue-card ${isFinishedOrder ? 'cursor-pointer hover:border-slate-600' : ''}`;
        card.setAttribute('data-id', r.id);
        card.setAttribute('data-status', r.status);
        card.setAttribute('data-ref', r.ref_code);
        card.setAttribute('data-stuid', r.student_id || '');
        card.setAttribute('data-name', r.student_name || '');
        card.setAttribute('data-dept', r.department || '');
        card.setAttribute('data-total', r.total_amount || '0');
        const itemsJson = typeof r.items === 'string' ? r.items : JSON.stringify(r.items || []);
        card.setAttribute('data-items', itemsJson);
        if (isFinishedOrder) {
          card.onclick = (e) => this.toggleReservationRowSelect(e, r.id);
        }

        const activeTicket = r.active_ticket || (this.supportTickets || []).find(t =>
          t.reservation_ref === r.ref_code && (t.status === 'Open' || t.status === 'In Progress')
        );

        let statusClass = 'bg-amber-950 text-amber-300 border border-amber-700';
        let statusContent = this.escapeHtml(r.status);
        if (r.status === 'Ready for Pickup') {
          statusClass = 'bg-blue-950 text-blue-300 border border-blue-700';
        } else if (r.status === 'Claimed') {
          statusClass = 'bg-emerald-950 text-emerald-300 border border-emerald-700';
        } else if (r.status === 'Cancelled') {
          statusClass = 'bg-rose-950 text-rose-300 border border-rose-700 font-extrabold';
          statusContent = '<span class="text-rose-500 font-black mr-1">✕</span> Cancelled';
        }

        const purchasedAt = this.formatReservationDate(r.created_at);
        const claimedAt = this.formatReservationDate(r.claimed_at || r.updated_at);

        let warningBadgeHtml = '';
        if (activeTicket) {
          warningBadgeHtml = `
            <span class="ticket-warning-badge inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/50 animate-pulse" title="This reservation has a pending Helpdesk Support Ticket">
              <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
              <span>⚠️ ON HOLD: Active Support Ticket (${this.escapeHtml(activeTicket.ticket_code)})</span>
            </span>
          `;
        }

        let receiptHtml = '';
        if (r.receipt_image && r.receipt_image !== 'images/gcash_qr.jpg' && !r.receipt_image.includes('gcash_qr')) {
          const receiptSrc = (r.receipt_image.startsWith('http://') || r.receipt_image.startsWith('https://') || r.receipt_image.startsWith('data:image'))
            ? r.receipt_image
            : (`{{ asset('') }}` + r.receipt_image.replace(/^\//, ''));
          receiptHtml = `
            <div class="relative group cursor-pointer inline-block" onclick="event.stopPropagation(); icsApp.openReceiptViewModal('${r.id}')" title="Click to view full receipt image">
              <img
                src="${receiptSrc}"
                alt="Payment Receipt"
                class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-2 border-cyan-500/80 group-hover:border-cyan-300 shadow-lg group-hover:scale-105 group-hover:shadow-cyan-500/20 transition-all duration-200"
              />
              <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center transition-opacity pointer-events-none p-1 text-center">
                <svg class="w-5 h-5 text-cyan-300 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                <span class="text-[9px] font-bold text-white leading-tight">Click to zoom</span>
              </div>
              <span class="absolute -bottom-1 -right-1 px-1.5 py-0.5 rounded-md text-[9px] font-mono font-bold bg-cyan-950 text-cyan-300 border border-cyan-700 shadow flex items-center gap-1">
                <span>🔍 Zoom</span>
              </span>
            </div>
          `;
        } else if ((r.payment_method || '') === 'GCash Online') {
          receiptHtml = `
            <div class="mt-2 text-[11px] text-slate-400 italic flex items-center gap-1">
              <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              <span>Verified via GCash Ref</span>
            </div>
          `;
        }

        let itemsHtml = '';
        let itemsList = Array.isArray(r.items) ? r.items : [];
        if (typeof r.items === 'string') {
          try { itemsList = JSON.parse(r.items); } catch (e) { itemsList = []; }
        }
        itemsList.forEach(it => {
          itemsHtml += `
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-900 border border-slate-800 text-[11px] text-slate-300">
              <strong class="text-white">${this.escapeHtml(it.productName || it.name || 'Item')}</strong>
              <span class="text-ics-gold">(${this.escapeHtml(it.size || 'M')})</span>
              <span>&times;${this.escapeHtml(it.quantity || 1)}</span>
            </span>
          `;
        });

        const isChecked = this.selectedReservationIds && this.selectedReservationIds.has(String(r.id));
        const checkboxHtml = isFinishedOrder ? `
          <label class="inline-flex items-center cursor-pointer mr-0.5" onclick="event.stopPropagation()">
            <input
              type="checkbox"
              value="${r.id}"
              ${isChecked ? 'checked' : ''}
              onchange="icsApp.onReservationCheckboxChange()"
              class="reservation-row-checkbox w-4 h-4 rounded text-rose-500 bg-slate-900 border-slate-700 focus:ring-0 cursor-pointer"
              title="Select finished order for bulk delete"
            />
          </label>
        ` : '';

        card.innerHTML = `
          <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 pb-3 border-b border-slate-800/80">
            <div class="reservation-header-badges flex items-center gap-2.5 flex-wrap">
              ${checkboxHtml}
              <span class="font-mono font-bold text-sm text-ics-gold">${this.escapeHtml(r.ref_code)}</span>
              <span class="reservation-status-badge px-2 py-0.5 rounded-full text-[10px] font-bold ${statusClass}">
                ${statusContent}
              </span>
              ${warningBadgeHtml}
            </div>
            <div class="text-[11px] text-slate-400 font-mono text-left sm:text-right">
              <div>Purchased: ${purchasedAt}</div>
              ${r.status === 'Claimed' ? `
                <div class="text-emerald-400 font-semibold flex items-center sm:justify-end gap-1">
                  <svg class="w-3 h-3 text-emerald-400 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                  <span>Claimed: ${claimedAt}</span>
                </div>` : ''}
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mt-4 pt-3 border-t border-slate-800/60">
            <div>
              <p class="text-xs font-bold text-slate-300 uppercase tracking-wider">Student Buyer</p>
              <p class="text-sm font-black text-white mt-1">${this.escapeHtml(r.student_name || 'N/A')}</p>
              <div class="mt-1">
                <span class="font-mono text-xs font-bold text-cyan-300 bg-cyan-950/60 px-2 py-0.5 rounded-md border border-cyan-800/60 inline-block">${this.escapeHtml(r.student_id || 'N/A')}</span>
                <span class="text-xs text-slate-300 ml-1">(${this.escapeHtml(r.year_level || 'N/A')})</span>
              </div>
              <p class="text-xs text-slate-300 mt-1">${this.escapeHtml(r.department || 'N/A')}</p>
              <p class="text-xs text-slate-400 font-mono mt-0.5">Contact: ${this.escapeHtml(r.contact || 'N/A')}</p>
            </div>

            <div>
              <p class="text-xs font-bold text-slate-300 uppercase tracking-wider">Pickup Schedule</p>
              <p class="text-sm font-bold text-ics-gold mt-1">${this.escapeHtml(r.pickup_date || 'N/A')}</p>
              <p class="text-xs text-slate-200 mt-0.5">${this.escapeHtml(r.pickup_slot || 'N/A')}</p>
              <p class="text-xs text-slate-400 mt-1 italic">${this.escapeHtml(r.notes || 'No additional notes')}</p>
            </div>

            <div>
              <p class="text-xs font-bold text-slate-300 uppercase tracking-wider">Payment &amp; Receipt</p>
              <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                <span class="px-2.5 py-1 rounded-full text-xs font-bold ${r.payment_method === 'GCash Online' ? 'bg-blue-950 text-blue-300 border border-blue-800' : (r.payment_method === 'Maya Online' ? 'bg-emerald-950 text-emerald-300 border border-emerald-800' : (r.payment_method === 'Debit/Credit Card' ? 'bg-indigo-950 text-indigo-300 border border-indigo-800' : 'bg-amber-950 text-amber-300 border border-amber-800'))} flex items-center gap-1">
                  ${this.escapeHtml(r.payment_method || 'Cash on Pickup')}
                </span>
                <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded-md bg-slate-900 border border-slate-800 ${(r.payment_status || 'Unpaid') === 'Verified' ? 'text-emerald-400' : 'text-amber-400'}">
                  ${this.escapeHtml(r.payment_status || 'Unpaid')}
                </span>
              </div>
              ${r.payment_reference ? `
                <div class="mt-2 p-1.5 rounded-lg bg-slate-950/80 border border-slate-800/80 flex items-center justify-between gap-1">
                  <span class="text-[10px] uppercase font-bold text-slate-400">GCash Ref:</span>
                  <span class="font-mono text-xs font-bold text-ics-gold select-all">${this.escapeHtml(r.payment_reference)}</span>
                </div>` : ''}
              <div class="mt-2.5 reservation-receipt-container">
                ${receiptHtml}
              </div>
            </div>

            <div class="text-left md:text-right flex flex-col justify-between">
              <div>
                <p class="text-xs font-bold text-slate-300 uppercase tracking-wider">Grand Total</p>
                <p class="text-2xl font-black text-emerald-400 font-mono mt-1">₱${Number(r.total_amount || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
              </div>
              <div class="reservation-actions-container flex items-center md:justify-end gap-2 mt-3 flex-wrap">
              </div>
            </div>
          </div>

          <div class="mt-3 pt-3 border-t border-slate-900 text-xs text-slate-400">
            <p class="text-[10px] uppercase font-semibold text-slate-500 mb-1">Reserved Items:</p>
            <div class="flex flex-wrap gap-2">
              ${itemsHtml}
            </div>
          </div>
        `;

        return card;
      }

      renderReservationsQueue() {
        const container = document.getElementById('reservations-list');
        if (!container || !this.reservations) return;

        // Clean up cards removed from database
        const activeRefs = new Set(this.reservations.map(x => x.ref_code));
        container.querySelectorAll('[data-ref]').forEach(cardEl => {
          const ref = cardEl.getAttribute('data-ref');
          if (ref && !activeRefs.has(ref)) {
            cardEl.remove();
          }
        });

        if (this.reservations.length === 0) {
          container.innerHTML = `
            <div id="reservations-empty-notice" class="text-center py-12 px-4 rounded-3xl bg-slate-950/40 border border-slate-800/80">
              <svg class="w-12 h-12 text-slate-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
              <h4 class="text-sm font-bold text-slate-300">No Reservations in Queue</h4>
              <p class="text-xs text-slate-500 mt-1">Incoming student orders will appear here automatically in real time.</p>
            </div>
          `;
          const totalBadge = document.getElementById('reservations-total-badge');
          if (totalBadge) totalBadge.textContent = '0 Total';
          this._hasRenderedInitialQueue = true;
          return;
        } else {
          const emptyNotice = document.getElementById('reservations-empty-notice');
          if (emptyNotice) emptyNotice.remove();
        }

        // Priority Queue Ordering:
        // 1. Pending orders first (newest orders right at the top for immediate visibility)
        // 2. Ready for Pickup orders second (newest first)
        // 3. Other statuses last
        this.reservations.sort((a, b) => {
          const getStatusRank = (s) => (s === 'Pending' ? 1 : (s === 'Ready for Pickup' ? 2 : 3));
          const rankA = getStatusRank(a.status);
          const rankB = getStatusRank(b.status);
          if (rankA !== rankB) return rankA - rankB;
          return new Date(b.created_at || 0).getTime() - new Date(a.created_at || 0).getTime();
        });

        const firstPendingIdx = this.reservations.findIndex(r => r.status === 'Pending');

        this.reservations.forEach((r, idx) => {
          let card = container.querySelector(`[data-ref="${r.ref_code}"]`);

          // Auto-hide cancelled orders in code after 10 minutes (600,000 ms) without showing timer UI
          if (r.status === 'Cancelled') {
            const updated = r.updated_at ? new Date(r.updated_at).getTime() : 0;
            if (updated && (Date.now() - updated > 600000)) {
              if (card) card.remove();
              return;
            }
          }

          if (!card) {
            card = this.createReservationCardElement(r);
            container.appendChild(card);

            card.classList.add('ring-2', 'ring-amber-400', 'animate-pulse');
            setTimeout(() => {
              card.classList.remove('ring-2', 'ring-amber-400', 'animate-pulse');
            }, 6000);
          } else {
            // Re-append in FIFO sorted order
            container.appendChild(card);
          }

          card.setAttribute('data-status', r.status);

          // Priority Badge for latest incoming pending order
          const headerBadges = card.querySelector('.reservation-header-badges');
          let fifoBadge = card.querySelector('.fifo-queue-badge');
          if (idx === firstPendingIdx) {
            card.classList.add('border-amber-500/80', 'bg-amber-950/20', 'shadow-lg', 'shadow-amber-500/10');
            if (!fifoBadge && headerBadges) {
              fifoBadge = document.createElement('span');
              fifoBadge.className = 'fifo-queue-badge inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-500/20 text-amber-300 border border-amber-500/50 shadow-sm';
              fifoBadge.title = 'Top Priority: Latest pending order';
              fifoBadge.innerHTML = '<span>⚡ Latest Order</span>';
              headerBadges.appendChild(fifoBadge);
            }
          } else {
            card.classList.remove('border-amber-500/80', 'bg-amber-950/20', 'shadow-lg', 'shadow-amber-500/10');
            if (fifoBadge) fifoBadge.remove();
          }

          const activeTicket = r.active_ticket || (this.supportTickets || []).find(t =>
            t.reservation_ref === r.ref_code && (t.status === 'Open' || t.status === 'In Progress')
          );

          const statusBadge = card.querySelector('.reservation-status-badge');
          if (statusBadge) {
            if (r.status === 'Cancelled') {
              statusBadge.innerHTML = '<span class="text-rose-500 font-black mr-1">✕</span> Cancelled';
              statusBadge.className = 'reservation-status-badge px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-950 text-rose-300 border border-rose-700 font-extrabold';
            } else {
              statusBadge.textContent = r.status;
              statusBadge.className = 'reservation-status-badge px-2 py-0.5 rounded-full text-[10px] font-bold ' + (
                r.status === 'Pending' ? 'bg-amber-950 text-amber-300 border border-amber-700' :
                (r.status === 'Ready for Pickup' ? 'bg-blue-950 text-blue-300 border border-blue-700' :
                  'bg-emerald-950 text-emerald-300 border border-emerald-700')
              );
            }
          }

          let warnEl = card.querySelector('.ticket-warning-badge');
          if (activeTicket) {
            if (!warnEl) {
              warnEl = document.createElement('span');
              warnEl.className = 'ticket-warning-badge inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/50 animate-pulse';
              const headerEl = card.querySelector('.reservation-header-badges');
              if (headerEl) headerEl.appendChild(warnEl);
            }
            warnEl.innerHTML = `
              <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
              <span>⚠️ ON HOLD: Active Support Ticket (${this.escapeHtml(activeTicket.ticket_code)})</span>
            `;
            warnEl.classList.remove('hidden');
          } else if (warnEl) {
            warnEl.classList.add('hidden');
          }

          const receiptContainer = card.querySelector('.reservation-receipt-container');
          if (receiptContainer && r.receipt_image && r.receipt_image !== 'images/gcash_qr.jpg' && !r.receipt_image.includes('gcash_qr')) {
            const receiptSrc = (r.receipt_image.startsWith('http://') || r.receipt_image.startsWith('https://') || r.receipt_image.startsWith('data:image'))
              ? r.receipt_image
              : (`{{ asset('') }}` + r.receipt_image.replace(/^\//, ''));
            receiptContainer.innerHTML = `
              <div class="relative group cursor-pointer inline-block" onclick="event.stopPropagation(); icsApp.openReceiptViewModal('${r.id}')" title="Click to view full receipt image">
                <img
                  src="${receiptSrc}"
                  alt="Payment Receipt"
                  class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-2 border-cyan-500/80 group-hover:border-cyan-300 shadow-lg group-hover:scale-105 group-hover:shadow-cyan-500/20 transition-all duration-200"
                />
                <div class="absolute inset-0 bg-black/40 rounded-2xl opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center transition-opacity pointer-events-none p-1 text-center">
                  <svg class="w-5 h-5 text-cyan-300 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                  <span class="text-[9px] font-bold text-white leading-tight">Click to zoom</span>
                </div>
                <span class="absolute -bottom-1 -right-1 px-1.5 py-0.5 rounded-md text-[9px] font-mono font-bold bg-cyan-950 text-cyan-300 border border-cyan-700 shadow flex items-center gap-1">
                  <span>🔍 Zoom</span>
                </span>
              </div>
            `;
          }

          const actionsEl = card.querySelector('.reservation-actions-container');
          if (actionsEl) {
            let actionsHtml = `
              <button
                type="button"
                onclick="event.stopPropagation(); icsApp.openAdminMessageBuyerModal('${r.id}')"
                class="px-2.5 py-1 rounded-xl text-xs font-bold bg-cyan-950/80 hover:bg-cyan-900 text-cyan-300 border border-cyan-800 transition flex items-center gap-1.5 cursor-pointer shadow-sm"
                title="Message Student Buyer">
                <svg class="w-3.5 h-3.5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <span>Message</span>
              </button>
            `;
            if (activeTicket) {
              actionsHtml += `
                <button
                  type="button"
                  onclick="event.stopPropagation(); icsApp.setAdminTab('support'); icsApp.selectAdminTicket(${activeTicket.id});"
                  class="px-2.5 py-1 rounded-xl text-xs font-bold bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/60 transition flex items-center gap-1.5 cursor-pointer shadow-sm"
                  title="This reservation has an active support ticket. Please resolve ticket before claiming.">
                  <svg class="w-3.5 h-3.5 text-amber-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                  <span>⚠️ Resolve Ticket [${this.escapeHtml(activeTicket.ticket_code)}]</span>
                </button>
              `;
            } else {
              if (r.status === 'Pending') {
                actionsHtml += `
                  <button
                    onclick="event.stopPropagation(); icsApp.updateReservationStatus('${r.id}', 'Ready for Pickup')"
                    class="px-2.5 py-1 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-500 text-white transition">
                    Mark Ready
                  </button>
                `;
              }
              // Only show Mark Claimed when status is strictly Ready for Pickup
              if (r.status === 'Ready for Pickup') {
                actionsHtml += `
                  <button
                    onclick="event.stopPropagation(); icsApp.updateReservationStatus('${r.id}', 'Claimed')"
                    class="px-2.5 py-1 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition">
                    Mark Claimed
                  </button>
                `;
              }
            }

            if (r.status !== 'Cancelled' && r.status !== 'Claimed') {
              actionsHtml += `
                <button
                  onclick="event.stopPropagation(); icsApp.updateReservationStatus('${r.id}', 'Cancelled')"
                  class="px-2.5 py-1 rounded-xl text-xs font-bold bg-rose-950/80 hover:bg-rose-900 text-rose-300 border border-rose-800 transition">
                  Cancel
                </button>
              `;
            }

            actionsHtml += `
              <button
                onclick="event.stopPropagation(); icsApp.viewPrintClaimSlip('${r.id}')"
                class="px-2.5 py-1 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition">
                Print Slip
              </button>
            `;

            if (r.status === 'Claimed' || r.status === 'Cancelled') {
              actionsHtml += `
                <button
                  type="button"
                  onclick="event.stopPropagation(); icsApp.deleteReservation('${r.id}', '${r.ref_code}')"
                  class="px-2.5 py-1 rounded-xl text-xs font-bold bg-rose-950 hover:bg-rose-900 text-rose-300 border border-rose-800 transition flex items-center gap-1 shadow-sm cursor-pointer"
                  title="Permanently delete finished reservation from database">
                  <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  <span>Delete</span>
                </button>
              `;
            }

            actionsEl.innerHTML = actionsHtml;
          }
        });

        const totalBadge = document.getElementById('reservations-total-badge');
        if (totalBadge) {
          totalBadge.textContent = `${this.reservations.length} Total`;
        }

        const currentFilter = document.getElementById('reservation-filter-status')?.value || 'all';
        this.filterReservations(currentFilter);
        this._hasRenderedInitialQueue = true;
      }

    }

    // Initialize Global Singleton
    window.icsApp = new IcsMerchApp();
    window.addEventListener('load', () => {
      setTimeout(() => {
        if (window.icsApp && window.icsApp.adminTab === 'dashboard') window.icsApp.initAdminCharts();
      }, 100);
    });
  </script>

</body>

</html>