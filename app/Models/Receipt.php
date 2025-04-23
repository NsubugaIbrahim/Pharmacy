<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_number',
        'customer_name',
        'total_price'
        
    ];

    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }

    

public function sales()
{
    return $this->hasMany(Sale::class, 'receipt_id');
}

}
