<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - SoutenanceManager</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8c 100%); min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; margin: 0; }
        .logo3 { width: 90px; height: 90px; border-radius: 50%; margin-bottom: 20px; box-shadow: 0 10px 30px rgba(0,0,0,.3); }
        #cap { color: #fff; font-size: 26px; font-weight: 600; margin-bottom: 25px; text-align: center; }
        .body { background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,.3); width: 100%; max-width: 560px; box-sizing: border-box; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        label { display: block; color: #1e3a5f; font-weight: 600; margin-bottom: 6px; font-size: 14px; }
        input { width: 100%; padding: 12px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; margin-bottom: 16px; box-sizing: border-box; }
        input:focus { outline: none; border-color: #4db8ff; }
        button { width: 100%; background: linear-gradient(135deg, #4db8ff 0%, #3da3e8 100%); color: #fff; padding: 15px; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; }
        .error { background: #fdecea; color: #b71c1c; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .links { color: #fff; margin-top: 20px; text-align: center; }
        .links a { color: #fff; }
    </style>
</head>
<body>
    <img src="{{ asset('icons/logo3.png') }}" alt="Logo" class="logo3">
    <h2 id="cap">Créer mon compte étudiant</h2>
    <div class="body">
        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error) {{ $error }}<br> @endforeach
            </div>
        @endif
        <form action="{{ route('etudiant.register') }}" method="POST">
            @csrf
            <div class="row">
                <div><label for="nom">Nom *</label><input type="text" id="nom" name="nom" value="{{ old('nom') }}" required></div>
                <div><label for="prenom">Prénom *</label><input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" required></div>
            </div>
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            <div class="row">
                <div><label for="matricule">Matricule</label><input type="text" id="matricule" name="matricule" value="{{ old('matricule') }}"></div>
                <div><label for="date_naissance">Date de naissance</label><input type="date" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}"></div>
            </div>
            <div class="row">
                <div><label for="filiere">Filière</label><input type="text" id="filiere" name="filiere" value="{{ old('filiere') }}" placeholder="Informatique"></div>
                <div><label for="annee_universitaire">Année universitaire</label><input type="text" id="annee_universitaire" name="annee_universitaire" value="{{ old('annee_universitaire') }}" placeholder="2024-2025"></div>
            </div>
            <div class="row">
                <div><label for="password">Mot de passe *</label><input type="password" id="password" name="password" required></div>
                <div><label for="password_confirmation">Confirmation *</label><input type="password" id="password_confirmation" name="password_confirmation" required></div>
            </div>
            <button type="submit">Créer mon compte</button>
        </form>
    </div>
    <div class="links">
        Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a>
    </div>
</body>
</html>
