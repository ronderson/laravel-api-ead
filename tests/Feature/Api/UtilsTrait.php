<?php

namespace Tests\Feature\Api;

use App\Models\User;

trait UtilsTrait
{

    public function createTokenUser() {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        return [
            'Authorization' => "Bearer {$token}"
        ];
    }
}
