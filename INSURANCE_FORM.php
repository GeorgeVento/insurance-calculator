<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Insurance Premium Calculation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Verdana', sans-serif;
            background-color: #f4f7f6;
            padding: 2rem;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #ff8000;
            margin-bottom: 1.5rem;
        }
        h3 {
            color: #39ac73;
            margin-top: 1.5rem;
            padding: 0.5rem;
            border-bottom: 2px solid #39ac73;
        }
        strong {
            color: #0d6efd;
        }
        input[type="submit"] {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .calculate-btn {
            background-color: #39ac73;
        }
        .apply-btn {
            background-color: #4da6ff;
        }
        .calculate-btn:hover {
            background-color: #2c8c5c;
        }
        .apply-btn:hover {
            background-color: #3a85cc;
        }
        .discount-info {
            background-color: #e0f7fa;
            color: #00796b;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            display: inline-block;
            margin-top: 10px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
<div class="container">
<?php
session_start();

// --- CALCULATION LOGIC ---
if (isset($_POST['Calculate'])) {
    if (!empty($_POST['insurance']) && is_array($_POST['insurance'])) {
        // Calculate the sum of selected insurance values
        $total = array_sum($_POST['insurance']);

        // Store the total cost in the session for subsequent discount application
        $_SESSION['total'] = $total;

        echo "<h3>Total Cost = €{$total}</h3>";
    } else {
        echo "<h3>Please select at least one insurance type.</h3>";
    }
}

// --- DISCOUNT LOGIC ---
if (isset($_POST['Apply_Code'])) {

    // Get the previously calculated total from the session
    $total = $_SESSION['total'] ?? 0;

    // Get the discount code from the form input
    $discount_code = $_POST['discount'] ?? '';
    
    // Array with valid codes and their percentage values
    $valid_codes = [
        "DISCOUNT10" => 10,
        "DISCOUNT20" => 20,
        "DISCOUNT30" => 30
    ];

    if ($total > 0 && isset($valid_codes[$discount_code])) {
        $pct = $valid_codes[$discount_code];
        $discount_amount = ($total * $pct) / 100;
        $final_total     = $total - $discount_amount;

        echo "<p>The code is valid.</p>";
        echo "<p>The discount is: €{$discount_amount} ({$pct}%)</p>";
        echo "<p><strong>Final Amount after Discount:</strong> €{$final_total}</p>";

        // Optionally, update the session total to the discounted amount
        $_SESSION['total'] = $final_total; 
    } else {
        echo "<p>The code is not valid or you have not calculated the total first.</p>";
    }
}
?>

<h2 class="text-2xl font-bold">Select the Insurance Types You Want</h2>
<form action="" method="post" class="space-y-3">
    <!-- Insurance Type: Health (100) -->
    <div class="flex items-center space-x-2">
        <input type="checkbox" name="insurance[]" value=100 id="health"
            <?php echo (isset($_POST['insurance']) && is_array($_POST['insurance']) && in_array(100, $_POST['insurance'])) ? 'checked' : ''; ?>>
        <label for="health">Health (€100)</label>
    </div>

    <!-- Insurance Type: Car (150) -->
    <div class="flex items-center space-x-2">
        <input type="checkbox" name="insurance[]" value=150 id="car"
            <?php echo (isset($_POST['insurance']) && is_array($_POST['insurance']) && in_array(150, $_POST['insurance'])) ? 'checked' : ''; ?>>
        <label for="car">Car (€150)</label>
    </div>

    <!-- Insurance Type: Home (200) -->
    <div class="flex items-center space-x-2">
        <input type="checkbox" name="insurance[]" value=200 id="home"
            <?php echo (isset($_POST['insurance']) && is_array($_POST['insurance']) && in_array(200, $_POST['insurance'])) ? 'checked' : ''; ?>>
        <label for="home">Home (€200)</label>
    </div>

    <!-- Insurance Type: Life (300) -->
    <div class="flex items-center space-x-2">
        <input type="checkbox" name="insurance[]" value=300 id="life"
            <?php echo (isset($_POST['insurance']) && is_array($_POST['insurance']) && in_array(300, $_POST['insurance'])) ? 'checked' : ''; ?>>
        <label for="life">Life (€300)</label>
    </div>

    <input class="calculate-btn mt-4" type="submit" value="Calculate" name="Calculate">
</form>

<form action="" method="post" class="mt-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
    <label class="font-semibold text-gray-700">DISCOUNT CODE:</label>
    <div class="flex flex-col sm:flex-row sm:space-x-4 mt-2">
        <input type="text" name="discount" placeholder="e.g. DISCOUNT10" class="flex-grow p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 mb-2 sm:mb-0">
        <input class="apply-btn" type="submit" value="Apply Code" name="Apply_Code">
    </div>
    <div class="discount-info">
        Available discount codes: DISCOUNT10, DISCOUNT20, DISCOUNT30
    </div>
</form>

</div>
</body>
</html>
