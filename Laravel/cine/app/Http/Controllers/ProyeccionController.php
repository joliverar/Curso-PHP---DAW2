<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Proyeccion;
use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProyeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $proyecciones = Proyeccion::all();
        return view('proyecciones.index', compact('proyecciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $peliculas = Pelicula::all();
        $salas = Sala::all();
        return view('proyecciones.create', compact('peliculas', 'salas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'pelicula_id' => 'required|exists:peliculas,id',
            'sala_id' => 'required|exists:salas,id',
            'fecha_hora' => 'required|date'
        ]);
        Proyeccion::create($request->all());
        return redirect::route('proyecciones.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(proyeccion $proyeccion)
    {
        //
        // dd($proyeccion, $proyeccion->pelicula, $proyeccion->sala);
        return view('proyecciones.show', compact('proyeccion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(proyeccion $proyeccion)
    {
        //
        $peliculas = Pelicula::all();
        $salas = Sala::all();

        return view('proyecciones.edit', compact('proyeccion', 'peliculas', 'salas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, proyeccion $proyeccion)
    {
        //
        $request->validate([
            'pelicula_id' => 'required|integer',
            'sala_id' => 'required|integer',
            'fecha_hora' => 'required|date'
        ]);

        $proyeccion->update($request->all());
        return redirect::route('proyecciones.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(proyeccion $proyeccion)
    {
        //
        $proyeccion->delete();
        return redirect::route('proyecciones.index');
    }
}
