<?php
session_start();
include 'db.php';

// Redirect to login if the user is not signed in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$bill_id = isset($_GET['id']) ? $_GET['id'] : null;

// Fetch the bill details
$sql = "SELECT * FROM bills WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $bill_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Invalid bill.";
    exit();
}

$bill = $result->fetch_assoc();

// Check if the bill is already paid
if ($bill['status'] === 'Paid') {
    echo "This bill has already been paid.";
    exit();
}

// Handle the payment process based on the selected payment method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];

    if ($payment_method === 'nagad') {
        // Simulating redirection to Nagad's payment page
        header("Location: https://www.nagad.com.bd"); // Dummy URL, replace with actual API/URL
        exit();
    } elseif ($payment_method === 'bkash') {
        // Simulating redirection to Bkash's payment page
        header("Location: https://www.bkash.com"); // Dummy URL, replace with actual API/URL
        exit();
    } elseif ($payment_method === 'mobile_banking') {
        // Simulating redirection to mobile banking payment page
        header("Location: https://www.mobilebanking.com"); // Dummy URL, replace with actual API/URL
        exit();
    } else {
        echo "Invalid payment method.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Bill</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Pay Your Bill</h2>

        <p><strong>Bill ID:</strong> <?php echo htmlspecialchars($bill['id']); ?></p>
        <p><strong>Bill Date:</strong> <?php echo htmlspecialchars($bill['bill_date']); ?></p>
        <p><strong>Total Amount (BDT):</strong> <?php echo htmlspecialchars($bill['total_amount']); ?></p>

        <form action="pay_bill.php?id=<?php echo $bill['id']; ?>" method="POST">
            <div class="form-group">
                <label for="payment_method">Choose Payment Method:</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="nagad">Nagad</option>
                    <option value="bkash">Bkash</option>
                    <option value="mobile_banking">Mobile Banking</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success mt-3">Pay Now</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
