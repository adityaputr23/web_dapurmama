<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'name' => 'Signature Nasi Campur',
            'price' => 14.50,
            'description' => 'A balanced platter of turmeric rice, lemongrass chicken, beef rendang, and sambal.',
            'image_path' => 'https://images.unsplash.com/photo-1626132647523-66f5bf380027?auto=format&fit=crop&w=600&q=80',
            'badge' => 'Daily',
            'tags' => ['Non-Spicy'],
            'category' => 'Daily Favorites',
            'rating' => 4.9
        ]);

        Menu::create([
            'name' => 'Garden Harvest Bowl',
            'price' => 12.00,
            'description' => 'Freshly sourced seasonal greens, quinoa base, avocado, chickpeas, and tahini dressing.',
            'image_path' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=600&q=80',
            'badge' => 'Healthy',
            'tags' => ['Vegan'],
            'category' => 'Healthy Bowls',
            'rating' => 4.7
        ]);

        Menu::create([
            'name' => 'Slow-Cooked Rendang',
            'price' => 45.00,
            'description' => 'Tender beef shank braised for 8 hours in aromatic spices and rich coconut milk. Perfect for sharing.',
            'image_path' => 'https://images.unsplash.com/photo-1608897013039-887f21d8c804?auto=format&fit=crop&w=600&q=80',
            'badge' => 'Party',
            'tags' => ['Spicy'],
            'category' => 'Party Platters',
            'rating' => 4.9
        ]);

        Menu::create([
            'name' => 'Artisan Chicken Mee',
            'price' => 11.50,
            'description' => 'Hand-pulled noodles served in a savory clear broth with organic chicken, soft boiled egg, and bok choy.',
            'image_path' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&w=600&q=80',
            'badge' => 'Daily',
            'tags' => ['Non-Spicy'],
            'category' => 'Daily Favorites',
            'rating' => 4.8
        ]);

        Menu::create([
            'name' => 'Citrus Salmon Kale',
            'price' => 16.80,
            'description' => 'Omega-3 rich grilled salmon over a bed of baby kale, orange wedges, and honey mustard dressing.',
            'image_path' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?auto=format&fit=crop&w=600&q=80',
            'badge' => 'Healthy',
            'tags' => ['Gluten-Free'],
            'category' => 'Healthy Bowls',
            'rating' => 4.6
        ]);

        Menu::create([
            'name' => 'Classic Sate Ayam',
            'price' => 13.00,
            'description' => 'Grilled chicken skewers served with savory peanut sauce, lontong, and sweet soy sauce.',
            'image_path' => 'https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?auto=format&fit=crop&w=600&q=80',
            'badge' => 'Daily',
            'tags' => ['Nutty'],
            'category' => 'Daily Favorites',
            'rating' => 4.8
        ]);

        Menu::create([
            'name' => "Bunda's Nasi Goreng",
            'price' => 10.50,
            'description' => 'Signature Indonesian fried rice with shredded chicken, egg, sweet soy sauce, and cucumber pickles.',
            'image_path' => 'https://images.unsplash.com/photo-1603133872878-6966b46880a0?auto=format&fit=crop&w=600&q=80',
            'badge' => 'Daily',
            'tags' => ['Spicy'],
            'category' => 'Daily Favorites',
            'rating' => 4.9
        ]);

        Menu::create([
            'name' => 'Premium Seafood Platter',
            'price' => 49.99,
            'description' => 'A grand selection of grilled prawns, calamari, snapper fish, and green mussels in Padang sauce.',
            'image_path' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?auto=format&fit=crop&w=600&q=80',
            'badge' => 'Party',
            'tags' => ['Spicy'],
            'category' => 'Party Platters',
            'rating' => 4.9
        ]);
    }
}
