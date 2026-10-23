<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TrainingCenterController extends Controller
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
        $trainingCenters = $this->fetchDataFromApi($this->apiBaseUrl() . '/training_centers');

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

        Http::post($this->apiBaseUrl() . '/training_centers', [
            'name' => $request->input('name'),
            'location' => $request->input('location'),
        ])->throw();

        return redirect()->route('api.v1.training_centers.index')->with('success', 'Centro creado con éxito.');
    }

    public function show($id)
    {
        $trainingCenter = $this->fetchDataFromApi($this->apiBaseUrl() . '/training_centers/' . $id);

        return view('training_centers.show', compact('trainingCenter'));
    }

    public function edit($id)
    {
        $trainingCenter = $this->fetchDataFromApi($this->apiBaseUrl() . '/training_centers/' . $id);

        return view('training_centers.edit', compact('trainingCenter'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Http::put($this->apiBaseUrl() . '/training_centers/' . $id, [
            'name' => $request->input('name'),
            'location' => $request->input('location'),
        ])->throw();

        return redirect()->route('api.v1.training_centers.index')->with('success', 'Centro actualizado con éxito.');
    }

    public function destroy($id)
    {
        Http::delete($this->apiBaseUrl() . '/training_centers/' . $id)->throw();

        return redirect()->route('api.v1.training_centers.index')->with('success', 'Centro eliminado con éxito.');
    }
}
