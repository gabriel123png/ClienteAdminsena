<?php

namespace App\Http\Controllers;

use App\Services\AdminSenaApi;
use Illuminate\Http\Request;

class CourseTeacherController extends Controller
{
    public function __construct(private AdminSenaApi $api)
    {
    }

    public function index()
    {
        $courseTeachers = $this->api->get('/course-teachers');

        return view('course_teacher.index', compact('courseTeachers'));
    }

    public function create()
    {
        $courses = $this->api->get('/courses');
        $teachers = $this->api->get('/teachers');

        return view('course_teacher.create', compact('courses', 'teachers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|integer',
            'teacher_id' => 'required|integer',
        ]);

        $this->api->post('/course-teachers', $data);

        return redirect()->route('course_teachers.index')->with('success', 'Instructor asignado al curso correctamente.');
    }

    public function edit(string $id)
    {
        $courseTeacher = $this->api->get('/course-teachers/' . $id);
        $courses = $this->api->get('/courses');
        $teachers = $this->api->get('/teachers');

        return view('course_teacher.edit', compact('courseTeacher', 'courses', 'teachers'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'course_id' => 'required|integer',
            'teacher_id' => 'required|integer',
        ]);

        $this->api->put('/course-teachers/' . $id, $data);

        return redirect()->route('course_teachers.index')->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $this->api->delete('/course-teachers/' . $id);

        return redirect()->route('course_teachers.index')->with('success', 'Asignación eliminada correctamente.');
    }
}
