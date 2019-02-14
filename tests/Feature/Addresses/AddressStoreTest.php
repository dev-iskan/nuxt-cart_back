<?php

namespace Tests\Feature\Addresses;

use App\Models\Country;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressStoreTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_fails_unauth()
    {
        $this->json('POST', 'api/addresses')
            ->assertStatus(401);
    }

    public function test_it_requires_a_name()
    {
        $user = factory(User::class)->create();
        $this->jsonAs($user,'POST', 'api/addresses')
            ->assertJsonValidationErrors(['name']);
    }

    public function test_it_requires_a_address_1()
    {
        $user = factory(User::class)->create();
        $this->jsonAs($user,'POST', 'api/addresses')
            ->assertJsonValidationErrors(['address_1']);
    }

    public function test_it_requires_a_city()
    {
        $user = factory(User::class)->create();
        $this->jsonAs($user,'POST', 'api/addresses')
            ->assertJsonValidationErrors(['city']);
    }

    public function test_it_requires_a_postal_code()
    {
        $user = factory(User::class)->create();
        $this->jsonAs($user,'POST', 'api/addresses')
            ->assertJsonValidationErrors(['postal_code']);
    }

    public function test_it_requires_a_country()
    {
        $user = factory(User::class)->create();
        $this->jsonAs($user,'POST', 'api/addresses', [
            'country_id' => 1
        ])
            ->assertJsonValidationErrors(['country_id']);
    }

    public function test_it_stores_an_address()
    {
        $user = factory(User::class)->create();
        $response = $this->jsonAs($user,'POST', 'api/addresses', $payload =[
            'name' => 'Test',
            'address_1' => '123 test',
            'city' => 'London',
            'postal_code' => '100077',
            'country_id' => factory(Country::class)->create()->id
        ]);

        $this->assertDatabaseHas('addresses', array_merge($payload, [
            'user_id' => $user->id
        ]));
    }

    public function test_it_returns_address()
    {
        $user = factory(User::class)->create();

        $response = $this->jsonAs($user,'POST', 'api/addresses', $payload =[
            'name' => 'Test',
            'address_1' => '123 test',
            'city' => 'London',
            'postal_code' => '100077',
            'country_id' => factory(Country::class)->create()->id
        ]);
        $response->assertJsonFragment([
                'id' => json_decode($response->getContent())->data->id
            ]);
    }
}
