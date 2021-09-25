<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
class AdminController extends Controller{
    function deleteUrl(Request $request){
        $data       = $request->all();
        $url        = Url::where('id', $data['id_url'])->first();
        $url->delete();
        $url_all    = Url::all();
        return redirect()->route('admin.home', compact('url_all'));
    }

    function editUrl(Request $request){
        $data       = $request->all();
        $url        = Url::where('id', $data['id_url'])->first();
        return view('admin_edit', compact('url'));
    }
}