<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Online Payment Gateway (Test Mode) — ICS Store</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .font-mono { font-family: 'JetBrains Mono', monospace; }
    @keyframes pulse-ring {
      0% { transform: scale(0.95); opacity: 0.8; }
      50% { transform: scale(1.05); opacity: 0.4; }
      100% { transform: scale(0.95); opacity: 0.8; }
    }
    .animate-pulse-ring { animation: pulse-ring 2s infinite ease-in-out; }
  </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col items-center justify-center p-3 sm:p-5 select-none">

  <!-- Main Mobile Gateway Container -->
  <div id="gateway-card" class="max-w-md w-full rounded-3xl overflow-hidden shadow-2xl border border-slate-800 bg-white text-slate-900 transition-all duration-300">

    <!-- Dynamic Brand Header -->
    <div id="brand-header" class="bg-[#007DFE] text-white p-5 transition-colors duration-300 relative overflow-hidden">
      <div class="flex items-center justify-between relative z-10">
        <div class="flex items-center gap-2.5">
          <div id="brand-logo-box" class="w-10 h-10 rounded-2xl bg-white text-[#007DFE] font-black text-lg flex items-center justify-center shadow-md">
            G
          </div>
          <div>
            <div class="flex items-center gap-1.5">
              <h1 id="brand-title" class="text-lg font-black tracking-tight leading-none">GCash Express</h1>
              <span class="text-[9px] font-bold uppercase px-1.5 py-0.5 rounded bg-black/20 text-white">TEST</span>
            </div>
            <p id="brand-subtitle" class="text-[11px] text-white/80 mt-0.5">Secure Online Checkout Simulator</p>
          </div>
        </div>
        <div class="text-right">
          <span class="text-[10px] uppercase tracking-wider text-white/75 block font-semibold">Amount Due</span>
          <span class="text-xl font-black font-mono">₱{{ number_format($paymentData['amount'] ?? 460, 2) }}</span>
        </div>
      </div>

      <!-- Merchant Pill -->
      <div class="mt-4 pt-3 border-t border-white/20 flex items-center justify-between text-xs relative z-10">
        <span class="text-white/80">Merchant:</span>
        <span class="font-bold flex items-center gap-1">
          <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
          Integrated Computer Society (ICS)
        </span>
      </div>
    </div>

    <!-- ============================================================== -->
    <!-- VIEW 1: AUTO-FILL & AUTO-LOGIN SIMULATION (GCASH / MAYA / CARD) -->
    <!-- ============================================================== -->
    <div id="step-login" class="p-5 space-y-4">
      <!-- Auto-Login Status Banner -->
      <div id="auto-login-banner" class="p-3 rounded-2xl bg-blue-50 border border-blue-200 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
          <div id="auto-login-spinner" class="w-5 h-5 rounded-full border-2 border-blue-600 border-t-transparent animate-spin"></div>
          <div>
            <p id="auto-login-title" class="text-xs font-extrabold text-blue-950">Auto-Filling Test Account & Logging In...</p>
            <p id="auto-login-desc" class="text-[10px] text-blue-700">Simulating instant OAuth / MPIN verification for demo</p>
          </div>
        </div>
        <span class="text-[10px] font-mono font-bold px-2 py-0.5 rounded-full bg-blue-600 text-white">AUTO</span>
      </div>

      <!-- Editable Student / Payer Identity (Auto-Filled from Website!) -->
      <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-200 space-y-2.5">
        <div class="flex items-center justify-between">
          <span class="text-[10px] font-extrabold uppercase tracking-wider text-slate-500">Auto-Filled Student Payer Info</span>
          <span class="text-[10px] font-semibold text-emerald-600 flex items-center gap-1">
            ✓ Auto-Synced
          </span>
        </div>
        <div class="grid grid-cols-2 gap-2">
          <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5">Student Name</label>
            <input type="text" id="payer-name" value="{{ $paymentData['student_name'] ?? 'Juan Dela Cruz' }}"
              class="w-full bg-white border border-slate-300 rounded-xl px-2.5 py-1.5 text-xs font-bold text-slate-900 focus:outline-none focus:border-blue-500">
          </div>
          <div>
            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-0.5">Student ID</label>
            <input type="text" id="payer-student-id" value="{{ $paymentData['student_id'] ?? '2024-10822-AIS' }}"
              class="w-full bg-white border border-slate-300 rounded-xl px-2.5 py-1.5 text-xs font-mono font-bold text-slate-900 focus:outline-none focus:border-blue-500">
          </div>
        </div>
      </div>

      <!-- E-WALLET LOGIN FIELDS (GCash / Maya) -->
      <div id="wallet-login-fields" class="space-y-3">
        <div>
          <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Registered Mobile Number (Test)</label>
          <div class="flex items-center bg-slate-100 border border-slate-300 rounded-xl px-3 py-2.5">
            <span class="text-xs font-bold text-slate-500 pr-2 border-r border-slate-300">+63</span>
            <input type="text" id="wallet-phone" value="{{ preg_replace('/^(\+63|0)/', '', $paymentData['contact'] ?? '9171234567') }}"
              class="w-full bg-transparent pl-2.5 text-sm font-mono font-bold text-slate-900 focus:outline-none">
            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded-full">Verified</span>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-2.5">
          <div class="p-2.5 rounded-xl bg-slate-100 border border-slate-200 text-center">
            <span class="text-[10px] font-bold text-slate-500 uppercase block">4-Digit Test MPIN</span>
            <div class="flex justify-center gap-2 mt-1.5" id="mpin-dots">
              <span class="w-3 h-3 rounded-full bg-blue-600"></span>
              <span class="w-3 h-3 rounded-full bg-blue-600"></span>
              <span class="w-3 h-3 rounded-full bg-blue-600"></span>
              <span class="w-3 h-3 rounded-full bg-blue-600"></span>
            </div>
          </div>
          <div class="p-2.5 rounded-xl bg-slate-100 border border-slate-200 text-center">
            <span class="text-[10px] font-bold text-slate-500 uppercase block">6-Digit Test OTP</span>
            <span id="otp-code-display" class="text-sm font-mono font-black text-slate-800 tracking-widest mt-1 block">849201</span>
          </div>
        </div>
      </div>

      <!-- DEBIT / CREDIT CARD FIELDS (Shown when Debit Card tab is selected) -->
      <div id="card-login-fields" class="hidden space-y-3">
        <!-- Realistic Visual Debit Card Preview -->
        <div class="p-4 rounded-2xl bg-gradient-to-br from-indigo-900 via-slate-900 to-blue-950 text-white shadow-lg relative overflow-hidden border border-indigo-500/30">
          <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
              <!-- EMV Gold Chip -->
              <div class="w-9 h-7 rounded-md bg-gradient-to-br from-amber-200 to-amber-500 border border-amber-600 flex items-center justify-center">
                <div class="w-6 h-4 border border-amber-700/50 rounded-sm"></div>
              </div>
              <span class="text-[10px] font-mono uppercase tracking-widest text-indigo-200">SANDBOX DEBIT CARD</span>
            </div>
            <span class="text-sm font-black italic tracking-wider text-white">VISA / MC</span>
          </div>
          <p id="card-visual-number" class="text-base sm:text-lg font-mono font-bold tracking-widest text-amber-100 mb-3">
            4343 •••• •••• 4343
          </p>
          <div class="flex items-center justify-between text-[10px] font-mono uppercase text-indigo-200">
            <div>
              <span class="block text-[8px] text-indigo-400">CARDHOLDER NAME</span>
              <span id="card-visual-name" class="font-bold text-white">{{ strtoupper($paymentData['student_name'] ?? 'JUAN DELA CRUZ') }}</span>
            </div>
            <div class="text-right">
              <span class="block text-[8px] text-indigo-400">EXPIRES</span>
              <span class="font-bold text-white">12/28</span>
            </div>
          </div>
        </div>

        <div class="space-y-2">
          <div>
            <label class="block text-[10px] font-bold text-slate-600 uppercase mb-0.5">Test Card Number (PayMongo Sandbox)</label>
            <input type="text" id="card-number-input" value="4343 4343 4343 4343"
              class="w-full bg-slate-100 border border-slate-300 rounded-xl px-3 py-2 text-xs font-mono font-bold text-slate-900">
          </div>
          <div class="grid grid-cols-2 gap-2">
            <div>
              <label class="block text-[10px] font-bold text-slate-600 uppercase mb-0.5">Expiry Date</label>
              <input type="text" value="12/28" class="w-full bg-slate-100 border border-slate-300 rounded-xl px-3 py-2 text-xs font-mono font-bold text-slate-900">
            </div>
            <div>
              <label class="block text-[10px] font-bold text-slate-600 uppercase mb-0.5">CVV / CVC</label>
              <input type="text" value="888" class="w-full bg-slate-100 border border-slate-300 rounded-xl px-3 py-2 text-xs font-mono font-bold text-slate-900">
            </div>
          </div>
        </div>
      </div>

      <button type="button" onclick="proceedToConfirmStep()" id="login-continue-btn"
        class="w-full py-3.5 px-4 rounded-2xl bg-[#007DFE] hover:opacity-95 text-white font-extrabold text-sm shadow-lg transition flex items-center justify-center gap-2 cursor-pointer">
        <span>Auto-Login & Proceed to Payment</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
      </button>
    </div>

    <!-- ============================================================== -->
    <!-- VIEW 2: LOGGED-IN WALLET / 3DS CONFIRMATION SCREEN             -->
    <!-- ============================================================== -->
    <div id="step-confirm" class="hidden p-5 space-y-4">
      <!-- Logged-in Account Badge -->
      <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
          <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white font-black text-sm flex items-center justify-center shadow">
            ✓
          </div>
          <div>
            <div class="flex items-center gap-1.5">
              <p id="logged-in-name" class="text-xs font-black text-slate-900">{{ $paymentData['student_name'] ?? 'Juan Dela Cruz' }}</p>
              <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-emerald-600 text-white uppercase">Logged In</span>
            </div>
            <p id="logged-in-sub" class="text-[11px] font-mono text-slate-600">+63 917 123 4567 • Auto-Verified</p>
          </div>
        </div>
        <button type="button" onclick="showEditStep()" class="text-[10px] font-bold text-blue-600 underline hover:text-blue-800">
          Edit Info
        </button>
      </div>

      <!-- Available Test Balance Box -->
      <div class="p-4 rounded-2xl bg-slate-900 text-white space-y-2.5">
        <div class="flex items-center justify-between text-xs">
          <span class="text-slate-400 font-medium" id="balance-label">Available Wallet Balance (Test):</span>
          <span class="font-mono font-bold text-emerald-400">₱25,450.00</span>
        </div>
        <div class="pt-2.5 border-t border-slate-800 flex items-center justify-between">
          <div>
            <span class="text-[10px] uppercase font-bold text-slate-400 block">Total Amount to Pay</span>
            <span class="text-xl font-black font-mono text-amber-400">₱{{ number_format($paymentData['amount'] ?? 460, 2) }}</span>
          </div>
          <div class="text-right">
            <span class="text-[10px] text-slate-400 block">Payment Ref Preview</span>
            <span id="preview-ref-code" class="text-xs font-mono font-bold text-white">GCASH-{{ date('Ymd') }}</span>
          </div>
        </div>
      </div>

      <!-- Order Breakdown -->
      <div class="bg-slate-50 rounded-2xl p-3.5 border border-slate-200 text-xs space-y-1.5">
        <div class="flex justify-between text-slate-500">
          <span>Merchant:</span>
          <span class="font-bold text-slate-800">ICS Apparel & Merch Store</span>
        </div>
        <div class="flex justify-between text-slate-500">
          <span>Student ID:</span>
          <span id="confirm-student-id" class="font-mono font-bold text-slate-800">{{ $paymentData['student_id'] ?? '2024-10822-AIS' }}</span>
        </div>
        <div class="flex justify-between text-slate-500">
          <span>Real-Time Website Sync:</span>
          <span class="font-bold text-emerald-600">Active (Instant Auto-Submit)</span>
        </div>
      </div>

      <!-- 1-Tap Complete Payment Button -->
      <button type="button" onclick="completeTestPayment()" id="pay-now-btn"
        class="w-full py-4 px-5 rounded-2xl bg-[#007DFE] hover:opacity-95 text-white font-black text-sm shadow-xl transition transform active:scale-98 flex items-center justify-center gap-2 cursor-pointer">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span id="pay-now-btn-text">PAY ₱{{ number_format($paymentData['amount'] ?? 460, 2) }} NOW</span>
      </button>
    </div>

    <!-- ============================================================== -->
    <!-- VIEW 3: OFFICIAL DIGITAL RECEIPT SCREEN (REAL-TIME PAID)       -->
    <!-- ============================================================== -->
    <div id="step-receipt" class="hidden p-5 text-center space-y-4">
      <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-3xl font-black shadow-inner">
        ✓
      </div>
      <div>
        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800">
          Real-Time Payment Confirmed
        </span>
        <h2 class="text-xl font-black text-slate-900 mt-1">₱{{ number_format($paymentData['amount'] ?? 460, 2) }} Paid!</h2>
        <p class="text-xs text-slate-500 mt-0.5">
          This payment was synchronized in <strong>real-time</strong> with the ICS Store! Your official receipt and reference code have been auto-attached to your order.
        </p>
      </div>

      <!-- Receipt Card Details -->
      <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-left text-xs space-y-2">
        <div class="flex justify-between">
          <span class="text-slate-500">Payment Channel:</span>
          <span id="receipt-method-text" class="font-bold text-slate-900">GCash Online</span>
        </div>
        <div class="flex justify-between">
          <span class="text-slate-500">Reference No.:</span>
          <span id="receipt-ref-text" class="font-mono font-black text-blue-700"></span>
        </div>
        <div class="flex justify-between">
          <span class="text-slate-500">Paid By:</span>
          <span id="receipt-student-text" class="font-bold text-slate-900"></span>
        </div>
        <div class="flex justify-between">
          <span class="text-slate-500">Status:</span>
          <span class="font-bold text-emerald-600">VERIFIED & AUTO-ATTACHED</span>
        </div>
      </div>

      <div class="p-3 rounded-2xl bg-emerald-950 text-emerald-200 text-xs font-semibold flex items-center justify-center gap-2">
        <svg class="w-4 h-4 text-emerald-400 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span>Laptop / Main Website Updated in Real-Time!</span>
      </div>
    </div>

    <!-- Footer Security Notice -->
    <div class="bg-slate-50 px-5 py-3 border-t border-slate-200 flex items-center justify-between text-[11px] text-slate-500">
      <span>Integrated Computer Society Checkout</span>
      <span class="text-emerald-600 font-semibold flex items-center gap-1">
        <span>🔒 256-Bit SSL Encrypted</span>
      </span>
    </div>
  </div>

  <!-- Hidden Canvas for Generating High-Resolution Receipt Image -->
  <canvas id="receipt-canvas" width="600" height="820" class="hidden"></canvas>

  <script>
    const TOKEN = @json($token);
    const AMOUNT = Number(@json($paymentData['amount'] ?? 460));
    const INITIAL_STATUS = @json($paymentData['status'] ?? 'scanned');
    let currentChannel = @json($paymentData['method'] ?? 'GCash Online');
    let autoLoginTimer = null;

    function applyChannelTheme(channel) {
      currentChannel = channel;
      const header = document.getElementById('brand-header');
      const logoBox = document.getElementById('brand-logo-box');
      const title = document.getElementById('brand-title');
      const subtitle = document.getElementById('brand-subtitle');
      const walletFields = document.getElementById('wallet-login-fields');
      const cardFields = document.getElementById('card-login-fields');
      const loginBtn = document.getElementById('login-continue-btn');
      const payNowBtn = document.getElementById('pay-now-btn');
      const balanceLabel = document.getElementById('balance-label');
      const previewRef = document.getElementById('preview-ref-code');

      if (channel === 'Maya Online') {
        header.className = 'bg-slate-900 text-white p-5 transition-colors duration-300 border-b-4 border-emerald-400';
        logoBox.className = 'w-10 h-10 rounded-2xl bg-emerald-400 text-slate-950 font-black text-lg flex items-center justify-center shadow-md';
        logoBox.textContent = 'M';
        title.textContent = 'Maya Checkout';
        subtitle.textContent = 'Maya E-Wallet Sandbox Gateway';
        walletFields.classList.remove('hidden');
        cardFields.classList.add('hidden');
        loginBtn.className = 'w-full py-3.5 px-4 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-sm shadow-lg transition flex items-center justify-center gap-2 cursor-pointer';
        payNowBtn.className = 'w-full py-4 px-5 rounded-2xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-sm shadow-xl transition flex items-center justify-center gap-2 cursor-pointer';
        balanceLabel.textContent = 'Maya Wallet Balance (Test):';
        previewRef.textContent = 'MAYA-' + new Date().toISOString().slice(0,10).replace(/-/g,'');
      } else if (channel === 'Debit/Credit Card') {
        header.className = 'bg-gradient-to-r from-indigo-900 to-slate-900 text-white p-5 transition-colors duration-300';
        logoBox.className = 'w-10 h-10 rounded-2xl bg-amber-400 text-slate-950 font-black text-sm flex items-center justify-center shadow-md';
        logoBox.textContent = '💳';
        title.textContent = 'Bank Card 3DS';
        subtitle.textContent = 'Visa / Mastercard Sandbox Debit';
        walletFields.classList.add('hidden');
        cardFields.classList.remove('hidden');
        loginBtn.className = 'w-full py-3.5 px-4 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white font-black text-sm shadow-lg transition flex items-center justify-center gap-2 cursor-pointer';
        payNowBtn.className = 'w-full py-4 px-5 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white font-black text-sm shadow-xl transition flex items-center justify-center gap-2 cursor-pointer';
        balanceLabel.textContent = 'Available Debit Limit (Test):';
        previewRef.textContent = 'CARD-' + new Date().toISOString().slice(0,10).replace(/-/g,'');
      } else {
        header.className = 'bg-[#007DFE] text-white p-5 transition-colors duration-300';
        logoBox.className = 'w-10 h-10 rounded-2xl bg-white text-[#007DFE] font-black text-lg flex items-center justify-center shadow-md';
        logoBox.textContent = 'G';
        title.textContent = 'GCash Express';
        subtitle.textContent = 'GCash Online Sandbox Checkout';
        walletFields.classList.remove('hidden');
        cardFields.classList.add('hidden');
        loginBtn.className = 'w-full py-3.5 px-4 rounded-2xl bg-[#007DFE] hover:opacity-95 text-white font-extrabold text-sm shadow-lg transition flex items-center justify-center gap-2 cursor-pointer';
        payNowBtn.className = 'w-full py-4 px-5 rounded-2xl bg-[#007DFE] hover:opacity-95 text-white font-black text-sm shadow-xl transition flex items-center justify-center gap-2 cursor-pointer';
        balanceLabel.textContent = 'GCash Wallet Balance (Test):';
        previewRef.textContent = 'GCASH-' + new Date().toISOString().slice(0,10).replace(/-/g,'');
      }
    }

    function switchChannel(channel) {
      applyChannelTheme(channel);
      notifyStepUpdate('scanned', channel);
    }

    async function notifyStepUpdate(status, methodOverride = null) {
      try {
        await fetch(`/api/payment/sandbox/${TOKEN}/step`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            status: status,
            method: methodOverride || currentChannel,
            student_name: document.getElementById('payer-name').value,
            student_id: document.getElementById('payer-student-id').value,
            contact: '+63' + document.getElementById('wallet-phone').value
          })
        });
      } catch (e) {}
    }

    function proceedToConfirmStep() {
      if (autoLoginTimer) clearTimeout(autoLoginTimer);
      const name = document.getElementById('payer-name').value || 'Juan Dela Cruz';
      const stuId = document.getElementById('payer-student-id').value || '2024-10822-AIS';
      const phone = document.getElementById('wallet-phone').value || '9171234567';

      document.getElementById('logged-in-name').textContent = name;
      document.getElementById('confirm-student-id').textContent = stuId;
      document.getElementById('card-visual-name').textContent = name.toUpperCase();

      if (currentChannel === 'Debit/Credit Card') {
        document.getElementById('logged-in-sub').textContent = 'Visa Debit •••• 4343 • 3DS Verified';
      } else {
        document.getElementById('logged-in-sub').textContent = `+63 ${phone} • ${currentChannel.replace(' Online', '')} Verified`;
      }

      document.getElementById('step-login').classList.add('hidden');
      document.getElementById('step-confirm').classList.remove('hidden');

      notifyStepUpdate('authenticated');
    }

    function showEditStep() {
      if (autoLoginTimer) clearTimeout(autoLoginTimer);
      document.getElementById('step-confirm').classList.add('hidden');
      document.getElementById('step-login').classList.remove('hidden');
    }

    /**
     * Generate a clean, high-resolution Digital Payment Receipt Image on Canvas
     */
    function generateDigitalReceiptBase64(refNo, name, stuId, channel) {
      const canvas = document.getElementById('receipt-canvas');
      const ctx = canvas.getContext('2d');

      // Background
      ctx.fillStyle = '#0f172a';
      ctx.fillRect(0, 0, canvas.width, canvas.height);

      // Header Banner
      if (channel === 'Maya Online') {
        ctx.fillStyle = '#10b981';
      } else if (channel === 'Debit/Credit Card') {
        ctx.fillStyle = '#4f46e5';
      } else {
        ctx.fillStyle = '#007DFE';
      }
      ctx.fillRect(30, 30, 540, 130);

      // Header Text
      ctx.fillStyle = '#ffffff';
      ctx.font = 'bold 28px Inter, sans-serif';
      ctx.fillText(channel.toUpperCase() + ' OFFICIAL RECEIPT', 55, 85);
      ctx.font = '16px Inter, sans-serif';
      ctx.fillText('SANDBOX / REAL-TIME VERIFIED TRANSACTION', 55, 120);

      // White Receipt Body
      ctx.fillStyle = '#ffffff';
      ctx.fillRect(30, 160, 540, 620);

      // Amount Box
      ctx.fillStyle = '#f1f5f9';
      ctx.fillRect(60, 195, 480, 110);
      ctx.fillStyle = '#64748b';
      ctx.font = 'bold 15px Inter, sans-serif';
      ctx.fillText('TOTAL AMOUNT PAID', 85, 230);
      ctx.fillStyle = '#0f172a';
      ctx.font = 'bold 42px monospace';
      ctx.fillText('PHP ' + AMOUNT.toFixed(2), 85, 282);

      // Details Rows
      const rows = [
        ['STATUS', 'PAID & VERIFIED (REAL-TIME)'],
        ['REFERENCE NO.', refNo],
        ['MERCHANT', 'Integrated Computer Society (ICS)'],
        ['STUDENT BUYER', name],
        ['STUDENT ID', stuId],
        ['PAYMENT METHOD', channel],
        ['DATE & TIME', new Date().toLocaleString()]
      ];

      let y = 360;
      rows.forEach(([label, val]) => {
        ctx.fillStyle = '#64748b';
        ctx.font = 'bold 14px Inter, sans-serif';
        ctx.fillText(label, 65, y);

        ctx.fillStyle = label === 'STATUS' ? '#059669' : '#0f172a';
        ctx.font = 'bold 16px monospace';
        ctx.fillText(String(val), 245, y);

        ctx.strokeStyle = '#e2e8f0';
        ctx.beginPath();
        ctx.moveTo(65, y + 18);
        ctx.lineTo(535, y + 18);
        ctx.stroke();

        y += 52;
      });

      // Footer Stamp
      ctx.fillStyle = '#059669';
      ctx.font = 'bold 16px Inter, sans-serif';
      ctx.fillText('✓ AUTHENTICATED BY ICS ONLINE PAYMENT SANDBOX', 95, 745);

      return canvas.toDataURL('image/png');
    }

    async function completeTestPayment() {
      const btn = document.getElementById('pay-now-btn');
      btn.disabled = true;
      document.getElementById('pay-now-btn-text').textContent = 'Processing Real-Time Payment...';

      const name = document.getElementById('payer-name').value || 'Juan Dela Cruz';
      const stuId = document.getElementById('payer-student-id').value || '2024-10822-AIS';
      const phone = '+63' + (document.getElementById('wallet-phone').value || '9171234567');

      const prefix = currentChannel === 'Maya Online' ? 'MAYA' : (currentChannel === 'Debit/Credit Card' ? 'CARD' : 'GCASH');
      const refNo = `${prefix}-${new Date().toISOString().slice(0,10).replace(/-/g,'')}-${Math.floor(100000 + Math.random() * 900000)}`;
      const receiptBase64 = generateDigitalReceiptBase64(refNo, name, stuId, currentChannel);

      try {
        const res = await fetch(`/api/payment/sandbox/${TOKEN}/complete`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            method: currentChannel,
            reference_number: refNo,
            student_name: name,
            student_id: stuId,
            contact: phone,
            receipt_image: receiptBase64
          })
        });

        const data = await res.json();
        if (data.success) {
          document.getElementById('step-confirm').classList.add('hidden');
          document.getElementById('step-login').classList.add('hidden');
          document.getElementById('step-receipt').classList.remove('hidden');

          document.getElementById('receipt-method-text').textContent = currentChannel;
          document.getElementById('receipt-ref-text').textContent = data.session.reference_number || refNo;
          document.getElementById('receipt-student-text').textContent = `${name} (${stuId})`;
        }
      } catch (err) {
        alert('Network error while completing test payment. Please try again.');
        btn.disabled = false;
        document.getElementById('pay-now-btn-text').textContent = 'PAY ₱' + AMOUNT.toFixed(2) + ' NOW';
      }
    }

    // Initialize UI & Auto-Login Sequence on Load
    window.addEventListener('DOMContentLoaded', () => {
      applyChannelTheme(currentChannel);

      if (INITIAL_STATUS === 'paid') {
        document.getElementById('step-login').classList.add('hidden');
        document.getElementById('step-receipt').classList.remove('hidden');
        document.getElementById('receipt-method-text').textContent = currentChannel;
        document.getElementById('receipt-ref-text').textContent = @json($paymentData['reference_number'] ?? 'GCASH-PAID');
        document.getElementById('receipt-student-text').textContent = document.getElementById('payer-name').value;
        return;
      }

      // Smooth 1.6-second Auto-Fill & Auto-Login Simulation so when scanned, it automatically logs into the wallet!
      autoLoginTimer = setTimeout(() => {
        proceedToConfirmStep();
      }, 1600);
    });
  </script>
</body>
</html>
