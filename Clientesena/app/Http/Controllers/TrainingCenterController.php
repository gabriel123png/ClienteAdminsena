<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminSenaApi;

class TrainingCenterController extends Controller
{
    public function __construct(private AdminSenaApi $api)
    {
    }

    public function index()
    {
        $trainingCenters = $this->api->get('/training_centers');

        return view('training_centers.index', compact('trainingCenters'));
    }

    public function create()
    {
        return view('training_centers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $this->api->post('/training_centers', [
            'name' => $request->input('name'),
            'location' => $request->input('location'),
        ]);

        return redirect()->route('training_centers.index')->with('success', 'Centro creado con éxito.');
    }

    public function show($id)
    {
        $trainingCenter = $this->api->get('/training_centers/' . $id);

        return view('training_centers.show', compact('trainingCenter'));
    }

    public function edit($id)
    {
        $trainingCenter = $this->api->get('/training_centers/' . $id);

        return view('training_centers.edit', compact('trainingCenter'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $this->api->put('/training_centers/' . $id, [
            'name' => $request->input('name'),
            'location' => $request->input('location'),
        ]);

        return redirect()->route('training_centers.index')->with('success', 'Centro actualizado con éxito.');
    }

    public function destroy($id)
    {
        $this->api->delete('/training_centers/' . $id);

        return redirect()->route('training_centers.index')->with('success', 'Centro eliminado con éxito.');
    }
}
