<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
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
        $user = User::factory()->create([
            'name' => 'Jimmi Robles',
            'email' => 'admin@admin.com',
        ]);

        // TODO: Delete when app is ready for production

        // Create fake companies 
        $company = Company::factory(2)->create(); 
        // Attach company to user
        $user->companies()->attach($company);
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
        Material::insert($materials);
        // add units to products
        foreach ($products as &$product) {
            $product['unit_id'] = $units->random()->id;
            $product['category_id'] = $categories->random()->id; 
        }
        // Inserting data to products table
        Product::insert($products);
    }
}
