<?php

// database/migrations/2023_08_07_123456_create_news_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsLogsTable extends Migration
{
    public function up()
    {
        Schema::create('news_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->unsignedBigInteger('news_id')->nullable();
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('news_logs');
    }
}
