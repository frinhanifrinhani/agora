<?php

namespace App\Services;

use Carbon\Carbon;
use App\Helpers\MakeAlias;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\CategoryRepository;
use App\Repositories\NewsRepository;

class MigratorService
{
    use MakeAlias;

    private UserRepository $userRepository;
    private CategoryRepository $categoryRepository;
    private TagRepository $tagRepository;
    private NewsRepository $newsRepository;

    public function __construct(
        UserRepository $userRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        NewsRepository $newsRepository
    ) {
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->newsRepository = $newsRepository;
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

            DB::beginTransaction();

            $authorsData = $this->handlerAuthors($data);
            $this->saveAuthors($authorsData);

            $categoriesData = $this->handlerCategories($data);
            $this->saveCategories($categoriesData);

            $tagsData = $this->handlerTags($data);
            $this->saveTags($tagsData);

            $newsData = $this->handlerNews($data);
            $this->saveNews($newsData);


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
                        }
                    }
                }
                array_push($categoriesData, $data);
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
                $author = $this->categoryRepository->findByAttribute('alias', $data['alias']);
                echo "<br />";
                if (!$author) {
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

    private function handlerTags($data)
    {
        if (isset($data['rss']['channel']['item'])) {
            $tags = $data['rss']['channel']['item'];

            $tagsData = [];
            foreach ($tags as $tag) {

                foreach ($tag['category'] as $tagIn) {

                    if (gettype($tagIn) == 'array') {
                        if (
                            $tagIn['_domain'] == 'post_tag'
                        ) {
                            $data = [
                                'name' => $tagIn['__cdata'] ?? null,
                                'alias' => $tagIn['_nicename'] ?? null,
                            ];
                        }
                    } else {

                        if (
                            $tag['category']['_domain']  == 'post_tag'
                        ) {
                            $data = [
                                'name' => $tag['category']['__cdata'] ?? null,
                                'alias' => $tag['category']['_nicename'] ?? null,
                            ];
                        }
                    }
                }
                array_push($tagsData, $data);
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
                $author = $this->tagRepository->findByAttribute('alias', $data['alias']);
                echo "<br />";
                if (!$author) {
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

    private function handlerNews($data)
    {
        if (isset($data['rss']['channel']['item'])) {
            $newsJson = $data['rss']['channel']['item'];

            $newsData = [];
            foreach ($newsJson as $news) {

                $body = strlen($news['encoded'][1]['__cdata']) > strlen($news['encoded'][0]['__cdata']) ? $news['encoded'][1]['__cdata'] : $news['encoded'][0]['__cdata'];

                $publicated = $news['status']['__cdata'] == 'publish' ? true : false;
                $openToComments = $news['comment_status']['__cdata'] == 'open' ? true : false;

                $data = [
                    'title' =>  $news['title'],
                    'body' => $body,
                    'alias' => $news['post_name']['__cdata'],
                    'user_id' => $this->getUserIdByLogin($news['creator']['__cdata']),
                    'publication_date' => $this->dateWPToDefault($news['pubDate']),
                    'publicated'=> $publicated,
                    'open_to_comments'=> $openToComments,
                    'created_at'=>  $this->dateWPToDefault($news['post_date']['__cdata']),
                    'updated_at'=>$this->dateWPToDefault($news['post_modified']['__cdata']),

                ];

                array_push($newsData, $data);
            }
        }

        return $newsData;
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
                $news = $this->newsRepository->findByAttribute('alias', $data['alias']);
                echo "<br />";
                if (!$news) {
                    DB::beginTransaction();
                    $this->newsRepository->create($data);
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
}
