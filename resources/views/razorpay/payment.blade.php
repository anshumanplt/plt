@extends('layouts.frontlayout') {{-- Assuming you have a layout file --}}

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Make a Payment</div>

                    <div class="card-body">
                        <form id="paymentForm">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount (in INR)</label>
                                <input type="number" name="amount" id="amount" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Pay Now</button>
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
            key: '{{ env('RAZORPAY_KEY') }}', // Your Razorpay API Key
            amount: '{{ $orderAmount }}', // Amount in paise (e.g., 1000 for ₹10)
            currency: 'INR',
            name: 'Your Company Name',
            description: 'Payment for Order #123',
            image: '{{ url('/') }}/frontend/img/1657366295logo.png',
            handler: function(response) {
                // Handle the payment success and redirect to a success page
                window.location.href = '/payment/success?payment_id=' + response.razorpay_payment_id;
            }
        };

        var rzp = new Razorpay(options);

        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            rzp.open();
        });
    </script>
@endsection
