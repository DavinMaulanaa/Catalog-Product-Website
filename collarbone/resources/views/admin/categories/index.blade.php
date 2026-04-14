@extends('admin.layout')

@section('title', 'Categories')
@section('page-title', 'Categories')
@section('page-subtitle', 'Manage product categories')

@section('topbar-actions')
    <div style="display:flex;align-items:center;gap:12px;">
        <form action="{{ route('admin.categories.index') }}" method="GET" class="search-box" style="width: 260px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="search" placeholder="Search categories..." value="{{ request('search') }}">
        </form>
        <button class="btn btn-primary" onclick="openModal('addCategoryModal')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Category
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
        .stat-card-icon.blue { --stat-color: #3b82f6; background: rgba(59, 130, 246, 0.1); }
        .stat-card-icon.teal { --stat-color: #00d4aa; background: rgba(0, 212, 170, 0.1); }
        .stat-card-icon.yellow { --stat-color: #f59e0b; background: rgba(245, 158, 11, 0.1); }
        .stat-card-icon.green { --stat-color: #10b981; background: rgba(16, 185, 129, 0.1); }
        .stat-card-value { font-size: 28px; font-weight: 800; margin: 12px 0 4px; }
        .stat-card-label { font-size: 13px; color: var(--text-secondary); }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 24px;
        }
        .section-title { font-size: 18px; font-weight: 700; margin-bottom: 4px; }
        .section-subtitle { font-size: 13px; color: var(--text-muted); }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 4px;
            background: var(--bg-input);
            color: var(--text-muted);
        }
        .status-badge .dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .status-badge.active { color: var(--success); background: rgba(16, 185, 129, 0.1); }
        .status-badge.archived { color: var(--text-muted); background: var(--bg-input); }
        
        .data-table-wrapper {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            margin-bottom: 24px;
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

        .card-title { font-size: 16px; font-weight: 600; }

        .category-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

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
            max-width: 500px;
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
    </style>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card slide-in-up stagger-1">
            <div class="stat-card-header">
                <div class="stat-card-icon blue"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2 2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg></div>
            </div>
            <div class="stat-card-value">{{ $totalCategories }}</div>
            <div class="stat-card-label">Total Categories</div>
        </div>
        <div class="stat-card slide-in-up stagger-2">
            <div class="stat-card-header">
                <div class="stat-card-icon teal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46L16 2 12 5.5 8 2 3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg></div>
            </div>
            <div class="stat-card-value">{{ $categories->sum('products_count') }}</div>
            <div class="stat-card-label">Total Products in View</div>
        </div>
        <div class="stat-card slide-in-up stagger-3">
             <div class="stat-card-header">
                <div class="stat-card-icon yellow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 14.14 14.14"/></svg></div>
            </div>
             <div class="stat-card-value">{{ $categories->where('is_active', false)->count() }}</div>
             <div class="stat-card-label">Inactive Categories</div>
        </div>
        <div class="stat-card slide-in-up stagger-4">
            <div class="stat-card-header">
                <div class="stat-card-icon green"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            </div>
            <div class="stat-card-value">{{ $totalProducts }}</div>
            <div class="stat-card-label">Total Products (All)</div>
        </div>
    </div>

    <!-- Hero Banner Management -->
    <div class="card slide-in-up" style="animation-delay:0.25s; opacity:0; margin-bottom:24px;">
        <div class="card-header">
            <h2 style="font-size:16px;font-weight:600;">🖼️ Banner Categories</h2>
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
                    <form action="{{ route('admin.banners.update', 'categories') }}" method="POST" enctype="multipart/form-data">
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
                                    <input type="color" id="bannerColorPicker" class="form-control" value="{{ $banner->text_color ?? '#FFFFFF' }}" style="height: 40px; padding: 2px; width: 60px;">
                                    <input type="text" name="text_color" id="bannerColorText" class="form-control" value="{{ $banner->text_color ?? '#FFFFFF' }}" style="flex: 1;">
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

    <!-- Category Cards -->
    <div class="section-header slide-in-up" style="animation-delay:0.2s;opacity:0;">
        <div>
            <h2 class="section-title">Category Overview</h2>
            <p class="section-subtitle">Manage your product categories</p>
        </div>
        <button class="btn btn-primary btn-sm" onclick="openModal('addCategoryModal')">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Category
        </button>
    </div>

    <div class="category-card-grid slide-in-up" style="animation-delay:0.25s;" id="category-cards-grid">
        @foreach($categories as $category)
        <div class="card" id="category-card-{{ $category->id }}">
            <div class="card-header">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:36px;height:36px; display:flex; align-items:center; justify-content:center; border-radius:8px; background:rgba(0, 212, 170, 0.1); overflow:hidden;">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" style="width:100%; height:100%; object-fit:cover; border-radius:8px;">
                        @else
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;color:var(--accent-teal);"><path d="M20.38 3.46L16 2 12 5.5 8 2 3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>
                        @endif
                    </div>
                    <div>
                        <h3 class="card-title">{{ $category->name }}</h3>
                        <span style="font-size:11px;color:var(--text-muted);">{{ $category->products_count }} products</span>
                    </div>
                </div>
                <div style="display:flex; gap:4px;">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm" onclick="confirmDeleteCategory({{ $category->id }}, '{{ addslashes($category->name) }}', {{ $category->products_count }})">Delete</button>
                </div>
            </div>
            <div class="card-body" style="padding:16px 24px;">
                <p style="font-size:12px;color:var(--text-secondary);line-height:1.6;margin-bottom:12px;">
                    {{ $category->description ?? 'No description.' }}
                </p>
                <div style="display:flex;gap:8px;">
                    <span class="status-badge {{ $category->is_active ? 'active' : 'archived' }}">
                        <span class="dot"></span> {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Product Tables Per Category -->
    @foreach($categories as $category)
    <div class="data-table-wrapper slide-in-up" style="animation-delay:{{ 0.35 + ($loop->index * 0.1) }}s;opacity:0;">
        <div class="data-table-toolbar">
            <div class="data-table-toolbar-left">
                <h2 class="card-title">{{ $category->name }} Products</h2>
                <span style="font-size:11px;color:var(--text-muted);">{{ $category->products_count }} items</span>
            </div>
            <div class="data-table-toolbar-right">
                <button class="btn btn-primary btn-sm" onclick="openAddProductModal({{ $category->id }})">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Product
                </button>
            </div>
        </div>
        @if($category->products->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width:70px;">Order</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($category->products as $product)
                <tr id="cat-product-row-{{ $product->id }}">
                    <td>
                        <select class="form-control" style="padding:2px 6px; font-size:12px; cursor:pointer;" onchange="updateSortOrder({{ $product->id }}, this.value)">
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
                                <span style="font-size:12px;color:var(--text-muted);">SKU: {{ $product->sku ?? '-' }}</span>
                            </div>
                        </div>
                    </td>
                    <td style="font-weight:500;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        @if($product->stock < 10)
                            <span class="badge badge-warning">{{ $product->stock }}</span>
                        @else
                            <span class="badge badge-success">{{ $product->stock }}</span>
                        @endif
                    </td>
                    <td><span class="status-badge {{ $product->is_active ? 'active' : 'archived' }}"><span class="dot"></span>{{ $product->is_active ? 'Active' : 'Draft' }}</span></td>
                    <td>
                        <div class="actions-cell">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn-icon" title="Edit"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></a>
                            <button class="btn-icon" style="color:var(--danger);" title="Delete" onclick="confirmDeleteProduct({{ $product->id }}, '{{ addslashes($product->name) }}')">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state" style="padding:40px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:40px;height:40px;color:var(--text-muted);margin-bottom:12px;"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            <p style="color:var(--text-muted);margin-bottom:16px;">No products in this category.</p>
            <button class="btn btn-primary btn-sm" onclick="openAddProductModal({{ $category->id }})">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Product
            </button>
        </div>
        @endif
    </div>
    @endforeach

    @if($categories->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination-info">
                Showing {{ $categories->firstItem() }} - {{ $categories->lastItem() }} of {{ $categories->total() }}
            </div>
            <div class="pagination">
                {{ $categories->appends(request()->query())->links('vendor.pagination.custom-admin') }}
            </div>
        </div>
    @endif

    <!-- ========== MODALS ========== -->

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="modal-overlay">
        <div class="modal">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title">Add Category</h2>
                    <button type="button" class="modal-close" onclick="closeModal('addCategoryModal')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Category Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Hoodies" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subtitle (e.g. 01. PRODUCT)</label>
                        <input type="text" name="subtitle" class="form-control" placeholder="e.g. 01. PRODUCT">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Describe this category..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Category Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="0" min="0">
                        </div>
                        <div class="form-group" style="display:flex;align-items:flex-end;">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="cat_active" value="1" checked>
                                <label for="cat_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addCategoryModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Add Product Modal -->
    <div id="addProductModal" class="modal-overlay">
        <div class="modal">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title">Add Product to Category</h2>
                    <button type="button" class="modal-close" onclick="closeModal('addProductModal')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="category_id" id="modal_category_id" value="">
                    <input type="hidden" name="is_active" value="1">
                    
                    <div class="form-group">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Oversized Tee" required>
                    </div>
                    <div class="form-row">
                         <div class="form-group">
                            <label class="form-label">Price (Rp) *</label>
                            <input type="number" name="price" class="form-control" placeholder="e.g. 350000" required>
                         </div>
                         <div class="form-group">
                            <label class="form-label">Stock *</label>
                            <input type="number" name="stock" class="form-control" value="0" required>
                         </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Product description..."></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Colors (comma separated)</label>
                            <input type="text" name="colors" class="form-control" placeholder="#000000, #FFFFFF">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sizes (comma separated)</label>
                            <input type="text" name="sizes" class="form-control" placeholder="S, M, L, XL">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Images</label>
                        <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                    </div>
                    <div style="display:flex;gap:20px;">
                        <div class="form-check">
                            <input type="checkbox" name="is_featured" id="prod_featured" value="1">
                            <label for="prod_featured">Featured</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_new_arrival" id="prod_new" value="1">
                            <label for="prod_new">New Arrival</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addProductModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Category Confirmation Modal -->
    <div id="deleteCategoryModal" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Delete Category</h2>
                <button type="button" class="modal-close" onclick="closeModal('deleteCategoryModal')">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="confirm-dialog">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <h3>Delete this category?</h3>
                    <p id="deleteCategoryMessage">This category and all its products will be permanently deleted.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteCategoryModal')">Cancel</button>
                <form id="deleteCategoryForm" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Category</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Product Confirmation Modal -->
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
                    <h3>Delete this product?</h3>
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
    function openModal(id) {
        document.getElementById(id).classList.add('active');
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
    }
    
    function openAddProductModal(categoryId) {
        document.getElementById('modal_category_id').value = categoryId;
        openModal('addProductModal');
    }

    // Delete Category with confirmation
    function confirmDeleteCategory(categoryId, categoryName, productCount) {
        const msg = productCount > 0 
            ? `Category "${categoryName}" and its ${productCount} product(s) will be permanently deleted.`
            : `Category "${categoryName}" will be permanently deleted.`;
        document.getElementById('deleteCategoryMessage').textContent = msg;
        document.getElementById('deleteCategoryForm').action = `${BASE_URL}/admin/categories/${categoryId}`;
        openModal('deleteCategoryModal');
    }

    // Delete Product with confirmation
    function confirmDeleteProduct(productId, productName) {
        document.getElementById('deleteProductMessage').textContent = `Product "${productName}" will be permanently deleted.`;
        document.getElementById('deleteProductForm').action = `${BASE_URL}/admin/products/${productId}`;
        openModal('deleteProductModal');
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
    
    function updateSortOrder(productId, newOrder) {
        // Get CSRF token
        const csrfToken = document.querySelector('input[name="_token"]')?.value || document.head.querySelector('meta[name="csrf-token"]')?.content;

        fetch(`${BASE_URL}/admin/products/update-sort-order`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: productId,
                sort_order: newOrder
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('Product order updated!', 'success');
            } else {
                showToast('Failed to update product order', 'error');
            }
        })
        .catch(err => {
            showToast('Error updating product order', 'error');
            console.error(err);
        });
    }
</script>
@endsection
