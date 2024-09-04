<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Response;
use App\Services\AuthService;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected AuthService $authService;
    protected AuthController $authController;
    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = $this->app->make(AuthService::class);
        $this->authController = new AuthController($this->authService);

        $this->user = User::factory()->create();

        $this->token = $this->user->createToken('token')->plainTextToken;
    }

    public function testLoginSuccess()
    {

        $email=$this->user['email'];
        $password='123456';

        $userData = ['email'=>$email ,'password'=>$password];

        $response = $this->post('/api/login', $userData);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Login realizado com suscesso!', $responseData['message']);

    }

    public function logoutSuccess()
    {
        $email=$this->user['email'];
        $password='123456';

        $userData = ['email'=>$email ,'password'=>$password];

        $responseLogin = $this->post('/api/login', $userData);

        $response = $this->withHeader('Authorization', 'Bearer ' . $responseLogin['token'])->post('/api/logout');

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Logout realizado com sucesso!', $responseData['message']);

    }
}
