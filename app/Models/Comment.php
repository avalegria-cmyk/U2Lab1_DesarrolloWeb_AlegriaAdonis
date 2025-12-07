<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'content',
        'post_id',
        'user_id',
        'guest_name',
        'guest_email',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Relación con la publicación
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Relación con el usuario (si está autenticado)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el nombre del autor del comentario
     */
    public function getAuthorNameAttribute()
    {
        return $this->user ? $this->user->name : $this->guest_name;
    }
}