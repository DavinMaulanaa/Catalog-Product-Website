<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Collarbone')</title>
  <link rel="icon" href="{{ asset('img/collarbone.jpg') }}">
  <meta name="description"
    content="Purwokerto-based unisex streetwear brand focused on quality, comfort, and timeless design.">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('dist/output.css') }}">

  @stack('styles')

  <style>
    /* === Accent Bar Gradient === */
    .accent-bar { background: linear-gradient(90deg, #2a9d9d, #1a6b6b, #2a9d9d); background-size: 200% 100%; animation: shimmer 6s ease-in-out infinite; }
    @keyframes shimmer { 0%,100%{background-position:0% 50%} 50%{background-position:100% 50%} }

    /* === Subtle body background === */
    body { background: #fafaf9; }

    /* === Section separator === */
    .section-divider { height: 1px; background: linear-gradient(90deg, transparent, #2a9d9d33, transparent); margin: 0 auto; max-width: 200px; }

    /* === Cart Sidebar === */
    #cartSidebar { transform: translateX(100%); transition: transform 0.4s cubic-bezier(0.32,0.72,0,1); }
    #cartSidebar.cart-open { transform: translateX(0); }
    #cartOverlay { transition: opacity 0.3s ease; }
    #cartOverlay.cart-visible { opacity: 1; pointer-events: auto; }
    .cart-item-img { width: 56px; height: 68px; object-fit: cover; border-radius: 10px; flex-shrink: 0; }
    .cart-qty-btn { width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border: 1.5px solid #e5e5e5; border-radius: 8px; cursor: pointer; font-size: 14px; background: white; transition: all 0.2s; }
    .cart-qty-btn:hover { border-color: #2a9d9d; background: #f0fdfa; color: #2a9d9d; }
    /* Bounce badge animation */
    @keyframes cartBounce { 0%,100%{transform:scale(1)} 50%{transform:scale(1.4)} }
    .cart-badge-bounce { animation: cartBounce 0.35s ease; }
    /* Floating button glow */
    .cart-float-glow { box-shadow: 0 4px 20px rgba(42,157,157,0.35), 0 0 0 0 rgba(42,157,157,0.3); }
    .cart-float-glow:hover { box-shadow: 0 8px 30px rgba(42,157,157,0.5), 0 0 0 6px rgba(42,157,157,0.1); }
  </style>
</head>

<body class="bg-white text-neutral-900 antialiased">

  <!-- Accent Bar -->
  <div class="h-1 accent-bar"></div>

  <!-- Header -->
  <header
    class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl shadow-[0_1px_3px_rgba(0,0,0,0.04)] transition-all duration-300 border-b border-neutral-100">
    <div class="flex items-center justify-between px-6 lg:px-12 h-[4.5rem]">
      <!-- Logo -->
      <a href="{{ url('/') }}" class="flex items-center group">
        <img src="{{ asset('img/collarbone.jpg') }}" alt="Collarbone Logo"
          class="h-10 w-auto object-contain group-hover:opacity-80 transition-opacity duration-300 rounded-full">
      </a>

      <!-- Desktop Navigation -->
      <nav class="hidden lg:flex items-center gap-10">
        <a href="{{ url('/') }}" class="relative group py-2 block">
          <span
            class="text-xs font-medium tracking-[0.15em] uppercase @if(Request::is('/')) text-orbis-teal @else text-neutral-900 @endif transition-colors group-hover:text-orbis-teal">Dashboard</span>
          <span
            class="absolute bottom-0 left-0 @if(Request::is('/')) w-full @else w-0 @endif h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
        </a>
        <a href="{{ route('new_arrivals') }}" class="relative group py-2 block">
          <span
            class="text-xs font-medium tracking-[0.15em] uppercase @if(Route::currentRouteName() == 'new_arrivals') text-orbis-teal @else text-neutral-900 @endif transition-colors group-hover:text-orbis-teal">New
            Arrivals</span>
          <span
            class="absolute bottom-0 left-0 @if(Route::currentRouteName() == 'new_arrivals') w-full @else w-0 @endif h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
        </a>
        <a href="{{ route('categories') }}" class="relative group py-2 block">
          <span
            class="text-xs font-medium tracking-[0.15em] uppercase @if(Route::currentRouteName() == 'categories') text-orbis-teal @else text-neutral-900 @endif transition-colors group-hover:text-orbis-teal">Categories</span>
          <span
            class="absolute bottom-0 left-0 @if(Route::currentRouteName() == 'categories') w-full @else w-0 @endif h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
        </a>
      </nav>



      <!-- Mobile Menu Toggle -->
      <button id="menuToggle" class="lg:hidden group p-2 hover:bg-neutral-100 rounded-full transition-colors">
        <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
          stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
          class="group-hover:stroke-orbis-teal transition-colors">
          <line x1="3" x2="21" y1="6" y2="6" />
          <line x1="3" x2="21" y1="12" y2="12" />
          <line x1="3" x2="21" y1="18" y2="18" />
        </svg>
        <svg id="closeIcon" class="hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
          fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
          class="group-hover:stroke-orbis-teal transition-colors">
          <path d="M18 6 6 18" />
          <path d="m6 6 12 12" />
        </svg>
      </button>
    </div>

    <!-- Mobile Navigation -->
    <nav id="mobileMenu"
      class="lg:hidden hidden absolute top-full left-0 right-0 h-[calc(100vh-4.5rem)] bg-white overflow-y-auto border-t border-neutral-100 shadow-xl z-40">
      <div class="py-12 px-6 space-y-8 flex flex-col items-center">
        <a href="{{ url('/') }}" class="group">
          <span class="relative inline-block text-sm font-medium tracking-[0.2em] uppercase
            @if(Route::currentRouteName() == 'home') @else text-neutral-900 @endif
            group-hover:text-orbis-teal transition-colors">
            Dashboard
            <span class="absolute -bottom-1 left-0 w-0
              h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
          </span>
        </a>
        <a href="{{ route('new_arrivals') }}" class="group">
          <span class="relative inline-block text-sm font-medium tracking-[0.2em] uppercase
            @if(Route::currentRouteName() == 'new_arrivals') text-orbis-teal @else text-neutral-900 @endif
            group-hover:text-orbis-teal transition-colors">
            New Arrivals
            <span class="absolute -bottom-1 left-0
              @if(Route::currentRouteName() == 'new_arrivals') w-full @else w-0 @endif
              h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
          </span>
        </a>
        <a href="{{ route('categories') }}" class="group">
          <span class="relative inline-block text-sm font-medium tracking-[0.2em] uppercase
            @if(Route::currentRouteName() == 'categories') text-orbis-teal @else text-neutral-900 @endif
            group-hover:text-orbis-teal transition-colors">
            Categories
            <span class="absolute -bottom-1 left-0
              @if(Route::currentRouteName() == 'categories') w-full @else w-0 @endif
              h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
          </span>
        </a>
      </div>
    </nav>
  </header>

  @yield('content')

  <!-- Footer -->
  <footer class="bg-neutral-950 relative overflow-hidden">
    <!-- Decorative top gradient line -->
    <div class="h-[2px] bg-gradient-to-r from-transparent via-[#2a9d9d] to-transparent"></div>
    <div class="w-full mx-auto px-6 max-w-[1400px] py-16">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-8 mb-12">
        <!-- Brand -->
        <div class="flex flex-col items-center md:items-start gap-4">
          <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <img src="{{ asset('img/collarbone.jpg') }}" alt="Collarbone" class="h-10 w-auto rounded-full ring-2 ring-neutral-800 group-hover:ring-[#2a9d9d] transition-all">
            <span class="text-white text-sm font-medium tracking-[0.15em] uppercase">Collarbone</span>
          </a>
          <p class="text-neutral-500 text-xs leading-relaxed max-w-[260px] text-center md:text-left">Purwokerto-based unisex streetwear brand focused on quality, comfort, and timeless design.</p>
        </div>
        <!-- Quick Links -->
        <div class="flex flex-col items-center gap-4">
          <h4 class="text-[10px] tracking-[0.25em] uppercase text-[#2a9d9d] font-medium">Quick Links</h4>
          <div class="flex flex-col items-center gap-2.5">
            <a href="{{ url('/') }}" class="text-xs tracking-wider text-neutral-500 hover:text-white transition-colors">Dashboard</a>
            <a href="{{ route('new_arrivals') }}" class="text-xs tracking-wider text-neutral-500 hover:text-white transition-colors">New Arrivals</a>
            <a href="{{ route('categories') }}" class="text-xs tracking-wider text-neutral-500 hover:text-white transition-colors">Categories</a>
          </div>
        </div>
        <!-- Contact -->
        <div class="flex flex-col items-center md:items-end gap-4">
          <h4 class="text-[10px] tracking-[0.25em] uppercase text-[#2a9d9d] font-medium">Get In Touch</h4>
          <a href="https://wa.me/6288802612864" target="_blank" class="flex items-center gap-2 text-xs text-neutral-500 hover:text-[#25D366] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.999 2C6.477 2 2 6.484 2 12.017c0 1.99.522 3.861 1.438 5.479L2.05 21.87a.5.5 0 0 0 .611.61l4.474-1.369A9.953 9.953 0 0 0 12 22c5.522 0 10-4.484 10-10.017C22 6.483 17.522 2 11.999 2z" fill-rule="evenodd" clip-rule="evenodd"/></svg>
            WhatsApp
          </a>
          <p class="text-xs text-neutral-600">Banyumas, Central Java</p>
        </div>
      </div>
      <!-- Bottom bar -->
      <div class="border-t border-neutral-800/50 pt-6 flex flex-col md:flex-row items-center justify-between gap-3">
        <p class="text-[11px] text-neutral-600 tracking-wider">&copy; 2026 Collarbone. All rights reserved.</p>
        <p class="text-[10px] text-neutral-700 tracking-wider">EST. 2024 &mdash; Purwokerto</p>
      </div>
    </div>
    <!-- Decorative teal glow -->
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[400px] h-[200px] bg-[#2a9d9d]/5 blur-[100px] pointer-events-none"></div>
  </footer>

  <!-- Floating Cart Button -->
  <button id="cartToggleBtn" class="fixed bottom-6 right-6 z-[140] p-4 bg-gradient-to-br from-[#2a9d9d] to-[#1a7a7a] text-white border-none rounded-2xl cart-float-glow hover:-translate-y-1 transition-all duration-300 pointer-events-auto" aria-label="Cart">
    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
    <span id="cartBadge" class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center hidden shadow-sm border-2 border-white">0</span>
  </button>

  <!-- Cart Overlay -->
  <div id="cartOverlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-[150] opacity-0 pointer-events-none"></div>

  <!-- Cart Sidebar -->
  <aside id="cartSidebar" class="fixed top-0 right-0 h-full w-full max-w-sm bg-white shadow-2xl z-[160] flex flex-col rounded-l-2xl">
    <!-- Header -->
    <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-100">
      <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        <h2 class="text-sm font-semibold tracking-widest uppercase">Cart</h2>
        <span id="cartItemCount" class="text-xs text-neutral-400"></span>
      </div>
      <button id="closeCartBtn" class="p-2 hover:bg-neutral-100 rounded-full transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
      </button>
    </div>
    <!-- Items -->
    <div id="cartItemsContainer" class="flex-1 overflow-y-auto px-5 py-4 space-y-4">
      <!-- Dynamically populated -->
    </div>
    <!-- Empty state -->
    <div id="cartEmptyState" class="hidden flex-1 flex flex-col items-center justify-center text-center px-6 py-12">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d4d4d4" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mb-4"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
      <p class="text-sm text-neutral-400 tracking-wide">Your cart is empty.</p>
      <p class="text-xs text-neutral-300 mt-1">Add items to get started.</p>
    </div>
    <!-- Footer -->
    <div id="cartFooter" class="border-t border-neutral-100 px-5 py-5">
      <div class="flex items-center justify-between mb-4">
        <span class="text-xs text-neutral-500 uppercase tracking-widest">Total</span>
        <span id="cartTotal" class="text-base font-semibold text-neutral-900">IDR 0</span>
      </div>
      <button id="cartCheckoutBtn" class="w-full flex items-center justify-center gap-2 py-3.5 bg-[#25D366] hover:bg-[#1ebe5d] text-white font-medium tracking-widest uppercase text-xs rounded-xl transition-all duration-300 shadow-md mb-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.999 2C6.477 2 2 6.484 2 12.017c0 1.99.522 3.861 1.438 5.479L2.05 21.87a.5.5 0 0 0 .611.61l4.474-1.369A9.953 9.953 0 0 0 12 22c5.522 0 10-4.484 10-10.017C22 6.483 17.522 2 11.999 2z" fill-rule="evenodd" clip-rule="evenodd"/></svg>
        Checkout via WhatsApp
      </button>
      <button id="clearCartBtn" class="w-full py-2.5 text-xs text-neutral-400 hover:text-red-500 tracking-widest uppercase transition-colors">Clear Cart</button>
    </div>
  </aside>

  <!-- JavaScript for interactivity -->
  <script>
    // Mobile menu toggle
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const menuIcon = document.getElementById('menuIcon');
    const closeIcon = document.getElementById('closeIcon');
    if (menuToggle) {
      menuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
      });
    }
  </script>
  @stack('scripts')

  <!-- ===== Cart System Script ===== -->
  <script>
  (function(){
    const WA_NUMBER = '6281234567890'; // ← GANTI nomer WA toko
    const CART_KEY  = 'collarbone_cart';

    /* ── helpers ── */
    function loadCart() { try { return JSON.parse(localStorage.getItem(CART_KEY)) || []; } catch(e){ return []; } }
    function saveCart(c){ localStorage.setItem(CART_KEY, JSON.stringify(c)); }
    function cartKey(item){ return item.name + '|' + (item.size||'') + '|' + (item.color||''); }

    /* ── add to cart (called from each page's add-to-cart buttons via custom event) ── */
    window.addToCart = function(item) {
      const cart = loadCart();
      const key  = cartKey(item);
      const existing = cart.find(c => cartKey(c) === key);
      if (existing) { existing.qty += (item.qty || 1); }
      else { cart.push({ name: item.name, price: item.price, size: item.size||'', color: item.color||'', image: item.image||'', qty: item.qty||1 }); }
      saveCart(cart);
      renderCart();
      const badge = document.getElementById('cartBadge');
      if (badge) { badge.classList.add('cart-badge-bounce'); setTimeout(()=>badge.classList.remove('cart-badge-bounce'),400); }
    };

    /* ── render sidebar ── */
    function renderCart() {
      const cart = loadCart();
      const container = document.getElementById('cartItemsContainer');
      const empty     = document.getElementById('cartEmptyState');
      const footer    = document.getElementById('cartFooter');
      const badge     = document.getElementById('cartBadge');
      const countEl   = document.getElementById('cartItemCount');
      if (!container) return;

      const totalQty = cart.reduce((s,c)=>s+c.qty,0);
      const totalAmt = cart.reduce((s,c)=>s+(c.price*c.qty),0);

      // badge
      if (badge) {
        if (totalQty > 0) { badge.textContent = totalQty > 99 ? '99+' : totalQty; badge.classList.remove('hidden'); }
        else badge.classList.add('hidden');
      }
      if (countEl) countEl.textContent = totalQty > 0 ? `(${totalQty} item${totalQty>1?'s':''})` : '';

      // total
      const totalEl = document.getElementById('cartTotal');
      if (totalEl) totalEl.textContent = 'IDR ' + totalAmt.toLocaleString('id-ID');

      // empty / items
      if (cart.length === 0) {
        container.classList.add('hidden'); container.innerHTML = '';
        if (empty) empty.classList.remove('hidden');
        if (footer) footer.classList.add('hidden');
        return;
      }
      if (empty) empty.classList.add('hidden');
      if (footer) footer.classList.remove('hidden');
      container.classList.remove('hidden');

      container.innerHTML = cart.map((item, idx) => `
        <div class="flex gap-3 items-start border-b border-neutral-50 pb-4">
          <img src="${item.image}" alt="${item.name}" class="cart-item-img border border-neutral-100">
          <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold text-neutral-900 leading-tight mb-0.5 truncate">${item.name}</p>
            ${item.size  ? `<p class="text-[10px] text-neutral-400 tracking-wide">Size: ${item.size}</p>`  : ''}
            ${item.color ? `<p class="text-[10px] text-neutral-400 tracking-wide">Color: ${item.color}</p>` : ''}
            <p class="text-xs font-medium text-[#2a9d9d] mt-1">IDR ${(item.price).toLocaleString('id-ID')}</p>
            <div class="flex items-center gap-2 mt-2">
              <button class="cart-qty-btn" onclick="cartChangeQty(${idx}, -1)">−</button>
              <span class="text-xs font-semibold w-4 text-center">${item.qty}</span>
              <button class="cart-qty-btn" onclick="cartChangeQty(${idx}, 1)">+</button>
              <button class="ml-2 text-[10px] text-red-400 hover:text-red-600 tracking-wide uppercase transition-colors" onclick="cartRemove(${idx})">Remove</button>
            </div>
          </div>
        </div>
      `).join('');
    }

    window.cartChangeQty = function(idx, delta) {
      const cart = loadCart();
      if (!cart[idx]) return;
      cart[idx].qty = Math.max(1, cart[idx].qty + delta);
      saveCart(cart); renderCart();
    };

    window.cartRemove = function(idx) {
      const cart = loadCart(); cart.splice(idx, 1); saveCart(cart); renderCart();
    };

    /* ── open / close ── */
    function openCart()  { document.getElementById('cartSidebar').classList.add('cart-open'); document.getElementById('cartOverlay').classList.add('cart-visible'); document.body.style.overflow = 'hidden'; }
    function closeCart() { document.getElementById('cartSidebar').classList.remove('cart-open'); document.getElementById('cartOverlay').classList.remove('cart-visible'); document.body.style.overflow = ''; }

    document.addEventListener('DOMContentLoaded', function() {
      renderCart();
      const toggleBtn = document.getElementById('cartToggleBtn');
      const closeBtn  = document.getElementById('closeCartBtn');
      const overlay   = document.getElementById('cartOverlay');
      const clearBtn  = document.getElementById('clearCartBtn');
      const checkoutBtn = document.getElementById('cartCheckoutBtn');

      if (toggleBtn)  toggleBtn.addEventListener('click', openCart);
      if (closeBtn)   closeBtn.addEventListener('click', closeCart);
      if (overlay)    overlay.addEventListener('click', closeCart);
      if (clearBtn)   clearBtn.addEventListener('click', () => { saveCart([]); renderCart(); });

      if (checkoutBtn) checkoutBtn.addEventListener('click', () => {
        const cart = loadCart();
        if (!cart.length) { alert('Keranjang masih kosong!'); return; }
        const total = cart.reduce((s,c) => s + c.price * c.qty, 0);
        let msg = 'Halo Collarbone! Saya ingin memesan:\n\n';
        cart.forEach((item, i) => {
          msg += `${i+1}. *${item.name}*`;
          if (item.size)  msg += ` | Size: ${item.size}`;
          if (item.color) msg += ` | Color: ${item.color}`;
          msg += ` | Qty: ${item.qty} | IDR ${(item.price*item.qty).toLocaleString('id-ID')}\n`;
        });
        msg += `\n💰 *Total: IDR ${total.toLocaleString('id-ID')}*\n\nMohon informasi ketersediaan dan cara pembayaran. Terima kasih! 🙏`;
        window.open(`https://wa.me/${WA_NUMBER}?text=${encodeURIComponent(msg)}`, '_blank');
        
        // Auto-clear cart after checkout
        saveCart([]);
        renderCart();
      });

      // Listen for add-to-cart events from pages
      document.addEventListener('cart:add', (e) => addToCart(e.detail));
    });
  })();
  </script>
</body>

</html>
