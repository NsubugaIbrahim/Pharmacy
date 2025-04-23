<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockEntry;
use App\Models\Drug;
use App\Models\Supplier;
use App\Models\StockOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    public function index()
    {
        $drugs = Drug::all();
        $suppliers = Supplier::all();
        // Return the view with the stock entries
        return view('stock.index', compact('drugs', 'suppliers'));
    }

    public function stockView(){
        $stockOrders = StockOrder::with('supplier')->orderBy('date', 'desc')->get();
        return view('stock.stockview', compact('stockOrders'));
    }
    

    public function approve_order(){
        $stockOrders = StockOrder::with('supplier')
                        ->whereNull('status')  // Only get orders with null status
                        ->orderBy('date', 'desc')
                        ->get();
        return view('stock.approveorder', compact('stockOrders'));
    }

    public function approveOrder($id)
    {
        $order = StockOrder::findOrFail($id);
        $order->status = 'approved';
        $order->save();
        
        return redirect()->back()->with('success', 'Order has been approved successfully.');
    }
    
    public function declineOrder($id)
    {
        $order = StockOrder::findOrFail($id);
        $order->status = 'declined';
        $order->save();
        
        return redirect()->back()->with('success', 'Order has been declined successfully.');
    }

    public function receiveStock() {
        $stockOrders = StockOrder::with('supplier')
                        ->where('status', 'approved')
                        ->orderBy('date', 'desc')
                        ->get();
        return view('stock.receivestock', compact('stockOrders'));
    }
    
    //Insert expiry dates for Received Stock entries
    public function receiveStockLogic(Request $request, StockOrder $order)
    {
        $request->validate([
            'expiry_dates' => 'required|array',
            'expiry_dates.*' => 'required|date',
            'entry_ids' => 'required|array',
            'entry_ids.*' => 'required|exists:stock_entries,id',
            'selling_prices' => 'required|array',
            'selling_prices.*' => 'required|numeric|min:0',
        ]);

        foreach ($request->entry_ids as $entryId) {
            $expiryDate = $request->expiry_dates[$entryId];
            $sellingPrice = $request->selling_prices[$entryId];

            $stockEntry = StockEntry::findOrFail($entryId);
            $stockEntry->expiry_date = $expiryDate;
            $stockEntry->save();

            // Check if inventory already exists for same drug and expiry date
            $existingInventory = \App\Models\Inventory::where('drug_id', $stockEntry->drug_id)
                ->where('expiry_date', $expiryDate)
                ->first();

            if ($existingInventory) {
                $existingInventory->quantity += $stockEntry->quantity;
                $existingInventory->selling_price = $sellingPrice; // Update selling price if needed
                $existingInventory->save();
            } else {
                \App\Models\Inventory::create([
                    'restock_id' => $order->id,
                    'drug_id' => $stockEntry->drug_id,
                    'quantity' => $stockEntry->quantity,
                    'selling_price' => $sellingPrice,
                    'expiry_date' => $expiryDate,
                ]);
            }
        }

        $order->reception = true;
        $order->save();

        return redirect()->back()->with('success', 'Expiry dates and selling prices have been saved to inventory.');
    }




    public function store_order(Request $request)
    {
        // Validate the basic fields
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'date' => 'required|date',
            'entries' => 'required|array|min:1',
            'total' => 'required|numeric',
        ]);
        
        // Filter out empty entries
        $validEntries = [];
        foreach ($request->entries as $entry) {
            if (!empty($entry['quantity']) && !empty($entry['price'])) {
                $validEntries[] = $entry;
            }
        }
        
        // Check if we have any valid entries
        if (empty($validEntries)) {
            return redirect()->back()->with('error', 'Please fill at least one restock item.');
        }
        
        // Validate each entry
        foreach ($validEntries as $entry) {
            if (!isset($entry['drug_id']) || !isset($entry['quantity']) || 
                !isset($entry['price']) || !isset($entry['cost'])) {
                return redirect()->back()->with('error', 'Invalid entry data');
            }
        }

        try {
            DB::transaction(function () use ($request, $validEntries) {
                // Create the stock order
                $order = StockOrder::create([
                    'supplier_id' => $request->supplier_id,
                    'date' => $request->date,
                    'total' => $request->total, // Save the total amount
                ]);

                // Create each stock entry
                foreach ($validEntries as $entry) {
                    StockEntry::create([
                        'restock_id' => $order->id,
                        'drug_id' => $entry['drug_id'],
                        'quantity' => $entry['quantity'],
                        'price' => $entry['price'],
                        'cost' => $entry['cost'],
                    ]);
                }
            });
            
            return redirect()->back()->with('success', 'Stock restocked successfully!');
        } catch (\Exception $e) {
            Log::error('Stock order creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create stock order: ' . $e->getMessage());
        }
    }


    // Form to stock a drug
    public function create()
    {
        $drugs = Drug::all();
        $suppliers = Supplier::all();
        return view('stock.create', compact('drugs', 'suppliers'));
    }
    // Store a new stock entry
    public function store(Request $request)
    {
        $request->validate([
            'drug_id' => 'required|exists:drugs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'supply_price' => 'required|numeric|min:0',
        ]);

        StockEntry::create([
            'drug_id' => $request->drug_id,  // This refers to the drug's ID
            'supplier_id' => $request->supplier_id,
            'quantity' => $request->quantity,
            'supply_price' => $request->supply_price,
        ]);

        return redirect()->route('stock.show')->with('success', 'Stock entry created successfully.');
    }
    // Show the form for editing a stock entry
    public function edit(StockEntry $stockEntry)
    {
        $drugs = Drug::all();
        $suppliers = Supplier::all();
        return view('stock.edit', compact('stockEntry', 'drugs', 'suppliers'));
    }
    // Update a stock entry
    public function update(Request $request, StockEntry $stockEntry)
    {
        $request->validate([
            'drug_id' => 'required|exists:drugs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'supply_price' => 'required|numeric|min:0',
            
        ]);

        StockEntry::update([
            'drug_id' => $request->name,  // This refers to the drug's ID
            'supplier_id' => $request->supplier_id,
            'quantity' => $request->quantity,
            'supply_price' => $request->supply_price,
        ]);;

        return redirect()->route('stock.index')->with('success', 'Stock entry updated successfully.');
    }
    // Delete a stock entry
    public function destroy(StockEntry $stockEntry)
    {
        $stockEntry->delete();

        return redirect()->route('stock.index')->with('success', 'Stock entry deleted successfully.');
    }

    public function show()
{
    $inventory = Drug::select('drugs.id', 'drugs.name')
        ->selectRaw('SUM(inventories.quantity) as total_quantity')
        ->selectRaw('MIN(inventories.expiry_date) as closest_expiry_date')
        ->selectRaw('MAX(inventories.selling_price) as selling_price') // Using MAX as an example, you could use AVG or other logic
        ->leftJoin('inventories', 'drugs.id', '=', 'inventories.drug_id')
        ->groupBy('drugs.id', 'drugs.name')
        ->with(['stockEntries' => function($query) {
            $query->with('stockOrder.supplier');
        }, 'inventoryItems'])
        ->get();

    return view('stock.show', compact('inventory'));
}


}