<?php

use Goutte\Client;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrapingController;

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



Route::get('/', [ScrapingController::class, 'scrapeWebsite']);
Route::get('/scraping', [ScrapingController::class, 'scrapingView']);

