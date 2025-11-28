{{-- Admin Contact Message Show --}}
@extends('layouts.admin')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Contact Message Details</h1>
                    <p class="mt-1 text-sm text-gray-600">Message #{{ $message->id }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.contact-messages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                    <a href="{{ route('admin.contact-messages.edit', $message->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                </div>
            </div>

            {{-- Message Card --}}
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">{{ $message->subject }}</h2>
                        @if($message->status === 'new')
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                New
                            </span>
                        @elseif($message->status === 'in_progress')
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                In Progress
                            </span>
                        @else
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                Resolved
                            </span>
                        @endif
                    </div>
                </div>

                <div class="px-6 py-6 space-y-6">
                    {{-- Contact Information --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Name</label>
                            <p class="text-base text-gray-900">{{ $message->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                            <p class="text-base text-gray-900">
                                <a href="mailto:{{ $message->email }}" class="text-indigo-600 hover:text-indigo-800">
                                    {{ $message->email }}
                                </a>
                            </p>
                        </div>
                        @if($message->phone)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Phone</label>
                                <p class="text-base text-gray-900">
                                    <a href="tel:{{ $message->phone }}" class="text-indigo-600 hover:text-indigo-800">
                                        {{ $message->phone }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Received</label>
                            <p class="text-base text-gray-900">{{ $message->created_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>

                    {{-- Message Content --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Message</label>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $message->message }}</p>
                        </div>
                    </div>
                </div>

                {{-- Actions Footer --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between">
                    <form action="{{ route('admin.contact-messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Message
                        </button>
                    </form>
                    <a href="{{ route('admin.contact-messages.edit', $message->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                        Update Status
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
