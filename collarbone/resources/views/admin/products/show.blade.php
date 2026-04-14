@extends('admin.layout')

@section('title', $product->name)
@section('page-title', 'Detail Produk')
@section('page-subtitle', $product->name)

@section('topbar-actions')
    <div style="display: flex; gap: 8px;">
        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit
        </a>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali
        </a>
    </div>
@endsection

@section('content')
    <div class="detail-grid">
        <!-- Images -->
        <div class="detail-images">
            @if($product->images && count($product->images) > 0)
                <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" class="main-image" id="mainImage">
                @if(count($product->images) > 1)
                    <div class="thumb-grid">
                        @foreach($product->images as $img)
                            <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" onclick="document.getElementById('mainImage').src=this.src">
                        @endforeach
                    </div>
                @endif
            @else
                <div class="main-image" style="display:flex;align-items:center;justify-content:center;background:var(--bg-input)">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="color:var(--text-muted)"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
            @endif
        </div>

        <!-- Info -->
        <div class="detail-info">
            <div style="display: flex; gap: 8px; margin-bottom: 12px;">
                @if($product->is_active)
                    <span class="badge badge-success">Aktif</span>
                @else
                    <span class="badge badge-danger">Nonaktif</span>
                @endif
                @if($product->is_featured)
                    <span class="badge badge-info">★ Featured</span>
                @endif
                @if($product->is_new_arrival)
                    <span class="badge badge-purple">New Arrival</span>
                @endif
            </div>

            <h1>{{ $product->name }}</h1>

            <div class="price-group">
                @if($product->is_on_sale)
                    <span class="price">{{ $product->formatted_sale_price }}</span>
                    <span class="original-price">{{ $product->formatted_price }}</span>
                @else
                    <span class="price">{{ $product->formatted_price }}</span>
                @endif
            </div>

            @if($product->description)
                <div class="card" style="margin-bottom: 24px;">
                    <div class="card-body">
                        <p style="color: var(--text-secondary); line-height: 1.8;">{{ $product->description }}</p>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <dl class="detail-meta">
                        <dt>Kategori</dt>
                        <dd><span class="badge badge-purple">{{ $product->category->name ?? '-' }}</span></dd>

                        <dt>SKU</dt>
                        <dd>{{ $product->sku ?? '-' }}</dd>

                        <dt>Stok</dt>
                        <dd>
                            @if($product->stock < 10)
                                <span class="badge badge-warning">{{ $product->stock }} unit</span>
                            @else
                                <span class="badge badge-success">{{ $product->stock }} unit</span>
                            @endif
                        </dd>

                        @if($product->colors && count($product->colors) > 0)
                            <dt>Warna</dt>
                            <dd>
                                @foreach($product->colors as $color)
                                    <span class="badge badge-info" style="margin: 2px;">{{ $color }}</span>
                                @endforeach
                            </dd>
                        @endif

                        @if($product->sizes && count($product->sizes) > 0)
                            <dt>Ukuran</dt>
                            <dd>
                                @foreach($product->sizes as $size)
                                    <span class="badge badge-info" style="margin: 2px;">{{ $size }}</span>
                                @endforeach
                            </dd>
                        @endif

                        <dt>Dibuat</dt>
                        <dd>{{ $product->created_at->format('d M Y, H:i') }}</dd>

                        <dt>Diperbarui</dt>
                        <dd>{{ $product->updated_at->format('d M Y, H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
