<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use App\Models\Permission;
use App\Models\Role;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ManagePermissions extends ManageRecords
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {

                    // dd($data);
                    $data['user_id'] = auth()->id();

                    return $data;
                })->using(function (array $data, string $model): Model {
                    $create = $model::create($data);

                    $role = Role::find(1); // Supondo que você já tenha recuperado o objeto Role com ID 1
                    $permission = Permission::find($create->id); // Supondo que você já tenha recuperado o objeto Permission

                    $role->permissions()->attach($permission);

                    return $create;
                })
        ];
    }
    public function getFooter(): ?View
    {
        return view('filament.pages.footer');
    }
}
