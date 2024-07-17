<?php

use App\Models\StockPrice;
use Illuminate\Support\Facades\Redis;
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
    return view('welcome');
});

Route::get('/reliance/price', function () {
    $stockPriceInstance = StockPrice::where('id',1)->first();
    
    if( $stockPriceInstance ){
    
        return response()->json([
            'message' => 'Data retrieved successfully',
            'data' => json_decode($stockPriceInstance)
        ]);

    }else{
        
        return response()->json(['message'=> 'Failed to fetch data'],404);
    
    }
});

Route::get('/test-redis', function () {
    $key = 'relianceStock';
    $value = Redis::get($key);
    print_r( json_decode($value));
    
    if( $value != null ){
        //data from redis
        return response()->json([
            "message"=>"Price load successfull.",
            "price"=> $value,
            'origin'=>"redis"
        ]);

    }else{
        //$value not found in redis
        $stockPriceInstance = StockPrice::where('id',1)->first();
        // print_r($stockPriceInstance);
        if ($stockPriceInstance) {
            // Assuming $stockPriceInstance->price is a string representation of a price
            $decodedPrice = $stockPriceInstance->price;
    
            return response()->json([
                'message' => 'Data retrieved successfully',
                'price' => $decodedPrice,
                'origin' => 'database'
            ]);
        } else {
            return response()->json(['message' => 'Failed to fetch data'], 404);
        }
    }

});


use Illuminate\Support\Facades\Http;

Route::get('/reliance_stock_history/{period}/{interval}', function ($period, $interval) {
    // Make the HTTP request to the third-party API
    $response = Http::get("https://reliance-stock-scrapper.onrender.com/reliance_stock_history/$period/$interval");

    // Check if the request was successful
    if ($response->successful()) {
        return response()->json([
            'message' => 'Data retrieved successfully',
            'data' => $response->json()
        ]);
    } else {
        return response()->json([
            'error' => 'Failed to fetch data from the API.',
            'status_code' => $response->status()
        ], $response->status());
    }
});
