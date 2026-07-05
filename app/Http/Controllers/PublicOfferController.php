<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class PublicOfferController extends Controller
{
    public function index(Request $request)
    {
        $query = Offer::where('is_active', true)->with('company')->latest();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('city', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $offers = $query->paginate(12);
        $cities = Offer::where('is_active', true)->distinct()->pluck('city');

        return view('offers.public.index', compact('offers', 'cities'));
    }

    public function show(Offer $offer)
    {
        if (!$offer->is_active) {
            abort(404);
        }
        $offer->load('company');
        $hasApplied = false;
        
        if (auth()->check() && auth()->user()->role === 'student') {
            $hasApplied = $offer->applications()->where('student_id', auth()->id())->exists();
        }

        return view('offers.public.show', compact('offer', 'hasApplied'));
    }
}