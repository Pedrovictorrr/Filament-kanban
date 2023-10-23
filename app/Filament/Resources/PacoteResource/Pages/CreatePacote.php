<?php

namespace App\Filament\Resources\PacoteResource\Pages;

use App\Filament\Resources\PacoteResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePacote extends CreateRecord
{
    protected static string $resource = PacoteResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
    protected static ?string $title = 'Novo Pacote';
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
