<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_id',
        'drug_id',
        'quantity',
        'selling_price',
        'customer_name',
        'total_price'
        
    ];

    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

}
