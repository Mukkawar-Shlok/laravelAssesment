<?php

namespace App\Jobs;

use App\Models\StockPrice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Redis;

class FetchStockPrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            //logging when job starts
            Log::info("In job");
            //third party api for fetching stock price of reliance
            $response = Http::withHeaders([
                'x-rapidapi-host' => 'real-time-finance-data.p.rapidapi.com',
                'x-rapidapi-key' => env('X_RapidAPI_Key'),
            ])->get('https://real-time-finance-data.p.rapidapi.com/stock-time-series-source-2?symbol=RELIANCE.NS&period=1D');

            // Real time scrapper
            // $stockResponse = Http::get('https://reliance-stock-scrapper.onrender.com/stock-price');
            // $stockPrice = $response->json('stock_price');
            
            if($response->successful()){
                    // Getting the stock price
                $stockPrice = $response->json('data.price');

                //finding record 
                //assuming id 1 is reliance stock
                $stockPriceRecord = StockPrice::find(1);
                
                //if stockPrice record exists
                if($stockPriceRecord){
                    //update the price in DB
                    $stockPriceRecord->update([
                        'price' => $stockPrice,
                        'name' => 'RELIANCE:NSE',
                    ]);
                    //set the data of stock with 60 sec expiration
                    Redis::setex('relianceStock', 60,$stockPrice);
                    // Redis::setex($key, 60, $value);
                }else{
                    //as there is no stockPrice entry make a entry
                    StockPrice::create([
                        'price' => $stockPrice,
                        'name' =>"RELIANCE:NSE"
                    ]);
                    //set the data of stock with 60 sec expiration
                    Redis::setex('relianceStock', 60,$stockPrice);
                }
                
                //log the price of fetched data
                Log::info('Fetched stock price: ' . $stockPrice);
            }else{

                Log::info('Error : Network Request Failed (Check if the limit of rapid api is over!.)');
            
            }
            
        } catch (Exception $e) {
            //Internal server error
            Log::error('Error fetching stock price: ' . $e->getMessage());
        }
    }
}
