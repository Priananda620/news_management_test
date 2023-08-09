<?php

namespace App\Http\Controllers;

use App\Events\NewsEvent;
use Illuminate\Http\Request;

use App\Models\News;

use App\Http\Resources\NewsResource;

use App\Http\Resources\CommentResource;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\ModelNotFoundException;


class NewsController extends Controller
{
    // Get all news
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
    
        $news = News::paginate($perPage, ['*'], 'page', $page);
    
        return NewsResource::collection($news);
    }

    // Get a single news
    public function getNews($id)
    {
        try {
            $news = News::findOrFail($id);
            return new NewsResource($news);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'News not found'], 404);
        }
    }


    public function getNewsDetails($news_id)
    {
        try {
            $news = News::with('comment')->findOrFail($news_id);
            $responseData = [
                'news' => new NewsResource($news),
                'total_comments' => $news->comment->count(),
                'comments' => CommentResource::collection($news->comment), // Assuming you have a CommentResource
            ];
            
            return response()->json($responseData);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'News not found'], 404);
        }
    }

    // Create a new news
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $news = new News();
        $news->user_id = Auth::user()->id;
        $news->title = $request->input('title');
        $news->content = $request->input('content');

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
            $news->attached_img = $imagePath;
        }

        $news->save();
        event(new NewsEvent($news, 'created')); 

        return new NewsResource($news);
    }

    // Update a news
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {

            $news = News::findOrFail($id);

            // Delete previously uploaded image if request has new image
            if ($request->hasFile('image')) {
                // Delete old image if it exists
                if ($news->attached_img) {
                    Storage::disk('public')->delete($news->attached_img);
                }

                // Store the new image
                $imagePath = $request->file('image')->store('news_images', 'public');
                $news->attached_img = $imagePath;
            }

            // Update news attributes
            $news->title = $request->input('title', $news->title);
            $news->content = $request->input('content', $news->content);

            $news->save();

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
            $news = News::findOrFail($id);

            //soft delete
            $news->delete();

            event(new NewsEvent($news, 'deleted')); 

            return response()->json(['message' => 'News deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'News not found'], 404);
        }

    }
    
}
