<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    /**
     * Display a listing of contact messages
     */
    public function index()
    {
        $messages = \App\Models\ContactMessage::orderByDesc('created_at')->paginate(15);

        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * Display the specified contact message
     */
    public function show(string $id)
    {
        $message = \App\Models\ContactMessage::findOrFail($id);

        return view('admin.contact-messages.show', compact('message'));
    }

    /**
     * Show the form for editing the specified contact message
     */
    public function edit(string $id)
    {
        $message = \App\Models\ContactMessage::findOrFail($id);

        return view('admin.contact-messages.edit', compact('message'));
    }

    /**
     * Update the specified contact message in storage
     */
    public function update(Request $request, string $id)
    {
        $message = \App\Models\ContactMessage::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:new,in_progress,resolved',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string|min:10',
        ]);

        $message->update($validated);

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Contact message updated successfully.');
    }

    /**
     * Remove the specified contact message from storage
     */
    public function destroy(string $id)
    {
        $message = \App\Models\ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Contact message deleted successfully.');
    }
}
