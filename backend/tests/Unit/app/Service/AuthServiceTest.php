<?php

namespace Tests\Unit\app\Http\Services;

use Mockery;
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

class AuthServiceTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected $authController;
    protected $userRepository;
    protected $authService;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->authService = $this->createMock(AuthService::class);
        $this->authController = new AuthController($this->authService);

        $userMock = Mockery::mock(User::class);
        $this->app->instance(User::class, $userMock);
        $this->user = User::factory()->create();
    }

    public function testLoginSuccess()
    {
        $response = $this->post('/api/login', [
            'email' =>  $this->user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Login realizado com suscesso!',
                'user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email
                ],
                'token' => $response->original['token']
            ]);

        $this->assertAuthenticatedAs($this->user);
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
        $token = $this->user->createToken('token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/logout');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'message' => 'Logout realizado com sucesso!'
            ]);

        $this->assertEmpty($this->user->tokens);
    }

    public function testLogoutError()
    {
        $token = 'null';

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/logout');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'error' => 'Not authorized'
            ]);

        $this->assertEmpty($this->user->tokens);
    }
}
