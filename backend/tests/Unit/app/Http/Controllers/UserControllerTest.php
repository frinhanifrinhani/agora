<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    private $userController;
    private $userService;
    private $userFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->createMock(UserService::class);
        $this->userController = new UserController($this->userService);
        $this->userFactory = User::factory()->create();
    }


    public function testIndexSuccess()
    {
        $request = new Request();

        $data = $this->userFactory;

        $this->userService
            ->expects($this->once())
            ->method('getAllUsers')
            ->with($request)
            ->willReturn($data);

        $response = $this->userController->index($request);

        $this->assertEquals($data, $response);
    }

    public function testIndexExceptionError()
    {
        $request = new Request();
        $exception = new \Exception();

        $this->userService
            ->expects($this->once())
            ->method('getAllUsers')
            ->with($request)
            ->willThrowException($exception);

        $this->expectException(\Exception::class);
        $this->userController->index($request);
    }

    public function testStoreSuccess()
    {
        $request = new UserRequest();
        $userData = array($this->userFactory);
        $expectedResponse = new JsonResponse('', Response::HTTP_CREATED);

        $request->request->add($userData);

        $this->userService
            ->expects($this->once())
            ->method('createUser')
            ->with($request)
            ->willReturn($expectedResponse);

        $response = $this->userController->store($request);

        $this->assertEquals($response->getStatusCode(), Response::HTTP_CREATED);
    }

    public function testUpdateSuccess()
    {
        $request = new UserRequest();
        $userData = array($this->userFactory);
        $expectedResponse = new JsonResponse('', Response::HTTP_CREATED);

        $request->request->add($userData);

        $this->userService
            ->expects($this->once())
            ->method('updateUser')
            ->with($request)
            ->willReturn($expectedResponse);

        $response = $this->userController->update($request, $userData[0]['id']);

        $this->assertEquals($response->getStatusCode(), Response::HTTP_CREATED);
    }

    public function testShowSuccess()
    {
        $expectedResponse = new JsonResponse('', Response::HTTP_OK);

        $this->userService
            ->expects($this->once())
            ->method('getUserById')
            ->willReturn($expectedResponse);

        $response = $this->userController->show($this->userFactory->id);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }

    public function testDestroySuccess()
    {
        $expectedResponse = new JsonResponse('', Response::HTTP_OK);

        $this->userService
            ->expects($this->once())
            ->method('deleteUser')
            ->willReturn($expectedResponse);

        $response = $this->userController->destroy($this->userFactory->id);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
    }
}
