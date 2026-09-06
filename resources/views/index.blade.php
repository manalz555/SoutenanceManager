<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SoutenanceManager</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
    </style>

</head>
<body>

   <x-admin title="admin" />
<div class="content">
    <div class="cards">
        <div class="card">
            <h1>20</h1>
            <p>ÉTUDIANTS</p>
        </div>

        <div class="card green">
            <h1>19</h1>
            <p>JURYS</p>
        </div>

        <div class="card">
            <h1>15</h1>
            <p>SOUTENANCES</p>
        </div>

    </div>

    <h2 id="cap">Prochaines soutenances :</h2>

    <table>
        <tr>
            <th>Date</th>
            <th>Heure</th>
            <th>Salle</th>
            <th>Étudiant</th>
            <th>Jury</th>
        </tr>

            <tr>
                <td>${s.date}</td>
                <td>${s.heure}</td>
                <td>${s.salle}</td>
                <td>${s.etudiant}</td>
                <td>${s.jury}</td>
            </tr>
       

    </table>


</div>



   
</body>
</html>