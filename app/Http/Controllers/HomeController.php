<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function adminHome(){
        $url_all    = Url::all();
        return view('admin', compact('url_all'));
    }

    public function ajaxCenter(Request $request){
        $method = $request->get('method');
        switch ($method) {
            case 'generateShortUrl':
                $full_url = $request->get('full_url');
                if(!empty($full_url) && filter_var($full_url, FILTER_VALIDATE_URL)){

                    $url_all          = Url::all();
                    $error            = [];
                    foreach ($url_all as $value) {
                        $error[] = $value->short_url;
                    }

                    $unique_short_url = false;
                    while (!$unique_short_url) {  
                        $ran_url      = substr(md5(microtime()), rand(0, 26), 5);
                        if(!in_array($ran_url, $error)){
                            $unique_short_url = true;
                        }
                    }
                    $url                = new Url();
                    $url->short_url     = $ran_url;
                    $url->full_url      = $full_url;
                    $url->save();
                    
                    $currrent_id        = Url::where('short_url',$url->short_url)->where('full_url',$url->full_url)->first();
                    return response()->json(['status'=> 'success', 'ran_url'=> $ran_url, 'id' => $currrent_id['id']]);
                }else{
                    return response()->json(['status'=> 'error']);
                }
            break;

            case 'updateUrl':
                $current_id     = $request->get('current_id');
                $ogn_url        = $request->get('ogn_url');
                $short_url      = $request->get('short_url');
                
                $domain = "http://salty-cliffs-10650.herokuapp.com/url/";
                if(substr($short_url,0,44) == $domain){
                    if(strlen($short_url) >= 45){
                        $explodeURL    = explode('/', $short_url);
                        $short_url     = end($explodeURL);
                        if($short_url != $ogn_url){
                            $chk_data_duplicate     = Url::where('short_url',$short_url)->count();
                            if($chk_data_duplicate == 0){
                                $url = Url::where('id',$current_id)->first();
                                $url->short_url = $short_url;
                                $url->save();
                                return response()->json(['status'=> 'success'] );
                            }else{
                                return response()->json(['status'=> 'error3'] );
                            }    
                        }else{
                            return response()->json(['status'=> 'success'] );
                        }
                    }else{
                        return response()->json(['status'=> 'error2'] );
                    }          
                }else{
                    return response()->json(['status'=> 'error1'] );
                }
            break;


            default:
                # code...
            break;
        }
    }
}
