<?php

namespace App\Listeners;

use App\Events\NewsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\NewsLog;

class NewsEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewsEvent  $event
     * @return void
     */

    public function handle(NewsEvent $event)
    {
        $news = $event->news;
        $action = $event->action;

        // Log the news activity in the news_logs table
        NewsLog::create([
            'action' => $action,
            'news_id' => $news->id,
            'title' => $news->title,
            'content' => $news->content,
        ]);

    }
}
