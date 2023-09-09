<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
</head>
<body>
    <h1>Payment Page</h1>

    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <label for="amount">Amount (in INR):</label>
        <input type="text" id="amount" name="amount" required>
        
        <!-- Add other payment fields here -->
        
        <button type="submit">Pay Now</button>
    </form>
</body>
</html>
