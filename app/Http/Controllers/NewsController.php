<?php

namespace App\Http\Controllers;

use App\Events\NewsEvent;
use Illuminate\Http\Request;

use App\Http\Resources\NewsResource;
use App\Http\Resources\CommentResource;

use App\Repositories\NewsRepositoryInterface;
use App\Repositories\EloquentNewsRepository;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class NewsController extends Controller
{
    protected $newsRepository;

    public function __construct(EloquentNewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    // Get all news
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $news = $this->newsRepository->getAllNews($perPage, $page);
        return NewsResource::collection($news);
    }

    // Get a single news
    public function getNews($id)
    {
        try {
            $news = $this->newsRepository->getNewsById($id);
            return new NewsResource($news);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'News not found'], 404);
        }
    }

    // Get news details including comments
    public function getNewsDetails($news_id)
    {
        try {
            $newsDetails = $this->newsRepository->getNewsDetails($news_id);
            $responseData = [
                'news' => new NewsResource($newsDetails),
                'total_comments' => $newsDetails->comment->count(),
                'comments' => CommentResource::collection($newsDetails->comment),
            ];

            return response()->json($responseData);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'News not found'], 404);
        }
    }

    // Create a new news
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Create news using repository
        $newsData = [
            'user_id' => Auth::user()->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
            $newsData['attached_img'] = $imagePath;
        }

        $news = $this->newsRepository->createNews($newsData);
        event(new NewsEvent($news, 'created'));

        return new NewsResource($news);
    }

    // Update a news
    public function update(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            // Update news using repository
            $newsData = [
                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ];

            if ($request->hasFile('image')) {
                $newsData['attached_img'] = $request->file('image');
            }

            $news = $this->newsRepository->updateNews($id, $newsData);
            event(new NewsEvent($news, 'updated'));

            return new NewsResource($news);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'News not found'], 404);
        }
    }

    // Delete a news
    public function destroy($id)
    {
        try {
            // Delete news using repository
            $news = $this->newsRepository->getNewsById($id);
            $this->newsRepository->deleteNews($id);

            event(new NewsEvent($news, 'deleted'));

            return response()->json(['message' => 'News deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'News not found'], 404);
        }
    }
}
