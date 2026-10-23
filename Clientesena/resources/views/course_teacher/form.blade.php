<div class="mb-3">
    <label class="form-label" for="course_id">Curso</label>
    <select id="course_id" name="course_id" class="form-select" required>
        <option value="">-- Seleccione un curso --</option>
        @foreach($courses as $course)
            <option value="{{ data_get($course, 'id') }}" @selected(old('course_id', data_get($courseTeacher, 'course_id')) == data_get($course, 'id'))>
                {{ data_get($course, 'course_number') }}
            </option>
        @endforeach
    </select>
    @error('course_id')<div class="text-danger">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label" for="teacher_id">Instructor</label>
    <select id="teacher_id" name="teacher_id" class="form-select" required>
        <option value="">-- Seleccione un instructor --</option>
        @foreach($teachers as $teacher)
            <option value="{{ data_get($teacher, 'id') }}" @selected(old('teacher_id', data_get($courseTeacher, 'teacher_id')) == data_get($teacher, 'id'))>
                {{ data_get($teacher, 'name') }}
            </option>
        @endforeach
    </select>
    @error('teacher_id')<div class="text-danger">{{ $message }}</div>@enderror
</div>
