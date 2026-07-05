<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferRequest;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Auth::user()->company->offers()->latest()->paginate(10);
        return view('offers.index', compact('offers'));
    }

    public function create()
    {
        return view('offers.create');
    }

    public function store(StoreOfferRequest $request)
    {
        Auth::user()->company->offers()->create($request->validated() + ['is_active' => false]);

        return redirect()->route('offers.index')->with('status', 'Offre créée en attente de validation.');
    }

    public function edit(Offer $offer)
    {
        $this->authorize('update', $offer);
        return view('offers.edit', compact('offer'));
    }

    public function update(StoreOfferRequest $request, Offer $offer)
    {
        $this->authorize('update', $offer);
        $offer->update($request->validated());

        return redirect()->route('offers.index')->with('status', 'Offre mise à jour.');
    }

    public function destroy(Offer $offer)
    {
        $this->authorize('delete', $offer);
        $offer->delete();

        return redirect()->route('offers.index')->with('status', 'Offre supprimée.');
    }
}