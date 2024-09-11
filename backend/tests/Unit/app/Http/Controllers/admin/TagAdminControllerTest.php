<?php

namespace Tests\Feature\App\Http\Controllers\admin;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\User;

use Illuminate\Http\Response;
use App\Services\admin\TagAdminService;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\admin\TagAdminController;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TagAdminControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected TagAdminService $tagAdminService;
    protected TagAdminController $tagAdminController;
    protected $user;
    protected $token;

    protected $title;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tagAdminService = $this->app->make(TagAdminService::class);
        $this->tagAdminController = new TagAdminController($this->tagAdminService);

        $this->user = User::factory()->create();

        $this->token = $this->user->createToken('token')->plainTextToken;

        $faker = \Faker\Factory::create('pt_BR');
        $this->title =  $faker->words(10, true);
    }

    public function testIndexSuccess()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->get('/api/admin/tags');

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);
    }

    public function testIndexUrlNotFoundError()
    {
        $response = $this->get('/api/admin/tags-url-not-found');

        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertArrayHasKey('error', $responseData);
        $this->assertEquals('A rota não foi encontrada.', $responseData['error']['message']);
    }

    public function testShowSuccess()
    {
        $tag = Tag::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->get('/api/admin/tags/' . $tag->id);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);
    }

    public function testShowNotFoundRegisterError()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->get('/api/admin/tags/0');

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();

        $this->assertEquals('Tag não encontrado(a).', $responseData['error']['message']);
    }

    public function testStoreSuccess()
    {

        $tagData = [
            'name' => $this->title
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/admin/tags', $tagData);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Tag salvo(a) com sucesso.', $responseData['success']['message']);
    }

    public function testStoreEmptyFieldsError()
    {
        $tagData = [];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/admin/tags', $tagData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();

        $this->assertEquals(['O campo Nome é obrigatório.'], $responseData['error']['message']['name']);
    }

    public function testStoreDuplicatedRegisterError()
    {
        $tagData = [
            'name' => $this->title
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/admin/tags', $tagData);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/admin/tags', $tagData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();

        $this->assertEquals('Tag já cadastrado(a).', $responseData['error']['message']);
    }

    public function testUpdateEmptyFieldsError()
    {
        $tagData = [
            'name' => $this->title,
        ];

        $tagResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/admin/tags', $tagData);

        $tagDataUpdate = [];

        $response = $this->put('/api/admin/tags/' . $tagResponse['data']['tag']['id'], $tagDataUpdate);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals(['O campo Nome é obrigatório.'], $responseData['error']['message']['name']);
    }

    public function testUpdateSuccess()
    {

        $tagData = [
            'name' => $this->title,
        ];

        $tagCreateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/admin/tags', $tagData);

        $tagDataUpdate = [
            'name' => $this->title . ' updated',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/admin/tags/' . $tagCreateResponse['data']['tag']['id'], $tagDataUpdate);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Tag alterado(a) com sucesso.', $responseData['success']['message']);
    }

    public function testUpdateDuplicatedRegisterError()
    {

        $title = $this->title;
        $titleTwo = $this->title.' tow';

        $tagData = [
            'name' => $title
        ];

        $tagData2 = [
            'name' =>$titleTwo
        ];

        $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/admin/tags', $tagData);

        $tagCreateResponse2 = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/admin/tags', $tagData2);

        $tagDataUpdate = [
            'name' =>$title
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/admin/tags/' . $tagCreateResponse2['data']['tag']['id'], $tagDataUpdate);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Tag já cadastrado(a).', $responseData['error']['message']);
    }

    public function testDeleteNotFoundError()
    {
        $tag = Tag::factory()->create();

        $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/admin/tags/' . $tag->id);
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/admin/tags/' . $tag->id);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Tag não encontrado(a).', $responseData['error']['message']);
    }

    public function testDeleteSuccess()
    {
        $tag = Tag::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/admin/tags/' . $tag->id);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Tag excluído(a) com sucesso.', $responseData['success']['message']);
    }
}
