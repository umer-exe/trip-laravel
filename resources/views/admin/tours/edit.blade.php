@extends('layouts.admin')

@section('content')
    <section class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Tour</h1>
                <p class="text-gray-600">Update tour content, pricing, availability, and media.</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <form action="{{ route('admin.tours.update', $tour) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    @include('admin.tours.partials.form', ['submitLabel' => 'Update Tour'])
                </form>
            </div>
        </div>
    </section>
@endsection



