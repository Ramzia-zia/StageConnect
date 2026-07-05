<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        
        if ($user->role === 'company') {
            $user->load('company');
        } else {
            $user->load('profile');
        }

        return view('profiles.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        // Mise à jour des infos utilisateur de base
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if ($user->role === 'student') {
            $profileData = [
                'phone' => $data['phone'] ?? null,
                'bio' => $data['bio'] ?? null,
                'education_level' => $data['education_level'] ?? null,
                'skills' => isset($data['skills']) ? explode(',', $data['skills'][0] ?? $data['skills']) : null,
            ];

            if ($request->hasFile('avatar')) {
                if ($user->profile && $user->profile->avatar) {
                    Storage::disk('public')->delete($user->profile->avatar);
                }
                $profileData['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            if ($request->hasFile('cv')) {
                if ($user->profile && $user->profile->cv_path) {
                    Storage::disk('public')->delete($user->profile->cv_path);
                }
                $profileData['cv_path'] = $request->file('cv')->store('cvs', 'public');
            }

            $user->profile()->updateOrCreate(['user_id' => $user->id], $profileData);
        } 
        elseif ($user->role === 'company') {
            $companyData = [
                'name' => $data['company_name'],
                'siret' => $data['siret'] ?? null,
                'website' => $data['website'] ?? null,
                'sector' => $data['sector'] ?? null,
                'city' => $data['city'],
            ];

            if ($request->hasFile('logo')) {
                if ($user->company && $user->company->logo) {
                    Storage::disk('public')->delete($user->company->logo);
                }
                $companyData['logo'] = $request->file('logo')->store('logos', 'public');
            }

            $user->company()->updateOrCreate(['user_id' => $user->id], $companyData);
        }

        return back()->with('status', 'Profil mis à jour avec succès.');
    }
}