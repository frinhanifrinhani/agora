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
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->get('/api/events');

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

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->get('/api/events/' . $event->id);

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

    public function testStoreWithOutTagsAndWithOutScheduleSuccess()
    {

        $eventData = [
            'title' => $this->title,
            'body' => $this->body,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'address' => $this->address,
            'organizer' => $this->organizer,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/events', $eventData);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Evento salvo(a) com sucesso.', $responseData['success']['message']);
    }

    public function testStoreWithOutShedulesSuccess()
    {

        $tagResponse = Tag::factory()->count(3)->create();

        $eventData = [
            'title' => $this->title,
            'body' => $this->body,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'address' => $this->address,
            'organizer' => $this->organizer,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'tags' => [
                $tagResponse[0]->id,
                $tagResponse[1]->id,
                $tagResponse[2]->id
            ],
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/events', $eventData);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Evento salvo(a) com sucesso.', $responseData['success']['message']);
    }

    public function testStoreWithOutTagsSuccess()
    {

        $eventData = [
            'title' => $this->title,
            'body' => $this->body,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'address' => $this->address,
            'organizer' => $this->organizer,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'schedule' => [
                [
                    "title" => "teste",
                    "date" => "2018-11-30",
                    "time" => "12:00",
                    "description" => "teste",
                    "order" => "1"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "3"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "2"
                ]
            ],
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/events', $eventData);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Evento salvo(a) com sucesso.', $responseData['success']['message']);
    }

    public function testStoreWithTagsAndWithScheduleSuccess()
    {

        $tagResponse = Tag::factory()->count(3)->create();

        $eventData = [
            'title' => $this->title,
            'body' => $this->body,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'address' => $this->address,
            'organizer' => $this->organizer,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'schedule' => [
                [
                    "title" => "teste",
                    "date" => "2018-11-30",
                    "time" => "12:00",
                    "description" => "teste",
                    "order" => "1"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "3"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "2"
                ]
            ],
            'tags' => [
                $tagResponse[0]->id,
                $tagResponse[1]->id,
                $tagResponse[2]->id
            ],
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/events', $eventData);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();

        $this->assertNotEmpty($responseData);

        $this->assertEquals('Evento salvo(a) com sucesso.', $responseData['success']['message']);
    }

    public function testStoreEmptyFieldsError()
    {
        $eventData = [];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/events', $eventData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();

        $this->assertEquals(['O campo Título é obrigatório.'], $responseData['error']['message']['title']);
        $this->assertEquals(['O campo Evento é obrigatório.'], $responseData['error']['message']['body']);
        $this->assertEquals(['O campo Data início é obrigatório.'], $responseData['error']['message']['start_date']);
        $this->assertEquals(['O campo Hora início é obrigatório.'], $responseData['error']['message']['start_time']);
        $this->assertEquals(['O campo Data fim é obrigatório.'], $responseData['error']['message']['end_date']);
        $this->assertEquals(['O campo Hora fim é obrigatório.'], $responseData['error']['message']['end_time']);
        $this->assertEquals(['O campo Organizador é obrigatório.'], $responseData['error']['message']['organizer']);
        $this->assertEquals(['O campo Endereço é obrigatório.'], $responseData['error']['message']['address']);
    }

    public function testStoreDuplicatedRegisterError()
    {

        $tagResponse = Tag::factory()->count(3)->create();

        $eventData = [
            'title' => $this->title,
            'body' => $this->body,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'address' => $this->address,
            'organizer' => $this->organizer,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'schedule' => [
                [
                    "title" => "teste",
                    "date" => "2018-11-30",
                    "time" => "12:00",
                    "description" => "teste",
                    "order" => "1"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "3"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "2"
                ]
            ],
            'tags' => [
                $tagResponse[0]->id,
                $tagResponse[1]->id,
                $tagResponse[2]->id
            ],
        ];

        $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/events', $eventData);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/events', $eventData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();

        $this->assertEquals('Evento já cadastrado(a).', $responseData['error']['message']);
    }

    public function testUpdateEmptyFieldsError()
    {
        $tagResponse = Tag::factory()->count(3)->create();

        $eventData = [
            'title' => $this->title,
            'body' => $this->body,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'address' => $this->address,
            'organizer' => $this->organizer,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'schedule' => [
                [
                    "title" => "teste",
                    "date" => "2018-11-30",
                    "time" => "12:00",
                    "description" => "teste",
                    "order" => "1"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "3"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "2"
                ]
            ],
            'tags' => [
                $tagResponse[0]->id,
                $tagResponse[1]->id,
                $tagResponse[2]->id
            ],
        ];

        $eventResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/events', $eventData);

        $eventDataUpdate = [];

        $response = $this->put('/api/events/' . $eventResponse['data']['event']['id'], $eventDataUpdate);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals(['O campo Título é obrigatório.'], $responseData['error']['message']['title']);
        $this->assertEquals(['O campo Evento é obrigatório.'], $responseData['error']['message']['body']);
        $this->assertEquals(['O campo Data início é obrigatório.'], $responseData['error']['message']['start_date']);
        $this->assertEquals(['O campo Hora início é obrigatório.'], $responseData['error']['message']['start_time']);
        $this->assertEquals(['O campo Data fim é obrigatório.'], $responseData['error']['message']['end_date']);
        $this->assertEquals(['O campo Hora fim é obrigatório.'], $responseData['error']['message']['end_time']);
        $this->assertEquals(['O campo Organizador é obrigatório.'], $responseData['error']['message']['organizer']);
        $this->assertEquals(['O campo Endereço é obrigatório.'], $responseData['error']['message']['address']);
    }

    public function testUpdateDuplicatedRegisterError()
    {

        $title = $this->title;
        $titleTwo = $this->title  . ' two';

        $body = $this->body;
        $bodyTwo = $this->body. ' two';

        $tagResponse = Tag::factory()->count(3)->create();

        $eventData = [
            'title' => $title,
            'body' => $body,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'address' => $this->address,
            'organizer' => $this->organizer,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'schedule' => [
                [
                    "title" => "teste",
                    "date" => "2018-11-30",
                    "time" => "12:00",
                    "description" => "teste",
                    "order" => "1"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "3"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "2"
                ]
            ],
            'tags' => [
                $tagResponse[0]->id,
                $tagResponse[1]->id,
                $tagResponse[2]->id
            ],
        ];

        $eventData2 = [
            'title' => $titleTwo,
            'body' => $bodyTwo,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'address' => $this->address,
            'organizer' => $this->organizer,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'schedule' => [
                [
                    "title" => "teste",
                    "date" => "2018-11-30",
                    "time" => "12:00",
                    "description" => "teste",
                    "order" => "1"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "3"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "2"
                ]
            ],
            'tags' => [
                $tagResponse[0]->id,
                $tagResponse[1]->id,
                $tagResponse[2]->id
            ],
        ];

        $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/events', $eventData);

        $eventCreateResponse2 = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/events', $eventData2);

        $eventDataUpdate = [
            'title' => $title,
            'body' => $body,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'address' => $this->address,
            'organizer' => $this->organizer,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'schedule' => [
                [
                    "title" => "teste",
                    "date" => "2018-11-30",
                    "time" => "12:00",
                    "description" => "teste",
                    "order" => "1"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "3"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "2"
                ]
            ],
            'tags' => [
                $tagResponse[0]->id,
                $tagResponse[1]->id,
                $tagResponse[2]->id
            ],
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/events/' . $eventCreateResponse2['data']['event']['id'], $eventDataUpdate);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Evento já cadastrado(a).', $responseData['error']['message']);
    }

    public function testUpdateNotFoundError()
    {
        $title = $this->title;
        $titleTwo = $this->title  . ' two';

        $body = $this->body;
        $bodyTwo = $this->body. ' two';

        $tagResponse = Tag::factory()->count(3)->create();

        $eventData = [
            'title' => $title,
            'body' => $body,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'address' => $this->address,
            'organizer' => $this->organizer,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'schedule' => [
                [
                    "title" => "teste",
                    "date" => "2018-11-30",
                    "time" => "12:00",
                    "description" => "teste",
                    "order" => "1"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "3"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "2"
                ]
            ],
            'tags' => [
                $tagResponse[0]->id,
                $tagResponse[1]->id,
                $tagResponse[2]->id
            ],
        ];

        $eventDataUpdate = [
            'title' => $titleTwo,
            'body' => $bodyTwo,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'address' => $this->address,
            'organizer' => $this->organizer,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'schedule' => [
                [
                    "title" => "teste",
                    "date" => "2018-11-30",
                    "time" => "12:00",
                    "description" => "teste",
                    "order" => "1"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "3"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "2"
                ]
            ],
            'tags' => [
                $tagResponse[0]->id,
                $tagResponse[1]->id,
                $tagResponse[2]->id
            ],
        ];

        $eventCreateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/events', $eventData);

        $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/events/' . $eventCreateResponse['data']['event']['id']);

        $response = $this->put('/api/events/' . $eventCreateResponse['data']['event']['id'], $eventDataUpdate);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/events/' . $eventCreateResponse['data']['event']['id'], $eventDataUpdate);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Evento não encontrado(a).', $responseData['error']['message']);
    }

    public function testUpdateSuccess()
    {
        $title = $this->title;
        $titleTwo = $this->title  . ' two';

        $body = $this->body;
        $bodyTwo = $this->body. ' two';

        $tagResponse = Tag::factory()->count(3)->create();

        $eventData = [
            'title' => $title,
            'body' => $body,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'address' => $this->address,
            'organizer' => $this->organizer,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'schedule' => [
                [
                    "title" => "teste",
                    "date" => "2018-11-30",
                    "time" => "12:00",
                    "description" => "teste",
                    "order" => "1"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "3"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "2"
                ]
            ],
            'tags' => [
                $tagResponse[0]->id,
                $tagResponse[1]->id,
                $tagResponse[2]->id
            ],
        ];

        $eventDataUpdate = [
            'title' => $titleTwo,
            'body' => $bodyTwo,
            'start_date' => $this->startDate,
            'start_time' => $this->startTime,
            'end_date' => $this->endDate,
            'end_time' => $this->endTime,
            'address' => $this->address,
            'organizer' => $this->organizer,
            'publicated' => true,
            'publication_date' => date('Y-m-d H:i:s'),
            'schedule' => [
                [
                    "title" => "teste",
                    "date" => "2018-11-30",
                    "time" => "12:00",
                    "description" => "teste",
                    "order" => "1"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "3"
                ],
                [
                    "title" => "teste 2",
                    "date" => "2018-11-30",
                    "time" => "13:00",
                    "description" => "teste 2",
                    "order" => "2"
                ]
            ],
            'tags' => [
                $tagResponse[0]->id,
                $tagResponse[1]->id,
                $tagResponse[2]->id
            ],
        ];

        $eventCreateResponse = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->post('/api/events', $eventData);

        $response = $this->put('/api/events/' . $eventCreateResponse['data']['event']['id'], $eventDataUpdate);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->put('/api/events/' . $eventCreateResponse['data']['event']['id'], $eventDataUpdate);

        $response->assertStatus(Response::HTTP_CREATED);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Evento alterado(a) com sucesso.', $responseData['success']['message']);
    }

    public function testDeleteNotFoundSuccess()
    {
        $event = Event::factory()->create();

        $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/events/' . $event->id);
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/events/' . $event->id);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Evento não encontrado(a).', $responseData['error']['message']);
    }

    public function testDeleteSuccess()
    {
        $event = Event::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)->delete('/api/events/' . $event->id);

        $response->assertStatus(Response::HTTP_OK);

        $responseData = $response->json();
        $this->assertNotEmpty($responseData);

        $this->assertEquals('Evento excluído(a) com sucesso.', $responseData['success']['message']);
    }
}
