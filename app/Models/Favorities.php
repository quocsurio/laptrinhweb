<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Favorities extends Model
{
    use HasFactory;

    protected $table = 'favorities';

    protected $primaryKey = 'favorite_id';

    protected $fillable = [
        'favorite_name',
        'favorite_description',
    ];

   
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_favorite', 'favorite_id', 'user_id');
    }
}
