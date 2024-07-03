<?php

// use App\Models\Article;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\WorkplanController;
use App\Http\Controllers\PekanEsportController;

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

// Route::view('/', 'homepage')->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/structure', [StructureController::class, 'index'])->name('structure');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/article', [ArticleController::class, 'index'])->name('article');
Route::get('/article/{slug}', [ArticleController::class, 'detail'])->name('article.detail');
Route::get('/workplan', [WorkplanController::class, 'index'])->name('workplan');

Route::get('/event/{link_registration}', [EventController::class, 'index'])->name('event.form');
Route::post('/event/{link_registration}', [EventController::class, 'submit'])->name('event.form.submit');

Route::get('/pekanesport', [PekanEsportController::class, 'index'])->name('pekanesport');
Route::get('/pekanesport/register', [PekanEsportController::class, 'form'])->name('pekanesport.form');
Route::get('/pekanesport/{game}', [PekanEsportController::class, 'game'])->name('pekanesport.game');
Route::post('/pekanesport/register', [PekanEsportController::class, 'formSubmit'])->name('pekanesport.form.submit');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';

Route::redirect('/login', '/admin')->name('login');
Route::redirect('/register', '/admin')->name('register');
