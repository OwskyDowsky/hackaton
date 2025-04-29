<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\BrailleReaderController;
use App\Http\Controllers\CuentaCuentosController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DiasController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
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

/**
 * Braille Reader Routes
 */
Route::prefix('braille-reader')->name('braille.')->group(function () {
    Route::get('/', [BrailleReaderController::class, 'index'])->name('index');
    Route::post('/start', [BrailleReaderController::class, 'start'])->name('start');
    Route::get('/list', [BrailleReaderController::class, 'list'])->name('list');
    Route::get('/outputs', [BrailleReaderController::class, 'outputs'])->name('outputs');
});

Route::prefix('braille')->name('braille.')->group(function () {
    Route::post('/stop', [BrailleReaderController::class, 'stop'])->name('stop');
    Route::post('/pause', [BrailleReaderController::class, 'pause'])->name('pause');
    Route::post('/resume', [BrailleReaderController::class, 'resume'])->name('resume');
});

/**
 * Cuenta Cuentos Routes
 */
Route::prefix('cuentacuentos')->name('cuentacuentos.')->group(function () {
    Route::get('/', [CuentaCuentosController::class, 'index'])->name('index');
    Route::post('/start', [CuentaCuentosController::class, 'start'])->name('start');
    Route::post('/stop', [CuentaCuentosController::class, 'stop'])->name('stop');
});

/**
 * Authenticated Routes
 */
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    // Roles
    Route::resource('roles', RolesController::class);

    // Permissions
    Route::resource('permissions', PermissionsController::class);

    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name('index');
        Route::get('/create', [UsersController::class, 'create'])->name('create');
        Route::post('/create', [UsersController::class, 'store'])->name('store');
        Route::get('/{user}/show', [UsersController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('edit');
        Route::patch('/{user}/update', [UsersController::class, 'update'])->name('update');
        Route::delete('/{user}/delete', [UsersController::class, 'destroy'])->name('destroy');
    });

    // Cursos
    Route::prefix('cursos')->name('cursos.')->group(function () {
        Route::get('/', [CursosController::class, 'index'])->name('index');
        Route::get('/crear', [CursosController::class, 'create'])->name('create');
        Route::post('/crear', [CursosController::class, 'store'])->name('store');
        Route::get('/{curso}/edit', [CursosController::class, 'edit'])->name('edit');
        Route::patch('/{curso}/update', [CursosController::class, 'update'])->name('update');
        Route::get('/{curso}/estudiantes', [CursosController::class, 'estudiante'])->name('estudiantes');
        Route::post('/{curso}/asignar-estudiantes', [CursosController::class, 'asignarEstudiantes'])->name('asignarEstudiantes');
        
        // Días de asistencia relacionados a cursos
        Route::prefix('{curso}/dia')->group(function () {
            Route::get('/', [DiasController::class, 'index'])->name('dias.index');
            Route::get('/{dia}/asistencias', [DiasController::class, 'asistencias'])->name('dias.asistencias');
            Route::post('/{dia}/asistencias', [DiasController::class, 'registrarAsistencia'])->name('dias.registrarAsistencia');
        });
    });

});
