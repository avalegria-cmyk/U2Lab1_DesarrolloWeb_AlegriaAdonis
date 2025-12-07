@extends('layouts.app')

@section('content')
    <article>
        <header>
            <h1>{{ $post->title }}</h1>

            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="post-detail-image">
            @endif

            <p class="post-meta">
                Por <strong>{{ $post->user->name }}</strong>
                · {{ $post->created_at->format('d/m/Y H:i') }}
            </p>

            @auth
                @if(auth()->user()->id === $post->user_id || auth()->user()->isAdmin())
                    <div class="inline-buttons">
                        <a href="{{ route('posts.edit', $post) }}" role="button" class="secondary">Editar</a>

                        <form method="POST" action="{{ route('posts.destroy', $post) }}"
                            onsubmit="return confirm('¿Estás seguro de eliminar esta publicación?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="contrast">Eliminar</button>
                        </form>
                    </div>
                @endif
            @endauth
        </header>

        <section>
            <p style="white-space: pre-wrap;">{{ $post->content }}</p>
        </section>

        <hr>

        <!-- Sección de comentarios -->
        <section>
            <h2>Comentarios ({{ $post->comments->count() }})</h2>

            @forelse($post->comments as $comment)
                <div class="comment">
                    <p class="comment-author">
                        @if($comment->user)
                            {{ $comment->user->name }}
                        @else
                            {{ $comment->guest_name }} (Invitado)
                        @endif
                    </p>
                    <p class="comment-date">{{ $comment->created_at->diffForHumans() }}</p>
                    <p>{{ $comment->content }}</p>
                </div>
            @empty
                <p>No hay comentarios aún. ¡Sé el primero en comentar!</p>
            @endforelse

            <!-- Formulario para nuevo comentario -->
            <h3>Agregar un comentario</h3>
            <form method="POST" action="{{ route('comments.store', $post) }}">
                @csrf

                @guest
                    <label for="guest_name">
                        Nombre
                        <input type="text" id="guest_name" name="guest_name" value="{{ old('guest_name') }}" required>
                    </label>

                    <label for="guest_email">
                        Email (opcional)
                        <input type="email" id="guest_email" name="guest_email" value="{{ old('guest_email') }}">
                    </label>
                @endguest

                <label for="content">
                    Comentario
                    <textarea id="content" name="content" rows="4" required>{{ old('content') }}</textarea>
                </label>

                <button type="submit">Publicar Comentario</button>
            </form>
        </section>

        <footer style="margin-top: 2rem;">
            <a href="{{ route('home') }}">← Volver al inicio</a>
        </footer>
    </article>
@endsection