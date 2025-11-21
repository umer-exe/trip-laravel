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

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Thumbnail Image</label>
        <input type="text" name="thumbnail_image" value="{{ old('thumbnail_image', $tour->thumbnail_image) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="images/tours/japan.jpg">
        @error('thumbnail_image')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Banner Image</label>
        <input type="text" name="banner_image" value="{{ old('banner_image', $tour->banner_image) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="images/gallery/japan-1.jpg">
        @error('banner_image')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Gallery Images (one per line)</label>
        <textarea name="gallery_images" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="images/gallery/japan-1.jpg&#10;images/gallery/japan-2.jpg">{{ $galleryValue }}</textarea>
        @error('gallery_images')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Highlights (one per line)</label>
        <textarea name="highlights" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Visit Tokyo Tower&#10;Traditional tea ceremony">{{ $highlightsValue }}</textarea>
        @error('highlights')
            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
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



