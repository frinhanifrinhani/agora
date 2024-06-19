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
    protected $userController ;
    protected $userFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->authService = $this->createMock(AuthService::class);
        $this->authController = new AuthController( $this->authService);
        $this->userFactory = User::factory()->create();
    }

    public function testLoginSuccess()
    {
        $request = new AuthRequest();
        $userData = array($this->userFactory);

        $expectedResponse = new JsonResponse();

        $request->request->add($userData);

        $this->authService
            ->expects($this->once())
            ->method('login')
            ->with($request)
            ->willReturn($expectedResponse);

        $response = $this->authController->login($request);

        $this->assertEquals($response->getStatusCode(),Response::HTTP_OK);
    }
}
