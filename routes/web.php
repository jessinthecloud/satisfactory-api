<?php

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

Route::get('/', function () {
//    dump(json_decode(Storage::disk('public')->get('data.json')));
    $data = Cache::remember('raw-data', 300, function () {
        return collect(json_decode(Storage::disk('public')->get('data.json')));
    });

//    dd($data->all());
//    dd($data->all()['items']->Desc_Coal_C, $data->all()['resources']->Desc_Coal_C);
    dd($data->all()['miners']->Build_MinerMk2_C, $data->all()['buildings']->Desc_MinerMk2_C);
//    dd($data->all()['items']->Desc_AluminumIngot_C);

    
    $data->each(function ($item, $key) {
        
    });
    
});
