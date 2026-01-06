<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
   public function register($validated): array
   {
       $user = User::create([
           'name' => $validated['name'],
           'email' => $validated['email'],
           'password' => Hash::make($validated['password']),
       ]);

       $token = $this->generateToken($user, $validated['device_name']);

       return [
           'user' => $user,
           'token' => $token,
       ];
   }

   public function login($validated): array
   {
       $user = User::where('email', $validated['email'])->first();

       if (!$user) {
           $this->loginFailed('The provided credentials are incorrect.');
       }

       if (!Hash::check($validated['password'], $user->password)) {
           $this->loginFailed('The provided credentials are incorrect.');
       }

       $token = $this->generateToken($user, $validated['device_name']);

       return [
           'user' => $user,
           'token' => $token,
       ];
   }

    private function loginFailed($message)
    {
        throw ValidationException::withMessages([
            'email' => [$message],
        ]);
    }

    public function generateToken(User $user, $device_name): string
    {
        return $user->createToken($device_name)->plainTextToken;
    }

    public function saveFcmToken($validated): void
    {
        $user = auth()->user();
        $fcmToken = $user->fcmTokens()->where('token', $validated['fcm_token'])->first();
        if (!$fcmToken) {
            $user->fcmTokens()->create([
                'token' => $validated['fcm_token'],
            ]);
        }
    }
}
