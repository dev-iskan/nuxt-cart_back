<?php

namespace Tests\Feature\Countries;

use App\Models\Country;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryIndexTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_it_returns_countries()
    {
        $country = factory(Country::class)->create();

        $this->json('GET', 'api/countries')
            ->assertJsonFragment([
                'id' => $country->id
            ]);
    }
}
