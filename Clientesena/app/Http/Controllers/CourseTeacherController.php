<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourseTeacherController extends Controller
{
     private function apiBaseUrl()
    {
        return rtrim(trim((string) config('services.adminsena.url', '')), '/;');
    }
 
    private function fetchDataFromApi(string $url)
    {
        $payload = Http::acceptJson()->get($url)->throw()->json();
 
        return is_array($payload) && array_key_exists('data', $payload)
            ? $payload['data']
            : $payload;
    }
 
    public function index()
    {
        $courseTeachers = $this->fetchDataFromApi($this->apiBaseUrl() . '/course-teachers');
 
        return view('course_teacher.index', compact('courseTeachers'));
    }
 
    public function create()
    {
        $courses = $this->fetchDataFromApi($this->apiBaseUrl() . '/courses');
        $teachers = $this->fetchDataFromApi($this->apiBaseUrl() . '/teachers');
 
        return view('course_teacher.create', compact('courses', 'teachers'));
    }
 
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|integer',
            'teacher_id' => 'required|integer',
        ]);
 
        Http::acceptJson()->post($this->apiBaseUrl() . '/course-teachers', $data)->throw();
 
        return redirect()->route('api.v1.course_teachers.index')->with('success', 'Instructor asignado al curso correctamente.');
    }
 
    // NUEVO: la ruta existe en web.php pero faltaba el método
    public function show(string $id)
    {
        $courseTeacher = $this->fetchDataFromApi($this->apiBaseUrl() . '/course-teachers/' . $id);
 
        return view('course_teacher.show', compact('courseTeacher'));
    }
 
    public function edit(string $id)
    {
        $courseTeacher = $this->fetchDataFromApi($this->apiBaseUrl() . '/course-teachers/' . $id);
        $courses = $this->fetchDataFromApi($this->apiBaseUrl() . '/courses');
        $teachers = $this->fetchDataFromApi($this->apiBaseUrl() . '/teachers');
 
        return view('course_teacher.edit', compact('courseTeacher', 'courses', 'teachers'));
    }
 
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'course_id' => 'required|integer',
            'teacher_id' => 'required|integer',
        ]);
 
        Http::acceptJson()->put($this->apiBaseUrl() . '/course-teachers/' . $id, $data)->throw();
 
        return redirect()->route('api.v1.course_teachers.index')->with('success', 'Asignación actualizada correctamente.');
    }
 
    public function destroy(string $id)
    {
        Http::acceptJson()->delete($this->apiBaseUrl() . '/course-teachers/' . $id)->throw();
 
        return redirect()->route('api.v1.course_teachers.index')->with('success', 'Asignación eliminada correctamente.');
    }
}
 