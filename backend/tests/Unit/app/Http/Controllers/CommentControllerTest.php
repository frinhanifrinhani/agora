<?php

namespace Tests\Feature\App\Http\Controllers;

use Tests\TestCase;
use App\Models\News;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Response;
use App\Services\CommentService;
use App\Http\Controllers\CommentController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected CommentService $CommentService;
    protected CommentController $CommentController;
    protected $user;
    protected $token;

    protected $description;

    protected function setUp(): void
    {
        parent::setUp();
        $this->CommentService = $this->app->make(CommentService::class);
        $this->CommentController = new CommentController($this->CommentService);

        $this->user = User::factory()->create();

        $this->token = $this->user->createToken('token')->plainTextToken;

        $faker = \Faker\Factory::create('pt_BR');

        $this->description =  $faker->words(10, true);
    }

    public function testStoreSuccess()
    {
        $news = News::factory()->create();

        $commentData = [
            'news_id' => $news->id,
            'description' => $this->description
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/comments', $commentData);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Comentário salvo(a) com sucesso.', $responseData['success']['message']);
    }

    public function testStoreEmptyFieldsError()
    {
        $commentData = [];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/comments', $commentData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();

        $this->assertEquals(['O campo Notícia é obrigatório.'], $responseData['error']['message']['news_id']);
        $this->assertEquals(['O campo Descrição é obrigatório.'], $responseData['error']['message']['description']);
    }

    public function testStoreDuplicatedRegisterError()
    {
        $news = News::factory()->create();

        $commentData = [
            'news_id' => $news->id,
            'description' => $this->description
        ];

        $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/comments', $commentData);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/comments', $commentData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();

        $this->assertEquals('Você já fez este comentário.', $responseData['error']['message']);
    }

    public function testUpdateEmptyFieldsError()
    {
        $news = News::factory()->create();

        $commentData = [
            'news_id' => $news->id,
            'description' => $this->description
        ];

        $commentResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/comments', $commentData);

        $commentDataUpdate = [];

        $response = $this->put('/api/comments/' . $commentResponse['data']['comment']['id'], $commentDataUpdate);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals(['O campo Notícia é obrigatório.'], $responseData['error']['message']['news_id']);
        $this->assertEquals(['O campo Descrição é obrigatório.'], $responseData['error']['message']['description']);
    }

    public function testUpdateSuccess()
    {
        $news = News::factory()->create();

        $description = $this->description;
        $descriptionUpdated = $this->description . ' updated';

        $commentData = [
            'news_id' => $news->id,
            'description' => $description
        ];

        $commentCreateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/comments', $commentData);

        $commentDataUpdate = [
            'news_id' => $news->id,
            'description' => $descriptionUpdated
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/comments/' . $commentCreateResponse['data']['comment']['id'], $commentDataUpdate);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Comentário alterado(a) com sucesso.', $responseData['success']['message']);
    }

    public function testUpdateNotFoundError()
    {
        $news = News::factory()->create();

        $description = $this->description;
        $descriptionUpdated = $this->description . ' updated';

        $commentData = [
            'news_id' => $news->id,
            'description' => $description
        ];

        $commentCreateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/comments', $commentData);

            $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->delete('/api/comments/' . $commentCreateResponse['data']['comment']['id']);

        $commentDataUpdate = [
            'news_id' => $news->id,
            'description' => $descriptionUpdated
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/comments/' . $commentCreateResponse['data']['comment']['id'], $commentDataUpdate);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Comentário não encontrado(a).', $responseData['error']['message']);
    }

    public function testUpdateDuplicatedRegisterByUserError()
    {

        $news = News::factory()->create();

        $description = $this->description;
        $descriptionUpdated = $this->description . ' updated';

        $commentData = [
            'news_id' => $news->id,
            'description' => $description
        ];

        $commentDataTwo = [
            'news_id' => $news->id,
            'description' => $descriptionUpdated
        ];

        $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/comments', $commentData);

        $commentCreateResponse2 = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/comments', $commentDataTwo);

        $commentDataUpdate = [
            'news_id' => $news->id,
            'description' => $description
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/comments/' . $commentCreateResponse2['data']['comment']['id'], $commentDataUpdate);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Você já fez este comentário.', $responseData['error']['message']);
    }

    public function testUpdateCommentOtherUserError()
    {

        $comment = Comment::factory()->create();

        $news = News::factory()->create();

        $commentData = [
            'news_id' => $news->id,
            'description' => $this->description
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/comments/' . $comment->id, $commentData);

        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Este comentário pertence a outro usuário.', $responseData['error']['message']);
    }

    public function testDeleteCommentOtherUserError()
    {

        $comment = Comment::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/comments/' . $comment->id);

        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Este comentário pertence a outro usuário.', $responseData['error']['message']);
    }

    public function testDeleteNotFoundError()
    {
        $news = News::factory()->create();

        $commentData = [
            'news_id' => $news->id,
            'description' => $this->description
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/comments', $commentData);

        $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/comments/' . $response['data']['comment']['id']);
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/comments/' . $response['data']['comment']['id']);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Comentário não encontrado(a).', $responseData['error']['message']);
    }

    public function testDeleteSuccess()
    {
        $news = News::factory()->create();

        $commentData = [
            'news_id' => $news->id,
            'description' => $this->description
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/comments', $commentData);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/comments/' . $response['data']['comment']['id']);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Comentário excluído(a) com sucesso.', $responseData['success']['message']);
    }
}
