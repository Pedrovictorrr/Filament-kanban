<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class dificuldade_enum extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dificuldade_enum')->insert([
            'titulo' => 'Muito Facil',
        ]);
        DB::table('dificuldade_enum')->insert([
            'titulo' => 'Facil',
        ]);
        DB::table('dificuldade_enum')->insert([
            'titulo' => 'Médio',
        ]);
        DB::table('dificuldade_enum')->insert([
            'titulo' => 'Difícil',
        ]);
        DB::table('dificuldade_enum')->insert([
            'titulo' => 'Muito Difícil',
        ]);
    }
}
