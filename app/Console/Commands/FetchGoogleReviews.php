<?php

namespace App\Console\Commands;

use App\Models\Review;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchGoogleReviews extends Command
{
    protected $signature = 'reviews:fetch';
    protected $description = 'Fetch Google Maps reviews from SerpApi and store them in the database';

    public function handle()
    {
        $apiKey = config('services.serpapi.key');
        if (!$apiKey) {
            $this->error('SerpApi API key not found. Please set SERPAPI_KEY in your .env file.');
            return 1;
        }

        $this->info('Fetching reviews from SerpApi...');

        // PERUBAHAN: Menggunakan 'place_id' yang lebih stabil
        $response = Http::withoutVerifying()->get('https://serpapi.com/search', [
            'engine' => 'google_maps_reviews',
            'place_id' => 'ChIJD5PVYyRF0i0RvwNHzKOrxXs', // Place ID untuk Putra Bali Tour
            'api_key' => $apiKey,
            'hl' => 'id',
            'sort_by' => 'newestFirst'
        ]);

        if ($response->failed()) {
            $this->error('Failed to fetch reviews from SerpApi.');
            $this->line('Response Body: ' . $response->body()); // Tambahan untuk debugging
            return 1;
        }

        $reviews = $response->json()['reviews'] ?? [];

        if (empty($reviews)) {
            $this->warn('No reviews were found in the API response.');
            $this->line('Response Body: ' . $response->body()); // Tambahan untuk debugging
            return 0;
        }

        $newReviewsCount = 0;
        foreach ($reviews as $reviewData) {
            // Menggunakan updateOrCreate untuk mencegah duplikasi
            $review = Review::updateOrCreate(
                ['review_id' => $reviewData['review_id']],
                [
                    'user_name' => $reviewData['user']['name'],
                    'user_thumbnail' => $reviewData['user']['thumbnail'],
                    'rating' => $reviewData['rating'],
                    'snippet' => $reviewData['snippet'] ?? '',
                    'review_date' => isset($reviewData['iso_date']) ? \Carbon\Carbon::parse($reviewData['iso_date']) : \Carbon\Carbon::parse($reviewData['date']),
                ]
            );

            if ($review->wasRecentlyCreated) {
                $newReviewsCount++;
            }
        }

        $this->info("Fetch complete! " . count($reviews) . " reviews processed. {$newReviewsCount} new reviews added.");
        return 0;
    }
}