<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.principal');
})->name('principal');

Route::resource('aluno', 'AlunoController');

Route::get('escola', 'EscolaController@index')->name('escola.index');
Route::post('escola', 'EscolaController@store')->name('escola.store');
Route::get('escola/create', 'EscolaController@create')->name('escola.create');
Route::get('escola/{escola}', 'EscolaController@show')->name('escola.show');
Route::put('escola/{escola}', 'EscolaController@update')->name('escola.update');
Route::delete('escola/{escola}', 'EscolaController@destroy')->name('escola.destroy');
Route::get('escola/{escola}/edit', 'EscolaController@edit')->name('escola.edit');

Route::resource('turma', 'TurmaController');