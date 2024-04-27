<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_date',
        'status',
        'tags'
    ];

    protected $casts = [
        'tags' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);

    }
}
