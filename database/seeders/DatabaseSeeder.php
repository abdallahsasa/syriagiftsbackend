<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\District;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin User ──────────────────────────────────────
        // ── Admin User ──────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@syriagifts.com'],
            [
                'name'              => 'Admin',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // ── Districts ───────────────────────────────────────
        $districts = [
            ['name' => 'Mazzeh', 'express' => true, 'fee' => 5],
            ['name' => 'Malki', 'express' => true, 'fee' => 7],
            ['name' => 'Abu Rummaneh', 'express' => true, 'fee' => 7],
            ['name' => 'Kafr Souseh', 'express' => true, 'fee' => 6],
            ['name' => 'Shaalan', 'express' => true, 'fee' => 5],
            ['name' => 'Dummar', 'express' => false, 'fee' => 10],
            ['name' => 'Baramkeh', 'express' => false, 'fee' => 8],
        ];

        foreach ($districts as $d) {
            District::updateOrCreate(
                ['slug' => Str::slug($d['name'])],
                [
                    'name' => $d['name'],
                    'express_eligible' => $d['express'],
                    'delivery_fee' => $d['fee'],
                ]
            );
        }

        // ── Categories ──────────────────────────────────────
        $categories = [
            ['name' => 'Gift Packages', 'featured' => false, 'image' => null],
            ['name' => 'Flowers', 'featured' => false, 'image' => null],
            ['name' => 'Cakes & Sweets', 'featured' => false, 'image' => null],
            ['name' => 'Chocolates', 'featured' => false, 'image' => null],
            ['name' => 'Jewelry & Accessories', 'featured' => false, 'image' => null],
            ['name' => 'Beauty & Perfumes', 'featured' => false, 'image' => null],
            ['name' => 'Gift Items', 'featured' => false, 'image' => null],
            ['name' => 'Event Decorations', 'featured' => false, 'image' => null],
            ['name' => 'Express Gifts', 'featured' => false, 'image' => null],
            
            // Occasions (Featured)
            ['name' => 'Birthday', 'featured' => true, 'image' => 'https://images.unsplash.com/photo-1513201099705-a9746e1e201f?w=400&h=400&fit=crop'],
            ['name' => 'Anniversary', 'featured' => true, 'image' => 'https://images.unsplash.com/photo-1518199266791-5375a83190b7?w=400&h=400&fit=crop'],
            ['name' => 'Romance', 'featured' => true, 'image' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=400&h=400&fit=crop'],
            ['name' => 'Thank You', 'featured' => true, 'image' => 'https://images.unsplash.com/photo-1515934751635-c81c6bc9a2d8?w=400&h=400&fit=crop'],
            ['name' => 'Get Well', 'featured' => true, 'image' => 'https://images.unsplash.com/photo-1531353826977-0941b4779a1c?w=400&h=400&fit=crop'],
            ['name' => 'New Born', 'featured' => true, 'image' => 'https://images.unsplash.com/photo-1559734840-f9509ee5677f?w=400&h=400&fit=crop'],
            ['name' => 'Congratulations', 'featured' => true, 'image' => 'https://images.unsplash.com/photo-1527529482837-4698179dc6ce?w=400&h=400&fit=crop'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'is_active' => true,
                    'is_featured' => $cat['featured'],
                    'image' => $cat['image'],
                ]
            );
        }

        // ── Vendor ──────────────────────────────────────────
        $vendor = Vendor::updateOrCreate(
            ['slug' => 'damascus-rose-shop'],
            [
                'name'        => 'Damascus Rose Shop',
                'description' => 'Premium flower and gift shop in the heart of Damascus.',
                'address'     => 'Mazzeh, Damascus, Syria',
                'phone'       => '+963 11 9876',
                'email'       => 'vendor@damascusrose.com',
                'user_id'     => 1,
                'is_active'   => true,
            ]
        );

        // ── Products ────────────────────────────────────────
        $flowers = Category::where('slug', 'flowers')->first();
        $cakes = Category::where('slug', 'cakes-sweets')->first();
        $gifts = Category::where('slug', 'gift-packages')->first();
        $chocolates = Category::where('slug', 'chocolates')->first();
        $express = Category::where('slug', 'express-gifts')->first();
        $beauty = Category::where('slug', 'beauty-perfumes')->first();

        $products = [
            ['name' => 'Royal Violet Bloom Bouquet', 'price' => 89, 'category' => $flowers, 'is_express' => true,
             'image' => 'https://images.unsplash.com/photo-1522673607200-164883eecd4c?w=600'],
            ['name' => 'Classic Red Roses (12 Stems)', 'price' => 55, 'category' => $flowers, 'is_express' => true,
             'image' => 'https://images.unsplash.com/photo-1548092372-0d1bd40894a3?w=600'],
            ['name' => 'Pink Peony Elegance', 'price' => 75, 'category' => $flowers, 'is_express' => true,
             'image' => 'https://images.unsplash.com/photo-1490750967868-88aa4f44baee?w=600'],
            ['name' => 'Sunflower Sunshine Bundle', 'price' => 65, 'category' => $flowers, 'is_express' => false,
             'image' => 'https://images.unsplash.com/photo-1551399833-6857c114f5a3?w=600'],
            ['name' => 'White Lily Serenity', 'price' => 70, 'category' => $flowers, 'is_express' => true,
             'image' => 'https://images.unsplash.com/photo-1508610048659-a06b669e3321?w=600'],

            ['name' => 'Decadent Chocolate Fudge Cake', 'price' => 45, 'category' => $cakes, 'is_express' => true,
             'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=600'],
            ['name' => 'Red Velvet Dream Cake', 'price' => 50, 'category' => $cakes, 'is_express' => true,
             'image' => 'https://images.unsplash.com/photo-1616541823729-00fe0aacd32c?w=600'],
            ['name' => 'Strawberry Cheesecake Delight', 'price' => 42, 'category' => $cakes, 'is_express' => false,
             'image' => 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=600'],
            ['name' => 'Tiramisu Layer Cake', 'price' => 55, 'category' => $cakes, 'is_express' => false,
             'image' => 'https://images.unsplash.com/photo-1571115177098-24ec42ed204d?w=600'],

            ['name' => 'Birthday Surprise Gift Box', 'price' => 120, 'category' => $gifts, 'is_express' => false,
             'image' => 'https://images.unsplash.com/photo-1549463010-2ef2c976487a?w=600'],
            ['name' => 'Luxury Perfume & Roses Set', 'price' => 150, 'category' => $gifts, 'is_express' => false,
             'image' => 'https://images.unsplash.com/photo-1583467875263-d50dec37a88c?w=600'],
            ['name' => 'Premium Gift Hamper', 'price' => 180, 'category' => $gifts, 'is_express' => false,
             'image' => 'https://images.unsplash.com/photo-1513151233558-d860c5398176?w=600'],
            ['name' => 'Wellness Spa Box', 'price' => 95, 'category' => $gifts, 'is_express' => true,
             'image' => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=600'],

            ['name' => 'Belgian Chocolate Collection', 'price' => 65, 'category' => $chocolates, 'is_express' => true,
             'image' => 'https://images.unsplash.com/photo-1549007994-cb92caebd54b?w=600'],
            ['name' => 'Luxury Truffle Box', 'price' => 85, 'category' => $chocolates, 'is_express' => true,
             'image' => 'https://images.unsplash.com/photo-1548907040-4baa42d10919?w=600'],
            ['name' => 'Dark Chocolate Assortment', 'price' => 45, 'category' => $chocolates, 'is_express' => false,
             'image' => 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=600'],

            ['name' => 'Express Birthday Bundle', 'price' => 99, 'category' => $express, 'is_express' => true,
             'image' => 'https://images.unsplash.com/photo-1530103862676-fa8c9d34b689?w=600'],
            ['name' => 'Quick Love Package', 'price' => 79, 'category' => $express, 'is_express' => true,
             'image' => 'https://images.unsplash.com/photo-1518199266791-5375a83190b7?w=600'],

            ['name' => 'Rose Gold Perfume Set', 'price' => 110, 'category' => $beauty, 'is_express' => false,
             'image' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?w=600'],
            ['name' => 'Luxury Skincare Gift Set', 'price' => 130, 'category' => $beauty, 'is_express' => false,
             'image' => 'https://images.unsplash.com/photo-1556228578-8c89e6adf883?w=600'],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'name'        => $p['name'],
                    'description' => 'A beautiful gift delivered fresh in Damascus.',
                    'price'       => $p['price'],
                    'image'       => $p['image'],
                    'category_id' => $p['category']->id,
                    'vendor_id'   => $vendor->id,
                    'is_express'  => $p['is_express'],
                    'is_active'   => true,
                ]
            );
        }
    }
}
