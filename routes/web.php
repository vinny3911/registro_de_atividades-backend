<?php

use App\Http\Controllers\AtividadeController;
use Illuminate\Support\Facades\Route;

//WEB
Route::redirect('/', '/atividades');
Route::resource('atividades', AtividadeController::class);

//API
Route::get('/api/atividades', [AtividadeController::class, 'list']);


