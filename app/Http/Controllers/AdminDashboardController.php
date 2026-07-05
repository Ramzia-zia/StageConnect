<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'students' => User::where('role', 'student')->count(),
            'companies' => User::where('role', 'company')->count(),
            'offers_active' => Offer::where('is_active', true)->count(),
            'offers_pending' => Offer::where('is_active', false)->count(),
            'applications' => Application::count(),
        ];

        $recentApplications = Application::with(['student', 'offer.company'])->latest()->take(5)->get();

        return view('dashboards.admin', compact('stats', 'recentApplications'));
    }

    public function moderateOffers()
    {
        $offers = Offer::with('company')->where('is_active', false)->latest()->paginate(15);
        return view('admin.offers', compact('offers'));
    }

    public function validateOffer(Offer $offer)
    {
        $offer->update(['is_active' => true, 'published_at' => now()]);
        return back()->with('status', 'Offre validée et publiée.');
    }

    public function destroyOffer(Offer $offer)
    {
        $offer->delete();
        return back()->with('status', 'Offre supprimée.');
    }

    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }
}