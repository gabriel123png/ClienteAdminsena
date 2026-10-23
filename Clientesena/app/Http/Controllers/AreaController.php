<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use App\Services\AdminSenaApi;

class AreaController extends Controller
{
    public function __construct(private AdminSenaApi $api)
    {
    }

    public function index()
    {
        try {
            $areas = $this->api->get('/areas');
        } catch (RequestException $exception) {
            if ($exception->response->status() !== 401) {
                throw $exception;
            }

            return view('area.index', [
                'areas' => [],
                'error' => 'El servidor API requiere autenticación para consultar las áreas.',
            ]);
        }

        return view('area.index', compact('areas'));
    }

    public function create()
    {
        return view('area.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $this->api->post('/areas', [
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ]);

        return redirect()->route('areas.index')->with('success', 'Área registrada correctamente.');
    }

    public function show($id)
    {
        $area = $this->api->get('/areas/' . $id);

        return view('area.show', compact('area'));
    }

    public function edit($id)
    {
        $area = $this->api->get('/areas/' . $id);

        return view('area.edit', compact('area'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $this->api->put('/areas/' . $id, [
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ]);

        return redirect()->route('areas.index')->with('success', 'Área actualizada correctamente.');
    }

    public function destroy($id)
    {
        $this->api->delete('/areas/' . $id);

        return redirect()->route('areas.index')->with('success', 'Área eliminada correctamente.');
    }
    
}
