<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'SUPORTE teste',
                'email' => 'suporte@teste.com.br',
                'password' => bcrypt('123456'),
                'telefone' => '47985852845',
                'avatar_url' => 'public/fotos-perfil/SUPORTE teste.png',
                'git_token' => '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',
            ],
          
        ];

        User::insert($users);
    }
}
