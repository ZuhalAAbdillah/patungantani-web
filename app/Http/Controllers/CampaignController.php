<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function create()
    {
        return view('campaign.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'target_amount' => 'required|integer|min:1',
            'price_per_unit' => 'required|numeric|min:0',
            'margin_per_unit' => 'nullable|numeric|min:0',
            'closes_at' => 'required|date|after:today',
            'description' => 'nullable|string',
        ]);

        Campaign::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'target_amount' => $request->target_amount,
            'price_per_unit' => $request->price_per_unit,
            'margin_per_unit' => $request->margin_per_unit ?? 0,
            'closes_at' => $request->closes_at,
            'description' => $request->description,
            'current_amount' => 0,
            'status' => 'active',
        ]);

        return redirect()->route('dashboard')->with('success', 'Kampanye berhasil dibuat.');
    }

    public function show(Campaign $campaign)
    {
        return view('campaign.show', compact('campaign'));
    }
}
