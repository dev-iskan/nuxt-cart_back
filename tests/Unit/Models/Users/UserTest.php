<?php

namespace Tests\Unit\Models\Users;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_hashes_password_on_creating () {
        $user = factory(User::class)->create();

        $this->assertNotEquals($user->password, 'cats');
    }
}
