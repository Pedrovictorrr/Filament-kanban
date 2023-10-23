<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [



            // Permission policies
            [
                'title' => 'repositorio_create',
            ],
            [
                'title' => 'repositorio_edit',
            ],
            [
                'title' => 'repositorio_delete',
            ],
            [
                'title' => 'repositorio_show',
            ],
            [
                'title' => 'repositorio_access',
            ],
            // Permission policies
            [
                'title' => 'release_create',
            ],
            [
                'title' => 'release_edit',
            ],
            [
                'title' => 'release_delete',
            ],
            [
                'title' => 'release_show',
            ],
            [
                'title' => 'release_access',
            ],

            // Permission policies
            [
                'title' => 'historia_create',
            ],
            [
                'title' => 'historia_edit',
            ],
            [
                'title' => 'historia_delete',
            ],
            [
                'title' => 'historia_show',
            ],
            [
                'title' => 'historia_access',
            ],

            // Permission policies
            [
                'title' => 'cliente_create',
            ],
            [
                'title' => 'cliente_edit',
            ],
            [
                'title' => 'cliente_delete',
            ],
            [
                'title' => 'cliente_show',
            ],
            [
                'title' => 'cliente_access',
            ],

            // Permission policies
            [
                'title' => 'projeto_create',
            ],
            [
                'title' => 'projeto_edit',
            ],
            [
                'title' => 'projeto_delete',
            ],
            [
                'title' => 'projeto_show',
            ],
            [
                'title' => 'projeto_access',
            ],

            // Permission policies
            [
                'title' => 'tarefa_create',
            ],
            [
                'title' => 'tarefa_edit',
            ],
            [
                'title' => 'tarefa_delete',
            ],
            [
                'title' => 'tarefa_show',
            ],
            [
                'title' => 'tarefa_access',
            ],


            // Permission policies
            [
                'title' => 'permission_create',
            ],
            [
                'title' => 'permission_edit',
            ],
            [
                'title' => 'permission_delete',
            ],
            [
                'title' => 'permission_show',
            ],
            [
                'title' => 'permission_access',
            ],

            // Roles policies
            [
                'title' => 'role_create',
            ],
            [
                'title' => 'role_edit',
            ],
            [
                'title' => 'role_show',
            ],
            [
                'title' => 'role_delete',
            ],
            [
                'title' => 'role_access',
            ],

            // User policies
            [
                'title' => 'user_create',
            ],
            [
                'title' => 'user_edit',
            ],
            [
                'title' => 'user_show',
            ],
            [
                'title' => 'user_delete',
            ],
            [
                'title' => 'user_access',
            ],
            [
                'title' => 'user_status_edit',
            ],

            // Log policies
            [
                'title' => 'activity_create',
            ],
            [
                'title' => 'activity_edit',
            ],
            [
                'title' => 'activity_show',
            ],
            [
                'title' => 'activity_delete',
            ],
            [
                'title' => 'activity_access',
            ],

            // Helpers policies
            [
                'title' => 'instrucao_create',
            ],
            [
                'title' => 'instrucao_edit',
            ],
            [
                'title' => 'instrucao_show',
            ],
            [
                'title' => 'instrucao_delete',
            ],
            [
                'title' => 'instrucao_access',
            ],


        ];

        Permission::insert($permissions);
    }
}
