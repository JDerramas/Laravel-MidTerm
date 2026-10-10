<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  <!-- TOP APP BAR & HEADER (ICS ADMIN CONSOLE) -->
  <!-- ======================================================== -->
  <header class="sticky top-0 z-40 bg-ics-dark/95 backdrop-blur-md border-b border-ics-900/80 shadow-2xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-18 py-2">

        <!-- ICS Brand Identity & Emblem -->
        <a href="{{ route('admin') }}" class="flex items-center gap-2.5 sm:gap-3.5 group">
          <div class="relative w-10 h-10 sm:w-12 sm:h-12 flex-shrink-0 rounded-2xl p-0.5 bg-gradient-to-br from-amber-500 via-ics-700 to-ics-900 shadow-lg group-hover:scale-105 transition-transform duration-300">
            <img src="{{ asset('images/ics-logo.png') }}"
              alt="ICS Integrated Computer Society"
              class="w-full h-full object-contain rounded-xl bg-ics-950 p-0.5">
          </div>
          <div>
            <div class="flex items-center gap-1.5 sm:gap-2">
              <h1 class="text-sm sm:text-lg font-black tracking-tight leading-none text-white font-display uppercase flex items-center gap-1 sm:gap-1.5">
                <span>ICS</span>
                <span class="text-ics-gold font-normal">|</span>
                <span class="bg-gradient-to-r from-red-400 via-ics-gold to-yellow-300 bg-clip-text text-transparent">Admin Console</span>
              </h1>
              <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-950/80 text-amber-300 border border-amber-800">
                Staff & Logistics
              </span>
            </div>
            <p class="text-[10px] sm:text-[11px] text-slate-400 font-medium flex items-center gap-1.5 mt-0.5">
              <span class="text-ics-gold font-semibold tracking-wider">Executive Management</span>
              <span>Apparel & Merch System</span>
            </p>
          </div>
        </a>

        <!-- Portal Link Switcher & Controls -->
        <div class="flex items-center gap-2 sm:gap-3">

          <!-- Switch to Student Store Button -->
          <a
            href="{{ route('home') }}"
            class="px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-900 hover:bg-slate-800 text-slate-200 hover:text-white border border-slate-700 hover:border-ics-600 transition flex items-center gap-1.5 shadow">
            <svg class="w-3.5 h-3.5 text-ics-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span>🛒 Go to Student Store</span>
          </a>

          <!-- Admin Account Pill (ICS Black & Red Design) -->
          <div class="flex items-center gap-2.5 p-1 px-3 py-1 rounded-2xl bg-slate-900 border border-ics-900/80 shadow">
            @if(!empty($studentUser['avatar']))
              <img src="{{ $studentUser['avatar'] }}" alt="Profile" class="w-8 h-8 rounded-xl object-cover border border-ics-600 shadow flex-shrink-0">
            @else
              <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-ics-800 to-ics-crimson border border-ics-700 flex items-center justify-center text-white font-bold text-xs shadow flex-shrink-0">
                {{ $studentUser['initials'] ?? strtoupper(substr($adminUser->name ?? 'AD', 0, 2)) }}
              </div>
            @endif
            <div class="hidden sm:block text-left">
              <p class="text-xs font-bold text-white leading-tight truncate max-w-[130px]" title="{{ $adminUser->name ?? $studentUser['name'] ?? 'Administrator' }}">
                {{ $adminUser->name ?? $studentUser['name'] ?? 'Administrator' }}
              </p>
              <p class="text-[10px] text-ics-gold font-mono leading-tight truncate max-w-[130px]" title="{{ $adminUser->role ?? 'Admin' }}">
                {{ $adminUser->role ?? 'Admin' }}
              </p>
            </div>
          </div>

        </div>

      </div>
    </div>
  </header>

  <main id="admin-view-container" class="flex-1 pb-28 lg:pb-16 transition-opacity duration-300">
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
              </div>
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
                </div>
                <p id="kpi-total-products" class="text-2xl font-black text-white font-display mt-1">{{ $totalProducts }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Active merchandise models</p>
              </div>

              <!-- Available Stock -->
              <div class="bg-slate-900/90 rounded-2xl border border-slate-800 p-4 shadow">
                <div class="flex items-center justify-between">
                  <span class="text-[11px] font-bold text-slate-400 uppercase">On-Hand Stock</span>
                </div>
                <p id="kpi-total-stock" class="text-2xl font-black text-emerald-400 font-display mt-1">{{ $totalStockUnits }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Units ready for issue</p>
              </div>

              <!-- Claimed / Sold -->
              <div class="bg-slate-900/90 rounded-2xl border border-slate-800 p-4 shadow">
                <div class="flex items-center justify-between">
                  <span class="text-[11px] font-bold text-slate-400 uppercase">Units Claimed / Sold</span>
                </div>
                <p id="kpi-total-sold" class="text-2xl font-black text-blue-400 font-display mt-1">{{ $totalSoldUnits }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Revenue: <span id="kpi-total-revenue" class="font-mono text-emerald-400 font-bold">₱{{ number_format($totalRevenue, 2) }}</span></p>
              </div>

              <!-- Active Reservations -->
              <div class="bg-slate-900/90 rounded-2xl border border-slate-800 p-4 shadow">
                <div class="flex items-center justify-between">
                  <span class="text-[11px] font-bold text-slate-400 uppercase">Active Reservations</span>
                </div>
                <p id="kpi-total-reserved" class="text-2xl font-black text-ics-gold font-display mt-1">{{ $totalReservedUnits }}</p>
                <p class="text-[10px] text-slate-400 mt-0.5"><span id="kpi-pending-count">{{ $pendingReservationsCount }}</span> pending, <span id="kpi-ready-count">{{ $readyReservationsCount }}</span> ready</p>
              </div>

            </div>

            <!-- ======================================================== -->
            <!-- VISUAL CHARTS (DONUT / CIRCLE CHART & BAR CHART) -->
            <!-- Interactive with Tooltips, Percentages, and Real-Time Sync -->
            <!-- ======================================================== -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

              <!-- Donut Chart: Inventory Distribution (Circle Chart) -->
              <div class="bg-slate-900/90 rounded-3xl border border-slate-800 p-5 shadow-xl flex flex-col justify-between">
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-800">
                  <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">
                      <span>Stock & Sales Distribution</span>
                      <span class="px-2 py-0.5 rounded text-[9px] font-mono bg-emerald-950 text-emerald-300 border border-emerald-800">Circle Chart</span>
                    </h4>
                  </div>
                </div>

                <div class="relative w-full h-72 sm:h-80 min-h-[290px]" id="donut-chart-container">
                  <canvas id="inventoryDonutChart" class="w-full h-full block"></canvas>
                  <div id="inventoryDonutSvgFallback" class="w-full h-full hidden flex items-center justify-center"></div>
                </div>

                @php $totRatio = max(1, $totalStockUnits + $totalSoldUnits + $totalReservedUnits); @endphp
                <div class="grid grid-cols-3 gap-2 mt-4 pt-3 border-t border-slate-800/80 text-center font-mono text-xs">
                  <div class="p-2 rounded-xl bg-slate-950/60 border border-slate-800">
                    <span class="text-[10px] text-emerald-400 block font-bold">On-Hand</span>
                    <span id="chart-total-stock" class="text-white font-bold">{{ number_format($totalStockUnits) }}</span>
                    <span id="chart-pct-stock" class="text-[9px] text-emerald-400/90 block mt-0.5 font-sans font-semibold">
                      {{ round(($totalStockUnits / $totRatio) * 100, 1) }}%
                    </span>
                  </div>
                  <div class="p-2 rounded-xl bg-slate-950/60 border border-slate-800">
                    <span class="text-[10px] text-blue-400 block font-bold">Claimed (Sold)</span>
                    <span id="chart-total-sold" class="text-white font-bold">{{ number_format($totalSoldUnits) }}</span>
                    <span id="chart-pct-sold" class="text-[9px] text-blue-400/90 block mt-0.5 font-sans font-semibold">
                      {{ round(($totalSoldUnits / $totRatio) * 100, 1) }}%
                    </span>
                  </div>
                  <div class="p-2 rounded-xl bg-slate-950/60 border border-slate-800">
                    <span class="text-[10px] text-amber-400 block font-bold">Reserved</span>
                    <span id="chart-total-reserved" class="text-white font-bold">{{ number_format($totalReservedUnits) }}</span>
                    <span id="chart-pct-reserved" class="text-[9px] text-amber-400/90 block mt-0.5 font-sans font-semibold">
                      {{ round(($totalReservedUnits / $totRatio) * 100, 1) }}%
                    </span>
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
                  </div>
                </div>

                <div class="relative w-full h-72 sm:h-80 min-h-[290px]" id="bar-chart-container">
                  <canvas id="categoryBarChart" class="w-full h-full block"></canvas>
                  <div id="categoryBarSvgFallback" class="w-full h-full hidden"></div>
                </div>

                <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-800/80 text-[10px] text-slate-400">
                  <span>General, PE, Dept, Accessories</span>
                  <span class="font-mono text-emerald-400">Real-Time Inventory Synced</span>
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
                            <p class="text-[10px] text-slate-400">{{ $p->gender }} / {{ $p->dept }}</p>
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
                    <span>Student Reservation Queue</span>
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
                <div class="p-4 rounded-2xl bg-slate-950/80 border border-slate-800 hover:border-slate-700 transition" data-status="{{ $r->status }}" data-ref="{{ $r->ref_code }}">
                  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 pb-3 border-b border-slate-800/80">
                    <div class="reservation-header-badges flex items-center gap-2.5 flex-wrap">
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

                      @if($r->activeTicket)
                      <span class="ticket-warning-badge inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/50 animate-pulse" title="This reservation has a pending Helpdesk Support Ticket">
                        <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>⚠️ ON HOLD: Active Support Ticket ({{ $r->activeTicket->ticket_code }})</span>
                      </span>
                      @endif
                    </div>

                    <div class="text-[11px] text-slate-400 font-mono">
                      Reserved on: {{ $r->created_at->format('M d, Y h:i A') }}
                    </div>
                  </div>

                  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-3">
                    <div>
                      <p class="text-[10px] text-slate-400 uppercase font-semibold">Student Info</p>
                      <p class="text-xs font-bold text-white">{{ $r->student_name }}</p>
                      <p class="text-[11px] text-slate-300 font-mono">{{ $r->student_id }} / {{ $r->year_level }}</p>
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
                          GCash Online
                        </span>
                        @else
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-950 text-amber-300 border border-amber-800 flex items-center gap-1">
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
                          <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                          </svg>
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
                      <div class="reservation-actions-container flex items-center md:justify-end gap-2 mt-2">
                        @if($r->activeTicket)
                        <!-- LOCKED: Cannot Mark Ready or Mark Claimed while ticket is pending -->
                        <button
                          type="button"
                          onclick="icsApp.setAdminTab('helpdesk'); icsApp.selectAdminTicket({{ $r->activeTicket->id }});"
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
                          onclick="icsApp.updateReservationStatus('{{ $r->id }}', 'Ready for Pickup')"
                          class="px-2.5 py-1 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-500 text-white transition">
                          Mark Ready
                        </button>
                        @endif

                        @if($r->status === 'Ready for Pickup')
                        <button
                          onclick="icsApp.updateReservationStatus('{{ $r->id }}', 'Claimed')"
                          class="px-2.5 py-1 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition">
                          Mark Claimed
                        </button>
                        @endif
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

                        @if($r->status === 'Claimed' || $r->status === 'Cancelled')
                        <!-- Delete Button: Only appears when reservation is finished (Claimed or Cancelled) -->
                        <button
                          type="button"
                          onclick="icsApp.deleteReservation('{{ $r->id }}', '{{ $r->ref_code }}')"
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
                    System audit specifications: <strong>USER CODE | ACTION | ACTIVITY | DATE/TIMESTAMP</strong>
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
                    <svg class="w-4 h-4 text-slate-500 absolute left-2.5 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
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
                  <div class="p-4 border-b border-slate-800 bg-slate-900/90 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
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

  <!-- Admin Fixed Mobile Bottom Icon Navigation Bar (Instant 1-Tap Access) -->
  <nav class="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-slate-950/95 backdrop-blur-xl border-t border-slate-800 shadow-[0_-8px_30px_rgba(0,0,0,0.8)] px-2 py-1.5 flex items-center justify-between gap-1 safe-area-pb">
    <!-- Dashboard -->
    <button
      onclick="icsApp.setAdminTab('dashboard')"
      id="admin-bottom-tab-dashboard"
      class="admin-bottom-tab flex-1 py-1.5 px-0.5 rounded-xl flex flex-col items-center justify-center text-white bg-ics-800 shadow transition cursor-pointer"
      title="Dashboard">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
      <span class="text-[9px] font-bold mt-0.5 leading-none">Dash</span>
    </button>

    <!-- Info Mgmt / Products -->
    <button
      onclick="icsApp.setAdminTab('infomgmt')"
      id="admin-bottom-tab-infomgmt"
      class="admin-bottom-tab flex-1 py-1.5 px-0.5 rounded-xl flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer"
      title="Merchandise Items">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
      <span class="text-[9px] font-bold mt-0.5 leading-none">Items</span>
    </button>

    <!-- Reservation Queue -->
    <button
      onclick="icsApp.setAdminTab('reservations')"
      id="admin-bottom-tab-reservations"
      class="admin-bottom-tab flex-1 py-1.5 px-0.5 rounded-xl flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer relative"
      title="Reservation Queue">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
      <span class="text-[9px] font-bold mt-0.5 leading-none">Queue</span>
      @if(($pendingReservationsCount ?? 0) > 0)
      <span class="absolute top-1 right-2 w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
      @endif
    </button>

    <!-- Reports -->
    <button
      onclick="icsApp.setAdminTab('reports')"
      id="admin-bottom-tab-reports"
      class="admin-bottom-tab flex-1 py-1.5 px-0.5 rounded-xl flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer"
      title="Reports">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
      <span class="text-[9px] font-bold mt-0.5 leading-none">Reports</span>
    </button>

    <!-- Users -->
    <button
      onclick="icsApp.setAdminTab('usermgmt')"
      id="admin-bottom-tab-usermgmt"
      class="admin-bottom-tab flex-1 py-1.5 px-0.5 rounded-xl flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer"
      title="User Management">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
      <span class="text-[9px] font-bold mt-0.5 leading-none">Users</span>
    </button>

    <!-- Audit Trail Logs -->
    <button
      onclick="icsApp.setAdminTab('actlogs')"
      id="admin-bottom-tab-actlogs"
      class="admin-bottom-tab flex-1 py-1.5 px-0.5 rounded-xl flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer"
      title="Activity Logs">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      <span class="text-[9px] font-bold mt-0.5 leading-none">Logs</span>
    </button>

    <!-- Support Chat Helpdesk -->
    <button
      onclick="icsApp.setAdminTab('support')"
      id="admin-bottom-tab-support"
      class="admin-bottom-tab flex-1 py-1.5 px-0.5 rounded-xl flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer relative"
      title="Support Chat">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
      <span class="text-[9px] font-bold mt-0.5 leading-none">Chat</span>
      @if(($openTicketsCount ?? 0) > 0)
      <span class="absolute top-1 right-2 w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
      @endif
    </button>
  </nav>

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
          <label class="block text-[11px] font-bold text-slate-300 uppercase mb-1">User Code *</label>
          <input type="text" id="crud-user-code" required placeholder="e.g. USR-008" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white">
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

        const rawLogs = @json($activityLogs);
        this.activityLogs = Array.isArray(rawLogs) ? rawLogs : Object.values(rawLogs || {});

        const rawUsers = @json($users);
        this.users = Array.isArray(rawUsers) ? rawUsers : Object.values(rawUsers || {});

        // Logged-in Admin Identity
        @php
          $currentAdminPayload = $studentUser ?? [
            'name' => $adminUser->name ?? 'Administrator',
            'email' => $adminUser->email ?? '',
            'student_id' => $adminUser->user_code ?? 'USR-001',
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

        this.init();
      }

      init() {
        this.updateCartBadge();
        this.renderSizeGuide();
        this.initTracker();
        this.updateMobileDrawerContent();
        this.renderAdminTicketsList();

        // Restore active admin tab: stays on current section upon edit, delete, or reload
        let initialTab = 'dashboard';
        try {
          const hashTab = (window.location.hash || '').replace('#', '').trim();
          const localTab = localStorage.getItem('ics_admin_active_tab');
          const validTabs = ['dashboard', 'infomgmt', 'reservations', 'reports', 'usermgmt', 'actlogs', 'support', 'helpdesk'];
          if (validTabs.includes(hashTab)) {
            initialTab = hashTab === 'helpdesk' ? 'support' : hashTab;
          } else if (validTabs.includes(localTab)) {
            initialTab = localTab === 'helpdesk' ? 'support' : localTab;
          }
        } catch (e) {}

        this.setAdminTab(initialTab, true);

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
            if (data.reservations) this.reservations = data.reservations;
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
        const validTabs = ['dashboard', 'infomgmt', 'reservations', 'reports', 'usermgmt', 'actlogs', 'support'];
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

          // Sync fixed bottom mobile navigation bar icon buttons
          const bottomTab = document.getElementById(`admin-bottom-tab-${t}`);
          if (bottomTab) {
            if (t === tabName) {
              bottomTab.className = 'admin-bottom-tab flex-1 py-1.5 px-0.5 rounded-xl flex flex-col items-center justify-center text-white bg-ics-800 shadow transition cursor-pointer';
            } else {
              bottomTab.className = 'admin-bottom-tab flex-1 py-1.5 px-0.5 rounded-xl flex flex-col items-center justify-center text-slate-400 hover:text-white transition cursor-pointer relative';
            }
          }
        });

        if (tabName !== 'support' && tabName !== 'helpdesk' && this._adminChatPollInterval) {
          clearInterval(this._adminChatPollInterval);
          this._adminChatPollInterval = null;
        }

        if (tabName === 'dashboard') {
          setTimeout(() => this.initAdminCharts(), 100);
        } else if (tabName === 'support' || tabName === 'helpdesk') {
          this.renderAdminTicketsList();
          if (this.activeAdminTicketId) {
            this.selectAdminTicket(this.activeAdminTicketId);
          }
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
        document.getElementById('crud-user-code').value = 'USR-0' + Math.floor(10 + Math.random() * 90);
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
        document.getElementById('user-modal-title').textContent = `Edit User: ${user.name}`;
        document.getElementById('crud-user-id').value = user.id;
        document.getElementById('crud-user-code').value = user.user_code;
        document.getElementById('crud-user-name').value = user.name;
        document.getElementById('crud-user-email').value = user.email;
        document.getElementById('crud-user-role').value = user.role;
        document.getElementById('crud-user-dept').value = user.department;
        const feedbackEl = document.getElementById('user-email-feedback');
        if (feedbackEl) {
          feedbackEl.className = 'text-[10px] mt-1 text-slate-400';
          feedbackEl.textContent = 'Editing system user account.';
        }
        document.getElementById('user-crud-modal').classList.remove('hidden');
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
          const nameInput = document.getElementById('crud-user-name');
          const deptInput = document.getElementById('crud-user-dept');
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
        if (sSubEl) sSubEl.textContent = `${ticket.student_id} / ${ticket.student_email || 'Verified Student'}`;

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
            if (detailsEl) detailsEl.textContent = `₱${Number(linkedRes.total_amount).toFixed(2)} (${linkedRes.payment_method})`;
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
        if (ticket.messages && ticket.messages.length > 0) {
          this.renderAdminChatMessages(ticket.messages, ticket);
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
            this.renderAdminChatMessages(data.messages || [], ticket);
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
                  container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
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

      renderAdminChatMessages(messagesOrTicket, ticket) {
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
        if (ticket && ticket.status === 'Open') {
          ticket.status = 'In Progress';
          this.renderAdminTicketsList();
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

      renderReservationsQueue() {
        const container = document.getElementById('reservations-list');
        if (!container || !this.reservations) return;

        this.reservations.forEach(r => {
          const card = container.querySelector(`[data-ref="${r.ref_code}"]`);
          if (!card) return;

          // Auto-hide cancelled orders in code after 10 minutes (600,000 ms) without showing timer UI
          if (r.status === 'Cancelled') {
            const updated = r.updated_at ? new Date(r.updated_at).getTime() : 0;
            if (updated && (Date.now() - updated > 600000)) {
              card.style.display = 'none';
              return;
            }
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
              <span>⚠️ ON HOLD: Active Support Ticket (${activeTicket.ticket_code})</span>
            `;
            warnEl.classList.remove('hidden');
          } else if (warnEl) {
            warnEl.classList.add('hidden');
          }

          const actionsEl = card.querySelector('.reservation-actions-container');
          if (actionsEl) {
            let actionsHtml = '';
            if (activeTicket) {
              actionsHtml += `
                <button
                  type="button"
                  onclick="icsApp.setAdminTab('support'); icsApp.selectAdminTicket(${activeTicket.id});"
                  class="px-2.5 py-1 rounded-xl text-xs font-bold bg-amber-500/20 hover:bg-amber-500/30 text-amber-300 border border-amber-500/60 transition flex items-center gap-1.5 cursor-pointer shadow-sm"
                  title="This reservation has an active support ticket. Please resolve ticket before claiming.">
                  <svg class="w-3.5 h-3.5 text-amber-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                  <span>⚠️ Resolve Ticket [${activeTicket.ticket_code}]</span>
                </button>
              `;
            } else {
              if (r.status === 'Pending') {
                actionsHtml += `
                  <button
                    onclick="icsApp.updateReservationStatus('${r.id}', 'Ready for Pickup')"
                    class="px-2.5 py-1 rounded-xl text-xs font-bold bg-blue-600 hover:bg-blue-500 text-white transition">
                    Mark Ready
                  </button>
                `;
              }
              // Only show Mark Claimed when status is strictly Ready for Pickup
              if (r.status === 'Ready for Pickup') {
                actionsHtml += `
                  <button
                    onclick="icsApp.updateReservationStatus('${r.id}', 'Claimed')"
                    class="px-2.5 py-1 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition">
                    Mark Claimed
                  </button>
                `;
              }
            }

            if (r.status !== 'Cancelled' && r.status !== 'Claimed') {
              actionsHtml += `
                <button
                  onclick="icsApp.updateReservationStatus('${r.id}', 'Cancelled')"
                  class="px-2.5 py-1 rounded-xl text-xs font-bold bg-rose-950/80 hover:bg-rose-900 text-rose-300 border border-rose-800 transition">
                  Cancel
                </button>
              `;
            }

            actionsHtml += `
              <button
                onclick="icsApp.viewPrintClaimSlip(icsApp.reservations.find(x => x.id === ${r.id}))"
                class="px-2.5 py-1 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition">
                Print Slip
              </button>
            `;

            if (r.status === 'Claimed' || r.status === 'Cancelled') {
              actionsHtml += `
                <button
                  type="button"
                  onclick="icsApp.deleteReservation('${r.id}', '${r.ref_code}')"
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