<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class Login extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        try {
            $data = $this->form->getState();
        } catch (ValidationException $exception) {
            throw $exception;
        }

        $response = Http::post('https://summary.timurbersinar.com/api/login', [
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if ($response->successful()) {
            $apiUser = $response->json();
            \Illuminate\Support\Facades\Log::info('SSO Response:', $apiUser);

            // Spec: id, name, email, avatar_url, nip, jabatan, status
            // Note: API might return data wrapped in 'data' key? 
            // The prompt says: "API returns User Data (id, name, email...)" directly or implied.
            // I will assume it returns the user object directly or check if it has 'data'.
            // Usually Laravel APIs return 'data' => user. 
            // But prompt says "Payload: ... If Success: API returns User Data".
            // I'll assume flat for now, or check for 'data' key if 'email' is missing.
            
            $data = $apiUser['data'] ?? [];
            $userData = $data['user'] ?? [];
            $accessToken = $data['access_token'] ?? null;

            if (! isset($userData['email'])) {
                 throw ValidationException::withMessages([
                    'data.email' => 'Invalid response from SSO server.',
                ]);
            }

            \Illuminate\Support\Facades\Log::info('User Data to Save:', [
                'email' => $userData['email'],
                'sso_id' => $userData['id'] ?? null,
                'status_from_api' => $userData['status'] ?? true,
            ]);

            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'sso_id' => $userData['id'] ?? null,
                    'name' => $userData['name'],
                    'avatar_url' => $userData['avatar_url'] ?? null,
                    'nip' => $userData['nip'] ?? null,
                    'jabatan' => $userData['jabatan'] ?? null,
                    'status' => $userData['status'] ?? true,
                    'sso_token' => $accessToken,
                ]
            );

            \Illuminate\Support\Facades\Log::info('User Saved:', ['id' => $user->id, 'status' => $user->status]);

            if (! $user->status) {
                \Illuminate\Support\Facades\Log::warning('User status is false. Login denied.');
                throw ValidationException::withMessages([
                    'data.email' => __('filament-panels::pages/auth/login.messages.failed'),
                ]);
            }

            Auth::login($user);
            \Illuminate\Support\Facades\Log::info('Auth::login called.');

            session()->regenerate();

            return app(LoginResponse::class);
        }

        throw ValidationException::withMessages([
            'data.email' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }
}
