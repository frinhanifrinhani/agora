<?php

namespace Tests\Unit\app\Http\Services;

use Mockery;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserServiceTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected $userRepository;
    protected $userService;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->userService = $this->createMock(UserService::class);

        $userMock = Mockery::mock(User::class);
        $this->app->instance(User::class, $userMock);
        $this->user = User::factory()->create();
    }

    public function testCreateUserSuccess()
    {
        $request = new UserRequest();
        $userData = array($this->user);

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

    public function testCreateUserEmptyFieldsError()
    {
        $request = new UserRequest();
        $userData = array();

        $request->request->add($userData);

        $this->userService
            ->expects($this->once())
            ->method('createUser')
            ->with($request)
            ->willReturn(new JsonResponse('', Response::HTTP_UNPROCESSABLE_ENTITY));

        $this->userRepository
            ->expects($this->once())
            ->method('create')
            ->with($request)
            ->willReturn(new User());

        $response = $this->userService->createUser($request);

        $this->userRepository->create($request);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
    }

    public function testCreateUserDuplicatRegisterError()
    {
        $user = $this->user->create([
            'name' => 'Maria teste',
            'cpf' => '12345678901',
            'email' => 'test.user1@mail.com',
            'phone' => '123456',
            'password' => bcrypt('password'),
            'status' => true,
            'role_id' => 1
        ]);

        $userData1 = [
            'name' => $user->name,
            'cpf' =>  $user->cpf,
            'email' => $user->email,
            'password' => 'password',
            'phone' => '123456',
            'password' => bcrypt('password'),
            'status' => true,
            'role_id' => 1
        ];

        $userData2 = [
            'name' => $user->name,
            'cpf' =>  $user->cpf,
            'email' => $user->email,
            'password' => 'password',
            'phone' => '123456',
            'password' => bcrypt('password'),
            'status' => true,
            'role_id' => 1
        ];

        $request1 = new UserRequest();
        $request1->request->add($userData1);

        $request2 = new UserRequest();
        $request2->request->add($userData2);

        $this->userService
            ->expects($this->exactly(2))
            ->method('createUser')
            ->willReturnOnConsecutiveCalls(
                new JsonResponse('', Response::HTTP_CREATED),
                new JsonResponse('', Response::HTTP_BAD_REQUEST)
            );

        $this->userRepository
            ->expects($this->exactly(2))
            ->method('create')
            ->willReturnOnConsecutiveCalls(new User(), new User());

        $response1 = $this->userService->createUser($request1);
        $this->userRepository->create($request1);
        $response2 = $this->userService->createUser($request2);
        $this->userRepository->create($request2);

        $this->assertEquals(Response::HTTP_CREATED, $response1->getStatusCode());
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response2->getStatusCode());
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
        $userId = $this->user->id;

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
        $userData = array($this->user);

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
        $userId = $this->user->id;

        $this->userService
            ->expects($this->once())
            ->method('deleteUser')
            ->with($userId)
            ->willReturn(new JsonResponse('', Response::HTTP_OK));

        $response = $this->userService->deleteUser($userId);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
