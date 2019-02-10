<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Contracts\JWTSubject;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    // Recall base test case method json but before we login and return token and assign it to header with merging
    public function jsonAs (JWTSubject $user, $method, $endpoint, array $data = [], array $headers = []) {
        $token = auth()->tokenById($user->id);

        return $this->json($method, $endpoint, $data, array_merge($headers, [
            'Authorization' => 'Bearer '.$token
        ]));
    }
}
