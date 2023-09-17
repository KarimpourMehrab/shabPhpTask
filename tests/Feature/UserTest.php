<?php

namespace Tests\Feature;


use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Ybazli\Faker\Facades\Faker;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login(): void
    {
        $response = $this->post($this->url . 'login', [
            'mobile' => '09054603316',
            'password' => '121212'
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * A basic feature test example.
     */
    public function test_register_repeated_mobile(): void
    {
        $response = $this->post($this->url . 'register', [
            'mobile' => '09054603316',
            'password' => '121212',
            'name' => 'user test'
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * A basic feature test example.
     */
    public function test_register_with_new_mobile(): void
    {
        $response = $this->post($this->url . 'register', [
            'mobile' => Faker::mobile(),
            'password' => rand(6, 12),
            'name' => 'test user'
        ]);
        $state = $response->status() === Response::HTTP_CREATED || $response->status() === Response::HTTP_UNPROCESSABLE_ENTITY;
        $this->assertTrue($state);
    }
}
