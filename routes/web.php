<?php
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DiasController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Models\DiasAsistencias;

use App\Http\Controllers\CuentaCuentosController;

use App\Http\Controllers\CuentaCuentosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BrailleReaderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

/**
 * Auth Routes
 */
Auth::routes(['verify' => false]);

Route::get('/braille-reader', [BrailleReaderController::class, 'index'])->name('braille.index');
Route::post('/braille-reader/start', [BrailleReaderController::class, 'start'])->name('braille.start');
Route::get('/braille-reader/list', [BrailleReaderController::class, 'list'])->name('braille.list');
Route::post('/braille/stop', [BrailleReaderController::class, 'stop'])->name('braille.stop');
Route::post('/braille/pause', [BrailleReaderController::class, 'pause'])->name('braille.pause');
Route::post('/braille/resume', [BrailleReaderController::class, 'resume'])->name('braille.resume');
Route::get('/braille-outputs', [BrailleReaderController::class, 'outputs'])->name('braille.outputs');

// Detener el narrador
Route::post('/cuentacuentos/stop', [CuentaCuentosController::class, 'stop'])->name('cuentacuentos.stop');
Route::get('/cuentacuentos', [CuentaCuentosController::class, 'index'])->name('cuentacuentos.index');
Route::post('/cuentacuentos/start', [CuentaCuentosController::class, 'start'])->name('cuentacuentos.start');
Route::group(['namespace' => 'App\Http\Controllers'], function()
{
Route::post('/cuentacuentos/stop', [CuentaCuentosController::class, 'stop'])->name('cuentacuentos.stop');


Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::middleware('auth')->group(function () {
        /**
         * Home Routes
         */
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
        /**
         * Role Routes
         */
        Route::resource('roles', RolesController::class);
        /**
         * Permission Routes
         */
        Route::resource('permissions', PermissionsController::class);
        /**
         * User Routes
         */
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [App\Http\Controllers\UsersController::class, 'index'])->name('users.index');
            Route::get('/create', 'UsersController@create')->name('users.create');
            Route::post('/create', 'UsersController@store')->name('users.store');
            Route::get('/{user}/show', 'UsersController@show')->name('users.show');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
            Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
        });

        //cursos
        Route::get('/cursos', [CursosController::class, 'index'])->name('cursos.index');
        Route::get('/cursos/crear', [CursosController::class, 'create'])->name('cursos.create');
        Route::post('/cursos/crear', [CursosController::class, 'store'])->name('cursos.store');
        Route::get('/{curso}/edit', [CursosController::class, 'edit'])->name('cursos.edit');
        Route::patch('/{curso}/update', [CursosController::class, 'update'])->name('cursos.update');
        Route::get('/cursos/{curso}/estudiantes', [CursosController::class, 'estudiante'])->name('cursos.estudiantes');
        Route::post('/cursos/{curso}/asignar-estudiantes', [CursosController::class, 'asignarEstudiantes'])->name('cursos.asignarEstudiantes');

        //dia
        Route::get('/{curso}/dia', [DiasController::class, 'index'])->name('dias.index');
        Route::get('/{curso}/{dia}/asistencias', [DiasController::class, 'asistencias'])->name('dias.asistencias');
        Route::post('/{curso}/{dia}/asistencias', [DiasController::class, 'registrarAsistencia'])->name('dias.registrarAsistencia');

    });
});
