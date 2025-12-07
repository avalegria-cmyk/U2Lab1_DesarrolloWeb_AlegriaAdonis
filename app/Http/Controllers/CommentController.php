<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        // Validar el contenido del comentario
        $rules = ['content' => 'required|string|max:1000'];

        // Si no está autenticado, requerir nombre
        if (!auth()->check()) {
            $rules['guest_name'] = 'required|string|max:255';
            $rules['guest_email'] = 'nullable|email|max:255';
        }

        $data = $request->validate($rules);

        // Agregar el post_id
        $data['post_id'] = $post->id;

        // Si está autenticado, agregar user_id
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        Comment::create($data);

        return back()->with('status', 'Comentario publicado exitosamente.');
    }
}