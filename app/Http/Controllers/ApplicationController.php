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
        $offer = \App\Models\Offer::find($request->offer_id);

        // Création de la candidature
        $application = Application::create([
            'offer_id' => $request->offer_id,
            'student_id' => $student->id,
            'cover_letter_custom' => $request->cover_letter_custom,
        ]);

        // Envoyer la notification à l'entreprise
        if ($offer && $offer->company) {
            $offer->company->user->notify(new \App\Notifications\NewApplicationNotification($offer, $student));
        }

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

        public function offerApplications(Offer $offer)
    {
        $this->authorize('update', $offer);
        $applications = $offer->applications()->with('student.profile')->latest()->paginate(10);
        return view('applications.company', compact('offer', 'applications'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $offer = $application->offer;
        $this->authorize('update', $offer);

        $request->validate([
            'status' => ['required', 'in:pending,interview,accepted,rejected'],
        ]);

        $application->update(['status' => $request->status]);

                $application->student->notify(new \App\Notifications\ApplicationStatusNotification($application));

        return back()->with('status', 'Statut de la candidature mis à jour.');
    }
}