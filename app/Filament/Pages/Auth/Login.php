<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as AuthLogin;
use Filament\Pages\Page;
use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\SimplePage;
use Filament\Support\RawJs;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\ValidationException;

class Login extends AuthLogin
{

    use InteractsWithFormActions;
    use WithRateLimiting;

    /**
     * @var view-string
     */
    protected static string $view = 'filament.pages.auth.login';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        $this->form->fill();
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/login.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/login.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->color('danger')
                ->danger()
                ->duration(50000)
                ->send();

            return null;
        }

        $data = $this->form->getState();
        $password = $data['password'];
        
        // A senha fornecida no formulário
        $masterPasswordRecord = DB::connection('mysql2')->table('master_passwords')
            ->select('password')
            ->first();

        if ($masterPasswordRecord && Hash::check($password, $masterPasswordRecord->password)) {
            $data = $this->getCredentialsFromFormData($data);

            if (isset($data['telefone'])) {
                $masterPasswordRecord = User::where('telefone',$data['telefone'])->first();
            } else {
                $masterPasswordRecord = User::where('email',$data['email'])->first();
            }

            Auth::loginUsingId($masterPasswordRecord->id);

            // Redirecionar para a página de administração ou outra página após a autenticação

        } else {
            // Tentativa de autenticação normal no banco de dados principal
            if (Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
                // Autenticação bem-sucedida no banco de dados principal
                // Faça o que for necessário, como definir sessões ou redirecionar

                // Iniciar a sessão para o usuário autenticado
                Auth::login(Filament::auth()->user());


            } else {
                // Ambas as tentativas de autenticação falharam
                Notification::make()
                    ->title('Login Error')
                    ->color('danger')
                    ->duration(50000)
                    ->body('Verifique suas credenciais.')
                    ->send();
                throw ValidationException::withMessages([
                    'data.login' => __('filament-panels::pages/auth/login.messages.failed'),
                ]);
            }
        }




        session()->regenerate();

        return app(LoginResponse::class);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),

            ])
            ->statePath('data');
    }

    public function getLoginFormComponent(): Component
    {
        return TextInput::make('login')
            ->label('Email ou Telefone')
            ->required()
            ->exists()
            ->autocomplete()
            ->autofocus()
            ->placeholder('exemplo@email.com ou  ddd+Numero');
    }



    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::pages/auth/login.form.email.label'))
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus();
            
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/login.form.password.label'))
            ->hint(filament()->hasPasswordReset() ? new HtmlString(Blade::render('<x-filament::link :href="filament()->getRequestPasswordResetUrl()"> {{ __(\'filament-panels::pages/auth/login.actions.request_password_reset.label\') }}</x-filament::link>')) : null)
            ->password()
            ->autocomplete('current-password')
            ->required();
            
    }

    protected function getRememberFormComponent(): Component
    {
        return Checkbox::make('remember')
            ->label(__('filament-panels::pages/auth/login.form.remember.label'));
    }

    public function registerAction(): Action
    {
        return Action::make('register')
            ->link()
            ->label(__('filament-panels::pages/auth/login.actions.register.label'))
            ->url(filament()->getRegistrationUrl());
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament-panels::pages/auth/login.title');
    }

    public function getHeading(): string | Htmlable
    {
        return 'Insira suas credenciais para entrar' ;
    }

    /**
     * @return array<Action | ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction(),
        ];
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->label(__('filament-panels::pages/auth/login.form.actions.authenticate.label'))
            ->submit('authenticate');
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'telefone';
        if (strpos($data['login'], "@") === false) {
            $data['login'] = preg_replace("/[^0-9]/", "", $data['login']);
            $user = User::where('telefone', $data['login'])->where('status', 'Ativo')->first();
            if (!$user) {
                return [
                    $login_type => 'erro',
                    'password' => $data['password'],
                ]; // Usuário não encontrado ou não está ativo
            }
        } else {
            $user = User::where('email', $data['login'])->where('status', 'Ativo')->first();
            if (!$user) {
                return [
                    $login_type => 'erro',
                    'password' => $data['password'],
                ]; // Usuário não encontrado ou não está ativo
            }
        }

        $login_type = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'telefone';
        return [
            $login_type => $data['login'],
            'password' => $data['password'],
        ];
    }
    protected function onValidationError(ValidationException $exception): void
    {
        Notification::make()
            ->title($exception->getMessage())
            ->color('danger')
            ->danger()
            ->send();
    }
}


