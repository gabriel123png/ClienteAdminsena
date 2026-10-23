<?php

namespace App\Http\Controllers;

use App\Services\AdminSenaApi;
use Illuminate\Http\Request;

class ApprenticeController extends Controller
{
    public function __construct(private AdminSenaApi $api)
    {
    }

    public function index()
    {
        $apprentices = collect($this->api->get('/apprentices'))
            ->map(function ($apprentice) {
                $apprentice['photo_url'] = $this->api->photoUrl(data_get($apprentice, 'photo'));

                return $apprentice;
            });

        return view('apprentice.index', compact('apprentices'));
    }

    public function create()
    {
        $courses = $this->api->get('/courses');
        $computers = $this->api->get('/computers');

        return view('apprentice.create', compact('courses', 'computers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cell_number' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'course_id' => 'required|integer',
            'computer_id' => 'nullable|integer',
        ]);

        $photo = $request->file('photo');
        unset($data['photo']);

        $this->api->post('/apprentices', $data, $photo);

        return redirect()->route('apprentices.index')->with('success', 'Aprendiz registrado correctamente.');
    }

    public function show(string $id)
    {
        $apprentice = $this->api->get('/apprentices/' . $id);
        $photoUrl = $this->api->photoUrl(data_get($apprentice, 'photo'));

        return view('apprentice.show', compact('apprentice', 'photoUrl'));
    }

    public function edit(string $id)
    {
        $apprentice = $this->api->get('/apprentices/' . $id);
        $courses = $this->api->get('/courses');
        $computers = $this->api->get('/computers');
        $photoUrl = $this->api->photoUrl(data_get($apprentice, 'photo'));

        return view('apprentice.edit', compact('apprentice', 'courses', 'computers', 'photoUrl'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cell_number' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'course_id' => 'required|integer',
            'computer_id' => 'nullable|integer',
        ]);

        $photo = $request->file('photo');
        unset($data['photo']);

        if ($photo) {
            $this->api->post('/apprentices/' . $id, $data + ['_method' => 'PUT'], $photo);
        } else {
            $this->api->put('/apprentices/' . $id, $data);
        }

        return redirect()->route('apprentices.index')->with('success', 'Aprendiz actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $this->api->delete('/apprentices/' . $id);

        return redirect()->route('apprentices.index')->with('success', 'Aprendiz eliminado correctamente.');
    }
}
