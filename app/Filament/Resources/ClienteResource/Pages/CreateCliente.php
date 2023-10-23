<?php

namespace App\Filament\Resources\ClienteResource\Pages;

use App\Filament\Resources\ClienteResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCliente extends CreateRecord
{
    protected static string $resource = ClienteResource::class;

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

    protected function getCreatedNotification(): ?Notification
    {
        $recipient = auth()->user();

        Notification::make()
            ->title('Cliente criado com sucesso!')
            ->success()
            ->sendToDatabase($recipient);

        return Notification::make()
            ->success()
            ->title('Cliente registrado com sucesso')
            ->color('success');
    }
}
