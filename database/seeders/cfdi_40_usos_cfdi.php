<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class cfdi_40_usos_cfdi extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usosCfdi = [
            ['clave' => 'G01', 'descripcion' => 'Adquisición de mercancías.', 'aplica_fisica' => 1, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => '', 'regimenes_fiscales_receptores' => json_encode(['601', '603', '606', '612', '620', '621', '622', '623', '624', '625', '626'])],
            ['clave' => 'G02', 'descripcion' => 'Devoluciones, descuentos o bonificaciones.', 'aplica_fisica' => 1, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => '', 'regimenes_fiscales_receptores' => json_encode(['601', '603', '606', '612', '616', '620', '621', '622', '623', '624', '625', '626'])],
            ['clave' => 'G03', 'descripcion' => 'Gastos en general.', 'aplica_fisica' => 1, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => '', 'regimenes_fiscales_receptores' => json_encode(['601', '603', '606', '612', '620', '621', '622', '623', '624', '625', '626'])],
            ['clave' => 'I01', 'descripcion' => 'Construcciones.', 'aplica_fisica' => 1, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => '', 'regimenes_fiscales_receptores' => json_encode(['601', '603', '606', '612', '620', '621', '622', '623', '624', '625', '626'])],
            ['clave' => 'I02', 'descripcion' => 'Mobiliario y equipo de oficina por inversiones.', 'aplica_fisica' => 1, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => '', 'regimenes_fiscales_receptores' => json_encode(['601', '603', '606', '612', '620', '621', '622', '623', '624', '625', '626'])],
            ['clave' => 'I03', 'descripcion' => 'Equipo de transporte.', 'aplica_fisica' => 1, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => '', 'regimenes_fiscales_receptores' => json_encode(['601', '603', '606', '612', '620', '621', '622', '623', '624', '625', '626'])],
            ['clave' => 'D01', 'descripcion' => 'Honorarios médicos, dentales y gastos hospitalarios.', 'aplica_fisica' => 1, 'aplica_moral' => 0, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => '', 'regimenes_fiscales_receptores' => json_encode(['605', '606', '608', '611', '612', '614', '607', '615', '625'])],
            ['clave' => 'S01', 'descripcion' => 'Sin efectos fiscales.', 'aplica_fisica' => 1, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => '', 'regimenes_fiscales_receptores' => json_encode(['601', '603', '605', '606', '608', '610', '611', '612', '614', '616', '620', '621', '622', '623', '624', '607', '615', '625', '626'])],
            ['clave' => 'CP01', 'descripcion' => 'Pagos', 'aplica_fisica' => 1, 'aplica_moral' => 1, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => '', 'regimenes_fiscales_receptores' => json_encode(['601', '603', '605', '606', '608', '610', '611', '612', '614', '616', '620', '621', '622', '623', '624', '607', '615', '625', '626'])],
            ['clave' => 'CN01', 'descripcion' => 'Nómina', 'aplica_fisica' => 1, 'aplica_moral' => 0, 'vigencia_desde' => '2022-01-01', 'vigencia_hasta' => '', 'regimenes_fiscales_receptores' => json_encode(['605'])],
        ];

        DB::table('cfdi_40_usos_cfdi')->insert($usosCfdi);
    }
}
