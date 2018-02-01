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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    $query = http_build_query([
        'client_id'     => '4',
        'redirect_uri'  => 'http://localhost:1234/test',
        'response_type' => 'code',
        'scope'         => '',
    ]);

    return redirect('http://localhost:8000/oauth/authorize?' . $query);
});

Route::get('/test', function () {

    $http = new GuzzleHttp\Client;

    if (request('code')) {
        $response = $http->post('http://localhost:8000/oauth/token', [
            'form_params' => [
                'grant_type'    => 'authorization_code',
                'client_id'     => '4',
                'client_secret' => 'FFpaYiJKoqA5niyPPMngIm5t0C4yhIu1Gp5f8m55',
                'redirect_uri'  => 'http://localhost:1234/test',
                'code'          => request('code'),
            ],
        ]);

        return json_decode((string)$response->getBody(), TRUE);
    } else {
        return response()->json(['error' => request('error')]);
    }
});

