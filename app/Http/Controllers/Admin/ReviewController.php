<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of reviews
     */
    public function index()
    {
        $reviews = \App\Models\Review::orderByDesc('created_at')->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new review
     */
    public function create()
    {
        $review = new \App\Models\Review(['rating' => 5, 'is_active' => true]);

        return view('admin.reviews.create', compact('review'));
    }

    /**
     * Store a newly created review in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'image' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        \App\Models\Review::create($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review created successfully.');
    }

    /**
     * Show the form for editing the specified review
     */
    public function edit(string $id)
    {
        $review = \App\Models\Review::findOrFail($id);

        return view('admin.reviews.edit', compact('review'));
    }

    /**
     * Update the specified review in storage
     */
    public function update(Request $request, string $id)
    {
        $review = \App\Models\Review::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
            'image' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $review->update($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified review from storage
     */
    public function destroy(string $id)
    {
        $review = \App\Models\Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
