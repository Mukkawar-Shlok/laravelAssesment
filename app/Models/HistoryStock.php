<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryStock extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_interval',
        'data',
        'stock_price_id',
    ];
    public function stockPrice()
    {
        return $this->belongsTo(StockPrice::class);
    }
}
