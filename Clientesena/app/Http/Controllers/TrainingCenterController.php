<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TrainingCenterController extends Controller
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

        $trainingCenter = $this->fetchDataFromApi($url . '/trainingcenter');

        // Apunta a la carpeta 'training_centers'
        return view('training_centers.index', compact('trainingCenter'));
    }

    public function create()
    {
        return view('training_centers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $url = env('URL_SERVER_API');

        $response = Http::post($url . '/trainingcenter', [
            'name' => $request->input('name'),
        ]);

        if ($response->successful()) {
            return redirect()->route('training_centers.index')->with('success', 'Centro creado con éxito.');
        }

        return back()->withInput()->with('error', 'No se pudo guardar en la API.');
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $trainingCenter = $this->fetchDataFromApi($url . '/trainingcenter/' . $id);

        return view('training_centers.show', compact('trainingCenter'));
    }
}
