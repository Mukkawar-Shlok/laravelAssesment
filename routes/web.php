<?php

use App\Models\StockPrice;
use App\Models\HistoryStock;
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
    //sample function to check if the server is running properly
    return view('welcome');
});


//api only for fetching from DB
Route::get('/reliance/price', function () {
    //asumming only one stock exists that is reliance
    //in case of multiple stocks we can just pass id in url and use it.
    try{
        //fetching stock instance 
        $stockPriceInstance = StockPrice::where('id',1)->first();
    
        if( $stockPriceInstance ){
            //return stockprice instance
            return response()->json([
                'message' => 'Data retrieved successfully',
                'data' => json_decode($stockPriceInstance)
            ]);
    
        }else{
            //failed to retrive data
            return response()->json(['message'=> 'Failed to fetch data'],404);
        
        }
    }catch (\Exception $e) {
        //in error
        return response()->json([
            'message' => 'Internal Server Error.',
            'error'=>$e->getMessage()
        ], 500);
    }
});

//api for getting reliance price from db or redis
Route::get('/reliance/redis/price', function () {
    try{
        //key is set to relianceStock assuming only one stock exists
        //in case of multiple we can just pass that in url 
        $key = 'relianceStock';
        //retreive the value
        $value = Redis::get($key);

        //logs for debugging
        // print_r( json_decode($value));
        
        //if there is data in redis
        if( $value != null ){
            //data from redis
            return response()->json([
                "message"=>"Reliance Stock Price load successfull.",
                "price"=> $value,
                'origin'=>"redis"
            ]);
        }else{
            //$value not found in redis
            $stockPriceInstance = StockPrice::where('id',1)->first();
            
            //logs for debugging
            // print_r($stockPriceInstance);
            
            if ($stockPriceInstance) {
                // extracting price
                $decodedPrice = $stockPriceInstance->price;
                //returning extracted data
                return response()->json([
                    'message' => 'Reliance Stock Price load successfull.',
                    'price' => $decodedPrice,
                    'origin' => 'database'
                ]);
            } else {
                //failed to fetch data
                return response()->json(['message' => 'Failed to fetch data'], 404);
            }
        }

    }catch(\Exception $e){
        return response()->json([
            'message' => 'Internal Server Error.',
            'error' =>$e->getMessage()
        ], 500);
    }
});


//api for getting history from Redis->DB->API
Route::get('/reliance_stock/history/{interval}', function ($interval) {
    try{
        //creating key with interwal,from and to date
        //1 here is stockPriceId for identifying stock
        //Assuming only one stock exists
    $cacheKey = "reliance_stock_history_{$interval}_1";

    //if key exists in redis
    if (Redis::exists($cacheKey)) {
        //retrieve data
        $cachedResponse = Redis::get($cacheKey);
        //return data
        return response()->json([
            'message' => 'Data retrieved successfully from cache',
            'data' => json_decode($cachedResponse, true),
            'origin'=>"redis"
        ]);
    }
    
    //checking if key exists in DB
    $historyStock = HistoryStock::where('date_interval', $cacheKey)->first();
    //if there is instance of data
    if ($historyStock) {
        // store it in redis for caching
        Redis::setex($cacheKey, 3600, $historyStock->data);

        //returning data
        return response()->json([
            'message' => 'Data retrieved successfully from database',
            'data' => json_decode($historyStock->data, true),
            'origin' => "database"
        ]);
    }

    //now fetching from API
    $response = Http::withHeaders([
        'x-rapidapi-host' => 'real-time-finance-data.p.rapidapi.com',
        'x-rapidapi-key' => env('X_RapidAPI_Key'),
    ])->get('https://real-time-finance-data.p.rapidapi.com/stock-time-series-source-2?symbol=RELIANCE.NS&period={$interval}');


    //if api response is sucessful
    if ($response->successful()) {
        //converting data into json format
        $responseData = $response->json();
        //setting value in redis with 1 hour expiration
        Redis::setex($cacheKey, 3600, json_encode($responseData));
        //as it does not exists inside DB create instance and insert it
        HistoryStock::insert([
            'date_interval' => $cacheKey,
            'data' => json_encode($responseData),
            'stock_price_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        //return data
        return response()->json([
            'message' => 'Data retrieved successfully',
            'data' => $responseData,
            'origin'=>"API"
        ]);
    } else {
        //failed to fetch data from api
        return response()->json([
            'error' => 'Failed to fetch data from the API.',
            'status_code' => $response->status()
        ], $response->status());
    }

    }catch (\Exception $e){
        //internal server error
        return response()->json([
            'message' => 'Internal Server Error.',
            'error'=>$e->getMessage()
        ]);
    }
});


//api for clearing out redis
Route::get('/clear_redis_cache', function () {
    try{
        //clear redis
        Redis::flushall();
        //return response
        return response()->json([
            'message' => 'Redis cache cleared successfully'
        ]);

    }catch (\Exception $e){
        //return internal server error
        return response()->json([
            'message' => 'Internal Server Error.',
            'error'=>$e->getMessage()
        ]);
    }
});