<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'restock_id',
        'drug_id',
        'quantity',
        'selling_price',
        'expiry_date',
    ];
    
    // Relationships
    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
    
    public function stockOrder()
    {
        return $this->belongsTo(StockOrder::class, 'restock_id');
    }
}
