<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function stockEntries()
{
    return $this->hasMany(StockEntry::class);
}

public function inventoryItems()
{
    return $this->hasMany(Inventory::class);
}

public function inventory(){
    return $this->hasOne(Inventory::class);
}
    
    
}
