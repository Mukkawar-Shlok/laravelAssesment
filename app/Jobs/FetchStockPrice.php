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
            Log::info("In job");
            $response = Http::get('https://reliance-stock-scrapper.onrender.com/stock-price');
            
            $stockPrice = $response->json('stock_price');
            $stockPriceRecord = StockPrice::find(1);
            if($stockPriceRecord){
                $stockPriceRecord->update([
                    'price' => $stockPrice,
                    'name' => 'RELIANCE:NSE',
                ]);
                Redis::setex('relianceStock', 60,$stockPrice);
                // Redis::setex($key, 60, $value);
            }else{
                StockPrice::create([
                    'price' => $stockPrice,
                    'name' =>"RELIANCE:NSE"
                ]);
                Redis::setex('relianceStock', 60,$stockPrice);
            }
            
            
            Log::info('Fetched stock price: ' . $stockPrice);
        } catch (Exception $e) {
            Log::error('Error fetching stock price: ' . $e->getMessage());
        }
    }
}
