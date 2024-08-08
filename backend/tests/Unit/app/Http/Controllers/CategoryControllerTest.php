<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Category;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use App\Services\CategoryService;
use Illuminate\Http\Response;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected CategoryService $CategoryService;
    protected CategoryController $CategoryController;
    protected $user;
    protected $token;

    protected $title;

    protected function setUp(): void
    {
        parent::setUp();
        $this->CategoryService = $this->app->make(CategoryService::class);
        $this->CategoryController = new CategoryController($this->CategoryService);

        $this->user = User::factory()->create();

        $this->token = $this->user->createToken('token')->plainTextToken;

        $faker = \Faker\Factory::create('pt_BR');
        $this->title =  $faker->words(10, true);
    }

    public function testIndexSuccess()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->get('/api/categories');

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);
    }

    public function testIndexUrlNotFoundError()
    {
        $response = $this->get('/api/categories-url-not-found');

        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertArrayHasKey('error', $responseData);
        $this->assertEquals('A rota não foi encontrada.', $responseData['error']);
    }

    public function testShowSuccess()
    {
        $category = Category::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->get('/api/categories/' . $category->id);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);
    }

    public function testShowNotFoundRegisterError()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->get('/api/categories/0');

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();

        $this->assertEquals('Categoria não encontrado(a).', $responseData['error']['message']);
    }

    public function testStoreSuccess()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        $categoryData = [
            'name' => $this->title
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/categories', $categoryData);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Categoria salvo(a) com sucesso.', $responseData['success']['message']);
    }

    public function testStoreEmptyFieldsError()
    {
        $categoryData = [];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/categories', $categoryData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();

        $this->assertEquals(['O campo Nome é obrigatório.'], $responseData['error']['name']);
    }

    public function testStoreDuplicatedRegisterError()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        $categoryData = [
            'name' => $this->title
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/categories', $categoryData);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/categories', $categoryData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();

        $this->assertEquals('Categoria já cadastrado(a).', $responseData['error']['message']);
    }

    public function testUpdateEmptyFieldsError()
    {

        $categoryData = [
            'name' => $this->title,
        ];

        $categoryResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/categories', $categoryData);

        $categoryDataUpdate = [];

        $response = $this->put('/api/categories/' . $categoryResponse['data']['category']['id'], $categoryDataUpdate);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals(['O campo Nome é obrigatório.'], $responseData['error']['name']);
    }

    public function testUpdateSuccess()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        $categoryData = [
            'name' => $this->title,
        ];

        $categoryCreateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/categories', $categoryData);

        $categoryDataUpdate = [
            'name' => $this->title . ' updated',
        ];

        $response = $this->put('/api/categories/' . $categoryCreateResponse['data']['category']['id'], $categoryDataUpdate);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/categories/' . $categoryCreateResponse['data']['category']['id'], $categoryDataUpdate);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Categoria alterado(a) com sucesso.', $responseData['success']['message']);
    }

    public function testUpdateDuplicatedRegisterError()
    {

        $title = $this->title;
        $titleTwo = $this->title.' tow';

        $categoryData = [
            'name' => $title
        ];

        $categoryData2 = [
            'name' =>$titleTwo
        ];

        $categoryCreateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/categories', $categoryData);

        $categoryCreateResponse2 = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/categories', $categoryData2);

        $categoryDataUpdate = [
            'name' =>$title
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/categories/' . $categoryCreateResponse2['data']['category']['id'], $categoryDataUpdate);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Categoria já cadastrado(a).', $responseData['error']['message']);
    }

    public function testDeleteNotFoundSuccess()
    {
        $category = Category::factory()->create();

        $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/categories/' . $category->id);
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/categories/' . $category->id);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Categoria não encontrado(a).', $responseData['error']['message']);
    }

    public function testDeleteSuccess()
    {
        $category = Category::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/categories/' . $category->id);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Categoria excluído(a) com sucesso.', $responseData['success']['message']);
    }
}
