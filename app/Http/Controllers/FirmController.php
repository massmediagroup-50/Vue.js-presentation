<?php

namespace App\Http\Controllers;

use App\Models\Firm;

class FirmController extends Controller
{
    /**
     * @param Firm $firm
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Firm $firm)
    {
        return view('pages.firm', compact('firm'));
    }
}