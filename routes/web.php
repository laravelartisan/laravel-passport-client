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
        'client_id'     => '3',
        'redirect_uri'  => 'http://localhost:1234/test',
        'response_type' => 'code',
        'scope'         => '',
    ]);

    return redirect('http://localhost:8000/oauth/authorize?' . $query);
});

//implicit
Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://localhost/test',
        'response_type' => 'token',
        'scope' => '',
    ]);

    return redirect('http://localhost:8000/oauth/authorize?'.$query);
});

Route::get('/test', function () {

    $http = new GuzzleHttp\Client;

    if (request('code')) {
        $response = $http->post('http://localhost:8000/oauth/token', [
            'form_params' => [
                'grant_type'    => 'authorization_code',
                'client_id'     => '3',
                'client_secret' => 'PtmvmhBknxDHfwB2ceLCHRunBHTflvrvgc03Zw6B',
                'redirect_uri'  => 'http://localhost:1234/test',
                'code'          => request('code'),
            ],
        ]);

        return json_decode((string)$response->getBody(), TRUE);
    } else {
        return response()->json(['error' => request('error')]);
    }
});

Route::get('/refresh', function () {

    $http = new GuzzleHttp\Client;

    $response = $http->post('http://localhost:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'refresh_token',
            'refresh_token' => 'def50200c6aa54f83a9a905153f7fd580e62e266dfff50d86a22ef007716ac71b86bb5ae05e61b2785be835366cc310c2c008929de933278e3cda6c5d714c76c5db4edb01ee5eb6e1df3d3309ad80ceabfa4c92beea2bce70fe09182e50fa1f3c34d4ef2c8b535bea25d10943afefe91b77874a39546a4829ef3a9b18237e661e6f95466e683081ee3177eab0ea7bbc945185f939a45752e8ab4958118b3ff01dea88710aedab850996609368502dcafe19524ea7c85ccc626308a41e9497689d927110dd2db1bb7ad48726ed1e6387716dce8dbaa9415292751fa90a8dc32281293bc55cb5389d25d09535ca6f8ef6fd5744d137e5233b371096246c91c411b468bf5c37bdb653f0436bcdd7600fa91b34213bfe55c0bacaadf96f8fc845e3c593afe1f423cdbd15383990f1346151547d2fca3a4f2332b84b3a83bb5863e6200f03067375a2f2533484295f3a5ce7f327f7bf4693ed46d4e555ba327e1f2d069',
            'client_id' => '3',
            'client_secret' => 'PtmvmhBknxDHfwB2ceLCHRunBHTflvrvgc03Zw6B',
            'scope' => '',
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

Route::get('/auth', function () {

    $http = new GuzzleHttp\Client;

    $response = $http->post('http://localhost:8000/oauth/token', [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => '4',
            'client_secret' => 'MvplWPMOe039etgtc6UjPlWRVJbZErtukL3SiYXT',
            'username' => 'raja@email.com',
            'password' => '123456',
            'scope' => '*',
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});

