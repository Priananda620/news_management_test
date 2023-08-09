<?php

namespace App\Jobs;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class CreateCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $newsId;
    protected $commentData;

    protected $userId;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($news_id, $comment, $user_id)
    {
        $this->newsId = $news_id;
        $this->commentData = $comment;
        $this->userId = $user_id;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $newsId = $this->newsId;
        $commentData = $this->commentData;
        $userId = $this->userId;


        $comment = new Comment();
        $comment->news_id = $newsId;
        $comment->comment = $commentData;
        $comment->user_id = $userId;

        $comment->save();
    }
}
