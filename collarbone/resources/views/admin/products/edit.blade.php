@extends('admin.layout')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('page-subtitle', 'Edit: {{ $product->name }}')

@section('topbar-actions')
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali
    </a>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 360px; gap: 24px;">
            <!-- Main Column -->
            <div>
                <div class="card" style="margin-bottom: 24px;">
                    <div class="card-header">
                        <h2>Informasi Produk</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Nama Produk *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                            @error('name') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                            @error('description') <div class="form-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Harga (Rp) *</label>
                                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" min="0" step="1000" required>
                                @error('price') <div class="form-error">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Harga Sale (Rp)</label>
                                <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}" min="0" step="1000">
                                @error('sale_price') <div class="form-error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">SKU</label>
                                <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                                @error('sku') <div class="form-error">{{ $message }}</div> @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Stok *</label>
                                <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" min="0" required>
                                @error('stock') <div class="form-error">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" style="margin-bottom: 24px;">
                    <div class="card-header">
                        <h2>Variasi</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Warna Tersedia</label>
                            <input type="text" name="colors" class="form-control" value="{{ old('colors', is_array($product->colors) ? implode(', ', $product->colors) : '') }}">
                            <div class="form-hint">Pisahkan dengan koma (,)</div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Ukuran Tersedia</label>
                            <input type="text" name="sizes" class="form-control" value="{{ old('sizes', is_array($product->sizes) ? implode(', ', $product->sizes) : '') }}">
                            <div class="form-hint">Pisahkan dengan koma (,)</div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Gambar Produk</h2>
                    </div>
                    <div class="card-body">
                        {{-- Existing Images --}}
                        @if($product->images && count($product->images) > 0)
                            <div class="form-label" style="margin-bottom: 8px;">Gambar Saat Ini</div>
                            <div class="image-preview-grid" style="margin-bottom: 20px;">
                                @foreach($product->images as $img)
                                    <div class="image-preview-item" id="existing-{{ $loop->index }}">
                                        <img src="{{ asset('storage/' . $img) }}" alt="Product image">
                                        <button type="button" class="remove-btn" onclick="markForRemoval('{{ $img }}', 'existing-{{ $loop->index }}')">×</button>
                                        <input type="hidden" name="keep_images[]" value="{{ $img }}" id="keep-{{ $loop->index }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Upload New Images --}}
                        <div class="image-upload-area" onclick="document.getElementById('imageInput').click()">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <p>Klik untuk menambah gambar baru</p>
                            <p style="font-size:12px;color:var(--text-muted);margin-top:4px">JPG, PNG, WebP (maks 2MB per gambar)</p>
                        </div>
                        <input type="file" id="imageInput" name="images[]" multiple accept="image/*" style="display:none" onchange="previewImages(this)">
                        <div class="image-preview-grid" id="imagePreviewGrid"></div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div>
                <div class="card" style="margin-bottom: 24px;">
                    <div class="card-header">
                        <h2>Kategori</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group" style="margin-bottom:0">
                            <label class="form-label">Kategori *</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="form-error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="card" style="margin-bottom: 24px;">
                    <div class="card-header">
                        <h2>Status & Visibilitas</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-check" style="margin-bottom: 16px;">
                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <label for="is_active">Produk Aktif</label>
                        </div>
                        <div class="form-check" style="margin-bottom: 16px;">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label for="is_featured">Featured Product</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_new_arrival" id="is_new_arrival" value="1" {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }}>
                            <label for="is_new_arrival">New Arrival</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Update Produk
                </button>
            </div>
        </div>

        {{-- Hidden inputs for images to remove --}}
        <div id="removeImagesContainer"></div>
    </form>

    {{-- Delete form is OUTSIDE the update form to prevent nested form issues --}}
    <div style="max-width: 360px; margin-left: auto; margin-top: 16px;">
        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: center; padding: 14px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                Hapus Produk
            </button>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    let uploadedFiles = [];

    function previewImages(input) {
        const grid = document.getElementById('imagePreviewGrid');
        const newFiles = Array.from(input.files);
        
        newFiles.forEach(file => {
            // Avoid duplicates
            if(uploadedFiles.some(f => f.name === file.name && f.size === file.size)) return;
            
            // Assign unique ID for removal
            file.uniqueId = Math.random().toString(36).substring(7);
            uploadedFiles.push(file);
            
            const reader = new FileReader();
            reader.onload = (e) => {
                const item = document.createElement('div');
                item.className = 'image-preview-item';
                item.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    <button type="button" class="remove-btn" onclick="removeNewFile('${file.uniqueId}', this)">×</button>
                `;
                grid.appendChild(item);
            };
            reader.readAsDataURL(file);
        });
        
        updateInputFiles(input);
    }

    function removeNewFile(id, btn) {
        uploadedFiles = uploadedFiles.filter(f => f.uniqueId !== id);
        btn.parentElement.remove();
        updateInputFiles(document.getElementById('imageInput'));
    }

    function updateInputFiles(input) {
        const dt = new DataTransfer();
        uploadedFiles.forEach(file => dt.items.add(file));
        input.files = dt.files;
    }

function markForRemoval(imagePath, elementId) {
    const el = document.getElementById(elementId);
    if (el) {
        el.style.opacity = '0';
        el.style.transform = 'scale(0.8)';
        el.style.transition = 'all 0.3s ease';
        setTimeout(() => el.remove(), 300);
    }

    // Add hidden input to mark for removal
    const container = document.getElementById('removeImagesContainer');
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'remove_images[]';
    input.value = imagePath;
    container.appendChild(input);
}
</script>
@endsection
