<div class="admin-form-grid">

    <div class="form-group">
        <label for="sena_id">Seña que se mostrará</label>
        <select id="sena_id" name="sena_id" class="@error('sena_id') input-error @enderror">
            <option value="">Sin seña</option>
            @foreach ($senas as $categoria => $grupo)
                <optgroup label="{{ $categoria }}">
                    @foreach ($grupo as $sena)
                        <option value="{{ $sena->id }}" @selected(old('sena_id', $ejercicio->sena_id) == $sena->id)>
                            {{ $sena->palabra }}{{ $sena->tiene_video ? '' : ' (sin video)' }}
                        </option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        <small class="form-hint">Su video o imagen aparecerá en el ejercicio.</small>
        @error('sena_id') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="orden">Orden</label>
        <input type="number" id="orden" name="orden" min="0"
               value="{{ old('orden', $ejercicio->orden) }}"
               class="@error('orden') input-error @enderror" required>
        @error('orden') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group form-group-full">
        <label for="pregunta">Pregunta</label>
        <input type="text" id="pregunta" name="pregunta"
               value="{{ old('pregunta', $ejercicio->pregunta) }}"
               class="@error('pregunta') input-error @enderror" required>
        @error('pregunta') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="opciones">Opciones (una por línea)</label>
        <textarea id="opciones" name="opciones" rows="5"
                  class="@error('opciones') input-error @enderror"
                  placeholder="Hola&#10;Adiós&#10;Gracias">{{ old('opciones', implode("\n", $ejercicio->opciones ?? [])) }}</textarea>
        @error('opciones') <span class="form-error">{{ $message }}</span> @enderror
    </div>

    <div class="form-group">
        <label for="respuesta">Respuesta correcta</label>
        <input type="text" id="respuesta" name="respuesta"
               value="{{ old('respuesta', $ejercicio->respuesta) }}"
               class="@error('respuesta') input-error @enderror" required>
        <small class="form-hint">Debe escribirse exactamente igual que una de las opciones.</small>
        @error('respuesta') <span class="form-error">{{ $message }}</span> @enderror
    </div>

</div>