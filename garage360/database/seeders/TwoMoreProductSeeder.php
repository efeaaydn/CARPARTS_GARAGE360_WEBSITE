<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TwoMoreProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name'              => 'Denso Klima Kompresörü - Toyota Corolla 1.6',
                'brand'             => 'Denso',
                'oem_number'        => '447260-1190',
                'price'             => 3200.00,
                'sale_price'        => 2850.00,
                'stock'             => 5,
                'category_slug'     => 'sogutma-isitma',
                'short_description' => 'Toyota Corolla 1.6 2002-2007 klima kompresörü, orijinal kalite.',
                'is_featured'       => true,
                'vehicle_make'      => 'Toyota',
            ],
            [
                'name'              => 'Bosch Ön Cam Silecek Motoru - Volkswagen Passat',
                'brand'             => 'Bosch',
                'oem_number'        => '0390241520',
                'price'             => 890.00,
                'sale_price'        => null,
                'stock'             => 8,
                'category_slug'     => 'silecek-sistemi',
                'short_description' => 'VW Passat B5/B6 ön cam silecek motoru, komple.',
                'is_featured'       => false,
                'vehicle_make'      => 'Volkswagen',
            ],
        ];

        foreach ($products as $index => $data) {
            $categorySlug = $data['category_slug'];
            unset($data['category_slug']);

            $category = Category::where('slug', $categorySlug)->first()
                ?? Category::whereNull('parent_id')->first();

            $slug = Str::slug($data['name']) . '-bonus-' . ($index + 1);
            $sku  = 'SKU-BN-' . strtoupper(Str::random(5));

            Product::firstOrCreate(
                ['slug' => $slug],
                array_merge($data, [
                    'category_id'  => $category->id,
                    'slug'         => $slug,
                    'sku'          => $sku,
                    'is_active'    => true,
                    'description'  => $data['short_description'],
                    'currency'     => 'TRY',
                    'condition'    => 'Sıfır',
                ])
            );
        }
    }
}
