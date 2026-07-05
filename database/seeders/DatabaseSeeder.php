<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Company;
use App\Models\Offer;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer l'Administrateur
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@stageconnect.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 2. Créer l'Entreprise
        $companyUser = User::create([
            'name' => 'Directeur TechCorp',
            'email' => 'entreprise@techcorp.com',
            'password' => Hash::make('entreprise123'),
            'role' => 'company',
            'email_verified_at' => now(),
        ]);

        $company = Company::where('user_id', $companyUser->id)->first();
        $company->update([
            'name' => 'TechCorp Solutions',
            'siret' => '12345678900012',
            'sector' => 'Développement Web & Mobile',
            'city' => 'Paris',
            'website' => 'https://techcorp.fr',
            'logo' => 'logos/techcorp_logo.png',
        ]);

        // 3. Créer des offres pour cette entreprise (Déjà validées)
        $offre1 = Offer::create([
            'company_id' => $company->id,
            'title' => 'Développeur Backend Laravel',
            'description' => "Vous intégrerez une équipe agile de 5 personnes pour développer et maintenir notre API principale. Vous participerez à la conception de nouvelles fonctionnalités et à l'optimisation des performances de notre plateforme SaaS.",
            'requirements' => "- Maîtrise de Laravel (Routes, Controllers, Eloquent)\n- Connaissance de PostgreSQL ou MySQL\n- Compréhension des API REST\n- Git et GitHub",
            'city' => 'Paris',
            'salary' => '1500€ / mois',
            'duration' => '6 mois',
            'is_active' => true,
            'published_at' => now(),
        ]);

        $offre2 = Offer::create([
            'company_id' => $company->id,
            'title' => 'Stagiaire UI/UX Design',
            'description' => "Mission orientée sur la refonte de l'interface utilisateur de notre application mobile. Vous réaliserez des maquettes sur Figma, ferez des tests utilisateurs et travaillerez en étroite collaboration avec les développeurs.",
            'requirements' => "- Maîtrise de Figma\n- Sensibilité esthétique et ergonomique\n- Notions de HTML/CSS (un plus)\n- Esprit d'analyse",
            'city' => 'Lyon',
            'salary' => '1200€ / mois',
            'duration' => '4 mois',
            'is_active' => true,
            'published_at' => now(),
        ]);

        // 4. Créer l'Étudiant
        $studentUser = User::create([
            'name' => 'Ramzia Étudiante',
            'email' => 'etudiant@stageconnect.com',
            'password' => Hash::make('etudiant123'),
            'role' => 'student',
            'email_verified_at' => now(),
        ]);

        $profile = Profile::where('user_id', $studentUser->id)->first();
        $profile->update([
            'phone' => '06 12 34 56 78',
            'bio' => 'Étudiante en Licence 3 Informatique, passionnée par le développement web et la conception d\'interfaces utilisateur.',
            'education_level' => 'Licence 3 (Bac+3)',
            'skills' => ['PHP', 'Laravel', 'JavaScript', 'Figma', 'MySQL'],
            'cv_path' => 'cvs/cv_ramzia.pdf',
            'avatar' => 'avatars/ramzia.jpg',
        ]);

        // 5. Créer des candidatures
        Application::create([
            'offer_id' => $offre1->id,
            'student_id' => $studentUser->id,
            'status' => 'interview', // Entretien en cours
            'cover_letter_custom' => "Madame, Monsieur,\n\nActuellement en fin de Licence 3 Informatique, je suis à la recherche d'un stage de 6 mois à partir de avril. Votre offre de Développeur Backend Laravel m'intéresse particulièrement car j'ai développé plusieurs projets scolaires avec ce framework.\n\nJe suis rigoureuse, curieuse et prête à m'investir dans votre équipe.\n\nCordialement, Ramzia."
        ]);

        Application::create([
            'offer_id' => $offre2->id,
            'student_id' => $studentUser->id,
            'status' => 'pending', // En attente
            'cover_letter_custom' => "Madame, Monsieur,\n\nJe suis très intéressée par votre stage en UI/UX Design. Bien que je sois issue d'une formation développeur, j'ai toujours eu un fort attrait pour le design et j'utilise Figma de manière personnelle depuis 2 ans.\n\nJe serais ravie de vous démontrer ma créativité lors d'un entretien.\n\nCordialement, Ramzia."
        ]);
    }
}