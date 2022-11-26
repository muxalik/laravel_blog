<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'subject',
        'message'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDate($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }
}
