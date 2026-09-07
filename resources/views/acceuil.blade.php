<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - SoutenanceManager</title>
    <link rel="stylesheet" href="{{ asset('css/acceuil.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; padding: 0; font-family: 'Montserrat', sans-serif; background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8c 100%); min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #fff; }
        .container { text-align: center; padding: 40px; }
        .logosign { width: 120px; height: 120px; border-radius: 50%; margin-bottom: 30px; animation: fadeIn 1s ease; box-shadow: 0 10px 30px rgba(0,0,0,.3); }
        #cap { font-size: 48px; font-weight: 600; margin-bottom: 30px; animation: fadeIn 1.2s ease; text-shadow: 2px 2px 4px rgba(0,0,0,.3); }
        .buttun { display: inline-block; padding: 18px 50px; background: #fff; color: #1e3a5f; text-decoration: none; border-radius: 50px; font-weight: 600; font-size: 18px; transition: all .3s; box-shadow: 0 4px 15px rgba(0,0,0,.2); animation: fadeIn 1.4s ease; margin: 8px; }
        .buttun.secondary { background: transparent; color: #fff; border: 2px solid #fff; }
        .buttun:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.3); }
        .description { margin: 0 auto 40px; font-size: 18px; opacity: .9; max-width: 600px; line-height: 1.6; }
        .flash { background: rgba(255,255,255,.15); padding: 12px 20px; border-radius: 10px; margin-bottom: 20px; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: translateY(0);} }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('icons/logo3.png') }}" class="logosign" alt="Logo">
        <h1 id="cap">SoutenanceManager</h1>
        @if (session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif
        <p class="description">
            Application web de gestion des soutenances de stages (PFE et stage d'été) :
            planification, composition des jurys, dépôt des rapports et suivi des remarques.
        </p>
        <a href="{{ route('login') }}" class="buttun">Se connecter</a>
        <a href="{{ route('etudiant.register') }}" class="buttun secondary">Créer un compte étudiant</a>
    </div>
</body>
</html>
