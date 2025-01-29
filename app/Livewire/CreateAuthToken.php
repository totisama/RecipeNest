<?php

namespace App\Livewire;

use Livewire\Component;

class CreateAuthToken extends Component
{
    public string $token;

    public function createToken()
    {
        $user = auth()->user();
        $user->tokens()->delete();

        $tokenName = str_replace(' ', '-', $user->name).'-'.now()->timestamp;
        $token = $user->createToken($tokenName);

        $this->token = $token->plainTextToken;
    }

    public function render()
    {
        return view('livewire.create-auth-token');
    }
}
