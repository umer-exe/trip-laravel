<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviews = [
            [
                'name' => 'Sarah Ahmed',
                'location' => 'Islamabad, Pakistan',
                'rating' => 5,
                'comment' => 'Absolutely breathtaking! The Hunza Valley exceeded all my expectations. Our guide was knowledgeable and the accommodations were comfortable. Highly recommend Atlas Tours!',
                'is_active' => true,
            ],
            [
                'name' => 'John Smith',
                'location' => 'New York, USA',
                'rating' => 5,
                'comment' => 'An incredible journey through Japan! Every detail was perfectly planned. The tea ceremony and Mount Fuji trip were highlights. Thank you Atlas Tours for an unforgettable experience.',
                'is_active' => true,
            ],
            [
                'name' => 'Fatima Khan',
                'location' => 'Karachi, Pakistan',
                'rating' => 4,
                'comment' => 'Great tour with amazing sights! The desert safari was thrilling and Burj Khalifa views were spectacular. Only minor issue was the tight schedule on day 2.',
                'is_active' => true,
            ],
            [
                'name' => 'Michael Chen',
                'location' => 'Singapore',
                'rating' => 5,
                'comment' => 'Best vacation ever! Paris, Rome, and Barcelona were all stunning. The high-speed trains were comfortable and the local guides were excellent. Worth every penny!',
                'is_active' => true,
            ],
            [
                'name' => 'Ayesha Malik',
                'location' => 'Lahore, Pakistan',
                'rating' => 5,
                'comment' => 'Swat is truly the Switzerland of Pakistan! Mahodand Lake was pristine and the local hospitality was heartwarming. Atlas Tours made everything seamless.',
                'is_active' => true,
            ],
            [
                'name' => 'David Wilson',
                'location' => 'London, UK',
                'rating' => 5,
                'comment' => 'Perfect beach getaway! The islands were gorgeous and the Thai food tour was delicious. Our tour coordinator was responsive and helpful throughout.',
                'is_active' => true,
            ],
        ];

        foreach ($reviews as $reviewData) {
            Review::create($reviewData);
        }

        $this->command->info('✓ Created ' . count($reviews) . ' sample reviews');
    }
}
