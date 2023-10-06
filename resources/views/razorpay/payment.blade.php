@extends('layouts.frontlayout') {{-- Assuming you have a layout file --}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" style="padding: 10%;">
                <div class="card">
                    <div class="card-header">Make a Payment</div>

                    <div class="card-body">
                        <form id="paymentForm">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" readonly id="name" class="form-control" required>
                            </div>
                            <input type="hidden" name="orderid" value="{{ $orderIdData }}">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" readonly id="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount (in INR) <?php echo $orderAmount/100; ?></label>

                                <input type="hidden" name="amount" id="amount" value="{{ $orderAmount }}" class="form-control" required>
                            </div>

                            <button type="submit" id="submitButton" class="btn btn-primary">Pay Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- Include Razorpay JavaScript SDK --}}
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    {{-- Your JavaScript code for handling Razorpay payments --}}
    <script>
        var options = {
            key: '{{ $RAZORPAY_KEY }}', // Your Razorpay API Key
            amount: '{{ $orderAmount }}', // Amount in paise (e.g., 1000 for ₹10)
            currency: 'INR',
            name: 'Prettylovingthing',
            description: '{{ $orderIdData }}',
          
            image: '{{ url('/') }}/frontend/img/1657366295logo.png',
            handler: function(response) {
                // Handle the payment success and redirect to a success page
                window.location.href = '/payment/success?payment_id=' + response.razorpay_payment_id + '&order_id='+ {{ $orderIdData }};
            },
            prefill: {
                name: '{{ Auth::user()->name }}',
                email: '{{ Auth::user()->email }}',
                orderId: '{{ $orderIdData }}'
            },
            user: {
                // Pass user-related data here
                name: '{{ Auth::user()->name }}', // User's name
                email: '{{ Auth::user()->email }}', // User's email
                // Add other user data if needed
            },
            order: {
                // Pass order-related data here
                id: '{{ $orderIdData }}', // Order ID
                // Add other order data if needed
            }
        };

        var rzp = new Razorpay(options);

        rzp.on('payment.failed', function (response) {
            // Handle payment failure
            window.location.href = '/payment-failed?order_id='+ {{ $orderIdData }}; // Redirect to payment failed page
        });

        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            rzp.open();
        });
    </script>
@endsection
