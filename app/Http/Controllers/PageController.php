<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class PageController extends Controller
{
    public function caraKerja()
    {
        return view('pages.cara-kerja');
    }

    public function keunggulan()
    {
        return view('pages.keunggulan');
    }

    public function preOrder()
    {
        $campaigns = Campaign::where('status', 'active')->latest()->get();
        return view('pages.pre-order', compact('campaigns'));
    }
}
