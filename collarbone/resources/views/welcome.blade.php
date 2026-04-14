@extends('layouts.frontend')

@section('title', 'Collarbone')

@push('styles')
<script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'system-ui', 'sans-serif'],
          },
          colors: {
            orbis: {
              teal: '#2a9d9d',
              'dark-teal': '#1a6b6b',
              charcoal: '#262626',
              grey: '#808080',
              'light-grey': '#f5f5f5',
            },
          },
          letterSpacing: {
            'orbis': '0.3em',
            'orbis-wide': '0.5em',
          },
          animation: {
            'fade-up': 'fadeUp 0.8s ease-out',
            'slide-in': 'slideIn 0.4s ease-out',
            'slide-out': 'slideOut 0.4s ease-in forwards',
            'marquee': 'marquee 40s linear infinite',
          },
          keyframes: {
            fadeUp: {
              '0%': { opacity: '0', transform: 'translateY(20px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' },
            },
            slideIn: {
              '0%': { transform: 'translateX(-100%)' },
              '100%': { transform: 'translateX(0)' },
            },
            slideOut: {
              '0%': { transform: 'translateX(0)' },
              '100%': { transform: 'translateX(-100%)' },
            },
            marquee: {
              '0%': { transform: 'translateX(0)' },
              '100%': { transform: 'translateX(-50%)' },
            },
          },
        },
      },
    }
</script>
<style>
    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Inter', system-ui, sans-serif;
    }

    /* Hero overlay */
    .hero-overlay {
      background: linear-gradient(to top, rgba(0, 0, 0, 0.45), rgba(0,0,0,0.05), transparent);
    }

    .stroke-text {
      -webkit-text-stroke: 1px white;
    }

    /* Slider dots */
    .slider-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.4);
      transition: all 0.3s;
      cursor: pointer;
    }

    .slider-dot.active {
      background: white;
      box-shadow: 0 0 8px rgba(255,255,255,0.4);
    }

    /* Hide scrollbar */
    .hide-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .hide-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    /* Scroll Reveal Animation */
    .reveal {
      opacity: 0;
      transform: translateY(30px);
      transition: all 1s cubic-bezier(0.5, 0, 0, 1);
    }

    .reveal.active {
      opacity: 1;
      transform: translateY(0);
    }

    /* Stagger delays */
    .delay-100 { transition-delay: 0.1s; }
    .delay-200 { transition-delay: 0.2s; }
    .delay-300 { transition-delay: 0.3s; }

    /* Hero Image Zoom */
    .slide img {
      transition: transform 8s ease;
      transform: scale(1);
    }

    .slide.active img {
      transform: scale(1.1);
    }

    /* Product Card Hover */
    .product-card-modern {
      transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
    }
    .product-card-modern:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }

    /* Checkout Modal */
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
</style>
@endpush

@section('content')
<main>
    <!-- Hero Slider -->
    <section id="heroSlider" class="relative h-[calc(100vh-4.5rem-0.375rem)] overflow-hidden">
      <!-- Slides -->
      @forelse($heroSlides as $index => $slide)
          <div class="slide {{ $index === 0 ? 'active' : '' }} absolute inset-0 transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}">
            <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" class="w-full h-full object-cover">
            <div class="hero-overlay absolute inset-0"></div>
          </div>
      @empty
          <!-- Default Slide if no data -->
          <div class="slide active absolute inset-0 transition-opacity duration-1000 opacity-100">
            <img src="{{ asset('img/baju.jpg') }}" alt="Default" class="w-full h-full object-cover">
            <div class="hero-overlay absolute inset-0"></div>
          </div>
      @endforelse

      <!-- Content -->
      <div class="absolute inset-0 flex flex-col items-center justify-center text-center z-10 transition-all duration-500 bg-black/20" id="slideContent">
        <p id="slideLabel" class="text-white text-sm md:text-base tracking-[0.4em] font-medium mb-4 animate-fade-up">
            {{ $heroSlides->first()->subtitle ?? 'NEW ARRIVALS' }}
        </p>
        <h2 id="slideTitle" class="text-white text-5xl md:text-8xl font-black tracking-tighter uppercase mb-6 animate-fade-up drop-shadow-2xl hero-text-shadow">
          {{ $heroSlides->first()->title ?? 'Welcome' }}
        </h2>
        <a href="#collections" class="mt-8 text-white border border-white px-8 py-3 rounded-full hover:bg-white hover:text-black transition-colors duration-300 tracking-widest text-xs uppercase font-semibold">Explore Now</a>
      </div>

      <!-- Dots Navigation -->
      <div class="absolute bottom-16 right-6 lg:right-12 flex gap-3 z-10">
        @if($heroSlides->count() > 0)
            @foreach($heroSlides as $index => $slide)
                <button class="slider-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})"></button>
            @endforeach
        @else
            <button class="slider-dot active"></button>
        @endif
      </div>
    </section>

    <!-- Collection Grid (Bento Style) -->
    <section id="collections" class="py-20 lg:py-32 px-6 lg:px-12 bg-[#fafaf9]">
      <div class="flex flex-col items-center text-center mb-16 reveal">
        <div class="w-12 h-[3px] bg-[#2a9d9d] mb-6"></div>
        <h2 class="text-3xl md:text-5xl font-bold tracking-tighter uppercase text-neutral-900 mb-4">Curated Style</h2>
        <p class="text-neutral-500 max-w-lg mx-auto text-sm">Discover our signature collections crafted for the modern streetwear enthusiast.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-2 gap-4 lg:gap-6 min-h-[600px] md:min-h-[800px]">
        @forelse($collections as $index => $collection)
          @php
            // Bento logic: First item gets big square, others get different spans
            $spanClasses = '';
            $aspectClass = 'h-full w-full';
            if($index === 0) {
              $spanClasses = 'md:col-span-2 md:row-span-2';
            } elseif ($index === 1) {
              $spanClasses = 'md:col-span-2 md:row-span-1';
            } elseif ($index === 2) {
              $spanClasses = 'md:col-span-1 md:row-span-1';
            } else {
              $spanClasses = 'md:col-span-1 md:row-span-1';
            }
          @endphp
        <a href="{{ $collection->link ?? '#' }}" class="{{ $spanClasses }} group relative overflow-hidden reveal delay-{{ ($index + 1) * 100 }} rounded-[2rem] shadow-lg hover:shadow-2xl transition-all duration-700">
          <img src="{{ $collection->image_url }}" alt="{{ $collection->title }}"
            class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110 bg-neutral-200">
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-500"></div>
          
          <!-- Decorative UI elements on Bento cards -->
          <div class="absolute top-6 right-6 w-10 h-10 rounded-full border border-white/30 flex items-center justify-center backdrop-blur-md opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-500">
             <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </div>

          <div class="absolute bottom-8 left-8 right-8">
            <span class="inline-block px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] tracking-widest font-semibold uppercase rounded-full mb-3">{{ $collection->subtitle ?? 'CATEGORY' }}</span>
            <h3 class="text-white text-3xl {{ $index === 0 ? 'md:text-5xl' : 'md:text-3xl' }} font-bold tracking-tight mb-2 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">{{ $collection->title }}</h3>
            <div class="h-[2px] w-0 bg-[#2a9d9d] group-hover:w-16 transition-all duration-500"></div>
          </div>
        </a>
        @empty
        <div class="col-span-4 text-center py-20 text-neutral-400">Belum ada collection</div>
        @endforelse 
      </div>
    </section>

    <!-- Section Divider -->
    <div class="section-divider"></div>

    <!-- Featured Products -->
    <section class="py-16 lg:py-24 px-6 lg:px-12 bg-gradient-to-b from-[#f5fafa] to-white relative">
      <!-- Decorative background -->
      <div class="absolute top-0 right-0 w-[300px] h-[300px] bg-[#2a9d9d]/[0.03] rounded-full blur-[80px] pointer-events-none"></div>
      <div class="flex items-center gap-4 mb-12 reveal relative">
        <div class="w-8 h-[2px] bg-[#2a9d9d]"></div>
        <h2 class="text-xl lg:text-2xl font-light tracking-orbis">FEATURED</h2>
        <div class="flex-1 h-[1px] bg-neutral-200"></div>
        <span class="text-[10px] tracking-widest text-[#2a9d9d] uppercase font-medium bg-[#2a9d9d]/10 px-3 py-1 rounded-full">{{ $featuredProducts->count() }} Items</span>
      </div>
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 relative">
        @forelse($featuredProducts as $product)
        <article class="group reveal delay-{{ ($loop->index % 4) * 100 }}">
          <div class="aspect-square overflow-hidden mb-4 rounded-xl bg-neutral-100 relative shadow-sm product-card-modern border border-neutral-100 hover:border-[#2a9d9d]/30">
            <img src="{{ $product->thumbnail ?? asset('img/placeholder.jpg') }}" alt="{{ $product->name }}"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            <!-- Featured badge -->
            <div class="absolute top-2.5 left-2.5 bg-[#2a9d9d] text-white text-[8px] tracking-wider uppercase px-2 py-0.5 rounded-full font-medium shadow-sm">Featured</div>
          </div>
          <p class="text-[10px] tracking-orbis text-neutral-500 mb-1">{{ $product->category->name ?? 'PRODUCT' }}</p>
          <h3 class="text-sm font-medium text-neutral-900 mb-1">{{ $product->name }}</h3>
          <div class="flex items-center justify-between mt-1 gap-1">
            <p class="text-sm font-medium text-neutral-900">IDR {{ number_format($product->price, 0, ',', '.') }}</p>
            <div class="flex gap-1">
              <button class="cart-quick-btn p-1.5 border border-neutral-200 bg-white hover:bg-neutral-900 hover:text-white hover:border-neutral-900 text-neutral-900 transition-all duration-300 rounded-lg"
                data-name="{{ $product->name }}" data-price="{{ (int)$product->price }}"
                data-sizes='@json($product->sizes ?? [])' data-colors='@json($product->colors ?? [])'
                data-image="{{ $product->thumbnail ?? asset('img/placeholder.jpg') }}" title="Add to Cart">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
              </button>
              <button class="order-btn uppercase tracking-widest px-3 py-1.5 border border-[#2a9d9d] bg-[#2a9d9d] hover:bg-[#1a6b6b] text-white transition-all duration-300 rounded-lg text-[10px] font-medium shadow-sm hover:shadow-md"
                data-name="{{ $product->name }}" data-price="{{ number_format($product->price, 0, ',', '.') }}"
                data-sizes='@json($product->sizes ?? [])' data-colors='@json($product->colors ?? [])'
                data-image="{{ $product->thumbnail ?? asset('img/placeholder.jpg') }}">Order</button>
            </div>
          </div>
        </article>
        @empty
          <p class="text-neutral-500 col-span-full">No featured products found.</p>
        @endforelse
      </div>
    </section>

    <!-- Brand Banner -->
    <section class="relative h-[60vh] lg:h-[80vh] overflow-hidden">
      <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1920&q=80" alt="Brand Story"
        class="w-full h-full object-cover">
      <div class="absolute inset-0 bg-neutral-900/40"></div>

      <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-6 reveal">
        <div
          class="bg-neutral-900/20 backdrop-blur-xl p-8 md:p-14 rounded-3xl max-w-4xl mx-auto border border-white/15 shadow-2xl">
          <p class="text-white text-xs tracking-orbis-wide mb-4 opacity-80">Collarbone</p>
          <h2 class="text-white text-3xl lg:text-5xl font-light tracking-orbis mb-6">TIMELESS STREETWEAR FOR THE
            MODERN ERA</h2>
          <a href="{{ route('categories') }}"
            class="inline-flex items-center justify-center px-8 py-3 text-xs font-medium tracking-[0.2em] uppercase bg-white text-neutral-900 border border-white hover:bg-transparent hover:text-white hover:border-white transition-all duration-300 rounded-full shadow-lg">DISCOVER
            MORE</a>
        </div>
      </div>
    </section>

    <!-- Marquee Text Section (Replaced Newsletter) -->
    <section class="py-12 bg-black overflow-hidden reveal">
      <div class="flex animate-marquee whitespace-nowrap">
        <div class="flex items-center">
            <span class="text-white text-4xl md:text-7xl font-black tracking-tighter uppercase mx-8">NO RESTOCKS —</span>
            <span class="text-transparent stroke-text text-4xl md:text-7xl font-black tracking-tighter uppercase mx-8">LIMITED DROPS ONLY —</span>
            <span class="text-white text-4xl md:text-7xl font-black tracking-tighter uppercase mx-8">BORN WITH ART —</span>
            <span class="text-transparent stroke-text text-4xl md:text-7xl font-black tracking-tighter uppercase mx-8">EST 2024 —</span>
            <span class="text-white text-4xl md:text-7xl font-black tracking-tighter uppercase mx-8">COLLARBONE ARCHIVE —</span>
        </div>
        <!-- Duplicate for seamless loop -->
        <div class="flex items-center">
            <span class="text-white text-4xl md:text-7xl font-black tracking-tighter uppercase mx-8">NO RESTOCKS —</span>
            <span class="text-transparent stroke-text text-4xl md:text-7xl font-black tracking-tighter uppercase mx-8">LIMITED DROPS ONLY —</span>
            <span class="text-white text-4xl md:text-7xl font-black tracking-tighter uppercase mx-8">BORN WITH ART —</span>
            <span class="text-transparent stroke-text text-4xl md:text-7xl font-black tracking-tighter uppercase mx-8">EST 2024 —</span>
            <span class="text-white text-4xl md:text-7xl font-black tracking-tighter uppercase mx-8">COLLARBONE ARCHIVE —</span>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 lg:py-28 bg-gradient-to-b from-[#f0fafa] via-[#f5fafa] to-white overflow-hidden relative">
      <!-- Decorative blobs -->
      <div class="absolute top-0 left-0 w-[250px] h-[250px] bg-[#2a9d9d]/[0.04] rounded-full blur-[80px] pointer-events-none"></div>
      <div class="absolute bottom-0 right-0 w-[200px] h-[200px] bg-[#2a9d9d]/[0.03] rounded-full blur-[60px] pointer-events-none"></div>
      <div class="px-6 lg:px-12 mb-16 text-center reveal relative">
        <p class="text-[10px] tracking-[0.3em] uppercase text-[#2a9d9d] font-medium mb-4">Testimonials</p>
        <h2 class="text-3xl lg:text-5xl font-light tracking-orbis text-neutral-900 mb-8">What They Say
          <br>About Our's Products
        </h2>
      </div>

      <div class="relative w-full">
        <!-- Gradient Masks -->
        <div class="absolute inset-y-0 left-0 w-20 lg:w-40 bg-gradient-to-r from-neutral-50 to-transparent z-10 pointer-events-none"></div>
        <div class="absolute inset-y-0 right-0 w-20 lg:w-40 bg-gradient-to-l from-neutral-50 to-transparent z-10 pointer-events-none"></div>

        <!-- Marquee Container -->
        <div class="flex w-max animate-marquee hover:[animation-play-state:paused] items-stretch">
          <!-- Original Cards -->
          <div class="flex gap-6 mx-3">
            @for($i = 0; $i < 5; $i++)
            @foreach($testimonials as $testimonial)
            <div class="bg-white p-8 rounded-2xl shadow-[0_2px_16px_rgba(0,0,0,0.04)] border border-neutral-100/80 w-[400px] flex-shrink-0 flex flex-col justify-between transition-all duration-500 hover:scale-[1.03] hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] cursor-default">
              <div>
                <p class="text-neutral-600 font-light leading-relaxed mb-8">"{{ $testimonial->content }}"</p>
              </div>
              <div class="flex items-center gap-4">
                @if($testimonial->photo_url)
                <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="w-12 h-12 rounded-full object-cover">
                @else
                <div class="w-12 h-12 rounded-full bg-neutral-200 flex items-center justify-center text-neutral-500 text-lg font-semibold">{{ substr($testimonial->name, 0, 1) }}</div>
                @endif
                <div>
                  <h4 class="font-medium text-sm text-neutral-900">{{ $testimonial->name }}</h4>
                  <p class="text-xs text-neutral-500">{{ $testimonial->role }}</p>
                </div>
              </div>
            </div>
            @endforeach
            @endfor
          </div>

          <!-- Duplicate Cards (for seamless marquee loop) -->
          <div class="flex gap-6 mx-3" aria-hidden="true">
            @for($i = 0; $i < 5; $i++)
            @foreach($testimonials as $testimonial)
            <div class="bg-white p-8 rounded-2xl shadow-[0_2px_16px_rgba(0,0,0,0.04)] border border-neutral-100/80 w-[400px] flex-shrink-0 flex flex-col justify-between transition-all duration-500 hover:scale-[1.03] hover:shadow-[0_8px_30px_rgba(0,0,0,0.08)] cursor-default">
              <div>
                <p class="text-neutral-600 font-light leading-relaxed mb-8">"{{ $testimonial->content }}"</p>
              </div>
              <div class="flex items-center gap-4">
                @if($testimonial->photo_url)
                <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" class="w-12 h-12 rounded-full object-cover">
                @else
                <div class="w-12 h-12 rounded-full bg-neutral-200 flex items-center justify-center text-neutral-500 text-lg font-semibold">{{ substr($testimonial->name, 0, 1) }}</div>
                @endif
                <div>
                  <h4 class="font-medium text-sm text-neutral-900">{{ $testimonial->name }}</h4>
                  <p class="text-xs text-neutral-500">{{ $testimonial->role }}</p>
                </div>
              </div>
            </div>
            @endforeach
            @endfor
          </div>
        </div>
      </div>
    </section>
</main>

<!-- Checkout Modal -->
<div id="checkoutModal" class="fixed inset-0 z-[200] hidden" role="dialog" aria-modal="true" aria-labelledby="checkoutModalTitle">
    <div id="checkoutBackdrop" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div id="checkoutDrawer" class="absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl shadow-2xl translate-y-full max-h-[92vh] overflow-y-auto">
        <div class="flex justify-center pt-3 pb-1"><div class="w-10 h-1 bg-neutral-200 rounded-full"></div></div>
        <div class="px-6 pt-4 pb-10">
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

@endsection

@push('scripts')
<script>
    // Hero slider
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    const slideLabel = document.getElementById('slideLabel');
    const slideTitle = document.getElementById('slideTitle');
    const slideLink = document.getElementById('slideLink');

    // Get Data from PHP
    const slideData = @json($heroSlides->map(fn($s) => [
        'label' => $s->subtitle, 
        'title' => $s->title, 
        'link' => $s->link
    ]));

    // Fallback if empty
    if(slideData.length === 0) {
        slideData.push({ label: 'NEW ARRIVALS', title: 'Welcome', link: '#' });
    }

    let currentSlide = 0;

    function goToSlide(index) {
      if(!slides.length) return;
      
      slides.forEach((slide, i) => {
        slide.style.opacity = i === index ? '1' : '0';
        if (i === index) slide.classList.add('active');
        else slide.classList.remove('active');
      });

      dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
      });

      // Update Text Content with animation reset
      if(slideData[index]) {
          if(slideLabel) {
              slideLabel.style.animation = 'none';
              slideLabel.offsetHeight; /* trigger reflow */
              slideLabel.style.animation = null; 
              slideLabel.textContent = slideData[index].label || '';
          }
          if(slideTitle) {
              slideTitle.style.animation = 'none';
              slideTitle.offsetHeight; /* trigger reflow */
              slideTitle.style.animation = null;
              slideTitle.textContent = slideData[index].title || '';
          }
          if(slideLink) {
              slideLink.href = slideData[index].link || '#';
          }
      }
      currentSlide = index;
    }
    
    // Add Click Listeners explicitly if needed, though onClick is in HTML
    dots.forEach((dot, index) => {
       dot.onclick = () => goToSlide(index); 
    });

    // Intersection Observer for Scroll Animation
    const observerOptions = {
      root: null,
      rootMargin: '0px',
      threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
          observer.unobserve(entry.target); // Only animate once
        }
      });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => {
      observer.observe(el);
    });
    // Auto-advance slider
    setInterval(() => {
      goToSlide((currentSlide + 1) % slides.length);
    }, 5000);
</script>

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
        // Parse price: remove dots used as thousands separators
        const rawPrice = btn.dataset.price.replace(/\./g, '').replace(/,/g, '.');
        checkoutData = {
            name: btn.dataset.name,
            price: parseFloat(rawPrice) || 0,
            sizes: JSON.parse(btn.dataset.sizes || '[]'),
            colors: JSON.parse(btn.dataset.colors || '[]'),
            image: btn.dataset.image
        };
        selectedSize = ''; selectedColor = ''; quantity = 1;
        document.getElementById('checkoutModalTitle').textContent = checkoutData.name;
        document.getElementById('modalProductImg').src = checkoutData.image;
        document.getElementById('modalProductPrice').textContent = 'IDR ' + checkoutData.price.toLocaleString('id-ID');
        document.getElementById('qtyValue').textContent = '1';
        updateTotalPrice();

        const sizeSection = document.getElementById('sizeSection');
        const sizeOptions = document.getElementById('sizeOptions');
        sizeOptions.innerHTML = '';
        if (checkoutData.sizes.length > 0) {
            sizeSection.classList.remove('hidden');
            checkoutData.sizes.forEach(size => {
                const b = document.createElement('button');
                b.className = 'size-option'; b.textContent = size;
                b.addEventListener('click', () => { document.querySelectorAll('.size-option').forEach(x => x.classList.remove('selected')); b.classList.add('selected'); selectedSize = size; });
                sizeOptions.appendChild(b);
            });
        } else sizeSection.classList.add('hidden');

        const colorSection = document.getElementById('colorSection');
        const colorOptions = document.getElementById('colorOptions');
        colorOptions.innerHTML = ''; document.getElementById('selectedColorName').textContent = '';
        if (checkoutData.colors.length > 0) {
            colorSection.classList.remove('hidden');
            checkoutData.colors.forEach(color => {
                // Konversi warna ke lowercase untuk mencari di mapping
                const cleanColorName = color.trim().toLowerCase();
                // Jika tidak ada di mapping, asumsikan itu kode HEX yang valid dari database, atau set default transparent
                const hex = colorHexMap[cleanColorName] || (color.startsWith('#') ? color : 'transparent');
                
                const s = document.createElement('button');
                s.className = 'color-option relative'; 
                s.style.backgroundColor = hex; 
                s.title = color;
                
                // Tambahkan border khusus untuk warna putih atau cerah agar terlihat
                if (cleanColorName === 'white' || cleanColorName === 'putih' || hex === '#ffffff') {
                    s.style.border = '2.5px solid #d4d4d4';
                }
                
                // Fallback teks di dalam lingkaran jika warna tidak valid
                if(hex === 'transparent') {
                    s.innerHTML = '<span class="text-[8px] flex items-center justify-center w-full h-full">' + color.substring(0,2).toUpperCase() + '</span>';
                    s.style.backgroundColor = '#f3f4f6'; 
                }
                s.addEventListener('click', () => { document.querySelectorAll('.color-option').forEach(x => x.classList.remove('selected')); s.classList.add('selected'); selectedColor = color; document.getElementById('selectedColorName').textContent = color; });
                colorOptions.appendChild(s);
            });
        } else colorSection.classList.add('hidden');

        modal.classList.remove('hidden');
        requestAnimationFrame(() => requestAnimationFrame(() => drawer.classList.remove('translate-y-full')));
        document.body.style.overflow = 'hidden';
    }

    function closeCheckoutModal() {
        drawer.classList.add('translate-y-full');
        setTimeout(() => { modal.classList.add('hidden'); document.body.style.overflow = ''; }, 400);
    }

    function updateTotalPrice() {
        document.getElementById('modalTotalPrice').textContent = 'Total: IDR ' + (checkoutData.price * quantity).toLocaleString('id-ID');
    }

    document.getElementById('qtyMinus').addEventListener('click', () => { if (quantity > 1) { quantity--; document.getElementById('qtyValue').textContent = quantity; updateTotalPrice(); } });
    document.getElementById('qtyPlus').addEventListener('click', () => { quantity++; document.getElementById('qtyValue').textContent = quantity; updateTotalPrice(); });
    document.getElementById('closeCheckoutModal').addEventListener('click', closeCheckoutModal);
    document.getElementById('checkoutBackdrop').addEventListener('click', closeCheckoutModal);

    document.getElementById('checkoutWhatsapp').addEventListener('click', () => {
        if (checkoutData.sizes.length > 0 && !selectedSize) { alert('Silakan pilih ukuran / Please select a size.'); return; }
        if (checkoutData.colors.length > 0 && !selectedColor) { alert('Silakan pilih warna / Please select a color.'); return; }
        const total = checkoutData.price * quantity;
        let msg = `Halo Collarbone! Saya ingin memesan:\n\n *Produk:* ${checkoutData.name}\n`;
        if (selectedSize) msg += ` *Ukuran:* ${selectedSize}\n`;
        if (selectedColor) msg += ` *Warna:* ${selectedColor}\n`;
        msg += ` *Qty:* ${quantity}\n *Total:* IDR ${total.toLocaleString('id-ID')}\n\nMohon informasi ketersediaan dan cara pembayaran. Terima kasih! 🙏`;
        window.open(`https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(msg)}`, '_blank');
    });

    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.order-btn');
        if (btn) { e.stopPropagation(); openCheckoutModal(btn); }

        // Cart quick-add: open modal for size/color selection
        const cartBtn = e.target.closest('.cart-quick-btn');
        if (cartBtn) { e.stopPropagation(); openCheckoutModal(cartBtn); }
    });

    // Add to Cart from modal
    document.getElementById('addToCartFromModal').addEventListener('click', () => {
        if (checkoutData.sizes.length > 0 && !selectedSize) { alert('Silakan pilih ukuran / Please select a size.'); return; }
        if (checkoutData.colors.length > 0 && !selectedColor) { alert('Silakan pilih warna / Please select a color.'); return; }
        if (typeof addToCart === 'function') {
            addToCart({
                name:  checkoutData.name,
                price: checkoutData.price,
                size:  selectedSize,
                color: selectedColor,
                image: checkoutData.image,
                qty:   quantity
            });
        }
        closeCheckoutModal();
        // Open cart sidebar after modal closes
        setTimeout(() => {
            const sidebar = document.getElementById('cartSidebar');
            const overlay = document.getElementById('cartOverlay');
            if (sidebar) sidebar.classList.add('cart-open');
            if (overlay) overlay.classList.add('cart-visible');
            document.body.style.overflow = 'hidden';
        }, 450);
    });
</script>
@endpush
