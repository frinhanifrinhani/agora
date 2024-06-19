<?php

namespace Tests\Unit\app\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AuthRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected $authController;
    protected $userRepository;
    protected $authService;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->authService = $this->createMock(AuthService::class);
        $this->authController = new AuthController( $this->authService);
    }

    public function testLoginSuccess()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            'email' =>  $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Login realizado com suscesso!',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email
                ],
                'token' => $response->original['token']
            ]);

        $this->assertAuthenticatedAs($user);
    }


    public function testLoginValidationEmptyFieldsError()
    {

        $requestData = [
            'email' => '',
            'password' => '',
        ];

        $request = new AuthRequest($requestData);

        $responseMock = $this->createMock(JsonResponse::class);
        $responseMock->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(Response::HTTP_UNPROCESSABLE_ENTITY);


        $responseMock->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode([
                'errors' => [
                    'email' => ['O campo E-mail é obrigatório.'],
                    'password' => ['O campo Senha é obrigatório.']
                ]
            ]));

        $this->authService->expects($this->once())
            ->method('login')
            ->with($this->equalTo($request))
            ->willReturn($responseMock);

        $response = $this->authController->login($request);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('errors', $responseContent);
        $this->assertArrayHasKey('email', $responseContent['errors']);
        $this->assertArrayHasKey('password', $responseContent['errors']);
        $this->assertEquals(['O campo E-mail é obrigatório.'], $responseContent['errors']['email']);
        $this->assertEquals(['O campo Senha é obrigatório.'], $responseContent['errors']['password']);
    }

    public function testLoginInvalidEmailTypeError()
    {

        $requestData = [
            'email' => 'invalid',
            'password' => 'invalid',
        ];

        $request = new AuthRequest($requestData);

        $responseMock = $this->createMock(JsonResponse::class);
        $responseMock->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(Response::HTTP_UNPROCESSABLE_ENTITY);


        $responseMock->expects($this->once())
            ->method('getContent')
            ->willReturn(json_encode([
                'errors' => [
                    'email' => ['The email field must be a valid email address.'],
                ]
            ]));

        $this->authService->expects($this->once())
            ->method('login')
            ->with($this->equalTo($request))
            ->willReturn($responseMock);

        $response = $this->authController->login($request);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('errors', $responseContent);
        $this->assertArrayHasKey('email', $responseContent['errors']);
        $this->assertEquals(['The email field must be a valid email address.'], $responseContent['errors']['email']);
    }

    public function testLoginInvalidLoginOrPasswordError()
    {

        $requestData = [
            'email' => 'invalid@payments.com',
            'password' => 'invalidPassword',
        ];

        $request = new AuthRequest($requestData);

        $responseMock = $this->createMock(JsonResponse::class);
        $responseMock->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(Response::HTTP_UNPROCESSABLE_ENTITY);


        $responseMock->expects($this->once())
            ->method('getContent')
            ->willReturn(
                json_encode(
                    [
                        'errors' =>  "E-mail e/ou senha incorreto(s)."
                    ]
                )
            );

        $this->authService->expects($this->once())
            ->method('login')
            ->with($this->equalTo($request))
            ->willReturn($responseMock);

        $response = $this->authController->login($request);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $responseContent = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('errors', $responseContent);
        $this->assertEquals('E-mail e/ou senha incorreto(s).', $responseContent['errors']);
    }

    public function testLogoutSuccess()
    {
        $user = User::factory()->create();
        $token = $user->createToken('token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/logout');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Logout realizado com sucesso!'
            ]);

        $this->assertEmpty($user->tokens);
    }


    public function testLogoutError()
    {
        $user = User::factory()->create();
        $token = 'null';

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/logout');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'error' => 'Not authorized'
            ]);

        $this->assertEmpty($user->tokens);
    }
}
