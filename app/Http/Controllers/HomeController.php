<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    
    // !!!!!!!!!!!!!!!!!! ДЛЯ ЧЕГО?
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
        // $params=['heading'=>'Главная'];
        return view('home');
    }
}
