<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class ImagesMigrator
{
    public function scrapeNews($url)
    {
        $client = new Client([
            'verify' => false,
        ]);
        $response = $client->request('GET', $url);

        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);

        $posts = $crawler->filter('.event-list-styles');

        $results = [];

        $posts->each(function (Crawler $node) use (&$results) {
            $images = $node->filter('.image img')->each(function (Crawler $imgNode) {
                return $imgNode->attr('src');
            });

            $titles = $node->filter('.title a')->each(function (Crawler $linkNode) {
                return $linkNode->attr('title');
            });

            $links = $node->filter('.title a')->each(function (Crawler $linkNode) {
                return $linkNode->attr('href');
            });

            Log::info($images);
            if (!empty($images)) {
                $results[] = [
                    'images' => $images,
                    'titles' => $titles,
                    'links' => $links,
                    'img' => preg_replace('/^.*\/([^\/]+)$/', '$1', $images[0])
                ];
            }
        });

        return $results;
    }

    public function downloadImages($images, $saveDir)
    {
        $client = new Client(['verify' => false]);

        foreach ($images as $image) {
            $imageUrl = $image['images'][0] ?? null;

            if ($imageUrl) {
                $imageContent = $client->request('GET', $imageUrl)->getBody()->getContents();
                $imagePath = $saveDir . '/' . basename($imageUrl);
                file_put_contents($imagePath, $imageContent);

                Log::info("Imagem salva em: $imagePath");
            } else {
                Log::warning('Imagem inválida encontrada: ' . json_encode($image));
            }
        }
    }

    public function executeCrowler()
    {
        $allImages = [];

        for ($i = 1; $i <= 2; $i++) {

            $url = $i == 1 ? "https://agora.fiocruz.br/blog/event/" : "https://agora.fiocruz.br/blog/event/page/$i/";

            Log::info("Url crowler: $url");
            $news = $this->scrapeNews($url);

            $allImages = array_merge($allImages, $news);
        }

        if (!empty($allImages)) {
            Storage::put('migrator/temp_images_events.json', json_encode($allImages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            //$saveDir = 'images';
            //$this->downloadImages($allImages, $saveDir);

            //echo "Todas as imagens foram baixadas e salvas em: $saveDir\n";
            echo "fim do crowler";
        } else {
            Log::warning('Nenhuma imagem foi encontrada para salvar.');
            echo "Nenhuma imagem foi encontrada para salvar.\n";
        }
    }
}