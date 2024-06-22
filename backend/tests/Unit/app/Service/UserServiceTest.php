<?php

namespace Tests\Unit\app\Http\Services;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;

class UserServiceTest extends TestCase
{
    private $userService;

    public function setUp(): void
    {

        $userModel = new User(); // assuming you have a User model
        $this->userService = new UserService(new UserRepository(Illuminate\Container\Container));

    }

    public function testCreateUserSuccess()
    {
        $request = new Request([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ]);

        $response = $this->userService->createUser($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertArrayHasKey('user', json_decode($response->getContent(), true));
    }

    public function testCreateUserInvalidData()
    {
        $request = new Request([
            'name' => '',
            'email' => '',
            'password' => '',
        ]);

        $this->expectException(ValidationException::class);

        $this->userService->createUser($request);
    }

    public function testCreateUserDuplicateEmail()
    {
        $existingUser = factory(User::class)->create(['email' => 'johndoe@example.com']);

        $request = new Request([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ]);

        $response = $this->userService->createUser($request);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertEquals('Registro duplicado, email e/ou CPF já cadastrado(s).', json_decode($response->getContent(), true)['error']);
    }

    public function testCreateUserDatabaseError()
    {
        DB::shouldReceive('beginTransaction')->andReturnNull();
        DB::shouldReceive('rollBack')->andReturnNull();

        $request = new Request([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ]);

        $this->expectException(\Exception::class);

        $this->userService->createUser($request);
    }

    public function testCreateUserInvalidPassword()
    {
        $request = new Request([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'hort',
        ]);

        $this->expectException(\Exception::class);

        $this->userService->createUser($request);
    }
}
