<?php
namespace App\Repositories;

use App\Models\News;
use Illuminate\Support\Facades\Storage;

class EloquentNewsRepository implements NewsRepositoryInterface
{
    public function getAllNews($perPage, $page)
    {
        return News::paginate($perPage, ['*'], 'page', $page);
    }

    public function getNewsById($id)
    {
        return News::findOrFail($id);
    }

    public function createNews(array $data)
    {
        return News::create($data);
    }

    public function updateNews($id, array $data)
    {
        $news = News::findOrFail($id);

        if (isset($data['attached_img'])) {
            // Delete old image if it exists
            if ($news->attached_img) {
                Storage::disk('public')->delete($news->attached_img);
            }

            // Store the new image
            $imagePath = $data['attached_img']->store('news_images', 'public');
            $data['attached_img'] = $imagePath;
        }

        $news->update($data);

        return $news;
    }

    public function deleteNews($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
    }

    public function getNewsDetails($news_id)
    {
        return News::with('comment')->findOrFail($news_id);
    }
}
