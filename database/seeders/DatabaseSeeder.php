<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Jimmi Robles',
            'email' => 'admin@admin.com',
        ]);

        $company = Company::factory(2)->create(); 

        $user->companies()->attach($company);

        // Basic units
        $units = [
            ['name' => 'Pieza', 'abbreviation' => 'PZA'],
            ['name' => 'Metro', 'abbreviation' => 'MTR'],
            ['name' => 'Kilogramo', 'abbreviation' => 'KGM'],
            ['name' => 'Litro', 'abbreviation' => 'LTR'],
            ['name' => 'Paquete', 'abbreviation' => 'PAQ'],
            ['name' => 'Caja', 'abbreviation' => 'CJA'],
            ['name' => 'Juego', 'abbreviation' => 'JGO'],
            ['name' => 'Par', 'abbreviation' => 'PAR'],
        ];
        
        Unit::insert($units);

        $categories = [
            [
                'name' => 'Herramientas Manuales',
                'color' => '#FF5733',
                'description' => 'Instrumentos operados sin electricidad.',
            ],
            [
                'name' => 'Herramientas Eléctricas',
                'color' => '#33C1FF',
                'description' => 'Equipos motorizados para diversas tareas.',
            ],
            [
                'name' => 'Materiales de Construcción',
                'color' => '#8D6E63',
                'description' => 'Suministros esenciales para edificación.',
            ],
            [
                'name' => 'Pinturas y Acabados',
                'color' => '#FFC300',
                'description' => 'Productos para decorar y proteger superficies.',
            ],
            [
                'name' => 'Fontanería y Sanitarios',
                'color' => '#4CAF50',
                'description' => 'Sistemas de agua y accesorios sanitarios.',
            ],
            [
                'name' => 'Electricidad e Iluminación',
                'color' => '#FFEB3B',
                'description' => 'Componentes eléctricos y soluciones lumínicas.',
            ],
            [
                'name' => 'Ferretería General',
                'color' => '#9E9E9E',
                'description' => 'Variedad de artículos para múltiples usos.',
            ],
            [
                'name' => 'Jardinería y Exteriores',
                'color' => '#81C784',
                'description' => 'Herramientas y productos para el jardín.',
            ],
            [
                'name' => 'Seguridad y Protección Laboral',
                'color' => '#E53935',
                'description' => 'Equipos para garantizar seguridad laboral.',
            ],
            [
                'name' => 'Adhesivos y Selladores',
                'color' => '#FF9800',
                'description' => 'Materiales para unir y sellar superficies.',
            ],
        ];

        Category::insert($categories);
    }
}
