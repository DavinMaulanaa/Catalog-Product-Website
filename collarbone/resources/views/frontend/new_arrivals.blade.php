<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Collarbone - New Arrivals</title>
  <link rel="icon" type="image/png" href="{{ asset('img/collarbone.jpg') }}">
  <meta name="description" content="Contemporary streetwear from Jakarta. Minimal design, premium quality." />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'sans-serif'],
          },
          letterSpacing: {
            'widest': '0.15em',
            'super': '0.3em',
            'mega': '0.5em',
          },
          colors: {
            orbis: {
              teal: '#2a9d9d',
              charcoal: '#262626',
              grey: '#808080',
            }
          },
          aspectRatio: {
            'product': '3 / 4',
          },
          keyframes: {
            'fade-in': {
              from: { opacity: '0', transform: 'translateY(10px)' },
              to: { opacity: '1', transform: 'translateY(0)' },
            },
            'slide-up': {
              from: { transform: 'translateY(100%)' },
              to: { transform: 'translateY(0)' }
            }
          },
          animation: {
            'fade-in': 'fade-in 0.6s ease-out forwards',
            'slide-up': 'slide-up 0.3s ease-out forwards',
          },
        },
      },
    }
  </script>

  <style>
    * {
      border-color: hsl(0 0% 90%);
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      font-weight: 400;
      letter-spacing: 0.01em;
      -webkit-font-smoothing: antialiased;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-weight: 400;
      letter-spacing: 0.1em;
      text-transform: uppercase;
    }

    .hero-text-shadow {
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    /* Product Card Styles */
    .product-card-image {
      transition: transform 0.7s cubic-bezier(0.19, 1, 0.22, 1);
    }

    .group:hover .product-card-image {
      transform: scale(1.05);
    }

    /* Product Card Modern Hover */
    .product-card-modern {
      transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
    }
    .product-card-modern:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }

    /* Filter Dropdown */
    .filter-btn {
      position: relative;
    }

    .filter-btn::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 1px;
      background-color: black;
      transition: width 0.3s;
    }

    .filter-btn:hover::after {
      width: 100%;
    }

    /* Scrollbar hide */
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    /* Blur In Animation */
    .blur-in {
      opacity: 0;
      filter: blur(10px);
      transform: scale(0.95);
      transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .blur-in.visible {
      opacity: 1;
      filter: blur(0);
      transform: scale(1);
    }

    .delay-100 {
      transition-delay: 100ms;
    }

    .delay-200 {
      transition-delay: 200ms;
    }

    .delay-300 {
      transition-delay: 300ms;
    }

    /* Flip Card Styles */
    .perspective-1000 {
      perspective: 1000px;
    }

    .transform-style-3d {
      transform-style: preserve-3d;
    }

    .backface-hidden {
      -webkit-backface-visibility: hidden;
      backface-visibility: hidden;
    }

    .rotate-y-180 {
      transform: rotateY(180deg);
    }

    /* ===== TikTok-Style Image Slider ===== */
    .product-slider {
      position: relative;
      width: 100%;
      height: 100%;
      overflow: hidden;
      touch-action: pan-y;
    }

    .product-slider-track {
      display: flex;
      width: 100%;
      height: 100%;
      transition: transform 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      will-change: transform;
    }

    .product-slider-track.is-dragging {
      transition: none;
    }

    .product-slider-slide {
      min-width: 100%;
      width: 100%;
      height: 100%;
      flex-shrink: 0;
    }

    .product-slider-slide img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      pointer-events: none;
      user-select: none;
      -webkit-user-drag: none;
    }

    /* Dot Indicators */
    .slider-dots {
      position: absolute;
      bottom: 10px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 6px;
      z-index: 10;
      padding: 4px 8px;
      border-radius: 20px;
      background: rgba(0, 0, 0, 0.25);
      backdrop-filter: blur(4px);
    }

    .slider-dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.45);
      transition: all 0.3s ease;
      cursor: pointer;
      border: none;
      padding: 0;
    }

    .slider-dot.active {
      background: #ffffff;
      transform: scale(1.3);
      box-shadow: 0 0 4px rgba(255, 255, 255, 0.5);
    }

        .slider-counter {
      position: absolute;
      top: 10px;
      right: 10px;
      z-index: 10;
      font-size: 11px;
      font-weight: 500;
      color: white;
      background: rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(6px);
      padding: 3px 10px;
      border-radius: 20px;
      letter-spacing: 0.05em;
    }

        /* ===== Checkout Modal ===== */
        #checkoutModal { transition: opacity 0.3s ease; }
        #checkoutModal.hidden { display: none; }
        #checkoutDrawer { transition: transform 0.4s cubic-bezier(0.32, 0.72, 0, 1); }
        #checkoutDrawer.translate-y-full { transform: translateY(100%); }
        .size-option { cursor:pointer; padding:6px 14px; border:1.5px solid #e5e5e5; border-radius:10px; font-size:11px; font-weight:500; letter-spacing:0.1em; text-transform:uppercase; transition:all 0.2s; background:white; color:#262626; }
        .size-option:hover, .size-option.selected { background:#262626; color:white; border-color:#262626; }
        .color-option { cursor:pointer; width:30px; height:30px; border-radius:50%; border:2.5px solid #e5e5e5; transition:all 0.2s; }
        .color-option:hover, .color-option.selected { border-color:#2a9d9d; transform:scale(1.15); box-shadow:0 0 0 2px white, 0 0 0 4px #2a9d9d; }
        .qty-btn { width:34px; height:34px; display:flex; align-items:center; justify-content:center; border:1.5px solid #e5e5e5; border-radius:10px; cursor:pointer; font-size:16px; background:white; transition:all 0.2s; }
        .qty-btn:hover { border-color:#2a9d9d; background:#f0fdfa; color:#2a9d9d; }

        /* === Cart Sidebar === */
        #cartSidebar { transition: transform 0.4s cubic-bezier(0.32,0.72,0,1); }
        #cartSidebar.cart-open { transform: translateX(0) !important; }
        #cartOverlay { transition: opacity 0.3s ease; }
        #cartOverlay.cart-visible { opacity: 1; pointer-events: auto; }
        .cart-item-img { width: 56px; height: 68px; object-fit: cover; border-radius: 10px; flex-shrink: 0; }
        .cart-qty-btn { width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border: 1.5px solid #e5e5e5; border-radius: 8px; cursor: pointer; font-size: 14px; background: white; transition: all 0.2s; }
        .cart-qty-btn:hover { border-color: #2a9d9d; background: #f0fdfa; color: #2a9d9d; }
        @keyframes cartBounce { 0%,100%{transform:scale(1)} 50%{transform:scale(1.4)} }
        .cart-badge-bounce { animation: cartBounce 0.35s ease; }
        /* Floating button glow */
        .cart-float-glow { box-shadow: 0 4px 20px rgba(42,157,157,0.35); }
        .cart-float-glow:hover { box-shadow: 0 8px 30px rgba(42,157,157,0.5), 0 0 0 6px rgba(42,157,157,0.1); }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-white text-black">

  <!-- Header -->
  <header
    class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl shadow-[0_1px_3px_rgba(0,0,0,0.04)] transition-all duration-300 border-b border-neutral-100">
    <div class="flex items-center justify-between px-6 lg:px-12 h-[4.5rem]">
      <!-- Logo -->
      <a href="/" class="flex items-center group">
        <img src="{{ asset('img/collarbone.jpg') }}" alt="Collarbone Logo"
          class="h-10 w-auto object-contain group-hover:opacity-80 transition-opacity duration-300 rounded-full">
      </a>

      <!-- Desktop Navigation -->
      <nav class="hidden lg:flex items-center gap-10">
        <a href="{{ route('home') }}" class="relative group py-2 block">
          <span
            class="text-xs font-medium tracking-[0.15em] uppercase text-neutral-900 transition-colors group-hover:text-orbis-teal">Dashboard</span>
          <span
            class="absolute bottom-0 left-0 w-0 h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
        </a>
        <a href="{{ route('new_arrivals') }}" class="relative group py-2 block">
          <span
            class="text-xs font-medium tracking-[0.15em] uppercase text-orbis-teal transition-colors group-hover:text-orbis-teal">New
            Arrivals</span>
          <span
            class="absolute bottom-0 left-0 w-0 h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
        </a>
        <a href="{{ route('categories') }}" class="relative group py-2 block">
          <span
            class="text-xs font-medium tracking-[0.15em] uppercase text-neutral-900 transition-colors group-hover:text-orbis-teal">Categories</span>
          <span
            class="absolute bottom-0 left-0 w-0 h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
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
        <a href="{{ route('home') }}"
          class="text-sm font-medium tracking-[0.2em] uppercase hover:text-orbis-teal transition-colors relative group">
          Dashboard
          <span
            class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-0 h-[1px] bg-orbis-teal transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="{{ route('new_arrivals') }}"
          class="text-sm font-medium tracking-[0.2em] uppercase hover:text-orbis-teal transition-colors relative group">
          New Arrivals
          <span
            class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-0 h-[1px] bg-orbis-teal transition-all duration-300 group-hover:w-full"></span>
        </a>
        <a href="{{ route('categories') }}"
          class="text-sm font-medium tracking-[0.2em] uppercase hover:text-orbis-teal transition-colors relative group">
          Categories
          <span
            class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-0 h-[1px] bg-orbis-teal transition-all duration-300 group-hover:w-full"></span>
        </a>
      </div>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="flex-1">

    <!-- Hero Banner (Editorial Style) -->
    <section class="relative h-[60vh] lg:h-[70vh] w-full bg-neutral-100 flex items-center justify-center overflow-hidden">
      <!-- Background Image with Parallax feel -->
      <div class="absolute inset-0 w-full h-full">
        <img src="{{ $banner->image_url }}" alt="New Collection" class="w-full h-full object-cover opacity-90 scale-105 transform origin-center transition-transform duration-[10s] hover:scale-110">
      </div>
      <div class="absolute inset-0 bg-black/30 backdrop-blur-[2px]"></div>
      
      <!-- Editorial Typography -->
      <div class="relative z-10 flex flex-col items-center justify-center text-center px-4 w-full h-full mix-blend-overlay">
        <!-- Giant overlapping text -->
        <h1 class="text-[5rem] sm:text-[8rem] lg:text-[12rem] font-bold tracking-tighter leading-none text-white opacity-90" style="color: {{ $banner->text_color ?? '#FFFFFF' }}">
          NEW
        </h1>
        <h1 class="text-[5rem] sm:text-[8rem] lg:text-[12rem] font-bold tracking-tighter leading-none text-transparent stroke-text" style="-webkit-text-stroke: 2px {{ $banner->text_color ?? '#FFFFFF' }}; margin-top: -0.4em;">
          ARRIVALS
        </h1>
      </div>

      <!-- Floating Subtitle -->
      <div class="absolute bottom-12 left-6 lg:left-12 z-20 max-w-sm">
        <div class="w-12 h-[2px] bg-white mb-4"></div>
        <p class="text-white text-sm tracking-widest font-light leading-relaxed">
          {{ $banner->subtitle ?? 'SEASON 04' }}
        </p>
      </div>
        <p class="mt-4 text-xs tracking-widest max-w-md mx-auto animate-fade-in hero-text-shadow"
          style="animation-delay: 0.2s;">
          {{ $banner->subtitle }}
        </p>
      </div>
      <!-- Bottom teal accent line -->
      <div class="absolute bottom-0 left-0 right-0 h-[3px] bg-gradient-to-r from-transparent via-[#2a9d9d] to-transparent"></div>
    </section>

    <!-- Filters & Sort -->
    <div class="sticky top-[4.5rem] z-40 bg-white/95 backdrop-blur-xl border-b border-neutral-100 shadow-[0_2px_8px_rgba(0,0,0,0.03)]">
      <div class="flex flex-col md:flex-row items-center justify-between px-6 lg:px-12 py-4 gap-4">

        <!-- Mobile Filter Toggle (visible only on small) -->
        <div class="md:hidden w-full flex justify-between items-center">
          <button class="text-xs uppercase tracking-widest flex items-center gap-2">
            Filters <span
              class="bg-black text-white rounded-full w-4 h-4 flex items-center justify-center text-[8px]">2</span>
          </button>
          <div class="flex items-center gap-2">
            <span class="text-[10px] text-neutral-400 uppercase tracking-widest">Sort by:</span>
            <select class="text-xs uppercase tracking-widest border-none bg-transparent focus:ring-0 cursor-pointer p-0" onchange="updateSort(this.value)">
              <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
              <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
              <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
            </select>
          </div>
        </div>
        <div class="hidden md:flex items-center gap-2">
          <span class="text-[10px] text-neutral-400 uppercase tracking-widest">Sort by:</span>
          <select class="text-xs uppercase tracking-widest border-none bg-transparent focus:ring-0 cursor-pointer" onchange="updateSort(this.value)">
            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
          </select>
        </div>

        <div class="hidden md:flex items-center gap-3">
          <span class="text-[10px] text-[#2a9d9d] uppercase tracking-widest font-medium bg-[#2a9d9d]/10 px-3 py-1 rounded-full">{{ $products->count() }} Products</span>
        </div>
      </div>
    </div>

    <!-- Product Grid -->
    <section class="w-full mx-auto px-6 lg:px-12 py-12 bg-gradient-to-b from-[#f7fafa] via-white to-white relative">
      <!-- Decorative background blobs -->
      <div class="absolute top-20 left-0 w-[250px] h-[250px] bg-[#2a9d9d]/[0.03] rounded-full blur-[80px] pointer-events-none"></div>
      <div class="absolute bottom-40 right-0 w-[200px] h-[200px] bg-[#2a9d9d]/[0.02] rounded-full blur-[60px] pointer-events-none"></div>

      <!-- Section header -->
      <div class="flex items-center gap-4 mb-16">
        <h2 class="text-4xl lg:text-6xl font-black tracking-tighter uppercase text-neutral-900 opacity-10">THE DROP</h2>
      </div>

      <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-16 min-h-[500px] transition-opacity duration-300 relative items-start pb-20">

        @foreach($products as $index => $product)

            <!-- Staggered effect: even items are pushed down on large screens -->
            <article class="group cursor-pointer blur-in delay-{{ ($index % 4) * 100 }} {{ $index % 2 != 0 ? 'lg:translate-y-24 sm:translate-y-12' : '' }}">
              <!-- Image flip container -->
              <div class="perspective-1000 mb-4 relative">
                <div class="relative transition-all duration-700 transform-style-3d w-full aspect-[3/4]">
                  <!-- Front (Slider) -->
                  <div class="absolute inset-0 backface-hidden bg-[#f4f4f4] overflow-hidden product-card-modern border-none shadow-none group-hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)] rounded-none">
                    <div class="product-slider h-full" data-slider>
                      <div class="product-slider-track h-full">
                          @if(!empty($product->image_urls))
                              @foreach($product->image_urls as $img)
                              <div class="product-slider-slide h-full">
                                  <img src="{{ Str::startsWith($img, 'http') ? $img : asset($img) }}" alt="{{ $product->name }}" class="w-full h-full object-cover scale-100 group-hover:scale-105 transition-transform duration-700">
                              </div>
                              @endforeach
                          @else
                              <div class="product-slider-slide h-full"><img src="{{ asset('img/placeholder.jpg') }}" alt="Placeholder" class="w-full h-full object-cover"></div>
                          @endif
                      </div>
                      <div class="slider-dots"></div>
                    </div>
                  </div>
                  <!-- Back (Description) -->
                  <div class="absolute inset-0 backface-hidden rotate-y-180 bg-neutral-900 text-white p-8 flex flex-col items-center justify-center text-center rounded-none shadow-2xl">
                    <h3 class="text-sm font-bold uppercase tracking-widest mb-4">{{ $product->name }}</h3>
                    <p class="text-xs text-neutral-400 leading-relaxed mb-6 font-light">{{ Str::limit($product->description, 100) }}</p>
                  </div>
                </div>
                <!-- Details Button inside photo card -->
                <!-- NEW badge (Editorial style) -->
                <div class="absolute top-4 left-4 z-20">
                  <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-black bg-white px-3 py-1 shadow-md">NEW</span>
                </div>
              </div>
              <!-- Product info (Minimalist) -->
              <div class="mt-6 flex flex-col items-center text-center">
                <p class="text-[9px] tracking-[0.2em] text-[#2a9d9d] uppercase mb-2">{{ $product->category->name ?? 'CATEGORY' }}</p>
                <h3 class="text-base font-medium text-neutral-900 mb-2 uppercase">{{ $product->name }}</h3>
                <p class="text-sm font-light text-neutral-500 mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                
                <!-- Action Buttons (Slide down initially, appearing on hover) -->
                <div class="flex gap-2 opacity-0 transform translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300">
                  <button class="cart-quick-btn p-3 border border-neutral-200 bg-white hover:bg-[#2a9d9d] hover:text-white hover:border-[#2a9d9d] text-neutral-900 transition-all duration-300 rounded-full shadow-sm"
                        data-name="{{ $product->name }}"
                        data-price="{{ (int)$product->price }}"
                        data-sizes='@json($product->sizes ?? [])'
                        data-colors='@json($product->colors ?? [])'
                        data-image="{{ $product->thumbnail ?? asset('img/placeholder.jpg') }}"
                        title="Add to Cart">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    </button>
                    <button
                        class="order-btn uppercase tracking-widest px-6 py-3 bg-[#2a9d9d] hover:bg-neutral-900 text-white transition-all duration-300 rounded-full text-xs font-semibold shadow-md"
                        data-name="{{ $product->name }}"
                        data-price="{{ number_format($product->price, 0, ',', '.') }}"
                        data-sizes='@json($product->sizes ?? [])'
                        data-colors='@json($product->colors ?? [])'
                        data-image="{{ $product->thumbnail ?? asset('img/placeholder.jpg') }}"
                    >Buy Now</button>
                </div>
              </div>
            </article>
        @endforeach

      </div>
    </section>
  </main>

  <!-- CTA Banner Before Footer -->
  <section class="bg-neutral-900 py-16 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-[#2a9d9d]/10 via-transparent to-[#2a9d9d]/10 pointer-events-none"></div>
    <div class="max-w-3xl mx-auto text-center px-6 relative">
      <p class="text-[10px] tracking-[0.3em] uppercase text-[#2a9d9d] font-medium mb-4">Explore More</p>
      <h2 class="text-2xl md:text-4xl font-light tracking-widest text-white mb-6 uppercase">Discover Our Full Collection</h2>
      <p class="text-sm text-neutral-400 mb-8 max-w-md mx-auto">Browse through our curated categories and find the perfect piece for your wardrobe.</p>
      <a href="{{ route('categories') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-[#2a9d9d] hover:bg-[#1a6b6b] text-white text-xs font-medium tracking-[0.2em] uppercase rounded-full transition-all duration-300 shadow-lg hover:shadow-[#2a9d9d]/30">
        View Categories
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
      </a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-neutral-950 relative overflow-hidden">
    <div class="h-[2px] bg-gradient-to-r from-transparent via-[#2a9d9d] to-transparent"></div>
    <div class="w-full mx-auto px-6 max-w-[1400px] py-16">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-8 mb-12">
        <div class="flex flex-col items-center md:items-start gap-4">
          <a href="/" class="flex items-center gap-3 group">
            <img src="{{ asset('img/collarbone.jpg') }}" alt="Collarbone" class="h-10 w-auto rounded-full ring-2 ring-neutral-800 group-hover:ring-[#2a9d9d] transition-all">
            <span class="text-white text-sm font-medium tracking-[0.15em] uppercase">Collarbone</span>
          </a>
          <p class="text-neutral-500 text-xs leading-relaxed max-w-[260px] text-center md:text-left">Purwokerto-based unisex streetwear brand focused on quality, comfort, and timeless design.</p>
        </div>
        <div class="flex flex-col items-center gap-4">
          <h4 class="text-[10px] tracking-[0.25em] uppercase text-[#2a9d9d] font-medium">Quick Links</h4>
          <div class="flex flex-col items-center gap-2.5">
            <a href="{{ route('home') }}" class="text-xs tracking-wider text-neutral-500 hover:text-white transition-colors">Dashboard</a>
            <a href="{{ route('new_arrivals') }}" class="text-xs tracking-wider text-neutral-500 hover:text-white transition-colors">New Arrivals</a>
            <a href="{{ route('categories') }}" class="text-xs tracking-wider text-neutral-500 hover:text-white transition-colors">Categories</a>
          </div>
        </div>
        <div class="flex flex-col items-center md:items-end gap-4">
          <h4 class="text-[10px] tracking-[0.25em] uppercase text-[#2a9d9d] font-medium">Get In Touch</h4>
          <a href="https://wa.me/6288802612864" target="_blank" class="flex items-center gap-2 text-xs text-neutral-500 hover:text-[#25D366] transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.999 2C6.477 2 2 6.484 2 12.017c0 1.99.522 3.861 1.438 5.479L2.05 21.87a.5.5 0 0 0 .611.61l4.474-1.369A9.953 9.953 0 0 0 12 22c5.522 0 10-4.484 10-10.017C22 6.483 17.522 2 11.999 2z" fill-rule="evenodd" clip-rule="evenodd"/></svg>
            WhatsApp
          </a>
          <p class="text-xs text-neutral-600">Banyumas, Central Java</p>
        </div>
      </div>
      <div class="border-t border-neutral-800/50 pt-6 flex flex-col md:flex-row items-center justify-between gap-3">
        <p class="text-[11px] text-neutral-600 tracking-wider">&copy; 2026 Collarbone. All rights reserved.</p>
        <p class="text-[10px] text-neutral-700 tracking-wider">EST. 2024 &mdash; Purwokerto</p>
      </div>
    </div>
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[400px] h-[200px] bg-[#2a9d9d]/5 blur-[100px] pointer-events-none"></div>
  </footer>


  <!-- Scripts -->
  <script>
    // ===== TikTok-Style Product Slider =====
    class ProductSlider {
      constructor(el) {
        this.el = el;
        this.track = el.querySelector('.product-slider-track');
        this.slides = el.querySelectorAll('.product-slider-slide');
        this.dotsContainer = el.querySelector('.slider-dots');
        this.counter = el.querySelector('.slider-counter');
        this.currentIndex = 0;
        this.totalSlides = this.slides.length;
        this.isDragging = false;
        this.startX = 0;
        this.currentTranslate = 0;
        this.prevTranslate = 0;
        this.animationID = null;

        if(this.totalSlides > 0) this.init();
      }

      init() {
        // Create dots
        for (let i = 0; i < this.totalSlides; i++) {
          const dot = document.createElement('button');
          dot.classList.add('slider-dot');
          if (i === 0) dot.classList.add('active');
          dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
          dot.addEventListener('click', (e) => {
            e.stopPropagation();
            this.goToSlide(i);
          });
          this.dotsContainer.appendChild(dot);
        }

        // Touch events
        this.el.addEventListener('touchstart', this.touchStart.bind(this), { passive: true });
        this.el.addEventListener('touchmove', this.touchMove.bind(this), { passive: false });
        this.el.addEventListener('touchend', this.touchEnd.bind(this));

        // Mouse events (for desktop)
        this.el.addEventListener('mousedown', this.touchStart.bind(this));
        this.el.addEventListener('mousemove', this.touchMove.bind(this));
        this.el.addEventListener('mouseup', this.touchEnd.bind(this));
        this.el.addEventListener('mouseleave', () => {
          if (this.isDragging) this.touchEnd();
        });

        // Prevent context menu on long press
        this.el.addEventListener('contextmenu', (e) => e.preventDefault());
      }

      getPositionX(event) {
        return event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
      }

      touchStart(event) {
        this.isDragging = true;
        this.startX = this.getPositionX(event);
        this.track.classList.add('is-dragging');
        this.animationID = requestAnimationFrame(this.animation.bind(this));
      }

      touchMove(event) {
        if (!this.isDragging) return;
        const currentX = this.getPositionX(event);
        const diff = currentX - this.startX;
        this.currentTranslate = this.prevTranslate + diff;

        // Prevent default to stop page scrolling while swiping horizontally
        if (Math.abs(diff) > 5) {
          event.preventDefault();
        }
      }

      touchEnd() {
        this.isDragging = false;
        cancelAnimationFrame(this.animationID);
        this.track.classList.remove('is-dragging');

        const movedBy = this.currentTranslate - this.prevTranslate;
        const threshold = this.el.offsetWidth * 0.15; // 15% swipe threshold

        if (movedBy < -threshold && this.currentIndex < this.totalSlides - 1) {
          this.currentIndex++;
        } else if (movedBy > threshold && this.currentIndex > 0) {
          this.currentIndex--;
        }

        this.setPositionByIndex();
        this.updateDots();
        this.updateCounter();
      }

      animation() {
        this.setSliderPosition();
        if (this.isDragging) {
          requestAnimationFrame(this.animation.bind(this));
        }
      }

      setSliderPosition() {
        this.track.style.transform = `translateX(${this.currentTranslate}px)`;
      }

      setPositionByIndex() {
        this.currentTranslate = this.currentIndex * -this.el.offsetWidth;
        this.prevTranslate = this.currentTranslate;
        this.track.style.transform = `translateX(${this.currentTranslate}px)`;
      }

      goToSlide(index) {
        this.currentIndex = index;
        this.setPositionByIndex();
        this.updateDots();
        this.updateCounter();
      }

      updateDots() {
        const dots = this.dotsContainer.querySelectorAll('.slider-dot');
        dots.forEach((dot, i) => {
          dot.classList.toggle('active', i === this.currentIndex);
        });
      }

      updateCounter() {
        if (this.counter) {
          this.counter.textContent = `${this.currentIndex + 1} / ${this.totalSlides}`;
        }
      }
    }

    // Initialize all sliders
    document.querySelectorAll('[data-slider]').forEach(slider => {
      new ProductSlider(slider);
    });

    // Navigation
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

    // Blur In Animation Observer
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, {
      threshold: 0.1,
      rootMargin: '50px'
    });

    document.querySelectorAll('.blur-in').forEach(el => observer.observe(el));

    // Flip Card Interaction function
    function initFlipCards(container = document) {
      container.querySelectorAll('.details-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          const article = btn.closest('article');
          const cardInner = article ? article.querySelector('.transform-style-3d') : null;

          if (cardInner) {
            btn.classList.add('opacity-0', 'scale-90');

            const isFlippingToBack = !cardInner.classList.contains('rotate-y-180');
            if (isFlippingToBack) {
              cardInner.classList.add('rotate-y-180');
            } else {
              cardInner.classList.remove('rotate-y-180');
            }

            setTimeout(() => {
              btn.textContent = isFlippingToBack ? 'Back' : 'Details';
              btn.classList.remove('opacity-0', 'scale-90');
            }, 300);
          }
        });
      });
    }
    
    // Initial call
    initFlipCards();

    // AJAX Sorting
    window.updateSort = function(sortValue) {
      // Sync dropdowns
      document.querySelectorAll('select[onchange^="updateSort"]').forEach(select => {
        select.value = sortValue;
      });

      const grid = document.getElementById('productGrid');
      if(grid) {
        grid.style.opacity = '0.4';
        grid.style.pointerEvents = 'none';
      }

      const url = new URL(window.location.href);
      url.searchParams.set('sort', sortValue);
      window.history.pushState({}, '', url);

      fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(response => response.text())
        .then(html => {
          const parser = new DOMParser();
          const doc = parser.parseFromString(html, 'text/html');
          const newGrid = doc.getElementById('productGrid');

          if(newGrid && grid) {
            grid.innerHTML = newGrid.innerHTML;
            grid.style.opacity = '1';
            grid.style.pointerEvents = 'auto';

            // Re-initialize scripts for new DOM
            grid.querySelectorAll('.blur-in').forEach(el => observer.observe(el));
            grid.querySelectorAll('[data-slider]').forEach(slider => {
              new ProductSlider(slider);
            });
            initFlipCards(grid);
          }
        })
        .catch(err => {
          console.error(err);
          if(grid) {
            grid.style.opacity = '1';
            grid.style.pointerEvents = 'auto';
          }
        });
    }
  </script>

  <!-- Floating Cart Button -->
  <button id="cartToggleBtn" class="fixed bottom-6 right-6 z-[140] p-4 bg-gradient-to-br from-[#2a9d9d] to-[#1a7a7a] text-white border-none rounded-2xl cart-float-glow hover:-translate-y-1 transition-all duration-300 pointer-events-auto" aria-label="Cart">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
    <span id="cartBadge" class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center hidden shadow-sm border-2 border-white">0</span>
  </button>

  <!-- Cart Overlay -->
  <div id="cartOverlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-[150] opacity-0 pointer-events-none"></div>
  <!-- Cart Sidebar -->
  <aside id="cartSidebar" class="fixed top-0 right-0 h-full w-full max-w-sm bg-white shadow-2xl z-[160] flex flex-col rounded-l-2xl" style="transform: translateX(100%)">
    <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-100">
      <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        <h2 class="text-sm font-semibold tracking-widest uppercase">Cart</h2>
        <span id="cartItemCount" class="text-xs text-neutral-400"></span>
      </div>
      <button id="closeCartBtn" class="p-2 hover:bg-neutral-100 rounded-full transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
    </div>
    <div id="cartItemsContainer" class="flex-1 overflow-y-auto px-5 py-4 space-y-4"></div>
    <div id="cartEmptyState" class="hidden flex-1 flex flex-col items-center justify-center text-center px-6 py-12">
      <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d4d4d4" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mb-4"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
      <p class="text-sm text-neutral-400 tracking-wide">Your cart is empty.</p>
    </div>
    <div id="cartFooter" class="border-t border-neutral-100 px-5 py-5">
      <div class="flex items-center justify-between mb-4"><span class="text-xs text-neutral-500 uppercase tracking-widest">Total</span><span id="cartTotal" class="text-base font-semibold text-neutral-900">IDR 0</span></div>
      <button id="cartCheckoutBtn" class="w-full flex items-center justify-center gap-2 py-3.5 bg-[#25D366] hover:bg-[#1ebe5d] text-white font-medium tracking-widest uppercase text-xs rounded-xl transition-all duration-300 shadow-md mb-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.999 2C6.477 2 2 6.484 2 12.017c0 1.99.522 3.861 1.438 5.479L2.05 21.87a.5.5 0 0 0 .611.61l4.474-1.369A9.953 9.953 0 0 0 12 22c5.522 0 10-4.484 10-10.017C22 6.483 17.522 2 11.999 2z" fill-rule="evenodd" clip-rule="evenodd"/></svg>
        Checkout via WhatsApp
      </button>
      <button id="clearCartBtn" class="w-full py-2.5 text-xs text-neutral-400 hover:text-red-500 tracking-widest uppercase transition-colors">Clear Cart</button>
    </div>
  </aside>

  <!-- Checkout Modal -->
  <div id="checkoutModal" class="fixed inset-0 z-[100] hidden" role="dialog" aria-modal="true" aria-labelledby="checkoutModalTitle">
      <div id="checkoutBackdrop" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
      <div id="checkoutDrawer" class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl shadow-2xl translate-y-full max-h-[92vh] overflow-y-auto">
          <div class="flex justify-center pt-3 pb-1"><div class="w-10 h-1 bg-neutral-200 rounded-full"></div></div>
          <div class="px-6 pt-4 pb-8">
              <div class="flex items-start justify-between mb-6">
                  <div class="flex gap-4 items-start">
                      <img id="modalProductImg" src="" alt="" class="w-16 h-20 object-cover rounded-lg border border-neutral-100">
                      <div>
                          <p id="modalModeLabel" class="text-[10px] tracking-widest text-neutral-400 uppercase mb-1">SELECT OPTIONS</p>
                          <h3 id="checkoutModalTitle" class="text-sm font-semibold text-neutral-900 leading-snug"></h3>
                          <p id="modalProductPrice" class="text-sm font-medium text-[#2a9d9d] mt-1"></p>
                      </div>
                  </div>
                  <button id="closeCheckoutModal" class="p-2 hover:bg-neutral-100 rounded-full transition-colors flex-shrink-0">
                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                  </button>
              </div>
              <div id="sizeSection" class="mb-6">
                  <p class="text-[10px] tracking-widest text-neutral-500 uppercase mb-3">Select Size</p>
                  <div id="sizeOptions" class="flex flex-wrap gap-2"></div>
              </div>
              <div id="colorSection" class="mb-6">
                  <p class="text-[10px] tracking-widest text-neutral-500 uppercase mb-3">Select Color &mdash; <span id="selectedColorName" class="text-neutral-700"></span></p>
                  <div id="colorOptions" class="flex flex-wrap gap-3"></div>
              </div>
              <div class="mb-8">
                  <p class="text-[10px] tracking-widest text-neutral-500 uppercase mb-3">Quantity</p>
                  <div class="flex items-center gap-4">
                      <button id="qtyMinus" class="qty-btn">&minus;</button>
                      <span id="qtyValue" class="text-sm font-semibold w-6 text-center">1</span>
                      <button id="qtyPlus" class="qty-btn">+</button>
                      <span class="text-xs text-neutral-400 ml-2" id="modalTotalPrice"></span>
                  </div>
              </div>
              <button id="addToCartFromModal" class="w-full flex items-center justify-center gap-3 py-4 bg-neutral-900 hover:bg-neutral-700 text-white font-medium tracking-widest uppercase text-sm rounded-xl transition-all duration-300 shadow-md mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                  Add to Cart
              </button>
              <button id="checkoutWhatsapp" class="w-full flex items-center justify-center gap-3 py-4 bg-[#25D366] hover:bg-[#1ebe5d] text-white font-medium tracking-widest uppercase text-sm rounded-xl transition-all duration-300 shadow-lg">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.999 2C6.477 2 2 6.484 2 12.017c0 1.99.522 3.861 1.438 5.479L2.05 21.87a.5.5 0 0 0 .611.61l4.474-1.369A9.953 9.953 0 0 0 12 22c5.522 0 10-4.484 10-10.017C22 6.483 17.522 2 11.999 2z" fill-rule="evenodd" clip-rule="evenodd"/></svg>
                  Order via WhatsApp
              </button>
              <p class="text-center text-[10px] text-neutral-400 mt-3 tracking-wide">Pilih <strong>Add to Cart</strong> untuk simpan, atau <strong>Order</strong> untuk langsung ke WhatsApp.</p>
          </div>
      </div>
  </div>

  <!-- Checkout Script -->
  <script>
    const WHATSAPP_NUMBER = '6288802612864'; // ← GANTI dengan nomer WA toko
    const colorHexMap = { 
        'black':'#000000', 'white':'#ffffff', 'grey':'#808080', 'cream':'#E5D0B1', 'navy':'#000080', 'olive':'#808000', 'blue':'#0000ff', 'charcoal':'#36454F', 'green':'#4CAF50', 'red':'#ef4444', 'yellow':'#EAB308', 'purple':'#9333EA', 'pink':'#EC4899', 'brown':'#92400E',
        'hitam':'#000000', 'putih':'#ffffff', 'abu-abu':'#808080', 'krim':'#E5D0B1', 'biru dongker':'#000080', 'biru':'#0000ff', 'hijau':'#4CAF50', 'merah':'#ef4444', 'kuning':'#EAB308', 'ungu':'#9333EA', 'merah muda':'#EC4899', 'coklat':'#92400E', 'krem':'#E5D0B1', 'abu':'#808080'
    };
    let checkoutData = { name:'', price:0, sizes:[], colors:[], image:'' };
    let selectedSize = '', selectedColor = '', quantity = 1;
    const modal = document.getElementById('checkoutModal');
    const drawer = document.getElementById('checkoutDrawer');

    function openCheckoutModal(btn) {
        checkoutData = { name: btn.dataset.name, price: parseInt(btn.dataset.price.replace(/\./g,'').replace(/,/g,'')), sizes: JSON.parse(btn.dataset.sizes||'[]'), colors: JSON.parse(btn.dataset.colors||'[]'), image: btn.dataset.image };
        selectedSize = ''; selectedColor = ''; quantity = 1;
        document.getElementById('checkoutModalTitle').textContent = checkoutData.name;
        document.getElementById('modalProductImg').src = checkoutData.image;
        document.getElementById('modalProductPrice').textContent = 'IDR ' + checkoutData.price.toLocaleString('id-ID');
        document.getElementById('qtyValue').textContent = '1';
        updateTotalPrice();
        const sizeSection = document.getElementById('sizeSection'), sizeOptions = document.getElementById('sizeOptions');
        sizeOptions.innerHTML = '';
        if (checkoutData.sizes.length > 0) { sizeSection.classList.remove('hidden'); checkoutData.sizes.forEach(size => { const b=document.createElement('button'); b.className='size-option'; b.textContent=size; b.addEventListener('click',()=>{ document.querySelectorAll('.size-option').forEach(x=>x.classList.remove('selected')); b.classList.add('selected'); selectedSize=size; }); sizeOptions.appendChild(b); }); } else sizeSection.classList.add('hidden');
        
        const colorSection = document.getElementById('colorSection'), colorOptions = document.getElementById('colorOptions');
        colorOptions.innerHTML = ''; document.getElementById('selectedColorName').textContent = '';
        if (checkoutData.colors.length > 0) { 
            colorSection.classList.remove('hidden'); 
            checkoutData.colors.forEach(color => { 
                const cleanColorName = color.trim().toLowerCase();
                const hex = colorHexMap[cleanColorName] || (color.startsWith('#') ? color : 'transparent');
                
                const s = document.createElement('button');
                s.className = 'color-option relative'; 
                s.style.backgroundColor = hex; 
                s.title = color;
                
                if (cleanColorName === 'white' || cleanColorName === 'putih' || hex === '#ffffff') {
                    s.style.border = '2.5px solid #d4d4d4';
                }
                
                if(hex === 'transparent') {
                    s.innerHTML = '<span class="text-[8px] flex items-center justify-center w-full h-full">' + color.substring(0,2).toUpperCase() + '</span>';
                    s.style.backgroundColor = '#f3f4f6'; 
                }

                s.addEventListener('click',()=>{ 
                    document.querySelectorAll('.color-option').forEach(x=>x.classList.remove('selected')); 
                    s.classList.add('selected'); 
                    selectedColor=color; 
                    document.getElementById('selectedColorName').textContent=color; 
                }); 
                colorOptions.appendChild(s); 
            }); 
        } else {
            colorSection.classList.add('hidden');
        }
        
        modal.classList.remove('hidden'); requestAnimationFrame(()=>requestAnimationFrame(()=>drawer.classList.remove('translate-y-full')));
        document.body.style.overflow = 'hidden';
    }
    function closeCheckoutModal() { drawer.classList.add('translate-y-full'); setTimeout(()=>{ modal.classList.add('hidden'); document.body.style.overflow=''; }, 400); }
    function updateTotalPrice() { document.getElementById('modalTotalPrice').textContent = 'Total: IDR ' + (checkoutData.price*quantity).toLocaleString('id-ID'); }
    document.getElementById('qtyMinus').addEventListener('click',()=>{ if(quantity>1){ quantity--; document.getElementById('qtyValue').textContent=quantity; updateTotalPrice(); } });
    document.getElementById('qtyPlus').addEventListener('click',()=>{ quantity++; document.getElementById('qtyValue').textContent=quantity; updateTotalPrice(); });
    document.getElementById('closeCheckoutModal').addEventListener('click', closeCheckoutModal);
    document.getElementById('checkoutBackdrop').addEventListener('click', closeCheckoutModal);
    document.getElementById('checkoutWhatsapp').addEventListener('click',()=>{
        if (checkoutData.sizes.length>0&&!selectedSize){ alert('Silakan pilih ukuran / Please select a size.'); return; }
        if (checkoutData.colors.length>0&&!selectedColor){ alert('Silakan pilih warna / Please select a color.'); return; }
        const total=checkoutData.price*quantity;
        let msg=`Halo Collarbone! Saya ingin memesan:\n\n📦 *Produk:* ${checkoutData.name}\n`;
        if(selectedSize) msg+=`📐 *Ukuran:* ${selectedSize}\n`;
        if(selectedColor) msg+=`🎨 *Warna:* ${selectedColor}\n`;
        msg+=`🔢 *Qty:* ${quantity}\n💰 *Total:* IDR ${total.toLocaleString('id-ID')}\n\nMohon informasi ketersediaan dan cara pembayaran. Terima kasih! 🙏`;
        window.open(`https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(msg)}`,'_blank');
    });
    document.addEventListener('click',(e)=>{ 
      const btn=e.target.closest('.order-btn'); if(btn){ e.stopPropagation(); openCheckoutModal(btn); }
      const cartBtn=e.target.closest('.cart-quick-btn');
      if(cartBtn){ e.stopPropagation(); openCheckoutModal(cartBtn); }
    });

    // Add to Cart from modal
    document.getElementById('addToCartFromModal').addEventListener('click', () => {
        if (checkoutData.sizes.length>0&&!selectedSize){ alert('Silakan pilih ukuran / Please select a size.'); return; }
        if (checkoutData.colors.length>0&&!selectedColor){ alert('Silakan pilih warna / Please select a color.'); return; }
        cartAddItem({ name:checkoutData.name, price:checkoutData.price, size:selectedSize, color:selectedColor, image:checkoutData.image, qty:quantity });
        closeCheckoutModal();
        setTimeout(()=>{
            document.getElementById('cartSidebar').classList.add('cart-open');
            document.getElementById('cartOverlay').classList.add('cart-visible');
            document.body.style.overflow='hidden';
        }, 450);
    });
  </script>

  <!-- Cart System JS -->
  <script>
  (function(){
    const WA_NUMBER='6288802612864'; // ← GANTI nomer WA toko
    const CART_KEY='collarbone_cart';
    function loadCart(){ try{ return JSON.parse(localStorage.getItem(CART_KEY))||[]; }catch(e){return[];} }
    function saveCart(c){ localStorage.setItem(CART_KEY,JSON.stringify(c)); }
    function cKey(i){ return i.name+'|'+(i.size||'')+'|'+(i.color||''); }
    window.cartAddItem=function(item){ const cart=loadCart(),key=cKey(item),ex=cart.find(c=>cKey(c)===key); if(ex){ex.qty+=(item.qty||1);}else{cart.push({...item,qty:item.qty||1});} saveCart(cart);renderCart(); const b=document.getElementById('cartBadge');if(b){b.classList.add('cart-badge-bounce');setTimeout(()=>b.classList.remove('cart-badge-bounce'),400);} };
    window.cartChangeQty=function(idx,delta){const cart=loadCart();if(!cart[idx])return;cart[idx].qty=Math.max(1,cart[idx].qty+delta);saveCart(cart);renderCart();};
    window.cartRemove=function(idx){const cart=loadCart();cart.splice(idx,1);saveCart(cart);renderCart();};
    function renderCart(){
      const cart=loadCart(),container=document.getElementById('cartItemsContainer'),empty=document.getElementById('cartEmptyState'),footer=document.getElementById('cartFooter'),badge=document.getElementById('cartBadge'),countEl=document.getElementById('cartItemCount');
      if(!container)return;
      const totalQty=cart.reduce((s,c)=>s+c.qty,0),totalAmt=cart.reduce((s,c)=>s+(c.price*c.qty),0);
      if(badge){if(totalQty>0){badge.textContent=totalQty>99?'99+':totalQty;badge.classList.remove('hidden');}else badge.classList.add('hidden');}
      if(countEl) countEl.textContent=totalQty>0?`(${totalQty} item${totalQty>1?'s':''})`:''; 
      const totalEl=document.getElementById('cartTotal');if(totalEl)totalEl.textContent='IDR '+totalAmt.toLocaleString('id-ID');
      if(cart.length===0){container.classList.add('hidden');container.innerHTML='';if(empty)empty.classList.remove('hidden');if(footer)footer.classList.add('hidden');return;}
      if(empty)empty.classList.add('hidden');if(footer)footer.classList.remove('hidden');container.classList.remove('hidden');
      container.innerHTML=cart.map((item,idx)=>`<div class="flex gap-3 items-start border-b border-neutral-50 pb-4"><img src="${item.image}" alt="${item.name}" class="cart-item-img border border-neutral-100"><div class="flex-1 min-w-0"><p class="text-xs font-semibold text-neutral-900 leading-tight mb-0.5 truncate">${item.name}</p>${item.size?`<p class="text-[10px] text-neutral-400">Size: ${item.size}</p>`:''} ${item.color?`<p class="text-[10px] text-neutral-400">Color: ${item.color}</p>`:''}<p class="text-xs font-medium text-[#2a9d9d] mt-1">IDR ${item.price.toLocaleString('id-ID')}</p><div class="flex items-center gap-2 mt-2"><button class="cart-qty-btn" onclick="cartChangeQty(${idx},-1)">−</button><span class="text-xs font-semibold w-4 text-center">${item.qty}</span><button class="cart-qty-btn" onclick="cartChangeQty(${idx},1)">+</button><button class="ml-2 text-[10px] text-red-400 hover:text-red-600 uppercase transition-colors" onclick="cartRemove(${idx})">Remove</button></div></div></div>`).join('');
    }
    function openCart(){document.getElementById('cartSidebar').classList.add('cart-open');document.getElementById('cartOverlay').classList.add('cart-visible');document.body.style.overflow='hidden';}
    function closeCart(){document.getElementById('cartSidebar').classList.remove('cart-open');document.getElementById('cartOverlay').classList.remove('cart-visible');document.body.style.overflow='';}
    document.addEventListener('DOMContentLoaded',function(){
      renderCart();
      document.getElementById('cartToggleBtn')?.addEventListener('click',openCart);
      document.getElementById('closeCartBtn')?.addEventListener('click',closeCart);
      document.getElementById('cartOverlay')?.addEventListener('click',closeCart);
      document.getElementById('clearCartBtn')?.addEventListener('click',()=>{saveCart([]);renderCart();});
      document.getElementById('cartCheckoutBtn')?.addEventListener('click',()=>{
        const cart=loadCart();if(!cart.length){alert('Keranjang masih kosong!');return;}
        const total=cart.reduce((s,c)=>s+c.price*c.qty,0);
        let msg='Halo Collarbone! Saya ingin memesan:\n\n';
        cart.forEach((item,i)=>{msg+=`${i+1}. *${item.name}*`;if(item.size)msg+=` | Size: ${item.size}`;if(item.color)msg+=` | Color: ${item.color}`;msg+=` | Qty: ${item.qty} | IDR ${(item.price*item.qty).toLocaleString('id-ID')}\n`;});
        msg+=`\n💰 *Total: IDR ${total.toLocaleString('id-ID')}*\n\nMohon informasi ketersediaan dan cara pembayaran. Terima kasih! 🙏`;
        window.open(`https://wa.me/${WA_NUMBER}?text=${encodeURIComponent(msg)}`,'_blank');
        saveCart([]);
        renderCart();
      });
    });
  })();
  </script>

</body>

</html>
