<?php

namespace App\Console\Commands;

use App\Jobs\FetchStockPrice;
use Illuminate\Console\Command;

class FetchStockPriceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:stock-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches stock price from API and logs it';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch(new FetchStockPrice());
    }
}
