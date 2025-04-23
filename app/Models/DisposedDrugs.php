<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DisposedDrugs extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'restock_id',
        'drug_id',
        'quantity',
        'expiry_date'
    ];
    
    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
    
    public function stockOrder()
    {
        return $this->belongsTo(StockOrder::class, 'restock_id');
    }
    
    /**
     * Get the selling price for the drug
     * 
     * @return float
     */
    public function getSellingPriceAttribute()
    {
        return Inventory::where('drug_id', $this->drug_id)
            ->max('selling_price') ?? 0;
    }
    
    /**
     * Calculate the loss amount for this disposed drug
     * 
     * @return float
     */
    public function getLossAmountAttribute()
    {
        return $this->quantity * $this->selling_price;
    }
    
    /**
     * Get total losses from all disposed drugs
     * 
     * @return float
     */
    public static function getTotalLosses()
    {
        return DB::table('disposed_drugs')
            ->join('inventories', 'disposed_drugs.drug_id', '=', 'inventories.drug_id')
            ->select(DB::raw('SUM(disposed_drugs.quantity * inventories.selling_price) as total_losses'))
            ->groupBy('disposed_drugs.id')
            ->get()
            ->sum('total_losses');
    }
    
    public static function calculateTotalLosses()
{
    // Use DB facade for direct query to avoid Eloquent issues
    return DB::table('disposed_drugs')
        ->leftJoin(DB::raw('(SELECT drug_id, MAX(selling_price) as max_price FROM inventories GROUP BY drug_id) as inv'), 
              'disposed_drugs.drug_id', '=', 'inv.drug_id')
        ->selectRaw('SUM(disposed_drugs.quantity * COALESCE(inv.max_price, 0)) as total_losses')
        ->value('total_losses') ?? 0;
}
}
