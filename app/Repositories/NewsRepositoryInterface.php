<?php

namespace App\Repositories;

interface NewsRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    // public function getNewsByCategory($category);

    // public function getLatestNews($limit);
}
