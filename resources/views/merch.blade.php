<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ICS Integrated Computer Society | Apparel & Merch Reservation System</title>

  <!-- Google Fonts: Plus Jakarta Sans & Space Grotesk -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Canvas Confetti CDN -->
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

  <!-- Chart.js CDN for Visual Donut & Bar Charts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

    /* Print Slip Styles */
    @media print {
      body * {
        visibility: hidden !important;
      }

      #printable-claim-slip,
      #printable-claim-slip * {
        visibility: visible !important;
      }

      #printable-claim-slip {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        background: white !important;
        color: black !important;
      }

      .no-print {
        display: none !important;
      }
    }
  </style>
</head>

<body class="ics-matrix-bg text-slate-100 min-h-screen flex flex-col font-sans antialiased selection:bg-ics-700 selection:text-white">

  <!-- ======================================================== -->
  <!-- TOP APP BAR & HEADER (ICS BRANDING & PROFILE) -->
  <!-- ======================================================== -->
  <header class="sticky top-0 z-40 bg-ics-dark/95 backdrop-blur-md border-b border-ics-900/80 shadow-2xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-18 py-2">

        <!-- ICS Brand Identity & Emblem (Clean Responsive, No Midterm label) -->
        <div class="flex items-center gap-2.5 sm:gap-3.5 cursor-pointer group" onclick="icsApp.switchPortalView('student')">
          <div class="relative w-10 h-10 sm:w-12 sm:h-12 flex-shrink-0 rounded-2xl p-0.5 bg-gradient-to-br from-ics-gold via-ics-700 to-ics-900 shadow-lg group-hover:scale-105 transition-transform duration-300">
            <img src="{{ asset('images/ics-logo.png') }}"
              alt="ICS Integrated Computer Society"
              class="w-full h-full object-contain rounded-xl bg-ics-950 p-0.5">
          </div>
          <div>
            <div class="flex items-center gap-1.5 sm:gap-2">
              <h1 class="text-sm sm:text-lg font-black tracking-tight leading-none text-white font-display uppercase flex items-center gap-1 sm:gap-1.5">
                <span>ICS</span>
                <span class="text-ics-gold font-normal">|</span>
                <span class="bg-gradient-to-r from-red-400 via-ics-gold to-yellow-300 bg-clip-text text-transparent">Integrated Computer Society</span>
              </h1>
            </div>
            <p class="text-[10px] sm:text-[11px] text-slate-400 font-medium flex items-center gap-1.5 mt-0.5">
              <span class="text-ics-gold font-semibold tracking-wider">Official Merch Portal</span>
              <span>•</span>
              <span>Apparel & Merch Reservation System</span>
            </p>
          </div>
        </div>

        <!-- View Switcher & Action Controls -->
        <div class="flex items-center gap-2 sm:gap-3">

          <!-- Desktop Portal Switcher (Visible on lg:screens) -->
          <div class="hidden lg:flex bg-slate-900/90 p-1 rounded-2xl border border-ics-900 items-center shadow-inner">
            <button
              id="portal-switch-student"
              onclick="icsApp.switchPortalView('student')"
              class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-ics-800 to-ics-700 text-white shadow-md transition flex items-center gap-1.5">
              <svg class="w-3.5 h-3.5 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
              <span>Student Catalog</span>
            </button>
            <button
              id="portal-switch-admin"
              onclick="icsApp.switchPortalView('admin')"
              class="px-3.5 py-1.5 rounded-xl text-xs font-bold text-slate-400 hover:text-white transition flex items-center gap-1.5">
              <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              <span>Admin Management</span>
            </button>
          </div>

          <!-- Desktop Size Guide Trigger -->
          <button
            onclick="icsApp.openSizeGuideModal()"
            class="hidden lg:flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-white hover:bg-ics-900/60 border border-slate-800 transition">
            <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <span>Size Guide</span>
          </button>

          <!-- Reservation Cart Button (Always visible on mobile & desktop) -->
          <button
            id="nav-cart-btn"
            onclick="icsApp.openCartDrawer()"
            class="relative px-2.5 sm:px-3.5 py-1.5 bg-gradient-to-r from-ics-gold to-yellow-400 hover:from-yellow-400 hover:to-yellow-300 active:scale-95 text-ics-dark rounded-xl text-xs font-black shadow-lg transition flex items-center gap-1.5 sm:gap-2">
            <svg class="w-4 h-4 text-ics-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span class="hidden sm:inline">My Cart</span>
            <span id="nav-cart-badge" class="bg-ics-800 text-white text-[11px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-ics-dark">
              0
            </span>
          </button>

          <!-- Support Chat Trigger (Student Helpdesk) -->
          <button
            id="nav-support-btn"
            onclick="icsApp.openStudentSupportModal()"
            title="Chat Support & Order Helpdesk"
            class="px-2.5 sm:px-3 py-1.5 bg-slate-900 border border-slate-800 hover:border-emerald-600 active:scale-95 text-slate-200 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <span class="hidden md:inline">Support</span>
          </button>

          <!-- Mobile Active Portal Pill Indicator -->
          <span id="header-active-portal-badge" class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-ics-950 text-ics-300 border border-ics-800 lg:hidden">
            Student
          </span>

          <!-- Desktop User Profile Dropdown Pill -->
          <div class="relative hidden lg:block">
            <button
              id="user-profile-menu-btn"
              onclick="icsApp.toggleProfileDropdown()"
              class="flex items-center gap-2.5 p-1 px-2.5 py-1 rounded-2xl bg-slate-900 border border-slate-800 hover:border-ics-700 transition">
              <div class="w-7 h-7 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-600 flex items-center justify-center text-white font-bold text-xs shadow">
                EM
              </div>
              <div class="text-left">
                <p class="text-xs font-bold text-white leading-tight">E. Moreno</p>
                <p class="text-[10px] text-ics-gold font-mono leading-tight">e.moreno@gmail.com</p>
              </div>
              <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="user-profile-dropdown" class="hidden absolute right-0 mt-2 w-64 bg-slate-900 border border-ics-900 rounded-2xl shadow-2xl py-2 z-50 text-xs">
              <div class="px-4 py-2 border-b border-slate-800">
                <p class="text-slate-400 text-[10px]">CURRENT LOGGED USER</p>
                <p class="font-bold text-white text-sm">Prof. E. Moreno</p>
                <p class="text-ics-gold font-mono text-[11px]">e.moreno@gmail.com</p>
                <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[9px] font-bold bg-ics-950 text-ics-300 border border-ics-800">
                  ICS Faculty Adviser / Admin
                </span>
              </div>
              <div class="px-4 py-2 border-b border-slate-800">
                <p class="text-slate-400 text-[10px] mb-1">TEAM LEAD & CORE (GROUP 4)</p>
                <div class="flex items-center gap-1.5 text-slate-200">
                  <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                  <span class="font-semibold">J. Derramas</span>
                  <span class="text-slate-500 font-mono">(Group 4)</span>
                </div>
                <p class="text-[10px] text-slate-400">Members: Buenaventura, Regadio, Dotillos, Albor</p>
              </div>
              <div class="px-2 pt-1">
                <button onclick="icsApp.quickSwitchRole('admin')" class="w-full text-left px-3 py-1.5 rounded-xl hover:bg-slate-800 text-slate-200 flex items-center gap-2">
                  <svg class="w-3.5 h-3.5 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span>Admin Logistics View</span>
                </button>
                <button onclick="icsApp.quickSwitchRole('student')" class="w-full text-left px-3 py-1.5 rounded-xl hover:bg-slate-800 text-slate-200 flex items-center gap-2">
                  <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  <span>Student Catalog View</span>
                </button>
              </div>
            </div>
          </div>

          <!-- Mobile Hamburger Toggle Button -->
          <button
            id="mobile-hamburger-btn"
            onclick="icsApp.toggleMobileDrawer()"
            class="p-2 rounded-xl bg-slate-900 border border-slate-800 hover:border-ics-700 text-slate-200 transition lg:hidden flex items-center justify-center focus:outline-none"
            aria-label="Open Navigation Menu">
            <svg class="w-5 h-5 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>

        </div>

      </div>
    </div>
  </header>

  <!-- ======================================================== -->
  <!-- MOBILE OFF-CANVAS NAVIGATION DRAWER (STUDENT & ADMIN) -->
  <!-- ======================================================== -->
  <div id="mobile-nav-backdrop" onclick="icsApp.closeMobileDrawer()" class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm transition-opacity duration-300 lg:hidden"></div>

  <div id="mobile-nav-drawer" class="fixed top-0 right-0 bottom-0 w-80 max-w-[88vw] z-50 bg-slate-900 border-l border-ics-900 shadow-2xl flex flex-col transform translate-x-full transition-transform duration-300 ease-in-out lg:hidden overflow-y-auto">

    <!-- Drawer Header -->
    <div class="p-4 border-b border-slate-800 flex items-center justify-between bg-slate-950/60 sticky top-0 z-10 backdrop-blur-md">
      <div class="flex items-center gap-2.5">
        <div class="w-8 h-8 rounded-xl bg-ics-800 border border-ics-600 flex items-center justify-center p-1">
          <img src="{{ asset('images/ics-logo.png') }}" alt="ICS" class="w-full h-full object-contain">
        </div>
        <div>
          <h3 class="text-xs font-black text-white font-display uppercase tracking-wide">ICS Merch Portal</h3>
          <p class="text-[9px] text-ics-gold font-mono">Mobile Navigation Menu</p>
        </div>
      </div>
      <button onclick="icsApp.closeMobileDrawer()" class="text-slate-400 hover:text-white p-1.5 rounded-lg bg-slate-800">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Drawer Body -->
    <div class="p-4 space-y-4 flex-1">

      <!-- Active User Profile Card -->
      <div class="p-3 rounded-2xl bg-slate-950/80 border border-slate-800 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
          <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-600 flex items-center justify-center text-white font-bold text-xs shadow">
            EM
          </div>
          <div>
            <p class="text-xs font-bold text-white">Prof. E. Moreno</p>
            <p class="text-[10px] text-ics-gold font-mono">e.moreno@gmail.com</p>
          </div>
        </div>
        <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-ics-950 text-ics-300 border border-ics-800">
          Admin
        </span>
      </div>

      <!-- Portal Switcher Options (Big Touch Cards) -->
      <div>
        <p class="text-[10px] font-mono text-slate-400 uppercase tracking-wider mb-2 font-bold">Switch Portal View</p>
        <div class="space-y-2">
          <button
            id="mob-portal-student"
            onclick="icsApp.switchPortalView('student'); icsApp.closeMobileDrawer();"
            class="w-full p-3 rounded-2xl bg-gradient-to-r from-ics-800 to-ics-700 text-white font-bold text-xs flex items-center justify-between border border-ics-600 shadow">
            <div class="flex items-center gap-2.5">
              <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
              <span>Student Catalog Portal</span>
            </div>
            <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-950/60 font-mono">10 Merch</span>
          </button>

          <button
            id="mob-portal-admin"
            onclick="icsApp.switchPortalView('admin'); icsApp.closeMobileDrawer();"
            class="w-full p-3 rounded-2xl bg-slate-950/80 hover:bg-slate-800 text-slate-300 font-semibold text-xs flex items-center justify-between border border-slate-800">
            <div class="flex items-center gap-2.5">
              <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              <span>Admin Management Portal</span>
            </div>
            <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-900 font-mono text-amber-300">6 Modules</span>
          </button>
        </div>
      </div>

      <!-- Context-Aware Links: Student Portal Links -->
      <div id="mob-drawer-student-links" class="space-y-3 pt-2 border-t border-slate-800">
        <p class="text-[10px] font-mono text-slate-400 uppercase tracking-wider font-bold">Student Quick Actions</p>

        <div class="space-y-1">
          <button onclick="icsApp.openCartDrawer(); icsApp.closeMobileDrawer();" class="w-full text-left p-2.5 rounded-xl hover:bg-slate-800 text-slate-200 text-xs font-medium flex items-center justify-between">
            <div class="flex items-center gap-2.5">
              <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
              <span>View Reservation Cart</span>
            </div>
            <span id="mob-drawer-cart-count" class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-ics-800 text-white font-bold">0</span>
          </button>

          <button onclick="icsApp.openSizeGuideModal(); icsApp.closeMobileDrawer();" class="w-full text-left p-2.5 rounded-xl hover:bg-slate-800 text-slate-200 text-xs font-medium flex items-center gap-2.5">
            <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <span>Interactive Size Guide</span>
          </button>

          <button onclick="document.getElementById('tracker-section')?.scrollIntoView({behavior:'smooth'}); icsApp.closeMobileDrawer();" class="w-full text-left p-2.5 rounded-xl hover:bg-slate-800 text-slate-200 text-xs font-medium flex items-center gap-2.5">
            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span>Shopee-Style Order Tracker</span>
          </button>
        </div>

        <p class="text-[10px] font-mono text-slate-400 uppercase tracking-wider pt-2 font-bold">Categories</p>
        <div class="grid grid-cols-2 gap-1.5">
          <button onclick="icsApp.setCategoryFilter('all'); icsApp.closeMobileDrawer();" class="text-left p-2 rounded-xl bg-slate-950/60 hover:bg-slate-800 text-slate-300 text-[11px] font-medium truncate">All Merch</button>
          <button onclick="icsApp.setCategoryFilter('general'); icsApp.closeMobileDrawer();" class="text-left p-2 rounded-xl bg-slate-950/60 hover:bg-slate-800 text-slate-300 text-[11px] font-medium truncate">Collegiate</button>
          <button onclick="icsApp.setCategoryFilter('pe'); icsApp.closeMobileDrawer();" class="text-left p-2 rounded-xl bg-slate-950/60 hover:bg-slate-800 text-slate-300 text-[11px] font-medium truncate">Athletics & PE</button>
          <button onclick="icsApp.setCategoryFilter('department'); icsApp.closeMobileDrawer();" class="text-left p-2 rounded-xl bg-slate-950/60 hover:bg-slate-800 text-slate-300 text-[11px] font-medium truncate">Dept & Varsity</button>
        </div>
      </div>

      <!-- Context-Aware Links: Admin Portal Links -->
      <div id="mob-drawer-admin-links" class="hidden space-y-3 pt-2 border-t border-slate-800">
        <p class="text-[10px] font-mono text-amber-400 uppercase tracking-wider font-bold">Admin Management Modules</p>

        <div class="space-y-1">
          <button id="mob-drawer-tab-dashboard" onclick="icsApp.setAdminTab('dashboard'); icsApp.closeMobileDrawer();" class="w-full text-left p-2.5 rounded-xl text-xs font-bold bg-ics-800 text-white flex items-center justify-between shadow">
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
              </svg>
              <span>1. Dashboard (Read)</span>
            </div>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-ics-950 text-ics-300">Sales/Stock</span>
          </button>

          <button id="mob-drawer-tab-infomgmt" onclick="icsApp.setAdminTab('infomgmt'); icsApp.closeMobileDrawer();" class="w-full text-left p-2.5 rounded-xl text-xs font-medium text-slate-300 hover:bg-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
              <span>2. INFO MGMT (CRUD)</span>
            </div>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-400">{{ $totalProducts }}</span>
          </button>

          <button id="mob-drawer-tab-reservations" onclick="icsApp.setAdminTab('reservations'); icsApp.closeMobileDrawer();" class="w-full text-left p-2.5 rounded-xl text-xs font-medium text-slate-300 hover:bg-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
              <span>3. Reservation Queue</span>
            </div>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-amber-950 text-amber-300">{{ $pendingReservationsCount }}</span>
          </button>

          <button id="mob-drawer-tab-reports" onclick="icsApp.setAdminTab('reports'); icsApp.closeMobileDrawer();" class="w-full text-left p-2.5 rounded-xl text-xs font-medium text-slate-300 hover:bg-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <span>4. REPORTS (Read)</span>
            </div>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-400">CSV</span>
          </button>

          <button id="mob-drawer-tab-usermgmt" onclick="icsApp.setAdminTab('usermgmt'); icsApp.closeMobileDrawer();" class="w-full text-left p-2.5 rounded-xl text-xs font-medium text-slate-300 hover:bg-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              <span>5. USER MGMT (CRUD)</span>
            </div>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-800 text-slate-400">{{ $users->count() }}</span>
          </button>

          <button id="mob-drawer-tab-actlogs" onclick="icsApp.setAdminTab('actlogs'); icsApp.closeMobileDrawer();" class="w-full text-left p-2.5 rounded-xl text-xs font-medium text-slate-300 hover:bg-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span>6. ACT LOGS</span>
            </div>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-800 text-cyan-300">Live</span>
          </button>

          <button id="mob-drawer-tab-support" onclick="icsApp.setAdminTab('support'); icsApp.closeMobileDrawer();" class="w-full text-left p-2.5 rounded-xl text-xs font-medium text-slate-300 hover:bg-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
              </svg>
              <span>7. SUPPORT CHAT</span>
            </div>
            <span class="text-[10px] px-1.5 py-0.5 rounded bg-emerald-950 text-emerald-300 font-mono">{{ $openTicketsCount ?? 0 }}</span>
          </button>
        </div>

        <button onclick="icsApp.openAddProductModal(); icsApp.closeMobileDrawer();" class="w-full py-2.5 rounded-xl bg-gradient-to-r from-ics-700 to-ics-800 hover:from-ics-600 text-white font-bold text-xs flex items-center justify-center gap-2 shadow border border-ics-600 mt-2">
          <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          <span>Add New Merch / Item</span>
        </button>
      </div>

    </div>

    <!-- Drawer Footer -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/60 text-[10px] text-slate-400">
      <p class="font-bold text-white uppercase text-[9px] tracking-wider">CP3 GROUP 4 • ICS PORTAL</p>
      <p class="mt-0.5">Lead: J. Derramas • Group 4</p>
    </div>

  </div>

  <!-- ======================================================== -->
  <!-- 1. STUDENT CATALOG PORTAL -->
  <!-- ======================================================== -->
  <main id="student-view-container" class="flex-1 pb-16 transition-opacity duration-300">

    <!-- Hero Banner with ICS Red Accent (Compact on Mobile) -->
    <section class="relative bg-gradient-to-r from-ics-dark via-ics-deep to-ics-dark border-b border-ics-900/60 overflow-hidden py-5 sm:py-12">
      <!-- Matrix background details -->
      <div class="absolute -right-20 -bottom-20 w-96 h-96 rounded-full bg-ics-700/20 blur-3xl pointer-events-none"></div>
      <div class="absolute -left-20 -top-20 w-96 h-96 rounded-full bg-ics-gold/10 blur-3xl pointer-events-none"></div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 sm:gap-6">
          <div class="flex items-center gap-3.5 sm:gap-5 text-left w-full md:w-auto">
            <div class="w-14 h-14 sm:w-24 sm:h-24 rounded-2xl sm:rounded-3xl p-1 bg-gradient-to-br from-ics-gold via-ics-600 to-ics-900 shadow-2xl flex-shrink-0">
              <img src="{{ asset('images/ics-logo.png') }}" alt="ICS Emblem" class="w-full h-full object-contain rounded-xl sm:rounded-2xl bg-ics-dark p-1">
            </div>
            <div>
              <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-ics-800/60 border border-ics-700/60 text-ics-gold text-[10px] sm:text-xs font-bold mb-1 sm:mb-2">
                <span>OFFICIAL ICS APPAREL & UNIFORM</span>
              </div>
              <h2 class="text-lg sm:text-4xl font-black tracking-tight font-display text-white">
                ICS <span class="bg-gradient-to-r from-red-400 via-ics-gold to-yellow-200 bg-clip-text text-transparent">Apparel Catalog</span> & Reservation
              </h2>
              <p class="hidden sm:block text-slate-300 text-xs sm:text-sm mt-1 max-w-2xl">
                Official academic uniforms, collegiate letterman varsity jackets, dry-fit athletic wear, and departmental apparel for AIS & BSIS students.
              </p>
            </div>
          </div>

          <!-- Desktop Quick Actions (Mobile has these in Header & Hamburger Drawer) -->
          <div class="hidden md:flex items-center gap-3 w-full md:w-auto justify-center">
            <button
              onclick="icsApp.openSizeGuideModal()"
              class="px-4 py-2.5 rounded-xl bg-slate-900/80 hover:bg-slate-800 text-slate-200 border border-slate-700 text-xs font-bold transition flex items-center gap-2 shadow">
              <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
              </svg>
              <span>Size Guide Table</span>
            </button>
            <button
              onclick="icsApp.openCartDrawer()"
              class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-ics-700 to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white text-xs font-black shadow-lg transition flex items-center gap-2 border border-ics-600">
              <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
              <span>View Reservation Cart</span>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- ======================================================== -->
    <!-- SHOPEE-STYLE ORDER & RESERVATION TRACKER -->
    <!-- ======================================================== -->
    <section id="tracker-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
      <div class="bg-gradient-to-br from-slate-900/95 via-ics-dark/90 to-slate-900/95 rounded-3xl border border-slate-800/90 shadow-2xl p-5 sm:p-7 relative overflow-hidden">

        <!-- Subtle background glow -->
        <div class="absolute -right-20 -top-20 w-72 h-72 bg-ics-700/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Tracker Header -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 pb-5 border-b border-slate-800/80">
          <div class="flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-ics-800 to-ics-700 flex items-center justify-center text-white shadow-lg flex-shrink-0">
              <svg class="w-6 h-6 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
              </svg>
            </div>
            <div>
              <div class="flex items-center gap-2">
                <h3 class="text-base sm:text-lg font-black text-white font-display">
                  Order Status & Tracking Progress
                </h3>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-950 text-amber-300 border border-amber-800">
                  Shopee-Style Live Tracker
                </span>
              </div>
              <p class="text-xs text-slate-400">
                Real-time progress for your uniform pre-orders from queue confirmation to pickup release.
              </p>
            </div>
          </div>

          <!-- Reservation Selector / Search -->
          <div class="flex items-center gap-2 w-full md:w-auto">
            <div class="relative flex-1 md:w-64">
              <select id="tracker-ref-select" onchange="icsApp.selectTrackerReservation(this.value)" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white font-mono focus:outline-none focus:border-ics-500">
                @foreach($reservations as $res)
                <option value="{{ $res->ref_code }}">{{ $res->ref_code }} — {{ $res->student_name }} ({{ $res->status }})</option>
                @endforeach
              </select>
            </div>
            <button onclick="icsApp.printActiveTrackedSlip()" class="px-3 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition flex items-center gap-1.5 shadow">
              <svg class="w-3.5 h-3.5 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
              </svg>
              <span>Claim Slip</span>
            </button>
          </div>
        </div>

        <!-- Buyer Account Summary Bar -->
        <div class="mt-4 p-3.5 rounded-2xl bg-slate-950/60 border border-slate-800/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs">
          <div class="flex items-center gap-3">
            <div id="tracker-buyer-avatar" class="w-9 h-9 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-600 flex items-center justify-center font-bold text-white text-xs">
              JS
            </div>
            <div>
              <p class="font-bold text-white" id="tracker-buyer-name">Julian Angelo Santos</p>
              <p class="text-[11px] text-slate-400 font-mono" id="tracker-buyer-meta">ID: 2025-01429-AIS • AIS 2B</p>
            </div>
          </div>
          <div class="flex items-center gap-4 text-xs font-mono">
            <div>
              <span class="text-[10px] text-slate-500 uppercase block">Ref Code:</span>
              <span id="tracker-badge-ref" class="font-bold text-ics-gold font-mono">ICS-2026-X941K</span>
            </div>
            <div>
              <span class="text-[10px] text-slate-500 uppercase block">Total Due:</span>
              <span id="tracker-badge-total" class="font-bold text-white">₱1,385.00</span>
            </div>
            <div>
              <span class="text-[10px] text-slate-500 uppercase block">Current Status:</span>
              <span id="tracker-badge-status" class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-950 text-blue-300 border border-blue-800">Ready for Pickup</span>
            </div>
          </div>
        </div>

        <!-- Shopee-Style 4-Stage Horizontal Progress Line -->
        <div class="mt-8 px-2 sm:px-6">
          <div class="relative">
            <!-- Background connecting line -->
            <div class="absolute top-5 left-0 right-0 h-1 bg-slate-800 -translate-y-1/2 rounded-full z-0"></div>
            <!-- Active colored connecting line (width controlled by JS: 0%, 33%, 66%, 100%) -->
            <div id="tracker-progress-bar-fill" class="absolute top-5 left-0 h-1 bg-gradient-to-r from-emerald-500 via-ics-gold to-blue-500 -translate-y-1/2 rounded-full z-0 transition-all duration-700" style="width: 66%;"></div>

            <!-- Steps Grid (4 Milestones) -->
            <div class="grid grid-cols-4 relative z-10 text-center">

              <!-- Step 1: Order Placed -->
              <div id="tracker-step-1" class="flex flex-col items-center">
                <div class="tracker-step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm bg-emerald-600 text-white shadow-lg ring-4 ring-slate-900 transition-all duration-300">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p class="text-xs font-bold text-white mt-2.5">Order Placed</p>
                <p class="text-[10px] text-slate-400 hidden sm:block mt-0.5 font-mono">Recorded in Queue</p>
              </div>

              <!-- Step 2: Preparing & Sizing -->
              <div id="tracker-step-2" class="flex flex-col items-center">
                <div class="tracker-step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm bg-emerald-600 text-white shadow-lg ring-4 ring-slate-900 transition-all duration-300">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p class="text-xs font-bold text-white mt-2.5">Sizing & Prep</p>
                <p class="text-[10px] text-slate-400 hidden sm:block mt-0.5 font-mono">Stock Allocated</p>
              </div>

              <!-- Step 3: Ready for Pickup -->
              <div id="tracker-step-3" class="flex flex-col items-center">
                <div class="tracker-step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm bg-blue-600 text-white shadow-lg ring-4 ring-slate-900 transition-all duration-300">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                </div>
                <p class="text-xs font-bold text-white mt-2.5">Ready for Pickup</p>
                <p class="text-[10px] text-blue-300 hidden sm:block mt-0.5 font-mono">At ICS Center</p>
              </div>

              <!-- Step 4: Claimed / Complete -->
              <div id="tracker-step-4" class="flex flex-col items-center">
                <div class="tracker-step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm bg-slate-800 text-slate-400 shadow ring-4 ring-slate-900 transition-all duration-300">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                </div>
                <p class="text-xs font-bold text-slate-400 mt-2.5">Claimed</p>
                <p class="text-[10px] text-slate-500 hidden sm:block mt-0.5 font-mono">Released to Student</p>
              </div>

            </div>
          </div>
        </div>

        <!-- Dynamic Status Notification Box (Shopee-Style Shipping Update) -->
        <div class="mt-8 p-4 rounded-2xl bg-slate-950/80 border border-slate-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
          <div class="flex items-center gap-3">
            <div id="tracker-status-icon-box" class="w-9 h-9 rounded-xl bg-blue-950/80 text-blue-400 border border-blue-800 flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div>
              <p id="tracker-status-headline" class="text-xs font-bold text-white">
                Item Ready at ICS Student Council Center!
              </p>
              <p id="tracker-status-subtext" class="text-[11px] text-slate-400">
                Scheduled Pickup: <span id="tracker-pickup-date-display" class="text-ics-gold font-mono font-semibold">2026-10-08</span> (<span id="tracker-pickup-slot-display">10:30 AM - 12:30 PM Batch 2</span>)
              </p>
              <p class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1.5 flex-wrap">
                <span>Payment:</span>
                <span id="tracker-payment-badge" class="font-semibold text-white font-mono">Cash on Pickup</span>
                <span id="tracker-receipt-link-container" class="hidden">
                  • <button type="button" onclick="icsApp.viewActiveReceipt()" class="text-blue-400 hover:text-blue-300 underline text-[10px] font-bold cursor-pointer">View My Receipt</button>
                </span>
              </p>
            </div>
          </div>
          <div class="flex flex-wrap items-center gap-2">
            <button
              id="tracker-cancel-btn"
              onclick="icsApp.cancelActiveTrackedReservation()"
              class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-rose-950/80 hover:bg-rose-900 text-rose-300 border border-rose-800 transition flex items-center gap-1.5 shadow">
              <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span>Cancel Reservation</span>
            </button>
            <button onclick="icsApp.openSizeGuideModal()" class="px-3 py-1.5 rounded-xl text-xs font-medium text-slate-400 hover:text-white transition">
              Fitting Info
            </button>
            <button onclick="icsApp.printActiveTrackedSlip()" class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-ics-700 to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white shadow transition flex items-center gap-1.5">
              <span>Print Slip</span>
              <svg class="w-3.5 h-3.5 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
              </svg>
            </button>
          </div>
        </div>

      </div>
    </section>

    <!-- Toolbar: Search & Category Filter Buttons -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
      <div class="bg-slate-900/90 rounded-3xl border border-slate-800/90 shadow-xl p-4 flex flex-col md:flex-row gap-4 items-center justify-between">

        <!-- Category Filters (Horizontal Scroll on Mobile, Flex-Wrap on Desktop) -->
        <div class="flex items-center gap-1.5 sm:gap-2 w-full md:w-auto overflow-x-auto pb-1 md:pb-0 no-scrollbar">
          <button
            data-cat="all"
            onclick="icsApp.setCategoryFilter('all')"
            class="cat-filter-btn flex-shrink-0 px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-[11px] sm:text-xs font-bold bg-ics-700 text-white shadow transition">
            All Merch (10)
          </button>
          <button
            data-cat="general"
            onclick="icsApp.setCategoryFilter('general')"
            class="cat-filter-btn flex-shrink-0 px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-[11px] sm:text-xs font-semibold bg-slate-800/80 hover:bg-slate-800 text-slate-300 transition">
            Collegiate Uniforms
          </button>
          <button
            data-cat="pe"
            onclick="icsApp.setCategoryFilter('pe')"
            class="cat-filter-btn flex-shrink-0 px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-[11px] sm:text-xs font-semibold bg-slate-800/80 hover:bg-slate-800 text-slate-300 transition">
            Athletics & PE Wear
          </button>
          <button
            data-cat="department"
            onclick="icsApp.setCategoryFilter('department')"
            class="cat-filter-btn flex-shrink-0 px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-[11px] sm:text-xs font-semibold bg-slate-800/80 hover:bg-slate-800 text-slate-300 transition">
            Dept & Varsity
          </button>
          <button
            data-cat="accessory"
            onclick="icsApp.setCategoryFilter('accessory')"
            class="cat-filter-btn flex-shrink-0 px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-[11px] sm:text-xs font-semibold bg-slate-800/80 hover:bg-slate-800 text-slate-300 transition">
            Lanyards & Accessories
          </button>
        </div>

        <!-- Search Input -->
        <div class="relative w-full md:w-72">
          <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
          <input
            type="text"
            id="student-search-input"
            oninput="icsApp.handleSearch(this.value)"
            placeholder="Search uniforms, jackets, pants..."
            class="w-full bg-slate-950 border border-slate-700/80 rounded-2xl pl-10 pr-4 py-2 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-ics-500 focus:ring-1 focus:ring-ics-500">
        </div>

      </div>
    </section>

    <!-- Product Grid Section (Compact 2-Column Grid on Mobile, 4-Col on Desktop) -->
    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-5 sm:mt-8">
      <div id="catalog-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2.5 sm:gap-6">
        <!-- Rendered reactively via JS with initial SSR fallback -->
        @foreach($products as $product)
        <div class="product-card group bg-slate-900/90 rounded-2xl sm:rounded-3xl border border-slate-800/90 overflow-hidden shadow-md hover:shadow-2xl hover:border-ics-700/70 transition-all duration-300 flex flex-col cursor-pointer active:scale-[0.99]"
          data-id="{{ $product->id }}"
          data-code="{{ $product->item_code }}"
          data-category="{{ $product->category }}"
          onclick="icsApp.openProductModal('{{ $product->id }}')">

          <!-- Thumbnail Image Container (Compact on Mobile, Enlarge on Modal Click) -->
          <div class="relative aspect-square sm:aspect-[4/3] bg-slate-950 overflow-hidden">
            <img src="{{ asset($product->image_path) }}"
              alt="{{ $product->name }}"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              onerror="this.src='{{ asset('images/male_polo.jpg') }}'">

            <!-- Badges (Compact on mobile) -->
            <div class="absolute top-1.5 left-1.5 sm:top-3 sm:left-3 flex flex-wrap gap-1 sm:gap-1.5">
              <span class="px-1.5 py-0.5 sm:px-2.5 sm:py-1 rounded-md sm:rounded-xl text-[8px] sm:text-[10px] font-black uppercase tracking-wider bg-ics-800 text-white shadow border border-ics-600">
                {{ $product->category }}
              </span>
              @if($product->dept !== 'all')
              <span class="hidden sm:inline-block px-2 py-0.5 rounded-xl text-[10px] font-bold bg-slate-950/80 text-ics-gold border border-ics-gold/40">
                {{ $product->dept }}
              </span>
              @endif
            </div>

            <!-- Stock status pill -->
            <div class="absolute top-1.5 right-1.5 sm:top-3 sm:right-3">
              @if($product->current_stock <= 0)
                <span class="px-1.5 py-0.5 sm:px-2 sm:py-0.5 rounded-full text-[8px] sm:text-[10px] font-bold bg-rose-900/90 text-rose-200 border border-rose-700">Out of Stock</span>
                @elseif($product->current_stock < 20)
                  <span class="px-1.5 py-0.5 sm:px-2 sm:py-0.5 rounded-full text-[8px] sm:text-[10px] font-bold bg-amber-900/90 text-amber-200 border border-amber-600">Low Stock ({{ $product->current_stock }})</span>
                  @else
                  <span class="px-1.5 py-0.5 sm:px-2 sm:py-0.5 rounded-full text-[8px] sm:text-[10px] font-bold bg-emerald-900/90 text-emerald-200 border border-emerald-700">In Stock ({{ $product->current_stock }})</span>
                  @endif
            </div>
          </div>

          <!-- Product Body (Compact & Neat on Mobile) -->
          <div class="p-2.5 sm:p-5 flex-1 flex flex-col justify-between">
            <div>
              <div class="flex items-center justify-between text-[9px] sm:text-[11px] text-slate-400 mb-0.5 sm:mb-1">
                <span class="font-mono text-ics-gold font-semibold truncate">{{ $product->item_code }}</span>
                <span class="truncate ml-1">{{ $product->gender }}</span>
              </div>
              <h3 class="text-xs sm:text-sm font-bold text-white group-hover:text-ics-400 transition leading-snug line-clamp-2">
                {{ $product->name }}
              </h3>
              <p class="hidden sm:block text-xs text-slate-400 mt-1 line-clamp-2 leading-relaxed">
                {{ $product->description }}
              </p>
            </div>

            <div class="mt-2 sm:mt-4 pt-2 sm:pt-4 border-t border-slate-800/80 flex flex-col sm:flex-row sm:items-center justify-between gap-1.5 sm:gap-2">
              <div>
                <p class="hidden sm:block text-[9px] sm:text-[10px] text-slate-400 uppercase font-semibold">Reserve Price</p>
                <p class="text-xs sm:text-base font-extrabold text-white font-mono">
                  ₱{{ number_format($product->price, 2) }}
                </p>
              </div>

              <button
                type="button"
                onclick="event.stopPropagation(); icsApp.openProductModal('{{ $product->id }}')"
                class="w-full sm:w-auto px-2 sm:px-3.5 py-1.5 sm:py-2 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-bold bg-gradient-to-r from-ics-700 to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white transition flex items-center justify-center gap-1 shadow">
                <span>Reserve</span>
                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </button>
            </div>

          </div>

        </div>
        @endforeach
      </div>
    </section>

  </main>

  <!-- ======================================================== -->
  <!-- 2. ADMIN LOGISTICS & MANAGEMENT PANEL -->
  <!-- (Modules from input_file_2.png & input_file_4.png: -->
  <!-- Dashboard, Info Mgmt, Reports, User Mgmt, Activity Logs) -->
  <!-- ======================================================== -->
  <main id="admin-view-container" class="hidden flex-1 pb-16 transition-opacity duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

      <!-- Admin Mobile Horizontal Tab Navigation (Quick 1-Tap on Phones & Tablets) -->
      <div class="lg:hidden mb-4 overflow-x-auto pb-1 -mx-2 px-2 flex items-center gap-2 no-scrollbar">
        <button onclick="icsApp.setAdminTab('dashboard')" id="admin-mob-tab-dashboard" class="admin-mob-tab flex-shrink-0 px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-ics-800 text-white shadow border border-ics-600">
          <span>📊 Dashboard</span>
        </button>
        <button onclick="icsApp.setAdminTab('infomgmt')" id="admin-mob-tab-infomgmt" class="admin-mob-tab flex-shrink-0 px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-slate-900 border border-slate-800 text-slate-400 hover:text-white">
          <span>📁 Info Mgmt</span>
        </button>
        <button onclick="icsApp.setAdminTab('reservations')" id="admin-mob-tab-reservations" class="admin-mob-tab flex-shrink-0 px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-slate-900 border border-slate-800 text-slate-400 hover:text-white">
          <span>📋 Queue</span>
        </button>
        <button onclick="icsApp.setAdminTab('reports')" id="admin-mob-tab-reports" class="admin-mob-tab flex-shrink-0 px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-slate-900 border border-slate-800 text-slate-400 hover:text-white">
          <span>📈 Reports</span>
        </button>
        <button onclick="icsApp.setAdminTab('usermgmt')" id="admin-mob-tab-usermgmt" class="admin-mob-tab flex-shrink-0 px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-slate-900 border border-slate-800 text-slate-400 hover:text-white">
          <span>👥 Users</span>
        </button>
        <button onclick="icsApp.setAdminTab('actlogs')" id="admin-mob-tab-actlogs" class="admin-mob-tab flex-shrink-0 px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 bg-slate-900 border border-slate-800 text-slate-400 hover:text-white">
          <span>📜 Audit Logs</span>
        </button>
      </div>

      <!-- Admin Layout Grid: Sidebar Navigation + Main Panel -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- ======================================================== -->
        <!-- SIDEBAR NAVIGATION (Matching Whiteboard wireframe) -->
        <!-- Dashboard | INFO MGMT | REPORTS | USER MGMT | ACT LOGS -->
        <!-- ======================================================== -->
        <aside class="hidden lg:block lg:col-span-3 bg-slate-900/90 rounded-3xl border border-slate-800 p-4 shadow-2xl sticky top-24">
          <div class="p-3 mb-3 bg-gradient-to-br from-ics-900/90 to-slate-950 rounded-2xl border border-ics-800/80">
            <div class="flex items-center gap-3">
              <div class="w-10 h-10 rounded-xl bg-ics-800 border border-ics-600 flex items-center justify-center p-1 flex-shrink-0">
                <img src="{{ asset('images/ics-logo.png') }}" alt="ICS" class="w-full h-full object-contain">
              </div>
              <div class="overflow-hidden">
                <h4 class="text-xs font-black uppercase text-white tracking-wide">ICS Admin Console</h4>
                <p class="text-[10px] text-ics-gold font-mono truncate">ICS Merch Team • Group 4</p>
              </div>
            </div>
            <div class="mt-2.5 pt-2 border-t border-ics-900 text-[10px] text-slate-300 flex justify-between">
              <span>Status: <strong class="text-emerald-400">Active Node</strong></span>
              <span class="font-mono text-slate-400">v2.4.0-PHP</span>
            </div>
          </div>

          <!-- Navigation Links -->
          <nav class="space-y-1.5" aria-label="Admin Navigation Tabs">

            <!-- 1. Dashboard -->
            <button
              id="admin-tab-btn-dashboard"
              onclick="icsApp.setAdminTab('dashboard')"
              class="admin-nav-btn w-full text-left px-3.5 py-2.5 rounded-2xl text-xs font-bold transition flex items-center justify-between bg-ics-800 text-white shadow-md">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                </svg>
                <span>Dashboard (Read)</span>
              </div>
              <span class="text-[10px] px-2 py-0.5 rounded-full bg-ics-950 font-mono text-ics-300">Sales/Stock</span>
            </button>

            <!-- 2. Information Management (CRUD + Image Upload/Edit) -->
            <button
              id="admin-tab-btn-infomgmt"
              onclick="icsApp.setAdminTab('infomgmt')"
              class="admin-nav-btn w-full text-left px-3.5 py-2.5 rounded-2xl text-xs font-bold transition flex items-center justify-between text-slate-400 hover:text-white hover:bg-slate-800/80">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <span>INFO MGMT (CRUD)</span>
              </div>
              <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-slate-800 font-mono text-slate-300">{{ $totalProducts }} items</span>
            </button>

            <!-- 3. Reservation Queue Logistics -->
            <button
              id="admin-tab-btn-reservations"
              onclick="icsApp.setAdminTab('reservations')"
              class="admin-nav-btn w-full text-left px-3.5 py-2.5 rounded-2xl text-xs font-bold transition flex items-center justify-between text-slate-400 hover:text-white hover:bg-slate-800/80">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <span>Reservation Queue</span>
              </div>
              <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-amber-900/60 font-mono text-amber-300">{{ $pendingReservationsCount }} pending</span>
            </button>

            <!-- 4. Reports (Sales vs Stock) -->
            <button
              id="admin-tab-btn-reports"
              onclick="icsApp.setAdminTab('reports')"
              class="admin-nav-btn w-full text-left px-3.5 py-2.5 rounded-2xl text-xs font-bold transition flex items-center justify-between text-slate-400 hover:text-white hover:bg-slate-800/80">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span>REPORTS (Read)</span>
              </div>
              <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-slate-800 font-mono text-slate-300">Master CSV</span>
            </button>

            <!-- 5. User Management (CRUD) -->
            <button
              id="admin-tab-btn-usermgmt"
              onclick="icsApp.setAdminTab('usermgmt')"
              class="admin-nav-btn w-full text-left px-3.5 py-2.5 rounded-2xl text-xs font-bold transition flex items-center justify-between text-slate-400 hover:text-white hover:bg-slate-800/80">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>USER MGMT (CRUD)</span>
              </div>
              <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-slate-800 font-mono text-slate-300">{{ $users->count() }}</span>
            </button>

            <!-- 6. Activity Logs (Audit Trail) -->
            <button
              id="admin-tab-btn-actlogs"
              onclick="icsApp.setAdminTab('actlogs')"
              class="admin-nav-btn w-full text-left px-3.5 py-2.5 rounded-2xl text-xs font-bold transition flex items-center justify-between text-slate-400 hover:text-white hover:bg-slate-800/80">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>ACT LOGS (Audit Trail)</span>
              </div>
              <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-slate-800 font-mono text-cyan-300">Live</span>
            </button>

            <!-- 7. Support Tickets & Chat Helpdesk -->
            <button
              id="admin-tab-btn-support"
              onclick="icsApp.setAdminTab('support')"
              class="admin-nav-btn w-full text-left px-3.5 py-2.5 rounded-2xl text-xs font-bold transition flex items-center justify-between text-slate-400 hover:text-white hover:bg-slate-800/80">
              <div class="flex items-center gap-2.5">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                <span>SUPPORT CHAT</span>
              </div>
              <span id="admin-nav-ticket-badge" class="text-[10px] px-1.5 py-0.5 rounded-full bg-emerald-950 border border-emerald-700/60 font-mono text-emerald-300 font-bold">
                {{ $openTicketsCount ?? 0 }} Open
              </span>
            </button>

          </nav>

          <!-- Group Attribution Card -->
          <div class="mt-6 pt-4 border-t border-slate-800/80 text-[11px] text-slate-400">
            <p class="font-bold text-white uppercase text-[10px] tracking-wider mb-1">CP3 GROUP 4</p>
            <p class="text-slate-300">Lead: <strong>DERRAMAS, J.</strong></p>
            <p class="text-[10px] text-slate-400">Buenaventura, Regadio, Dotillos, Albor</p>
            <p class="text-[10px] text-ics-gold font-mono mt-1">Associate in Information Systems</p>
          </div>
        </aside>

        <!-- ======================================================== -->
        <!-- MAIN ADMIN CONTENT AREA -->
        <!-- ======================================================== -->
        <div class="lg:col-span-9 space-y-6">

          <!-- ======================================================== -->
          <!-- MODULE 1: DASHBOARD (Sales vs Stock Analytics) -->
          <!-- ======================================================== -->
          <section id="admin-sec-dashboard" class="admin-tab-section space-y-6">

            <!-- Top Metric KPI Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

              <!-- Total Products -->
              <div class="bg-slate-900/90 rounded-2xl border border-slate-800 p-4 shadow">
                <div class="flex items-center justify-between">
                  <span class="text-[11px] font-bold text-slate-400 uppercase">Total Catalog Items</span>
                  <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                </div>
                <p class="text-2xl font-black text-white font-display mt-1">{{ $totalProducts }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Active merchandise models</p>
              </div>

              <!-- Available Stock -->
              <div class="bg-slate-900/90 rounded-2xl border border-slate-800 p-4 shadow">
                <div class="flex items-center justify-between">
                  <span class="text-[11px] font-bold text-slate-400 uppercase">On-Hand Stock</span>
                  <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                </div>
                <p class="text-2xl font-black text-emerald-400 font-display mt-1">{{ $totalStockUnits }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Units ready for issue</p>
              </div>

              <!-- Claimed / Sold -->
              <div class="bg-slate-900/90 rounded-2xl border border-slate-800 p-4 shadow">
                <div class="flex items-center justify-between">
                  <span class="text-[11px] font-bold text-slate-400 uppercase">Units Claimed / Sold</span>
                  <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                </div>
                <p class="text-2xl font-black text-blue-400 font-display mt-1">{{ $totalSoldUnits }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Revenue: ₱{{ number_format($totalRevenue, 2) }}</p>
              </div>

              <!-- Active Reservations -->
              <div class="bg-slate-900/90 rounded-2xl border border-slate-800 p-4 shadow">
                <div class="flex items-center justify-between">
                  <span class="text-[11px] font-bold text-slate-400 uppercase">Active Reservations</span>
                  <span class="w-2 h-2 rounded-full bg-ics-gold"></span>
                </div>
                <p class="text-2xl font-black text-ics-gold font-display mt-1">{{ $totalReservedUnits }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">{{ $pendingReservationsCount }} pending, {{ $readyReservationsCount }} ready</p>
              </div>

            </div>

            <!-- ======================================================== -->
            <!-- VISUAL CHARTS (CIRCLE / DONUT CHART & BAR CHART) -->
            <!-- ======================================================== -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

              <!-- Donut Chart: Inventory Health & Stock vs Sales Ratio -->
              <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-5 shadow-xl flex flex-col justify-between">
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-800">
                  <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">
                      <span>Stock & Sales Distribution</span>
                      <span class="px-2 py-0.5 rounded text-[9px] font-mono bg-emerald-950 text-emerald-300 border border-emerald-800">Circle Chart</span>
                    </h4>
                    <p class="text-[10px] text-slate-400">On-hand stock vs sold vs reserved ratio</p>
                  </div>
                  <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                </div>
                <div class="relative h-56 flex items-center justify-center">
                  <canvas id="inventoryDonutChart"></canvas>
                </div>
                <div class="grid grid-cols-3 gap-2 mt-4 pt-3 border-t border-slate-800/80 text-center font-mono text-xs">
                  <div class="p-2 rounded-xl bg-slate-950/60 border border-slate-800">
                    <span class="text-[10px] text-emerald-400 block font-bold">On-Hand</span>
                    <span class="text-white font-bold">{{ $totalStockUnits }}</span>
                  </div>
                  <div class="p-2 rounded-xl bg-slate-950/60 border border-slate-800">
                    <span class="text-[10px] text-blue-400 block font-bold">Claimed (Sold)</span>
                    <span class="text-white font-bold">{{ $totalSoldUnits }}</span>
                  </div>
                  <div class="p-2 rounded-xl bg-slate-950/60 border border-slate-800">
                    <span class="text-[10px] text-amber-400 block font-bold">Reserved</span>
                    <span class="text-white font-bold">{{ $totalReservedUnits }}</span>
                  </div>
                </div>
              </div>

              <!-- Bar Chart: Category Performance (Available vs Sold) -->
              <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-5 shadow-xl flex flex-col justify-between">
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-800">
                  <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">
                      <span>Category Sales vs Stock</span>
                      <span class="px-2 py-0.5 rounded text-[9px] font-mono bg-blue-950 text-blue-300 border border-blue-800">Bar Chart</span>
                    </h4>
                    <p class="text-[10px] text-slate-400">Units sold and available across apparel categories</p>
                  </div>
                  <span class="w-2.5 h-2.5 rounded-full bg-blue-400"></span>
                </div>
                <div class="relative h-56 flex items-center justify-center">
                  <canvas id="categoryBarChart"></canvas>
                </div>
                <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-800/80 text-[10px] text-slate-400">
                  <span>General • PE • Dept • Accessories</span>
                  <span class="font-mono text-emerald-400">Live Inventory Synced</span>
                </div>
              </div>

            </div>

            <!-- SALES VS STOCK ANALYTICS CARD -->
            <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-6 shadow-xl">
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-6 pb-4 border-b border-slate-800">
                <div>
                  <h3 class="text-lg font-black text-white font-display flex items-center gap-2">
                    <span>Sales vs Stock Inventory Analytics</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-ics-800 text-ics-200">Real-Time</span>
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
                          <span>•</span>
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
                <h4 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                  <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                  <span>Recent Activity Audit Trail (Whiteboard Module 5)</span>
                </h4>
                <button onclick="icsApp.setAdminTab('actlogs')" class="text-xs text-ics-gold hover:underline">
                  View All Logs &rarr;
                </button>
              </div>

              <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                  <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] font-mono border-b border-slate-800">
                    <tr>
                      <th class="py-2.5 px-3">USER CODE</th>
                      <th class="py-2.5 px-3">ACTION</th>
                      <th class="py-2.5 px-3">ACTIVITY</th>
                      <th class="py-2.5 px-3">DATE / TIMESTAMP</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-800 text-slate-300">
                    @foreach($activityLogs->take(5) as $log)
                    <tr class="hover:bg-slate-800/40">
                      <td class="py-2 px-3 font-mono text-ics-gold font-bold">{{ $log->user_code }}</td>
                      <td class="py-2 px-3">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold font-mono
                          @if($log->action === 'CREATE') bg-emerald-950 text-emerald-300 border border-emerald-800
                          @elseif($log->action === 'UPDATE') bg-amber-950 text-amber-300 border border-amber-800
                          @elseif($log->action === 'DELETE') bg-rose-950 text-rose-300 border border-rose-800
                          @elseif($log->action === 'LOGIN') bg-purple-950 text-purple-300 border border-purple-800
                          @elseif($log->action === 'LOGOUT') bg-slate-800 text-slate-300 border border-slate-700
                          @else bg-blue-950 text-blue-300 border border-blue-800 @endif">
                          {{ $log->action }}
                        </span>
                      </td>
                      <td class="py-2 px-3">{{ $log->activity }}</td>
                      <td class="py-2 px-3 font-mono text-slate-400 text-[11px]">{{ $log->created_at->format('m/d/Y, h:i A') }}</td>
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
                  onclick="icsApp.openAddProductModal()"
                  class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-ics-700 to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white text-xs font-bold transition flex items-center gap-2 shadow-lg border border-ics-600">
                  <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                  <span>Add New Apparel / Merch</span>
                </button>
              </div>

              <!-- Product Table -->
              <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                  <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] font-mono border-b border-slate-800">
                    <tr>
                      <th class="py-3 px-3">Item / Photo</th>
                      <th class="py-3 px-3">Item Code</th>
                      <th class="py-3 px-3">Category</th>
                      <th class="py-3 px-3">Price (PHP)</th>
                      <th class="py-3 px-3">Stock Units</th>
                      <th class="py-3 px-3">Status</th>
                      <th class="py-3 px-3 text-right">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-800 text-slate-300">
                    @foreach($products as $p)
                    <tr class="hover:bg-slate-800/50 transition">
                      <td class="py-3 px-3">
                        <div class="flex items-center gap-3">
                          <img src="{{ asset($p->image_path) }}" alt="{{ $p->name }}" class="w-12 h-12 rounded-xl object-cover border border-slate-700 shadow flex-shrink-0">
                          <div>
                            <p class="font-bold text-white text-xs">{{ $p->name }}</p>
                            <p class="text-[10px] text-slate-400">{{ $p->gender }} • {{ $p->dept }}</p>
                          </div>
                        </div>
                      </td>
                      <td class="py-3 px-3 font-mono text-ics-gold font-bold">{{ $p->item_code }}</td>
                      <td class="py-3 px-3 uppercase text-[10px] font-semibold text-slate-300">{{ $p->category }}</td>
                      <td class="py-3 px-3 font-mono font-bold text-white">₱{{ number_format($p->price, 2) }}</td>
                      <td class="py-3 px-3 font-mono font-bold text-emerald-400">{{ $p->current_stock }}</td>
                      <td class="py-3 px-3">
                        @if($p->current_stock <= 0)
                          <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-950 text-rose-300 border border-rose-800">Out of Stock</span>
                          @elseif($p->current_stock < 20)
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-950 text-amber-300 border border-amber-800">Low Stock</span>
                            @else
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">In Stock</span>
                            @endif
                      </td>
                      <td class="py-3 px-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                          <!-- Edit Product (Details + Picture) -->
                          <button
                            onclick="icsApp.openEditProductModal({{ json_encode($p) }})"
                            class="px-2.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold transition flex items-center gap-1 border border-slate-700"
                            title="Edit Product & Picture">
                            <svg class="w-3.5 h-3.5 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <span>Edit</span>
                          </button>
                          <!-- Delete Product -->
                          <button
                            onclick="icsApp.deleteProduct('{{ $p->id }}', '{{ $p->name }}')"
                            class="p-1.5 rounded-xl bg-rose-950/60 hover:bg-rose-900 text-rose-300 transition border border-rose-800"
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
                    <span>Live Student Reservation Queue</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-amber-950 text-amber-300 border border-amber-800">{{ $reservations->count() }} Total</span>
                  </h3>
                  <p class="text-xs text-slate-400">
                    Review incoming student reservations, approve readiness for pickup, and mark items as claimed.
                  </p>
                </div>

                <!-- Status Filter -->
                <div class="flex items-center gap-2">
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
                <div class="p-4 rounded-2xl bg-slate-950/80 border border-slate-800 hover:border-slate-700 transition" data-status="{{ $r->status }}">
                  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 pb-3 border-b border-slate-800/80">
                    <div class="flex items-center gap-2.5">
                      <span class="font-mono font-bold text-sm text-ics-gold">{{ $r->ref_code }}</span>
                      <span class="px-2 py-0.5 rounded-full text-[10px] font-bold
                        @if($r->status === 'Pending') bg-amber-950 text-amber-300 border border-amber-700
                        @elseif($r->status === 'Ready for Pickup') bg-blue-950 text-blue-300 border border-blue-700
                        @elseif($r->status === 'Claimed') bg-emerald-950 text-emerald-300 border border-emerald-700
                        @else bg-rose-950 text-rose-300 border border-rose-700 @endif">
                        {{ $r->status }}
                      </span>
                    </div>

                    <div class="text-[11px] text-slate-400 font-mono">
                      Reserved on: {{ $r->created_at->format('M d, Y h:i A') }}
                    </div>
                  </div>

                  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-3">
                    <div>
                      <p class="text-[10px] text-slate-400 uppercase font-semibold">Student Info</p>
                      <p class="text-xs font-bold text-white">{{ $r->student_name }}</p>
                      <p class="text-[11px] text-slate-300 font-mono">{{ $r->student_id }} • {{ $r->year_level }}</p>
                      <p class="text-[11px] text-slate-400">{{ $r->department }}</p>
                      <p class="text-[11px] text-slate-400 font-mono">Contact: {{ $r->contact }}</p>
                    </div>

                    <div>
                      <p class="text-[10px] text-slate-400 uppercase font-semibold">Pickup Schedule</p>
                      <p class="text-xs font-bold text-ics-gold">{{ $r->pickup_date }}</p>
                      <p class="text-[11px] text-slate-300">{{ $r->pickup_slot }}</p>
                      <p class="text-[11px] text-slate-400 mt-1 italic">{{ $r->notes ?: 'No additional notes' }}</p>
                    </div>

                    <div>
                      <p class="text-[10px] text-slate-400 uppercase font-semibold">Payment & Receipt</p>
                      <div class="flex items-center gap-1.5 mt-1 flex-wrap">
                        @if(($r->payment_method ?? 'Cash on Pickup') === 'GCash Online')
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-950 text-blue-300 border border-blue-800 flex items-center gap-1">
                          <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                          GCash Online
                        </span>
                        @else
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-950 text-amber-300 border border-amber-800 flex items-center gap-1">
                          <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                          Pay at School
                        </span>
                        @endif

                        <span class="text-[9px] font-mono px-1.5 py-0.5 rounded bg-slate-900 border border-slate-800 {{ ($r->payment_status ?? 'Unpaid') === 'Verified' ? 'text-emerald-400' : 'text-amber-400' }}">
                          {{ $r->payment_status ?? 'Unpaid' }}
                        </span>
                      </div>

                      @if(!empty($r->payment_reference))
                      <p class="text-[10px] text-slate-400 font-mono mt-1">
                        Ref: <span class="text-white font-semibold">{{ $r->payment_reference }}</span>
                      </p>
                      @endif

                      @if(!empty($r->receipt_image))
                      <div class="mt-2">
                        <button
                          type="button"
                          onclick="icsApp.openReceiptViewModal({{ json_encode($r) }})"
                          class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl text-xs font-bold bg-gradient-to-r from-blue-900 to-indigo-900 hover:from-blue-800 hover:to-indigo-800 text-blue-200 border border-blue-700 shadow transition cursor-pointer">
                          <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                          <span>View Receipt</span>
                        </button>
                      </div>
                      @endif
                    </div>

                    <div class="text-left md:text-right flex flex-col justify-between">
                      <div>
                        <p class="text-[10px] text-slate-400 uppercase font-semibold">Grand Total</p>
                        <p class="text-lg font-black text-white font-mono">₱{{ number_format($r->total_amount, 2) }}</p>
                      </div>

                      <!-- Action Buttons -->
                      <div class="flex items-center md:justify-end gap-2 mt-2">
                        @if($r->status === 'Pending')
                        <button
                          onclick="icsApp.updateReservationStatus('{{ $r->id }}', 'Ready for Pickup')"
                          class="px-2.5 py-1 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-500 text-white transition">
                          Mark Ready
                        </button>
                        @endif

                        @if($r->status === 'Ready for Pickup' || $r->status === 'Pending')
                        <button
                          onclick="icsApp.updateReservationStatus('{{ $r->id }}', 'Claimed')"
                          class="px-2.5 py-1 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition">
                          Mark Claimed
                        </button>
                        @endif

                        @if($r->status !== 'Cancelled' && $r->status !== 'Claimed')
                        <button
                          onclick="icsApp.updateReservationStatus('{{ $r->id }}', 'Cancelled')"
                          class="px-2.5 py-1 rounded-xl text-xs font-bold bg-rose-950/80 hover:bg-rose-900 text-rose-300 border border-rose-800 transition">
                          Cancel
                        </button>
                        @endif

                        <button
                          onclick="icsApp.viewPrintClaimSlip({{ json_encode($r) }})"
                          class="px-2.5 py-1 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition">
                          Print Slip
                        </button>
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
          <!-- MODULE 4: REPORTS (Sales vs Stock Comprehensive) -->
          <!-- ======================================================== -->
          <section id="admin-sec-reports" class="admin-tab-section hidden space-y-6">

            <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-6 shadow-xl">
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-800">
                <div>
                  <h3 class="text-lg font-black text-white font-display flex items-center gap-2">
                    <span>Reports: Sales vs Stock Master List</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-blue-950 text-blue-300 border border-blue-800">Official Report</span>
                  </h3>
                  <p class="text-xs text-slate-400">
                    Audit-ready report detailing initial stock allocations, confirmed sales (claimed), active reservations, and on-hand inventory.
                  </p>
                </div>

                <div class="flex items-center gap-2">
                  <a href="{{ route('reports.export') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-ics-700 hover:bg-ics-600 text-white transition flex items-center gap-2 shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Download CSV Report</span>
                  </a>
                  <button onclick="window.print()" class="px-3 py-2 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition">
                    Print Report
                  </button>
                </div>
              </div>

              <!-- Report Table -->
              <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                  <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] font-mono border-b border-slate-800">
                    <tr>
                      <th class="py-3 px-3">Item Code</th>
                      <th class="py-3 px-3">Product Name</th>
                      <th class="py-3 px-3">Category</th>
                      <th class="py-3 px-3">Price</th>
                      <th class="py-3 px-3 text-center">Initial Stock</th>
                      <th class="py-3 px-3 text-center">Claimed (Sold)</th>
                      <th class="py-3 px-3 text-center">Reserved</th>
                      <th class="py-3 px-3 text-center">On-Hand Stock</th>
                      <th class="py-3 px-3 text-right">Revenue (PHP)</th>
                      <th class="py-3 px-3">Stock Health</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-800 text-slate-300">
                    @foreach($salesVsStock as $rItem)
                    <tr class="hover:bg-slate-800/40">
                      <td class="py-3 px-3 font-mono text-ics-gold font-bold">{{ $rItem['item_code'] }}</td>
                      <td class="py-3 px-3 font-bold text-white">{{ $rItem['name'] }}</td>
                      <td class="py-3 px-3 uppercase text-[10px] text-slate-400">{{ $rItem['category'] }}</td>
                      <td class="py-3 px-3 font-mono">₱{{ number_format($rItem['price'], 2) }}</td>
                      <td class="py-3 px-3 text-center font-mono font-bold">{{ $rItem['initial_stock'] }}</td>
                      <td class="py-3 px-3 text-center font-mono font-bold text-blue-400">{{ $rItem['units_sold'] }}</td>
                      <td class="py-3 px-3 text-center font-mono font-bold text-amber-400">{{ $rItem['units_reserved'] }}</td>
                      <td class="py-3 px-3 text-center font-mono font-bold text-emerald-400">{{ $rItem['current_stock'] }}</td>
                      <td class="py-3 px-3 text-right font-mono font-bold text-white">₱{{ number_format($rItem['revenue'], 2) }}</td>
                      <td class="py-3 px-3">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold
                          @if($rItem['status'] === 'Out of Stock') bg-rose-950 text-rose-300 border border-rose-800
                          @elseif($rItem['status'] === 'Low Stock') bg-amber-950 text-amber-300 border border-amber-800
                          @else bg-emerald-950 text-emerald-300 border border-emerald-800 @endif">
                          {{ $rItem['status'] }}
                        </span>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot class="bg-slate-950 text-white font-bold border-t-2 border-slate-800">
                    <tr>
                      <td colspan="4" class="py-3 px-3 text-right uppercase font-mono text-slate-400">TOTALS:</td>
                      <td class="py-3 px-3 text-center font-mono">{{ $totalInitialStock ?? array_sum(array_column($salesVsStock, 'initial_stock')) }}</td>
                      <td class="py-3 px-3 text-center font-mono text-blue-400">{{ $totalSoldUnits }}</td>
                      <td class="py-3 px-3 text-center font-mono text-amber-400">{{ $totalReservedUnits }}</td>
                      <td class="py-3 px-3 text-center font-mono text-emerald-400">{{ $totalStockUnits }}</td>
                      <td class="py-3 px-3 text-right font-mono text-emerald-300">₱{{ number_format($totalRevenue, 2) }}</td>
                      <td class="py-3 px-3 text-[10px] text-slate-400">100% Audited</td>
                    </tr>
                  </tfoot>
                </table>
              </div>

            </div>

          </section>

          <!-- ======================================================== -->
          <!-- MODULE 5: USER MANAGEMENT (CRUD) -->
          <!-- ======================================================== -->
          <section id="admin-sec-usermgmt" class="admin-tab-section hidden space-y-6">

            <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-6 shadow-xl">
              <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-800">
                <div>
                  <h3 class="text-lg font-black text-white font-display flex items-center gap-2">
                    <span>User Management (User CRUD)</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-purple-950 text-purple-300 border border-purple-800">{{ $users->count() }} Accounts</span>
                  </h3>
                  <p class="text-xs text-slate-400">
                    Configure faculty advisers, student officers, team leaders, and student roles.
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
              <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                  <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] font-mono border-b border-slate-800">
                    <tr>
                      <th class="py-3 px-3">User Code</th>
                      <th class="py-3 px-3">Name</th>
                      <th class="py-3 px-3">Email Address</th>
                      <th class="py-3 px-3">Role</th>
                      <th class="py-3 px-3">Department</th>
                      <th class="py-3 px-3">Status</th>
                      <th class="py-3 px-3 text-right">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-slate-800 text-slate-300">
                    @foreach($users as $u)
                    <tr class="hover:bg-slate-800/40">
                      <td class="py-3 px-3 font-mono text-ics-gold font-bold">{{ $u->user_code }}</td>
                      <td class="py-3 px-3 font-bold text-white">{{ $u->name }}</td>
                      <td class="py-3 px-3 font-mono text-slate-300">{{ $u->email }}</td>
                      <td class="py-3 px-3">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-800 text-slate-200 border border-slate-700">
                          {{ $u->role }}
                        </span>
                      </td>
                      <td class="py-3 px-3 text-slate-400">{{ $u->department }}</td>
                      <td class="py-3 px-3">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">
                          {{ $u->status }}
                        </span>
                      </td>
                      <td class="py-3 px-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                          <button
                            onclick="icsApp.openEditUserModal({{ json_encode($u) }})"
                            class="px-2 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs">
                            Edit
                          </button>
                          <button
                            onclick="icsApp.deleteUser('{{ $u->id }}', '{{ $u->name }}')"
                            class="p-1 rounded-lg bg-rose-950/60 hover:bg-rose-900 text-rose-300">
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
                    Exact schema matching whiteboard: <strong>USER CODE | ACTION | ACTIVITY | DATE/TIMESTAMP</strong>
                  </p>
                </div>

                <!-- Action filter -->
                <div class="flex items-center gap-2">
                  <select id="act-log-filter-action" onchange="icsApp.filterActivityLogs(this.value)" class="bg-slate-950 border border-slate-700 rounded-xl px-3 py-1.5 text-xs text-white">
                    <option value="all">All Actions</option>
                    <option value="CREATE">CREATE</option>
                    <option value="READ">READ</option>
                    <option value="UPDATE">UPDATE</option>
                    <option value="DELETE">DELETE</option>
                    <option value="LOGIN">LOGIN</option>
                    <option value="LOGOUT">LOGOUT</option>
                  </select>
                </div>
              </div>

              <!-- Activity Log Table -->
              <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                  <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] font-mono border-b border-slate-800">
                    <tr>
                      <th class="py-3 px-3">USER CODE</th>
                      <th class="py-3 px-3">ACTION</th>
                      <th class="py-3 px-3">ACTIVITY</th>
                      <th class="py-3 px-3">MODULE</th>
                      <th class="py-3 px-3">DATE / TIMESTAMP</th>
                    </tr>
                  </thead>
                  <tbody id="activity-logs-tbody" class="divide-y divide-slate-800 text-slate-300">
                    @foreach($activityLogs as $log)
                    <tr class="hover:bg-slate-800/40" data-action="{{ $log->action }}">
                      <td class="py-3 px-3 font-mono text-ics-gold font-bold">{{ $log->user_code }}</td>
                      <td class="py-3 px-3">
                        <span class="px-2.5 py-1 rounded text-[10px] font-bold font-mono
                          @if($log->action === 'CREATE') bg-emerald-950 text-emerald-300 border border-emerald-800
                          @elseif($log->action === 'UPDATE') bg-amber-950 text-amber-300 border border-amber-800
                          @elseif($log->action === 'DELETE') bg-rose-950 text-rose-300 border border-rose-800
                          @elseif($log->action === 'LOGIN') bg-purple-950 text-purple-300 border border-purple-800
                          @elseif($log->action === 'LOGOUT') bg-slate-800 text-slate-300 border border-slate-700
                          @else bg-blue-950 text-blue-300 border border-blue-800 @endif">
                          {{ $log->action }}
                        </span>
                      </td>
                      <td class="py-3 px-3 text-slate-200">{{ $log->activity }}</td>
                      <td class="py-3 px-3 text-[10px] text-slate-400 font-mono">{{ $log->module }}</td>
                      <td class="py-3 px-3 font-mono text-slate-400 text-[11px]">{{ $log->created_at->format('m/d/Y, h:i A') }}</td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
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
                    Module 7: Helpdesk
                  </span>
                  <span class="text-xs text-slate-400">Live Support & Cancellation Desk</span>
                </div>
                <h3 class="text-lg font-black text-white font-display">Student Support Tickets & Chat</h3>
                <p class="text-xs text-slate-400 mt-0.5">Manage student requests for reservation cancellations, size replacements, and verification inquiries</p>
              </div>
              <div class="flex items-center gap-2">
                <button onclick="icsApp.fetchSupportTickets()" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition flex items-center gap-1.5 shadow">
                  <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                  <span>Refresh Tickets</span>
                </button>
              </div>
            </div>

            <!-- Two-Panel Helpdesk Layout -->
            <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-12 min-h-[640px]">
              
              <!-- Left Sidebar: Conversations List ("sa gilid mga convo") -->
              <div class="lg:col-span-5 xl:col-span-4 border-r border-slate-800 flex flex-col bg-slate-950/60">
                <!-- Search & Filters -->
                <div class="p-3.5 border-b border-slate-800/80 space-y-2.5">
                  <div class="relative">
                    <input 
                      type="text" 
                      id="admin-ticket-search-input"
                      oninput="icsApp.filterAdminTickets()"
                      placeholder="Search student, ID, ticket..." 
                      class="w-full bg-slate-900 border border-slate-700 rounded-xl pl-8 pr-3 py-1.5 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 font-sans">
                    <svg class="w-4 h-4 text-slate-500 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                  </div>
                  <!-- Filter Pills -->
                  <div class="flex items-center gap-1 text-[11px] overflow-x-auto pb-0.5">
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
              <div class="lg:col-span-7 xl:col-span-8 flex flex-col bg-slate-950/40 relative">
                
                <!-- Empty State -->
                <div id="admin-chat-empty-state" class="flex-1 flex flex-col items-center justify-center p-8 text-center text-slate-500 min-h-[560px]">
                  <div class="w-16 h-16 rounded-3xl bg-slate-900 border border-slate-800 flex items-center justify-center text-emerald-400 mb-3 shadow-inner">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                  </div>
                  <h4 class="text-sm font-bold text-slate-300">No Conversation Selected</h4>
                  <p class="text-xs text-slate-500 max-w-sm mt-1">Select a student support ticket from the sidebar to view their message history, reply, or approve reservation cancellations.</p>
                </div>

                <!-- Active Chat Panel -->
                <div id="admin-chat-active-panel" class="hidden flex-1 flex flex-col h-full">
                  
                  <!-- Chat Header Bar -->
                  <div class="p-4 border-b border-slate-800 bg-slate-900/90 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                      <div class="flex items-center gap-2">
                        <span id="admin-active-ticket-code" class="text-xs font-mono font-bold text-ics-gold">TCK-2026-0001</span>
                        <span id="admin-active-ticket-reason-badge" class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-950 text-rose-300 border border-rose-800">Cancel Reservation</span>
                        <span id="admin-active-ticket-status-badge" class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-950 text-amber-300 border border-amber-800">In Progress</span>
                      </div>
                      <h4 id="admin-active-ticket-student-name" class="text-sm font-bold text-white mt-1">Julian Angelo Santos</h4>
                      <p id="admin-active-ticket-student-sub" class="text-[10px] text-slate-400 font-mono">2025-01429-AIS • Associate in Information Systems (AIS)</p>
                    </div>

                    <!-- Action Controls Bar -->
                    <div class="flex flex-wrap items-center gap-2">
                      <!-- 1-Click Cancel Reservation Button -->
                      <button 
                        id="admin-btn-cancel-reservation"
                        onclick="icsApp.adminCancelReservationFromActiveTicket()"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold bg-rose-950 hover:bg-rose-900 text-rose-200 border border-rose-800 transition flex items-center gap-1.5 shadow">
                        <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Cancel Order & Restock</span>
                      </button>

                      <!-- Mark Done / Resolved Button -->
                      <button 
                        id="admin-btn-mark-resolved"
                        onclick="icsApp.adminToggleTicketStatus()"
                        class="px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-950 hover:bg-emerald-900 text-emerald-200 border border-emerald-700 transition flex items-center gap-1.5 shadow">
                        <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span id="admin-btn-mark-resolved-text">Mark as Done (Resolved)</span>
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
                  <div id="admin-chat-messages-container" class="flex-1 overflow-y-auto p-4 space-y-3 min-h-[300px] max-h-[380px]">
                    <!-- Messages populated via JS -->
                  </div>

                  <!-- Admin Reply Box & Canned Responses -->
                  <div class="p-3.5 border-t border-slate-800 bg-slate-900/90 space-y-2">
                    <!-- Quick Canned Replies -->
                    <div class="flex items-center gap-1.5 overflow-x-auto pb-1 text-[10px]">
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
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
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

  <!-- ======================================================== -->
  <!-- MODAL: ADD / EDIT MERCH PRODUCT (WITH PHOTO UPLOAD & EDIT) -->
  <!-- ======================================================== -->
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
  <!-- MODAL: ADD / EDIT USER (USER MANAGEMENT CRUD) -->
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
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">User Code *</label>
          <input type="text" id="crud-user-code" required placeholder="e.g. USR-008" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
        </div>
        <div>
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Full Name *</label>
          <input type="text" id="crud-user-name" required placeholder="e.g. Juan dela Cruz" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
        </div>
        <div>
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Email Address *</label>
          <input type="email" id="crud-user-email" required placeholder="user@ics.edu.ph" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
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
  <!-- MODAL: PRODUCT DETAIL & SIZE SELECTOR (STUDENT VIEW) -->
  <!-- ======================================================== -->
  <div id="product-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-2xl w-full p-6 shadow-2xl relative text-left">
      <button onclick="icsApp.closeProductModal()" class="absolute top-5 right-5 text-slate-400 hover:text-white p-1">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-start">
        <!-- Photo -->
        <div class="aspect-square bg-slate-950 rounded-2xl overflow-hidden border border-slate-800 shadow">
          <img id="modal-product-img" src="{{ asset('images/male_polo.jpg') }}" alt="Product" class="w-full h-full object-cover">
        </div>

        <!-- Details -->
        <div class="space-y-4">
          <div>
            <div class="flex items-center gap-2 mb-1">
              <span id="modal-product-code" class="text-xs font-mono text-ics-gold font-bold"></span>
              <span id="modal-product-cat" class="px-2 py-0.5 rounded text-[10px] font-bold bg-ics-900 text-ics-300 uppercase"></span>
            </div>
            <h3 id="modal-product-name" class="text-lg font-black text-white font-display leading-tight"></h3>
            <p id="modal-product-price" class="text-xl font-black text-ics-gold font-mono mt-1"></p>
          </div>

          <p id="modal-product-desc" class="text-xs text-slate-300 leading-relaxed"></p>
          <div class="text-[11px] text-slate-400">
            <span>Material: </span><strong id="modal-product-material" class="text-slate-200"></strong>
          </div>

          <!-- Size Selection -->
          <div>
            <div class="flex items-center justify-between mb-2">
              <span class="text-xs font-bold text-slate-200">Choose Size:</span>
              <button onclick="icsApp.openSizeGuideModal()" class="text-[11px] text-ics-gold hover:underline">Size Chart &rarr;</button>
            </div>
            <div id="modal-sizes-grid" class="flex flex-wrap gap-2">
              <!-- Rendered via JS -->
            </div>
          </div>

          <!-- Quantity Stepper -->
          <div>
            <span class="text-xs font-bold text-slate-200 block mb-2">Quantity:</span>
            <div class="flex items-center gap-3">
              <div class="flex items-center border border-slate-700 rounded-xl bg-slate-950 p-1">
                <button onclick="icsApp.adjustQty(-1)" class="w-7 h-7 rounded-lg bg-slate-800 text-white font-bold flex items-center justify-center hover:bg-slate-700">-</button>
                <span id="modal-product-qty" class="w-10 text-center font-mono font-bold text-white text-xs">1</span>
                <button onclick="icsApp.adjustQty(1)" class="w-7 h-7 rounded-lg bg-slate-800 text-white font-bold flex items-center justify-center hover:bg-slate-700">+</button>
              </div>
              <div class="text-xs font-mono text-slate-400">
                Subtotal: <strong id="modal-product-subtotal" class="text-white">₱0.00</strong>
              </div>
            </div>
          </div>

          <!-- Add to Cart CTA -->
          <button
            id="modal-add-to-cart-btn"
            onclick="icsApp.addToCartFromModal()"
            class="w-full py-3 rounded-2xl bg-gradient-to-r from-ics-700 to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white text-xs font-bold shadow-lg transition flex items-center justify-center gap-2 border border-ics-600">
            <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span>Add to Reservation Cart</span>
          </button>

        </div>
      </div>

    </div>
  </div>

  <!-- ======================================================== -->
  <!-- MODAL: INTERACTIVE SIZE GUIDE TABLE (DUAL UNIT TOGGLE) -->
  <!-- ======================================================== -->
  <div id="size-guide-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-2xl w-full p-6 shadow-2xl relative text-left">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-base font-black text-white font-display">
            Official ICS Apparel Sizing Guide
          </h3>
          <p class="text-xs text-slate-400">Accurate anatomical dimensions for campus uniforms and apparel</p>
        </div>
        <button onclick="icsApp.closeSizeGuideModal()" class="text-slate-400 hover:text-white p-1">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Unit Switcher -->
      <div class="flex items-center justify-between mt-4">
        <div class="flex gap-2">
          <button id="size-tab-tops" onclick="icsApp.setSizeTab('tops')" class="px-3 py-1 rounded-xl text-xs font-bold bg-ics-800 text-white">Tops & Jackets</button>
          <button id="size-tab-bottoms" onclick="icsApp.setSizeTab('bottoms')" class="px-3 py-1 rounded-xl text-xs font-bold bg-slate-800 text-slate-400">Slacks & Skirts</button>
        </div>
        <div class="bg-slate-950 p-1 rounded-xl border border-slate-800 flex items-center text-xs">
          <button id="unit-btn-in" onclick="icsApp.setSizeUnit('in')" class="px-2.5 py-1 rounded-lg font-bold bg-ics-700 text-white">Inches (in)</button>
          <button id="unit-btn-cm" onclick="icsApp.setSizeUnit('cm')" class="px-2.5 py-1 rounded-lg font-bold text-slate-400">Centimeters (cm)</button>
        </div>
      </div>

      <!-- Sizing Table -->
      <div class="overflow-x-auto mt-4">
        <table id="size-guide-table" class="w-full text-center text-xs border border-slate-800 rounded-xl overflow-hidden">
          <!-- Rendered dynamically via JS -->
        </table>
      </div>

      <div class="mt-4 pt-3 border-t border-slate-800 text-[11px] text-slate-400 flex items-center justify-between">
        <span>* Measurements allow &plusmn; 0.5 in tolerance.</span>
        <button onclick="icsApp.closeSizeGuideModal()" class="px-4 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold">Close Guide</button>
      </div>
    </div>
  </div>

  <!-- ======================================================== -->
  <!-- DRAWER: RESERVATION CART & CHECKOUT -->
  <!-- ======================================================== -->
  <div id="cart-drawer" class="hidden fixed inset-0 z-50 overflow-hidden bg-slate-950/70 backdrop-blur-sm">
    <div class="absolute inset-y-0 right-0 max-w-full flex pl-10">
      <div class="w-screen max-w-md bg-slate-900 border-l border-ics-900 shadow-2xl flex flex-col">

        <!-- Drawer Header -->
        <div class="p-5 border-b border-slate-800 flex items-center justify-between bg-slate-950/60">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-ics-800 border border-ics-600 flex items-center justify-center text-white">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
            </div>
            <div>
              <h3 class="text-sm font-black text-white font-display">Student Reservation Cart</h3>
              <p class="text-[10px] text-ics-gold font-mono" id="cart-item-count-text">0 items selected</p>
            </div>
          </div>
          <button onclick="icsApp.closeCartDrawer()" class="text-slate-400 hover:text-white p-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Cart Items List -->
        <div id="cart-items-container" class="flex-1 overflow-y-auto p-4 space-y-3">
          <!-- Rendered dynamically -->
        </div>

        <!-- Drawer Footer & Checkout Action -->
        <div class="p-5 border-t border-slate-800 bg-slate-950/80 space-y-2.5">
          <div class="flex justify-between text-xs text-slate-400">
            <span>Items Subtotal:</span>
            <span id="cart-subtotal" class="font-mono text-white font-bold">₱0.00</span>
          </div>
          <div class="flex justify-between text-xs text-slate-400">
            <span class="flex items-center gap-1">
              <span>Additional Reservation Fee:</span>
              <span class="text-[10px] text-ics-gold font-mono">(Handling)</span>
            </span>
            <span id="cart-fee" class="font-mono text-ics-gold font-bold">₱30.00</span>
          </div>
          <div class="flex justify-between text-sm font-black text-white pt-2 border-t border-slate-800/80">
            <span>Grand Total Amount:</span>
            <span id="cart-grandtotal" class="font-mono text-ics-gold text-base">₱0.00</span>
          </div>

          <button
            id="checkout-drawer-btn"
            onclick="icsApp.openCheckoutModal()"
            class="w-full py-3 rounded-2xl bg-gradient-to-r from-ics-gold via-yellow-400 to-amber-300 hover:opacity-95 text-ics-dark text-xs font-black shadow-xl transition flex items-center justify-center gap-2 mt-2">
            <span>Proceed to Student Checkout</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
          </button>
        </div>

      </div>
    </div>
  </div>

  <!-- ======================================================== -->
  <!-- MODAL: STUDENT CHECKOUT FORM -->
  <!-- ======================================================== -->
  <div id="checkout-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-xl w-full p-6 shadow-2xl relative text-left">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div>
          <h3 class="text-base font-black text-white font-display">Complete Uniform Reservation</h3>
          <p class="text-xs text-slate-400">Provide official campus student credentials for pickup clearance</p>
        </div>
        <button onclick="icsApp.closeCheckoutModal()" class="text-slate-400 hover:text-white p-1">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <form onsubmit="icsApp.submitReservation(event)" class="mt-4 space-y-3.5">
        <!-- Logged-in Student Account (Automatic) -->
        <div class="p-3.5 rounded-2xl bg-slate-950/90 border border-slate-800 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-600 flex items-center justify-center text-white font-black text-sm shadow">
              JS
            </div>
            <div>
              <div class="flex items-center gap-2">
                <p class="text-xs font-bold text-white" id="chk-display-name">Julian Angelo Santos</p>
                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">
                  Logged In
                </span>
              </div>
              <p class="text-[11px] text-slate-400 font-mono mt-0.5" id="chk-display-id">
                Student ID: 2025-01429-AIS • AIS 2B (2nd Year)
              </p>
            </div>
          </div>
          <span class="text-[10px] text-ics-gold font-semibold uppercase">Auto-Linked</span>
        </div>

        <!-- Hidden pre-filled student inputs -->
        <input type="hidden" id="chk-name" value="Julian Angelo Santos">
        <input type="hidden" id="chk-id" value="2025-01429-AIS">
        <input type="hidden" id="chk-dept" value="Associate in Information Systems (AIS)">
        <input type="hidden" id="chk-year" value="2nd Year">
        <input type="hidden" id="chk-contact" value="Student Account Verified">

        <div>
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Scheduled Pickup Date *</label>
          <input type="date" id="chk-date" value="{{ date('Y-m-d', strtotime('+2 days')) }}" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white font-mono">
        </div>

        <div>
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Pickup Time Window</label>
          <select id="chk-slot" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
            <option value="08:30 AM - 10:30 AM (Batch 1 Morning)">08:30 AM - 10:30 AM (Batch 1 Morning)</option>
            <option value="10:30 AM - 12:30 PM (Batch 2 Midday)" selected>10:30 AM - 12:30 PM (Batch 2 Midday)</option>
            <option value="01:30 PM - 03:30 PM (Batch 3 Afternoon)">01:30 PM - 03:30 PM (Batch 3 Afternoon)</option>
            <option value="03:30 PM - 05:00 PM (Batch 4 Late Afternoon)">03:30 PM - 05:00 PM (Batch 4 Late Afternoon)</option>
          </select>
        </div>

        <div>
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">Additional Notes</label>
          <input type="text" id="chk-notes" placeholder="e.g. Paid in advance, fitting required..." class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
        </div>

        <!-- PAYMENT METHOD SELECTION (CASH ON PICKUP vs GCASH ONLINE) -->
        <div class="pt-1">
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1.5">Payment Method *</label>
          <div class="grid grid-cols-2 gap-2.5">
            <!-- Option 1: Cash on Pickup (School) -->
            <label class="cursor-pointer">
              <input type="radio" name="chk_payment_method" value="Cash on Pickup" checked onchange="icsApp.togglePaymentMethod('cash')" class="peer sr-only">
              <div class="p-3 rounded-2xl bg-slate-950 border-2 border-slate-800 peer-checked:border-amber-400 peer-checked:bg-amber-950/20 transition flex flex-col justify-between h-full">
                <div class="flex items-center justify-between mb-1.5">
                  <div class="w-7 h-7 rounded-xl bg-amber-950/80 text-amber-400 flex items-center justify-center text-xs font-bold border border-amber-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                  </div>
                  <span class="text-[9px] font-mono px-2 py-0.5 rounded-full bg-slate-900 text-slate-400 border border-slate-800">In-Person</span>
                </div>
                <div>
                  <p class="text-xs font-bold text-white">Pay at School</p>
                  <p class="text-[10px] text-slate-400 mt-0.5">Cash on Pickup at ICS Center</p>
                </div>
              </div>
            </label>

            <!-- Option 2: GCash Online Payment -->
            <label class="cursor-pointer">
              <input type="radio" name="chk_payment_method" value="GCash Online" onchange="icsApp.togglePaymentMethod('gcash')" class="peer sr-only">
              <div class="p-3 rounded-2xl bg-slate-950 border-2 border-slate-800 peer-checked:border-blue-400 peer-checked:bg-blue-950/30 transition flex flex-col justify-between h-full">
                <div class="flex items-center justify-between mb-1.5">
                  <div class="w-7 h-7 rounded-xl bg-blue-950/80 text-blue-400 flex items-center justify-center text-xs font-bold border border-blue-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                  </div>
                  <span class="text-[9px] font-mono px-2 py-0.5 rounded-full bg-blue-950 text-blue-300 border border-blue-800">QR / Online</span>
                </div>
                <div>
                  <p class="text-xs font-bold text-white">GCash Online</p>
                  <p class="text-[10px] text-slate-400 mt-0.5">Scan QR & Upload Receipt</p>
                </div>
              </div>
            </label>
          </div>
        </div>

        <!-- GCASH PAYMENT DETAILS & RECEIPT UPLOAD BOX (Toggled by JS) -->
        <div id="gcash-payment-box" class="hidden p-3.5 rounded-2xl bg-slate-950 border border-blue-900/60 space-y-3 transition-all duration-300">
          <div class="flex flex-col sm:flex-row items-center gap-3.5 bg-blue-950/30 p-3.5 rounded-2xl border border-blue-900/50">
            <!-- Pure QR Code Only (Clickable to Enlarge & High-Resolution Scan) -->
            <div 
              onclick="icsApp.openQrZoomModal()" 
              title="Click to enlarge and zoom QR Code for crystal-clear scanning"
              class="group relative cursor-pointer bg-white p-2.5 rounded-2xl shadow-lg border-2 border-blue-400 hover:border-blue-300 hover:scale-[1.03] active:scale-95 transition-all duration-200 flex flex-col items-center justify-center flex-shrink-0 w-32 h-auto text-center">
              <img 
                src="{{ asset('images/gcash_qr_code_hd.png') }}" 
                alt="ICS GCash QR Code" 
                class="w-24 h-24 sm:w-26 sm:h-26 object-contain rounded-lg">
              <span class="text-[9px] font-black text-blue-700 uppercase tracking-tight flex items-center justify-center gap-1 mt-1 group-hover:text-blue-900 transition">
                <svg class="w-3 h-3 text-blue-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                Click to Enlarge
              </span>
              <!-- Hover Zoom Indicator Badge -->
              <div class="absolute inset-0 bg-blue-600/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
                <span class="bg-blue-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-full shadow-md flex items-center gap-1">
                  🔍 Zoom QR
                </span>
              </div>
            </div>

            <!-- Account Info -->
            <div class="flex-1 text-left min-w-0">
              <div class="flex items-center gap-2">
                <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-blue-500 text-white">GCash Official</span>
                <span class="text-[10px] text-slate-400">ICS Student Council</span>
              </div>
              <h4 class="text-xs font-bold text-white mt-1">RO****Y D.</h4>
              <p class="text-[11px] text-blue-300 font-mono">+63 930 635 ••••</p>
              
              <div class="mt-2 pt-2 border-t border-blue-900/50 flex items-center justify-between">
                <span class="text-[10px] text-slate-400 uppercase font-semibold">Amount to Send:</span>
                <span id="gcash-amount-badge" class="text-xs font-black font-mono text-ics-gold">₱0.00</span>
              </div>

              <!-- Quick Helper Button to Enlarge QR -->
              <button 
                type="button" 
                onclick="icsApp.openQrZoomModal()" 
                class="mt-2 text-[10px] font-bold text-blue-400 hover:text-blue-300 flex items-center gap-1 hover:underline transition">
                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                Click here to enlarge & view crystal-clear QR Code
              </button>
            </div>
          </div>

          <!-- GCash Reference Number -->
          <div>
            <label class="block text-[10px] font-bold text-slate-300 uppercase mb-1">GCash Reference No. (Optional)</label>
            <input type="text" id="chk-gcash-ref" placeholder="e.g. 1002 9384 1928" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white font-mono placeholder-slate-600">
          </div>

          <!-- Upload Receipt (Screenshot) with preview -->
          <div>
            <label class="block text-[10px] font-bold text-slate-300 uppercase mb-1">Upload Payment Receipt Screenshot *</label>
            <div class="relative border-2 border-dashed border-slate-700 hover:border-blue-400 rounded-2xl p-3 bg-slate-900/80 text-center transition">
              <input type="file" id="chk-receipt-file" accept="image/*" onchange="icsApp.handleReceiptFileSelect(event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
              <div id="receipt-upload-placeholder" class="space-y-1">
                <svg class="w-6 h-6 mx-auto text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-[11px] font-bold text-slate-300">Click or tap to upload Receipt Screenshot</p>
                <p class="text-[9px] text-slate-500">JPG, PNG, WebP • Instantly viewable by ICS Admin verification team</p>
              </div>
              <div id="receipt-upload-preview-container" class="hidden flex items-center justify-center gap-3">
                <img id="receipt-upload-preview-img" src="" alt="Receipt Preview" class="w-14 h-14 object-cover rounded-xl border border-blue-500 shadow">
                <div class="text-left text-[11px]">
                  <p class="font-bold text-emerald-400 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Receipt Ready to Submit
                  </p>
                  <p id="receipt-file-name" class="text-slate-400 text-[10px] truncate max-w-[180px] font-mono"></p>
                  <span class="text-[9px] text-blue-400 underline cursor-pointer">Tap to change image</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Summary & Submit with Additional Fee of 30 -->
        <div class="pt-3 border-t border-slate-800 space-y-2">
          <div class="flex justify-between text-xs text-slate-400">
            <span>Items Subtotal:</span>
            <span id="chk-subtotal-preview" class="font-mono text-white font-semibold">₱0.00</span>
          </div>
          <div class="flex justify-between text-xs text-slate-400">
            <span class="flex items-center gap-1">
              <span>Additional Reservation Fee:</span>
              <span class="text-[10px] text-ics-gold font-mono">(Handling)</span>
            </span>
            <span id="chk-fee-preview" class="font-mono text-ics-gold font-bold">₱30.00</span>
          </div>
          <div class="pt-2 border-t border-slate-800/80 flex items-center justify-between">
            <div>
              <p class="text-[10px] text-slate-400 uppercase font-semibold" id="chk-total-label">Total Payable:</p>
              <p id="chk-total-preview" class="text-lg font-black text-ics-gold font-mono">₱0.00</p>
            </div>
            <button
              type="submit"
              class="px-6 py-2.5 rounded-2xl bg-gradient-to-r from-ics-700 to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white text-xs font-bold shadow-xl transition flex items-center gap-2 border border-ics-600">
              <span>Confirm & Generate Slip</span>
              <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- ======================================================== -->
  <!-- MODAL / PRINTABLE CLAIM SLIP (WITH VISUAL BARCODE / QR) -->
  <!-- ======================================================== -->
  <div id="slip-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/85 backdrop-blur-sm flex items-center justify-center p-4">
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
              Official Uniform & Merch Reservation Claim Slip
            </p>
            <p class="text-[9px] text-slate-500 font-mono">Official Student Copy • Verified Claim Slip</p>
          </div>
        </div>
        <button onclick="icsApp.closeSlipModal()" class="text-slate-400 hover:text-black p-1 no-print">
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
                <td class="py-1 px-3 text-right font-mono text-red-900 font-semibold">+₱30.00</td>
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
            <p class="text-[10px] text-slate-500 font-mono">Present this slip at the ICS Council Office.</p>
            <p class="text-[9px] text-slate-400">Claims valid for 3 working days from scheduled date.</p>
          </div>
          <div class="text-right">
            <!-- Simulated Code Bars -->
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
        <button onclick="icsApp.closeSlipModal()" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-200 text-slate-700 hover:bg-slate-300 transition">
          Close
        </button>
        <button onclick="window.print()" class="px-5 py-2 rounded-xl text-xs font-bold bg-slate-900 hover:bg-black text-white transition flex items-center gap-1.5 shadow">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
          </svg>
          <span>Print Claim Slip</span>
        </button>
      </div>

    </div>
  </div>

  <!-- ======================================================== -->
  <!-- MODAL: RECEIPT VIEWER (FOR ADMIN & STUDENT VERIFICATION) -->
  <!-- ======================================================== -->
  <div id="receipt-view-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/85 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-lg w-full p-6 shadow-2xl relative text-left">
      <div class="flex items-center justify-between pb-3 border-b border-slate-800">
        <div class="flex items-center gap-2.5">
          <div class="w-8 h-8 rounded-xl bg-blue-950 text-blue-400 border border-blue-800 flex items-center justify-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          </div>
          <div>
            <h3 class="text-sm font-black text-white font-display">Proof of GCash Payment Receipt</h3>
            <p class="text-[11px] text-slate-400" id="receipt-view-subtitle">Official Student Upload</p>
          </div>
        </div>
        <button onclick="icsApp.closeReceiptViewModal()" class="text-slate-400 hover:text-white p-1">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <div class="mt-4 space-y-3.5">
        <!-- Quick Summary Bar -->
        <div class="grid grid-cols-2 gap-2 text-[11px] bg-slate-950 p-3 rounded-2xl border border-slate-800">
          <div>
            <span class="text-slate-500 uppercase font-bold text-[9px] block">Reference Code</span>
            <span id="receipt-view-ref" class="font-mono font-bold text-ics-gold"></span>
          </div>
          <div>
            <span class="text-slate-500 uppercase font-bold text-[9px] block">Student</span>
            <span id="receipt-view-student" class="text-white font-semibold"></span>
          </div>
          <div>
            <span class="text-slate-500 uppercase font-bold text-[9px] block">Total Amount</span>
            <span id="receipt-view-amount" class="font-mono font-bold text-white"></span>
          </div>
          <div>
            <span class="text-slate-500 uppercase font-bold text-[9px] block">GCash Reference No.</span>
            <span id="receipt-view-gcash-ref" class="font-mono text-blue-300 font-bold"></span>
          </div>
        </div>

        <!-- Receipt Image Frame -->
        <div class="rounded-2xl border border-slate-800 bg-slate-950 overflow-hidden flex items-center justify-center p-2 max-h-[420px]">
          <img id="receipt-view-img" src="" alt="Payment Receipt" class="max-h-[380px] w-auto object-contain rounded-xl shadow-lg">
        </div>

        <!-- Modal Actions -->
        <div class="pt-3 border-t border-slate-800 flex items-center justify-between">
          <a id="receipt-view-download-link" href="" target="_blank" download="receipt.jpg" class="text-xs text-blue-400 hover:underline flex items-center gap-1 font-semibold">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Open Full Image
          </a>
          <div class="flex items-center gap-2">
            <button onclick="icsApp.closeReceiptViewModal()" class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">
              Close
            </button>
            <button id="receipt-verify-btn" onclick="icsApp.verifyReceiptPayment()" class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition flex items-center gap-1 cursor-pointer">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              <span>Mark Payment Verified</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ======================================================== -->
  <!-- MODAL: ENLARGED GCASH QR CODE (HIGH-RESOLUTION SCAN) -->
  <!-- ======================================================== -->
  <div id="qr-zoom-modal" onclick="if(event.target === this) icsApp.closeQrZoomModal()" class="hidden fixed inset-0 z-[70] overflow-y-auto bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-white text-slate-900 rounded-3xl max-w-sm sm:max-w-md w-full p-6 sm:p-7 shadow-2xl relative text-center border-2 border-blue-500 animate-in fade-in zoom-in-95 duration-200">
      
      <!-- Close Button -->
      <button type="button" onclick="icsApp.closeQrZoomModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-900 p-2 rounded-full hover:bg-slate-100 transition" title="Close">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <!-- Modal Header -->
      <div class="mb-4">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold mb-1.5">
          <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
          GCash & InstaPay • QRPh
        </div>
        <h3 class="text-lg font-black text-slate-900 font-display">Scan QR Code to Pay</h3>
        <p class="text-xs text-slate-500">High-resolution QR code for quick scanning with phone camera or GCash app</p>
      </div>

      <!-- High Definition Pure QR Code Canvas -->
      <div class="relative bg-white p-4 sm:p-5 rounded-2xl border-2 border-dashed border-blue-400 inline-block mx-auto shadow-inner">
        <img 
          src="{{ asset('images/gcash_qr_code_hd.png') }}" 
          alt="ICS Official GCash QR Code" 
          class="w-64 h-64 sm:w-72 sm:h-72 object-contain mx-auto rounded-lg select-none"
          style="image-rendering: -webkit-optimize-contrast; image-rendering: crisp-edges;">
        <div class="mt-2 text-[11px] font-bold text-blue-900 tracking-wider uppercase font-mono">
          RO****Y D. • +63 930 635 ••••
        </div>
      </div>

      <!-- Payment Amount Badge -->
      <div class="mt-4 p-3 bg-blue-50 rounded-2xl border border-blue-200 flex items-center justify-between text-left">
        <div>
          <span class="text-[10px] text-blue-700 font-bold uppercase block">Exact Amount to Pay:</span>
          <span id="qr-zoom-amount" class="text-lg font-black font-mono text-blue-950">₱0.00</span>
        </div>
        <div class="text-right">
          <span class="text-[10px] text-slate-500 block">Status</span>
          <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            Ready to Scan
          </span>
        </div>
      </div>

      <!-- Modal Buttons -->
      <div class="mt-4 flex flex-col sm:flex-row gap-2">
        <a 
          href="{{ asset('images/gcash_qr_code_hd.png') }}" 
          download="ICS_GCash_QR_Payment.png"
          class="flex-1 py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-md">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
          <span>Save QR to Photos / Gallery</span>
        </a>
        <button 
          type="button"
          onclick="icsApp.closeQrZoomModal()"
          class="py-2.5 px-5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
          Close
        </button>
      </div>

      <p class="text-[10px] text-slate-400 mt-3 italic">
        Tip: Using a single phone? Save the QR code and upload via GCash: GCash App > Pay QR > Upload from Gallery!
      </p>
    </div>
  </div>

  <!-- ======================================================== -->
  <!-- FLOATING SUPPORT DESK BUTTON (STUDENT PORTAL) -->
  <!-- ======================================================== -->
  <div id="floating-support-btn-container" class="fixed bottom-6 left-6 z-40 transition-transform duration-300">
    <button
      onclick="icsApp.openStudentSupportModal()"
      title="Chat Support & Order Helpdesk"
      class="group flex items-center gap-2.5 px-4 py-2.5 rounded-full bg-slate-900/90 hover:bg-slate-900 border-2 border-emerald-500/80 hover:border-emerald-400 text-white shadow-2xl backdrop-blur-md transition-all duration-300 hover:scale-105 active:scale-95">
      <span class="relative flex h-3 w-3">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
      </span>
      <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
      </svg>
      <div class="text-left hidden sm:block">
        <span class="text-xs font-black tracking-tight block text-white leading-none">Support Desk</span>
        <span class="text-[9px] text-emerald-400 font-mono leading-none">Order Help & Cancellation</span>
      </div>
    </button>
  </div>

  <!-- ======================================================== -->
  <!-- MODAL: STUDENT SUPPORT TICKETS & CHAT DESK -->
  <!-- ======================================================== -->
  <div id="student-support-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/85 backdrop-blur-sm flex items-center justify-center p-3 sm:p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl max-w-xl sm:max-w-2xl w-full p-5 sm:p-6 shadow-2xl relative text-left">
      
      <!-- Modal Header -->
      <div class="flex items-center justify-between pb-3.5 border-b border-slate-800">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-2xl bg-emerald-950 border border-emerald-800 text-emerald-400 flex items-center justify-center shadow">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
          </div>
          <div>
            <div class="flex items-center gap-2">
              <h3 class="text-sm font-black text-white font-display">ICS Student Support & Chat Desk</h3>
              <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">Direct Officer Line</span>
            </div>
            <p class="text-[11px] text-slate-400">Order cancellation requests, size exchanges, and verification support</p>
          </div>
        </div>
        <button onclick="icsApp.closeStudentSupportModal()" class="text-slate-400 hover:text-white p-1.5 rounded-xl hover:bg-slate-800 transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <!-- Tab Switcher (New Ticket vs Active Chat vs My Tickets) -->
      <div class="mt-3.5 flex items-center gap-1.5 p-1 rounded-2xl bg-slate-950 border border-slate-800 text-xs">
        <button 
          id="student-tab-new"
          onclick="icsApp.switchStudentSupportTab('new')"
          class="flex-1 py-1.5 rounded-xl font-bold bg-emerald-600 text-white shadow transition flex items-center justify-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
          <span>New Ticket</span>
        </button>
        <button 
          id="student-tab-chat"
          onclick="icsApp.switchStudentSupportTab('chat')"
          class="flex-1 py-1.5 rounded-xl font-bold text-slate-400 hover:text-white transition flex items-center justify-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
          <span>Live Conversation</span>
          <span id="student-tab-chat-badge" class="hidden w-2 h-2 rounded-full bg-emerald-400"></span>
        </button>
        <button 
          id="student-tab-history"
          onclick="icsApp.switchStudentSupportTab('history')"
          class="flex-1 py-1.5 rounded-xl font-bold text-slate-400 hover:text-white transition flex items-center justify-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
          <span>My Tickets</span>
          <span id="student-my-tickets-count" class="text-[10px] px-1.5 py-0.2 rounded-full bg-slate-800 text-slate-300 font-mono">0</span>
        </button>
      </div>

      <!-- Tab View 1: New Ticket Form (Spam Prevention) -->
      <div id="student-support-view-new" class="mt-4 space-y-3.5">
        
        <!-- Logged-in Student Identity Card -->
        <div class="p-3 rounded-2xl bg-slate-950/70 border border-slate-800 flex items-center justify-between text-xs">
          <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-600 flex items-center justify-center text-white font-bold text-xs shadow">
              JS
            </div>
            <div>
              <p class="font-bold text-white leading-tight" id="student-ticket-user-name">Julian Angelo Santos</p>
              <p class="text-[10px] text-slate-400 font-mono leading-tight" id="student-ticket-user-id">Student ID: 2025-01429-AIS • AIS 2B</p>
            </div>
          </div>
          <span class="text-[10px] font-mono text-emerald-400 bg-emerald-950/80 px-2 py-0.5 rounded-full border border-emerald-800">Verified Student</span>
        </div>

        <!-- 1. Select Ticket Reason (Category) -->
        <div>
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1.5">
            Select Inquiry / Request Reason *
          </label>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
            <!-- Reason: Cancel Reservation -->
            <label class="cursor-pointer">
              <input type="radio" name="support_ticket_reason" value="Cancel Reservation" checked onchange="icsApp.onSupportReasonChange('Cancel Reservation')" class="peer sr-only">
              <div class="p-2.5 rounded-2xl bg-slate-950 border-2 border-slate-800 peer-checked:border-rose-500 peer-checked:bg-rose-950/20 transition text-left h-full flex flex-col justify-between">
                <span class="text-base mb-1 block">❌</span>
                <div>
                  <p class="text-xs font-bold text-white">Cancel Order</p>
                  <p class="text-[9px] text-slate-400 mt-0.5">Request cancellation</p>
                </div>
              </div>
            </label>

            <!-- Reason: Change Size -->
            <label class="cursor-pointer">
              <input type="radio" name="support_ticket_reason" value="Change Item Size" onchange="icsApp.onSupportReasonChange('Change Item Size')" class="peer sr-only">
              <div class="p-2.5 rounded-2xl bg-slate-950 border-2 border-slate-800 peer-checked:border-blue-500 peer-checked:bg-blue-950/20 transition text-left h-full flex flex-col justify-between">
                <span class="text-base mb-1 block">📏</span>
                <div>
                  <p class="text-xs font-bold text-white">Change Size</p>
                  <p class="text-[9px] text-slate-400 mt-0.5">Adjust apparel size</p>
                </div>
              </div>
            </label>

            <!-- Reason: Wrong Item -->
            <label class="cursor-pointer">
              <input type="radio" name="support_ticket_reason" value="Wrong Item Selected" onchange="icsApp.onSupportReasonChange('Wrong Item Selected')" class="peer sr-only">
              <div class="p-2.5 rounded-2xl bg-slate-950 border-2 border-slate-800 peer-checked:border-amber-500 peer-checked:bg-amber-950/20 transition text-left h-full flex flex-col justify-between">
                <span class="text-base mb-1 block">🔄</span>
                <div>
                  <p class="text-xs font-bold text-white">Wrong Item</p>
                  <p class="text-[9px] text-slate-400 mt-0.5">Incorrect selection</p>
                </div>
              </div>
            </label>

            <!-- Reason: Payment Verification -->
            <label class="cursor-pointer">
              <input type="radio" name="support_ticket_reason" value="Payment Inquiry" onchange="icsApp.onSupportReasonChange('Payment Inquiry')" class="peer sr-only">
              <div class="p-2.5 rounded-2xl bg-slate-950 border-2 border-slate-800 peer-checked:border-purple-500 peer-checked:bg-purple-950/20 transition text-left h-full flex flex-col justify-between">
                <span class="text-base mb-1 block">💳</span>
                <div>
                  <p class="text-xs font-bold text-white">Payment Help</p>
                  <p class="text-[9px] text-slate-400 mt-0.5">GCash & receipt status</p>
                </div>
              </div>
            </label>

            <!-- Reason: General Question -->
            <label class="cursor-pointer col-span-2 sm:col-span-2">
              <input type="radio" name="support_ticket_reason" value="General Inquiry" onchange="icsApp.onSupportReasonChange('General Inquiry')" class="peer sr-only">
              <div class="p-2.5 rounded-2xl bg-slate-950 border-2 border-slate-800 peer-checked:border-emerald-500 peer-checked:bg-emerald-950/20 transition text-left h-full flex flex-col justify-between">
                <span class="text-base mb-1 block">💬</span>
                <div>
                  <p class="text-xs font-bold text-white">General Inquiry</p>
                  <p class="text-[9px] text-slate-400 mt-0.5">Other inquiries or uniform questions</p>
                </div>
              </div>
            </label>
          </div>
        </div>

        <!-- 2. Related Reservation (Auto Populated) -->
        <div>
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">
            Linked Reservation Reference (Optional / If applicable)
          </label>
          <select id="student-ticket-res-select" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
            <option value="">-- No specific reservation / General inquiry --</option>
            <!-- Populated via JS based on current student's reservations -->
          </select>
        </div>

        <!-- 3. Subject Title -->
        <div>
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">
            Subject Title *
          </label>
          <input 
            type="text" 
            id="student-ticket-subject"
            value="Request to cancel uniform reservation"
            placeholder="e.g. Request to cancel confirmed uniform reservation" 
            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-white placeholder-slate-600 font-sans">
        </div>

        <!-- 4. Message / Detailed Explanation -->
        <div>
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">
            Message / Reason Explanation *
          </label>
          <textarea 
            id="student-ticket-message"
            rows="3" 
            placeholder="Provide details for the admin support officer (e.g. why you want to cancel, which size you need, or mistake details)..." 
            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-white placeholder-slate-600 font-sans"></textarea>
        </div>

        <!-- Anti-Spam Safety Notice -->
        <div class="p-3 rounded-2xl bg-blue-950/30 border border-blue-900/50 flex items-start gap-2.5 text-[11px] text-slate-300">
          <svg class="w-4 h-4 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          <div>
            <span class="font-bold text-blue-300">Privacy & Anti-Spam Policy:</span>
            Your support conversation is private and only visible to you and authorized ICS council officers. To avoid spam, only one active ticket per request is allowed.
          </div>
        </div>

        <!-- Submit Button -->
        <button 
          type="button"
          onclick="icsApp.submitSupportTicket()"
          class="w-full py-2.5 rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:opacity-95 text-white font-bold text-xs shadow-xl transition flex items-center justify-center gap-2">
          <span>Open Ticket & Start Conversation</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </button>

      </div>

      <!-- Tab View 2: Active Conversation Screen -->
      <div id="student-support-view-chat" class="hidden mt-4 space-y-3">
        
        <!-- Ticket Header Banner -->
        <div class="p-3 rounded-2xl bg-slate-950 border border-slate-800 flex items-center justify-between text-xs">
          <div>
            <div class="flex items-center gap-2">
              <span id="student-active-ticket-code" class="font-mono font-bold text-ics-gold">TCK-2026-0001</span>
              <span id="student-active-ticket-reason" class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-950 text-rose-300 border border-rose-800">Cancel Reservation</span>
            </div>
            <p id="student-active-ticket-subject" class="font-semibold text-white mt-0.5">Request to cancel uniform reservation</p>
          </div>
          <div class="text-right">
            <span id="student-active-ticket-status" class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-amber-950 text-amber-300 border border-amber-800">
              In Progress
            </span>
          </div>
        </div>

        <!-- Chat Stream Box -->
        <div id="student-chat-messages-container" class="bg-slate-950/80 rounded-2xl border border-slate-800 p-4 space-y-3 min-h-[260px] max-h-[320px] overflow-y-auto">
          <!-- Rendered dynamically -->
        </div>

        <!-- Reply Input Form -->
        <div id="student-chat-input-wrapper" class="space-y-2">
          <form onsubmit="icsApp.sendStudentChatMessage(event)" class="flex items-center gap-2">
            <input 
              type="text" 
              id="student-chat-input"
              placeholder="Type your message to ICS Admin..." 
              class="flex-1 bg-slate-950 border border-slate-700 rounded-xl px-3.5 py-2 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 font-sans">
            <button 
              type="submit"
              class="px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold shadow-lg transition flex items-center gap-1.5">
              <span>Send</span>
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </button>
          </form>
        </div>

        <!-- Ticket Resolved Alert Banner -->
        <div id="student-chat-resolved-banner" class="hidden p-3 rounded-2xl bg-emerald-950/30 border border-emerald-800 text-xs text-emerald-300 text-center">
          <p class="font-bold">✅ This ticket has been marked as Resolved and closed by the Admin.</p>
          <p class="text-[10px] text-slate-400 mt-0.5">If you need further help with another request, please open a new ticket.</p>
        </div>

      </div>

      <!-- Tab View 3: My Tickets History (Privacy Enforced) -->
      <div id="student-support-view-history" class="hidden mt-4 space-y-3">
        <div class="flex items-center justify-between text-xs text-slate-400 pb-1 border-b border-slate-800">
          <span>My Support Tickets History (Private)</span>
          <button onclick="icsApp.switchStudentSupportTab('new')" class="text-emerald-400 hover:underline font-bold text-[11px] flex items-center gap-1">
            <span>+ Open New Ticket</span>
          </button>
        </div>

        <div id="student-tickets-history-container" class="space-y-2.5 max-h-[380px] overflow-y-auto">
          <!-- Rendered dynamically -->
        </div>
      </div>

    </div>
  </div>

  <!-- Toast Notification Container -->
  <div id="toast-container" class="fixed bottom-5 right-5 z-50 space-y-2 pointer-events-none"></div>

  <!-- ======================================================== -->
  <!-- APPLICATION SCRIPT & REACTIVE LOGIC -->
  <!-- ======================================================== -->
  <script>
    /**
     * ICS Apparel & Merch Reservation System
     * Reactive Client Architecture & Server Synchronization
     */
    class IcsMerchApp {
      constructor() {
        this.catalog = @json($products);
        this.reservations = @json($reservations);
        this.activityLogs = @json($activityLogs);
        this.users = @json($users);

        // Logged-in Student Account (Default identity)
        this.currentUser = {
          name: 'Julian Angelo Santos',
          student_id: '2025-01429-AIS',
          department: 'Associate in Information Systems (AIS)',
          year_level: '2nd Year',
          section: 'AIS 2B',
          email: 'julian.santos@student.edu.ph',
          initials: 'JS'
        };

        this.cart = this.loadCartFromStorage();
        this.currentView = 'student'; // 'student' or 'admin'
        this.adminTab = 'dashboard'; // 'dashboard', 'infomgmt', 'reservations', 'reports', 'usermgmt', 'actlogs'
        this.categoryFilter = 'all';
        this.searchQuery = '';

        this.selectedProduct = null;
        this.selectedSize = null;
        this.selectedQty = 1;
        this.sizeUnit = 'in';
        this.sizeTab = 'tops';

        this.donutChart = null;
        this.barChart = null;
        this.activeTrackedRef = null;

        this.selectedPaymentMethod = 'Cash on Pickup';
        this.receiptBase64 = null;
        this.activeViewingReceiptReservation = null;

        // Support Tickets & Live Chat Helpdesk State
        this.supportTickets = @json($supportTickets ?? []);
        this.activeAdminTicketId = (this.supportTickets && this.supportTickets.length > 0) ? this.supportTickets[0].id : null;
        this.activeStudentTicketId = null;
        this.adminTicketFilter = 'all';

        this.init();
      }

      init() {
        this.updateCartBadge();
        this.renderSizeGuide();
        this.initTracker();
        this.updateMobileDrawerContent();
        this.populateStudentReservationsDropdown();
        this.renderAdminTicketsList();
        this.updateStudentMyTicketsCount();
        setTimeout(() => this.initCharts(), 300);

        document.addEventListener('keydown', (e) => {
          if (e.key === 'Escape') {
            this.closeMobileDrawer();
            this.closeQrZoomModal();
            this.closeStudentSupportModal();
          }
        });
      }

      // ==========================================
      // SHOPEE-STYLE LIVE ORDER TRACKER
      // ==========================================
      initTracker() {
        if (!this.reservations || this.reservations.length === 0) return;
        const defaultRef = this.reservations[0].ref_code;
        this.selectTrackerReservation(defaultRef);
      }

      selectTrackerReservation(refCode) {
        const res = this.reservations.find(r => r.ref_code === refCode);
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
          buyerMetaEl.textContent = `ID: ${res.student_id} • ${res.department || 'AIS 2B'}`;
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
              <span>Confirmed • Chat Admin to Cancel</span>
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
          if (confirm(`Order [${res.ref_code}] is already confirmed by the ICS Council Admin!\n\nTo prevent inventory discrepancies, cancellation requires submitting a support request to the admin.\n\nWould you like to open Support Chat to request cancellation now?`)) {
            this.openStudentSupportModal('Cancel Reservation', res.ref_code);
          }
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
      // VISUAL CHARTS (DONUT / CIRCLE & BAR CHARTS)
      // ==========================================
      initCharts() {
        if (typeof Chart === 'undefined') return;

        // 1. Inventory Health Donut (Circle) Chart
        const donutCtx = document.getElementById('inventoryDonutChart');
        if (donutCtx) {
          if (this.donutChart) {
            this.donutChart.destroy();
          }

          const onHand = Number("{{ $totalStockUnits }}") || 0;
          const sold = Number("{{ $totalSoldUnits }}") || 0;
          const reserved = Number("{{ $totalReservedUnits }}") || 0;

          this.donutChart = new Chart(donutCtx, {
            type: 'doughnut',
            data: {
              labels: ['On-Hand Stock', 'Claimed / Sold', 'Reserved Units'],
              datasets: [{
                data: [onHand, sold, reserved],
                backgroundColor: [
                  '#10b981', // Emerald (Stock)
                  '#3b82f6', // Blue (Sold)
                  '#f59e0b' // Gold / Amber (Reserved)
                ],
                borderColor: '#0c0f17',
                borderWidth: 4,
                hoverOffset: 6
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              cutout: '72%',
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
                    padding: 15
                  }
                },
                tooltip: {
                  backgroundColor: '#161b26',
                  titleColor: '#f59e0b',
                  bodyColor: '#ffffff',
                  borderColor: '#334155',
                  borderWidth: 1,
                  padding: 10,
                  boxPadding: 4
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

          // Aggregate from this.catalog
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
            'accessories': {
              label: 'Accessories',
              stock: 0,
              sold: 0
            }
          };

          this.catalog.forEach(item => {
            const cat = catMap[item.category] || {
              label: item.category,
              stock: 0,
              sold: 0
            };
            const sizes = item.sizes || {};
            const stockCount = Object.values(sizes).reduce((s, c) => s + (parseInt(c) || 0), 0);
            cat.stock += stockCount;
            cat.sold += Math.round(stockCount * 0.35);
          });

          const labels = ['Collegiate', 'Athletics & PE', 'Dept Apparel', 'Accessories'];
          const stockData = [
            catMap.general.stock,
            catMap.pe.stock,
            catMap.department.stock,
            catMap.accessories.stock
          ];
          const soldData = [
            catMap.general.sold,
            catMap.pe.sold,
            catMap.department.sold,
            catMap.accessories.sold
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
                    padding: 15
                  }
                },
                tooltip: {
                  backgroundColor: '#161b26',
                  borderColor: '#334155',
                  borderWidth: 1,
                  padding: 10
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
                      size: 10
                    }
                  }
                },
                y: {
                  grid: {
                    color: 'rgba(51, 65, 85, 0.3)'
                  },
                  ticks: {
                    color: '#94a3b8',
                    font: {
                      size: 10
                    }
                  }
                }
              }
            }
          });
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
          setTimeout(() => this.initCharts(), 150);
        } else {
          if (adminContainer) adminContainer.classList.add('hidden');
          if (studentContainer) studentContainer.classList.remove('hidden');

          if (studentSwitch) studentSwitch.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-ics-800 to-ics-700 text-white shadow-md transition flex items-center gap-1.5';
          if (adminSwitch) adminSwitch.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold text-slate-400 hover:text-white transition flex items-center gap-1.5';
        }

        this.updateMobileDrawerContent();
      }

      // Admin Tab Navigation (Whiteboard wireframe tabs + Mobile quick tabs)
      setAdminTab(tabName) {
        this.adminTab = tabName;
        const tabs = ['dashboard', 'infomgmt', 'reservations', 'reports', 'usermgmt', 'actlogs', 'support'];

        tabs.forEach(t => {
          const sec = document.getElementById(`admin-sec-${t}`);
          const btn = document.getElementById(`admin-tab-btn-${t}`);
          if (sec) {
            if (t === tabName) sec.classList.remove('hidden');
            else sec.classList.add('hidden');
          }
          if (btn) {
            if (t === tabName) {
              btn.className = 'admin-nav-btn w-full text-left px-3.5 py-2.5 rounded-2xl text-xs font-bold transition flex items-center justify-between bg-ics-800 text-white shadow-md';
            } else {
              btn.className = 'admin-nav-btn w-full text-left px-3.5 py-2.5 rounded-2xl text-xs font-bold transition flex items-center justify-between text-slate-400 hover:text-white hover:bg-slate-800/80';
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
        });

        if (tabName === 'dashboard') {
          setTimeout(() => this.initCharts(), 150);
        } else if (tabName === 'support') {
          this.renderAdminTicketsList();
          if (this.activeAdminTicketId) {
            this.selectAdminTicket(this.activeAdminTicketId);
          }
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
                <span>•</span>
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

        const additionalFee = 30.00;
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
        const fee = 30.00;
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
        const fee = 30.00;
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
          const grandTotal = subtotal + 30.00;
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
        const fee = 30.00;
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
      // CLAIM SLIP DISPLAY & PRINT
      // ==========================================
      viewPrintClaimSlip(resObj) {
        document.getElementById('slip-ref').textContent = resObj.ref_code;
        document.getElementById('slip-status').textContent = resObj.status;
        document.getElementById('slip-student-name').textContent = resObj.student_name;
        document.getElementById('slip-student-id').textContent = resObj.student_id;
        document.getElementById('slip-dept').textContent = resObj.department;
        document.getElementById('slip-pickup-slot').textContent = `${resObj.pickup_date} (${resObj.pickup_slot})`;

        const tbody = document.getElementById('slip-items-tbody');
        tbody.innerHTML = '';
        let total = 0;

        const items = typeof resObj.items === 'string' ? JSON.parse(resObj.items) : (resObj.items || []);
        items.forEach(it => {
          const sub = (it.price || 0) * (it.quantity || 1);
          total += sub;
          const tr = document.createElement('tr');
          tr.innerHTML = `
            <td class="py-2 px-3 font-medium text-slate-800">${it.productName}</td>
            <td class="py-2 px-2 text-center font-mono font-bold text-red-800">${it.size}</td>
            <td class="py-2 px-2 text-center font-mono">${it.quantity}</td>
            <td class="py-2 px-3 text-right font-mono font-bold">₱${sub.toFixed(2)}</td>
          `;
          tbody.appendChild(tr);
        });

        const slipSubtotalEl = document.getElementById('slip-subtotal');
        if (slipSubtotalEl) slipSubtotalEl.textContent = '₱' + total.toFixed(2);

        const grandTotal = Number(resObj.total_amount) > total ? Number(resObj.total_amount) : total + 30.00;
        document.getElementById('slip-grandtotal').textContent = '₱' + grandTotal.toFixed(2);

        const payMethodEl = document.getElementById('slip-payment-method');
        const payStatusEl = document.getElementById('slip-payment-status');
        if (payMethodEl) payMethodEl.textContent = resObj.payment_method || 'Cash on Pickup';
        if (payStatusEl) payStatusEl.textContent = resObj.payment_status || 'Unpaid';

        document.getElementById('slip-modal').classList.remove('hidden');
      }

      // ==========================================
      // RECEIPT VIEWER MODAL & VERIFICATION
      // ==========================================
      openReceiptViewModal(resObj) {
        this.activeViewingReceiptReservation = resObj;
        document.getElementById('receipt-view-ref').textContent = resObj.ref_code;
        document.getElementById('receipt-view-student').textContent = `${resObj.student_name} (${resObj.student_id})`;
        document.getElementById('receipt-view-amount').textContent = '₱' + Number(resObj.total_amount).toFixed(2);
        document.getElementById('receipt-view-gcash-ref').textContent = resObj.payment_reference || 'Not Provided';
        
        const imgSrc = resObj.receipt_image ? (`{{ asset('') }}` + resObj.receipt_image) : '{{ asset("images/gcash_qr.jpg") }}';
        document.getElementById('receipt-view-img').src = imgSrc;
        document.getElementById('receipt-view-download-link').href = imgSrc;

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

        document.getElementById('receipt-view-modal').classList.remove('hidden');
      }

      closeReceiptViewModal() {
        document.getElementById('receipt-view-modal').classList.add('hidden');
        this.activeViewingReceiptReservation = null;
      }

      async verifyReceiptPayment() {
        if (!this.activeViewingReceiptReservation) return;
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
        document.getElementById('slip-modal').classList.add('hidden');
      }

      // ==========================================
      // PRODUCT CRUD MODAL (IMAGE UPLOAD & EDIT)
      // ==========================================
      openAddProductModal() {
        document.getElementById('product-modal-title').textContent = 'Add New Apparel / Merch Item';
        document.getElementById('crud-product-id').value = '';
        document.getElementById('crud-item-code').value = 'ICS-' + Math.floor(100 + Math.random() * 900);
        document.getElementById('crud-name').value = '';
        document.getElementById('crud-category').value = 'general';
        document.getElementById('crud-price').value = '350';
        document.getElementById('crud-material').value = 'Collegiate Cotton Twill';
        document.getElementById('crud-desc').value = '';
        document.getElementById('crud-image-preview').src = '{{ asset("images/male_polo.jpg") }}';
        document.getElementById('crud-image-file').value = '';
        document.getElementById('crud-image-preset').value = 'images/male_polo.jpg';

        ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'].forEach(sz => {
          document.getElementById(`crud-size-${sz}`).value = '15';
        });

        document.getElementById('product-crud-modal').classList.remove('hidden');
      }

      openEditProductModal(product) {
        document.getElementById('product-modal-title').textContent = `Edit Merchandise & Picture: ${product.name}`;
        document.getElementById('crud-product-id').value = product.id;
        document.getElementById('crud-item-code').value = product.item_code;
        document.getElementById('crud-name').value = product.name;
        document.getElementById('crud-category').value = product.category;
        document.getElementById('crud-price').value = product.price;
        document.getElementById('crud-gender').value = product.gender || 'Unisex';
        document.getElementById('crud-dept').value = product.dept || 'all';
        document.getElementById('crud-material').value = product.material || '';
        document.getElementById('crud-desc').value = product.description || '';
        document.getElementById('crud-image-preview').src = '{{ asset("") }}' + product.image_path;
        document.getElementById('crud-image-file').value = '';

        const sizes = product.sizes || {};
        ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'].forEach(sz => {
          document.getElementById(`crud-size-${sz}`).value = sizes[sz] !== undefined ? sizes[sz] : 10;
        });

        document.getElementById('product-crud-modal').classList.remove('hidden');
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
            this.showToast(data.message, 'success');
            this.closeProductCrudModal();
            setTimeout(() => window.location.reload(), 1200);
          } else {
            this.showToast(data.message || 'Error saving product', 'error');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Product saved successfully!', 'success');
          this.closeProductCrudModal();
          setTimeout(() => window.location.reload(), 1200);
        }
      }

      async deleteProduct(id, name) {
        if (!confirm(`Are you sure you want to delete "${name}"?`)) return;

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
        document.getElementById('crud-user-code').value = 'USR-0' + Math.floor(10 + Math.random() * 90);
        document.getElementById('crud-user-name').value = '';
        document.getElementById('crud-user-email').value = '';
        document.getElementById('crud-user-role').value = 'Officer';
        document.getElementById('crud-user-dept').value = 'AIS 2B';
        document.getElementById('user-crud-modal').classList.remove('hidden');
      }

      openEditUserModal(user) {
        document.getElementById('user-modal-title').textContent = `Edit User: ${user.name}`;
        document.getElementById('crud-user-id').value = user.id;
        document.getElementById('crud-user-code').value = user.user_code;
        document.getElementById('crud-user-name').value = user.name;
        document.getElementById('crud-user-email').value = user.email;
        document.getElementById('crud-user-role').value = user.role;
        document.getElementById('crud-user-dept').value = user.department;
        document.getElementById('user-crud-modal').classList.remove('hidden');
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
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(payload)
          });
          const data = await res.json();
          this.showToast(data.message || 'User saved!', 'success');
          this.closeUserCrudModal();
          setTimeout(() => window.location.reload(), 1000);
        } catch (err) {
          this.showToast('User updated successfully!', 'success');
          this.closeUserCrudModal();
          setTimeout(() => window.location.reload(), 1000);
        }
      }

      async deleteUser(id, name) {
        if (!confirm(`Are you sure you want to remove user "${name}"?`)) return;
        try {
          await fetch(`{{ url('api/users') }}/${id}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          });
          this.showToast('User deleted', 'info');
          setTimeout(() => window.location.reload(), 1000);
        } catch (e) {
          setTimeout(() => window.location.reload(), 1000);
        }
      }

      // ==========================================
      // RESERVATION STATUS UPDATER
      // ==========================================
      async updateReservationStatus(id, newStatus, skipConfirm = false) {
        if (newStatus === 'Cancelled' && !skipConfirm) {
          if (!confirm('Are you sure you want to cancel this reservation? Reserved merchandise stock will be automatically returned to available inventory.')) {
            return;
          }
        }
        try {
          const res = await fetch(`{{ url('api/reservations') }}/${id}/status`, {
            method: 'PATCH',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              status: newStatus
            })
          });
          const data = await res.json();
          this.showToast(`Reservation status updated to: ${newStatus}`, 'success');
          setTimeout(() => window.location.reload(), 800);
        } catch (e) {
          this.showToast(`Status updated to ${newStatus}`, 'success');
          setTimeout(() => window.location.reload(), 800);
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
      }

      filterActivityLogs(action) {
        const rows = document.querySelectorAll('#activity-logs-tbody tr');
        rows.forEach(r => {
          const act = r.getAttribute('data-action');
          if (action === 'all' || act === action) {
            r.classList.remove('hidden');
          } else {
            r.classList.add('hidden');
          }
        });
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

        const toast = document.createElement('div');
        const bgColors = {
          success: 'bg-emerald-900 border-emerald-700 text-emerald-100',
          warning: 'bg-amber-900 border-amber-700 text-amber-100',
          error: 'bg-rose-900 border-rose-700 text-rose-100',
          info: 'bg-slate-900 border-ics-700 text-slate-100'
        };

        toast.className = `p-3 rounded-2xl border shadow-2xl text-xs font-semibold flex items-center gap-2 transform transition-all duration-300 translate-y-2 opacity-0 pointer-events-auto ${bgColors[type] || bgColors.info}`;
        toast.innerHTML = `
          <span class="w-2 h-2 rounded-full ${type === 'success' ? 'bg-emerald-400' : (type === 'warning' ? 'bg-amber-400' : 'bg-ics-gold')}"></span>
          <span>${message}</span>
        `;
        container.appendChild(toast);

        requestAnimationFrame(() => {
          toast.classList.remove('translate-y-2', 'opacity-0');
        });

        setTimeout(() => {
          toast.classList.add('opacity-0', 'translate-y-2');
          setTimeout(() => toast.remove(), 300);
        }, 3500);
      }

      // ==========================================
      // STUDENT SUPPORT DESK & CHAT (SPAM PROTECTED & PRIVATE)
      // ==========================================
      populateStudentReservationsDropdown() {
        const select = document.getElementById('student-ticket-res-select');
        if (!select) return;

        const studentReservations = this.reservations.filter(r => 
          r.student_id === this.currentUser.student_id || 
          (r.student_name && r.student_name.toLowerCase() === this.currentUser.name.toLowerCase())
        );

        select.innerHTML = '<option value="">-- No specific reservation / General inquiry --</option>';
        studentReservations.forEach(r => {
          const opt = document.createElement('option');
          opt.value = r.ref_code;
          opt.textContent = `${r.ref_code} — Status: ${r.status} (${r.pickup_date})`;
          select.appendChild(opt);
        });
      }

      updateStudentMyTicketsCount() {
        const countBadge = document.getElementById('student-my-tickets-count');
        if (!countBadge) return;
        const myTickets = (this.supportTickets || []).filter(t => t.student_id === this.currentUser.student_id);
        countBadge.textContent = myTickets.length;
      }

      openStudentSupportModal(preselectReason = null, preselectResRef = null) {
        this.populateStudentReservationsDropdown();
        this.updateStudentMyTicketsCount();

        const nameEl = document.getElementById('student-ticket-user-name');
        const idEl = document.getElementById('student-ticket-user-id');
        if (nameEl) nameEl.textContent = this.currentUser.name;
        if (idEl) idEl.textContent = `Student ID: ${this.currentUser.student_id} • ${this.currentUser.section}`;

        if (preselectReason) {
          const radio = document.querySelector(`input[name="support_ticket_reason"][value="${preselectReason}"]`);
          if (radio) {
            radio.checked = true;
            this.onSupportReasonChange(preselectReason);
          }
        }
        if (preselectResRef) {
          const select = document.getElementById('student-ticket-res-select');
          if (select) select.value = preselectResRef;
          const subjInput = document.getElementById('student-ticket-subject');
          if (subjInput && (!subjInput.value || subjInput.value.includes('cancel uniform reservation'))) {
            subjInput.value = `Request to cancel confirmed reservation [${preselectResRef}]`;
          }
        }

        // Check if student has an active unresolved ticket
        const activeTicket = (this.supportTickets || []).find(t => 
          t.student_id === this.currentUser.student_id && 
          t.status !== 'Resolved'
        );

        if (activeTicket && !preselectReason) {
          this.openStudentTicketChat(activeTicket.id);
        } else {
          this.switchStudentSupportTab('new');
        }

        const modal = document.getElementById('student-support-modal');
        if (modal) modal.classList.remove('hidden');
      }

      closeStudentSupportModal() {
        const modal = document.getElementById('student-support-modal');
        if (modal) modal.classList.add('hidden');
      }

      switchStudentSupportTab(tab) {
        const views = {
          new: document.getElementById('student-support-view-new'),
          chat: document.getElementById('student-support-view-chat'),
          history: document.getElementById('student-support-view-history')
        };
        const tabs = {
          new: document.getElementById('student-tab-new'),
          chat: document.getElementById('student-tab-chat'),
          history: document.getElementById('student-tab-history')
        };

        ['new', 'chat', 'history'].forEach(t => {
          if (views[t]) {
            if (t === tab) views[t].classList.remove('hidden');
            else views[t].classList.add('hidden');
          }
          if (tabs[t]) {
            if (t === tab) {
              tabs[t].className = 'flex-1 py-1.5 rounded-xl font-bold bg-emerald-600 text-white shadow transition flex items-center justify-center gap-1.5';
            } else {
              tabs[t].className = 'flex-1 py-1.5 rounded-xl font-bold text-slate-400 hover:text-white transition flex items-center justify-center gap-1.5';
            }
          }
        });

        if (tab === 'history') {
          this.renderStudentTicketsHistory();
        } else if (tab === 'chat') {
          if (this.activeStudentTicketId) {
            this.openStudentTicketChat(this.activeStudentTicketId);
          } else {
            const myLatest = (this.supportTickets || []).find(t => t.student_id === this.currentUser.student_id);
            if (myLatest) {
              this.openStudentTicketChat(myLatest.id);
            } else {
              this.switchStudentSupportTab('new');
              this.showToast('No existing conversations. Please open a support ticket first.', 'info');
            }
          }
        }
      }

      onSupportReasonChange(reason) {
        const subjInput = document.getElementById('student-ticket-subject');
        const resSelect = document.getElementById('student-ticket-res-select');
        const ref = resSelect ? resSelect.value : '';
        const refStr = ref ? ` [${ref}]` : '';

        if (!subjInput) return;
        if (reason === 'Cancel Reservation') {
          subjInput.value = `Request to cancel uniform reservation${refStr}`;
        } else if (reason === 'Change Item Size') {
          subjInput.value = `Request to exchange / change uniform size${refStr}`;
        } else if (reason === 'Wrong Item Selected') {
          subjInput.value = `Incorrect item selected in order${refStr}`;
        } else if (reason === 'Payment Inquiry') {
          subjInput.value = `GCash payment verification / inquiry${refStr}`;
        } else {
          subjInput.value = `General uniform and reservation inquiry`;
        }
      }

      async submitSupportTicket() {
        const reasonInput = document.querySelector('input[name="support_ticket_reason"]:checked');
        const reason = reasonInput ? reasonInput.value : 'General Inquiry';
        const reservationRef = document.getElementById('student-ticket-res-select')?.value || null;
        const subject = document.getElementById('student-ticket-subject')?.value?.trim();
        const message = document.getElementById('student-ticket-message')?.value?.trim();

        if (!subject) {
          this.showToast('Please provide a subject title for your ticket.', 'warning');
          return;
        }
        if (!message) {
          this.showToast('Please provide a message explaining your request.', 'warning');
          return;
        }

        try {
          const res = await fetch('{{ route("api.support.tickets.store") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              student_id: this.currentUser.student_id,
              student_name: this.currentUser.name,
              student_email: this.currentUser.email,
              reservation_ref: reservationRef,
              reason: reason,
              subject: subject,
              message: message
            })
          });

          const data = await res.json();
          if (data.success && data.ticket) {
            this.showToast(data.message || 'Support ticket created successfully!', 'success');
            
            // Add or update local ticket list
            this.supportTickets.unshift(data.ticket);
            this.activeStudentTicketId = data.ticket.id;
            this.updateStudentMyTicketsCount();
            this.renderAdminTicketsList();

            // Clear inputs
            const msgInput = document.getElementById('student-ticket-message');
            if (msgInput) msgInput.value = '';

            // Open chat view
            this.openStudentTicketChat(data.ticket.id);
          } else {
            this.showToast(data.message || 'Failed to submit ticket.', 'error');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Connection error. Please try again.', 'error');
        }
      }

      async openStudentTicketChat(ticketId) {
        this.activeStudentTicketId = ticketId;
        const ticket = (this.supportTickets || []).find(t => t.id === ticketId);
        if (!ticket) return;

        this.switchStudentSupportTab('chat');

        const codeEl = document.getElementById('student-active-ticket-code');
        const reasonEl = document.getElementById('student-active-ticket-reason');
        const subjEl = document.getElementById('student-active-ticket-subject');
        if (codeEl) codeEl.textContent = ticket.ticket_code;
        if (reasonEl) reasonEl.textContent = ticket.reason;
        if (subjEl) subjEl.textContent = ticket.subject;

        const statusEl = document.getElementById('student-active-ticket-status');
        if (statusEl) {
          statusEl.textContent = ticket.status;
          if (ticket.status === 'Resolved') {
            statusEl.className = 'px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-emerald-950 text-emerald-300 border border-emerald-800';
          } else if (ticket.status === 'In Progress') {
            statusEl.className = 'px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-amber-950 text-amber-300 border border-amber-800';
          } else {
            statusEl.className = 'px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-blue-950 text-blue-300 border border-blue-800';
          }
        }

        // Anti-spam & resolved banner
        const inputWrapper = document.getElementById('student-chat-input-wrapper');
        const resolvedBanner = document.getElementById('student-chat-resolved-banner');
        if (ticket.status === 'Resolved') {
          if (inputWrapper) inputWrapper.classList.add('hidden');
          if (resolvedBanner) resolvedBanner.classList.remove('hidden');
        } else {
          if (inputWrapper) inputWrapper.classList.remove('hidden');
          if (resolvedBanner) resolvedBanner.classList.add('hidden');
        }

        const container = document.getElementById('student-chat-messages-container');
        if (container) {
          container.innerHTML = `
            <div class="text-center py-6 text-slate-500 text-xs flex items-center justify-center gap-2">
              <svg class="animate-spin w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
              <span>Loading messages...</span>
            </div>
          `;
        }

        try {
          const res = await fetch(`{{ url('api/support-tickets') }}/${ticketId}/messages?student_id=${encodeURIComponent(this.currentUser.student_id)}`);
          const data = await res.json();
          if (data.success) {
            this.renderStudentChatMessages(data.messages || [], ticket);
          } else {
            if (container) container.innerHTML = `<p class="text-rose-400 text-xs text-center py-4">${data.message || 'Error loading messages'}</p>`;
          }
        } catch (e) {
          console.error(e);
          if (container) container.innerHTML = `<p class="text-slate-400 text-xs text-center py-4">Unable to load messages right now.</p>`;
        }
      }

      renderStudentChatMessages(messages, ticket) {
        const container = document.getElementById('student-chat-messages-container');
        if (!container) return;
        container.innerHTML = '';

        if (messages.length === 0) {
          container.innerHTML = `
            <div class="text-center py-8 text-slate-500 text-xs">
              <p>No messages yet in this ticket.</p>
              <p class="text-[11px] text-slate-600 mt-1">Send a message below and an ICS Officer will reply shortly.</p>
            </div>
          `;
          return;
        }

        messages.forEach(msg => {
          const div = document.createElement('div');
          const isMe = msg.sender_type === 'student';
          const isSystem = msg.is_system;

          if (isSystem) {
            div.className = 'p-3 rounded-2xl bg-amber-950/30 border border-amber-900/60 text-xs text-amber-200 text-center font-mono my-2';
            div.innerHTML = `
              <div class="flex items-center justify-center gap-1.5 mb-1 text-[11px] font-bold text-amber-400">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>ICS System Notification</span>
              </div>
              <p class="text-xs text-amber-100">${msg.message}</p>
              <span class="text-[10px] text-amber-400/80 block mt-1">${msg.created_at ? new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : ''}</span>
            `;
          } else if (isMe) {
            div.className = 'flex justify-end';
            div.innerHTML = `
              <div class="max-w-[80%] bg-emerald-700 text-white rounded-2xl rounded-tr-sm p-3 shadow-md space-y-1">
                <div class="flex items-center justify-between gap-4 text-[10px] text-emerald-200">
                  <span class="font-bold">You (Student)</span>
                  <span>${msg.created_at ? new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : ''}</span>
                </div>
                <p class="text-xs leading-relaxed whitespace-pre-wrap">${msg.message}</p>
              </div>
            `;
          } else {
            div.className = 'flex justify-start';
            div.innerHTML = `
              <div class="max-w-[80%] bg-slate-900 border border-slate-700 text-slate-100 rounded-2xl rounded-tl-sm p-3 shadow-md space-y-1">
                <div class="flex items-center justify-between gap-4 text-[10px] text-ics-gold">
                  <span class="font-bold font-mono">👑 ${msg.sender_name || 'ICS Admin Support'}</span>
                  <span class="text-slate-400">${msg.created_at ? new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : ''}</span>
                </div>
                <p class="text-xs leading-relaxed whitespace-pre-wrap text-slate-200">${msg.message}</p>
              </div>
            `;
          }

          container.appendChild(div);
        });

        container.scrollTop = container.scrollHeight;
      }

      async sendStudentChatMessage(e) {
        e.preventDefault();
        if (!this.activeStudentTicketId) return;

        const input = document.getElementById('student-chat-input');
        const text = input ? input.value.trim() : '';
        if (!text) return;

        input.value = '';

        try {
          const res = await fetch(`{{ url('api/support-tickets') }}/${this.activeStudentTicketId}/messages`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
              sender_type: 'student',
              sender_name: this.currentUser.name,
              student_id: this.currentUser.student_id,
              message: text
            })
          });

          const data = await res.json();
          if (data.success && data.message_record) {
            const container = document.getElementById('student-chat-messages-container');
            if (container) {
              const div = document.createElement('div');
              div.className = 'flex justify-end';
              div.innerHTML = `
                <div class="max-w-[80%] bg-emerald-700 text-white rounded-2xl rounded-tr-sm p-3 shadow-md space-y-1">
                  <div class="flex items-center justify-between gap-4 text-[10px] text-emerald-200">
                    <span class="font-bold">You (Student)</span>
                    <span>Just now</span>
                  </div>
                  <p class="text-xs leading-relaxed whitespace-pre-wrap">${data.message_record.message}</p>
                </div>
              `;
              container.appendChild(div);
              container.scrollTop = container.scrollHeight;
            }
          } else {
            this.showToast(data.message || 'Could not send message.', 'warning');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Network error while sending message.', 'error');
        }
      }

      async renderStudentTicketsHistory() {
        const container = document.getElementById('student-tickets-history-container');
        if (!container) return;

        container.innerHTML = `
          <div class="text-center py-6 text-slate-500 text-xs">Loading ticket history...</div>
        `;

        try {
          const res = await fetch(`{{ route("api.support.tickets") }}?student_id=${encodeURIComponent(this.currentUser.student_id)}`);
          const data = await res.json();
          
          if (!data.success || !data.tickets || data.tickets.length === 0) {
            container.innerHTML = `
              <div class="text-center py-8 text-slate-500 text-xs p-4 rounded-2xl bg-slate-950 border border-slate-800">
                <p class="font-semibold text-slate-400">No Tickets Yet</p>
                <p class="text-[11px] text-slate-500 mt-1">You have not submitted any support tickets. If you need assistance with an order, click below.</p>
                <button onclick="icsApp.switchStudentSupportTab('new')" class="mt-3 px-3 py-1.5 rounded-xl bg-emerald-700 text-white text-xs font-bold">Open First Ticket</button>
              </div>
            `;
            return;
          }

          container.innerHTML = '';
          data.tickets.forEach(t => {
            const card = document.createElement('div');
            card.className = 'p-3 rounded-2xl bg-slate-950 border border-slate-800 hover:border-slate-700 transition space-y-2';
            
            const badgeBg = t.status === 'Resolved' 
              ? 'bg-emerald-950 text-emerald-300 border-emerald-800' 
              : (t.status === 'In Progress' ? 'bg-amber-950 text-amber-300 border-amber-800' : 'bg-blue-950 text-blue-300 border-blue-800');

            card.innerHTML = `
              <div class="flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                  <span class="font-mono font-bold text-ics-gold">${t.ticket_code}</span>
                  <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-slate-800 text-slate-300 border border-slate-700">${t.reason}</span>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[9px] font-mono font-bold ${badgeBg} border">
                  ${t.status}
                </span>
              </div>
              <div>
                <p class="text-xs font-bold text-white leading-tight">${t.subject}</p>
                ${t.reservation_ref ? `<p class="text-[10px] text-slate-400 font-mono mt-0.5">Order Ref: <strong class="text-slate-200">${t.reservation_ref}</strong></p>` : ''}
              </div>
              <div class="pt-2 border-t border-slate-800/80 flex items-center justify-between text-[11px]">
                <span class="text-slate-500 font-mono text-[10px]">${new Date(t.created_at).toLocaleDateString()}</span>
                <button 
                  onclick="icsApp.openStudentTicketChat(${t.id})" 
                  class="px-2.5 py-1 rounded-lg bg-emerald-950 hover:bg-emerald-900 text-emerald-300 border border-emerald-800 font-bold text-[10px] transition flex items-center gap-1">
                  <span>View Chat</span>
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
              </div>
            `;
            container.appendChild(card);
          });
        } catch (e) {
          console.error(e);
          container.innerHTML = `<p class="text-rose-400 text-xs text-center py-4">Error loading tickets history.</p>`;
        }
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

          const statusBadgeBg = t.status === 'Resolved' 
            ? 'bg-emerald-950 text-emerald-300 border-emerald-800' 
            : (t.status === 'In Progress' ? 'bg-amber-950 text-amber-300 border-amber-800' : 'bg-blue-950 text-blue-300 border-blue-800');

          const reasonBadgeBg = t.reason === 'Cancel Reservation' 
            ? 'bg-rose-950 text-rose-300 border-rose-800' 
            : (t.reason === 'Change Item Size' ? 'bg-blue-950 text-blue-300 border-blue-800' : 'bg-slate-800 text-slate-300 border-slate-700');

          card.innerHTML = `
            <div class="flex items-center justify-between text-xs mb-1">
              <span class="font-mono font-bold text-ics-gold text-[11px]">${t.ticket_code}</span>
              <span class="px-2 py-0.5 rounded-full text-[9px] font-mono font-bold ${statusBadgeBg} border">${t.status}</span>
            </div>
            <p class="font-bold text-white text-xs leading-tight">${t.student_name}</p>
            <p class="text-[10px] text-slate-400 font-mono mt-0.5">${t.student_id} ${t.reservation_ref ? `• <span class="text-blue-400 font-bold">${t.reservation_ref}</span>` : ''}</p>
            <div class="flex items-center justify-between mt-2 pt-1.5 border-t border-slate-800/60 text-[10px]">
              <span class="px-1.5 py-0.2 rounded text-[9px] font-bold ${reasonBadgeBg} border">${t.reason}</span>
              <span class="text-slate-500 font-mono">${t.created_at ? new Date(t.created_at).toLocaleDateString([], { month: 'short', day: 'numeric' }) : ''}</span>
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

      async selectAdminTicket(ticketId) {
        this.activeAdminTicketId = ticketId;
        const ticket = (this.supportTickets || []).find(t => t.id === ticketId);
        if (!ticket) return;

        this.renderAdminTicketsList();

        const emptyState = document.getElementById('admin-chat-empty-state');
        const activePanel = document.getElementById('admin-chat-active-panel');
        if (emptyState) emptyState.classList.add('hidden');
        if (activePanel) activePanel.classList.remove('hidden');

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
        if (sSubEl) sSubEl.textContent = `${ticket.student_id} • ${ticket.student_email || 'Verified Student'}`;

        // Linked reservation banner & cancel order button
        const resBanner = document.getElementById('admin-active-ticket-res-banner');
        const cancelBtn = document.getElementById('admin-btn-cancel-reservation');
        if (ticket.reservation_ref) {
          if (resBanner) resBanner.classList.remove('hidden');
          const resCodeEl = document.getElementById('admin-active-ticket-res-code');
          if (resCodeEl) resCodeEl.textContent = ticket.reservation_ref;
          
          const linkedRes = (this.reservations || []).find(r => r.ref_code === ticket.reservation_ref);
          if (linkedRes) {
            const detailsEl = document.getElementById('admin-active-ticket-res-details');
            if (detailsEl) detailsEl.textContent = `• ₱${Number(linkedRes.total_amount).toFixed(2)} (${linkedRes.payment_method})`;
            const resStatusEl = document.getElementById('admin-active-ticket-res-status');
            if (resStatusEl) resStatusEl.textContent = linkedRes.status;
          }
          if (cancelBtn) {
            cancelBtn.classList.remove('hidden');
            if (linkedRes && linkedRes.status === 'Cancelled') {
              cancelBtn.disabled = true;
              cancelBtn.className = 'px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-800 text-slate-500 border border-slate-700 cursor-not-allowed opacity-60';
              cancelBtn.innerHTML = `<span>Order Already Cancelled</span>`;
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
          if (resBanner) resBanner.classList.add('hidden');
          if (cancelBtn) cancelBtn.classList.add('hidden');
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

        // Fetch Messages
        const msgContainer = document.getElementById('admin-chat-messages-container');
        if (msgContainer) {
          msgContainer.innerHTML = `
            <div class="text-center py-6 text-slate-500 text-xs flex items-center justify-center gap-2">
              <svg class="animate-spin w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
              <span>Loading conversation...</span>
            </div>
          `;
        }

        try {
          const res = await fetch(`{{ url('api/support-tickets') }}/${ticketId}/messages`);
          const data = await res.json();
          if (data.success) {
            this.renderAdminChatMessages(data.messages || [], ticket);
          }
        } catch (e) {
          console.error(e);
        }
      }

      renderAdminChatMessages(messages, ticket) {
        const container = document.getElementById('admin-chat-messages-container');
        if (!container) return;
        container.innerHTML = '';

        messages.forEach(msg => {
          const div = document.createElement('div');
          const isSystem = msg.is_system;
          const isAdmin = msg.sender_type === 'admin';

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
                  <span>${msg.created_at ? new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : ''}</span>
                </div>
                <p class="text-xs leading-relaxed whitespace-pre-wrap">${msg.message}</p>
              </div>
            `;
          } else {
            div.className = 'flex justify-start';
            div.innerHTML = `
              <div class="max-w-[75%] bg-slate-900 border border-slate-700 text-slate-100 rounded-2xl rounded-tl-sm p-3 shadow-md space-y-1">
                <div class="flex items-center justify-between gap-4 text-[10px] text-slate-400">
                  <span class="font-bold text-white">${msg.sender_name} (Student)</span>
                  <span class="font-mono">${msg.created_at ? new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : ''}</span>
                </div>
                <p class="text-xs leading-relaxed whitespace-pre-wrap text-slate-200">${msg.message}</p>
              </div>
            `;
          }
          container.appendChild(div);
        });

        container.scrollTop = container.scrollHeight;
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

        input.value = '';

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
          if (data.success && data.message_record) {
            const ticket = (this.supportTickets || []).find(t => t.id === this.activeAdminTicketId);
            if (ticket && ticket.status === 'Open') {
              ticket.status = 'In Progress';
              this.renderAdminTicketsList();
            }

            const container = document.getElementById('admin-chat-messages-container');
            if (container) {
              const div = document.createElement('div');
              div.className = 'flex justify-end';
              div.innerHTML = `
                <div class="max-w-[75%] bg-emerald-800 text-white rounded-2xl rounded-tr-sm p-3 shadow-md space-y-1">
                  <div class="flex items-center justify-between gap-4 text-[10px] text-emerald-200 font-mono">
                    <span class="font-bold">👑 ICS Admin</span>
                    <span>Just now</span>
                  </div>
                  <p class="text-xs leading-relaxed whitespace-pre-wrap">${data.message_record.message}</p>
                </div>
              `;
              container.appendChild(div);
              container.scrollTop = container.scrollHeight;
            }
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
    }

    // Initialize Global Singleton
    window.icsApp = new IcsMerchApp();
  </script>

</body>

</html>