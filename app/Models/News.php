<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class News extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps=true;

    protected $fillable = [
        'user_id',
        'content',
        'title',
        'attached_img'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'content' => 'string',
        'title' => 'string',
        'attached_img' => 'string'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function news_log(){
        return $this->hasMany(NewsLog::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }
}
