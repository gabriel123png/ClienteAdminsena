<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TeacherController extends Controller
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
        $teachers = $this->fetchDataFromApi($this->apiBaseUrl() . '/teachers');
 
        return view('teacher.index', compact('teachers'));
    }
 
    public function create()
    {
        $areas = $this->fetchDataFromApi($this->apiBaseUrl() . '/areas');
        $trainingCenters = $this->fetchDataFromApi($this->apiBaseUrl() . '/training_centers');
 
        return view('teacher.create', compact('areas', 'trainingCenters'));
    }
 
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'area_id' => 'required|integer',
            'training_center_id' => 'required|integer',
        ]);
 
        Http::acceptJson()->post($this->apiBaseUrl() . '/teachers', $data)->throw();
 
        return redirect()->route('api.v1.teachers.index')->with('success', 'Instructor registrado correctamente.');
    }
 
    // NUEVO: la ruta existe en web.php pero faltaba el método
    public function show(string $id)
    {
        $teacher = $this->fetchDataFromApi($this->apiBaseUrl() . '/teachers/' . $id);
 
        return view('teacher.show', compact('teacher'));
    }
 
    public function edit(string $id)
    {
        $teacher = $this->fetchDataFromApi($this->apiBaseUrl() . '/teachers/' . $id);
        $areas = $this->fetchDataFromApi($this->apiBaseUrl() . '/areas');
        $trainingCenters = $this->fetchDataFromApi($this->apiBaseUrl() . '/training_centers');
 
        return view('teacher.edit', compact('teacher', 'areas', 'trainingCenters'));
    }
 
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'area_id' => 'required|integer',
            'training_center_id' => 'required|integer',
        ]);
 
        Http::acceptJson()->put($this->apiBaseUrl() . '/teachers/' . $id, $data)->throw();
 
        return redirect()->route('api.v1.teachers.index')->with('success', 'Instructor actualizado correctamente.');
    }
 
    public function destroy(string $id)
    {
        Http::acceptJson()->delete($this->apiBaseUrl() . '/teachers/' . $id)->throw();
 
        return redirect()->route('api.v1.teachers.index')->with('success', 'Instructor eliminado correctamente.');
    }
}
 