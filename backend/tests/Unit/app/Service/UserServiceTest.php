<?php

namespace Tests\Unit\app\Http\Services;

use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;

class UserServiceTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected $userRepository;
    protected $userService;
    protected $userFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->userService = $this->createMock(UserService::class);
        $this->userFactory = User::factory()->create();
    }

    public function testCreateUserSuccess()
    {
        $request = new UserRequest();
        $userData = array($this->userFactory);

        $request->request->add($userData);

        $this->userService
            ->expects($this->once())
            ->method('createUser')
            ->with($request)
            ->willReturn(new JsonResponse('', Response::HTTP_CREATED));

        $this->userRepository
            ->expects($this->once())
            ->method('create')
            ->with($request)
            ->willReturn(new User());

        $response = $this->userService->createUser($request);

        $this->userRepository->create($request);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testGetAllUsersSuccess()
    {
        $request = new Request();

        $this->userService
            ->expects($this->once())
            ->method('getAllUsers')
            ->with($request)
            ->willReturn(new JsonResponse('', Response::HTTP_OK));

        $response = $this->userService->getAllUsers($request);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testGetUserByIdSuccess()
    {
        $userId = $this->userFactory->id;

        $this->userService
            ->expects($this->once())
            ->method('getUserById')
            ->with($userId)
            ->willReturn(new JsonResponse('', Response::HTTP_OK));

        $response = $this->userService->getUserById($userId);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testUpdateUserSuccess()
    {
        $request = new UserRequest();
        $userData = array($this->userFactory);

        $request->request->add($userData);

        $this->userService
            ->expects($this->once())
            ->method('updateUser')
            ->with($request)
            ->willReturn(new JsonResponse('', Response::HTTP_CREATED));

        $this->userRepository
            ->expects($this->once())
            ->method('update')
            ->with($request)
            ->willReturn(new User());

        $response = $this->userService->updateUser($request, $userData[0]['id']);

        $this->userRepository->update($request, $userData[0]['id']);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testDeleteUserSuccess()
    {
        $userId = $this->userFactory->id;

        $this->userService
            ->expects($this->once())
            ->method('deleteUser')
            ->with($userId)
            ->willReturn(new JsonResponse('', Response::HTTP_OK));

        $response = $this->userService->deleteUser($userId);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
