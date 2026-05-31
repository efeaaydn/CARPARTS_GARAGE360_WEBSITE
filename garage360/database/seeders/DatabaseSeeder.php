<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Roller
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole  = Role::firstOrCreate(['name' => 'user',  'guard_name' => 'web']);

        // Admin kullanıcı
        $admin = User::firstOrCreate(
            ['email' => 'admin@garage360.com'],
            ['name' => 'Admin', 'password' => bcrypt('password'), 'is_active' => true]
        );
        $admin->syncRoles([$adminRole]);

        // Test kullanıcıları
        $users = [
            ['name' => 'Ahmet Yılmaz', 'email' => 'ahmet@test.com'],
            ['name' => 'Mehmet Demir', 'email' => 'mehmet@test.com'],
            ['name' => 'Ayşe Kaya',    'email' => 'ayse@test.com'],
            ['name' => 'Fatma Çelik',  'email' => 'fatma@test.com'],
            ['name' => 'Ali Öztürk',   'email' => 'ali@test.com'],
        ];

        foreach ($users as $userData) {
            $u = User::firstOrCreate(
                ['email' => $userData['email']],
                ['name' => $userData['name'], 'password' => bcrypt('password'), 'is_active' => true]
            );
            $u->syncRoles([$userRole]);
        }

        // Kategoriler
        $this->call(CategorySeeder::class);

        // Ürünler (en az 20 adet)
        $this->call(ProductSeeder::class);
    }
}
