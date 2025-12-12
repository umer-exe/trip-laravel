<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ContactMessage Model - Customer inquiries and messages
 * 
 * Stores messages submitted through the contact form
 * Admin can view, update status, and respond to messages
 * 
 * Database table: contact_messages
 * 
 * Status values:
 * - 'new': Just submitted, not yet reviewed
 * - 'read': Admin has viewed the message
 * - 'replied': Admin has responded to customer
 */
class ContactMessage extends Model
{
    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'name',      // Customer name
        'email',     // Customer email
        'phone',     // Customer phone (optional)
        'subject',   // Message subject
        'message',   // Message content
        'status',    // Message status: 'new', 'read', 'replied'
    ];

    /**
     * Get a formatted status label for display
     * 
     * Converts database status values to user-friendly labels
     * Used in admin panel for better readability
     * 
     * Usage: $message->status_label
     * 
     * @return string Formatted status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'new' => 'New',
            'in_progress' => 'In Progress',
            'resolved' => 'Resolved',
            default => ucfirst($this->status),  // Capitalize any other status
        };
    }
}
