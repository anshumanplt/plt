<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;


class InstagramController extends Controller
{
    public function index()
    {

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

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            print_r(json_decode($response));
        }
        die("check");
      return view('instagram');
    }
}
