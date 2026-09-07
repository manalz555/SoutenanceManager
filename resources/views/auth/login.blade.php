<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SoutenanceManager</title>
    <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8c 100%); min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 20px; margin: 0; }
        .logo3 { width: 100px; height: 100px; border-radius: 50%; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,.3); animation: fadeIn .5s ease; }
        #cap { color: #fff; font-size: 28px; font-weight: 600; margin-bottom: 30px; text-align: center; animation: fadeIn .7s ease; }
        .body { background: #fff; padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,.3); width: 100%; max-width: 450px; animation: fadeIn .9s ease; box-sizing: border-box; }
        form { display: flex; flex-direction: column; }
        label { color: #1e3a5f; font-weight: 600; margin-bottom: 8px; font-size: 14px; }
        input[type=email], input[type=password] { width: 100%; padding: 14px 18px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 15px; margin-bottom: 20px; box-sizing: border-box; }
        input:focus { outline: none; border-color: #4db8ff; box-shadow: 0 0 0 3px rgba(77,184,255,.1); }
        button[type=submit] { background: linear-gradient(135deg, #4db8ff 0%, #3da3e8 100%); color: #fff; padding: 16px; border: none; border-radius: 10px; font-size: 16px; font-weight: 600; cursor: pointer; transition: all .3s; margin-top: 10px; }
        button[type=submit]:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(77,184,255,.3); }
        .role-selector { margin-bottom: 20px; }
        .role-buttons { display: flex; gap: 10px; }
        .role-btn { flex: 1; padding: 12px; border: 2px solid #e0e0e0; background: #fff; border-radius: 10px; cursor: pointer; transition: all .3s; font-size: 14px; font-weight: 600; }
        .role-btn:hover, .role-btn.active { background: #4db8ff; color: #fff; border-color: #4db8ff; }
        .error { background: #fdecea; color: #b71c1c; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .success { background: #e8f5e9; color: #1b5e20; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; }
        .links { color: #fff; margin-top: 20px; text-align: center; opacity: .9; }
        .links a { color: #fff; }
        .hint { font-size: 12px; color: #777; margin-top: -10px; margin-bottom: 15px; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px);} to { opacity: 1; transform: translateY(0);} }
    </style>
</head>
<body>
    <img src="{{ asset('icons/logo3.png') }}" alt="Logo" class="logo3">
    <h2 id="cap">Connectez-vous à votre compte</h2>
    <div class="body">
        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="role-selector">
                <label>Type de compte :</label>
                <div class="role-buttons">
                    @foreach (['etudiant' => 'Étudiant', 'professeur' => 'Professeur', 'admin' => 'Admin'] as $value => $label)
                        <button type="button" class="role-btn {{ old('role', $role) === $value ? 'active' : '' }}" onclick="selectRole('{{ $value }}', this)">{{ $label }}</button>
                    @endforeach
                </div>
                <input type="hidden" id="role" name="role" value="{{ old('role', $role) }}">
            </div>

            <label for="email">Adresse email :</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="exemple@mail.com" required autofocus>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>

            <button type="submit">Se connecter</button>
        </form>
    </div>
    <div class="links">
        Pas encore de compte étudiant ? <a href="{{ route('etudiant.register') }}">S'inscrire</a><br>
        <a href="{{ route('home') }}">← Retour à l'accueil</a>
    </div>

    <script>
        function selectRole(role, button) {
            document.querySelectorAll('.role-btn').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            document.getElementById('role').value = role;
        }
    </script>
</body>
</html>
