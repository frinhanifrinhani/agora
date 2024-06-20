<?php

namespace Tests\Unit\app\Http\Controllers;

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

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected $authController;
    protected $userRepository;
    protected $authService;
    protected $userController;
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

        $request = new AuthRequest();
        $userData = array($this->user);

        $expectedResponse = new JsonResponse();

        $request->request->add($userData);

        $this->authService
            ->expects($this->once())
            ->method('login')
            ->with($request)
            ->willReturn($expectedResponse);

        $response = $this->authController->login($request);

        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }

    public function testLogoutSuccess()
    {
        $expectedResponse = new JsonResponse();

        $this->authService
            ->expects($this->once())
            ->method('logout')
            ->willReturn($expectedResponse);

        $response = $this->authController->logout();

        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }

    public function testLoginThrowsExceptionError()
    {
        $request = new AuthRequest();
        $userData = [
            "email" => "xxx@xxx.xx",
            "password" => "xxx"
        ];

        $request->request->add($userData);

        $this->authService
            ->expects($this->once())
            ->method('login')
            ->with($request)
            ->willThrowException(new \Exception());

        $this->expectException(\Exception::class);

        $this->authController->login($request);
    }

    public function testLogoutThrowsExceptionError()
    {
        $this->authService
            ->expects($this->once())
            ->method('logout')
            ->willThrowException(new \Exception());

        $this->expectException(\Exception::class);

        $this->authController->logout();
    }
}
