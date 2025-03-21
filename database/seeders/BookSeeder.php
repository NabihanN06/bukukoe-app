<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define available categories
        $categories = [
            'Fiction',
            'Non-Fiction',
            'Science',
            'Technology',
            'History',
            'Biography',
            'Self-Help',
            'Other'
        ];

        // Create storage directory if it doesn't exist
        $storagePath = storage_path('app/public/book-images');
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true);
        }

        // Ensure placeholder images exist
        $this->copyPlaceholderImages();

        // Get all available book cover images
        $bookCovers = File::files($storagePath);
        $coverFileNames = [];

        foreach ($bookCovers as $cover) {
            $coverFileNames[] = basename($cover);
        }

        // Create 40 books with or without covers
        Book::factory(40)->make()->each(function ($book) use ($coverFileNames, $categories) {
            // Assign a random category
            $book->category = $categories[array_rand($categories)];

            // Assign a random cover if available
            if (!empty($coverFileNames)) {
                $book->image = $coverFileNames[array_rand($coverFileNames)];
            }

            $book->save();
        });
    }

    /**
     * Copy placeholder book covers from resources to storage.
     */
    private function copyPlaceholderImages(): void
    {
        $sourcePath = resource_path('placeholder-covers');
        $destinationPath = storage_path('app/public/book-images');

        // If placeholder covers directory doesn't exist, create it and copy example images
        if (!File::exists($sourcePath)) {
            File::makeDirectory($sourcePath, 0755, true);
            $this->createPlaceholderImages($destinationPath);
        }

        // Copy existing placeholder images to storage
        $placeholderImages = File::files($sourcePath);
        foreach ($placeholderImages as $image) {
            $filename = basename($image);
            File::copy($image, $destinationPath . '/' . $filename);
        }
    }

    /**
     * Create basic placeholder images manually (without GD).
     */
    private function createPlaceholderImages($destinationPath): void
    {
        // Define sample images (Ensure these exist in `resources/placeholder-covers/`)
        $defaultImages = [
            'placeholder1.jpg',
            'placeholder2.jpg',
            'placeholder3.jpg',
            'placeholder4.jpg',
            'placeholder5.jpg'
        ];

        foreach ($defaultImages as $image) {
            $sourceFile = resource_path("placeholder-covers/{$image}");
            if (File::exists($sourceFile)) {
                File::copy($sourceFile, $destinationPath . '/' . $image);
            }
        }
    }
}
