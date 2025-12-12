@php
    $highlightsOld = old('highlights');
    $highlightsValue = is_array($highlightsOld)
        ? implode("\n", array_filter($highlightsOld))
        : ($highlightsOld ?? implode("\n", $tour->highlights ?? []));

    $galleryOld = old('gallery_images');
    $galleryValue = is_array($galleryOld)
        ? implode("\n", array_filter($galleryOld))
        : ($galleryOld ?? implode("\n", $tour->gallery_images ?? []));

    $availableDatesOld = old('available_dates');
    if (is_array($availableDatesOld)) {
        $availableDatesValue = collect($availableDatesOld)
            ->map(fn ($label, $date) => "{$date} = {$label}")
            ->implode("\n");
    } elseif (is_string($availableDatesOld)) {
        $availableDatesValue = $availableDatesOld;
    } else {
        $availableDatesValue = collect($tour->available_dates ?? [])
            ->map(fn ($label, $date) => "{$date} = {$label}")
            ->implode("\n");
    }

    $itineraryOld = old('itinerary');
    if (is_array($itineraryOld)) {
        $itineraryValue = collect($itineraryOld)
            ->map(fn ($item) => implode(' | ', [
                $item['day'] ?? '',
                $item['title'] ?? '',
                $item['description'] ?? '',
            ]))
            ->implode("\n");
    } elseif (is_string($itineraryOld)) {
        $itineraryValue = $itineraryOld;
    } else {
        $itineraryValue = collect($tour->itinerary ?? [])
            ->map(fn ($item) => implode(' | ', [
                $item['day'] ?? '',
                $item['title'] ?? '',
                $item['description'] ?? '',
            ]))
            ->implode("\n");
    }
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
        <input type="text" name="title" value="{{ old('title', $tour->title) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        @error('title')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Slug *</label>
        <input type="text" name="slug" value="{{ old('slug', $tour->slug) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        <p class="text-xs text-gray-500 mt-1">Auto-generated from title if left unchanged.</p>
        @error('slug')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
        <input type="text" name="location" value="{{ old('location', $tour->location) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        @error('location')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Duration *</label>
        <input type="text" name="duration" value="{{ old('duration', $tour->duration) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        @error('duration')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Price (USD) *</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $tour->price) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>
        @error('price')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
        <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            <option value="domestic" {{ old('type', $tour->type) === 'domestic' ? 'selected' : '' }}>Domestic</option>
            <option value="international" {{ old('type', $tour->type) === 'international' ? 'selected' : '' }}>International</option>
        </select>
        @error('type')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            <option value="active" {{ old('status', $tour->status) === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $tour->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>
</div>

<div class="mt-4 flex items-center space-x-3">
    <label class="inline-flex items-center text-sm text-gray-700">
        <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('is_featured', $tour->is_featured) ? 'checked' : '' }}>
        <span class="ml-2">Feature on home page</span>
    </label>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-1">Overview *</label>
    <textarea name="overview" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" required>{{ old('overview', $tour->overview) }}</textarea>
    @error('overview')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- Thumbnail Image Upload with Preview --}}
<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">Thumbnail Image Upload</label>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <input type="file" 
                   id="thumbnail_image" 
                   name="thumbnail_image" 
                   accept="image/jpeg,image/png,image/jpg,image/webp"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            <p class="text-xs text-gray-500 mt-1">Accepted: JPEG, PNG, JPG, WEBP (Max: 1MB)</p>
            @error('thumbnail_image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
            <div id="thumbnail-preview-container" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center bg-gray-50">
                @if(isset($tour->thumbnail_image) && $tour->thumbnail_image)
                    <img id="thumbnail-preview" 
                         src="{{ asset('storage/' . $tour->thumbnail_image) }}" 
                         alt="Current thumbnail" 
                         class="max-h-48 mx-auto rounded">
                    <p class="text-xs text-gray-500 mt-2">Current image - select new file to replace</p>
                @else
                    <img id="thumbnail-preview" 
                         src="" 
                         alt="Preview" 
                         class="max-h-48 mx-auto rounded hidden">
                    <p id="thumbnail-placeholder" class="text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Preview will appear here
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Banner Image Upload with Preview --}}
<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image Upload</label>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <input type="file" 
                   id="banner_image" 
                   name="banner_image" 
                   accept="image/jpeg,image/png,image/jpg,image/webp"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            <p class="text-xs text-gray-500 mt-1">Accepted: JPEG, PNG, JPG, WEBP (Max: 1MB)</p>
            @error('banner_image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
            <div id="banner-preview-container" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center bg-gray-50">
                @if(isset($tour->banner_image) && $tour->banner_image)
                    <img id="banner-preview" 
                         src="{{ asset('storage/' . $tour->banner_image) }}" 
                         alt="Current banner" 
                         class="max-h-48 mx-auto rounded">
                    <p class="text-xs text-gray-500 mt-2">Current image - select new file to replace</p>
                @else
                    <img id="banner-preview" 
                         src="" 
                         alt="Preview" 
                         class="max-h-48 mx-auto rounded hidden">
                    <p id="banner-placeholder" class="text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Preview will appear here
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Featured Image Upload with Preview --}}
<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image Upload</label>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <input type="file" 
                   id="featured_image" 
                   name="featured_image" 
                   accept="image/jpeg,image/png,image/jpg,image/webp"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            <p class="text-xs text-gray-500 mt-1">Accepted: JPEG, PNG, JPG, WEBP (Max: 1MB)</p>
            @error('featured_image')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Image Preview</label>
            <div id="image-preview-container" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center bg-gray-50">
                @if(isset($tour->featured_image) && $tour->featured_image)
                    <img id="image-preview" 
                         src="{{ asset('storage/' . $tour->featured_image) }}" 
                         alt="Current featured image" 
                         class="max-h-48 mx-auto rounded">
                    <p class="text-xs text-gray-500 mt-2">Current image - select new file to replace</p>
                @else
                    <img id="image-preview" 
                         src="" 
                         alt="Preview" 
                         class="max-h-48 mx-auto rounded hidden">
                    <p id="preview-placeholder" class="text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Preview will appear here
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- JavaScript for Image Preview --}}
<script>
    // Helper function for image preview with validation
    function setupImagePreview(inputId, previewId, placeholderId, maxSizeMB = 1) {
        const input = document.getElementById(inputId);
        if (!input) return;
        
        input.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById(previewId);
            const placeholder = placeholderId ? document.getElementById(placeholderId) : null;
            
            if (file) {
                // Validate file size
                if (file.size > maxSizeMB * 1024 * 1024) {
                    alert(`File size must be less than ${maxSizeMB}MB`);
                    event.target.value = '';
                    return;
                }
                
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, JPG, or WEBP)');
                    event.target.value = '';
                    return;
                }
                
                // Read and display image using FileReader
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) {
                        placeholder.classList.add('hidden');
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    // Setup preview for all image inputs
    setupImagePreview('thumbnail_image', 'thumbnail-preview', 'thumbnail-placeholder', 1);
    setupImagePreview('banner_image', 'banner-preview', 'banner-placeholder', 1);
    setupImagePreview('featured_image', 'image-preview', 'preview-placeholder', 1);
    
    // Gallery images preview (multiple files, max 4)
    document.getElementById('gallery_images')?.addEventListener('change', function(event) {
        const files = event.target.files;
        const container = document.getElementById('gallery-previews');
        const placeholder = document.getElementById('gallery-placeholder');
        
        // Validate maximum 4 files
        if (files.length > 4) {
            alert('You can only upload a maximum of 4 gallery images');
            event.target.value = '';
            return;
        }
        
        if (files.length > 0) {
            container.innerHTML = ''; // Clear previous previews
            if (placeholder) placeholder.classList.add('hidden');
            
            let hasError = false;
            
            Array.from(files).forEach((file, index) => {
                // Validate file size (1MB)
                if (file.size > 1024 * 1024) {
                    alert(`Image ${index + 1} exceeds 1MB size limit`);
                    event.target.value = '';
                    container.innerHTML = '';
                    if (placeholder) placeholder.classList.remove('hidden');
                    hasError = true;
                    return;
                }
                
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert(`Image ${index + 1} is not a valid image file`);
                    event.target.value = '';
                    container.innerHTML = '';
                    if (placeholder) placeholder.classList.remove('hidden');
                    hasError = true;
                    return;
                }
                
                if (!hasError) {
                    // Read and display image
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgWrapper = document.createElement('div');
                        imgWrapper.className = 'relative';
                        imgWrapper.innerHTML = `
                            <img src="${e.target.result}" alt="Gallery ${index + 1}" class="w-full h-32 object-cover rounded">
                            <span class="absolute top-1 right-1 bg-indigo-600 text-white text-xs px-2 py-1 rounded">${index + 1}</span>
                        `;
                        container.appendChild(imgWrapper);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>

{{-- Gallery Images Upload with Preview --}}
<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-2">Gallery Images Upload (Max 4 images)</label>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <input type="file" 
                   id="gallery_images" 
                   name="gallery_images[]" 
                   accept="image/jpeg,image/png,image/jpg,image/webp"
                   multiple
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            <p class="text-xs text-gray-500 mt-1">Accepted: JPEG, PNG, JPG, WEBP (Max: 1MB each, up to 4 images)</p>
            @error('gallery_images')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
            @error('gallery_images.*')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Previews</label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50 max-h-64 overflow-y-auto">
                @if(isset($tour->gallery_images) && is_array($tour->gallery_images) && count($tour->gallery_images) > 0)
                    <div id="gallery-previews" class="grid grid-cols-2 gap-2">
                        @foreach($tour->gallery_images as $index => $image)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="Gallery {{ $index + 1 }}" 
                                     class="w-full h-32 object-cover rounded">
                                <span class="absolute top-1 right-1 bg-indigo-600 text-white text-xs px-2 py-1 rounded">{{ $index + 1 }}</span>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-center">Current images - select new files to replace all</p>
                @else
                    <div id="gallery-previews" class="grid grid-cols-2 gap-2"></div>
                    <p id="gallery-placeholder" class="text-gray-400 text-center">
                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Gallery previews will appear here
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-1">Highlights (one per line)</label>
    <textarea name="highlights" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Visit Tokyo Tower&#10;Traditional tea ceremony">{{ $highlightsValue }}</textarea>
    @error('highlights')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-1">Available Dates (format: YYYY-MM-DD = Label)</label>
    <textarea name="available_dates" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="2024-03-15 = March 15, 2024&#10;2024-04-10 = April 10, 2024">{{ $availableDatesValue }}</textarea>
    @error('available_dates')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mt-6">
    <label class="block text-sm font-medium text-gray-700 mb-1">Itinerary (format: Day | Title | Description)</label>
    <textarea name="itinerary" rows="5" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="1 | Arrival in Tokyo | Transfer to hotel, welcome dinner">{{ $itineraryValue }}</textarea>
    @error('itinerary')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mt-8">
    <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition">
        {{ $submitLabel ?? 'Save Tour' }}
    </button>
    <a href="{{ route('admin.tours.index') }}" class="inline-flex items-center px-6 py-3 ml-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
        Cancel
    </a>
</div>



