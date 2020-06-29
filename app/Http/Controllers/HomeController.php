<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $test = 10;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       //  $this->middleware('auth');
    }

    public function getLatestProfiles() {
        $users = \App\User::orderBy('id', 'desc')->limit(5)->get();
        return $users;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', [
            'users' => $this->getLatestProfiles()
        ]);
    }
}
