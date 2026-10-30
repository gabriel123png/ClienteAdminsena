<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ComputerController extends Controller
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
        $computers = $this->fetchDataFromApi($this->apiBaseUrl() . '/computers');
 
        return view('computer.index', compact('computers'));
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
 
        Http::acceptJson()->post($this->apiBaseUrl() . '/computers', [
            'number' => $request->input('number'),
            'brand'  => $request->input('brand'),
        ])->throw();
 
        return redirect()->route('api.v1.computers.index')->with('success', 'Computador creado con éxito.');
    }
 
    public function show($id)
    {
        $computer = $this->fetchDataFromApi($this->apiBaseUrl() . '/computers/' . $id);
 
        return view('computer.show', compact('computer'));
    }
 
    public function edit($id)
    {
        $computer = $this->fetchDataFromApi($this->apiBaseUrl() . '/computers/' . $id);
 
        return view('computer.edit', compact('computer'));
    }
 
    public function update(Request $request, $id)
    {
        $request->validate([
            'number' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
        ]);
 
        Http::acceptJson()->put($this->apiBaseUrl() . '/computers/' . $id, [
            'number' => $request->input('number'),
            'brand' => $request->input('brand'),
        ])->throw();
 
        return redirect()->route('api.v1.computers.index')->with('success', 'Computador actualizado con éxito.');
    }
 
    public function destroy($id)
    {
        Http::acceptJson()->delete($this->apiBaseUrl() . '/computers/' . $id)->throw();
 
        return redirect()->route('api.v1.computers.index')->with('success', 'Computador eliminado con éxito.');
    }
}
 