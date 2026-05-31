<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $tree = [
            [
                'name' => 'Motor & Mekanik',
                'children' => [
                    ['name' => 'Filtreler (Yağ, Hava, Polen)'],
                    ['name' => 'Triger & Kayış Sistemleri'],
                    ['name' => 'Soğutma & Isıtma'],
                    ['name' => 'Ateşleme & Yakıt'],
                ],
            ],
            [
                'name' => 'Süspansiyon & Fren',
                'children' => [
                    ['name' => 'Fren Balatası & Disk'],
                    ['name' => 'Amortisör & Viraj Demiri'],
                    ['name' => 'Direksiyon Kutusu & Pompası'],
                ],
            ],
            [
                'name' => 'Elektrik & Aydınlatma',
                'children' => [
                    ['name' => 'Akü & Marş Motoru'],
                    ['name' => 'Far & Sinyal Grubu'],
                    ['name' => 'Sensörler & Beyinler'],
                ],
            ],
            [
                'name' => 'Kaporta & Dış Trim',
                'children' => [
                    ['name' => 'Tampon & Panjur'],
                    ['name' => 'Ayna & Cam'],
                    ['name' => 'Silecek Sistemi'],
                ],
            ],
        ];

        foreach ($tree as $order => $node) {
            $parent = Category::create([
                'name'       => $node['name'],
                'slug'       => Str::slug($node['name']),
                'parent_id'  => null,
                'is_active'  => true,
                'sort_order' => $order,
            ]);

            foreach ($node['children'] as $childOrder => $child) {
                Category::create([
                    'name'       => $child['name'],
                    'slug'       => Str::slug($child['name']),
                    'parent_id'  => $parent->id,
                    'is_active'  => true,
                    'sort_order' => $childOrder,
                ]);
            }
        }
    }
}
