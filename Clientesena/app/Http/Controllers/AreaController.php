<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AreaController extends Controller
{
    private function apiBaseUrl()
    {
        return rtrim((string) env('URL_SERVER_API', ''), '/');
    }

    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);

        return $response->successful() ? $response->json() : [];
    }

    public function index()
    {
        $areas = $this->fetchDataFromApi($this->apiBaseUrl() . '/areas');

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

        Http::post($this->apiBaseUrl() . '/areas', [
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ]);

        return redirect()->route('areas.index')->with('success', 'Área registrada correctamente.');
    }

    public function show($id)
    {
        $area = $this->fetchDataFromApi($this->apiBaseUrl() . '/areas/' . $id);

        return view('area.show', compact('area'));
    }

    public function edit($id)
    {
        $area = $this->fetchDataFromApi($this->apiBaseUrl() . '/areas/' . $id);

        return view('area.edit', compact('area'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Http::put($this->apiBaseUrl() . '/areas/' . $id, [
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ]);

        return redirect()->route('areas.index')->with('success', 'Área actualizada correctamente.');
    }

    public function destroy($id)
    {
        Http::delete($this->apiBaseUrl() . '/areas/' . $id);

        return redirect()->route('areas.index')->with('success', 'Área eliminada correctamente.');
    }
}
