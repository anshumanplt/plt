<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {font-family: Helvetica, sans-serif;font-size:13px;}
        .container{max-width: 680px; margin:0 auto;}
        .logotype{color:#fff;height:100px;  line-height: 75px; text-align: center; font-size:11px;}
        .column-title{background:#eee;text-transform:uppercase;padding:15px 5px 15px 15px;font-size:11px}
        .column-detail{border-top:1px solid #eee;border-bottom:1px solid #eee;}
        .column-header{background:#eee;text-transform:uppercase;padding:15px;font-size:11px;border-right:1px solid #eee;}
        .row{padding:7px 14px;border-left:1px solid #eee;border-right:1px solid #eee;}
        .alert{background: #ffd9e8;padding:20px;margin:20px 0;line-height:22px;color:#333}
        .socialmedia{background:#eee;padding:20px; display:inline-block}
    </style>
</head>

<body>
    <div class="container">
       

        <table width="100%">
            <tr>
                <td><div class="logotype"><img src="https://prettylovingthing.com/frontend/img/prettylovingthing-logo.png" alt="" width="100%"></div></td>
                <td></td>
            </tr>
            <tr>
                <td width="300px" style="background: #fee977; font-size:26px;font-weight:bold;letter-spacing:-1px;">Order confirmation</td>
                <td></td>
          </tr>
        </table> 
        <h3>Billing/Shipping Address</h3>
        <table width="100%" style="border-collapse: collapse;">
          <tr>
            <td width="180px" class="column-title">Name<td>
            <td class="column-detail">{{ Auth::user()->name }}<td>
          </tr>
          <tr>
            <td width="180px" class="column-title">Email<td>
            <td class="column-detail">{{ Auth::user()->email }}<td>
          </tr>
          <tr>
            <td class="column-title">Mobile<td>
            <td class="column-detail">{{ $order->address->mobile }}<td>
          </tr>
          <tr>
            <td class="column-title">Address1<td>
            <td class="column-detail">{{ $order->address->address1 }}<td>
          </td>
          <tr>
            <td class="column-title">Address2<td>
            <td class="column-detail">{{ $order->address->address2 }}<td>
          </tr>
          <tr>
            <td class="column-title">City<td>
            <td class="column-detail">{{ $order->address->addCity->name }}<td>
          </td>
          <tr>
            <td class="column-title">State<td>
            <td class="column-detail">{{ $order->address->addState->name }}<td>
          </tr>
          <tr>
            <td class="column-title">Country<td>
            <td class="column-detail">{{ $order->address->addCountry->name }}<td>
          </tr>
          <tr>
            <td class="column-title">PIN<td>
            <td class="column-detail">{{ $order->address->pin }}<td>
          </tr>
        </table>


        <h3>Order Products</h3>
      
         <table width="100%" style="border-collapse: collapse;border-bottom:1px solid #eee;">
           <tr>
             <td width="10%" class="column-header">#</td>
             <td width="40%" class="column-header">Product Name</td>
             <td width="10%" class="column-header">SKU</td>
             {{-- <td width="30%" class="column-header">Product Variant</td> --}}
             <td width="10%" class="column-header">Quantity</td>
             <td width="10%" class="column-header">Price</td>
           </tr>
           @foreach($orderItems as $key => $item)
            <tr>
                <td class="row">{{ $key + 1 }}</td>
                <td class="row">{{ $item->product->name }}</td>
                <td class="row">{{ $item->sku }}</td>
                {{-- <td class="row">
                    @php 
                        $variant = App/Models/ProductAttribute::where(['sku' => $item->sku, 'product_id' => $item->product_id])->first();
                        $variantArr = explode(',', $variant->attribute_value_id);
                        $allAtt = App/Models/AttributeValue::whereIn('attribute_id', $variantArr)->get();

                        foreach ($allAtt as $key => $value) {
                            echo "<b>".$value->value."</b>&nbsp;";
                        }
                        
                    @endphp
                </td> --}}
                <td class="row">{{ $item->quantity }}</td>
                <td class="row"> ₹ {{$item->subtotal}}</td>
            </tr>
           @endforeach
          

        </table>
      
        <div class="alert"></div>
      </div><!-- container -->
</body>
</html>