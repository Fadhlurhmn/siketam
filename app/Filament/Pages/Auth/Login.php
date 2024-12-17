<?php

namespace App\Filament\Pages\Auth;

use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BasePage;
use Illuminate\Validation\ValidationException;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class Login extends BasePage
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->autocomplete()
                    ->autofocus(),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required(),
            ]);
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'data.username' => __('filament-panels::pages/auth/login.messages.throttled', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]),
            ]);
        }

        $data = $this->form->getState();

        // Autentikasi user menggunakan username
        if (!auth()->attempt([
            'username' => $data['username'],
            'password' => $data['password'],
        ])) {
            throw ValidationException::withMessages([
                'data.username' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }

        // Setelah login sukses, regenerasi sesi
        session()->regenerate();

        // Redirect user berdasarkan role
        return $this->redirectBasedOnRole();
    }

    protected function redirectBasedOnRole(): LoginResponse
    {
        $user = auth()->user();

        $redirectPath = match ($user->role) {
            'driver' => '/admin/driver-dashboard',
            'supervisor_driver' => '/admin/supervisor-dashboard',
            'vehicle_admin' => '/admin/vehicle-dashboard',
            'supervisor_admin' => '/admin/admin-dashboard',
            default => '/admin',
        };

        return app(LoginResponse::class)->setRedirectUrl($redirectPath);
    }
}
