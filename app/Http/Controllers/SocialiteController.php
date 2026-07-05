<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider(string $provider)
    {
        if (!in_array($provider, ['google', 'github'])) {
            abort(404);
        }
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        // Vérifier si l'utilisateur existe déjà via le provider ID
        $user = User::where('provider', $provider)
                    ->where('provider_id', $socialUser->getId())
                    ->first();

        // Si non, vérifier par email (pour lier un compte classique à un compte social)
        if (!$user) {
            $user = User::where('email', $socialUser->getEmail())->first();
            
            if ($user) {
                // Lier le compte social au compte existant
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                ]);
            } else {
                // Créer un nouveau compte
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => bcrypt(str()->random(16)), // Mot de passe aléatoire
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'role' => 'student', // Rôle par défaut
                    'email_verified_at' => now(), // Les réseaux sociaux vérifient l'email
                ]);
            }
        }

               Auth::login($user, true);

        // Si l'utilisateur n'a pas encore complété son profil spécifique (étudiant/entreprise)
        // on l'envoie sur son dashboard pour qu'il finisse son inscription
        if (empty($user->profile) && $user->role === 'student') {
            return redirect()->route('profile.edit')->with('status', 'Veuillez compléter votre profil étudiant.');
        }
        if (empty($user->company) && $user->role === 'company') {
            return redirect()->route('profile.edit')->with('status', 'Veuillez compléter le profil de votre entreprise.');
        }

        return redirect()->route('student.dashboard'); // Redirection par défaut sur l'accueil des étudiants
    }
}