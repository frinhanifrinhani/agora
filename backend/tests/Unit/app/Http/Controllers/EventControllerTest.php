<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Services\EventService;
use Illuminate\Http\Response;
use App\Http\Controllers\EventController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EventControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    protected EventService $EventService;
    protected EventController $EventController;
    protected $user;
    protected $token;

    protected $title;
    protected $body;
    protected $startDate;
    protected $startTime;
    protected $endDate;
    protected $endTime;
    protected $address;
    protected $organizer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->EventService = $this->app->make(EventService::class);
        $this->EventController = new EventController($this->EventService);

        $this->user = User::factory()->create();

        $this->token = $this->user->createToken('token')->plainTextToken;

        $faker = \Faker\Factory::create('pt_BR');
        $this->title =  $faker->words(10, true);
        $this->startDate = $faker->date('Y-m-d');
        $this->startTime = $faker->time('H:i:s');
        $this->endDate = $faker->date('Y-m-d');
        $this->endTime = $faker->time('H:i:s');
        $this->address = $faker->address();
        $this->body = $faker->text(200);
        $this->organizer = $faker->words(2, true);
    }

    public function testIndexSuccess()
    {

        $response = $this->get('/api/events');

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);
    }

    public function testIndexUrlNotFoundError()
    {
        $response = $this->get('/api/events-url-not-found');

        $response->assertStatus(Response::HTTP_NOT_FOUND);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertArrayHasKey('error', $responseData);
        $this->assertEquals('A rota não foi encontrada.', $responseData['error']['message']);
    }

    public function testShowSuccess()
    {
        $event = Event::factory()->create();

        $response = $this->get('/api/events/' . $event->alias);
        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);
    }

    public function testShowNotFoundRegisterError()
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->get('/api/events/0');

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();

        $this->assertEquals('Evento não encontrado(a).', $responseData['error']['message']);
    }
}
