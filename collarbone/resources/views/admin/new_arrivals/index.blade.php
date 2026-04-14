@extends('admin.layout')

@section('title', 'New Arrivals')
@section('page-title', 'New Arrivals')
@section('page-subtitle', 'Manage your New Arrivals products')

@section('topbar-actions')
    <div style="display:flex;align-items:center;gap:12px;">
        <form action="{{ route('admin.new_arrivals') }}" method="GET" class="search-box" style="width:260px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
        </form>
        <button class="btn btn-primary" onclick="openModal('addNewArrivalModal')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Product
        </button>
    </div>
@endsection

@section('content')
<style>
    /* Animations */
    @keyframes slideInUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .slide-in-up {
        animation: slideInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    .stagger-1 { animation-delay: 0.05s; }
    .stagger-2 { animation-delay: 0.1s; }
    .stagger-3 { animation-delay: 0.15s; }
    .stagger-4 { animation-delay: 0.2s; }

    /* Stat card icons */
    .stat-card-icon { width: 44px; height: 44px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    .stat-card-icon svg { width: 22px; height: 22px; color: var(--stat-color); }
    .stat-card-icon.teal { --stat-color: #00d4aa; background: rgba(0, 212, 170, 0.1); }
    .stat-card-icon.green { --stat-color: #10b981; background: rgba(16, 185, 129, 0.1); }
    .stat-card-icon.red { --stat-color: #ef4444; background: rgba(239, 68, 68, 0.1); }
    .stat-card-icon.yellow { --stat-color: #f59e0b; background: rgba(245, 158, 11, 0.1); }
    .stat-card-value { font-size: 28px; font-weight: 800; margin: 12px 0 4px; }
    .stat-card-label { font-size: 13px; color: var(--text-secondary); }

    .hero-preview {
        position: relative;
        border-radius: var(--radius);
        overflow: hidden;
        aspect-ratio: 3/1;
        background: #000;
    }
    .hero-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.7;
    }
    .hero-preview-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 20px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 4px;
    }
    .status-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .status-badge.active { color: var(--success); background: rgba(16, 185, 129, 0.1); }
    .status-badge.archived { color: var(--text-muted); background: var(--bg-input); }
    .status-badge.available { color: var(--accent-teal); background: rgba(0, 212, 170, 0.1); }
    .status-badge.out { color: var(--text-muted); background: var(--bg-input); }

    .data-table-wrapper {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        margin-bottom: 32px;
    }
    .data-table-toolbar {
        padding: 16px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .data-table-toolbar-left { display: flex; align-items: baseline; gap: 12px; }
    .data-table-toolbar-right { display: flex; align-items: center; gap: 8px; }

    .table-actions { display: flex; gap: 4px; }
    .table-actions .btn-icon { width: 32px; height: 32px; }
    .table-actions .btn-icon.danger { color: var(--danger); }
    .table-actions .btn-icon.danger:hover { background: rgba(239, 68, 68, 0.1); }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .modal-overlay.active { display: flex; opacity: 1; }
    .modal {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        width: 100%;
        max-width: 560px;
        box-shadow: var(--shadow-lg);
        transform: scale(0.95);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .modal-overlay.active .modal { transform: scale(1); }
    .modal-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-title { font-size: 18px; font-weight: 700; }
    .modal-close { background: none; border: none; color: var(--text-muted); cursor: pointer; }
    .modal-close:hover { color: var(--text-primary); }
    .modal-close svg { width: 20px; height: 20px; }
    .modal-body { padding: 24px; max-height: 70vh; overflow-y: auto; }
    .modal-footer {
        padding: 20px 24px;
        border-top: 1px solid var(--border);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .confirm-dialog {
        text-align: center;
        padding: 20px 0;
    }
    .confirm-dialog svg {
        width: 48px;
        height: 48px;
        color: var(--warning);
        margin-bottom: 16px;
    }
    .confirm-dialog h3 { font-size: 18px; margin-bottom: 8px; }
    .confirm-dialog p { color: var(--text-muted); font-size: 14px; }

    .existing-images-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 8px;
        margin-bottom: 12px;
    }
    .existing-images-grid .img-item {
        position: relative;
        aspect-ratio: 1;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid var(--border);
    }
    .existing-images-grid .img-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .existing-images-grid .img-item .remove-img-btn {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.9);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }
</style>

<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card slide-in-up stagger-1">
        <div class="stat-card-header">
            <div class="stat-card-icon teal">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
        </div>
        <div class="stat-card-value">{{ $totalProducts }}</div>
        <div class="stat-card-label">Total Products</div>
    </div>

    <div class="stat-card slide-in-up stagger-2">
        <div class="stat-card-header">
            <div class="stat-card-icon green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
        </div>
        <div class="stat-card-value">{{ $inStock }}</div>
        <div class="stat-card-label">In Stock</div>
    </div>

    <div class="stat-card slide-in-up stagger-3">
        <div class="stat-card-header">
            <div class="stat-card-icon red">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
        </div>
        <div class="stat-card-value">{{ $lowStock }}</div>
        <div class="stat-card-label">Low Stock</div>
    </div>
</div>

<!-- Hero Banner Management -->
<div class="card slide-in-up" style="animation-delay:0.25s; opacity:0; margin-bottom:24px;">
    <div class="card-header">
        <h2 style="font-size:16px;font-weight:600;">🖼️ Banner New Arrivals</h2>
    </div>
    <div class="card-body">
        <div style="display: flex; gap: 24px; align-items: flex-start; flex-wrap: wrap;">
            <!-- Preview -->
            <div style="flex: 1; min-width: 300px; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; position: relative;">
                <img id="bannerPreviewImg" src="{{ $banner->image_url }}" alt="Banner Preview" style="width: 100%; height: 200px; object-fit: cover;">
                <div id="bannerPreviewOverlay" style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; color: {{ $banner->text_color }}; background: rgba(0,0,0,0.3);">
                    <h3 id="bannerPreviewTitle" style="font-size: 24px; font-weight: 300; letter-spacing: 0.15em; margin-bottom: 8px; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">{{ $banner->title }}</h3>
                    <p id="bannerPreviewSubtitle" style="font-size: 12px; letter-spacing: 0.1em; max-width: 80%; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">{{ $banner->subtitle }}</p>
                </div>
            </div>

            <!-- Edit Form -->
            <div style="flex: 1; min-width: 300px;">
                <form action="{{ route('admin.banners.update', 'new_arrivals') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Judul Banner</label>
                        <input type="text" name="title" class="form-control" value="{{ $banner->title }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subtitle</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ $banner->subtitle }}">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <div class="form-group">
                            <label class="form-label">Warna Teks</label>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <input type="color" id="bannerColorPicker" class="form-control" value="{{ $banner->text_color }}" style="height: 40px; padding: 2px; width: 60px;">
                                <input type="text" name="text_color" id="bannerColorText" class="form-control" value="{{ $banner->text_color }}" style="flex: 1;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Ganti Gambar</label>
                            <input type="file" name="image_path" class="form-control" accept="image/*">
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label class="form-label">Atau URL Gambar</label>
                            <div style="display:flex; gap:8px;">
                            <select name="image_url_type" class="form-control" style="width: 100px;">
                                <option value="file">Upload</option>
                                <option value="url">URL</option>
                            </select>
                            <input type="text" name="image_url" class="form-control" placeholder="https://...">
                            </div>
                    </div>

                    <div style="display: flex; justify-content: flex-end; margin-top: 16px;">
                        <button type="submit" class="btn btn-primary">Update Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="data-table-wrapper slide-in-up" style="animation-delay:0.3s; opacity:0;">
    <div class="data-table-toolbar">
        <div class="data-table-toolbar-left">
            <h2 style="font-size:16px;font-weight:600;">New Arrival Products</h2>
            <span style="font-size:11px;color:var(--text-muted);">{{ $products->total() }} items</span>
        </div>
        <div class="data-table-toolbar-right">
            <button class="btn btn-primary btn-sm" onclick="openModal('addNewArrivalModal')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Product
            </button>
        </div>
    </div>
    
    @if($products->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:80px;">Order</th>
                <th>Product</th>
                <th>Price</th>
                <th>Sizes</th>
                <th>Colors</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr data-product-id="{{ $product->id }}" id="product-row-{{ $product->id }}">
                <td>
                    <select class="form-control" style="padding:4px 8px; font-size:13px; cursor:pointer;" onchange="updateSortOrder({{ $product->id }}, this.value)">
                        @for($i = 0; $i <= max($totalProducts, 20); $i++)
                            <option value="{{ $i }}" {{ $product->sort_order == $i ? 'selected' : '' }}>{{ $i == 0 ? '-' : $i }}</option>
                        @endfor
                    </select>
                </td>
                <td>
                    <div class="product-cell">
                         @if($product->thumbnail)
                            <img src="{{ $product->thumbnail }}" class="product-thumb">
                        @else
                            <div class="product-thumb" style="display:flex;align-items:center;justify-content:center;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--text-muted)"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            </div>
                        @endif
                        <div class="product-info">
                            <span style="display:block; font-weight:600; font-size:14px;">{{ $product->name }}</span>
                            <span style="font-size:12px;color:var(--text-muted);">{{ $product->category->name ?? '-' }}</span>
                        </div>
                    </div>
                </td>
                <td style="font-weight:500;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    <div style="display:flex;gap:4px;flex-wrap:wrap;">
                        @foreach($product->sizes ?? [] as $size)
                            <span class="status-badge available" style="padding:2px 6px;font-size:10px;">{{ $size }}</span>
                        @endforeach
                    </div>
                </td>
                <td>
                    <div style="display:flex;gap:4px;">
                        @foreach($product->colors ?? [] as $color)
                            <span style="width:14px;height:14px;border-radius:50%;background:{{ $color }};border:1px solid var(--border);display:inline-block;" title="{{ $color }}"></span>
                        @endforeach
                    </div>
                </td>
                <td>
                    @if($product->stock < 10)
                        <span class="badge badge-warning">{{ $product->stock }}</span>
                    @else
                        <span class="badge badge-success">{{ $product->stock }}</span>
                    @endif
                </td>
                <td><span class="status-badge {{ $product->is_active ? 'active' : 'archived' }}"><span class="dot"></span>{{ $product->is_active ? 'Active' : 'Draft' }}</span></td>
                <td>
                    <div class="table-actions">
                        <button class="btn-icon" title="Edit" onclick="openEditProductModal({{ $product->id }})">
                             <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </button>
                        <button class="btn-icon danger" title="Delete" onclick="confirmDelete({{ $product->id }}, '{{ addslashes($product->name) }}')">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            <h3>No New Arrival Products</h3>
            <p>Start by adding your first new arrival product.</p>
            <button class="btn btn-primary" onclick="openModal('addNewArrivalModal')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Product
            </button>
        </div>
    @endif

    @if($products->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }}
            </div>
            <div class="pagination">
                {{ $products->appends(request()->query())->links('vendor.pagination.custom-admin') }}
            </div>
        </div>
    @endif
</div>

<!-- ========== MODALS ========== -->

<!-- Add New Arrival Modal -->
<div id="addNewArrivalModal" class="modal-overlay">
    <div class="modal">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="is_new_arrival" value="1">
            <input type="hidden" name="is_active" value="1">

            <div class="modal-header">
                <h2 class="modal-title">Add New Arrival Product</h2>
                <button type="button" class="modal-close" onclick="closeModal('addNewArrivalModal')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Product Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Essential Oversized Tee" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Price (Rp) *</label>
                        <input type="number" name="price" class="form-control" placeholder="e.g. 450000" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" placeholder="Product description..."></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Product Images (Front & Back)</label>
                    <div class="image-upload-area">
                        <input type="file" name="images[]" multiple style="display:none;" id="addImageInput" onchange="previewNewImages(this, 'addImagePreview')">
                        <label for="addImageInput" style="cursor:pointer;display:block;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <p><span>Click to upload</span> or drag and drop</p>
                        </label>
                    </div>
                    <div class="existing-images-grid" id="addImagePreview"></div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Available Sizes</label>
                        <input type="text" name="sizes" class="form-control" placeholder="S, M, L, XL">
                        <p class="form-hint">Comma-separated values</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Colors</label>
                        <input type="text" name="colors" class="form-control" placeholder="#000000, #FFFFFF">
                        <p class="form-hint">Hex codes, comma-separated</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Stock *</label>
                    <input type="number" name="stock" class="form-control" value="10" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addNewArrivalModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Product Modal -->
<div id="editProductModal" class="modal-overlay">
    <div class="modal">
        <form id="editProductForm" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <input type="hidden" name="is_new_arrival" value="1">

            <div class="modal-header">
                <h2 class="modal-title">Edit Product</h2>
                <button type="button" class="modal-close" onclick="closeModal('editProductModal')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            <div class="modal-body">
                <div id="editLoading" style="text-align:center;padding:40px;display:none;">
                    <p style="color:var(--text-muted);">Loading product data...</p>
                </div>
                <div id="editFormFields">
                    <div class="form-group">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Category *</label>
                            <select name="category_id" id="editCategory" class="form-control" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Price (Rp) *</label>
                            <input type="number" name="price" id="editPrice" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editDescription" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Current Images</label>
                        <div class="existing-images-grid" id="editExistingImages"></div>
                        <div class="image-upload-area" style="margin-top:8px;">
                            <input type="file" name="images[]" multiple style="display:none;" id="editImageInput" onchange="previewNewImages(this, 'editNewImagePreview')">
                            <label for="editImageInput" style="cursor:pointer;display:block;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:32px;height:32px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                <p style="font-size:13px;"><span>Click to add</span> more images</p>
                            </label>
                        </div>
                        <div class="existing-images-grid" id="editNewImagePreview"></div>
                    </div>
                    <div id="editRemoveImagesContainer"></div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Available Sizes</label>
                            <input type="text" name="sizes" id="editSizes" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Colors</label>
                            <input type="text" name="colors" id="editColors" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Stock *</label>
                            <input type="number" name="stock" id="editStock" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sale Price (Rp)</label>
                            <input type="number" name="sale_price" id="editSalePrice" class="form-control">
                        </div>
                    </div>
                    <div style="display:flex;gap:20px;">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="editIsActive" value="1">
                            <label for="editIsActive">Active</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" id="editIsFeatured" value="1">
                            <label for="editIsFeatured">Featured</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editProductModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>



<!-- Delete Confirmation Modal -->
<div id="deleteProductModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h2 class="modal-title">Delete Product</h2>
            <button type="button" class="modal-close" onclick="closeModal('deleteProductModal')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div class="confirm-dialog">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                <h3>Are you sure?</h3>
                <p id="deleteProductMessage">This product will be permanently deleted.</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('deleteProductModal')">Cancel</button>
            <form id="deleteProductForm" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Product</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const BASE_URL = "{{ url('/') }}";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    function openModal(id) {
        document.getElementById(id).classList.add('active');
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }
    
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                ${type === 'success' 
                    ? '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>' 
                    : '<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'}
            </svg>
            ${message}
        `;
        
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }
        
        container.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(50px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Preview new images before upload
    function previewNewImages(input, containerId) {
        const container = document.getElementById(containerId);
        Array.from(input.files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                const item = document.createElement('div');
                item.className = 'img-item';
                item.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="remove-img-btn" onclick="this.parentElement.remove()">×</button>
                `;
                container.appendChild(item);
            };
            reader.readAsDataURL(file);
        });
    }

    // Open Edit Product Modal with AJAX data
    function openEditProductModal(productId) {
        const modal = document.getElementById('editProductModal');
        const form = document.getElementById('editProductForm');
        const loading = document.getElementById('editLoading');
        const fields = document.getElementById('editFormFields');
        
        // Set form action
        form.action = `${BASE_URL}/admin/products/${productId}`;
        
        // Show loading
        loading.style.display = 'block';
        fields.style.display = 'none';
        openModal('editProductModal');
        
        // Fetch product data
        fetch(`${BASE_URL}/admin/products/${productId}/json`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            document.getElementById('editName').value = data.name;
            document.getElementById('editCategory').value = data.category_id;
            document.getElementById('editPrice').value = parseFloat(data.price);
            document.getElementById('editDescription').value = data.description || '';
            document.getElementById('editSizes').value = (data.sizes || []).join(', ');
            document.getElementById('editColors').value = (data.colors || []).join(', ');
            document.getElementById('editStock').value = data.stock;
            document.getElementById('editSalePrice').value = data.sale_price ? parseFloat(data.sale_price) : '';
            document.getElementById('editIsActive').checked = data.is_active;
            document.getElementById('editIsFeatured').checked = data.is_featured;
            
            // Show existing images
            const imagesContainer = document.getElementById('editExistingImages');
            imagesContainer.innerHTML = '';
            const removeContainer = document.getElementById('editRemoveImagesContainer');
            removeContainer.innerHTML = '';
            
            if (data.images && data.images.length > 0) {
                data.images.forEach((imgUrl, i) => {
                    const item = document.createElement('div');
                    item.className = 'img-item';
                    item.id = `edit-img-${i}`;
                    item.innerHTML = `
                        <img src="${imgUrl}" alt="Product image">
                        <button type="button" class="remove-img-btn" onclick="markEditImageForRemoval(${i}, '${imgUrl}')">×</button>
                    `;
                    imagesContainer.appendChild(item);
                });
            }
            
            // Clear new image preview
            document.getElementById('editNewImagePreview').innerHTML = '';
            
            loading.style.display = 'none';
            fields.style.display = 'block';
        })
        .catch(err => {
            loading.innerHTML = '<p style="color:var(--danger);">Failed to load product data. Redirecting to edit page...</p>';
            setTimeout(() => {
                window.location.href = `${BASE_URL}/admin/products/${productId}/edit`;
            }, 1500);
        });
    }

    function markEditImageForRemoval(index, imgUrl) {
        const el = document.getElementById(`edit-img-${index}`);
        if (el) {
            el.style.opacity = '0';
            el.style.transform = 'scale(0.8)';
            el.style.transition = 'all 0.3s ease';
            setTimeout(() => el.remove(), 300);
        }
        
        // Extract path from full URL (remove /storage/ prefix)
        const path = imgUrl.replace(/^.*\/storage\//, '');
        const container = document.getElementById('editRemoveImagesContainer');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'remove_images[]';
        input.value = path;
        container.appendChild(input);
    }

    // Delete Product
    function confirmDelete(productId, productName) {
        document.getElementById('deleteProductMessage').textContent = `Product "${productName}" will be permanently deleted.`;
        document.getElementById('deleteProductForm').action = `${BASE_URL}/admin/products/${productId}`;
        openModal('deleteProductModal');
    }

    // Save Hero Banner (client-side only for now)
    function saveHeroBanner() {
        const season = document.getElementById('heroBannerSeason').value;
        const title = document.getElementById('heroBannerTitle').value;
        
        // Update the preview
        const overlay = document.querySelector('.hero-preview-overlay');
        if (overlay) {
            overlay.querySelector('p').textContent = season;
            overlay.querySelector('h3').textContent = title;
        }
        
        showToast('Hero banner updated!', 'success');
        closeModal('editHeroBannerModal');
    }
    function updateSortOrder(productId, newOrder) {
        fetch(`${BASE_URL}/admin/products/update-sort-order`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                id: productId,
                sort_order: newOrder
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Sort order updated!', 'success');
            } else {
                showToast('Failed to update sort order', 'error');
            }
        })
        .catch(err => {
            showToast('Error updating sort order', 'error');
            console.error(err);
        });
    }

    // Sync Banner Text Color
    const bannerColorPicker = document.getElementById('bannerColorPicker');
    const bannerColorText = document.getElementById('bannerColorText');

    if(bannerColorPicker && bannerColorText) {
        // When color picker changes, update text input + live preview
        bannerColorPicker.addEventListener('input', (e) => {
            bannerColorText.value = e.target.value;
            document.getElementById('bannerPreviewOverlay').style.color = e.target.value;
        });

        // When text input changes (e.g. manual hex entry), update color picker + live preview
        bannerColorText.addEventListener('input', (e) => {
            const val = e.target.value;
            if(/^#[0-9A-F]{6}$/i.test(val)) {
                bannerColorPicker.value = val;
                document.getElementById('bannerPreviewOverlay').style.color = val;
            }
        });
    }

    // Live preview for Banner Title & Subtitle
    const titleInput = document.querySelector('input[name="title"]');
    const subtitleInput = document.querySelector('input[name="subtitle"]');

    if (titleInput) {
        titleInput.addEventListener('input', (e) => {
            const el = document.getElementById('bannerPreviewTitle');
            if (el) el.textContent = e.target.value;
        });
    }
    if (subtitleInput) {
        subtitleInput.addEventListener('input', (e) => {
            const el = document.getElementById('bannerPreviewSubtitle');
            if (el) el.textContent = e.target.value;
        });
    }
</script>
@endsection
