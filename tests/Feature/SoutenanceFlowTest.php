<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\etudiants;
use App\Models\professeurs;
use App\Models\Remarque;
use App\Models\soutenances;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Parcours complet : connexion des trois profils, dépôt d'un rapport par
 * l'étudiant, remarque et validation par le professeur, planification de la
 * soutenance par l'administrateur, notation par le jury.
 */
class SoutenanceFlowTest extends TestCase
{
    use RefreshDatabase;

    private professeurs $encadrant;
    private professeurs $rapporteur;
    private professeurs $president;
    private etudiants $etudiant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->encadrant = professeurs::create(['nom_prof' => 'Zahra', 'prenom_prof' => 'Fatima', 'role_prof' => 'encadrant', 'email_prof' => 'zahra@univ.ma', 'password_prof' => 'secret1']);
        $this->rapporteur = professeurs::create(['nom_prof' => 'Alami', 'prenom_prof' => 'Mohammed', 'role_prof' => 'rapporteur', 'email_prof' => 'alami@univ.ma', 'password_prof' => 'secret1']);
        $this->president = professeurs::create(['nom_prof' => 'Benjelloun', 'prenom_prof' => 'Ahmed', 'role_prof' => 'president', 'email_prof' => 'benjelloun@univ.ma', 'password_prof' => 'secret1']);

        $this->etudiant = etudiants::create([
            'nom' => 'Benali', 'prenom' => 'Ahmed', 'email' => 'ahmed@etu.ma', 'password' => 'secret1',
            'encadrant_id' => $this->encadrant->id, 'rapporteur_id' => $this->rapporteur->id,
        ]);
    }

    public function test_home_and_login_pages_render(): void
    {
        $this->get('/')->assertOk()->assertSee('SoutenanceManager');
        $this->get('/login?role=admin')->assertOk()->assertSee('Connectez-vous');
        $this->get('/etudiant/register')->assertOk();
    }

    public function test_protected_areas_redirect_to_login(): void
    {
        // Le middleware renvoie vers la page de login du profil, qui redirige vers le formulaire unique.
        $this->get('/admin/dashboard')->assertRedirect('/admin/login');
        $this->get('/professeur/dashboard')->assertRedirect('/professeur/login');
        $this->get('/etudiant/dashboard')->assertRedirect('/etudiant/login');
        $this->get('/admin/login')->assertRedirect('/login?role=admin');
    }

    public function test_student_can_register_login_and_upload_a_report(): void
    {
        Storage::fake('local');

        $this->post('/etudiant/register', [
            'nom' => 'Alami', 'prenom' => 'Fatima', 'email' => 'fatima@etu.ma',
            'password' => 'secret1', 'password_confirmation' => 'secret1',
        ])->assertRedirect('/etudiant/dashboard');

        $this->assertDatabaseHas('etudiants', ['email' => 'fatima@etu.ma']);

        // Connexion via le formulaire unique
        $this->post('/logout');
        $this->post('/login', ['role' => 'etudiant', 'email' => 'ahmed@etu.ma', 'password' => 'secret1'])
            ->assertRedirect('/etudiant/dashboard');

        $this->get('/etudiant/dashboard')->assertOk()->assertSee('Ahmed Benali');

        $this->post('/etudiant/depot', [
            'type' => 'rapport',
            'titre' => 'Application de gestion',
            'document' => UploadedFile::fake()->create('rapport.pdf', 200, 'application/pdf'),
        ])->assertRedirect('/etudiant/depot');

        $document = Document::first();
        $this->assertSame('soumis', $document->statut);
        $this->assertSame($this->etudiant->id, $document->etudiant_id);
        Storage::disk('local')->assertExists($document->chemin_fichier);

        $this->get('/etudiant/depot')->assertOk()->assertSee('rapport.pdf');
    }

    public function test_wrong_password_is_rejected(): void
    {
        $this->from('/login')
            ->post('/login', ['role' => 'professeur', 'email' => 'alami@univ.ma', 'password' => 'wrong'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('email');
    }

    public function test_professor_can_review_a_student_and_add_a_remark(): void
    {
        $document = Document::create([
            'etudiant_id' => $this->etudiant->id, 'type' => 'rapport', 'titre' => 'Rapport',
            'chemin_fichier' => 'documents/x.pdf', 'nom_fichier_original' => 'x.pdf', 'extension' => 'pdf', 'taille_mo' => 1,
        ]);

        $this->post('/login', ['role' => 'professeur', 'email' => 'alami@univ.ma', 'password' => 'secret1'])
            ->assertRedirect('/professeur/dashboard');

        $this->get('/professeur/dashboard')->assertOk()->assertSee('Mohammed Alami');
        $this->get('/professeur/etudiants')->assertOk()->assertSee('Ahmed Benali');
        $this->get('/professeur/etudiants/'.$this->etudiant->id)->assertOk()->assertSee('Rapport');

        $this->post('/professeur/etudiants/'.$this->etudiant->id.'/remarques', [
            'document_id' => $document->id, 'sujet' => 'Bibliographie', 'contenu' => 'Ajouter des références.',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('remarques', ['sujet' => 'Bibliographie', 'professeur_id' => $this->rapporteur->id]);

        $this->post('/professeur/documents/'.$document->id.'/valider', ['statut' => 'valide']);
        $this->assertSame('valide', $document->fresh()->statut);
    }

    public function test_professor_cannot_see_a_student_he_does_not_follow(): void
    {
        $autre = etudiants::create(['nom' => 'Tazi', 'prenom' => 'Mohammed', 'email' => 'tazi@etu.ma', 'password' => 'secret1']);

        $this->post('/login', ['role' => 'professeur', 'email' => 'alami@univ.ma', 'password' => 'secret1']);

        $this->get('/professeur/etudiants/'.$autre->id)->assertForbidden();
    }

    public function test_student_can_mark_a_remark_as_treated(): void
    {
        $remarque = Remarque::create(['etudiant_id' => $this->etudiant->id, 'professeur_id' => $this->rapporteur->id, 'contenu' => 'Corriger le chapitre 2']);

        $this->post('/login', ['role' => 'etudiant', 'email' => 'ahmed@etu.ma', 'password' => 'secret1']);
        $this->get('/etudiant/remarques')->assertOk()->assertSee('Corriger le chapitre 2');

        $this->post('/etudiant/remarques/'.$remarque->id.'/traiter')->assertSessionHas('success');
        $this->assertSame('traitee', $remarque->fresh()->statut);
    }

    public function test_admin_plans_a_defense_and_jury_grades_it(): void
    {
        config(['soutenance.admin_email' => 'admin@test.ma', 'soutenance.admin_password' => 'admin123']);

        $this->post('/login', ['role' => 'admin', 'email' => 'admin@test.ma', 'password' => 'admin123'])
            ->assertRedirect('/admin/dashboard');

        $this->get('/admin/dashboard')->assertOk();
        $this->get('/admin/soutenances/planifier')->assertOk()->assertSee('Ahmed Benali');

        $this->post('/admin/soutenances', [
            'etudiant_id' => $this->etudiant->id,
            'date' => now()->subDay()->format('Y-m-d'), // déjà passée : le jury peut noter
            'heure' => '10:00',
            'salle' => 'B102',
            'president_id' => $this->president->id,
            'encadrant_id' => $this->encadrant->id,
            'rapporteur_id' => $this->rapporteur->id,
        ])->assertRedirect('/admin/soutenances');

        $soutenance = soutenances::first();
        $this->assertSame('B102', $soutenance->Salle_Sout);
        $this->assertCount(3, $soutenance->juryMembers);

        // Un même professeur ne peut pas être planifié deux fois pour le même étudiant
        $this->post('/admin/soutenances', [
            'etudiant_id' => $this->etudiant->id, 'date' => '2030-01-01', 'heure' => '10:00', 'salle' => 'A1',
            'president_id' => $this->president->id, 'encadrant_id' => $this->encadrant->id, 'rapporteur_id' => $this->rapporteur->id,
        ])->assertSessionHasErrors('etudiant_id');

        $this->get('/admin/soutenances/'.$soutenance->id)->assertOk()->assertSee('Ahmed Benjelloun');

        // Notation par les trois membres du jury -> note finale = moyenne
        foreach ([[$this->president, 16], [$this->encadrant, 18], [$this->rapporteur, 14]] as [$prof, $note]) {
            $this->post('/logout');
            $this->post('/login', ['role' => 'professeur', 'email' => $prof->email_prof, 'password' => 'secret1']);
            $this->post('/professeur/soutenances/'.$soutenance->id.'/noter', ['note' => $note])->assertSessionHas('success');
        }

        $this->assertEquals(16.0, $soutenance->fresh()->Note_finale);

        // L'étudiant voit sa note
        $this->post('/logout');
        $this->post('/login', ['role' => 'etudiant', 'email' => 'ahmed@etu.ma', 'password' => 'secret1']);
        $this->get('/etudiant/soutenance')->assertOk()->assertSee('16.00');
    }

    public function test_professor_outside_the_jury_cannot_grade(): void
    {
        $soutenance = soutenances::create(['etudiant_id' => $this->etudiant->id, 'Date_Sout' => now()->subDay(), 'Salle_Sout' => 'B1']);
        $soutenance->juryMembers()->attach($this->president->id, ['role' => 'president']);

        $this->post('/login', ['role' => 'professeur', 'email' => 'alami@univ.ma', 'password' => 'secret1']);
        $this->post('/professeur/soutenances/'.$soutenance->id.'/noter', ['note' => 12])->assertForbidden();
    }
}
