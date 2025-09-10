<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run(): void
{
    // Borra y crea la carpeta solo una vez, antes de crear productos
    Storage::deleteDirectory('products');
    Storage::makeDirectory('products');

    \App\Models\User::factory()->create([
        'name' => 'Osmel',
        'last_name' => 'Boscan',
        'document_type' => '1', 
        'document_number' => '25195018',
        'email' => 'admin@admin.com',
        'phone' => '04141234567',
        'password' => bcrypt('12345678'),

    ]);
        // \App\Models\User::factory(20)->create();

    $this->call([

         PermissionSeeder::class,
         RoleSeeder::class,

         FamilySeeder::class,
         OptionSeeder::class,
    ]);

    // Ahora sí, crea los productos (y sus imágenes)
    // Product::factory(20)->create();
}
}
