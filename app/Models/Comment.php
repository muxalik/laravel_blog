<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'content'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getDate()
    {
        return Carbon::parse($this->created_at)
            ->diffForHumans();
    }

    public static function getAmount($id)
    {
        return Comment::where('post_id', $id)
            ->count();
    }

    public static function getByPostId($id)
    {
        return Comment::where('post_id', $id)
            ->oldest()
            ->paginate(4);
    }
}
