<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Jobs\CreateCommentJob;


class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'news_id' => 'required|integer|exists:news,id',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }


        $commentData = [
            'news_id' => $request->input('news_id'),
            'comment' => $request->input('comment'),
            'user_id' => Auth::user()->id
        ];
    
        // Dispatch the job to the queue with redis

        CreateCommentJob::dispatch(
            $commentData['news_id'],
            $commentData['comment'],
            $commentData['user_id']
        );

        // $serializedJob = serialize(new CreateCommentJob(
        //     $commentData['news_id'],
        //     $commentData['comment'],
        //     $commentData['user_id']
        // ));
        // Redis::rpush('comment_queue', $serializedJob);

        // Redis::rpush('comment_queue', json_encode([
        //     'user_id' => Auth::user()->id,
        //     'news_id' => $request->news_id,
        //     'comment' => $request->comment,
        // ]));

        return response()->json([
            'message' => 'Comment creation success, queued for processing.',
        ], 202);
    }

}
