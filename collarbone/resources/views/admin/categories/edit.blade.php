@extends('admin.layout')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('page-subtitle', 'Edit: {{ $category->name }}')

@section('topbar-actions')
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Kembali
    </a>
@endsection

@section('content')
    <div style="max-width: 640px;">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header">
                    <h2>Informasi Kategori</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Nama Kategori *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                        @error('name') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                        @error('description') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Urutan Tampil</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order) }}" min="0">
                        <div class="form-hint">Semakin kecil semakin di depan</div>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        <label for="is_active">Kategori Aktif</label>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-bottom: 24px;">
                <div class="card-header">
                    <h2>Gambar Kategori</h2>
                </div>
                <div class="card-body">
                    @if($category->image_url)
                        <div style="margin-bottom: 16px;">
                            <div class="form-label" style="margin-bottom: 8px;">Gambar Saat Ini</div>
                            <div class="image-preview-item" style="width: 120px;">
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                            </div>
                        </div>
                    @endif

                    <div class="image-upload-area" onclick="document.getElementById('categoryImage').click()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <p>Klik untuk mengganti gambar</p>
                        <p style="font-size:12px;color:var(--text-muted);margin-top:4px">JPG, PNG, WebP (maks 2MB)</p>
                    </div>
                    <input type="file" id="categoryImage" name="image" accept="image/*" style="display:none" onchange="previewCategoryImage(this)">
                    <div id="categoryPreview" style="margin-top: 16px;"></div>
                    @error('image') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Update Kategori
            </button>
        </form>

        <div style="margin-top: 16px;">
            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Yakin ingin menghapus kategori &quot;{{ $category->name }}&quot;? Semua produk dalam kategori ini juga akan terhapus.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: center; padding: 14px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    Hapus Kategori
                </button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
function previewCategoryImage(input) {
    const preview = document.getElementById('categoryPreview');
    preview.innerHTML = '';

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const item = document.createElement('div');
            item.className = 'image-preview-item';
            item.style.width = '120px';
            item.innerHTML = `
                <img src="${e.target.result}" alt="Preview">
                <button type="button" class="remove-btn" onclick="this.parentElement.remove(); document.getElementById('categoryImage').value=''">×</button>
            `;
            preview.appendChild(item);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
