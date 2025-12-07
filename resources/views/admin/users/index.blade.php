@extends('layouts.app')

@section('content')
    <article>
        <header>
            <h1>Gestión de Usuarios</h1>
            <p>Administra los roles de los usuarios registrados en el blog.</p>
        </header>

        <figure>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Registrado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="{{ !$user->is_active ? 'opacity: 0.6;' : '' }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <strong style="color: var(--pico-primary);">Administrador</strong>
                                @elseif($user->role === 'editor')
                                    <span style="color: var(--pico-secondary);">Editor</span>
                                @else
                                    <span>Lector</span>
                                @endif
                            </td>
                            <td>
                                @if($user->is_active)
                                    <span style="color: #28a745;">✓ Activo</span>
                                @else
                                    <span style="color: #dc3545;">✗ Inactivo</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                    <a href="{{ route('admin.users.edit', $user) }}" role="button" class="secondary"
                                        style="margin: 0;">
                                        Editar
                                    </a>

                                    <form method="POST" action="{{ route('admin.users.toggleStatus', $user) }}"
                                        style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="{{ $user->is_active ? 'contrast' : '' }}"
                                            style="margin: 0;">
                                            {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </figure>

        <!-- Paginación -->
        @if($users->hasPages())
            <nav aria-label="Paginación">
                {{ $users->links() }}
            </nav>
        @endif

        <footer>
            <a href="{{ route('home') }}">← Volver al inicio</a>
        </footer>
    </article>
@endsection