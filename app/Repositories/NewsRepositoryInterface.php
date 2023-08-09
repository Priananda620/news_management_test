<?php

namespace App\Repositories;

interface NewsRepositoryInterface
{
    public function getAllNews($perPage, $page);
    public function getNewsById($id);
    public function createNews(array $data);
    public function updateNews($id, array $data);
    public function deleteNews($id);
    public function getNewsDetails($news_id);
}

