<?php

namespace App\Http\Controllers;

use App\Models\Firm;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $firms = Firm::simplePaginate();

        return view('home', compact('firms'));
    }
}
