<?php

namespace App\Http\Controllers;

use App\Models\StockEntry;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\DisposedDrugs;

use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function updatePrice(Request $request, $drugId)
    {
        // Validate the request
        $request->validate([
            'selling_price' => 'required|numeric|min:0',
        ]);

        // Update the selling price for all inventory items of this drug
        DB::table('inventories')
            ->where('drug_id', $drugId)
            ->update(['selling_price' => $request->selling_price]);

        return redirect()->route('stock.show')
            ->with('success', 'Drug price updated successfully');
    }

    public function getSellingPrice($drugId)
    {
        // Get the most recent inventory record (can customize based on logic)
        $inventory = Inventory::where('drug_id', $drugId)
            ->where('quantity', '>', 0)
            ->orderBy('expiry_date') // Optional: choose closest expiry
            ->first();

        if ($inventory) {
            return response()->json(['selling_price' => $inventory->selling_price]);
        }

        return response()->json(['selling_price' => 0], 404);
    }

    public function nearExpiry(){
        $oneMonthLater = now()->addMonth();
        
        $expiringDrugs = Inventory::with('drug')
            ->where('expiry_date', '<=', $oneMonthLater)
            ->where('quantity', '>', 0)
            ->orderBy('expiry_date', 'asc')
            ->get();
        
        return view('expiry.expiry-alert', compact('expiringDrugs'));
    }

    public function expiredDrugs()
    {
        $today = now();
        
        $expiredDrugs = Inventory::with('drug')
            ->where('expiry_date', '<', $today)
            ->where('quantity', '>', 0)
            ->orderBy('expiry_date', 'asc')
            ->get();
        
        return view('expiry.expired-drugs', compact('expiredDrugs'));
    }
    
    public function disposeDrug($id)
    {
        $inventory = Inventory::findOrFail($id);
        
        // Create a record in disposed_drugs table
        DisposedDrugs::create([
            'restock_id' => $inventory->restock_id,
            'drug_id' => $inventory->drug_id,
            'quantity' => $inventory->quantity,
            'expiry_date' => $inventory->expiry_date
        ]);
        
        // Update inventory to zero quantity
        $inventory->quantity = 0;
        $inventory->save();
        
        return redirect()->route('expired.drugs')
            ->with('success', 'Drug has been disposed successfully');
    }
    
    public function disposedDrugs()
{
    $disposedDrugs = DisposedDrugs::select(
        'disposed_drugs.id',
        'disposed_drugs.restock_id',
        'disposed_drugs.drug_id',
        'disposed_drugs.quantity',
        'disposed_drugs.expiry_date',
        'drugs.name as drug_name',
        'stock_orders.id as stock_id'
    )
    ->join('drugs', 'disposed_drugs.drug_id', '=', 'drugs.id')
    ->join('stock_orders', 'disposed_drugs.restock_id', '=', 'stock_orders.id')
    ->selectRaw('DATEDIFF(CURRENT_DATE, disposed_drugs.expiry_date) as days_expired')
    ->selectRaw('(disposed_drugs.quantity * (SELECT MAX(selling_price) FROM inventories WHERE drug_id = disposed_drugs.drug_id)) as losses_incurred')
    ->orderBy('disposed_drugs.expiry_date', 'desc')
    ->get();
    
    return view('expiry.disposed-drugs', compact('disposedDrugs'));
}

}

