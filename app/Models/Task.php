<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'title', 'description', 'is_completed', 'user_id'];

    protected static function booted()
    {
        static::creating(function ($task) {
            $task->id = (string)Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
