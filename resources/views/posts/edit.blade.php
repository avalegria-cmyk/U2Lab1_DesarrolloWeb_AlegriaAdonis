@extends('layouts.app')

@section('content')
    <article>
        <header>
            <h1>Editar Publicación</h1>
        </header>

        <form method="POST" action="{{ route('posts.update', $post) }}">
            @csrf
            @method('PUT')

            <label for="title">
                Título
                <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required autofocus>
            </label>

            <label for="content">
                Contenido
                <textarea id="content" name="content" rows="12" required>{{ old('content', $post->content) }}</textarea>
            </label>

            <div class="inline-buttons">
                <button type="submit">Actualizar</button>
                <a href="{{ route('posts.show', $post) }}" role="button" class="secondary">Cancelar</a>
            </div>
        </form>
    </article>
@endsection