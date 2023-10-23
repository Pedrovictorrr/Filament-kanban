<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 1,
                'title' => Role::ROLES['Super'],
            ],
            [
                'id' => 2,
                'title' => Role::ROLES['Admin'],
            ],
            [
                'id' => 3,
                'title' => Role::ROLES['User'],
            ],

            [
                'id' => 4,
                'title' => Role::ROLES['Inativo'],
            ],
            [
                'id' => 5,
                'title' => Role::ROLES['Analista'],
            ],
            [
                'id' => 6,
                'title' => Role::ROLES['Estagiario'],
            ],

            [
                'id' => 7,
                'title' => Role::ROLES['Desenvolvedor'],
            ],
            [
                'id' => 8,
                'title' => Role::ROLES['Qualidade'],
            ],
        ];

        Role::insert($roles);
    }
}
