<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\ActivityLog;
use App\Models\Cliente;
use App\Models\Historia;
use App\Models\instrucao;
use App\Policies\ActivityPolicy;
use App\Models\Permission;
use App\Models\Releases;
use App\Models\Role;
use App\Models\Projeto;
use App\Models\Tarefa;
use App\Policies\ClientePolicy;
use App\Policies\HistoriaPolicy;
use App\Policies\InstrucaoPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ReleasePolicy;
use App\Policies\RolePolicy;
use App\Policies\ProjetoPolicy;
use App\Policies\TarefaPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        User::class => UserPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        Activity::class => ActivityPolicy::class,
        ActivityLog::class => ActivityPolicy::class,
        instrucao::class => InstrucaoPolicy::class,
        Historia::class => HistoriaPolicy::class,
        Cliente::class => ClientePolicy::class,
        Projeto::class => ProjetoPolicy::class,
        Tarefa::class => TarefaPolicy::class,
        Releases::class => ReleasePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
