<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComputerController extends Controller
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

        $computer = $this->fetchDataFromApi($url . '/computer');

        return view('computer.index', compact('computer'));
    }

    public function create()
    {
        return view('computer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|string|max:255',
            'brand'  => 'required|string|max:255',
        ]);

        $url = env('URL_SERVER_API');

        $response = Http::post($url . '/computer', [
            'number' => $request->input('number'),
            'brand'  => $request->input('brand'),
        ]);

        if ($response->successful()) {
            return redirect()->route('computers.index')->with('success', 'Computador creado con éxito.');
        }

        return back()->withInput()->with('error', 'No se pudo guardar el computador en la API.');
    }

    public function show($id)
    {
        $url = env('URL_SERVER_API');

        $computer = $this->fetchDataFromApi($url . '/computer/' . $id);

        return view('computer.show', compact('computer'));
    }
}
