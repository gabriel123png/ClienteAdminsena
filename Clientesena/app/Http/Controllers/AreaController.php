<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class AreaController extends Controller
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
        $areas = [];

        return view('area.index', [
            'areas' => $areas,
        ]);
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
        ])->throw();

        return redirect()->route('api.v1.areas.index')->with('success', 'Área registrada correctamente.');
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
        ])->throw();

        return redirect()->route('api.v1.areas.index')->with('success', 'Área actualizada correctamente.');
    }

    public function destroy($id)
    {
        Http::delete($this->apiBaseUrl() . '/areas/' . $id)->throw();

        return redirect()->route('api.v1.areas.index')->with('success', 'Área eliminada correctamente.');
    }
    
}
