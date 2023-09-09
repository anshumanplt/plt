
@foreach ($products as $product)
    <div class="search-result">
        <a href="{{ url('/product-detail') }}/{{ $product->id }}">{{ $product->name }}</a>
        <!-- Display other product details here -->
    </div>
@endforeach