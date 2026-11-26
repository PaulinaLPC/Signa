<div class="admin-form-grid">

    <!-- DATOS GENERALES -->
    <div class="form-group">
        <label for="palabra">Palabra</label>
        <input type="text" id="palabra" name="palabra"
               value="{{ old('palabra', $sena->palabra) }}"
               class="@error('palabra') input-error @enderror" required>
        @error('palabra') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="categoria_id">Categoría</label>
        <select id="categoria_id" name="categoria_id" class="@error('categoria_id') input-error @enderror" required>
            <option value="">Selecciona una categoría</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}"
                        @selected(old('categoria_id', $sena->categoria_id) == $categoria->id)>
                    {{ $categoria->icono }} {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>
        @error('categoria_id') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group form-group-full">
        <label for="descripcion">¿Cómo se realiza la seña?</label>
        <textarea id="descripcion" name="descripcion" rows="4"
                  class="@error('descripcion') input-error @enderror">{{ old('descripcion', $sena->descripcion) }}</textarea>
        @error('descripcion') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <!-- VIDEO -->
    <div class="form-group form-group-full">
        <label for="video">Enlace del video</label>
        <input type="url" id="video" name="video"
               value="{{ old('video', $sena->video) }}"
               class="@error('video') input-error @enderror"
               placeholder="https://youtu.be/XXXXXXXXXXX">
        <small class="form-hint">Pega el enlace de YouTube (normal, youtu.be o Shorts).</small>
        @error('video') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <!-- IMAGEN ACTUAL -->
    @if ($sena->exists && $sena->imagen_url)
        <div class="form-group form-group-full">
            <label>Imagen actual</label>
            <div class="admin-current-image">
                <img src="{{ $sena->imagen_url }}" alt="{{ $sena->palabra }}">

                @if ($sena->imagen)
                    <label class="form-check">
                        <input type="checkbox" name="quitar_imagen" value="1">
                        Quitar imagen
                    </label>
                @else
                    <small class="form-hint">Es la miniatura automática del video de YouTube.</small>
                @endif
            </div>
        </div>
    @endif

    <!-- NUEVA IMAGEN -->
    <div class="form-group">
        <label for="imagen_url">Enlace de imagen (opcional)</label>
        <input type="url" id="imagen_url" name="imagen_url"
               value="{{ old('imagen_url') }}"
               class="@error('imagen_url') input-error @enderror"
               placeholder="https://...jpg">
        @error('imagen_url') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="imagen_archivo">O subir imagen (opcional)</label>
        <input type="file" id="imagen_archivo" name="imagen_archivo" accept="image/*"
               class="@error('imagen_archivo') input-error @enderror">
        <small class="form-hint">JPG, PNG o WebP, máximo 2 MB. Si llenas ambos, se usa el archivo.</small>
        @error('imagen_archivo') <span class="form-error">{{ $message }}</span> @enderror
    </div>

</div>