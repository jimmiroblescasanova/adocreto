<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        if (app()->isLocal()) {
            $user = User::factory()->create([
                'name' => 'Jimmi Robles',
                'email' => 'admin@admin.com',
            ]);
        }

        // Create fake companies 
        DB::table('companies')->insert([
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
