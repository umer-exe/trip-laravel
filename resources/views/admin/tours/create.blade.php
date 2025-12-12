@extends('layouts.admin')

@section('content')
    <section class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Tour</h1>
                <p class="text-gray-600">Add a new tour with complete content, pricing, and imagery.</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @include('admin.tours.partials.form', ['submitLabel' => 'Create Tour'])
                </form>
            </div>
        </div>
    </section>
@endsection



