<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use App\Models\News;
use App\Models\User;
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
        $response = $this->get('/api/news');

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

    public function testNewsByAliasSuccess()
    {
        $news = News::factory()->create();

        $response = $response = $this->get('/api/news/'.$news->alias);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);
    }

    public function testNewsByAliasNotFoundRegisterError()
    {
        $response = $this->get('/api/news/0');

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();

        $this->assertEquals('Notícia não encontrado(a).', $responseData['error']['message']);
    }
}
