<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $timestamps=true;

    protected $fillable = [
        'news_id',
        'user_id',
        'comment'
    ];

    protected $casts = [
        'comment' => 'string',
        'news_id' => 'integer',
        'user_id' => 'integer'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function news(){
        return $this->belongsTo(News::class);
    }
}
