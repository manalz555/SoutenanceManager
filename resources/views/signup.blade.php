<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SoutenanceManager</title>
    <link rel="stylesheet" href="{{ asset('css/signup.css')}}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8c 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .logo3 {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.5s ease;
        }
        #cap {
            color: white;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
            animation: fadeIn 0.7s ease;
        }
        .body {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
            animation: fadeIn 0.9s ease;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            color: #1e3a5f;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            margin-bottom: 20px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: #4db8ff;
            box-shadow: 0 0 0 3px rgba(77, 184, 255, 0.1);
        }
        button[type="submit"] {
            background: linear-gradient(135deg, #4db8ff 0%, #3da3e8 100%);
            color: white;
            padding: 16px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        button[type="submit"]:hover {
            background: linear-gradient(135deg, #3da3e8 0%, #2d8fd1 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(77, 184, 255, 0.3);
        }
        .role-selector {
            margin-bottom: 20px;
        }
        .role-selector label {
            display: block;
            margin-bottom: 10px;
        }
        .role-buttons {
            display: flex;
            gap: 10px;
        }
        .role-btn {
            flex: 1;
            padding: 12px;
            border: 2px solid #e0e0e0;
            background: white;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 600;
        }
        .role-btn:hover,
        .role-btn.active {
            background: #4db8ff;
            color: white;
            border-color: #4db8ff;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .back-link {
            color: white;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
            opacity: 0.9;
        }
        .back-link:hover {
            opacity: 1;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <img src="{{ asset('icons/logo3.png') }}" alt="Logo" class="logo3">
    <h2 id="cap">Connectez-vous à votre compte</h2>
    <div class="body">
        <form action="#" method="POST">
            <div class="role-selector">
                <label>Type de compte :</label>
                <div class="role-buttons">
                    <button type="button" class="role-btn active" onclick="selectRole('etudiant', this)">Étudiant</button>
                    <button type="button" class="role-btn" onclick="selectRole('professeur', this)">Professeur</button>
                    <button type="button" class="role-btn" onclick="selectRole('admin', this)">Admin</button>
                </div>
                <input type="hidden" id="role" name="role" value="etudiant">
            </div>

            <label for="email">Adresse email :</label>
            <input type="email" id="email" name="email" placeholder="exemple@mail.com" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>

            <button type="submit">Se connecter</button>
        </form>
    </div>
    <a href="/acceuil" class="back-link">← Retour à l'accueil</a>

    <script>
        function selectRole(role, button) {
            document.querySelectorAll('.role-btn').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            document.getElementById('role').value = role;
        }
    </script>
</body>
</html>