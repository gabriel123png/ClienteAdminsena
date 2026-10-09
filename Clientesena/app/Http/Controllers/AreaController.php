<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
class AreaController extends Controller
{
    // Método privado para manejar llamadas HTTP repetitivas
    private function fetchDataFromApi($url)
    {
        $response = Http::get($url);

        return $response->json();
    }

    public function index()
    {
        $url = env('URL_SERVER_API');

        $area = $this->fetchDataFromApi($url.'/area');

        return view('area.index', compact('area'));
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $area = $this->fetchDataFromApi($url.'/area/'.$id);

        return view('area.show', compact('area'));
    }


    public function create()
    {
        return view('area.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $url = env('URL_SERVER_API');

        $response = Http::post($url.'/area', [
            'nombre'      => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ]);

        if ($response->successful()) {
            return redirect()->route('areas.index')->with('success', 'Área creada con éxito.');
        }

        return back()->withInput()->with('error', 'No se pudo guardar el área en la API.');
    }
}
