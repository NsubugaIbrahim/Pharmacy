<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOrder extends Model
{
    use HasFactory;

    protected $table = 'stock_orders';
    
    protected $fillable = [
        'supplier_id',
        'date',
        'total',
        'status',
    ];
    
    public function stockEntries()
    {
        return $this->hasMany(StockEntry::class, 'restock_id');
    }
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function orderItems()
    {
        return $this->hasMany(StockEntry::class, 'restock_id');
    }
}