@extends('layouts.app')

@section('content')
    <article>
        <header>
            <h1>Crear Nueva Publicación</h1>
        </header>

        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf

            <label for="title">
                Título
                <input type="text" id="title" name="title" value="{{ old('title') }}" required autofocus>
            </label>

            <label for="image">
                Imagen (opcional)
                <input type="file" id="image" name="image" accept="image/*">
                <small>Formatos permitidos: JPG, PNG, GIF, WEBP. Tamaño máximo: 2MB</small>
            </label>

            <label for="content">
                Contenido
                <textarea id="content" name="content" rows="12" required>{{ old('content') }}</textarea>
            </label>

            <div class="inline-buttons">
                <button type="submit">Publicar</button>
                <a href="{{ route('home') }}" role="button" class="secondary">Cancelar</a>
            </div>
        </form>
    </article>
@endsection