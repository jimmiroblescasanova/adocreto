<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
use App\Models\Entity;
use App\Models\Company;
use App\Models\Product;
use App\Models\Category;
use App\Models\Material;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            cfdi_40_regimenes_fiscales::class,
            cfdi_40_usos_cfdi::class,
        ]);

        $user = User::factory()->create([
            'name' => 'Jimmi Robles',
            'email' => 'admin@admin.com',
        ]);

        // TODO: Delete when app is ready for production

        // Create fake companies 
        Company::insert([
            [
                'name' => 'Empresa 1',
                'rfc' => 'xaxx010101000',
            ], [
                'name' => 'Empresa 2',
                'rfc' => 'abc010101dfg',
            ]
        ]); 
        // Attach company to user
        $user->companies()->attach(Company::all());
        // Pre-load data
        $categories = require __DIR__ . '/FakeCategories.php';
        $materials = require __DIR__ . '/FakeMaterials.php';
        $products = require __DIR__ . '/FakeProducts.php';
        $units = require __DIR__ . '/FakeUnits.php';
        // Inserting data
        Unit::insert($units);
        Category::insert($categories);
        // Pre-load units and categories
        $units = Unit::all();
        $categories = Category::all();
        // add units to materials
        foreach ($materials as &$material) {
            $material['unit_id'] = $units->random()->id;
        }
        // Inserting data to materials table
        Product::insert($materials);
        // add units to products
        foreach ($products as &$product) {
            $product['unit_id'] = $units->random()->id;
            $product['category_id'] = $categories->random()->id; 
        }
        // Inserting data to products table
        Product::insert($products);
        Entity::factory(40)->create();
    }
}
