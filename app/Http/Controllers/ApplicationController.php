<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function apply(StoreApplicationRequest $request)
    {
        $student = Auth::user();
        
        if (!$student->profile || !$student->profile->cv_path) {
            return back()->withErrors(['error' => 'Vous devez uploader votre CV dans votre profil avant de postuler.']);
        }

        Application::create([
            'offer_id' => $request->offer_id,
            'student_id' => $student->id,
            'cover_letter_custom' => $request->cover_letter_custom,
        ]);

        return redirect()->route('applications.my')->with('status', 'Votre candidature a été envoyée avec succès.');
    }

    public function myApplications()
    {
        $applications = Application::where('student_id', Auth::id())
                                    ->with('offer.company')
                                    ->latest()
                                    ->paginate(10);

        return view('applications.index', compact('applications'));
    }
}