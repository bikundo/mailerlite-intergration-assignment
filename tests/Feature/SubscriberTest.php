<?php

namespace Tests\Feature;

use App\Http\Requests\CreateSubscriberRequest;
use Faker\Factory;
use Tests\TestCase;

class SubscriberTest extends TestCase
{

    public function testSubscriberCanBeCreated()
    {
        $this->withoutMiddleware();
        $faker = Factory::create();
        $request = new CreateSubscriberRequest();
        $request->merge([
            'email'   => $faker->safeEmail,
            'name'    => $faker->name,
            'country' => 'Kenya',
        ]);

        $response = $this->post('/subscribers', $request->all());
        $response->assertRedirect('/');
        $response->assertSessionHas('message', 'subscriber successfully saved!');
    }

    public function testSubscriberCannotBeCreatedIfAlreadyExists()
    {
        $this->withoutMiddleware();
        $faker = Factory::create();
        $request = new CreateSubscriberRequest();
        $request->merge([
            'email'   => $faker->safeEmail,
            'name'    => $faker->name,
            'country' => $faker->country,
        ]);
        $response1 = $this->post('/subscribers', $request->all());
        $response1->assertRedirect('/');
        $response1->assertSessionHas('message', 'subscriber successfully saved!');

        // Try to create the subscriber again
        $response2 = $this->post('/subscribers', $request->all());
        $response2->assertRedirect('/');
        $response2->assertSessionHas('message', 'subscriber already exists!');
    }

}
