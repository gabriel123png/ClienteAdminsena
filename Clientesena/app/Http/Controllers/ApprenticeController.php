<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class ApprenticeController extends Controller
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

    private function photoUrl(?string $photo): ?string
    {
        if (! $photo) {
            return null;
        }

        $storageUrl = rtrim((string) config('services.adminsena.storage_url', ''), '/');
        if ($storageUrl === '') {
            $storageUrl = preg_replace('~/api$~', '', $this->apiBaseUrl());
        }

        return $storageUrl . '/storage/' . ltrim($photo, '/');
    }

    private function photoContents(UploadedFile $photo): string
    {
        $contents = file_get_contents($photo->getRealPath());

        if ($contents === false) {
            throw new RuntimeException('No se pudo leer la foto seleccionada.');
        }

        return $contents;
    }

    public function index()
    {
        $apprentices = collect($this->fetchDataFromApi($this->apiBaseUrl() . '/apprentices'))
            ->map(function ($apprentice) {
                $apprentice['photo_url'] = $this->photoUrl(data_get($apprentice, 'photo'));

                return $apprentice;
            });

        return view('apprentice.index', compact('apprentices'));
    }

    public function create()
    {
        $courses = $this->fetchDataFromApi($this->apiBaseUrl() . '/courses');
        $computers = $this->fetchDataFromApi($this->apiBaseUrl() . '/computers');

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

        if ($photo) {
            Http::attach('photo', $this->photoContents($photo), $photo->getClientOriginalName())
                ->post($this->apiBaseUrl() . '/apprentices', $data)
                ->throw();
        } else {
            Http::post($this->apiBaseUrl() . '/apprentices', $data)->throw();
        }

        return redirect()->route('api.v1.apprentices.index')->with('success', 'Aprendiz registrado correctamente.');
    }

    public function show(string $id)
    {
        $apprentice = $this->fetchDataFromApi($this->apiBaseUrl() . '/apprentices/' . $id);
        $photoUrl = $this->photoUrl(data_get($apprentice, 'photo'));

        return view('apprentice.show', compact('apprentice', 'photoUrl'));
    }

    public function edit(string $id)
    {
        $apprentice = $this->fetchDataFromApi($this->apiBaseUrl() . '/apprentices/' . $id);
        $courses = $this->fetchDataFromApi($this->apiBaseUrl() . '/courses');
        $computers = $this->fetchDataFromApi($this->apiBaseUrl() . '/computers');
        $photoUrl = $this->photoUrl(data_get($apprentice, 'photo'));

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
            Http::attach('photo', $this->photoContents($photo), $photo->getClientOriginalName())
                ->post($this->apiBaseUrl() . '/apprentices/' . $id, $data + ['_method' => 'PUT'])
                ->throw();
        } else {
            Http::put($this->apiBaseUrl() . '/apprentices/' . $id, $data)->throw();
        }

        return redirect()->route('api.v1.apprentices.index')->with('success', 'Aprendiz actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        Http::delete($this->apiBaseUrl() . '/apprentices/' . $id)->throw();

        return redirect()->route('api.v1.apprentices.index')->with('success', 'Aprendiz eliminado correctamente.');
    }
}
