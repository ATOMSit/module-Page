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

Route::prefix('page')->group(function () {
    Route::get('/', function () {

        $path = storage_path() . '/app/public/websites/' . app(\Hyn\Tenancy\Environment::class)->website()->uuid . '-website/template';


        $file = '/var/www/atomsit/modules/Page/Resources/views/themes/beer/index.html';


        if (!copy($file, $path . '/index.html')) {
            echo "La copie $file du fichier a échoué...\n";
        }

        $path = "storage/websites/" . app(\Hyn\Tenancy\Environment::class)->website()->uuid . "-website";
        return view('page::index')
            ->with('path', $path);
    });
});
