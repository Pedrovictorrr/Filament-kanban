<?php

namespace App\Filament\Resources\ProjetoResource\Pages;

use App\Filament\Resources\ProjetoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProjeto extends CreateRecord
{
    protected static string $resource = ProjetoResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('F2 - Salvar')
                ->keyBindings('f2'),
            ...(static::canCreateAnother() ? [$this->getCreateAnotherFormAction()] : []),
            $this->getCancelFormAction()
                ->label('F10 - Voltar')
                ->keyBindings('f10')
                ->color('danger'),
        ];
    }
}
