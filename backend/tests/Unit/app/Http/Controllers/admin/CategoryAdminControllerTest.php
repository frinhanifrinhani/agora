<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Response;
use App\Services\admin\CategoryAdminService;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\admin\CategoryAdminController;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoryAdminControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected CategoryAdminService $categoryAdminService;
    protected CategoryAdminController $categoryAdminController;
    protected $user;
    protected $token;

    protected $title;

    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryAdminService = $this->app->make(CategoryAdminService::class);
        $this->categoryAdminController = new CategoryAdminController($this->categoryAdminService);

        $this->user = User::factory()->create();

        $this->token = $this->user->createToken('token')->plainTextToken;

        $faker = \Faker\Factory::create('pt_BR');
        $this->title =  $faker->words(10, true);
    }

    public function testIndexSuccess()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->get('/api/admin/categories');

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);
    }

    public function testIndexUrlNotFoundError()
    {
        $response = $this->get('/api/admin/categories-url-not-found');

        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertArrayHasKey('error', $responseData);
        $this->assertEquals('A rota não foi encontrada.', $responseData['error']['message']);
    }

    public function testShowSuccess()
    {
        $category = Category::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->get('/api/admin/categories/' . $category->id);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);
    }

    public function testShowNotFoundRegisterError()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->get('/api/admin/categories/0');

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
            ->post('/api/admin/categories', $categoryData);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Categoria salvo(a) com sucesso.', $responseData['success']['message']);
    }

    public function testStoreEmptyFieldsError()
    {
        $categoryData = [];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/admin/categories', $categoryData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();

        $this->assertEquals(['O campo Nome é obrigatório.'], $responseData['error']['message']['name']);
    }

    public function testStoreDuplicatedRegisterError()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        $categoryData = [
            'name' => $this->title
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/admin/categories', $categoryData);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/admin/categories', $categoryData);

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
            ->post('/api/admin/categories', $categoryData);

        $categoryDataUpdate = [];

        $response = $this->put('/api/admin/categories/' . $categoryResponse['data']['category']['id'], $categoryDataUpdate);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals(['O campo Nome é obrigatório.'], $responseData['error']['message']['name']);
    }

    public function testUpdateSuccess()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));

        $categoryData = [
            'name' => $this->title,
        ];

        $categoryCreateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/admin/categories', $categoryData);

        $categoryDataUpdate = [
            'name' => $this->title . ' updated',
        ];

        $response = $this->put('/api/admin/categories/' . $categoryCreateResponse['data']['category']['id'], $categoryDataUpdate);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/admin/categories/' . $categoryCreateResponse['data']['category']['id'], $categoryDataUpdate);

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
            ->post('/api/admin/categories', $categoryData);

        $categoryCreateResponse2 = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/admin/categories', $categoryData2);

        $categoryDataUpdate = [
            'name' =>$title
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/admin/categories/' . $categoryCreateResponse2['data']['category']['id'], $categoryDataUpdate);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Categoria já cadastrado(a).', $responseData['error']['message']);
    }

    public function testDeleteNotFoundError()
    {
        $category = Category::factory()->create();

        $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/admin/categories/' . $category->id);
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/admin/categories/' . $category->id);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Categoria não encontrado(a).', $responseData['error']['message']);
    }

    public function testDeleteSuccess()
    {
        $category = Category::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/admin/categories/' . $category->id);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Categoria excluído(a) com sucesso.', $responseData['success']['message']);
    }
}
