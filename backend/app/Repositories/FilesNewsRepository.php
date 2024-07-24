<?php

namespace App\Repositories;

use App\Models\File;
use App\Models\FilesNews;

class FilesNewsRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return FilesNews::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return FilesNews::class;
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeFilesNews($newsId, $fileId)
    {
        return FilesNews::create([
            'news_id' => $newsId,
            'file_id' => $fileId
        ]);
    }
}