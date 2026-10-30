<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CourseController extends Controller
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
        $courses = $this->fetchDataFromApi($this->apiBaseUrl() . '/courses');
 
        return view('course.index', compact('courses'));
    }
 
    public function create()
    {
        $areas = $this->fetchDataFromApi($this->apiBaseUrl() . '/areas');
        $trainingCenters = $this->fetchDataFromApi($this->apiBaseUrl() . '/training_centers');
 
        return view('course.create', compact('areas', 'trainingCenters'));
    }
 
    public function store(Request $request)
    {
        $data = $request->validate([
            'course_number' => 'required|string|max:255',
            'day' => 'required|string|max:255',
            'area_id' => 'required|integer',
            'training_center_id' => 'required|integer',
        ]);
 
        Http::acceptJson()->post($this->apiBaseUrl() . '/courses', $data)->throw();
 
        return redirect()->route('api.v1.courses.index')->with('success', 'Curso registrado correctamente.');
    }
 
    // NUEVO: la ruta existe en web.php pero faltaba el método
    public function show(string $id)
    {
        $course = $this->fetchDataFromApi($this->apiBaseUrl() . '/courses/' . $id);
 
        return view('course.show', compact('course'));
    }
 
    public function edit(string $id)
    {
        $course = $this->fetchDataFromApi($this->apiBaseUrl() . '/courses/' . $id);
        $areas = $this->fetchDataFromApi($this->apiBaseUrl() . '/areas');
        $trainingCenters = $this->fetchDataFromApi($this->apiBaseUrl() . '/training_centers');
 
        return view('course.edit', compact('course', 'areas', 'trainingCenters'));
    }
 
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'course_number' => 'required|string|max:255',
            'day' => 'required|string|max:255',
            'area_id' => 'required|integer',
            'training_center_id' => 'required|integer',
        ]);
 
        Http::acceptJson()->put($this->apiBaseUrl() . '/courses/' . $id, $data)->throw();
 
        return redirect()->route('api.v1.courses.index')->with('success', 'Curso actualizado correctamente.');
    }
 
    public function destroy(string $id)
    {
        Http::acceptJson()->delete($this->apiBaseUrl() . '/courses/' . $id)->throw();
 
        return redirect()->route('api.v1.courses.index')->with('success', 'Curso eliminado correctamente.');
    }
}
 