<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class AdminSenaApi
{
    public function get(string $path, array $query = [])
    {
        $response = $this->request()->get($this->endpoint($path), $query)->throw();

        return $this->data($response->json());
    }

    public function post(string $path, array $data = [], ?UploadedFile $photo = null)
    {
        $request = $this->withPhoto($this->request(), $photo);

        return $this->data($request->post($this->endpoint($path), $data)->throw()->json());
    }

    public function put(string $path, array $data = [], ?UploadedFile $photo = null)
    {
        $request = $this->withPhoto($this->request(), $photo);

        return $this->data($request->put($this->endpoint($path), $data)->throw()->json());
    }

    public function delete(string $path): void
    {
        $this->request()->delete($this->endpoint($path))->throw();
    }

    public function photoUrl(?string $photo): ?string
    {
        if (! $photo) {
            return null;
        }

        $baseUrl = rtrim((string) config('services.adminsena.url', ''), '/');
        $storageUrl = rtrim((string) config('services.adminsena.storage_url', ''), '/');
        $baseUrl = preg_replace('~/api$~', '', $baseUrl);
        $storageUrl = $storageUrl !== '' ? $storageUrl : $baseUrl;

        return $storageUrl . '/storage/' . ltrim($photo, '/');
    }

    private function request(): PendingRequest
    {
        $baseUrl = rtrim(trim((string) config('services.adminsena.url', '')), '/;');

        if ($baseUrl === '') {
            throw new RuntimeException('Falta configurar URL_SERVER_API en el archivo .env.');
        }

        return Http::baseUrl($baseUrl . '/')->acceptJson();
    }

    private function withPhoto(PendingRequest $request, ?UploadedFile $photo): PendingRequest
    {
        if (! $photo) {
            return $request;
        }

        $contents = file_get_contents($photo->getRealPath());

        if ($contents === false) {
            throw new RuntimeException('No se pudo leer la foto seleccionada.');
        }

        return $request->attach(
            'photo',
            $contents,
            $photo->getClientOriginalName(),
            ['Content-Type' => $photo->getMimeType()]
        );
    }

    private function endpoint(string $path): string
    {
        return ltrim($path, '/');
    }

    private function data($payload)
    {
        if (is_array($payload) && array_key_exists('data', $payload)) {
            return $payload['data'];
        }

        return $payload;
    }
}
