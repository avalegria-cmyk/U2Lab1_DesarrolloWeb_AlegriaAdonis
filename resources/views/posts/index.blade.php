@extends('layouts.app')

@section('content')
    <div>
        <h1>Publicaciones Recientes</h1>

        @forelse($posts as $post)
            <article class="post-card">
                <header>
                    <h2>
                        <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                    </h2>
                    <p class="post-meta">
                        Por <strong>{{ $post->user->name }}</strong>
                        · {{ $post->created_at->diffForHumans() }}
                        · {{ $post->comments->count() }} comentarios
                    </p>
                </header>

                <p>{{ Str::limit($post->content, 200) }}</p>

                <footer>
                    <a href="{{ route('posts.show', $post) }}" role="button">Leer más</a>

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
                </footer>
            </article>
        @empty
            <article>
                <p>No hay publicaciones aún. ¡Sé el primero en crear una!</p>
            </article>
        @endforelse

        <!-- Paginación -->
        @if($posts->hasPages())
            <nav aria-label="Paginación">
                {{ $posts->links() }}
            </nav>
        @endif
    </div>
@endsection