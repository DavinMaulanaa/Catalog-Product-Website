<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Collarbone - Categories</title>
    <link rel="icon" type="image/png" href="{{ asset('img/collarbone.jpg') }}">
    <meta name="description" content="Explore our curated T-shirt collections." />
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
                        }
                    },
                    keyframes: {
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(0)' },
                        },
                        slideOut: {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-100%)' },
                        }
                    },
                    animation: {
                        'slide-in': 'slideIn 0.4s ease-out forwards',
                        'slide-out': 'slideOut 0.4s ease-in forwards',
                    }
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
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        /* Scroll Animation Base Styles */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 1s cubic-bezier(0.19, 1, 0.22, 1);
        }

        .reveal-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .card-zoom-image {
            transition: transform 1.2s cubic-bezier(0.19, 1, 0.22, 1);
        }

        .group:hover .card-zoom-image {
            transform: scale(1.05);
        }

        /* Staggered transition delays */
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

        /* ===== Checkout Modal ===== */
        #checkoutModal {
            transition: opacity 0.3s ease;
        }

        #checkoutModal.hidden {
            display: none;
        }

        #checkoutDrawer {
            transition: transform 0.4s cubic-bezier(0.32, 0.72, 0, 1);
        }

        #checkoutDrawer.translate-y-full {
            transform: translateY(100%);
        }

        .size-option {
            cursor: pointer;
            padding: 6px 14px;
            border: 1.5px solid #e5e5e5;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            transition: all 0.2s;
            background: white;
            color: #262626;
        }

        .size-option:hover, .size-option.selected {
            background: #262626;
            color: white;
            border-color: #262626;
        }

        .color-option {
            cursor: pointer;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2.5px solid #e5e5e5;
            transition: all 0.2s;
            position: relative;
        }

        .color-option:hover, .color-option.selected {
            border-color: #2a9d9d;
            transform: scale(1.15);
            box-shadow: 0 0 0 2px white, 0 0 0 4px #2a9d9d;
        }

        .qty-btn {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #e5e5e5;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            background: white;
            transition: all 0.2s;
        }

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
        /* Product Card Modern Hover */
        .product-card-modern {
          transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
        }
        .product-card-modern:hover {
          transform: translateY(-4px);
          box-shadow: 0 12px 40px rgba(0,0,0,0.08);
        }
        /* Slide counter (optional) */
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
    </style>
</head>

<body class="min-h-screen flex flex-col bg-white text-black">

    <!-- Header -->
    <header
        class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl shadow-[0_1px_3px_rgba(0,0,0,0.04)] transition-all duration-300 border-b border-neutral-100">
        <div class="flex items-center justify-between px-6 lg:px-12 h-[4.5rem]">
            <a href="/" class="flex items-center group">
                <img src="{{ asset('img/collarbone.jpg') }}" alt="Collarbone Logo"
                    class="h-10 w-auto object-contain group-hover:opacity-80 transition-opacity duration-300 rounded-full">
            </a>

            <nav class="hidden lg:flex items-center gap-10">
                <a href="{{ route('home') }}" class="relative group py-2 block">
                    <span
                        class="text-xs font-medium tracking-[0.15em] uppercase text-neutral-900 transition-colors group-hover:text-orbis-teal">Dashboard</span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
                </a>
                <a href="{{ route('new_arrivals') }}" class="relative group py-2 block">
                    <span
                        class="text-xs font-medium tracking-[0.15em] uppercase text-neutral-900 transition-colors group-hover:text-orbis-teal">New
                        Arrivals</span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
                </a>
                <a href="{{ route('categories') }}" class="relative group py-2 block">
                    <span
                        class="text-xs font-medium tracking-[0.15em] uppercase text-orbis-teal transition-colors group-hover:text-orbis-teal">Categories</span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-[1.5px] bg-orbis-teal transition-all duration-300 ease-out group-hover:w-full"></span>
                </a>
            </nav>



            <button id="menuToggle" class="lg:hidden group p-2 hover:bg-neutral-100 rounded-full transition-colors">
                <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    class="group-hover:stroke-orbis-teal transition-colors">
                    <line x1="3" x2="21" y1="6" y2="6" />
                    <line x1="3" x2="21" y1="12" y2="12" />
                    <line x1="3" x2="21" y1="18" y2="18" />
                </svg>
                <svg id="closeIcon" class="hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" class="group-hover:stroke-orbis-teal transition-colors">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
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
    <main class="flex-1 w-full overflow-hidden">

        <!-- SECTION 1: GREETINGS (HERO) -->
        <section class="h-[60vh] md:h-[80vh] relative flex items-center justify-center overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="{{ $banner->image_url ?? (Str::startsWith($banner->image_path, 'http') ? $banner->image_path : asset($banner->image_path)) }}"
                    alt="Categories Hero" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-black/5"></div>
            </div>

            <div class="relative z-10 text-center text-white px-6 max-w-4xl mx-auto">
                <p class="reveal-on-scroll text-xs tracking-mega mb-4 text-[#2a9d9d]">EST. 2024</p>
                <h1 class="reveal-on-scroll delay-100 text-4xl md:text-7xl font-light tracking-widest mb-6" style="color: {{ $banner->text_color ?? '#FFFFFF' }}">{{ $banner->title }}
                </h1>
                <p
                    class="reveal-on-scroll delay-200 text-sm md:text-base font-light tracking-wide leading-relaxed max-w-2xl mx-auto text-white/90">
                    {{ $banner->subtitle }}
                </p>
            </div>
            <!-- Bottom teal accent -->
            <div class="absolute bottom-0 left-0 right-0 h-[3px] bg-gradient-to-r from-transparent via-[#2a9d9d] to-transparent z-10"></div>
        </section>

        <!-- SECTION 2: CATEGORY ARCHIVE BLOCKS -->
        @forelse($categories as $index => $category)
            @php $isEven = ($index % 2 == 0); @endphp
            <!-- SPLIT SCREEN LAYOUT -->
            <section class="py-20 md:py-28 {{ $isEven ? 'bg-white' : 'bg-gradient-to-br from-[#f7fafa] to-[#f5f5f4]' }} border-b border-neutral-100 relative" id="category-{{ $category->id }}">
                <div class="max-w-[1400px] mx-auto px-6 lg:px-12 block lg:grid lg:grid-cols-12 gap-12 lg:gap-16 items-start relative">
                    
                    <!-- LEFT COLUMN: STICKY INFO -->
                    <div class="lg:col-span-4 lg:sticky lg:top-28 mb-12 lg:mb-0 reveal-on-scroll">
                        <span class="inline-flex items-center gap-2 text-[10px] tracking-mega text-[#2a9d9d] font-bold mb-6">
                            <span class="w-6 h-6 rounded-full bg-[#2a9d9d]/10 flex items-center justify-center">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            ARCHIVE
                        </span>
                        <h2 class="text-4xl lg:text-5xl font-semibold tracking-tighter uppercase mb-6 text-neutral-900 leading-[1.1]">{{ $category->name }}</h2>
                        
                        <div class="aspect-square w-2/3 md:w-1/2 lg:w-full overflow-hidden mb-8 rounded-2xl shadow-md border border-neutral-100">
                            <img src="{{ $category->image_url ?? asset('img/placeholder.jpg') }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                        </div>

                        <div class="space-y-4 text-xs md:text-sm text-neutral-500 leading-relaxed font-light break-words mb-8">
                            {!! nl2br(e($category->description)) !!}
                        </div>
                        
                        <div class="h-[1px] w-full bg-neutral-200 mb-6"></div>
                        <div class="text-[10px] tracking-widest uppercase text-neutral-400 font-medium">
                            Total: {{ $category->products->count() }} Products
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: PRODUCT GRID -->
                    <div class="lg:col-span-8">
                        @if($category->products->count() > 6)
                        <div class="flex justify-end mb-8">
                            <button class="view-all-btn text-[10px] border border-neutral-900 px-4 py-2 rounded-full hover:bg-neutral-900 hover:text-white transition-colors uppercase tracking-widest cursor-pointer" data-category="{{ $category->id }}" data-expanded="false" data-original-text="View All {{ Str::limit($category->name, 10, '') }}">View All</button>
                        </div>
                        @else
                        <!-- Spacing buffer if no view all button -->
                        <div class="h-8 lg:h-0"></div>
                        @endif
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-4 gap-y-12">
                        @forelse($category->products as $pIndex => $product)
                        <article class="group cursor-pointer product-card-{{ $category->id }} 
                            @if($pIndex < 4) reveal-on-scroll @else hidden-product-{{ $category->id }} hidden opacity-0 transform translate-y-8 @endif
                            delay-{{ ($pIndex % 4) * 100 }}">
                            
                            <div class="perspective-1000 mb-4 relative hover:z-10">
                                <div class="relative transition-all duration-700 transform-style-3d w-full aspect-[3/4]">
                                    <div class="absolute inset-0 backface-hidden bg-neutral-100 overflow-hidden rounded-xl product-card-modern border border-neutral-100 hover:border-[#2a9d9d]/30">
                                        <div class="product-slider" data-slider>
                                            <div class="product-slider-track">
                                                @if(!empty($product->image_urls) && is_array($product->image_urls) && count($product->image_urls) > 0)
                                                    @foreach($product->image_urls as $img)
                                                    <div class="product-slider-slide">
                                                        <img src="{{ Str::startsWith($img, 'http') ? $img : asset($img) }}" alt="{{ $product->name }}">
                                                    </div>
                                                    @endforeach
                                                @else
                                                    <div class="product-slider-slide">
                                                        <img src="{{ $product->thumbnail ?? asset('img/placeholder.jpg') }}" alt="{{ $product->name }}">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="slider-dots"></div>
                                        </div>
                                    </div>
                                    <div class="absolute inset-0 backface-hidden rotate-y-180 bg-white border border-neutral-100 p-6 flex flex-col items-center justify-center text-center rounded-xl shadow-lg overflow-hidden text-clip">
                                        <div class="absolute top-0 left-0 w-full h-1 bg-[#2a9d9d]"></div>
                                        <h3 class="text-xs font-medium uppercase tracking-widest mb-4 truncate w-full" title="{{ Str::before($product->name, ' -') }}">{{ Str::before($product->name, ' -') }}</h3>
                                        <p class="text-[10px] text-neutral-500 leading-relaxed overflow-hidden text-ellipsis line-clamp-4">{{ Str::limit($product->description, 100) }}</p>
                                    </div>
                                </div>
                                <button class="details-btn absolute bottom-3 right-3 z-30 uppercase tracking-widest px-3 py-1.5 border border-white/80 bg-white/90 hover:bg-neutral-900 text-neutral-900 hover:text-white transition-all duration-300 rounded-full text-[10px] font-medium backdrop-blur-sm shadow-md">Details</button>
                            </div>
                            <p class="text-[10px] tracking-widest text-neutral-500 mb-1 line-clamp-1" title="{{ Str::upper($category->name) }}">{{ Str::upper($category->name) }}</p>
                            <h3 class="text-sm font-medium text-neutral-900 mb-1 line-clamp-1" title="{{ $product->name }}">{{ $product->name }}</h3>
                            <div class="flex items-end justify-between mb-2">
                                <div>
                                    <p class="text-sm font-medium mb-1 truncate">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
                                    <div class="flex gap-2 text-[10px] font-medium tracking-wider">
                                         @foreach($product->sizes ?? [] as $size)
                                            <span class="text-green-600 bg-green-50 px-1.5 py-0.5 rounded-md">{{ $size }}</span>
                                         @endforeach
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <div class="flex gap-1 flex-wrap justify-end">
                                    @if(is_array($product->colors) && count($product->colors) > 0)
                                         @php
                                            $colorName = $product->colors[0] ?? 'Black';
                                            $colorHex = match(strtolower(trim($colorName))) {
                                                'black', 'hitam' => '#000000',
                                                'white', 'putih' => '#ffffff',
                                                'grey', 'abu-abu', 'abu' => '#808080',
                                                'cream', 'krim', 'krem' => '#E5D0B1',
                                                'navy', 'biru dongker' => '#000080',
                                                'olive' => '#808000',
                                                'blue', 'biru' => '#0000ff',
                                                'charcoal' => '#36454F',
                                                'green', 'hijau' => '#4CAF50',
                                                'red', 'merah' => '#ef4444',
                                                'yellow', 'kuning' => '#EAB308',
                                                'purple', 'ungu' => '#9333EA',
                                                'pink', 'merah muda' => '#EC4899',
                                                'brown', 'coklat' => '#92400E',
                                                default => str_starts_with(trim($colorName), '#') ? trim($colorName) : '#000000'
                                            };
                                         @endphp
                                        <span class="w-3.5 h-3.5 rounded-full border border-neutral-200 shadow-sm flex-shrink-0"
                                            style="background-color: {{ $colorHex }}"
                                            title="{{ $colorName }}"></span>
                                    @endif
                                    </div>
                                    <div class="flex gap-1 shrink-0">
                                        <button class="cart-quick-btn p-1.5 border border-neutral-200 bg-white hover:bg-neutral-900 hover:text-white hover:border-neutral-900 text-neutral-900 transition-all duration-300 rounded-lg"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ (int)$product->price }}"
                                            data-sizes='@json($product->sizes ?? [])'
                                            data-colors='@json($product->colors ?? [])'
                                            data-image="{{ $product->thumbnail ?? asset('img/placeholder.jpg') }}"
                                            title="Add to Cart">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                        </button>
                                        <button class="order-btn uppercase tracking-widest px-3 py-1.5 border border-[#2a9d9d] bg-[#2a9d9d] hover:bg-[#1a6b6b] text-white transition-all duration-300 rounded-lg text-[10px] font-medium shadow-sm hover:shadow-md"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ number_format($product->price, 0, ',', '.') }}"
                                            data-sizes='@json($product->sizes ?? [])'
                                            data-colors='@json($product->colors ?? [])'
                                            data-image="{{ $product->thumbnail ?? asset('img/placeholder.jpg') }}">Order</button>
                                    </div>
                                </div>
                            </div>
                        </article>
                        @empty
                            <p class="text-neutral-500 col-span-full">No products currently available in this category.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        @empty
            <section class="py-20 text-center"><p class="text-neutral-500 col-span-full">No categories found.</p></section>
        @endforelse

    </main>

    <!-- CTA Banner -->
    <section class="bg-neutral-900 py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-[#2a9d9d]/10 via-transparent to-[#2a9d9d]/10 pointer-events-none"></div>
        <div class="max-w-3xl mx-auto text-center px-6 relative">
            <p class="text-[10px] tracking-[0.3em] uppercase text-[#2a9d9d] font-medium mb-4">Fresh Drops</p>
            <h2 class="text-2xl md:text-4xl font-light tracking-widest text-white mb-6 uppercase">Check Our Latest Arrivals</h2>
            <p class="text-sm text-neutral-400 mb-8 max-w-md mx-auto">Be the first to discover our newest pieces, fresh off the design table.</p>
            <a href="{{ route('new_arrivals') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-[#2a9d9d] hover:bg-[#1a6b6b] text-white text-xs font-medium tracking-[0.2em] uppercase rounded-full transition-all duration-300 shadow-lg hover:shadow-[#2a9d9d]/30">
                New Arrivals
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
        <!-- Backdrop -->
        <div id="checkoutBackdrop" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

        <!-- Drawer -->
        <div id="checkoutDrawer" class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl shadow-2xl translate-y-full max-h-[92vh] overflow-y-auto">
            <!-- Handle -->
            <div class="flex justify-center pt-3 pb-1">
                <div class="w-10 h-1 bg-neutral-200 rounded-full"></div>
            </div>

            <div class="px-6 pt-4 pb-8">
                <!-- Header -->
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

                <!-- Size -->
                <div id="sizeSection" class="mb-6">
                    <p class="text-[10px] tracking-widest text-neutral-500 uppercase mb-3">Select Size</p>
                    <div id="sizeOptions" class="flex flex-wrap gap-2"></div>
                </div>

                <!-- Color -->
                <div id="colorSection" class="mb-6">
                    <p class="text-[10px] tracking-widest text-neutral-500 uppercase mb-3">Select Color — <span id="selectedColorName" class="text-neutral-700"></span></p>
                    <div id="colorOptions" class="flex flex-wrap gap-3"></div>
                </div>

                <!-- Quantity -->
                <div class="mb-8">
                    <p class="text-[10px] tracking-widest text-neutral-500 uppercase mb-3">Quantity</p>
                    <div class="flex items-center gap-4">
                        <button id="qtyMinus" class="qty-btn">−</button>
                        <span id="qtyValue" class="text-sm font-semibold w-6 text-center">1</span>
                        <button id="qtyPlus" class="qty-btn">+</button>
                        <span class="text-xs text-neutral-400 ml-2" id="modalTotalPrice"></span>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <button id="addToCartFromModal" class="w-full flex items-center justify-center gap-3 py-4 bg-neutral-900 hover:bg-neutral-700 text-white font-medium tracking-widest uppercase text-sm rounded-xl transition-all duration-300 shadow-md mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    Add to Cart
                </button>
                <button id="checkoutWhatsapp" class="w-full flex items-center justify-center gap-3 py-4 bg-[#25D366] hover:bg-[#1ebe5d] text-white font-medium tracking-widest uppercase text-sm rounded-xl transition-all duration-300 shadow-lg hover:shadow-[#25D366]/30 hover:shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M11.999 2C6.477 2 2 6.484 2 12.017c0 1.99.522 3.861 1.438 5.479L2.05 21.87a.5.5 0 0 0 .611.61l4.474-1.369A9.953 9.953 0 0 0 12 22c5.522 0 10-4.484 10-10.017C22 6.483 17.522 2 11.999 2z" fill-rule="evenodd" clip-rule="evenodd"/></svg>
                    Order via WhatsApp
                </button>
                <p class="text-center text-[10px] text-neutral-400 mt-3 tracking-wide">Pilih <strong>Add to Cart</strong> untuk simpan, atau <strong>Order</strong> untuk langsung ke WhatsApp.</p>
            </div>
        </div>
    </div>

    <!-- Scroll Animation Script -->
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

                if (this.totalSlides > 0) this.init();
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

        // Simple Intersection Observer for scroll animations
        document.addEventListener('DOMContentLoaded', () => {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target); // Only animate once
                    }
                });
            }, observerOptions);

            const elements = document.querySelectorAll('.reveal-on-scroll');
            elements.forEach(el => observer.observe(el));

            // Initialize Sliders
            document.querySelectorAll('[data-slider]').forEach(slider => {
                new ProductSlider(slider);
            });

            // View All Button Handlers for Multiple Categories
            const viewAllBtns = document.querySelectorAll('.view-all-btn');
            
            viewAllBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const categoryId = btn.dataset.category;
                    const hiddenProducts = document.querySelectorAll('.hidden-product-' + categoryId);
                    let expanded = btn.dataset.expanded === "true";

                    if (!expanded) {
                        // Show hidden products with staggered animation
                        hiddenProducts.forEach((card, index) => {
                            card.classList.remove('hidden');
                            
                            // Small delay to ensure display:none is removed before opacity transition
                            requestAnimationFrame(() => {
                                setTimeout(() => {
                                    card.classList.remove('opacity-0', 'translate-y-8');
                                    card.classList.add('opacity-100', 'translate-y-0');
                                    card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                                }, index * 100); 
                            });
                        });

                        btn.textContent = 'Show Less';
                        btn.dataset.expanded = "true";
                    } else {
                        // Hide products with animation
                        hiddenProducts.forEach((card, index) => {
                            card.classList.remove('opacity-100', 'translate-y-0');
                            card.classList.add('opacity-0', 'translate-y-8');

                            // Hide after animation completes
                            setTimeout(() => {
                                card.classList.add('hidden');
                            }, 600);
                        });

                        btn.textContent = btn.dataset.originalText || 'View All';
                        btn.dataset.expanded = "false";
                    }
                });
            });
        });

        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        if (menuToggle && mobileMenu) {
            menuToggle.addEventListener('click', () => {
                const isHidden = mobileMenu.classList.contains('hidden');
                const menuIcon = document.getElementById('menuIcon');
                const closeIcon = document.getElementById('closeIcon');

                if (isHidden) {
                    // Open
                    mobileMenu.classList.remove('hidden');
                    mobileMenu.classList.add('animate-slide-in');
                    mobileMenu.classList.remove('animate-slide-out');
                    if (menuIcon) menuIcon.classList.add('hidden');
                    if (closeIcon) closeIcon.classList.remove('hidden');
                } else {
                    // Close
                    mobileMenu.classList.add('animate-slide-out');
                    mobileMenu.classList.remove('animate-slide-in');

                    mobileMenu.addEventListener('animationend', () => {
                        if (mobileMenu.classList.contains('animate-slide-out')) {
                            mobileMenu.classList.add('hidden');
                            mobileMenu.classList.remove('animate-slide-out');
                        }
                    }, { once: true });

                    if (menuIcon) menuIcon.classList.remove('hidden');
                    if (closeIcon) closeIcon.classList.add('hidden');
                }
            });
        }

        // Flip Card Logic
        document.addEventListener('DOMContentLoaded', () => {
            // Flip Card Logic - Combined Details/Back Button
            document.querySelectorAll('.details-btn, .back-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const article = btn.closest('article');
                    const cardInner = article ? article.querySelector('.transform-style-3d') : null;

                    if (cardInner) {
                       // Find the details button specifically if clicked back button
                       const detailsBtn = article.querySelector('.details-btn');
                       
                        // Animate button
                        if(detailsBtn) detailsBtn.classList.add('opacity-0', 'scale-90');

                        // Toggle flip immediately
                        const isFlippingToBack = !cardInner.classList.contains('rotate-y-180');
                        if (isFlippingToBack) {
                            cardInner.classList.add('rotate-y-180');
                        } else {
                            cardInner.classList.remove('rotate-y-180');
                        }

                        // Change text after fade out
                        setTimeout(() => {
                            if(detailsBtn) {
                                detailsBtn.textContent = isFlippingToBack ? 'Back' : 'Details';
                                detailsBtn.classList.remove('opacity-0', 'scale-90');
                            }
                        }, 300);
                    }
                });
            });
        });
    </script>

    <!-- ===== Checkout Modal Script ===== -->
    <script>
        const WHATSAPP_NUMBER = '6288802612864'; // ← GANTI dengan nomer WA toko

        // Color hex map
        const colorHexMap = {
            'black': '#000000', 'white': '#ffffff', 'grey': '#808080',
            'cream': '#E5D0B1', 'navy': '#000080', 'olive': '#808000',
            'blue': '#0000ff', 'charcoal': '#36454F', 'green': '#4CAF50',
            'red': '#ef4444', 'yellow': '#EAB308', 'purple': '#9333EA',
            'pink': '#EC4899', 'brown': '#92400E',
            'hitam':'#000000', 'putih':'#ffffff', 'abu-abu':'#808080', 
            'krim':'#E5D0B1', 'biru dongker':'#000080', 'biru':'#0000ff', 
            'hijau':'#4CAF50', 'merah':'#ef4444', 'kuning':'#EAB308', 
            'ungu':'#9333EA', 'merah muda':'#EC4899', 'coklat':'#92400E', 
            'krem':'#E5D0B1', 'abu':'#808080'
        };

        let checkoutData = { name:'', price:0, sizes:[], colors:[], image:'' };
        let selectedSize = '';
        let selectedColor = '';
        let quantity = 1;

        const modal = document.getElementById('checkoutModal');
        const drawer = document.getElementById('checkoutDrawer');

        function openCheckoutModal(btn) {
            checkoutData = {
                name: btn.dataset.name,
                price: parseInt(btn.dataset.price.replace(/\./g,'').replace(/,/g,'')),
                sizes: JSON.parse(btn.dataset.sizes || '[]'),
                colors: JSON.parse(btn.dataset.colors || '[]'),
                image: btn.dataset.image
            };
            selectedSize = '';
            selectedColor = '';
            quantity = 1;

            // Populate modal
            document.getElementById('checkoutModalTitle').textContent = checkoutData.name;
            document.getElementById('modalProductImg').src = checkoutData.image;
            document.getElementById('modalProductImg').alt = checkoutData.name;
            document.getElementById('modalProductPrice').textContent = 'IDR ' + checkoutData.price.toLocaleString('id-ID');
            document.getElementById('qtyValue').textContent = '1';
            updateTotalPrice();

            // Sizes
            const sizeSection = document.getElementById('sizeSection');
            const sizeOptions = document.getElementById('sizeOptions');
            sizeOptions.innerHTML = '';
            if (checkoutData.sizes.length > 0) {
                sizeSection.classList.remove('hidden');
                checkoutData.sizes.forEach(size => {
                    const btn = document.createElement('button');
                    btn.className = 'size-option';
                    btn.textContent = size;
                    btn.addEventListener('click', () => {
                        document.querySelectorAll('.size-option').forEach(b => b.classList.remove('selected'));
                        btn.classList.add('selected');
                        selectedSize = size;
                    });
                    sizeOptions.appendChild(btn);
                });
            } else {
                sizeSection.classList.add('hidden');
            }

            // Colors
            const colorSection = document.getElementById('colorSection');
            const colorOptions = document.getElementById('colorOptions');
            colorOptions.innerHTML = '';
            document.getElementById('selectedColorName').textContent = '';
            if (checkoutData.colors.length > 0) {
                colorSection.classList.remove('hidden');
                checkoutData.colors.forEach(color => {
                    const cleanColorName = color.trim().toLowerCase();
                    const hex = colorHexMap[cleanColorName] || (color.startsWith('#') ? color : 'transparent');
                    
                    const swatch = document.createElement('button');
                    swatch.className = 'color-option relative';
                    swatch.style.backgroundColor = hex;
                    swatch.title = color;
                    
                    if (cleanColorName === 'white' || cleanColorName === 'putih' || hex === '#ffffff') {
                        swatch.style.border = '2.5px solid #d4d4d4';
                    }
                    
                    if(hex === 'transparent') {
                        swatch.innerHTML = '<span class="text-[8px] flex items-center justify-center w-full h-full">' + color.substring(0,2).toUpperCase() + '</span>';
                        swatch.style.backgroundColor = '#f3f4f6'; 
                    }

                    swatch.addEventListener('click', () => {
                        document.querySelectorAll('.color-option').forEach(b => b.classList.remove('selected'));
                        swatch.classList.add('selected');
                        selectedColor = color;
                        document.getElementById('selectedColorName').textContent = color;
                    });
                    colorOptions.appendChild(swatch);
                });
            } else {
                colorSection.classList.add('hidden');
            }

            // Show modal
            modal.classList.remove('hidden');
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    drawer.classList.remove('translate-y-full');
                });
            });
            document.body.style.overflow = 'hidden';
        }

        function closeCheckoutModal() {
            drawer.classList.add('translate-y-full');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 400);
        }

        function updateTotalPrice() {
            const total = checkoutData.price * quantity;
            document.getElementById('modalTotalPrice').textContent = 'Total: IDR ' + total.toLocaleString('id-ID');
        }

        // Quantity controls
        document.getElementById('qtyMinus').addEventListener('click', () => {
            if (quantity > 1) { quantity--; document.getElementById('qtyValue').textContent = quantity; updateTotalPrice(); }
        });
        document.getElementById('qtyPlus').addEventListener('click', () => {
            quantity++; document.getElementById('qtyValue').textContent = quantity; updateTotalPrice();
        });

        // Close button
        document.getElementById('closeCheckoutModal').addEventListener('click', closeCheckoutModal);
        document.getElementById('checkoutBackdrop').addEventListener('click', closeCheckoutModal);

        // WhatsApp Checkout
        document.getElementById('checkoutWhatsapp').addEventListener('click', () => {
            if (checkoutData.sizes.length > 0 && !selectedSize) {
                alert('Silakan pilih ukuran / Please select a size.');
                return;
            }
            if (checkoutData.colors.length > 0 && !selectedColor) {
                alert('Silakan pilih warna / Please select a color.');
                return;
            }
            const total = checkoutData.price * quantity;
            let msg = `Halo Collarbone! Saya ingin memesan:\n\n`;
            msg += `📦 *Produk:* ${checkoutData.name}\n`;
            if (selectedSize)  msg += `📐 *Ukuran:* ${selectedSize}\n`;
            if (selectedColor) msg += `🎨 *Warna:* ${selectedColor}\n`;
            msg += `🔢 *Qty:* ${quantity}\n`;
            msg += `💰 *Total:* IDR ${total.toLocaleString('id-ID')}\n\n`;
            msg += `Mohon informasi ketersediaan dan cara pembayaran. Terima kasih! 🙏`;
            const url = `https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(msg)}`;
            window.open(url, '_blank');
        });

        // Bind Order buttons + Cart quick-add
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.order-btn');
            if (btn) { e.stopPropagation(); openCheckoutModal(btn); }

            // Cart quick-add: open the same modal
            const cartBtn = e.target.closest('.cart-quick-btn');
            if (cartBtn) { e.stopPropagation(); openCheckoutModal(cartBtn); }
        });

        // Add to Cart from modal
        document.getElementById('addToCartFromModal').addEventListener('click', () => {
            if (checkoutData.sizes.length > 0 && !selectedSize) {
                alert('Silakan pilih ukuran / Please select a size.');
                return;
            }
            if (checkoutData.colors.length > 0 && !selectedColor) {
                alert('Silakan pilih warna / Please select a color.');
                return;
            }
            cartAddItem({
                name:  checkoutData.name,
                price: checkoutData.price,
                size:  selectedSize,
                color: selectedColor,
                image: checkoutData.image,
                qty:   quantity
            });
            closeCheckoutModal();
            // Show cart sidebar after adding
            setTimeout(() => {
                document.getElementById('cartSidebar').classList.add('cart-open');
                document.getElementById('cartOverlay').classList.add('cart-visible');
                document.body.style.overflow = 'hidden';
            }, 450);
        });
    </script>

    <!-- Cart System JS -->
    <script>
    (function(){
        const WA_NUMBER = '6288802612864'; // ← GANTI nomer WA toko
        const CART_KEY = 'collarbone_cart';
        function loadCart(){ try{ return JSON.parse(localStorage.getItem(CART_KEY))||[]; }catch(e){ return []; } }
        function saveCart(c){ localStorage.setItem(CART_KEY, JSON.stringify(c)); }
        function cKey(i){ return i.name+'|'+(i.size||'')+'|'+(i.color||''); }

        window.cartAddItem = function(item){
            const cart=loadCart(), key=cKey(item), ex=cart.find(c=>cKey(c)===key);
            if(ex){ ex.qty+=(item.qty||1); }else{ cart.push({...item,qty:item.qty||1}); }
            saveCart(cart); renderCart();
            const b=document.getElementById('cartBadge');
            if(b){ b.classList.add('cart-badge-bounce'); setTimeout(()=>b.classList.remove('cart-badge-bounce'),400); }
        };
        window.cartChangeQty=function(idx,delta){ const cart=loadCart(); if(!cart[idx])return; cart[idx].qty=Math.max(1,cart[idx].qty+delta); saveCart(cart); renderCart(); };
        window.cartRemove=function(idx){ const cart=loadCart(); cart.splice(idx,1); saveCart(cart); renderCart(); };

        function renderCart(){
            const cart=loadCart(), container=document.getElementById('cartItemsContainer'), empty=document.getElementById('cartEmptyState'), footer=document.getElementById('cartFooter'), badge=document.getElementById('cartBadge'), countEl=document.getElementById('cartItemCount');
            if(!container)return;
            const totalQty=cart.reduce((s,c)=>s+c.qty,0), totalAmt=cart.reduce((s,c)=>s+(c.price*c.qty),0);
            if(badge){ if(totalQty>0){badge.textContent=totalQty>99?'99+':totalQty;badge.classList.remove('hidden');}else badge.classList.add('hidden'); }
            if(countEl) countEl.textContent=totalQty>0?`(${totalQty} item${totalQty>1?'s':''})`:'';
            const totalEl=document.getElementById('cartTotal'); if(totalEl) totalEl.textContent='IDR '+totalAmt.toLocaleString('id-ID');
            if(cart.length===0){ container.classList.add('hidden'); container.innerHTML=''; if(empty)empty.classList.remove('hidden'); if(footer)footer.classList.add('hidden'); return; }
            if(empty)empty.classList.add('hidden'); if(footer)footer.classList.remove('hidden'); container.classList.remove('hidden');
            container.innerHTML=cart.map((item,idx)=>`
                <div class="flex gap-3 items-start border-b border-neutral-50 pb-4">
                    <img src="${item.image}" alt="${item.name}" class="cart-item-img border border-neutral-100">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-neutral-900 leading-tight mb-0.5 truncate">${item.name}</p>
                        ${item.size?`<p class="text-[10px] text-neutral-400">Size: ${item.size}</p>`:''}
                        ${item.color?`<p class="text-[10px] text-neutral-400">Color: ${item.color}</p>`:''}
                        <p class="text-xs font-medium text-[#2a9d9d] mt-1">IDR ${item.price.toLocaleString('id-ID')}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <button class="cart-qty-btn" onclick="cartChangeQty(${idx},-1)">−</button>
                            <span class="text-xs font-semibold w-4 text-center">${item.qty}</span>
                            <button class="cart-qty-btn" onclick="cartChangeQty(${idx},1)">+</button>
                            <button class="ml-2 text-[10px] text-red-400 hover:text-red-600 uppercase transition-colors" onclick="cartRemove(${idx})">Remove</button>
                        </div>
                    </div>
                </div>`).join('');
        }

        function openCart(){ document.getElementById('cartSidebar').classList.add('cart-open'); document.getElementById('cartOverlay').classList.add('cart-visible'); document.body.style.overflow='hidden'; }
        function closeCart(){ document.getElementById('cartSidebar').classList.remove('cart-open'); document.getElementById('cartOverlay').classList.remove('cart-visible'); document.body.style.overflow=''; }

        document.addEventListener('DOMContentLoaded',function(){
            renderCart();
            document.getElementById('cartToggleBtn')?.addEventListener('click',openCart);
            document.getElementById('closeCartBtn')?.addEventListener('click',closeCart);
            document.getElementById('cartOverlay')?.addEventListener('click',closeCart);
            document.getElementById('clearCartBtn')?.addEventListener('click',()=>{ saveCart([]); renderCart(); });
            document.getElementById('cartCheckoutBtn')?.addEventListener('click',()=>{
                const cart=loadCart();
                if(!cart.length){ alert('Keranjang masih kosong!'); return; }
                const total=cart.reduce((s,c)=>s+c.price*c.qty,0);
                let msg='Halo Collarbone! Saya ingin memesan:\n\n';
                cart.forEach((item,i)=>{ msg+=`${i+1}. *${item.name}*`; if(item.size)msg+=` | Size: ${item.size}`; if(item.color)msg+=` | Color: ${item.color}`; msg+=` | Qty: ${item.qty} | IDR ${(item.price*item.qty).toLocaleString('id-ID')}\n`; });
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
