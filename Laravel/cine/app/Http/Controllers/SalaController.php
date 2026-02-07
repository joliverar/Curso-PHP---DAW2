<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SalaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $salas = Sala::all();
        return view('salas.index', compact('salas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('salas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nombre' => 'required|string',
            'aforo' => 'required|integer'
        ]);
        Sala::create($request->all());
        return redirect::route('salas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(sala $sala)
    {
        //
        return view('salas.show', compact('sala'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(sala $sala)
    {
        //
        return view('salas.edit', compact('sala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, sala $sala)
    {
        //
        $request->validate([
            'nombre' => 'required|string',
            'aforo' => 'required|integer'
        ]);
        $sala->update($request->all());
        return redirect::route('salas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(sala $sala)
    {
        //
        $sala->delete();
        return redirect::route('salas.index');
    }
}
