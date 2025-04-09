<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class cfdi_40_regimenes_fiscales extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regimenes = [
            ['clave' => '601', 'descripcion' => 'General de Ley Personas Morales', 'aplica_fisica' => 0, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '603', 'descripcion' => 'Personas Morales con Fines no Lucrativos', 'aplica_fisica' => 0, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '605', 'descripcion' => 'Sueldos y Salarios e Ingresos Asimilados a Salarios', 'aplica_fisica' => 1, 'aplica_moral' => 0, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '606', 'descripcion' => 'Arrendamiento', 'aplica_fisica' => 1, 'aplica_moral' => 0, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '607', 'descripcion' => 'Régimen de Enajenación o Adquisición de Bienes', 'aplica_fisica' => 1, 'aplica_moral' => 0, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '608', 'descripcion' => 'Demás ingresos', 'aplica_fisica' => 1, 'aplica_moral' => 0, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '610', 'descripcion' => 'Residentes en el Extranjero sin Establecimiento Permanente en México', 'aplica_fisica' => 1, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '611', 'descripcion' => 'Ingresos por Dividendos (socios y accionistas)', 'aplica_fisica' => 1, 'aplica_moral' => 0, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '612', 'descripcion' => 'Personas Físicas con Actividades Empresariales y Profesionales', 'aplica_fisica' => 1, 'aplica_moral' => 0, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '614', 'descripcion' => 'Ingresos por intereses', 'aplica_fisica' => 1, 'aplica_moral' => 0, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '615', 'descripcion' => 'Régimen de los ingresos por obtención de premios', 'aplica_fisica' => 1, 'aplica_moral' => 0, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '616', 'descripcion' => 'Sin obligaciones fiscales', 'aplica_fisica' => 1, 'aplica_moral' => 0, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '620', 'descripcion' => 'Sociedades Cooperativas de Producción que optan por diferir sus ingresos', 'aplica_fisica' => 0, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '621', 'descripcion' => 'Incorporación Fiscal', 'aplica_fisica' => 1, 'aplica_moral' => 0, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '622', 'descripcion' => 'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras', 'aplica_fisica' => 0, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '623', 'descripcion' => 'Opcional para Grupos de Sociedades', 'aplica_fisica' => 0, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '624', 'descripcion' => 'Coordinados', 'aplica_fisica' => 0, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '625', 'descripcion' => 'Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas', 'aplica_fisica' => 1, 'aplica_moral' => 0, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
            ['clave' => '626', 'descripcion' => 'Régimen Simplificado de Confianza', 'aplica_fisica' => 1, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => ''],
        ];

        DB::table('cfdi_40_regimenes_fiscales')->insert($regimenes);
    }
}
