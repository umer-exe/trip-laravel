<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $messages = [
            [
                'name' => 'Ali Hassan',
                'email' => 'ali.hassan@example.com',
                'phone' => '+92-300-1234567',
                'subject' => 'Group Booking Inquiry',
                'message' => 'Hi, I am interested in booking the Hunza Valley tour for a group of 8 people in June. Can you provide a group discount? Also, what is included in the package?',
                'status' => 'new',
            ],
            [
                'name' => 'Emma Thompson',
                'email' => 'emma.t@example.com',
                'phone' => '+44-7700-900123',
                'subject' => 'Tokyo Tour Questions',
                'message' => 'I would like to know if the Tokyo Adventure tour includes vegetarian meal options. Also, is travel insurance included or should I arrange it separately?',
                'status' => 'new',
            ],
            [
                'name' => 'Ahmed Raza',
                'email' => 'ahmed.raza@example.com',
                'phone' => '+92-321-9876543',
                'subject' => 'Custom Tour Request',
                'message' => 'Can you arrange a custom tour combining Hunza and Swat valleys for 10 days? We are a family of 5 and prefer private transportation.',
                'status' => 'read',
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa.anderson@example.com',
                'phone' => '+1-555-0123',
                'subject' => 'Payment Options',
                'message' => 'What payment methods do you accept for international bookings? Do you offer installment plans for the European Highlights tour?',
                'status' => 'replied',
            ],
        ];

        foreach ($messages as $messageData) {
            ContactMessage::create($messageData);
        }

        $this->command->info('✓ Created ' . count($messages) . ' sample contact messages');
    }
}
