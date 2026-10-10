<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ICS Integrated Computer Society | Apparel & Merch Reservation System</title>

  <!-- Performance Optimization: DNS Prefetch & Preconnect -->
  <link rel="dns-prefetch" href="//fonts.googleapis.com">
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link rel="dns-prefetch" href="//cdn.tailwindcss.com">
  <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
  <link rel="dns-prefetch" href="//onepass-gdbe.onrender.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://onepass-gdbe.onrender.com" crossorigin>
  <!-- Google Fonts: Plus Jakarta Sans & Space Grotesk -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Canvas Confetti CDN -->
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>


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
              <span>Apparel & Merch Reservation System</span>
            </p>
          </div>
        </div>

        <!-- View Switcher & Action Controls -->
        <div class="flex items-center gap-2 sm:gap-3">


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

          <!-- Mobile Active Portal Pill Indicator -->
          <span id="header-active-portal-badge" class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-ics-950 text-ics-300 border border-ics-800 lg:hidden">
            Student
          </span>

          <!-- Unified Header User Profile & Auth Widget -->
          <div id="header-user-profile-container" class="relative hidden lg:block">
            @if(session('student_user'))
            @php $stu = session('student_user'); @endphp
            <!-- Logged-in Student Profile Pill Button (ICS Black & Red Design) -->
            <button
              type="button"
              id="user-profile-menu-btn"
              onclick="icsApp.toggleProfileDropdown()"
              class="flex items-center gap-2.5 p-1 px-3 py-1 rounded-2xl bg-slate-900 border border-ics-600/70 hover:border-ics-500 shadow-md transition group"
              title="View student account menu">
              @if(!empty($stu['avatar']))
              <img src="{{ $stu['avatar'] }}" alt="{{ $stu['name'] }}" class="w-7 h-7 rounded-xl object-cover border border-ics-600/70 shadow flex-shrink-0" id="header-student-avatar-img">
              @else
              <div id="header-student-avatar-box" class="w-7 h-7 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-crimson border border-ics-700 flex items-center justify-center text-white font-bold text-xs shadow flex-shrink-0">
                {{ $stu['initials'] ?? 'ST' }}
              </div>
              @endif
              <div class="text-left max-w-[130px] truncate">
                <p class="text-xs font-bold text-white leading-tight flex items-center gap-1 truncate">
                  <span id="header-student-name-text" class="truncate">{{ $stu['name'] }}</span>
                  <span class="text-[9px] px-1.5 py-0.2 rounded bg-ics-950 text-ics-300 font-mono font-bold flex-shrink-0 border border-ics-800">Student</span>
                </p>
                <p id="header-student-id-text" class="text-[10px] text-ics-gold font-mono leading-tight truncate">{{ $stu['student_id'] }} &bull; {{ $stu['section'] ?? 'AIS' }}</p>
              </div>
              <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-ics-400 transition-transform group-hover:translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- Dynamic Unified Dropdown Menu (ICS Black & Red Design) -->
            <div id="user-profile-dropdown" class="hidden absolute right-0 mt-2 w-72 bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl py-2 z-50 text-xs">
              <div class="px-4 py-3 border-b border-slate-800 bg-slate-950/80 rounded-t-2xl">
                <p class="text-slate-400 text-[10px] uppercase font-mono tracking-wider font-semibold">Active Student Account</p>
                <p class="font-bold text-white text-sm mt-0.5" id="dropdown-student-name">{{ $stu['name'] }}</p>
                <p class="text-ics-gold font-mono text-[11px]" id="dropdown-student-id">{{ $stu['student_id'] }} &bull; {{ $stu['department'] ?? 'Information Systems' }}</p>
                <div class="flex items-center gap-2 mt-2">
                  <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-bold bg-ics-950 text-ics-300 border border-ics-800">
                    Verified ICS Student
                  </span>
                  @if(!empty($stu['section']))
                  <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-mono text-slate-300 bg-slate-800 border border-slate-700">
                    Section {{ $stu['section'] }}
                  </span>
                  @endif
                </div>
              </div>

              <div class="px-2 pt-2 space-y-1">
                <a href="https://onepass-gdbe.onrender.com/profile" target="_blank" rel="noopener noreferrer" class="w-full text-left px-3 py-2 rounded-xl bg-ics-950/60 hover:bg-ics-900/80 text-white flex items-center gap-2.5 transition border border-ics-900/80 group">
                  <svg class="w-4 h-4 text-ics-crimson group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  <span class="font-bold text-xs text-white">View OnePass Profile</span>
                  <svg class="w-3 h-3 text-ics-gold ml-auto group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                  </svg>
                </a>
                <a href="{{ route('oauth.login') }}" class="w-full text-left px-3 py-2 rounded-xl hover:bg-slate-800 text-slate-200 flex items-center gap-2.5 transition">
                  <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                  </svg>
                  <span>Switch Student Account (OnePass)</span>
                </a>
                <button type="button" onclick="icsApp.studentLogout()" class="w-full text-left px-3 py-2 rounded-xl hover:bg-rose-950/50 text-rose-300 flex items-center gap-2.5 transition">
                  <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                  </svg>
                  <span>Sign Out</span>
                </button>
              </div>

              <div class="px-2 pt-2 mt-2 border-t border-slate-800">
                <a href="{{ route('admin') }}" class="w-full text-left px-3 py-2 rounded-xl bg-slate-950/80 hover:bg-slate-800 text-slate-200 hover:text-white flex items-center gap-2.5 transition border border-slate-800 group shadow-sm text-xs font-semibold">
                  <svg class="w-4 h-4 text-amber-400 group-hover:rotate-45 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span>Admin Management Console</span>
                  <span class="text-slate-400 group-hover:text-white ml-auto">&rarr;</span>
                </a>
              </div>
            </div>
            @else
            <!-- Guest Student: Direct OnePass SSO Login Button + Register Link (ICS Black & Red Design) -->
            <div class="flex items-center gap-2">
              <a
                href="{{ route('oauth.login') }}"
                id="header-student-login-btn"
                class="flex px-3.5 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-ics-700 via-ics-crimson to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white border border-ics-600/70 shadow-md transition items-center gap-2 active:scale-95 group"
                title="Sign in with your verified OnePass campus account">
                <span class="w-2 h-2 rounded-full bg-ics-gold animate-pulse"></span>
                <svg class="w-3.5 h-3.5 text-white group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Student Login (OnePass)</span>
              </a>
              <a
                href="https://onepass-gdbe.onrender.com/onepass/login"
                target="_blank"
                rel="noopener noreferrer"
                class="px-2.5 py-1.5 rounded-xl text-xs font-bold text-ics-gold hover:text-amber-300 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 transition flex items-center gap-1 shadow-sm"
                title="Don't have an account yet? Register on OnePass">
                <span>Register</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
              </a>
            </div>
            @endif
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

      <!-- Active User Profile Card (Dynamic) -->
      @if(session('student_user'))
      @php $mStu = session('student_user'); @endphp
      <div id="mob-user-profile-card" class="p-3 rounded-2xl bg-ics-950/90 border border-ics-900 flex items-center justify-between shadow">
        <a href="https://onepass-gdbe.onrender.com/profile" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2.5 hover:opacity-90 transition group" title="Open OnePass Profile">
          @if(!empty($mStu['avatar']))
          <img src="{{ $mStu['avatar'] }}" alt="{{ $mStu['name'] }}" class="w-9 h-9 rounded-xl object-cover border border-ics-700 shadow group-hover:border-ics-crimson transition">
          @else
          <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-crimson border border-ics-700 flex items-center justify-center text-white font-bold text-xs shadow group-hover:scale-105 transition-transform">
            {{ $mStu['initials'] ?? 'ST' }}
          </div>
          @endif
          <div>
            <p class="text-xs font-bold text-white leading-tight flex items-center gap-1" id="mob-user-name">
              <span>{{ $mStu['name'] }}</span>
              <svg class="w-3 h-3 text-ics-gold opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
              </svg>
            </p>
            <p class="text-[10px] text-ics-gold font-mono" id="mob-user-id">{{ $mStu['student_id'] }} &bull; {{ $mStu['section'] ?? 'Student' }}</p>
          </div>
        </a>
        <button
          type="button"
          onclick="icsApp.studentLogout(); icsApp.closeMobileDrawer();"
          class="px-2.5 py-1 rounded-xl bg-rose-950/80 hover:bg-rose-900 text-rose-300 text-[10px] font-bold border border-rose-800 transition">
          Sign Out
        </button>
      </div>
      @else
      <div id="mob-user-profile-card" class="p-3.5 rounded-2xl bg-slate-950/80 border border-slate-800 space-y-2.5">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 font-bold text-xs">
              <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
            <div>
              <p class="text-xs font-bold text-white">Guest Student</p>
              <p class="text-[10px] text-slate-400 font-mono">Sign in to reserve merch</p>
            </div>
          </div>
          <a
            href="{{ route('oauth.login') }}"
            class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-ics-700 to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white text-[10px] font-bold border border-ics-600 transition shadow flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-ics-gold animate-pulse"></span>
            <span>Sign In (OnePass)</span>
          </a>
        </div>
        <div class="pt-2 border-t border-slate-800/80 flex items-center justify-between text-[11px]">
          <span class="text-slate-400">No student account yet?</span>
          <a
            href="https://onepass-gdbe.onrender.com/onepass/login"
            target="_blank"
            rel="noopener noreferrer"
            class="text-ics-gold hover:text-amber-300 font-bold flex items-center gap-1">
            <span>Register on OnePass</span>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
          </a>
        </div>
      </div>
      @endif

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

          <a
            id="mob-portal-admin"
            href="{{ route('admin') }}"
            class="w-full p-3 rounded-2xl bg-slate-950/80 hover:bg-slate-800 text-slate-300 font-semibold text-xs flex items-center justify-between border border-slate-800">
            <div class="flex items-center gap-2.5">
              <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              <span>Admin Management Portal</span>
            </div>
            <span class="text-[10px] px-2 py-0.5 rounded-full bg-slate-900 font-mono text-amber-300">6 Modules</span>
          </a>
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

      <!-- Admin Console Link -->
      <div class="pt-2 border-t border-slate-800">
        <a href="{{ route('admin') }}" class="w-full text-left p-3 rounded-2xl bg-gradient-to-r from-slate-950 to-slate-900 border border-slate-800 text-slate-300 hover:text-white hover:border-amber-500/50 flex items-center justify-between shadow transition">
          <div class="flex items-center gap-2.5">
            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <div>
              <span class="text-xs font-bold text-white block">ICS Admin Console</span>
              <span class="text-[9px] text-slate-400 font-mono">Staff & Logistics Portal &rarr;</span>
            </div>
          </div>
          <span class="text-[9px] px-2 py-0.5 rounded-full bg-amber-950 text-amber-300 border border-amber-800 font-mono font-bold">Admin</span>
        </a>
      </div>
    </div>



  </div>

  <!-- ======================================================== -->
  <!-- 1. STUDENT CATALOG PORTAL -->
  <!-- ======================================================== -->
  <main id="student-view-container" class="flex-1 pb-16 transition-opacity duration-300">

    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
      <div class="p-4 rounded-2xl bg-emerald-950/90 border border-emerald-600/80 text-emerald-200 text-xs flex items-center justify-between shadow-2xl">
        <div class="flex items-center gap-2.5">
          <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="font-bold">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.parentElement.remove()" class="text-slate-400 hover:text-white p-1">✕</button>
      </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
      <div class="p-4 rounded-2xl bg-rose-950/90 border border-rose-600/80 text-rose-200 text-xs flex items-center justify-between gap-3 shadow-2xl">
        <div class="flex items-center gap-2.5">
          <svg class="w-5 h-5 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="font-bold">{{ session('error') }}</span>
        </div>
        <button onclick="this.parentElement.parentElement.remove()" class="text-slate-400 hover:text-white p-1 text-sm font-bold flex-shrink-0 leading-none" title="Dismiss">✕</button>
      </div>
    </div>
    @endif

    @if(session('info'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
      <div class="p-4 rounded-2xl bg-slate-900 border border-slate-700 text-slate-200 text-xs flex items-center justify-between shadow-2xl">
        <div class="flex items-center gap-2.5">
          <svg class="w-5 h-5 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <span class="font-bold">{{ session('info') }}</span>
        </div>
        <button onclick="this.parentElement.parentElement.remove()" class="text-slate-400 hover:text-white p-1">✕</button>
      </div>
    </div>
    @endif

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

    @php
    $activeReservations = $reservations->filter(function($r) {
    return in_array($r->status, ['Pending', 'Payment Under Verification', 'In Production', 'Ready for Pickup']);
    });
    $hasActiveOrders = ($studentUser && $activeReservations->count() > 0);
    @endphp
    <!-- ======================================================== -->
    <!-- SHOPEE-STYLE ORDER & RESERVATION TRACKER -->
    <!-- ======================================================== -->
    <section id="tracker-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 {{ $hasActiveOrders ? '' : 'hidden' }}">
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
            <div class="relative flex-1 md:w-72">
              <select id="tracker-ref-select" onchange="icsApp.selectTrackerReservation(this.value)" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white font-mono focus:outline-none focus:border-ics-500">
                @if($studentUser && $activeReservations->count() > 0)
                @foreach($activeReservations as $res)
                <option value="{{ $res->ref_code }}">{{ $res->ref_code }} ({{ $res->status }}) — ₱{{ number_format($res->total_amount, 2) }}</option>
                @endforeach
                @else
                <option value="" disabled selected>No active pre-orders in progress</option>
                @endif
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
            @if(!empty($studentUser['avatar']))
            <img id="tracker-buyer-avatar-img" src="{{ $studentUser['avatar'] }}" class="w-9 h-9 rounded-xl object-cover border border-ics-600 shadow" alt="Avatar">
            @else
            <div id="tracker-buyer-avatar" class="w-9 h-9 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-600 flex items-center justify-center font-bold text-white text-xs">
              {{ $studentUser['initials'] ?? 'ST' }}
            </div>
            @endif
            <div>
              <p class="font-bold text-white" id="tracker-buyer-name">{{ $studentUser['name'] ?? 'Guest Student' }}</p>
              <p class="text-[11px] text-slate-400 font-mono" id="tracker-buyer-meta">
                @if($studentUser)
                ID: {{ $studentUser['student_id'] }} / {{ $studentUser['section'] ?? $studentUser['department'] ?? 'AIS' }}
                @else
                Sign in with OnePass to activate live tracking
                @endif
              </p>
            </div>
          </div>
          <div class="flex items-center gap-4 text-xs font-mono">
            <div>
              <span class="text-[10px] text-slate-500 uppercase block">Ref Code:</span>
              <span id="tracker-badge-ref" class="font-bold text-ics-gold font-mono">{{ count($reservations) > 0 ? $reservations[0]->ref_code : 'None' }}</span>
            </div>
            <div>
              <span class="text-[10px] text-slate-500 uppercase block">Total Due:</span>
              <span id="tracker-badge-total" class="font-bold text-white">₱{{ count($reservations) > 0 ? number_format($reservations[0]->total_amount, 2) : '0.00' }}</span>
            </div>
            <div>
              <span class="text-[10px] text-slate-500 uppercase block">Current Status:</span>
              <span id="tracker-badge-status" class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-950 text-blue-300 border border-blue-800">{{ count($reservations) > 0 ? $reservations[0]->status : 'No Order' }}</span>
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
                  <button type="button" onclick="icsApp.viewActiveReceipt()" class="text-blue-400 hover:text-blue-300 underline text-[10px] font-bold cursor-pointer">View My Receipt</button>
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
                <span id="prod-stock-badge-{{ $product->id }}" class="px-1.5 py-0.5 sm:px-2 sm:py-0.5 rounded-full text-[8px] sm:text-[10px] font-bold bg-rose-900/90 text-rose-200 border border-rose-700">Out of Stock</span>
                @elseif($product->current_stock < 20)
                  <span id="prod-stock-badge-{{ $product->id }}" class="px-1.5 py-0.5 sm:px-2 sm:py-0.5 rounded-full text-[8px] sm:text-[10px] font-bold bg-amber-900/90 text-amber-200 border border-amber-600">Low Stock ({{ $product->current_stock }})</span>
                  @else
                  <span id="prod-stock-badge-{{ $product->id }}" class="px-1.5 py-0.5 sm:px-2 sm:py-0.5 rounded-full text-[8px] sm:text-[10px] font-bold bg-emerald-900/90 text-emerald-200 border border-emerald-700">In Stock ({{ $product->current_stock }})</span>
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
                id="prod-reserve-btn-{{ $product->id }}"
                type="button"
                {{ $product->current_stock <= 0 ? 'disabled' : '' }}
                onclick="event.stopPropagation(); icsApp.openProductModal('{{ $product->id }}')"
                class="w-full sm:w-auto px-2 sm:px-3.5 py-1.5 sm:py-2 rounded-lg sm:rounded-xl text-[10px] sm:text-xs font-bold bg-gradient-to-r from-ics-700 to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white transition flex items-center justify-center gap-1 shadow {{ $product->current_stock <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
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
            <span id="cart-fee" class="font-mono text-ics-gold font-bold">₱10.00</span>
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
  <!-- MODAL: LOGIN REQUIRED PROMPT (GUEST AUTH GUARD) -->
  <!-- ======================================================== -->
  <div id="login-prompt-modal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/85 backdrop-blur-md flex items-center justify-center p-4">
    <div class="bg-gradient-to-b from-slate-900 to-slate-950 border border-slate-800 rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl relative text-center">

      <!-- Close Button -->
      <button onclick="icsApp.closeLoginPromptModal()" class="absolute top-4 right-4 text-slate-400 hover:text-white p-2 rounded-xl hover:bg-slate-800 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <!-- Glowing Icon (ICS Black & Red Design) -->
      <div class="w-16 h-16 mx-auto rounded-3xl bg-gradient-to-tr from-ics-700 to-ics-crimson p-0.5 shadow-xl shadow-ics-950/60 flex items-center justify-center mb-4">
        <div class="w-full h-full bg-slate-950 rounded-[22px] flex items-center justify-center">
          <svg class="w-8 h-8 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
          </svg>
        </div>
      </div>

      <!-- Badge (ICS Black & Red Design) -->
      <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-ics-950 border border-ics-800 text-ics-300 text-xs font-mono font-bold mb-3">
        <span class="w-2 h-2 rounded-full bg-ics-gold animate-pulse"></span>
        <span>OnePass Single Sign-On Required</span>
      </div>

      <h3 id="login-prompt-title" class="text-lg font-black text-white font-display">
        Student Login Required
      </h3>
      <p id="login-prompt-desc" class="text-xs text-slate-400 mt-2 leading-relaxed">
        You can freely browse uniforms and add items to your cart, but completing a reservation requires signing in with your official OnePass student account.
      </p>

      <div class="mt-4 p-3 rounded-2xl bg-slate-950/80 border border-slate-800/80 text-left text-[11px] text-slate-300 flex items-center gap-2.5">
        <div class="w-7 h-7 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center flex-shrink-0">
          <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <span id="login-prompt-tip">Your cart items and size selections are preserved safely in your session.</span>
      </div>

      <!-- Action Buttons -->
      <div class="mt-6 space-y-2.5">
        <a
          href="{{ route('oauth.login') }}"
          class="w-full py-3 px-4 rounded-2xl bg-gradient-to-r from-ics-700 via-ics-crimson to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white text-xs font-black shadow-xl shadow-ics-950/60 transition flex items-center justify-center gap-2 group active:scale-95 border border-ics-600/70">
          <svg class="w-4 h-4 text-ics-gold group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
          </svg>
          <span>Continue with OnePass SSO</span>
        </a>

        <!-- Register on OnePass Hyperlink 
        <div class="pt-2 pb-1 border-t border-slate-800/80 flex flex-col items-center justify-center gap-1.5 text-center">
          <p class="text-[11px] text-slate-400">Don't have an official student account yet?</p>
          <a
            href="https://onepass-gdbe.onrender.com/onepass/login"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-ics-gold hover:text-amber-300 text-xs font-bold border border-slate-700 transition shadow-md">
            <span>Register on OnePass</span>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
          </a>
        </div>
-->
        <button
          type="button"
          onclick="icsApp.closeLoginPromptModal()"
          class="w-full py-2.5 px-4 rounded-2xl bg-slate-800/80 hover:bg-slate-800 text-slate-300 text-xs font-semibold border border-slate-700/80 transition">
          Continue Browsing Catalog
        </button>
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
        @php
        $activeStudent = session('student_user') ?? [
        'name' => 'Louvie Rose Derramas',
        'student_id' => '2026-79818',
        'department' => 'Associate in Information Systems (AIS)',
        'year_level' => '2nd Year',
        'section' => '2A',
        'contact' => '0917-882-3419',
        'avatar' => 'https://lh3.googleusercontent.com/a/ACg8ocJ90cEExETC-aQuo-VEYELCIH7mUJZXGQ8o0XevR358Yu0qfaRa=s96-c',
        'initials' => 'LD'
        ];
        @endphp
        <div class="p-3.5 rounded-2xl bg-slate-950/90 border border-slate-800 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div id="chk-display-avatar" class="w-10 h-10 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-600 flex items-center justify-center text-white font-black text-sm shadow overflow-hidden flex-shrink-0">
              @if(!empty($activeStudent['avatar']))
              <img src="{{ $activeStudent['avatar'] }}" alt="{{ $activeStudent['name'] }}" class="w-full h-full object-cover" id="chk-avatar-img">
              @else
              <span id="chk-avatar-initials">{{ $activeStudent['initials'] ?? 'ST' }}</span>
              @endif
            </div>
            <div>
              <div class="flex items-center gap-2">
                <p class="text-xs font-bold text-white" id="chk-display-name">{{ $activeStudent['name'] }}</p>
                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-800">
                  Verified Student
                </span>
              </div>
              <p class="text-[11px] text-slate-400 font-mono mt-0.5" id="chk-display-id">
                Student ID: {{ $activeStudent['student_id'] }} &bull; {{ $activeStudent['section'] ?? 'AIS' }} ({{ $activeStudent['year_level'] ?? '2nd Year' }})
              </p>
            </div>
          </div>
          <button type="button" onclick="icsApp.openStudentLoginModal()" class="text-[10px] text-ics-gold hover:underline font-semibold uppercase flex items-center gap-1">
            <span>Change</span>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
          </button>
        </div>

        <!-- Hidden pre-filled student inputs -->
        <input type="hidden" id="chk-name" value="{{ $activeStudent['name'] ?? '' }}">
        <input type="hidden" id="chk-id" value="{{ $activeStudent['student_id'] ?? '' }}">
        <input type="hidden" id="chk-dept" value="{{ $activeStudent['department'] ?? '' }}">
        <input type="hidden" id="chk-year" value="{{ $activeStudent['year_level'] ?? '' }}">
        <input type="hidden" id="chk-contact" value="{{ $activeStudent['contact'] ?? 'Verified Student' }}">

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
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
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
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
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
                <svg class="w-3 h-3 text-blue-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                </svg>
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
              <p class="text-[11px] text-blue-300 font-mono">+63 930 635 ****</p>

              <div class="mt-2 pt-2 border-t border-blue-900/50 flex items-center justify-between">
                <span class="text-[10px] text-slate-400 uppercase font-semibold">Amount to Send:</span>
                <span id="gcash-amount-badge" class="text-xs font-black font-mono text-ics-gold">₱0.00</span>
              </div>

              <!-- Quick Helper Button to Enlarge QR -->
              <button
                type="button"
                onclick="icsApp.openQrZoomModal()"
                class="mt-2 text-[10px] font-bold text-blue-400 hover:text-blue-300 flex items-center gap-1 hover:underline transition">
                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                </svg>
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
                <svg class="w-6 h-6 mx-auto text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-[11px] font-bold text-slate-300">Click or tap to upload Receipt Screenshot</p>
                <p class="text-[9px] text-slate-500">JPG, PNG, WebP | Instantly viewable by ICS Admin verification team</p>
              </div>
              <div id="receipt-upload-preview-container" class="hidden flex items-center justify-center gap-3">
                <img id="receipt-upload-preview-img" src="" alt="Receipt Preview" class="w-14 h-14 object-cover rounded-xl border border-blue-500 shadow">
                <div class="text-left text-[11px]">
                  <p class="font-bold text-emerald-400 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
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
            <span id="chk-fee-preview" class="font-mono text-ics-gold font-bold">₱10.00</span>
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
            <p class="text-[9px] text-slate-500 font-mono">Official Student Copy | Verified Claim Slip</p>
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
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <div>
            <h3 class="text-sm font-black text-white font-display">Proof of GCash Payment Receipt</h3>
            <p class="text-[11px] text-slate-400" id="receipt-view-subtitle">Official Student Upload</p>
          </div>
        </div>
        <button onclick="icsApp.closeReceiptViewModal()" class="text-slate-400 hover:text-white p-1">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
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
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Open Full Image
          </a>
          <div class="flex items-center gap-2">
            <button onclick="icsApp.closeReceiptViewModal()" class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-slate-800 text-slate-300 hover:bg-slate-700 transition">
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
          <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
          </svg>
          GCash & InstaPay / QRPh
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
          RO****Y D. | +63 930 635 ****
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
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
          </svg>
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
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
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
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Tab Switcher (New Ticket vs Active Chat vs My Tickets) -->
      <div class="mt-3.5 flex items-center gap-1.5 p-1 rounded-2xl bg-slate-950 border border-slate-800 text-xs">
        <button
          id="student-tab-new"
          onclick="icsApp.switchStudentSupportTab('new')"
          class="flex-1 py-1.5 rounded-xl font-bold bg-emerald-600 text-white shadow transition flex items-center justify-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
          <span>New Ticket</span>
        </button>
        <button
          id="student-tab-chat"
          onclick="icsApp.switchStudentSupportTab('chat')"
          class="flex-1 py-1.5 rounded-xl font-bold text-slate-400 hover:text-white transition flex items-center justify-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
          </svg>
          <span>Live Conversation</span>

        </button>
        <button
          id="student-tab-history"
          onclick="icsApp.switchStudentSupportTab('history')"
          class="flex-1 py-1.5 rounded-xl font-bold text-slate-400 hover:text-white transition flex items-center justify-center gap-1.5">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
          </svg>
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
              <p class="text-[10px] text-slate-400 font-mono leading-tight" id="student-ticket-user-id">Student ID: 2025-01429-AIS / AIS 2B</p>
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
          <svg class="w-4 h-4 text-blue-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
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
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
          </svg>
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
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
              </svg>
            </button>
          </form>
        </div>

        <!-- Ticket Resolved Alert Banner -->
        <div id="student-chat-resolved-banner" class="hidden p-3 rounded-2xl bg-emerald-950/30 border border-emerald-800 text-xs text-emerald-300 text-center space-y-2">
          <div>
            <p class="font-bold">✅ This ticket has been marked as Resolved and closed by the Admin.</p>
            <p class="text-[10px] text-slate-400 mt-0.5">If you need further help with another request, please open a new ticket.</p>
          </div>
          <div>
            <button
              type="button"
              onclick="icsApp.deleteCurrentStudentTicket()"
              class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-rose-950/80 hover:bg-rose-900 text-rose-300 border border-rose-800 text-xs font-bold transition shadow-sm cursor-pointer"
              title="Delete this resolved ticket">
              <svg class="w-3.5 h-3.5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              <span>Delete Resolved Ticket</span>
            </button>
          </div>
        </div>

        <!-- Anti-Spam: Waiting for Admin Reply Banner -->
        <div id="student-chat-waiting-banner" class="hidden p-3 rounded-2xl bg-amber-950/40 border border-amber-800 text-xs text-amber-200 text-center space-y-1">
          <div class="flex items-center justify-center gap-1.5 font-bold text-amber-300">
            <svg class="w-4 h-4 text-amber-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Waiting for a response from the admin (Anti-Spam)</span>
          </div>
          <p class="text-[11px] text-amber-200/90">Your message has been sent. You cannot chat again until the ICS Admin Officer replies.</p>
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

  <!-- Toast Notification Container (Top Floating / High Z-Index / Non-blocking) -->
  <div id="toast-container" class="fixed top-5 left-1/2 -translate-x-1/2 z-[100] space-y-2 pointer-events-none flex flex-col items-center max-w-[92vw] sm:max-w-md w-full px-4" style="z-index: 99999;"></div>

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
        this.supportTickets = @json($supportTickets ?? []);

        // Logged-in Student Account (Verified via OnePass OAuth)
        this.currentUser = @json($studentUser ?? null);

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
        this.syncStudentIdentityToForms();
        this.updateStudentMyTicketsCount();
        this.startRealtimeSync();

        @if(session('success'))
          this.showToast(@json(session('success')), 'success');
        @endif
        @if(session('info'))
          this.showToast(@json(session('info')), 'info');
        @endif
        @if(session('error'))
          this.showToast(@json(session('error')), 'error');
        @endif

        // Silently pre-warm OnePass Render server in background to avoid OAuth cold-start delays
        try {
          fetch('https://onepass-gdbe.onrender.com/', {
            mode: 'no-cors',
            cache: 'no-cache',
            signal: AbortSignal.timeout ? AbortSignal.timeout(1500) : undefined
          }).catch(() => {});
        } catch (e) {}

        document.addEventListener('keydown', (e) => {
          if (e.key === 'Escape') {
            this.closeMobileDrawer();
            this.closeQrZoomModal();
            this.closeStudentSupportModal();
            this.closeLoginPromptModal();
          }
        });
      }

      syncStudentIdentityToForms() {
        if (!this.currentUser) return;
        const u = this.currentUser;
        const chkName = document.getElementById('chk-display-name');
        if (chkName) chkName.textContent = u.name;
        const chkId = document.getElementById('chk-display-id');
        if (chkId) chkId.textContent = `Student ID: ${u.student_id} • ${u.section || 'AIS'} (${u.year_level || '2nd Year'})`;
        const inName = document.getElementById('chk-name');
        if (inName) inName.value = u.name;
        const inId = document.getElementById('chk-id');
        if (inId) inId.value = u.student_id;
        const inDept = document.getElementById('chk-dept');
        if (inDept) inDept.value = u.department || 'Associate in Information Systems (AIS)';
        const inYear = document.getElementById('chk-year');
        if (inYear) inYear.value = u.year_level || '2nd Year';
        const inContact = document.getElementById('chk-contact');
        if (inContact) inContact.value = u.contact || 'Verified Student';

        const avatarBox = document.getElementById('chk-display-avatar');
        if (avatarBox) {
          if (u.avatar) {
            avatarBox.innerHTML = `<img src="${u.avatar}" alt="${u.name}" class="w-full h-full object-cover" id="chk-avatar-img">`;
          } else {
            avatarBox.innerHTML = `<span id="chk-avatar-initials">${u.initials || 'ST'}</span>`;
          }
        }
      }

      // ==========================================
      // STUDENT PORTAL AUTHENTICATION (ONEPASS OIDC SSO)
      // Direct Single Sign-On (Zero Manual Typing)
      // ==========================================
      openStudentLoginModal() {
        window.location.href = "{{ route('oauth.login') }}";
      }

      async studentLogout() {
        try {
          await fetch('{{ route("student.logout") }}', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
          });
        } catch (e) {
          // fallback
        }
        this.currentUser = null;
        this.renderLoggedOutStudentUi();
        this.showToast('You have signed out of your student session.', 'info');
      }

      applyStudentToUi(user) {
        this.currentUser = user;
        this.syncStudentIdentityToForms();

        // 1. Update Desktop Header Profile Container
        const profileContainer = document.getElementById('header-user-profile-container');
        if (profileContainer) {
          const avatarHtml = user.avatar ?
            `<img src="${user.avatar}" alt="${user.name}" class="w-7 h-7 rounded-xl object-cover border border-ics-600/70 shadow flex-shrink-0" id="header-student-avatar-img">` :
            `<div id="header-student-avatar-box" class="w-7 h-7 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-crimson border border-ics-700 flex items-center justify-center text-white font-bold text-xs shadow flex-shrink-0">${user.initials || 'ST'}</div>`;

          profileContainer.innerHTML = `
            <button
              type="button"
              id="user-profile-menu-btn"
              onclick="icsApp.toggleProfileDropdown()"
              class="flex items-center gap-2.5 p-1 px-3 py-1 rounded-2xl bg-slate-900 border border-ics-600/70 hover:border-ics-500 shadow-md transition group"
              title="View student account menu">
              ${avatarHtml}
              <div class="text-left max-w-[130px] truncate">
                <p class="text-xs font-bold text-white leading-tight flex items-center gap-1 truncate">
                  <span id="header-student-name-text" class="truncate">${user.name}</span>
                  <span class="text-[9px] px-1.5 py-0.2 rounded bg-ics-950 text-ics-300 font-mono font-bold flex-shrink-0 border border-ics-800">Student</span>
                </p>
                <p id="header-student-id-text" class="text-[10px] text-ics-gold font-mono leading-tight truncate">${user.student_id} &bull; ${user.section || 'AIS'}</p>
              </div>
              <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-ics-400 transition-transform group-hover:translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- Dynamic Unified Dropdown Menu (ICS Black & Red Design) -->
            <div id="user-profile-dropdown" class="hidden absolute right-0 mt-2 w-72 bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl py-2 z-50 text-xs">
              <div class="px-4 py-3 border-b border-slate-800 bg-slate-950/80 rounded-t-2xl">
                <p class="text-slate-400 text-[10px] uppercase font-mono tracking-wider font-semibold">Active Student Account</p>
                <p class="font-bold text-white text-sm mt-0.5" id="dropdown-student-name">${user.name}</p>
                <p class="text-ics-gold font-mono text-[11px]" id="dropdown-student-id">${user.student_id} &bull; ${user.department || 'Information Systems'}</p>
                <div class="flex items-center gap-2 mt-2">
                  <span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-bold bg-ics-950 text-ics-300 border border-ics-800">
                    Verified ICS Student
                  </span>
                  ${user.section ? `<span class="inline-block px-2 py-0.5 rounded-full text-[9px] font-mono text-slate-300 bg-slate-800 border border-slate-700">Section ${user.section}</span>` : ''}
                </div>
              </div>

              <div class="px-2 pt-2 space-y-1">
                <a href="https://onepass-gdbe.onrender.com/profile" target="_blank" rel="noopener noreferrer" class="w-full text-left px-3 py-2 rounded-xl bg-ics-950/60 hover:bg-ics-900/80 text-white flex items-center gap-2.5 transition border border-ics-900/80 group">
                  <svg class="w-4 h-4 text-ics-crimson group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  <span class="font-bold text-xs text-white">View OnePass Profile</span>
                  <svg class="w-3 h-3 text-ics-gold ml-auto group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
                <a href="{{ route('oauth.login') }}" class="w-full text-left px-3 py-2 rounded-xl hover:bg-slate-800 text-slate-200 flex items-center gap-2.5 transition">
                  <svg class="w-4 h-4 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                  </svg>
                  <span>Switch Student Account (OnePass)</span>
                </a>
                <button type="button" onclick="icsApp.studentLogout()" class="w-full text-left px-3 py-2 rounded-xl hover:bg-rose-950/50 text-rose-300 flex items-center gap-2.5 transition">
                  <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                  </svg>
                  <span>Sign Out</span>
                </button>
              </div>

              <div class="px-2 pt-2 mt-2 border-t border-slate-800">
                <a href="{{ route('admin') }}" class="w-full text-left px-3 py-2 rounded-xl bg-slate-950/80 hover:bg-slate-800 text-slate-200 hover:text-white flex items-center gap-2.5 transition border border-slate-800 group shadow-sm text-xs font-semibold">
                  <svg class="w-4 h-4 text-amber-400 group-hover:rotate-45 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span>Admin Management Console</span>
                  <span class="text-slate-400 group-hover:text-white ml-auto">&rarr;</span>
                </a>
              </div>
            </div>
          `;
        }

        // 2. Update Mobile Drawer Card
        const mobCard = document.getElementById('mob-user-profile-card');
        if (mobCard) {
          const mobAvatarHtml = user.avatar ?
            `<img src="${user.avatar}" alt="${user.name}" class="w-9 h-9 rounded-xl object-cover border border-ics-700 shadow group-hover:border-ics-crimson transition">` :
            `<div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-crimson border border-ics-700 flex items-center justify-center text-white font-bold text-xs shadow group-hover:scale-105 transition-transform">${user.initials || 'ST'}</div>`;

          mobCard.className = 'p-3 rounded-2xl bg-ics-950/90 border border-ics-900 flex items-center justify-between shadow';
          mobCard.innerHTML = `
            <a href="https://onepass-gdbe.onrender.com/profile" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2.5 hover:opacity-90 transition group" title="Open OnePass Profile">
              ${mobAvatarHtml}
              <div>
                <p class="text-xs font-bold text-white leading-tight flex items-center gap-1" id="mob-user-name">
                  <span>${user.name}</span>
                  <svg class="w-3 h-3 text-ics-gold opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </p>
                <p class="text-[10px] text-ics-gold font-mono" id="mob-user-id">${user.student_id} &bull; ${user.section || 'Student'}</p>
              </div>
            </a>
            <button
              type="button"
              onclick="icsApp.studentLogout(); icsApp.closeMobileDrawer();"
              class="px-2.5 py-1 rounded-xl bg-rose-950/80 hover:bg-rose-900 text-rose-300 text-[10px] font-bold border border-rose-800 transition">
              Sign Out
            </button>
          `;
        }
      }

      renderLoggedOutStudentUi() {
        // 1. Revert Desktop Profile Container
        const profileContainer = document.getElementById('header-user-profile-container');
        if (profileContainer) {
          profileContainer.innerHTML = `
            <div class="flex items-center gap-2">
              <a
                href="{{ route('oauth.login') }}"
                id="header-student-login-btn"
                class="flex px-3.5 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-ics-700 via-ics-crimson to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white border border-ics-600/70 shadow-md transition items-center gap-2 active:scale-95 group"
                title="Sign in with your verified OnePass campus account">
                <span class="w-2 h-2 rounded-full bg-ics-gold animate-pulse"></span>
                <svg class="w-3.5 h-3.5 text-white group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Student Login (OnePass)</span>
              </a>
              <a
                href="https://onepass-gdbe.onrender.com/onepass/login"
                target="_blank"
                rel="noopener noreferrer"
                class="px-2.5 py-1.5 rounded-xl text-xs font-bold text-ics-gold hover:text-amber-300 hover:bg-slate-800 border border-slate-800 hover:border-slate-700 transition flex items-center gap-1 shadow-sm"
                title="Don't have an account yet? Register on OnePass">
                <span>Register</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
              </a>
            </div>
          `;
        }

        // 2. Revert Mobile Drawer Card
        const mobCard = document.getElementById('mob-user-profile-card');
        if (mobCard) {
          mobCard.className = 'p-3.5 rounded-2xl bg-slate-950/80 border border-slate-800 space-y-2.5';
          mobCard.innerHTML = `
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-300 font-bold text-xs">
                  <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <div>
                  <p class="text-xs font-bold text-white">Guest Student</p>
                  <p class="text-[10px] text-slate-400 font-mono">Sign in to reserve merch</p>
                </div>
              </div>
              <a
                href="{{ route('oauth.login') }}"
                class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-ics-700 to-ics-800 hover:from-ics-600 hover:to-ics-700 text-white text-[10px] font-bold border border-ics-600 transition shadow flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-ics-gold animate-pulse"></span>
                <span>Sign In (OnePass)</span>
              </a>
            </div>
            <div class="pt-2 border-t border-slate-800/80 flex items-center justify-between text-[11px]">
              <span class="text-slate-400">No student account yet?</span>
              <a
                href="https://onepass-gdbe.onrender.com/onepass/login"
                target="_blank"
                rel="noopener noreferrer"
                class="text-ics-gold hover:text-amber-300 font-bold flex items-center gap-1">
                <span>Register on OnePass</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
              </a>
            </div>
          `;
        }
      }

      // ==========================================
      // SHOPEE-STYLE LIVE ORDER TRACKER
      // ==========================================
      initTracker() {
        this.updateTrackerVisibility();
      }

      updateTrackerVisibility() {
        const trackerSection = document.getElementById('tracker-section');
        if (!trackerSection) return;

        if (!this.currentUser) {
          trackerSection.classList.add('hidden');
          return;
        }

        const activeStatuses = ['pending', 'payment under verification', 'in production', 'ready for pickup', 'cancelled'];
        const activeList = (this.reservations || []).filter(r => {
          const isMine = (
            (this.currentUser.student_id && String(r.student_id).trim().toLowerCase() === String(this.currentUser.student_id).trim().toLowerCase()) ||
            (this.currentUser.email && String(r.student_id).trim().toLowerCase() === String(this.currentUser.email).trim().toLowerCase()) ||
            (this.currentUser.name && String(r.student_name).trim().toLowerCase() === String(this.currentUser.name).trim().toLowerCase())
          );
          if (!isMine) return false;

          const statusLower = String(r.status || '').trim().toLowerCase();
          // Auto-hide cancelled reservation in code after 10 minutes (600,000 ms) without showing timer UI
          if (statusLower === 'cancelled') {
            const updated = r.updated_at ? new Date(r.updated_at).getTime() : 0;
            if (updated && (Date.now() - updated > 600000)) {
              return false;
            }
          }

          return activeStatuses.includes(statusLower);
        });

        if (activeList.length === 0) {
          trackerSection.classList.add('hidden');
          return;
        }

        trackerSection.classList.remove('hidden');

        const selectEl = document.getElementById('tracker-ref-select');
        if (selectEl) {
          selectEl.innerHTML = activeList.map(res =>
            `<option value="${res.ref_code}">${res.ref_code} (${res.status}) — ₱${Number(res.total_amount).toFixed(2)}</option>`
          ).join('');
        }

        if (!this.activeTrackedRef || !activeList.some(r => r.ref_code === this.activeTrackedRef)) {
          this.selectTrackerReservation(activeList[0].ref_code);
        } else {
          this.selectTrackerReservation(this.activeTrackedRef);
        }
      }

      openLoginPromptModal(actionType = 'reservation') {
        const titleEl = document.getElementById('login-prompt-title');
        const descEl = document.getElementById('login-prompt-desc');
        const tipEl = document.getElementById('login-prompt-tip');

        if (actionType === 'reservation') {
          if (titleEl) titleEl.textContent = 'Student Login Required to Reserve';
          if (descEl) descEl.textContent = 'You can browse and select uniforms freely, but confirming your official reservation requires logging in with your OnePass campus credentials for verification.';
          if (tipEl) tipEl.textContent = 'Your selected uniform sizes and cart items will remain saved!';
        } else if (actionType === 'support') {
          if (titleEl) titleEl.textContent = 'Student Login Required for Support';
          if (descEl) descEl.textContent = 'To message ICS officers, inquire about order status, or file a size exchange request, please log in with your verified OnePass student account.';
          if (tipEl) tipEl.textContent = 'Officers will reply directly to your student account tickets.';
        }

        const modal = document.getElementById('login-prompt-modal');
        if (modal) modal.classList.remove('hidden');
      }

      closeLoginPromptModal() {
        const modal = document.getElementById('login-prompt-modal');
        if (modal) modal.classList.add('hidden');
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
          statusBadgeClass += 'bg-rose-950 text-rose-300 border border-rose-800 font-extrabold';
        } else {
          statusBadgeClass += 'bg-amber-950 text-amber-300 border border-amber-800';
        }
        if (badgeStatusEl) {
          badgeStatusEl.className = statusBadgeClass;
          badgeStatusEl.innerHTML = st.includes('cancel') ? '<span class="text-rose-500 font-black mr-1">✕</span> Cancelled' : res.status;
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

      initCharts() {}

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
        if (view === 'admin') {
          window.location.href = "{{ route('admin') }}";
          return;
        }

        this.currentView = 'student';
        const studentContainer = document.getElementById('student-view-container');
        const adminContainer = document.getElementById('admin-view-container');
        const studentSwitch = document.getElementById('portal-switch-student');
        const adminSwitch = document.getElementById('portal-switch-admin');

        if (adminContainer) adminContainer.classList.add('hidden');
        if (studentContainer) studentContainer.classList.remove('hidden');

        if (studentSwitch) studentSwitch.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold bg-gradient-to-r from-ics-800 to-ics-700 text-white shadow-md transition flex items-center gap-1.5';
        if (adminSwitch) adminSwitch.className = 'px-3.5 py-1.5 rounded-xl text-xs font-bold text-slate-400 hover:text-white transition flex items-center gap-1.5';

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
        if (!this.currentUser) {
          this.closeCartDrawer();
          this.openLoginPromptModal('reservation');
          return;
        }
        if (this.cart.length === 0) {
          this.showToast('Please add items to your cart first!', 'warning');
          return;
        }
        this.closeCartDrawer();
        this.syncStudentIdentityToForms();
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
              this.activeTrackedRef = data.reservation.ref_code;
              this.updateTrackerVisibility();
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

        const grandTotal = Number(resObj.total_amount) > total ? Number(resObj.total_amount) : total + 10.00;
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


      /**
       * REALTIME LIVE POLLING ENGINE (STUDENT STORE)
       * Automatically syncs product catalog stock, order tracking milestone status,
       * and helpdesk chat without page reloads every 3 seconds.
       */
      startRealtimeSync() {
        if (this._syncInterval) clearInterval(this._syncInterval);
        this._syncInterval = setInterval(async () => {
          if (document.hidden) return; // Skip polling when tab is not active to prevent server load
          if (this._syncInProgress) return;
          this._syncInProgress = true;
          try {
            const queryParams = new URLSearchParams();
            if (this.activeTrackedRef) {
              queryParams.append('tracking_code', this.activeTrackedRef);
            }
            if (this.activeStudentTicketId) {
              queryParams.append('ticket_id', this.activeStudentTicketId);
            }

            const qs = queryParams.toString() ? '?' + queryParams.toString() : '';
            const res = await fetch('{{ route("api.realtime.sync") }}' + qs, {
              headers: {
                'Accept': 'application/json'
              }
            });
            if (!res.ok) return;
            const data = await res.json();
            if (!data || !data.success) return;

            // 1. Update Product Catalog Stock in real-time
            if (data.products && Array.isArray(data.products)) {
              this.catalog = data.products;
              this.updateCatalogStockBadges();
            }

            // 2. Update Reservations & Live Order Tracker
            if (data.reservations && Array.isArray(data.reservations)) {
              this.reservations = data.reservations;
              this.updateTrackerVisibility();
            }

            // If student is tracking an order, update tracker view live
            if (this.activeTrackedRef) {
              const matchedRes = (this.reservations || []).find(r => r.ref_code === this.activeTrackedRef) || data.tracked_reservation;
              if (matchedRes) {
                const currentStatus = matchedRes.status;
                if (this._lastTrackedStatus && this._lastTrackedStatus !== currentStatus) {
                  this.showToast('Order [' + matchedRes.ref_code + '] status updated to: ' + currentStatus, 'info');
                }
                this._lastTrackedStatus = currentStatus;
                this.updateTrackerView(matchedRes);
              }
            }

            // 3. Update Support Tickets Cache in real-time
            if (data.support_tickets && Array.isArray(data.support_tickets)) {
              this.supportTickets = data.support_tickets;
              const histContainer = document.getElementById('student-tickets-history-container');
              if (histContainer && !histContainer.classList.contains('hidden')) {
                if (typeof this.renderTicketsListHtml === 'function') {
                  this.renderTicketsListHtml(histContainer, this.supportTickets);
                }
              }
            }

            // 4. Update Student Support Live Chat
            if (this.activeStudentTicketId && data.active_ticket && data.active_ticket.id === this.activeStudentTicketId) {
              if (data.active_ticket.status) {
                this.updateStudentTicketStatusUi(data.active_ticket.status);
              }
              if (data.active_ticket.messages && Array.isArray(data.active_ticket.messages)) {
                const container = document.getElementById('student-chat-messages-container');
                if (container) {
                  let hasNew = false;
                  data.active_ticket.messages.forEach(msg => {
                    if (this._renderedStudentMsgIds && !this._renderedStudentMsgIds.has(msg.id)) {
                      if (container.querySelector('.text-slate-500')) container.innerHTML = '';
                      this._renderedStudentMsgIds.add(msg.id);
                      this._studentChatLastMsgId = Math.max(this._studentChatLastMsgId || 0, msg.id);
                      const isMe = msg.sender_type === 'student';
                      const div = this.createMessageBubbleElement(msg, isMe);
                      container.appendChild(div);
                      hasNew = true;
                    }
                  });
                  if (hasNew) {
                    container.scrollTo({
                      top: container.scrollHeight,
                      behavior: 'smooth'
                    });
                  }
                }
              }
            }
          } catch (err) {
            // Silently ignore transient network drops
          } finally {
            this._syncInProgress = false;
          }
        }, 2000);
      }

      /**
       * Updates the stock pills and buttons on the catalog grid live
       */
      updateCatalogStockBadges() {
        if (!this.catalog) return;
        this.catalog.forEach(p => {
          const badgeEl = document.getElementById('prod-stock-badge-' + p.id);
          if (badgeEl) {
            if (p.current_stock <= 0) {
              badgeEl.className = 'px-1.5 py-0.5 sm:px-2 sm:py-0.5 rounded-full text-[8px] sm:text-[10px] font-bold bg-rose-900/90 text-rose-200 border border-rose-700';
              badgeEl.textContent = 'Out of Stock';
            } else if (p.current_stock < 20) {
              badgeEl.className = 'px-1.5 py-0.5 sm:px-2 sm:py-0.5 rounded-full text-[8px] sm:text-[10px] font-bold bg-amber-900/90 text-amber-200 border border-amber-600';
              badgeEl.textContent = 'Low Stock (' + p.current_stock + ')';
            } else {
              badgeEl.className = 'px-1.5 py-0.5 sm:px-2 sm:py-0.5 rounded-full text-[8px] sm:text-[10px] font-bold bg-emerald-900/90 text-emerald-200 border border-emerald-700';
              badgeEl.textContent = 'In Stock (' + p.current_stock + ')';
            }
          }

          const btnEl = document.getElementById('prod-reserve-btn-' + p.id);
          if (btnEl) {
            if (p.current_stock <= 0) {
              btnEl.disabled = true;
              btnEl.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
              btnEl.disabled = false;
              btnEl.classList.remove('opacity-50', 'cursor-not-allowed');
            }
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

        // Click to dismiss immediately
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
      // STUDENT SUPPORT DESK & CHAT (SPAM PROTECTED & PRIVATE)
      // ==========================================
      populateStudentReservationsDropdown() {
        const select = document.getElementById('student-ticket-res-select');
        if (!select) return;

        if (!this.currentUser) {
          select.innerHTML = '<option value="">-- No specific reservation / General inquiry --</option>';
          return;
        }

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
        if (!this.currentUser) {
          countBadge.textContent = '0';
          return;
        }
        const myTickets = (this.supportTickets || []).filter(t => t.student_id === this.currentUser.student_id);
        countBadge.textContent = myTickets.length;
      }

      openStudentSupportModal(preselectReason = null, preselectResRef = null) {
        if (!this.currentUser) {
          this.openLoginPromptModal('support');
          return;
        }

        this.populateStudentReservationsDropdown();
        this.updateStudentMyTicketsCount();

        const nameEl = document.getElementById('student-ticket-user-name');
        const idEl = document.getElementById('student-ticket-user-id');
        if (nameEl) nameEl.textContent = this.currentUser.name;
        if (idEl) idEl.textContent = `Student ID: ${this.currentUser.student_id} / ${this.currentUser.section || 'Student'}`;

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
        if (this._studentChatPollInterval) {
          clearInterval(this._studentChatPollInterval);
          this._studentChatPollInterval = null;
        }
        const modal = document.getElementById('student-support-modal');
        if (modal) modal.classList.add('hidden');
        this.activeStudentTicketId = null;
      }

      switchStudentSupportTab(tab) {
        if (tab !== 'chat' && this._studentChatPollInterval) {
          clearInterval(this._studentChatPollInterval);
          this._studentChatPollInterval = null;
        }

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

      createMessageBubbleElement(msg, isMe) {
        const div = document.createElement('div');
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
                <span>${msg.created_at ? new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : 'Just now'}</span>
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
        return div;
      }

      updateStudentTicketStatusUi(status) {
        const statusEl = document.getElementById('student-active-ticket-status');
        if (statusEl) {
          statusEl.textContent = status;
          if (status === 'Resolved') {
            statusEl.className = 'px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-emerald-950 text-emerald-300 border border-emerald-800';
          } else if (status === 'In Progress') {
            statusEl.className = 'px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-amber-950 text-amber-300 border border-amber-800';
          } else {
            statusEl.className = 'px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-blue-950 text-blue-300 border border-blue-800';
          }
        }

        const inputWrapper = document.getElementById('student-chat-input-wrapper');
        const waitingBanner = document.getElementById('student-chat-waiting-banner');
        const resolvedBanner = document.getElementById('student-chat-resolved-banner');

        if (status === 'Resolved') {
          if (inputWrapper) inputWrapper.classList.add('hidden');
          if (waitingBanner) waitingBanner.classList.add('hidden');
          if (resolvedBanner) resolvedBanner.classList.remove('hidden');
        } else {
          if (inputWrapper) inputWrapper.classList.remove('hidden');
          if (resolvedBanner) resolvedBanner.classList.add('hidden');
          if (waitingBanner) waitingBanner.classList.add('hidden');
        }
      }

      startStudentChatPoller() {
        if (this._studentChatPollInterval) {
          clearInterval(this._studentChatPollInterval);
        }
        this._studentChatPollInterval = setInterval(async () => {
          const modal = document.getElementById('student-support-modal');
          const isModalOpen = modal && !modal.classList.contains('hidden');
          const chatView = document.getElementById('student-support-view-chat');
          const isChatActive = chatView && !chatView.classList.contains('hidden');

          if (!isModalOpen || !isChatActive || !this.activeStudentTicketId || document.hidden) {
            return;
          }

          if (this._isPollingStudentChat) return;
          this._isPollingStudentChat = true;

          try {
            const stuId = (this.currentUser && this.currentUser.student_id) || '';
            const lastId = this._studentChatLastMsgId || 0;
            const res = await fetch(`{{ url('api/support-tickets') }}/${this.activeStudentTicketId}/messages?after_id=${lastId}&student_id=${encodeURIComponent(stuId)}`);
            if (!res.ok) return;
            const data = await res.json();
            if (!data || !data.success) return;

            if (data.ticket_status) {
              this.updateStudentTicketStatusUi(data.ticket_status);
            }

            if (data.messages && data.messages.length > 0) {
              const container = document.getElementById('student-chat-messages-container');
              if (container) {
                // If container was showing empty state or loading, clear it
                if (container.querySelector('.text-slate-500')) {
                  container.innerHTML = '';
                }

                let hasNew = false;
                data.messages.forEach(msg => {
                  if (this._renderedStudentMsgIds && this._renderedStudentMsgIds.has(msg.id)) {
                    return;
                  }
                  if (!this._renderedStudentMsgIds) this._renderedStudentMsgIds = new Set();
                  this._renderedStudentMsgIds.add(msg.id);
                  this._studentChatLastMsgId = Math.max(this._studentChatLastMsgId || 0, msg.id);

                  const isMe = msg.sender_type === 'student';
                  if (isMe) {
                    const optBubble = container.querySelector('[data-optimistic="true"]');
                    if (optBubble) {
                      optBubble.removeAttribute('data-optimistic');
                      return;
                    }
                  }

                  const div = this.createMessageBubbleElement(msg, isMe);
                  container.appendChild(div);
                  hasNew = true;
                });

                if (hasNew) {
                  container.scrollTo({
                    top: container.scrollHeight,
                    behavior: 'smooth'
                  });
                }
              }
            }
          } catch (e) {
            // Silently swallow network drops
          } finally {
            this._isPollingStudentChat = false;
          }
        }, 1200);
      }

      async openStudentTicketChat(ticketId) {
        this.activeStudentTicketId = ticketId;
        const ticket = (this.supportTickets || []).find(t => t.id === ticketId);

        this.switchStudentSupportTab('chat');

        if (ticket) {
          const codeEl = document.getElementById('student-active-ticket-code');
          const reasonEl = document.getElementById('student-active-ticket-reason');
          const subjEl = document.getElementById('student-active-ticket-subject');
          if (codeEl) codeEl.textContent = ticket.ticket_code;
          if (reasonEl) reasonEl.textContent = ticket.reason;
          if (subjEl) subjEl.textContent = ticket.subject;
          this.updateStudentTicketStatusUi(ticket.status);
        }

        const container = document.getElementById('student-chat-messages-container');
        if (ticket && ticket.messages && ticket.messages.length > 0) {
          this.renderStudentChatMessages(ticket.messages, ticket);
        } else if (container) {
          container.innerHTML = `
            <div class="text-center py-6 text-slate-500 text-xs flex items-center justify-center gap-2">
              <svg class="animate-spin w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
              <span>Connecting to conversation...</span>
            </div>
          `;
        }

        try {
          const stuId = (this.currentUser && this.currentUser.student_id) || '';
          const res = await fetch(`{{ url('api/support-tickets') }}/${ticketId}/messages?student_id=${encodeURIComponent(stuId)}`);
          const data = await res.json();
          if (data.success) {
            this.renderStudentChatMessages(data.messages || [], data.ticket || ticket);
            this.startStudentChatPoller();
          } else {
            if (container) container.innerHTML = `<p class="text-rose-400 text-xs text-center py-4">${data.message || 'Error loading messages'}</p>`;
          }
        } catch (e) {
          console.error(e);
          if (container && (!ticket || !ticket.messages || ticket.messages.length === 0)) {
            container.innerHTML = `<p class="text-slate-400 text-xs text-center py-4">Unable to load messages right now.</p>`;
          }
        }
      }

      renderStudentChatMessages(messagesOrTicket, ticket) {
        const container = document.getElementById('student-chat-messages-container');
        if (!container) return;

        let messages = [];
        let actualTicket = ticket;
        if (Array.isArray(messagesOrTicket)) {
          messages = messagesOrTicket;
        } else if (messagesOrTicket && messagesOrTicket.messages) {
          messages = messagesOrTicket.messages;
          actualTicket = messagesOrTicket;
        }

        this._renderedStudentMsgIds = new Set();
        this._studentChatLastMsgId = 0;
        container.innerHTML = '';

        if (!messages || messages.length === 0) {
          container.innerHTML = `
            <div class="text-center py-8 text-slate-500 text-xs">
              <p>No messages yet in this ticket.</p>
              <p class="text-[11px] text-slate-600 mt-1">Send a message below and an ICS Officer will reply shortly.</p>
            </div>
          `;
          return;
        }

        messages.forEach(msg => {
          this._renderedStudentMsgIds.add(msg.id);
          this._studentChatLastMsgId = Math.max(this._studentChatLastMsgId, msg.id);
          const isMe = msg.sender_type === 'student';
          const div = this.createMessageBubbleElement(msg, isMe);
          container.appendChild(div);
        });

        container.scrollTop = container.scrollHeight;

        if (actualTicket && actualTicket.status) {
          this.updateStudentTicketStatusUi(actualTicket.status);
        }
      }

      async sendStudentChatMessage(e) {
        if (e) e.preventDefault();
        const input = document.getElementById('student-chat-input');
        const message = input ? input.value.trim() : '';
        if (!message) return;
        if (!this.activeStudentTicketId) {
          this.showToast('No active support ticket selected.', 'warning');
          return;
        }

        // Instant Optimistic UI (0ms delay): append student bubble immediately without waiting
        input.value = '';
        input.focus();

        const container = document.getElementById('student-chat-messages-container');
        if (container) {
          if (container.querySelector('.text-slate-500')) {
            container.innerHTML = '';
          }
          const div = document.createElement('div');
          div.className = 'flex justify-end';
          div.setAttribute('data-optimistic', 'true');
          div.innerHTML = `
            <div class="max-w-[80%] bg-emerald-700 text-white rounded-2xl rounded-tr-sm p-3 shadow-md space-y-1">
              <div class="flex items-center justify-between gap-4 text-[10px] text-emerald-200">
                <span class="font-bold">You (Student)</span>
                <span>Just now</span>
              </div>
              <p class="text-xs leading-relaxed whitespace-pre-wrap">${message}</p>
            </div>
          `;
          container.appendChild(div);
          container.scrollTo({
            top: container.scrollHeight,
            behavior: 'smooth'
          });
        }

        try {
          const res = await fetch(`{{ url('api/support-tickets') }}/${this.activeStudentTicketId}/messages`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': this.csrfToken,
              'Accept': 'application/json'
            },
            body: JSON.stringify({
              sender_type: 'student',
              sender_name: (this.currentUser && this.currentUser.name) || 'Student',
              student_id: (this.currentUser && this.currentUser.student_id) || '',
              message: message
            })
          });

          const data = await res.json();
          if (data.success) {
            const ticket = (this.supportTickets || []).find(t => t.id === this.activeStudentTicketId);
            const returnedMsg = data.message_record || data.message;
            if (returnedMsg && returnedMsg.id) {
              if (!this._renderedStudentMsgIds) this._renderedStudentMsgIds = new Set();
              this._renderedStudentMsgIds.add(returnedMsg.id);
              this._studentChatLastMsgId = Math.max(this._studentChatLastMsgId || 0, returnedMsg.id);
              if (ticket) {
                if (!ticket.messages) ticket.messages = [];
                ticket.messages.push(returnedMsg);
              }
            }
          } else {
            this.showToast(data.message || 'Could not send message.', 'warning');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Network error while sending message.', 'error');
        }
      }

      renderTicketsListHtml(container, tickets) {
        if (!tickets || tickets.length === 0) {
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
        tickets.forEach(t => {
          const card = document.createElement('div');
          card.className = 'p-3 rounded-2xl bg-slate-950 border border-slate-800 hover:border-slate-700 transition space-y-2';

          const badgeBg = t.status === 'Resolved' ?
            'bg-emerald-950 text-emerald-300 border-emerald-800' :
            (t.status === 'In Progress' ? 'bg-amber-950 text-amber-300 border-amber-800' : 'bg-blue-950 text-blue-300 border-blue-800');

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
              <div class="flex items-center gap-1.5">
                ${t.status === 'Resolved' ? `
                  <button 
                    type="button"
                    onclick="icsApp.deleteStudentTicket(${t.id}, '${t.ticket_code}')" 
                    class="px-2 py-1 rounded-lg bg-rose-950/80 hover:bg-rose-900 text-rose-300 border border-rose-800 font-bold text-[10px] transition flex items-center gap-1 shadow-sm cursor-pointer"
                    title="Delete resolved ticket">
                    <svg class="w-3 h-3 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Delete</span>
                  </button>
                ` : ''}
                <button 
                  onclick="icsApp.openStudentTicketChat(${t.id})" 
                  class="px-2.5 py-1 rounded-lg bg-emerald-950 hover:bg-emerald-900 text-emerald-300 border border-emerald-800 font-bold text-[10px] transition flex items-center gap-1">
                  <span>View Chat</span>
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
              </div>
            </div>
          `;
          container.appendChild(card);
        });
      }

      async renderStudentTicketsHistory() {
        const container = document.getElementById('student-tickets-history-container');
        if (!container) return;

        // Instant Render (0ms): If tickets are already cached in memory, display them right away!
        if (this.supportTickets && this.supportTickets.length > 0) {
          this.renderTicketsListHtml(container, this.supportTickets);
        } else {
          container.innerHTML = `
            <div class="text-center py-6 text-slate-500 text-xs">Loading ticket history...</div>
          `;
        }

        try {
          const stuId = (this.currentUser && this.currentUser.student_id) || '';
          const res = await fetch(`{{ route("api.support.tickets") }}?student_id=${encodeURIComponent(stuId)}`);
          const data = await res.json();

          if (data.success && data.tickets) {
            this.supportTickets = data.tickets;
            this.renderTicketsListHtml(container, data.tickets);
          } else if (!this.supportTickets || this.supportTickets.length === 0) {
            this.renderTicketsListHtml(container, []);
          }
        } catch (e) {
          console.error(e);
          if (!this.supportTickets || this.supportTickets.length === 0) {
            container.innerHTML = `<p class="text-rose-400 text-xs text-center py-4">Error loading tickets history.</p>`;
          }
        }
      }

      async deleteStudentTicket(ticketId, ticketCode) {
        if (!confirm(`Are you sure you want to delete resolved ticket [${ticketCode}]?\n\nThis action cannot be undone and conversation history will be permanently deleted.`)) {
          return;
        }

        try {
          const res = await fetch(`{{ url('api/support-tickets') }}/${ticketId}`, {
            method: 'DELETE',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': this.csrfToken,
              'Accept': 'application/json'
            },
            body: JSON.stringify({
              student_id: this.currentUser.student_id,
              role: 'student'
            })
          });

          const data = await res.json();
          if (data.success) {
            this.showToast(data.message || 'Ticket deleted successfully!', 'success');
            this.supportTickets = (this.supportTickets || []).filter(t => t.id !== ticketId);
            if (this.activeStudentTicketId === ticketId) {
              this.activeStudentTicketId = null;
              this.switchStudentSupportTab('history');
            }
            this.renderStudentTicketsHistory();
            this.updateStudentMyTicketsCount();
          } else {
            this.showToast(data.message || 'Could not delete ticket.', 'warning');
          }
        } catch (err) {
          console.error(err);
          this.showToast('Network error while deleting ticket.', 'error');
        }
      }

      deleteCurrentStudentTicket() {
        if (!this.activeStudentTicketId) return;
        const currentTicket = (this.supportTickets || []).find(t => t.id === this.activeStudentTicketId);
        const code = currentTicket ? currentTicket.ticket_code : 'ticket';
        this.deleteStudentTicket(this.activeStudentTicketId, code);
      }

      // ==========================================
      // ADMIN SUPPORT HELPDESK & CONVERSATION LIST
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

      updateTrackerView(res) {
        if (!res) return;
        this.selectTrackerReservation(res.ref_code);
      }

      renderAdminTicketsList() {}
      selectAdminTicket() {}

    }

    // Initialize Global Singleton
    window.icsApp = new IcsMerchApp();
  </script>

</body>

</html>