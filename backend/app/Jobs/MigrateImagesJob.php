<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Helpers\MakeAlias;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use App\Helpers\ImagesMigrator;
use Illuminate\Support\Facades\DB;
use App\Repositories\TagRepository;
use Illuminate\Support\Facades\Log;
use App\Repositories\FileRepository;
use App\Repositories\NewsRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Expr\Cast\Array_;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Repositories\CategoryRepository;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\filesNewsRepository;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\JobCompletedNotification;

class MigrateImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    // public $jobId;
    
    // public $userRepository;
    // /* private $categoryRepository;
    // private $tagRepository; */
    // public $newsRepository;
    // public $fileRepository;
    // public $filesNewsRepository;

    // public function __construct(
    //     /* UserRepository $userRepository,
    //     CategoryRepository $categoryRepository,
    //     TagRepository $tagRepository,
    //     NewsRepository $newsRepository,
    //     FileRepository $fileRepository,
    //     FilesNewsRepository $filesNewsRepository */
    // ) {
    //     /* $this->userRepository = $userRepository;
    //     $this->categoryRepository = $categoryRepository;
    //     $this->tagRepository = $tagRepository;
    //     $this->newsRepository = $newsRepository;
    //     $this->fileRepository = $fileRepository;
    //     $this->filesNewsRepository = $filesNewsRepository; */
    //     //$this->jobId = DB::table('jobs')->latest('id')->first()->id;
    // }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Iniciando migração de imagens...');
        
        $userRepository = app(UserRepository::class);
        $categoryRepository = app(CategoryRepository::class);
        $tagRepository = app(TagRepository::class);
        $newsRepository = app(NewsRepository::class);
        $fileRepository = app(FileRepository::class);
        $filesNewsRepository = app(FilesNewsRepository::class);
        
        $json = Storage::get('migrator/posts.json');
        $data = json_decode($json, true);

        $migrator = new ImagesMigrator();
        $migrator->executeCrowler();
        
        $imagesJson = Storage::get('migrator/temp_images.json');
        $imagesData = json_decode($imagesJson, true);

        DB::beginTransaction();

        $authorsData = $this->handlerAuthors($data, $userRepository);
        $this->saveAuthors($authorsData, $userRepository);

        $categoriesData = $this->handlerCategories($data, $categoryRepository);
        $this->saveCategories($categoriesData, $categoryRepository);

        $tagsData = $this->handlerTags($data, $tagRepository);
        $this->saveTags($tagsData, $tagRepository);

        $newsData = $this->handlerNews($data, $categoryRepository, $tagRepository, $userRepository);
        $this->saveNews($newsData, $newsRepository);
        
        $this->addImagesToJson($data, $imagesData);
        $this->saveImages($this->handlerImages($imagesData), $fileRepository, $filesNewsRepository, $newsRepository);

        DB::commit();

        //Storage::put('migrator/posts.json', json_encode($data, JSON_PRETTY_PRINT));

        $user = User::find(1);
        $user->notify(new JobCompletedNotification());
        
        Log::info('Migração de imagens concluída.');
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

    private function saveAuthors($arrayData, $userRepository)
    {

        echo "==========================================";
        echo "<br />";
        echo "INICIANDO MIGRAÇÃO DE AUTORES";
        echo "<br />";

        try {

            foreach ($arrayData as $data) {

                $author = $userRepository->findByAttribute('name', $data['name']);

                echo "<br />";
                if (!$author) {
                    DB::beginTransaction();
                    echo $userRepository->create($data);
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

    private function saveCategories($arrayData, $categoryRepository)
    {
        echo "<br />";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
        echo "INICIANDO MIGRAÇÃO DE CATEGORIAS";
        echo "<br />";

        try {

            foreach ($arrayData as $data) {
                $category = $categoryRepository->findByAttribute('alias', $data['alias']);
                echo "<br />";
                if (!$category) {
                    DB::beginTransaction();
                    echo $categoryRepository->create($data);
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
            $arrayTag = [];
            foreach ($tags as $tag) {

                foreach ($tag['category'] as $tagIn) {

                    if (gettype($tagIn) == 'array') {
                        if ($tagIn['_domain'] == 'post_tag') {
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

    private function saveTags($arrayData, $tagRepository)
    {
        echo "<br />";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
        echo "INICIANDO MIGRAÇÃO DE TAGS";
        echo "<br />";

        try {

            foreach ($arrayData as $data) {

                $tag = $tagRepository->findByAttribute('alias', $data['alias']);
                echo "<br />";
                if (!$tag) {
                    DB::beginTransaction();
                    echo $tagRepository->create($data);
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

    private function addImagesToJson(&$data, $imagesData)
    {
        if (isset($data['rss']['channel']['item'])) {
            $items = &$data['rss']['channel']['item'];

            foreach ($items as &$item) {
                foreach ($imagesData as $imageData) {
                    if (isset($item['titles']) && $item['titles'] === $imageData['titles']) {
                        $item['img'] = 'images/' . basename($imageData['images']);
                    }
                }
            }
        }
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

    private function saveImages($arrayData, $fileRepository, $filesNewsRepository, $newsRepository)
    {
        echo "<br />";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
        echo "INICIANDO MIGRAÇÃO DE IMAGENS";
        echo "<br />";

        try {
            foreach ($arrayData as $data) {
                $news = $newsRepository->findByTitle($data['title']);
                Log::info($news);
                echo "<br />";

                DB::beginTransaction();
                $file = $fileRepository->storeFile($data);
                DB::commit();
                Log::info($file);
                DB::beginTransaction();
                echo $filesNewsRepository->storeFilesNews($news->id, $file->id);
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
            echo "Erro: " . 'Tags ' . $e;
            echo "<br />";
            echo "<br />";
        }

        echo "FINALIZADA MIGRAÇÃO DE IMAGENS";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
    }

    private function handlerNews($data, $categoryRepository, $tagRepository, $userRepository)
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
                        $catetoryResponse = $categoryRepository->findByAttribute('alias', $news['category']['_nicename']);
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

                            $catetoryResponse = $categoryRepository->findByAttribute('alias', $categories['_nicename']);
                            if ($catetoryResponse) {
                                array_push($categoriesToAdd, $catetoryResponse->id);
                            }
                        }
                    }
                }

                $tagsToAdd = [];
                if (isset($news['category']['_domain'])) {

                    if ($news['category']['_domain'] == 'post_tag') {
                        $tagResponse = $tagRepository->findByAttribute('alias', $news['post_tag']['_nicename']);
                        if ($tagResponse) {
                            array_push($tagsToAdd, $tagResponse->id);
                        }
                    }
                } else {

                    foreach ($news['category'] as $tags) {

                        if ($tags['_domain'] == 'post_tag') {

                            $tagResponse = $tagRepository->findByAttribute('alias', $tags['_nicename']);
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
                    'user_id' => $this->getUserIdByLogin($news['creator']['__cdata'], $userRepository),
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

    private function dateWPToDefault($date)
    {
        $date = Carbon::parse($date);

        $formattedDate = $date->format('Y-m-d H:i:s.u');

        return $formattedDate;
    }

    private function getUserIdByLogin($login, $userRepository)
    {
        $creator = $userRepository->findByAttribute('login', $login);
        return $creator->id;
    }

    private function saveNews($arrayData, $newsRepository)
    {
        echo "<br />";
        echo "<br />";
        echo "==========================================";
        echo "<br />";
        echo "INICIANDO MIGRAÇÃO DE NOTÍCIAS";
        echo "<br />";

        try {

            foreach ($arrayData as $data) {
                $news = $newsRepository->findByAttribute('alias', $data['alias']); //->firstOrFail();
                echo "<br />";
                if (!$news) {
                    DB::beginTransaction();
                    $newsResponse = $newsRepository->create($data);
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
}