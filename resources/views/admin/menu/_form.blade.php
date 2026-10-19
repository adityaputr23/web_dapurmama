{{-- Shared form partial used by both create.blade.php and edit.blade.php --}}
@if($errors->any())
    <div class="admin-flash error" style="margin-bottom:1rem;">
        <i class="fa-solid fa-circle-exclamation"></i>
        <ul style="margin:0;padding-left:1.2rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="admin-form-grid">
    <!-- Left Column -->
    <div class="admin-form-col">
        <div class="form-group">
            <label for="name" class="form-label">Nama Menu <span class="required">*</span></label>
            <input type="text" id="name" name="name" class="form-input @error('name') is-invalid @enderror"
                   value="{{ old('name', $menu?->name) }}" placeholder="cth: Opor Ayam Special" required>
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-row-2col">
            <div class="form-group">
                <label for="price" class="form-label">Harga (×1000 IDR) <span class="required">*</span></label>
                <div class="input-prefix-wrapper">
                    <span class="input-prefix">Rp</span>
                    <input type="number" id="price" name="price" step="0.5"
                           class="form-input @error('price') is-invalid @enderror"
                           value="{{ old('price', $menu?->price) }}" placeholder="45" required>
                </div>
                <p class="field-hint">Masukkan kelipatan 0.5 (contoh: 45 = Rp 45.000)</p>
                @error('price') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="rating" class="form-label">Rating (0–5)</label>
                <input type="number" id="rating" name="rating" step="0.1" min="0" max="5"
                       class="form-input @error('rating') is-invalid @enderror"
                       value="{{ old('rating', $menu?->rating) }}" placeholder="4.8">
                @error('rating') <span class="field-error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Deskripsi <span class="required">*</span></label>
            <textarea id="description" name="description" rows="4"
                      class="form-input form-textarea @error('description') is-invalid @enderror"
                      placeholder="Deskripsikan hidangan ini secara menarik..." required>{{ old('description', $menu?->description) }}</textarea>
            @error('description') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="tags" class="form-label">Tags</label>
            <input type="text" id="tags" name="tags" class="form-input"
                   value="{{ old('tags', $menu ? implode(', ', (array)$menu->tags) : '') }}"
                   placeholder="Trending, Halal, Low Carb (pisahkan dengan koma)">
            <p class="field-hint">Pisahkan tags dengan koma.</p>
        </div>
    </div>

    <!-- Right Column -->
    <div class="admin-form-col">
        <div class="form-group">
            <label for="image_path" class="form-label">URL Gambar <span class="required">*</span></label>
            <input type="text" id="image_path" name="image_path"
                   class="form-input @error('image_path') is-invalid @enderror"
                   value="{{ old('image_path', $menu?->image_path) }}"
                   placeholder="https://images.unsplash.com/..." required
                   oninput="updateImagePreview(this.value)">
            @error('image_path') <span class="field-error">{{ $message }}</span> @enderror
        </div>

        <!-- Image Preview -->
        <div class="image-preview-box" id="image-preview-box">
            @if($menu?->image_path)
                <img src="{{ $menu->image_path }}" alt="Preview" id="image-preview-img">
            @else
                <div class="image-preview-placeholder" id="image-preview-placeholder">
                    <i class="fa-solid fa-image"></i>
                    <span>Preview gambar akan muncul di sini</span>
                </div>
                <img src="" alt="Preview" id="image-preview-img" style="display:none">
            @endif
        </div>

        <div class="form-row-2col">
            <div class="form-group">
                <label for="category" class="form-label">Kategori <span class="required">*</span></label>
                <select id="category" name="category" class="form-input form-select @error('category') is-invalid @enderror" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach(['main course','dessert','appetizer','beverages'] as $cat)
                        <option value="{{ $cat }}" {{ old('category', $menu?->category) === $cat ? 'selected' : '' }}>
                            {{ ucfirst($cat) }}
                        </option>
                    @endforeach
                </select>
                @error('category') <span class="field-error">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label for="badge" class="form-label">Badge Label</label>
                <input type="text" id="badge" name="badge" class="form-input"
                       value="{{ old('badge', $menu?->badge) }}" placeholder="cth: New, Hot, Chef's Pick">
            </div>
        </div>

        <div class="form-row-2col">
            <div class="form-group">
                <label for="status" class="form-label">Status <span class="required">*</span></label>
                <select id="status" name="status" class="form-input form-select @error('status') is-invalid @enderror" required>
                    <option value="available" {{ old('status', $menu?->status ?? 'available') === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="sold_out"  {{ old('status', $menu?->status) === 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Featured Menu</label>
                <label class="toggle-switch-label">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1"
                           class="toggle-switch-input"
                           {{ old('is_featured', $menu?->is_featured) ? 'checked' : '' }}>
                    <span class="toggle-switch-track"></span>
                    <span class="toggle-switch-text">Tampilkan sebagai Featured</span>
                </label>
            </div>
        </div>
    </div>
</div>

<script>
function updateImagePreview(url) {
    const img = document.getElementById('image-preview-img');
    const placeholder = document.getElementById('image-preview-placeholder');
    if (url) {
        img.src = url;
        img.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
    } else {
        img.style.display = 'none';
        if (placeholder) placeholder.style.display = 'flex';
    }
}
</script>
