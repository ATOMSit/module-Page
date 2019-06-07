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
    Route::get('/create', function () {
        $structure = '/var/www/atomsit/public/admin/page/projects/website_' . app(\Hyn\Tenancy\Environment::class)->website()->uuid;
        if (!is_dir($structure) === true) {
            if (!mkdir($structure, 0777, true)) {
                return ('Echec lors de la création des répertoires...');
            }
        }

        $array = ([
            "demoMode" => false,
            "project" => "website_" . app(\Hyn\Tenancy\Environment::class)->website()->uuid,
            "mode" => 1,
            "showIntroduction" => false,
            "jets" => true,
            "checkForUpdates" => false,
            "lang" => "en",
            "enableAuthorization" => false,
            "updateServers" => [
                "//update.novibuilder.com"
            ]
        ]);
        $file = '/var/www/atomsit/public/admin/page/config/website_' . app(\Hyn\Tenancy\Environment::class)->website()->uuid . '.json';
        $fp = fopen($file, 'w');
        fwrite($fp, json_encode($array));
        fclose($fp);

        return view('page::index')
            ->with('website_id', app(\Hyn\Tenancy\Environment::class)->website()->uuid);
    });
});
