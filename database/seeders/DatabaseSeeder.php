<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
use App\Models\Entity;
use App\Models\Company;
use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
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
    }
}
