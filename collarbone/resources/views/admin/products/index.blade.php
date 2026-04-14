@extends('admin.layout')

@section('title', 'All Products')
@section('page-title', 'All Products')
@section('page-subtitle', 'Manage your product catalog')

@section('topbar-actions')
    <div style="display:flex;align-items:center;gap:12px;">
        <form action="{{ route('admin.products.index') }}" method="GET" class="search-box" style="width:260px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}">
        </form>
        <select onchange="if(this.value) window.location.href=this.value" class="form-control" style="width:160px;padding:8px 12px;font-size:13px;">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ route('admin.products.index', ['category' => $cat->id, 'search' => request('search')]) }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Product
        </a>
    </div>
@endsection

@section('content')
<style>
    @keyframes slideInUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .slide-in-up {
        animation: slideInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
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

    .table-actions { display: flex; gap: 4px; }
    .table-actions .btn-icon { width: 32px; height: 32px; }
    .table-actions .btn-icon.danger { color: var(--danger); }
    .table-actions .btn-icon.danger:hover { background: rgba(239, 68, 68, 0.1); }
    .table-actions .btn-icon.star { color: var(--text-muted); }
    .table-actions .btn-icon.star.featured-active { color: #EAB308; }
    .table-actions .btn-icon.star:hover { background: rgba(234, 179, 8, 0.1); color: #EAB308; }

    /* Modal Styles */
    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(4px);
        z-index: 1000; display: none;
        align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.3s ease;
    }
    .modal-overlay.active { display: flex; opacity: 1; }
    .modal {
        background: var(--bg-card); border: 1px solid var(--border);
        border-radius: var(--radius); width: 100%;
        max-width: 560px; box-shadow: var(--shadow-lg);
        transform: scale(0.95);
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .modal-overlay.active .modal { transform: scale(1); }
    .modal-header {
        padding: 20px 24px; border-bottom: 1px solid var(--border);
        display: flex; justify-content: space-between; align-items: center;
    }
    .modal-title { font-size: 18px; font-weight: 700; }
    .modal-close { background: none; border: none; color: var(--text-muted); cursor: pointer; }
    .modal-close:hover { color: var(--text-primary); }
    .modal-close svg { width: 20px; height: 20px; }
    .modal-body { padding: 24px; max-height: 70vh; overflow-y: auto; }
    .modal-footer {
        padding: 20px 24px; border-top: 1px solid var(--border);
        display: flex; justify-content: flex-end; gap: 12px;
    }

    .confirm-dialog { text-align: center; padding: 20px 0; }
    .confirm-dialog svg { width: 48px; height: 48px; color: var(--warning); margin-bottom: 16px; }
    .confirm-dialog h3 { font-size: 18px; margin-bottom: 8px; }
    .confirm-dialog p { color: var(--text-muted); font-size: 14px; }

    .existing-images-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 8px; margin-bottom: 12px;
    }
    .existing-images-grid .img-item {
        position: relative; aspect-ratio: 1; border-radius: 6px;
        overflow: hidden; border: 1px solid var(--border);
    }
    .existing-images-grid .img-item img { width: 100%; height: 100%; object-fit: cover; }
    .existing-images-grid .img-item .remove-img-btn {
        position: absolute; top: 2px; right: 2px;
        width: 20px; height: 20px; border-radius: 50%;
        background: rgba(239, 68, 68, 0.9); color: white;
        border: none; cursor: pointer;
        display: flex; align-items: center; justify-content: center; font-size: 12px;
    }
</style>

<!-- Products Table -->
<div class="data-table-wrapper slide-in-up">
    <div class="data-table-toolbar">
        <div class="data-table-toolbar-left">
            <h2 style="font-size:16px;font-weight:600;">Products</h2>
            <span style="font-size:11px;color:var(--text-muted);">{{ $products->total() }} items</span>
        </div>
    </div>

    @if($products->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr id="product-row-{{ $product->id }}">
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
                            @if($product->sku)<span style="font-size:12px;color:var(--text-muted);">SKU: {{ $product->sku }}</span>@endif
                        </div>
                    </div>
                </td>
                <td><span class="badge badge-info">{{ $product->category->name ?? '-' }}</span></td>
                <td style="font-weight:500;">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    @if($product->stock < 10)
                        <span class="badge badge-warning">{{ $product->stock }}</span>
                    @else
                        <span class="badge badge-success">{{ $product->stock }}</span>
                    @endif
                </td>
                <td>
                    <span class="status-badge {{ $product->is_active ? 'active' : 'archived' }}">
                        <span class="dot"></span>{{ $product->is_active ? 'Active' : 'Draft' }}
                    </span>
                </td>
                <td>
                    <div class="table-actions">
                        <button class="btn-icon star {{ $product->is_featured ? 'featured-active' : '' }}" title="{{ $product->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}" onclick="toggleFeatured({{ $product->id }}, this)">
                            <svg viewBox="0 0 24 24" fill="{{ $product->is_featured ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        </button>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-icon" title="Edit">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </a>
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
            <h3>No Products Found</h3>
            <p>Start by adding your first product.</p>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Product
            </a>
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

    // Delete Product
    function confirmDelete(productId, productName) {
        document.getElementById('deleteProductMessage').textContent = `Product "${productName}" will be permanently deleted.`;
        document.getElementById('deleteProductForm').action = `${BASE_URL}/admin/products/${productId}`;
        openModal('deleteProductModal');
    }

    // Toggle Featured
    function toggleFeatured(productId, btn) {
        const isFeatured = btn.classList.contains('featured-active');
        const newState = !isFeatured;
        
        // Optimistic UI updates
        btn.classList.toggle('featured-active');
        btn.querySelector('svg').setAttribute('fill', newState ? 'currentColor' : 'none');
        btn.setAttribute('title', newState ? 'Remove from Featured' : 'Mark as Featured');

        fetch(`${BASE_URL}/admin/products/${productId}/toggle-featured`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ is_featured: newState })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                showToast(newState ? 'Product added to featured' : 'Product removed from featured', 'success');
            } else {
                // Revert
                btn.classList.toggle('featured-active');
                btn.querySelector('svg').setAttribute('fill', isFeatured ? 'currentColor' : 'none');
                btn.setAttribute('title', isFeatured ? 'Remove from Featured' : 'Mark as Featured');
                showToast(data.message || 'Failed to update featured status', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            // Revert
            btn.classList.toggle('featured-active');
            btn.querySelector('svg').setAttribute('fill', isFeatured ? 'currentColor' : 'none');
            btn.setAttribute('title', isFeatured ? 'Remove from Featured' : 'Mark as Featured');
            showToast('Error updating featured status', 'error');
        });
    }
</script>
@endsection
