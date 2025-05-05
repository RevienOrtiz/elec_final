<!DOCTYPE html>
<html>
<head>
    <title>Multi-Item Sales Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table input { min-width: 100px; }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Daily Sales Report Entry</h2>
    <form method="POST" action="{{ route('sales.multiple.store') }}">
        @csrf

        <div class="row mb-3">
            <div class="col">
                <label for="salesperson" class="form-label">Salesperson</label>
                <input type="text" name="salesperson" class="form-control" required>
            </div>
            <div class="col">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>
        </div>

        <table class="table table-bordered" id="sales-table">
            <thead class="table-dark">
                <tr>
                    <th>Item No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price (₱)</th>
                    <th>Qty</th>
                    <th>Tax Rate (%)</th>
                    <th>Amount</th>
                    <th>Tax</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    @for ($i = 0; $i < 1; $i++)
                    <td><input type="text" name="items[0][item_no]" class="form-control" required></td>
                    <td><input type="text" name="items[0][name]" class="form-control" required></td>
                    <td><input type="text" name="items[0][description]" class="form-control"></td>
                    <td><input type="number" step="0.01" name="items[0][price]" class="form-control price" required></td>
                    <td><input type="number" name="items[0][qty]" class="form-control qty" required></td>
                    <td><input type="number" name="items[0][tax_rate]" class="form-control tax-rate" required></td>
                    <td><input type="text" name="items[0][amount]" class="form-control amount" readonly></td>
                    <td><input type="text" name="items[0][tax]" class="form-control tax" readonly></td>
                    <td><input type="text" name="items[0][total]" class="form-control total" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row">×</button></td>
                    @endfor
                </tr>
            </tbody>
        </table>

        <button type="button" id="add-row" class="btn btn-secondary mb-3">Add Row</button>
        <br>
        <button type="submit" class="btn btn-primary">Submit Sales Report</button>
    </form>
</div>

<script>
    let rowCount = 1;

    document.getElementById('add-row').addEventListener('click', function () {
        const table = document.querySelector('#sales-table tbody');
        const newRow = table.rows[0].cloneNode(true);

        [...newRow.querySelectorAll('input')].forEach(input => {
            const name = input.name.replace(/\[\d+\]/, `[${rowCount}]`);
            input.name = name;
            input.value = '';
        });

        table.appendChild(newRow);
        rowCount++;
    });

    document.addEventListener('input', function (e) {
        if (e.target.closest('tr')) {
            const row = e.target.closest('tr');
            const price = parseFloat(row.querySelector('.price')?.value || 0);
            const qty = parseFloat(row.querySelector('.qty')?.value || 0);
            const taxRate = parseFloat(row.querySelector('.tax-rate')?.value || 0);

            const amount = price * qty;
            const tax = amount * (taxRate / 100);
            const total = amount + tax;

            row.querySelector('.amount').value = amount.toFixed(2);
            row.querySelector('.tax').value = tax.toFixed(2);
            row.querySelector('.total').value = total.toFixed(2);
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row') && document.querySelectorAll('#sales-table tbody tr').length > 1) {
            e.target.closest('tr').remove();
        }
    });
</script>
</body>
</html>
