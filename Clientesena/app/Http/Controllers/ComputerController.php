<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminSenaApi;

class ComputerController extends Controller
{
    public function __construct(private AdminSenaApi $api)
    {
    }

    public function index()
    {
        $computers = $this->api->get('/computers');

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

        $this->api->post('/computers', [
            'number' => $request->input('number'),
            'brand'  => $request->input('brand'),
        ]);

        return redirect()->route('computers.index')->with('success', 'Computador creado con éxito.');
    }

    public function show($id)
    {
        $computer = $this->api->get('/computers/' . $id);

        return view('computer.show', compact('computer'));
    }

    public function edit($id)
    {
        $computer = $this->api->get('/computers/' . $id);

        return view('computer.edit', compact('computer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'number' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
        ]);

        $this->api->put('/computers/' . $id, [
            'number' => $request->input('number'),
            'brand' => $request->input('brand'),
        ]);

        return redirect()->route('computers.index')->with('success', 'Computador actualizado con éxito.');
    }

    public function destroy($id)
    {
        $this->api->delete('/computers/' . $id);

        return redirect()->route('computers.index')->with('success', 'Computador eliminado con éxito.');
    }
}
