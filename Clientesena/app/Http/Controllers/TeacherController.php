<?php

namespace App\Http\Controllers;

use App\Services\AdminSenaApi;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct(private AdminSenaApi $api)
    {
    }

    public function index()
    {
        $teachers = $this->api->get('/teachers');

        return view('teacher.index', compact('teachers'));
    }

    public function create()
    {
        $areas = $this->api->get('/areas');
        $trainingCenters = $this->api->get('/training_centers');

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

        $this->api->post('/teachers', $data);

        return redirect()->route('teachers.index')->with('success', 'Instructor registrado correctamente.');
    }

    public function edit(string $id)
    {
        $teacher = $this->api->get('/teachers/' . $id);
        $areas = $this->api->get('/areas');
        $trainingCenters = $this->api->get('/training_centers');

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

        $this->api->put('/teachers/' . $id, $data);

        return redirect()->route('teachers.index')->with('success', 'Instructor actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $this->api->delete('/teachers/' . $id);

        return redirect()->route('teachers.index')->with('success', 'Instructor eliminado correctamente.');
    }
}
