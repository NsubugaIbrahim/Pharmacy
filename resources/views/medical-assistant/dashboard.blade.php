@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Medical Assistant Dashboard'])
<div class="container-fluid py-4">
    <div class="row">
            <div class="col-12 mx-auto">
            <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Customer Order</h6>
                    </div>
<div class="container mt-4">

    <!-- Create Order Button -->
    <button
        onclick="document.getElementById('order-form').style.display='block'"
        style="
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        "
        onmouseover="this.style.backgroundColor='#808000'"
        onmouseout="this.style.backgroundColor='#007bff'"
    >
        ➕ Create New Order
    </button>
</div>
</div>
</div>
</div>
</div>

    <!-- Order Form Fragment -->
    <div id="order-form" style="display: none;">
    <div style="margin-bottom: 20px;">
        <label for="customer_name"><strong>Customer Name:</strong></label>
        <input type="text" id="customer_name" name="customer_name" required placeholder="Enter Customer Name">
    </div>
        <table boarder="1" cellpadding="10" cellspacing="0" style="width: 100%; margin-bottom: 20px;">
        <thead style="background-color: rgb(230, 235, 240); color: black; font-weight: bold;">
        <tr>
            <th style="padding: 12px; border: 1px solid #ccc; font-weight: bold;">Drug Name</th>
            <th style="padding: 12px; border: 1px solid #ccc; font-weight: bold;">Unit Price (Ugx)</th>
            <th style="padding: 12px; border: 1px solid #ccc; font-weight: bold;">Quantity</th>
            <th style="padding: 12px; border: 1px solid #ccc; font-weight: bold;">Amount (Ugx)</th>
            <th style="padding: 12px; border: 1px solid #ccc; font-weight: bold;">Action</th>
        </tr>
    </thead>
            <tbody id="order-items">
                <tr>
                <td>
    <input type="text" name="drug_name[]" class="drug-name" autocomplete="off" required>
</td>
                    <td><input type="text" name="unit_price[]" class="unit-price" readonly oninput="calculateAmount(this)" required></td>
                    <td><input type="number" name="quantity[]" oninput="calculateAmount(this)" required min="0" step="1"></td>
                    <td><input type="text" name="amount[]" readonly></td>
                    <td><button type="button" onclick="removeRow(this)">🗑️</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" onclick="addRow()">➕ Add Drug</button>

        <h4 style="margin-top: 20px;">Total Amount: <span id="total-amount">0.00</span></h4>
        <button 
    type="button" 
    style="
        background-color: lightgreen; 
        color: white; 
        padding: 10px 20px; 
        font-size: 16px; 
        border: none; 
        border-radius: 5px; 
        transition: background-color 0.3s ease;
    "
    onmouseover="this.style.backgroundColor='green';"
    onmouseout="this.style.backgroundColor='lightgreen';"
    class="btn btn-success"
    id="saveOrderBtn"
>
    💾 Save Order
</button>
    </div>
</div>

<!-- Inline Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function calculateAmount(elem) {
        const row = elem.parentElement.parentElement;
        const unitPrice = parseFloat(row.querySelector('input[name="unit_price[]"]').value) || 0;
        const quantity = parseInt(row.querySelector('input[name="quantity[]"]').value) || 0;
        const amount = unitPrice * quantity;
        row.querySelector('input[name="amount[]"]').value = amount.toFixed(2);
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('input[name="amount[]"]').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('total-amount').innerText = total.toFixed(2);
    }

    function addRow() {
        const tbody = document.getElementById('order-items');
        const newRow = tbody.rows[0].cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        tbody.appendChild(newRow);
    }

    function removeRow(button) {
        const row = button.parentElement.parentElement;
        const tbody = document.getElementById('order-items');
        if (tbody.rows.length > 1) {
            row.remove();
            updateTotal();
        }else {
            // If it's the last row, redirect to the dashboard
            window.location.href = "{{ route('medical-assistant.dashboard') }}";
        }
    }

    //db query

    $(document).ready(function() {
    $(document).on('keyup', '.drug-name', function() {
        let $input = $(this);
        let query = $input.val();

        if (query.length >= 2) { // start suggesting after 2 characters
            $.ajax({
                url: '{{ route("drugs.search") }}',
                type: 'GET',
                data: { term: query },
                success: function(data) {
                    let suggestions = data.map(item => `<div class="suggestion-item" data-value="${item.value}">${item.value}</div>`);
                    let suggestionBox = `<div class="suggestion-box">${suggestions.join('')}</div>`;

                    $input.next('.suggestion-box').remove();  // Remove old box
                    $input.after(suggestionBox);  // Show new one
                }
            });
        } else {
            $input.next('.suggestion-box').remove(); // Clear suggestions
        }
    });

    $(document).on('click', '.suggestion-item', function() {
        let value = $(this).data('value');
        $(this).closest('td').find('.drug-name').val(value);
        $('.suggestion-box').remove();
    });

    $(document).click(function(e) {
        if (!$(e.target).hasClass('drug-name') && !$(e.target).hasClass('suggestion-item')) {
            $('.suggestion-box').remove();
        }
    });
});

//unit price auto fill

$(document).on('click', '.suggestion-item', function() {
    let value = $(this).data('value');
    let $input = $(this).closest('td').find('.drug-name');
    
    $input.val(value);
    $('.suggestion-box').remove();

    // Fetch Unit Price from server
    $.ajax({
        url: '{{ route("drugs.getPrice") }}',
        type: 'GET',
        data: { name: value },
        success: function(response) {
            let price = response.price ?? '';
            $input.closest('tr').find('.unit-price').val(price);
        }
    });
});

//on click of save button
document.getElementById('saveOrderBtn').addEventListener('click', function() {

// Gather form data
let customerName = document.querySelector('[name="customer_name"]').value;
let drugNames = document.querySelectorAll('[name="drug_name[]"]');
let quantities = document.querySelectorAll('[name="quantity[]"]');
let unitPrices = document.querySelectorAll('[name="unit_price[]"]');
let amounts = document.querySelectorAll('[name="amount[]"]');

let data = {
    customer_name: customerName,
    drugs: []
};

drugNames.forEach((input, index) => {
    data.drugs.push({
        name: input.value,
        quantity: quantities[index].value,
        unit_price: unitPrices[index].value,
        amount: amounts[index].value
    });
});

fetch("{{ route('medical-assistant.storeOrder') }}", {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify(data)
})
.then(response => response.json())
.then(result => {
    if(result.success) {
        alert("Thank you! Order saved successfully.");
        window.location.href = "/medical-assistant/dashboard";
    } else {
        alert("Failed to save order. " + (result.message || 'Check inputs.'));
    }
})
.catch(error => {
    alert("Error! Something went wrong.");
    console.error(error);
});
});
 

</script>
<style>
.suggestion-box {
    border: 1px solid #ccc;
    max-height: 150px;
    overflow-y: auto;
    background: white;
    position: absolute;
    z-index: 1000;
}
.suggestion-item {
    padding: 5px 10px;
    cursor: pointer;
}
.suggestion-item:hover {
    background: #f0f0f0;
}
</style>

<!-- @if(session('success'))
<script>
    alert('Thank you for your order!');
    window.location.href = "{{ route('medical-assistant.dashboard') }}";
</script>
@endif -->


@endsection
