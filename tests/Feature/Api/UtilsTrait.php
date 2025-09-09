<?php

namespace Tests\Feature\Api;

use App\Models\User;

trait UtilsTrait
{
    public function createUser()
    {
        return User::factory()->create();
    }


    public function createTokenUser()
    {

        $token = $this->createUser()->createToken('test')->plainTextToken;
        return [
            'Authorization' => "Bearer {$token}"
        ];
    }
}
