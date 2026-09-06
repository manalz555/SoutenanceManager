<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - SoutenanceManager</title>
    <link rel="stylesheet" href="{{ asset('css/acceuil.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8c 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .container {
            text-align: center;
            padding: 40px;
        }
        .logosign {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 30px;
            animation: fadeIn 1s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        #cap {
            font-size: 48px;
            font-weight: 600;
            margin-bottom: 50px;
            animation: fadeIn 1.2s ease;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .buttun {
            display: inline-block;
            padding: 18px 50px;
            background: white;
            color: #1e3a5f;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 18px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1.4s ease;
        }
        .buttun:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            background: #f0f0f0;
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
        .description {
            margin-top: 30px;
            font-size: 18px;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('icons/logo3.png') }}" class="logosign" alt="Logo">
        <h1 id="cap">SoutenanceManager</h1>
        <p class="description">
            Application web de gestion des soutenances de stages (PFE et stage d'été)
        </p>
        <a href="/signup" class="buttun">Se connecter</a>
    </div>
</body>
</html>