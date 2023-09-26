@php 
    $response = [];
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://graph.instagram.com/me/media?fields=caption,id,media_type,media_url,permalink,thumbnail_url,timestamp,username&access_token=IGQWRQb1ZAmay1NY0M3ME9aSUJwUXE5akZAuY2d0eG8zeVFWQ2lkVWNRdXVpdEVVUDZABVFhzMldWWFZAOc3lIYTZAhV1JCckhOYU9pRUo4alFRejFDZAHNzX1Q3MzBCZAEZAob3ZAITWYwd2VmX2RnOFEyRVJ5ZA19HUmVXcTgZD",// your preferred link
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_TIMEOUT => 30000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            // Set Here Your Requesred Headers
            'Content-Type: application/json',
        ),
    ));

    $curlRes = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    $response = json_decode($curlRes);
    // echo "<pre>"; print_r($response); echo "</pre>";
@endphp

<!-- Instagram Begin -->
<div class="instagram">
    <div class="container-fluid">
        <div class="row">
            @if(isset($response->data))
                @foreach($response->data as $key => $value)
            
                    <div class="col-lg-3 col-md-5 col-sm-6 p-0">
                        <div class="instagram__item set-bg" data-setbg="{{ $value->media_url }}">
                            <div class="instagram__text">
                                <i class="fa fa-instagram"></i>
                                <a href="{{ $value->permalink }}" target="_blank">@ prettylovingthing</a>
                            </div>
                        </div>
                    </div>
                    @if($key == 3)
                    <?php  break; ?>                
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>
<!-- Instagram End -->
    