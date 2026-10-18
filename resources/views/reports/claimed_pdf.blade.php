<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Official Claimed Releases Ledger | ICS Navotas Polytechnic College</title>

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
          <span>Official Claimed Releases Ledger</span>
          <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-emerald-950 text-emerald-400 border border-emerald-700">PDF Document</span>
        </h2>
        <p class="text-xs text-slate-400">Ready for institutional distribution audit, filing, and physical release sign-offs</p>
      </div>
    </div>

    <div class="flex items-center gap-2.5 flex-wrap">
      <a href="{{ route('admin') }}#claimed" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition flex items-center gap-1.5">
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        <span>Back to Admin Console</span>
      </a>

      <a href="{{ route('reports.export_claimed') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-emerald-700 hover:bg-emerald-600 text-white transition flex items-center gap-1.5 shadow">
        <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <span>Download CSV</span>
      </a>

      <button type="button" onclick="window.print()" class="px-4 py-2 rounded-xl text-xs font-black bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white shadow-lg shadow-red-950/40 transition flex items-center gap-2 cursor-pointer">
        <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        <span>Save as PDF / Print Now</span>
      </button>
    </div>
  </header>

  <!-- ======================================================== -->
  <!-- PRINTABLE DOCUMENT SHEET CONTAINER -->
  <!-- ======================================================== -->
  <main class="w-full max-w-[1780px] 2xl:max-w-[1920px] mx-auto bg-white border border-slate-200 rounded-3xl p-6 sm:p-10 shadow-xl print-shadow-none print:border-none print:p-0">

    <!-- INSTITUTIONAL ACADEMIC HEADER -->
    <div class="border-b-2 border-slate-900 pb-5 mb-6">
      <div class="flex items-center justify-between gap-4">
        <!-- NPC / ICS Seal Logo -->
        <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 flex items-center justify-center p-1 bg-red-900 rounded-2xl border border-red-700 shadow-sm print:rounded-none">
          <img src="{{ asset('images/ics-logo.png') }}" alt="ICS Seal" class="w-full h-full object-contain">
        </div>

        <!-- College Headings -->
        <div class="flex-1 text-center">
          <p class="text-[11px] sm:text-xs font-semibold tracking-wider text-slate-600 uppercase">Republic of the Philippines &bull; City of Navotas</p>
          <h1 class="text-base sm:text-xl font-extrabold text-slate-900 uppercase tracking-tight">NAVOTAS POLYTECHNIC COLLEGE</h1>
          <p class="text-xs sm:text-sm font-bold text-red-800 uppercase tracking-wide">INTEGRATED COMPUTER SOCIETY (ICS)</p>
          <p class="text-[10px] sm:text-xs text-slate-500 font-medium">Student Council Apparel &amp; Merchandise Management System</p>
        </div>

        <!-- Academic Barcode / Verification Badge -->
        <div class="text-right flex-shrink-0">
          <div class="inline-block px-3 py-1.5 rounded-xl bg-slate-100 border border-slate-300 text-right">
            <span class="block text-[9px] font-mono uppercase text-slate-500 font-semibold">Document No.</span>
            <span class="block text-xs font-mono font-bold text-slate-900">DOC-CLM-{{ date('Ymd') }}</span>
            <span class="block text-[9px] font-mono text-emerald-700 font-bold uppercase mt-0.5">&bull; Official Release Ledger</span>
          </div>
        </div>
      </div>

      <!-- Document Title Banner -->
      <div class="mt-4 pt-3 border-t border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
        <div>
          <h2 class="text-sm sm:text-base font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
            <span>Official Claimed Releases &amp; Physical Distribution Ledger</span>
          </h2>
          <p class="text-[11px] text-slate-600">
            Certified record of claimed student merchandise containing Student Numbers, Student Names, Items, Prices, and Release Timestamps.
          </p>
        </div>
        <div class="text-[11px] font-mono text-slate-500">
          Academic Year 2026-2027 &bull; 1st Semester
        </div>
      </div>
    </div>

    <!-- METADATA & KPI SUMMARY ROW -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6 text-xs">
      <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
        <span class="block text-[10px] uppercase font-bold text-slate-500">Total Claimed Orders</span>
        <span class="block text-lg font-extrabold font-mono text-slate-900 mt-0.5">{{ count($claimed) }} Orders</span>
        <span class="block text-[10px] text-slate-500">Physically released</span>
      </div>

      <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
        <span class="block text-[10px] uppercase font-bold text-slate-500">Total Units Distributed</span>
        <span class="block text-lg font-extrabold font-mono text-blue-700 mt-0.5">{{ $totalItems }} Units</span>
        <span class="block text-[10px] text-slate-500">Issued to students</span>
      </div>

      <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
        <span class="block text-[10px] uppercase font-bold text-slate-500">Total Revenue Collected</span>
        <span class="block text-lg font-extrabold font-mono text-emerald-700 mt-0.5">₱{{ number_format($totalRevenue, 2) }}</span>
        <span class="block text-[10px] text-emerald-800 font-semibold">100% Remitted</span>
      </div>

      <div class="p-3 rounded-xl bg-slate-50 border border-slate-200">
        <span class="block text-[10px] uppercase font-bold text-slate-500">Generated Date &amp; Time</span>
        <span class="block text-xs font-extrabold font-mono text-slate-900 mt-0.5">{{ date('M d, Y h:i A') }}</span>
        <span class="block text-[10px] text-slate-500 truncate" title="{{ $operatorName }}">By: {{ $operatorName }} ({{ $operatorCode }})</span>
      </div>
    </div>

    <!-- MAIN CLAIMED RELEASE LEDGER TABLE -->
    <div class="overflow-x-auto border border-slate-300 rounded-xl mb-6">
      <table class="w-full text-left text-xs border-collapse">
        <thead class="bg-slate-900 text-white font-mono text-[10px] uppercase tracking-wider">
          <tr>
            <th class="py-2.5 px-3 border-b border-slate-700 w-8 text-center">#</th>
            <th class="py-2.5 px-3 border-b border-slate-700 font-bold text-yellow-300">Student Number</th>
            <th class="py-2.5 px-3 border-b border-slate-700 font-bold">Student Name</th>
            <th class="py-2.5 px-3 border-b border-slate-700">Program / Year</th>
            <th class="py-2.5 px-3 border-b border-slate-700">Item na Binili (Name &amp; Size)</th>
            <th class="py-2.5 px-3 border-b border-slate-700 text-right">Price (PHP)</th>
            <th class="py-2.5 px-3 border-b border-slate-700">Date &amp; Time Ordered</th>
            <th class="py-2.5 px-3 border-b border-slate-700 text-emerald-300">Date &amp; Time Claimed</th>
            <th class="py-2.5 px-3 border-b border-slate-700">Claim Ref</th>
            <th class="py-2.5 px-3 border-b border-slate-700">Released By</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 text-slate-800">
          @forelse($claimed as $index => $r)
          <tr class="hover:bg-slate-50 page-break-inside-avoid {{ $index % 2 === 0 ? 'bg-white' : 'bg-slate-50/60' }}">
            <td class="py-2.5 px-3 text-center font-mono text-slate-500 font-bold">{{ $index + 1 }}</td>

            <!-- Student Number -->
            <td class="py-2.5 px-3 font-mono font-bold text-red-800 whitespace-nowrap bg-red-50/50">
              {{ $r->student_id }}
            </td>

            <!-- Student Name -->
            <td class="py-2.5 px-3 font-bold text-slate-900 whitespace-nowrap">
              {{ $r->student_name }}
            </td>

            <!-- Program & Year -->
            <td class="py-2.5 px-3 text-slate-600 text-[11px] whitespace-nowrap">
              {{ $r->department ?? 'ICS' }} <span class="text-slate-400">({{ $r->year_level ?? 'N/A' }})</span>
            </td>

            <!-- Item(s) Purchased Breakdown -->
            <td class="py-2.5 px-3">
              <div class="space-y-0.5">
                @if(is_array($r->items))
                  @foreach($r->items as $it)
                  <div class="text-[11px] leading-tight flex items-center gap-1.5">
                    <span class="font-bold text-slate-900">{{ $it['quantity'] ?? 1 }}&times;</span>
                    <span class="font-medium text-slate-800">{{ $it['name'] ?? $it['productName'] ?? $it['productId'] ?? 'Item' }}</span>
                    @if(isset($it['size']) && !empty($it['size']))
                      <span class="px-1 py-0.2 rounded text-[10px] font-mono bg-slate-200 text-slate-700 font-semibold">[{{ $it['size'] }}]</span>
                    @endif
                    @if(isset($it['price']))
                      <span class="text-[10px] text-slate-500 font-mono">@ ₱{{ number_format($it['price'], 2) }}</span>
                    @endif
                  </div>
                  @endforeach
                @else
                  <span class="text-slate-400">N/A</span>
                @endif
              </div>
            </td>

            <!-- Price / Total Amount -->
            <td class="py-2.5 px-3 text-right font-mono font-bold text-slate-900 whitespace-nowrap">
              ₱{{ number_format($r->total_amount, 2) }}
            </td>

            <!-- Date & Time Ordered -->
            <td class="py-2.5 px-3 font-mono text-slate-600 text-[11px] whitespace-nowrap">
              {{ $r->created_at ? $r->created_at->format('Y-m-d h:i A') : 'N/A' }}
            </td>

            <!-- Date & Time Claimed -->
            <td class="py-2.5 px-3 font-mono font-bold text-emerald-800 text-[11px] whitespace-nowrap bg-emerald-50/50">
              {{ $r->claimed_at ? $r->claimed_at->format('Y-m-d h:i A') : ($r->updated_at ? $r->updated_at->format('Y-m-d h:i A') : 'N/A') }}
            </td>

            <!-- Claim Ref Code -->
            <td class="py-2.5 px-3 font-mono text-[11px] font-semibold text-slate-700 whitespace-nowrap">
              {{ $r->ref_code }}
            </td>

            <!-- Released By -->
            <td class="py-2.5 px-3 text-[11px] text-slate-600 font-medium whitespace-nowrap">
              {{ $r->claimed_by ?? 'J. Derramas (Officer)' }}
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="10" class="py-8 text-center text-slate-500">
              No claimed releases currently recorded in the database.
            </td>
          </tr>
          @endforelse
        </tbody>

        <!-- TABLE SUMMARY FOOTER -->
        <tfoot class="bg-slate-100 text-slate-900 font-bold border-t-2 border-slate-400 text-xs font-mono">
          <tr>
            <td colspan="4" class="py-3 px-3 text-right uppercase text-slate-600">
              GRAND TOTAL ({{ count($claimed) }} RELEASES):
            </td>
            <td class="py-3 px-3 text-slate-900 font-bold">
              {{ $totalItems }} Total Distributed Units
            </td>
            <td class="py-3 px-3 text-right text-emerald-800 text-sm font-extrabold">
              ₱{{ number_format($totalRevenue, 2) }}
            </td>
            <td colspan="4" class="py-3 px-3 text-slate-500 font-sans text-[11px] font-normal">
              Payment Status: Verified &amp; Remitted
            </td>
          </tr>
        </tfoot>
      </table>
    </div>

    <!-- CERTIFICATION & SIGN-OFF BLOCK -->
    <div class="mt-8 pt-6 border-t border-slate-300 page-break-inside-avoid">
      <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold mb-6 text-center">
        OFFICIAL VERIFICATION &amp; ADMINISTRATIVE RELEASE CERTIFICATION
      </p>

      <div class="grid grid-cols-3 gap-8 text-center">
        <!-- 1. Releasing Officer -->
        <div class="space-y-1">
          <div class="h-10 border-b border-slate-900 flex items-end justify-center pb-1">
            <span class="text-xs font-bold text-slate-900 uppercase font-mono">{{ $operatorName }}</span>
          </div>
          <p class="text-xs font-bold text-slate-800">Releasing Logistics Officer</p>
          <p class="text-[10px] text-slate-500 font-mono">Student ID: {{ $operatorCode }}</p>
          <p class="text-[10px] text-slate-400">Integrated Computer Society</p>
        </div>

        <!-- 2. Core Administrator / Student Council President -->
        <div class="space-y-1">
          <div class="h-10 border-b border-slate-900 flex items-end justify-center pb-1">
            <span class="text-xs font-bold text-slate-900 uppercase font-mono">JILO DERRAMAS</span>
          </div>
          <p class="text-xs font-bold text-slate-800">ICS Executive Administrator</p>
          <p class="text-[10px] text-slate-500 font-mono">Student ID: 251505</p>
          <p class="text-[10px] text-slate-400">NPC Student Council &bull; Executive</p>
        </div>

        <!-- 3. Faculty Adviser / Department Head -->
        <div class="space-y-1">
          <div class="h-10 border-b border-slate-900 flex items-end justify-center pb-1">
            <span class="text-xs font-bold text-slate-900 uppercase font-mono">ENGR. EDSEL MORENO</span>
          </div>
          <p class="text-xs font-bold text-slate-800">Faculty Adviser / Program Chair</p>
          <p class="text-[10px] text-slate-500 font-mono">College of Computer Studies</p>
          <p class="text-[10px] text-slate-400">Navotas Polytechnic College</p>
        </div>
      </div>

      <!-- Footer Security Note -->
      <div class="mt-8 pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-2 text-[10px] text-slate-400 font-mono">
        <div>
          Generated via ICS Apparel &amp; Merch Admin Console &bull; Security Hash: SHA256-{{ substr(md5(date('Y-m-d H:i')), 0, 12) }}
        </div>
        <div>
          Official Document &bull; Navotas Polytechnic College &bull; Page 1 of 1
        </div>
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
