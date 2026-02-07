<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PeliculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $peliculas = Pelicula::all();
        return view('peliculas.index', compact('peliculas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('peliculas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'titulo' => 'required|string',
            'duracion' => 'required|integer'
        ]);
        Pelicula::create($request->all());
        return redirect::route('peliculas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(pelicula $pelicula)
    {
        return view('peliculas.show', compact('pelicula'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pelicula $pelicula)
    {
        //
        return view('peliculas.edit', compact('pelicula'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pelicula $pelicula)
    {
        //
        $request->validate([
            'titulo' => 'required|string',
            'duracion' => 'required|integer'
        ]);
        $pelicula->update($request->all());
        return redirect::route('peliculas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pelicula $pelicula)
    {
        //
        $pelicula->delete();
        return redirect::route('peliculas.index');
    }
}
