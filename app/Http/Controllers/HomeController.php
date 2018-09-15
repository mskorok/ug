<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Adventures\Adventure;
use App\Models\Reviews\Review;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adventures = Adventure::with('user')->limit(3)->orderBy('created_at', 'DESC')->get();

        $reviews = Review::with('user')->limit(6)->orderBy('created_at', 'DESC')->get();

        return view('app.index.index', ['adventures' => $adventures, 'reviews' => $reviews]);
    }
}
