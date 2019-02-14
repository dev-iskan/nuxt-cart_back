<?php

namespace Tests\Unit\Models\Addresses;

use App\Models\Address;
use App\Models\Country;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_has_one_country()
    {
        $address = factory(Address::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->assertInstanceOf(Country::class, $address->country);

    }

    public function test_it_belongs_to_user()
    {
        $address = factory(Address::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $this->assertInstanceOf(User::class, $address->user);

    }

    public function test_it_set_all_address_not_default()
    {
        $user = factory(User::class)->create();

        $oldAddress = factory(Address::class)->create([
            'user_id' => $user->id,
            'default' => true
        ]);

        factory(Address::class)->create([
            'user_id' => $user->id,
            'default' => true
        ]);

        $this->assertFalse($oldAddress->fresh()->default);

    }
}
