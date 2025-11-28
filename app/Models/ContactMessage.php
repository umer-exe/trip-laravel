<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
    ];

    /**
     * Get a formatted status label for display
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'new' => 'New',
            'in_progress' => 'In Progress',
            'resolved' => 'Resolved',
            default => ucfirst($this->status),
        };
    }
}
