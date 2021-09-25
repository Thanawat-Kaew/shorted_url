<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
class ShortUrlController extends Controller{
    public function shortUrl($short_url){
        if(isset($short_url) && $short_url != ''){
            $url    = Url::where('short_url', $short_url)->first();
            /*print_r($url['full_url']);
            echo "dd".$short_url;exit;*/
            return view('new_tab', ['short_url' => $short_url, 'full_url' => $url['full_url']]);
        }
       
    }
}