<!-- resources/views/products/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
    <div class="container">


<h3>CSV Upload Report</h3>
<table class="table">
    <tr>
        <td>Total Upload Product</td>
        <td>{{ $report['totalProductInserted'] }}</td>
    </tr>
    <tr>
        <td>Total Duplicate Product</td>
        <td>{{ count($report['duplicateProduct']) }}</td>
    </tr>

</table>

    </div></div></div>

    @endsection
