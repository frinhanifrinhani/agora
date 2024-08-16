<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\News;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Services\NewsService;
use Illuminate\Http\Response;
use App\Http\Controllers\NewsController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewsControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected NewsService $NewsService;
    protected NewsController $NewsController;
    protected $user;
    protected $token;

    protected $title;
    protected $body;

    protected function setUp(): void
    {
        parent::setUp();
        $this->NewsService = $this->app->make(NewsService::class);
        $this->NewsController = new NewsController($this->NewsService);

        $this->user = User::factory()->create();

        $this->token = $this->user->createToken('token')->plainTextToken;

        $faker = \Faker\Factory::create('pt_BR');
        $this->title =  $faker->words(10, true);
        $this->body =  $faker->text(200);
    }

    public function testIndexSuccess()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->get('/api/news');

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);
    }

    public function testIndexUrlNotFoundError()
    {
        $response = $this->get('/api/news-url-not-found');

        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertArrayHasKey('error', $responseData);
        $this->assertEquals('A rota não foi encontrada.', $responseData['error']['message']);
    }

    public function testShowSuccess()
    {
        $news = News::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->get('/api/news/' . $news->id);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);
    }

    public function testShowNotFoundRegisterError()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->get('/api/news/0');

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();

        $this->assertEquals('Notícia não encontrado(a).', $responseData['error']['message']);
    }

    public function testStoreWithOutCategoriesAndWithOutTagsSuccess()
    {

        $userResponse = User::factory()->create();

        $newsData = [
            'title' => $this->title,
            'body' => $this->body,
            'open_to_comments' => true,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'user_id' => $userResponse->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/news', $newsData);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Notícia salvo(a) com sucesso.', $responseData['success']['message']);
    }

    public function testStoreWithOutCategoriesSuccess()
    {

        $userResponse = User::factory()->create();
        $tagResponse = Tag::factory()->count(3)->create();

        $newsData = [
            'title' => $this->title,
            'body' => $this->body,
            'open_to_comments' => true,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'tags' => [
                $tagResponse[0]->id,
                $tagResponse[1]->id,
                $tagResponse[2]->id
            ],
            'user_id' => $userResponse->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/news', $newsData);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Notícia salvo(a) com sucesso.', $responseData['success']['message']);
    }

    public function testStoreWithOutTagsSuccess()
    {

        $userResponse = User::factory()->create();
        $categoryResponse = Category::factory()->count(3)->create();

        $newsData = [
            'title' => $this->title,
            'body' => $this->body,
            'open_to_comments' => true,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'category' => [
                $categoryResponse[0]->id,
                $categoryResponse[1]->id,
                $categoryResponse[2]->id
            ],
            'user_id' => $userResponse->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/news', $newsData);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Notícia salvo(a) com sucesso.', $responseData['success']['message']);
    }

    public function testStoreWithTagsAndWithCategoriesSuccess()
    {

        $userResponse = User::factory()->create();
        $categoryResponse = Category::factory()->count(3)->create();
        $tagResponse = Tag::factory()->count(3)->create();

        $newsData = [
            'title' => $this->title,
            'body' => $this->body,
            'open_to_comments' => true,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'category' => [
                $categoryResponse[0]->id,
                $categoryResponse[1]->id,
                $categoryResponse[2]->id
            ],
            'tag' => [
                $tagResponse[0]->id,
                $tagResponse[1]->id,
                $tagResponse[2]->id
            ],
            'user_id' => $userResponse->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/news', $newsData);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Notícia salvo(a) com sucesso.', $responseData['success']['message']);
    }

    public function testStoreEmptyFieldsError()
    {
        $newsData = [];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/news', $newsData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();

        $this->assertEquals(['O campo Título é obrigatório.'], $responseData['error']['message']['title']);
        $this->assertEquals(['O campo Corpo da Notícia é obrigatório.'], $responseData['error']['message']['body']);
    }

    public function testStoreDuplicatedRegisterError()
    {

        $newsData = [
            'title' => $this->title,
            'body' => $this->body,
        ];

        $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/news', $newsData);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/news', $newsData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();

        $this->assertEquals('Notícia já cadastrado(a).', $responseData['error']['message']);
    }

    public function testUpdateEmptyFieldsError()
    {

        $newsData = [
            'title' => $this->title,
            'body' => $this->body,
        ];

        $newsResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/news', $newsData);

        $newsDataUpdate = [];

        $response = $this->put('/api/news/' . $newsResponse['data']['news']['id'], $newsDataUpdate);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals(['O campo Título é obrigatório.'], $responseData['error']['message']['title']);
        $this->assertEquals(['O campo Corpo da Notícia é obrigatório.'], $responseData['error']['message']['body']);
    }

    public function testUpdateDuplicatedRegisterError()
    {

        $title = $this->title;
        $titleTwo = $this->title  . ' two';

        $body = $this->body;
        $bodyTwo = $this->body. ' two';

        $newsData = [
            'title' => $title,
            'body' => $body,
        ];

        $newsData2 = [
            'title' => $titleTwo,
            'body' => $bodyTwo,
        ];

        $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/news', $newsData);

        $newsCreateResponse2 = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/news', $newsData2);

        $newsDataUpdate = [
            'title' => $this->title,
            'body' => $this->body,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/news/' . $newsCreateResponse2['data']['news']['id'], $newsDataUpdate);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Notícia já cadastrado(a).', $responseData['error']['message']);
    }

    public function testUpdateNotFoundError()
    {
        $newsData = [
            'title' => $this->title,
            'body' => $this->body,
        ];

        $newsCreateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/news', $newsData);

        $newsDataUpdate = [
            'title' => $this->title . ' updated',
            'body' => $this->body . ' updated',
        ];

        $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/news/' . $newsCreateResponse['data']['news']['id']);

        $response = $this->put('/api/news/' . $newsCreateResponse['data']['news']['id'], $newsDataUpdate);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/news/' . $newsCreateResponse['data']['news']['id'], $newsDataUpdate);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Notícia não encontrado(a).', $responseData['error']['message']);
    }

    public function testUpdateSuccess()
    {
        $newsData = [
            'title' => $this->title,
            'body' => $this->body,
        ];

        $newsCreateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/news', $newsData);

        $newsDataUpdate = [
            'title' => $this->title . ' updated',
            'body' => $this->body . ' updated',
        ];

        $response = $this->put('/api/news/' . $newsCreateResponse['data']['news']['id'], $newsDataUpdate);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/news/' . $newsCreateResponse['data']['news']['id'], $newsDataUpdate);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Notícia alterado(a) com sucesso.', $responseData['success']['message']);
    }

    public function testDeleteNotFoundError()
    {
        $news = News::factory()->create();

        $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/news/' . $news->id);
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/news/' . $news->id);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Notícia não encontrado(a).', $responseData['error']['message']);
    }

    public function testDeleteSuccess()
    {
        $news = News::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/news/' . $news->id);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Notícia excluído(a) com sucesso.', $responseData['success']['message']);
    }
}
