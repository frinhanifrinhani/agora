<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected UserService $userService;
    protected UserController $userController;
    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
        $this->userController = new UserController($this->userService);

        $this->user = User::factory()->create();

        $this->token = $this->user->createToken('token')->plainTextToken;
    }

    public function testIndexSuccess()
    {

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->get('/api/users');

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);
    }

    public function testIndexUrlNotFoundError()
    {
        User::factory()->count(5)->create();

        $response = $this->get('/api/users-url-not-found');

        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertArrayHasKey('error', $responseData);
        $this->assertEquals('A rota não foi encontrada.', $responseData['error']);
    }

    public function testShowSuccess()
    {

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->get('/api/users/' . $this->user->id);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);
    }

    public function testShowNotFoundRegisterError()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->get('/api/users/0');

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();

        $this->assertEquals('Usuário não encontrado.', $responseData['error']);
    }

    public function testStoreSuccess()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        $userData = [
            'name' => fake()->name(),
            'cpf' => $faker->cpf(false),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '619969999',
            'status' => true,
            'password' => '123456',
            'role_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/users', $userData);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('messages.saved', $responseData['success']['message']);
    }

    public function testStoreEmptyFieldsError()
    {
        $userData = [];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/users', $userData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();

        $this->assertEquals(['CPF inválido.'], $responseData['error']['cpf']);
        $this->assertEquals(['O campo Nome é obrigatório.'], $responseData['error']['name']);
        $this->assertEquals(['O campo E-mail é obrigatório.'], $responseData['error']['email']);
        $this->assertEquals(['O campo Senha é obrigatório.'], $responseData['error']['password']);
    }

    public function testStoreDuplicatedRegisterError()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        $userData = [
            'name' => fake()->name(),
            'cpf' => $faker->cpf(false),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '619969999',
            'status' => true,
            'password' => '123456',
            'role_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/users', $userData);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/users', $userData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();

        $this->assertEquals('Registro duplicado, email e/ou CPF já cadastrado(s).', $responseData['error']);
    }

    public function testStoreInvalidCpfError()
    {

        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        $userData = [
            'name' => fake()->name(),
            'cpf' => '12345678910',
            'email' => fake()->unique()->safeEmail(),
            'phone' => '619969999',
            'status' => true,
            'password' => '123456',
            'role_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/users', $userData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals(['CPF inválido.'], $responseData['error']['cpf']);
    }

    public function testUpdateSuccess()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        $userData = [
            'name' => fake()->name(),
            'cpf' =>  $faker->cpf(false),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '619969999',
            'status' => true,
            'password' => '123456',
            'role_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

        $userCreateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/users', $userData);

        $userDataUpdate = [
            'name' => fake()->name(),
            'cpf' => $userData['cpf'],
            'email' => $userData['email'],
            'phone' => '619969999',
            'status' => true,
            'password' => '123456',
            'role_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

        $response = $this->put('/api/users/' . $userCreateResponse['object']['user']['id'], $userDataUpdate);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/users/' . $userCreateResponse['object']['user']['id'], $userDataUpdate);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('messages.updated', $responseData['success']['message']);
    }

    public function testUpdateEmptyFieldsError()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        $userData = [
            'name' => fake()->name(),
            'cpf' =>  $faker->cpf(false),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '619969999',
            'status' => true,
            'password' => '123456',
            'role_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

        $userCreateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/users', $userData);

        $userDataUpdate = [];

        $response = $this->put('/api/users/' . $userCreateResponse['object']['user']['id'], $userDataUpdate);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals(['CPF inválido.'], $responseData['error']['cpf']);
        $this->assertEquals(['O campo Nome é obrigatório.'], $responseData['error']['name']);
        $this->assertEquals(['O campo E-mail é obrigatório.'], $responseData['error']['email']);
        $this->assertEquals(['O campo Senha é obrigatório.'], $responseData['error']['password']);
    }

    public function testUpdateDuplicatedRegisterError()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        $userData = [
            'name' => fake()->name(),
            'cpf' =>  $faker->cpf(false),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '619969999',
            'status' => true,
            'password' => '123456',
            'role_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

        $userData2 = [
            'name' => fake()->name(),
            'cpf' =>  $faker->cpf(false),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '619969999',
            'status' => true,
            'password' => '123456',
            'role_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];


        $userCreateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/users', $userData);

        $userCreateResponse2 = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/users', $userData2);

        $userDataUpdate = [
            'name' => fake()->name(),
            'cpf' =>  $userData['cpf'],
            'email' => $userData['email'],
            'phone' => '619969999',
            'status' => true,
            'password' => '123456',
            'role_id' => 1,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/users/' . $userCreateResponse2['object']['user']['id'], $userDataUpdate);


        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Registro duplicado, email e/ou CPF já cadastrado(s).', $responseData['error']);
    }

    public function testDeleteSuccess()
    {
        $user = User::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/users/' . $user->id);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('messages.deleted', $responseData['success']['message']);
    }
}
