<?php

// app\Repositories\EloquentNewsRepository.php

namespace App\Repositories;

use App\Models\News;

class EloquentNewsRepository implements NewsRepositoryInterface
{
    protected $newsModel;

    public function __construct(News $newsModel)
    {
        $this->newsModel = $newsModel;
    }

    // Implement the methods defined in the NewsRepositoryInterface
    public function all()
    {
        return $this->newsModel->all();
    }

    public function find($id)
    {
        return $this->newsModel->find($id);
    }

    public function create(array $data)
    {
        return $this->newsModel->create($data);
    }

    public function update($id, array $data)
    {
        // ...
    }

    public function delete($id)
    {
        // ...
    }

    // public function getNewsByCategory($category)
    // {
    //     return $this->newsModel->where('category', $category)->get();
    // }

    // public function getLatestNews($limit)
    // {
    //     return $this->newsModel->orderBy('created_at', 'desc')->limit($limit)->get();
    // }
}
