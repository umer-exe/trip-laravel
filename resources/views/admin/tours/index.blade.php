@extends('layouts.admin')

@section('content')
    <section class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Manage Tours</h1>
                    <p class="text-gray-600 mt-1">Create, update, and feature tours for Atlas Tours.</p>
                </div>
                <a href="{{ route('admin.tours.create') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-indigo-600 text-white font-semibold shadow hover:bg-indigo-700 transition">
                    + New Tour
                </a>
            </div>

            @if(session('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Thumbnail</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tours as $tour)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3">
                                    @php
                                        $thumb = $tour->thumbnail_image ? asset($tour->thumbnail_image) : 'https://placehold.co/80x64?text=Tour';
                                    @endphp
                                    <div class="w-16 h-12 rounded-md overflow-hidden bg-gray-100">
                                        <img src="{{ $thumb }}" alt="{{ $tour->title }} thumbnail" class="w-full h-full object-cover">
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-semibold text-gray-900">{{ $tour->title }}</div>
                                    <div class="text-xs text-gray-500">{{ $tour->slug }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $tour->type === 'international' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($tour->type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    ${{ number_format((float) $tour->price, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $tour->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-200 text-gray-700' }}">
                                        {{ ucfirst($tour->status) }}
                                    </span>
                                    @if($tour->is_featured)
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-yellow-100 text-yellow-700">
                                            Featured
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.tours.edit', $tour) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('admin.tours.destroy', $tour) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Delete this tour?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                    No tours found. Use the "New Tour" button to add your first tour.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $tours->links() }}
            </div>
        </div>
    </section>
@endsection



