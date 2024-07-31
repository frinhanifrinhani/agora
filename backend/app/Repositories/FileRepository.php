<?php

namespace App\Repositories;

use App\Models\File;

class FileRepository extends BaseRepository
{
    /**
     * @inheritDoc
     */
    public function getFieldsSearchable()
    {
        return File::searchable();
    }

    /**
     * @inheritDoc
     */
    public function model()
    {
        return File::class;
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function storeFile($data)
    {
        return File::create([
            'name' => $data['name'],
            'path' => $data['path'],
            'full_path' => $data['full_path'],
            'file' => null,
            'type' => $data['type'],
            'size' => $data['size'],
            'extension' => $data['extension']
        ]);
    }
}