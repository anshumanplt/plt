@extends('layouts.app') {{-- Assuming you have a layout file --}}

@section('content')
<div class="card">
    <div class="card-body">

        <div class="container">
            <h2>Create Product Attribute</h2>

            <a href="{{ route('product-attributes.index', $productId) }}" class="btn btn-primary">Back to listing</a>
            <a href="{{ route('products.index') }}"  class="btn btn-primary" >Back to product listing</a>
            <a href="{{ route('product-attributes.createAllvariation',  $productId) }}" class="btn btn-primary" >Create All Variation</a>
            <br>
            <br>
            <br>
            {{-- Start Generating custom variation list --}}
                {{-- <form action="{{ route('product-attributes.generatevariation') }}" method="post">
                    @csrf
                    @foreach($allAttribute as $value)
                        <div class="form-group">
                            <label for="">{{ $value->name }}</label>
                            <select name="attributes[]" multiple class="form-control" id="">
                                <option value="">-- Select option --</option>
                                @foreach ($value->attributeValues as $item)
                                    <option value="{{ $value->id }}:{{ $item->id }}">{{ $item->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                    <div class="form-group">
                        <input type="submit" value="Create Variation" class="btn btn-primary">
                    </div>
                </form> --}}

                <form id="variation-form">

                    @foreach($allAttribute as $key => $value)
                        <div class="form-group">
                            <label for="{{ $value->name }}">{{ $value->name }}</label>
                            <select name="attributes[]" class="form-control attribute-select" multiple id="{{ $value->name }}">
                                <option value="">-- Select option --</option>
                                @foreach ($value->attributeValues as $item)
                                    <option value="{{ $value->id }}:{{ $item->id }}:{{ $item->value }}">{{ $item->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                
                    <!-- Add more attribute select boxes as needed -->
                
                    <button type="button" id="generate-table" class="btn btn-primary">Generate variation</button>

                </form>
                
                <div id="variation-table-container">
                    <!-- The generated table will be displayed here -->
                </div>
                
            </div>
            <br><br><br>
            {{-- End Generating cutom varition list --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
            <form method="POST" enctype="multipart/form-data" action="{{ route('product-attributes.store') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $productId }}">
                @foreach($allAttribute as $value)
                    <div class="form-group">
                        <label for="">{{ $value->name }}</label>
                        <select name="attributes[]" class="form-control" id="">
                            <option value="">-- Select option --</option>
                            @foreach ($value->attributeValues as $item)
                                <option value="{{ $value->id }}:{{ $item->id }}">{{ $item->value }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
                <div class="form-group">
                    <label for="">Product Images</label>
                    <input type="file" class="form-control" name="files[]" multiple id="">
                </div>
                
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" name="price" id="price" placeholder="Price" class="form-control">
                </div>

                <div class="form-group">
                    <label for="inventory">Inventory:</label>
                    <input type="number" name="inventory" placeholder="Inventory" id="inventory" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="">SKU:</label>
                    <input type="text" name="sku" class="form-control" placeholder="SKU" id="">
                </div>
                
                <button type="submit" class="btn btn-primary">Create Product Attribute</button>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const generateTableButton = document.getElementById('generate-table');
    generateTableButton.addEventListener('click', generateVariationTable);
});

function generateVariationTable() {
    const attributeSelects = document.querySelectorAll('.attribute-select');
    const variationTableContainer = document.getElementById('variation-table-container');

    // Get selected attribute values
    const selectedValues = Array.from(attributeSelects, (select) =>
        Array.from(select.selectedOptions, (option) => option.value)
    );

    // Generate all possible combinations of selected values
    const variations = generateVariations(selectedValues);

    // Create an HTML table
    const table = createTable(variations);

    // Replace the table content in the container
    variationTableContainer.innerHTML = '';
    variationTableContainer.appendChild(table);
}

function generateVariations(arrays) {
    const result = arrays.reduce(
        (acc, values) =>
            values.flatMap((value) =>
                acc.map((combination) => [...combination, value])
            ),
        [[]]
    );
    return result;
}

function createTable(variations) {
    const table = document.createElement('table');
    table.classList.add("table");
    const thead = document.createElement('thead');
    const tbody = document.createElement('tbody');

    // Create table header
    const headerRow = document.createElement('tr');
    variations[0].forEach((value, index) => {
        const th = document.createElement('th');
        th.textContent = `Attribute ${index + 1}`;
        headerRow.appendChild(th);
    });

    // Custom added th
    const th = document.createElement('th');
        th.textContent = `Action`;
        headerRow.appendChild(th);

    thead.appendChild(headerRow);
    table.appendChild(thead);

    // Create table body
    variations.forEach((variation) => {
        const row = document.createElement('tr');
        variation.forEach((value) => {
            const cell = document.createElement('td');
            let valArr = value.split(':');
            cell.textContent = valArr[2];
            row.appendChild(cell);

        });
        const cell = document.createElement('td');
            // cell.textContent = "button";
            let button = document.createElement("BUTTON");
            
            button.innerText = button.textContent = 'Add variant';
            button.classList.add('btn');
            button.classList.add('btn-primary');
            // row.appendChild(button);
            cell.appendChild(button);
            row.appendChild(cell);
        tbody.appendChild(row);
    });
    table.appendChild(tbody);

    return table;
}

</script>
@endsection
