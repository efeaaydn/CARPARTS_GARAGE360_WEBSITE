<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ExtraProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name'              => 'Bosch Ateşleme Bobini - Volkswagen Polo',
                'brand'             => 'Bosch',
                'oem_number'        => '0221504464',
                'price'             => 380.00,
                'sale_price'        => 320.00,
                'stock'             => 25,
                'category_slug'     => 'atesleme-yakit',
                'short_description' => 'VW Polo 1.4 benzinli ateşleme bobini.',
                'is_featured'       => true,
                'vehicle_make'      => 'Volkswagen',
            ],
            [
                'name'              => 'Febi Bilstein Rot Başı - Opel Corsa',
                'brand'             => 'Febi',
                'oem_number'        => '41857',
                'price'             => 210.00,
                'sale_price'        => null,
                'stock'             => 30,
                'category_slug'     => 'direksiyon-kutusu-pompasi',
                'short_description' => 'Opel Corsa C/D dış rot başı, sağ veya sol.',
                'is_featured'       => false,
                'vehicle_make'      => 'Opel',
            ],
            [
                'name'              => 'Continental Triger Kayışı - Ford Fiesta 1.4 TDCi',
                'brand'             => 'Continental',
                'oem_number'        => 'CT1162',
                'price'             => 290.00,
                'sale_price'        => 249.00,
                'stock'             => 18,
                'category_slug'     => 'triger-kayis-sistemleri',
                'short_description' => 'Ford Fiesta 1.4 TDCi dizel triger kayışı.',
                'is_featured'       => false,
                'vehicle_make'      => 'Ford',
            ],
            [
                'name'              => 'Mahle Motor Soğutma Termostatı - BMW 5 Serisi',
                'brand'             => 'Mahle',
                'oem_number'        => 'TO 14 87',
                'price'             => 450.00,
                'sale_price'        => null,
                'stock'             => 12,
                'category_slug'     => 'sogutma-isitma',
                'short_description' => 'BMW E39/E60 520i/525i termostat ve conta seti.',
                'is_featured'       => true,
                'vehicle_make'      => 'BMW',
            ],
            [
                'name'              => 'ATE Arka Fren Disk Seti - Volkswagen Golf VII',
                'brand'             => 'ATE',
                'oem_number'        => '24.0110-0233.1',
                'price'             => 890.00,
                'sale_price'        => 790.00,
                'stock'             => 8,
                'category_slug'     => 'fren-balatasi-disk',
                'short_description' => 'VW Golf VII 1.4/1.6/2.0 arka fren disk çifti.',
                'is_featured'       => true,
                'vehicle_make'      => 'Volkswagen',
            ],
            [
                'name'              => 'Philips H4 Crystal Vision Ampul (2\'li)',
                'brand'             => 'Philips',
                'oem_number'        => '12342CVB2',
                'price'             => 175.00,
                'sale_price'        => null,
                'stock'             => 60,
                'category_slug'     => 'far-sinyal-grubu',
                'short_description' => 'H4 12V 60/55W beyaz ışık ampul seti, 2 adet.',
                'is_featured'       => false,
                'vehicle_make'      => null,
            ],
            [
                'name'              => 'Sachs Ön Amortisör - Renault Megane II',
                'brand'             => 'Sachs',
                'oem_number'        => '313 593',
                'price'             => 720.00,
                'sale_price'        => 640.00,
                'stock'             => 10,
                'category_slug'     => 'amortisor-viraj-demiri',
                'short_description' => 'Renault Megane II 2002-2008 ön amortisör, tek adet.',
                'is_featured'       => true,
                'vehicle_make'      => 'Renault',
            ],
        ];

        foreach ($products as $index => $data) {
            $categorySlug = $data['category_slug'];
            unset($data['category_slug']);

            $category = Category::where('slug', $categorySlug)->first()
                ?? Category::whereNull('parent_id')->first();

            $slug = Str::slug($data['name']) . '-extra-' . ($index + 1);
            $sku  = 'SKU-EX-' . strtoupper(Str::random(5));

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
