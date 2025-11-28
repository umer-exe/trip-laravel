{{-- Admin Contact Message Edit --}}
@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Edit Contact Message</h1>
                <p class="mt-1 text-sm text-gray-600">Update message status and details</p>
            </div>

            {{-- Edit Form --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <form action="{{ route('admin.contact-messages.update', $message->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="px-6 py-6 space-y-6">
                        {{-- Contact Information (Read-only) --}}
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Contact Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Name:</span>
                                    <span class="ml-2 text-gray-900 font-medium">{{ $message->name }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Email:</span>
                                    <a href="mailto:{{ $message->email }}" class="ml-2 text-indigo-600 hover:text-indigo-800">
                                        {{ $message->email }}
                                    </a>
                                </div>
                                @if($message->phone)
                                    <div>
                                        <span class="text-gray-500">Phone:</span>
                                        <span class="ml-2 text-gray-900">{{ $message->phone }}</span>
                                    </div>
                                @endif
                                <div>
                                    <span class="text-gray-500">Received:</span>
                                    <span class="ml-2 text-gray-900">{{ $message->created_at->format('M d, Y g:i A') }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" name="status" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                                <option value="new" {{ $message->status === 'new' ? 'selected' : '' }}>New</option>
                                <option value="in_progress" {{ $message->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $message->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Subject (Optional Edit) --}}
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Subject
                            </label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject', $message->subject) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('subject') border-red-500 @enderror">
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Message (Optional Edit) --}}
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message
                            </label>
                            <textarea id="message" name="message" rows="6" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('message') border-red-500 @enderror">{{ old('message', $message->message) }}</textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Form Actions --}}
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
                        <a href="{{ route('admin.contact-messages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                            Cancel
                        </a>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.contact-messages.show', $message->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                View Details
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
