<?php

use App\Http\Controllers\TrackingsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

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


/*Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');*/


Route::get('/', [TrackingsController::class, 'index'])->name('tracking.index');
Route::post('/', [TrackingsController::class, 'store'])->name('tracking.store');
Route::put('/', [TrackingsController::class, 'update'])->name('tracking.update');



/*Route::get('/tracking/{code}', function($code){
    $response = \Illuminate\Support\Facades\Http::get("https://www.linkcorreios.com.br/", [
        'id' => $code
    ]);


    if ($response->ok()) {

        $body = $response->body();

        //remover caracteres especiais
        $body = preg_replace( "/\r|\n|\t/", "", $body );

        //retirar dados
        preg_match_all('/<ul class=\"linha_status\" style=\"\">(.*?)<\/ul>/i', $body, $data);

        $response = array_map(function ($item){
            //remove as tag <li></li>
            preg_match_all('/<li>(.*?)<\/li>/', $item, $row);

            //data e tempo
            $datetime = explode('|', $row[1][1]);
            preg_match('/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/', $datetime[0], $date);
            preg_match('/([0-9]{2}):([0-9]{2})/', $datetime[1], $time);

            //local e origem
            $placeOrOrigin = trim(explode(':', $row[1][2],2)[1]);
            $place = $origin = null;
            if (preg_match('/^local/i', trim($row[1][2]))) {
                $place = $placeOrOrigin;
            } else {
                $origin = $placeOrOrigin;
            }

            //destino
            $destiny = array_key_exists(3, $row[1]) ? trim(explode(':', $row[1][3],2)[1]) : null;

            return [
                'status' => trim(strip_tags(explode(':', $row[1][0], 2)[1])),
                'date' => $date[0],
                'time'=> $time[0],
                'place' => $place,
                'origin' => $origin,
                'destiny' => $destiny
            ];
        }, $data[1]);

        dd($response);

    }

    return 'nao foi posivel capturar o rastreio tente novemnte.';

});*/
