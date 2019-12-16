<?php

namespace App\Traits;

use App\Models\User;
use Firebase\JWT\JWT;

trait JwtTrait {

    private function jwt(User $user){

        $payload = [
            'iss' => "lumen-jwt",
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60*60*1000
        ];
     
        return JWT::encode($payload, env('JWT_SECRET'));
    }

}