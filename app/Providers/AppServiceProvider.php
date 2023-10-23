<?php

namespace App\Providers;

use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DatePicker::configureUsing(function (DatePicker $datePicker): void {
            $datePicker->displayFormat('d/m/Y');
            $datePicker->native(false);
            $datePicker->firstDayOfWeek(7);
        });

        Page::$reportValidationErrorUsing = function (ValidationException $exception) {
            Notification::make()
                ->title('Erro de validação')
                ->body($exception->getMessage())
                ->color('danger')
                ->danger()
                ->send();
        };
    }
}
