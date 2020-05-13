<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Page;

class ViewCrawlerResult extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {        
        // $pageData = Page::whereDate('created_at', DB::raw('CURDATE()'))->get();
        $pageData = Page::whereDate('created_at', '=', '2020-04-21');

        return view('showList',['posts' => $pageData]);
    }
}
