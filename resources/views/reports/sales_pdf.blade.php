<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $pageTitle ?? 'Official Merchandise Sales & Distribution Report' }} | ICS NPC</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      color: #0f172a;
      background-color: #f8fafc;
      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
    }

    .font-mono {
      font-family: 'JetBrains Mono', monospace;
    }

    @page {
      size: landscape;
      margin: 10mm 8mm;
    }

    @media print {
      body {
        background-color: #ffffff !important;
        color: #000000 !important;
      }
      .no-print {
        display: none !important;
      }
      .print-shadow-none {
        box-shadow: none !important;
      }
      .page-break-inside-avoid {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
      }
    }
  </style>
</head>

<body class="p-4 sm:p-8 min-h-screen">

  <!-- ======================================================== -->
  <!-- ACTION BAR (SCREEN ONLY - HIDDEN IN PRINT / PDF OUTPUT) -->
  <!-- ======================================================== -->
  <header class="no-print w-full max-w-[1780px] 2xl:max-w-[1920px] mx-auto mb-6 bg-slate-900 text-white rounded-2xl p-4 shadow-xl border border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
    <div class="flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl bg-red-700 border border-red-500 flex items-center justify-center p-1.5 shadow">
        <img src="{{ asset('images/ics-logo.png') }}" alt="ICS" class="w-full h-full object-contain">
      </div>
      <div>
        <h2 class="text-sm font-extrabold uppercase tracking-wide text-white flex items-center gap-2">
          <span>{{ $reportTitle ?? 'Official Merchandise Sales & Distribution Audit Report' }}</span>
          <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-blue-950 text-blue-300 border border-blue-700">Official Report</span>
        </h2>
        <p class="text-xs text-slate-400">
          @if($isSingle)
            Single Item Audit: <strong>{{ $product->name }} ({{ $product->item_code }})</strong> &bull; Complete buyers &amp; distribution history
          @else
            Master Sales vs Stock Comprehensive Ledger &bull; Complete student buyer orders
          @endif
        </p>
      </div>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
      <a href="{{ route('admin') }}#reports" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition flex items-center gap-1.5">
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        <span>Back to Admin Console</span>
      </a>

      @if($isSingle)
      <a href="{{ route('reports.export', ['product_id' => $product->id]) }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-emerald-700 hover:bg-emerald-600 text-white transition flex items-center gap-1.5 shadow">
        <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <span>Download Item CSV</span>
      </a>
      @else
      <a href="{{ route('reports.export') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-emerald-700 hover:bg-emerald-600 text-white transition flex items-center gap-1.5 shadow">
        <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <span>Download Master CSV</span>
      </a>
      @endif

      <button type="button" onclick="window.print()" class="px-4 py-2 rounded-xl text-xs font-black bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white shadow-lg shadow-red-950/40 transition flex items-center gap-2 cursor-pointer">
        <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        <span>Save as PDF / Print Now</span>
      </button>
    </div>
  </header>

  <!-- ======================================================== -->
  <!-- PRINTABLE DOCUMENT CONTAINER -->
  <!-- ======================================================== -->
  <main class="w-full max-w-[1780px] 2xl:max-w-[1920px] mx-auto bg-white border border-slate-200 rounded-3xl p-6 sm:p-10 shadow-xl print-shadow-none print:border-none print:p-0">

    <!-- INSTITUTIONAL ACADEMIC HEADER -->
    <div class="border-b-2 border-slate-900 pb-5 mb-6">
      <div class="flex items-center justify-between gap-4">
        <!-- NPC / ICS Seal Logo -->
        <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 flex items-center justify-center p-1 bg-red-900 rounded-2xl border border-red-700 shadow-sm print:rounded-none">
          <img src="{{ asset('images/ics-logo.png') }}" alt="ICS Seal" class="w-full h-full object-contain">
        </div>

        <!-- Institutional Titles -->
        <div class="text-center flex-1">
          <p class="text-[11px] sm:text-xs font-bold uppercase tracking-widest text-slate-500">Republic of the Philippines &bull; City of Navotas</p>
          <h1 class="text-base sm:text-xl font-extrabold text-slate-900 tracking-tight uppercase">NAVOTAS POLYTECHNIC COLLEGE</h1>
          <h2 class="text-xs sm:text-sm font-bold text-red-800 uppercase tracking-wide">Institute of Computer Studies &bull; Merchandise Portal</h2>
          <div class="mt-1 inline-flex items-center gap-2 px-3 py-0.5 rounded-full bg-slate-100 border border-slate-300 text-[11px] font-bold text-slate-700">
            @if($isSingle)
              <span>OFFICIAL SINGLE ITEM SALES &amp; BUYERS LEDGER</span>
            @else
              <span>OFFICIAL MASTER SALES VS STOCK INVENTORY &amp; BUYERS REPORT</span>
            @endif
          </div>
        </div>

        <!-- Document Reference Box -->
        <div class="text-right flex-shrink-0 hidden sm:block text-xs font-mono">
          <div class="border border-slate-300 bg-slate-50 rounded-xl p-2.5 space-y-1">
            <div><span class="text-slate-400">DOC REF:</span> <strong class="text-slate-800">ICS-REP-{{ date('Ymd') }}</strong></div>
            <div><span class="text-slate-400">DATE:</span> <strong class="text-slate-800">{{ date('M d, Y') }}</strong></div>
            <div><span class="text-slate-400">AUDITOR:</span> <strong class="text-slate-800">{{ $operatorCode ?? '251505' }}</strong></div>
          </div>
        </div>
      </div>
    </div>

    @if($isSingle)
      <!-- ======================================================== -->
      <!-- SINGLE PRODUCT AUDIT REPORT VIEW -->
      <!-- "yung damit lng na ito makikita don kung ilan bumili or ano" -->
      <!-- ======================================================== -->

      <!-- Product Information Banner & KPI Cards -->
      <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mb-6">
        <!-- Product Identity Banner -->
        <div class="md:col-span-5 p-4 rounded-2xl bg-slate-900 text-white border border-slate-800 flex items-center gap-4">
          @if(!empty($product->image_path))
          <img src="{{ asset($product->image_path) }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-xl object-cover border border-slate-700 flex-shrink-0">
          @else
          <div class="w-16 h-16 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-2xl flex-shrink-0">
            👕
          </div>
          @endif
          <div class="min-w-0">
            <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-cyan-950 text-cyan-300 border border-cyan-800">
              SKU: {{ $product->item_code }}
            </span>
            <h3 class="text-base font-black text-white truncate mt-1">{{ $product->name }}</h3>
            <p class="text-xs text-slate-300 font-mono mt-0.5">
              Unit Price: <strong class="text-emerald-400 font-bold">₱{{ number_format($product->price, 2) }}</strong> &bull; Category: <span class="uppercase">{{ $product->category }}</span>
            </p>
          </div>
        </div>

        <!-- 4 KPI Metrics: "kung ilan bumili, sales, at stock" -->
        <div class="md:col-span-7 grid grid-cols-2 sm:grid-cols-4 gap-3 text-xs">
          <div class="p-3.5 rounded-2xl bg-cyan-50 border border-cyan-200">
            <span class="block text-[10px] uppercase font-bold text-cyan-700 tracking-wider">Ilan ang Bumili (Sold)</span>
            <span class="block text-2xl font-black font-mono text-cyan-900 mt-1">{{ $product->units_sold }} <span class="text-xs font-normal">units</span></span>
            <span class="block text-[11px] text-cyan-700 mt-0.5">{{ count($buyers) }} student orders</span>
          </div>

          <div class="p-3.5 rounded-2xl bg-amber-50 border border-amber-200">
            <span class="block text-[10px] uppercase font-bold text-amber-700 tracking-wider">Units Reserved</span>
            <span class="block text-2xl font-black font-mono text-amber-900 mt-1">{{ $product->units_reserved }} <span class="text-xs font-normal">units</span></span>
            <span class="block text-[11px] text-amber-700 mt-0.5">Awaiting pickup</span>
          </div>

          <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200">
            <span class="block text-[10px] uppercase font-bold text-emerald-700 tracking-wider">Available Stock</span>
            <span class="block text-2xl font-black font-mono text-emerald-900 mt-1">{{ $product->current_stock }} <span class="text-xs font-normal">units</span></span>
            <span class="block text-[11px] text-emerald-700 mt-0.5">Initial: {{ $metrics['initial_stock'] }}</span>
          </div>

          <div class="p-3.5 rounded-2xl bg-purple-50 border border-purple-200">
            <span class="block text-[10px] uppercase font-bold text-purple-700 tracking-wider">Total Revenue</span>
            <span class="block text-2xl font-black font-mono text-purple-900 mt-1">₱{{ number_format($product->units_sold * $product->price, 2) }}</span>
            <span class="block text-[11px] text-purple-700 mt-0.5">100% Remitted</span>
          </div>
        </div>
      </div>

      <!-- Section Title -->
      <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-300">
        <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 flex items-center gap-2">
          <span>Official Student Buyers &amp; Orders Ledger</span>
          <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-slate-200 text-slate-700 font-bold">
            {{ count($buyers) }} Orders Recorded
          </span>
        </h4>
        <span class="text-[11px] text-slate-500 font-mono">Real-time Student Purchase Audit Trail</span>
      </div>

      <!-- Detailed Buyers Table: "makikita don kung ilan bumili or ano" -->
      <div class="overflow-x-auto border border-slate-200 rounded-2xl">
        <table class="w-full text-left text-xs">
          <thead class="bg-slate-100 text-slate-700 uppercase font-mono font-bold text-[10px] border-b border-slate-300">
            <tr>
              <th class="py-2.5 px-3 text-center">#</th>
              <th class="py-2.5 px-3">Student Number</th>
              <th class="py-2.5 px-3">Student Buyer Name</th>
              <th class="py-2.5 px-3">Program / Year</th>
              <th class="py-2.5 px-3 text-center">Qty</th>
              <th class="py-2.5 px-3 text-center">Size</th>
              <th class="py-2.5 px-3 text-right">Price</th>
              <th class="py-2.5 px-3 text-right">Subtotal</th>
              <th class="py-2.5 px-3">Order Date</th>
              <th class="py-2.5 px-3">Claim Date</th>
              <th class="py-2.5 px-3 text-center">Status</th>
              <th class="py-2.5 px-3 font-mono">Claim Ref</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 text-slate-800">
            @forelse($buyers as $idx => $b)
            <tr class="{{ $idx % 2 === 0 ? 'bg-white' : 'bg-slate-50' }} hover:bg-slate-100/70 transition">
              <td class="py-2.5 px-3 text-center font-mono font-bold text-slate-500">{{ $idx + 1 }}</td>
              <td class="py-2.5 px-3 font-mono font-bold text-cyan-800 whitespace-nowrap">{{ $b['student_id'] }}</td>
              <td class="py-2.5 px-3 font-bold text-slate-900 whitespace-nowrap">{{ $b['student_name'] }}</td>
              <td class="py-2.5 px-3 whitespace-nowrap text-slate-600">{{ $b['department'] }} - {{ $b['year_level'] }}</td>
              <td class="py-2.5 px-3 text-center font-mono font-bold text-slate-900">{{ $b['quantity'] }}</td>
              <td class="py-2.5 px-3 text-center font-mono font-bold">
                <span class="px-1.5 py-0.5 rounded bg-slate-200 text-slate-800 border border-slate-300 text-[10px]">{{ $b['size'] }}</span>
              </td>
              <td class="py-2.5 px-3 text-right font-mono text-slate-600">₱{{ number_format($b['unit_price'], 2) }}</td>
              <td class="py-2.5 px-3 text-right font-mono font-bold text-emerald-700">₱{{ number_format($b['subtotal'], 2) }}</td>
              <td class="py-2.5 px-3 font-mono text-[11px] text-slate-600 whitespace-nowrap">{{ $b['ordered_display'] }}</td>
              <td class="py-2.5 px-3 font-mono text-[11px] text-slate-700 whitespace-nowrap">
                @if($b['status'] === 'Claimed')
                  <span class="text-emerald-700 font-bold">{{ $b['claimed_display'] }}</span>
                @else
                  <span class="text-amber-600 italic">Pending Release</span>
                @endif
              </td>
              <td class="py-2.5 px-3 text-center whitespace-nowrap">
                <span class="px-2 py-0.5 rounded text-[10px] font-bold font-mono
                  @if($b['status'] === 'Claimed') bg-emerald-100 text-emerald-800 border border-emerald-300
                  @elseif($b['status'] === 'Ready for Pickup') bg-blue-100 text-blue-800 border border-blue-300
                  @else bg-amber-100 text-amber-800 border border-amber-300 @endif">
                  {{ $b['status'] }}
                </span>
              </td>
              <td class="py-2.5 px-3 font-mono text-[11px] text-slate-700 whitespace-nowrap">{{ $b['ref_code'] }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="12" class="py-10 text-center text-slate-500">
                <p class="font-bold text-sm text-slate-600">No student orders found for this item.</p>
                <p class="text-xs text-slate-400 mt-1">Once students reserve or claim this merchandise item, their records will automatically appear here.</p>
              </td>
            </tr>
            @endforelse
          </tbody>
          <tfoot class="bg-slate-100 font-bold border-t-2 border-slate-300 text-slate-900">
            <tr>
              <td colspan="4" class="py-2.5 px-3 text-right uppercase font-mono">TOTALS FOR THIS ITEM:</td>
              <td class="py-2.5 px-3 text-center font-mono text-cyan-800 text-sm font-black">{{ array_sum(array_column($buyers, 'quantity')) }}</td>
              <td colspan="2" class="py-2.5 px-3 text-right font-mono text-slate-600">Total Sales Value:</td>
              <td class="py-2.5 px-3 text-right font-mono text-emerald-800 text-sm font-black">₱{{ number_format(array_sum(array_column($buyers, 'subtotal')), 2) }}</td>
              <td colspan="4" class="py-2.5 px-3 text-slate-500 text-[10px] font-mono">{{ count($buyers) }} Total Order Transactions</td>
            </tr>
          </tfoot>
        </table>
      </div>

    @else
      <!-- ======================================================== -->
      <!-- MASTER INVENTORY & SALES AUDIT REPORT VIEW -->
      <!-- ======================================================== -->
      <div class="mb-6">
        <div class="flex items-center justify-between pb-2 mb-3 border-b border-slate-300">
          <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-800">
            Sales vs Stock Master Inventory Ledger
          </h3>
          <span class="text-xs text-slate-500 font-mono">{{ count($salesVsStock) }} Total Products Cataloged</span>
        </div>

        <div class="overflow-x-auto border border-slate-200 rounded-2xl mb-6">
          <table class="w-full text-left text-xs">
            <thead class="bg-slate-100 text-slate-700 uppercase font-mono font-bold text-[10px] border-b border-slate-300">
              <tr>
                <th class="py-2.5 px-3">Item Code</th>
                <th class="py-2.5 px-3">Product Name</th>
                <th class="py-2.5 px-3">Category</th>
                <th class="py-2.5 px-3 text-right">Price</th>
                <th class="py-2.5 px-3 text-center">Initial Stock</th>
                <th class="py-2.5 px-3 text-center">Claimed (Sold)</th>
                <th class="py-2.5 px-3 text-center">Reserved</th>
                <th class="py-2.5 px-3 text-center">On-Hand Stock</th>
                <th class="py-2.5 px-3 text-right">Revenue (PHP)</th>
                <th class="py-2.5 px-3 text-center">Stock Health</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-slate-800">
              @foreach($salesVsStock as $rItem)
              <tr class="hover:bg-slate-50 transition">
                <td class="py-2.5 px-3 font-mono font-bold text-cyan-800 whitespace-nowrap">{{ $rItem['item_code'] }}</td>
                <td class="py-2.5 px-3 font-bold text-slate-900">{{ $rItem['name'] }}</td>
                <td class="py-2.5 px-3 uppercase text-[11px] text-slate-600 whitespace-nowrap">{{ $rItem['category'] }}</td>
                <td class="py-2.5 px-3 font-mono text-right">₱{{ number_format($rItem['price'], 2) }}</td>
                <td class="py-2.5 px-3 text-center font-mono font-bold">{{ $rItem['initial_stock'] }}</td>
                <td class="py-2.5 px-3 text-center font-mono font-black text-cyan-700">{{ $rItem['units_sold'] }}</td>
                <td class="py-2.5 px-3 text-center font-mono font-bold text-amber-700">{{ $rItem['units_reserved'] }}</td>
                <td class="py-2.5 px-3 text-center font-mono font-black text-emerald-700">{{ $rItem['current_stock'] }}</td>
                <td class="py-2.5 px-3 text-right font-mono font-black text-slate-900">₱{{ number_format($rItem['revenue'], 2) }}</td>
                <td class="py-2.5 px-3 text-center whitespace-nowrap">
                  <span class="px-2 py-0.5 rounded text-[10px] font-bold font-mono
                    @if($rItem['status'] === 'Out of Stock') bg-rose-100 text-rose-800 border border-rose-300
                    @elseif($rItem['status'] === 'Low Stock') bg-amber-100 text-amber-800 border border-amber-300
                    @else bg-emerald-100 text-emerald-800 border border-emerald-300 @endif">
                    {{ $rItem['status'] }}
                  </span>
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot class="bg-slate-100 font-bold border-t-2 border-slate-300 text-slate-900">
              <tr>
                <td colspan="4" class="py-2.5 px-3 text-right uppercase font-mono">TOTALS:</td>
                <td class="py-2.5 px-3 text-center font-mono">{{ $totalInitialStock }}</td>
                <td class="py-2.5 px-3 text-center font-mono text-cyan-800 font-black">{{ $totalSoldUnits }}</td>
                <td class="py-2.5 px-3 text-center font-mono text-amber-800 font-black">{{ $totalReservedUnits }}</td>
                <td class="py-2.5 px-3 text-center font-mono text-emerald-800 font-black">{{ $totalStockUnits }}</td>
                <td class="py-2.5 px-3 text-right font-mono text-emerald-800 font-black text-sm">₱{{ number_format($totalRevenue, 2) }}</td>
                <td class="py-2.5 px-3 text-center text-slate-500 font-mono text-[10px]">100% Audited</td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    @endif

    <!-- ======================================================== -->
    <!-- CERTIFICATION & SIGN-OFF BLOCK (ACADEMIC AUDIT STANDARD) -->
    <!-- ======================================================== -->
    <div class="mt-10 pt-6 border-t-2 border-slate-900 page-break-inside-avoid">
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center text-xs">
        <div>
          <p class="text-[10px] uppercase font-bold text-slate-500 tracking-wider">Report Prepared &amp; Audited By:</p>
          <div class="mt-8 border-b border-slate-400 pb-1 mx-auto max-w-[220px]">
            <p class="font-bold text-slate-900 uppercase">{{ $operatorName ?? 'J. Derramas' }}</p>
          </div>
          <p class="text-[11px] text-slate-600 mt-1">Releasing Officer / Admin Auditor</p>
          <p class="text-[10px] font-mono text-slate-400">ID: {{ $operatorCode ?? '251505' }}</p>
        </div>

        <div>
          <p class="text-[10px] uppercase font-bold text-slate-500 tracking-wider">Verified for Distribution By:</p>
          <div class="mt-8 border-b border-slate-400 pb-1 mx-auto max-w-[220px]">
            <p class="font-bold text-slate-900 uppercase">ICS Student Council Auditor</p>
          </div>
          <p class="text-[11px] text-slate-600 mt-1">Navotas Polytechnic College</p>
          <p class="text-[10px] font-mono text-slate-400">AY 2025-2026</p>
        </div>

        <div>
          <p class="text-[10px] uppercase font-bold text-slate-500 tracking-wider">Approved for Official Filing By:</p>
          <div class="mt-8 border-b border-slate-400 pb-1 mx-auto max-w-[220px]">
            <p class="font-bold text-slate-900 uppercase">Dean / Department Head</p>
          </div>
          <p class="text-[11px] text-slate-600 mt-1">Institute of Computer Studies</p>
          <p class="text-[10px] font-mono text-slate-400">Official College Record</p>
        </div>
      </div>

      <div class="mt-8 pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between text-[10px] text-slate-400 font-mono">
        <p>CONFIDENTIAL &bull; NAVOTAS POLYTECHNIC COLLEGE &bull; INSTITUTE OF COMPUTER STUDIES MERCHANDISE PORTAL</p>
        <p>GENERATED ON: {{ date('Y-m-d H:i:s') }} PHT &bull; SYSTEM VERSION 2.0</p>
      </div>
    </div>

  </main>

  <script>
    // Automatically trigger print dialog if loaded with ?print=1 or ?auto_print=1
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('print') === '1' || urlParams.get('auto_print') === '1') {
      window.addEventListener('load', () => {
        setTimeout(() => {
          try {
            window.print();
          } catch(e) {
            console.error('Print trigger error:', e);
          }
        }, 350);
      });
    }
  </script>

</body>
</html>
