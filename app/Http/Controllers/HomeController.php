<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cantidadEstudiantes = User::role('Estudiantes')->count();
        $cantidadProfesores = User::role('Profesores')->count();
        $cantidadPadres = User::role('Padre de familia')->count();
        $cantidadUsuarios = User::count(); // Todos los usuarios

        return view('home', compact(
            'cantidadEstudiantes',
            'cantidadProfesores',
            'cantidadPadres',
            'cantidadUsuarios'
        ));
    }


    public function about()
    {
        return view('about');
    }
}
