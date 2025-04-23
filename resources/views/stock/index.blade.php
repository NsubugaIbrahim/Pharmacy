@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Order Stock '])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Order Stock</h6>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- <div class="alert alert-info" style="color: white; font-size: 14px;">
                            <i class="fas fa-info-circle me-2"></i>
                            Fill in details only for the drugs to be restocked. Empty rows will be ignored.
                        </div> --}}

                        <div class="d-flex align-items-center gap-2 mb-3">
                            <form method="POST" action="{{ route('stock_orders.store') }}" id="restock-form">
                                @csrf
                                <div class="d-flex align-items-end gap-3 mb-3 text-center">
                                    <div class="mb-3">
                                        <label for="supplier" class="form-label">Select Supplier</label>
                                        <select name="supplier_id" id="supplier" class="form-select" style="width: 200px;" required>
                                            <option value="">Select Supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Restock Date</label>
                                        <input type="date" id="date" name="date" class="form-control" style="width: 200px;" required value="{{ date('Y-m-d') }}">
                                    </div>                                    
                                    <div class="mb-3">
                                        <label class="form-label">Search</label> <br>
                                        <input type="text" id="search-input" class="form-control" placeholder="Search for a drug">
                                    </div>                                    
                                </div>
                                <div class="table-responsive" style="margin-top: -30px;">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Drug</th>
                                                <th>Quantity</th>
                                                <th>Stock In Price (UGX)</th>
                                                <th>Cost (UGX)</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($drugs as $index => $drug)
                                            <tr class="drug-row">
                                                <td>
                                                    <strong>{{ $drug->name }}</strong>
                                                    <input type="hidden" name="entries[{{ $index }}][drug_id]" value="{{ $drug->id }}" class="drug-id">
                                                </td>
                                                <td>
                                                    <input type="number" name="entries[{{ $index }}][quantity]" class="form-control quantity-field" min="1">
                                                </td>
                                                <td>
                                                    <input type="number" name="entries[{{ $index }}][price]" step="0.01" min="0.01" class="form-control price-field">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control cost-display" readonly>
                                                    <input type="hidden" name="entries[{{ $index }}][cost]" class="cost-field">
                                                </td>                                                                                                
                                                <td class="row-status">
                                                    <span class="badge bg-secondary">Not selected</span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-3 d-flex align-items-center">
                                    <input type="hidden" name="total" id="total-amount-input">
                                    <div class="ms-3 fw-bold" style = "margin-right:30px">
                                        Total Amount: <span id="total-cost" class="text-primary">0.00</span>
                                    </div>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i> Submit Restock
                                    </button>
                                </div>                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')

        {{-- JavaScript to handle form submission --}}
        <script>
           document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('restock-form');
    const rows = document.querySelectorAll('.drug-row');
    
    // Update row status when any field changes
    rows.forEach(row => {
        const quantityField = row.querySelector('.quantity-field');
        const priceField = row.querySelector('.price-field');
        const costDisplay = row.querySelector('.cost-display');
        const statusBadge = row.querySelector('.row-status .badge');
        
        // Calculate cost function
        const calculateCost = () => {
            const quantity = parseFloat(quantityField.value) || 0;
            const price = parseFloat(priceField.value) || 0;
            const cost = quantity * price;
            costDisplay.value = cost.toFixed(0);
            
            // Add a hidden input to store the cost value for submission
            let costInput = row.querySelector('.cost-field');
            if (costInput) {
                costInput.value = cost.toFixed(0);
            }
        };
        
        // Initialize cost calculation
        calculateCost();
        
        // Update cost when quantity or price changes
        quantityField.addEventListener('input', calculateCost);
        priceField.addEventListener('input', calculateCost);
        
        const updateRowStatus = () => {
            const quantity = quantityField.value.trim();
            const price = priceField.value.trim();
            
            if (quantity && price) {
                statusBadge.className = 'badge bg-success';
                statusBadge.textContent = 'Will be restocked';
                row.classList.add('table-success');
                row.classList.remove('table-warning');
            } else if (quantity || price) {
                statusBadge.className = 'badge bg-warning';
                statusBadge.textContent = 'Incomplete';
                row.classList.add('table-warning');
                row.classList.remove('table-success');
            } else {
                statusBadge.className = 'badge bg-secondary';
                statusBadge.textContent = 'Not selected';
                row.classList.remove('table-success', 'table-warning');
            }
        };
        
        // Add event listeners to update status
        quantityField.addEventListener('input', updateRowStatus);
        priceField.addEventListener('input', updateRowStatus);
    });
    
    // Form submission handler
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Temporarily prevent submission
        
        // Disable empty rows before submitting
        let hasFilledRow = false;
        
        rows.forEach(row => {
            const quantityField = row.querySelector('.quantity-field');
            const priceField = row.querySelector('.price-field');
            
            const quantity = quantityField.value.trim();
            const price = priceField.value.trim();
            
            // If any field is filled but not all, show warning
            if ((quantity || price) && !(quantity && price)) {
                e.preventDefault();
                alert('Please complete all fields for the drugs you want to restock.');
                return;
            }
            
            // If all fields are filled, count as valid row
            if (quantity && price) {
                hasFilledRow = true;
                
                // Make sure cost is calculated and included
                const quantity = parseFloat(quantityField.value) || 0;
                const price = parseFloat(priceField.value) || 0;
                const cost = quantity * price;
                
                // Update the cost field
                const costField = row.querySelector('.cost-field');
                if (costField) {
                    costField.value = cost.toFixed(2);
                }
                
                // Enable all inputs in this row to ensure they're submitted
                row.querySelectorAll('input').forEach(input => {
                    input.disabled = false;
                });
            } else {
                // Disable empty rows so they don't get submitted
                row.querySelectorAll('input').forEach(input => {
                    input.disabled = true;
                });
            }
        });
        
        if (!hasFilledRow) {
            alert('Please fill in details for at least one drug to restock.');
            return;
        }
        
        // Submit the form if validation passes
        this.submit();
    });
    
    // Add search functionality
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            rows.forEach(row => {
                const drugName = row.querySelector('strong').textContent.toLowerCase();
                if (drugName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});

// Set default date to today
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    
    document.getElementById('date').value = `${year}-${month}-${day}`;
});

// Add search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const rows = document.querySelectorAll('.drug-row');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            rows.forEach(row => {
                const drugName = row.querySelector('strong').textContent.toLowerCase();
                if (drugName.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});


// Calculate and update total cost
function updateTotalCost() {
    const costDisplays = document.querySelectorAll('.cost-display');
    let total = 0;
    
    costDisplays.forEach(display => {
        if (display.value) {
            total += parseFloat(display.value) || 0;
        }
    });
    
    document.getElementById('total-cost').textContent = total.toFixed(0);
    document.getElementById('total-amount-input').value = total.toFixed(0);
}


// Add event listeners to update total cost
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.drug-row');
    
    rows.forEach(row => {
        const quantityField = row.querySelector('.quantity-field');
        const priceField = row.querySelector('.price-field');
        
        quantityField.addEventListener('input', updateTotalCost);
        priceField.addEventListener('input', updateTotalCost);
    });
    
    // Initialize total cost
    updateTotalCost();
});

        </script>

                
        @include('layouts.footers.auth.footer')
    </div>
@endsection