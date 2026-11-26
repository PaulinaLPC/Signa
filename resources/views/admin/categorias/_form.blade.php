<div class="admin-form-grid">

    <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre"
               value="{{ old('nombre', $categoria->nombre) }}"
               class="@error('nombre') input-error @enderror" required>
        @error('nombre') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="icono">Ícono (emoji)</label>
        <input type="text" id="icono" name="icono"
               value="{{ old('icono', $categoria->icono) }}"
               class="@error('icono') input-error @enderror" placeholder="Ej. 🐶">
        <small class="form-hint">Presiona Windows + . (punto) para abrir los emojis.</small>
        @error('icono') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group form-group-full">
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="3"
                  class="@error('descripcion') input-error @enderror">{{ old('descripcion', $categoria->descripcion) }}</textarea>
        @error('descripcion') <span class="form-error">{{ $message }}</span> @enderror
    </div>

</div>