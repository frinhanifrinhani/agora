<?php

namespace App\Services;

use Carbon\Carbon;
use App\Helpers\MakeAlias;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\TagRepository;
use App\Repositories\FileRepository;
use App\Repositories\NewsRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\EventRepository;
use App\Services\EventScheduleService;
use Illuminate\Support\Facades\Storage;
use App\Repositories\CategoryRepository;
use App\Repositories\filesNewsRepository;

class MigratorService
{
    use MakeAlias;

    private UserRepository $userRepository;
    private CategoryRepository $categoryRepository;
    private TagRepository $tagRepository;
    private NewsRepository $newsRepository;
    private EventRepository $eventRepository;
    private EventScheduleService $eventScheduleService;

    private FileRepository $fileRepository;
    private filesNewsRepository $filesNewsRepository;

    public function __construct(
        UserRepository $userRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        NewsRepository $newsRepository,
        EventRepository $eventRepository,
        FileRepository $fileRepository,
        filesNewsRepository $filesNewsRepository,
        EventScheduleService $eventScheduleService,
    ) {
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->newsRepository = $newsRepository;
        $this->eventRepository = $eventRepository;
        $this->fileRepository = $fileRepository;
        $this->filesNewsRepository = $filesNewsRepository;
        $this->eventScheduleService = $eventScheduleService;
    }

    public function migrateNews()
    {
        echo "==========================================";
        echo "<br />";
        echo "INICIANDO MIGRADOR DE NOTÍCIAS";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
        echo "<br />";
        echo "<br />";

        try {
            $json = Storage::get('migrator/posts.json');
            $data = json_decode($json, true);

            $imagesJson = Storage::get('migrator/temp_images.json');
            $imagesData = json_decode($imagesJson, true);

            DB::beginTransaction();

            $authorsData = $this->handlerAuthors($data);
            $this->saveAuthors($authorsData);

            $categoriesData = $this->handlerCategories($data);
            $this->saveCategories($categoriesData);

            $tagsData = $this->handlerTags($data,'post_tag');
            $this->saveTags($tagsData);

            $newsData = $this->handlerNews($data);
            $this->saveNews($newsData);

            $this->saveImages($this->handlerImages($imagesData));

            DB::commit();
        } catch (\Exception $e) {

            return response()->json(
                [
                    'error' => [$e->getMessage()]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
        echo "<br />";
        echo "==========================================";
        echo "<br />";
        echo "MIGRAÇÃO FINALIZADA COM SUCESSO";
        echo "<br />";
        echo "==========================================";
    }

    public function migrateEvent()
    {

        echo "==========================================";
        echo "<br />";
        echo "INICIANDO MIGRADOR DE EVENTOS";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
        echo "<br />";
        echo "<br />";

        try {
            $json = Storage::get('migrator/paginas.json');
            $data = json_decode($json, true);

            DB::beginTransaction();

            $authorsData = $this->handlerAuthors($data);
            $this->saveAuthors($authorsData);

            $tagsData = $this->handlerTags($data,'event_tags');
            $this->saveTags($tagsData);

            $eventData = $this->handlerEvent($data);
            $this->saveEvent($eventData);

            $imagesData = $this->handlerImages($data);
            $this->saveImages($imagesData);

            DB::commit();
        } catch (\Exception $e) {

            return response()->json(
                [
                    'error' => [$e->getMessage()]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
        echo "<br />";
        echo "==========================================";
        echo "<br />";
        echo "MIGRAÇÃO FINALIZADA COM SUCESSO";
        echo "<br />";
        echo "==========================================";
    }

    private function handlerAuthors($data)
    {
        if (isset($data['rss']['channel']['author'])) {
            $authors = $data['rss']['channel']['author'];

            $authorsData = [];
            foreach ($authors as $author) {

                $rand = str_pad(rand(0, 99999999999), 11, '0', STR_PAD_LEFT);

                $data = [
                    'name' => $author['author_first_name']['__cdata'] . ' ' . $author['author_last_name']['__cdata'] ?? null,
                    'login' => $author['author_login']['__cdata'] ?? null,
                    'cpf' => $rand,
                    'email' => $author['author_email']['__cdata'] ?? null,
                    'password' => bcrypt($rand),
                    'status' => true,
                    'role_id' => 3
                ];

                array_push($authorsData, $data);
            }

            return $authorsData;
        }
    }

    private function saveAuthors($arrayData)
    {

        echo "==========================================";
        echo "<br />";
        echo "INICIANDO MIGRAÇÃO DE AUTORES";
        echo "<br />";

        try {

            foreach ($arrayData as $data) {

                $author = $this->userRepository->findByAttribute('name', $data['name']);

                echo "<br />";
                if (!$author) {
                    DB::beginTransaction();
                    echo $this->userRepository->create($data);
                    DB::commit();
                } else {
                    echo "O Autor <b>" . $data['name'] . "</b> já se econtra cadastrado";
                }
            }

            echo "<br />";
            echo "<br />";
            echo "Autores migrados com sucesso";
            echo "<br />";
            echo "<br />";
        } catch (\Exception $e) {
            echo "<br />";
            echo "<br />";
            echo "Erro: " . 'Autores ' . $e;
            echo "<br />";
            echo "<br />";
        }

        echo "FINALIZADA MIGRAÇÃO DE AUTORES";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
    }

    private function handlerCategories($data)
    {
        if (isset($data['rss']['channel']['item'])) {
            $categories = $data['rss']['channel']['item'];

            $categoriesData = [];
            foreach ($categories as $category) {

                foreach ($category['category'] as $categoryIn) {

                    if (gettype($categoryIn) == 'array') {
                        if (
                            $categoryIn['_domain'] == 'category'
                            && $categoryIn['_nicename'] != 'nao-categorizado'
                            && $categoryIn['_nicename'] != 'uncategorized'
                        ) {
                            $data = [
                                'name' => $categoryIn['__cdata'] ?? null,
                                'alias' => $categoryIn['_nicename'] ?? null,
                                'status' => true,
                            ];

                            array_push($categoriesData, $data);
                        }
                    } else {

                        if (
                            $category['category']['_domain']  == 'category'
                            && $category['category']['_nicename'] != 'nao-categorizado'
                            && $category['category']['_nicename'] != 'uncategorized'
                        ) {
                            $data = [
                                'name' => $category['category']['__cdata'] ?? null,
                                'alias' => $category['category']['_nicename'] ?? null,
                                'status' => true,
                            ];

                            array_push($categoriesData, $data);
                        }
                    }
                }
            }

            return $categoriesData;
        }
    }

    private function saveCategories($arrayData)
    {
        echo "<br />";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
        echo "INICIANDO MIGRAÇÃO DE CATEGORIAS";
        echo "<br />";

        try {

            foreach ($arrayData as $data) {
                $category = $this->categoryRepository->findByAttribute('alias', $data['alias']);
                echo "<br />";
                if (!$category) {
                    DB::beginTransaction();
                    echo $this->categoryRepository->create($data);
                    DB::commit();
                } else {
                    echo "A Categoria <b>" . $data['name'] . "</b> já se econtra cadastrada";
                }
            }

            echo "<br />";
            echo "<br />";
            echo "Categorias migradas com sucesso";
            echo "<br />";
            echo "<br />";
        } catch (\Exception $e) {
            echo "<br />";
            echo "<br />";
            echo "Erro: " . 'Categorias ' . $e;
            echo "<br />";
            echo "<br />";
        }

        echo "FINALIZADA MIGRAÇÃO DE CATEGORIAS";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
    }

    private function handlerTags($data,$type)
    {
        if (isset($data['rss']['channel']['item'])) {
            $tags = $data['rss']['channel']['item'];
            $tagsData = [];
            $arrayTag = [];
            foreach ($tags as $tag) {

                foreach ($tag['category'] as $tagIn) {

                    if (gettype($tagIn) == 'array') {
                        if ($tagIn['_domain'] == $type) {
                            $arrayTag = [
                                'name' => $tagIn['__cdata'] ?? null,
                                'alias' => $tagIn['_nicename'] ?? null,
                            ];

                            array_push($tagsData, $arrayTag);
                        }
                    } else {

                        if ($tag['category']['_domain']  == 'post_tag') {
                            $arrayTag = [
                                'name' => $tag['category']['__cdata'] ?? null,
                                'alias' => $tag['category']['_nicename'] ?? null,
                            ];
                            array_push($tagsData, $arrayTag);
                        }
                    }
                }
            }

            return $tagsData;
        }
    }

    private function saveTags($arrayData)
    {
        echo "<br />";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
        echo "INICIANDO MIGRAÇÃO DE TAGS";
        echo "<br />";

        try {

            foreach ($arrayData as $data) {

                $tag = $this->tagRepository->findByAttribute('alias', $data['alias']);
                echo "<br />";
                if (!$tag) {
                    DB::beginTransaction();
                    echo $this->tagRepository->create($data);
                    DB::commit();
                } else {
                    echo "A Tag <b>" . $data['name'] . "</b> já se econtra cadastrada";
                }
            }

            echo "<br />";
            echo "<br />";
            echo "Tags migradas com sucesso";
            echo "<br />";
            echo "<br />";
        } catch (\Exception $e) {
            echo "<br />";
            echo "<br />";
            echo "Erro: " . 'Tags ' . $e;
            echo "<br />";
            echo "<br />";
        }

        echo "FINALIZADA MIGRAÇÃO DE TAGS";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
    }

    private function handlerImages($data)
    {
        if (isset($data)) {
            $basePath = 'images/';
            $fileInfoList = [];

            foreach ($data as $item) {
                if (isset($item['images']) && !is_null($item['images'])) {
                    $imgPath = $basePath . $item['img'][0];

                    if (File::exists($imgPath)) {
                        $fileInfo = [
                            'name' => pathinfo($imgPath, PATHINFO_FILENAME),
                            'path' => $basePath,
                            'full_path' => $imgPath,
                            'type' => File::mimeType($imgPath),
                            'size' => File::size($imgPath),
                            'extension' => pathinfo($imgPath, PATHINFO_EXTENSION),
                            'title' => isset($item['titles'][0]) ? $item['titles'][0] : null,
                        ];

                        $fileInfoList[] = $fileInfo;
                    }
                }
            }

            return $fileInfoList;
        } 
    }

    private function saveImages($arrayData)
    {
        echo "<br />";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
        echo "INICIANDO MIGRAÇÃO DE IMAGENS";
        echo "<br />";

        try {
            foreach ($arrayData as $data) {
                
                $title = '';

                switch ($data['title']) {
                    case 'Parceria entre Fiocruz e FCT é reconhecida como “investimento transformador” pela CEPAL':
                        break;
                        
                    case 'Pesquisa sobre o Sistema Nacional de Auditoria: “teremos condições de realizar um planejamento efetivo das ações”':
                        break;
                    
                    case '“Uma atuação da estratégia da Fiocruz para a Agenda 2030 no território”':
                        break;

                    case 'Cúpula Climática COP28: urgência para ação global com foco na equidade – considerações sobre saúde e papel do Brasil, por Danielly Magalhães, Luiz Augusto Galvão, Paulo Buss e Mário Moreira':
                        break;

                    case 'Fiocruz Brasília lança Painel Interativo – Banco de Soluções':
                        break;

                    case '“Rotas críticas: Feminicídio” é tema de palestra na Semana Uma Só Saúde':
                        break;
                        
                    case '“A Saúde no Brasil em 2030”: livro alcança mais de 300 mil downloads':
                        break;

                    case 'O que pensamos ou sentimos quando falamos a palavra “gênero”?':
                        break;
                        
                    case 'Programa Mais Médicos – como sustentar um programa que contribui para a cobertura universal?':
                        break;
                        
                    default:
                        $title = self::normalizeText($data['title']);
                        break;
                }

                $news = $this->newsRepository->findByTitle($title ? $title : $data['title']);

                echo "<br />";

                DB::beginTransaction();
                $file = $this->fileRepository->storeFile($data);
                DB::commit();

                DB::beginTransaction();
                echo $this->filesNewsRepository->storeFilesNews($news->id, $file->id);
                DB::commit();
            }

            echo "<br />";
            echo "<br />";
            echo "Imagens migradas com sucesso";
            echo "<br />";
            echo "<br />";
        } catch (\Exception $e) {
            echo "<br />";
            echo "<br />";
            echo "Erro: " . 'Images ' . $e;
            echo "<br />";
            echo "<br />";
        }

        echo "FINALIZADA MIGRAÇÃO DE IMAGENS";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
    }

    private function normalizeText($text) {
        return str_replace(
            ['“', '”', '‘', '’', '–', '—'],
            ['"', '"', "'", "'", '-', '-'],
            $text
        );
    }

    private function handlerNews($data)
    {
        if (isset($data['rss']['channel']['item'])) {
            $newsJson = $data['rss']['channel']['item'];

            $newsData = [];

            foreach ($newsJson as $news) {

                $body = strlen($news['encoded'][1]['__cdata']) > strlen($news['encoded'][0]['__cdata']) ? $news['encoded'][1]['__cdata'] : $news['encoded'][0]['__cdata'];

                $publicated = $news['status']['__cdata'] == 'publish' ? true : false;
                $openToComments = $news['comment_status']['__cdata'] == 'open' ? true : false;

                $categoriesToAdd = [];
                if (isset($news['category']['_domain'])) {

                    if (
                        $news['category']['_domain'] == 'category'
                        && $news['category']['_nicename'] != 'nao-categorizado'
                        && $news['category']['_nicename'] != 'uncategorized'
                    ) {
                        $catetoryResponse = $this->categoryRepository->findByAttribute('alias', $news['category']['_nicename']);
                        if ($catetoryResponse) {
                            array_push($categoriesToAdd, $catetoryResponse->id);
                        }
                    }
                } else {

                    foreach ($news['category'] as $categories) {

                        if (
                            $categories['_domain'] == 'category'
                            && $categories['_nicename'] != 'uncategorized'
                            && $categories['_nicename'] != 'nao-categorizado'
                        ) {

                            $catetoryResponse = $this->categoryRepository->findByAttribute('alias', $categories['_nicename']);
                            if ($catetoryResponse) {
                                array_push($categoriesToAdd, $catetoryResponse->id);
                            }
                        }
                    }
                }

                $tagsToAdd = [];
                if (isset($news['category']['_domain'])) {

                    if ($news['category']['_domain'] == 'post_tag') {
                        $tagResponse = $this->tagRepository->findByAttribute('alias', $news['post_tag']['_nicename']);
                        if ($tagResponse) {
                            array_push($tagsToAdd, $tagResponse->id);
                        }
                    }
                } else {

                    foreach ($news['category'] as $tags) {

                        if ($tags['_domain'] == 'post_tag') {

                            $tagResponse = $this->tagRepository->findByAttribute('alias', $tags['_nicename']);
                            if ($tagResponse) {
                                array_push($tagsToAdd, $tagResponse->id);
                            }
                        }
                    }
                }

                $data = [
                    'title' =>  $news['title'],
                    'body' => $body,
                    'alias' => $news['post_name']['__cdata'],
                    'user_id' => $this->getUserIdByLogin($news['creator']['__cdata']),
                    'publication_date' => $this->dateWPToDefault($news['pubDate']),
                    'publicated' => $publicated,
                    'open_to_comments' => $openToComments,
                    'categories' =>  $categoriesToAdd,
                    'tags' => $tagsToAdd,
                    'created_at' =>  $this->dateWPToDefault($news['post_date']['__cdata']),
                    'updated_at' => $this->dateWPToDefault($news['post_modified']['__cdata']),

                ];

                array_push($newsData, $data);
            }
        }

        return $newsData;
    }

    private function handlerEvent($data)
    {
        if (isset($data['rss']['channel']['item'])) {
            $eventJson = $data['rss']['channel']['item'];

            $eventData = [];

            foreach ($eventJson as $event) {

                $body = strlen($event['encoded'][1]['__cdata']) > strlen($event['encoded'][0]['__cdata']) ? $event['encoded'][1]['__cdata'] : $event['encoded'][0]['__cdata'];

                $publicated = $event['status']['__cdata'] == 'publish' ? true : false;

                $collection = collect($event['postmeta']);
                $getMetaValue = function ($key) use ($collection) {
                    return $collection->firstWhere('meta_key.__cdata', $key)['meta_value']['__cdata'] ?? null;
                };

                $organizers = array_filter($event['category'], function ($item) {
                    return $item['_domain'] === 'organizer';
                });

                $organizerCdataValues = array_map(function ($item) {
                    return $item['__cdata'];
                }, $organizers);

                $organizersToSave = implode(', ', $organizerCdataValues);


                $location = array_filter($event['category'], function ($item) {
                    return $item['_domain'] === 'location';
                });

                $locationCdataValues = array_map(function ($item) {
                    return $item['__cdata'];
                }, $location);

                $locationToSave = implode(', ', $locationCdataValues);

                $locationNiceNameValues = array_map(function ($item) {
                    return $item['_nicename'];
                }, $location);

                $locationNiceNameToSave = implode(', ', $locationNiceNameValues);

                $serializedArrayEventSchedule = $getMetaValue('event_schedule');

                $unserializedArrayEventSchedule = unserialize($serializedArrayEventSchedule);

                $eventSchedules = json_encode($unserializedArrayEventSchedule, JSON_PRETTY_PRINT);

                $schedules = json_decode($eventSchedules);

                $sheduleData = [];

                if (!empty($schedules) && count($schedules) > 0) {

                    foreach ($schedules as  $schedule) {

                        $dataSchedule = [
                            'title' => $schedule->title,
                            'date' => $schedule->event_schedule_date,
                            'time' => $schedule->event_schedule_time,
                            'description' => $schedule->event_schedule_description,
                        ];

                        array_push($sheduleData, $dataSchedule);
                    }
                }

                $tagsToAdd = [];

                foreach ($event['category'] as $tags) {

                    if ($tags['_domain'] == 'event_tags') {

                        $tagResponse = $this->tagRepository->findByAttribute('alias', $tags['_nicename']);
                        if ($tagResponse) {
                            array_push($tagsToAdd, $tagResponse->id);
                        }
                    }
                }

                $data = [
                    'user_id' => $this->getUserIdByLogin($event['creator']['__cdata']),
                    'title' =>  $event['title'],
                    'body' => $body,
                    'alias' => $event['post_name']['__cdata'],
                    'publicated' => $publicated,
                    'publication_date' => $this->dateWPToDefault($event['pubDate']),
                    'start_date' => $getMetaValue('event_start_date'),
                    'start_time' => $getMetaValue('event_start_time'),
                    'end_date' => $getMetaValue('event_end_date'),
                    'end_time' =>  $getMetaValue('event_end_time'),
                    'organizer' => $organizersToSave,
                    //'ddd'=> '',
                    'phone' => $getMetaValue('event_phone'),
                    'email' => $getMetaValue('event_email'),
                    'address' => $getMetaValue('event_detailed_address'),
                    'location' => $locationToSave,
                    'location_alias' => $locationNiceNameToSave,
                    'venue' => $getMetaValue('event_venue'),
                    'sidebar_button_link' => $getMetaValue('event_extra_sidebar_button_link'),
                    'created_at' =>  $this->dateWPToDefault($event['post_date']['__cdata']),
                    'updated_at' => $this->dateWPToDefault($event['post_modified']['__cdata']),
                    'schedule' => [
                        $sheduleData
                    ],
                    'tags' => $tagsToAdd
                ];

                array_push($eventData, $data);
            }
        }

        return $eventData;
    }

    private function dateWPToDefault($date)
    {
        $date = Carbon::parse($date);

        $formattedDate = $date->format('Y-m-d H:i:s.u');

        return $formattedDate;
    }

    private function getUserIdByLogin($login)
    {
        $creator = $this->userRepository->findByAttribute('login', $login);
        return $creator->id;
    }

    private function saveNews($arrayData)
    {
        echo "<br />";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
        echo "INICIANDO MIGRAÇÃO DE NOTÍCIAS";
        echo "<br />";

        try {

            foreach ($arrayData as $data) {
                $news = $this->newsRepository->findByAttribute('alias', $data['alias']); //->firstOrFail();
                echo "<br />";
                if (!$news) {
                    DB::beginTransaction();
                    $newsResponse = $this->newsRepository->create($data);
                    $newsResponse->category()->sync($data['categories']);
                    $newsResponse->tag()->sync($data['tags']);
                    echo $data['title'];
                    DB::commit();
                } else {
                    echo "A Notícia <b>" . $data['title'] . "</b> já se econtra cadastrada";
                }
            }

            echo "<br />";
            echo "<br />";
            echo "Notícas migradas com sucesso";
            echo "<br />";
            echo "<br />";
        } catch (\Exception $e) {
            echo "<br />";
            echo "<br />";
            echo "Erro: " . 'Notícias ' . $e;
            echo "<br />";
            echo "<br />";
        }

        echo "FINALIZADA MIGRAÇÃO DE NOTÍCAS";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
    }

    private function saveEvent($arrayData)
    {
        echo "<br />";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
        echo "INICIANDO MIGRAÇÃO DE EVENTOS";
        echo "<br />";

        try {

            foreach ($arrayData as $data) {
                $event = $this->eventRepository->findByAttribute('alias', $data['alias']); //->firstOrFail();
                echo "<br />";
                if (!$event) {
                    DB::beginTransaction();
                    $eventResponse = $this->eventRepository->create($data);
                    $this->eventScheduleService->createEventSchedule($data['schedule'][0], $eventResponse->id);
                    $eventResponse->tag()->sync($data['tags']);
                    echo $data['title'];
                    DB::commit();
                } else {
                    echo "O Evento <b>" . $data['title'] . "</b> já se econtra cadastrada";
                }
            }

            echo "<br />";
            echo "<br />";
            echo "Notícas migradas com sucesso";
            echo "<br />";
            echo "<br />";
        } catch (\Exception $e) {
            echo "<br />";
            echo "<br />";
            echo "Erro: " . 'Evento ' . $e;
            echo "<br />";
            echo "<br />";
        }

        echo "FINALIZADA MIGRAÇÃO DE NOTÍCAS";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
    }
}
