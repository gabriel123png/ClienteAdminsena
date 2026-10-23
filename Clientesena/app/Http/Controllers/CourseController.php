<?php

namespace App\Http\Controllers;

use App\Services\AdminSenaApi;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct(private AdminSenaApi $api)
    {
    }

    public function index()
    {
        $courses = $this->api->get('/courses');

        return view('course.index', compact('courses'));
    }

    public function create()
    {
        $areas = $this->api->get('/areas');
        $trainingCenters = $this->api->get('/training_centers');

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

        $this->api->post('/courses', $data);

        return redirect()->route('courses.index')->with('success', 'Curso registrado correctamente.');
    }

    public function edit(string $id)
    {
        $course = $this->api->get('/courses/' . $id);
        $areas = $this->api->get('/areas');
        $trainingCenters = $this->api->get('/training_centers');

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

        $this->api->put('/courses/' . $id, $data);

        return redirect()->route('courses.index')->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $this->api->delete('/courses/' . $id);

        return redirect()->route('courses.index')->with('success', 'Curso eliminado correctamente.');
    }
}
