<div class="admin-form-grid">

    <div class="form-group">
        <label for="name">Nombre completo</label>
        <input type="text" id="name" name="name"
               value="{{ old('name', $usuario->name) }}"
               class="@error('name') input-error @enderror" required>
        @error('name') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email"
               value="{{ old('email', $usuario->email) }}"
               class="@error('email') input-error @enderror" required>
        @error('email') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group form-group-full">
        <label for="rol">Rol</label>
        <select id="rol" name="rol" class="@error('rol') input-error @enderror" required>
            <option value="estudiante" @selected(old('rol', $usuario->rol) === 'estudiante')>Estudiante</option>
            <option value="admin" @selected(old('rol', $usuario->rol) === 'admin')>Administrador</option>
        </select>
        <small class="form-hint">Los administradores pueden entrar a este panel.</small>
        @error('rol') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password"
               class="@error('password') input-error @enderror" autocomplete="new-password">
        <small class="form-hint">
            {{ $usuario->exists ? 'Déjala vacía para conservar la actual.' : 'Mínimo 8 caracteres.' }}
        </small>
        @error('password') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirmar contraseña</label>
        <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
    </div>

</div>