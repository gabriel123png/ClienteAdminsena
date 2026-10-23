<div class="mb-3">
    <label class="form-label" for="name">Nombre</label>
    <input id="name" type="text" name="name" class="form-control" value="{{ old('name', data_get($apprentice, 'name', '')) }}" required>
    @error('name')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label" for="email">Email</label>
    <input id="email" type="email" name="email" class="form-control" value="{{ old('email', data_get($apprentice, 'email', '')) }}" required>
    @error('email')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label" for="cell_number">Celular</label>
    <input id="cell_number" type="text" name="cell_number" class="form-control" value="{{ old('cell_number', data_get($apprentice, 'cell_number', '')) }}" required>
    @error('cell_number')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label" for="apprentice-photo">Foto</label>
    <input id="apprentice-photo" type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
    <div class="form-text">Formatos permitidos: JPG, PNG o WEBP. Tamaño máximo: 2 MB.</div>
    <div id="apprentice-photo-preview" class="mt-3 {{ $photoUrl ? '' : 'd-none' }}">
        <img id="apprentice-photo-preview-image" src="{{ $photoUrl ?? '' }}" alt="Vista previa de la foto" style="width: 120px; height: 120px; object-fit: cover; border-radius: 1rem;">
    </div>
    @if($photoUrl)
        <p class="form-text">Si no seleccionas otra imagen, se conservará la foto actual.</p>
    @endif
    @error('photo')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label" for="course_id">Curso</label>
    <select id="course_id" name="course_id" class="form-select" required>
        <option value="">-- Seleccione un curso --</option>
        @foreach($courses as $course)
            <option value="{{ data_get($course, 'id') }}" @selected(old('course_id', data_get($apprentice, 'course_id')) == data_get($course, 'id'))>{{ data_get($course, 'course_number') }}</option>
        @endforeach
    </select>
    @error('course_id')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label" for="computer_id">Computador (opcional)</label>
    <select id="computer_id" name="computer_id" class="form-select">
        <option value="">-- Sin computador asignado --</option>
        @foreach($computers as $computer)
            <option value="{{ data_get($computer, 'id') }}" @selected(old('computer_id', data_get($apprentice, 'computer_id')) == data_get($computer, 'id'))>
                {{ data_get($computer, 'number') }} - {{ data_get($computer, 'brand') }}
            </option>
        @endforeach
    </select>
    @error('computer_id')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('apprentice-photo');
        const preview = document.getElementById('apprentice-photo-preview');
        const image = document.getElementById('apprentice-photo-preview-image');
        let previewUrl;

        input?.addEventListener('change', () => {
            const file = input.files?.[0];

            if (!file) {
                return;
            }

            if (previewUrl) {
                URL.revokeObjectURL(previewUrl);
            }

            previewUrl = URL.createObjectURL(file);
            image.src = previewUrl;
            preview.classList.remove('d-none');
        });
    });
</script>
