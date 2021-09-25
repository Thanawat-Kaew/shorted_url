<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
class ShortUrlController extends Controller{
    public function shortUrl($short_url){
        if(isset($short_url) && $short_url != ''){
            $url    = Url::where('short_url', $short_url)->first();
            return view('new_tab', ['short_url' => $short_url, 'full_url' => $url['full_url']]);
        }
       
    }
}