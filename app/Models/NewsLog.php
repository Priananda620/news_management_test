<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsLog extends Model
{
    use HasFactory;

    public $timestamps=true;
    
    protected $fillable = [
        'action',
        'news_id',
        'title',
        'content',
    ];

    protected $casts = [
        'action' => 'string',
        'news_id' => 'integer',
        'title' => 'string',
        'content' => 'string'
    ];

    public function news(){
        return $this->belongsTo(News::class);
    }
}
