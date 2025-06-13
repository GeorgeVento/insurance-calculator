<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Υπολογισμός Ασφαλίστρων</title>
</head>
<body>
<?php
session_start();

if (isset($_POST['Υπολόγισε'])) {
    if (!empty($_POST['insurance']) && is_array($_POST['insurance'])) {
        $total = array_sum($_POST['insurance']);

        $_SESSION['total'] = $total; // Αποθήκευση του συνολικού κόστους

        echo "<h3>Συνολικό κόστος = €{$total}</h3>";
    } else {
        echo "<h3>Παρακαλώ επιλέξτε τουλάχιστον μία ασφάλεια.</h3>";
    }
}

if (isset($_POST['Εφαρμογή_κωδικού'])) {

    // Παίρνω το προηγούμενο σύνολο
    $total = $_SESSION['total'] ?? 0;

    // Παίρνω τον κωδικό έκπτωσης από τη φόρμα
    $discount_code = $_POST['discount'] ?? '';
    
    // Πίνακας με κωδικούς
    $valid_codes = [
        "DISCOUNT10" => 10,
        "DISCOUNT20" => 20,
        "DISCOUNT30" => 30
    ];

    if ($total > 0 && isset($valid_codes[$discount_code])) {
        $pct = $valid_codes[$discount_code];
        $discount_amount = ($total * $pct) / 100;
        $final_total    = $total - $discount_amount;

        echo "<p>Ο κωδικός είναι έγκυρος.</p>";
        echo "<p>Η έκπτωση είναι: €{$discount_amount} ({$pct}%)</p>";
        echo "<p><strong>Τελικό ποσό μετά την έκπτωση:</strong> €{$final_total}</p>";
    } else {
        echo "<p>Ο κωδικός δεν είναι έγκυρος ή δεν έχετε υπολογίσει πρώτα το σύνολο.</p>";
    }
}
?>

<h2 style="font-family:verdana; color: #ff8000">Επιλέξτε τις ασφάλειες που θέλετε</h2>
<form action="" method="post">
<input type="checkbox" name="insurance[]" value=100 <?php echo (isset($_POST['insurance']) && in_array(100, $_POST['insurance'])) ? 'checked' : ''; ?>> Υγείας<br>
<input type="checkbox" name="insurance[]" value=150 <?php echo (isset($_POST['insurance']) && in_array(150, $_POST['insurance'])) ? 'checked' : ''; ?>> Αυτοκινήτου<br>
<input type="checkbox" name="insurance[]" value=200 <?php echo (isset($_POST['insurance']) && in_array(200, $_POST['insurance'])) ? 'checked' : ''; ?>> Οικείας<br>
<input type="checkbox" name="insurance[]" value=300 <?php echo (isset($_POST['insurance']) && in_array(300, $_POST['insurance'])) ? 'checked' : ''; ?>> Ζωής<br>
<input style="background-color: #39ac73" type="submit" value="Submit" name="Υπολόγισε">
</form>

<form action="" method="post"><br>
    <label>DISCOUNT:
        <input type="text" name="discount" placeholder="π.χ. DISCOUNT10">
    </label>
    <input type="submit" value="Submit_code" name="Εφαρμογή_κωδικού">
    <span style="background-color: #4da6ff;">Διαθέσιμοι κωδικοί έκπτωσης: DISCOUNT10, DISCOUNT20, DISCOUNT30</span>
</form>
</body>
</html>
