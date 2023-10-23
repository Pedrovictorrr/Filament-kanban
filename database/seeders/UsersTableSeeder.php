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
                'name' => 'SUPORTE W2O',
                'email' => 'suporte@w2o.com.br',
                'password' => bcrypt('123456'),
                'telefone' => '47985852845',
                'avatar_url' => 'public/fotos-perfil/SUPORTE W2O.png',
                'git_token' => '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',
            ],
            [
                'name' => 'Edmundo',
                'email' => 'edmundo@w2o.com.br',
                'password' => bcrypt('!EdmundoW2O'),
                'telefone' => '47991933500',
                'avatar_url' => 'public/fotos-perfil/SUPORTE W2O.png',
                'git_token' => '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',
            ],
            [
                'name' => 'Victor de Abreu',
                'email' => 'pedro.victor@w2o.com.br',
                'password' => bcrypt('123456'),
                'telefone' => '21985852845',
                'avatar_url' => 'public/fotos-perfil/SUPORTE W2O.png',
                'git_token' => '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',
            ],
            [
                'name' => 'Roger Rocha',
                'email' => 'roger.rocha@w2o.com.br',
                'password' => bcrypt('123456'),
                'telefone' => '47992095001',
                'avatar_url' => 'public/fotos-perfil/SUPORTE W2O.png',
                'git_token' => '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',
            ],
            [
                'name' => 'Carlos Brito',
                'email' => 'carlos.brito@w2o.com.br',
                'password' => bcrypt('123456'),
                'telefone' => '47989050242',
                'avatar_url' => 'public/fotos-perfil/SUPORTE W2O.png',
                'git_token' => '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',
            ],
            [
                'name' => 'Andre Garlini',
                'email' => 'randre.garlini@w2o.com.br',
                'password' => bcrypt('123456'),
                'telefone' => '47992095088',
                'avatar_url' => 'public/fotos-perfil/SUPORTE W2O.png',
                'git_token' => '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',
            ],
            [
                'name' => 'Bernardo Schramm',
                'email' => 'bernardo.schramm@w2o.com.br',
                'password' => bcrypt('123456'),
                'telefone' => '47992093001',
                'avatar_url' => 'public/fotos-perfil/SUPORTE W2O.png',
                'git_token' => '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',
            ],
        ];

        User::insert($users);
    }
}
