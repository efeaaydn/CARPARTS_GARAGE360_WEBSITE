<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Motor & Mekanik — Filtreler
            [
                'name'              => 'Bosch Yağ Filtresi - VW Golf/Passat',
                'brand'             => 'Bosch',
                'oem_number'        => 'F026407016',
                'price'             => 89.90,
                'sale_price'        => 74.90,
                'stock'             => 50,
                'category_slug'     => 'filtreler-yag-hava-polen',
                'short_description' => 'VW Golf IV, V, Passat B5, B6 uyumlu Bosch yağ filtresi.',
                'is_featured'       => true,
                'vehicle_make'      => 'Volkswagen',
            ],
            [
                'name'              => 'Mann Hava Filtresi - Toyota Corolla',
                'brand'             => 'Mann-Filter',
                'oem_number'        => 'C25114/1',
                'price'             => 129.00,
                'sale_price'        => null,
                'stock'             => 35,
                'category_slug'     => 'filtreler-yag-hava-polen',
                'short_description' => 'Toyota Corolla 1.6 2002-2007 uyumlu hava filtresi.',
                'is_featured'       => true,
                'vehicle_make'      => 'Toyota',
            ],
            [
                'name'              => 'Mahle Polen Filtresi - BMW 3 Serisi',
                'brand'             => 'Mahle',
                'oem_number'        => 'LAK 557',
                'price'             => 179.90,
                'sale_price'        => null,
                'stock'             => 40,
                'category_slug'     => 'filtreler-yag-hava-polen',
                'short_description' => 'BMW E46, E90 uyumlu aktif karbonlu polen filtresi.',
                'is_featured'       => false,
                'vehicle_make'      => 'BMW',
            ],
            // Triger & Kayış
            [
                'name'              => 'Gates Triger Seti - Renault Clio / Megane',
                'brand'             => 'Gates',
                'oem_number'        => 'K015619XS',
                'price'             => 849.00,
                'sale_price'        => 749.00,
                'stock'             => 20,
                'category_slug'     => 'triger-kayis-sistemleri',
                'short_description' => 'Renault 1.5 dCi K9K motor triger seti (kayış + rölanti).',
                'is_featured'       => true,
                'vehicle_make'      => 'Renault',
            ],
            // Soğutma
            [
                'name'              => 'Valeo Su Pompası - Ford Focus 1.6',
                'brand'             => 'Valeo',
                'oem_number'        => '506910',
                'price'             => 420.00,
                'sale_price'        => null,
                'stock'             => 15,
                'category_slug'     => 'sogutma-isitma',
                'short_description' => 'Ford Focus II 1.6 TDCi uyumlu su pompası.',
                'is_featured'       => false,
                'vehicle_make'      => 'Ford',
            ],
            // Ateşleme & Yakıt
            [
                'name'              => 'NGK Buji Seti (4\'lü) - Honda Civic',
                'brand'             => 'NGK',
                'oem_number'        => 'IZFR6K11',
                'price'             => 320.00,
                'sale_price'        => 280.00,
                'stock'             => 60,
                'category_slug'     => 'atesleme-yakit',
                'short_description' => 'Honda Civic 1.6 iridyum buji seti, 4 adet.',
                'is_featured'       => true,
                'vehicle_make'      => 'Honda',
            ],
            // Fren Balatası & Disk
            [
                'name'              => 'Brembo Ön Fren Disk Seti - Mercedes C Serisi',
                'brand'             => 'Brembo',
                'oem_number'        => '09.A940.11',
                'price'             => 1250.00,
                'sale_price'        => 1099.00,
                'stock'             => 12,
                'category_slug'     => 'fren-balatasi-disk',
                'short_description' => 'Mercedes W204 C180/C200 ön disk ve balata seti.',
                'is_featured'       => true,
                'vehicle_make'      => 'Mercedes-Benz',
            ],
            [
                'name'              => 'Textar Arka Fren Balatası - Audi A4',
                'brand'             => 'Textar',
                'oem_number'        => '2355601',
                'price'             => 380.00,
                'sale_price'        => null,
                'stock'             => 28,
                'category_slug'     => 'fren-balatasi-disk',
                'short_description' => 'Audi A4 B7/B8 arka fren balatası seti.',
                'is_featured'       => false,
                'vehicle_make'      => 'Audi',
            ],
            // Amortisör
            [
                'name'              => 'Monroe Amortisör Seti (2\'li) - Opel Astra',
                'brand'             => 'Monroe',
                'oem_number'        => 'R14012',
                'price'             => 950.00,
                'sale_price'        => 850.00,
                'stock'             => 10,
                'category_slug'     => 'amortisor-viraj-demiri',
                'short_description' => 'Opel Astra H ön amortisör çifti.',
                'is_featured'       => true,
                'vehicle_make'      => 'Opel',
            ],
            // Akü & Marş
            [
                'name'              => 'Varta Blue Dynamic 60Ah Akü',
                'brand'             => 'Varta',
                'oem_number'        => 'D47',
                'price'             => 1890.00,
                'sale_price'        => null,
                'stock'             => 8,
                'category_slug'     => 'aku-mars-motoru',
                'short_description' => '60Ah 540A (EN) - küçük-orta segment araçlar için.',
                'is_featured'       => true,
                'vehicle_make'      => null,
            ],
            // Far & Sinyal
            [
                'name'              => 'Hella Far Sol - Fiat Egea / Tipo',
                'brand'             => 'Hella',
                'oem_number'        => '1EL010031-031',
                'price'             => 1450.00,
                'sale_price'        => 1250.00,
                'stock'             => 6,
                'category_slug'     => 'far-sinyal-grubu',
                'short_description' => 'Fiat Egea 2015+ sol ön far komple.',
                'is_featured'       => false,
                'vehicle_make'      => 'Fiat',
            ],
            [
                'name'              => 'Osram H7 Xenon +150 Ampul (2\'li)',
                'brand'             => 'Osram',
                'oem_number'        => '64210NBS-HCB',
                'price'             => 210.00,
                'sale_price'        => null,
                'stock'             => 80,
                'category_slug'     => 'far-sinyal-grubu',
                'short_description' => 'H7 12V 55W, +150% daha fazla ışık, 2 adet.',
                'is_featured'       => true,
                'vehicle_make'      => null,
            ],
            // Sensörler
            [
                'name'              => 'Bosch Lambda Sensörü - VW/Audi 1.6/2.0 TDI',
                'brand'             => 'Bosch',
                'oem_number'        => '0281004114',
                'price'             => 560.00,
                'sale_price'        => null,
                'stock'             => 22,
                'category_slug'     => 'sensorler-beyinler',
                'short_description' => 'VAG grubu 1.6-2.0 TDI motorlar için oksijen sensörü.',
                'is_featured'       => false,
                'vehicle_make'      => 'Volkswagen',
            ],
            // Tampon & Panjur
            [
                'name'              => 'Ön Tampon Boyasız - Hyundai i20',
                'brand'             => 'Özel Marka',
                'oem_number'        => 'HYI20-FB01',
                'price'             => 780.00,
                'sale_price'        => 650.00,
                'stock'             => 5,
                'category_slug'     => 'tampon-panjur',
                'short_description' => 'Hyundai i20 2012-2014 ön tampon, boyasız muadil.',
                'is_featured'       => false,
                'vehicle_make'      => 'Hyundai',
            ],
            // Ayna & Cam
            [
                'name'              => 'Sağ Dış Dikiz Aynası Camı - Renault Megane III',
                'brand'             => 'Özel Marka',
                'oem_number'        => 'RNM3-MR',
                'price'             => 145.00,
                'sale_price'        => null,
                'stock'             => 30,
                'category_slug'     => 'ayna-cam',
                'short_description' => 'Renault Megane III sağ dikiz aynası yedek camı.',
                'is_featured'       => false,
                'vehicle_make'      => 'Renault',
            ],
            // Silecek
            [
                'name'              => 'Bosch Aerotwin Silecek Takımı - 650/400mm',
                'brand'             => 'Bosch',
                'oem_number'        => 'A099S',
                'price'             => 295.00,
                'sale_price'        => 249.00,
                'stock'             => 45,
                'category_slug'     => 'silecek-sistemi',
                'short_description' => 'Spoiler silecek seti 650mm + 400mm, çoğu araçla uyumlu.',
                'is_featured'       => true,
                'vehicle_make'      => null,
            ],
            // Direksiyon
            [
                'name'              => 'TRW Rotil Takımı - Toyota Yaris',
                'brand'             => 'TRW',
                'oem_number'        => 'JTE1248',
                'price'             => 340.00,
                'sale_price'        => null,
                'stock'             => 18,
                'category_slug'     => 'direksiyon-kutusu-pompasi',
                'short_description' => 'Toyota Yaris 1.0/1.3 dış rot başı, her iki taraf.',
                'is_featured'       => false,
                'vehicle_make'      => 'Toyota',
            ],
            // Ateşleme ek ürünler
            [
                'name'              => 'Denso Enjektör Temizleyici Seti',
                'brand'             => 'Denso',
                'oem_number'        => 'DNX-IJ001',
                'price'             => 180.00,
                'sale_price'        => 159.00,
                'stock'             => 50,
                'category_slug'     => 'atesleme-yakit',
                'short_description' => 'Yakıt sistemi ve enjektör temizleme kiti.',
                'is_featured'       => false,
                'vehicle_make'      => null,
            ],
            [
                'name'              => 'Valeo Debriyaj Seti - Peugeot 206 / 207 1.4',
                'brand'             => 'Valeo',
                'oem_number'        => '826519',
                'price'             => 1380.00,
                'sale_price'        => 1190.00,
                'stock'             => 7,
                'category_slug'     => 'triger-kayis-sistemleri',
                'short_description' => 'Peugeot 206/207 1.4i debriyaj disk + baskı seti.',
                'is_featured'       => true,
                'vehicle_make'      => 'Peugeot',
            ],
            [
                'name'              => 'SKF Ön Tekerlek Rulmanı - Volkswagen Polo',
                'brand'             => 'SKF',
                'oem_number'        => 'VKBA3563',
                'price'             => 420.00,
                'sale_price'        => null,
                'stock'             => 25,
                'category_slug'     => 'amortisor-viraj-demiri',
                'short_description' => 'VW Polo 9N 2001-2009 ön tekerlek rulman seti.',
                'is_featured'       => false,
                'vehicle_make'      => 'Volkswagen',
            ],
        ];

        foreach ($products as $index => $data) {
            $categorySlug = $data['category_slug'];
            unset($data['category_slug']);

            $category = Category::where('slug', $categorySlug)->first();
            if (!$category) {
                $category = Category::whereNull('parent_id')->first();
            }

            $name = $data['name'];
            $slug = Str::slug($name) . '-' . ($index + 1);
            $sku  = 'SKU-' . strtoupper(Str::random(6));

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
