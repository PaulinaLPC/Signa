<div class="admin-form-grid">

    <div class="form-group form-group-full">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo"
               value="{{ old('titulo', $leccion->titulo) }}"
               class="@error('titulo') input-error @enderror" required>
        @error('titulo') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="categoria_id">Categoría</label>
        <select id="categoria_id" name="categoria_id" class="@error('categoria_id') input-error @enderror">
            <option value="">Sin categoría</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}"
                        @selected(old('categoria_id', $leccion->categoria_id) == $categoria->id)>
                    {{ $categoria->icono }} {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
        <small class="form-hint">Las señas de esta categoría se mostrarán en la lección.</small>
        @error('categoria_id') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="nivel">Nivel</label>
        <select id="nivel" name="nivel" class="@error('nivel') input-error @enderror" required>
            @foreach ($niveles as $nivel)
                <option value="{{ $nivel }}" @selected(old('nivel', $leccion->nivel) === $nivel)>{{ $nivel }}</option>
            @endforeach
        </select>
        @error('nivel') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="orden">Orden</label>
        <input type="number" id="orden" name="orden" min="0"
               value="{{ old('orden', $leccion->orden) }}"
               class="@error('orden') input-error @enderror" required>
        <small class="form-hint">Posición en la lista de lecciones (1, 2, 3...).</small>
        @error('orden') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="descripcion">Descripción corta</label>
        <input type="text" id="descripcion" name="descripcion"
               value="{{ old('descripcion', $leccion->descripcion) }}"
               class="@error('descripcion') input-error @enderror">
        @error('descripcion') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group form-group-full">
        <label for="contenido">Contenido de la lección</label>
        <textarea id="contenido" name="contenido" rows="6"
                  class="@error('contenido') input-error @enderror">{{ old('contenido', $leccion->contenido) }}</textarea>
        @error('contenido') <span class="form-error">{{ $message }}</span> @enderror
    </div>

</div>