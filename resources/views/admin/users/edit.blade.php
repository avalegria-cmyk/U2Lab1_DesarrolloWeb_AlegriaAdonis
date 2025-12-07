@extends('layouts.app')

@section('content')
    <article>
        <header>
            <h1>Cambiar Rol de Usuario</h1>
            <p>Usuario: <strong>{{ $user->name }}</strong> ({{ $user->email }})</p>
        </header>

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <label for="role">
                Seleccionar Rol
                <select id="role" name="role" required>
                    <option value="lector" {{ $user->role === 'lector' ? 'selected' : '' }}>
                        Lector (Solo lectura y comentarios)
                    </option>
                    <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>
                        Editor (Puede crear y editar publicaciones)
                    </option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                        Administrador (Acceso completo)
                    </option>
                </select>
            </label>

            <label for="is_active">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}>
                Usuario activo (los usuarios inactivos no pueden iniciar sesión)
            </label>

            <div class="inline-buttons">
                <button type="submit">Actualizar Rol</button>
                <a href="{{ route('admin.users.index') }}" role="button" class="secondary">Cancelar</a>
            </div>
        </form>

        <footer style="margin-top: 2rem;">
            <details>
                <summary>Información sobre roles</summary>
                <ul>
                    <li><strong>Lector:</strong> Puede leer publicaciones y dejar comentarios.</li>
                    <li><strong>Editor:</strong> Puede crear, editar y eliminar sus propias publicaciones.</li>
                    <li><strong>Administrador:</strong> Acceso completo al sistema, incluyendo gestión de usuarios.</li>
                </ul>
            </details>
        </footer>
    </article>
@endsection